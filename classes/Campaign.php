<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network (OSSN)
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
namespace Monetization;
class Campaign {
		/**
		 * Smart deduction: Automatically detects CPC vs CPM rate from component settings and deducts atomically.
		 *
		 * @param object $ad The OSSN Ad object from ossn_get_ad($guid)
		 * @return bool True if deduction succeeded or not applicable (e.g. flat rate), false if balance depleted.
		 */
		public static function deductByAd($ad) {
				if(!is_object($ad) || empty($ad->guid)) {
						return false;
				}

				// 1. Resolve billing_mode ($ad->billing_mode or $ad->data->billing_mode)
				$billing_mode = $ad->billing_mode;
				if(empty($billing_mode)) {
						return false;
				}

				// Flat-rate or fixed campaigns do not deduct performance balance
				if($billing_mode === 'daily') {
						return true;
				}

				//Fetch component settings using OSSN component handler
				$com      = new \OssnComponents();
				$settings = $com->getSettings('Monetization');

				$cpc_rate = isset($settings->cpc_rate) ? (float) $settings->cpc_rate : 0.1;
				$cpm_rate = isset($settings->cpm_rate) ? (float) $settings->cpm_rate : 1.0;

				//Resolve optimization_type ($ad->optimization_type or $ad->data->optimization_type)
				$opt_type = isset($ad->optimization_type) ? $ad->optimization_type : '';
				if(empty($opt_type) && isset($ad->data->optimization_type)) {
						$opt_type = $ad->data->optimization_type;
				}
				$opt_type = strtolower($opt_type);

				$amount = 0.0;

				if($opt_type === 'cpc') {
						$amount = $cpc_rate;
				} elseif($opt_type === 'cpm') {
						// Per single view cost (e.g., $1.00 / 1000 = $0.001)
						$amount = $cpm_rate / 1000.0;
				}

				// If no performance billing matches, pass through
				if($amount <= 0) {
						return true;
				}

				// Execute atomic database deduction

				if(!self::deductBalance($ad->guid, $amount)) {
						$ad->data->expired = true;
						$ad->data->balance = 0.0;
						$ad->save();
						return false;
				}
				return true;
		}

		/**
		 * Atomically deduct an amount from an ad campaign's metadata balance in MySQL/InnoDB.
		 *
		 * @param int   $ad_guid The GUID of the ad entity.
		 * @param float $amount  The amount to deduct.
		 * @return bool True if deduction succeeded, false if insufficient balance.
		 */
		public static function deductBalance($ad_guid, $amount) {
				$ad_guid = (int) $ad_guid;
				$amount  = (float) $amount;

				if($ad_guid <= 0 || $amount <= 0) {
						return false;
				}

				$db = new \OssnDatabase();

				$query = "UPDATE ossn_entities_metadata m
                  INNER JOIN ossn_entities e ON e.guid = m.guid
                  SET m.value = ROUND(CAST(m.value AS DECIMAL(10,4)) - {$amount}, 4)
                  WHERE e.owner_guid = '{$ad_guid}'
                    AND e.type = 'object'
                    AND e.subtype = 'balance'
                    AND CAST(m.value AS DECIMAL(10,4)) >= {$amount}";

				$db->statement($query);

				if($db->execute()) {
						if(isset($db->exe) && $db->exe instanceof \PDOStatement) {
								return $db->exe->rowCount() > 0;
						}
				}

				return false;
		}
		/**
		 * Calculate the eligible refund amount when ending a campaign early.
		 *
		 * @param object $ad The Ad object.
		 * @return float Refund amount rounded to 2 decimal places.
		 */
		public static function calculateRefund($ad) {
				if(!is_object($ad)) {
						return 0.0;
				}

				$approved     = isset($ad->approved) ? $ad->approved : 'pending';
				$total_budget = isset($ad->initial_budget) ? (float) $ad->initial_budget : 0.0;

				//Pending Campaigns: Always refund 100% of initial budget
				if($approved === 'pending') {
						return max(0.0, round($total_budget, 2));
				}

				$billing_mode = isset($ad->billing_mode) ? strtolower($ad->billing_mode) : 'performance';
				$now          = time();

				// Active Daily Duration Campaigns (Pro-rated time refund)
				if($billing_mode === 'daily') {
						$expire_time = isset($ad->expire_time) ? (int) $ad->expire_time : 0;
						$start_time  = isset($ad->time_created) ? (int) $ad->time_created : $now;

						if($expire_time <= 0 || $now >= $expire_time || $total_budget <= 0) {
								return 0.0;
						}

						$total_duration     = max(1, $expire_time - $start_time);
						$remaining_duration = max(0, $expire_time - $now);

						$remaining_ratio = $remaining_duration / $total_duration;
						$refund_amount   = $total_budget * $remaining_ratio;

						return max(0.0, round($refund_amount, 2));
				}

				// Active Performance Campaigns (CPC / CPM remaining balance)
				$balance = isset($ad->balance) ? (float) $ad->balance : 0.0;
				return max(0.0, round($balance, 2));
		}
}
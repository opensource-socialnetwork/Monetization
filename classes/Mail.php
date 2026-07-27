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
class Mail {
		/**
		 * Send email to Admin when a new ad campaign is created.
		 *
		 * @param object $ad The created OSSN Ad object.
		 * @return bool
		 */
		public static function notifyAdminNewCampaign($ad) {
				$mailModel  = new \OssnMail();
				$site_name  = ossn_site_settings('site_name');
				$site_email = ossn_site_settings('owner_email');

				if(empty($site_email)) {
						return false;
				}

				$owner       = ossn_user_by_guid($ad->ad_owner_guid);
				$owner_name  = $owner ? $owner->fullname : ossn_print('ossn:monetization:admin:site_owned');
				$status_text = $ad->approved === 'yes' ? ossn_print('ossn:monetization:status:active') : ossn_print('ossn:monetization:status:pending');
				$review_url  = ossn_site_url('administrator/component/Monetization?page=pending');
				$budget_fmt  = sprintf('%.2f', $ad->initial_budget);

				$subject = ossn_print('ossn:monetization:mail:admin_new:subject', array(
						$site_name,
				));
				$body = ossn_print('ossn:monetization:mail:admin_new:body', array(
						$site_name,
						$ad->title,
						$owner_name,
						$budget_fmt,
						$status_text,
						$review_url,
				));

				return $mailModel->notifyUser($site_email, $subject, $body);
		}

		/**
		 * Send email to User when their ad campaign is approved.
		 *
		 * @param object $ad The approved OSSN Ad object.
		 * @return bool
		 */
		public static function notifyUserApproved($ad) {
				$owner = ossn_user_by_guid($ad->ad_owner_guid);
				if(!$owner || empty($owner->email)) {
						return false;
				}

				$mailModel     = new \OssnMail();
				$site_name     = ossn_site_settings('site_name');
				$dashboard_url = ossn_site_url('campaigns/dashboard');

				$subject = ossn_print('ossn:monetization:mail:user_approved:subject', array(
						$site_name,
				));
				$body = ossn_print('ossn:monetization:mail:user_approved:body', array(
						$owner->fullname,
						$ad->title,
						$site_name,
						$dashboard_url,
				));

				return $mailModel->notifyUser($owner->email, $subject, $body);
		}

		/**
		 * Send email to User when their ad campaign is declined.
		 *
		 * @param object $ad The declined OSSN Ad object.
		 * @param float  $refund_amount The amount refunded to their wallet.
		 * @return bool
		 */
		public static function notifyUserDeclined($ad, $refund_amount = 0.0) {
				$owner = ossn_user_by_guid($ad->ad_owner_guid);
				if(!$owner || empty($owner->email)) {
						return false;
				}

				$mailModel     = new \OssnMail();
				$site_name     = ossn_site_settings('site_name');
				$currency      = defined('WALLET_CURRENCY_CODE') ? WALLET_CURRENCY_CODE : 'USD';
				$dashboard_url = ossn_site_url('campaigns/dashboard');

				$refund_line = '';
				if($refund_amount > 0) {
						$formatted_refund = sprintf('%.2f', $refund_amount);
						$refund_line      = ossn_print('ossn:monetization:mail:user_declined:refund_line', array(
								$formatted_refund,
								$currency,
						));
				}

				$subject = ossn_print('ossn:monetization:mail:user_declined:subject', array(
						$site_name,
				));
				$body = ossn_print('ossn:monetization:mail:user_declined:body', array(
						$owner->fullname,
						$ad->title,
						$site_name,
						$refund_line,
						$dashboard_url,
				));

				return $mailModel->notifyUser($owner->email, $subject, $body);
		}
}
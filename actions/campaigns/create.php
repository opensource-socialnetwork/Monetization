<?php
$user = ossn_loggedin_user();

$params['title']         = input('title');
$params['description']   = input('description');
$params['siteurl']       = input('siteurl');
$params['gender_target'] = input('gender_target');
$params['placement']     = input('placement');
$billing_mode 			 = input('billing_mode');

// Ensure required core fields are not empty
foreach ($params as $field) {
		if(empty($field)) {
				ossn_trigger_message(ossn_print('fields:required'), 'error');
				redirect(REF);
		}
}

//Validate Expiry Date & Calculate Days
$expiry_date = input('expiry_date');
if(empty($expiry_date)) {
		ossn_trigger_message(ossn_print('fields:required'), 'error');
		redirect(REF);
}

$dateObject = DateTime::createFromFormat('Y-m-d H:i:s', $expiry_date . ' 23:59:59');
if(!$dateObject || $dateObject->format('Y-m-d H:i:s') !== $expiry_date . ' 23:59:59') {
		ossn_trigger_message(ossn_print('ossn:monetization:campaign:error:invalid_date'), 'error');
		redirect(REF);
}

// Convert expiry date to Unix timestamp for OSSN Ad Object
$params['expiry_date'] = $dateObject->getTimestamp();

// Calculate total duration in days (minimum 1 day)
$today     = new DateTime('today');
$expiryDay = DateTime::createFromFormat('Y-m-d', $expiry_date);
$interval  = $today->diff($expiryDay);
$days      = $interval->invert === 0 && $interval->days > 0 ? $interval->days : 1;

//Load Admin Monetization Settings & Calculate Cost
$com      = new \OssnComponents();
$settings = $com->getSettings('Monetization');

$daily_rate   = $settings && isset($settings->daily_rate) ? (float) $settings->daily_rate : 3.0;
$cpc_rate     = $settings && isset($settings->cpc_rate) ? (float) $settings->cpc_rate : 0.2;
$cpm_rate     = $settings && isset($settings->cpm_rate) ? (float) $settings->cpm_rate : 1.0;
$min_budget   = $settings && isset($settings->min_budget) ? (float) $settings->min_budget : 5.0;
$auto_approve = $settings && isset($settings->auto_approve) ? $settings->auto_approve : 'no';

$total_cost        = 0.0;
$optimization_type = 'daily';

if($billing_mode === 'daily') {
		$total_cost = (float) ($days * $daily_rate);
} else {
		$user_budget       = (float) input('budget');
		$optimization_type = input('optimization_type'); // 'cpc' or 'cpm'

		if($user_budget < $min_budget) {
				ossn_trigger_message(
						ossn_print('ossn:monetization:campaign:error:min_budget', array(
								$min_budget,
						)),
						'error'
				);
				redirect(REF);
		}
		$total_cost = $user_budget;
}

// Ensure cost is a valid positive amount
if($total_cost <= 0) {
		ossn_trigger_message(ossn_print('ossn:monetization:campaign:error:invalid_cost'), 'error');
		redirect(REF);
}

if(!isset($_FILES['ossn_ads']) || $_FILES['ossn_ads']['error'] !== UPLOAD_ERR_OK || empty($_FILES['ossn_ads']['tmp_name'])) {
		ossn_trigger_message(ossn_print('ossn:monetization:campaign:error:no_image'), 'error');
		redirect(REF);
}

try {
		$wallet           = new Wallet\Wallet($user->guid);
		$transaction_desc = 'Ad Campaign Payment: ' . substr($params['title'], 0, 30);

		// Debit funds from user's balance
		$wallet->debit($total_cost, $transaction_desc);
} catch (Wallet\NoUserException $e) {
		ossn_trigger_message(ossn_print('ossn:monetization:campaign:error:no_wallet'), 'error');
		redirect(REF);
} catch (Wallet\DebitException $e) {
		ossn_trigger_message(ossn_print('ossn:monetization:campaign:error:insufficient_funds'), 'error');
		redirect(REF);
} catch (Exception $e) {
		ossn_trigger_message($e->getMessage(), 'error');
		redirect(REF);
}

$add  = new OssnAds();
$guid = $add->adCreate($params);

if(!$guid) {
		// Refund user wallet if ad creation fails
		try {
				$wallet->credit($total_cost, 'Refund: Ad creation failed');
		} catch (Exception $e) {
				// Log refund failure
		}
		ossn_trigger_message(ossn_print('ad:create:fail'), 'error');
		redirect(REF);
}

$ad = ossn_get_ad($guid);
if($ad) {
		// Attach custom properties to the ad entity
		$ad->data->ad_owner_guid     = $user->guid;
		$ad->data->billing_mode      = $billing_mode;
		$ad->data->optimization_type = $optimization_type;
		$ad->data->initial_budget    = $total_cost;
		$ad->data->balance           = $total_cost; // Remaining ad balance/credit

		// Set approval status based on admin rules ('yes' = active, 'no' = pending approval)
		if($auto_approve != 'yes') {
				$ad->data->approved = 'pending';
		}
		$MonetizationMail = new Monetization\Mail();
		$MonetizationMail->notifyAdminNewCampaign($ad);

		$ad->save();
}

ossn_trigger_message(ossn_print('ad:created'), 'success');
redirect('campaigns/dashboard');
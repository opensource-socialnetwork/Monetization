<?php
$user = ossn_loggedin_user();
$guid = input('guid');
$ad   = ossn_get_ad($guid);

if(!$ad || (int) $ad->ad_owner_guid !== (int) $user->guid) {
		ossn_trigger_message(ossn_print('ossn:monetization:campaign:error:not_owner'), 'error');
		redirect(REF);
}

if(isset($ad->approved) && $ad->approved === 'declined') {
		ossn_trigger_message(ossn_print('ossn:monetization:campaign:already_declined'), 'error');
		redirect(REF);
}

$is_expired = isset($ad->expired) && ($ad->expired == true || $ad->expired == 1);
if($is_expired) {
		ossn_trigger_message(ossn_print('ossn:monetization:campaign:already_ended'), 'error');
		redirect(REF);
}

$refund_amount  = \Monetization\Campaign::calculateRefund($ad);
$refund_success = false;

if($refund_amount > 0) {
		try {
				$wallet      = new Wallet\Wallet($user->guid);
				$refund_desc = 'Refund: Unspent amount from ended campaign (' . substr($ad->title, 0, 30) . ')';

				$wallet->credit($refund_amount, $refund_desc);
				$refund_success = true;
		} catch (Wallet\NoUserException $e) {
				ossn_trigger_message(ossn_print('ossn:monetization:campaign:error:no_wallet'), 'error');
				redirect(REF);
		} catch (Exception $e) {
				ossn_trigger_message($e->getMessage(), 'error');
				redirect(REF);
		}
}

$ad->data->expired = true;
$ad->data->balance = '0.00';
$ad->data->approved = true;

if($ad->save()) {
		if($refund_success) {
				$formatted_refund = sprintf('%.2f', $refund_amount);
				$currency         = defined('WALLET_CURRENCY_CODE') ? WALLET_CURRENCY_CODE : 'USD';

				ossn_trigger_message(
						ossn_print('ossn:monetization:campaign:ended_refunded', array(
								$formatted_refund,
								$currency,
						)),
						'success'
				);
		} else {
				ossn_trigger_message(ossn_print('ossn:monetization:campaign:ended_success'), 'success');
		}
} else {
		ossn_trigger_message(ossn_print('ossn:monetization:campaign:end_failed'), 'error');
}

redirect(REF);
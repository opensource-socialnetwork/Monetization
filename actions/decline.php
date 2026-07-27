<?php

$guid = input('guid');
$ad   = ossn_get_ad($guid);

if($ad && isset($ad->approved) && $ad->approved === 'pending') {
		$ad->data->approved = 'declined';
		$ad->data->expired  = true;
		$ad->data->balance = '0.00';
		
		//Refund full initial budget since pending ad never ran
		$refund_amount = isset($ad->initial_budget) ? (float) $ad->initial_budget : 0.0;
		if($refund_amount <= 0 && isset($ad->balance)) {
				$refund_amount = (float)$ad->balance;
		}

		$owner_guid = isset($ad->ad_owner_guid) ? (int) $ad->ad_owner_guid : (int) $ad->owner_guid;

		if($owner_guid > 0 && $refund_amount > 0) {
				try {
						$wallet      = new Wallet\Wallet($owner_guid);
						$refund_desc = 'Refund: Ad Campaign Declined by Admin (' . substr($ad->title, 0, 30) . ')';
						$wallet->credit($refund_amount, $refund_desc);
						
				} catch (Exception $e) {
						ossn_trigger_message($e->getMessage(), 'error');
						redirect(REF);
				}
		}

		//Send notification email to campaign owner
		$MonetizationMail = new Monetization\Mail();
		$MonetizationMail->notifyUserDeclined($ad, $refund_amount);

		//Save entity changes
		if($ad->save()) {
				ossn_trigger_message(ossn_print('ossn:monetization:admin:declined_success'), 'success');
		} else {
				ossn_trigger_message(ossn_print('ossn:monetization:admin:action_failed'), 'error');
		}
}

redirect(REF);
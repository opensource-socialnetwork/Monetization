<?php
$guid = input('guid');
$ad   = ossn_get_ad($guid);
if($ad) {
		$ad->data->approved = 'yes';
		if($ad->save()) {
				$MonetizationMail = new Monetization\Mail();
				$MonetizationMail->notifyUserApproved($ad);

				ossn_trigger_message(ossn_print('ossn:monetization:admin:approved_success'), 'success');
		} else {
				ossn_trigger_message(ossn_print('ossn:monetization:admin:action_failed'), 'error');
		}
}
redirect(REF);
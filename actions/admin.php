<?php
$billing_mode    = input('billing_mode');
$daily_rate      = input('daily_rate');
$cpc_rate        = input('cpc_rate');
$cpm_rate        = input('cpm_rate');
$min_budget      = input('min_budget');
$auto_approve    = input('auto_approve');
$feed_interval   = input('feed_interval');

if(
		empty($billing_mode) ||
		!in_array($billing_mode, array(
				'daily',
				'performance',
				'both',
		))
) {
		ossn_trigger_message(ossn_print('ossn:monetization:admin:save:error:invalid_mode'), 'error');
		redirect(REF);
}

if(($billing_mode === 'daily' || $billing_mode === 'both') && (!is_numeric($daily_rate) || (float) $daily_rate <= 0)) {
		ossn_trigger_message(ossn_print('ossn:monetization:admin:save:error:invalid_rates'), 'error');
		redirect(REF);
}

if(
		($billing_mode === 'performance' || $billing_mode === 'both') &&
		(!is_numeric($cpc_rate) || (float) $cpc_rate <= 0 || !is_numeric($cpm_rate) || (float) $cpm_rate <= 0 || !is_numeric($min_budget) || (float) $min_budget <= 0)
) {
		ossn_trigger_message(ossn_print('ossn:monetization:admin:save:error:invalid_rates'), 'error');
		redirect(REF);
}

if(!is_numeric($feed_interval) || (int) $feed_interval < 1) {
		ossn_trigger_message(ossn_print('ossn:monetization:admin:save:error:invalid_interval'), 'error');
		redirect(REF);
}

$com   = new \OssnComponents();
$saved = $com->setSettings('Monetization', array(
		'billing_mode'    => $billing_mode,
		'daily_rate'      => number_format((float) $daily_rate, 2, '.', ''),
		'cpc_rate'        => number_format((float) $cpc_rate, 2, '.', ''),
		'cpm_rate'        => number_format((float) $cpm_rate, 2, '.', ''),
		'min_budget'      => number_format((float) $min_budget, 2, '.', ''),
		'auto_approve'    => $auto_approve === 'yes' ? 'yes' : 'no',
		'feed_interval'   => (int) $feed_interval,
));

if($saved) {
		ossn_trigger_message(ossn_print('ossn:monetization:admin:save:success'), 'success');
} else {
		ossn_trigger_message(ossn_print('ossn:monetization:admin:save:error'), 'error');
}

redirect(REF);
<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Source Social Network Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

define('__Monetization__', ossn_route()->com . 'Monetization/');
ossn_register_class(array(
		'Monetization\Campaign' => __Monetization__ . 'classes/Campaign.php',
		'Monetization\Mail'     => __Monetization__ . 'classes/Mail.php',
));
function monetization_init() {
		ossn_extend_view('css/ossn.default', 'monetization/css');

		if(ossn_isAdminLoggedin()) {
				ossn_register_com_panel('Monetization', 'settings');
				ossn_register_action('monetization/admin/settings', __Monetization__ . 'actions/admin.php');
				ossn_register_action('monetization/admin/approve', __Monetization__ . 'actions/approve.php');
				ossn_register_action('monetization/admin/decline', __Monetization__ . 'actions/decline.php');

				ossn_register_menu_item('topbar_dropdown', array(
						'name' => 'campaignspending',
						'text' => ossn_print('ossn:monetization:admin:pending:title'),
						'href' => ossn_site_url('administrator/component/Monetization?page=pending'),
				));
		}
		if(ossn_isLoggedin()) {
				ossn_register_page('campaigns', 'ossn_monetization_campaigns_page_handler');
				ossn_register_action('monetization/campaign/create', __Monetization__ . 'actions/campaigns/create.php');
				ossn_register_action('monetization/campaign/end', __Monetization__ . 'actions/end.php');
		}

		ossn_register_callback('ads', 'view', 'monetization_view_deduct_balance');
		ossn_register_callback('ads', 'before:go', 'monetization_click_deduct_balance');

		//when ad expire itself refund user
		ossn_register_callback('ad', 'before:expired', function ($callback, $type, $params) {
				if(!isset($params['ad'])) {
						return;
				}

				$ad                = $params['ad'];
				$remaining_balance = \Monetization\Campaign::calculateRefund($ad);
				$owner_guid        = $ad->owner_guid;

				if($remaining_balance > 0 && !empty($owner_guid)) {
						try {
								$user = ossn_user_by_guid($owner_guid);
								if($user) {
										$wallet           = new Wallet\Wallet($user->guid);
										$transaction_desc = 'Ad Campaign Refund (Expired): ' . substr($ad->title, 0, 30);

										$wallet->credit($remaining_balance, $transaction_desc);
								}
						} catch (Wallet\NoUserException $e) {
						} catch (Exception $e) {
						}
				}

				$ad->data->balance  = 0.0;
				$ad->data->approved = 'yes'; //it is approved but expired
				$ad->save();
		});

		if(ossn_isLoggedin()) {
				ossn_register_sections_menu('newsfeed', array(
						'name'    => 'campaigns',
						'text'    => ossn_print('ossn:monetization:dashboard:title'),
						'href'    => ossn_site_url('campaigns/dashboard'),
						'section' => 'links',
				));
		}
		ossn_add_hook('required', 'components', 'monetization_wallet_required');
}
function monetization_wallet_required($hook, $type, $return, $params) {
		$return[] = 'Wallet';
		return $return;
}
function monetization_click_deduct_balance($c, $t, $params) {
		$ad = $params['ad'];
		if(!isset($_SESSION['monetization_ads_deducted'])) {
				$_SESSION['monetization_ads_deducted'] = array();
		}
		if(!in_array($ad->guid, $_SESSION['monetization_ads_deducted'])) {
				\Monetization\Campaign::deductByAd($ad);
				$_SESSION['monetization_ads_deducted'][] = $ad->guid;
		}
}
function monetization_view_deduct_balance($c, $t, $params) {
		$ad = $params['ad'];
		error_log(1);
		if(!isset($_SESSION['monetization_ads_viewed']) || !is_array($_SESSION['monetization_ads_viewed'])) {
				$_SESSION['monetization_ads_viewed'] = array();
		}
		if(!in_array($ad->guid, $_SESSION['monetization_ads_viewed'])) {
				error_log(2);
				\Monetization\Campaign::deductByAd($ad);
				$_SESSION['monetization_ads_viewed'][] = $ad->guid;
		}
}
function ossn_monetization_campaigns_page_handler($pages) {
		$action = $pages[0] ?? 'dashboard';

		switch ($action) {
		case 'create':
				$title    = ossn_print('ossn:monetization:campaign:create');
				$contents = array(
						'content' => ossn_plugin_view('monetization/pages/create'),
				);
				$content = ossn_set_page_layout('contents', $contents);
				echo ossn_view_page($title, $content);
				break;
		case 'dashboard':
		default:
				$title    = ossn_print('ossn:monetization:dashboard:title');
				$contents = array(
						'content' => ossn_plugin_view('monetization/pages/dashboard'),
				);
				$content = ossn_set_page_layout('contents', $contents);
				echo ossn_view_page($title, $content);
				break;
		}
}
ossn_register_callback('ossn', 'init', 'monetization_init');
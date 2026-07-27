<?php
/**
 * Open Source Social Network
 *
 * @package   Wallet
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (c) Engr. Syed Arsalan Hussain Shah (OpenTeknik LLC)
 * @license   OpenTeknik LLC, COMMERCIAL LICENSE  https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.openteknik.com/
 */

 echo ossn_plugin_view('monetization/adminnav');
 $page = input('page', '', 'settings');
 switch($page){
	case 'pending':
		echo ossn_plugin_view('monetization/pages/pending');
		break;
	case 'settings':
		echo ossn_view_form('monetization/admin/settings', array(
    			'action' => ossn_site_url() . 'action/monetization/admin/settings',
    			'class' => 'ossn-admin-form'	
		));	
		break;
 }
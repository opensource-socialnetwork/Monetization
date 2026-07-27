<?php

$en = array(
		// Common
		'ossn:monetization'                                   => 'Monetization',
		'ossn:monetization:yes'                               => 'Yes',
		'ossn:monetization:no'                                => 'No',

		// Section Headers
		'ossn:monetization:admin:section:pricing'             => 'Pricing & Billing Configuration',
		'ossn:monetization:admin:section:safety'              => 'Moderation & Safety Rules',
		'ossn:monetization:admin:section:display'             => 'Ad Placement & Display Settings',

		// Billing Mode
		'ossn:monetization:admin:billing_mode'                => 'Primary Billing Mode',
		'ossn:monetization:admin:billing_mode:hint'           => 'Choose how users will be charged when launching ad campaigns on your site.',
		'ossn:monetization:admin:mode:daily'                  => 'Fixed Daily Rate (Pay Per Day)',
		'ossn:monetization:admin:mode:performance'            => 'Performance Rate (Pay Per Click / View)',

		// Rates
		'ossn:monetization:admin:daily_rate'                  => 'Daily Ad Cost',
		'ossn:monetization:admin:daily_rate:hint'             => 'The flat rate charged to a user for running an ad for 1 full day.',
		'ossn:monetization:admin:cpc_rate'                    => 'Cost Per Click (CPC)',
		'ossn:monetization:admin:cpc_rate:hint'               => 'Deducted from the ad budget when a user clicks the ad link.',
		'ossn:monetization:admin:cpm_rate'                    => 'Cost Per 1,000 Views (CPM)',
		'ossn:monetization:admin:cpm_rate:hint'               => 'Deducted from the ad budget every 1,000 newsfeed or sidebar impressions.',
		'ossn:monetization:admin:min_budget'                  => 'Minimum Upfront Campaign Budget',
		'ossn:monetization:admin:min_budget:hint'             => 'The lowest budget threshold a user can spend to start a campaign.',

		// Safety & Moderation
		'ossn:monetization:admin:auto_approve'                => 'Automatically Approve New Ads',
		'ossn:monetization:admin:auto_approve:hint'           => 'If disabled, money goes into escrow while ads wait in the Admin Review Queue.',
		'ossn:monetization:admin:auto_refund'                 => 'Auto-Refund Rejected Ads',
		'ossn:monetization:admin:auto_refund:hint'            => 'Automatically return escrowed funds to the user\'s wallet if an admin declines their campaign.',

		// Display
		'ossn:monetization:admin:feed_interval'               => 'Newsfeed In-Feed Post Interval',
		'ossn:monetization:admin:feed_interval:hint'          => 'Number of regular posts between each injected newsfeed ad (e.g., 5 = show 1 ad every 5 posts).',

		//
		'ossn:monetization:admin:save:success'                => 'Monetization settings saved successfully!',
		'ossn:monetization:admin:save:error'                  => 'Failed to save monetization settings. Please try again.',
		'ossn:monetization:admin:save:error:invalid_mode'     => 'Please select a valid primary billing mode.',
		'ossn:monetization:admin:save:error:invalid_rates'    => 'All rates and minimum budgets must be valid numbers greater than 0.',
		'ossn:monetization:admin:save:error:invalid_interval' => 'In-feed post interval must be at least 1.',

		// Common Time Units
		'ossn:monetization:day'                               => 'day',
		'ossn:monetization:days'                              => 'days',

		// New Placement Wording (Replacing "global")
		'ad:placement:sidebar_all'                            => 'All Other Sidebar Places',
		'ossn:monetization:campaign'                          => 'Campaign',
		'ossn:monetization:allcampaign'                       => 'All Campaign',
		'ossn:monetization:campaign:pricing'                  => 'Campaign Pricing',
		// Campaign Creation & Pricing
		'ossn:monetization:campaign:create'                   => 'Create Campaign',
		'ossn:monetization:campaign:duration'                 => 'Run Duration',
		'ossn:monetization:campaign:budget'                   => 'Campaign Budget',
		'ossn:monetization:campaign:optimization'             => 'Optimization Goal',
		'ossn:monetization:campaign:opt:cpc'                  => 'Pay Per Click (CPC)',
		'ossn:monetization:campaign:opt:cpm'                  => 'Pay Per 1,000 Views (CPM)',

		// Checkout Summary & Actions
		'ossn:monetization:campaign:total_cost'               => 'Total Campaign Cost',
		'ossn:monetization:campaign:launch'                   => 'Pay & Launch Campaign',

		'ossn:monetization:campaign:explanation:daily'        => '%s days × %s %s / day',
		'ossn:monetization:campaign:explanation:cpc'          => 'Covers up to ~%s clicks',
		'ossn:monetization:campaign:explanation:cpm'          => 'Covers up to ~%s ad views',

		//
		'ossn:monetization:campaign:error:invalid_date'       => 'Please select a valid future expiry date.',
		'ossn:monetization:campaign:error:min_budget'         => 'Minimum campaign budget required is %s.',
		'ossn:monetization:campaign:error:invalid_cost'       => 'Invalid total campaign cost calculated.',
		'ossn:monetization:campaign:error:no_wallet'          => 'Wallet account not found for this user.',
		'ossn:monetization:campaign:error:insufficient_funds' => 'Insufficient wallet balance to launch this campaign. Please top up your wallet.',
		'ossn:monetization:campaign:error:no_image'           => 'Please select or drop a banner image for your campaign.',

		'ossn:monetization:campaign:expirydate'               => 'Campaign Expiry Date',

		'ossn:monetization:placement:newsfeed'                => 'Activity Newsfeed (Sidebar)',
		'ossn:monetization:placement:profile'                 => 'User Profiles (Sidebar)',
		'ossn:monetization:placement:groups'                  => 'Group Pages (Sidebar)',
		'ossn:monetization:placement:sidebar_all'             => 'All Other Sidebars and Places',

		//dashboard
		// Dashboard - Main Headers
		'ossn:monetization:dashboard:title'                   => 'Ad Campaigns',
		'ossn:monetization:dashboard:subtitle'                => 'Track live performance, budget usage, and ad impressions',

		// Dashboard - Table Headers & Metrics
		'ossn:monetization:campaign:budget'                   => 'Campaign Budget',
		'ossn:monetization:campaign:balance'                  => 'Remaining Credit',
		'ossn:monetization:campaign:spent'                    => 'Spent',
		'ossn:monetization:campaign:views'                    => 'views',
		'ossn:monetization:campaign:clicks'                   => 'clicks',
		'ossn:monetization:actions'                           => 'Actions',

		// Dashboard - Status Badges
		'ossn:monetization:status:active'                     => 'Active',
		'ossn:monetization:status:pending'                    => 'Pending Approval',
		'ossn:monetization:status:declined'                   => 'Declined',
		'ossn:monetization:status:expired'                    => 'Completed / Expired',

		// Dashboard - Empty State & Action Tooltips
		'ossn:monetization:no_campaigns'                      => 'You have not created any ad campaigns yet.',
		'ossn:monetization:campaign:end_tooltip'              => 'End Campaign & Refund Remaining Balance',
		'ossn:monetization:campaign:end_confirm'              => 'Are you sure you want to end this campaign? Any remaining balance will be refunded to your wallet.',

		//
		// Admin Pending Review Keys
		'ossn:monetization:admin:pending:title'               => 'Pending Ad Reviews',
		'ossn:monetization:admin:pending:subtitle'            => 'Review user ad submissions before they go live',
		'ossn:monetization:admin:pending:count'               => 'Pending Approval',
		'ossn:monetization:admin:owner'                       => 'Advertiser',
		'ossn:monetization:admin:site_owned'                  => 'Site Admin',
		'ossn:monetization:admin:no_pending'                  => 'All caught up! No ads are currently pending review.',
		'ossn:monetization:admin:approve'                     => 'Approve',
		'ossn:monetization:admin:decline'                     => 'Decline',
		'ossn:monetization:admin:approve_confirm'             => 'Approve this campaign and publish it immediately?',
		'ossn:monetization:admin:decline_confirm'             => 'Decline this campaign and refund the advertiser\'s balance?',
		'ossn:monetization:admin:approved_success'            => 'Campaign has been approved and is now live.',
		'ossn:monetization:admin:declined_success'            => 'Campaign declined and user funds refunded.',
		'ossn:monetization:admin:action_failed'               => 'Failed to update campaign approval status.',
		//
		'ossn:monetization:campaign:ended_success'            => 'Campaign ended successfully.',
		'ossn:monetization:campaign:ended_refunded'           => 'Campaign ended successfully! %s %s remaining credit was refunded to your wallet.',
		'ossn:monetization:campaign:already_ended'            => 'This campaign has already ended or expired.',
		'ossn:monetization:campaign:already_declined'         => 'This campaign was declined by an admin and its funds have already been refunded.',
		'ossn:monetization:campaign:end_failed'               => 'Failed to update campaign status.',
		'ossn:monetization:campaign:error:not_owner'          => 'You do not have permission to modify this campaign.',
		'ossn:monetization:campaign:error:no_wallet'          => 'Could not process refund: Wallet account not found.',
		//
		// Mail Notifications - Admin New Campaign Created
		'ossn:monetization:mail:admin_new:subject'            => '[%s Admin] New Ad Campaign Submitted',
		'ossn:monetization:mail:admin_new:body'               => "Hello Admin,

A new ad campaign has been submitted on %s.

----------------------------------------
Campaign Title: %s
Advertiser: %s
Budget: %s
Status: %s
----------------------------------------

Please review this campaign in the admin panel:
%s

Regards,
System",

		// Mail Notifications - User Approved
		'ossn:monetization:mail:user_approved:subject'        => '[%s] Your Ad Campaign Has Been Approved!',
		'ossn:monetization:mail:user_approved:body'           => "Hello %s,

Great news! Your ad campaign '%s' has been approved and is now live on %s.

You can track your live campaign impressions, clicks, and remaining balance anytime here:
%s

Thank you for advertising with us!

Best regards,
Support Team",

		// Mail Notifications - User Declined
		'ossn:monetization:mail:user_declined:subject'        => '[%s] Update Regarding Your Ad Campaign',
		'ossn:monetization:mail:user_declined:refund_line'    => "Your unspent budget of %s %s has been refunded back to your wallet balance.
",
		'ossn:monetization:mail:user_declined:body'           => "Hello %s,

We regret to inform you that your ad campaign '%s' was not approved for display on %s.

%sYou can view your campaign history here:
%s

Best regards,
Support Team",
		//

		// Billing Modes
		'ossn:monetization:mode:daily'                        => 'Daily',
		'ossn:monetization:mode:fixed'                        => 'Fixed',
		'ossn:monetization:mode:flat'                         => 'Flat Rate',
		'ossn:monetization:mode:performance'                  => 'Performance',

		// Table Metrics & Submetrics
		'ossn:monetization:spent'                             => 'Spent: %s %s',
		'ossn:monetization:days_left'                         => '%s Days Left',
		'ossn:monetization:flat_rate_hits'                    => 'Flat Rate (Unlimited Hits)',
		'ossn:monetization:views'                             => 'views',
		'ossn:monetization:clicks'                            => 'clicks',

		// Actions
		'ossn:monetization:campaign:end_title'                => 'End / Cancel Campaign',

		//
		'ossn:monetization:campaign:gender'                   => 'Gender',

		// Gender Badges
		'ossn:monetization:gender:male'                       => 'Male',
		'ossn:monetization:gender:female'                     => 'Female',
		'ossn:monetization:gender:other'                      => 'Other',
		'ossn:monetization:gender:all'                        => 'All Genders',
		'ossn:monetization:campaign:createddate'              => 'Created Date',
		'ossn:monetization:admin:mode:both'                   => 'Hybrid Mode (Allow Both Daily & Performance)',

		//
		'ossn:monetization:section:creative'                  => 'Title & Creative Copy',
		'ossn:monetization:section:targeting'                 => 'Placement & Target Audience',
		'ossn:monetization:section:budget'                    => 'Budget & Schedule',
		'ossn:monetization:placeholder:title'                 => 'e.g. 50% Off Summer Flash Sale!',
		'ossn:monetization:placeholder:url'                   => 'https://example.com/landing-page',
		'ossn:monetization:placeholder:desc'                  => 'Write catchy ad copy to encourage clicks...',
		'ossn:monetization:counter:left'                      => 'left',
		'ossn:monetization:file:recommendation'               => 'Recommended size: 1200 x 630px (JPG, PNG, WEBP - Max 2MB)',
		'ossn:monetization:per_day'                           => 'day',
		'ossn:monetization:mode:performance:desc'             => 'Pay per click or view',
		'ossn:monetization:preview:title'                     => 'Live Ad Preview',
		'ossn:monetization:preview:placeholder_title'         => 'Your Ad Title Here',
		'ossn:monetization:preview:placeholder_desc'          => 'Your ad copy preview will render live in this space as you type...',
		'ossn:monetization:preview:placeholder_image'         => 'Banner Preview',
);

ossn_register_languages('en', $en);
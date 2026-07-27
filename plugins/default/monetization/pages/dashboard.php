<?php
$user = ossn_loggedin_user();

// Fetch ads owned by the logged-in user
$adsModel = new OssnAds();
$user_ads = $adsModel->getAds(array(
			'order_by' => "o.guid DESC",
			'entities_pairs' => array(
					array(
						'name'  => 'ad_owner_guid',
						'value' => $user->guid,	  
					),						  
			),									
));

$count = $adsModel->getAds(array(
    'count'      => true,
	'entities_pairs' => array(
					array(
						'name'  => 'ad_owner_guid',
						'value' => $user->guid,	  
					),						  
	),				
));

// Currency Code
$currency = defined('WALLET_CURRENCY_CODE') ? WALLET_CURRENCY_CODE : 'USD';
?>
<div class="ossn-campaign-dashboard">
    <!-- Header Controls -->
    <div class="dashboard-header-row">
        <div>
            <h3 class="dashboard-title"><?php echo ossn_print('ossn:monetization:dashboard:title'); ?></h3>
            <span class="text-muted small"><?php echo ossn_print('ossn:monetization:dashboard:subtitle'); ?></span>
        </div>
        <a href="<?php echo ossn_site_url('campaigns/create'); ?>" class="btn-launch-new">
            <i class="fa fa-plus-circle me-0"></i> <?php echo ossn_print('ossn:monetization:campaign:create'); ?>
        </a>
    </div>

    <!-- Campaigns Table -->
    <div class="table-responsive rounded border">
        <table class="table table-campaigns align-middle ">
            <thead>
                <tr>
                	<th><?php echo ossn_print('ad:photo'); ?></th>
                    <th><?php echo ossn_print('ad:title'); ?></th>
                    <th><?php echo ossn_print('ad:placement'); ?></th>
                    <th class="text-center"><?php echo ossn_print('ossn:monetization:campaign:gender'); ?></th>
                    <th class="text-center"><?php echo ossn_print('ossn:monetization:campaign:budget'); ?></th>
                    <th class="text-center"><?php echo ossn_print('ossn:monetization:campaign:balance'); ?></th>
                    <th class="text-center"><?php echo ossn_print('ad:views'); ?> / <?php echo ossn_print('ad:clicks'); ?></th>
                    <th class="text-center"><?php echo ossn_print('ossn:monetization:campaign:createddate'); ?></th>
                    <th class="text-center"><?php echo ossn_print('ossn:monetization:campaign:expirydate'); ?></th>
                    <th class="text-center"><?php echo ossn_print('ad:status'); ?></th>
                    <th class="text-center"><?php echo ossn_print('ossn:monetization:actions'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($user_ads) {
                foreach ($user_ads as $ad) {
                    $placements = json_decode($ad->placement, true);
                    if (!is_array($placements)) { $placements = array(); }

                    $genders = isset($ad->gender_target) ? json_decode($ad->gender_target, true) : array();
                    if (!is_array($genders)) { $genders = array(); }

                    // Custom Metadata Properties
                    $initial_budget = isset($ad->initial_budget) ? (float)$ad->initial_budget : 0.00;
                    $views          = isset($ad->views_count) ? (int)$ad->views_count : 0;
                    $clicks         = isset($ad->clicks_count) ? (int)$ad->clicks_count : 0;
                    $raw_expiry     = isset($ad->expire_time) ? (int)$ad->expire_time : 0;
                    
                    // Billing Mode & Raw metadata values
                    $billing_mode   = isset($ad->billing_mode) ? strtolower($ad->billing_mode) : 'performance';
                    $approved       = isset($ad->approved) ? $ad->approved : 'pending';

                    // Strict check for expired boolean flag
                    $is_expired     = isset($ad->expired) && ($ad->expired == true);
                    $balance        = isset($ad->balance) ? (float)$ad->balance : 0.00;

                    // Check if campaign is time-based (daily, fixed, flat)
                    $is_time_based  = ($billing_mode === 'daily');

                    // Calculate Spend (for performance campaigns)
                    $spent = max(0, $initial_budget - $balance);

                    // Status Mapping
                    if ($approved === 'declined') {
                        $status_key  = 'declined';
                        $badge_class = 'badge-declined';
                    } elseif ($approved === 'pending') {
                        $status_key  = 'pending';
                        $badge_class = 'badge-pending';
                    } elseif ($is_expired) {
                        $status_key  = 'expired';
                        $badge_class = 'badge-expired';
                    } else {
                        $status_key  = 'active';
                        $badge_class = 'badge-active';
                    }
					$ad_image   = $ad->getPhotoURL()
                    ?>
                    <tr>
                        <td>
                            <a href="<?php echo $ad_image; ?>" target="_blank">
                                <img src="<?php echo $ad_image; ?>" class="rounded border" style="width: 70px; height: 50px; object-fit: cover;" />
                            </a>
                        </td>                    
                        <!-- Title & URL -->
                        <td>
                            <strong class="d-block text-dark"><?php echo htmlspecialchars($ad->title); ?></strong>
                            <small class="text-muted d-block"><?php echo $ad->description; ?></small>
                            <a href="<?php echo htmlspecialchars($ad->site_url); ?>" target="_blank" class="small text-primary text-decoration-none">
                                <i class="fa fa-external-link me-1"></i><?php echo parse_url($ad->site_url, PHP_URL_HOST); ?>
                            </a>
                        </td>

                        <!-- Placement -->
                        <td>
                            <?php if (!empty($placements)): ?>
                                <?php foreach ($placements as $place): ?>
                                    <?php $placementLangKey = ($place === 'global') ? 'sidebar_all' : $place; ?>
                                    <span class="badge bg-light text-secondary border me-1 my-1">
                                        <?php echo ossn_print("ossn:monetization:placement:{$placementLangKey}"); ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>

                        <!-- Gender Targets -->
                        <td class="text-center">
                            <?php if (!empty($genders)): ?>
                                <?php foreach ($genders as $gen): ?>
                                    <span class="badge bg-light text-dark border me-1 my-1 text-capitalize">
                                        <?php echo ossn_print("ossn:monetization:gender:{$gen}"); ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="badge bg-light text-dark border my-1">
                                    <?php echo ossn_print('ossn:monetization:gender:all'); ?>
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Budget & Type -->
                        <td class="text-center">
                            <span class="campaign-metric"><?php echo sprintf('%.2f', $initial_budget); ?> <?php echo $currency; ?></span>
                            <span class="campaign-submetric mode-badge"><?php echo ossn_print("ossn:monetization:mode:{$billing_mode}"); ?></span>
                        </td>

                        <!-- Balance Left / Time Remaining -->
                        <td class="text-center">
                            <?php if ($is_time_based): ?>
                                <?php 
                                $now = time();
                                $days_left = ($raw_expiry > $now) ? ceil(($raw_expiry - $now) / 86400) : 0;
                                ?>
                                <span class="campaign-metric text-dark">
                                    <?php echo ossn_print('ossn:monetization:days_left', array($days_left)); ?>
                                </span>
                                <span class="campaign-submetric"><?php echo ossn_print('ossn:monetization:flat_rate_hits'); ?></span>
                            <?php else: ?>
                                <span class="campaign-metric text-primary"><?php echo monetization_format_amount($balance); ?> <?php echo $currency; ?></span>
                                <span class="campaign-submetric"><?php echo ossn_print('ossn:monetization:spent', array(sprintf('%.3f', $spent), $currency)); ?></span>
                            <?php endif; ?>
                        </td>

                        <!-- Impressions / Clicks -->
                        <td class="text-center">
                            <span class="campaign-metric"><?php echo number_format($views); ?> <small class="text-muted fs-7"><?php echo ossn_print('ossn:monetization:views'); ?></small></span>
                            <span class="campaign-submetric"><?php echo number_format($clicks); ?> <?php echo ossn_print('ossn:monetization:clicks'); ?></span>
                        </td>

						<td class="text-center">
                                <span class="small font-monospace text-dark"><?php echo date('M j, Y', $ad->time_created); ?></span>
                        </td>
                        <!-- End Date -->
                        <td class="text-center">
                            <?php if ($raw_expiry > 0): ?>
                                <span class="small font-monospace text-dark"><?php echo date('M j, Y', $raw_expiry); ?></span>
                            <?php else: ?>
                                <span class="text-muted small"><?php echo ossn_print('ad:end:date:infinity'); ?></span>
                            <?php endif; ?>
                        </td>

                        <!-- Status Badge -->
                        <td class="text-center">
                            <span class="campaign-badge <?php echo $badge_class; ?>">
                                <?php echo ossn_print("ossn:monetization:status:{$status_key}"); ?>
                            </span>
                        </td>

                        <!-- Actions (Edit / End Campaign) -->
                        <td class="text-center">
                            <?php if ($approved !== 'declined' && !$is_expired): ?>
                                <a href="<?php echo ossn_site_url("action/monetization/campaign/end?guid={$ad->guid}", true); ?>" 
                                   class="action-btn-icon ossn-make-sure" 
                                   title="<?php echo ossn_print('ossn:monetization:campaign:end_title'); ?>"
                                   data-ossn-msg="<?php echo ossn_print('ossn:monetization:campaign:end_confirm'); ?>">
                                    <i class="fa fa-stop-circle me-0"></i>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="fa fa-folder-open-o d-block fs-2 mb-2 text-secondary opacity-50"></i>
                        <?php echo ossn_print('ossn:monetization:no_campaigns'); ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Pagination -->
<div class="row">
    <?php echo ossn_view_pagination($count); ?>
</div>
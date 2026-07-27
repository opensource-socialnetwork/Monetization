<?php
$adsModel = new OssnAds();

$pending_ads = $adsModel->getAds(array(
	'order_by' => "o.guid DESC",								   
    'entities_pairs' => array(
        array(
            'name'  => 'approved',
            'value' => 'pending',
        ),
    ),
));

$count = $adsModel->getAds(array(
    'count'          => true,
    'entities_pairs' => array(
        array(
            'name'  => 'approved',
            'value' => 'pending',
        ),
    ),
));

$currency = defined('WALLET_CURRENCY_CODE') ? WALLET_CURRENCY_CODE : 'USD';
?>

<div class="ossn-admin-pending-ads-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-1"><?php echo ossn_print('ossn:monetization:admin:pending:title'); ?></h3>
            <p class="text-muted small mb-0"><?php echo ossn_print('ossn:monetization:admin:pending:subtitle'); ?></p>
        </div>
        <span class="badge bg-warning text-dark px-3 py-2 fs-6">
            <i class="fa fa-clock-o me-1"></i> <?php echo (int)$count; ?> <?php echo ossn_print('ossn:monetization:admin:pending:count'); ?>
        </span>
    </div>

    <div class="table-responsive bg-white rounded border shadow-sm ossn-campaign-dashboard">
        <table class="table table-campaigns align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th><?php echo ossn_print('ad:photo'); ?></th>
                    <th><?php echo ossn_print('ad:title'); ?></th>
                    <th><?php echo ossn_print('ossn:monetization:admin:owner'); ?></th>
                    <th><?php echo ossn_print('ad:placement'); ?></th>
                    <th class="text-center"><?php echo ossn_print('ossn:monetization:campaign:budget'); ?></th>
                    <th class="text-center"><?php echo ossn_print('ossn:monetization:campaign:createddate'); ?></th>
                    <th class="text-center"><?php echo ossn_print('ossn:monetization:campaign:expirydate'); ?></th>
                    <th class="text-center" width="160"><?php echo ossn_print('ossn:monetization:actions'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($pending_ads) {
                foreach ($pending_ads as $ad) {
                    $owner = ossn_user_by_guid($ad->ad_owner_guid);
                    $placements = json_decode($ad->placement, true);
                    if (!is_array($placements)) { $placements = array(); }

                    $budget     = isset($ad->initial_budget) ? (float)$ad->initial_budget : 0.00;
                    $raw_expiry = isset($ad->expire_time) ? $ad->expire_time : 0;
                    $ad_image   = $ad->getPhotoURL()
                    ?>
                    <tr>
                        <!-- Ad Banner Image Preview -->
                        <td>
                            <a href="<?php echo $ad_image; ?>" target="_blank">
                                <img src="<?php echo $ad_image; ?>" class="rounded border" style="width: 70px; height: 50px; object-fit: cover;" />
                            </a>
                        </td>

                        <!-- Title, Description & Link -->
                        <td>
                            <strong class="d-block text-dark"><?php echo htmlspecialchars($ad->title); ?></strong>
                            <small class="text-muted d-block"><?php echo $ad->description; ?></small>
                            <a href="<?php echo htmlspecialchars($ad->site_url); ?>" target="_blank" class="small text-primary text-decoration-none">
                                <i class="fa fa-external-link me-1"></i><?php echo parse_url($ad->site_url, PHP_URL_HOST); ?>
                            </a>
                        </td>

                        <!-- Ad Owner / User -->
                        <td>
                            <?php if ($owner): ?>
                                <a href="<?php echo $owner->profileURL(); ?>" target="_blank" class="d-flex align-items-center text-decoration-none text-dark">
                                    <img src="<?php echo $owner->iconURL()->small; ?>" class="rounded-circle me-2" width="28" height="28" />
                                    <span><?php echo $owner->fullname; ?></span>
                                </a>
                            <?php else: ?>
                                <span class="text-muted"><?php echo ossn_print('ossn:monetization:admin:site_owned'); ?></span>
                            <?php endif; ?>
                        </td>

                        <!-- Placement Badges -->
                        <td>
                            <?php if (!empty($placements)): ?>
                                <?php foreach ($placements as $place): ?>
                                    <?php $placementLangKey = ($place === 'global') ? 'sidebar_all' : $place; ?>
                                    <span class="badge bg-light text-dark border me-1 mb-1">
                                        <?php echo ossn_print("ossn:monetization:placement:{$placementLangKey}"); ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>

                        <!-- Budget & Optimization Mode -->
                        <td class="text-center">
                            <strong class="text-dark d-block"><?php echo sprintf('%.2f', $budget); ?> <?php echo $currency; ?></strong>
                            <span class="badge bg-secondary text-uppercase" style="font-size: 10px;">
                                <?php echo isset($ad->optimization_type) ? strtoupper($ad->optimization_type) : strtoupper($ad->billing_mode); ?>
                            </span>
                        </td>

						<td class="text-center">
                                <span class="small font-monospace text-dark"><?php echo date('M j, Y', $ad->time_created); ?></span>
                        </td>
                        <!-- Expiry Date -->
                        <td class="text-center small">
                            <?php if ($raw_expiry > 0): ?>
                                <?php echo date('M j, Y', $raw_expiry); ?>
                            <?php else: ?>
                                <span class="text-muted"><?php echo ossn_print('ad:end:date:infinity'); ?></span>
                            <?php endif; ?>
                        </td>

                        <!-- Action Buttons -->
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <!-- Approve Action -->
                                <a href="<?php echo ossn_site_url("action/monetization/admin/approve?guid={$ad->guid}", true); ?>" 
                                   class="btn btn-success ossn-make-sure" 
                                   data-ossn-msg="<?php echo ossn_print('ossn:monetization:admin:approve_confirm'); ?>">
                                    <i class="fa fa-check"></i> <?php echo ossn_print('ossn:monetization:admin:approve'); ?>
                                </a>

                                <!-- Decline Action -->
                                <a href="<?php echo ossn_site_url("action/monetization/admin/decline?guid={$ad->guid}", true); ?>" 
                                   class="btn btn-danger ossn-make-sure" 
                                   data-ossn-msg="<?php echo ossn_print('ossn:monetization:admin:decline_confirm'); ?>">
                                    <i class="fa fa-times"></i> <?php echo ossn_print('ossn:monetization:admin:decline'); ?>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>

                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa fa-check-circle-o d-block fs-2 mb-2 text-success"></i>
                        <?php echo ossn_print('ossn:monetization:admin:no_pending'); ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    <?php echo ossn_view_pagination($count); ?>
</div>
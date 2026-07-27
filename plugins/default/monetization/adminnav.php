<?php
$ads   = new OssnAds();
$total = $ads->getAds(array(
		'count' => true,
));
$total_pending = $ads->getAds(array(
		'count'          => true,
		'entities_pairs' => array(
				array(
						'name'  => 'approved',
						'value' => 'pending',
				),
		),
));
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom px-3 py-2 mb-4">
    <div class="container-fluid p-0">
        <!-- Section Title / Brand -->
        <span class="navbar-brand fw-bold fs-6 d-flex align-items-center gap-2 mb-0">
            <i class="fa fa-rectangle-ad text-primary"></i> <?php echo ossn_print('ossn:monetization');?>
        </span>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#monetizationAdminNav" aria-controls="monetizationAdminNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Items -->
        <div class="collapse navbar-collapse" id="monetizationAdminNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1 align-items-lg-center">
                
                <!-- 1. Campaigns Dropdown (Includes Pending Ads) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 fw-medium active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bullhorn text-primary"></i> <?php echo ossn_print('ossn:monetization:campaign');?>
                        <?php if(!empty($total_pending)){ ?>
	                        <span class="badge text-bg-warning rounded-pill ms-1"><?php echo $total_pending;?></span>
                        <?php } ?>    
                    </a>
                    <ul class="dropdown-menu shadow-sm border mt-1">
                        <li>
                            <a class="dropdown-item d-flex align-items-center justify-content-between gap-3" href="<?php echo ossn_site_url('administrator/component/OssnAds'); ?>">
                                <span><i class="fa fa-list text-secondary me-2"></i> <?php echo ossn_print('ossn:monetization:allcampaign');?></span>
                                <span class="badge text-bg-primary rounded-pill"><?php echo $total;?></span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center justify-content-between gap-3" href="<?php echo ossn_site_url('administrator/component/Monetization?page=pending'); ?>">
                                <span><i class="fa fa-clock text-warning me-2"></i> <?php echo ossn_print('ossn:monetization:admin:pending:title');?></span>
                                <span class="badge text-bg-warning rounded-pill"><?php echo $total_pending;?></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 2. Settings Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 fw-medium text-body" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-sliders-h text-secondary"></i> <?php echo ossn_print('settings');?>
                    </a>
                    <ul class="dropdown-menu shadow-sm border mt-1">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="<?php echo ossn_site_url('administrator/component/Monetization?page=settings'); ?>">
                                <i class="fa fa-cog text-secondary"></i> <?php echo ossn_print('ossn:monetization:campaign:pricing');?>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
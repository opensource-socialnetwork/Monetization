<?php
// Load Admin Monetization Settings
$com = new \OssnComponents();
$settings = $com->getSettings('Monetization');

$admin_billing_mode = ($settings && isset($settings->billing_mode)) ? $settings->billing_mode : 'both';
$daily_rate         = ($settings && isset($settings->daily_rate)) ? (float)$settings->daily_rate : 3.00;
$cpc_rate           = ($settings && isset($settings->cpc_rate)) ? (float)$settings->cpc_rate : 0.20;
$cpm_rate           = ($settings && isset($settings->cpm_rate)) ? (float)$settings->cpm_rate : 1.00;
$min_budget         = ($settings && isset($settings->min_budget)) ? (float)$settings->min_budget : 5.00;

// Currency Code
$currency_code = defined('WALLET_CURRENCY_CODE') ? WALLET_CURRENCY_CODE : 'USD';

// Default Dates
$default_expiry = date('Y-m-d', strtotime('+7 days'));
$min_expiry     = date('Y-m-d', strtotime('+1 day'));
?>
<div class="monetization-builder-container">
    <div class="monetization-split-grid">
        <div class="builder-form-side">
            <div class="builder-card">
                <div class="builder-card-title">
                    <i class="fa fa-pencil-square"></i> <?php echo ossn_print('ossn:monetization:section:creative'); ?>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label-modern mb-0"><?php echo ossn_print('ad:title'); ?></label>
                        <span class="small text-muted" id="builder-title-counter">35 <?php echo ossn_print('ossn:monetization:counter:left'); ?></span>
                    </div>
                    <input type="text" name="title" id="builder-input-title" class="form-control-modern" maxlength="35" placeholder="<?php echo ossn_print('ossn:monetization:placeholder:title'); ?>" required />
                </div>

                <div class="mb-3">
                    <label class="form-label-modern"><?php echo ossn_print('ad:site:url'); ?></label>
                    <input type="url" name="siteurl" id="builder-input-url" class="form-control-modern" placeholder="<?php echo ossn_print('ossn:monetization:placeholder:url'); ?>" required />
                </div>

                <div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label-modern mb-0"><?php echo ossn_print('ad:desc'); ?></label>
                        <span class="small text-muted" id="builder-desc-counter">250 <?php echo ossn_print('ossn:monetization:counter:left'); ?></span>
                    </div>
                    <textarea name="description" id="builder-input-desc" class="form-control-modern" rows="3" maxlength="250" placeholder="<?php echo ossn_print('ossn:monetization:placeholder:desc'); ?>"></textarea>
                </div>
            </div>

            <!-- SECTION 2: Media Banner Upload -->
            <div class="builder-card">
                <div class="builder-card-title">
                    <i class="fa fa-image"></i> <?php echo ossn_print('ad:photo'); ?>
                </div>

                <input type="file" name="ossn_ads" id="builder_file_input" class="d-none" accept="image/*" />
                
                <div id="builder-dropzone" class="dropzone-upload-box">
                    <label for="builder_file_input" class="mb-0 cursor-pointer">
                        <span class="dropzone-icon"><i class="fa fa-cloud-upload"></i></span>
                        <span class="d-block fw-bold text-dark fs-6"><?php echo ossn_print('ad:file:choose'); ?></span>
                        <span class="small text-muted"><?php echo ossn_print('ossn:monetization:file:recommendation'); ?></span>
                    </label>
                </div>

                <div id="builder-file-selected" class="d-none text-center pt-2">
                    <span class="badge bg-light text-dark border px-3 py-2 me-2" id="builder-filename-display">image.png</span>
                    <button type="button" id="builder-remove-file" class="btn btn-sm btn-outline-danger py-1 px-2 fs-7">
                        <i class="fa fa-trash"></i> <?php echo ossn_print('ad:file:remove'); ?>
                    </button>
                </div>
            </div>

            <!-- SECTION 3: Targeting Controls -->
            <div class="builder-card">
                <div class="builder-card-title">
                    <i class="fa fa-bullseye"></i> <?php echo ossn_print('ossn:monetization:section:targeting'); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label-modern"><?php echo ossn_print('ad:placement'); ?></label>
                    <div class="custom-pill-checkboxes">
                        <?php
                        $placementOptions = array(
                            'newsfeed' => ossn_print('ossn:monetization:placement:newsfeed'),
                            'profile'  => ossn_print('ossn:monetization:placement:profile'),
                            'groups'   => ossn_print('ossn:monetization:placement:groups'),
                            'global'   => ossn_print('ossn:monetization:placement:sidebar_all')
                        );
                        foreach ($placementOptions as $pKey => $pLabel):
                            $checked = 'checked';
                        ?>
                            <label>
                                <input type="checkbox" name="placement[]" value="<?php echo $pKey; ?>" <?php echo $checked; ?> />
                                <span><?php echo $pLabel; ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <label class="form-label-modern"><?php echo ossn_print('ad:gender:target'); ?></label>
                    <div class="custom-pill-checkboxes">
                        <?php
                        $genderTypes = (new OssnUser())->genderTypes();
                        if ($genderTypes && is_array($genderTypes)):
                            foreach ($genderTypes as $gender):
                                $langKey = ($gender === 'male' || $gender === 'female') ? $gender : 'gender:other';
                        ?>
                                <label>
                                    <input type="checkbox" name="gender_target[]" value="<?php echo $gender; ?>" checked />
                                    <span><?php echo ossn_print($langKey); ?></span>
                                </label>
                        <?php 
                            endforeach;
                        endif; 
                        ?>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: Budget & Schedule -->
            <div class="builder-card mb-0">
                <div class="builder-card-title">
                    <i class="fa fa-calculator"></i> <?php echo ossn_print('ossn:monetization:section:budget'); ?>
                </div>

                <!-- Billing Mode Selector -->
                <?php if ($admin_billing_mode === 'both'): ?>
                    <div class="mb-3">
                        <label class="form-label-modern"><?php echo ossn_print('ossn:monetization:admin:billing_mode'); ?></label>
                        <div class="billing-mode-selector">
                            <label class="billing-mode-card active" id="mode-card-daily">
                                <input type="radio" name="billing_mode" value="daily" checked />
                                <span class="mode-badge-title"><?php echo ossn_print('ossn:monetization:mode:daily'); ?></span>
                                <span class="mode-badge-desc"><?php echo sprintf('%.2f', $daily_rate) . ' ' . $currency_code; ?> / <?php echo ossn_print('ossn:monetization:per_day'); ?></span>
                            </label>
                            <label class="billing-mode-card" id="mode-card-performance">
                                <input type="radio" name="billing_mode" value="performance" />
                                <span class="mode-badge-title"><?php echo ossn_print('ossn:monetization:mode:performance'); ?></span>
                                <span class="mode-badge-desc"><?php echo ossn_print('ossn:monetization:mode:performance:desc'); ?></span>
                            </label>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="billing_mode" id="builder-active-billing-mode" value="<?php echo htmlspecialchars($admin_billing_mode); ?>" />
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-modern"><?php echo ossn_print('ossn:monetization:campaign:expirydate'); ?></label>
                        <input type="date" name="expiry_date" id="builder-expiry-date" class="form-control-modern" value="<?php echo $default_expiry; ?>" min="<?php echo $min_expiry; ?>" required />
                    </div>

                    <!-- Performance Budget (Shown dynamically) -->
                    <div class="col-md-6" id="performance-budget-wrapper" style="<?php echo ($admin_billing_mode === 'performance') ? '' : 'display:none;'; ?>">
                        <label class="form-label-modern"><?php echo ossn_print('ossn:monetization:campaign:budget'); ?> (<?php echo $currency_code; ?>)</label>
                        <input type="number" name="budget" id="builder-budget-amount" class="form-control-modern" value="<?php echo $min_budget; ?>" min="<?php echo $min_budget; ?>" step="1.00" />
                    </div>
                </div>

                <div class="mt-3" id="performance-opt-wrapper" style="<?php echo ($admin_billing_mode === 'performance') ? '' : 'display:none;'; ?>">
                    <label class="form-label-modern"><?php echo ossn_print('ossn:monetization:campaign:optimization'); ?></label>
                    <?php 
                    echo ossn_plugin_view('input/dropdown', array(
                        'name'    => 'optimization_type',
                        'id'      => 'builder-opt-type',
                        'value'   => 'cpc',
                        'options' => array(
                            'cpc' => ossn_print('ossn:monetization:campaign:opt:cpc') . ' (' . sprintf('%.2f', $cpc_rate) . ' ' . $currency_code . ')',
                            'cpm' => ossn_print('ossn:monetization:campaign:opt:cpm') . ' (' . sprintf('%.2f', $cpm_rate) . ' ' . $currency_code . ')'
                        )
                    ));
                    ?>
                </div>
            </div>

        </div>

       <!-- RIGHT COLUMN: Interactive Live Ad Preview & Checkout -->
<div class="builder-preview-side">
    <div class="sticky-preview-wrapper">
        
        <!-- Live Preview Container -->
        <div class="preview-box-container">
            <div class="preview-box-header">
                <i class="fa fa-eye me-1"></i> <?php echo ossn_print('ossn:monetization:preview:title'); ?>
            </div>
            
            <a href="#" id="preview-card-link" target="_blank" class="preview-clickable-card">
                <div class="mock-feed-ad">
                    <!-- Top Meta Row: Sponsored Badge + Dynamic Domain Host -->
                    <div class="mock-sponsored-meta">
                        <span class="mock-sponsored-badge"><?php echo ossn_print('sponsored'); ?></span>
                        <span class="mock-domain-preview" id="preview-domain-host">example.com</span>
                    </div>

                    <div class="mock-ad-title" id="preview-display-title"><?php echo ossn_print('ossn:monetization:preview:placeholder_title'); ?></div>
                    
                    <div class="mock-ad-image-frame" id="preview-image-frame">
                        <img src="#" id="preview-real-img" class="w-100 h-100 object-fit-contain d-none" alt="Preview" />
                        <span id="preview-placeholder-text"><i class="fa fa-picture-o fa-2x d-block mb-1"></i> <?php echo ossn_print('ossn:monetization:preview:placeholder_image'); ?></span>
                    </div>

                    <div class="mock-ad-desc" id="preview-display-desc"><?php echo ossn_print('ossn:monetization:preview:placeholder_desc'); ?></div>
                </div>
            </a>
        </div>

        <!-- Light Checkout Summary Card -->
        <div class="checkout-summary-card">
            <span class="d-block text-uppercase small text-muted fw-bold"><?php echo ossn_print('ossn:monetization:campaign:total_cost'); ?></span>
            <div class="d-flex align-items-baseline gap-2 my-1">
                <span class="price-tag" id="summary-total-price">0.00</span>
                <span class="fw-bold text-dark"><?php echo $currency_code; ?></span>
            </div>
            <span class="small text-muted d-block" id="summary-cost-hint">--</span>

            <button type="submit" class="btn-launch-campaign">
                <i class="fa fa-rocket me-1"></i> <?php echo ossn_print('ossn:monetization:campaign:launch'); ?>
            </button>
        </div>

    </div>
</div>

    </div>
</div>

<script>
jQuery(document).ready(function ($) {
    // 1. Live Text Preview Sync
    $('#builder-input-title').on('input', function () {
        var val = $(this).val().trim();
        var max = 35;
        $('#builder-title-counter').text((max - val.length) + ' ' + Ossn.Print('ossn:monetization:counter:left'));
        $('#preview-display-title').text(val.length > 0 ? val : Ossn.Print('ossn:monetization:preview:placeholder_title'));
    });

    $('#builder-input-desc').on('input', function () {
        var val = $(this).val().trim();
        var max = 250;
        $('#builder-desc-counter').text((max - val.length) + ' ' + Ossn.Print('ossn:monetization:counter:left'));
        $('#preview-display-desc').text(val.length > 0 ? val : Ossn.Print('ossn:monetization:preview:placeholder_desc'));
    });

    // Sync URL input to update the domain text and clickable preview link
    $('#builder-input-url').on('input', function () {
        var rawUrl = $(this).val().trim();
        if (rawUrl.length > 0) {
            var formattedUrl = (rawUrl.indexOf('http://') === 0 || rawUrl.indexOf('https://') === 0) 
                ? rawUrl 
                : 'https://' + rawUrl;

            $('#preview-card-link').attr('href', formattedUrl);

            try {
                var urlObj = new URL(formattedUrl);
                var host = urlObj.hostname.replace(/^www\./, '');
                $('#preview-domain-host').text(host.length > 0 ? host : 'example.com');
            } catch (e) {
                $('#preview-domain-host').text('example.com');
            }
        } else {
            $('#preview-card-link').attr('href', '#');
            $('#preview-domain-host').text('example.com');
        }
    });

    // 2. Dropzone & Real-time Image Preview
    $('#builder_file_input').on('change', function (e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (event) {
                $('#preview-real-img').attr('src', event.target.result).removeClass('d-none');
                $('#preview-placeholder-text').addClass('d-none');

                $('#builder-filename-display').text(file.name);
                $('#builder-dropzone').addClass('d-none');
                $('#builder-file-selected').removeClass('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    $('#builder-remove-file').on('click', function () {
        $('#builder_file_input').val('');
        $('#preview-real-img').attr('src', '#').addClass('d-none');
        $('#preview-placeholder-text').removeClass('d-none');

        $('#builder-file-selected').addClass('d-none');
        $('#builder-dropzone').removeClass('d-none');
    });

    // 3. Billing Mode Selector Toggle
    $('.billing-mode-card').on('click', function () {
        $('.billing-mode-card').removeClass('active');
        $(this).addClass('active');
        recalculateCost();
    });

    // 4. Real-time Cost Calculation Engine
    var dailyRate = <?php echo (float)$daily_rate; ?>;
    var cpcRate   = <?php echo (float)$cpc_rate; ?>;
    var cpmRate   = <?php echo (float)$cpm_rate; ?>;
    var currency  = <?php echo json_encode($currency_code); ?>;

    function getSelectedMode() {
        var radioVal = $('input[name="billing_mode"]:checked').val();
        if (radioVal) return radioVal;
        return $('#builder-active-billing-mode').val() || 'daily';
    }

    function calculateDays() {
        var selectedVal = $('#builder-expiry-date').val();
        if (!selectedVal) return 1;

        var today = new Date();
        today.setHours(0, 0, 0, 0);

        var expiry = new Date(selectedVal + 'T00:00:00');
        var diffDays = Math.ceil((expiry.getTime() - today.getTime()) / (1000 * 3600 * 24));
        return diffDays > 0 ? diffDays : 1;
    }

    function recalculateCost() {
        var mode = getSelectedMode();
        var days = calculateDays();

        if (mode === 'daily') {
            $('#performance-budget-wrapper, #performance-opt-wrapper').hide();

            var total = days * dailyRate;
            $('#summary-total-price').text(total.toFixed(2));
            $('#summary-cost-hint').text(Ossn.Print('ossn:monetization:campaign:explanation:daily', [days, dailyRate.toFixed(2), currency]));
        } else {
            $('#performance-budget-wrapper, #performance-opt-wrapper').fadeIn(150);

            var budget = parseFloat($('#builder-budget-amount').val()) || 0;
            var optType = $('#builder-opt-type').val();
            $('#summary-total-price').text(budget.toFixed(2));

            if (optType === 'cpc') {
                var clicks = Math.floor(budget / cpcRate);
                $('#summary-cost-hint').text(Ossn.Print('ossn:monetization:campaign:explanation:cpc', [clicks.toLocaleString()]));
            } else {
                var views = Math.floor((budget / cpmRate) * 1000);
                $('#summary-cost-hint').text(Ossn.Print('ossn:monetization:campaign:explanation:cpm', [views.toLocaleString()]));
            }
        }
    }

    $('#builder-expiry-date, #builder-budget-amount, #builder-opt-type').on('change input', recalculateCost);
    recalculateCost();
});
</script>
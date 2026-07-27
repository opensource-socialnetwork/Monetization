<?php
/**
 * OssnMonetization - Admin Settings Form
 * Location: plugins/default/forms/OssnMonetization/admin/settings.php
 */

$com = new \OssnComponents();
$settings = $com->getSettings('Monetization');

// Safely pull object properties or set sensible defaults
$billing_mode    = ($settings && isset($settings->billing_mode)) ? $settings->billing_mode : 'both';
$daily_rate      = ($settings && isset($settings->daily_rate)) ? (float)$settings->daily_rate : 3.00;
$cpc_rate        = ($settings && isset($settings->cpc_rate)) ? (float)$settings->cpc_rate : 0.20;
$cpm_rate        = ($settings && isset($settings->cpm_rate)) ? (float)$settings->cpm_rate : 1.00;
$min_budget      = ($settings && isset($settings->min_budget)) ? (float)$settings->min_budget : 5.00;
$feed_interval   = ($settings && isset($settings->feed_interval)) ? (int)$settings->feed_interval : 5;

// Wallet currency code fallback if constant is not defined
$currency_code = defined('WALLET_CURRENCY_CODE') ? WALLET_CURRENCY_CODE : 'USD';

// Safely pull object properties with fallback
$auto_approve    = ($settings && isset($settings->auto_approve)) ? $settings->auto_approve : 'no';

// Shared Options Array with string keys
$yes_no_options = array(
    'yes' => ossn_print('ossn:monetization:yes'),
    'no'  => ossn_print('ossn:monetization:no')
);
?>

<style>
/* Scoped Component Styling */
.ossn-monetization-admin-panel {
    background: var(--bs-body-bg, #ffffff);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: var(--bs-border-radius-lg, 0.75rem);
}

.ossn-monetization-admin-panel .setting-section-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--bs-heading-color, #1e293b);
    padding-bottom: 0.65rem;
    border-bottom: 2px solid var(--bs-border-color-subtle, #f1f5f9);
}

/* Fancy Colorful Icon Badges */
.ossn-monetization-admin-panel .icon-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 8px;
    font-size: 15px;
}

.ossn-monetization-admin-panel .icon-badge.pricing-icon {
    background-color: #eff6ff;
    color: #2563eb;
}

.ossn-monetization-admin-panel .icon-badge.safety-icon {
    background-color: #ecfdf5;
    color: #059669;
}

.ossn-monetization-admin-panel .icon-badge.display-icon {
    background-color: #f3e8ff;
    color: #9333ea;
}

.ossn-monetization-admin-panel label {
    font-weight: 600;
    font-size: 0.875rem;
    color: var(--bs-body-color, #334155);
    margin-bottom: 0.35rem;
    display: block;
}

.ossn-monetization-admin-panel .form-text {
    font-size: 0.775rem;
    color: var(--bs-secondary-color, #64748b);
    margin-top: 0.35rem;
}

.ossn-monetization-admin-panel .btn-save-monetization {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #ffffff;
    font-weight: 600;
    padding: 0.55rem 1.75rem;
    border-radius: var(--bs-border-radius, 0.375rem);
    border: none;
    transition: transform 0.15s ease, filter 0.15s ease, box-shadow 0.15s ease;
}

.ossn-monetization-admin-panel .btn-save-monetization:hover {
    filter: brightness(1.08);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    color: #ffffff;
}

.ossn-monetization-admin-panel .btn-save-monetization:active {
    transform: scale(0.98);
}
</style>

<div class="ossn-monetization-admin-panel p-4 shadow-sm">

    <!-- 1. PRICING & BILLING MODEL SECTION -->
    <div class="setting-section-title mb-3 d-flex align-items-center gap-2">
        <span class="icon-badge pricing-icon">
            <i class="fa fa-money-bill-alt me-0"></i>
        </span>
        <?php echo ossn_print('ossn:monetization:admin:section:pricing'); ?>
    </div>

    <div class="mb-3">
        <label><?php echo ossn_print('ossn:monetization:admin:billing_mode'); ?></label>
        <?php 
        echo ossn_plugin_view('input/dropdown', array(
            'name' => 'billing_mode',
            'id' => 'ossn-monetization-billing-mode',
            'value' => $billing_mode,
            'options' => array(
                'daily'       => ossn_print('ossn:monetization:admin:mode:daily'),
                'performance' => ossn_print('ossn:monetization:admin:mode:performance'),
                'both'        => ossn_print('ossn:monetization:admin:mode:both')
            )
        ));
        ?>
        <div class="form-text"><?php echo ossn_print('ossn:monetization:admin:billing_mode:hint'); ?></div>
    </div>

    <!-- Mode A: Daily Rate Input (Visible for 'daily' or 'both') -->
    <div class="mb-3 mode-field mode-daily" style="<?php echo ($billing_mode === 'daily' || $billing_mode === 'both') ? '' : 'display:none;'; ?>">
        <label><?php echo ossn_print('ossn:monetization:admin:daily_rate'); ?> (<?php echo $currency_code; ?>)</label>
        <?php 
        echo ossn_plugin_view('input/text', array(
            'name' => 'daily_rate',
            'value' => $daily_rate,
            'placeholder' => '3.00'
        ));
        ?>
        <div class="form-text"><?php echo ossn_print('ossn:monetization:admin:daily_rate:hint'); ?></div>
    </div>

    <!-- Mode B: Performance Rates (Visible for 'performance' or 'both') -->
    <div class="mode-field mode-performance" style="<?php echo ($billing_mode === 'performance' || $billing_mode === 'both') ? '' : 'display:none;'; ?>">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label><?php echo ossn_print('ossn:monetization:admin:cpc_rate'); ?> (<?php echo $currency_code; ?>)</label>
                <?php 
                echo ossn_plugin_view('input/text', array(
                    'name' => 'cpc_rate',
                    'value' => $cpc_rate,
                    'placeholder' => '0.20'
                ));
                ?>
                <div class="form-text"><?php echo ossn_print('ossn:monetization:admin:cpc_rate:hint'); ?></div>
            </div>
            <div class="col-md-6">
                <label><?php echo ossn_print('ossn:monetization:admin:cpm_rate'); ?> (<?php echo $currency_code; ?>)</label>
                <?php 
                echo ossn_plugin_view('input/text', array(
                    'name' => 'cpm_rate',
                    'value' => $cpm_rate,
                    'placeholder' => '1.00'
                ));
                ?>
                <div class="form-text"><?php echo ossn_print('ossn:monetization:admin:cpm_rate:hint'); ?></div>
            </div>
        </div>

        <div class="mb-3">
            <label><?php echo ossn_print('ossn:monetization:admin:min_budget'); ?> (<?php echo $currency_code; ?>)</label>
            <?php 
            echo ossn_plugin_view('input/text', array(
                'name' => 'min_budget',
                'value' => $min_budget,
                'placeholder' => '5.00'
            ));
            ?>
            <div class="form-text"><?php echo ossn_print('ossn:monetization:admin:min_budget:hint'); ?></div>
        </div>
    </div>

    <hr class="my-4" />

    <!-- 2. APPROVAL & SAFETY RULES SECTION -->
    <div class="setting-section-title mb-3 d-flex align-items-center gap-2">
        <span class="icon-badge safety-icon">
            <i class="fa fa-shield me-0"></i>
        </span>
        <?php echo ossn_print('ossn:monetization:admin:section:safety'); ?>
    </div>

    <div class="mb-3">
        <label><?php echo ossn_print('ossn:monetization:admin:auto_approve'); ?></label>
        <?php 
        echo ossn_plugin_view('input/dropdown', array(
            'name' => 'auto_approve',
            'value' => $auto_approve,
            'options' => $yes_no_options
        ));
        ?>
        <div class="form-text"><?php echo ossn_print('ossn:monetization:admin:auto_approve:hint'); ?></div>
    </div>

    <hr class="my-4" />

    <!-- 3. FEED & DISPLAY CONTROL SECTION -->
    <div class="setting-section-title mb-3 d-flex align-items-center gap-2 d-none">
        <span class="icon-badge display-icon">
            <i class="fa fa-desktop me-0"></i>
        </span>
        <?php echo ossn_print('ossn:monetization:admin:section:display'); ?>
    </div>

    <div class="row g-3 mb-4 d-none">
        <div class="col-md-4 d-none">
            <label><?php echo ossn_print('ossn:monetization:admin:feed_interval'); ?></label>
            <?php 
            echo ossn_plugin_view('input/text', array(
                'name' => 'feed_interval',
                'type' => 'number',
                'value' => $feed_interval
            ));
            ?>
            <div class="form-text"><?php echo ossn_print('ossn:monetization:admin:feed_interval:hint'); ?></div>
        </div>
    </div>

    <div class="text-end">
        <input type="submit" class="btn-save-monetization" value="<?php echo ossn_print('save'); ?>" />
    </div>

</div>

<script>
jQuery(document).ready(function ($) {
    function toggleBillingFields(selectedMode) {
        if (selectedMode === 'daily') {
            $('.mode-performance').hide();
            $('.mode-daily').fadeIn(200);
        } else if (selectedMode === 'performance') {
            $('.mode-daily').hide();
            $('.mode-performance').fadeIn(200);
        } else if (selectedMode === 'both') {
            $('.mode-daily').fadeIn(200);
            $('.mode-performance').fadeIn(200);
        }
    }

    $('select[name="billing_mode"]').on('change', function () {
        toggleBillingFields($(this).val());
    });
});
</script>
<?php
/**
 * Currency Admin Interface
 * File: inc/currency/currency-admin.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Currency admin page
 */
function yoursite_currency_admin_page() {
    $active_tab = $_GET['tab'] ?? 'currencies';
    
    // Handle form submissions
    if (isset($_POST['submit'])) {
        if ($active_tab === 'currencies') {
            yoursite_handle_currency_form();
        } elseif ($active_tab === 'settings') {
            yoursite_handle_currency_settings_form();
        }
    }
    
    ?>
    <div class="wrap">
        <h1><?php _e('Multi-Currency Management', 'yoursite'); ?></h1>
        
        <!-- Admin Navigation Tabs -->
        <nav class="nav-tab-wrapper">
            <a href="?page=yoursite-currencies&tab=currencies" 
               class="nav-tab <?php echo $active_tab === 'currencies' ? 'nav-tab-active' : ''; ?>">
                <?php _e('Currencies', 'yoursite'); ?>
            </a>
            <a href="?page=yoursite-currencies&tab=settings" 
               class="nav-tab <?php echo $active_tab === 'settings' ? 'nav-tab-active' : ''; ?>">
                <?php _e('Settings', 'yoursite'); ?>
            </a>
            <a href="?page=yoursite-currencies&tab=rates" 
               class="nav-tab <?php echo $active_tab === 'rates' ? 'nav-tab-active' : ''; ?>">
                <?php _e('Exchange Rates', 'yoursite'); ?>
            </a>
        </nav>
        
        <?php if ($active_tab === 'currencies') : ?>
            <?php yoursite_render_currencies_tab(); ?>
        <?php elseif ($active_tab === 'settings') : ?>
            <?php yoursite_render_settings_tab(); ?>
        <?php elseif ($active_tab === 'rates') : ?>
            <?php yoursite_render_rates_tab(); ?>
        <?php endif; ?>
        
    </div>
    <?php
}

/**
 * Render currencies management tab
 */
function yoursite_render_currencies_tab() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $currencies = $wpdb->get_results("SELECT * FROM $table_name ORDER BY display_order ASC, code ASC");
    
    ?>
    <div class="currency-management-section">
        
        <!-- Quick Stats -->
        <div class="currency-stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0;">
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
                <h3 style="margin: 0 0 10px 0; color: #0073aa;"><?php echo count(array_filter($currencies, function($c) { return $c->status === 'active'; })); ?></h3>
                <p style="margin: 0; color: #666;"><?php _e('Active Currencies', 'yoursite'); ?></p>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
                <h3 style="margin: 0 0 10px 0; color: #46b450;"><?php echo count(array_filter($currencies, function($c) { return $c->auto_update == 1; })); ?></h3>
                <p style="margin: 0; color: #666;"><?php _e('Auto-Updated', 'yoursite'); ?></p>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
                <h3 style="margin: 0 0 10px 0; color: #dc3232;"><?php echo count(array_filter($currencies, function($c) { return $c->is_crypto == 1; })); ?></h3>
                <p style="margin: 0; color: #666;"><?php _e('Cryptocurrencies', 'yoursite'); ?></p>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="currency-actions" style="margin: 20px 0; display: flex; gap: 10px; flex-wrap: wrap;">
            <button type="button" class="button button-primary" onclick="showAddCurrencyModal()">
                <?php _e('Add New Currency', 'yoursite'); ?>
            </button>
            <button type="button" class="button manual-refresh-btn" onclick="refreshAllRates()">
                <?php _e('Refresh All Rates', 'yoursite'); ?>
            </button>
            <button type="button" class="button" onclick="toggleAllCurrencies('active')">
                <?php _e('Activate All', 'yoursite'); ?>
            </button>
            <button type="button" class="button" onclick="toggleAllCurrencies('inactive')">
                <?php _e('Deactivate All', 'yoursite'); ?>
            </button>
        </div>
        
        <!-- Currency List -->
        <div class="currency-list" id="currency-list">
            <?php foreach ($currencies as $currency) : ?>
                <?php yoursite_render_currency_item($currency); ?>
            <?php endforeach; ?>
            
            <?php if (empty($currencies)) : ?>
                <div class="no-currencies" style="text-align: center; padding: 40px; background: #fff; border: 1px solid #ddd; border-radius: 8px;">
                    <h3><?php _e('No currencies configured yet', 'yoursite'); ?></h3>
                    <p><?php _e('Add your first currency to get started with multi-currency pricing.', 'yoursite'); ?></p>
                    <button type="button" class="button button-primary" onclick="showAddCurrencyModal()">
                        <?php _e('Add Currency', 'yoursite'); ?>
                    </button>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
    
    <!-- Add Currency Modal -->
    <div id="add-currency-modal" style="display: none;">
        <?php yoursite_render_add_currency_modal(); ?>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Make currency list sortable
        $('#currency-list').sortable({
            handle: '.currency-drag-handle',
            update: function(event, ui) {
                var order = $(this).sortable('serialize');
                $.post(ajaxurl, {
                    action: 'update_currency_order',
                    order: order,
                    nonce: currencyAjax.nonce
                });
            }
        });
    });
    
    function showAddCurrencyModal() {
        jQuery('#add-currency-modal').fadeIn();
    }
    
    function hideAddCurrencyModal() {
        jQuery('#add-currency-modal').fadeOut();
    }
    
    function refreshAllRates() {
        if (!confirm(currencyAjax.strings.confirm_refresh)) return;
        
        var button = jQuery('.manual-refresh-btn');
        var originalText = button.text();
        button.text(currencyAjax.strings.updating).prop('disabled', true);
        
        jQuery.post(ajaxurl, {
            action: 'refresh_currency_rates',
            nonce: currencyAjax.nonce
        }).done(function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert(currencyAjax.strings.error + ': ' + response.data);
            }
        }).fail(function() {
            alert(currencyAjax.strings.error);
        }).always(function() {
            button.text(originalText).prop('disabled', false);
        });
    }
    
    function toggleCurrency(id, status) {
        jQuery.post(ajaxurl, {
            action: 'toggle_currency_status',
            currency_id: id,
            status: status,
            nonce: currencyAjax.nonce
        }).done(function(response) {
            if (response.success) {
                location.reload();
            }
        });
    }
    
    function deleteCurrency(id) {
        if (!confirm(currencyAjax.strings.confirm_delete)) return;
        
        jQuery.post(ajaxurl, {
            action: 'delete_currency',
            currency_id: id,
            nonce: currencyAjax.nonce
        }).done(function(response) {
            if (response.success) {
                jQuery('#currency-' + id).fadeOut();
            }
        });
    }
    
    function toggleAllCurrencies(status) {
        jQuery.post(ajaxurl, {
            action: 'toggle_all_currencies',
            status: status,
            nonce: currencyAjax.nonce
        }).done(function(response) {
            if (response.success) {
                location.reload();
            }
        });
    }
    </script>
    <?php
}

/**
 * Render individual currency item
 */
function yoursite_render_currency_item($currency) {
    $last_updated = $currency->last_updated ? human_time_diff(strtotime($currency->last_updated)) . ' ago' : 'Never';
    $is_base = $currency->is_base_currency;
    
    ?>
    <div class="currency-item <?php echo $currency->status; ?>" id="currency-<?php echo $currency->id; ?>" data-id="<?php echo $currency->id; ?>">
        
        <!-- Drag Handle -->
        <div class="currency-drag-handle" style="cursor: move; display: inline-block; margin-right: 10px; color: #999;">
            ⋮⋮
        </div>
        
        <!-- Currency Info -->
        <div class="currency-info" style="display: inline-block; width: 300px;">
            <div class="currency-header" style="display: flex; align-items: center; margin-bottom: 5px;">
                <span class="currency-flag"><?php echo esc_html($currency->flag); ?></span>
                <strong class="currency-code"><?php echo esc_html($currency->code); ?></strong>
                <span style="margin-left: 10px; color: #666;"><?php echo esc_html($currency->name); ?></span>
                <?php if ($is_base) : ?>
                    <span style="background: #46b450; color: white; padding: 2px 8px; border-radius: 3px; font-size: 11px; margin-left: 10px;">
                        <?php _e('BASE', 'yoursite'); ?>
                    </span>
                <?php endif; ?>
                <?php if ($currency->is_crypto) : ?>
                    <span style="background: #f0b90b; color: white; padding: 2px 8px; border-radius: 3px; font-size: 11px; margin-left: 5px;">
                        <?php _e('CRYPTO', 'yoursite'); ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <div class="currency-format-preview">
                <?php echo yoursite_format_currency(1234.56, $currency->code); ?>
            </div>
        </div>
        
        <!-- Conversion Rate -->
        <div class="currency-rate-info" style="display: inline-block; width: 200px; vertical-align: top;">
            <div style="margin-bottom: 5px;">
                <strong><?php _e('Rate:', 'yoursite'); ?></strong> 
                <input type="number" class="conversion-rate-input" value="<?php echo esc_attr($currency->conversion_rate); ?>" 
                       step="0.00000001" min="0" data-currency-id="<?php echo $currency->id; ?>" 
                       onchange="updateConversionRate(<?php echo $currency->id; ?>, this.value)" />
            </div>
            <div class="currency-rate" style="font-size: 12px;">
                <?php _e('Updated:', 'yoursite'); ?> <?php echo $last_updated; ?>
                <span class="auto-update-indicator <?php echo $currency->auto_update ? 'active' : 'inactive'; ?>">
                    <?php echo $currency->auto_update ? '🔄' : '⏸️'; ?>
                </span>
            </div>
        </div>
        
        <!-- Currency Actions -->
        <div class="currency-actions">
            <button type="button" class="button button-small" onclick="editCurrency(<?php echo $currency->id; ?>)">
                <?php _e('Edit', 'yoursite'); ?>
            </button>
            
            <?php if ($currency->status === 'active') : ?>
                <button type="button" class="button button-small" onclick="toggleCurrency(<?php echo $currency->id; ?>, 'inactive')">
                    <?php _e('Deactivate', 'yoursite'); ?>
                </button>
            <?php else : ?>
                <button type="button" class="button button-small button-primary" onclick="toggleCurrency(<?php echo $currency->id; ?>, 'active')">
                    <?php _e('Activate', 'yoursite'); ?>
                </button>
            <?php endif; ?>
            
            <?php if (!$is_base) : ?>
                <button type="button" class="button button-small" onclick="setBaseCurrency(<?php echo $currency->id; ?>)">
                    <?php _e('Set as Base', 'yoursite'); ?>
                </button>
            <?php endif; ?>
            
            <button type="button" class="button button-small" style="color: #dc3232;" onclick="deleteCurrency(<?php echo $currency->id; ?>)">
                <?php _e('Delete', 'yoursite'); ?>
            </button>
        </div>
        
    </div>
    <?php
}

/**
 * Render add currency modal
 */
function yoursite_render_add_currency_modal() {
    $default_currencies = yoursite_get_default_currencies();
    
    ?>
    <div class="modal-overlay" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 9999;">
        <div class="modal-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; max-width: 600px; width: 90%; max-height: 80vh; overflow-y: auto;">
            
            <h2><?php _e('Add New Currency', 'yoursite'); ?></h2>
            
            <form method="post" id="add-currency-form">
                <?php wp_nonce_field('add_currency_nonce'); ?>
                
                <!-- Currency Selection -->
                <div style="margin-bottom: 20px;">
                    <label><strong><?php _e('Select Currency:', 'yoursite'); ?></strong></label>
                    <select name="currency_type" onchange="toggleCurrencyForm(this.value)" style="width: 100%; padding: 8px; margin-top: 5px;">
                        <option value=""><?php _e('Choose...', 'yoursite'); ?></option>
                        <optgroup label="<?php _e('Standard Currencies', 'yoursite'); ?>">
                            <?php foreach ($default_currencies as $code => $currency) : ?>
                                <?php if (!$currency['is_crypto'] ?? false) : ?>
                                    <option value="<?php echo $code; ?>"><?php echo $currency['flag']; ?> <?php echo $code; ?> - <?php echo $currency['name']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </optgroup>
                        <optgroup label="<?php _e('Cryptocurrencies', 'yoursite'); ?>">
                            <?php foreach ($default_currencies as $code => $currency) : ?>
                                <?php if ($currency['is_crypto'] ?? false) : ?>
                                    <option value="<?php echo $code; ?>"><?php echo $currency['flag']; ?> <?php echo $code; ?> - <?php echo $currency['name']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </optgroup>
                        <option value="custom"><?php _e('Custom Currency', 'yoursite'); ?></option>
                    </select>
                </div>
                
                <!-- Custom Currency Fields -->
                <div id="custom-currency-fields" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <label><strong><?php _e('Currency Code:', 'yoursite'); ?></strong></label>
                            <input type="text" name="custom_code" placeholder="USD" maxlength="10" style="width: 100%; padding: 8px; margin-top: 5px;" />
                        </div>
                        <div>
                            <label><strong><?php _e('Currency Name:', 'yoursite'); ?></strong></label>
                            <input type="text" name="custom_name" placeholder="US Dollar" style="width: 100%; padding: 8px; margin-top: 5px;" />
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <label><strong><?php _e('Symbol:', 'yoursite'); ?></strong></label>
                            <input type="text" name="custom_symbol" placeholder="$" style="width: 100%; padding: 8px; margin-top: 5px;" />
                        </div>
                        <div>
                            <label><strong><?php _e('Flag/Icon:', 'yoursite'); ?></strong></label>
                            <input type="text" name="custom_flag" placeholder="🇺🇸" style="width: 100%; padding: 8px; margin-top: 5px;" />
                        </div>
                        <div>
                            <label><strong><?php _e('Decimal Places:', 'yoursite'); ?></strong></label>
                            <input type="number" name="custom_decimal_places" value="2" min="0" max="8" style="width: 100%; padding: 8px; margin-top: 5px;" />
                        </div>
                    </div>
                </div>
                
                <!-- Currency Format Settings -->
                <div id="currency-format-settings" style="display: none;">
                    <h3><?php _e('Format Settings', 'yoursite'); ?></h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <label><strong><?php _e('Prefix:', 'yoursite'); ?></strong></label>
                            <input type="text" name="prefix" placeholder="$" style="width: 100%; padding: 8px; margin-top: 5px;" />
                        </div>
                        <div>
                            <label><strong><?php _e('Suffix:', 'yoursite'); ?></strong></label>
                            <input type="text" name="suffix" placeholder="" style="width: 100%; padding: 8px; margin-top: 5px;" />
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <label><strong><?php _e('Decimal Separator:', 'yoursite'); ?></strong></label>
                            <input type="text" name="decimal_separator" value="." maxlength="5" style="width: 100%; padding: 8px; margin-top: 5px;" />
                        </div>
                        <div>
                            <label><strong><?php _e('Thousand Separator:', 'yoursite'); ?></strong></label>
                            <input type="text" name="thousand_separator" value="," maxlength="5" style="width: 100%; padding: 8px; margin-top: 5px;" />
                        </div>
                    </div>
                    
                    <!-- Rounding Settings -->
                    <div style="margin-bottom: 20px;">
                        <label><strong><?php _e('Rounding Mode:', 'yoursite'); ?></strong></label>
                        <select name="rounding_mode" style="width: 100%; padding: 8px; margin-top: 5px;">
                            <option value="nearest"><?php _e('Nearest (1.23)', 'yoursite'); ?></option>
                            <option value="up"><?php _e('Round Up (1.99)', 'yoursite'); ?></option>
                            <option value="down"><?php _e('Round Down (1.00)', 'yoursite'); ?></option>
                            <option value="none"><?php _e('No Rounding', 'yoursite'); ?></option>
                        </select>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label><strong><?php _e('Rounding Precision:', 'yoursite'); ?></strong></label>
                        <select name="rounding_precision" style="width: 100%; padding: 8px; margin-top: 5px;">
                            <option value="0.01">0.01 (to nearest cent)</option>
                            <option value="0.05">0.05 (to nearest nickel)</option>
                            <option value="0.10">0.10 (to nearest dime)</option>
                            <option value="0.25">0.25 (to nearest quarter)</option>
                            <option value="0.50">0.50 (to nearest half)</option>
                            <option value="1.00">1.00 (to nearest whole)</option>
                            <option value="0.99">0.99 (psychological pricing)</option>
                            <option value="0.95">0.95 (ends in .95)</option>
                            <option value="0.87">0.87 (ends in .87)</option>
                        </select>
                    </div>
                    
                    <!-- Conversion Rate -->
                    <div style="margin-bottom: 20px;">
                        <label><strong><?php _e('Conversion Rate:', 'yoursite'); ?></strong></label>
                        <input type="number" name="conversion_rate" value="1.0" step="0.00000001" min="0" style="width: 100%; padding: 8px; margin-top: 5px;" />
                        <small style="color: #666; display: block; margin-top: 5px;">
                            <?php _e('Rate relative to base currency. Leave 1.0 to auto-fetch.', 'yoursite'); ?>
                        </small>
                    </div>
                    
                    <!-- Auto Update -->
                    <div style="margin-bottom: 20px;">
                        <label>
                            <input type="checkbox" name="auto_update" value="1" style="margin-right: 8px;" />
                            <strong><?php _e('Enable Auto-Update', 'yoursite'); ?></strong>
                        </label>
                        <small style="color: #666; display: block; margin-top: 5px;">
                            <?php _e('Automatically update conversion rates daily', 'yoursite'); ?>
                        </small>
                    </div>
                    
                    <!-- Preview -->
                    <div class="currency-preview" style="background: #f0f0f1; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                        <strong><?php _e('Preview:', 'yoursite'); ?></strong>
                        <div id="format-preview" style="font-family: monospace; font-size: 16px; margin-top: 5px;">
                            $1,234.56
                        </div>
                    </div>
                </div>
                
                <!-- Modal Actions -->
                <div style="text-align: right; border-top: 1px solid #ddd; padding-top: 20px; margin-top: 20px;">
                    <button type="button" class="button" onclick="hideAddCurrencyModal()">
                        <?php _e('Cancel', 'yoursite'); ?>
                    </button>
                    <button type="submit" name="submit" class="button button-primary" style="margin-left: 10px;">
                        <?php _e('Add Currency', 'yoursite'); ?>
                    </button>
                </div>
                
            </form>
            
        </div>
    </div>
    
    <script>
    function toggleCurrencyForm(selectedValue) {
        var customFields = document.getElementById('custom-currency-fields');
        var formatSettings = document.getElementById('currency-format-settings');
        
        if (selectedValue === 'custom') {
            customFields.style.display = 'block';
            formatSettings.style.display = 'block';
        } else if (selectedValue !== '') {
            customFields.style.display = 'none';
            formatSettings.style.display = 'block';
            // Pre-fill format settings for selected currency
            // This would be populated via AJAX or predefined data
        } else {
            customFields.style.display = 'none';
            formatSettings.style.display = 'none';
        }
    }
    
    // Update preview as user types
    jQuery(document).on('input', '[name="prefix"], [name="suffix"], [name="decimal_separator"], [name="thousand_separator"]', function() {
        updateFormatPreview();
    });
    
    function updateFormatPreview() {
        var prefix = jQuery('[name="prefix"]').val() || '';
        var suffix = jQuery('[name="suffix"]').val() || '';
        var decimal = jQuery('[name="decimal_separator"]').val() || '.';
        var thousand = jQuery('[name="thousand_separator"]').val() || ',';
        
        var amount = 1234.56;
        var formatted = amount.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        
        // Simple format replacement for preview
        if (thousand !== ',') {
            formatted = formatted.replace(',', thousand);
        }
        if (decimal !== '.') {
            formatted = formatted.replace('.', decimal);
        }
        
        jQuery('#format-preview').text(prefix + formatted + suffix);
    }
    </script>
    <?php
}

/**
 * Handle currency form submission
 */
function yoursite_handle_currency_form() {
    if (!wp_verify_nonce($_POST['_wpnonce'], 'add_currency_nonce')) {
        wp_die(__('Security check failed', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $currency_type = sanitize_text_field($_POST['currency_type']);
    
    if ($currency_type === 'custom') {
        $currency_data = array(
            'code' => strtoupper(sanitize_text_field($_POST['custom_code'])),
            'name' => sanitize_text_field($_POST['custom_name']),
            'symbol' => sanitize_text_field($_POST['custom_symbol']),
            'flag' => sanitize_text_field($_POST['custom_flag']),
            'decimal_places' => intval($_POST['custom_decimal_places'])
        );
    } else {
        $default_currencies = yoursite_get_default_currencies();
        if (!isset($default_currencies[$currency_type])) {
            wp_die(__('Invalid currency selected', 'yoursite'));
        }
        $currency_data = array_merge(array('code' => $currency_type), $default_currencies[$currency_type]);
    }
    
    // Add format and conversion settings
    $currency_data = array_merge($currency_data, array(
        'prefix' => sanitize_text_field($_POST['prefix'] ?? ''),
        'suffix' => sanitize_text_field($_POST['suffix'] ?? ''),
        'decimal_separator' => sanitize_text_field($_POST['decimal_separator'] ?? '.'),
        'thousand_separator' => sanitize_text_field($_POST['thousand_separator'] ?? ','),
        'rounding_mode' => sanitize_text_field($_POST['rounding_mode'] ?? 'nearest'),
        'rounding_precision' => sanitize_text_field($_POST['rounding_precision'] ?? '0.01'),
        'conversion_rate' => floatval($_POST['conversion_rate'] ?? 1.0),
        'auto_update' => isset($_POST['auto_update']) ? 1 : 0,
        'status' => 'active'
    ));
    
    $result = $wpdb->insert($table_name, $currency_data);
    
    if ($result) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible"><p>' . __('Currency added successfully!', 'yoursite') . '</p></div>';
        });
    } else {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error is-dismissible"><p>' . __('Error adding currency.', 'yoursite') . '</p></div>';
        });
    }
}


/**
 * Currency Settings Tab - Missing from currency-admin.php
 * File: inc/currency/currency-admin.php (Settings Tab Functions)
 */

/**
 * Render settings tab
 */
function yoursite_render_settings_tab() {
    $settings = get_option('yoursite_currency_settings', array());
    ?>
    <div class="currency-settings-section">
        
        <form method="post" action="">
            <?php wp_nonce_field('yoursite_currency_settings_nonce'); ?>
            <input type="hidden" name="tab" value="settings" />
            
            <!-- API Configuration -->
            <div class="settings-card">
                <h3><?php _e('🔗 Exchange Rate API Configuration', 'yoursite'); ?></h3>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('API Provider', 'yoursite'); ?></th>
                        <td>
                            <select name="api_provider" id="api-provider" onchange="toggleApiSettings(this.value)">
                                <option value="exchangerate_api" <?php selected($settings['api_provider'] ?? '', 'exchangerate_api'); ?>>
                                    ExchangeRate-API (Free/Paid)
                                </option>
                                <option value="fixer_io" <?php selected($settings['api_provider'] ?? '', 'fixer_io'); ?>>
                                    Fixer.io (Paid)
                                </option>
                                <option value="currencylayer" <?php selected($settings['api_provider'] ?? '', 'currencylayer'); ?>>
                                    CurrencyLayer (Free/Paid)
                                </option>
                                <option value="openexchangerates" <?php selected($settings['api_provider'] ?? '', 'openexchangerates'); ?>>
                                    Open Exchange Rates (Free/Paid)
                                </option>
                                <option value="manual" <?php selected($settings['api_provider'] ?? '', 'manual'); ?>>
                                    Manual Only (No API)
                                </option>
                            </select>
                            <p class="description">
                                <?php _e('Choose your preferred exchange rate provider. Some providers offer free tiers.', 'yoursite'); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr id="api-key-row" style="<?php echo ($settings['api_provider'] ?? '') === 'manual' ? 'display:none;' : ''; ?>">
                        <th scope="row"><?php _e('API Key', 'yoursite'); ?></th>
                        <td>
                            <input type="password" name="api_key" value="<?php echo esc_attr($settings['api_key'] ?? ''); ?>" 
                                   class="regular-text" id="api-key-input" />
                            <button type="button" class="button" onclick="toggleApiKeyVisibility()">
                                <?php _e('Show/Hide', 'yoursite'); ?>
                            </button>
                            <button type="button" class="button" onclick="testApiConnection()">
                                <?php _e('Test Connection', 'yoursite'); ?>
                            </button>
                            <p class="description">
                                <?php _e('Enter your API key. Leave empty for free tiers where available.', 'yoursite'); ?>
                            </p>
                            <div id="api-test-result"></div>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Auto Update Settings -->
            <div class="settings-card">
                <h3><?php _e('🔄 Automatic Updates', 'yoursite'); ?></h3>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Enable Auto Updates', 'yoursite'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="auto_update_enabled" value="1" 
                                       <?php checked($settings['auto_update_enabled'] ?? false, 1); ?>
                                       onchange="toggleAutoUpdateSettings(this.checked)" />
                                <?php _e('Automatically update exchange rates', 'yoursite'); ?>
                            </label>
                            <p class="description">
                                <?php _e('When enabled, currency rates will be updated automatically based on the schedule below.', 'yoursite'); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr id="update-frequency-row">
                        <th scope="row"><?php _e('Update Frequency', 'yoursite'); ?></th>
                        <td>
                            <select name="update_frequency">
                                <option value="hourly" <?php selected($settings['update_frequency'] ?? '', 'hourly'); ?>>
                                    <?php _e('Every Hour', 'yoursite'); ?>
                                </option>
                                <option value="six_hours" <?php selected($settings['update_frequency'] ?? '', 'six_hours'); ?>>
                                    <?php _e('Every 6 Hours', 'yoursite'); ?>
                                </option>
                                <option value="twelve_hours" <?php selected($settings['update_frequency'] ?? '', 'twelve_hours'); ?>>
                                    <?php _e('Every 12 Hours', 'yoursite'); ?>
                                </option>
                                <option value="daily" <?php selected($settings['update_frequency'] ?? '', 'daily'); ?>>
                                    <?php _e('Daily', 'yoursite'); ?>
                                </option>
                                <option value="weekly" <?php selected($settings['update_frequency'] ?? '', 'weekly'); ?>>
                                    <?php _e('Weekly', 'yoursite'); ?>
                                </option>
                            </select>
                            <p class="description">
                                <?php _e('How often to fetch new exchange rates. More frequent updates may hit API limits.', 'yoursite'); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('Email Notifications', 'yoursite'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="email_notifications" value="1" 
                                       <?php checked($settings['email_notifications'] ?? false, 1); ?> />
                                <?php _e('Send email notifications for rate updates', 'yoursite'); ?>
                            </label>
                            <br><br>
                            <label>
                                <?php _e('Notification Email:', 'yoursite'); ?>
                                <input type="email" name="notification_email" 
                                       value="<?php echo esc_attr($settings['notification_email'] ?? get_option('admin_email')); ?>" 
                                       class="regular-text" />
                            </label>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Display Settings -->
            <div class="settings-card">
                <h3><?php _e('🎨 Display Settings', 'yoursite'); ?></h3>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Currency Selector', 'yoursite'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="display_currency_selector" value="1" 
                                       <?php checked($settings['display_currency_selector'] ?? true, 1); ?> />
                                <?php _e('Show currency selector on frontend', 'yoursite'); ?>
                            </label>
                            <p class="description">
                                <?php _e('Display currency selector widget on your website.', 'yoursite'); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('Remember User Choice', 'yoursite'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="remember_user_choice" value="1" 
                                       <?php checked($settings['remember_user_choice'] ?? true, 1); ?> />
                                <?php _e('Remember user\'s currency preference', 'yoursite'); ?>
                            </label>
                            <p class="description">
                                <?php _e('Save user\'s currency choice in cookies/user meta.', 'yoursite'); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('Geolocation Detection', 'yoursite'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="geolocation_detection" value="1" 
                                       <?php checked($settings['geolocation_detection'] ?? false, 1); ?> />
                                <?php _e('Auto-detect currency based on visitor location', 'yoursite'); ?>
                            </label>
                            <p class="description">
                                <?php _e('Automatically set currency based on visitor\'s IP address (requires external service).', 'yoursite'); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('Show Original Price', 'yoursite'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="show_original_price" value="1" 
                                       <?php checked($settings['show_original_price'] ?? false, 1); ?> />
                                <?php _e('Show base currency price alongside converted price', 'yoursite'); ?>
                            </label>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Default Settings -->
            <div class="settings-card">
                <h3><?php _e('⚙️ Default Settings', 'yoursite'); ?></h3>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Default Rounding Mode', 'yoursite'); ?></th>
                        <td>
                            <select name="default_rounding_mode">
                                <option value="nearest" <?php selected($settings['default_rounding_mode'] ?? '', 'nearest'); ?>>
                                    <?php _e('Round to Nearest', 'yoursite'); ?>
                                </option>
                                <option value="up" <?php selected($settings['default_rounding_mode'] ?? '', 'up'); ?>>
                                    <?php _e('Round Up', 'yoursite'); ?>
                                </option>
                                <option value="down" <?php selected($settings['default_rounding_mode'] ?? '', 'down'); ?>>
                                    <?php _e('Round Down', 'yoursite'); ?>
                                </option>
                                <option value="none" <?php selected($settings['default_rounding_mode'] ?? '', 'none'); ?>>
                                    <?php _e('No Rounding', 'yoursite'); ?>
                                </option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('Staleness Threshold', 'yoursite'); ?></th>
                        <td>
                            <input type="number" name="staleness_threshold" 
                                   value="<?php echo esc_attr($settings['staleness_threshold'] ?? 48); ?>" 
                                   min="1" max="168" />
                            <span><?php _e('hours', 'yoursite'); ?></span>
                            <p class="description">
                                <?php _e('Consider rates stale after this many hours without update.', 'yoursite'); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- System Information -->
            <div class="settings-card">
                <h3><?php _e('📊 System Information', 'yoursite'); ?></h3>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Last Rate Update', 'yoursite'); ?></th>
                        <td>
                            <?php 
                            $last_update = get_option('yoursite_currency_last_update');
                            if ($last_update) {
                                echo human_time_diff(strtotime($last_update)) . ' ago (' . $last_update . ')';
                            } else {
                                echo __('Never', 'yoursite');
                            }
                            ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('Next Scheduled Update', 'yoursite'); ?></th>
                        <td>
                            <?php 
                            $next_update = wp_next_scheduled('yoursite_update_currency_rates');
                            if ($next_update) {
                                echo human_time_diff($next_update) . ' (' . date('Y-m-d H:i:s', $next_update) . ')';
                            } else {
                                echo __('Not scheduled', 'yoursite');
                            }
                            ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('Active Currencies', 'yoursite'); ?></th>
                        <td>
                            <?php echo yoursite_get_active_currencies_count(); ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button(__('Save Settings', 'yoursite')); ?>
            
        </form>
        
        <!-- Import/Export -->
        <div class="settings-card">
            <h3><?php _e('📤 Import/Export', 'yoursite'); ?></h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                
                <!-- Export -->
                <div>
                    <h4><?php _e('Export Configuration', 'yoursite'); ?></h4>
                    <p><?php _e('Export all currency settings and data.', 'yoursite'); ?></p>
                    <button type="button" class="button" onclick="exportCurrencyData()">
                        <?php _e('Export Data', 'yoursite'); ?>
                    </button>
                </div>
                
                <!-- Import -->
                <div>
                    <h4><?php _e('Import Configuration', 'yoursite'); ?></h4>
                    <p><?php _e('Import currency settings from a JSON file.', 'yoursite'); ?></p>
                    <input type="file" id="import-file" accept=".json" style="margin-bottom: 10px;" />
                    <br>
                    <button type="button" class="button" onclick="importCurrencyData()">
                        <?php _e('Import Data', 'yoursite'); ?>
                    </button>
                </div>
                
            </div>
        </div>
        
    </div>
    
    <script>
    function toggleApiSettings(provider) {
        const apiKeyRow = document.getElementById('api-key-row');
        if (provider === 'manual') {
            apiKeyRow.style.display = 'none';
        } else {
            apiKeyRow.style.display = 'table-row';
        }
    }
    
    function toggleAutoUpdateSettings(enabled) {
        const frequencyRow = document.getElementById('update-frequency-row');
        if (enabled) {
            frequencyRow.style.display = 'table-row';
        } else {
            frequencyRow.style.display = 'none';
        }
    }
    
    function toggleApiKeyVisibility() {
        const input = document.getElementById('api-key-input');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
    
    function testApiConnection() {
        const provider = document.getElementById('api-provider').value;
        const apiKey = document.getElementById('api-key-input').value;
        const resultDiv = document.getElementById('api-test-result');
        
        resultDiv.innerHTML = '<p style="color: #666;">Testing connection...</p>';
        
        jQuery.post(ajaxurl, {
            action: 'validate_currency_settings',
            api_provider: provider,
            api_key: apiKey,
            nonce: currencyAjax.nonce
        }).done(function(response) {
            if (response.success) {
                resultDiv.innerHTML = '<p style="color: #46b450;">✓ Connection successful! Found ' + response.data.rate_count + ' exchange rates.</p>';
            } else {
                resultDiv.innerHTML = '<p style="color: #dc3232;">✗ Connection failed: ' + response.data + '</p>';
            }
        }).fail(function() {
            resultDiv.innerHTML = '<p style="color: #dc3232;">✗ Network error occurred</p>';
        });
    }
    
    function exportCurrencyData() {
        jQuery.post(ajaxurl, {
            action: 'export_currency_data',
            nonce: currencyAjax.nonce
        }).done(function(response) {
            if (response.success) {
                const dataStr = JSON.stringify(response.data.data, null, 2);
                const dataBlob = new Blob([dataStr], {type: 'application/json'});
                const url = URL.createObjectURL(dataBlob);
                const link = document.createElement('a');
                link.href = url;
                link.download = response.data.filename;
                link.click();
                URL.revokeObjectURL(url);
            } else {
                alert('Export failed: ' + response.data);
            }
        });
    }
    
    function importCurrencyData() {
        const fileInput = document.getElementById('import-file');
        const file = fileInput.files[0];
        
        if (!file) {
            alert('Please select a file to import.');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = JSON.parse(e.target.result);
                // Here you would send the data to the server for processing
                alert('Import functionality would be implemented here');
            } catch (error) {
                alert('Invalid JSON file');
            }
        };
        reader.readAsText(file);
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        toggleApiSettings(document.getElementById('api-provider').value);
        toggleAutoUpdateSettings(document.querySelector('[name="auto_update_enabled"]').checked);
    });
    ?>

    </script>
    
    <style>
    .settings-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .settings-card h3 {
        margin-top: 0;
        color: #333;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    
    .form-table th {
        width: 200px;
        font-weight: 600;
    }
    
    .form-table td {
        vertical-align: top;
    }
    
    .form-table input[type="text"],
    .form-table input[type="email"],
    .form-table input[type="password"],
    .form-table select {
        margin-right: 10px;
    }
    
    #api-test-result {
        margin-top: 10px;
        padding: 10px;
        border-radius: 4px;
    }
    </style>
    <?php
}

/**
 * Handle currency settings form submission
 */
function yoursite_handle_currency_settings_form() {
    if (!wp_verify_nonce($_POST['_wpnonce'], 'yoursite_currency_settings_nonce')) {
        wp_die(__('Security check failed', 'yoursite'));
    }
    
    $settings = array(
        'api_provider' => sanitize_text_field($_POST['api_provider'] ?? 'exchangerate_api'),
        'api_key' => sanitize_text_field($_POST['api_key'] ?? ''),
        'auto_update_enabled' => isset($_POST['auto_update_enabled']),
        'update_frequency' => sanitize_text_field($_POST['update_frequency'] ?? 'daily'),
        'email_notifications' => isset($_POST['email_notifications']),
        'notification_email' => sanitize_email($_POST['notification_email'] ?? get_option('admin_email')),
        'display_currency_selector' => isset($_POST['display_currency_selector']),
        'remember_user_choice' => isset($_POST['remember_user_choice']),
        'geolocation_detection' => isset($_POST['geolocation_detection']),
        'show_original_price' => isset($_POST['show_original_price']),
        'default_rounding_mode' => sanitize_text_field($_POST['default_rounding_mode'] ?? 'nearest'),
        'staleness_threshold' => intval($_POST['staleness_threshold'] ?? 48)
    );
    
    update_option('yoursite_currency_settings', $settings);
    
    // Reschedule cron job if auto-update settings changed
    yoursite_schedule_currency_updates();
    
    add_action('admin_notices', function() {
        echo '<div class="notice notice-success is-dismissible"><p>' . __('Settings saved successfully!', 'yoursite') . '</p></div>';
    });
}

/**
 * Currency Exchange Rates Tab - Missing from currency-admin.php
 * File: inc/currency/currency-admin.php (Rates Tab Functions)
 */

/**
 * Render exchange rates tab
 */
function yoursite_render_rates_tab() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $currencies = $wpdb->get_results("SELECT * FROM $table_name ORDER BY display_order ASC, code ASC");
    $base_currency = yoursite_get_base_currency();
    $settings = get_option('yoursite_currency_settings', array());
    
    ?>
    <div class="currency-rates-section">
        
        <!-- Rate Management Header -->
        <div class="rates-header">
            <div class="rates-summary">
                <h3><?php _e('📈 Exchange Rates Management', 'yoursite'); ?></h3>
                <p><?php _e('Monitor and manage currency conversion rates. Rates are relative to your base currency.', 'yoursite'); ?></p>
                
                <div class="base-currency-display">
                    <strong><?php _e('Base Currency:', 'yoursite'); ?></strong>
                    <span class="base-currency-info">
                        <?php echo $base_currency['flag']; ?> 
                        <?php echo $base_currency['code']; ?> - <?php echo $base_currency['name']; ?>
                        <span class="rate-badge">1.00000000</span>
                    </span>
                </div>
            </div>
            
            <div class="rates-actions">
                <button type="button" class="button button-primary" onclick="refreshAllRatesAdvanced()">
                    🔄 <?php _e('Refresh All Rates', 'yoursite'); ?>
                </button>
                <button type="button" class="button" onclick="showRateHistoryModal()">
                    📊 <?php _e('Rate History', 'yoursite'); ?>
                </button>
                <button type="button" class="button" onclick="exportRatesData()">
                    📤 <?php _e('Export Rates', 'yoursite'); ?>
                </button>
            </div>
        </div>
        
        <!-- API Status -->
        <?php if (!empty($settings['api_provider']) && $settings['api_provider'] !== 'manual') : ?>
            <div class="api-status-card">
                <div class="api-status-header">
                    <h4><?php _e('API Status', 'yoursite'); ?></h4>
                    <span class="api-provider-badge"><?php echo esc_html($settings['api_provider']); ?></span>
                </div>
                
                <div class="api-status-grid">
                    <div class="status-item">
                        <span class="status-label"><?php _e('Last Update:', 'yoursite'); ?></span>
                        <span class="status-value">
                            <?php 
                            $last_update = get_option('yoursite_currency_last_update');
                            echo $last_update ? human_time_diff(strtotime($last_update)) . ' ago' : 'Never';
                            ?>
                        </span>
                    </div>
                    
                    <div class="status-item">
                        <span class="status-label"><?php _e('Auto Updates:', 'yoursite'); ?></span>
                        <span class="status-value <?php echo ($settings['auto_update_enabled'] ?? false) ? 'status-active' : 'status-inactive'; ?>">
                            <?php echo ($settings['auto_update_enabled'] ?? false) ? 'Enabled' : 'Disabled'; ?>
                        </span>
                    </div>
                    
                    <div class="status-item">
                        <span class="status-label"><?php _e('Next Update:', 'yoursite'); ?></span>
                        <span class="status-value">
                            <?php 
                            $next_update = wp_next_scheduled('yoursite_update_currency_rates');
                            echo $next_update ? human_time_diff($next_update) : 'Not scheduled';
                            ?>
                        </span>
                    </div>
                    
                    <div class="status-item">
                        <span class="status-label"><?php _e('API Health:', 'yoursite'); ?></span>
                        <span class="status-value" id="api-health-status">
                            <button type="button" class="button button-small" onclick="checkApiHealth()">
                                <?php _e('Check Now', 'yoursite'); ?>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Exchange Rates Table -->
        <div class="rates-table-container">
            <table class="widefat rates-table">
                <thead>
                    <tr>
                        <th width="20%"><?php _e('Currency', 'yoursite'); ?></th>
                        <th width="15%"><?php _e('Current Rate', 'yoursite'); ?></th>
                        <th width="15%"><?php _e('Previous Rate', 'yoursite'); ?></th>
                        <th width="10%"><?php _e('Change', 'yoursite'); ?></th>
                        <th width="15%"><?php _e('Last Updated', 'yoursite'); ?></th>
                        <th width="10%"><?php _e('Status', 'yoursite'); ?></th>
                        <th width="15%"><?php _e('Actions', 'yoursite'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($currencies as $currency) : 
                        $is_base = $currency->is_base_currency;
                        $is_stale = yoursite_is_currency_rate_stale($currency);
                        $previous_rate = get_option("yoursite_previous_rate_{$currency->code}", $currency->conversion_rate);
                        $rate_change = $currency->conversion_rate - $previous_rate;
                        $rate_change_percent = $previous_rate > 0 ? (($rate_change / $previous_rate) * 100) : 0;
                        ?>
                        <tr class="currency-rate-row <?php echo $currency->status; ?> <?php echo $is_stale ? 'stale' : ''; ?>" 
                            data-currency="<?php echo esc_attr($currency->code); ?>">
                            
                            <!-- Currency Info -->
                            <td class="currency-info-cell">
                                <div class="currency-info">
                                    <span class="currency-flag"><?php echo esc_html($currency->flag); ?></span>
                                    <div class="currency-details">
                                        <strong class="currency-code"><?php echo esc_html($currency->code); ?></strong>
                                        <div class="currency-name"><?php echo esc_html($currency->name); ?></div>
                                        <?php if ($is_base) : ?>
                                            <span class="base-badge">BASE</span>
                                        <?php endif; ?>
                                        <?php if ($currency->is_crypto) : ?>
                                            <span class="crypto-badge">CRYPTO</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Current Rate -->
                            <td class="rate-cell">
                                <?php if ($is_base) : ?>
                                    <span class="base-rate">1.00000000</span>
                                <?php else : ?>
                                    <div class="rate-input-wrapper">
                                        <input type="number" 
                                               class="rate-input" 
                                               value="<?php echo esc_attr(number_format($currency->conversion_rate, 8)); ?>"
                                               step="0.00000001"
                                               min="0"
                                               data-currency="<?php echo esc_attr($currency->code); ?>"
                                               onchange="updateCurrencyRate('<?php echo esc_attr($currency->code); ?>', this.value)" />
                                        <div class="rate-display">
                                            <?php echo number_format($currency->conversion_rate, 8); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Previous Rate -->
                            <td class="previous-rate-cell">
                                <?php if (!$is_base) : ?>
                                    <span class="previous-rate"><?php echo number_format($previous_rate, 8); ?></span>
                                <?php else : ?>
                                    <span class="base-rate">1.00000000</span>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Change -->
                            <td class="change-cell">
                                <?php if (!$is_base && abs($rate_change) > 0.00000001) : ?>
                                    <div class="rate-change <?php echo $rate_change > 0 ? 'positive' : 'negative'; ?>">
                                        <span class="change-amount">
                                            <?php echo ($rate_change > 0 ? '+' : '') . number_format($rate_change, 8); ?>
                                        </span>
                                        <span class="change-percent">
                                            (<?php echo ($rate_change_percent > 0 ? '+' : '') . number_format($rate_change_percent, 2); ?>%)
                                        </span>
                                    </div>
                                <?php else : ?>
                                    <span class="no-change">—</span>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Last Updated -->
                            <td class="updated-cell">
                                <?php if ($currency->last_updated) : ?>
                                    <div class="update-info">
                                        <span class="update-time" title="<?php echo esc_attr($currency->last_updated); ?>">
                                            <?php echo human_time_diff(strtotime($currency->last_updated)); ?> ago
                                        </span>
                                        <?php if ($is_stale) : ?>
                                            <span class="stale-indicator">⚠️ Stale</span>
                                        <?php endif; ?>
                                    </div>
                                <?php else : ?>
                                    <span class="never-updated">Never</span>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Status -->
                            <td class="status-cell">
                                <div class="status-indicators">
                                    <span class="status-badge status-<?php echo $currency->status; ?>">
                                        <?php echo ucfirst($currency->status); ?>
                                    </span>
                                    <?php if ($currency->auto_update) : ?>
                                        <span class="auto-update-badge">Auto</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            
                            <!-- Actions -->
                            <td class="actions-cell">
                                <div class="rate-actions">
                                    <?php if (!$is_base) : ?>
                                        <button type="button" class="button button-small refresh-single-btn" 
                                                onclick="refreshSingleRate('<?php echo esc_attr($currency->code); ?>')"
                                                title="<?php _e('Refresh this rate', 'yoursite'); ?>">
                                            🔄
                                        </button>
                                    <?php endif; ?>
                                    
                                    <button type="button" class="button button-small history-btn" 
                                            onclick="showRateHistory('<?php echo esc_attr($currency->code); ?>')"
                                            title="<?php _e('View rate history', 'yoursite'); ?>">
                                        📊
                                    </button>
                                    
                                    <button type="button" class="button button-small edit-btn" 
                                            onclick="editCurrencyRate('<?php echo esc_attr($currency->code); ?>')"
                                            title="<?php _e('Edit currency settings', 'yoursite'); ?>">
                                        ✏️
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Rate Statistics -->
        <div class="rate-statistics">
            <h4><?php _e('Rate Statistics', 'yoursite'); ?></h4>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?php echo count(array_filter($currencies, function($c) { return $c->status === 'active'; })); ?></div>
                    <div class="stat-label"><?php _e('Active Currencies', 'yoursite'); ?></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value">
                        <?php 
                        $auto_updated = count(array_filter($currencies, function($c) { return $c->auto_update == 1; }));
                        echo $auto_updated;
                        ?>
                    </div>
                    <div class="stat-label"><?php _e('Auto-Updated', 'yoursite'); ?></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value">
                        <?php 
                        $stale_count = 0;
                        foreach ($currencies as $currency) {
                            if (yoursite_is_currency_rate_stale($currency)) {
                                $stale_count++;
                            }
                        }
                        echo $stale_count;
                        ?>
                    </div>
                    <div class="stat-label"><?php _e('Stale Rates', 'yoursite'); ?></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value"><?php echo count(array_filter($currencies, function($c) { return $c->is_crypto == 1; })); ?></div>
                    <div class="stat-label"><?php _e('Cryptocurrencies', 'yoursite'); ?></div>
                </div>
            </div>
        </div>
        
        <!-- Manual Rate Entry -->
        <div class="manual-rate-entry">
            <h4><?php _e('Manual Rate Entry', 'yoursite'); ?></h4>
            <p><?php _e('Manually set exchange rates for specific currencies. These will override API rates.', 'yoursite'); ?></p>
            
            <div class="manual-entry-form">
                <div class="form-row">
                    <label>
                        <?php _e('Currency:', 'yoursite'); ?>
                        <select id="manual-currency-select">
                            <option value=""><?php _e('Select currency...', 'yoursite'); ?></option>
                            <?php foreach ($currencies as $currency) : ?>
                                <?php if (!$currency->is_base_currency) : ?>
                                    <option value="<?php echo esc_attr($currency->code); ?>">
                                        <?php echo $currency->flag; ?> <?php echo $currency->code; ?> - <?php echo $currency->name; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    
                    <label>
                        <?php _e('Rate:', 'yoursite'); ?>
                        <input type="number" id="manual-rate-input" step="0.00000001" min="0" placeholder="1.00000000" />
                    </label>
                    
                    <button type="button" class="button button-primary" onclick="setManualRate()">
                        <?php _e('Set Rate', 'yoursite'); ?>
                    </button>
                </div>
                
                <div class="manual-entry-help">
                    <small>
                        <?php _e('Example: If 1', 'yoursite'); ?> <?php echo $base_currency['code']; ?> = 0.85 EUR, enter 0.85000000
                    </small>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Rate History Modal -->
    <div id="rate-history-modal" class="currency-modal" style="display: none;">
        <div class="modal-backdrop" onclick="closeRateHistoryModal()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="history-modal-title"><?php _e('Rate History', 'yoursite'); ?></h3>
                <button type="button" class="modal-close" onclick="closeRateHistoryModal()">×</button>
            </div>
            <div class="modal-body">
                <div id="rate-history-content">
                    <p><?php _e('Loading rate history...', 'yoursite'); ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function refreshAllRatesAdvanced() {
        if (!confirm('<?php _e('This will fetch fresh rates from your configured API provider. Continue?', 'yoursite'); ?>')) {
            return;
        }
        
        const button = document.querySelector('.button.button-primary');
        const originalText = button.textContent;
        button.textContent = '<?php _e('Refreshing...', 'yoursite'); ?>';
        button.disabled = true;
        
        // Add progress indicator
        const progressDiv = document.createElement('div');
        progressDiv.id = 'refresh-progress';
        progressDiv.innerHTML = '<div class="progress-bar"><div class="progress-fill"></div></div><p>Updating exchange rates...</p>';
        button.parentNode.insertBefore(progressDiv, button.nextSibling);
        
        jQuery.post(ajaxurl, {
            action: 'refresh_currency_rates',
            nonce: currencyAjax.nonce
        }).done(function(response) {
            if (response.success) {
                progressDiv.innerHTML = '<p style="color: green;">✓ Successfully updated ' + response.data.updated_count + ' currencies</p>';
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                progressDiv.innerHTML = '<p style="color: red;">✗ Error: ' + response.data + '</p>';
            }
        }).fail(function() {
            progressDiv.innerHTML = '<p style="color: red;">✗ Network error occurred</p>';
        }).always(function() {
            button.textContent = originalText;
            button.disabled = false;
            setTimeout(() => {
                if (progressDiv.parentNode) {
                    progressDiv.remove();
                }
            }, 3000);
        });
    }
    
    function refreshSingleRate(currency) {
        const button = document.querySelector(`[onclick="refreshSingleRate('${currency}')"]`);
        const originalContent = button.innerHTML;
        button.innerHTML = '⟳';
        button.disabled = true;
        
        jQuery.post(ajaxurl, {
            action: 'refresh_single_currency_rate',
            currency: currency,
            nonce: currencyAjax.nonce
        }).done(function(response) {
            if (response.success) {
                // Update the rate display
                const rateInput = document.querySelector(`[data-currency="${currency}"].rate-input`);
                const rateDisplay = document.querySelector(`[data-currency="${currency}"] .rate-display`);
                
                // You would fetch the new rate here
                location.reload(); // For now, just reload
            } else {
                alert('<?php _e('Failed to refresh rate', 'yoursite'); ?>: ' + response.data);
            }
        }).fail(function() {
            alert('<?php _e('Network error occurred', 'yoursite'); ?>');
        }).always(function() {
            button.innerHTML = originalContent;
            button.disabled = false;
        });
    }
    
    function updateCurrencyRate(currency, newRate) {
        if (newRate <= 0) {
            alert('<?php _e('Rate must be greater than 0', 'yoursite'); ?>');
            return;
        }
        
        jQuery.post(ajaxurl, {
            action: 'update_conversion_rate',
            currency_id: currency, // You'd need to pass the ID instead
            conversion_rate: newRate,
            nonce: currencyAjax.nonce
        }).done(function(response) {
            if (response.success) {
                // Update the display
                const rateDisplay = document.querySelector(`[data-currency="${currency}"] .rate-display`);
                if (rateDisplay) {
                    rateDisplay.textContent = parseFloat(newRate).toFixed(8);
                }
                
                // Show success indicator
                showSuccessIndicator(`Rate updated for ${currency}`);
            } else {
                alert('<?php _e('Failed to update rate', 'yoursite'); ?>: ' + response.data);
            }
        });
    }
    
    function showRateHistory(currency) {
        document.getElementById('rate-history-modal').style.display = 'block';
        document.getElementById('history-modal-title').textContent = `Rate History - ${currency}`;
        
        const content = document.getElementById('rate-history-content');
        content.innerHTML = '<p><?php _e('Loading rate history...', 'yoursite'); ?></p>';
        
        // Here you would fetch and display rate history
        // For now, show a placeholder
        setTimeout(() => {
            content.innerHTML = `
                <div class="rate-history-chart">
                    <p><?php _e('Rate history chart would go here', 'yoursite'); ?></p>
                    <p><?php _e('This would show rate changes over time with a line chart', 'yoursite'); ?></p>
                </div>
            `;
        }, 500);
    }
    
    function closeRateHistoryModal() {
        document.getElementById('rate-history-modal').style.display = 'none';
    }
    
    function setManualRate() {
        const currency = document.getElementById('manual-currency-select').value;
        const rate = document.getElementById('manual-rate-input').value;
        
        if (!currency) {
            alert('<?php _e('Please select a currency', 'yoursite'); ?>');
            return;
        }
        
        if (!rate || rate <= 0) {
            alert('<?php _e('Please enter a valid rate', 'yoursite'); ?>');
            return;
        }
        
        updateCurrencyRate(currency, rate);
        
        // Clear form
        document.getElementById('manual-currency-select').value = '';
        document.getElementById('manual-rate-input').value = '';
    }
    
    function checkApiHealth() {
        const statusElement = document.getElementById('api-health-status');
        statusElement.innerHTML = '<span class="checking">Checking...</span>';
        
        jQuery.post(ajaxurl, {
            action: 'validate_currency_settings',
            api_provider: '<?php echo esc_js($settings['api_provider'] ?? ''); ?>',
            api_key: '<?php echo esc_js($settings['api_key'] ?? ''); ?>',
            nonce: currencyAjax.nonce
        }).done(function(response) {
            if (response.success) {
                statusElement.innerHTML = '<span class="status-active">✓ Healthy</span>';
            } else {
                statusElement.innerHTML = '<span class="status-inactive">✗ Error</span>';
            }
        }).fail(function() {
            statusElement.innerHTML = '<span class="status-inactive">✗ Failed</span>';
        });
    }
    
    function showSuccessIndicator(message) {
        const indicator = document.createElement('div');
        indicator.className = 'success-indicator';
        indicator.textContent = message;
        document.body.appendChild(indicator);
        
        setTimeout(() => {
            indicator.remove();
        }, 3000);
    }
    
    function exportRatesData() {
        // Implementation for exporting rate data
        alert('<?php _e('Export functionality would be implemented here', 'yoursite'); ?>');
    }
    
    function editCurrencyRate(currency) {
        // Implementation for editing currency settings
        window.location.href = `admin.php?page=yoursite-currencies&tab=currencies&edit=${currency}`;
    }
    </script>
    
    <style>
    .currency-rates-section {
        max-width: 100%;
    }
    
    .rates-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        padding: 20px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    
    .rates-summary h3 {
        margin-top: 0;
        color: #333;
    }
    
    .base-currency-display {
        margin-top: 15px;
        padding: 10px;
        background: #f0f6fc;
        border-radius: 6px;
        border-left: 4px solid #0073aa;
    }
    
    .base-currency-info {
        font-size: 16px;
        font-weight: 600;
    }
    
    .rate-badge {
        background: #46b450;
        color: white;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 12px;
        margin-left: 10px;
    }
    
    .rates-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .api-status-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .api-status-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .api-provider-badge {
        background: #0073aa;
        color: white;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        text-transform: uppercase;
    }
    
    .api-status-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .status-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background: #f9f9f9;
        border-radius: 4px;
    }
    
    .status-label {
        font-weight: 600;
        color: #666;
    }
    
    .status-value {
        font-weight: 600;
    }
    
    .status-active {
        color: #46b450;
    }
    
    .status-inactive {
        color: #dc3232;
    }
    
    .rates-table-container {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .rates-table {
        margin: 0;
    }
    
    .rates-table th {
        background: #f0f0f1;
        font-weight: 600;
        padding: 15px 10px;
        border-bottom: 2px solid #ddd;
    }
    
    .currency-rate-row {
        border-bottom: 1px solid #eee;
    }
    
    .currency-rate-row.inactive {
        opacity: 0.6;
    }
    
    .currency-rate-row.stale {
        background: #fef7e0;
        border-left: 4px solid #f0b90b;
    }
    
    .currency-rate-row td {
        padding: 15px 10px;
        vertical-align: middle;
    }
    
    .currency-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .currency-flag {
        font-size: 18px;
    }
    
    .currency-details strong {
        color: #0073aa;
        display: block;
    }
    
    .currency-name {
        font-size: 12px;
        color: #666;
    }
    
    .base-badge,
    .crypto-badge {
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 3px;
        margin-top: 2px;
        display: inline-block;
    }
    
    .base-badge {
        background: #46b450;
        color: white;
    }
    
    .crypto-badge {
        background: #f0b90b;
        color: white;
    }
    
    .rate-input-wrapper {
        position: relative;
    }
    
    .rate-input {
        width: 120px;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: monospace;
        text-align: right;
    }
    
    .rate-display {
        font-family: monospace;
        font-weight: 600;
        color: #333;
    }
    
    .base-rate {
        font-family: monospace;
        font-weight: 600;
        color: #46b450;
        font-size: 14px;
    }
    
    .previous-rate {
        font-family: monospace;
        color: #666;
    }
    
    .rate-change {
        font-family: monospace;
        font-weight: 600;
    }
    
    .rate-change.positive {
        color: #46b450;
    }
    
    .rate-change.negative {
        color: #dc3232;
    }
    
    .change-percent {
        font-size: 11px;
        display: block;
    }
    
    .no-change {
        color: #999;
    }
    
    .update-info {
        font-size: 12px;
    }
    
    .update-time {
        display: block;
        color: #666;
    }
    
    .stale-indicator {
        color: #f0b90b;
        font-size: 11px;
        display: block;
        margin-top: 2px;
    }
    
    .never-updated {
        color: #dc3232;
        font-style: italic;
    }
    
    .status-indicators {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .status-badge {
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 600;
    }
    
    .status-active {
        background: #d4edda;
        color: #155724;
    }
    
    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }
    
    .auto-update-badge {
        background: #0073aa;
        color: white;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 10px;
    }
    
    .rate-actions {
        display: flex;
        gap: 5px;
    }
    
    .rate-actions .button {
        min-width: auto;
        padding: 4px 8px;
        font-size: 12px;
    }
    
    .rate-statistics {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    
    .stat-card {
        text-align: center;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 6px;
        border: 2px solid transparent;
        transition: all 0.2s ease;
    }
    
    .stat-card:hover {
        border-color: #0073aa;
        background: #f0f6fc;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: bold;
        color: #0073aa;
        display: block;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 12px;
        color: #666;
        text-transform: uppercase;
    }
    
    .manual-rate-entry {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
    }
    
    .manual-rate-entry h4 {
        margin-top: 0;
        color: #333;
    }
    
    .manual-entry-form {
        margin-top: 15px;
    }
    
    .form-row {
        display: flex;
        gap: 15px;
        align-items: end;
        margin-bottom: 10px;
    }
    
    .form-row label {
        display: flex;
        flex-direction: column;
        font-weight: 600;
    }
    
    .form-row select,
    .form-row input {
        margin-top: 5px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .manual-entry-help {
        color: #666;
        font-style: italic;
    }
    
    .currency-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 10000;
    }
    
    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
    }
    
    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 8px;
        width: 90%;
        max-width: 800px;
        max-height: 80vh;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid #eee;
        background: #f9f9f9;
    }
    
    .modal-header h3 {
        margin: 0;
        color: #333;
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #999;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-close:hover {
        color: #333;
    }
    
    .modal-body {
        padding: 20px;
        max-height: 60vh;
        overflow-y: auto;
    }
    
    .progress-bar {
        width: 100%;
        height: 4px;
        background: #eee;
        border-radius: 2px;
        overflow: hidden;
        margin: 10px 0;
    }
    
    .progress-fill {
        height: 100%;
        background: #0073aa;
        width: 0;
        animation: progress 2s ease-in-out infinite;
    }
    
    @keyframes progress {
        0% { width: 0; }
        50% { width: 70%; }
        100% { width: 100%; }
    }
    
    .success-indicator {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #46b450;
        color: white;
        padding: 12px 16px;
        border-radius: 6px;
        z-index: 10001;
        animation: slideInRight 0.3s ease;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    /* Mobile responsive */
    @media (max-width: 1200px) {
        .rates-table-container {
            overflow-x: auto;
        }
        
        .rates-table {
            min-width: 800px;
        }
    }
    
    @media (max-width: 768px) {
        .rates-header {
            flex-direction: column;
            gap: 20px;
        }
        
        .rates-actions {
            flex-direction: row;
            flex-wrap: wrap;
        }
        
        .api-status-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .form-row {
            flex-direction: column;
            align-items: stretch;
        }
        
        .modal-content {
            width: 95%;
        }
    }
    </style>
    <?php
}

/**
 * Helper function to check if currency rate is stale
 */
function yoursite_is_currency_rate_stale($currency) {
    if (!$currency->last_updated) {
        return true;
    }
    
    $settings = get_option('yoursite_currency_settings', array());
    $staleness_threshold = $settings['staleness_threshold'] ?? 48; // hours
    
    $last_updated_time = strtotime($currency->last_updated);
    $threshold_time = time() - ($staleness_threshold * HOUR_IN_SECONDS);
    
    return $last_updated_time < $threshold_time;
}
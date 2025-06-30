<?php
/**
 * Currency Meta Boxes for Pricing Plans
 * File: inc/currency/currency-meta-boxes.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add currency pricing meta box to pricing plans
 */
function yoursite_add_currency_pricing_meta_box() {
    add_meta_box(
        'pricing_currency_prices',
        __('Multi-Currency Pricing', 'yoursite'),
        'yoursite_currency_pricing_meta_box_callback',
        'pricing',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'yoursite_add_currency_pricing_meta_box');

/**
 * Currency pricing meta box callback
 */
function yoursite_currency_pricing_meta_box_callback($post) {
    wp_nonce_field('yoursite_currency_pricing_meta_box', 'yoursite_currency_pricing_meta_box_nonce');
    
    $active_currencies = yoursite_get_active_currencies();
    $base_currency = yoursite_get_base_currency();
    $existing_prices = yoursite_get_pricing_plan_currencies($post->ID);
    
    if (empty($active_currencies)) {
        echo '<p>' . __('No active currencies found. Please configure currencies first.', 'yoursite') . '</p>';
        echo '<a href="' . admin_url('admin.php?page=yoursite-currencies') . '" class="button">' . __('Manage Currencies', 'yoursite') . '</a>';
        return;
    }
    
    yoursite_currency_pricing_meta_box_styles();
    
    ?>
    <div class="currency-pricing-container">
        
        <!-- Instructions -->
        <div class="currency-pricing-instructions">
            <h3><?php _e('💰 Multi-Currency Pricing Configuration', 'yoursite'); ?></h3>
            <p><?php _e('Set prices for each active currency. You can either manually set prices or use auto-conversion from the base currency.', 'yoursite'); ?></p>
            <div class="base-currency-info">
                <strong><?php _e('Base Currency:', 'yoursite'); ?></strong> 
                <?php echo $base_currency['flag']; ?> <?php echo $base_currency['code']; ?> (<?php echo $base_currency['name']; ?>)
            </div>
        </div>
        
        <!-- Currency Pricing Table -->
        <div class="currency-pricing-table">
            <table class="widefat">
                <thead>
                    <tr>
                        <th width="15%"><?php _e('Currency', 'yoursite'); ?></th>
                        <th width="20%"><?php _e('Monthly Price', 'yoursite'); ?></th>
                        <th width="20%"><?php _e('Annual Price', 'yoursite'); ?></th>
                        <th width="25%"><?php _e('Purchase URL', 'yoursite'); ?></th>
                        <th width="15%"><?php _e('Auto Convert', 'yoursite'); ?></th>
                        <th width="5%"><?php _e('Actions', 'yoursite'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($active_currencies as $currency) : 
                        $currency_code = $currency['code'];
                        $existing_data = $existing_prices[$currency_code] ?? array();
                        $is_auto_converted = $existing_data['is_auto_converted'] ?? 0;
                        $is_base = $currency['is_base_currency'];
                        ?>
                        <tr class="currency-pricing-row" data-currency="<?php echo esc_attr($currency_code); ?>">
                            
                            <!-- Currency Info -->
                            <td class="currency-info-cell">
                                <div class="currency-display">
                                    <span class="currency-flag"><?php echo esc_html($currency['flag']); ?></span>
                                    <strong class="currency-code"><?php echo esc_html($currency_code); ?></strong>
                                    <div class="currency-name"><?php echo esc_html($currency['name']); ?></div>
                                    <?php if ($is_base) : ?>
                                        <span class="base-currency-badge">BASE</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            
                            <!-- Monthly Price -->
                            <td class="price-input-cell">
                                <div class="price-input-wrapper">
                                    <span class="currency-prefix"><?php echo esc_html($currency['prefix']); ?></span>
                                    <input type="number" 
                                           name="currency_monthly_price[<?php echo $currency_code; ?>]" 
                                           value="<?php echo esc_attr($existing_data['monthly_price'] ?? ''); ?>"
                                           placeholder="0.00"
                                           step="0.01"
                                           min="0"
                                           class="currency-price-input monthly-price"
                                           data-currency="<?php echo $currency_code; ?>"
                                           <?php echo $is_auto_converted ? 'readonly' : ''; ?> />
                                    <span class="currency-suffix"><?php echo esc_html($currency['suffix']); ?></span>
                                </div>
                                <?php if ($is_auto_converted) : ?>
                                    <div class="auto-converted-note">Auto-converted</div>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Annual Price -->
                            <td class="price-input-cell">
                                <div class="price-input-wrapper">
                                    <span class="currency-prefix"><?php echo esc_html($currency['prefix']); ?></span>
                                    <input type="number" 
                                           name="currency_annual_price[<?php echo $currency_code; ?>]" 
                                           value="<?php echo esc_attr($existing_data['annual_price'] ?? ''); ?>"
                                           placeholder="0.00"
                                           step="0.01"
                                           min="0"
                                           class="currency-price-input annual-price"
                                           data-currency="<?php echo $currency_code; ?>"
                                           <?php echo $is_auto_converted ? 'readonly' : ''; ?> />
                                    <span class="currency-suffix"><?php echo esc_html($currency['suffix']); ?></span>
                                </div>
                                <?php if ($is_auto_converted) : ?>
                                    <div class="auto-converted-note">Auto-converted</div>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Purchase URL -->
                            <td class="url-input-cell">
                                <input type="url" 
                                       name="currency_button_url[<?php echo $currency_code; ?>]" 
                                       value="<?php echo esc_attr($existing_data['button_url'] ?? ''); ?>"
                                       placeholder="https://checkout.example.com/?currency=<?php echo strtolower($currency_code); ?>"
                                       class="currency-url-input widefat" />
                                <div class="url-examples">
                                    <small>
                                        <?php _e('Examples:', 'yoursite'); ?><br>
                                        • <code>?currency=<?php echo strtolower($currency_code); ?></code><br>
                                        • <code>&amp;cur=<?php echo $currency_code; ?></code><br>
                                        • <code>/<?php echo strtolower($currency_code); ?>/checkout</code>
                                    </small>
                                </div>
                            </td>
                            
                            <!-- Auto Convert Toggle -->
                            <td class="auto-convert-cell">
                                <label class="auto-convert-toggle">
                                    <input type="checkbox" 
                                           name="currency_auto_convert[<?php echo $currency_code; ?>]" 
                                           value="1"
                                           <?php checked($is_auto_converted, 1); ?>
                                           class="auto-convert-checkbox"
                                           data-currency="<?php echo $currency_code; ?>"
                                           onchange="toggleAutoConvert('<?php echo $currency_code; ?>', this.checked)" />
                                    <span class="toggle-slider"></span>
                                </label>
                                <div class="auto-convert-label">
                                    <?php _e('Auto Convert', 'yoursite'); ?>
                                </div>
                                <?php if ($currency['conversion_rate'] != 1) : ?>
                                    <div class="conversion-rate-display">
                                        Rate: <?php echo number_format($currency['conversion_rate'], 4); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Actions -->
                            <td class="actions-cell">
                                <button type="button" class="button button-small refresh-btn" 
                                        onclick="refreshCurrencyPrice('<?php echo $currency_code; ?>')"
                                        title="<?php _e('Refresh conversion rate', 'yoursite'); ?>">
                                    🔄
                                </button>
                                <?php if (!$is_base) : ?>
                                    <button type="button" class="button button-small copy-btn" 
                                            onclick="copyFromBase('<?php echo $currency_code; ?>')"
                                            title="<?php _e('Copy and convert from base currency', 'yoursite'); ?>">
                                        📋
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Bulk Actions -->
        <div class="currency-bulk-actions">
            <div class="bulk-action-section">
                <h4><?php _e('Bulk Actions', 'yoursite'); ?></h4>
                <div class="bulk-buttons">
                    <button type="button" class="button" onclick="enableAutoConvertAll()">
                        <?php _e('Enable Auto-Convert All', 'yoursite'); ?>
                    </button>
                    <button type="button" class="button" onclick="disableAutoConvertAll()">
                        <?php _e('Disable Auto-Convert All', 'yoursite'); ?>
                    </button>
                    <button type="button" class="button" onclick="copyBasePriceToAll()">
                        <?php _e('Convert Base Price to All Currencies', 'yoursite'); ?>
                    </button>
                    <button type="button" class="button" onclick="clearAllPrices()">
                        <?php _e('Clear All Prices', 'yoursite'); ?>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Price Calculation Helper -->
        <div class="price-calculator">
            <h4><?php _e('Quick Price Calculator', 'yoursite'); ?></h4>
            <div class="calculator-inputs">
                <label>
                    <?php _e('Base Price:', 'yoursite'); ?>
                    <input type="number" id="calc-base-price" placeholder="19.99" step="0.01" />
                </label>
                <button type="button" class="button button-primary" onclick="calculateAllPrices()">
                    <?php _e('Calculate All Currencies', 'yoursite'); ?>
                </button>
            </div>
            <div class="calculation-results" id="calculation-results"></div>
        </div>
        
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Auto-calculate annual price when monthly changes
        $('.monthly-price').on('input', function() {
            var monthlyInput = $(this);
            var currency = monthlyInput.data('currency');
            var annualInput = $('[name="currency_annual_price[' + currency + ']"]');
            var monthlyPrice = parseFloat(monthlyInput.val()) || 0;
            
            if (monthlyPrice > 0 && !annualInput.val()) {
                var annualPrice = (monthlyPrice * 12 * 0.8).toFixed(2); // 20% discount
                annualInput.val(annualPrice);
                annualInput.css('background-color', '#f0f8ff');
            }
        });
        
        // Remove background color when user manually edits annual price
        $('.annual-price').on('input', function() {
            $(this).css('background-color', '');
        });
    });
    
    function toggleAutoConvert(currency, enabled) {
        var row = jQuery('[data-currency="' + currency + '"]');
        var inputs = row.find('.currency-price-input');
        
        if (enabled) {
            inputs.prop('readonly', true).addClass('auto-converted');
            // Auto-convert from base currency
            convertFromBaseCurrency(currency);
        } else {
            inputs.prop('readonly', false).removeClass('auto-converted');
        }
    }
    
    function convertFromBaseCurrency(targetCurrency) {
        var baseCurrency = '<?php echo $base_currency['code']; ?>';
        var baseMonthly = parseFloat(jQuery('[name="currency_monthly_price[' + baseCurrency + ']"]').val()) || 0;
        var baseAnnual = parseFloat(jQuery('[name="currency_annual_price[' + baseCurrency + ']"]').val()) || 0;
        
        if (baseMonthly > 0 || baseAnnual > 0) {
            jQuery.post(ajaxurl, {
                action: 'convert_currency_price',
                from_currency: baseCurrency,
                to_currency: targetCurrency,
                monthly_price: baseMonthly,
                annual_price: baseAnnual,
                nonce: '<?php echo wp_create_nonce('currency_conversion_nonce'); ?>'
            }).done(function(response) {
                if (response.success) {
                    if (response.data.monthly_price) {
                        jQuery('[name="currency_monthly_price[' + targetCurrency + ']"]').val(response.data.monthly_price);
                    }
                    if (response.data.annual_price) {
                        jQuery('[name="currency_annual_price[' + targetCurrency + ']"]').val(response.data.annual_price);
                    }
                }
            });
        }
    }
    
    function copyFromBase(targetCurrency) {
        if (confirm('<?php _e('This will overwrite existing prices. Continue?', 'yoursite'); ?>')) {
            convertFromBaseCurrency(targetCurrency);
        }
    }
    
    function refreshCurrencyPrice(currency) {
        jQuery.post(ajaxurl, {
            action: 'refresh_single_currency_rate',
            currency: currency,
            nonce: '<?php echo wp_create_nonce('currency_refresh_nonce'); ?>'
        }).done(function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('<?php _e('Error refreshing rate', 'yoursite'); ?>');
            }
        });
    }
    
    function enableAutoConvertAll() {
        jQuery('.auto-convert-checkbox').prop('checked', true).each(function() {
            toggleAutoConvert(jQuery(this).data('currency'), true);
        });
    }
    
    function disableAutoConvertAll() {
        jQuery('.auto-convert-checkbox').prop('checked', false).each(function() {
            toggleAutoConvert(jQuery(this).data('currency'), false);
        });
    }
    
    function copyBasePriceToAll() {
        if (!confirm('<?php _e('This will overwrite all existing prices with converted base currency prices. Continue?', 'yoursite'); ?>')) {
            return;
        }
        
        var baseCurrency = '<?php echo $base_currency['code']; ?>';
        
        jQuery('.currency-pricing-row').each(function() {
            var currency = jQuery(this).data('currency');
            if (currency !== baseCurrency) {
                convertFromBaseCurrency(currency);
            }
        });
    }
    
    function clearAllPrices() {
        if (confirm('<?php _e('This will clear all prices. Continue?', 'yoursite'); ?>')) {
            jQuery('.currency-price-input').val('');
        }
    }
    
    function calculateAllPrices() {
        var basePrice = parseFloat(jQuery('#calc-base-price').val()) || 0;
        if (basePrice <= 0) {
            alert('<?php _e('Please enter a valid base price', 'yoursite'); ?>');
            return;
        }
        
        var baseCurrency = '<?php echo $base_currency['code']; ?>';
        var resultsDiv = jQuery('#calculation-results');
        resultsDiv.html('<p><?php _e('Calculating...', 'yoursite'); ?></p>');
        
        jQuery.post(ajaxurl, {
            action: 'calculate_all_currency_prices',
            base_price: basePrice,
            base_currency: baseCurrency,
            nonce: '<?php echo wp_create_nonce('currency_calculation_nonce'); ?>'
        }).done(function(response) {
            if (response.success) {
                var results = '<h5><?php _e('Calculated Prices:', 'yoursite'); ?></h5><ul>';
                jQuery.each(response.data, function(currency, prices) {
                    results += '<li><strong>' + currency + ':</strong> ' + prices.monthly + ' (monthly), ' + prices.annual + ' (annual)</li>';
                });
                results += '</ul>';
                results += '<button type="button" class="button button-primary" onclick="applyCalculatedPrices(' + JSON.stringify(response.data) + ')"><?php _e('Apply These Prices', 'yoursite'); ?></button>';
                resultsDiv.html(results);
            } else {
                resultsDiv.html('<p style="color: red;"><?php _e('Error calculating prices', 'yoursite'); ?></p>');
            }
        });
    }
    
    function applyCalculatedPrices(prices) {
        jQuery.each(prices, function(currency, currencyPrices) {
            jQuery('[name="currency_monthly_price[' + currency + ']"]').val(currencyPrices.monthly_raw);
            jQuery('[name="currency_annual_price[' + currency + ']"]').val(currencyPrices.annual_raw);
        });
        
        jQuery('#calculation-results').html('<p style="color: green;"><?php _e('Prices applied successfully!', 'yoursite'); ?></p>');
    }
    </script>
    <?php
}

/**
 * Styles for currency pricing meta box
 */
function yoursite_currency_pricing_meta_box_styles() {
    ?>
    <style>
    .currency-pricing-container {
        background: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    
    .currency-pricing-instructions {
        background: #f0f6fc;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        border-left: 4px solid #0073aa;
    }
    
    .currency-pricing-instructions h3 {
        margin-top: 0;
        color: #0073aa;
    }
    
    .base-currency-info {
        background: #fff;
        padding: 10px;
        border-radius: 4px;
        margin-top: 10px;
        border: 1px solid #ddd;
        display: inline-block;
    }
    
    .currency-pricing-table table {
        margin-top: 0;
    }
    
    .currency-info-cell {
        vertical-align: top;
        padding: 15px 10px;
    }
    
    .currency-display {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    
    .currency-flag {
        font-size: 18px;
        margin-right: 8px;
    }
    
    .currency-code {
        color: #0073aa;
        font-size: 14px;
    }
    
    .currency-name {
        font-size: 12px;
        color: #666;
        margin-top: 2px;
    }
    
    .base-currency-badge {
        background: #46b450;
        color: white;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 10px;
        margin-top: 4px;
    }
    
    .price-input-cell {
        vertical-align: top;
        padding: 15px 10px;
    }
    
    .price-input-wrapper {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 2px;
    }
    
    .currency-prefix,
    .currency-suffix {
        padding: 8px;
        background: #f0f0f1;
        color: #666;
        font-weight: bold;
        white-space: nowrap;
    }
    
    .currency-price-input {
        border: none;
        padding: 8px;
        width: 100px;
        text-align: right;
        font-family: monospace;
    }
    
    .currency-price-input:focus {
        outline: none;
        box-shadow: 0 0 3px rgba(0, 115, 170, 0.3);
    }
    
    .currency-price-input.auto-converted {
        background: #f0f8ff;
        color: #666;
    }
    
    .auto-converted-note {
        font-size: 11px;
        color: #0073aa;
        margin-top: 2px;
        font-style: italic;
    }
    
    .url-input-cell {
        vertical-align: top;
        padding: 15px 10px;
    }
    
    .currency-url-input {
        font-family: monospace;
        font-size: 12px;
    }
    
    .url-examples {
        margin-top: 5px;
    }
    
    .url-examples small {
        color: #666;
        line-height: 1.4;
    }
    
    .url-examples code {
        background: #f0f0f1;
        padding: 1px 4px;
        border-radius: 2px;
        font-size: 11px;
    }
    
    .auto-convert-cell {
        vertical-align: top;
        padding: 15px 10px;
        text-align: center;
    }
    
    .auto-convert-toggle {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }
    
    .auto-convert-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.3s;
        border-radius: 24px;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
    }
    
    .auto-convert-toggle input:checked + .toggle-slider {
        background-color: #0073aa;
    }
    
    .auto-convert-toggle input:checked + .toggle-slider:before {
        transform: translateX(20px);
    }
    
    .auto-convert-label {
        font-size: 11px;
        margin-top: 5px;
        color: #666;
    }
    
    .conversion-rate-display {
        font-size: 10px;
        color: #999;
        margin-top: 2px;
    }
    
    .actions-cell {
        vertical-align: top;
        padding: 15px 10px;
        text-align: center;
    }
    
    .refresh-btn,
    .copy-btn {
        min-width: auto;
        padding: 4px 8px;
        font-size: 12px;
        line-height: 1;
        margin: 1px;
    }
    
    .currency-bulk-actions {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
    }
    
    .bulk-action-section h4 {
        margin-bottom: 10px;
        color: #333;
    }
    
    .bulk-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .price-calculator {
        margin-top: 20px;
        padding: 15px;
        background: #f9f9f9;
        border-radius: 6px;
        border: 1px solid #ddd;
    }
    
    .price-calculator h4 {
        margin-top: 0;
        margin-bottom: 15px;
        color: #333;
    }
    
    .calculator-inputs {
        display: flex;
        gap: 15px;
        align-items: end;
        margin-bottom: 15px;
    }
    
    .calculator-inputs label {
        display: flex;
        flex-direction: column;
        font-weight: 600;
    }
    
    .calculator-inputs input {
        margin-top: 5px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 120px;
    }
    
    .calculation-results {
        background: #fff;
        padding: 15px;
        border-radius: 4px;
        border: 1px solid #ddd;
        min-height: 50px;
    }
    
    .calculation-results ul {
        margin: 10px 0;
        padding-left: 20px;
    }
    
    .calculation-results li {
        margin-bottom: 5px;
        font-family: monospace;
    }
    
    /* Mobile responsive */
    @media (max-width: 1200px) {
        .currency-pricing-table {
            overflow-x: auto;
        }
        
        .currency-pricing-table table {
            min-width: 800px;
        }
    }
    
    @media (max-width: 768px) {
        .bulk-buttons {
            flex-direction: column;
        }
        
        .calculator-inputs {
            flex-direction: column;
            align-items: stretch;
        }
        
        .calculator-inputs input {
            width: 100%;
        }
    }
    </style>
    <?php
}

/**
 * Get pricing plan currencies
 */
function yoursite_get_pricing_plan_currencies($plan_id) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_pricing_currencies';
    
    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE pricing_plan_id = %d",
            $plan_id
        ),
        ARRAY_A
    );
    
    $currencies = array();
    foreach ($results as $result) {
        $currencies[$result['currency_code']] = $result;
    }
    
    return $currencies;
}

/**
 * Save currency pricing data
 */
function yoursite_save_currency_pricing_meta_box_data($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['yoursite_currency_pricing_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['yoursite_currency_pricing_meta_box_nonce'], 'yoursite_currency_pricing_meta_box')) {
        return;
    }

    // Check if user has permissions to save data
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_pricing_currencies';
    
    // Delete existing currency pricing data
    $wpdb->delete($table_name, array('pricing_plan_id' => $post_id), array('%d'));
    
    $monthly_prices = $_POST['currency_monthly_price'] ?? array();
    $annual_prices = $_POST['currency_annual_price'] ?? array();
    $button_urls = $_POST['currency_button_url'] ?? array();
    $auto_converts = $_POST['currency_auto_convert'] ?? array();
    
    foreach ($monthly_prices as $currency_code => $monthly_price) {
        $annual_price = $annual_prices[$currency_code] ?? '';
        $button_url = $button_urls[$currency_code] ?? '';
        $is_auto_converted = isset($auto_converts[$currency_code]) ? 1 : 0;
        
        // Skip if both prices are empty
        if (empty($monthly_price) && empty($annual_price)) {
            continue;
        }
        
        $wpdb->insert(
            $table_name,
            array(
                'pricing_plan_id' => $post_id,
                'currency_code' => sanitize_text_field($currency_code),
                'monthly_price' => !empty($monthly_price) ? floatval($monthly_price) : null,
                'annual_price' => !empty($annual_price) ? floatval($annual_price) : null,
                'button_url' => sanitize_url($button_url),
                'is_auto_converted' => $is_auto_converted
            ),
            array('%d', '%s', '%f', '%f', '%s', '%d')
        );
    }
}
add_action('save_post', 'yoursite_save_currency_pricing_meta_box_data');
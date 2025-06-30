<?php
/**
 * Frontend Currency Integration
 * File: inc/currency/currency-frontend.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue frontend currency assets
 */
function yoursite_enqueue_currency_frontend_assets() {
    wp_enqueue_script('jquery');
    
    wp_add_inline_script('jquery', '
        window.YourSiteCurrency = {
            ajaxUrl: "' . admin_url('admin-ajax.php') . '",
            currentCurrency: "' . yoursite_get_user_currency()['code'] . '",
            nonce: "' . wp_create_nonce('currency_frontend_nonce') . '"
        };
    ');
    
    wp_add_inline_style('wp-block-library', '
        /* Currency Selector Frontend Styles */
        .yoursite-currency-selector {
            position: relative;
            display: inline-block;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        
        .currency-selector-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: #fff;
            border: 1px solid #e1e5e9;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
        }
        
        .currency-selector-trigger:hover {
            border-color: #0073aa;
            background: #f8fafc;
            text-decoration: none;
            color: inherit;
        }
        
        .currency-selector-trigger.active {
            border-color: #0073aa;
            box-shadow: 0 0 0 1px #0073aa;
        }
        
        .currency-flag {
            font-size: 16px;
        }
        
        .currency-code {
            font-weight: 600;
            color: #374151;
        }
        
        .currency-chevron {
            width: 12px;
            height: 12px;
            transition: transform 0.2s ease;
            opacity: 0.7;
        }
        
        .currency-selector-trigger.active .currency-chevron {
            transform: rotate(180deg);
        }
        
        .currency-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #e1e5e9;
            border-radius: 6px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .currency-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .currency-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            cursor: pointer;
            transition: background 0.15s ease;
            border-bottom: 1px solid #f3f4f6;
            text-decoration: none;
            color: inherit;
        }
        
        .currency-option:last-child {
            border-bottom: none;
        }
        
        .currency-option:hover {
            background: #f8fafc;
            text-decoration: none;
            color: inherit;
        }
        
        .currency-option.selected {
            background: #eff6ff;
            color: #1d4ed8;
        }
        
        .currency-name {
            flex: 1;
            font-size: 13px;
            color: #6b7280;
        }
        
        /* Pricing Display Styles */
        .yoursite-pricing-card {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .pricing-loading {
            opacity: 0.7;
            pointer-events: none;
        }
        
        .pricing-loading::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #e1e5e9;
            border-top-color: #0073aa;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .price-amount {
            font-weight: 700;
            transition: all 0.2s ease;
        }
        
        .price-period {
            font-size: 0.85em;
            opacity: 0.8;
        }
        
        .price-savings {
            color: #059669;
            font-weight: 600;
            font-size: 0.9em;
        }
        
        .original-price {
            font-size: 0.8em;
            color: #6b7280;
            text-decoration: line-through;
            margin-left: 8px;
        }
        
        /* Currency change notification */
        .currency-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 12px 16px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .currency-notification.show {
            transform: translateX(0);
        }
        
        .currency-notification.error {
            background: #ef4444;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .currency-dropdown {
                left: auto;
                right: 0;
                min-width: 200px;
            }
            
            .currency-notification {
                left: 20px;
                right: 20px;
                transform: translateY(-100%);
            }
            
            .currency-notification.show {
                transform: translateY(0);
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .currency-selector-trigger {
                background: #374151;
                border-color: #4b5563;
                color: #f9fafb;
            }
            
            .currency-selector-trigger:hover {
                background: #4b5563;
                border-color: #60a5fa;
            }
            
            .currency-dropdown {
                background: #374151;
                border-color: #4b5563;
            }
            
            .currency-option {
                color: #f9fafb;
                border-color: #4b5563;
            }
            
            .currency-option:hover {
                background: #4b5563;
            }
            
            .currency-option.selected {
                background: #1e40af;
                color: #bfdbfe;
            }
        }
    ');
}
add_action('wp_enqueue_scripts', 'yoursite_enqueue_currency_frontend_assets');

/**
 * Advanced pricing card component with currency support
 */
function yoursite_render_pricing_card($plan_id, $args = array()) {
    $defaults = array(
        'show_currency_selector' => true,
        'show_original_price' => false,
        'billing_toggle' => true,
        'highlight' => false,
        'button_text' => __('Get Started', 'yoursite'),
        'button_class' => 'btn btn-primary',
        'features' => array(),
        'class' => ''
    );
    
    $args = wp_parse_args($args, $defaults);
    $current_currency = yoursite_get_user_currency();
    $plan = get_post($plan_id);
    
    if (!$plan) {
        return '';
    }
    
    // Get pricing data
    $monthly_price = yoursite_get_pricing_plan_price($plan_id, $current_currency['code'], 'monthly');
    $annual_price = yoursite_get_pricing_plan_price($plan_id, $current_currency['code'], 'annual');
    $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
    $savings = yoursite_calculate_annual_savings($plan_id, $current_currency['code']);
    $discount_percent = yoursite_calculate_annual_discount_percentage($plan_id, $current_currency['code']);
    
    // Get purchase URLs
    $currency_data = yoursite_get_pricing_plan_currencies($plan_id);
    $monthly_url = $currency_data[$current_currency['code']]['button_url'] ?? get_post_meta($plan_id, '_pricing_monthly_url', true);
    $annual_url = str_replace('monthly', 'annual', $monthly_url); // Simple URL modification
    
    ob_start();
    ?>
    <div class="yoursite-pricing-card <?php echo esc_attr($args['class']); ?> <?php echo $args['highlight'] ? 'highlighted' : ''; ?>"
         data-plan-id="<?php echo esc_attr($plan_id); ?>">
        
        <?php if ($args['highlight']) : ?>
            <div class="pricing-badge">
                <?php _e('Most Popular', 'yoursite'); ?>
            </div>
        <?php endif; ?>
        
        <!-- Plan Header -->
        <div class="pricing-header">
            <h3 class="plan-title"><?php echo esc_html($plan->post_title); ?></h3>
            <?php if ($plan->post_excerpt) : ?>
                <p class="plan-description"><?php echo esc_html($plan->post_excerpt); ?></p>
            <?php endif; ?>
        </div>
        
        <!-- Currency Selector -->
        <?php if ($args['show_currency_selector']) : ?>
            <div class="pricing-currency-selector">
                <?php echo yoursite_render_currency_selector(array(
                    'style' => 'compact',
                    'show_flag' => true,
                    'show_name' => false,
                    'show_symbol' => false,
                    'class' => 'pricing-currency-widget'
                )); ?>
            </div>
        <?php endif; ?>
        
        <!-- Billing Toggle -->
        <?php if ($args['billing_toggle'] && $monthly_price > 0 && $annual_price > 0) : ?>
            <div class="billing-toggle-wrapper">
                <div class="billing-toggle">
                    <label class="toggle-option">
                        <input type="radio" name="billing-<?php echo $plan_id; ?>" value="monthly" checked 
                               onchange="switchBilling(<?php echo $plan_id; ?>, 'monthly')" />
                        <span><?php _e('Monthly', 'yoursite'); ?></span>
                    </label>
                    <label class="toggle-option">
                        <input type="radio" name="billing-<?php echo $plan_id; ?>" value="annual" 
                               onchange="switchBilling(<?php echo $plan_id; ?>, 'annual')" />
                        <span><?php _e('Annual', 'yoursite'); ?></span>
                        <?php if ($discount_percent > 0) : ?>
                            <span class="discount-badge">-<?php echo $discount_percent; ?>%</span>
                        <?php endif; ?>
                    </label>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Pricing Display -->
        <div class="pricing-display">
            
            <!-- Monthly Pricing -->
            <div class="pricing-option monthly-pricing active" data-period="monthly">
                <?php if ($monthly_price > 0) : ?>
                    <div class="price-main">
                        <span class="price-amount" data-price-type="monthly">
                            <?php echo yoursite_format_currency($monthly_price, $current_currency['code']); ?>
                        </span>
                        <span class="price-period">/ <?php _e('month', 'yoursite'); ?></span>
                    </div>
                    
                    <?php if ($args['show_original_price'] && $current_currency['code'] !== yoursite_get_base_currency()['code']) : ?>
                        <div class="original-price-display">
                            <?php 
                            $base_currency = yoursite_get_base_currency();
                            $base_monthly = yoursite_get_pricing_plan_price($plan_id, $base_currency['code'], 'monthly');
                            echo yoursite_format_currency($base_monthly, $base_currency['code']);
                            ?>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="price-main">
                        <span class="price-amount"><?php _e('Contact Us', 'yoursite'); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Annual Pricing -->
            <?php if ($annual_price > 0) : ?>
                <div class="pricing-option annual-pricing" data-period="annual" style="display: none;">
                    <div class="price-main">
                        <span class="price-amount" data-price-type="annual-monthly">
                            <?php echo yoursite_format_currency($annual_monthly, $current_currency['code']); ?>
                        </span>
                        <span class="price-period">/ <?php _e('month', 'yoursite'); ?></span>
                    </div>
                    
                    <div class="price-billing">
                        <?php printf(__('Billed annually: %s', 'yoursite'), 
                            '<span data-price-type="annual">' . yoursite_format_currency($annual_price, $current_currency['code']) . '</span>'
                        ); ?>
                    </div>
                    
                    <?php if ($savings > 0) : ?>
                        <div class="price-savings">
                            <?php printf(__('Save %s per year', 'yoursite'), 
                                '<span data-savings-amount">' . yoursite_format_currency($savings, $current_currency['code']) . '</span>'
                            ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($args['show_original_price'] && $current_currency['code'] !== yoursite_get_base_currency()['code']) : ?>
                        <div class="original-price-display">
                            <?php 
                            $base_currency = yoursite_get_base_currency();
                            $base_annual = yoursite_get_pricing_plan_price($plan_id, $base_currency['code'], 'annual');
                            echo yoursite_format_currency($base_annual / 12, $base_currency['code']) . ' / ' . __('month', 'yoursite');
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Features List -->
        <?php if (!empty($args['features'])) : ?>
            <div class="pricing-features">
                <ul>
                    <?php foreach ($args['features'] as $feature) : ?>
                        <li>
                            <svg class="feature-check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"></polyline>
                            </svg>
                            <?php echo esc_html($feature); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- Action Button -->
        <div class="pricing-action">
            <?php if ($monthly_price > 0) : ?>
                <a href="<?php echo esc_url($monthly_url); ?>" 
                   class="pricing-button <?php echo esc_attr($args['button_class']); ?>"
                   data-monthly-url="<?php echo esc_url($monthly_url); ?>"
                   data-annual-url="<?php echo esc_url($annual_url); ?>">
                    <?php echo esc_html($args['button_text']); ?>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                   class="pricing-button <?php echo esc_attr($args['button_class']); ?>">
                    <?php _e('Contact Sales', 'yoursite'); ?>
                </a>
            <?php endif; ?>
        </div>
        
    </div>
    
    <script>
    // Currency switching for this specific card
    document.addEventListener('DOMContentLoaded', function() {
        const card = document.querySelector('[data-plan-id="<?php echo $plan_id; ?>"]');
        if (!card) return;
        
        // Listen for currency changes
        document.addEventListener('currencyChanged', function(e) {
            updateCardPricing(<?php echo $plan_id; ?>, e.detail.currency);
        });
    });
    
    function switchBilling(planId, period) {
        const card = document.querySelector(`[data-plan-id="${planId}"]`);
        if (!card) return;
        
        // Hide all pricing options
        card.querySelectorAll('.pricing-option').forEach(option => {
            option.style.display = 'none';
            option.classList.remove('active');
        });
        
        // Show selected period
        const selectedOption = card.querySelector(`.${period}-pricing`);
        if (selectedOption) {
            selectedOption.style.display = 'block';
            selectedOption.classList.add('active');
        }
        
        // Update button URL
        const button = card.querySelector('.pricing-button');
        const newUrl = button.dataset[period + 'Url'];
        if (newUrl && button) {
            button.href = newUrl;
        }
    }
    
    function updateCardPricing(planId, currencyCode) {
        const card = document.querySelector(`[data-plan-id="${planId}"]`);
        if (!card) return;
        
        // Add loading state
        card.classList.add('pricing-loading');
        
        // Fetch new pricing data
        fetch(YourSiteCurrency.ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'get_currency_pricing',
                plan_id: planId,
                currency: currencyCode,
                nonce: YourSiteCurrency.nonce
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCardElements(card, data.data);
            } else {
                console.error('Failed to update pricing:', data.data);
            }
        })
        .catch(error => {
            console.error('Error updating pricing:', error);
        })
        .finally(() => {
            card.classList.remove('pricing-loading');
        });
    }
    
    function updateCardElements(card, pricingData) {
        // Update monthly price
        const monthlyAmount = card.querySelector('[data-price-type="monthly"]');
        if (monthlyAmount && pricingData.monthly_price) {
            monthlyAmount.textContent = pricingData.monthly_price;
        }
        
        // Update annual prices
        const annualMonthlyAmount = card.querySelector('[data-price-type="annual-monthly"]');
        if (annualMonthlyAmount && pricingData.annual_monthly_equivalent) {
            annualMonthlyAmount.textContent = pricingData.annual_monthly_equivalent;
        }
        
        const annualAmount = card.querySelector('[data-price-type="annual"]');
        if (annualAmount && pricingData.annual_price) {
            annualAmount.textContent = pricingData.annual_price;
        }
        
        // Update savings
        const savingsAmount = card.querySelector('[data-savings-amount]');
        if (savingsAmount && pricingData.savings) {
            savingsAmount.textContent = pricingData.savings;
        }
        
        // Update button URLs if currency-specific URLs exist
        // This would require additional backend support for currency-specific URLs
    }
    </script>
    <?php
    
    return ob_get_clean();
}

/**
 * Pricing comparison table with currency support
 */
function yoursite_render_pricing_comparison_table($plan_ids, $args = array()) {
    $defaults = array(
        'show_currency_selector' => true,
        'features' => array(),
        'billing_toggle' => true
    );
    
    $args = wp_parse_args($args, $defaults);
    $current_currency = yoursite_get_user_currency();
    
    ob_start();
    ?>
    <div class="yoursite-pricing-comparison-wrapper" data-currency="<?php echo esc_attr($current_currency['code']); ?>">
        
        <!-- Currency Selector Header -->
        <?php if ($args['show_currency_selector']) : ?>
            <div class="comparison-currency-header">
                <div class="currency-info">
                    <span><?php _e('Showing prices in:', 'yoursite'); ?></span>
                    <?php echo yoursite_render_currency_selector(array(
                        'style' => 'dropdown',
                        'show_flag' => true,
                        'show_name' => true,
                        'show_symbol' => false
                    )); ?>
                </div>
                
                <?php if ($args['billing_toggle']) : ?>
                    <div class="global-billing-toggle">
                        <label class="toggle-switch">
                            <input type="checkbox" id="global-billing-toggle" onchange="toggleAllBilling(this.checked)" />
                            <span class="toggle-slider"></span>
                            <span class="toggle-label"><?php _e('Annual billing (save up to 20%)', 'yoursite'); ?></span>
                        </label>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- Comparison Table -->
        <div class="pricing-comparison-table">
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th class="feature-column"><?php _e('Features', 'yoursite'); ?></th>
                        <?php foreach ($plan_ids as $plan_id) : 
                            $plan = get_post($plan_id);
                            ?>
                            <th class="plan-column" data-plan-id="<?php echo esc_attr($plan_id); ?>">
                                <div class="plan-header">
                                    <h4><?php echo esc_html($plan->post_title); ?></h4>
                                    
                                    <!-- Monthly Pricing -->
                                    <div class="plan-pricing monthly-pricing active">
                                        <?php 
                                        $monthly_price = yoursite_get_pricing_plan_price($plan_id, $current_currency['code'], 'monthly');
                                        if ($monthly_price > 0) :
                                        ?>
                                            <div class="price-display">
                                                <span class="price-amount" data-price-type="monthly">
                                                    <?php echo yoursite_format_currency($monthly_price, $current_currency['code']); ?>
                                                </span>
                                                <span class="price-period">/ <?php _e('month', 'yoursite'); ?></span>
                                            </div>
                                        <?php else : ?>
                                            <div class="price-display">
                                                <span class="price-amount"><?php _e('Custom', 'yoursite'); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Annual Pricing -->
                                    <?php 
                                    $annual_price = yoursite_get_pricing_plan_price($plan_id, $current_currency['code'], 'annual');
                                    if ($annual_price > 0) :
                                        $annual_monthly = $annual_price / 12;
                                        $savings = yoursite_calculate_annual_savings($plan_id, $current_currency['code']);
                                    ?>
                                        <div class="plan-pricing annual-pricing" style="display: none;">
                                            <div class="price-display">
                                                <span class="price-amount" data-price-type="annual-monthly">
                                                    <?php echo yoursite_format_currency($annual_monthly, $current_currency['code']); ?>
                                                </span>
                                                <span class="price-period">/ <?php _e('month', 'yoursite'); ?></span>
                                            </div>
                                            <div class="annual-note">
                                                <?php printf(__('Billed annually: %s', 'yoursite'), 
                                                    '<span data-price-type="annual">' . yoursite_format_currency($annual_price, $current_currency['code']) . '</span>'
                                                ); ?>
                                            </div>
                                            <?php if ($savings > 0) : ?>
                                                <div class="savings-note">
                                                    <?php printf(__('Save %s', 'yoursite'), 
                                                        '<span data-savings-amount>' . yoursite_format_currency($savings, $current_currency['code']) . '</span>'
                                                    ); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- CTA Button -->
                                    <div class="plan-cta">
                                        <?php if ($monthly_price > 0) : ?>
                                            <?php 
                                            $currency_data = yoursite_get_pricing_plan_currencies($plan_id);
                                            $button_url = $currency_data[$current_currency['code']]['button_url'] ?? get_post_meta($plan_id, '_pricing_monthly_url', true);
                                            ?>
                                            <a href="<?php echo esc_url($button_url); ?>" class="cta-button">
                                                <?php _e('Get Started', 'yoursite'); ?>
                                            </a>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="cta-button">
                                                <?php _e('Contact Sales', 'yoursite'); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($args['features'] as $feature_name => $feature_data) : ?>
                        <tr class="feature-row">
                            <td class="feature-name">
                                <div class="feature-info">
                                    <strong><?php echo esc_html($feature_name); ?></strong>
                                    <?php if (!empty($feature_data['description'])) : ?>
                                        <p class="feature-description"><?php echo esc_html($feature_data['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <?php foreach ($plan_ids as $plan_id) : ?>
                                <td class="feature-value">
                                    <?php 
                                    $plan_features = get_post_meta($plan_id, '_pricing_features', true) ?: array();
                                    $has_feature = isset($plan_features[$feature_name]) ? $plan_features[$feature_name] : false;
                                    
                                    if (is_bool($has_feature)) :
                                        if ($has_feature) :
                                    ?>
                                            <svg class="feature-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="20,6 9,17 4,12"></polyline>
                                            </svg>
                                        <?php else : ?>
                                            <svg class="feature-cross" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        <?php endif;
                                    else :
                                        echo esc_html($has_feature);
                                    endif;
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
    function toggleAllBilling(isAnnual) {
        const wrapper = document.querySelector('.yoursite-pricing-comparison-wrapper');
        if (!wrapper) return;
        
        wrapper.querySelectorAll('.plan-pricing').forEach(pricing => {
            pricing.style.display = 'none';
            pricing.classList.remove('active');
        });
        
        const targetClass = isAnnual ? '.annual-pricing' : '.monthly-pricing';
        wrapper.querySelectorAll(targetClass).forEach(pricing => {
            pricing.style.display = 'block';
            pricing.classList.add('active');
        });
        
        // Update button URLs based on billing period
        // This would require additional implementation for annual URLs
    }
    
    // Listen for currency changes
    document.addEventListener('currencyChanged', function(e) {
        updateComparisonTablePricing(e.detail.currency);
    });
    
    function updateComparisonTablePricing(currencyCode) {
        const wrapper = document.querySelector('.yoursite-pricing-comparison-wrapper');
        if (!wrapper) return;
        
        // Add loading state
        wrapper.classList.add('pricing-loading');
        
        // Get all plan IDs
        const planColumns = wrapper.querySelectorAll('[data-plan-id]');
        const planIds = Array.from(planColumns).map(col => col.dataset.planId);
        
        // Fetch new pricing for all plans
        fetch(YourSiteCurrency.ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'get_all_pricing_in_currency',
                currency: currencyCode,
                nonce: YourSiteCurrency.nonce
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateComparisonTableElements(wrapper, data.data.pricing);
                wrapper.dataset.currency = currencyCode;
            } else {
                console.error('Failed to update comparison pricing:', data.data);
            }
        })
        .catch(error => {
            console.error('Error updating comparison pricing:', error);
        })
        .finally(() => {
            wrapper.classList.remove('pricing-loading');
        });
    }
    
    function updateComparisonTableElements(wrapper, pricingData) {
        Object.keys(pricingData).forEach(planId => {
            const pricing = pricingData[planId];
            const planColumn = wrapper.querySelector(`[data-plan-id="${planId}"]`);
            
            if (!planColumn) return;
            
            // Update monthly price
            const monthlyAmount = planColumn.querySelector('[data-price-type="monthly"]');
            if (monthlyAmount && pricing.monthly_price) {
                monthlyAmount.textContent = pricing.monthly_price;
            }
            
            // Update annual prices
            const annualMonthlyAmount = planColumn.querySelector('[data-price-type="annual-monthly"]');
            if (annualMonthlyAmount && pricing.annual_monthly_equivalent) {
                annualMonthlyAmount.textContent = pricing.annual_monthly_equivalent;
            }
            
            const annualAmount = planColumn.querySelector('[data-price-type="annual"]');
            if (annualAmount && pricing.annual_price) {
                annualAmount.textContent = pricing.annual_price;
            }
            
            // Update savings
            const savingsAmount = planColumn.querySelector('[data-savings-amount]');
            if (savingsAmount && pricing.savings) {
                savingsAmount.textContent = pricing.savings;
            }
        });
    }
    </script>
    
    <style>
    .yoursite-pricing-comparison-wrapper {
        margin: 40px 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    
    .comparison-currency-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e1e5e9;
    }
    
    .currency-info {
        display: flex;
        align-items: center;
        gap: 15px;
        font-weight: 600;
        color: #374151;
    }
    
    .global-billing-toggle {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .toggle-switch {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        user-select: none;
    }
    
    .toggle-switch input {
        display: none;
    }
    
    .toggle-slider {
        position: relative;
        width: 44px;
        height: 24px;
        background: #e1e5e9;
        border-radius: 24px;
        transition: background 0.3s ease;
    }
    
    .toggle-slider::before {
        content: "";
        position: absolute;
        top: 2px;
        left: 2px;
        width: 20px;
        height: 20px;
        background: white;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }
    
    .toggle-switch input:checked + .toggle-slider {
        background: #10b981;
    }
    
    .toggle-switch input:checked + .toggle-slider::before {
        transform: translateX(20px);
    }
    
    .toggle-label {
        font-weight: 600;
        color: #374151;
    }
    
    .pricing-comparison-table {
        overflow-x: auto;
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .comparison-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    
    .comparison-table th,
    .comparison-table td {
        padding: 20px;
        text-align: left;
        border-bottom: 1px solid #e1e5e9;
        vertical-align: top;
    }
    
    .comparison-table th {
        background: #f8fafc;
        font-weight: 600;
        border-bottom: 2px solid #e1e5e9;
    }
    
    .feature-column {
        width: 30%;
        min-width: 200px;
    }
    
    .plan-column {
        width: 23%;
        text-align: center;
        position: relative;
    }
    
    .plan-header h4 {
        margin: 0 0 15px 0;
        color: #1f2937;
        font-size: 18px;
    }
    
    .plan-pricing {
        margin-bottom: 20px;
    }
    
    .price-display {
        margin-bottom: 8px;
    }
    
    .price-amount {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        display: block;
    }
    
    .price-period {
        font-size: 14px;
        color: #6b7280;
    }
    
    .annual-note,
    .savings-note {
        font-size: 12px;
        color: #6b7280;
        line-height: 1.4;
    }
    
    .savings-note {
        color: #059669;
        font-weight: 600;
    }
    
    .cta-button {
        display: inline-block;
        padding: 12px 24px;
        background: #3b82f6;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
        transition: background 0.2s ease;
    }
    
    .cta-button:hover {
        background: #2563eb;
        text-decoration: none;
        color: white;
    }
    
    .feature-name {
        font-weight: 600;
        color: #1f2937;
    }
    
    .feature-description {
        font-size: 14px;
        color: #6b7280;
        margin: 5px 0 0 0;
        font-weight: normal;
    }
    
    .feature-value {
        text-align: center;
    }
    
    .feature-check {
        color: #10b981;
    }
    
    .feature-cross {
        color: #ef4444;
    }
    
    .pricing-loading {
        opacity: 0.7;
        pointer-events: none;
        position: relative;
    }
    
    .pricing-loading::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 30px;
        height: 30px;
        margin: -15px 0 0 -15px;
        border: 3px solid #e1e5e9;
        border-top-color: #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .comparison-currency-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        
        .pricing-comparison-table {
            margin: 0 -20px;
        }
        
        .comparison-table th,
        .comparison-table td {
            padding: 15px 10px;
        }
        
        .plan-header h4 {
            font-size: 16px;
        }
        
        .price-amount {
            font-size: 20px;
        }
    }
    </style>
    <?php
    
    return ob_get_clean();
}

/**
 * Add currency selector to header/footer
 */
function yoursite_add_header_currency_selector() {
    $settings = get_option('yoursite_currency_settings', array());
    
    if ($settings['display_currency_selector'] ?? true) {
        echo '<div class="header-currency-selector" style="margin: 0 15px;">';
        echo yoursite_render_currency_selector(array(
            'style' => 'compact',
            'show_flag' => true,
            'show_name' => false,
            'show_symbol' => false,
            'class' => 'header-currency-widget'
        ));
        echo '</div>';
    }
}

/**
 * Initialize frontend currency functionality
 */
function yoursite_init_frontend_currency() {
    // Auto-detect and set user currency on first visit
    if (!isset($_COOKIE['yoursite_preferred_currency'])) {
        $detected_currency = yoursite_smart_currency_detection();
        
        if ($detected_currency && $detected_currency['code'] !== yoursite_get_base_currency()['code']) {
            setcookie(
                'yoursite_preferred_currency',
                $detected_currency['code'],
                time() + (30 * DAY_IN_SECONDS),
                COOKIEPATH,
                COOKIE_DOMAIN
            );
        }
    }
}
add_action('init', 'yoursite_init_frontend_currency');

/**
 * Add global currency change JavaScript
 */
function yoursite_add_global_currency_js() {
    ?>
    <script>
    // Global currency change handler
    document.addEventListener('DOMContentLoaded', function() {
        // Dispatch currency change events
        function dispatchCurrencyChange(currency) {
            const event = new CustomEvent('currencyChanged', {
                detail: { currency: currency }
            });
            document.dispatchEvent(event);
        }
        
       // Listen for currency selector changes
document.addEventListener('click', function(e) {
    const currencyEl = e.target.closest('[data-currency-code]');
    if (!currencyEl) return;

    e.preventDefault();

    const newCurrency = currencyEl.dataset.currencyCode;

    // Update global currency state
    YourSiteCurrency.currentCurrency = newCurrency;

    // Dispatch event for components to update
    dispatchCurrencyChange(newCurrency);
});

        
        // Show currency change notification
        function showCurrencyNotification(message, isError = false) {
            const notification = document.createElement('div');
            notification.className = 'currency-notification' + (isError ? ' error' : '');
            notification.textContent = message;
            document.body.appendChild(notification);
            
            // Trigger animation
            setTimeout(() => notification.classList.add('show'), 100);
            
            // Remove after delay
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
        
        // Add to global scope for use by other components
        window.showCurrencyNotification = showCurrencyNotification;
    });
    </script>
    <?php
}
add_action('wp_footer', 'yoursite_add_global_currency_js');
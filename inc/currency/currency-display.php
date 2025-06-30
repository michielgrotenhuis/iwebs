<?php
/**
 * Currency Display Functions
 * File: inc/currency/currency-display.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render currency selector widget
 */
function yoursite_render_currency_selector($args = array()) {
    $defaults = array(
        'style' => 'dropdown', // dropdown, flags, compact
        'show_flag' => true,
        'show_name' => false,
        'show_symbol' => true,
        'class' => 'currency-selector',
        'container_class' => 'currency-selector-container'
    );
    
    $args = wp_parse_args($args, $defaults);
    
    $active_currencies = yoursite_get_active_currencies();
    $current_currency = yoursite_get_user_currency();
    
    if (count($active_currencies) <= 1) {
        return ''; // Don't show selector if only one currency
    }
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($args['container_class']); ?>" data-style="<?php echo esc_attr($args['style']); ?>">
        
        <?php if ($args['style'] === 'dropdown') : ?>
            <?php yoursite_render_dropdown_currency_selector($active_currencies, $current_currency, $args); ?>
        <?php elseif ($args['style'] === 'flags') : ?>
            <?php yoursite_render_flags_currency_selector($active_currencies, $current_currency, $args); ?>
        <?php elseif ($args['style'] === 'compact') : ?>
            <?php yoursite_render_compact_currency_selector($active_currencies, $current_currency, $args); ?>
        <?php endif; ?>
        
    </div>
    
   <?php if (!wp_script_is('currency-selector-js', 'enqueued')) : ?>
    <script id="currency-selector-js">
    document.addEventListener('DOMContentLoaded', function() {
        initCurrencySelector();
    });

    function initCurrencySelector() {
        document.addEventListener('click', function(e) {
            const target = e.target.closest('[data-currency-code]');
            if (target) {
                e.preventDefault();
                switchCurrency(target.dataset.currencyCode);
            }
        });
    
        
        // Handle dropdown toggle
                document.addEventListener('click', function(e) {
            if (e.target.closest('.currency-dropdown-toggle')) {

            e.preventDefault();
            e.stopPropagation();
            toggleCurrencyDropdown(this);
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.currency-selector-container')) {
                closeCurrencyDropdowns();
            }
        });
    }
    
    function switchCurrency(currencyCode) {
        // Show loading state
        showCurrencyLoadingState();
        
        // Make AJAX request
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'switch_user_currency',
                currency: currencyCode
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update all pricing on the page
                updatePagePricing(currencyCode);
                // Update selector state
                updateSelectorState(currencyCode);
                // Show success message
                showCurrencyChangeSuccess(data.data.message);
            } else {
                showCurrencyChangeError(data.data || 'Error switching currency');
            }
        })
        .catch(error => {
            console.error('Currency switch error:', error);
            showCurrencyChangeError('Network error occurred');
        })
        .finally(() => {
            hideCurrencyLoadingState();
        });
    }
    
    function updatePagePricing(currencyCode) {
        // Update pricing tables
        const pricingCards = document.querySelectorAll('.pricing-card, .conversion-pricing-card');
        if (pricingCards.length > 0) {
            updatePricingCards(currencyCode);
        }
        
        // Update comparison tables
        const comparisonTables = document.querySelectorAll('.pricing-comparison-wrapper');
        if (comparisonTables.length > 0) {
            updateComparisonTables(currencyCode);
        }
        
        // Update any other price displays
        const priceElements = document.querySelectorAll('[data-price-plan-id]');
        priceElements.forEach(element => {
            updatePriceElement(element, currencyCode);
        });
    }
    
    function updatePricingCards(currencyCode) {
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'get_all_pricing_in_currency',
                currency: currencyCode
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Object.keys(data.data.pricing).forEach(planId => {
                    const pricing = data.data.pricing[planId];
                    updatePlanPricing(planId, pricing);
                });
            }
        });
    }
    
    function updatePlanPricing(planId, pricing) {
        // Update monthly prices
        const monthlyElements = document.querySelectorAll('[data-plan-id="' + planId + '"] .monthly-price-display, [data-plan-id="' + planId + '"] .pricing-monthly-pricing');
        monthlyElements.forEach(el => {
            const priceElement = el.querySelector('.price-amount, .text-4xl, .text-5xl');
            if (priceElement) {
                priceElement.textContent = pricing.monthly_price.replace(/[^0-9.,]/g, '');
            }
        });
        
        // Update annual prices
        const annualElements = document.querySelectorAll('[data-plan-id="' + planId + '"] .annual-price-display, [data-plan-id="' + planId + '"] .pricing-annual-pricing');
        annualElements.forEach(el => {
            const priceElement = el.querySelector('.price-amount, .text-4xl, .text-5xl');
            if (priceElement) {
                priceElement.textContent = pricing.annual_monthly_equivalent.replace(/[^0-9.,]/g, '');
            }
        });
        
        // Update savings
        if (pricing.savings) {
            const savingsElements = document.querySelectorAll('[data-plan-id="' + planId + '"] .annual-savings, [data-plan-id="' + planId + '"] .pricing-annual-savings');
            savingsElements.forEach(el => {
                const savingsText = el.querySelector('.savings-amount');
                if (savingsText) {
                    savingsText.textContent = pricing.savings;
                }
            });
        }
    }
    
    function toggleCurrencyDropdown(toggle) {
        const container = toggle.closest('.currency-selector-container');
        const dropdown = container.querySelector('.currency-dropdown');
        
        // Close other dropdowns
        closeCurrencyDropdowns();
        
        // Toggle current dropdown
        if (dropdown) {
            dropdown.classList.toggle('active');
            toggle.classList.toggle('active');
        }
    }
    
    function closeCurrencyDropdowns() {
        document.querySelectorAll('.currency-dropdown.active').forEach(dropdown => {
            dropdown.classList.remove('active');
        });
        document.querySelectorAll('.currency-dropdown-toggle.active').forEach(toggle => {
            toggle.classList.remove('active');
        });
    }
    
    function updateSelectorState(currencyCode) {
        document.querySelectorAll('.currency-selector-container').forEach(container => {
            // Update active states
            container.querySelectorAll('[data-currency-code]').forEach(item => {
                item.classList.toggle('active', item.dataset.currencyCode === currencyCode);
            });
            
            // Update dropdown toggle display
            const toggle = container.querySelector('.currency-dropdown-toggle');
            const newActive = container.querySelector('[data-currency-code="' + currencyCode + '"]');
            if (toggle && newActive) {
                const toggleFlag = toggle.querySelector('.currency-flag');
                const toggleCode = toggle.querySelector('.currency-code');
                const newFlag = newActive.querySelector('.currency-flag');
                const newCode = newActive.querySelector('.currency-code');
                
                if (toggleFlag && newFlag) toggleFlag.textContent = newFlag.textContent;
                if (toggleCode && newCode) toggleCode.textContent = newCode.textContent;
            }
        });
        
        // Close dropdowns
        closeCurrencyDropdowns();
    }
    
    function showCurrencyLoadingState() {
        document.querySelectorAll('.currency-selector-container').forEach(container => {
            container.classList.add('loading');
        });
    }
    
    function hideCurrencyLoadingState() {
        document.querySelectorAll('.currency-selector-container').forEach(container => {
            container.classList.remove('loading');
        });
    }
    
    function showCurrencyChangeSuccess(message) {
        // Simple notification - you can enhance this
        const notification = document.createElement('div');
        notification.className = 'currency-notification success';
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    
    function showCurrencyChangeError(message) {
        // Simple error notification
        const notification = document.createElement('div');
        notification.className = 'currency-notification error';
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
    </script>
    <?php endif; ?>
    
    <style>
    /* Currency Selector Styles */
    .currency-selector-container {
        position: relative;
        display: inline-block;
    }
    
    .currency-selector-container.loading {
        opacity: 0.7;
        pointer-events: none;
    }
    
    /* Dropdown Style */
    .currency-dropdown-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s ease;
    .currency-compact-item {
        padding: 8px 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        color: inherit;
        border-right: 1px solid #ddd;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .currency-compact-item:last-child {
        border-right: none;
    }
    
    .currency-compact-item:hover {
        background: #f9f9f9;
        text-decoration: none;
        color: inherit;
    }
    
    .currency-compact-item.active {
        background: #0073aa;
        color: white;
    }
    
    /* Notifications */
    .currency-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 16px;
        border-radius: 6px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        animation: slideInRight 0.3s ease;
    }
    
    .currency-notification.success {
        background: #46b450;
    }
    
    .currency-notification.error {
        background: #dc3232;
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
    
    /* Dark mode support */
    .dark .currency-dropdown-toggle,
    .dark .currency-dropdown,
    .dark .currency-flag-item,
    .dark .currency-compact-selector {
        background: #1f2937;
        border-color: #374151;
        color: #e5e7eb;
    }
    
    .dark .currency-dropdown-item:hover,
    .dark .currency-flag-item:hover,
    .dark .currency-compact-item:hover {
        background: #374151;
    }
    
    .dark .currency-dropdown-item.active {
        background: #1e40af;
        color: white;
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .currency-dropdown {
            min-width: 180px;
            right: 0;
            left: auto;
        }
        
        .currency-flags-selector {
            gap: 6px;
        }
        
        .currency-flag-item {
            padding: 4px 8px;
            font-size: 11px;
        }
        
        .currency-notification {
            left: 20px;
            right: 20px;
            text-align: center;
        }
    }
    </style>
    <?php
    
    return ob_get_clean();
}

/**
 * Render dropdown currency selector
 */
function yoursite_render_dropdown_currency_selector($currencies, $current_currency, $args) {
    ?>
    <button class="currency-dropdown-toggle <?php echo esc_attr($args['class']); ?>" type="button">
        <?php if ($args['show_flag']) : ?>
            <span class="currency-flag"><?php echo esc_html($current_currency['flag']); ?></span>
        <?php endif; ?>
        
        <span class="currency-code"><?php echo esc_html($current_currency['code']); ?></span>
        
        <?php if ($args['show_name']) : ?>
            <span class="currency-name"><?php echo esc_html($current_currency['name']); ?></span>
        <?php endif; ?>
        
        <?php if ($args['show_symbol']) : ?>
            <span class="currency-symbol"><?php echo esc_html($current_currency['symbol']); ?></span>
        <?php endif; ?>
        
        <svg class="currency-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6,9 12,15 18,9"></polyline>
        </svg>
    </button>
    
    <div class="currency-dropdown">
        <?php foreach ($currencies as $currency) : ?>
            <a href="#" 
               class="currency-dropdown-item <?php echo $currency['code'] === $current_currency['code'] ? 'active' : ''; ?>"
               data-currency-code="<?php echo esc_attr($currency['code']); ?>">
                
                <?php if ($args['show_flag']) : ?>
                    <span class="currency-flag"><?php echo esc_html($currency['flag']); ?></span>
                <?php endif; ?>
                
                <span class="currency-code"><?php echo esc_html($currency['code']); ?></span>
                
                <?php if ($args['show_name']) : ?>
                    <span class="currency-name"><?php echo esc_html($currency['name']); ?></span>
                <?php endif; ?>
                
                <?php if ($args['show_symbol']) : ?>
                    <span class="currency-symbol"><?php echo esc_html($currency['symbol']); ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Render flags currency selector
 */
function yoursite_render_flags_currency_selector($currencies, $current_currency, $args) {
    ?>
    <div class="currency-flags-selector <?php echo esc_attr($args['class']); ?>">
        <?php foreach ($currencies as $currency) : ?>
            <a href="#" 
               class="currency-flag-item <?php echo $currency['code'] === $current_currency['code'] ? 'active' : ''; ?>"
               data-currency-code="<?php echo esc_attr($currency['code']); ?>"
               title="<?php echo esc_attr($currency['name'] . ' (' . $currency['symbol'] . ')'); ?>">
                
                <?php if ($args['show_flag']) : ?>
                    <span class="currency-flag"><?php echo esc_html($currency['flag']); ?></span>
                <?php endif; ?>
                
                <span class="currency-code"><?php echo esc_html($currency['code']); ?></span>
                
                <?php if ($args['show_symbol']) : ?>
                    <span class="currency-symbol"><?php echo esc_html($currency['symbol']); ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Render compact currency selector
 */
function yoursite_render_compact_currency_selector($currencies, $current_currency, $args) {
    ?>
    <div class="currency-compact-selector <?php echo esc_attr($args['class']); ?>">
        <?php foreach ($currencies as $currency) : ?>
            <a href="#" 
               class="currency-compact-item <?php echo $currency['code'] === $current_currency['code'] ? 'active' : ''; ?>"
               data-currency-code="<?php echo esc_attr($currency['code']); ?>"
               title="<?php echo esc_attr($currency['name']); ?>">
                
                <?php if ($args['show_flag']) : ?>
                    <span class="currency-flag"><?php echo esc_html($currency['flag']); ?></span>
                <?php endif; ?>
                
                <span class="currency-code"><?php echo esc_html($currency['code']); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Enhanced pricing display for multi-currency
 */
function yoursite_display_multi_currency_price($plan_id, $period = 'monthly', $args = array()) {
    $defaults = array(
        'show_currency_options' => true,
        'show_original_price' => false,
        'format' => 'standard', // standard, compact, detailed
        'class' => 'multi-currency-price'
    );
    
    $args = wp_parse_args($args, $defaults);
    $current_currency = yoursite_get_user_currency();
    $price = yoursite_get_pricing_plan_price($plan_id, $current_currency['code'], $period);
    
    if ($price <= 0) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($args['class']); ?>" 
         data-plan-id="<?php echo esc_attr($plan_id); ?>" 
         data-period="<?php echo esc_attr($period); ?>">
        
        <div class="primary-price">
            <?php echo yoursite_format_currency($price, $current_currency['code']); ?>
        </div>
        
        <?php if ($args['show_original_price'] && $current_currency['code'] !== yoursite_get_base_currency()['code']) : ?>
            <div class="original-price">
                <?php 
                $base_currency = yoursite_get_base_currency();
                $base_price = yoursite_get_pricing_plan_price($plan_id, $base_currency['code'], $period);
                echo yoursite_format_currency($base_price, $base_currency['code']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if ($args['show_currency_options']) : ?>
            <div class="currency-options">
                <?php echo yoursite_render_currency_selector(array('style' => 'compact')); ?>
            </div>
        <?php endif; ?>
        
    </div>
    <?php
    
    return ob_get_clean();
}

/**
 * Widget for displaying currency selector
 */
class YourSite_Currency_Selector_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'yoursite_currency_selector',
            __('Currency Selector', 'yoursite'),
            array('description' => __('Display a currency selector widget', 'yoursite'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $selector_args = array(
            'style' => $instance['style'] ?? 'dropdown',
            'show_flag' => !empty($instance['show_flag']),
            'show_name' => !empty($instance['show_name']),
            'show_symbol' => !empty($instance['show_symbol'])
        );
        
        echo yoursite_render_currency_selector($selector_args);
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $style = !empty($instance['style']) ? $instance['style'] : 'dropdown';
        $show_flag = isset($instance['show_flag']) ? (bool) $instance['show_flag'] : true;
        $show_name = isset($instance['show_name']) ? (bool) $instance['show_name'] : false;
        $show_symbol = isset($instance['show_symbol']) ? (bool) $instance['show_symbol'] : true;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style:', 'yoursite'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
                <option value="dropdown" <?php selected($style, 'dropdown'); ?>><?php _e('Dropdown', 'yoursite'); ?></option>
                <option value="flags" <?php selected($style, 'flags'); ?>><?php _e('Flags', 'yoursite'); ?></option>
                <option value="compact" <?php selected($style, 'compact'); ?>><?php _e('Compact', 'yoursite'); ?></option>
            </select>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_flag); ?> id="<?php echo $this->get_field_id('show_flag'); ?>" name="<?php echo $this->get_field_name('show_flag'); ?>" />
            <label for="<?php echo $this->get_field_id('show_flag'); ?>"><?php _e('Show flags', 'yoursite'); ?></label>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_name); ?> id="<?php echo $this->get_field_id('show_name'); ?>" name="<?php echo $this->get_field_name('show_name'); ?>" />
            <label for="<?php echo $this->get_field_id('show_name'); ?>"><?php _e('Show currency names', 'yoursite'); ?></label>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_symbol); ?> id="<?php echo $this->get_field_id('show_symbol'); ?>" name="<?php echo $this->get_field_name('show_symbol'); ?>" />
            <label for="<?php echo $this->get_field_id('show_symbol'); ?>"><?php _e('Show currency symbols', 'yoursite'); ?></label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['style'] = (!empty($new_instance['style'])) ? sanitize_text_field($new_instance['style']) : 'dropdown';
        $instance['show_flag'] = !empty($new_instance['show_flag']);
        $instance['show_name'] = !empty($new_instance['show_name']);
        $instance['show_symbol'] = !empty($new_instance['show_symbol']);
        
        return $instance;
    }
}

// Register the widget
function yoursite_register_currency_widgets() {
    register_widget('YourSite_Currency_Selector_Widget');
}
add_action('widgets_init', 'yoursite_register_currency_widgets');

/**
 * Shortcode for currency selector
 */
function yoursite_currency_selector_shortcode($atts) {
    $atts = shortcode_atts(array(
        'style' => 'dropdown',
        'show_flag' => 'true',
        'show_name' => 'false',
        'show_symbol' => 'true',
        'class' => 'currency-selector-shortcode'
    ), $atts, 'currency_selector');
    
    $args = array(
        'style' => $atts['style'],
        'show_flag' => $atts['show_flag'] === 'true',
        'show_name' => $atts['show_name'] === 'true',
        'show_symbol' => $atts['show_symbol'] === 'true',
        'class' => $atts['class']
    );
    
    return yoursite_render_currency_selector($args);
}
add_shortcode('currency_selector', 'yoursite_currency_selector_shortcode');

/**
 * Helper function to add currency selector to specific locations
 */
function yoursite_add_currency_selector_to_header() {
    $settings = get_option('yoursite_currency_settings', array());
    
    if ($settings['display_currency_selector'] ?? true) {
        echo '<div class="header-currency-selector">';
        echo yoursite_render_currency_selector(array(
            'style' => 'compact',
            'show_flag' => true,
            'show_name' => false,
            'show_symbol' => false
        ));
        echo '</div>';
    }
}

/**
 * Add currency selector to footer
 */
function yoursite_add_currency_selector_to_footer() {
    $settings = get_option('yoursite_currency_settings', array());
    
    if ($settings['display_currency_selector'] ?? true) {
        echo '<div class="footer-currency-selector">';
        echo '<span class="currency-selector-label">' . __('Currency:', 'yoursite') . '</span>';
        echo yoursite_render_currency_selector(array(
            'style' => 'dropdown',
            'show_flag' => true,
            'show_name' => false,
            'show_symbol' => true
        ));
        echo '</div>';
    }
}

/**
 * Display pricing with currency context
 */
function yoursite_pricing_with_currency_context($plan_id, $show_all_currencies = false) {
    $current_currency = yoursite_get_user_currency();
    $monthly_price = yoursite_get_pricing_plan_price($plan_id, $current_currency['code'], 'monthly');
    $annual_price = yoursite_get_pricing_plan_price($plan_id, $current_currency['code'], 'annual');
    
    ob_start();
    ?>
    <div class="pricing-with-currency-context" data-plan-id="<?php echo esc_attr($plan_id); ?>">
        
        <!-- Current Currency Pricing -->
        <div class="current-currency-pricing">
            <div class="currency-header">
                <span class="currency-flag"><?php echo esc_html($current_currency['flag']); ?></span>
                <span class="currency-name"><?php echo esc_html($current_currency['name']); ?></span>
                <span class="currency-code">(<?php echo esc_html($current_currency['code']); ?>)</span>
            </div>
            
            <div class="pricing-display">
                <?php if ($monthly_price > 0) : ?>
                    <div class="monthly-pricing">
                        <span class="price"><?php echo yoursite_format_currency($monthly_price, $current_currency['code']); ?></span>
                        <span class="period">/<?php _e('month', 'yoursite'); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($annual_price > 0) : ?>
                    <div class="annual-pricing">
                        <span class="price"><?php echo yoursite_format_currency($annual_price / 12, $current_currency['code']); ?></span>
                        <span class="period">/<?php _e('month', 'yoursite'); ?></span>
                        <span class="billing-note"><?php _e('billed annually', 'yoursite'); ?></span>
                        
                        <?php 
                        $savings = yoursite_calculate_annual_savings($plan_id, $current_currency['code']);
                        if ($savings > 0) : ?>
                            <div class="savings">
                                <?php printf(__('Save %s per year', 'yoursite'), yoursite_format_currency($savings, $current_currency['code'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if ($show_all_currencies) : ?>
            <!-- All Currencies -->
            <div class="all-currencies-pricing">
                <h4><?php _e('Pricing in Other Currencies', 'yoursite'); ?></h4>
                <?php 
                $active_currencies = yoursite_get_active_currencies();
                foreach ($active_currencies as $currency) :
                    if ($currency['code'] === $current_currency['code']) continue;
                    
                    $curr_monthly = yoursite_get_pricing_plan_price($plan_id, $currency['code'], 'monthly');
                    $curr_annual = yoursite_get_pricing_plan_price($plan_id, $currency['code'], 'annual');
                ?>
                    <div class="currency-pricing-row">
                        <span class="currency-info">
                            <?php echo esc_html($currency['flag']); ?> <?php echo esc_html($currency['code']); ?>
                        </span>
                        <?php if ($curr_monthly > 0) : ?>
                            <span class="price"><?php echo yoursite_format_currency($curr_monthly, $currency['code']); ?>/mo</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
<?php
    
    return ob_get_clean();
}
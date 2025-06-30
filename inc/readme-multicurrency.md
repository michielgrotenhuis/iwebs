# Multi-Currency Plugin Implementation Guide

## 1. Core Plugin Initialization

### A. Main Plugin File Setup
Create `currency-system.php` in your theme or plugin directory:

```php
<?php
/**
 * Multi-Currency System Main File
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('YOURSITE_CURRENCY_VERSION', '1.0.0');
define('YOURSITE_CURRENCY_PATH', plugin_dir_path(__FILE__));
define('YOURSITE_CURRENCY_URL', plugin_dir_url(__FILE__));

// Include all currency files
require_once YOURSITE_CURRENCY_PATH . 'inc/currency/currency-core.php';
require_once YOURSITE_CURRENCY_PATH . 'inc/currency/currency-conversion.php';
require_once YOURSITE_CURRENCY_PATH . 'inc/currency/currency-display.php';
require_once YOURSITE_CURRENCY_PATH . 'inc/currency/currency-frontend.php';
require_once YOURSITE_CURRENCY_PATH . 'inc/currency/currency-ajax.php';
require_once YOURSITE_CURRENCY_PATH . 'inc/currency/currency-admin.php';
require_once YOURSITE_CURRENCY_PATH . 'inc/currency/currency-meta-boxes.php';
require_once YOURSITE_CURRENCY_PATH . 'inc/currency/currency-cron.php';
require_once YOURSITE_CURRENCY_PATH . 'inc/currency/currency-custom.php';

/**
 * Initialize the currency system
 */
function yoursite_currency_init() {
    // Create database tables on activation
    yoursite_create_currency_tables();
    
    // Initialize default currencies if none exist
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    
    if ($count == 0) {
        yoursite_populate_default_currencies();
        yoursite_initialize_currency_settings();
    }
    
    // Register admin menu
    add_action('admin_menu', 'yoursite_currency_admin_menu');
    
    // Add AJAX handlers
    yoursite_register_currency_ajax_handlers();
    
    // Initialize frontend
    yoursite_init_frontend_currency();
}

// Hook to init
add_action('init', 'yoursite_currency_init');

/**
 * Register admin menu
 */
function yoursite_currency_admin_menu() {
    add_menu_page(
        __('Currency Management', 'yoursite'),
        __('Currencies', 'yoursite'),
        'manage_options',
        'yoursite-currencies',
        'yoursite_currency_admin_page',
        'dashicons-money-alt',
        30
    );
}

/**
 * Register AJAX handlers
 */
function yoursite_register_currency_ajax_handlers() {
    // Public AJAX handlers
    add_action('wp_ajax_switch_user_currency', 'yoursite_ajax_switch_user_currency');
    add_action('wp_ajax_nopriv_switch_user_currency', 'yoursite_ajax_switch_user_currency');
    
    add_action('wp_ajax_get_currency_pricing', 'yoursite_ajax_get_currency_pricing');
    add_action('wp_ajax_nopriv_get_currency_pricing', 'yoursite_ajax_get_currency_pricing');
    
    add_action('wp_ajax_get_all_pricing_in_currency', 'yoursite_ajax_get_all_pricing_in_currency');
    add_action('wp_ajax_nopriv_get_all_pricing_in_currency', 'yoursite_ajax_get_all_pricing_in_currency');
    
    // Admin AJAX handlers
    add_action('wp_ajax_refresh_currency_rates', 'yoursite_ajax_refresh_currency_rates');
    add_action('wp_ajax_update_conversion_rate', 'yoursite_ajax_update_conversion_rate');
    add_action('wp_ajax_toggle_currency_status', 'yoursite_ajax_toggle_currency_status');
    add_action('wp_ajax_delete_currency', 'yoursite_ajax_delete_currency');
}

/**
 * Activation hook
 */
register_activation_hook(__FILE__, 'yoursite_currency_activation');
function yoursite_currency_activation() {
    yoursite_create_currency_tables();
    yoursite_populate_default_currencies();
    yoursite_initialize_currency_settings();
    yoursite_schedule_currency_updates();
}

/**
 * Deactivation hook
 */
register_deactivation_hook(__FILE__, 'yoursite_currency_deactivation');
function yoursite_currency_deactivation() {
    yoursite_currency_deactivation_tasks();
}
```

## 2. Theme Integration Methods

### A. Display Currency Selector

#### Method 1: Using Shortcode (Easiest)
```php
// In any template file, post content, or widget
echo do_shortcode('[currency_selector style="dropdown" show_flag="true" show_symbol="true"]');

// Different styles available:
echo do_shortcode('[currency_selector style="flags"]'); // Flag buttons
echo do_shortcode('[currency_selector style="compact"]'); // Compact view
echo do_shortcode('[currency_selector style="dropdown" align="center"]'); // Centered
```

#### Method 2: Direct Function Call
```php
// In header.php
echo yoursite_render_currency_selector(array(
    'style' => 'dropdown',
    'show_flag' => true,
    'show_name' => false,
    'show_symbol' => true,
    'class' => 'header-currency-selector'
));

// In footer.php
echo yoursite_render_currency_selector(array(
    'style' => 'compact',
    'show_flag' => true,
    'show_name' => false,
    'show_symbol' => false,
    'class' => 'footer-currency-selector'
));
```

#### Method 3: Using Widget
```php
// Register widget area in functions.php
register_sidebar(array(
    'name' => 'Currency Selector',
    'id' => 'currency-selector',
    'before_widget' => '<div class="currency-widget">',
    'after_widget' => '</div>',
));

// Then add the Currency Selector Widget in WordPress admin
```

### B. Display Prices with Currency Support

#### Method 1: Simple Price Display
```php
// Display a price in current user's currency
$price = 29.99; // Your base price
$user_currency = yoursite_get_user_currency();
echo yoursite_format_currency($price, $user_currency['code']);

// Convert and display from base currency
$base_price = 29.99;
$converted_price = yoursite_convert_price($base_price, 'USD', $user_currency['code']);
echo yoursite_format_currency($converted_price, $user_currency['code']);
```

#### Method 2: Pricing Card Component
```php
// In your pricing page template
echo yoursite_render_pricing_card($plan_id, array(
    'show_currency_selector' => true,
    'show_original_price' => true,
    'billing_toggle' => true,
    'highlight' => false,
    'button_text' => 'Get Started',
    'features' => array(
        'Feature 1',
        'Feature 2',
        'Feature 3'
    )
));
```

#### Method 3: Multi-Currency Price Display
```php
// Display price with currency context
echo yoursite_pricing_with_currency_context($plan_id, false);

// Show all currencies comparison
echo yoursite_pricing_with_currency_context($plan_id, true);
```

#### Method 4: Pricing Comparison Table
```php
$plan_ids = array(123, 124, 125); // Your pricing plan post IDs
$features = array(
    'Storage Space' => array('description' => 'Amount of storage included'),
    'Bandwidth' => array('description' => 'Monthly bandwidth limit'),
    'Support' => array('description' => 'Type of support provided')
);

echo yoursite_render_pricing_comparison_table($plan_ids, array(
    'show_currency_selector' => true,
    'features' => $features,
    'billing_toggle' => true
));
```

### C. Manual Price Templates

#### For WooCommerce Integration
```php
// In your product template
add_filter('woocommerce_get_price_html', 'yoursite_woocommerce_price_html', 10, 2);
function yoursite_woocommerce_price_html($price_html, $product) {
    if (!is_admin()) {
        $user_currency = yoursite_get_user_currency();
        $base_currency = yoursite_get_base_currency();
        
        if ($user_currency['code'] !== $base_currency['code']) {
            $base_price = $product->get_price();
            $converted_price = yoursite_convert_price($base_price, $base_currency['code'], $user_currency['code']);
            $price_html = yoursite_format_currency($converted_price, $user_currency['code']);
        }
    }
    return $price_html;
}
```

#### For Custom Pricing Templates
```php
// In your pricing template files
function display_plan_pricing($monthly_price, $annual_price = null) {
    $user_currency = yoursite_get_user_currency();
    $base_currency = yoursite_get_base_currency();
    
    // Convert prices if needed
    if ($user_currency['code'] !== $base_currency['code']) {
        $monthly_price = yoursite_convert_price($monthly_price, $base_currency['code'], $user_currency['code']);
        if ($annual_price) {
            $annual_price = yoursite_convert_price($annual_price, $base_currency['code'], $user_currency['code']);
        }
    }
    
    echo '<div class="pricing-display" data-currency="' . esc_attr($user_currency['code']) . '">';
    echo '<div class="monthly-price">' . yoursite_format_currency($monthly_price, $user_currency['code']) . '/month</div>';
    
    if ($annual_price) {
        $annual_monthly = $annual_price / 12;
        echo '<div class="annual-price">' . yoursite_format_currency($annual_monthly, $user_currency['code']) . '/month</div>';
        echo '<div class="annual-total">Billed annually: ' . yoursite_format_currency($annual_price, $user_currency['code']) . '</div>';
    }
    echo '</div>';
}

// Usage
display_plan_pricing(29.99, 299.99);
```

## 3. JavaScript Integration for Dynamic Updates

### A. Basic Currency Switching
```javascript
// Add to your theme's JavaScript file
document.addEventListener('DOMContentLoaded', function() {
    // Listen for currency changes
    document.addEventListener('currencyChanged', function(e) {
        const newCurrency = e.detail.currency;
        updateAllPricing(newCurrency);
    });
    
    function updateAllPricing(currency) {
        // Update all pricing elements on the page
        document.querySelectorAll('[data-plan-id]').forEach(function(element) {
            const planId = element.dataset.planId;
            updatePlanPricing(planId, currency, element);
        });
    }
    
    function updatePlanPricing(planId, currency, element) {
        fetch(ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'get_currency_pricing',
                plan_id: planId,
                currency: currency,
                nonce: currencyNonce
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update pricing display
                const monthlyPrice = element.querySelector('.monthly-price');
                const annualPrice = element.querySelector('.annual-price');
                
                if (monthlyPrice && data.data.monthly_price) {
                    monthlyPrice.textContent = data.data.monthly_price;
                }
                if (annualPrice && data.data.annual_price) {
                    annualPrice.textContent = data.data.annual_price;
                }
            }
        });
    }
});
```

### B. Advanced Pricing Updates
```javascript
// For more complex pricing layouts
function updatePricingTable(currency) {
    fetch(ajaxurl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'get_all_pricing_in_currency',
            currency: currency,
            nonce: currencyNonce
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Object.keys(data.data.pricing).forEach(planId => {
                const pricing = data.data.pricing[planId];
                updatePlanDisplay(planId, pricing);
            });
        }
    });
}
```

## 4. Fixing the Issues You Mentioned

### A. Fix Currency Not Saving

#### Update the AJAX handler in currency-ajax.php:
```php
function yoursite_ajax_switch_user_currency() {
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (empty($currency_code)) {
        wp_send_json_error(__('Invalid currency', 'yoursite'));
    }
    
    $currency = yoursite_get_currency($currency_code);
    
    if (!$currency || $currency['status'] !== 'active') {
        wp_send_json_error(__('Currency not available', 'yoursite'));
    }
    
    // Set cookie with proper parameters
    $cookie_name = 'yoursite_preferred_currency';
    $cookie_value = $currency_code;
    $cookie_expire = time() + (30 * DAY_IN_SECONDS);
    $cookie_path = COOKIEPATH ? COOKIEPATH : '/';
    $cookie_domain = COOKIE_DOMAIN ? COOKIE_DOMAIN : '';
    
    // Set the cookie
    setcookie($cookie_name, $cookie_value, $cookie_expire, $cookie_path, $cookie_domain, is_ssl(), true);
    
    // Also set in $_COOKIE for immediate use
    $_COOKIE[$cookie_name] = $cookie_value;
    
    // Update user meta if logged in
    if (is_user_logged_in()) {
        update_user_meta(get_current_user_id(), 'preferred_currency', $currency_code);
    }
    
    wp_send_json_success(array(
        'currency' => $currency,
        'message' => sprintf(__('Currency switched to %s', 'yoursite'), $currency['name'])
    ));
}
```

### B. Fix Auto-Detection

#### Update currency-core.php user currency function:
```php
function yoursite_get_user_currency() {
    // 1. Check cookie first
    if (isset($_COOKIE['yoursite_preferred_currency'])) {
        $currency_code = sanitize_text_field($_COOKIE['yoursite_preferred_currency']);
        $currency = yoursite_get_currency($currency_code);
        if ($currency && $currency['status'] === 'active') {
            return $currency;
        }
    }
    
    // 2. Check logged-in user preference
    if (is_user_logged_in()) {
        $user_currency = get_user_meta(get_current_user_id(), 'preferred_currency', true);
        if ($user_currency) {
            $currency = yoursite_get_currency($user_currency);
            if ($currency && $currency['status'] === 'active') {
                return $currency;
            }
        }
    }
    
    // 3. Auto-detect for first-time visitors
    $settings = get_option('yoursite_currency_settings', array());
    if ($settings['geolocation_detection'] ?? true) {
        $detected_currency = yoursite_smart_currency_detection();
        if ($detected_currency) {
            // Automatically set cookie for detected currency
            setcookie(
                'yoursite_preferred_currency',
                $detected_currency['code'],
                time() + (30 * DAY_IN_SECONDS),
                COOKIEPATH ?: '/',
                COOKIE_DOMAIN ?: '',
                is_ssl(),
                true
            );
            return $detected_currency;
        }
    }
    
    // 4. Fallback to base currency
    return yoursite_get_base_currency();
}
```

#### Enable auto-detection in settings:
```php
// Add to functions.php or in your currency initialization
function yoursite_enable_auto_detection() {
    $settings = get_option('yoursite_currency_settings', array());
    $settings['geolocation_detection'] = true;
    update_option('yoursite_currency_settings', $settings);
}
add_action('init', 'yoursite_enable_auto_detection');
```

### C. Fix Price Display Updates

#### Add real-time price update JavaScript:
```javascript
// Add to your theme's main JS file
(function() {
    'use strict';
    
    // Store original prices for conversion
    const originalPrices = new Map();
    
    document.addEventListener('DOMContentLoaded', function() {
        // Store original prices on page load
        storeOriginalPrices();
        
        // Listen for currency changes
        document.addEventListener('currencyChanged', function(e) {
            updateAllPricesOnPage(e.detail.currency);
        });
    });
    
    function storeOriginalPrices() {
        document.querySelectorAll('[data-price]').forEach(function(element) {
            const price = parseFloat(element.dataset.price);
            const currency = element.dataset.currency || 'USD';
            originalPrices.set(element, { price: price, currency: currency });
        });
    }
    
    function updateAllPricesOnPage(newCurrency) {
        originalPrices.forEach(function(data, element) {
            convertAndUpdatePrice(element, data.price, data.currency, newCurrency);
        });
    }
    
    function convertAndUpdatePrice(element, originalPrice, fromCurrency, toCurrency) {
        if (fromCurrency === toCurrency) {
            element.textContent = formatCurrency(originalPrice, toCurrency);
            return;
        }
        
        // Make AJAX call to convert price
        fetch(ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'convert_currency_price',
                amount: originalPrice,
                from_currency: fromCurrency,
                to_currency: toCurrency,
                nonce: currencyNonce
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                element.textContent = data.data.formatted_amount;
            }
        });
    }
})();
```

## 5. Complete Theme Implementation Example

### A. In your functions.php:
```php
// Include currency system
require_once get_template_directory() . '/currency-system.php';

// Add currency selector to header
function add_currency_to_header() {
    if (function_exists('yoursite_render_currency_selector')) {
        echo '<div class="header-currency">';
        echo yoursite_render_currency_selector(array(
            'style' => 'dropdown',
            'show_flag' => true,
            'show_symbol' => true,
            'show_name' => false
        ));
        echo '</div>';
    }
}
add_action('wp_head', 'add_currency_to_header');

// Enqueue necessary scripts
function enqueue_currency_scripts() {
    wp_localize_script('jquery', 'currencyAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('currency_frontend_nonce'),
        'strings' => array(
            'confirm_refresh' => __('Refresh all currency rates?', 'yoursite'),
            'updating' => __('Updating...', 'yoursite'),
            'error' => __('Error occurred', 'yoursite'),
            'confirm_delete' => __('Are you sure you want to delete this currency?', 'yoursite')
        )
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_currency_scripts');
```

### B. In your pricing page template:
```php
<?php
// pricing-page.php
get_header();

// Your pricing plans (these would be your actual plan IDs)
$pricing_plans = array(
    array('id' => 123, 'name' => 'Basic', 'monthly' => 9.99, 'annual' => 99.99),
    array('id' => 124, 'name' => 'Pro', 'monthly' => 19.99, 'annual' => 199.99),
    array('id' => 125, 'name' => 'Enterprise', 'monthly' => 49.99, 'annual' => 499.99)
);

$user_currency = yoursite_get_user_currency();
?>

<div class="pricing-page">
    <div class="pricing-header">
        <h1>Choose Your Plan</h1>
        <div class="currency-selector-wrapper">
            <span>Currency: </span>
            <?php echo yoursite_render_currency_selector(array(
                'style' => 'dropdown',
                'show_flag' => true,
                'show_symbol' => true
            )); ?>
        </div>
    </div>
    
    <div class="pricing-grid">
        <?php foreach ($pricing_plans as $plan) : ?>
            <div class="pricing-card" data-plan-id="<?php echo $plan['id']; ?>">
                <h3><?php echo $plan['name']; ?></h3>
                
                <div class="price-display">
                    <div class="monthly-price" data-price="<?php echo $plan['monthly']; ?>" data-currency="USD">
                        <?php echo yoursite_format_currency(
                            yoursite_convert_price($plan['monthly'], 'USD', $user_currency['code']), 
                            $user_currency['code']
                        ); ?>
                        <span class="period">/month</span>
                    </div>
                    
                    <div class="annual-price" data-price="<?php echo $plan['annual']; ?>" data-currency="USD">
                        <?php 
                        $annual_monthly = $plan['annual'] / 12;
                        echo yoursite_format_currency(
                            yoursite_convert_price($annual_monthly, 'USD', $user_currency['code']), 
                            $user_currency['code']
                        ); 
                        ?>
                        <span class="period">/month (billed annually)</span>
                    </div>
                </div>
                
                <a href="#" class="btn-primary">Get Started</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php get_footer(); ?>
```

This comprehensive implementation will:
1. Properly save user currency preferences
2. Auto-detect visitor currency on first visit
3. Display prices in the selected currency
4. Update prices dynamically when currency changes
5. Provide multiple integration methods for different use cases

Make sure to test the implementation thoroughly and adjust the styling to match your theme's design.
<?php
/**
 * Currency AJAX Handlers - COMPLETE REWRITE
 * File: inc/currency/currency-ajax.php
 * 
 * FIXED VERSION: No header issues, reliable currency switching
 * 
 * Key Changes:
 * - No server-side cookie setting (prevents header issues)
 * - JavaScript handles all cookie operations
 * - Session and user meta for server-side persistence
 * - Proper output buffering for all handlers
 * - Enhanced error handling and debugging
 */

if (!defined('ABSPATH')) {
    exit;
}

// =============================================================================
// CORE CURRENCY SWITCHING HANDLERS
// =============================================================================

/**
 * MAIN: Switch user currency - NO COOKIES VERSION
 * This is the primary handler that avoids all header issues
 */
function yoursite_ajax_switch_user_currency() {
    // Start output buffering to prevent any unwanted output
    if (!ob_get_level()) {
        ob_start();
    }
    
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (empty($currency_code)) {
        ob_end_clean();
        wp_send_json_error(__('Invalid currency code', 'yoursite'));
    }
    
    // Validate currency code format (3 letter code)
    if (!preg_match('/^[A-Z]{3}$/', $currency_code)) {
        ob_end_clean();
        wp_send_json_error(__('Invalid currency format', 'yoursite'));
    }
    
    // Check if currency exists and is active
    $currency = yoursite_get_currency($currency_code);
    if (!$currency) {
        ob_end_clean();
        wp_send_json_error(__('Currency not found', 'yoursite'));
    }
    
    if ($currency['status'] !== 'active') {
        ob_end_clean();
        wp_send_json_error(__('Currency not available', 'yoursite'));
    }
    
    // Clean output buffer before processing
    ob_end_clean();
    
    // Start session if not already started
    if (!session_id()) {
        session_start();
    }
    
    // Store in session (immediate persistence)
    $_SESSION['preferred_currency'] = $currency_code;
    
    // Update user meta if logged in (persistent across sessions)
    if (is_user_logged_in()) {
        update_user_meta(get_current_user_id(), 'preferred_currency', $currency_code);
    }
    
    // Log for debugging (remove in production)
    if (WP_DEBUG_LOG) {
        error_log("Currency switched to: $currency_code for user: " . (is_user_logged_in() ? get_current_user_id() : 'guest'));
    }
    
    wp_send_json_success(array(
        'currency' => $currency,
        'currency_code' => $currency_code,
        'message' => sprintf(__('Currency switched to %s (%s)', 'yoursite'), $currency['name'], $currency_code),
        'set_cookie_js' => true, // Tell frontend to set cookie via JavaScript
        'session_set' => isset($_SESSION['preferred_currency']),
        'user_meta_updated' => is_user_logged_in(),
        'debug' => array(
            'session_id' => session_id(),
            'user_id' => is_user_logged_in() ? get_current_user_id() : 0,
            'timestamp' => current_time('mysql')
        )
    ));
}

/**
 * ALTERNATIVE: Get current user currency info
 */
function yoursite_ajax_get_current_currency() {
    $current_currency = yoursite_get_user_currency();
    
    wp_send_json_success(array(
        'currency' => $current_currency,
        'currency_code' => $current_currency['code'],
        'symbol' => $current_currency['symbol'] ?? $current_currency['code'],
        'name' => $current_currency['name']
    ));
}

/**
 * BULK: Get all available currencies for frontend
 */
function yoursite_ajax_get_available_currencies() {
    $currencies = yoursite_get_active_currencies();
    
    if (empty($currencies)) {
        wp_send_json_error(__('No currencies available', 'yoursite'));
    }
    
    // Format for frontend consumption
    $formatted_currencies = array();
    foreach ($currencies as $currency) {
        $formatted_currencies[] = array(
            'code' => $currency['code'],
            'name' => $currency['name'],
            'symbol' => $currency['symbol'] ?? $currency['code'],
            'flag' => $currency['flag'] ?? '',
            'is_base' => !empty($currency['is_base_currency'])
        );
    }
    
    wp_send_json_success(array(
        'currencies' => $formatted_currencies,
        'count' => count($formatted_currencies),
        'current' => yoursite_get_user_currency()['code']
    ));
}

// =============================================================================
// PRICING RELATED AJAX HANDLERS
// =============================================================================

/**
 * Get pricing for specific plan in specific currency
 */
function yoursite_ajax_get_currency_pricing() {
    if (!ob_get_level()) ob_start();
    
    $plan_id = intval($_POST['plan_id'] ?? 0);
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (!$plan_id || !$currency_code) {
        ob_end_clean();
        wp_send_json_error(__('Plan ID and currency code are required', 'yoursite'));
    }
    
    // Verify plan exists
    $plan = get_post($plan_id);
    if (!$plan || $plan->post_type !== 'pricing' || $plan->post_status !== 'publish') {
        ob_end_clean();
        wp_send_json_error(__('Invalid plan', 'yoursite'));
    }
    
    // Get pricing in requested currency
    $monthly_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'monthly');
    $annual_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'annual');
    
    if ($monthly_price === false || $annual_price === false) {
        ob_end_clean();
        wp_send_json_error(__('Unable to calculate pricing', 'yoursite'));
    }
    
    // Calculate additional pricing info
    $annual_monthly_equivalent = $annual_price > 0 ? $annual_price / 12 : 0;
    $savings = yoursite_calculate_annual_savings($plan_id, $currency_code);
    $discount_percentage = yoursite_calculate_annual_discount_percentage($plan_id, $currency_code);
    
    // Format currencies
    $formatted_monthly = yoursite_format_currency($monthly_price, $currency_code);
    $formatted_annual = yoursite_format_currency($annual_price, $currency_code);
    $formatted_annual_monthly = yoursite_format_currency($annual_monthly_equivalent, $currency_code);
    $formatted_savings = $savings > 0 ? yoursite_format_currency($savings, $currency_code) : '';
    
    // Get currency info
    $currency = yoursite_get_currency($currency_code);
    
    ob_end_clean();
    
    wp_send_json_success(array(
        'plan_id' => $plan_id,
        'currency_code' => $currency_code,
        'pricing' => array(
            'monthly' => array(
                'raw' => $monthly_price,
                'formatted' => $formatted_monthly
            ),
            'annual' => array(
                'raw' => $annual_price,
                'formatted' => $formatted_annual,
                'monthly_equivalent' => array(
                    'raw' => $annual_monthly_equivalent,
                    'formatted' => $formatted_annual_monthly
                )
            ),
            'savings' => array(
                'raw' => $savings,
                'formatted' => $formatted_savings,
                'percentage' => $discount_percentage
            )
        ),
        'currency' => $currency
    ));
}

/**
 * Get pricing for ALL plans in specific currency
 */
function yoursite_ajax_get_all_pricing_in_currency() {
    if (!ob_get_level()) ob_start();
    
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (!$currency_code) {
        ob_end_clean();
        wp_send_json_error(__('Currency code is required', 'yoursite'));
    }
    
    // Validate currency
    $currency = yoursite_get_currency($currency_code);
    if (!$currency || $currency['status'] !== 'active') {
        ob_end_clean();
        wp_send_json_error(__('Invalid or inactive currency', 'yoursite'));
    }
    
    // Get all published pricing plans
    $args = array(
        'post_type' => 'pricing',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_key' => '_pricing_monthly_price',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
    );
    
    $plans = get_posts($args);
    
    if (empty($plans)) {
        ob_end_clean();
        wp_send_json_error(__('No pricing plans found', 'yoursite'));
    }
    
    $pricing_data = array();
    
    foreach ($plans as $plan) {
        $monthly_price = yoursite_get_pricing_plan_price($plan->ID, $currency_code, 'monthly');
        $annual_price = yoursite_get_pricing_plan_price($plan->ID, $currency_code, 'annual');
        
        if ($monthly_price === false || $annual_price === false) {
            continue; // Skip plans with pricing errors
        }
        
        $annual_monthly_equivalent = $annual_price > 0 ? $annual_price / 12 : 0;
        $savings = yoursite_calculate_annual_savings($plan->ID, $currency_code);
        $discount_percentage = yoursite_calculate_annual_discount_percentage($plan->ID, $currency_code);
        
        $pricing_data[$plan->ID] = array(
            'title' => $plan->post_title,
            'monthly' => array(
                'raw' => $monthly_price,
                'formatted' => yoursite_format_currency($monthly_price, $currency_code)
            ),
            'annual' => array(
                'raw' => $annual_price,
                'formatted' => yoursite_format_currency($annual_price, $currency_code),
                'monthly_equivalent' => array(
                    'raw' => $annual_monthly_equivalent,
                    'formatted' => yoursite_format_currency($annual_monthly_equivalent, $currency_code)
                )
            ),
            'savings' => array(
                'raw' => $savings,
                'formatted' => $savings > 0 ? yoursite_format_currency($savings, $currency_code) : '',
                'percentage' => $discount_percentage
            ),
            'featured' => get_post_meta($plan->ID, '_pricing_featured', true) === '1'
        );
    }
    
    ob_end_clean();
    
    wp_send_json_success(array(
        'currency_code' => $currency_code,
        'currency' => $currency,
        'plans' => $pricing_data,
        'plan_count' => count($pricing_data)
    ));
}

/**
 * Convert a specific price between currencies
 */
function yoursite_ajax_convert_currency_price() {
    if (!ob_get_level()) ob_start();
    
    $from_currency = sanitize_text_field($_POST['from_currency'] ?? '');
    $to_currency = sanitize_text_field($_POST['to_currency'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);
    
    if (!$from_currency || !$to_currency || $amount <= 0) {
        ob_end_clean();
        wp_send_json_error(__('Invalid conversion parameters', 'yoursite'));
    }
    
    $converted_amount = yoursite_convert_price($amount, $from_currency, $to_currency);
    
    if ($converted_amount === false) {
        ob_end_clean();
        wp_send_json_error(__('Currency conversion failed', 'yoursite'));
    }
    
    $formatted_amount = yoursite_format_currency($converted_amount, $to_currency);
    
    ob_end_clean();
    
    wp_send_json_success(array(
        'from_currency' => $from_currency,
        'to_currency' => $to_currency,
        'original_amount' => $amount,
        'converted_amount' => $converted_amount,
        'formatted_amount' => $formatted_amount,
        'conversion_rate' => yoursite_get_conversion_rate($from_currency, $to_currency)
    ));
}

// =============================================================================
// ADMIN CURRENCY MANAGEMENT HANDLERS
// =============================================================================

/**
 * ADMIN: Refresh all currency rates
 */
function yoursite_ajax_refresh_currency_rates() {
    if (!ob_get_level()) ob_start();
    
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        ob_end_clean();
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $updated_count = yoursite_update_currency_rates();
    
    ob_end_clean();
    
    if ($updated_count !== false) {
        wp_send_json_success(array(
            'message' => sprintf(__('%d currencies updated successfully', 'yoursite'), $updated_count),
            'updated_count' => $updated_count,
            'last_update' => current_time('mysql')
        ));
    } else {
        wp_send_json_error(__('Failed to update currency rates', 'yoursite'));
    }
}

/**
 * ADMIN: Toggle currency status
 */
function yoursite_ajax_toggle_currency_status() {
    if (!ob_get_level()) ob_start();
    
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        ob_end_clean();
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_id = intval($_POST['currency_id'] ?? 0);
    $status = sanitize_text_field($_POST['status'] ?? '');
    
    if (!$currency_id || !in_array($status, array('active', 'inactive'))) {
        ob_end_clean();
        wp_send_json_error(__('Invalid parameters', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $result = $wpdb->update(
        $table_name,
        array('status' => $status, 'updated_at' => current_time('mysql')),
        array('id' => $currency_id),
        array('%s', '%s'),
        array('%d')
    );
    
    ob_end_clean();
    
    if ($result !== false) {
        wp_send_json_success(array(
            'message' => __('Currency status updated', 'yoursite'),
            'currency_id' => $currency_id,
            'new_status' => $status
        ));
    } else {
        wp_send_json_error(__('Failed to update currency status', 'yoursite'));
    }
}

/**
 * ADMIN: Update conversion rate
 */
function yoursite_ajax_update_conversion_rate() {
    if (!ob_get_level()) ob_start();
    
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        ob_end_clean();
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_id = intval($_POST['currency_id'] ?? 0);
    $conversion_rate = floatval($_POST['conversion_rate'] ?? 0);
    
    if (!$currency_id || $conversion_rate <= 0) {
        ob_end_clean();
        wp_send_json_error(__('Invalid parameters', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    // Log the rate change for history
    $old_rate = $wpdb->get_var($wpdb->prepare(
        "SELECT conversion_rate FROM $table_name WHERE id = %d",
        $currency_id
    ));
    
    $result = $wpdb->update(
        $table_name,
        array(
            'conversion_rate' => $conversion_rate,
            'last_updated' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        ),
        array('id' => $currency_id),
        array('%f', '%s', '%s'),
        array('%d')
    );
    
    ob_end_clean();
    
    if ($result !== false) {
        // Log rate change if history table exists
        $history_table = $wpdb->prefix . 'yoursite_currency_rate_history';
        if ($wpdb->get_var("SHOW TABLES LIKE '$history_table'") === $history_table) {
            $wpdb->insert(
                $history_table,
                array(
                    'currency_id' => $currency_id,
                    'old_rate' => $old_rate,
                    'new_rate' => $conversion_rate,
                    'change_type' => 'manual',
                    'created_at' => current_time('mysql')
                )
            );
        }
        
        wp_send_json_success(array(
            'message' => __('Conversion rate updated', 'yoursite'),
            'currency_id' => $currency_id,
            'new_rate' => $conversion_rate,
            'old_rate' => $old_rate
        ));
    } else {
        wp_send_json_error(__('Failed to update conversion rate', 'yoursite'));
    }
}

/**
 * ADMIN: Get currency statistics
 */
function yoursite_ajax_get_currency_statistics() {
    if (!ob_get_level()) ob_start();
    
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        ob_end_clean();
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    global $wpdb;
    $currencies_table = $wpdb->prefix . 'yoursite_currencies';
    $pricing_table = $wpdb->prefix . 'yoursite_pricing_currencies';
    
    // Get basic statistics
    $stats = array(
        'total_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM $currencies_table"),
        'active_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM $currencies_table WHERE status = 'active'"),
        'inactive_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM $currencies_table WHERE status = 'inactive'"),
        'crypto_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM $currencies_table WHERE is_crypto = 1"),
        'fiat_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM $currencies_table WHERE is_crypto = 0"),
        'auto_update_enabled' => $wpdb->get_var("SELECT COUNT(*) FROM $currencies_table WHERE auto_update = 1"),
        'base_currency' => $wpdb->get_var("SELECT code FROM $currencies_table WHERE is_base_currency = 1"),
        'last_rate_update' => $wpdb->get_var("SELECT MAX(last_updated) FROM $currencies_table WHERE auto_update = 1"),
        'stale_rates_count' => $wpdb->get_var(
            "SELECT COUNT(*) FROM $currencies_table 
             WHERE status = 'active' 
             AND auto_update = 1 
             AND (last_updated IS NULL OR last_updated < DATE_SUB(NOW(), INTERVAL 24 HOUR))"
        )
    );
    
    // Get most used currencies
    $popular_currencies = $wpdb->get_results(
        "SELECT c.code, c.name, c.symbol, COUNT(pc.id) as usage_count
         FROM $currencies_table c
         LEFT JOIN $pricing_table pc ON c.code = pc.currency_code
         WHERE c.status = 'active'
         GROUP BY c.code
         ORDER BY usage_count DESC, c.name ASC
         LIMIT 10"
    );
    
    $stats['popular_currencies'] = $popular_currencies;
    
    ob_end_clean();
    
    wp_send_json_success($stats);
}

// =============================================================================
// UTILITY HANDLERS
// =============================================================================

/**
 * Test currency formatting
 */
function yoursite_ajax_test_currency_format() {
    $currency_code = sanitize_text_field($_POST['currency_code'] ?? '');
    $test_amounts = array(9.99, 123.45, 1234.56, 12345.67);
    
    if (empty($currency_code)) {
        wp_send_json_error(__('Currency code is required', 'yoursite'));
    }
    
    $formatted_amounts = array();
    
    foreach ($test_amounts as $amount) {
        $formatted_amounts[] = array(
            'amount' => $amount,
            'formatted' => yoursite_format_currency($amount, $currency_code)
        );
    }
    
    wp_send_json_success(array(
        'currency_code' => $currency_code,
        'test_results' => $formatted_amounts
    ));
}

/**
 * Get conversion rate between two currencies
 */
function yoursite_ajax_get_conversion_rate() {
    $from_currency = sanitize_text_field($_POST['from'] ?? '');
    $to_currency = sanitize_text_field($_POST['to'] ?? '');
    
    if (!$from_currency || !$to_currency) {
        wp_send_json_error(__('Both currency codes are required', 'yoursite'));
    }
    
    $rate = yoursite_get_conversion_rate($from_currency, $to_currency);
    
    if ($rate === false) {
        wp_send_json_error(__('Unable to get conversion rate', 'yoursite'));
    }
    
    wp_send_json_success(array(
        'from' => $from_currency,
        'to' => $to_currency,
        'rate' => $rate,
        'formatted_rate' => number_format($rate, 6),
        'inverse_rate' => $rate > 0 ? 1 / $rate : 0
    ));
}

// =============================================================================
// REGISTER ALL AJAX ACTIONS
// =============================================================================

/**
 * Register all AJAX handlers
 */
function yoursite_register_currency_ajax_handlers() {
    // Public handlers (logged in and non-logged in users)
    $public_handlers = array(
        'switch_user_currency' => 'yoursite_ajax_switch_user_currency',
        'get_current_currency' => 'yoursite_ajax_get_current_currency',
        'get_available_currencies' => 'yoursite_ajax_get_available_currencies',
        'get_currency_pricing' => 'yoursite_ajax_get_currency_pricing',
        'get_all_pricing_in_currency' => 'yoursite_ajax_get_all_pricing_in_currency',
        'convert_currency_price' => 'yoursite_ajax_convert_currency_price',
        'test_currency_format' => 'yoursite_ajax_test_currency_format',
        'get_conversion_rate' => 'yoursite_ajax_get_conversion_rate'
    );
    
    foreach ($public_handlers as $action => $callback) {
        add_action('wp_ajax_' . $action, $callback);
        add_action('wp_ajax_nopriv_' . $action, $callback);
    }
    
    // Admin-only handlers
    $admin_handlers = array(
        'refresh_currency_rates' => 'yoursite_ajax_refresh_currency_rates',
        'toggle_currency_status' => 'yoursite_ajax_toggle_currency_status',
        'update_conversion_rate' => 'yoursite_ajax_update_conversion_rate',
        'get_currency_statistics' => 'yoursite_ajax_get_currency_statistics'
    );
    
    foreach ($admin_handlers as $action => $callback) {
        add_action('wp_ajax_' . $action, $callback);
    }
}

// Register handlers early in WordPress lifecycle
add_action('wp_loaded', 'yoursite_register_currency_ajax_handlers', 1);

// =============================================================================
// HELPER FUNCTIONS
// =============================================================================

/**
 * Enhanced get user currency function with multiple fallbacks
 */
function yoursite_get_user_currency_enhanced() {
    static $current_currency = null;
    
    // Return cached result
    if ($current_currency !== null) {
        return $current_currency;
    }
    
    $cookie_name = 'yoursite_preferred_currency';
    
    // Start session if needed
    if (!session_id()) {
        session_start();
    }
    
    // 1. Check session (most reliable for current request)
    if (isset($_SESSION['preferred_currency'])) {
        $currency_code = sanitize_text_field($_SESSION['preferred_currency']);
        $currency = yoursite_get_currency($currency_code);
        if ($currency && $currency['status'] === 'active') {
            $current_currency = $currency;
            return $current_currency;
        }
    }
    
    // 2. Check cookie
    if (isset($_COOKIE[$cookie_name])) {
        $currency_code = sanitize_text_field($_COOKIE[$cookie_name]);
        $currency = yoursite_get_currency($currency_code);
        if ($currency && $currency['status'] === 'active') {
            $_SESSION['preferred_currency'] = $currency_code;
            $current_currency = $currency;
            return $current_currency;
        }
    }
    
    // 3. Check user meta
    if (is_user_logged_in()) {
        $user_currency = get_user_meta(get_current_user_id(), 'preferred_currency', true);
        if ($user_currency) {
            $currency = yoursite_get_currency($user_currency);
            if ($currency && $currency['status'] === 'active') {
                $_SESSION['preferred_currency'] = $user_currency;
                $current_currency = $currency;
                return $current_currency;
            }
        }
    }
    
    // 4. Fallback to base currency
    $base_currency = yoursite_get_base_currency();
    $current_currency = $base_currency ?: array(
        'code' => 'USD',
        'name' => 'US Dollar',
        'symbol' => '$',
        'status' => 'active'
    );
    
    return $current_currency;
}

/**
 * Initialize currency JavaScript variables
 */
function yoursite_init_currency_javascript_vars() {
    $current_currency = yoursite_get_user_currency_enhanced();
    
    wp_add_inline_script('jquery', '
        window.YourSiteCurrency = window.YourSiteCurrency || {};
        window.YourSiteCurrency.current = "' . esc_js($current_currency['code']) . '";
        window.YourSiteCurrency.ajaxUrl = "' . esc_js(admin_url('admin-ajax.php')) . '";
        window.YourSiteCurrency.nonce = "' . esc_js(wp_create_nonce('currency_switch')) . '";
        window.YourSiteCurrency.cookieName = "yoursite_preferred_currency";
        window.YourSiteCurrency.debug = ' . (WP_DEBUG ? 'true' : 'false') . ';
    ', 'before');
}
add_action('wp_enqueue_scripts', 'yoursite_init_currency_javascript_vars', 5);

/**
 * Clean session on logout
 */
function yoursite_cleanup_currency_session_on_logout() {
    if (isset($_SESSION['preferred_currency'])) {
        unset($_SESSION['preferred_currency']);
    }
}
add_action('wp_logout', 'yoursite_cleanup_currency_session_on_logout');

/**
 * Debug logging function
 */
function yoursite_log_currency_debug($message, $data = null) {
    if (WP_DEBUG_LOG) {
        $log_message = 'YourSite Currency: ' . $message;
        if ($data !== null) {
            $log_message .= ' | Data: ' . print_r($data, true);
        }
        error_log($log_message);
    }
}

/**
 * Validate currency code format
 */
function yoursite_validate_currency_code($currency_code) {
    return preg_match('/^[A-Z]{3}$/', $currency_code);
}

/**
 * Error handler for AJAX requests
 */
function yoursite_ajax_error_handler($error_message, $error_code = 'currency_error', $data = null) {
    yoursite_log_currency_debug("AJAX Error: $error_message", $data);
    
    wp_send_json_error(array(
        'message' => $error_message,
        'code' => $error_code,
        'timestamp' => current_time('mysql')
    ));
}

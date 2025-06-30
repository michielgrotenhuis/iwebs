<?php
/**
 * Currency AJAX Handlers
 * File: inc/currency/currency-ajax.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * AJAX: Refresh all currency rates
 */
function yoursite_ajax_refresh_currency_rates() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $updated_count = yoursite_update_currency_rates();
    
    if ($updated_count !== false) {
        wp_send_json_success(array(
            'message' => sprintf(__('%d currencies updated successfully', 'yoursite'), $updated_count),
            'updated_count' => $updated_count
        ));
    } else {
        wp_send_json_error(__('Failed to update currency rates', 'yoursite'));
    }
}
add_action('wp_ajax_refresh_currency_rates', 'yoursite_ajax_refresh_currency_rates');

/**
 * AJAX: Import currencies from file
 */
function yoursite_ajax_import_currencies_file() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    if (!isset($_FILES['import_file']) || $_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error(__('No file uploaded or upload error', 'yoursite'));
    }
    
    $file_extension = pathinfo($_FILES['import_file']['name'], PATHINFO_EXTENSION);
    $allowed_extensions = array('json', 'csv');
    
    if (!in_array(strtolower($file_extension), $allowed_extensions)) {
        wp_send_json_error(__('Invalid file format. Only JSON and CSV files are allowed.', 'yoursite'));
    }
    
    $file_content = file_get_contents($_FILES['import_file']['tmp_name']);
    
    if ($file_content === false) {
        wp_send_json_error(__('Could not read uploaded file', 'yoursite'));
    }
    
    $result = array('success' => false, 'error' => __('Unknown error', 'yoursite'));
    
    if ($file_extension === 'json') {
        $result = yoursite_import_currencies_json($file_content);
    } elseif ($file_extension === 'csv') {
        $result = yoursite_import_currencies_from_csv($file_content);
    }
    
    if ($result['success']) {
        wp_send_json_success(array(
            'message' => sprintf(__('Successfully imported %d currencies', 'yoursite'), $result['imported_count']),
            'imported_count' => $result['imported_count'],
            'errors' => $result['errors'] ?? array()
        ));
    } else {
        wp_send_json_error($result['error']);
    }
}
add_action('wp_ajax_import_currencies_file', 'yoursite_ajax_import_currencies_file');

/**
 * AJAX: Get currency rate history
 */
function yoursite_ajax_get_currency_rate_history() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_code = sanitize_text_field($_POST['currency_code'] ?? '');
    $days = intval($_POST['days'] ?? 30);
    
    if (empty($currency_code)) {
        wp_send_json_error(__('Currency code is required', 'yoursite'));
    }
    
    if ($days < 1 || $days > 365) {
        $days = 30; // Default to 30 days
    }
    
    // Get rate history (if history table exists)
    global $wpdb;
    $history_table = $wpdb->prefix . 'yoursite_currency_rate_history';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$history_table'") === $history_table) {
        $history = $wpdb->get_results($wpdb->prepare(
            "SELECT new_rate as rate, created_at as date 
             FROM $history_table 
             WHERE currency_code = %s 
             AND created_at >= DATE_SUB(NOW(), INTERVAL %d DAY)
             ORDER BY created_at ASC",
            $currency_code,
            $days
        ));
    } else {
        // Fallback to current rate only
        $currency = yoursite_get_currency($currency_code);
        $history = array();
        
        if ($currency) {
            $history[] = (object) array(
                'rate' => $currency['conversion_rate'],
                'date' => $currency['last_updated'] ?: current_time('mysql')
            );
        }
    }
    
    wp_send_json_success(array(
        'currency_code' => $currency_code,
        'days' => $days,
        'history' => $history
    ));
}
add_action('wp_ajax_get_currency_rate_history', 'yoursite_ajax_get_currency_rate_history');

/**
 * AJAX: Update currency format settings
 */
function yoursite_ajax_update_currency_format() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_id = intval($_POST['currency_id'] ?? 0);
    $format_data = array(
        'prefix' => sanitize_text_field($_POST['prefix'] ?? ''),
        'suffix' => sanitize_text_field($_POST['suffix'] ?? ''),
        'decimal_places' => intval($_POST['decimal_places'] ?? 2),
        'decimal_separator' => sanitize_text_field($_POST['decimal_separator'] ?? '.'),
        'thousand_separator' => sanitize_text_field($_POST['thousand_separator'] ?? ','),
        'rounding_mode' => sanitize_text_field($_POST['rounding_mode'] ?? 'nearest'),
        'rounding_precision' => sanitize_text_field($_POST['rounding_precision'] ?? '0.01')
    );
    
    if (!$currency_id) {
        wp_send_json_error(__('Currency ID is required', 'yoursite'));
    }
    
    // Validate data
    if ($format_data['decimal_places'] < 0 || $format_data['decimal_places'] > 8) {
        wp_send_json_error(__('Decimal places must be between 0 and 8', 'yoursite'));
    }
    
    if (!in_array($format_data['rounding_mode'], array('nearest', 'up', 'down', 'none'))) {
        wp_send_json_error(__('Invalid rounding mode', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $result = $wpdb->update(
        $table_name,
        $format_data,
        array('id' => $currency_id),
        array('%s', '%s', '%d', '%s', '%s', '%s', '%s'),
        array('%d')
    );
    
    if ($result !== false) {
        wp_send_json_success(__('Currency format updated successfully', 'yoursite'));
    } else {
        wp_send_json_error(__('Failed to update currency format', 'yoursite'));
    }
}
add_action('wp_ajax_update_currency_format', 'yoursite_ajax_update_currency_format');

/**
 * AJAX: Test currency formatting
 */
function yoursite_ajax_test_currency_format() {
    $currency_code = sanitize_text_field($_POST['currency_code'] ?? '');
    $test_amounts = array(9.99, 1234.56, 1234567.89);
    
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
        'formatted_amounts' => $formatted_amounts
    ));
}
add_action('wp_ajax_test_currency_format', 'yoursite_ajax_test_currency_format');
add_action('wp_ajax_nopriv_test_currency_format', 'yoursite_ajax_test_currency_format');

/**
 * AJAX: Search currencies
 */
function yoursite_ajax_search_currencies() {
    $search_term = sanitize_text_field($_POST['search'] ?? '');
    $filter_status = sanitize_text_field($_POST['status'] ?? '');
    $filter_category = sanitize_text_field($_POST['category'] ?? '');
    $filter_crypto = isset($_POST['crypto_only']) ? 1 : null;
    
    if (strlen($search_term) < 2) {
        wp_send_json_success(array());
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $where_conditions = array("(code LIKE %s OR name LIKE %s)");
    $where_values = array(
        '%' . $wpdb->esc_like($search_term) . '%',
        '%' . $wpdb->esc_like($search_term) . '%'
    );
    
    if (!empty($filter_status)) {
        $where_conditions[] = "status = %s";
        $where_values[] = $filter_status;
    }
    
    if (!empty($filter_category)) {
        $where_conditions[] = "category = %s";
        $where_values[] = $filter_category;
    }
    
    if ($filter_crypto !== null) {
        $where_conditions[] = "is_crypto = %d";
        $where_values[] = $filter_crypto;
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    $query = "SELECT * FROM $table_name WHERE $where_clause ORDER BY code ASC LIMIT 20";
    $results = $wpdb->get_results($wpdb->prepare($query, $where_values));
    
    wp_send_json_success($results);
}
add_action('wp_ajax_search_currencies', 'yoursite_ajax_search_currencies');

/**
 * AJAX: Get currency details
 */
function yoursite_ajax_get_currency_details() {
    $currency_code = sanitize_text_field($_POST['currency_code'] ?? '');
    
    if (empty($currency_code)) {
        wp_send_json_error(__('Currency code is required', 'yoursite'));
    }
    
    $currency = yoursite_get_currency($currency_code);
    
    if (!$currency) {
        wp_send_json_error(__('Currency not found', 'yoursite'));
    }
    
    // Get usage statistics
    global $wpdb;
    $pricing_table = $wpdb->prefix . 'yoursite_pricing_currencies';
    
    $usage_count = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $pricing_table WHERE currency_code = %s",
        $currency_code
    ));
    
    $currency['usage_count'] = intval($usage_count);
    
    // Get recent rate changes
    $history_table = $wpdb->prefix . 'yoursite_currency_rate_history';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$history_table'") === $history_table) {
        $recent_changes = $wpdb->get_results($wpdb->prepare(
            "SELECT new_rate, old_rate, created_at 
             FROM $history_table 
             WHERE currency_code = %s 
             ORDER BY created_at DESC 
             LIMIT 5",
            $currency_code
        ));
        
        $currency['recent_changes'] = $recent_changes;
    }
    
    wp_send_json_success($currency);
}
add_action('wp_ajax_get_currency_details', 'yoursite_ajax_get_currency_details');

/**
 * AJAX: Clone currency
 */
function yoursite_ajax_clone_currency() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $source_currency_id = intval($_POST['source_currency_id'] ?? 0);
    $new_currency_code = strtoupper(sanitize_text_field($_POST['new_currency_code'] ?? ''));
    $new_currency_name = sanitize_text_field($_POST['new_currency_name'] ?? '');
    
    if (!$source_currency_id || empty($new_currency_code) || empty($new_currency_name)) {
        wp_send_json_error(__('Source currency, new code, and new name are required', 'yoursite'));
    }
    
    if (!yoursite_is_currency_available($new_currency_code)) {
        wp_send_json_error(__('Currency code already exists', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    // Get source currency
    $source_currency = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $source_currency_id),
        ARRAY_A
    );
    
    if (!$source_currency) {
        wp_send_json_error(__('Source currency not found', 'yoursite'));
    }
    
    // Prepare new currency data
    unset($source_currency['id']);
    $source_currency['code'] = $new_currency_code;
    $source_currency['name'] = $new_currency_name;
    $source_currency['is_base_currency'] = 0;
    $source_currency['status'] = 'inactive';
    $source_currency['display_order'] = 999;
    $source_currency['created_at'] = current_time('mysql');
    $source_currency['updated_at'] = current_time('mysql');
    
    $result = $wpdb->insert($table_name, $source_currency);
    
    if ($result) {
        wp_send_json_success(array(
            'message' => __('Currency cloned successfully', 'yoursite'),
            'new_currency_id' => $wpdb->insert_id
        ));
    } else {
        wp_send_json_error(__('Failed to clone currency', 'yoursite'));
    }
}
add_action('wp_ajax_clone_currency', 'yoursite_ajax_clone_currency');

/**
 * AJAX: Reset currency to defaults
 */
function yoursite_ajax_reset_currency_to_defaults() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_id = intval($_POST['currency_id'] ?? 0);
    
    if (!$currency_id) {
        wp_send_json_error(__('Currency ID is required', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    // Get current currency
    $currency = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $currency_id)
    );
    
    if (!$currency) {
        wp_send_json_error(__('Currency not found', 'yoursite'));
    }
    
    // Get defaults from library
    $library = yoursite_get_extended_currency_library();
    
    if (!isset($library[$currency->code])) {
        wp_send_json_error(__('No defaults available for this currency', 'yoursite'));
    }
    
    $defaults = $library[$currency->code];
    
    // Reset format settings to defaults
    $reset_data = array(
        'symbol' => $defaults['symbol'],
        'flag' => $defaults['flag'],
        'prefix' => $defaults['prefix'],
        'suffix' => $defaults['suffix'],
        'decimal_places' => $defaults['decimal_places'],
        'decimal_separator' => $defaults['decimal_separator'],
        'thousand_separator' => $defaults['thousand_separator'],
        'rounding_mode' => $defaults['rounding_mode'],
        'rounding_precision' => $defaults['rounding_precision']
    );
    
    $result = $wpdb->update(
        $table_name,
        $reset_data,
        array('id' => $currency_id),
        array('%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s'),
        array('%d')
    );
    
    if ($result !== false) {
        wp_send_json_success(__('Currency reset to defaults successfully', 'yoursite'));
    } else {
        wp_send_json_error(__('Failed to reset currency', 'yoursite'));
    }
}
add_action('wp_ajax_reset_currency_to_defaults', 'yoursite_ajax_reset_currency_to_defaults');

/**
 * AJAX: Generate CSV template
 */
function yoursite_ajax_generate_csv_template() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $template = yoursite_get_csv_template();
    
    wp_send_json_success(array(
        'csv_content' => $template,
        'filename' => 'currency-import-template.csv'
    ));
}
add_action('wp_ajax_generate_csv_template', 'yoursite_ajax_generate_csv_template');

/**
 * AJAX: Cleanup unused currencies
 */
function yoursite_ajax_cleanup_unused_currencies() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $deleted_count = yoursite_cleanup_unused_currencies();
    
    wp_send_json_success(array(
        'message' => sprintf(__('Cleaned up %d unused currencies', 'yoursite'), $deleted_count),
        'deleted_count' => $deleted_count
    ));
}
add_action('wp_ajax_cleanup_unused_currencies', 'yoursite_ajax_cleanup_unused_currencies');

/**
 * AJAX: Currency health check
 */
function yoursite_ajax_currency_health_check() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $health_check = yoursite_currency_health_check();
    wp_send_json_success($health_check);
}
add_action('wp_ajax_currency_health_check', 'yoursite_ajax_currency_health_check');

/**
 * AJAX: Calculate all currency prices
 */
function yoursite_ajax_calculate_all_currency_prices() {
    check_ajax_referer('currency_calculation_nonce', 'nonce');
    
    if (!current_user_can('edit_posts')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $base_price = floatval($_POST['base_price']);
    $base_currency = sanitize_text_field($_POST['base_currency']);
    
    if ($base_price <= 0) {
        wp_send_json_error(__('Invalid base price', 'yoursite'));
    }
    
    $active_currencies = yoursite_get_active_currencies();
    $calculated_prices = array();
    
    foreach ($active_currencies as $currency) {
        $currency_code = $currency['code'];
        
        // Convert monthly price
        $monthly_price = yoursite_convert_price($base_price, $base_currency, $currency_code);
        $annual_price = $monthly_price * 12 * 0.8; // 20% discount
        
        $calculated_prices[$currency_code] = array(
            'monthly' => yoursite_format_currency($monthly_price, $currency_code),
            'annual' => yoursite_format_currency($annual_price, $currency_code),
            'monthly_raw' => number_format($monthly_price, 2),
            'annual_raw' => number_format($annual_price, 2)
        );
    }
    
    wp_send_json_success($calculated_prices);
}
add_action('wp_ajax_calculate_all_currency_prices', 'yoursite_ajax_calculate_all_currency_prices');

/**
 * AJAX: Set base currency
 */
function yoursite_ajax_set_base_currency() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_id = intval($_POST['currency_id']);
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    // Remove base currency flag from all currencies
    $wpdb->update(
        $table_name,
        array('is_base_currency' => 0),
        array(),
        array('%d'),
        array()
    );
    
    // Set new base currency
    $result = $wpdb->update(
        $table_name,
        array('is_base_currency' => 1, 'conversion_rate' => 1.0),
        array('id' => $currency_id),
        array('%d', '%f'),
        array('%d')
    );
    
    if ($result !== false) {
        // Update settings
        $currency = $wpdb->get_row(
            $wpdb->prepare("SELECT code FROM $table_name WHERE id = %d", $currency_id)
        );
        
        if ($currency) {
            $settings = get_option('yoursite_currency_settings', array());
            $settings['base_currency'] = $currency->code;
            update_option('yoursite_currency_settings', $settings);
        }
        
        wp_send_json_success(__('Base currency updated', 'yoursite'));
    } else {
        wp_send_json_error(__('Failed to update base currency', 'yoursite'));
    }
}
add_action('wp_ajax_set_base_currency', 'yoursite_ajax_set_base_currency');

/**
 * AJAX: Update conversion rate
 */
function yoursite_ajax_update_conversion_rate() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_id = intval($_POST['currency_id']);
    $conversion_rate = floatval($_POST['conversion_rate']);
    
    if ($conversion_rate <= 0) {
        wp_send_json_error(__('Invalid conversion rate', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $result = $wpdb->update(
        $table_name,
        array(
            'conversion_rate' => $conversion_rate,
            'last_updated' => current_time('mysql')
        ),
        array('id' => $currency_id),
        array('%f', '%s'),
        array('%d')
    );
    
    if ($result !== false) {
        wp_send_json_success(__('Conversion rate updated', 'yoursite'));
    } else {
        wp_send_json_error(__('Failed to update conversion rate', 'yoursite'));
    }
}
add_action('wp_ajax_update_conversion_rate', 'yoursite_ajax_update_conversion_rate');

/**
 * AJAX: Switch user currency (frontend)
 */
function yoursite_ajax_switch_user_currency() {
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (empty($currency_code)) {
        wp_send_json_error(__('Invalid currency', 'yoursite'));
    }
    
    $currency = yoursite_get_currency($currency_code);
    
    if (!$currency || $currency['status'] !== 'active') {
        wp_send_json_error(__('Currency not available', 'yoursite'));
    }
    
    // Set cookie
    $cookie_name = 'yoursite_preferred_currency';
    $cookie_value = $currency_code;
    $cookie_expire = time() + (30 * DAY_IN_SECONDS); // 30 days
    
    setcookie($cookie_name, $cookie_value, $cookie_expire, COOKIEPATH, COOKIE_DOMAIN);
    
    // Update user meta if logged in
    if (is_user_logged_in()) {
        update_user_meta(get_current_user_id(), 'preferred_currency', $currency_code);
    }
    
    wp_send_json_success(array(
        'currency' => $currency,
        'message' => sprintf(__('Currency switched to %s', 'yoursite'), $currency['name'])
    ));
}
add_action('wp_ajax_switch_user_currency', 'yoursite_ajax_switch_user_currency');
add_action('wp_ajax_nopriv_switch_user_currency', 'yoursite_ajax_switch_user_currency');

/**
 * AJAX: Get currency pricing for plan
 */
function yoursite_ajax_get_currency_pricing() {
    $plan_id = intval($_POST['plan_id'] ?? 0);
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (!$plan_id || !$currency_code) {
        wp_send_json_error(__('Invalid parameters', 'yoursite'));
    }
    
    $monthly_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'monthly');
    $annual_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'annual');
    
    $formatted_monthly = yoursite_format_currency($monthly_price, $currency_code);
    $formatted_annual = yoursite_format_currency($annual_price, $currency_code);
    
    $annual_monthly_equivalent = $annual_price > 0 ? $annual_price / 12 : 0;
    $formatted_annual_monthly = yoursite_format_currency($annual_monthly_equivalent, $currency_code);
    
    $savings = yoursite_calculate_annual_savings($plan_id, $currency_code);
    $formatted_savings = $savings > 0 ? yoursite_format_currency($savings, $currency_code) : '';
    
    $discount_percentage = yoursite_calculate_annual_discount_percentage($plan_id, $currency_code);
    
    wp_send_json_success(array(
        'monthly_price' => $formatted_monthly,
        'annual_price' => $formatted_annual,
        'annual_monthly_equivalent' => $formatted_annual_monthly,
        'savings' => $formatted_savings,
        'discount_percentage' => $discount_percentage,
        'raw_monthly' => $monthly_price,
        'raw_annual' => $annual_price,
        'currency' => yoursite_get_currency($currency_code)
    ));
}
add_action('wp_ajax_get_currency_pricing', 'yoursite_ajax_get_currency_pricing');
add_action('wp_ajax_nopriv_get_currency_pricing', 'yoursite_ajax_get_currency_pricing');

/**
 * AJAX: Get all pricing plans in currency
 */
function yoursite_ajax_get_all_pricing_in_currency() {
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (!$currency_code) {
        wp_send_json_error(__('Invalid currency', 'yoursite'));
    }
    
    $args = array(
        'post_type' => 'pricing',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_key' => '_pricing_monthly_price',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
    );
    
    $plans = get_posts($args);
    $pricing_data = array();
    
    foreach ($plans as $plan) {
        $monthly_price = yoursite_get_pricing_plan_price($plan->ID, $currency_code, 'monthly');
        $annual_price = yoursite_get_pricing_plan_price($plan->ID, $currency_code, 'annual');
        
        $annual_monthly_equivalent = $annual_price > 0 ? $annual_price / 12 : 0;
        $savings = yoursite_calculate_annual_savings($plan->ID, $currency_code);
        $discount_percentage = yoursite_calculate_annual_discount_percentage($plan->ID, $currency_code);
        
        $pricing_data[$plan->ID] = array(
            'monthly_price' => yoursite_format_currency($monthly_price, $currency_code),
            'annual_price' => yoursite_format_currency($annual_price, $currency_code),
            'annual_monthly_equivalent' => yoursite_format_currency($annual_monthly_equivalent, $currency_code),
            'savings' => $savings > 0 ? yoursite_format_currency($savings, $currency_code) : '',
            'discount_percentage' => $discount_percentage,
            'raw_monthly' => $monthly_price,
            'raw_annual' => $annual_price,
            'raw_annual_monthly' => $annual_monthly_equivalent
        );
    }
    
    wp_send_json_success(array(
        'pricing' => $pricing_data,
        'currency' => yoursite_get_currency($currency_code)
    ));
}
add_action('wp_ajax_get_all_pricing_in_currency', 'yoursite_ajax_get_all_pricing_in_currency');
add_action('wp_ajax_nopriv_get_all_pricing_in_currency', 'yoursite_ajax_get_all_pricing_in_currency');

/**
 * AJAX: Validate currency settings
 */
function yoursite_ajax_validate_currency_settings() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $api_provider = sanitize_text_field($_POST['api_provider'] ?? '');
    $api_key = sanitize_text_field($_POST['api_key'] ?? '');
    
    if (empty($api_provider)) {
        wp_send_json_error(__('API provider is required', 'yoursite'));
    }
    
    // Test API connection
    $base_currency = yoursite_get_base_currency();
    
    switch ($api_provider) {
        case 'exchangerate_api':
            $test_rates = yoursite_fetch_from_exchangerate_api($base_currency['code'], $api_key);
            break;
        case 'fixer_io':
            $test_rates = yoursite_fetch_from_fixer_io($base_currency['code'], $api_key);
            break;
        case 'currencylayer':
            $test_rates = yoursite_fetch_from_currencylayer($base_currency['code'], $api_key);
            break;
        case 'openexchangerates':
            $test_rates = yoursite_fetch_from_openexchangerates($base_currency['code'], $api_key);
            break;
        default:
            wp_send_json_error(__('Invalid API provider', 'yoursite'));
    }
    
    if ($test_rates && is_array($test_rates) && count($test_rates) > 10) {
        wp_send_json_success(array(
            'message' => __('API connection successful', 'yoursite'),
            'rate_count' => count($test_rates)
        ));
    } else {
        wp_send_json_error(__('Failed to connect to API or insufficient data returned', 'yoursite'));
    }
}
add_action('wp_ajax_validate_currency_settings', 'yoursite_ajax_validate_currency_settings');

/**
 * AJAX: Export currency data
 */
function yoursite_ajax_export_currency_data() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    global $wpdb;
    
    $currencies_table = $wpdb->prefix . 'yoursite_currencies';
    $pricing_table = $wpdb->prefix . 'yoursite_pricing_currencies';
    
    $currencies = $wpdb->get_results("SELECT * FROM $currencies_table ORDER BY display_order", ARRAY_A);
    $pricing_currencies = $wpdb->get_results("SELECT * FROM $pricing_table", ARRAY_A);
    
    $export_data = array(
        'currencies' => $currencies,
        'pricing_currencies' => $pricing_currencies,
        'settings' => get_option('yoursite_currency_settings', array()),
        'export_date' => current_time('mysql'),
        'version' => '1.0'
    );
    
    wp_send_json_success(array(
        'data' => $export_data,
        'filename' => 'yoursite-currency-data-' . date('Y-m-d-H-i-s') . '.json'
    ));
}
add_action('wp_ajax_export_currency_data', 'yoursite_ajax_export_currency_data');

/**
 * AJAX: Get currency conversion rate
 */
function yoursite_ajax_get_conversion_rate() {
    $from_currency = sanitize_text_field($_POST['from'] ?? '');
    $to_currency = sanitize_text_field($_POST['to'] ?? '');
    
    if (!$from_currency || !$to_currency) {
        wp_send_json_error(__('Invalid currency codes', 'yoursite'));
    }
    
    $rate = yoursite_get_conversion_rate($from_currency, $to_currency);
    
    wp_send_json_success(array(
        'rate' => $rate,
        'from' => $from_currency,
        'to' => $to_currency,
        'formatted_rate' => number_format($rate, 6)
    ));
}
add_action('wp_ajax_get_conversion_rate', 'yoursite_ajax_get_conversion_rate');
add_action('wp_ajax_nopriv_get_conversion_rate', 'yoursite_ajax_get_conversion_rate');

/**
 * AJAX: Toggle currency status
 */
function yoursite_ajax_toggle_currency_status() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_id = intval($_POST['currency_id']);
    $status = sanitize_text_field($_POST['status']);
    
    if (!in_array($status, array('active', 'inactive'))) {
        wp_send_json_error(__('Invalid status', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $result = $wpdb->update(
        $table_name,
        array('status' => $status),
        array('id' => $currency_id),
        array('%s'),
        array('%d')
    );
    
    if ($result !== false) {
        wp_send_json_success(__('Currency status updated', 'yoursite'));
    } else {
        wp_send_json_error(__('Failed to update currency status', 'yoursite'));
    }
}
add_action('wp_ajax_toggle_currency_status', 'yoursite_ajax_toggle_currency_status');

/**
 * AJAX: Delete currency
 */
function yoursite_ajax_delete_currency() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_id = intval($_POST['currency_id']);
    
    global $wpdb;
    $currencies_table = $wpdb->prefix . 'yoursite_currencies';
    $pricing_table = $wpdb->prefix . 'yoursite_pricing_currencies';
    
    // Check if it's a base currency
    $currency = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $currencies_table WHERE id = %d", $currency_id)
    );
    
    if (!$currency) {
        wp_send_json_error(__('Currency not found', 'yoursite'));
    }
    
    if ($currency->is_base_currency) {
        wp_send_json_error(__('Cannot delete base currency', 'yoursite'));
    }
    
    // Delete from pricing currencies first
    $wpdb->delete($pricing_table, array('currency_code' => $currency->code), array('%s'));
    
    // Delete currency
    $result = $wpdb->delete($currencies_table, array('id' => $currency_id), array('%d'));
    
    if ($result !== false) {
        wp_send_json_success(__('Currency deleted successfully', 'yoursite'));
    } else {
        wp_send_json_error(__('Failed to delete currency', 'yoursite'));
    }
}
add_action('wp_ajax_delete_currency', 'yoursite_ajax_delete_currency');

/**
 * AJAX: Toggle all currencies status
 */
function yoursite_ajax_toggle_all_currencies() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $status = sanitize_text_field($_POST['status']);
    
    if (!in_array($status, array('active', 'inactive'))) {
        wp_send_json_error(__('Invalid status', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $result = $wpdb->update(
        $table_name,
        array('status' => $status),
        array(), // No WHERE clause = update all
        array('%s'),
        array()
    );
    
    if ($result !== false) {
        wp_send_json_success(sprintf(__('%d currencies updated', 'yoursite'), $result));
    } else {
        wp_send_json_error(__('Failed to update currencies', 'yoursite'));
    }
}
add_action('wp_ajax_toggle_all_currencies', 'yoursite_ajax_toggle_all_currencies');

/**
 * AJAX: Update currency order
 */
function yoursite_ajax_update_currency_order() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $order = $_POST['order'] ?? '';
    parse_str($order, $data);
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    if (isset($data['currency'])) {
        foreach ($data['currency'] as $position => $currency_id) {
            $wpdb->update(
                $table_name,
                array('display_order' => $position),
                array('id' => intval($currency_id)),
                array('%d'),
                array('%d')
            );
        }
    }
    
    wp_send_json_success(__('Currency order updated', 'yoursite'));
}
add_action('wp_ajax_update_currency_order', 'yoursite_ajax_update_currency_order');

/**
 * AJAX: Convert currency price
 */
function yoursite_ajax_convert_currency_price() {
    check_ajax_referer('currency_conversion_nonce', 'nonce');
    
    if (!current_user_can('edit_posts')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $from_currency = sanitize_text_field($_POST['from_currency']);
    $to_currency = sanitize_text_field($_POST['to_currency']);
    $monthly_price = floatval($_POST['monthly_price']);
    $annual_price = floatval($_POST['annual_price']);
    
    $converted_monthly = 0;
    $converted_annual = 0;
    
    if ($monthly_price > 0) {
        $converted_monthly = yoursite_convert_price($monthly_price, $from_currency, $to_currency);
    }
    
    if ($annual_price > 0) {
        $converted_annual = yoursite_convert_price($annual_price, $from_currency, $to_currency);
    }
    
    wp_send_json_success(array(
        'monthly_price' => number_format($converted_monthly, 2),
        'annual_price' => number_format($converted_annual, 2)
    ));
}
add_action('wp_ajax_convert_currency_price', 'yoursite_ajax_convert_currency_price');

/**
 * AJAX: Refresh single currency rate
 */
function yoursite_ajax_refresh_single_currency_rate() {
    check_ajax_referer('currency_refresh_nonce', 'nonce');
    
    if (!current_user_can('edit_posts')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency = sanitize_text_field($_POST['currency']);
    $updated_count = yoursite_update_specific_currency_rates(array($currency));
    
    if ($updated_count > 0) {
        wp_send_json_success(__('Currency rate updated', 'yoursite'));
    } else {
        wp_send_json_error(__('Failed to update currency rate', 'yoursite'));
    }
}
add_action('wp_ajax_refresh_single_currency_rate', 'yoursite_ajax_refresh_single_currency_rate');

/**
 * AJAX: Bulk currency operations
 */
function yoursite_ajax_bulk_currency_operations() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $operation = sanitize_text_field($_POST['operation'] ?? '');
    $currency_ids = array_map('intval', $_POST['currency_ids'] ?? array());
    
    if (empty($operation) || empty($currency_ids)) {
        wp_send_json_error(__('Invalid operation or currency selection', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $success_count = 0;
    $errors = array();
    
    foreach ($currency_ids as $currency_id) {
        switch ($operation) {
            case 'activate':
                $result = $wpdb->update(
                    $table_name,
                    array('status' => 'active'),
                    array('id' => $currency_id),
                    array('%s'),
                    array('%d')
                );
                break;
                
            case 'deactivate':
                // Check if it's a base currency
                $is_base = $wpdb->get_var(
                    $wpdb->prepare("SELECT is_base_currency FROM $table_name WHERE id = %d", $currency_id)
                );
                
                if ($is_base) {
                    $errors[] = sprintf(__('Cannot deactivate base currency (ID: %d)', 'yoursite'), $currency_id);
                    continue 2;
                }
                
                $result = $wpdb->update(
                    $table_name,
                    array('status' => 'inactive'),
                    array('id' => $currency_id),
                    array('%s'),
                    array('%d')
                );
                break;
                
            case 'delete':
                // Check if it's a base currency
                $currency = $wpdb->get_row(
                    $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $currency_id)
                );
                
                if (!$currency) {
                    $errors[] = sprintf(__('Currency not found (ID: %d)', 'yoursite'), $currency_id);
                    continue 2;
                }
                
                if ($currency->is_base_currency) {
                    $errors[] = sprintf(__('Cannot delete base currency (ID: %d)', 'yoursite'), $currency_id);
                    continue 2;
                }
                
                // Delete from pricing currencies first
                $pricing_table = $wpdb->prefix . 'yoursite_pricing_currencies';
                $wpdb->delete($pricing_table, array('currency_code' => $currency->code), array('%s'));
                
                $result = $wpdb->delete($table_name, array('id' => $currency_id), array('%d'));
                break;
                
            default:
                $errors[] = sprintf(__('Invalid operation: %s', 'yoursite'), $operation);
                continue 2;
        }
        
        if ($result !== false) {
            $success_count++;
        } else {
            $errors[] = sprintf(__('Failed to %s currency (ID: %d)', 'yoursite'), $operation, $currency_id);
        }
    }
    
    $response = array(
        'success_count' => $success_count,
        'total_attempted' => count($currency_ids),
        'errors' => $errors
    );
    
    if ($success_count > 0) {
        $response['message'] = sprintf(__('Successfully processed %d currencies', 'yoursite'), $success_count);
    }
    
    wp_send_json_success($response);
}
add_action('wp_ajax_bulk_currency_operations', 'yoursite_ajax_bulk_currency_operations');

/**
 * AJAX: Get currency statistics
 */
function yoursite_ajax_get_currency_statistics() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    global $wpdb;
    $currencies_table = $wpdb->prefix . 'yoursite_currencies';
    $pricing_table = $wpdb->prefix . 'yoursite_pricing_currencies';
    
    // Get basic stats
    $stats = array(
        'total_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM $currencies_table"),
        'active_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM $currencies_table WHERE status = 'active'"),
        'crypto_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM $currencies_table WHERE is_crypto = 1"),
        'auto_update_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM $currencies_table WHERE auto_update = 1"),
        'stale_rates' => $wpdb->get_var(
            "SELECT COUNT(*) FROM $currencies_table 
             WHERE status = 'active' 
             AND auto_update = 1 
             AND (last_updated IS NULL OR last_updated < DATE_SUB(NOW(), INTERVAL 7 DAY))"
        )
    );
    
    // Get usage stats
    $usage_stats = $wpdb->get_results(
        "SELECT c.code, c.name, COUNT(pc.id) as usage_count
         FROM $currencies_table c
         LEFT JOIN $pricing_table pc ON c.code = pc.currency_code
         WHERE c.status = 'active'
         GROUP BY c.code
         ORDER BY usage_count DESC
         LIMIT 10"
    );
    
    $stats['usage_stats'] = $usage_stats;
    
    // Get categories breakdown
    $category_stats = $wpdb->get_results(
        "SELECT category, COUNT(*) as count
         FROM $currencies_table
         WHERE status = 'active'
         GROUP BY category
         ORDER BY count DESC"
    );
    
    $stats['category_stats'] = $category_stats;
    
    wp_send_json_success($stats);
}
add_action('wp_ajax_get_currency_statistics', 'yoursite_ajax_get_currency_statistics');

/**
 * Helper function to import currencies from JSON content
 */
function yoursite_import_currencies_json($json_content) {
    $data = json_decode($json_content, true);
    
    if (!$data) {
        return array('success' => false, 'error' => __('Invalid JSON format', 'yoursite'));
    }
    
    if (!isset($data['currencies']) || !is_array($data['currencies'])) {
        return array('success' => false, 'error' => __('No currencies found in JSON file', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $imported_count = 0;
    $errors = array();
    
    foreach ($data['currencies'] as $currency_data) {
        // Validate required fields
        if (empty($currency_data['code']) || empty($currency_data['name'])) {
            $errors[] = __('Skipped currency with missing code or name', 'yoursite');
            continue;
        }
        
        // Check if currency already exists
        if (!yoursite_is_currency_available($currency_data['code'])) {
            $errors[] = sprintf(__('Currency %s already exists', 'yoursite'), $currency_data['code']);
            continue;
        }
        
        $result = $wpdb->insert($table_name, $currency_data);
        
        if ($result) {
            $imported_count++;
        } else {
            $errors[] = sprintf(__('Failed to import %s', 'yoursite'), $currency_data['code']);
        }
    }
    
    return array(
        'success' => true,
        'imported_count' => $imported_count,
        'errors' => $errors
    );
}
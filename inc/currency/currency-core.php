<?php
/**
 * Currency Core Functions
 * File: inc/currency/currency-core.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create currency database tables
 */
function yoursite_create_currency_tables() {
    global $wpdb;
    
    $charset_collate = $wpdb->get_charset_collate();
    
    // Main currencies table
    $currencies_table = $wpdb->prefix . 'yoursite_currencies';
    $currencies_sql = "CREATE TABLE $currencies_table (
        id int(11) NOT NULL AUTO_INCREMENT,
        code varchar(10) NOT NULL,
        name varchar(100) NOT NULL,
        symbol varchar(10) NOT NULL,
        flag varchar(10) DEFAULT '',
        prefix varchar(20) DEFAULT '',
        suffix varchar(20) DEFAULT '',
        decimal_places int(2) DEFAULT 2,
        decimal_separator varchar(5) DEFAULT '.',
        thousand_separator varchar(5) DEFAULT ',',
        conversion_rate decimal(15,8) DEFAULT 1.00000000,
        is_base_currency tinyint(1) DEFAULT 0,
        status enum('active','inactive') DEFAULT 'active',
        rounding_mode enum('up','down','nearest','none') DEFAULT 'nearest',
        rounding_precision varchar(10) DEFAULT '0.01',
        auto_update tinyint(1) DEFAULT 0,
        last_updated datetime DEFAULT CURRENT_TIMESTAMP,
        display_order int(11) DEFAULT 0,
        is_crypto tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY code (code),
        KEY status (status),
        KEY display_order (display_order)
    ) $charset_collate;";
    
    // Pricing plans currencies table
    $pricing_currencies_table = $wpdb->prefix . 'yoursite_pricing_currencies';
    $pricing_currencies_sql = "CREATE TABLE $pricing_currencies_table (
        id int(11) NOT NULL AUTO_INCREMENT,
        pricing_plan_id int(11) NOT NULL,
        currency_code varchar(10) NOT NULL,
        monthly_price decimal(15,2) DEFAULT NULL,
        annual_price decimal(15,2) DEFAULT NULL,
        button_url varchar(500) DEFAULT '',
        is_auto_converted tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY plan_currency (pricing_plan_id, currency_code),
        KEY pricing_plan_id (pricing_plan_id),
        KEY currency_code (currency_code)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($currencies_sql);
    dbDelta($pricing_currencies_sql);
}

/**
 * Get all default world currencies with comprehensive data
 */
function yoursite_get_default_currencies() {
    return array(
        'USD' => array(
            'name' => 'US Dollar',
            'symbol' => '$',
            'flag' => '🇺🇸',
            'prefix' => '$',
            'suffix' => '',
            'decimal_places' => 2,
            'is_base_currency' => 1,
            'status' => 'active',
            'display_order' => 1
        ),
        'EUR' => array(
            'name' => 'Euro',
            'symbol' => '€',
            'flag' => '🇪🇺',
            'prefix' => '€',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'active',
            'display_order' => 2
        ),
        'GBP' => array(
            'name' => 'British Pound',
            'symbol' => '£',
            'flag' => '🇬🇧',
            'prefix' => '£',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'active',
            'display_order' => 3
        ),
        'JPY' => array(
            'name' => 'Japanese Yen',
            'symbol' => '¥',
            'flag' => '🇯🇵',
            'prefix' => '¥',
            'suffix' => '',
            'decimal_places' => 0,
            'status' => 'inactive',
            'display_order' => 4
        ),
        'CAD' => array(
            'name' => 'Canadian Dollar',
            'symbol' => 'C$',
            'flag' => '🇨🇦',
            'prefix' => 'C$',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 5
        ),
        'AUD' => array(
            'name' => 'Australian Dollar',
            'symbol' => 'A$',
            'flag' => '🇦🇺',
            'prefix' => 'A$',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 6
        ),
        'CHF' => array(
            'name' => 'Swiss Franc',
            'symbol' => 'CHF',
            'flag' => '🇨🇭',
            'prefix' => 'CHF ',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 7
        ),
        'CNY' => array(
            'name' => 'Chinese Yuan',
            'symbol' => '¥',
            'flag' => '🇨🇳',
            'prefix' => '¥',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 8
        ),
        'SEK' => array(
            'name' => 'Swedish Krona',
            'symbol' => 'kr',
            'flag' => '🇸🇪',
            'prefix' => '',
            'suffix' => ' kr',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 9
        ),
        'NOK' => array(
            'name' => 'Norwegian Krone',
            'symbol' => 'kr',
            'flag' => '🇳🇴',
            'prefix' => '',
            'suffix' => ' kr',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 10
        ),
        'DKK' => array(
            'name' => 'Danish Krone',
            'symbol' => 'kr.',
            'flag' => '🇩🇰',
            'prefix' => '',
            'suffix' => ' kr.',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 11
        ),
        'PLN' => array(
            'name' => 'Polish Złoty',
            'symbol' => 'zł',
            'flag' => '🇵🇱',
            'prefix' => '',
            'suffix' => ' zł',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 12
        ),
        'INR' => array(
            'name' => 'Indian Rupee',
            'symbol' => '₹',
            'flag' => '🇮🇳',
            'prefix' => '₹',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 13
        ),
        'BRL' => array(
            'name' => 'Brazilian Real',
            'symbol' => 'R$',
            'flag' => '🇧🇷',
            'prefix' => 'R$ ',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 14
        ),
        'RUB' => array(
            'name' => 'Russian Ruble',
            'symbol' => '₽',
            'flag' => '🇷🇺',
            'prefix' => '',
            'suffix' => ' ₽',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 15
        ),
        'KRW' => array(
            'name' => 'South Korean Won',
            'symbol' => '₩',
            'flag' => '🇰🇷',
            'prefix' => '₩',
            'suffix' => '',
            'decimal_places' => 0,
            'status' => 'inactive',
            'display_order' => 16
        ),
        'MXN' => array(
            'name' => 'Mexican Peso',
            'symbol' => '$',
            'flag' => '🇲🇽',
            'prefix' => '$',
            'suffix' => ' MXN',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 17
        ),
        'SGD' => array(
            'name' => 'Singapore Dollar',
            'symbol' => 'S$',
            'flag' => '🇸🇬',
            'prefix' => 'S$',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 18
        ),
        'NZD' => array(
            'name' => 'New Zealand Dollar',
            'symbol' => 'NZ$',
            'flag' => '🇳🇿',
            'prefix' => 'NZ$',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 19
        ),
        'HKD' => array(
            'name' => 'Hong Kong Dollar',
            'symbol' => 'HK$',
            'flag' => '🇭🇰',
            'prefix' => 'HK$',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 20
        ),
        // Popular cryptocurrencies
        'BTC' => array(
            'name' => 'Bitcoin',
            'symbol' => '₿',
            'flag' => '₿',
            'prefix' => '₿',
            'suffix' => '',
            'decimal_places' => 8,
            'status' => 'inactive',
            'is_crypto' => 1,
            'display_order' => 101
        ),
        'ETH' => array(
            'name' => 'Ethereum',
            'symbol' => 'Ξ',
            'flag' => 'Ξ',
            'prefix' => 'Ξ',
            'suffix' => '',
            'decimal_places' => 6,
            'status' => 'inactive',
            'is_crypto' => 1,
            'display_order' => 102
        ),
        'USDC' => array(
            'name' => 'USD Coin',
            'symbol' => 'USDC',
            'flag' => '💰',
            'prefix' => '',
            'suffix' => ' USDC',
            'decimal_places' => 2,
            'status' => 'inactive',
            'is_crypto' => 1,
            'display_order' => 103
        )
    );
}

/**
 * Populate database with default currencies
 */
function yoursite_populate_default_currencies() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $currencies = yoursite_get_default_currencies();
    
    foreach ($currencies as $code => $currency) {
        $wpdb->insert(
            $table_name,
            array_merge(array('code' => $code), $currency),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%f', '%d', '%s', '%s', '%s', '%d', '%s', '%d', '%d', '%d')
        );
    }
}

/**
 * Initialize default currency settings
 */
function yoursite_initialize_currency_settings() {
    $default_settings = array(
        'base_currency' => 'USD',
        'auto_update_enabled' => false,
        'update_frequency' => 'daily',
        'api_provider' => 'exchangerate_api',
        'api_key' => '',
        'fallback_rates' => array(),
        'display_currency_selector' => true,
        'remember_user_choice' => true,
        'geolocation_detection' => false,
        'default_rounding_mode' => 'nearest',
        'show_original_price' => false
    );
    
    update_option('yoursite_currency_settings', $default_settings);
}

/**
 * Get all active currencies
 */
function yoursite_get_active_currencies() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $currencies = $wpdb->get_results(
        "SELECT * FROM $table_name WHERE status = 'active' ORDER BY display_order ASC, code ASC",
        ARRAY_A
    );
    
    if (empty($currencies)) {
        // Fallback to USD if no currencies found
        return array(
            array(
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'prefix' => '$',
                'suffix' => '',
                'conversion_rate' => 1.0,
                'is_base_currency' => 1
            )
        );
    }
    
    return $currencies;
}

/**
 * Get specific currency by code
 */
function yoursite_get_currency($code) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    return $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE code = %s", $code),
        ARRAY_A
    );
}

/**
 * Get base currency
 */
function yoursite_get_base_currency() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $base_currency = $wpdb->get_row(
        "SELECT * FROM $table_name WHERE is_base_currency = 1 AND status = 'active'",
        ARRAY_A
    );
    
    if (!$base_currency) {
        // Fallback to USD
        return array(
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'prefix' => '$',
            'suffix' => '',
            'conversion_rate' => 1.0,
            'is_base_currency' => 1
        );
    }
    
    return $base_currency;
}

/**
 * Update currency conversion rates
 */
function yoursite_update_currency_rates($rates_data = null) {
    global $wpdb;
    
    if (!$rates_data) {
        $rates_data = yoursite_fetch_exchange_rates();
    }
    
    if (!$rates_data || !is_array($rates_data)) {
        return false;
    }
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $updated_count = 0;
    
    foreach ($rates_data as $currency_code => $rate) {
        $result = $wpdb->update(
            $table_name,
            array(
                'conversion_rate' => $rate,
                'last_updated' => current_time('mysql')
            ),
            array('code' => $currency_code),
            array('%f', '%s'),
            array('%s')
        );
        
        if ($result !== false) {
            $updated_count++;
        }
    }
    
    // Update last refresh time
    update_option('yoursite_currency_last_update', current_time('mysql'));
    
    return $updated_count;
}

/**
 * Get user's preferred currency
 */
function yoursite_get_user_currency() {
    // Check session/cookie first
    if (isset($_COOKIE['yoursite_currency'])) {
        $currency_code = sanitize_text_field($_COOKIE['yoursite_currency']);
        $currency = yoursite_get_currency($currency_code);
        if ($currency && $currency['status'] === 'active') {
            return $currency;
        }
    }
    
    // Check if user is logged in and has preference
    if (is_user_logged_in()) {
        $user_currency = get_user_meta(get_current_user_id(), 'preferred_currency', true);
        if ($user_currency) {
            $currency = yoursite_get_currency($user_currency);
            if ($currency && $currency['status'] === 'active') {
                return $currency;
            }
        }
    }
    
    // Geolocation detection (if enabled)
    $settings = get_option('yoursite_currency_settings', array());
    if (!empty($settings['geolocation_detection'])) {
        $detected_currency = yoursite_detect_currency_by_location();
        if ($detected_currency) {
            return $detected_currency;
        }
    }
    
    // Fallback to base currency
    return yoursite_get_base_currency();
}

/**
 * Convert price between currencies
 */
function yoursite_convert_price($amount, $from_currency, $to_currency) {
    if ($from_currency === $to_currency) {
        return $amount;
    }
    
    $from_curr = yoursite_get_currency($from_currency);
    $to_curr = yoursite_get_currency($to_currency);
    
    if (!$from_curr || !$to_curr) {
        return $amount;
    }
    
    // Convert to base currency first, then to target currency
    $base_amount = $amount / $from_curr['conversion_rate'];
    $converted_amount = $base_amount * $to_curr['conversion_rate'];
    
    // Apply rounding
    return yoursite_apply_currency_rounding($converted_amount, $to_curr);
}

/**
 * Apply currency-specific rounding
 */
function yoursite_apply_currency_rounding($amount, $currency) {
    $rounding_mode = $currency['rounding_mode'] ?? 'nearest';
    $precision = $currency['rounding_precision'] ?? '0.01';
    
    if ($rounding_mode === 'none') {
        return round($amount, $currency['decimal_places']);
    }
    
    $precision_value = floatval($precision);
    
    switch ($rounding_mode) {
        case 'up':
            return ceil($amount / $precision_value) * $precision_value;
        case 'down':
            return floor($amount / $precision_value) * $precision_value;
        case 'nearest':
        default:
            return round($amount / $precision_value) * $precision_value;
    }
}

/**
 * Format price according to currency settings
 */
function yoursite_format_currency($amount, $currency_code = null) {
    if (!$currency_code) {
        $currency = yoursite_get_user_currency();
    } else {
        $currency = yoursite_get_currency($currency_code);
    }
    
    if (!$currency) {
        return number_format($amount, 2);
    }
    
    // Apply rounding
    $amount = yoursite_apply_currency_rounding($amount, $currency);
    
    // Format number
    $formatted = number_format(
        $amount,
        $currency['decimal_places'],
        $currency['decimal_separator'],
        $currency['thousand_separator']
    );
    
    // Add prefix and suffix
    return $currency['prefix'] . $formatted . $currency['suffix'];
}

/**
 * Simple geolocation currency detection
 */
function yoursite_detect_currency_by_location() {
    // Simple IP to country detection (you can integrate with a service)
    $country_currency_map = array(
        'US' => 'USD',
        'CA' => 'CAD',
        'GB' => 'GBP',
        'AU' => 'AUD',
        'DE' => 'EUR',
        'FR' => 'EUR',
        'IT' => 'EUR',
        'ES' => 'EUR',
        'NL' => 'EUR',
        'JP' => 'JPY',
        'CN' => 'CNY',
        'IN' => 'INR',
        'BR' => 'BRL',
        'SE' => 'SEK',
        'NO' => 'NOK',
        'DK' => 'DKK'
    );
    
    // This is a basic implementation - you can enhance with actual IP geolocation
    $user_ip = $_SERVER['REMOTE_ADDR'] ?? '';
    
    // For demo purposes, return based on browser language
    $browser_language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en', 0, 2);
    
    $language_currency_map = array(
        'en' => 'USD',
        'de' => 'EUR',
        'fr' => 'EUR',
        'es' => 'EUR',
        'it' => 'EUR',
        'ja' => 'JPY',
        'zh' => 'CNY',
        'sv' => 'SEK',
        'no' => 'NOK',
        'da' => 'DKK'
    );
    
    $detected_currency_code = $language_currency_map[$browser_language] ?? 'USD';
    
    return yoursite_get_currency($detected_currency_code);
}
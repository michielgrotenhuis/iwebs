<?php
/**
 * Custom Currency Management System
 * File: inc/currency/currency-custom.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get extended currency library with all world currencies and cryptocurrencies
 */
function yoursite_get_extended_currency_library() {
    return array(
        // Major World Currencies
        'USD' => array(
            'name' => 'US Dollar',
            'symbol' => '$',
            'flag' => '🇺🇸',
            'prefix' => '$',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 1.0,
            'is_base_currency' => 1,
            'status' => 'active',
            'auto_update' => 0,
            'is_crypto' => 0,
            'display_order' => 1,
            'category' => 'major',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'EUR' => array(
            'name' => 'Euro',
            'symbol' => '€',
            'flag' => '🇪🇺',
            'prefix' => '€',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 0.85,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 2,
            'category' => 'major',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'GBP' => array(
            'name' => 'British Pound Sterling',
            'symbol' => '£',
            'flag' => '🇬🇧',
            'prefix' => '£',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 0.73,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 3,
            'category' => 'major',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'JPY' => array(
            'name' => 'Japanese Yen',
            'symbol' => '¥',
            'flag' => '🇯🇵',
            'prefix' => '¥',
            'suffix' => '',
            'decimal_places' => 0,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 110.0,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 4,
            'category' => 'major',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '1.00'
        ),
        'CHF' => array(
            'name' => 'Swiss Franc',
            'symbol' => 'CHF',
            'flag' => '🇨🇭',
            'prefix' => 'CHF ',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 0.92,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 5,
            'category' => 'major',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.05'
        ),
        
        // North America
        'CAD' => array(
            'name' => 'Canadian Dollar',
            'symbol' => 'C$',
            'flag' => '🇨🇦',
            'prefix' => 'C$',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 1.25,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 10,
            'category' => 'north_america',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.05'
        ),
        'MXN' => array(
            'name' => 'Mexican Peso',
            'symbol' => '$',
            'flag' => '🇲🇽',
            'prefix' => '$',
            'suffix' => ' MXN',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 20.10,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 11,
            'category' => 'north_america',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        
        // Asia Pacific
        'AUD' => array(
            'name' => 'Australian Dollar',
            'symbol' => 'A$',
            'flag' => '🇦🇺',
            'prefix' => 'A$',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 1.35,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 20,
            'category' => 'asia_pacific',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.05'
        ),
        'CNY' => array(
            'name' => 'Chinese Yuan Renminbi',
            'symbol' => '¥',
            'flag' => '🇨🇳',
            'prefix' => '¥',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 6.45,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 21,
            'category' => 'asia_pacific',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'INR' => array(
            'name' => 'Indian Rupee',
            'symbol' => '₹',
            'flag' => '🇮🇳',
            'prefix' => '₹',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 74.50,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 22,
            'category' => 'asia_pacific',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'KRW' => array(
            'name' => 'South Korean Won',
            'symbol' => '₩',
            'flag' => '🇰🇷',
            'prefix' => '₩',
            'suffix' => '',
            'decimal_places' => 0,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 1180.0,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 23,
            'category' => 'asia_pacific',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '1.00'
        ),
        'SGD' => array(
            'name' => 'Singapore Dollar',
            'symbol' => 'S$',
            'flag' => '🇸🇬',
            'prefix' => 'S$',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 1.35,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 24,
            'category' => 'asia_pacific',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'HKD' => array(
            'name' => 'Hong Kong Dollar',
            'symbol' => 'HK$',
            'flag' => '🇭🇰',
            'prefix' => 'HK$',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 7.80,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 25,
            'category' => 'asia_pacific',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'NZD' => array(
            'name' => 'New Zealand Dollar',
            'symbol' => 'NZ$',
            'flag' => '🇳🇿',
            'prefix' => 'NZ$',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 1.42,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 26,
            'category' => 'asia_pacific',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        
        // Nordic Countries
        'SEK' => array(
            'name' => 'Swedish Krona',
            'symbol' => 'kr',
            'flag' => '🇸🇪',
            'prefix' => '',
            'suffix' => ' kr',
            'decimal_places' => 2,
            'decimal_separator' => ',',
            'thousand_separator' => ' ',
            'conversion_rate' => 8.60,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 30,
            'category' => 'nordic',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'NOK' => array(
            'name' => 'Norwegian Krone',
            'symbol' => 'kr',
            'flag' => '🇳🇴',
            'prefix' => '',
            'suffix' => ' kr',
            'decimal_places' => 2,
            'decimal_separator' => ',',
            'thousand_separator' => ' ',
            'conversion_rate' => 8.50,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 31,
            'category' => 'nordic',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'DKK' => array(
            'name' => 'Danish Krone',
            'symbol' => 'kr.',
            'flag' => '🇩🇰',
            'prefix' => '',
            'suffix' => ' kr.',
            'decimal_places' => 2,
            'decimal_separator' => ',',
            'thousand_separator' => '.',
            'conversion_rate' => 6.35,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 32,
            'category' => 'nordic',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        
        // Eastern Europe
        'PLN' => array(
            'name' => 'Polish Złoty',
            'symbol' => 'zł',
            'flag' => '🇵🇱',
            'prefix' => '',
            'suffix' => ' zł',
            'decimal_places' => 2,
            'decimal_separator' => ',',
            'thousand_separator' => ' ',
            'conversion_rate' => 3.90,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 40,
            'category' => 'eastern_europe',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'CZK' => array(
            'name' => 'Czech Koruna',
            'symbol' => 'Kč',
            'flag' => '🇨🇿',
            'prefix' => '',
            'suffix' => ' Kč',
            'decimal_places' => 2,
            'decimal_separator' => ',',
            'thousand_separator' => ' ',
            'conversion_rate' => 21.50,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 41,
            'category' => 'eastern_europe',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'RUB' => array(
            'name' => 'Russian Ruble',
            'symbol' => '₽',
            'flag' => '🇷🇺',
            'prefix' => '',
            'suffix' => ' ₽',
            'decimal_places' => 2,
            'decimal_separator' => ',',
            'thousand_separator' => ' ',
            'conversion_rate' => 73.50,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 42,
            'category' => 'eastern_europe',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        
        // South America
        'BRL' => array(
            'name' => 'Brazilian Real',
            'symbol' => 'R$',
            'flag' => '🇧🇷',
            'prefix' => 'R$ ',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => ',',
            'thousand_separator' => '.',
            'conversion_rate' => 5.20,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 50,
            'category' => 'south_america',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'ARS' => array(
            'name' => 'Argentine Peso',
            'symbol' => '$',
            'flag' => '🇦🇷',
            'prefix' => '$',
            'suffix' => ' ARS',
            'decimal_places' => 2,
            'decimal_separator' => ',',
            'thousand_separator' => '.',
            'conversion_rate' => 98.50,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 51,
            'category' => 'south_america',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        
        // Middle East & Africa
        'AED' => array(
            'name' => 'UAE Dirham',
            'symbol' => 'د.إ',
            'flag' => '🇦🇪',
            'prefix' => '',
            'suffix' => ' د.إ',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 3.67,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 60,
            'category' => 'middle_east_africa',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'SAR' => array(
            'name' => 'Saudi Riyal',
            'symbol' => '﷼',
            'flag' => '🇸🇦',
            'prefix' => '',
            'suffix' => ' ﷼',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 3.75,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 61,
            'category' => 'middle_east_africa',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        'ZAR' => array(
            'name' => 'South African Rand',
            'symbol' => 'R',
            'flag' => '🇿🇦',
            'prefix' => 'R ',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 14.50,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 0,
            'display_order' => 62,
            'category' => 'middle_east_africa',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01'
        ),
        
        // Cryptocurrencies
        'BTC' => array(
            'name' => 'Bitcoin',
            'symbol' => '₿',
            'flag' => '₿',
            'prefix' => '₿',
            'suffix' => '',
            'decimal_places' => 8,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 0.000025,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 1,
            'display_order' => 100,
            'category' => 'cryptocurrency',
            'rounding_mode' => 'none',
            'rounding_precision' => '0.00000001',
            'api_id' => 'bitcoin'
        ),
        'ETH' => array(
            'name' => 'Ethereum',
            'symbol' => 'Ξ',
            'flag' => 'Ξ',
            'prefix' => 'Ξ',
            'suffix' => '',
            'decimal_places' => 6,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 0.0004,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 1,
            'display_order' => 101,
            'category' => 'cryptocurrency',
            'rounding_mode' => 'none',
            'rounding_precision' => '0.000001',
            'api_id' => 'ethereum'
        ),
        'USDT' => array(
            'name' => 'Tether',
            'symbol' => 'USDT',
            'flag' => '💰',
            'prefix' => '',
            'suffix' => ' USDT',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 1.0,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 1,
            'display_order' => 102,
            'category' => 'cryptocurrency',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01',
            'api_id' => 'tether'
        ),
        'USDC' => array(
            'name' => 'USD Coin',
            'symbol' => 'USDC',
            'flag' => '💰',
            'prefix' => '',
            'suffix' => ' USDC',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 1.0,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 1,
            'display_order' => 103,
            'category' => 'cryptocurrency',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01',
            'api_id' => 'usd-coin'
        ),
        'BNB' => array(
            'name' => 'Binance Coin',
            'symbol' => 'BNB',
            'flag' => '🔶',
            'prefix' => '',
            'suffix' => ' BNB',
            'decimal_places' => 4,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 0.003,
            'is_base_currency' => 0,
            'status' => 'inactive',
            'auto_update' => 1,
            'is_crypto' => 1,
            'display_order' => 104,
            'category' => 'cryptocurrency',
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.0001',
            'api_id' => 'binancecoin'
        )
    );
}

/**
 * Get currency categories for organization
 */
function yoursite_get_currency_categories() {
    return array(
        'major' => __('Major World Currencies', 'yoursite'),
        'north_america' => __('North America', 'yoursite'),
        'asia_pacific' => __('Asia Pacific', 'yoursite'),
        'nordic' => __('Nordic Countries', 'yoursite'),
        'eastern_europe' => __('Eastern Europe', 'yoursite'),
        'south_america' => __('South America', 'yoursite'),
        'middle_east_africa' => __('Middle East & Africa', 'yoursite'),
        'cryptocurrency' => __('Cryptocurrencies', 'yoursite'),
        'custom' => __('Custom Currencies', 'yoursite')
    );
}

/**
 * Get all installed currencies from database
 */
function yoursite_get_installed_currencies() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $currencies = $wpdb->get_results(
        "SELECT * FROM $table_name ORDER BY display_order ASC, code ASC",
        ARRAY_A
    );
    
    $installed = array();
    foreach ($currencies as $currency) {
        $installed[$currency['code']] = $currency;
    }
    
    return $installed;
}

/**
 * Check if currency code is available
 */
function yoursite_is_currency_available($code) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $exists = $wpdb->get_var(
        $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE code = %s", strtoupper($code))
    );
    
    return $exists == 0;
}

/**
 * Validate custom currency data
 */
function yoursite_validate_currency_data($data) {
    $errors = array();
    
    // Required fields
    if (empty($data['code'])) {
        $errors[] = __('Currency code is required', 'yoursite');
    } elseif (!preg_match('/^[A-Z0-9]{3,10}$/', $data['code'])) {
        $errors[] = __('Currency code must be 3-10 uppercase letters/numbers', 'yoursite');
    } elseif (!yoursite_is_currency_available($data['code'])) {
        $errors[] = __('Currency code already exists', 'yoursite');
    }
    
    if (empty($data['name'])) {
        $errors[] = __('Currency name is required', 'yoursite');
    }
    
    // Numeric validations
    if (isset($data['decimal_places'])) {
        $decimal_places = intval($data['decimal_places']);
        if ($decimal_places < 0 || $decimal_places > 8) {
            $errors[] = __('Decimal places must be between 0 and 8', 'yoursite');
        }
    }
    
    if (isset($data['conversion_rate'])) {
        $rate = floatval($data['conversion_rate']);
        if ($rate <= 0) {
            $errors[] = __('Conversion rate must be greater than 0', 'yoursite');
        }
    }
    
    // String length validations
    if (isset($data['prefix']) && strlen($data['prefix']) > 20) {
        $errors[] = __('Prefix cannot exceed 20 characters', 'yoursite');
    }
    
    if (isset($data['suffix']) && strlen($data['suffix']) > 20) {
        $errors[] = __('Suffix cannot exceed 20 characters', 'yoursite');
    }
    
    return $errors;
}

/**
 * Install currency from library
 */
function yoursite_install_currency($currency_code) {
    $library = yoursite_get_extended_currency_library();
    
    if (!isset($library[$currency_code])) {
        return array('success' => false, 'error' => __('Currency not found in library', 'yoursite'));
    }
    
    if (!yoursite_is_currency_available($currency_code)) {
        return array('success' => false, 'error' => __('Currency already installed', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $currency_data = array_merge(array('code' => $currency_code), $library[$currency_code]);
    
    $result = $wpdb->insert($table_name, $currency_data);
    
    if ($result) {
        return array('success' => true, 'message' => __('Currency installed successfully', 'yoursite'));
    } else {
        return array('success' => false, 'error' => __('Failed to install currency', 'yoursite'));
    }
}

/**
 * Create custom currency
 */
function yoursite_create_custom_currency($data) {
    // Validate data
    $errors = yoursite_validate_currency_data($data);
    if (!empty($errors)) {
        return array('success' => false, 'errors' => $errors);
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    // Prepare currency data with defaults
    $currency_data = array(
        'code' => strtoupper(sanitize_text_field($data['code'])),
        'name' => sanitize_text_field($data['name']),
        'symbol' => sanitize_text_field($data['symbol'] ?? ''),
        'flag' => sanitize_text_field($data['flag'] ?? ''),
        'prefix' => sanitize_text_field($data['prefix'] ?? ''),
        'suffix' => sanitize_text_field($data['suffix'] ?? ''),
        'decimal_places' => intval($data['decimal_places'] ?? 2),
        'decimal_separator' => sanitize_text_field($data['decimal_separator'] ?? '.'),
        'thousand_separator' => sanitize_text_field($data['thousand_separator'] ?? ','),
        'conversion_rate' => floatval($data['conversion_rate'] ?? 1.0),
        'rounding_mode' => sanitize_text_field($data['rounding_mode'] ?? 'nearest'),
        'rounding_precision' => sanitize_text_field($data['rounding_precision'] ?? '0.01'),
        'auto_update' => isset($data['auto_update']) ? 1 : 0,
        'is_crypto' => isset($data['is_crypto']) ? 1 : 0,
        'is_base_currency' => 0,
        'status' => 'active',
        'category' => 'custom',
        'display_order' => 999
    );
    
    // Add crypto API ID if provided
    if ($currency_data['is_crypto'] && !empty($data['api_id'])) {
        $currency_data['api_id'] = sanitize_text_field($data['api_id']);
    }
    
    $result = $wpdb->insert($table_name, $currency_data);
    
    if ($result) {
        return array('success' => true, 'message' => __('Custom currency created successfully', 'yoursite'));
    } else {
        return array('success' => false, 'error' => __('Failed to create custom currency', 'yoursite'));
    }
}

/**
 * Get currency presets for bulk import
 */
function yoursite_get_currency_presets() {
    return array(
        'major_currencies' => array(
            'name' => __('Major World Currencies', 'yoursite'),
            'currencies' => array('USD', 'EUR', 'GBP', 'JPY', 'CHF'),
            'description' => __('The most commonly used world currencies', 'yoursite')
        ),
        'european_currencies' => array(
            'name' => __('European Currencies', 'yoursite'),
            'currencies' => array('EUR', 'GBP', 'CHF', 'SEK', 'NOK', 'DKK', 'PLN', 'CZK'),
            'description' => __('European region currencies', 'yoursite')
        ),
        'asia_pacific' => array(
            'name' => __('Asia Pacific', 'yoursite'),
            'currencies' => array('AUD', 'CNY', 'INR', 'KRW', 'SGD', 'HKD', 'NZD'),
            'description' => __('Asia Pacific region currencies', 'yoursite')
        ),
        'north_america' => array(
            'name' => __('North America', 'yoursite'),
            'currencies' => array('USD', 'CAD', 'MXN'),
            'description' => __('North American currencies', 'yoursite')
        ),
        'crypto_top_5' => array(
            'name' => __('Top 5 Cryptocurrencies', 'yoursite'),
            'currencies' => array('BTC', 'ETH', 'USDT', 'USDC', 'BNB'),
            'description' => __('Most popular cryptocurrencies', 'yoursite')
        ),
        'stable_coins' => array(
            'name' => __('Stable Coins', 'yoursite'),
            'currencies' => array('USDT', 'USDC'),
            'description' => __('USD-pegged stable cryptocurrencies', 'yoursite')
        )
    );
}

/**
 * Import currency preset
 */
function yoursite_import_currency_preset($preset_name) {
    $presets = yoursite_get_currency_presets();
    
    if (!isset($presets[$preset_name])) {
        return array('success' => false, 'error' => __('Invalid preset', 'yoursite'));
    }
    
    $preset = $presets[$preset_name];
    $library = yoursite_get_extended_currency_library();
    $imported_count = 0;
    $errors = array();
    
    foreach ($preset['currencies'] as $currency_code) {
        if (!isset($library[$currency_code])) {
            $errors[] = sprintf(__('Currency %s not found in library', 'yoursite'), $currency_code);
            continue;
        }
        
        $result = yoursite_install_currency($currency_code);
        if ($result['success']) {
            $imported_count++;
        } else {
            $errors[] = sprintf(__('%s: %s', 'yoursite'), $currency_code, $result['error']);
        }
    }
    
    return array(
        'success' => true,
        'imported_count' => $imported_count,
        'errors' => $errors
    );
}

/**
 * Import currencies from CSV data
 */
function yoursite_import_currencies_from_csv($csv_data) {
    $lines = explode("\n", $csv_data);
    if (empty($lines)) {
        return array('success' => false, 'error' => __('Empty CSV data', 'yoursite'));
    }
    
    // Get headers from first line
    $headers = str_getcsv(array_shift($lines));
    $required_fields = array('code', 'name');
    
    foreach ($required_fields as $field) {
        if (!in_array($field, $headers)) {
            return array('success' => false, 'error' => sprintf(__('Missing required field: %s', 'yoursite'), $field));
        }
    }
    
    $imported_count = 0;
    $errors = array();
    
    foreach ($lines as $line_number => $line) {
        $line = trim($line);
        if (empty($line)) continue;
        
        $data = str_getcsv($line);
        if (count($data) !== count($headers)) {
            $errors[] = sprintf(__('Line %d: Invalid CSV format', 'yoursite'), $line_number + 2);
            continue;
        }
        
        $currency_data = array_combine($headers, $data);
        
        // Set defaults for missing fields
        $defaults = array(
            'symbol' => '',
            'flag' => '',
            'prefix' => '',
            'suffix' => '',
            'decimal_places' => 2,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 1.0,
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01',
            'is_crypto' => 0
        );
        
        $currency_data = array_merge($defaults, $currency_data);
        
        $result = yoursite_create_custom_currency($currency_data);
        if ($result['success']) {
            $imported_count++;
        } else {
            $error_msg = isset($result['errors']) ? implode(', ', $result['errors']) : $result['error'];
            $errors[] = sprintf(__('Line %d (%s): %s', 'yoursite'), $line_number + 2, $currency_data['code'], $error_msg);
        }
    }
    
    return array(
        'success' => true,
        'imported_count' => $imported_count,
        'errors' => $errors
    );
}

/**
 * Enhanced crypto rate fetching
 */
function yoursite_fetch_crypto_rates_advanced() {
    $crypto_currencies = array('BTC', 'ETH', 'USDT', 'USDC', 'BNB');
    
    // Try CoinGecko API first
    $rates = yoursite_fetch_coingecko_rates($crypto_currencies);
    if ($rates) {
        return $rates;
    }
    
    // Fallback to static rates
    return yoursite_get_fallback_crypto_rates();
}

/**
 * Fetch rates from CoinGecko
 */
function yoursite_fetch_coingecko_rates($currencies) {
    $crypto_map = array(
        'BTC' => 'bitcoin',
        'ETH' => 'ethereum',
        'USDT' => 'tether',
        'USDC' => 'usd-coin',
        'BNB' => 'binancecoin'
    );
    
    $ids = array();
    foreach ($currencies as $code) {
        if (isset($crypto_map[$code])) {
            $ids[] = $crypto_map[$code];
        }
    }
    
    if (empty($ids)) {
        return false;
    }
    
    $url = 'https://api.coingecko.com/api/v3/simple/price?ids=' . implode(',', $ids) . '&vs_currencies=usd';
    
    $response = wp_remote_get($url, array(
        'timeout' => 10,
        'headers' => array(
            'User-Agent' => 'WordPress/' . get_bloginfo('version')
        )
    ));
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!$data) {
        return false;
    }
    
    $rates = array();
    foreach ($crypto_map as $currency_code => $api_id) {
        if (isset($data[$api_id]['usd']) && $data[$api_id]['usd'] > 0) {
            $rates[$currency_code] = 1 / $data[$api_id]['usd'];
        }
    }
    
    return $rates;
}

/**
 * Fallback crypto rates
 */
function yoursite_get_fallback_crypto_rates() {
    return array(
        'BTC' => 0.000025,  // ~$40,000
        'ETH' => 0.0004,    // ~$2,500
        'USDT' => 1.0,      // $1
        'USDC' => 1.0,      // $1
        'BNB' => 0.003      // ~$300
    );
}

/**
 * AJAX: Install currency from library
 */
function yoursite_ajax_install_library_currency() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_code = sanitize_text_field($_POST['currency_code'] ?? '');
    
    if (empty($currency_code)) {
        wp_send_json_error(__('Currency code is required', 'yoursite'));
    }
    
    $result = yoursite_install_currency($currency_code);
    
    if ($result['success']) {
        wp_send_json_success($result['message']);
    } else {
        wp_send_json_error($result['error']);
    }
}
add_action('wp_ajax_install_library_currency', 'yoursite_ajax_install_library_currency');

/**
 * AJAX: Create custom currency
 */
function yoursite_ajax_create_custom_currency() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_data = array(
        'code' => sanitize_text_field($_POST['code'] ?? ''),
        'name' => sanitize_text_field($_POST['name'] ?? ''),
        'symbol' => sanitize_text_field($_POST['symbol'] ?? ''),
        'flag' => sanitize_text_field($_POST['flag'] ?? ''),
        'prefix' => sanitize_text_field($_POST['prefix'] ?? ''),
        'suffix' => sanitize_text_field($_POST['suffix'] ?? ''),
        'decimal_places' => intval($_POST['decimal_places'] ?? 2),
        'decimal_separator' => sanitize_text_field($_POST['decimal_separator'] ?? '.'),
        'thousand_separator' => sanitize_text_field($_POST['thousand_separator'] ?? ','),
        'conversion_rate' => floatval($_POST['conversion_rate'] ?? 1.0),
        'rounding_mode' => sanitize_text_field($_POST['rounding_mode'] ?? 'nearest'),
        'rounding_precision' => sanitize_text_field($_POST['rounding_precision'] ?? '0.01'),
        'auto_update' => isset($_POST['auto_update']),
        'is_crypto' => isset($_POST['is_crypto']),
        'api_id' => sanitize_text_field($_POST['api_id'] ?? '')
    );
    
    $result = yoursite_create_custom_currency($currency_data);
    
    if ($result['success']) {
        wp_send_json_success($result['message']);
    } else {
        if (isset($result['errors'])) {
            wp_send_json_error(implode(', ', $result['errors']));
        } else {
            wp_send_json_error($result['error']);
        }
    }
}
add_action('wp_ajax_create_custom_currency', 'yoursite_ajax_create_custom_currency');

/**
 * AJAX: Import currency preset
 */
function yoursite_ajax_import_preset() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $preset_name = sanitize_text_field($_POST['preset'] ?? '');
    
    if (empty($preset_name)) {
        wp_send_json_error(__('Preset name is required', 'yoursite'));
    }
    
    $result = yoursite_import_currency_preset($preset_name);
    
    if ($result['success']) {
        wp_send_json_success(array(
            'message' => sprintf(__('Imported %d currencies successfully', 'yoursite'), $result['imported_count']),
            'imported_count' => $result['imported_count'],
            'errors' => $result['errors']
        ));
    } else {
        wp_send_json_error($result['error']);
    }
}
add_action('wp_ajax_import_preset', 'yoursite_ajax_import_preset');

/**
 * AJAX: Import CSV currencies
 */
function yoursite_ajax_import_csv_currencies() {
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error(__('No file uploaded or upload error', 'yoursite'));
    }
    
    $file_content = file_get_contents($_FILES['csv_file']['tmp_name']);
    
    if ($file_content === false) {
        wp_send_json_error(__('Could not read uploaded file', 'yoursite'));
    }
    
    $result = yoursite_import_currencies_from_csv($file_content);
    
    if ($result['success']) {
        wp_send_json_success(array(
            'message' => sprintf(__('Imported %d currencies from CSV', 'yoursite'), $result['imported_count']),
            'imported_count' => $result['imported_count'],
            'errors' => $result['errors']
        ));
    } else {
        wp_send_json_error($result['error']);
    }
}
add_action('wp_ajax_import_csv_currencies', 'yoursite_ajax_import_csv_currencies');

/**
 * AJAX: Get currency suggestions for search
 */
function yoursite_ajax_currency_suggestions() {
    $query = sanitize_text_field($_POST['query'] ?? '');
    
    if (strlen($query) < 2) {
        wp_send_json_success(array());
    }
    
    $library = yoursite_get_extended_currency_library();
    $installed = yoursite_get_installed_currencies();
    $suggestions = array();
    
    $query_lower = strtolower($query);
    
    foreach ($library as $code => $currency) {
        if (isset($installed[$code])) {
            continue; // Skip already installed
        }
        
        $score = 0;
        
        // Exact code match
        if (strtolower($code) === $query_lower) {
            $score = 100;
        }
        // Code starts with query
        elseif (strpos(strtolower($code), $query_lower) === 0) {
            $score = 80;
        }
        // Name contains query
        elseif (strpos(strtolower($currency['name']), $query_lower) !== false) {
            $score = 60;
        }
        // Code contains query
        elseif (strpos(strtolower($code), $query_lower) !== false) {
            $score = 40;
        }
        
        if ($score > 0) {
            $suggestions[] = array(
                'code' => $code,
                'name' => $currency['name'],
                'flag' => $currency['flag'],
                'category' => $currency['category'],
                'is_crypto' => $currency['is_crypto'],
                'score' => $score
            );
        }
    }
    
    // Sort by score
    usort($suggestions, function($a, $b) {
        return $b['score'] - $a['score'];
    });
    
    wp_send_json_success(array_slice($suggestions, 0, 10));
}
add_action('wp_ajax_currency_suggestions', 'yoursite_ajax_currency_suggestions');

/**
 * Currency usage statistics
 */
function yoursite_get_currency_usage_stats() {
    global $wpdb;
    
    $currencies_table = $wpdb->prefix . 'yoursite_currencies';
    $pricing_table = $wpdb->prefix . 'yoursite_pricing_currencies';
    
    $stats = $wpdb->get_results("
        SELECT 
            c.code,
            c.name,
            c.flag,
            c.status,
            c.is_crypto,
            c.category,
            COUNT(pc.id) as usage_count,
            c.last_updated
        FROM {$currencies_table} c
        LEFT JOIN {$pricing_table} pc ON c.code = pc.currency_code
        GROUP BY c.code
        ORDER BY usage_count DESC, c.code ASC
    ");
    
    return $stats;
}

/**
 * Cleanup unused currencies
 */
function yoursite_cleanup_unused_currencies() {
    global $wpdb;
    
    $currencies_table = $wpdb->prefix . 'yoursite_currencies';
    $pricing_table = $wpdb->prefix . 'yoursite_pricing_currencies';
    
    // Find unused inactive currencies (not base, not used in pricing, inactive for 30+ days)
    $unused = $wpdb->get_results("
        SELECT c.id, c.code, c.name
        FROM {$currencies_table} c
        LEFT JOIN {$pricing_table} pc ON c.code = pc.currency_code
        WHERE c.status = 'inactive' 
        AND c.is_base_currency = 0 
        AND pc.id IS NULL
        AND c.created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
    ");
    
    $deleted_count = 0;
    foreach ($unused as $currency) {
        $result = $wpdb->delete($currencies_table, array('id' => $currency->id), array('%d'));
        if ($result) {
            $deleted_count++;
        }
    }
    
    return $deleted_count;
}

/**
 * Export currencies to CSV
 */
function yoursite_export_currencies_csv() {
    $currencies = yoursite_get_installed_currencies();
    
    $csv_data = array();
    
    // Headers
    $csv_data[] = array(
        'code', 'name', 'symbol', 'flag', 'prefix', 'suffix',
        'decimal_places', 'decimal_separator', 'thousand_separator',
        'conversion_rate', 'status', 'is_crypto', 'auto_update',
        'category', 'rounding_mode', 'rounding_precision'
    );
    
    // Data rows
    foreach ($currencies as $currency) {
        $csv_data[] = array(
            $currency['code'],
            $currency['name'],
            $currency['symbol'],
            $currency['flag'],
            $currency['prefix'],
            $currency['suffix'],
            $currency['decimal_places'],
            $currency['decimal_separator'],
            $currency['thousand_separator'],
            $currency['conversion_rate'],
            $currency['status'],
            $currency['is_crypto'] ? '1' : '0',
            $currency['auto_update'] ? '1' : '0',
            $currency['category'],
            $currency['rounding_mode'],
            $currency['rounding_precision']
        );
    }
    
    // Convert to CSV string
    $output = '';
    foreach ($csv_data as $row) {
        $output .= '"' . implode('","', $row) . '"' . "\n";
    }
    
    return $output;
}

/**
 * Generate CSV template for import
 */
function yoursite_get_csv_template() {
    $template = array(
        array('code', 'name', 'symbol', 'flag', 'prefix', 'suffix', 'decimal_places', 'is_crypto', 'category'),
        array('EXAMPLE', 'Example Currency', ', '🌟', ', '', '2', '0', 'custom'),
        array('MYCOIN', 'My Custom Coin', 'MC', '🪙', '', ' MC', '4', '1', 'cryptocurrency')
    );
    
    $output = '';
    foreach ($template as $row) {
        $output .= '"' . implode('","', $row) . '"' . "\n";
    }
    
    return $output;
}

/**
 * Schedule currency system maintenance
 */
function yoursite_schedule_currency_maintenance() {
    if (!wp_next_scheduled('yoursite_currency_maintenance')) {
        wp_schedule_event(time(), 'weekly', 'yoursite_currency_maintenance');
    }
}
add_action('init', 'yoursite_schedule_currency_maintenance');

/**
 * Currency maintenance cron job
 */
function yoursite_currency_maintenance_job() {
    // Cleanup unused currencies
    $deleted = yoursite_cleanup_unused_currencies();
    
    if ($deleted > 0) {
        error_log("Currency maintenance: Cleaned up {$deleted} unused currencies");
    }
    
    // Update crypto rates if any crypto currencies are active
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $crypto_count = $wpdb->get_var(
        "SELECT COUNT(*) FROM {$table_name} WHERE is_crypto = 1 AND status = 'active' AND auto_update = 1"
    );
    
    if ($crypto_count > 0) {
        $crypto_rates = yoursite_fetch_crypto_rates_advanced();
        if ($crypto_rates) {
            foreach ($crypto_rates as $code => $rate) {
                $wpdb->update(
                    $table_name,
                    array(
                        'conversion_rate' => $rate,
                        'last_updated' => current_time('mysql')
                    ),
                    array('code' => $code),
                    array('%f', '%s'),
                    array('%s')
                );
            }
        }
    }
}
add_action('yoursite_currency_maintenance', 'yoursite_currency_maintenance_job');

/**
 * System health check for currencies
 */
function yoursite_currency_health_check() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $health = array(
        'status' => 'good',
        'issues' => array(),
        'warnings' => array(),
        'info' => array()
    );
    
    // Check for base currency
    $base_count = $wpdb->get_var("SELECT COUNT(*) FROM {$table_name} WHERE is_base_currency = 1");
    if ($base_count == 0) {
        $health['issues'][] = __('No base currency set', 'yoursite');
        $health['status'] = 'critical';
    } elseif ($base_count > 1) {
        $health['issues'][] = __('Multiple base currencies found', 'yoursite');
        $health['status'] = 'critical';
    }
    
    // Check for stale rates
    $stale_count = $wpdb->get_var(
        "SELECT COUNT(*) FROM {$table_name} 
         WHERE status = 'active' 
         AND auto_update = 1 
         AND (last_updated IS NULL OR last_updated < DATE_SUB(NOW(), INTERVAL 7 DAY))"
    );
    
    if ($stale_count > 0) {
        $health['warnings'][] = sprintf(__('%d currencies have stale exchange rates', 'yoursite'), $stale_count);
        if ($health['status'] === 'good') {
            $health['status'] = 'warning';
        }
    }
    
    // Check total active currencies
    $active_count = $wpdb->get_var("SELECT COUNT(*) FROM {$table_name} WHERE status = 'active'");
    $health['info'][] = sprintf(__('%d active currencies', 'yoursite'), $active_count);
    
    return $health;
}

/**
 * Initialize currency custom system
 */
function yoursite_init_currency_custom_system() {
    // Schedule maintenance
    yoursite_schedule_currency_maintenance();
    
    // Set system as ready
    update_option('yoursite_currency_custom_ready', true);
}
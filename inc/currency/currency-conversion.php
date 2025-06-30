<?php
/**
 * Currency Conversion Functions
 * File: inc/currency/currency-conversion.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Fetch exchange rates from external API
 */
function yoursite_fetch_exchange_rates($base_currency = null) {
    if (!$base_currency) {
        $base_curr = yoursite_get_base_currency();
        $base_currency = $base_curr['code'];
    }
    
    $settings = get_option('yoursite_currency_settings', array());
    $api_provider = $settings['api_provider'] ?? 'exchangerate_api';
    $api_key = $settings['api_key'] ?? '';
    
    switch ($api_provider) {
        case 'exchangerate_api':
            return yoursite_fetch_from_exchangerate_api($base_currency, $api_key);
        case 'fixer_io':
            return yoursite_fetch_from_fixer_io($base_currency, $api_key);
        case 'currencylayer':
            return yoursite_fetch_from_currencylayer($base_currency, $api_key);
        case 'openexchangerates':
            return yoursite_fetch_from_openexchangerates($base_currency, $api_key);
        default:
            return yoursite_fetch_fallback_rates($base_currency);
    }
}

/**
 * Fetch from ExchangeRate-API (free tier available)
 */
function yoursite_fetch_from_exchangerate_api($base_currency, $api_key = '') {
    $url = !empty($api_key) 
        ? "https://v6.exchangerate-api.com/v6/{$api_key}/latest/{$base_currency}"
        : "https://api.exchangerate-api.com/v4/latest/{$base_currency}";
    
    $response = wp_remote_get($url, array(
        'timeout' => 10,
        'headers' => array(
            'User-Agent' => 'WordPress/' . get_bloginfo('version') . '; ' . home_url()
        )
    ));
    
    if (is_wp_error($response)) {
        error_log('Currency API Error: ' . $response->get_error_message());
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!$data || !isset($data['rates'])) {
        error_log('Currency API Error: Invalid response format');
        return false;
    }
    
    return $data['rates'];
}

/**
 * Fetch from Fixer.io
 */
function yoursite_fetch_from_fixer_io($base_currency, $api_key) {
    if (empty($api_key)) {
        return false;
    }
    
    $url = "http://data.fixer.io/api/latest?access_key={$api_key}&base={$base_currency}";
    
    $response = wp_remote_get($url, array('timeout' => 10));
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!$data || !isset($data['rates']) || !$data['success']) {
        return false;
    }
    
    return $data['rates'];
}

/**
 * Fetch from CurrencyLayer
 */
function yoursite_fetch_from_currencylayer($base_currency, $api_key) {
    if (empty($api_key)) {
        return false;
    }
    
    $url = "http://api.currencylayer.com/live?access_key={$api_key}&source={$base_currency}";
    
    $response = wp_remote_get($url, array('timeout' => 10));
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!$data || !isset($data['quotes']) || !$data['success']) {
        return false;
    }
    
    // Convert from USDXXX format to XXX
    $rates = array();
    foreach ($data['quotes'] as $pair => $rate) {
        $currency = substr($pair, 3); // Remove first 3 characters (USD)
        $rates[$currency] = $rate;
    }
    
    return $rates;
}

/**
 * Fetch from Open Exchange Rates
 */
function yoursite_fetch_from_openexchangerates($base_currency, $api_key) {
    if (empty($api_key)) {
        return false;
    }
    
    $url = "https://openexchangerates.org/api/latest.json?app_id={$api_key}&base={$base_currency}";
    
    $response = wp_remote_get($url, array('timeout' => 10));
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!$data || !isset($data['rates'])) {
        return false;
    }
    
    return $data['rates'];
}

/**
 * Fallback rates (static rates for demo/emergency use)
 */
function yoursite_fetch_fallback_rates($base_currency) {
    // Static fallback rates relative to USD
    $fallback_rates = array(
        'USD' => 1.0,
        'EUR' => 0.85,
        'GBP' => 0.73,
        'JPY' => 110.0,
        'CAD' => 1.25,
        'AUD' => 1.35,
        'CHF' => 0.92,
        'CNY' => 6.45,
        'SEK' => 8.60,
        'NOK' => 8.50,
        'DKK' => 6.35,
        'PLN' => 3.90,
        'INR' => 74.50,
        'BRL' => 5.20,
        'RUB' => 73.50,
        'KRW' => 1180.0,
        'MXN' => 20.10,
        'SGD' => 1.35,
        'NZD' => 1.42,
        'HKD' => 7.80,
        'BTC' => 0.000025,  // 1 USD = 0.000025 BTC (example rate)
        'ETH' => 0.0004,    // 1 USD = 0.0004 ETH (example rate)
        'USDC' => 1.0       // 1 USD = 1 USDC (stable coin)
    );
    
    if ($base_currency === 'USD') {
        return $fallback_rates;
    }
    
    // Convert rates to different base currency
    $base_rate = $fallback_rates[$base_currency] ?? 1.0;
    $converted_rates = array();
    
    foreach ($fallback_rates as $currency => $rate) {
        $converted_rates[$currency] = $rate / $base_rate;
    }
    
    return $converted_rates;
}

/**
 * Get cryptocurrency rates (specialized handling)
 */
function yoursite_fetch_crypto_rates() {
    // Using CoinGecko API (free)
    $url = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,usd-coin&vs_currencies=usd';
    
    $response = wp_remote_get($url, array('timeout' => 10));
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!$data) {
        return false;
    }
    
    $crypto_rates = array();
    
    if (isset($data['bitcoin']['usd'])) {
        $crypto_rates['BTC'] = 1 / $data['bitcoin']['usd']; // Convert to BTC per USD
    }
    
    if (isset($data['ethereum']['usd'])) {
        $crypto_rates['ETH'] = 1 / $data['ethereum']['usd']; // Convert to ETH per USD
    }
    
    if (isset($data['usd-coin']['usd'])) {
        $crypto_rates['USDC'] = 1 / $data['usd-coin']['usd']; // Convert to USDC per USD
    }
    
    return $crypto_rates;
}

/**
 * Update specific currency rates
 */
function yoursite_update_specific_currency_rates($currency_codes = array()) {
    $base_currency = yoursite_get_base_currency();
    $all_rates = yoursite_fetch_exchange_rates($base_currency['code']);
    
    if (!$all_rates) {
        return false;
    }
    
    // Add crypto rates if needed
    $crypto_currencies = array('BTC', 'ETH', 'USDC');
    $needs_crypto = array_intersect($currency_codes, $crypto_currencies);
    
    if (!empty($needs_crypto)) {
        $crypto_rates = yoursite_fetch_crypto_rates();
        if ($crypto_rates) {
            $all_rates = array_merge($all_rates, $crypto_rates);
        }
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $updated_count = 0;
    
    foreach ($currency_codes as $currency_code) {
        if (isset($all_rates[$currency_code])) {
            $result = $wpdb->update(
                $table_name,
                array(
                    'conversion_rate' => $all_rates[$currency_code],
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
    }
    
    return $updated_count;
}

/**
 * Convert price with rounding and formatting
 */
function yoursite_convert_and_format_price($amount, $from_currency, $to_currency) {
    $converted_amount = yoursite_convert_price($amount, $from_currency, $to_currency);
    return yoursite_format_currency($converted_amount, $to_currency);
}

/**
 * Get conversion rate between two currencies
 */
function yoursite_get_conversion_rate($from_currency, $to_currency) {
    if ($from_currency === $to_currency) {
        return 1.0;
    }
    
    $from_curr = yoursite_get_currency($from_currency);
    $to_curr = yoursite_get_currency($to_currency);
    
    if (!$from_curr || !$to_curr) {
        return 1.0;
    }
    
    // Convert through base currency
    $base_amount = 1 / $from_curr['conversion_rate'];
    return $base_amount * $to_curr['conversion_rate'];
}

/**
 * Batch convert multiple prices
 */
function yoursite_batch_convert_prices($prices, $from_currency, $to_currency) {
    $conversion_rate = yoursite_get_conversion_rate($from_currency, $to_currency);
    $to_currency_data = yoursite_get_currency($to_currency);
    
    $converted_prices = array();
    
    foreach ($prices as $key => $amount) {
        $converted_amount = $amount * $conversion_rate;
        $converted_prices[$key] = yoursite_apply_currency_rounding($converted_amount, $to_currency_data);
    }
    
    return $converted_prices;
}

/**
 * Check if currency rates need updating
 */
function yoursite_check_rates_freshness() {
    $settings = get_option('yoursite_currency_settings', array());
    $update_frequency = $settings['update_frequency'] ?? 'daily';
    $last_update = get_option('yoursite_currency_last_update');
    
    if (!$last_update) {
        return true; // Never updated
    }
    
    $last_update_time = strtotime($last_update);
    $current_time = time();
    
    switch ($update_frequency) {
        case 'hourly':
            return ($current_time - $last_update_time) > HOUR_IN_SECONDS;
        case 'daily':
            return ($current_time - $last_update_time) > DAY_IN_SECONDS;
        case 'weekly':
            return ($current_time - $last_update_time) > WEEK_IN_SECONDS;
        default:
            return false;
    }
}

/**
 * Auto-update currency rates if needed
 */
function yoursite_maybe_update_currency_rates() {
    $settings = get_option('yoursite_currency_settings', array());
    
    if (!$settings['auto_update_enabled'] ?? false) {
        return false;
    }
    
    if (!yoursite_check_rates_freshness()) {
        return false;
    }
    
    return yoursite_update_currency_rates();
}

/**
 * Convert pricing plan prices to specific currency
 */
function yoursite_get_pricing_plan_price($plan_id, $currency_code, $period = 'monthly') {
    global $wpdb;
    
    // First try to get specific currency pricing
    $table_name = $wpdb->prefix . 'yoursite_pricing_currencies';
    
    $price_field = $period === 'annual' ? 'annual_price' : 'monthly_price';
    
    $specific_price = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT {$price_field} FROM {$table_name} WHERE pricing_plan_id = %d AND currency_code = %s",
            $plan_id,
            $currency_code
        )
    );
    
    if ($specific_price !== null) {
        return floatval($specific_price);
    }
    
    // Fallback to base currency conversion
    $base_currency = yoursite_get_base_currency();
    $base_price_meta = get_post_meta($plan_id, '_pricing_' . $period . '_price', true);
    
    if (!$base_price_meta) {
        return 0;
    }
    
    return yoursite_convert_price(floatval($base_price_meta), $base_currency['code'], $currency_code);
}

/**
 * Get formatted pricing plan price
 */
function yoursite_get_formatted_pricing_plan_price($plan_id, $currency_code, $period = 'monthly') {
    $price = yoursite_get_pricing_plan_price($plan_id, $currency_code, $period);
    return yoursite_format_currency($price, $currency_code);
}

/**
 * Calculate savings for annual pricing
 */
function yoursite_calculate_annual_savings($plan_id, $currency_code) {
    $monthly_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'monthly');
    $annual_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'annual');
    
    if ($monthly_price <= 0 || $annual_price <= 0) {
        return 0;
    }
    
    $annual_if_monthly = $monthly_price * 12;
    return $annual_if_monthly - $annual_price;
}

/**
 * Get formatted annual savings
 */
function yoursite_get_formatted_annual_savings($plan_id, $currency_code) {
    $savings = yoursite_calculate_annual_savings($plan_id, $currency_code);
    
    if ($savings <= 0) {
        return '';
    }
    
    return yoursite_format_currency($savings, $currency_code);
}

/**
 * Calculate discount percentage for annual pricing
 */
function yoursite_calculate_annual_discount_percentage($plan_id, $currency_code) {
    $monthly_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'monthly');
    $annual_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'annual');
    
    if ($monthly_price <= 0 || $annual_price <= 0) {
        return 0;
    }
    
    $annual_if_monthly = $monthly_price * 12;
    $discount = $annual_if_monthly - $annual_price;
    
    return round(($discount / $annual_if_monthly) * 100);
}

/**
 * Smart currency detection based on various factors
 */
function yoursite_smart_currency_detection() {
    $detected_currency = null;
    
    // 1. Check user preference (cookie/session)
    if (isset($_COOKIE['yoursite_preferred_currency'])) {
        $currency_code = sanitize_text_field($_COOKIE['yoursite_preferred_currency']);
        $currency = yoursite_get_currency($currency_code);
        if ($currency && $currency['status'] === 'active') {
            return $currency;
        }
    }
    
    // 2. Check logged-in user meta
    if (is_user_logged_in()) {
        $user_currency = get_user_meta(get_current_user_id(), 'preferred_currency', true);
        if ($user_currency) {
            $currency = yoursite_get_currency($user_currency);
            if ($currency && $currency['status'] === 'active') {
                return $currency;
            }
        }
    }
    
    // 3. Geolocation detection (if enabled)
    $settings = get_option('yoursite_currency_settings', array());
    if ($settings['geolocation_detection'] ?? false) {
        $geo_currency = yoursite_detect_currency_by_ip();
        if ($geo_currency) {
            return $geo_currency;
        }
    }
    
    // 4. Browser language detection
    $browser_currency = yoursite_detect_currency_by_browser_language();
    if ($browser_currency) {
        return $browser_currency;
    }
    
    // 5. Fallback to base currency
    return yoursite_get_base_currency();
}

/**
 * Detect currency by IP geolocation
 */
function yoursite_detect_currency_by_ip() {
    $user_ip = $_SERVER['REMOTE_ADDR'] ?? '';
    
    // Skip for localhost/private IPs
    if (filter_var($user_ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return null;
    }
    
    // Simple IP to country detection using a free service
    $geo_api_url = "http://ip-api.com/json/{$user_ip}?fields=countryCode";
    
    $response = wp_remote_get($geo_api_url, array(
        'timeout' => 5,
        'sslverify' => false
    ));
    
    if (is_wp_error($response)) {
        return null;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!$data || !isset($data['countryCode'])) {
        return null;
    }
    
    $country_currency_map = array(
        'US' => 'USD', 'CA' => 'CAD', 'GB' => 'GBP', 'AU' => 'AUD',
        'DE' => 'EUR', 'FR' => 'EUR', 'IT' => 'EUR', 'ES' => 'EUR',
        'NL' => 'EUR', 'BE' => 'EUR', 'AT' => 'EUR', 'PT' => 'EUR',
        'JP' => 'JPY', 'CN' => 'CNY', 'IN' => 'INR', 'BR' => 'BRL',
        'SE' => 'SEK', 'NO' => 'NOK', 'DK' => 'DKK', 'CH' => 'CHF',
        'PL' => 'PLN', 'RU' => 'RUB', 'KR' => 'KRW', 'MX' => 'MXN',
        'SG' => 'SGD', 'NZ' => 'NZD', 'HK' => 'HKD'
    );
    
    $country_code = $data['countryCode'];
    $currency_code = $country_currency_map[$country_code] ?? null;
    
    if ($currency_code) {
        return yoursite_get_currency($currency_code);
    }
    
    return null;
}

/**
 * Detect currency by browser language
 */
function yoursite_detect_currency_by_browser_language() {
    $accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    
    if (empty($accept_language)) {
        return null;
    }
    
    // Parse accept-language header
    preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)\s*(?:;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $accept_language, $matches);
    
    $languages = array();
    for ($i = 0; $i < count($matches[1]); $i++) {
        $lang = strtolower($matches[1][$i]);
        $quality = $matches[2][$i] ?? '1.0';
        $languages[$lang] = floatval($quality);
    }
    
    // Sort by quality
    arsort($languages);
    
    $language_currency_map = array(
        'en' => 'USD', 'en-us' => 'USD', 'en-ca' => 'CAD', 'en-gb' => 'GBP', 'en-au' => 'AUD',
        'de' => 'EUR', 'de-de' => 'EUR', 'fr' => 'EUR', 'fr-fr' => 'EUR',
        'es' => 'EUR', 'es-es' => 'EUR', 'it' => 'EUR', 'it-it' => 'EUR',
        'nl' => 'EUR', 'nl-nl' => 'EUR', 'pt' => 'EUR', 'pt-pt' => 'EUR',
        'ja' => 'JPY', 'ja-jp' => 'JPY', 'zh' => 'CNY', 'zh-cn' => 'CNY',
        'sv' => 'SEK', 'sv-se' => 'SEK', 'no' => 'NOK', 'nb' => 'NOK',
        'da' => 'DKK', 'da-dk' => 'DKK', 'pl' => 'PLN', 'pl-pl' => 'PLN',
        'ru' => 'RUB', 'ru-ru' => 'RUB', 'ko' => 'KRW', 'ko-kr' => 'KRW'
    );
    
    foreach ($languages as $language => $quality) {
        if (isset($language_currency_map[$language])) {
            $currency_code = $language_currency_map[$language];
            $currency = yoursite_get_currency($currency_code);
            if ($currency && $currency['status'] === 'active') {
                return $currency;
            }
        }
    }
    
    return null;
}
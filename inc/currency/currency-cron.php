<?php
/**
 * Currency Cron Jobs and Automated Updates
 * File: inc/currency/currency-cron.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register currency cron schedules
 */
function yoursite_currency_cron_schedules($schedules) {
    $schedules['hourly'] = array(
        'interval' => HOUR_IN_SECONDS,
        'display' => __('Every Hour', 'yoursite')
    );
    
    $schedules['six_hours'] = array(
        'interval' => 6 * HOUR_IN_SECONDS,
        'display' => __('Every 6 Hours', 'yoursite')
    );
    
    $schedules['twelve_hours'] = array(
        'interval' => 12 * HOUR_IN_SECONDS,
        'display' => __('Every 12 Hours', 'yoursite')
    );
    
    return $schedules;
}
add_filter('cron_schedules', 'yoursite_currency_cron_schedules');

/**
 * Schedule currency rate updates
 */
function yoursite_schedule_currency_updates() {
    $settings = get_option('yoursite_currency_settings', array());
    $frequency = $settings['update_frequency'] ?? 'daily';
    
    // Clear any existing scheduled events
    $timestamp = wp_next_scheduled('yoursite_update_currency_rates');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'yoursite_update_currency_rates');
    }
    
    // Schedule new event if auto-update is enabled
    if ($settings['auto_update_enabled'] ?? false) {
        wp_schedule_event(time(), $frequency, 'yoursite_update_currency_rates');
    }
}
add_action('init', 'yoursite_schedule_currency_updates');

/**
 * Currency rates update cron job
 */
function yoursite_cron_update_currency_rates() {
    $settings = get_option('yoursite_currency_settings', array());
    
    if (!($settings['auto_update_enabled'] ?? false)) {
        return;
    }
    
    error_log('Currency rates cron job started');
    
    $updated_count = yoursite_update_currency_rates();
    
    if ($updated_count !== false) {
        error_log("Currency rates updated successfully. {$updated_count} currencies updated.");
        
        // Log successful update
        yoursite_log_currency_update('success', array(
            'updated_count' => $updated_count,
            'timestamp' => current_time('mysql'),
            'trigger' => 'cron'
        ));
        
        // Send notification if configured
        yoursite_maybe_send_currency_update_notification($updated_count);
        
    } else {
        error_log('Currency rates update failed');
        
        // Log failed update
        yoursite_log_currency_update('failure', array(
            'timestamp' => current_time('mysql'),
            'trigger' => 'cron'
        ));
        
        // Try fallback rates
        yoursite_try_fallback_currency_update();
    }
}
add_action('yoursite_update_currency_rates', 'yoursite_cron_update_currency_rates');

/**
 * Log currency update attempts
 */
function yoursite_log_currency_update($status, $data = array()) {
    $log_entry = array(
        'status' => $status,
        'timestamp' => current_time('mysql'),
        'data' => $data
    );
    
    $log = get_option('yoursite_currency_update_log', array());
    
    // Keep only last 100 entries
    if (count($log) >= 100) {
        $log = array_slice($log, -99);
    }
    
    $log[] = $log_entry;
    update_option('yoursite_currency_update_log', $log);
}

/**
 * Try fallback currency update when primary fails
 */
function yoursite_try_fallback_currency_update() {
    $settings = get_option('yoursite_currency_settings', array());
    $fallback_rates = $settings['fallback_rates'] ?? array();
    
    if (empty($fallback_rates)) {
        // Use built-in fallback rates
        $base_currency = yoursite_get_base_currency();
        $fallback_rates = yoursite_fetch_fallback_rates($base_currency['code']);
    }
    
    if (!empty($fallback_rates)) {
        $updated_count = yoursite_update_currency_rates($fallback_rates);
        
        if ($updated_count !== false) {
            error_log("Fallback currency rates applied. {$updated_count} currencies updated.");
            
            yoursite_log_currency_update('fallback_success', array(
                'updated_count' => $updated_count,
                'timestamp' => current_time('mysql')
            ));
        }
    }
}

/**
 * Send email notification for currency updates
 */
function yoursite_maybe_send_currency_update_notification($updated_count) {
    $settings = get_option('yoursite_currency_settings', array());
    
    if (!($settings['email_notifications'] ?? false)) {
        return;
    }
    
    $recipient = $settings['notification_email'] ?? get_option('admin_email');
    $subject = sprintf(__('[%s] Currency Rates Updated', 'yoursite'), get_bloginfo('name'));
    
    $message = sprintf(
        __("Currency rates have been automatically updated.\n\nUpdated currencies: %d\nTime: %s\nNext update: %s\n\nView currency settings: %s", 'yoursite'),
        $updated_count,
        current_time('Y-m-d H:i:s'),
        date('Y-m-d H:i:s', wp_next_scheduled('yoursite_update_currency_rates')),
        admin_url('admin.php?page=yoursite-currencies')
    );
    
    wp_mail($recipient, $subject, $message);
}

/**
 * Clean up old currency logs
 */
function yoursite_cleanup_currency_logs() {
    $log = get_option('yoursite_currency_update_log', array());
    
    if (count($log) > 200) {
        $log = array_slice($log, -100); // Keep only last 100 entries
        update_option('yoursite_currency_update_log', $log);
    }
    
    // Clean up old conversion cache
    delete_transient('yoursite_currency_conversion_cache');
}
add_action('yoursite_cleanup_currency_logs', 'yoursite_cleanup_currency_logs');

/**
 * Schedule weekly cleanup
 */
function yoursite_schedule_currency_cleanup() {
    if (!wp_next_scheduled('yoursite_cleanup_currency_logs')) {
        wp_schedule_event(time(), 'weekly', 'yoursite_cleanup_currency_logs');
    }
}
add_action('init', 'yoursite_schedule_currency_cleanup');

/**
 * Handle currency system activation
 */
function yoursite_currency_activation_tasks() {
    // Schedule initial currency update
    if (!wp_next_scheduled('yoursite_update_currency_rates')) {
        wp_schedule_event(time() + 300, 'daily', 'yoursite_update_currency_rates'); // Start in 5 minutes
    }
    
    // Schedule cleanup
    yoursite_schedule_currency_cleanup();
    
    // Flush rewrite rules
    flush_rewrite_rules();
}

/**
 * Handle currency system deactivation
 */
function yoursite_currency_deactivation_tasks() {
    // Clear scheduled events
    $timestamp = wp_next_scheduled('yoursite_update_currency_rates');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'yoursite_update_currency_rates');
    }
    
    $cleanup_timestamp = wp_next_scheduled('yoursite_cleanup_currency_logs');
    if ($cleanup_timestamp) {
        wp_unschedule_event($cleanup_timestamp, 'yoursite_cleanup_currency_logs');
    }
    
    // Clear transients
    delete_transient('yoursite_currency_conversion_cache');
}

/**
 * Monitor currency rate staleness
 */
function yoursite_monitor_currency_staleness() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $settings = get_option('yoursite_currency_settings', array());
    $staleness_threshold = $settings['staleness_threshold'] ?? 48; // hours
    
    $stale_currencies = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT code, last_updated FROM {$table_name} 
             WHERE status = 'active' 
             AND (last_updated IS NULL OR last_updated < %s)",
            date('Y-m-d H:i:s', time() - ($staleness_threshold * HOUR_IN_SECONDS))
        )
    );
    
    if (!empty($stale_currencies)) {
        // Log stale currencies
        yoursite_log_currency_update('stale_detected', array(
            'stale_currencies' => array_column($stale_currencies, 'code'),
            'staleness_threshold' => $staleness_threshold,
            'timestamp' => current_time('mysql')
        ));
        
        // Try to update stale currencies
        $currency_codes = array_column($stale_currencies, 'code');
        yoursite_update_specific_currency_rates($currency_codes);
    }
}
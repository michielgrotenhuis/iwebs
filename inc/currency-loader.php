<?php
/**
 * Multi-Currency System Loader
 * File: inc/currency-loader.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load all currency-related components
 */
function yoursite_load_currency_system() {
    $currency_files = array(
        '/inc/currency/currency-core.php',
        '/inc/currency/currency-admin.php',
        '/inc/currency/currency-meta-boxes.php',
        '/inc/currency/currency-conversion.php',
        '/inc/currency/currency-display.php',
        '/inc/currency/currency-ajax.php',
        '/inc/currency/currency-cron.php'
    );
    
    foreach ($currency_files as $file) {
        $file_path = get_template_directory() . $file;
        if (file_exists($file_path)) {
            require_once $file_path;
        }
    }
}
add_action('after_setup_theme', 'yoursite_load_currency_system', 10);

/**
 * Initialize currency system
 */
function yoursite_init_currency_system() {
    // Create currency tables on activation
    if (!get_option('yoursite_currency_tables_created')) {
        yoursite_create_currency_tables();
        yoursite_populate_default_currencies();
        update_option('yoursite_currency_tables_created', true);
    }
    
    // Initialize default settings
    if (!get_option('yoursite_currency_settings_initialized')) {
        yoursite_initialize_currency_settings();
        update_option('yoursite_currency_settings_initialized', true);
    }
}
add_action('init', 'yoursite_init_currency_system');

/**
 * Admin notice for currency system
 */
function yoursite_currency_admin_notice() {
    $screen = get_current_screen();
    
    if ($screen->id === 'dashboard') {
        $currencies_count = yoursite_get_active_currencies_count();
        
        if ($currencies_count > 1) {
            ?>
            <div class="notice notice-info is-dismissible">
                <h3><?php _e('💰 Multi-Currency System Active', 'yoursite'); ?></h3>
                <p><?php printf(__('You have %d currencies configured. Manage your pricing in multiple currencies.', 'yoursite'), $currencies_count); ?></p>
                <p>
                    <a href="<?php echo admin_url('admin.php?page=yoursite-currencies'); ?>" class="button button-primary">
                        <?php _e('Manage Currencies', 'yoursite'); ?>
                    </a>
                    <a href="<?php echo admin_url('edit.php?post_type=pricing'); ?>" class="button">
                        <?php _e('Set Pricing Plans', 'yoursite'); ?>
                    </a>
                </p>
            </div>
            <?php
        }
    }
}
add_action('admin_notices', 'yoursite_currency_admin_notice');

/**
 * Enqueue currency admin assets
 */
function yoursite_currency_admin_assets($hook) {
    if (strpos($hook, 'yoursite-currencies') !== false || 
        get_current_screen()->post_type === 'pricing') {
        
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        
        wp_add_inline_style('wp-admin', '
            .currency-list { margin: 20px 0; }
            .currency-item { 
                background: #fff; 
                border: 1px solid #ddd; 
                border-radius: 4px; 
                padding: 15px; 
                margin-bottom: 10px;
                position: relative;
            }
            .currency-item.active { border-left: 4px solid #0073aa; }
            .currency-item.inactive { opacity: 0.6; }
            .currency-controls { display: flex; gap: 10px; align-items: center; }
            .currency-flag { font-size: 18px; margin-right: 8px; }
            .currency-code { font-weight: bold; color: #0073aa; }
            .currency-rate { color: #666; font-size: 12px; }
            .currency-actions { position: absolute; top: 15px; right: 15px; }
            .conversion-rate-input { width: 100px; }
            .currency-format-preview { 
                background: #f0f0f1; 
                padding: 8px 12px; 
                border-radius: 3px; 
                font-family: monospace; 
                margin-top: 5px;
            }
            .manual-refresh-btn { 
                background: #f0f6fc; 
                border: 1px solid #0073aa; 
                color: #0073aa; 
                padding: 8px 15px; 
                border-radius: 4px; 
                cursor: pointer;
            }
            .manual-refresh-btn:hover { background: #e6f3ff; }
            .auto-update-indicator.active { color: #46b450; }
            .auto-update-indicator.inactive { color: #dc3232; }
        ');
        
        wp_localize_script('jquery', 'currencyAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('currency_management_nonce'),
            'strings' => array(
                'updating' => __('Updating...', 'yoursite'),
                'updated' => __('Updated!', 'yoursite'),
                'error' => __('Error updating', 'yoursite'),
                'confirm_delete' => __('Are you sure you want to delete this currency?', 'yoursite'),
                'confirm_refresh' => __('This will update all conversion rates. Continue?', 'yoursite')
            )
        ));
    }
}
add_action('admin_enqueue_scripts', 'yoursite_currency_admin_assets');

/**
 * Add currency management to admin menu
 */
function yoursite_add_currency_menu() {
    add_submenu_page(
        'themes.php',
        __('Multi-Currency Settings', 'yoursite'),
        __('Currencies', 'yoursite'),
        'manage_options',
        'yoursite-currencies',
        'yoursite_currency_admin_page'
    );
}
add_action('admin_menu', 'yoursite_add_currency_menu');

/**
 * Get count of active currencies
 */
function yoursite_get_active_currencies_count() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") !== $table_name) {
        return 1; // Default USD
    }
    
    return $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'active'");
}
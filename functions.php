<?php
/**
 * YourSite.biz Theme Functions
 * Main functions file that loads modular components
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('YOURSITE_THEME_VERSION', '1.0.0');
define('YOURSITE_THEME_DIR', get_template_directory());
define('YOURSITE_THEME_URI', get_template_directory_uri());

/**
 * Create inc directory if it doesn't exist
 */
function yoursite_create_inc_directory() {
    $inc_dir = YOURSITE_THEME_DIR . '/inc';
    if (!file_exists($inc_dir)) {
        wp_mkdir_p($inc_dir);
    }
}
add_action('after_setup_theme', 'yoursite_create_inc_directory', 1);

/**
 * Load theme components
 */
function yoursite_load_components() {
    $components = array(
        'theme-setup.php',           // Theme setup and support
        'enqueue-scripts.php',       // Scripts and styles
        'customizer.php',            // Theme customizer
        'post-types.php',            // Custom post types
        'meta-boxes.php',            // Meta boxes for custom fields
        'widgets.php',               // Widget areas
        'helpers.php',               // Helper functions
        'ajax-handlers.php',         // AJAX form handlers
        'admin-functions.php',       // Admin panel functions
        'security.php',              // Security enhancements
        'theme-activation.php',      // Theme activation hooks
        'theme-modes.php'            // Dark/Light mode functionality
    );
    
    foreach ($components as $component) {
        $file = YOURSITE_THEME_DIR . '/inc/' . $component;
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
add_action('after_setup_theme', 'yoursite_load_components', 5);

/**
 * Fallback functions in case inc files don't load
 */
if (!function_exists('yoursite_theme_setup_fallback')) {
    function yoursite_theme_setup_fallback() {
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('custom-logo');
    }
    add_action('after_setup_theme', 'yoursite_theme_setup_fallback', 20);
}

if (!function_exists('yoursite_enqueue_scripts_fallback')) {
    function yoursite_enqueue_scripts_fallback() {
        wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), YOURSITE_THEME_VERSION);
    }
    add_action('wp_enqueue_scripts', 'yoursite_enqueue_scripts_fallback', 20);
}
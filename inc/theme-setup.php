<?php
/**
 * Theme setup and configuration
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function yoursite_theme_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form', 
        'comment-form', 
        'comment-list', 
        'gallery', 
        'caption'
    ));
    add_theme_support('customize-selective-refresh-widgets');
    
    // Add theme support for WordPress 5.0+ editor styles
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'yoursite'),
        'footer' => __('Footer Menu', 'yoursite'),
    ));
    
    // Set content width
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'yoursite_theme_setup');

/**
 * Add custom image sizes
 */
function yoursite_add_image_sizes() {
    add_image_size('hero-image', 1200, 600, true);
    add_image_size('feature-image', 400, 300, true);
    add_image_size('testimonial-avatar', 80, 80, true);
}
add_action('after_setup_theme', 'yoursite_add_image_sizes');

/**
 * Add theme support for block editor
 */
function yoursite_gutenberg_support() {
    add_theme_support('editor-color-palette', array(
        array(
            'name' => __('Primary Blue', 'yoursite'),
            'slug' => 'primary-blue',
            'color' => '#667eea',
        ),
        array(
            'name' => __('Secondary Purple', 'yoursite'),
            'slug' => 'secondary-purple',
            'color' => '#764ba2',
        ),
        array(
            'name' => __('Dark Gray', 'yoursite'),
            'slug' => 'dark-gray',
            'color' => '#374151',
        ),
    ));
}
add_action('after_setup_theme', 'yoursite_gutenberg_support');

/**
 * Custom excerpt length
 */
function yoursite_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'yoursite_excerpt_length');

/**
 * Custom excerpt more
 */
function yoursite_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'yoursite_excerpt_more');

/**
 * Add custom body classes
 */
function yoursite_body_classes($classes) {
    $page_templates = array(
        'page-pricing.php' => 'pricing-page',
        'page-contact.php' => 'contact-page',
        'page-features.php' => 'features-page',
        'page-templates.php' => 'templates-page',
        'page-webinars.php' => 'webinars-page'
    );
    
    foreach ($page_templates as $template => $class) {
        if (is_page_template($template)) {
            $classes[] = $class;
        }
    }
    
    return $classes;
}
add_filter('body_class', 'yoursite_body_classes');
?>
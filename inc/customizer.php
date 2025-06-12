<?php
/**
 * Safe Main theme customizer loader - RESTORE VERSION
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load all customizer modules
 */
function yoursite_load_customizer_modules() {
    $customizer_modules = array(
        'customizer-homepage.php',      // Homepage editor
        'customizer-header.php',        // Header settings
        'customizer-footer.php',        // Footer settings  
        'customizer-colors.php',        // Colors and typography
        'customizer-company.php',       // Company information
        'customizer-social.php',        // Social media links
        'customizer-features.php',      // Features page
        'customizer-pricing.php',       // Pricing page
        'customizer-contact.php',       // Contact page
        'customizer-about.php',         // About page
        'customizer-templates.php',     // Templates page
    );
    
    foreach ($customizer_modules as $module) {
        $file = get_template_directory() . '/inc/customizer/' . $module;
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
add_action('customize_register', 'yoursite_load_customizer_modules', 5);

/**
 * Main customizer registration
 */
function yoursite_customize_register($wp_customize) {
    // Add main panel for page editing
    $wp_customize->add_panel('yoursite_pages', array(
        'title' => __('Edit Pages', 'yoursite'),
        'description' => __('Customize all page elements including content, images, and settings', 'yoursite'),
        'priority' => 10,
    ));
    
    // Theme Options panel
    $wp_customize->add_panel('yoursite_theme_options', array(
        'title' => __('Theme Options', 'yoursite'),
        'description' => __('General theme settings, colors, fonts, and layout options', 'yoursite'),
        'priority' => 20,
    ));
}
add_action('customize_register', 'yoursite_customize_register', 1);

/**
 * Sanitize checkbox
 */
function yoursite_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Output custom CSS based on customizer settings
 */
function yoursite_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#667eea');
    $secondary_color = get_theme_mod('secondary_color', '#764ba2');
    $body_font = get_theme_mod('body_font_family', 'Inter');
    $heading_font = get_theme_mod('heading_font_family', 'Inter');
    
    if ($primary_color !== '#667eea' || $secondary_color !== '#764ba2' || $body_font !== 'Inter' || $heading_font !== 'Inter') {
        ?>
        <style type="text/css" id="yoursite-customizer-css">
        <?php if ($body_font !== 'Inter') : ?>
        body {
            font-family: '<?php echo esc_html($body_font); ?>', sans-serif;
        }
        <?php endif; ?>
        
        <?php if ($heading_font !== 'Inter') : ?>
        h1, h2, h3, h4, h5, h6 {
            font-family: '<?php echo esc_html($heading_font); ?>', sans-serif;
        }
        <?php endif; ?>
        
        <?php if ($primary_color !== '#667eea' || $secondary_color !== '#764ba2') : ?>
        .btn-primary,
        .hero-gradient {
            background: linear-gradient(135deg, <?php echo esc_html($primary_color); ?> 0%, <?php echo esc_html($secondary_color); ?> 100%) !important;
        }
        
        .text-primary {
            color: <?php echo esc_html($primary_color); ?> !important;
        }
        
        .bg-primary {
            background-color: <?php echo esc_html($primary_color); ?> !important;
        }
        
        .border-primary {
            border-color: <?php echo esc_html($primary_color); ?> !important;
        }
        
        .btn-secondary:hover {
            border-color: <?php echo esc_html($primary_color); ?> !important;
            color: <?php echo esc_html($primary_color); ?> !important;
        }
        
        .hero-gradient .btn-primary {
            color: <?php echo esc_html($secondary_color); ?> !important;
        }
        <?php endif; ?>
        </style>
        <?php
    }
}
add_action('wp_head', 'yoursite_customizer_css');

/**
 * Create customizer directory if it doesn't exist
 */
function yoursite_create_customizer_directory() {
    $customizer_dir = get_template_directory() . '/inc/customizer';
    if (!file_exists($customizer_dir)) {
        wp_mkdir_p($customizer_dir);
    }
}
add_action('after_setup_theme', 'yoursite_create_customizer_directory', 1);
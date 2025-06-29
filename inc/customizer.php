<?php
/**
 * Main theme customizer loader - UPDATED VERSION WITH ALL MODULES
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load all customizer modules in proper order
 */
function yoursite_load_customizer_modules() {
    $customizer_modules = array(
        'customizer-homepage.php',      // Homepage editor
        'customizer-header.php',        // Header settings (UPDATED)
        'customizer-footer.php',        // Footer settings (UPDATED)
        'customizer-colors.php',        // Colors and typography
        'customizer-company.php',       // Company information (UPDATED)
        'customizer-social.php',        // Social media links (UPDATED)
        'customizer-features.php',      // Features page
        'customizer-pricing.php',       // Pricing page
        'customizer-contact.php',       // Contact page
        'customizer-about.php',         // About page
        'customizer-templates.php',     // Templates page
        'customizer-partners.php',      // Partners page
        'customizer-webinars.php',      // Webinars page
        'customizer-press-kit.php',     // Press Kit page
        'customizer-difm.php',          // DIFM Page
        'customizer-newsletter.php',    // Newsletter settings
        'customizer-trust-badges.php',  // Trust badges and security
        'customizer-performance.php',   // Performance settings
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
 * Main customizer registration with enhanced organization
 */
function yoursite_customize_register($wp_customize) {
    
    // Add main panel for page editing
    $wp_customize->add_panel('yoursite_pages', array(
        'title' => __('📄 Edit Pages', 'yoursite'),
        'description' => __('Customize all page elements including content, images, and settings', 'yoursite'),
        'priority' => 10,
    ));
    
    // Theme Options panel  
    $wp_customize->add_panel('yoursite_theme_options', array(
        'title' => __('🎨 Theme Options', 'yoursite'),
        'description' => __('General theme settings, colors, fonts, and layout options', 'yoursite'),
        'priority' => 20,
    ));
    
    // Business Settings panel
    $wp_customize->add_panel('yoursite_business', array(
        'title' => __('🏢 Business Settings', 'yoursite'),
        'description' => __('Company information, contact details, and business-related settings', 'yoursite'),
        'priority' => 30,
    ));
    
    // Move existing sections to appropriate panels
    $sections_to_move = array(
        'company_info_section' => 'yoursite_business',
        'social_media_section' => 'yoursite_business',
        'header_section' => 'yoursite_theme_options',
        'footer_section' => 'yoursite_theme_options',
        'homepage_editor' => 'yoursite_pages',
        'pricing_page_editor' => 'yoursite_pages',
        'features_page_editor' => 'yoursite_pages',
    );
    
    foreach ($sections_to_move as $section_id => $panel_id) {
        if ($wp_customize->get_section($section_id)) {
            $wp_customize->get_section($section_id)->panel = $panel_id;
        }
    }
    
    // Add Custom CSS section to Theme Options panel
    if ($wp_customize->get_section('custom_css')) {
        $wp_customize->get_section('custom_css')->panel = 'yoursite_theme_options';
        $wp_customize->get_section('custom_css')->priority = 200;
    }
    
    // Reorganize WordPress default sections
    if ($wp_customize->get_section('title_tagline')) {
        $wp_customize->get_section('title_tagline')->panel = 'yoursite_business';
        $wp_customize->get_section('title_tagline')->priority = 10;
        $wp_customize->get_section('title_tagline')->title = __('Site Identity & Logo', 'yoursite');
    }
    
    if ($wp_customize->get_section('colors')) {
        $wp_customize->get_section('colors')->panel = 'yoursite_theme_options';
        $wp_customize->get_section('colors')->priority = 50;
    }
    
    if ($wp_customize->get_section('background_image')) {
        $wp_customize->get_section('background_image')->panel = 'yoursite_theme_options';
        $wp_customize->get_section('background_image')->priority = 60;
    }
    
    // Enhanced site identity with better organization
    $wp_customize->add_setting('site_description_extended', array(
        'default' => __('The easiest way to build and grow your online store', 'yoursite'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('site_description_extended', array(
        'label' => __('Extended Site Description', 'yoursite'),
        'description' => __('Longer description used in hero sections and meta descriptions', 'yoursite'),
        'section' => 'title_tagline',
        'type' => 'textarea',
        'priority' => 25,
    ));
}
add_action('customize_register', 'yoursite_customize_register', 1);

/**
 * Enhanced sanitize checkbox function
 */
function yoursite_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize select options
 */
function yoursite_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Sanitize number range
 */
function yoursite_sanitize_number_range($number, $setting) {
    $number = absint($number);
    $atts = $setting->manager->get_control($setting->id)->input_attrs;
    $min = (isset($atts['min']) ? $atts['min'] : $number);
    $max = (isset($atts['max']) ? $atts['max'] : $number);
    $step = (isset($atts['step']) ? $atts['step'] : 1);
    
    return ($min <= $number && $number <= $max && is_int($number / $step)) ? $number : $setting->default;
}

/**
 * Output enhanced custom CSS based on customizer settings
 */
function yoursite_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#667eea');
    $secondary_color = get_theme_mod('secondary_color', '#764ba2');
    $body_font = get_theme_mod('body_font_family', 'Inter');
    $heading_font = get_theme_mod('heading_font_family', 'Inter');
    $custom_css = get_theme_mod('custom_css', '');
    
    // Only output if values have changed from defaults
    if ($primary_color !== '#667eea' || $secondary_color !== '#764ba2' || $body_font !== 'Inter' || $heading_font !== 'Inter' || !empty($custom_css)) {
        ?>
        <style type="text/css" id="yoursite-customizer-css">
        <?php
        // CSS Custom Properties for better theming
        echo ':root {';
        if ($primary_color !== '#667eea') {
            echo '--primary-color: ' . esc_html($primary_color) . ';';
        }
        if ($secondary_color !== '#764ba2') {
            echo '--secondary-color: ' . esc_html($secondary_color) . ';';
        }
        echo '}';
        
        // Font families
        if ($body_font !== 'Inter') : ?>
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
        
        a {
            color: <?php echo esc_html($primary_color); ?> !important;
        }
        
        .social-link:hover {
            color: <?php echo esc_html($primary_color); ?> !important;
        }
        <?php endif; ?>
        
        <?php
        // Output any custom CSS
        if (!empty($custom_css)) {
            echo wp_strip_all_tags($custom_css);
        }
        ?>
        </style>
        <?php
    }
}
add_action('wp_head', 'yoursite_customizer_css', 15);

/**
 * Add live preview JavaScript for customizer
 */
function yoursite_customizer_live_preview() {
    wp_enqueue_script(
        'yoursite-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array('jquery', 'customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'yoursite_customizer_live_preview');

/**
 * Add customizer controls JavaScript
 */
function yoursite_customizer_controls() {
    wp_enqueue_script(
        'yoursite-customizer-controls',
        get_template_directory_uri() . '/assets/js/customizer-controls.js',
        array('jquery', 'customize-controls'),
        '1.0.0',
        true
    );
    
    wp_enqueue_style(
        'yoursite-customizer-controls',
        get_template_directory_uri() . '/assets/css/customizer-controls.css',
        array(),
        '1.0.0'
    );
}
add_action('customize_controls_enqueue_scripts', 'yoursite_customizer_controls');

/**
 * Create missing customizer files if needed (without conflicting with theme-activation.php)
 */
function yoursite_ensure_customizer_assets() {
    // Create assets directory for customizer JS/CSS
    $assets_dir = get_template_directory() . '/assets';
    if (!file_exists($assets_dir)) {
        wp_mkdir_p($assets_dir . '/js');
        wp_mkdir_p($assets_dir . '/css');
    }
    
    // Create basic customizer control files if they don't exist
    $js_file = $assets_dir . '/js/customizer-preview.js';
    if (!file_exists($js_file)) {
        $js_content = "/**\n * Customizer live preview\n */\n(function($) {\n    // Add live preview functionality here\n})(jQuery);";
        file_put_contents($js_file, $js_content);
    }
    
    $css_file = $assets_dir . '/css/customizer-controls.css';
    if (!file_exists($css_file)) {
        $css_content = "/**\n * Customizer control styles\n */\n.customize-control { /* Add custom styles here */ }";
        file_put_contents($css_file, $css_content);
    }
}
add_action('customize_controls_enqueue_scripts', 'yoursite_ensure_customizer_assets', 1);

/**
 * Add customizer contextual help
 */
function yoursite_customizer_help() {
    $screen = get_current_screen();
    
    if ($screen && $screen->id === 'customize') {
        $screen->add_help_tab(array(
            'id' => 'yoursite_customizer_help',
            'title' => __('YourSite Theme Help'),
            'content' => '<h3>' . __('Using the YourSite Customizer') . '</h3>
                <p>' . __('The YourSite theme customizer is organized into three main panels:') . '</p>
                <ul>
                    <li><strong>' . __('Edit Pages') . '</strong> - ' . __('Customize content and settings for specific pages') . '</li>
                    <li><strong>' . __('Theme Options') . '</strong> - ' . __('Control colors, fonts, layout, and design elements') . '</li>
                    <li><strong>' . __('Business Settings') . '</strong> - ' . __('Manage company information and contact details') . '</li>
                </ul>
                <p>' . __('Changes are previewed live and saved when you click "Publish".') . '</p>'
        ));
    }
}
add_action('current_screen', 'yoursite_customizer_help');
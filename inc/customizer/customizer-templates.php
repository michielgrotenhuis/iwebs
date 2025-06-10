<?php
/**
 * Templates Page Customizer Settings
 * Create this file as: inc/customizer/customizer-templates.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Templates Page customizer options
 */
function yoursite_templates_page_customizer($wp_customize) {
    
    // Templates Page Section (goes under the main Edit Pages panel)
    $wp_customize->add_section('templates_page_editor', array(
        'title' => __('Templates Page', 'yoursite'),
        'description' => __('Customize all elements of the Templates page', 'yoursite'),
        'panel' => 'yoursite_pages', // Use the main panel
        'priority' => 30,
    ));
    
    // ========================================
    // HERO SECTION
    // ========================================
    
    // Hero Enable/Disable
    $wp_customize->add_setting('templates_hero_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Hero Title
    $wp_customize->add_setting('templates_hero_title', array(
        'default' => __('Beautiful templates for every business', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 11,
        'active_callback' => function() {
            return get_theme_mod('templates_hero_enable', true);
        },
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('templates_hero_subtitle', array(
        'default' => __('Choose from 100+ professionally designed templates. All mobile-responsive, SEO-optimized, and ready to customize for your brand.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'textarea',
        'priority' => 12,
        'active_callback' => function() {
            return get_theme_mod('templates_hero_enable', true);
        },
    ));
    
    // Hero Background Color
    $wp_customize->add_setting('templates_hero_bg_color', array(
        'default' => '#f3e8ff', // purple-50
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'templates_hero_bg_color', array(
        'label' => __('Hero Background Color (Start)', 'yoursite'),
        'section' => 'templates_page_editor',
        'priority' => 13,
        'active_callback' => function() {
            return get_theme_mod('templates_hero_enable', true);
        },
    )));
    
    // Hero Background Color End
    $wp_customize->add_setting('templates_hero_bg_color_end', array(
        'default' => '#fce7f3', // pink-100
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'templates_hero_bg_color_end', array(
        'label' => __('Hero Background Color (End)', 'yoursite'),
        'section' => 'templates_page_editor',
        'priority' => 14,
        'active_callback' => function() {
            return get_theme_mod('templates_hero_enable', true);
        },
    )));
    
    // ========================================
    // FEATURED TEMPLATES SECTION
    // ========================================
    
    // Featured Templates Separator
    $wp_customize->add_setting('templates_separator_1', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('templates_separator_1', array(
        'label' => __('── Featured Templates Section ──', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 20,
        'description' => __('Configure the featured templates showcase', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Featured Section Enable
    $wp_customize->add_setting('templates_featured_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_featured_enable', array(
        'label' => __('Enable Featured Templates Section', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'checkbox',
        'priority' => 21,
    ));
    
    // Featured Section Title
    $wp_customize->add_setting('templates_featured_title', array(
        'default' => __('Featured Templates', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_featured_title', array(
        'label' => __('Featured Section Title', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 22,
        'active_callback' => function() {
            return get_theme_mod('templates_featured_enable', true);
        },
    ));
    
    // Featured Section Subtitle
    $wp_customize->add_setting('templates_featured_subtitle', array(
        'default' => __('Our most popular and versatile designs', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_featured_subtitle', array(
        'label' => __('Featured Section Subtitle', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 23,
        'active_callback' => function() {
            return get_theme_mod('templates_featured_enable', true);
        },
    ));
    
    // Featured Template 1 Settings
    for ($i = 1; $i <= 3; $i++) {
        $defaults = array(
            1 => array(
                'name' => __('Luxe Fashion', 'yoursite'),
                'description' => __('Perfect for high-end fashion brands with elegant product showcases', 'yoursite'),
                'category' => __('Fashion', 'yoursite'),
                'rating' => '4.8',
                'icon_color' => '#ec4899' // pink-500
            ),
            2 => array(
                'name' => __('TechVault', 'yoursite'),
                'description' => __('Modern design for electronics with detailed product specifications', 'yoursite'),
                'category' => __('Electronics', 'yoursite'),
                'rating' => '4.9',
                'icon_color' => '#3b82f6' // blue-500
            ),
            3 => array(
                'name' => __('Gourmet Kitchen', 'yoursite'),
                'description' => __('Warm, inviting design perfect for food and beverage stores', 'yoursite'),
                'category' => __('Food & Drink', 'yoursite'),
                'rating' => '4.7',
                'icon_color' => '#f97316' // orange-500
            )
        );
        
        // Template Enable
        $wp_customize->add_setting("templates_featured_template_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("templates_featured_template_{$i}_enable", array(
            'label' => sprintf(__('Enable Featured Template %d', 'yoursite'), $i),
            'section' => 'templates_page_editor',
            'type' => 'checkbox',
            'priority' => 23 + ($i * 6),
            'active_callback' => function() {
                return get_theme_mod('templates_featured_enable', true);
            },
        ));
        
        // Template Name
        $wp_customize->add_setting("templates_featured_template_{$i}_name", array(
            'default' => $defaults[$i]['name'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("templates_featured_template_{$i}_name", array(
            'label' => sprintf(__('Template %d Name', 'yoursite'), $i),
            'section' => 'templates_page_editor',
            'type' => 'text',
            'priority' => 24 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('templates_featured_enable', true) && get_theme_mod("templates_featured_template_{$i}_enable", true);
            },
        ));
        
        // Template Description
        $wp_customize->add_setting("templates_featured_template_{$i}_description", array(
            'default' => $defaults[$i]['description'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("templates_featured_template_{$i}_description", array(
            'label' => sprintf(__('Template %d Description', 'yoursite'), $i),
            'section' => 'templates_page_editor',
            'type' => 'textarea',
            'priority' => 25 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('templates_featured_enable', true) && get_theme_mod("templates_featured_template_{$i}_enable", true);
            },
        ));
        
        // Template Category
        $wp_customize->add_setting("templates_featured_template_{$i}_category", array(
            'default' => $defaults[$i]['category'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("templates_featured_template_{$i}_category", array(
            'label' => sprintf(__('Template %d Category', 'yoursite'), $i),
            'section' => 'templates_page_editor',
            'type' => 'text',
            'priority' => 26 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('templates_featured_enable', true) && get_theme_mod("templates_featured_template_{$i}_enable", true);
            },
        ));
        
        // Template Rating
        $wp_customize->add_setting("templates_featured_template_{$i}_rating", array(
            'default' => $defaults[$i]['rating'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("templates_featured_template_{$i}_rating", array(
            'label' => sprintf(__('Template %d Rating', 'yoursite'), $i),
            'section' => 'templates_page_editor',
            'type' => 'text',
            'priority' => 27 + ($i * 6),
            'description' => __('e.g., 4.8', 'yoursite'),
            'active_callback' => function() use ($i) {
                return get_theme_mod('templates_featured_enable', true) && get_theme_mod("templates_featured_template_{$i}_enable", true);
            },
        ));
        
        // Template Icon Color
        $wp_customize->add_setting("templates_featured_template_{$i}_icon_color", array(
            'default' => $defaults[$i]['icon_color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "templates_featured_template_{$i}_icon_color", array(
            'label' => sprintf(__('Template %d Icon Color', 'yoursite'), $i),
            'section' => 'templates_page_editor',
            'priority' => 28 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('templates_featured_enable', true) && get_theme_mod("templates_featured_template_{$i}_enable", true);
            },
        )));
    }
    
    // ========================================
    // ALL TEMPLATES SECTION
    // ========================================
    
    // All Templates Separator
    $wp_customize->add_setting('templates_separator_2', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('templates_separator_2', array(
        'label' => __('── All Templates Section ──', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 50,
        'description' => __('Configure the templates grid section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // All Templates Section Enable
    $wp_customize->add_setting('templates_grid_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_grid_enable', array(
        'label' => __('Enable All Templates Section', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'checkbox',
        'priority' => 51,
    ));
    
    // All Templates Title
    $wp_customize->add_setting('templates_grid_title', array(
        'default' => __('All Templates', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_grid_title', array(
        'label' => __('All Templates Section Title', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 52,
        'active_callback' => function() {
            return get_theme_mod('templates_grid_enable', true);
        },
    ));
    
    // All Templates Subtitle
    $wp_customize->add_setting('templates_grid_subtitle', array(
        'default' => __('Browse our complete collection of templates', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_grid_subtitle', array(
        'label' => __('All Templates Section Subtitle', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 53,
        'active_callback' => function() {
            return get_theme_mod('templates_grid_enable', true);
        },
    ));
    
    // Grid Background Color
    $wp_customize->add_setting('templates_grid_bg_color', array(
        'default' => '#f9fafb', // gray-50
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'templates_grid_bg_color', array(
        'label' => __('Grid Section Background Color', 'yoursite'),
        'section' => 'templates_page_editor',
        'priority' => 54,
        'active_callback' => function() {
            return get_theme_mod('templates_grid_enable', true);
        },
    )));
    
    // ========================================
    // WHY CHOOSE OUR TEMPLATES SECTION
    // ========================================
    
    // Features Separator
    $wp_customize->add_setting('templates_separator_3', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('templates_separator_3', array(
        'label' => __('── Why Choose Our Templates Section ──', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 60,
        'description' => __('Configure the features/benefits section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Features Section Enable
    $wp_customize->add_setting('templates_features_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_features_enable', array(
        'label' => __('Enable Template Features Section', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'checkbox',
        'priority' => 61,
    ));
    
    // Features Section Title
    $wp_customize->add_setting('templates_features_title', array(
        'default' => __('Why Choose Our Templates?', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_features_title', array(
        'label' => __('Features Section Title', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 62,
        'active_callback' => function() {
            return get_theme_mod('templates_features_enable', true);
        },
    ));
    
    // Features Section Subtitle
    $wp_customize->add_setting('templates_features_subtitle', array(
        'default' => __('Every template is built with best practices and conversion optimization', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_features_subtitle', array(
        'label' => __('Features Section Subtitle', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 63,
        'active_callback' => function() {
            return get_theme_mod('templates_features_enable', true);
        },
    ));
    
    // Template Features (4 features)
    $feature_defaults = array(
        1 => array('title' => __('Mobile Responsive', 'yoursite'), 'desc' => __('Perfect on every device and screen size', 'yoursite')),
        2 => array('title' => __('SEO Optimized', 'yoursite'), 'desc' => __('Built-in SEO best practices for better rankings', 'yoursite')),
        3 => array('title' => __('Fast Loading', 'yoursite'), 'desc' => __('Optimized for speed and performance', 'yoursite')),
        4 => array('title' => __('Easy Customization', 'yoursite'), 'desc' => __('Drag & drop customization without coding', 'yoursite'))
    );
    
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("templates_feature_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("templates_feature_{$i}_enable", array(
            'label' => sprintf(__('Enable Feature %d', 'yoursite'), $i),
            'section' => 'templates_page_editor',
            'type' => 'checkbox',
            'priority' => 63 + ($i * 3),
            'active_callback' => function() {
                return get_theme_mod('templates_features_enable', true);
            },
        ));
        
        $wp_customize->add_setting("templates_feature_{$i}_title", array(
            'default' => $feature_defaults[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("templates_feature_{$i}_title", array(
            'label' => sprintf(__('Feature %d Title', 'yoursite'), $i),
            'section' => 'templates_page_editor',
            'type' => 'text',
            'priority' => 64 + ($i * 3),
            'active_callback' => function() use ($i) {
                return get_theme_mod('templates_features_enable', true) && get_theme_mod("templates_feature_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("templates_feature_{$i}_description", array(
            'default' => $feature_defaults[$i]['desc'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("templates_feature_{$i}_description", array(
            'label' => sprintf(__('Feature %d Description', 'yoursite'), $i),
            'section' => 'templates_page_editor',
            'type' => 'textarea',
            'priority' => 65 + ($i * 3),
            'active_callback' => function() use ($i) {
                return get_theme_mod('templates_features_enable', true) && get_theme_mod("templates_feature_{$i}_enable", true);
            },
        ));
    }
    
    // ========================================
    // CTA SECTION
    // ========================================
    
    // CTA Separator
    $wp_customize->add_setting('templates_separator_4', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('templates_separator_4', array(
        'label' => __('── Call-to-Action Section ──', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 80,
        'description' => __('Configure the final CTA section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // CTA Enable
    $wp_customize->add_setting('templates_cta_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_cta_enable', array(
        'label' => __('Enable CTA Section', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'checkbox',
        'priority' => 81,
    ));
    
    // CTA Title
    $wp_customize->add_setting('templates_cta_title', array(
        'default' => __('Ready to build your store?', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_cta_title', array(
        'label' => __('CTA Title', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 82,
        'active_callback' => function() {
            return get_theme_mod('templates_cta_enable', true);
        },
    ));
    
    // CTA Description
    $wp_customize->add_setting('templates_cta_description', array(
        'default' => __('Choose a template and customize it to match your brand in minutes', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_cta_description', array(
        'label' => __('CTA Description', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'textarea',
        'priority' => 83,
        'active_callback' => function() {
            return get_theme_mod('templates_cta_enable', true);
        },
    ));
    
    // CTA Primary Button
    $wp_customize->add_setting('templates_cta_primary_text', array(
        'default' => __('Start Free Trial', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_cta_primary_text', array(
        'label' => __('Primary Button Text', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 84,
        'active_callback' => function() {
            return get_theme_mod('templates_cta_enable', true);
        },
    ));
    
    $wp_customize->add_setting('templates_cta_primary_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_cta_primary_url', array(
        'label' => __('Primary Button URL', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'url',
        'priority' => 85,
        'active_callback' => function() {
            return get_theme_mod('templates_cta_enable', true);
        },
    ));
    
    // CTA Secondary Button
    $wp_customize->add_setting('templates_cta_secondary_text', array(
        'default' => __('View Pricing', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_cta_secondary_text', array(
        'label' => __('Secondary Button Text', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'text',
        'priority' => 86,
        'active_callback' => function() {
            return get_theme_mod('templates_cta_enable', true);
        },
    ));
    
    $wp_customize->add_setting('templates_cta_secondary_url', array(
        'default' => '/pricing',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('templates_cta_secondary_url', array(
        'label' => __('Secondary Button URL', 'yoursite'),
        'section' => 'templates_page_editor',
        'type' => 'url',
        'priority' => 87,
        'active_callback' => function() {
            return get_theme_mod('templates_cta_enable', true);
        },
    ));
}
add_action('customize_register', 'yoursite_templates_page_customizer');
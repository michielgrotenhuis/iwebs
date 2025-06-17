<?php
/**
 * DIFM Page Customizer Settings
 * Create this file as: inc/customizer/customizer-difm.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add DIFM Page customizer options
 */
function yoursite_difm_page_customizer($wp_customize) {
    
    // DIFM Page Section (goes under the main Edit Pages panel)
    $wp_customize->add_section('difm_page_editor', array(
        'title' => __('DIFM - Do It For Me Page', 'yoursite'),
        'description' => __('Customize all elements of the DIFM page', 'yoursite'),
        'panel' => 'yoursite_pages',
        'priority' => 70,
    ));
    
    // ========================================
    // HERO SECTION
    // ========================================
    
    // Hero Enable/Disable
    $wp_customize->add_setting('difm_hero_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Hero Title
    $wp_customize->add_setting('difm_hero_title', array(
        'default' => __('Let Us Build Your Dream Website', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 11,
        'active_callback' => function() {
            return get_theme_mod('difm_hero_enable', true);
        },
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('difm_hero_subtitle', array(
        'default' => __('Professional website design and development service. Choose your package and let our experts handle everything while you focus on your business.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'textarea',
        'priority' => 12,
        'active_callback' => function() {
            return get_theme_mod('difm_hero_enable', true);
        },
    ));
    
    // Hero CTA Text
    $wp_customize->add_setting('difm_hero_cta_text', array(
        'default' => __('View Packages', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_cta_text', array(
        'label' => __('Primary CTA Button Text', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 13,
        'active_callback' => function() {
            return get_theme_mod('difm_hero_enable', true);
        },
    ));
    
    // Hero Secondary CTA Text
    $wp_customize->add_setting('difm_hero_secondary_cta', array(
        'default' => __('How It Works', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_secondary_cta', array(
        'label' => __('Secondary CTA Button Text', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 14,
        'active_callback' => function() {
            return get_theme_mod('difm_hero_enable', true);
        },
    ));
    
    // ========================================
    // BENEFITS SECTION
    // ========================================
    
    // Separator
    $wp_customize->add_setting('difm_separator_1', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('difm_separator_1', array(
        'label' => __('── Benefits Section ──', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 20,
        'description' => __('Configure the benefits/why choose us section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Benefits Enable
    $wp_customize->add_setting('difm_benefits_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_benefits_enable', array(
        'label' => __('Enable Benefits Section', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'checkbox',
        'priority' => 21,
    ));
    
    // Benefits Title
    $wp_customize->add_setting('difm_benefits_title', array(
        'default' => __('Why Choose Our DIFM Service?', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_benefits_title', array(
        'label' => __('Benefits Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 22,
        'active_callback' => function() {
            return get_theme_mod('difm_benefits_enable', true);
        },
    ));
    
    // Benefits Subtitle
    $wp_customize->add_setting('difm_benefits_subtitle', array(
        'default' => __('Professional results without the hassle', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_benefits_subtitle', array(
        'label' => __('Benefits Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 23,
        'active_callback' => function() {
            return get_theme_mod('difm_benefits_enable', true);
        },
    ));
    
    // Benefits (4 benefits)
    $benefit_defaults = array(
        1 => array(
            'title' => __('Fast Delivery', 'yoursite'),
            'description' => __('Get your website up and running in just 14 days', 'yoursite'),
            'color' => '#3b82f6'
        ),
        2 => array(
            'title' => __('Professional Quality', 'yoursite'),
            'description' => __('Expert designers and developers create your perfect site', 'yoursite'),
            'color' => '#10b981'
        ),
        3 => array(
            'title' => __('No Hassle', 'yoursite'),
            'description' => __('We handle everything while you focus on your business', 'yoursite'),
            'color' => '#8b5cf6'
        ),
        4 => array(
            'title' => __('Full Support', 'yoursite'),
            'description' => __('Ongoing support and maintenance after launch', 'yoursite'),
            'color' => '#f97316'
        )
    );
    
    for ($i = 1; $i <= 4; $i++) {
        // Benefit Enable
        $wp_customize->add_setting("difm_benefit_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_benefit_{$i}_enable", array(
            'label' => sprintf(__('Enable Benefit %d', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'checkbox',
            'priority' => 23 + ($i * 4),
            'active_callback' => function() {
                return get_theme_mod('difm_benefits_enable', true);
            },
        ));
        
        // Benefit Title
        $wp_customize->add_setting("difm_benefit_{$i}_title", array(
            'default' => $benefit_defaults[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_benefit_{$i}_title", array(
            'label' => sprintf(__('Benefit %d Title', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'text',
            'priority' => 24 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_benefits_enable', true) && get_theme_mod("difm_benefit_{$i}_enable", true);
            },
        ));
        
        // Benefit Description
        $wp_customize->add_setting("difm_benefit_{$i}_description", array(
            'default' => $benefit_defaults[$i]['description'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_benefit_{$i}_description", array(
            'label' => sprintf(__('Benefit %d Description', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'textarea',
            'priority' => 25 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_benefits_enable', true) && get_theme_mod("difm_benefit_{$i}_enable", true);
            },
        ));
        
        // Benefit Color
        $wp_customize->add_setting("difm_benefit_{$i}_color", array(
            'default' => $benefit_defaults[$i]['color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "difm_benefit_{$i}_color", array(
            'label' => sprintf(__('Benefit %d Icon Color', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'priority' => 26 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_benefits_enable', true) && get_theme_mod("difm_benefit_{$i}_enable", true);
            },
        )));
    }
    
    // ========================================
    // PACKAGES SECTION
    // ========================================
    
    // Separator
    $wp_customize->add_setting('difm_separator_2', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('difm_separator_2', array(
        'label' => __('── Packages Section ──', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 50,
        'description' => __('Configure the packages section (packages are managed in WP Admin)', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Packages Enable
    $wp_customize->add_setting('difm_packages_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_packages_enable', array(
        'label' => __('Enable Packages Section', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'checkbox',
        'priority' => 51,
    ));
    
    // Packages Title
    $wp_customize->add_setting('difm_packages_title', array(
        'default' => __('Choose Your Perfect Package', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_packages_title', array(
        'label' => __('Packages Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 52,
        'active_callback' => function() {
            return get_theme_mod('difm_packages_enable', true);
        },
    ));
    
    // Packages Subtitle
    $wp_customize->add_setting('difm_packages_subtitle', array(
        'default' => __('All packages include free project implementation and professional design', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_packages_subtitle', array(
        'label' => __('Packages Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 53,
        'active_callback' => function() {
            return get_theme_mod('difm_packages_enable', true);
        },
    ));
    
    // Comparison Table Enable
    $wp_customize->add_setting('difm_comparison_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_comparison_enable', array(
        'label' => __('Enable Feature Comparison Table', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'checkbox',
        'priority' => 54,
        'active_callback' => function() {
            return get_theme_mod('difm_packages_enable', true);
        },
    ));
    
    // Comparison Title
    $wp_customize->add_setting('difm_comparison_title', array(
        'default' => __('Detailed Feature Comparison', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_comparison_title', array(
        'label' => __('Comparison Table Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 55,
        'active_callback' => function() {
            return get_theme_mod('difm_packages_enable', true) && get_theme_mod('difm_comparison_enable', true);
        },
    ));
    
    // ========================================
    // PROCESS SECTION
    // ========================================
    
    // Separator
    $wp_customize->add_setting('difm_separator_3', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('difm_separator_3', array(
        'label' => __('── How It Works Section ──', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 60,
        'description' => __('Configure the process/how it works section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Process Enable
    $wp_customize->add_setting('difm_process_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_process_enable', array(
        'label' => __('Enable How It Works Section', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'checkbox',
        'priority' => 61,
    ));
    
    // Process Title
    $wp_customize->add_setting('difm_process_title', array(
        'default' => __('How Our Process Works', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_process_title', array(
        'label' => __('Process Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 62,
        'active_callback' => function() {
            return get_theme_mod('difm_process_enable', true);
        },
    ));
    
    // Process Subtitle
    $wp_customize->add_setting('difm_process_subtitle', array(
        'default' => __('Simple, straightforward, and professional', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_process_subtitle', array(
        'label' => __('Process Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 63,
        'active_callback' => function() {
            return get_theme_mod('difm_process_enable', true);
        },
    ));
    
    // Process Steps (4 steps)
    $step_defaults = array(
        1 => array(
            'title' => __('Fill Out Form', 'yoursite'),
            'description' => __('Complete our simple onboarding form with your requirements', 'yoursite')
        ),
        2 => array(
            'title' => __('We Plan', 'yoursite'),
            'description' => __('Our team creates a custom plan and design strategy for your project', 'yoursite')
        ),
        3 => array(
            'title' => __('We Build', 'yoursite'),
            'description' => __('Expert designers and developers bring your vision to life', 'yoursite')
        ),
        4 => array(
            'title' => __('You Launch', 'yoursite'),
            'description' => __('Your professional website goes live and starts working for you', 'yoursite')
        )
    );
    
    for ($i = 1; $i <= 4; $i++) {
        // Step Enable
        $wp_customize->add_setting("difm_step_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_step_{$i}_enable", array(
            'label' => sprintf(__('Enable Step %d', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'checkbox',
            'priority' => 63 + ($i * 3),
            'active_callback' => function() {
                return get_theme_mod('difm_process_enable', true);
            },
        ));
        
        // Step Title
        $wp_customize->add_setting("difm_step_{$i}_title", array(
            'default' => $step_defaults[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_step_{$i}_title", array(
            'label' => sprintf(__('Step %d Title', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'text',
            'priority' => 64 + ($i * 3),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_process_enable', true) && get_theme_mod("difm_step_{$i}_enable", true);
            },
        ));
        
        // Step Description
        $wp_customize->add_setting("difm_step_{$i}_description", array(
            'default' => $step_defaults[$i]['description'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_step_{$i}_description", array(
            'label' => sprintf(__('Step %d Description', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'textarea',
            'priority' => 65 + ($i * 3),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_process_enable', true) && get_theme_mod("difm_step_{$i}_enable", true);
            },
        ));
    }
    
    // ========================================
    // TESTIMONIALS SECTION (Optional)
    // ========================================
    
    // Separator
    $wp_customize->add_setting('difm_separator_4', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('difm_separator_4', array(
        'label' => __('── Testimonials Section ──', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 80,
        'description' => __('Configure optional testimonials section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Testimonials Enable
    $wp_customize->add_setting('difm_testimonials_enable', array(
        'default' => false,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_testimonials_enable', array(
        'label' => __('Enable Testimonials Section', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'checkbox',
        'priority' => 81,
    ));
    
    // Testimonials Title
    $wp_customize->add_setting('difm_testimonials_title', array(
        'default' => __('What Our Clients Say', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_testimonials_title', array(
        'label' => __('Testimonials Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 82,
        'active_callback' => function() {
            return get_theme_mod('difm_testimonials_enable', false);
        },
    ));
    
    // Testimonials Subtitle
    $wp_customize->add_setting('difm_testimonials_subtitle', array(
        'default' => __('Success stories from businesses we\'ve helped grow', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_testimonials_subtitle', array(
        'label' => __('Testimonials Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 83,
        'active_callback' => function() {
            return get_theme_mod('difm_testimonials_enable', false);
        },
    ));
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_difm_page_customizer');
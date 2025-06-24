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
$wp_customize->add_control('difm_hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Hero Title
    $wp_customize->add_setting('difm_hero_title', array(
        'default' => __('Professional Website Development Done For You', 'yoursite'),
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
        'default' => __('Skip the hassle of DIY website building. Our expert team creates stunning, conversion-optimized websites that work from day one. Focus on your business while we handle the tech.', 'yoursite'),
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
    
    // Hero Trust Badges
    $wp_customize->add_setting('difm_hero_rating', array(
        'default' => __('4.9/5 Rating', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_rating', array(
        'label' => __('Rating Badge', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 13,
        'active_callback' => function() {
            return get_theme_mod('difm_hero_enable', true);
        },
    ));
    
    $wp_customize->add_setting('difm_hero_projects', array(
        'default' => __('500+ Projects Completed', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_projects', array(
        'label' => __('Projects Badge', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 14,
        'active_callback' => function() {
            return get_theme_mod('difm_hero_enable', true);
        },
    ));
    
    $wp_customize->add_setting('difm_hero_guarantee', array(
        'default' => __('100% Money-Back Guarantee', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_guarantee', array(
        'label' => __('Guarantee Badge', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 15,
        'active_callback' => function() {
            return get_theme_mod('difm_hero_enable', true);
        },
    ));
    
    // Hero CTA Text
    $wp_customize->add_setting('difm_hero_cta_text', array(
        'default' => __('Get Started Now - Free Consultation', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_cta_text', array(
        'label' => __('Primary CTA Button Text', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 16,
        'active_callback' => function() {
            return get_theme_mod('difm_hero_enable', true);
        },
    ));
    
    // Hero Secondary CTA Text
    $wp_customize->add_setting('difm_hero_secondary_cta', array(
        'default' => __('View Our Packages', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_secondary_cta', array(
        'label' => __('Secondary CTA Button Text', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 17,
        'active_callback' => function() {
            return get_theme_mod('difm_hero_enable', true);
        },
    ));
    
    // Hero Statistics
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("difm_stat_{$i}_number", array(
            'default' => $i == 1 ? '5-14' : ($i == 2 ? '98%' : ($i == 3 ? '24/7' : '500+')),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_stat_{$i}_number", array(
            'label' => sprintf(__('Stat %d Number', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'text',
            'priority' => 17 + $i,
            'active_callback' => function() {
                return get_theme_mod('difm_hero_enable', true);
            },
        ));
        
        $wp_customize->add_setting("difm_stat_{$i}_label", array(
            'default' => $i == 1 ? 'Days to Launch' : ($i == 2 ? 'Client Satisfaction' : ($i == 3 ? 'Support Available' : 'Websites Built')),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_stat_{$i}_label", array(
            'label' => sprintf(__('Stat %d Label', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'text',
            'priority' => 21 + $i,
            'active_callback' => function() {
                return get_theme_mod('difm_hero_enable', true);
            },
        ));
    }
    
    // ========================================
    // BENEFITS SECTION (Why Choose Us)
    // ========================================
    
    // Separator
    $wp_customize->add_setting('difm_separator_1', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('difm_separator_1', array(
        'label' => __('── Benefits Section (Why Choose Us) ──', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 30,
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
        'priority' => 31,
    ));
    
    // Benefits Title
    $wp_customize->add_setting('difm_benefits_title', array(
        'default' => __('Why 500+ Businesses Trust Us With Their Online Presence', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_benefits_title', array(
        'label' => __('Benefits Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 32,
        'active_callback' => function() {
            return get_theme_mod('difm_benefits_enable', true);
        },
    ));
    
    // Benefits Subtitle
    $wp_customize->add_setting('difm_benefits_subtitle', array(
        'default' => __('Building a professional website is complex. Let our proven team handle it while you focus on what you do best - running your business.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_benefits_subtitle', array(
        'label' => __('Benefits Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'textarea',
        'priority' => 33,
        'active_callback' => function() {
            return get_theme_mod('difm_benefits_enable', true);
        },
    ));
    
    // Benefits (3 benefits)
    $benefit_defaults = array(
        1 => array(
            'title' => __('Lightning Fast Delivery', 'yoursite'),
            'description' => __('Get your professional website live in 5-14 days, not months. Our streamlined process eliminates delays.', 'yoursite'),
            'color' => '#3b82f6',
            'features' => "5-day express option available\nDaily progress updates\nNo hidden delays"
        ),
        2 => array(
            'title' => __('Expert Team', 'yoursite'),
            'description' => __('Senior designers and developers with 10+ years experience building high-converting websites.', 'yoursite'),
            'color' => '#10b981',
            'features' => "Conversion optimization experts\nMobile-first approach\nSEO optimized"
        ),
        3 => array(
            'title' => __('Complete Support', 'yoursite'),
            'description' => __('From concept to launch and beyond. We provide training, maintenance, and ongoing support.', 'yoursite'),
            'color' => '#8b5cf6',
            'features' => "30-day support included\nTraining videos provided\nQuick response times"
        )
    );
    
    for ($i = 1; $i <= 3; $i++) {
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
            'priority' => 33 + ($i * 6),
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
            'priority' => 34 + ($i * 6),
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
            'priority' => 35 + ($i * 6),
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
            'priority' => 36 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_benefits_enable', true) && get_theme_mod("difm_benefit_{$i}_enable", true);
            },
        )));
        
        // Benefit Features
        $wp_customize->add_setting("difm_benefit_{$i}_features", array(
            'default' => $benefit_defaults[$i]['features'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_benefit_{$i}_features", array(
            'label' => sprintf(__('Benefit %d Features (one per line)', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'textarea',
            'priority' => 37 + ($i * 6),
            'description' => __('Enter features one per line. Will automatically add checkmarks.', 'yoursite'),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_benefits_enable', true) && get_theme_mod("difm_benefit_{$i}_enable", true);
            },
        ));
    }
    
    // ========================================
    // GUARANTEE SECTION
    // ========================================
    
    // Guarantee Enable
    $wp_customize->add_setting('difm_guarantee_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_guarantee_enable', array(
        'label' => __('Enable Money-Back Guarantee Section', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'checkbox',
        'priority' => 52,
        'active_callback' => function() {
            return get_theme_mod('difm_benefits_enable', true);
        },
    ));
    
    // Guarantee Title
    $wp_customize->add_setting('difm_guarantee_title', array(
        'default' => __('🛡️ 100% Money-Back Guarantee', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_guarantee_title', array(
        'label' => __('Guarantee Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 53,
        'active_callback' => function() {
            return get_theme_mod('difm_guarantee_enable', true);
        },
    ));
    
    // Guarantee Subtitle
    $wp_customize->add_setting('difm_guarantee_subtitle', array(
        'default' => __('Not satisfied? Get your money back. No questions asked.', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_guarantee_subtitle', array(
        'label' => __('Guarantee Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 54,
        'active_callback' => function() {
            return get_theme_mod('difm_guarantee_enable', true);
        },
    ));
    
    // Guarantee Description
    $wp_customize->add_setting('difm_guarantee_description', array(
        'default' => __('We\'re so confident in our work that we offer a complete money-back guarantee. If you\'re not 100% satisfied with your website, we\'ll refund every penny within 30 days. That\'s how sure we are that you\'ll love your new website.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_guarantee_description', array(
        'label' => __('Guarantee Description', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'textarea',
        'priority' => 55,
        'active_callback' => function() {
            return get_theme_mod('difm_guarantee_enable', true);
        },
    ));
    
    // ========================================
    // TESTIMONIALS SECTION
    // ========================================
    
    // Separator
    $wp_customize->add_setting('difm_separator_2', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('difm_separator_2', array(
        'label' => __('── Testimonials Section ──', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 60,
        'description' => __('Configure the testimonials section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Testimonials Enable
    $wp_customize->add_setting('difm_testimonials_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_testimonials_enable', array(
        'label' => __('Enable Testimonials Section', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'checkbox',
        'priority' => 61,
    ));
    
    // Testimonials Title
    $wp_customize->add_setting('difm_testimonials_title', array(
        'default' => __('What Our Clients Say About Working With Us', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_testimonials_title', array(
        'label' => __('Testimonials Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 62,
        'active_callback' => function() {
            return get_theme_mod('difm_testimonials_enable', true);
        },
    ));
    
    // Testimonials Subtitle
    $wp_customize->add_setting('difm_testimonials_subtitle', array(
        'default' => __('Real results from real businesses', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_testimonials_subtitle', array(
        'label' => __('Testimonials Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 63,
        'active_callback' => function() {
            return get_theme_mod('difm_testimonials_enable', true);
        },
    ));
    
    // Testimonials (3 testimonials)
    $testimonial_defaults = array(
        1 => array(
            'name' => 'Sarah Mitchell',
            'title' => 'CEO, Mitchell Marketing',
            'content' => 'They delivered exactly what we needed in just 7 days. Our new website has increased our leads by 300% in the first month alone. Best investment we\'ve made for our business.',
            'rating' => 5
        ),
        2 => array(
            'name' => 'James Rodriguez',
            'title' => 'Founder, TechStart Solutions',
            'content' => 'Professional, fast, and incredibly knowledgeable. They understood our vision immediately and delivered beyond our expectations. The ongoing support has been fantastic too.',
            'rating' => 5
        ),
        3 => array(
            'name' => 'Amanda Liu',
            'title' => 'Owner, Artisan Jewelry Co.',
            'content' => 'After struggling with DIY website builders for months, hiring them was a game-changer. They built our e-commerce store in 10 days and we started making sales immediately.',
            'rating' => 5
        )
    );
    
    for ($i = 1; $i <= 3; $i++) {
        // Testimonial Enable
        $wp_customize->add_setting("difm_testimonial_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_testimonial_{$i}_enable", array(
            'label' => sprintf(__('Enable Testimonial %d', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'checkbox',
            'priority' => 63 + ($i * 5),
            'active_callback' => function() {
                return get_theme_mod('difm_testimonials_enable', true);
            },
        ));
        
        // Testimonial Name
        $wp_customize->add_setting("difm_testimonial_{$i}_name", array(
            'default' => $testimonial_defaults[$i]['name'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_testimonial_{$i}_name", array(
            'label' => sprintf(__('Testimonial %d - Name', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'text',
            'priority' => 64 + ($i * 5),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_testimonials_enable', true) && get_theme_mod("difm_testimonial_{$i}_enable", true);
            },
        ));
        
        // Testimonial Title
        $wp_customize->add_setting("difm_testimonial_{$i}_title", array(
            'default' => $testimonial_defaults[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_testimonial_{$i}_title", array(
            'label' => sprintf(__('Testimonial %d - Title/Company', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'text',
            'priority' => 65 + ($i * 5),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_testimonials_enable', true) && get_theme_mod("difm_testimonial_{$i}_enable", true);
            },
        ));
        
        // Testimonial Content
        $wp_customize->add_setting("difm_testimonial_{$i}_content", array(
            'default' => $testimonial_defaults[$i]['content'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_testimonial_{$i}_content", array(
            'label' => sprintf(__('Testimonial %d - Content', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'textarea',
            'priority' => 66 + ($i * 5),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_testimonials_enable', true) && get_theme_mod("difm_testimonial_{$i}_enable", true);
            },
        ));
        
        // Testimonial Rating
        $wp_customize->add_setting("difm_testimonial_{$i}_rating", array(
            'default' => $testimonial_defaults[$i]['rating'],
            'sanitize_callback' => 'absint',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_testimonial_{$i}_rating", array(
            'label' => sprintf(__('Testimonial %d - Rating (1-5)', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'number',
            'input_attrs' => array('min' => 1, 'max' => 5),
            'priority' => 67 + ($i * 5),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_testimonials_enable', true) && get_theme_mod("difm_testimonial_{$i}_enable", true);
            },
        ));
    }
    
    // Trust Logos Enable
    $wp_customize->add_setting('difm_trust_logos_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_trust_logos_enable', array(
        'label' => __('Enable Trust Logos Section', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'checkbox',
        'priority' => 79,
        'active_callback' => function() {
            return get_theme_mod('difm_testimonials_enable', true);
        },
    ));
    
    // Trust Logos Text
    $wp_customize->add_setting('difm_trust_logos_text', array(
        'default' => __('Trusted by companies of all sizes', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_trust_logos_text', array(
        'label' => __('Trust Logos Text', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 80,
        'active_callback' => function() {
            return get_theme_mod('difm_trust_logos_enable', true);
        },
    ));
    
    // Trust Logo Names
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("difm_trust_logo_{$i}", array(
            'default' => "Company {$i}",
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_trust_logo_{$i}", array(
            'label' => sprintf(__('Trust Logo %d Name', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'text',
            'priority' => 80 + $i,
            'active_callback' => function() {
                return get_theme_mod('difm_trust_logos_enable', true);
            },
        ));
    }
    
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
        'priority' => 90,
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
        'priority' => 91,
    ));
    
    // Process Title
    $wp_customize->add_setting('difm_process_title', array(
        'default' => __('Our Proven 4-Step Process', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_process_title', array(
        'label' => __('Process Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 92,
        'active_callback' => function() {
            return get_theme_mod('difm_process_enable', true);
        },
    ));
    
    // Process Subtitle
    $wp_customize->add_setting('difm_process_subtitle', array(
        'default' => __('From idea to launch in just 5-14 days. Here\'s exactly how we do it.', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_process_subtitle', array(
        'label' => __('Process Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 93,
        'active_callback' => function() {
            return get_theme_mod('difm_process_enable', true);
        },
    ));
    
    // Process Steps (4 steps)
    $step_defaults = array(
        1 => array(
            'title' => __('Discovery Call', 'yoursite'),
            'description' => __('We learn about your business, goals, and vision in a detailed 30-minute consultation.', 'yoursite')
        ),
        2 => array(
            'title' => __('Strategy & Design', 'yoursite'),
            'description' => __('Our team creates a custom strategy and design mockups tailored to your industry and goals.', 'yoursite')
        ),
        3 => array(
            'title' => __('Development', 'yoursite'),
            'description' => __('We build your website with daily updates and opportunities for feedback throughout the process.', 'yoursite')
        ),
        4 => array(
            'title' => __('Launch & Support', 'yoursite'),
            'description' => __('We launch your site, provide training, and offer 30 days of support to ensure your success.', 'yoursite')
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
            'priority' => 93 + ($i * 3),
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
            'priority' => 94 + ($i * 3),
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
            'priority' => 95 + ($i * 3),
            'active_callback' => function() use ($i) {
                return get_theme_mod('difm_process_enable', true) && get_theme_mod("difm_step_{$i}_enable", true);
            },
        ));
    }
    
    // ========================================
    // PACKAGES SECTION
    // ========================================
    
    // Separator
    $wp_customize->add_setting('difm_separator_4', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('difm_separator_4', array(
        'label' => __('── Packages Section ──', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 110,
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
        'priority' => 111,
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
        'priority' => 112,
        'active_callback' => function() {
            return get_theme_mod('difm_packages_enable', true);
        },
    ));
    
    // Packages Subtitle
    $wp_customize->add_setting('difm_packages_subtitle', array(
        'default' => __('All packages include professional design, development, and launch support', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_packages_subtitle', array(
        'label' => __('Packages Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 113,
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
        'priority' => 114,
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
        'priority' => 115,
        'active_callback' => function() {
            return get_theme_mod('difm_packages_enable', true) && get_theme_mod('difm_comparison_enable', true);
        },
    ));
    
    // ========================================
    // FAQ SECTION
    // ========================================
    
    // Separator
    $wp_customize->add_setting('difm_separator_5', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('difm_separator_5', array(
        'label' => __('── FAQ Section ──', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 120,
        'description' => __('Configure the FAQ section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // FAQ Title
    $wp_customize->add_setting('difm_faq_title', array(
        'default' => __('Frequently Asked Questions', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_faq_title', array(
        'label' => __('FAQ Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 121,
    ));
    
    // FAQ Subtitle
    $wp_customize->add_setting('difm_faq_subtitle', array(
        'default' => __('Everything you need to know about our done-for-you website service', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_faq_subtitle', array(
        'label' => __('FAQ Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 122,
    ));
    
    // FAQ Items (5 FAQs)
    $faq_defaults = array(
        1 => array(
            'question' => __('How long does it really take to build my website?', 'yoursite'),
            'answer' => __('Our delivery times are guaranteed: 14 days for Standard, 7 days for Professional, and 5 days for Enterprise packages. These timelines include design, development, testing, and launch. We provide daily updates so you know exactly where we are in the process.', 'yoursite')
        ),
        2 => array(
            'question' => __('What if I\'m not satisfied with the final result?', 'yoursite'),
            'answer' => __('We offer a 100% money-back guarantee within 30 days of project completion. If you\'re not completely satisfied with your website, we\'ll refund your entire payment - no questions asked. We\'re confident in our work because we\'ve delivered 500+ successful projects.', 'yoursite')
        ),
        3 => array(
            'question' => __('Do I own the website and can I make changes later?', 'yoursite'),
            'answer' => __('Yes, you own 100% of your website, domain, and all content. We build your site using popular platforms that give you full control. We also provide comprehensive training so you can make updates yourself, or you can hire us for ongoing maintenance and updates.', 'yoursite')
        ),
        4 => array(
            'question' => __('What information do you need from me to get started?', 'yoursite'),
            'answer' => __('We\'ll gather everything we need during our discovery call. This includes your business goals, target audience, brand preferences, content, and any specific functionality requirements. Don\'t worry if you don\'t have everything ready - we\'ll guide you through the entire process.', 'yoursite')
        ),
        5 => array(
            'question' => __('Can you help with content creation and copywriting?', 'yoursite'),
            'answer' => __('Absolutely! Our team includes professional copywriters who can create compelling content for your website. We can also help source high-quality images and create graphics. Content creation is included in Professional and Enterprise packages, and available as an add-on for Standard packages.', 'yoursite')
        )
    );
    
    for ($i = 1; $i <= 5; $i++) {
        // FAQ Question
        $wp_customize->add_setting("difm_faq_{$i}_question", array(
            'default' => isset($faq_defaults[$i]) ? $faq_defaults[$i]['question'] : '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_faq_{$i}_question", array(
            'label' => sprintf(__('FAQ %d Question', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'text',
            'priority' => 122 + ($i * 2),
        ));
        
        // FAQ Answer
        $wp_customize->add_setting("difm_faq_{$i}_answer", array(
            'default' => isset($faq_defaults[$i]) ? $faq_defaults[$i]['answer'] : '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_faq_{$i}_answer", array(
            'label' => sprintf(__('FAQ %d Answer', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'textarea',
            'priority' => 123 + ($i * 2),
        ));
    }
    
    // ========================================
    // FINAL CTA SECTION
    // ========================================
    
    // Separator
    $wp_customize->add_setting('difm_separator_6', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('difm_separator_6', array(
        'label' => __('── Final CTA Section ──', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 140,
        'description' => __('Configure the final call-to-action section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Final CTA Title
    $wp_customize->add_setting('difm_final_cta_title', array(
        'default' => __('Ready to Get Your Professional Website Built?', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_final_cta_title', array(
        'label' => __('Final CTA Title', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 141,
    ));
    
    // Final CTA Subtitle
    $wp_customize->add_setting('difm_final_cta_subtitle', array(
        'default' => __('Join 500+ businesses who chose to focus on their business while we handled their website. Your success is our guarantee.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_final_cta_subtitle', array(
        'label' => __('Final CTA Subtitle', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'textarea',
        'priority' => 142,
    ));
    
    // Final CTA Button
    $wp_customize->add_setting('difm_final_cta_button', array(
        'default' => __('Start Your Project Today', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_final_cta_button', array(
        'label' => __('Final CTA Button Text', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 143,
    ));
    
    // Phone Number
    $wp_customize->add_setting('difm_phone_number', array(
        'default' => '+1234567890',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_phone_number', array(
        'label' => __('Phone Number', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 144,
    ));
    
    // Final CTA Phone Button Text
    $wp_customize->add_setting('difm_final_cta_phone', array(
        'default' => __('Call Us Now', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_final_cta_phone', array(
        'label' => __('Phone Button Text', 'yoursite'),
        'section' => 'difm_page_editor',
        'type' => 'text',
        'priority' => 145,
    ));
    
    // Trust Points
    for ($i = 1; $i <= 3; $i++) {
        $defaults = array(
            1 => 'No upfront payment',
            2 => '30-day guarantee', 
            3 => 'Expert team'
        );
        
        $wp_customize->add_setting("difm_trust_point_{$i}", array(
            'default' => __($defaults[$i], 'yoursite'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_trust_point_{$i}", array(
            'label' => sprintf(__('Trust Point %d', 'yoursite'), $i),
            'section' => 'difm_page_editor',
            'type' => 'text',
            'priority' => 145 + $i,
        ));
    }
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_enhanced_difm_page_customizer');

/**
 * Sanitize checkbox input
 */
if (!function_exists('yoursite_sanitize_checkbox')) {
    function yoursite_sanitize_checkbox($checked) {
        return ((isset($checked) && true == $checked) ? true : false);
    }
}
        <?php
/**
 * Enhanced DIFM Page Customizer Settings
 * Create this file as: inc/customizer/customizer-difm.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Enhanced DIFM Page customizer options
 */
function yoursite_enhanced_difm_page_customizer($wp_customize) {
    
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
        'label' => __('Enable Hero Section', '
        
// Hook the function to the customizer
add_action('customize_register', 'yoursite_difm_page_customizer');
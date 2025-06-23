<?php
/**
 * Careers Page Customizer Settings
 * Create this file as: inc/customizer/customizer-careers.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sanitize checkbox function
 */
function yoursite_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Get job meta fields helper function
 */
function yoursite_get_job_meta_fields($job_id) {
    return array(
        'job_remote' => get_post_meta($job_id, '_job_remote', true) ?: 'no',
        'job_salary_min' => get_post_meta($job_id, '_job_salary_min', true),
        'job_salary_max' => get_post_meta($job_id, '_job_salary_max', true),
        'job_salary_currency' => get_post_meta($job_id, '_job_salary_currency', true) ?: 'USD'
    );
}

/**
 * Add Careers Page customizer options
 */
function yoursite_careers_page_customizer($wp_customize) {
    
    // Careers Page Section (goes under the main Edit Pages panel)
    $wp_customize->add_section('careers_page_editor', array(
        'title' => __('Careers Page', 'yoursite'),
        'description' => __('Customize all elements of the Careers page', 'yoursite'),
        'panel' => 'yoursite_pages',
        'priority' => 70,
    ));
    
    // ========================================
    // HERO SECTION
    // ========================================
    
    // Hero Enable/Disable
    $wp_customize->add_setting('careers_hero_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Hero Title
    $wp_customize->add_setting('careers_hero_title', array(
        'default' => __('Join Our Amazing Team', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'text',
        'priority' => 11,
        'active_callback' => function() {
            return get_theme_mod('careers_hero_enable', true);
        },
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('careers_hero_subtitle', array(
        'default' => __('We\'re building the future of e-commerce, one integration at a time. Join our passionate team and help businesses around the world grow and succeed.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'textarea',
        'priority' => 12,
        'active_callback' => function() {
            return get_theme_mod('careers_hero_enable', true);
        },
    ));
    
    // Hero Background Color
    $wp_customize->add_setting('careers_hero_bg_color', array(
        'default' => '#f3e8ff', // purple-50
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'careers_hero_bg_color', array(
        'label' => __('Hero Background Color (Start)', 'yoursite'),
        'section' => 'careers_page_editor',
        'priority' => 13,
        'active_callback' => function() {
            return get_theme_mod('careers_hero_enable', true);
        },
    )));
    
    // Hero Background Color End
    $wp_customize->add_setting('careers_hero_bg_color_end', array(
        'default' => '#dbeafe', // blue-100
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'careers_hero_bg_color_end', array(
        'label' => __('Hero Background Color (End)', 'yoursite'),
        'section' => 'careers_page_editor',
        'priority' => 14,
        'active_callback' => function() {
            return get_theme_mod('careers_hero_enable', true);
        },
    )));
    
    // ========================================
    // CULTURE SECTION
    // ========================================
    
    // Culture Separator
    $wp_customize->add_setting('careers_separator_1', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('careers_separator_1', array(
        'label' => __('── Company Culture Section ──', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'text',
        'priority' => 20,
        'description' => __('Configure the "Why Work With Us" section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Culture Section Enable
    $wp_customize->add_setting('careers_culture_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_culture_enable', array(
        'label' => __('Enable Culture Section', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'checkbox',
        'priority' => 21,
    ));
    
    // Culture Section Title
    $wp_customize->add_setting('careers_culture_title', array(
        'default' => __('Why Work With Us?', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_culture_title', array(
        'label' => __('Culture Section Title', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'text',
        'priority' => 22,
        'active_callback' => function() {
            return get_theme_mod('careers_culture_enable', true);
        },
    ));
    
    // Culture Section Subtitle
    $wp_customize->add_setting('careers_culture_subtitle', array(
        'default' => __('Join a company that values innovation, collaboration, and personal growth', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_culture_subtitle', array(
        'label' => __('Culture Section Subtitle', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'text',
        'priority' => 23,
        'active_callback' => function() {
            return get_theme_mod('careers_culture_enable', true);
        },
    ));
    
    // Culture Points (6 points)
    $culture_defaults = array(
        1 => array('title' => __('Innovation First', 'yoursite'), 'desc' => __('We\'re constantly pushing boundaries and exploring new technologies to stay ahead of the curve.', 'yoursite'), 'color' => '#3b82f6'),
        2 => array('title' => __('Collaborative Team', 'yoursite'), 'desc' => __('Work with talented individuals from around the world in a supportive, inclusive environment.', 'yoursite'), 'color' => '#10b981'),
        3 => array('title' => __('Growth Focused', 'yoursite'), 'desc' => __('Continuous learning opportunities, mentorship programs, and clear career advancement paths.', 'yoursite'), 'color' => '#8b5cf6'),
        4 => array('title' => __('Global Impact', 'yoursite'), 'desc' => __('Help millions of businesses worldwide succeed with our platform and integrations.', 'yoursite'), 'color' => '#f59e0b'),
        5 => array('title' => __('Work-Life Balance', 'yoursite'), 'desc' => __('Flexible schedules, unlimited PTO, and a culture that respects your time and well-being.', 'yoursite'), 'color' => '#ef4444'),
        6 => array('title' => __('Competitive Benefits', 'yoursite'), 'desc' => __('Great salary, equity, health benefits, and perks that make a real difference.', 'yoursite'), 'color' => '#6366f1')
    );
    
    for ($i = 1; $i <= 6; $i++) {
        $wp_customize->add_setting("careers_culture_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("careers_culture_{$i}_enable", array(
            'label' => sprintf(__('Enable Culture Point %d', 'yoursite'), $i),
            'section' => 'careers_page_editor',
            'type' => 'checkbox',
            'priority' => 23 + ($i * 4),
            'active_callback' => function() {
                return get_theme_mod('careers_culture_enable', true);
            },
        ));
        
        $wp_customize->add_setting("careers_culture_{$i}_title", array(
            'default' => $culture_defaults[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("careers_culture_{$i}_title", array(
            'label' => sprintf(__('Culture Point %d Title', 'yoursite'), $i),
            'section' => 'careers_page_editor',
            'type' => 'text',
            'priority' => 24 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('careers_culture_enable', true) && get_theme_mod("careers_culture_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("careers_culture_{$i}_description", array(
            'default' => $culture_defaults[$i]['desc'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("careers_culture_{$i}_description", array(
            'label' => sprintf(__('Culture Point %d Description', 'yoursite'), $i),
            'section' => 'careers_page_editor',
            'type' => 'textarea',
            'priority' => 25 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('careers_culture_enable', true) && get_theme_mod("careers_culture_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("careers_culture_{$i}_color", array(
            'default' => $culture_defaults[$i]['color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "careers_culture_{$i}_color", array(
            'label' => sprintf(__('Culture Point %d Icon Color', 'yoursite'), $i),
            'section' => 'careers_page_editor',
            'priority' => 26 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('careers_culture_enable', true) && get_theme_mod("careers_culture_{$i}_enable", true);
            },
        )));
    }
    
    // ========================================
    // CTA SECTION
    // ========================================
    
    // CTA Separator
    $wp_customize->add_setting('careers_separator_2', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('careers_separator_2', array(
        'label' => __('── Call-to-Action Section ──', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'text',
        'priority' => 80,
        'description' => __('Configure the final CTA section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // CTA Enable
    $wp_customize->add_setting('careers_cta_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_cta_enable', array(
        'label' => __('Enable CTA Section', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'checkbox',
        'priority' => 81,
    ));
    
    // CTA Title
    $wp_customize->add_setting('careers_cta_title', array(
        'default' => __('Ready to Make an Impact?', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_cta_title', array(
        'label' => __('CTA Title', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'text',
        'priority' => 82,
        'active_callback' => function() {
            return get_theme_mod('careers_cta_enable', true);
        },
    ));
    
    // CTA Description
    $wp_customize->add_setting('careers_cta_description', array(
        'default' => __('Join our mission to empower businesses worldwide with seamless integrations', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_cta_description', array(
        'label' => __('CTA Description', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'textarea',
        'priority' => 83,
        'active_callback' => function() {
            return get_theme_mod('careers_cta_enable', true);
        },
    ));
    
    // CTA Primary Button
    $wp_customize->add_setting('careers_cta_primary_text', array(
        'default' => __('View Open Positions', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_cta_primary_text', array(
        'label' => __('Primary Button Text', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'text',
        'priority' => 84,
        'active_callback' => function() {
            return get_theme_mod('careers_cta_enable', true);
        },
    ));
    
    // CTA Secondary Button
    $wp_customize->add_setting('careers_cta_secondary_text', array(
        'default' => __('Contact Us', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_cta_secondary_text', array(
        'label' => __('Secondary Button Text', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'text',
        'priority' => 85,
        'active_callback' => function() {
            return get_theme_mod('careers_cta_enable', true);
        },
    ));
    
    $wp_customize->add_setting('careers_cta_secondary_url', array(
        'default' => '/contact',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('careers_cta_secondary_url', array(
        'label' => __('Secondary Button URL', 'yoursite'),
        'section' => 'careers_page_editor',
        'type' => 'url',
        'priority' => 86,
        'active_callback' => function() {
            return get_theme_mod('careers_cta_enable', true);
        },
    ));
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_careers_page_customizer');
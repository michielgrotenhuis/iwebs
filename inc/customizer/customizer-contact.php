<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Contact Page customizer options - CLEAN VERSION
 */
function yoursite_contact_page_customizer($wp_customize) {
    
    // Create main Pages panel if it doesn't exist
    if (!$wp_customize->get_panel('yoursite_pages')) {
        $wp_customize->add_panel('yoursite_pages', array(
            'title' => __('Edit Pages', 'yoursite'),
            'description' => __('Customize individual pages', 'yoursite'),
            'priority' => 30,
        ));
    }
    
    // Contact Page Section
    $wp_customize->add_section('contact_page_editor', array(
        'title' => __('Contact Page', 'yoursite'),
        'description' => __('Customize the contact page content', 'yoursite'),
        'panel' => 'yoursite_pages',
        'priority' => 50,
    ));
    
    // Contact Hero Enable
    $wp_customize->add_setting('contact_hero_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Contact Hero Title
    $wp_customize->add_setting('contact_hero_title', array(
        'default' => 'Get in Touch',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 11,
    ));
    
    // Contact Hero Subtitle
    $wp_customize->add_setting('contact_hero_subtitle', array(
        'default' => 'We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'textarea',
        'priority' => 12,
    ));
    
    // Contact Options Enable
    $wp_customize->add_setting('contact_options_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_options_enable', array(
        'label' => __('Enable Contact Options Section', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'checkbox',
        'priority' => 20,
    ));
    
    // Contact Options (4 options)
    for ($i = 1; $i <= 4; $i++) {
        // Enable
        $wp_customize->add_setting("contact_option_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_option_{$i}_enable", array(
            'label' => sprintf(__('Enable Contact Option %d', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'checkbox',
            'priority' => 20 + ($i * 10),
        ));
        
        // Title
        $wp_customize->add_setting("contact_option_{$i}_title", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_option_{$i}_title", array(
            'label' => sprintf(__('Contact Option %d Title', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'text',
            'priority' => 21 + ($i * 10),
        ));
        
        // Description
        $wp_customize->add_setting("contact_option_{$i}_description", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_option_{$i}_description", array(
            'label' => sprintf(__('Contact Option %d Description', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'textarea',
            'priority' => 22 + ($i * 10),
        ));
        
        // Button Text
        $wp_customize->add_setting("contact_option_{$i}_button_text", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_option_{$i}_button_text", array(
            'label' => sprintf(__('Contact Option %d Button Text', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'text',
            'priority' => 23 + ($i * 10),
        ));
        
        // Button URL
        $wp_customize->add_setting("contact_option_{$i}_button_url", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_option_{$i}_button_url", array(
            'label' => sprintf(__('Contact Option %d Button URL', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'url',
            'priority' => 24 + ($i * 10),
        ));
        
        // Icon Color
        $wp_customize->add_setting("contact_option_{$i}_icon_color", array(
            'default' => 'blue',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_option_{$i}_icon_color", array(
            'label' => sprintf(__('Contact Option %d Icon Color', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'select',
            'choices' => array(
                'blue' => __('Blue', 'yoursite'),
                'green' => __('Green', 'yoursite'),
                'purple' => __('Purple', 'yoursite'),
                'red' => __('Red', 'yoursite'),
                'yellow' => __('Yellow', 'yoursite'),
                'indigo' => __('Indigo', 'yoursite'),
            ),
            'priority' => 25 + ($i * 10),
        ));
    }
    
    // Contact Form Enable
    $wp_customize->add_setting('contact_form_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_form_enable', array(
        'label' => __('Enable Contact Form Section', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'checkbox',
        'priority' => 100,
    ));
    
    // FAQ Enable
    $wp_customize->add_setting('contact_faq_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_faq_enable', array(
        'label' => __('Enable FAQ Section', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'checkbox',
        'priority' => 110,
    ));
    
    // Office Information Enable
    $wp_customize->add_setting('contact_office_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_office_enable', array(
        'label' => __('Enable Office Information Section', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'checkbox',
        'priority' => 120,
    ));
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_contact_page_customizer');
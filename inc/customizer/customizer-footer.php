<?php
/**
 * Footer customizer options - UPDATED VERSION
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add comprehensive footer customizer options
 */
function yoursite_footer_customizer($wp_customize) {
    
    // Footer Section
    $wp_customize->add_section('footer_section', array(
        'title' => __('Footer Settings', 'yoursite'),
        'priority' => 45,
        'panel' => 'yoursite_theme_options',
    ));
    
    // Company Information
    $wp_customize->add_setting('footer_company_description', array(
        'default' => __('Build and scale your online store with confidence. Trusted by 100,000+ businesses worldwide.', 'yoursite'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_company_description', array(
        'label' => __('Company Description', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'textarea',
        'priority' => 10,
    ));
    
    // Newsletter Settings
    $wp_customize->add_setting('show_footer_newsletter', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_footer_newsletter', array(
        'label' => __('Show Newsletter Signup', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'checkbox',
        'priority' => 20,
    ));
    
    $wp_customize->add_setting('newsletter_title', array(
        'default' => __('Stay in the Loop', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('newsletter_title', array(
        'label' => __('Newsletter Title', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'text',
        'priority' => 21,
    ));
    
    $wp_customize->add_setting('newsletter_description', array(
        'default' => __('Get the latest updates, tips, and exclusive offers delivered to your inbox.', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('newsletter_description', array(
        'label' => __('Newsletter Description', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'textarea',
        'priority' => 22,
    ));
    
    // Trust Badges Settings
    $wp_customize->add_setting('show_trust_badges', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_trust_badges', array(
        'label' => __('Show Trust Badges (SOC2, GDPR, PCI DSS)', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'checkbox',
        'priority' => 30,
    ));
    
    // Payment Methods Settings
    $wp_customize->add_setting('show_payment_methods', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_payment_methods', array(
        'label' => __('Show Payment Methods', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'checkbox',
        'priority' => 40,
    ));
    
    // Customer Support Settings
    $wp_customize->add_setting('show_customer_support', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_customer_support', array(
        'label' => __('Show 24/7 Customer Support Badge', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'checkbox',
        'priority' => 50,
    ));
    
    $wp_customize->add_setting('support_link_text', array(
        'default' => __('Get Help Now', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('support_link_text', array(
        'label' => __('Support Link Text', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'text',
        'priority' => 51,
    ));
    
    $wp_customize->add_setting('support_link_url', array(
        'default' => '/contact',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('support_link_url', array(
        'label' => __('Support Link URL', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'url',
        'priority' => 52,
    ));
    
    // Language/Currency Settings
    $wp_customize->add_setting('show_language_selector', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_language_selector', array(
        'label' => __('Show Language Selector', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'checkbox',
        'priority' => 60,
    ));
    
    $wp_customize->add_setting('show_currency_selector', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_currency_selector', array(
        'label' => __('Show Currency Selector', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'checkbox',
        'priority' => 61,
    ));
    
    $wp_customize->add_setting('default_currency', array(
        'default' => 'USD',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('default_currency', array(
        'label' => __('Default Currency', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'select',
        'choices' => array(
            'USD' => __('US Dollar (USD)', 'yoursite'),
            'EUR' => __('Euro (EUR)', 'yoursite'),
            'GBP' => __('British Pound (GBP)', 'yoursite'),
            'CAD' => __('Canadian Dollar (CAD)', 'yoursite'),
            'AUD' => __('Australian Dollar (AUD)', 'yoursite'),
            'INR' => __('Indian Rupee (INR)', 'yoursite'),
            'JPY' => __('Japanese Yen (JPY)', 'yoursite'),
            'CNY' => __('Chinese Yuan (CNY)', 'yoursite'),
        ),
        'priority' => 62,
    ));
    
    $wp_customize->add_setting('default_language', array(
        'default' => 'EN',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('default_language', array(
        'label' => __('Default Language', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'select',
        'choices' => array(
            'EN' => __('English', 'yoursite'),
            'ES' => __('Español', 'yoursite'),
            'FR' => __('Français', 'yoursite'),
            'DE' => __('Deutsch', 'yoursite'),
            'IT' => __('Italiano', 'yoursite'),
            'PT' => __('Português', 'yoursite'),
            'JP' => __('日本語', 'yoursite'),
            'CN' => __('中文', 'yoursite'),
        ),
        'priority' => 63,
    ));
    
    // Copyright Text
    $wp_customize->add_setting('footer_text', array(
        'default' => sprintf(__('© %s YourSite.biz. All rights reserved.', 'yoursite'), date('Y')),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_text', array(
        'label' => __('Footer Copyright Text', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'textarea',
        'priority' => 70,
    ));
    
    // Legal Links
    $wp_customize->add_setting('show_legal_links', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_legal_links', array(
        'label' => __('Show Legal Links (Privacy, Terms, etc.)', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'checkbox',
        'priority' => 80,
    ));
}
add_action('customize_register', 'yoursite_footer_customizer');
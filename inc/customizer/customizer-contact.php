<?php
/**
 * Contact Page Customizer Settings
 * Create this file as: inc/customizer/customizer-contact.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Contact Page customizer options
 */
function yoursite_contact_page_customizer($wp_customize) {
    
    // Contact Page Section (goes under the main Edit Pages panel)
    $wp_customize->add_section('contact_page_editor', array(
        'title' => __('Contact Page', 'yoursite'),
        'description' => __('Customize all elements of the Contact page', 'yoursite'),
        'panel' => 'yoursite_pages',
        'priority' => 60,
    ));
    
    // ========================================
    // HERO SECTION
    // ========================================
    
    // Hero Enable/Disable
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
    
    // Hero Title
    $wp_customize->add_setting('contact_hero_title', array(
        'default' => __('Get in touch with us', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 11,
        'active_callback' => function() {
            return get_theme_mod('contact_hero_enable', true);
        },
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('contact_hero_subtitle', array(
        'default' => __('Have questions about our platform? Need help getting started? Our team is here to help you succeed.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'textarea',
        'priority' => 12,
        'active_callback' => function() {
            return get_theme_mod('contact_hero_enable', true);
        },
    ));
    
    // ========================================
    // CONTACT OPTIONS SECTION
    // ========================================
    
    // Separator
    $wp_customize->add_setting('contact_separator_1', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_separator_1', array(
        'label' => __('── Contact Options Section ──', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 20,
        'description' => __('Configure contact method options', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
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
        'priority' => 21,
    ));
    
    // Contact Options (4 options)
    $contact_defaults = array(
        1 => array(
            'title' => __('Live Chat', 'yoursite'),
            'description' => __('Get instant answers from our support team', 'yoursite'),
            'button_text' => __('Start Chat →', 'yoursite'),
            'button_url' => '#',
            'icon_color' => '#3b82f6'
        ),
        2 => array(
            'title' => __('Email Support', 'yoursite'),
            'description' => __('We\'ll respond within 24 hours', 'yoursite'),
            'button_text' => 'support@yoursite.biz',
            'button_url' => 'mailto:support@yoursite.biz',
            'icon_color' => '#10b981'
        ),
        3 => array(
            'title' => __('Phone Support', 'yoursite'),
            'description' => __('Mon-Fri, 9AM-6PM EST', 'yoursite'),
            'button_text' => '+1 (555) 123-4567',
            'button_url' => 'tel:+1-555-123-4567',
            'icon_color' => '#8b5cf6'
        ),
        4 => array(
            'title' => __('Help Center', 'yoursite'),
            'description' => __('Find answers to common questions', 'yoursite'),
            'button_text' => __('Browse Articles →', 'yoursite'),
            'button_url' => '/help',
            'icon_color' => '#f97316'
        )
    );
    
    for ($i = 1; $i <= 4; $i++) {
        // Option Enable
        $wp_customize->add_setting("contact_option_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_option_{$i}_enable", array(
            'label' => sprintf(__('Enable Contact Option %d', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'checkbox',
            'priority' => 21 + ($i * 6),
            'active_callback' => function() {
                return get_theme_mod('contact_options_enable', true);
            },
        ));
        
        // Option Title
        $wp_customize->add_setting("contact_option_{$i}_title", array(
            'default' => $contact_defaults[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_option_{$i}_title", array(
            'label' => sprintf(__('Option %d Title', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'text',
            'priority' => 22 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('contact_options_enable', true) && get_theme_mod("contact_option_{$i}_enable", true);
            },
        ));
        
        // Option Description
        $wp_customize->add_setting("contact_option_{$i}_description", array(
            'default' => $contact_defaults[$i]['description'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_option_{$i}_description", array(
            'label' => sprintf(__('Option %d Description', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'textarea',
            'priority' => 23 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('contact_options_enable', true) && get_theme_mod("contact_option_{$i}_enable", true);
            },
        ));
        
        // Option Button Text
        $wp_customize->add_setting("contact_option_{$i}_button_text", array(
            'default' => $contact_defaults[$i]['button_text'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_option_{$i}_button_text", array(
            'label' => sprintf(__('Option %d Button Text', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'text',
            'priority' => 24 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('contact_options_enable', true) && get_theme_mod("contact_option_{$i}_enable", true);
            },
        ));
        
        // Option Button URL
        $wp_customize->add_setting("contact_option_{$i}_button_url", array(
            'default' => $contact_defaults[$i]['button_url'],
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_option_{$i}_button_url", array(
            'label' => sprintf(__('Option %d Button URL', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'url',
            'priority' => 25 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('contact_options_enable', true) && get_theme_mod("contact_option_{$i}_enable", true);
            },
        ));
        
        // Option Icon Color
        $wp_customize->add_setting("contact_option_{$i}_icon_color", array(
            'default' => $contact_defaults[$i]['icon_color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "contact_option_{$i}_icon_color", array(
            'label' => sprintf(__('Option %d Icon Color', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'priority' => 26 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('contact_options_enable', true) && get_theme_mod("contact_option_{$i}_enable", true);
            },
        )));
    }
    
    // ========================================
    // CONTACT FORM SECTION
    // ========================================
    
    // Separator
    $wp_customize->add_setting('contact_separator_2', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_separator_2', array(
        'label' => __('── Contact Form Section ──', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 50,
        'description' => __('Configure the contact form section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
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
        'priority' => 51,
    ));
    
    // Form Title
    $wp_customize->add_setting('contact_form_title', array(
        'default' => __('Send us a message', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_form_title', array(
        'label' => __('Form Title', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 52,
        'active_callback' => function() {
            return get_theme_mod('contact_form_enable', true);
        },
    ));
    
    // Form Subtitle
    $wp_customize->add_setting('contact_form_subtitle', array(
        'default' => __('We\'d love to hear from you. Fill out the form below and we\'ll get back to you soon.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_form_subtitle', array(
        'label' => __('Form Subtitle', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'textarea',
        'priority' => 53,
        'active_callback' => function() {
            return get_theme_mod('contact_form_enable', true);
        },
    ));
    
    // Form Background Color
    $wp_customize->add_setting('contact_form_bg_color', array(
        'default' => '#f9fafb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'contact_form_bg_color', array(
        'label' => __('Form Section Background Color', 'yoursite'),
        'section' => 'contact_page_editor',
        'priority' => 54,
        'active_callback' => function() {
            return get_theme_mod('contact_form_enable', true);
        },
    )));
    
    // ========================================
    // FAQ SECTION
    // ========================================
    
    // Separator
    $wp_customize->add_setting('contact_separator_3', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_separator_3', array(
        'label' => __('── FAQ Section ──', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 60,
        'description' => __('Configure the FAQ section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
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
        'priority' => 61,
    ));
    
    // FAQ Title
    $wp_customize->add_setting('contact_faq_title', array(
        'default' => __('Frequently Asked Questions', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_faq_title', array(
        'label' => __('FAQ Title', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 62,
        'active_callback' => function() {
            return get_theme_mod('contact_faq_enable', true);
        },
    ));
    
    // FAQ Subtitle
    $wp_customize->add_setting('contact_faq_subtitle', array(
        'default' => __('Quick answers to common questions', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_faq_subtitle', array(
        'label' => __('FAQ Subtitle', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 63,
        'active_callback' => function() {
            return get_theme_mod('contact_faq_enable', true);
        },
    ));
    
    // FAQ Items (5 items)
    $faq_defaults = array(
        1 => array(
            'question' => __('How quickly can I get my store online?', 'yoursite'),
            'answer' => __('Most merchants can set up their store and start selling within minutes using our templates and drag-and-drop builder. For custom designs, it may take a few hours to get everything exactly how you want it.', 'yoursite')
        ),
        2 => array(
            'question' => __('What payment methods do you support?', 'yoursite'),
            'answer' => __('We support all major credit cards, PayPal, Apple Pay, Google Pay, and many other payment methods. Our platform integrates with leading payment processors like Stripe, Square, and more.', 'yoursite')
        ),
        3 => array(
            'question' => __('Do you offer customer support?', 'yoursite'),
            'answer' => __('Yes! We offer 24/7 chat support, email support with 24-hour response times, phone support during business hours, and a comprehensive help center with tutorials and guides.', 'yoursite')
        ),
        4 => array(
            'question' => __('Can I migrate my existing store?', 'yoursite'),
            'answer' => __('Absolutely! We offer free migration services to help you move your products, customers, and order history from platforms like Shopify, WooCommerce, Magento, and others. Our team will handle the technical details.', 'yoursite')
        ),
        5 => array(
            'question' => __('What\'s included in the free trial?', 'yoursite'),
            'answer' => __('Our 14-day free trial includes access to all features, unlimited products, all templates, and full customer support. No credit card required to start, and you can upgrade or cancel anytime.', 'yoursite')
        )
    );
    
    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting("contact_faq_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_faq_{$i}_enable", array(
            'label' => sprintf(__('Enable FAQ %d', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'checkbox',
            'priority' => 63 + ($i * 3),
            'active_callback' => function() {
                return get_theme_mod('contact_faq_enable', true);
            },
        ));
        
        $wp_customize->add_setting("contact_faq_{$i}_question", array(
            'default' => $faq_defaults[$i]['question'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_faq_{$i}_question", array(
            'label' => sprintf(__('FAQ %d Question', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'text',
            'priority' => 64 + ($i * 3),
            'active_callback' => function() use ($i) {
                return get_theme_mod('contact_faq_enable', true) && get_theme_mod("contact_faq_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("contact_faq_{$i}_answer", array(
            'default' => $faq_defaults[$i]['answer'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("contact_faq_{$i}_answer", array(
            'label' => sprintf(__('FAQ %d Answer', 'yoursite'), $i),
            'section' => 'contact_page_editor',
            'type' => 'textarea',
            'priority' => 65 + ($i * 3),
            'active_callback' => function() use ($i) {
                return get_theme_mod('contact_faq_enable', true) && get_theme_mod("contact_faq_{$i}_enable", true);
            },
        ));
    }
    
    // ========================================
    // OFFICE LOCATION SECTION
    // ========================================
    
    // Separator
    $wp_customize->add_setting('contact_separator_4', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_separator_4', array(
        'label' => __('── Office Location Section ──', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 80,
        'description' => __('Configure the office/location section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Office Enable
    $wp_customize->add_setting('contact_office_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_office_enable', array(
        'label' => __('Enable Office Location Section', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'checkbox',
        'priority' => 81,
    ));
    
    // Office Title
    $wp_customize->add_setting('contact_office_title', array(
        'default' => __('Visit Our Office', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_office_title', array(
        'label' => __('Office Section Title', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 82,
        'active_callback' => function() {
            return get_theme_mod('contact_office_enable', true);
        },
    ));
    
    // Office Subtitle
    $wp_customize->add_setting('contact_office_subtitle', array(
        'default' => __('We\'d love to meet you in person', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_office_subtitle', array(
        'label' => __('Office Section Subtitle', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 83,
        'active_callback' => function() {
            return get_theme_mod('contact_office_enable', true);
        },
    ));
    
    // Office Name
    $wp_customize->add_setting('contact_office_name', array(
        'default' => __('San Francisco Headquarters', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_office_name', array(
        'label' => __('Office Name', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'text',
        'priority' => 84,
        'active_callback' => function() {
            return get_theme_mod('contact_office_enable', true);
        },
    ));
    
    // Office Address
    $wp_customize->add_setting('contact_office_address', array(
        'default' => __('123 Market Street, Suite 456<br>San Francisco, CA 94105', 'yoursite'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_office_address', array(
        'label' => __('Office Address', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'textarea',
        'priority' => 85,
        'description' => __('You can use HTML like &lt;br&gt; for line breaks', 'yoursite'),
        'active_callback' => function() {
            return get_theme_mod('contact_office_enable', true);
        },
    ));
    
    // Office Hours
    $wp_customize->add_setting('contact_office_hours', array(
        'default' => __('Monday - Friday: 9:00 AM - 6:00 PM PST<br>Weekend: By appointment only', 'yoursite'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_office_hours', array(
        'label' => __('Office Hours', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'textarea',
        'priority' => 86,
        'description' => __('You can use HTML like &lt;br&gt; for line breaks', 'yoursite'),
        'active_callback' => function() {
            return get_theme_mod('contact_office_enable', true);
        },
    ));
    
    // Office Email
    $wp_customize->add_setting('contact_office_email', array(
        'default' => __('hello@yoursite.biz', 'yoursite'),
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_office_email', array(
        'label' => __('Office Email', 'yoursite'),
        'section' => 'contact_page_editor',
        'type' => 'email',
        'priority' => 87,
        'active_callback' => function() {
            return get_theme_mod('contact_office_enable', true);
        },
    ));
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_contact_page_customizer');
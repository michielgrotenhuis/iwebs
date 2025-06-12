<?php
/**
 * Webinars Page Customizer Settings
 * Add this file as: inc/customizer/customizer-webinars.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Webinars Page customizer options
 */
function yoursite_webinars_page_customizer($wp_customize) {
    
    // Webinars Page Section
    $wp_customize->add_section('webinars_page_editor', array(
        'title' => __('Webinars Page', 'yoursite'),
        'description' => __('Customize all elements of the Webinars page', 'yoursite'),
        'panel' => 'yoursite_pages',
        'priority' => 50,
    ));
    
    // ========================================
    // HERO SECTION
    // ========================================
    
    // Hero Enable/Disable
    $wp_customize->add_setting('webinars_hero_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Hero Title
    $wp_customize->add_setting('webinars_hero_title', array(
        'default' => 'Expert Webinars',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 11,
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('webinars_hero_subtitle', array(
        'default' => 'Learn from industry experts and grow your eCommerce business with our exclusive webinar series',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'textarea',
        'priority' => 12,
    ));
    
    // Hero Primary Button Text
    $wp_customize->add_setting('webinars_hero_btn_primary_text', array(
        'default' => 'View Upcoming Webinars',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_hero_btn_primary_text', array(
        'label' => __('Primary Button Text', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 13,
    ));
    
    // Hero Secondary Button Text
    $wp_customize->add_setting('webinars_hero_btn_secondary_text', array(
        'default' => 'Register for Updates',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_hero_btn_secondary_text', array(
        'label' => __('Secondary Button Text', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 14,
    ));
    
    // ========================================
    // FEATURES SECTION
    // ========================================
    
    // Features Enable
    $wp_customize->add_setting('webinars_features_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_features_enable', array(
        'label' => __('Enable Features Section', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'checkbox',
        'priority' => 21,
    ));
    
    // Features Title
    $wp_customize->add_setting('webinars_features_title', array(
        'default' => 'Why Attend Our Webinars?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_features_title', array(
        'label' => __('Features Section Title', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 22,
    ));
    
    // Features Subtitle
    $wp_customize->add_setting('webinars_features_subtitle', array(
        'default' => 'Join thousands of successful entrepreneurs who have transformed their businesses through our expert-led sessions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_features_subtitle', array(
        'label' => __('Features Section Subtitle', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 23,
    ));
    
    // Feature 1
    $wp_customize->add_setting('webinars_feature_1_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_1_enable', array(
        'label' => __('Enable Feature 1', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'checkbox',
        'priority' => 24,
    ));
    
    $wp_customize->add_setting('webinars_feature_1_title', array(
        'default' => 'Expert Knowledge',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_1_title', array(
        'label' => __('Feature 1 Title', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 25,
    ));
    
    $wp_customize->add_setting('webinars_feature_1_description', array(
        'default' => 'Learn from industry leaders with proven track records',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_1_description', array(
        'label' => __('Feature 1 Description', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'textarea',
        'priority' => 26,
    ));
    
    // Feature 2
    $wp_customize->add_setting('webinars_feature_2_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_2_enable', array(
        'label' => __('Enable Feature 2', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'checkbox',
        'priority' => 27,
    ));
    
    $wp_customize->add_setting('webinars_feature_2_title', array(
        'default' => 'Live Interaction',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_2_title', array(
        'label' => __('Feature 2 Title', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 28,
    ));
    
    $wp_customize->add_setting('webinars_feature_2_description', array(
        'default' => 'Ask questions and get real-time answers from experts',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_2_description', array(
        'label' => __('Feature 2 Description', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'textarea',
        'priority' => 29,
    ));
    
    // Feature 3
    $wp_customize->add_setting('webinars_feature_3_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_3_enable', array(
        'label' => __('Enable Feature 3', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'checkbox',
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('webinars_feature_3_title', array(
        'default' => 'Actionable Insights',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_3_title', array(
        'label' => __('Feature 3 Title', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 31,
    ));
    
    $wp_customize->add_setting('webinars_feature_3_description', array(
        'default' => 'Get practical strategies you can implement immediately',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_3_description', array(
        'label' => __('Feature 3 Description', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'textarea',
        'priority' => 32,
    ));
    
    // Feature 4
    $wp_customize->add_setting('webinars_feature_4_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_4_enable', array(
        'label' => __('Enable Feature 4', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'checkbox',
        'priority' => 33,
    ));
    
    $wp_customize->add_setting('webinars_feature_4_title', array(
        'default' => 'Free Resources',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_4_title', array(
        'label' => __('Feature 4 Title', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 34,
    ));
    
    $wp_customize->add_setting('webinars_feature_4_description', array(
        'default' => 'Download templates, checklists, and guides',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_feature_4_description', array(
        'label' => __('Feature 4 Description', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'textarea',
        'priority' => 35,
    ));
    
    // ========================================
    // NEWSLETTER SECTION
    // ========================================
    
    // Newsletter Enable
    $wp_customize->add_setting('webinars_newsletter_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_newsletter_enable', array(
        'label' => __('Enable Newsletter Section', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'checkbox',
        'priority' => 41,
    ));
    
    // Newsletter Title
    $wp_customize->add_setting('webinars_newsletter_title', array(
        'default' => 'Never Miss a Webinar',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_newsletter_title', array(
        'label' => __('Newsletter Section Title', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 42,
    ));
    
    // Newsletter Subtitle
    $wp_customize->add_setting('webinars_newsletter_subtitle', array(
        'default' => 'Get notified about upcoming webinars and receive exclusive resources',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_newsletter_subtitle', array(
        'label' => __('Newsletter Section Subtitle', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 43,
    ));
    
    // Newsletter Description
    $wp_customize->add_setting('webinars_newsletter_description', array(
        'default' => 'Join 25,000+ entrepreneurs getting our weekly insights. Unsubscribe anytime.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_newsletter_description', array(
        'label' => __('Newsletter Description', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 44,
    ));
    
    // ========================================
    // FAQ SECTION
    // ========================================
    
    // FAQ Enable
    $wp_customize->add_setting('webinars_faq_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_faq_enable', array(
        'label' => __('Enable FAQ Section', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'checkbox',
        'priority' => 51,
    ));
    
    // FAQ Title
    $wp_customize->add_setting('webinars_faq_title', array(
        'default' => 'Frequently Asked Questions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_faq_title', array(
        'label' => __('FAQ Section Title', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 52,
    ));
    
    // FAQ Subtitle
    $wp_customize->add_setting('webinars_faq_subtitle', array(
        'default' => 'Quick answers to common questions about our platform',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_faq_subtitle', array(
        'label' => __('FAQ Section Subtitle', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 53,
    ));
    
    // FAQ 1
    $wp_customize->add_setting('webinars_faq_1_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_faq_1_enable', array(
        'label' => __('Enable FAQ 1', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'checkbox',
        'priority' => 54,
    ));
    
    $wp_customize->add_setting('webinars_faq_1_question', array(
        'default' => 'How quickly can I get my store online?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_faq_1_question', array(
        'label' => __('FAQ 1 Question', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'text',
        'priority' => 55,
    ));
    
    $wp_customize->add_setting('webinars_faq_1_answer', array(
        'default' => 'Most merchants can set up their store and start selling within minutes using our templates and drag-and-drop builder.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webinars_faq_1_answer', array(
        'label' => __('FAQ 1 Answer', 'yoursite'),
        'section' => 'webinars_page_editor',
        'type' => 'textarea',
        'priority' => 56,
    ));
    
    // FAQ 2-7 (similar structure)
    for ($i = 2; $i <= 7; $i++) {
        $default_questions = array(
            2 => 'What payment methods do you support?',
            3 => 'Do you offer customer support?',
            4 => 'Can I migrate my existing store?',
            5 => 'What\'s included in the free trial?',
            6 => 'Are there any transaction fees?',
            7 => 'Can I use my own domain name?'
        );
        
        $default_answers = array(
            2 => 'We support all major credit cards, PayPal, Apple Pay, Google Pay, and many other payment methods.',
            3 => 'Yes! We provide 24/7 live chat support, email support, and phone support during business hours.',
            4 => 'Absolutely! We offer free migration services from platforms like Shopify, WooCommerce, and others.',
            5 => 'Our 14-day free trial includes access to all premium features, unlimited products, and full support.',
            6 => 'We don\'t charge any transaction fees on top of your monthly subscription.',
            7 => 'Yes! You can connect your existing domain or purchase a new one through our platform.'
        );
        
        $wp_customize->add_setting("webinars_faq_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("webinars_faq_{$i}_enable", array(
            'label' => __("Enable FAQ {$i}", 'yoursite'),
            'section' => 'webinars_page_editor',
            'type' => 'checkbox',
            'priority' => 54 + ($i - 1) * 3,
        ));
        
        $wp_customize->add_setting("webinars_faq_{$i}_question", array(
            'default' => $default_questions[$i],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("webinars_faq_{$i}_question", array(
            'label' => __("FAQ {$i} Question", 'yoursite'),
            'section' => 'webinars_page_editor',
            'type' => 'text',
            'priority' => 55 + ($i - 1) * 3,
        ));
        
        $wp_customize->add_setting("webinars_faq_{$i}_answer", array(
            'default' => $default_answers[$i],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("webinars_faq_{$i}_answer", array(
            'label' => __("FAQ {$i} Answer", 'yoursite'),
            'section' => 'webinars_page_editor',
            'type' => 'textarea',
            'priority' => 56 + ($i - 1) * 3,
        ));
    }
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_webinars_page_customizer');
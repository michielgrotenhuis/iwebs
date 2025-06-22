<?php
/**
 * Pricing Page Customizer Settings - Updated Version
 * Only page content, no pricing plans management
 * File: inc/customizer/customizer-pricing.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Pricing Page customizer options
 */
function yoursite_pricing_page_customizer($wp_customize) {
    
    // Pricing Page Section
    $wp_customize->add_section('pricing_page_editor', array(
        'title' => __('Pricing Page', 'yoursite'),
        'description' => __('Customize pricing page content. Manage pricing plans in WP-Admin > Pricing Plans.', 'yoursite'),
        'panel' => 'yoursite_pages',
        'priority' => 30,
    ));
    
    // ========================================
    // HERO SECTION
    // ========================================
    
    // Hero Enable/Disable
    $wp_customize->add_setting('pricing_hero_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Hero Title
    $wp_customize->add_setting('pricing_hero_title', array(
        'default' => 'Simple, Transparent Pricing',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 11,
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('pricing_hero_subtitle', array(
        'default' => 'Choose the perfect plan for your business. Start free, upgrade when you\'re ready.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'textarea',
        'priority' => 12,
    ));
    
    // Billing Toggle Text
    $wp_customize->add_setting('pricing_billing_monthly_text', array(
        'default' => 'Monthly',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_billing_monthly_text', array(
        'label' => __('Monthly Billing Text', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 13,
    ));
    
    $wp_customize->add_setting('pricing_billing_yearly_text', array(
        'default' => 'Yearly',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_billing_yearly_text', array(
        'label' => __('Yearly Billing Text', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 14,
    ));
    
    $wp_customize->add_setting('pricing_billing_save_text', array(
        'default' => 'Save 20%',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_billing_save_text', array(
        'label' => __('Save Badge Text', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 15,
    ));
    
    // ========================================
    // PLANS SECTION INFO
    // ========================================
    
    // Info about managing plans
    $wp_customize->add_setting('pricing_plans_info', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'pricing_plans_info', array(
        'label' => __('Pricing Plans Management', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'hidden',
        'description' => __('To add, edit, or remove pricing plans, go to WP-Admin → Pricing Plans. The pricing cards and comparison table will automatically display your published pricing plans.', 'yoursite'),
        'priority' => 20,
    )));
    
    // ========================================
    // COMPARISON TABLE SECTION
    // ========================================
    
    // Comparison Table Enable
    $wp_customize->add_setting('pricing_comparison_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_comparison_enable', array(
        'label' => __('Enable Comparison Table', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'checkbox',
        'priority' => 21,
    ));
    
    // Comparison Table Title
    $wp_customize->add_setting('pricing_comparison_title', array(
        'default' => 'See What\'s Included in Each Plan',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_comparison_title', array(
        'label' => __('Comparison Table Title', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 22,
    ));
    
    // Comparison Table Subtitle
    $wp_customize->add_setting('pricing_comparison_subtitle', array(
        'default' => 'Every feature designed to help your business grow',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_comparison_subtitle', array(
        'label' => __('Comparison Table Subtitle', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 23,
    ));
    
    // ========================================
    // FAQ SECTION
    // ========================================
    
    // FAQ Enable
    $wp_customize->add_setting('pricing_faq_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_faq_enable', array(
        'label' => __('Enable FAQ Section', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'checkbox',
        'priority' => 31,
    ));
    
    // FAQ Title
    $wp_customize->add_setting('pricing_faq_title', array(
        'default' => 'Frequently Asked Questions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_faq_title', array(
        'label' => __('FAQ Section Title', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 32,
    ));
    
    // FAQ Subtitle
    $wp_customize->add_setting('pricing_faq_subtitle', array(
        'default' => 'Quick answers to common pricing questions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_faq_subtitle', array(
        'label' => __('FAQ Section Subtitle', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 33,
    ));
    
    // FAQ Items (5 FAQ items)
    $default_faqs = array(
        array('question' => 'Can I change plans anytime?', 'answer' => 'Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle, and we\'ll prorate any differences.'),
        array('question' => 'Is there a free trial?', 'answer' => 'Yes, all paid plans come with a 14-day free trial. No credit card required to get started. You can also use our Free plan indefinitely.'),
        array('question' => 'What payment methods do you accept?', 'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers for enterprise customers.'),
        array('question' => 'Do you offer refunds?', 'answer' => 'Yes, we offer a 30-day money-back guarantee. If you\'re not satisfied with our service, contact us within 30 days for a full refund.'),
        array('question' => 'Can I cancel anytime?', 'answer' => 'Absolutely! You can cancel your subscription at any time. Your account will remain active until the end of your current billing period.')
    );
    
    for ($i = 1; $i <= 5; $i++) {
        $faq = $default_faqs[$i - 1];
        
        $wp_customize->add_setting("pricing_faq_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("pricing_faq_{$i}_enable", array(
            'label' => __("Enable FAQ {$i}", 'yoursite'),
            'section' => 'pricing_page_editor',
            'type' => 'checkbox',
            'priority' => 34 + ($i - 1) * 3,
        ));
        
        $wp_customize->add_setting("pricing_faq_{$i}_question", array(
            'default' => $faq['question'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("pricing_faq_{$i}_question", array(
            'label' => __("FAQ {$i} Question", 'yoursite'),
            'section' => 'pricing_page_editor',
            'type' => 'text',
            'priority' => 35 + ($i - 1) * 3,
        ));
        
        $wp_customize->add_setting("pricing_faq_{$i}_answer", array(
            'default' => $faq['answer'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("pricing_faq_{$i}_answer", array(
            'label' => __("FAQ {$i} Answer", 'yoursite'),
            'section' => 'pricing_page_editor',
            'type' => 'textarea',
            'priority' => 36 + ($i - 1) * 3,
        ));
    }
    
    // ========================================
    // CTA SECTION
    // ========================================
    
    // CTA Enable
    $wp_customize->add_setting('pricing_cta_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_cta_enable', array(
        'label' => __('Enable CTA Section', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'checkbox',
        'priority' => 51,
    ));
    
    // CTA Title
    $wp_customize->add_setting('pricing_cta_title', array(
        'default' => 'Ready to grow your business?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_cta_title', array(
        'label' => __('CTA Section Title', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 52,
    ));
    
    // CTA Subtitle
    $wp_customize->add_setting('pricing_cta_subtitle', array(
        'default' => 'Join thousands of successful merchants using our platform',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_cta_subtitle', array(
        'label' => __('CTA Section Subtitle', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 53,
    ));
    
    // CTA Primary Button Text
    $wp_customize->add_setting('pricing_cta_primary_text', array(
        'default' => 'Start Your Free Trial',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_cta_primary_text', array(
        'label' => __('Primary CTA Button Text', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 54,
    ));
    
    // CTA Primary Button URL
    $wp_customize->add_setting('pricing_cta_primary_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_cta_primary_url', array(
        'label' => __('Primary CTA Button URL', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'url',
        'priority' => 55,
    ));
    
    // CTA Secondary Button Text
    $wp_customize->add_setting('pricing_cta_secondary_text', array(
        'default' => 'Talk to Sales',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_cta_secondary_text', array(
        'label' => __('Secondary CTA Button Text', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 56,
    ));
    
    // CTA Secondary Button URL
    $wp_customize->add_setting('pricing_cta_secondary_url', array(
        'default' => '/contact',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_cta_secondary_url', array(
        'label' => __('Secondary CTA Button URL', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 57,
    ));
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_pricing_page_customizer');
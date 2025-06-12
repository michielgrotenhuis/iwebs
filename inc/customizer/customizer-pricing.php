<?php
/**
 * Pricing Page Customizer Settings
 * Add this file as: inc/customizer/customizer-pricing.php
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
        'description' => __('Customize all elements of the Pricing page', 'yoursite'),
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
    // PRICING PLANS
    // ========================================
    
    // Plans Enable/Disable
    $wp_customize->add_setting('pricing_plans_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plans_enable', array(
        'label' => __('Enable Pricing Plans', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'checkbox',
        'priority' => 21,
    ));
    
    // Plan 1 - Free
    $wp_customize->add_setting('pricing_plan_1_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_1_enable', array(
        'label' => __('Enable Free Plan', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'checkbox',
        'priority' => 22,
    ));
    
    $wp_customize->add_setting('pricing_plan_1_name', array(
        'default' => 'Free',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_1_name', array(
        'label' => __('Free Plan Name', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 23,
    ));
    
    $wp_customize->add_setting('pricing_plan_1_description', array(
        'default' => 'Perfect for trying out our platform',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_1_description', array(
        'label' => __('Free Plan Description', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 24,
    ));
    
    $wp_customize->add_setting('pricing_plan_1_price', array(
        'default' => '0',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_1_price', array(
        'label' => __('Free Plan Price', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 25,
    ));
    
    $wp_customize->add_setting('pricing_plan_1_features', array(
        'default' => "Up to 50 products\nBasic analytics\nEmail support\nSSL certificate\nMobile responsive",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_1_features', array(
        'label' => __('Free Plan Features (one per line)', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'textarea',
        'priority' => 26,
    ));
    
    $wp_customize->add_setting('pricing_plan_1_button_text', array(
        'default' => 'Get Started Free',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_1_button_text', array(
        'label' => __('Free Plan Button Text', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 27,
    ));
    
    // Plan 2 - Starter
    $wp_customize->add_setting('pricing_plan_2_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_2_enable', array(
        'label' => __('Enable Starter Plan', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'checkbox',
        'priority' => 28,
    ));
    
    $wp_customize->add_setting('pricing_plan_2_name', array(
        'default' => 'Starter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_2_name', array(
        'label' => __('Starter Plan Name', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 29,
    ));
    
    $wp_customize->add_setting('pricing_plan_2_description', array(
        'default' => 'Perfect for small businesses getting started',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_2_description', array(
        'label' => __('Starter Plan Description', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('pricing_plan_2_price', array(
        'default' => '19',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_2_price', array(
        'label' => __('Starter Plan Price', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 31,
    ));
    
    $wp_customize->add_setting('pricing_plan_2_features', array(
        'default' => "Up to 500 products\nAdvanced analytics\nPriority support\nCustom domain\nPayment processing\nInventory management",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_2_features', array(
        'label' => __('Starter Plan Features (one per line)', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'textarea',
        'priority' => 32,
    ));
    
    $wp_customize->add_setting('pricing_plan_2_button_text', array(
        'default' => 'Get Started',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_2_button_text', array(
        'label' => __('Starter Plan Button Text', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 33,
    ));
    
    // Plan 3 - Professional (Featured)
    $wp_customize->add_setting('pricing_plan_3_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_3_enable', array(
        'label' => __('Enable Professional Plan', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'checkbox',
        'priority' => 34,
    ));
    
    $wp_customize->add_setting('pricing_plan_3_featured', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_3_featured', array(
        'label' => __('Mark Professional as Featured Plan', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'checkbox',
        'priority' => 35,
    ));
    
    $wp_customize->add_setting('pricing_plan_3_name', array(
        'default' => 'Professional',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_3_name', array(
        'label' => __('Professional Plan Name', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 36,
    ));
    
    $wp_customize->add_setting('pricing_plan_3_description', array(
        'default' => 'Best for growing businesses',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_3_description', array(
        'label' => __('Professional Plan Description', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 37,
    ));
    
    $wp_customize->add_setting('pricing_plan_3_price', array(
        'default' => '49',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_3_price', array(
        'label' => __('Professional Plan Price', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 38,
    ));
    
    $wp_customize->add_setting('pricing_plan_3_features', array(
        'default' => "Up to 2,000 products\nAdvanced analytics\nPriority support\nCustom integrations\nMarketing automation\nMulti-location support\nAdvanced SEO tools",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_3_features', array(
        'label' => __('Professional Plan Features (one per line)', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'textarea',
        'priority' => 39,
    ));
    
    $wp_customize->add_setting('pricing_plan_3_button_text', array(
        'default' => 'Get Started',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_plan_3_button_text', array(
        'label' => __('Professional Plan Button Text', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 40,
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
        'priority' => 51,
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
        'priority' => 52,
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
        'priority' => 53,
    ));
    
    // FAQ Items
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
            'priority' => 54 + ($i - 1) * 3,
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
            'priority' => 55 + ($i - 1) * 3,
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
            'priority' => 56 + ($i - 1) * 3,
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
        'priority' => 71,
    ));
    
    // CTA Title
    $wp_customize->add_setting('pricing_cta_title', array(
        'default' => 'Ready to get started?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_cta_title', array(
        'label' => __('CTA Section Title', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 72,
    ));
    
    // CTA Subtitle
    $wp_customize->add_setting('pricing_cta_subtitle', array(
        'default' => 'Join thousands of businesses already using our platform',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_cta_subtitle', array(
        'label' => __('CTA Section Subtitle', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 73,
    ));
    
    // CTA Button Text
    $wp_customize->add_setting('pricing_cta_button_text', array(
        'default' => 'Start Your Free Trial',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_cta_button_text', array(
        'label' => __('CTA Button Text', 'yoursite'),
        'section' => 'pricing_page_editor',
        'type' => 'text',
        'priority' => 74,
    ));
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_pricing_page_customizer');
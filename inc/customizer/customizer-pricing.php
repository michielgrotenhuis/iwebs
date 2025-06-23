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
/**
 * Add DIFM Banner customizer options to pricing page section
 */
function yoursite_difm_banner_customizer($wp_customize) {
    
    // Add DIFM Banner subsection to pricing page
    $wp_customize->add_section('pricing_difm_banner', array(
        'title' => __('DIFM Banner (Pricing Page)', 'yoursite'),
        'description' => __('Customize the "Done-For-You" service banner that appears on the pricing page.', 'yoursite'),
        'panel' => 'yoursite_pages',
        'priority' => 35,
    ));
    
    // ========================================
    // BANNER ENABLE/DISABLE
    // ========================================
    
    $wp_customize->add_setting('difm_banner_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_enable', array(
        'label' => __('Enable DIFM Banner', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // ========================================
    // CONTENT SETTINGS
    // ========================================
    
    // Badge Text
    $wp_customize->add_setting('difm_banner_badge_text', array(
        'default' => 'Done-For-You Service',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_badge_text', array(
        'label' => __('Badge Text', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'text',
        'priority' => 11,
    ));
    
    // Main Title
    $wp_customize->add_setting('difm_banner_title', array(
        'default' => 'Don\'t Want to Build It Yourself?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_title', array(
        'label' => __('Main Title', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'text',
        'priority' => 12,
    ));
    
    // Subtitle
    $wp_customize->add_setting('difm_banner_subtitle', array(
        'default' => 'Let our expert team build your perfect website while you focus on your business.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_subtitle', array(
        'label' => __('Subtitle', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'textarea',
        'priority' => 13,
    ));
    
    // ========================================
    // FEATURES LIST
    // ========================================
    
    // Feature 1
    $wp_customize->add_setting('difm_banner_feature_1', array(
        'default' => 'Professional Design',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_feature_1', array(
        'label' => __('Feature 1', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'text',
        'priority' => 21,
    ));
    
    // Feature 2
    $wp_customize->add_setting('difm_banner_feature_2', array(
        'default' => 'Fast Delivery',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_feature_2', array(
        'label' => __('Feature 2', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'text',
        'priority' => 22,
    ));
    
    // Feature 3
    $wp_customize->add_setting('difm_banner_feature_3', array(
        'default' => 'Full Setup Included',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_feature_3', array(
        'label' => __('Feature 3', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'text',
        'priority' => 23,
    ));
    
    // Feature 4
    $wp_customize->add_setting('difm_banner_feature_4', array(
        'default' => 'Ongoing Support',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_feature_4', array(
        'label' => __('Feature 4', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'text',
        'priority' => 24,
    ));
    
    // ========================================
    // CALL-TO-ACTION BUTTONS
    // ========================================
    
    // Primary Button Text
    $wp_customize->add_setting('difm_banner_primary_text', array(
        'default' => 'Build My Website',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_primary_text', array(
        'label' => __('Primary Button Text', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'text',
        'priority' => 31,
    ));
    
    // Primary Button URL
    $wp_customize->add_setting('difm_banner_primary_url', array(
        'default' => '/build-my-website',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_primary_url', array(
        'label' => __('Primary Button URL', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'text',
        'description' => __('Relative URL (e.g., /build-my-website) or full URL', 'yoursite'),
        'priority' => 32,
    ));
    
    // Secondary Button Text
    $wp_customize->add_setting('difm_banner_secondary_text', array(
        'default' => 'Ask Questions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_secondary_text', array(
        'label' => __('Secondary Button Text', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'text',
        'priority' => 33,
    ));
    
    // Secondary Button URL
    $wp_customize->add_setting('difm_banner_secondary_url', array(
        'default' => '/contact',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_secondary_url', array(
        'label' => __('Secondary Button URL', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'type' => 'text',
        'description' => __('Relative URL (e.g., /contact) or full URL', 'yoursite'),
        'priority' => 34,
    ));
    
    // ========================================
    // DESIGN SETTINGS
    // ========================================
    
    // Background Color
    $wp_customize->add_setting('difm_banner_bg_color', array(
        'default' => '#f8fafc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'difm_banner_bg_color', array(
        'label' => __('Background Color', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'priority' => 41,
    )));
    
    // Primary Button Color
    $wp_customize->add_setting('difm_banner_primary_color', array(
        'default' => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'difm_banner_primary_color', array(
        'label' => __('Primary Button Color', 'yoursite'),
        'section' => 'pricing_difm_banner',
        'priority' => 42,
    )));
}

// Hook the DIFM banner customizer to the existing pricing customizer
add_action('customize_register', 'yoursite_difm_banner_customizer');

/**
 * Generate dynamic CSS for DIFM banner
 */
function yoursite_difm_banner_dynamic_css() {
    $bg_color = get_theme_mod('difm_banner_bg_color', '#f8fafc');
    $primary_color = get_theme_mod('difm_banner_primary_color', '#3b82f6');
    
    // Generate secondary color (darker version of primary)
    $primary_rgb = sscanf($primary_color, "#%02x%02x%02x");
    $primary_darker = sprintf("#%02x%02x%02x", 
        max(0, $primary_rgb[0] - 20), 
        max(0, $primary_rgb[1] - 20), 
        max(0, $primary_rgb[2] - 20)
    );
    
    echo '<style id="difm-banner-dynamic-css">';
    echo '.difm-banner-section { background-color: ' . esc_attr($bg_color) . '; }';
    echo '.difm-banner-primary-btn { background: linear-gradient(135deg, ' . esc_attr($primary_color) . ' 0%, ' . esc_attr($primary_darker) . ' 100%); }';
    echo '.difm-banner-primary-btn:hover { background: linear-gradient(135deg, ' . esc_attr($primary_darker) . ' 0%, ' . esc_attr($primary_color) . ' 100%); }';
    echo '</style>';
}
add_action('wp_head', 'yoursite_difm_banner_dynamic_css');

/**
 * Add DIFM banner CSS classes to buttons
 */
function yoursite_difm_banner_button_classes($content) {
    // Add custom classes to buttons for styling
    $content = str_replace(
        'bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700',
        'difm-banner-primary-btn',
        $content
    );
    
    return $content;
}

/**
 * Helper function to check if DIFM banner should be displayed
 */
function yoursite_should_show_difm_banner() {
    return get_theme_mod('difm_banner_enable', true);
}

/**
 * Shortcode for DIFM banner (optional - for use in other pages)
 */
function yoursite_difm_banner_shortcode($atts) {
    if (!yoursite_should_show_difm_banner()) {
        return '';
    }
    
    $atts = shortcode_atts(array(
        'show_visual' => 'true',
        'layout' => 'default' // default, compact, minimal
    ), $atts);
    
    ob_start();
    
    // Include the banner section code here (simplified version for shortcode)
    echo '<div class="difm-banner-shortcode py-12">';
    // Simplified version of the banner
    echo '</div>';
    
    return ob_get_clean();
}
add_shortcode('difm_banner', 'yoursite_difm_banner_shortcode');

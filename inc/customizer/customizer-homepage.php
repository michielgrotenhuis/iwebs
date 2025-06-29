<?php
/**
 * Homepage customizer options - UPDATED TO MATCH CURRENT TEMPLATE
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add homepage customizer options
 */
function yoursite_homepage_customizer($wp_customize) {
    
    // Homepage Section
    $wp_customize->add_section('homepage_editor', array(
        'title' => __('Homepage', 'yoursite'),
        'panel' => 'yoursite_pages',
        'priority' => 10,
    ));
    
    // ===================
    // HERO SECTION
    // ===================
    
    // Hero Enable/Disable
    $wp_customize->add_setting('hero_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Trust Badge
    $wp_customize->add_setting('hero_trust_badge', array(
        'default' => __('Trusted by 50,000+ merchants', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_trust_badge', array(
        'label' => __('Hero Trust Badge Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 11,
    ));
    
    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default' => __('Launch Your Online Store in Minutes', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 12,
    ));
    
    // Hero Highlight Text
    $wp_customize->add_setting('hero_highlight', array(
        'default' => __('Not Hours', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_highlight', array(
        'label' => __('Hero Highlight Text (colored)', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 13,
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => __('The easiest way to build, launch, and scale your e-commerce business. No coding required, results guaranteed.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'textarea',
        'priority' => 14,
    ));
    
    // Hero Benefits (3 pills)
    for ($i = 1; $i <= 3; $i++) {
        $defaults = array(
            1 => '✓ 14-day free trial',
            2 => '✓ No credit card required',
            3 => '✓ Setup in 5 minutes'
        );
        
        $wp_customize->add_setting("hero_benefit_{$i}", array(
            'default' => $defaults[$i],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("hero_benefit_{$i}", array(
            'label' => sprintf(__('Hero Benefit %d', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'text',
            'priority' => 14 + $i,
        ));
    }
    
    // Primary CTA Button
    $wp_customize->add_setting('cta_primary_text', array(
        'default' => __('Start Your Free Store', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('cta_primary_text', array(
        'label' => __('Primary Button Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 18,
    ));
    
    $wp_customize->add_setting('cta_primary_url', array(
        'default' => '#signup',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('cta_primary_url', array(
        'label' => __('Primary Button URL', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'url',
        'priority' => 19,
    ));
    
    // Secondary CTA Button
    $wp_customize->add_setting('cta_secondary_text', array(
        'default' => __('Watch Demo', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('cta_secondary_text', array(
        'label' => __('Secondary Button Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 20,
    ));
    
    $wp_customize->add_setting('cta_secondary_url', array(
        'default' => '#demo',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('cta_secondary_url', array(
        'label' => __('Secondary Button URL', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'url',
        'priority' => 21,
    ));
    
    // Risk Reversal Text
    $wp_customize->add_setting('hero_risk_reversal', array(
        'default' => __('Cancel anytime. 30-day money-back guarantee.', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_risk_reversal', array(
        'label' => __('Risk Reversal Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 22,
    ));
    
    // Hero Dashboard Image
    $wp_customize->add_setting('hero_dashboard_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_dashboard_image', array(
        'label' => __('Dashboard Preview Image', 'yoursite'),
        'section' => 'homepage_editor',
        'description' => __('Image shown below the hero text (recommended: 1200x600px)', 'yoursite'),
        'priority' => 23,
    )));
    
    // Hero Video URL
    $wp_customize->add_setting('hero_video_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_video_url', array(
        'label' => __('Dashboard Video URL', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'url',
        'description' => __('YouTube video URL to play when clicking the dashboard preview', 'yoursite'),
        'priority' => 24,
    ));
    
    // ===================
    // SOCIAL PROOF SECTION
    // ===================
    
    // Social Proof Enable/Disable
    $wp_customize->add_setting('social_proof_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('social_proof_enable', array(
        'label' => __('Enable Social Proof Section', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'checkbox',
        'priority' => 30,
    ));
    
    // Social Proof Text
    $wp_customize->add_setting('social_proof_text', array(
        'default' => __('Trusted by 50,000+ merchants in 180+ countries', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('social_proof_text', array(
        'label' => __('Social Proof Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 31,
    ));
    
    // Logo uploads (5 logos)
    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting("social_proof_logo_{$i}", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "social_proof_logo_{$i}", array(
            'label' => sprintf(__('Company Logo %d', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'priority' => 31 + $i,
        )));
    }
    
    // ===================
    // PROBLEM/SOLUTION SECTION
    // ===================
    
    // Problem Section Enable/Disable
    $wp_customize->add_setting('problem_section_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('problem_section_enable', array(
        'label' => __('Enable Problem/Solution Section', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'checkbox',
        'priority' => 40,
    ));
    
    // Problem Title
    $wp_customize->add_setting('problem_title', array(
        'default' => __('Tired of Complex E-commerce Solutions?', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('problem_title', array(
        'label' => __('Problem Section Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 41,
    ));
    
    // Problem Subtitle
    $wp_customize->add_setting('problem_subtitle', array(
        'default' => __('Most platforms are either too basic or overwhelmingly complex. We\'ve built the perfect middle ground.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('problem_subtitle', array(
        'label' => __('Problem Section Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'textarea',
        'priority' => 42,
    ));
    
    // ===================
    // KEY BENEFITS SECTION
    // ===================
    
    // Benefits Enable/Disable
    $wp_customize->add_setting('benefits_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('benefits_enable', array(
        'label' => __('Enable Key Benefits Section', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'checkbox',
        'priority' => 50,
    ));
    
    // Benefits Title
    $wp_customize->add_setting('benefits_title', array(
        'default' => __('Everything You Need to Succeed Online', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('benefits_title', array(
        'label' => __('Benefits Section Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 51,
    ));
    
    // Benefits Subtitle
    $wp_customize->add_setting('benefits_subtitle', array(
        'default' => __('From beautiful storefronts to powerful analytics, we\'ve got you covered', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('benefits_subtitle', array(
        'label' => __('Benefits Section Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'textarea',
        'priority' => 52,
    ));
    
    // 6 Benefits (matching template)
    $benefit_defaults = array(
        array(
            'title' => __('Drag & Drop Builder', 'yoursite'),
            'description' => __('Create stunning pages without any coding. Our visual builder makes it simple.', 'yoursite'),
            'color' => 'blue'
        ),
        array(
            'title' => __('Secure Payments', 'yoursite'),
            'description' => __('Accept all major payment methods with bank-level security and fraud protection.', 'yoursite'),
            'color' => 'green'
        ),
        array(
            'title' => __('Advanced Analytics', 'yoursite'),
            'description' => __('Track sales, customers, and growth with detailed reports and insights.', 'yoursite'),
            'color' => 'purple'
        ),
        array(
            'title' => __('Global Shipping', 'yoursite'),
            'description' => __('Ship anywhere with integrated carriers and automated label printing.', 'yoursite'),
            'color' => 'orange'
        ),
        array(
            'title' => __('Marketing Tools', 'yoursite'),
            'description' => __('Built-in SEO, email marketing, and social media integration to grow your reach.', 'yoursite'),
            'color' => 'pink'
        ),
        array(
            'title' => __('24/7 Support', 'yoursite'),
            'description' => __('Get help when you need it with our dedicated support team and knowledge base.', 'yoursite'),
            'color' => 'indigo'
        )
    );
    
    for ($i = 1; $i <= 6; $i++) {
        $default = $benefit_defaults[$i-1];
        
        // Benefit Title
        $wp_customize->add_setting("benefit_{$i}_title", array(
            'default' => $default['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("benefit_{$i}_title", array(
            'label' => sprintf(__('Benefit %d Title', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'text',
            'priority' => 52 + ($i * 3),
        ));
        
        // Benefit Description
        $wp_customize->add_setting("benefit_{$i}_description", array(
            'default' => $default['description'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("benefit_{$i}_description", array(
            'label' => sprintf(__('Benefit %d Description', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'textarea',
            'priority' => 53 + ($i * 3),
        ));
        
        // Benefit Icon Color
        $wp_customize->add_setting("benefit_{$i}_color", array(
            'default' => $default['color'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("benefit_{$i}_color", array(
            'label' => sprintf(__('Benefit %d Icon Color', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'select',
            'choices' => array(
                'blue' => __('Blue', 'yoursite'),
                'green' => __('Green', 'yoursite'),
                'purple' => __('Purple', 'yoursite'),
                'orange' => __('Orange', 'yoursite'),
                'red' => __('Red', 'yoursite'),
                'yellow' => __('Yellow', 'yoursite'),
                'pink' => __('Pink', 'yoursite'),
                'indigo' => __('Indigo', 'yoursite'),
                'gray' => __('Gray', 'yoursite'),
            ),
            'priority' => 54 + ($i * 3),
        ));
    }
    
    // ===================
    // PRICING SECTION
    // ===================
    
    // Pricing Enable/Disable
    $wp_customize->add_setting('pricing_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_enable', array(
        'label' => __('Enable Pricing Section', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'checkbox',
        'priority' => 70,
    ));
    
    // Pricing Title
    $wp_customize->add_setting('pricing_title', array(
        'default' => __('Simple, Transparent Pricing', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_title', array(
        'label' => __('Pricing Section Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 71,
    ));
    
    // Pricing Subtitle
    $wp_customize->add_setting('pricing_subtitle', array(
        'default' => __('Start free, then choose the plan that scales with your business', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_subtitle', array(
        'label' => __('Pricing Section Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 72,
    ));
    
    // Homepage Pricing Count
    $wp_customize->add_setting('homepage_pricing_count', array(
        'default' => 3,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('homepage_pricing_count', array(
        'label' => __('Number of Pricing Plans to Show', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'number',
        'description' => __('How many pricing plans to display on the homepage', 'yoursite'),
        'input_attrs' => array(
            'min' => 1,
            'max' => 4,
        ),
        'priority' => 73,
    ));
    
    // ===================
    // DIFM BANNER SECTION
    // ===================
    
    // DIFM Enable/Disable
    $wp_customize->add_setting('difm_banner_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_enable', array(
        'label' => __('Enable Done-For-You Banner', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'checkbox',
        'priority' => 80,
    ));
    
    // DIFM Badge Text
    $wp_customize->add_setting('difm_banner_badge_text', array(
        'default' => __('Done-For-You Service', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_badge_text', array(
        'label' => __('DIFM Badge Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 81,
    ));
    
    // DIFM Title
    $wp_customize->add_setting('difm_banner_title', array(
        'default' => __('Don\'t Want to Build It Yourself?', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_title', array(
        'label' => __('DIFM Banner Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 82,
    ));
    
    // DIFM Subtitle
    $wp_customize->add_setting('difm_banner_subtitle', array(
        'default' => __('Let our expert team build your perfect store while you focus on your business. Professional results, guaranteed.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_subtitle', array(
        'label' => __('DIFM Banner Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'textarea',
        'priority' => 83,
    ));
    
    // DIFM Features (4 features)
    $difm_feature_defaults = array(
        1 => 'Professional Design',
        2 => '5-Day Delivery',
        3 => 'Money-Back Guarantee',
        4 => 'Ongoing Support'
    );
    
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("difm_banner_feature_{$i}", array(
            'default' => $difm_feature_defaults[$i],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("difm_banner_feature_{$i}", array(
            'label' => sprintf(__('DIFM Feature %d', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'text',
            'priority' => 83 + $i,
        ));
    }
    
    // DIFM Primary Button
    $wp_customize->add_setting('difm_banner_primary_text', array(
        'default' => __('Build My Store', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_primary_text', array(
        'label' => __('DIFM Primary Button Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 88,
    ));
    
    $wp_customize->add_setting('difm_banner_primary_url', array(
        'default' => '/build-my-website',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_primary_url', array(
        'label' => __('DIFM Primary Button URL', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'url',
        'priority' => 89,
    ));
    
    // DIFM Secondary Button
    $wp_customize->add_setting('difm_banner_secondary_text', array(
        'default' => __('Ask Questions', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_secondary_text', array(
        'label' => __('DIFM Secondary Button Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 90,
    ));
    
    $wp_customize->add_setting('difm_banner_secondary_url', array(
        'default' => '/contact',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_banner_secondary_url', array(
        'label' => __('DIFM Secondary Button URL', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'url',
        'priority' => 91,
    ));
    
    // ===================
    // TESTIMONIALS SECTION
    // ===================
    
    // Testimonials Enable/Disable
    $wp_customize->add_setting('testimonials_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('testimonials_enable', array(
        'label' => __('Enable Testimonials Section', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'checkbox',
        'priority' => 100,
    ));
    
    // Testimonials Title
    $wp_customize->add_setting('testimonials_title', array(
        'default' => __('Loved by 50,000+ Merchants Worldwide', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('testimonials_title', array(
        'label' => __('Testimonials Section Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 101,
    ));
    
    // Testimonials Subtitle
    $wp_customize->add_setting('testimonials_subtitle', array(
        'default' => __('See why businesses choose us to power their online success', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('testimonials_subtitle', array(
        'label' => __('Testimonials Section Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 102,
    ));
    
    // Testimonials Count
    $wp_customize->add_setting('testimonials_count', array(
        'default' => 3,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('testimonials_count', array(
        'label' => __('Number of Testimonials to Show', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 6,
        ),
        'priority' => 103,
    ));
    
    // ===================
    // STATS SECTION
    // ===================
    
    // Stats Enable/Disable
    $wp_customize->add_setting('stats_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('stats_enable', array(
        'label' => __('Enable Stats Section', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'checkbox',
        'priority' => 110,
    ));
    
    // Stats Title
    $wp_customize->add_setting('stats_title', array(
        'default' => __('Trusted by Growing Businesses', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('stats_title', array(
        'label' => __('Stats Section Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 111,
    ));
    
    // Stats Subtitle
    $wp_customize->add_setting('stats_subtitle', array(
        'default' => __('Join thousands of successful merchants who chose us', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('stats_subtitle', array(
        'label' => __('Stats Section Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 112,
    ));
    
    // 4 Stats
    $stat_defaults = array(
        array('number' => '50K+', 'label' => 'Active Stores'),
        array('number' => '$2B+', 'label' => 'Sales Processed'),
        array('number' => '180+', 'label' => 'Countries'),
        array('number' => '99.9%', 'label' => 'Uptime')
    );
    
    for ($i = 1; $i <= 4; $i++) {
        $default = $stat_defaults[$i-1];
        
        // Stat Number
        $wp_customize->add_setting("stat_{$i}_number", array(
            'default' => $default['number'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("stat_{$i}_number", array(
            'label' => sprintf(__('Stat %d Number', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'text',
            'priority' => 112 + ($i * 2),
        ));
        
        // Stat Label
        $wp_customize->add_setting("stat_{$i}_label", array(
            'default' => $default['label'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("stat_{$i}_label", array(
            'label' => sprintf(__('Stat %d Label', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'text',
            'priority' => 113 + ($i * 2),
        ));
    }
    
    // ===================
    // FAQ SECTION
    // ===================
    
    // FAQ Enable/Disable
    $wp_customize->add_setting('faq_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('faq_enable', array(
        'label' => __('Enable FAQ Section', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'checkbox',
        'priority' => 120,
    ));
    
    // FAQ Title
    $wp_customize->add_setting('faq_title', array(
        'default' => __('Frequently Asked Questions', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('faq_title', array(
        'label' => __('FAQ Section Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 121,
    ));
    
    // FAQ Subtitle
    $wp_customize->add_setting('faq_subtitle', array(
        'default' => __('Everything you need to know to get started', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('faq_subtitle', array(
        'label' => __('FAQ Section Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 122,
    ));
    
    // 5 FAQ Items
    $faq_defaults = array(
        array(
            'question' => 'How quickly can I launch my store?',
            'answer' => 'You can have a fully functional store live in under 5 minutes using our templates and quick setup wizard.'
        ),
        array(
            'question' => 'Do I need any technical skills?',
            'answer' => 'Not at all! Our drag-and-drop builder is designed for anyone to use, regardless of technical background.'
        ),
        array(
            'question' => 'What payment methods can I accept?',
            'answer' => 'We support all major credit cards, PayPal, Apple Pay, Google Pay, and many regional payment methods.'
        ),
        array(
            'question' => 'Is there a free trial?',
            'answer' => 'Yes! All paid plans include a 14-day free trial. No credit card required to get started.'
        ),
        array(
            'question' => 'Can I migrate from another platform?',
            'answer' => 'Absolutely! We offer free migration assistance to help you move your store from any platform.'
        )
    );
    
    for ($i = 1; $i <= 5; $i++) {
        $default = $faq_defaults[$i-1];
        
        // FAQ Question
        $wp_customize->add_setting("faq_{$i}_question", array(
            'default' => $default['question'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("faq_{$i}_question", array(
            'label' => sprintf(__('FAQ %d Question', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'text',
            'priority' => 122 + ($i * 2),
        ));
        
        // FAQ Answer
        $wp_customize->add_setting("faq_{$i}_answer", array(
            'default' => $default['answer'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("faq_{$i}_answer", array(
            'label' => sprintf(__('FAQ %d Answer', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'textarea',
            'priority' => 123 + ($i * 2),
        ));
    }
    
    // ===================
    // FINAL CTA SECTION
    // ===================
    
    // Final CTA Enable/Disable
    $wp_customize->add_setting('final_cta_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('final_cta_enable', array(
        'label' => __('Enable Final CTA Section', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'checkbox',
        'priority' => 140,
    ));
    
    // Final CTA Title
    $wp_customize->add_setting('final_cta_title', array(
        'default' => __('Ready to launch your store?', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('final_cta_title', array(
        'label' => __('Final CTA Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 141,
    ));
    
    // Final CTA Subtitle
    $wp_customize->add_setting('final_cta_subtitle', array(
        'default' => __('Start free today—no credit card required. Join thousands of successful merchants.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('final_cta_subtitle', array(
        'label' => __('Final CTA Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'textarea',
        'priority' => 142,
    ));
    
    // Final CTA Primary Button
    $wp_customize->add_setting('final_cta_primary_text', array(
        'default' => __('Start Free Trial', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('final_cta_primary_text', array(
        'label' => __('Final CTA Primary Button Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 143,
    ));
    
    $wp_customize->add_setting('final_cta_primary_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('final_cta_primary_url', array(
        'label' => __('Final CTA Primary Button URL', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'url',
        'priority' => 144,
    ));
    
    // Final CTA Secondary Button
    $wp_customize->add_setting('final_cta_secondary_text', array(
        'default' => __('Book a Demo', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('final_cta_secondary_text', array(
        'label' => __('Final CTA Secondary Button Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 145,
    ));
    
    $wp_customize->add_setting('final_cta_secondary_url', array(
        'default' => '/contact',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('final_cta_secondary_url', array(
        'label' => __('Final CTA Secondary Button URL', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'url',
        'priority' => 146,
    ));
}
add_action('customize_register', 'yoursite_homepage_customizer');

/**
 * Sanitize checkbox
 */
if (!function_exists('yoursite_sanitize_checkbox')) {
    function yoursite_sanitize_checkbox($input) {
        return ($input === true || $input === '1' || $input === 1) ? true : false;
    }
}
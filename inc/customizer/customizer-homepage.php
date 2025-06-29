<?php
/**
 * Homepage customizer options - COMPLETE FIXED VERSION
 * This file makes every element on the homepage customizable with proper WordPress structure
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add homepage customizer options - COMPLETE VERSION
 */
function yoursite_homepage_customizer($wp_customize) {
    
    // Add Pages Panel if it doesn't exist
    if (!$wp_customize->get_panel('yoursite_pages')) {
        $wp_customize->add_panel('yoursite_pages', array(
            'title' => __('Theme Pages', 'yoursite'),
            'description' => __('Customize your theme pages content', 'yoursite'),
            'priority' => 30,
        ));
    }
    
    // Homepage Section
    if (!$wp_customize->get_section('homepage_editor')) {
        $wp_customize->add_section('homepage_editor', array(
            'title' => __('Homepage', 'yoursite'),
            'panel' => 'yoursite_pages',
            'priority' => 10,
            'description' => __('Customize your homepage content and layout', 'yoursite'),
        ));
    }
    
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
    
    // Problem "Before" Items (3 items)
    $before_defaults = array(
        1 => 'Weeks of setup and configuration',
        2 => 'Expensive monthly fees + hidden costs',
        3 => 'Need developers for customization'
    );
    
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("problem_before_{$i}", array(
            'default' => $before_defaults[$i],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("problem_before_{$i}", array(
            'label' => sprintf(__('Problem "Before" Item %d', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'text',
            'priority' => 42 + $i,
        ));
    }
    
    // Problem "After" Items (3 items)
    $after_defaults = array(
        1 => 'Live in 5 minutes with templates',
        2 => 'Transparent pricing, no surprises',
        3 => 'Drag & drop - no coding needed'
    );
    
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("problem_after_{$i}", array(
            'default' => $after_defaults[$i],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("problem_after_{$i}", array(
            'label' => sprintf(__('Solution "After" Item %d', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'text',
            'priority' => 45 + $i,
        ));
    }
    
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
    
    // 6 Benefits (simplified - just title and description)
    $benefit_defaults = array(
        1 => array('title' => 'Drag & Drop Builder', 'description' => 'Create stunning pages without any coding. Our visual builder makes it simple.'),
        2 => array('title' => 'Secure Payments', 'description' => 'Accept all major payment methods with bank-level security and fraud protection.'),
        3 => array('title' => 'Advanced Analytics', 'description' => 'Track sales, customers, and growth with detailed reports and insights.'),
        4 => array('title' => 'Global Shipping', 'description' => 'Ship anywhere with integrated carriers and automated label printing.'),
        5 => array('title' => 'Marketing Tools', 'description' => 'Built-in SEO, email marketing, and social media integration to grow your reach.'),
        6 => array('title' => '24/7 Support', 'description' => 'Get help when you need it with our dedicated support team and knowledge base.')
    );
    
    for ($i = 1; $i <= 6; $i++) {
        // Benefit Title
        $wp_customize->add_setting("benefit_{$i}_title", array(
            'default' => $benefit_defaults[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("benefit_{$i}_title", array(
            'label' => sprintf(__('Benefit %d Title', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'text',
            'priority' => 52 + ($i * 2),
        ));
        
        // Benefit Description
        $wp_customize->add_setting("benefit_{$i}_description", array(
            'default' => $benefit_defaults[$i]['description'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("benefit_{$i}_description", array(
            'label' => sprintf(__('Benefit %d Description', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'textarea',
            'priority' => 53 + ($i * 2),
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
        'priority' => 80,
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
        'priority' => 81,
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
        'priority' => 82,
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
        'priority' => 83,
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
        'priority' => 90,
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
        'priority' => 91,
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
        'priority' => 92,
    ));
    
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
        'priority' => 93,
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
        'priority' => 94,
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
        'priority' => 110,
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
        'priority' => 111,
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
        'priority' => 112,
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
        'priority' => 113,
    ));
    
    // Fallback Testimonials (3 testimonials)
    for ($i = 1; $i <= 3; $i++) {
        $testimonial_defaults = array(
            1 => array(
                'content' => 'This platform transformed our business. We went from zero to $50k in monthly sales in just 3 months!',
                'name' => 'Sarah Chen',
                'title' => 'Founder, EcoProducts'
            ),
            2 => array(
                'content' => 'The easiest e-commerce platform I\'ve ever used. Setup was literally 5 minutes and we were selling immediately.',
                'name' => 'Mike Rodriguez',
                'title' => 'CEO, TechGadgets'
            ),
            3 => array(
                'content' => 'Customer support is incredible. They helped us customize everything perfectly for our unique needs.',
                'name' => 'Emily Johnson',
                'title' => 'Owner, Handmade Haven'
            )
        );
        
        $default = $testimonial_defaults[$i];
        
        // Testimonial Content
        $wp_customize->add_setting("testimonial_{$i}_content", array(
            'default' => $default['content'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("testimonial_{$i}_content", array(
            'label' => sprintf(__('Testimonial %d Content', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'textarea',
            'priority' => 113 + ($i * 3),
        ));
        
        // Testimonial Name
        $wp_customize->add_setting("testimonial_{$i}_name", array(
            'default' => $default['name'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("testimonial_{$i}_name", array(
            'label' => sprintf(__('Testimonial %d Name', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'text',
            'priority' => 114 + ($i * 3),
        ));
        
        // Testimonial Title
        $wp_customize->add_setting("testimonial_{$i}_title", array(
            'default' => $default['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("testimonial_{$i}_title", array(
            'label' => sprintf(__('Testimonial %d Title/Company', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'type' => 'text',
            'priority' => 115 + ($i * 3),
        ));
    }
    
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
        'priority' => 130,
    ));
    
    // Stats Title
    $wp_customize->add_setting('stats_title', array(
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('stats_title', array(
        'label' => __('Stats Section Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 131,
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
        'priority' => 132,
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
            'priority' => 132 + ($i * 2),
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
            'priority' => 133 + ($i * 2),
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
        'priority' => 150,
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
        'priority' => 151,
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
        'priority' => 152,
    ));
    
    // 5 FAQ Items
    $faq_defaults = array(
        1 => array(
            'question' => 'How quickly can I launch my store?',
            'answer' => 'You can have a fully functional store live in under 5 minutes using our templates and quick setup wizard.'
        ),
        2 => array(
            'question' => 'Do I need any technical skills?',
            'answer' => 'Not at all! Our drag-and-drop builder is designed for anyone to use, regardless of technical background.'
        ),
        3 => array(
            'question' => 'What payment methods can I accept?',
            'answer' => 'We support all major credit cards, PayPal, Apple Pay, Google Pay, and many regional payment methods.'
        ),
        4 => array(
            'question' => 'Is there a free trial?',
            'answer' => 'Yes! All paid plans include a 14-day free trial. No credit card required to get started.'
        ),
        5 => array(
            'question' => 'Can I migrate from another platform?',
            'answer' => 'Absolutely! We offer free migration assistance to help you move your store from any platform.'
        )
    );
    
    for ($i = 1; $i <= 5; $i++) {
        $default = $faq_defaults[$i];
        
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
            'priority' => 152 + ($i * 2),
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
            'priority' => 153 + ($i * 2),
        ));
    }
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

/**
 * Add customizer CSS for better organization - HOMEPAGE SPECIFIC
 */
function yoursite_homepage_customizer_css() {
    ?>
    <style>
    /* Better customizer styling for homepage */
    .customize-control-description {
        font-style: italic;
        color: #666;
        margin-top: 5px;
    }
    
    .customize-section-description {
        margin-bottom: 15px;
        padding: 12px;
        background: #f9f9f9;
        border-left: 4px solid #0073aa;
        font-size: 13px;
    }
    
    /* Section separators */
    .customize-control.section-separator {
        margin: 20px 0 10px;
        padding: 8px 12px;
        background: #f1f1f1;
        border-left: 4px solid #0073aa;
        font-weight: bold;
        font-size: 13px;
    }
    
    /* Group related controls with colored borders */
    .customize-control[id*="hero_"]:not([id*="_enable"]) {
        border-left: 3px solid #007cba;
        padding-left: 8px;
        margin-left: 5px;
    }
    
    .customize-control[id*="social_proof_"]:not([id*="_enable"]) {
        border-left: 3px solid #00a0d2;
        padding-left: 8px;
        margin-left: 5px;
    }
    
    .customize-control[id*="problem_"]:not([id*="_enable"]) {
        border-left: 3px solid #826eb4;
        padding-left: 8px;
        margin-left: 5px;
    }
    
    .customize-control[id*="benefit_"] {
        border-left: 3px solid #f56e28;
        padding-left: 8px;
        margin-left: 5px;
    }
    
    .customize-control[id*="pricing_"]:not([id*="_enable"]) {
        border-left: 3px solid #d63638;
        padding-left: 8px;
        margin-left: 5px;
    }
    
    .customize-control[id*="difm_"] {
        border-left: 3px solid #7c3aed;
        padding-left: 8px;
        margin-left: 5px;
    }
    
    .customize-control[id*="testimonial"] {
        border-left: 3px solid #00ba37;
        padding-left: 8px;
        margin-left: 5px;
    }
    
    .customize-control[id*="stats_"]:not([id*="_enable"]),
    .customize-control[id*="stat_"] {
        border-left: 3px solid #ff6900;
        padding-left: 8px;
        margin-left: 5px;
    }
    
    .customize-control[id*="faq_"]:not([id*="_enable"]) {
        border-left: 3px solid #9b2393;
        padding-left: 8px;
        margin-left: 5px;
    }
    
    /* Enable/disable checkboxes */
    .customize-control[id*="_enable"] {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 10px;
        margin: 15px 0 10px 0;
    }
    
    .customize-control[id*="_enable"] .customize-control-title {
        font-weight: bold;
        color: #495057;
    }
    </style>
    <?php
}
add_action('customize_controls_print_styles', 'yoursite_homepage_customizer_css');

/**
 * Add customizer JavaScript for better UX - HOMEPAGE SPECIFIC
 */
function yoursite_homepage_customizer_js() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        console.log('🎨 Homepage Customizer Enhanced');
        
        // Add section headers for better organization
        var sections = {
            'hero': '🏠 Hero Section Settings',
            'social_proof': '👥 Social Proof Settings', 
            'problem': '❓ Problem/Solution Settings',
            'benefit': '✨ Benefits Settings',
            'pricing': '💰 Pricing Settings',
            'difm': '🔧 Done-For-You Settings',
            'testimonial': '💬 Testimonials Settings',
            'stats': '📊 Stats Settings',
            'faq': '❓ FAQ Settings'
        };
        
        // Add visual separators
        $.each(sections, function(prefix, title) {
            var firstControl = $('.customize-control[id*="' + prefix + '_"]:first');
            if (firstControl.length) {
                firstControl.before('<div class="section-separator">' + title + '</div>');
            }
        });
        
        // Handle enable/disable toggles
        $('.customize-control[id$="_enable"] input[type="checkbox"]').each(function() {
            var $checkbox = $(this);
            var controlId = $checkbox.closest('.customize-control').attr('id');
            var prefix = controlId.replace('customize-control-', '').replace('_enable', '');
            
            function toggleRelatedControls() {
                var isEnabled = $checkbox.is(':checked');
                var relatedControls = $('.customize-control[id*="' + prefix + '_"]:not([id$="_enable"])');
                
                if (isEnabled) {
                    relatedControls.slideDown(300);
                } else {
                    relatedControls.slideUp(300);
                }
            }
            
            // Initial state
            toggleRelatedControls();
            
            // On change
            $checkbox.on('change', toggleRelatedControls);
        });
        
        // Add helpful descriptions
        var helpTexts = {
            'hero_enable': 'Controls the main banner section at the top of your homepage',
            'social_proof_enable': 'Shows company logos and trust indicators below the hero',
            'problem_section_enable': 'Displays before/after comparison of your solution',
            'benefits_enable': 'Showcases your key product features and benefits',
            'pricing_enable': 'Displays pricing plans from your Pricing post type',
            'difm_banner_enable': 'Promotes your done-for-you service offering',
            'testimonials_enable': 'Shows customer reviews and testimonials',
            'stats_enable': 'Displays key company statistics and metrics',
            'faq_enable': 'Shows frequently asked questions section'
        };
        
        $.each(helpTexts, function(controlId, helpText) {
            var control = $('#customize-control-' + controlId);
            if (control.length && !control.find('.customize-control-description').length) {
                control.find('.customize-control-title').after(
                    '<span class="description customize-control-description">' + helpText + '</span>'
                );
            }
        });
        
        console.log('✅ Customizer enhancements loaded');
    });
    </script>
    <?php
}
add_action('customize_controls_print_footer_scripts', 'yoursite_homepage_customizer_js');
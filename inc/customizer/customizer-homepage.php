<?php
/**
 * Homepage customizer options
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
    
    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default' => __('Build Your Online Store in Minutes', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 11,
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => __('No code. No hassle. Just launch and sell.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'textarea',
        'priority' => 12,
    ));
    
    // Hero Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label' => __('Hero Background Image', 'yoursite'),
        'section' => 'homepage_editor',
        'priority' => 13,
    )));
    
    // Primary CTA Button
    $wp_customize->add_setting('cta_primary_text', array(
        'default' => __('Start Free Trial', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('cta_primary_text', array(
        'label' => __('Primary Button Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 14,
    ));
    
    $wp_customize->add_setting('cta_primary_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('cta_primary_url', array(
        'label' => __('Primary Button URL', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'url',
        'priority' => 15,
    ));
    
    // Secondary CTA Button
    $wp_customize->add_setting('cta_secondary_text', array(
        'default' => __('View Demo', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('cta_secondary_text', array(
        'label' => __('Secondary Button Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 16,
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
        'priority' => 17,
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
        'description' => __('Image shown below the hero text', 'yoursite'),
        'priority' => 18,
    )));
    
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
        'priority' => 20,
    ));
    
    // Social Proof Text
    $wp_customize->add_setting('social_proof_text', array(
        'default' => __('Trusted by over 10,000 merchants worldwide', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('social_proof_text', array(
        'label' => __('Social Proof Text', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 21,
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
            'priority' => 21 + $i,
        )));
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
        'priority' => 30,
    ));
    
    // Benefits Title
    $wp_customize->add_setting('benefits_title', array(
        'default' => __('Everything you need to sell online', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('benefits_title', array(
        'label' => __('Benefits Section Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 31,
    ));
    
    // Benefits Subtitle
    $wp_customize->add_setting('benefits_subtitle', array(
        'default' => __('From store building to shipping, we\'ve got all the tools to help you succeed', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('benefits_subtitle', array(
        'label' => __('Benefits Section Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'textarea',
        'priority' => 32,
    ));
    
    // 4 Benefits
    $benefit_defaults = array(
        array(
            'title' => __('Drag & Drop Builder', 'yoursite'),
            'description' => __('Build your store with our intuitive drag & drop interface. No coding required.', 'yoursite'),
            'color' => 'blue'
        ),
        array(
            'title' => __('Secure Payments', 'yoursite'),
            'description' => __('Accept payments safely with our secure checkout and multiple payment options.', 'yoursite'),
            'color' => 'green'
        ),
        array(
            'title' => __('Marketing & SEO', 'yoursite'),
            'description' => __('Built-in marketing tools and SEO optimization to grow your business.', 'yoursite'),
            'color' => 'purple'
        ),
        array(
            'title' => __('Shipping Made Simple', 'yoursite'),
            'description' => __('Manage inventory and shipping with automated tools and integrations.', 'yoursite'),
            'color' => 'orange'
        )
    );
    
    for ($i = 1; $i <= 4; $i++) {
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
            'priority' => 32 + ($i * 4),
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
            'priority' => 33 + ($i * 4),
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
                'gray' => __('Gray', 'yoursite'),
            ),
            'priority' => 34 + ($i * 4),
        ));
        
        // Benefit Custom Image (optional)
        $wp_customize->add_setting("benefit_{$i}_image", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "benefit_{$i}_image", array(
            'label' => sprintf(__('Benefit %d Custom Image (Optional)', 'yoursite'), $i),
            'section' => 'homepage_editor',
            'description' => __('Upload a custom image to replace the icon', 'yoursite'),
            'priority' => 35 + ($i * 4),
        )));
    }
    
    // ===================
    // FEATURES SECTION
    // ===================
    
    // Features Enable/Disable
    $wp_customize->add_setting('features_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_enable', array(
        'label' => __('Enable Features Section', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'checkbox',
        'priority' => 50,
    ));
    
    // Features Title
    $wp_customize->add_setting('features_title', array(
        'default' => __('Powerful features for every business', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_title', array(
        'label' => __('Features Section Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 51,
    ));
    
    // Features Subtitle
    $wp_customize->add_setting('features_subtitle', array(
        'default' => __('Everything you need to create, customize, and grow your online store', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_subtitle', array(
        'label' => __('Features Section Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 52,
    ));
    
    // Features Count
    $wp_customize->add_setting('features_count', array(
        'default' => 6,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_count', array(
        'label' => __('Number of Features to Show', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 3,
            'max' => 12,
            'step' => 3,
        ),
        'priority' => 53,
    ));
    
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
        'priority' => 60,
    ));
    
    // Pricing Title
    $wp_customize->add_setting('pricing_title', array(
        'default' => __('Simple, transparent pricing', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_title', array(
        'label' => __('Pricing Section Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 61,
    ));
    
    // Pricing Subtitle
    $wp_customize->add_setting('pricing_subtitle', array(
        'default' => __('Choose the plan that\'s right for your business', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('pricing_subtitle', array(
        'label' => __('Pricing Section Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 62,
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
        'priority' => 70,
    ));
    
    // Testimonials Title
    $wp_customize->add_setting('testimonials_title', array(
        'default' => __('Loved by thousands of merchants', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('testimonials_title', array(
        'label' => __('Testimonials Section Title', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 71,
    ));
    
    // Testimonials Subtitle
    $wp_customize->add_setting('testimonials_subtitle', array(
        'default' => __('See what our customers have to say about their success', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('testimonials_subtitle', array(
        'label' => __('Testimonials Section Subtitle', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'text',
        'priority' => 72,
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
        'priority' => 73,
    ));
    
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
        'priority' => 80,
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
        'priority' => 81,
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
        'priority' => 82,
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
        'priority' => 83,
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
        'priority' => 84,
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
        'priority' => 85,
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
        'priority' => 86,
    ));
}
add_action('customize_register', 'yoursite_homepage_customizer');
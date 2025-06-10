<?php
/**
 * Features Page Customizer Settings
 * Add this to your inc/customizer.php file
 */

/**
 * Add Features Page customizer options
 */
function yoursite_features_page_customizer($wp_customize) {
    
    // Features Page Section
    $wp_customize->add_section('features_page_settings', array(
        'title' => __('Edit Pages', 'yoursite'),
        'priority' => 55,
    ));
    
    // Features Page Panel
    $wp_customize->add_panel('features_page_panel', array(
        'title' => __('Features Page', 'yoursite'),
        'description' => __('Customize all elements of the Features page', 'yoursite'),
        'priority' => 56,
    ));
    
    // Hero Section
    $wp_customize->add_section('features_hero_section', array(
        'title' => __('Hero Section', 'yoursite'),
        'panel' => 'features_page_panel',
        'priority' => 10,
    ));
    
    // Enable/Disable Hero Section
    $wp_customize->add_setting('features_hero_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'features_hero_section',
        'type' => 'checkbox',
    ));
    
    // Hero Title
    $wp_customize->add_setting('features_hero_title', array(
        'default' => __('Everything you need to sell online', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'features_hero_section',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_hero_enable', true);
        },
    ));
    
    // Hero Description
    $wp_customize->add_setting('features_hero_description', array(
        'default' => __('From store building to payment processing, marketing to analytics - discover all the powerful features that make your eCommerce dreams a reality.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_hero_description', array(
        'label' => __('Hero Description', 'yoursite'),
        'section' => 'features_hero_section',
        'type' => 'textarea',
        'active_callback' => function() {
            return get_theme_mod('features_hero_enable', true);
        },
    ));
    
    // Hero Button Text
    $wp_customize->add_setting('features_hero_button_text', array(
        'default' => __('Explore Features', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_hero_button_text', array(
        'label' => __('Hero Button Text', 'yoursite'),
        'section' => 'features_hero_section',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_hero_enable', true);
        },
    ));
    
    // Hero Button URL
    $wp_customize->add_setting('features_hero_button_url', array(
        'default' => '#features',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_hero_button_url', array(
        'label' => __('Hero Button URL', 'yoursite'),
        'section' => 'features_hero_section',
        'type' => 'url',
        'active_callback' => function() {
            return get_theme_mod('features_hero_enable', true);
        },
    ));
    
    // Store Building Section
    $wp_customize->add_section('features_store_building', array(
        'title' => __('Store Building Section', 'yoursite'),
        'panel' => 'features_page_panel',
        'priority' => 20,
    ));
    
    // Enable Store Building Section
    $wp_customize->add_setting('features_store_building_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_enable', array(
        'label' => __('Enable Store Building Section', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'checkbox',
    ));
    
    // Store Building Title
    $wp_customize->add_setting('features_store_building_title', array(
        'default' => __('Store Building', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_title', array(
        'label' => __('Section Title', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_store_building_enable', true);
        },
    ));
    
    // Store Building Description
    $wp_customize->add_setting('features_store_building_description', array(
        'default' => __('Create stunning online stores without any coding knowledge', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_description', array(
        'label' => __('Section Description', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'textarea',
        'active_callback' => function() {
            return get_theme_mod('features_store_building_enable', true);
        },
    ));
    
    // Store Building Feature 1
    $wp_customize->add_setting('features_store_building_feature_1_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_feature_1_enable', array(
        'label' => __('Enable Feature 1 (Drag & Drop Builder)', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'checkbox',
        'active_callback' => function() {
            return get_theme_mod('features_store_building_enable', true);
        },
    ));
    
    $wp_customize->add_setting('features_store_building_feature_1_title', array(
        'default' => __('Drag & Drop Builder', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_feature_1_title', array(
        'label' => __('Feature 1 Title', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_store_building_enable', true) && get_theme_mod('features_store_building_feature_1_enable', true);
        },
    ));
    
    $wp_customize->add_setting('features_store_building_feature_1_description', array(
        'default' => __('Intuitive visual editor to customize your store layout, add products, and arrange elements exactly how you want them.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_feature_1_description', array(
        'label' => __('Feature 1 Description', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'textarea',
        'active_callback' => function() {
            return get_theme_mod('features_store_building_enable', true) && get_theme_mod('features_store_building_feature_1_enable', true);
        },
    ));
    
    // Store Building Feature 2
    $wp_customize->add_setting('features_store_building_feature_2_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_feature_2_enable', array(
        'label' => __('Enable Feature 2 (Professional Templates)', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'checkbox',
        'active_callback' => function() {
            return get_theme_mod('features_store_building_enable', true);
        },
    ));
    
    $wp_customize->add_setting('features_store_building_feature_2_title', array(
        'default' => __('Professional Templates', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_feature_2_title', array(
        'label' => __('Feature 2 Title', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_store_building_enable', true) && get_theme_mod('features_store_building_feature_2_enable', true);
        },
    ));
    
    $wp_customize->add_setting('features_store_building_feature_2_description', array(
        'default' => __('Choose from 100+ mobile-responsive templates designed for conversion and optimized for your industry.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_feature_2_description', array(
        'label' => __('Feature 2 Description', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'textarea',
        'active_callback' => function() {
            return get_theme_mod('features_store_building_enable', true) && get_theme_mod('features_store_building_feature_2_enable', true);
        },
    ));
    
    // Store Building Feature 3
    $wp_customize->add_setting('features_store_building_feature_3_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_feature_3_enable', array(
        'label' => __('Enable Feature 3 (Mobile Optimized)', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'checkbox',
        'active_callback' => function() {
            return get_theme_mod('features_store_building_enable', true);
        },
    ));
    
    $wp_customize->add_setting('features_store_building_feature_3_title', array(
        'default' => __('Mobile Optimized', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_feature_3_title', array(
        'label' => __('Feature 3 Title', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_store_building_enable', true) && get_theme_mod('features_store_building_feature_3_enable', true);
        },
    ));
    
    $wp_customize->add_setting('features_store_building_feature_3_description', array(
        'default' => __('Every store is automatically optimized for mobile devices, ensuring perfect shopping experience across all screen sizes.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_store_building_feature_3_description', array(
        'label' => __('Feature 3 Description', 'yoursite'),
        'section' => 'features_store_building',
        'type' => 'textarea',
        'active_callback' => function() {
            return get_theme_mod('features_store_building_enable', true) && get_theme_mod('features_store_building_feature_3_enable', true);
        },
    ));
    
    // Payments & Checkout Section
    $wp_customize->add_section('features_payments_checkout', array(
        'title' => __('Payments & Checkout Section', 'yoursite'),
        'panel' => 'features_page_panel',
        'priority' => 30,
    ));
    
    // Enable Payments Section
    $wp_customize->add_setting('features_payments_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_payments_enable', array(
        'label' => __('Enable Payments & Checkout Section', 'yoursite'),
        'section' => 'features_payments_checkout',
        'type' => 'checkbox',
    ));
    
    // Payments Section Title
    $wp_customize->add_setting('features_payments_title', array(
        'default' => __('Payments & Checkout', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_payments_title', array(
        'label' => __('Section Title', 'yoursite'),
        'section' => 'features_payments_checkout',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_payments_enable', true);
        },
    ));
    
    // Payments Section Description
    $wp_customize->add_setting('features_payments_description', array(
        'default' => __('Secure, fast checkout that converts browsers into buyers', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_payments_description', array(
        'label' => __('Section Description', 'yoursite'),
        'section' => 'features_payments_checkout',
        'type' => 'textarea',
        'active_callback' => function() {
            return get_theme_mod('features_payments_enable', true);
        },
    ));
    
    // Payments Features (similar pattern for all 3 features)
    for ($i = 1; $i <= 3; $i++) {
        $default_titles = array(
            1 => __('Secure Payments', 'yoursite'),
            2 => __('One-Click Checkout', 'yoursite'),
            3 => __('Multi-Currency', 'yoursite')
        );
        
        $default_descriptions = array(
            1 => __('Accept all major credit cards, PayPal, Apple Pay, and Google Pay with bank-level security and PCI compliance.', 'yoursite'),
            2 => __('Reduce cart abandonment with express checkout options that let customers buy in seconds.', 'yoursite'),
            3 => __('Sell globally with support for 100+ currencies, automatic tax calculation, and local payment methods.', 'yoursite')
        );
        
        $wp_customize->add_setting("features_payments_feature_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_payments_feature_{$i}_enable", array(
            'label' => sprintf(__('Enable Payment Feature %d', 'yoursite'), $i),
            'section' => 'features_payments_checkout',
            'type' => 'checkbox',
            'active_callback' => function() {
                return get_theme_mod('features_payments_enable', true);
            },
        ));
        
        $wp_customize->add_setting("features_payments_feature_{$i}_title", array(
            'default' => $default_titles[$i],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_payments_feature_{$i}_title", array(
            'label' => sprintf(__('Payment Feature %d Title', 'yoursite'), $i),
            'section' => 'features_payments_checkout',
            'type' => 'text',
            'active_callback' => function() use ($i) {
                return get_theme_mod('features_payments_enable', true) && get_theme_mod("features_payments_feature_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("features_payments_feature_{$i}_description", array(
            'default' => $default_descriptions[$i],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_payments_feature_{$i}_description", array(
            'label' => sprintf(__('Payment Feature %d Description', 'yoursite'), $i),
            'section' => 'features_payments_checkout',
            'type' => 'textarea',
            'active_callback' => function() use ($i) {
                return get_theme_mod('features_payments_enable', true) && get_theme_mod("features_payments_feature_{$i}_enable", true);
            },
        ));
    }
    
    // Marketing & SEO Section
    $wp_customize->add_section('features_marketing_seo', array(
        'title' => __('Marketing & SEO Section', 'yoursite'),
        'panel' => 'features_page_panel',
        'priority' => 40,
    ));
    
    // Enable Marketing Section
    $wp_customize->add_setting('features_marketing_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_marketing_enable', array(
        'label' => __('Enable Marketing & SEO Section', 'yoursite'),
        'section' => 'features_marketing_seo',
        'type' => 'checkbox',
    ));
    
    // Marketing Section Title
    $wp_customize->add_setting('features_marketing_title', array(
        'default' => __('Marketing & SEO', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_marketing_title', array(
        'label' => __('Section Title', 'yoursite'),
        'section' => 'features_marketing_seo',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_marketing_enable', true);
        },
    ));
    
    // Marketing Section Description
    $wp_customize->add_setting('features_marketing_description', array(
        'default' => __('Built-in tools to drive traffic and increase sales', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_marketing_description', array(
        'label' => __('Section Description', 'yoursite'),
        'section' => 'features_marketing_seo',
        'type' => 'textarea',
        'active_callback' => function() {
            return get_theme_mod('features_marketing_enable', true);
        },
    ));
    
    // Marketing Features
    $marketing_default_titles = array(
        1 => __('SEO Optimization', 'yoursite'),
        2 => __('Email Marketing', 'yoursite'),
        3 => __('Analytics & Insights', 'yoursite')
    );
    
    $marketing_default_descriptions = array(
        1 => __('Built-in SEO tools, meta tags, sitemaps, and clean URLs to help your store rank higher in search results.', 'yoursite'),
        2 => __('Automated email campaigns, abandoned cart recovery, and customer segmentation to boost repeat purchases.', 'yoursite'),
        3 => __('Detailed reports on sales, traffic, customer behavior, and inventory to make data-driven decisions.', 'yoursite')
    );
    
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("features_marketing_feature_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_marketing_feature_{$i}_enable", array(
            'label' => sprintf(__('Enable Marketing Feature %d', 'yoursite'), $i),
            'section' => 'features_marketing_seo',
            'type' => 'checkbox',
            'active_callback' => function() {
                return get_theme_mod('features_marketing_enable', true);
            },
        ));
        
        $wp_customize->add_setting("features_marketing_feature_{$i}_title", array(
            'default' => $marketing_default_titles[$i],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_marketing_feature_{$i}_title", array(
            'label' => sprintf(__('Marketing Feature %d Title', 'yoursite'), $i),
            'section' => 'features_marketing_seo',
            'type' => 'text',
            'active_callback' => function() use ($i) {
                return get_theme_mod('features_marketing_enable', true) && get_theme_mod("features_marketing_feature_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("features_marketing_feature_{$i}_description", array(
            'default' => $marketing_default_descriptions[$i],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_marketing_feature_{$i}_description", array(
            'label' => sprintf(__('Marketing Feature %d Description', 'yoursite'), $i),
            'section' => 'features_marketing_seo',
            'type' => 'textarea',
            'active_callback' => function() use ($i) {
                return get_theme_mod('features_marketing_enable', true) && get_theme_mod("features_marketing_feature_{$i}_enable", true);
            },
        ));
    }
    
    // Inventory & Orders Section
    $wp_customize->add_section('features_inventory_orders', array(
        'title' => __('Inventory & Orders Section', 'yoursite'),
        'panel' => 'features_page_panel',
        'priority' => 50,
    ));
    
    // Enable Inventory Section
    $wp_customize->add_setting('features_inventory_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_inventory_enable', array(
        'label' => __('Enable Inventory & Orders Section', 'yoursite'),
        'section' => 'features_inventory_orders',
        'type' => 'checkbox',
    ));
    
    // Inventory Section Title
    $wp_customize->add_setting('features_inventory_title', array(
        'default' => __('Inventory & Orders', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_inventory_title', array(
        'label' => __('Section Title', 'yoursite'),
        'section' => 'features_inventory_orders',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_inventory_enable', true);
        },
    ));
    
    // Inventory Section Description
    $wp_customize->add_setting('features_inventory_description', array(
        'default' => __('Streamlined management for products, inventory, and fulfillment', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_inventory_description', array(
        'label' => __('Section Description', 'yoursite'),
        'section' => 'features_inventory_orders',
        'type' => 'textarea',
        'active_callback' => function() {
            return get_theme_mod('features_inventory_enable', true);
        },
    ));
    
    // Inventory Features
    $inventory_default_titles = array(
        1 => __('Product Management', 'yoursite'),
        2 => __('Order Management', 'yoursite'),
        3 => __('Inventory Tracking', 'yoursite')
    );
    
    $inventory_default_descriptions = array(
        1 => __('Easy product catalog management with variants, bulk editing, and unlimited product uploads.', 'yoursite'),
        2 => __('Centralized order processing, automatic invoices, and real-time order tracking for customers.', 'yoursite'),
        3 => __('Real-time inventory tracking, low stock alerts, and automatic reorder points to prevent stockouts.', 'yoursite')
    );
    
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("features_inventory_feature_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_inventory_feature_{$i}_enable", array(
            'label' => sprintf(__('Enable Inventory Feature %d', 'yoursite'), $i),
            'section' => 'features_inventory_orders',
            'type' => 'checkbox',
            'active_callback' => function() {
                return get_theme_mod('features_inventory_enable', true);
            },
        ));
        
        $wp_customize->add_setting("features_inventory_feature_{$i}_title", array(
            'default' => $inventory_default_titles[$i],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_inventory_feature_{$i}_title", array(
            'label' => sprintf(__('Inventory Feature %d Title', 'yoursite'), $i),
            'section' => 'features_inventory_orders',
            'type' => 'text',
            'active_callback' => function() use ($i) {
                return get_theme_mod('features_inventory_enable', true) && get_theme_mod("features_inventory_feature_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("features_inventory_feature_{$i}_description", array(
            'default' => $inventory_default_descriptions[$i],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_inventory_feature_{$i}_description", array(
            'label' => sprintf(__('Inventory Feature %d Description', 'yoursite'), $i),
            'section' => 'features_inventory_orders',
            'type' => 'textarea',
            'active_callback' => function() use ($i) {
                return get_theme_mod('features_inventory_enable', true) && get_theme_mod("features_inventory_feature_{$i}_enable", true);
            },
        ));
    }
    
    // Feature Comparison Section
    $wp_customize->add_section('features_comparison_section', array(
        'title' => __('Feature Comparison Section', 'yoursite'),
        'panel' => 'features_page_panel',
        'priority' => 60,
    ));
    
    // Enable Feature Comparison Section
    $wp_customize->add_setting('features_comparison_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_comparison_enable', array(
        'label' => __('Enable Feature Comparison Section', 'yoursite'),
        'section' => 'features_comparison_section',
        'type' => 'checkbox',
    ));
    
    // Comparison Section Title
    $wp_customize->add_setting('features_comparison_title', array(
        'default' => __('Compare Our Plans', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_comparison_title', array(
        'label' => __('Comparison Title', 'yoursite'),
        'section' => 'features_comparison_section',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_comparison_enable', true);
        },
    ));
    
    // Comparison Section Description
    $wp_customize->add_setting('features_comparison_description', array(
        'default' => __('See which features are included in each pricing tier', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_comparison_description', array(
        'label' => __('Comparison Description', 'yoursite'),
        'section' => 'features_comparison_section',
        'type' => 'textarea',
        'active_callback' => function() {
            return get_theme_mod('features_comparison_enable', true);
        },
    ));
    
    // CTA Section
    $wp_customize->add_section('features_cta_section', array(
        'title' => __('CTA Section', 'yoursite'),
        'panel' => 'features_page_panel',
        'priority' => 70,
    ));
    
    // Enable CTA Section
    $wp_customize->add_setting('features_cta_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_cta_enable', array(
        'label' => __('Enable CTA Section', 'yoursite'),
        'section' => 'features_cta_section',
        'type' => 'checkbox',
    ));
    
    // CTA Title
    $wp_customize->add_setting('features_cta_title', array(
        'default' => __('Ready to explore all features?', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_cta_title', array(
        'label' => __('CTA Title', 'yoursite'),
        'section' => 'features_cta_section',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_cta_enable', true);
        },
    ));
    
    // CTA Description
    $wp_customize->add_setting('features_cta_description', array(
        'default' => __('Start your free trial and experience the power of our platform', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_cta_description', array(
        'label' => __('CTA Description', 'yoursite'),
        'section' => 'features_cta_section',
        'type' => 'textarea',
        'active_callback' => function() {
            return get_theme_mod('features_cta_enable', true);
        },
    ));
    
    // CTA Primary Button
    $wp_customize->add_setting('features_cta_primary_text', array(
        'default' => __('Start Free Trial', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_cta_primary_text', array(
        'label' => __('Primary Button Text', 'yoursite'),
        'section' => 'features_cta_section',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_cta_enable', true);
        },
    ));
    
    $wp_customize->add_setting('features_cta_primary_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_cta_primary_url', array(
        'label' => __('Primary Button URL', 'yoursite'),
        'section' => 'features_cta_section',
        'type' => 'url',
        'active_callback' => function() {
            return get_theme_mod('features_cta_enable', true);
        },
    ));
    
    // CTA Secondary Button
    $wp_customize->add_setting('features_cta_secondary_text', array(
        'default' => __('View Pricing', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_cta_secondary_text', array(
        'label' => __('Secondary Button Text', 'yoursite'),
        'section' => 'features_cta_section',
        'type' => 'text',
        'active_callback' => function() {
            return get_theme_mod('features_cta_enable', true);
        },
    ));
    
    $wp_customize->add_setting('features_cta_secondary_url', array(
        'default' => '/pricing',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('features_cta_secondary_url', array(
        'label' => __('Secondary Button URL', 'yoursite'),
        'section' => 'features_cta_section',
        'type' => 'url',
        'active_callback' => function() {
            return get_theme_mod('features_cta_enable', true);
        },
    ));
}
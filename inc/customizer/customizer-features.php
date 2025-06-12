<?php
/**
 * Features Page Customizer Settings - Nested under Edit Pages > Features Page
 * Add this to your inc/customizer/customizer-features.php file
 */

/**
 * Sanitize checkbox values
 */
if (!function_exists('yoursite_sanitize_checkbox')) {
    function yoursite_sanitize_checkbox($checked) {
        return ((isset($checked) && true == $checked) ? true : false);
    }
}

/**
 * Add Features Page customizer options with proper nesting
 */
function yoursite_features_page_customizer($wp_customize) {
    
    // First, create the main "Edit Pages" panel if it doesn't exist
    if (!$wp_customize->get_panel('yoursite_pages')) {
        $wp_customize->add_panel('yoursite_pages', array(
            'title' => __('Edit Pages', 'yoursite'),
            'description' => __('Customize all your website pages', 'yoursite'),
            'priority' => 55,
        ));
    }
    
    // Create Features Page as a Panel under Edit Pages
    $wp_customize->add_panel('features_page_panel', array(
        'title' => __('Features Page', 'yoursite'),
        'description' => __('Customize all elements of the Features page', 'yoursite'),
        'priority' => 10,
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
    ));
    
    // Store Building Features (1-3)
    $store_features = array(
        1 => array(
            'title' => __('Drag & Drop Builder', 'yoursite'),
            'description' => __('Intuitive visual editor to customize your store layout, add products, and arrange elements exactly how you want them.', 'yoursite')
        ),
        2 => array(
            'title' => __('Professional Templates', 'yoursite'),
            'description' => __('Choose from 100+ mobile-responsive templates designed for conversion and optimized for your industry.', 'yoursite')
        ),
        3 => array(
            'title' => __('Mobile Optimized', 'yoursite'),
            'description' => __('Every store is automatically optimized for mobile devices, ensuring perfect shopping experience across all screen sizes.', 'yoursite')
        )
    );
    
    foreach ($store_features as $i => $feature) {
        // Enable Feature
        $wp_customize->add_setting("features_store_building_feature_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_store_building_feature_{$i}_enable", array(
            'label' => sprintf(__('Enable Feature %d', 'yoursite'), $i),
            'section' => 'features_store_building',
            'type' => 'checkbox',
        ));
        
        // Feature Title
        $wp_customize->add_setting("features_store_building_feature_{$i}_title", array(
            'default' => $feature['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_store_building_feature_{$i}_title", array(
            'label' => sprintf(__('Feature %d Title', 'yoursite'), $i),
            'section' => 'features_store_building',
            'type' => 'text',
        ));
        
        // Feature Description
        $wp_customize->add_setting("features_store_building_feature_{$i}_description", array(
            'default' => $feature['description'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_store_building_feature_{$i}_description", array(
            'label' => sprintf(__('Feature %d Description', 'yoursite'), $i),
            'section' => 'features_store_building',
            'type' => 'textarea',
        ));
    }
    
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
    ));
    
    // Payment Features
    $payment_features = array(
        1 => array(
            'title' => __('Secure Payments', 'yoursite'),
            'description' => __('Accept all major credit cards, PayPal, Apple Pay, and Google Pay with bank-level security and PCI compliance.', 'yoursite')
        ),
        2 => array(
            'title' => __('One-Click Checkout', 'yoursite'),
            'description' => __('Reduce cart abandonment with express checkout options that let customers buy in seconds.', 'yoursite')
        ),
        3 => array(
            'title' => __('Multi-Currency', 'yoursite'),
            'description' => __('Sell globally with support for 100+ currencies, automatic tax calculation, and local payment methods.', 'yoursite')
        )
    );
    
    foreach ($payment_features as $i => $feature) {
        // Enable Feature
        $wp_customize->add_setting("features_payments_feature_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_payments_feature_{$i}_enable", array(
            'label' => sprintf(__('Enable Payment Feature %d', 'yoursite'), $i),
            'section' => 'features_payments_checkout',
            'type' => 'checkbox',
        ));
        
        // Feature Title
        $wp_customize->add_setting("features_payments_feature_{$i}_title", array(
            'default' => $feature['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_payments_feature_{$i}_title", array(
            'label' => sprintf(__('Payment Feature %d Title', 'yoursite'), $i),
            'section' => 'features_payments_checkout',
            'type' => 'text',
        ));
        
        // Feature Description
        $wp_customize->add_setting("features_payments_feature_{$i}_description", array(
            'default' => $feature['description'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_payments_feature_{$i}_description", array(
            'label' => sprintf(__('Payment Feature %d Description', 'yoursite'), $i),
            'section' => 'features_payments_checkout',
            'type' => 'textarea',
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
    ));
    
    // Marketing Features
    $marketing_features = array(
        1 => array(
            'title' => __('SEO Optimization', 'yoursite'),
            'description' => __('Built-in SEO tools, meta tags, sitemaps, and clean URLs to help your store rank higher in search results.', 'yoursite')
        ),
        2 => array(
            'title' => __('Email Marketing', 'yoursite'),
            'description' => __('Automated email campaigns, abandoned cart recovery, and customer segmentation to boost repeat purchases.', 'yoursite')
        ),
        3 => array(
            'title' => __('Analytics & Insights', 'yoursite'),
            'description' => __('Detailed reports on sales, traffic, customer behavior, and inventory to make data-driven decisions.', 'yoursite')
        )
    );
    
    foreach ($marketing_features as $i => $feature) {
        // Enable Feature
        $wp_customize->add_setting("features_marketing_feature_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_marketing_feature_{$i}_enable", array(
            'label' => sprintf(__('Enable Marketing Feature %d', 'yoursite'), $i),
            'section' => 'features_marketing_seo',
            'type' => 'checkbox',
        ));
        
        // Feature Title
        $wp_customize->add_setting("features_marketing_feature_{$i}_title", array(
            'default' => $feature['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_marketing_feature_{$i}_title", array(
            'label' => sprintf(__('Marketing Feature %d Title', 'yoursite'), $i),
            'section' => 'features_marketing_seo',
            'type' => 'text',
        ));
        
        // Feature Description
        $wp_customize->add_setting("features_marketing_feature_{$i}_description", array(
            'default' => $feature['description'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_marketing_feature_{$i}_description", array(
            'label' => sprintf(__('Marketing Feature %d Description', 'yoursite'), $i),
            'section' => 'features_marketing_seo',
            'type' => 'textarea',
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
    ));
    
    // Inventory Features
    $inventory_features = array(
        1 => array(
            'title' => __('Product Management', 'yoursite'),
            'description' => __('Easy product catalog management with variants, bulk editing, and unlimited product uploads.', 'yoursite')
        ),
        2 => array(
            'title' => __('Order Management', 'yoursite'),
            'description' => __('Centralized order processing, automatic invoices, and real-time order tracking for customers.', 'yoursite')
        ),
        3 => array(
            'title' => __('Inventory Tracking', 'yoursite'),
            'description' => __('Real-time inventory tracking, low stock alerts, and automatic reorder points to prevent stockouts.', 'yoursite')
        )
    );
    
    foreach ($inventory_features as $i => $feature) {
        // Enable Feature
        $wp_customize->add_setting("features_inventory_feature_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_inventory_feature_{$i}_enable", array(
            'label' => sprintf(__('Enable Inventory Feature %d', 'yoursite'), $i),
            'section' => 'features_inventory_orders',
            'type' => 'checkbox',
        ));
        
        // Feature Title
        $wp_customize->add_setting("features_inventory_feature_{$i}_title", array(
            'default' => $feature['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_inventory_feature_{$i}_title", array(
            'label' => sprintf(__('Inventory Feature %d Title', 'yoursite'), $i),
            'section' => 'features_inventory_orders',
            'type' => 'text',
        ));
        
        // Feature Description
        $wp_customize->add_setting("features_inventory_feature_{$i}_description", array(
            'default' => $feature['description'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("features_inventory_feature_{$i}_description", array(
            'label' => sprintf(__('Inventory Feature %d Description', 'yoursite'), $i),
            'section' => 'features_inventory_orders',
            'type' => 'textarea',
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
    ));
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_features_page_customizer');

/**
 * Add custom JavaScript to create nested panel behavior
 */
function yoursite_features_customizer_scripts() {
    ?>
    <script type="text/javascript">
    wp.customize.bind('ready', function() {
        // Move Features Page panel under Edit Pages panel
        var editPagesPanel = wp.customize.panel('yoursite_pages');
        var featuresPanel = wp.customize.panel('features_page_panel');
        
        if (editPagesPanel && featuresPanel) {
            // Hide the features panel from root level
            jQuery('#accordion-panel-features_page_panel').appendTo('#sub-accordion-panel-yoursite_pages');
            
            // Add click handler to Edit Pages panel to show Features Page as sub-panel
            editPagesPanel.container.on('click', '.accordion-section-title', function() {
                // Small delay to ensure the panel is expanded
                setTimeout(function() {
                    jQuery('#accordion-panel-features_page_panel').show();
                }, 100);
            });
        }
    });
    </script>
    <style type="text/css">
    /* Style the nested panel */
    #sub-accordion-panel-yoursite_pages #accordion-panel-features_page_panel {
        margin-left: 20px;
        border-left: 2px solid #0073aa;
        background: #f9f9f9;
    }
    
    #sub-accordion-panel-yoursite_pages #accordion-panel-features_page_panel .accordion-section-title {
        background: #f1f1f1;
        border-left: 4px solid #0073aa;
    }
    
    #sub-accordion-panel-yoursite_pages #accordion-panel-features_page_panel .accordion-section-title:hover {
        background: #e5e5e5;
    }
    </style>
    <?php
}
add_action('customize_controls_print_scripts', 'yoursite_features_customizer_scripts');
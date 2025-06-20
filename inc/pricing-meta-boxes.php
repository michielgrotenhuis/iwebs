<?php
/**
 * Enhanced Pricing Plans Meta Box with Features Comparison
 * File inc/pricing-meta-boxes.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add pricing plan meta boxes
 */
function yoursite_add_pricing_meta_boxes() {
    add_meta_box(
        'pricing_plan_details',
        __('Pricing Plan Details', 'yoursite'),
        'yoursite_pricing_plan_meta_box_callback',
        'pricing',
        'normal',
        'high'
    );
    
    add_meta_box(
        'pricing_plan_features',
        __('Plan Features Comparison', 'yoursite'),
        'yoursite_pricing_features_meta_box_callback',
        'pricing',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'yoursite_add_pricing_meta_boxes');

/**
 * Pricing plan details meta box callback
 */
function yoursite_pricing_plan_meta_box_callback($post) {
    wp_nonce_field('yoursite_pricing_meta_box', 'yoursite_pricing_meta_box_nonce');
    
    $meta = yoursite_get_pricing_meta_fields($post->ID);
    
    yoursite_pricing_meta_box_styles();
    
    echo '<table class="pricing-meta-table">';
    
    // Basic Pricing Info
    echo '<tr><td colspan="2"><div class="meta-section"><h4>💰 ' . __('Basic Pricing Information', 'yoursite') . '</h4></div></td></tr>';
    
    // Monthly Price
    echo '<tr>';
    echo '<th><label for="pricing_monthly_price"><strong>' . __('Monthly Price ($)', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="number" id="pricing_monthly_price" name="pricing_monthly_price" value="' . esc_attr($meta['pricing_monthly_price']) . '" step="0.01" min="0" placeholder="19.99" />';
    echo '<p class="description">' . __('Monthly subscription price in USD', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Annual Price
    echo '<tr>';
    echo '<th><label for="pricing_annual_price"><strong>' . __('Annual Price ($)', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="number" id="pricing_annual_price" name="pricing_annual_price" value="' . esc_attr($meta['pricing_annual_price']) . '" step="0.01" min="0" placeholder="199.99" />';
    echo '<p class="description">' . __('Annual subscription price in USD (leave empty to auto-calculate 20% discount)', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Currency
    echo '<tr>';
    echo '<th><label for="pricing_currency"><strong>' . __('Currency', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="pricing_currency" name="pricing_currency">';
    $currencies = array('USD' => '$', 'EUR' => '€', 'GBP' => '£', 'CAD' => 'C$', 'AUD' => 'A$');
    foreach ($currencies as $code => $symbol) {
        echo '<option value="' . $code . '"' . selected($meta['pricing_currency'], $code, false) . '>' . $code . ' (' . $symbol . ')</option>';
    }
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    // Featured Plan
    echo '<tr>';
    echo '<th><label for="pricing_featured"><strong>' . __('Featured Plan', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="pricing_featured" name="pricing_featured" value="1" ' . checked($meta['pricing_featured'], '1', false) . ' />';
    echo '<label for="pricing_featured">' . __('Mark as featured/recommended plan', 'yoursite') . '</label>';
    echo '</td>';
    echo '</tr>';
    
    // Button Text
    echo '<tr>';
    echo '<th><label for="pricing_button_text"><strong>' . __('Button Text', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="pricing_button_text" name="pricing_button_text" value="' . esc_attr($meta['pricing_button_text']) . '" placeholder="Get Started" />';
    echo '</td>';
    echo '</tr>';
    
    // Button URL
    echo '<tr>';
    echo '<th><label for="pricing_button_url"><strong>' . __('Button URL', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="url" id="pricing_button_url" name="pricing_button_url" value="' . esc_attr($meta['pricing_button_url']) . '" placeholder="https://signup.example.com" />';
    echo '</td>';
    echo '</tr>';
    
    // Basic Features
    echo '<tr><td colspan="2"><div class="meta-section"><h4>⭐ ' . __('Basic Features List', 'yoursite') . '</h4></div></td></tr>';
    
    echo '<tr>';
    echo '<th><label for="pricing_features"><strong>' . __('Features', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<textarea id="pricing_features" name="pricing_features" rows="6" placeholder="Up to 100 products&#10;Email support&#10;SSL certificate">' . esc_textarea($meta['pricing_features']) . '</textarea>';
    echo '<p class="description">' . __('List features, one per line. These appear as bullet points on the pricing cards.', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
}

// Add to the yoursite_pricing_features_meta_box_callback function
function yoursite_pricing_features_meta_box_callback($post) {
    $meta = yoursite_get_pricing_meta_fields($post->ID);
    
    echo '<div class="pricing-features-comparison">';
    echo '<p class="description" style="margin-bottom: 20px;">' . __('Configure detailed features for the comparison table. Use "Yes", "No", numbers, or descriptive text.', 'yoursite') . '</p>';
    
    $feature_categories = array(
        'basics' => array(
            'title' => __('Essentials', 'yoursite'),
            'description' => __('Core features to get started', 'yoursite'),
            'fields' => array(
                'transaction_fee' => __('Transaction Fee', 'yoursite'),
                'product_limit' => __('Product Limit', 'yoursite'),
                'categories' => __('Categories', 'yoursite'),
                'storage' => __('Storage', 'yoursite'),
            )
        ),
        'shopping_experience' => array(
            'title' => __('Shopping Experience', 'yoursite'),
            'description' => __('Create seamless shopping journeys', 'yoursite'),
            'fields' => array(
                'adaptive_storefront' => __('Adaptive Storefront Widget', 'yoursite'),
                'wishlist' => __('Favorites/Wishlist', 'yoursite'),
                'single_product_widgets' => __('Single Product Widgets', 'yoursite'),
                'faceted_search' => __('Advanced Search & Filters', 'yoursite'),
            )
        ),
        'online_store' => array(
            'title' => __('Online Store Builder', 'yoursite'),
            'description' => __('Build and customize your store', 'yoursite'),
            'fields' => array(
                'wordpress_plugin' => __('WordPress Plugin', 'yoursite'),
                'customizable_design' => __('Customizable Design', 'yoursite'),
                'mobile_responsive' => __('Mobile Responsive', 'yoursite'),
                'seo_optimized' => __('SEO Optimized', 'yoursite'),
            )
        ),
        'product_inventory' => array(
            'title' => __('Product & Inventory', 'yoursite'),
            'description' => __('Manage products efficiently', 'yoursite'),
            'fields' => array(
                'bulk_import' => __('Bulk Import/Export', 'yoursite'),
                'inventory_tracking' => __('Inventory Tracking', 'yoursite'),
                'product_variants' => __('Product Variants', 'yoursite'),
                'digital_products' => __('Digital Products', 'yoursite'),
            )
        ),
        'sales_channels' => array(
            'title' => __('Sales Channels', 'yoursite'),
            'description' => __('Sell everywhere your customers are', 'yoursite'),
            'fields' => array(
                'link_in_bio' => __('Link-in-Bio Store', 'yoursite'),
                'facebook_shop' => __('Facebook Shop', 'yoursite'),
                'instagram_store' => __('Instagram Shopping', 'yoursite'),
                'marketplace_sync' => __('Marketplace Integration', 'yoursite'),
            )
        ),
        'marketing' => array(
            'title' => __('Marketing Tools', 'yoursite'),
            'description' => __('Grow your audience and sales', 'yoursite'),
            'fields' => array(
                'email_marketing' => __('Email Marketing', 'yoursite'),
                'discount_codes' => __('Discount Codes', 'yoursite'),
                'abandoned_cart' => __('Abandoned Cart Recovery', 'yoursite'),
                'affiliate_program' => __('Affiliate Program', 'yoursite'),
            )
        ),
        'checkout_payment' => array(
            'title' => __('Checkout & Payment', 'yoursite'),
            'description' => __('Secure and flexible payments', 'yoursite'),
            'fields' => array(
                'payment_gateways' => __('Payment Methods', 'yoursite'),
                'one_page_checkout' => __('One-Page Checkout', 'yoursite'),
                'guest_checkout' => __('Guest Checkout', 'yoursite'),
                'multi_currency' => __('Multi-Currency', 'yoursite'),
            )
        ),
        'analytics' => array(
            'title' => __('Analytics & Reports', 'yoursite'),
            'description' => __('Data-driven insights', 'yoursite'),
            'fields' => array(
                'sales_analytics' => __('Sales Analytics', 'yoursite'),
                'customer_insights' => __('Customer Insights', 'yoursite'),
                'product_performance' => __('Product Performance', 'yoursite'),
                'custom_reports' => __('Custom Reports', 'yoursite'),
            )
        ),
        'support' => array(
            'title' => __('Support & Success', 'yoursite'),
            'description' => __('We\'re here to help you succeed', 'yoursite'),
            'fields' => array(
                'support_type' => __('Support Type', 'yoursite'),
                'response_time' => __('Response Time', 'yoursite'),
                'onboarding' => __('Onboarding Help', 'yoursite'),
                'api_access' => __('API Access', 'yoursite'),
            )
        )
    );
    
    foreach ($feature_categories as $category_key => $category) {
        echo '<div class="feature-category" style="margin-bottom: 30px; border: 1px solid #ddd; padding: 20px; border-radius: 8px;">';
        echo '<h4 style="margin-top: 0; color: #2271b1; border-bottom: 1px solid #ddd; padding-bottom: 10px;">' . $category['title'] . '</h4>';
        echo '<p style="font-style: italic; color: #666; margin-bottom: 15px;">' . $category['description'] . '</p>';
        
        echo '<div class="feature-fields" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">';
        
        foreach ($category['fields'] as $field_key => $field_label) {
            $meta_key = $category_key . '_' . $field_key;
            $value = isset($meta[$meta_key]) ? $meta[$meta_key] : '';
            
            echo '<div class="feature-field">';
            echo '<label for="' . $meta_key . '" style="display: block; font-weight: 600; margin-bottom: 5px;">' . $field_label . '</label>';
            echo '<input type="text" id="' . $meta_key . '" name="' . $meta_key . '" value="' . esc_attr($value) . '" style="width: 100%;" placeholder="e.g., Yes, No, Unlimited, 1000" />';
            echo '<p class="description" style="font-size: 12px; margin-top: 4px;">Use: Yes/No, numbers, or short descriptions</p>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
}

/**
 * Get pricing meta fields with defaults
 */
function yoursite_get_pricing_meta_fields($post_id) {
    $defaults = array(
        'pricing_monthly_price' => '',
        'pricing_annual_price' => '',
        'pricing_currency' => 'USD',
        'pricing_featured' => '0',
        'pricing_button_text' => 'Get Started',
        'pricing_button_url' => '',
        'pricing_features' => '',
    );
    
    // Add all feature fields to defaults
    $feature_categories = array(
        'basics' => array('transaction_fee', 'product_limit', 'categories', 'storage'),
        'shopping_experience' => array('adaptive_storefront', 'wishlist', 'single_product_widgets', 'faceted_search', 'bulk_actions', 'user_reviews', 'quick_view', 'advanced_sorting', 'product_recommendations', 'live_search', 'product_comparison'),
        'online_store' => array('wordpress_plugin', 'customizable_design', 'mobile_responsive', 'seo_optimized', 'page_builder_compatible', 'multi_language', 'custom_css_js', 'theme_compatibility'),
        'product_inventory' => array('bulk_import', 'inventory_tracking', 'product_variants', 'digital_products', 'stock_alerts', 'barcode_scanning', 'product_bundles', 'serial_numbers', 'expiry_tracking', 'multi_location'),
        'advanced_features' => array('custom_fields', 'product_scheduling', 'dynamic_pricing', 'wholesale_features', 'subscription_products', 'product_addons', 'tax_rules', 'multi_vendor'),
        'sales_channels' => array('link_in_bio', 'facebook_shop', 'instagram_store', 'google_shopping', 'amazon_integration', 'ebay_sync', 'pinterest_shopping', 'tiktok_shop', 'marketplace_api'),
        'marketing' => array('email_marketing', 'discount_codes', 'abandoned_cart', 'affiliate_program', 'loyalty_program', 'gift_cards', 'social_auto_post', 'referral_program', 'sms_marketing', 'push_notifications'),
        'checkout_payment' => array('payment_gateways', 'one_page_checkout', 'guest_checkout', 'multi_currency', 'express_checkout', 'split_payments', 'cryptocurrency', 'b2b_payments', 'fraud_protection', 'pci_compliance'),
        'shipping_fulfillment' => array('realtime_rates', 'label_printing', 'order_tracking', 'dropshipping', 'local_delivery', 'pickup_options', 'international_shipping', 'fulfillment_integration', 'shipping_rules', 'package_optimization'),
        'analytics' => array('sales_analytics', 'customer_insights', 'product_performance', 'custom_reports', 'traffic_analytics', 'conversion_funnel', 'cohort_analysis', 'profit_analytics', 'forecasting', 'ab_testing'),
        'domains' => array('free_subdomain', 'custom_domain', 'domain_management', 'ssl_certificate', 'domain_forwarding', 'subdomain_support', 'domain_privacy', 'international_domains'),
        'support' => array('support_type', 'response_time', 'onboarding', 'api_access', 'knowledge_base', 'community_forum', 'account_manager', 'phone_support', 'migration_assistance', 'training_webinars'),
    );
    
    foreach ($feature_categories as $category => $fields) {
        foreach ($fields as $field) {
            $defaults[$category . '_' . $field] = '';
        }
    }
    
    $meta = array();
    foreach ($defaults as $key => $default) {
        $meta[$key] = get_post_meta($post_id, '_' . $key, true) ?: $default;
    }
    
    return $meta;
}

/**
 * Save pricing meta box data
 */
function yoursite_save_pricing_meta_box_data($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['yoursite_pricing_meta_box_nonce']) || !wp_verify_nonce($_POST['yoursite_pricing_meta_box_nonce'], 'yoursite_pricing_meta_box')) {
        return;
    }

    // Check if user has permissions to save data
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Get all possible meta fields
    $meta_fields = array(
        'pricing_monthly_price',
        'pricing_annual_price',
        'pricing_currency',
        'pricing_featured',
        'pricing_button_text',
        'pricing_button_url',
        'pricing_features',
    );
    
    // Add all feature fields
    $feature_categories = array(
        'basics' => array('transaction_fee', 'product_limit', 'categories', 'storage'),
        'shopping_experience' => array('adaptive_storefront', 'wishlist', 'single_product_widgets', 'faceted_search', 'bulk_actions', 'user_reviews', 'quick_view', 'advanced_sorting', 'product_recommendations', 'live_search', 'product_comparison'),
        'online_store' => array('wordpress_plugin', 'customizable_design', 'mobile_responsive', 'seo_optimized', 'page_builder_compatible', 'multi_language', 'custom_css_js', 'theme_compatibility'),
        'product_inventory' => array('bulk_import', 'inventory_tracking', 'product_variants', 'digital_products', 'stock_alerts', 'barcode_scanning', 'product_bundles', 'serial_numbers', 'expiry_tracking', 'multi_location'),
        'advanced_features' => array('custom_fields', 'product_scheduling', 'dynamic_pricing', 'wholesale_features', 'subscription_products', 'product_addons', 'tax_rules', 'multi_vendor'),
        'sales_channels' => array('link_in_bio', 'facebook_shop', 'instagram_store', 'google_shopping', 'amazon_integration', 'ebay_sync', 'pinterest_shopping', 'tiktok_shop', 'marketplace_api'),
        'marketing' => array('email_marketing', 'discount_codes', 'abandoned_cart', 'affiliate_program', 'loyalty_program', 'gift_cards', 'social_auto_post', 'referral_program', 'sms_marketing', 'push_notifications'),
        'checkout_payment' => array('payment_gateways', 'one_page_checkout', 'guest_checkout', 'multi_currency', 'express_checkout', 'split_payments', 'cryptocurrency', 'b2b_payments', 'fraud_protection', 'pci_compliance'),
        'shipping_fulfillment' => array('realtime_rates', 'label_printing', 'order_tracking', 'dropshipping', 'local_delivery', 'pickup_options', 'international_shipping', 'fulfillment_integration', 'shipping_rules', 'package_optimization'),
        'analytics' => array('sales_analytics', 'customer_insights', 'product_performance', 'custom_reports', 'traffic_analytics', 'conversion_funnel', 'cohort_analysis', 'profit_analytics', 'forecasting', 'ab_testing'),
        'domains' => array('free_subdomain', 'custom_domain', 'domain_management', 'ssl_certificate', 'domain_forwarding', 'subdomain_support', 'domain_privacy', 'international_domains'),
        'support' => array('support_type', 'response_time', 'onboarding', 'api_access', 'knowledge_base', 'community_forum', 'account_manager', 'phone_support', 'migration_assistance', 'training_webinars'),
    );
    
    foreach ($feature_categories as $category => $fields) {
        foreach ($fields as $field) {
            $meta_fields[] = $category . '_' . $field;
        }
    }

    foreach ($meta_fields as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            
            // Sanitize based on field type
            if ($field === 'pricing_featured') {
                $value = isset($_POST[$field]) ? '1' : '0';
            } elseif (in_array($field, array('pricing_monthly_price', 'pricing_annual_price'))) {
                $value = floatval($value);
            } elseif ($field === 'pricing_button_url') {
                $value = esc_url_raw($value);
            } elseif ($field === 'pricing_features') {
                $value = sanitize_textarea_field($value);
            } else {
                $value = sanitize_text_field($value);
            }
            
            update_post_meta($post_id, '_' . $field, $value);
        }
    }
    
    // Auto-calculate annual price if not set (20% discount)
    if (isset($_POST['pricing_monthly_price']) && !empty($_POST['pricing_monthly_price'])) {
        $monthly_price = floatval($_POST['pricing_monthly_price']);
        if (empty($_POST['pricing_annual_price']) && $monthly_price > 0) {
            $annual_price = $monthly_price * 12 * 0.8; // 20% discount
            update_post_meta($post_id, '_pricing_annual_price', $annual_price);
        }
    }
}
add_action('save_post', 'yoursite_save_pricing_meta_box_data');

/**
 * Pricing meta box styles
 */
function yoursite_pricing_meta_box_styles() {
    echo '<style>
        .pricing-meta-table { width: 100%; }
        .pricing-meta-table th { text-align: left; padding: 15px 10px 15px 0; width: 180px; vertical-align: top; }
        .pricing-meta-table td { padding: 15px 0; }
        .pricing-meta-table input[type="text"], 
        .pricing-meta-table input[type="number"], 
        .pricing-meta-table input[type="url"], 
        .pricing-meta-table select,
        .pricing-meta-table textarea { width: 100%; max-width: 400px; }
        .pricing-meta-table textarea { height: 100px; }
        .pricing-meta-table .description { font-style: italic; color: #666; margin-top: 5px; font-size: 13px; }
        .meta-section { background: #f9f9f9; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .meta-section h4 { margin-top: 0; color: #333; }
        .feature-category { background: #fafafa; }
        .feature-field label { font-size: 13px; }
        .feature-field input { padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
    </style>';
}
/**
 * Add admin columns for pricing plans
 */
function yoursite_pricing_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['monthly_price'] = __('Monthly Price', 'yoursite');
    $new_columns['annual_price'] = __('Annual Price', 'yoursite');
    $new_columns['featured'] = __('Featured', 'yoursite');
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_pricing_posts_columns', 'yoursite_pricing_admin_columns');

/**
 * Admin column content for pricing plans
 */
function yoursite_pricing_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'monthly_price':
            $price = get_post_meta($post_id, '_pricing_monthly_price', true);
            $currency = get_post_meta($post_id, '_pricing_currency', true) ?: 'USD';
            echo $price ? $currency . ' ' . number_format($price, 2) : '—';
            break;
        case 'annual_price':
            $price = get_post_meta($post_id, '_pricing_annual_price', true);
            $currency = get_post_meta($post_id, '_pricing_currency', true) ?: 'USD';
            echo $price ? $currency . ' ' . number_format($price, 2) : '—';
            break;
        case 'featured':
            $featured = get_post_meta($post_id, '_pricing_featured', true);
            echo $featured === '1' ? '<span style="color: #d63638;">★ Featured</span>' : '—';
            break;
    }
}
add_action('manage_pricing_posts_custom_column', 'yoursite_pricing_admin_column_content', 10, 2);
?>
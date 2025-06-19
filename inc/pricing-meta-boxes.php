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

/**
 * Pricing features comparison meta box callback
 */
function yoursite_pricing_features_meta_box_callback($post) {
    $meta = yoursite_get_pricing_meta_fields($post->ID);
    
    echo '<div class="pricing-features-comparison">';
    echo '<p class="description" style="margin-bottom: 20px;">' . __('Configure detailed features for the comparison table. Use specific values like "Unlimited", "5GB", "✓", "✗", or "Premium only".', 'yoursite') . '</p>';
    
    $feature_categories = array(
        'transaction_fees' => array(
            'title' => __('Transaction Fees', 'yoursite'),
            'description' => __('Fees charged per sale', 'yoursite'),
            'fields' => array(
                'transaction_fee_percentage' => __('Transaction Fee %', 'yoursite'),
                'transaction_fee_fixed' => __('Fixed Fee per Transaction', 'yoursite'),
            )
        ),
        'ecommerce_website' => array(
            'title' => __('Ecommerce Website', 'yoursite'),
            'description' => __('Website and store features', 'yoursite'),
            'fields' => array(
                'add_store_existing_website' => __('Add store to existing website', 'yoursite'),
                'sell_multiple_sites' => __('Sell on multiple sites', 'yoursite'),
                'instant_site_builder' => __('Instant Site builder', 'yoursite'),
                'site_templates_count' => __('Number of site templates', 'yoursite'),
                'additional_pages_count' => __('Additional Instant Site pages', 'yoursite'),
            )
        ),
        'domains' => array(
            'title' => __('Domains', 'yoursite'),
            'description' => __('Domain and URL features', 'yoursite'),
            'fields' => array(
                'free_subdomain' => __('Free company.site domain', 'yoursite'),
                'connect_existing_domain' => __('Connect existing domain', 'yoursite'),
                'buy_custom_domain' => __('Buy custom domain', 'yoursite'),
                'custom_url_slugs' => __('Custom URL slugs', 'yoursite'),
            )
        ),
        'sales_channels' => array(
            'title' => __('Other Sales Channels', 'yoursite'),
            'description' => __('Additional selling platforms', 'yoursite'),
            'fields' => array(
                'linkup_bio_page' => __('Link-in-bio ecom page', 'yoursite'),
                'facebook_shop' => __('Facebook shop', 'yoursite'),
                'instagram_store' => __('Instagram store', 'yoursite'),
                'mobile_pos' => __('Mobile point of sale', 'yoursite'),
                'marketplace_selling' => __('Sell on marketplaces', 'yoursite'),
            )
        ),
        'support_analytics' => array(
            'title' => __('Support & Analytics', 'yoursite'),
            'description' => __('Customer support and analytics features', 'yoursite'),
            'fields' => array(
                'support_type' => __('Support Type', 'yoursite'),
                'analytics_level' => __('Analytics Level', 'yoursite'),
                'reporting_features' => __('Reporting Features', 'yoursite'),
                'api_access' => __('API Access', 'yoursite'),
            )
        ),
        'storage_limits' => array(
            'title' => __('Storage & Limits', 'yoursite'),
            'description' => __('Product and storage limitations', 'yoursite'),
            'fields' => array(
                'product_limit' => __('Product Limit', 'yoursite'),
                'storage_limit' => __('Storage Space', 'yoursite'),
                'bandwidth_limit' => __('Bandwidth Limit', 'yoursite'),
                'user_accounts' => __('Staff/User Accounts', 'yoursite'),
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
            echo '<input type="text" id="' . $meta_key . '" name="' . $meta_key . '" value="' . esc_attr($value) . '" style="width: 100%;" placeholder="e.g., ✓, ✗, Unlimited, 5GB" />';
            echo '</div>';
        }
        
        echo '</div>'; // .feature-fields
        echo '</div>'; // .feature-category
    }
    
    echo '</div>'; // .pricing-features-comparison
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
        
        // Transaction fees
        'transaction_fees_transaction_fee_percentage' => '',
        'transaction_fees_transaction_fee_fixed' => '',
        
        // Ecommerce website
        'ecommerce_website_add_store_existing_website' => '',
        'ecommerce_website_sell_multiple_sites' => '',
        'ecommerce_website_instant_site_builder' => '',
        'ecommerce_website_site_templates_count' => '',
        'ecommerce_website_additional_pages_count' => '',
        
        // Domains
        'domains_free_subdomain' => '',
        'domains_connect_existing_domain' => '',
        'domains_buy_custom_domain' => '',
        'domains_custom_url_slugs' => '',
        
        // Sales channels
        'sales_channels_linkup_bio_page' => '',
        'sales_channels_facebook_shop' => '',
        'sales_channels_instagram_store' => '',
        'sales_channels_mobile_pos' => '',
        'sales_channels_marketplace_selling' => '',
        
        // Support & Analytics
        'support_analytics_support_type' => '',
        'support_analytics_analytics_level' => '',
        'support_analytics_reporting_features' => '',
        'support_analytics_api_access' => '',
        
        // Storage & Limits
        'storage_limits_product_limit' => '',
        'storage_limits_storage_limit' => '',
        'storage_limits_bandwidth_limit' => '',
        'storage_limits_user_accounts' => '',
    );
    
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

    // List of all meta fields to save
    $meta_fields = array(
        'pricing_monthly_price',
        'pricing_annual_price',
        'pricing_currency',
        'pricing_featured',
        'pricing_button_text',
        'pricing_button_url',
        'pricing_features',
        
        // Transaction fees
        'transaction_fees_transaction_fee_percentage',
        'transaction_fees_transaction_fee_fixed',
        
        // Ecommerce website
        'ecommerce_website_add_store_existing_website',
        'ecommerce_website_sell_multiple_sites',
        'ecommerce_website_instant_site_builder',
        'ecommerce_website_site_templates_count',
        'ecommerce_website_additional_pages_count',
        
        // Domains
        'domains_free_subdomain',
        'domains_connect_existing_domain',
        'domains_buy_custom_domain',
        'domains_custom_url_slugs',
        
        // Sales channels
        'sales_channels_linkup_bio_page',
        'sales_channels_facebook_shop',
        'sales_channels_instagram_store',
        'sales_channels_mobile_pos',
        'sales_channels_marketplace_selling',
        
        // Support & Analytics
        'support_analytics_support_type',
        'support_analytics_analytics_level',
        'support_analytics_reporting_features',
        'support_analytics_api_access',
        
        // Storage & Limits
        'storage_limits_product_limit',
        'storage_limits_storage_limit',
        'storage_limits_bandwidth_limit',
        'storage_limits_user_accounts',
    );

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
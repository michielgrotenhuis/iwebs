<?php
/**
 * Enhanced Pricing Plans Meta Box with Complete Feature Set Matching Comparison Table
 * File: inc/pricing-meta-boxes.php
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
        __('Complete Feature Set for Comparison Table', 'yoursite'),
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
    
    // Basic Features for Cards
    echo '<tr><td colspan="2"><div class="meta-section"><h4>⭐ ' . __('Basic Features List (for pricing cards)', 'yoursite') . '</h4></div></td></tr>';
    
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
 * Complete feature set meta box for comparison table
 */
function yoursite_pricing_features_meta_box_callback($post) {
    $meta = yoursite_get_pricing_meta_fields($post->ID);
    
    echo '<div class="pricing-features-comparison">';
    echo '<p class="description" style="margin-bottom: 20px; background: #f0f6fc; padding: 15px; border: 1px solid #c3dcf2; border-radius: 6px;">';
    echo '<strong>Instructions:</strong> Configure detailed features for the comparison table. Use:<br>';
    echo '• <strong>"Yes"</strong> or <strong>"✓"</strong> for included features<br>';
    echo '• <strong>"No"</strong> or <strong>"✗"</strong> for not included features<br>';
    echo '• <strong>Numbers</strong> like "100", "1000", "Unlimited"<br>';
    echo '• <strong>Descriptive text</strong> like "Basic support", "24/7 Premium support"<br>';
    echo '• <strong>"Unlimited"</strong> for unlimited features';
    echo '</p>';
    
    // Get comprehensive feature categories matching the comparison table
    // This function is now defined in pricing-features-helper.php
    $feature_categories = yoursite_get_comparison_feature_categories();
    
    foreach ($feature_categories as $category_key => $category) {
        echo '<div class="feature-category" style="margin-bottom: 30px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: #fafafa;">';
        echo '<h4 style="margin-top: 0; color: #2271b1; border-bottom: 1px solid #ddd; padding-bottom: 10px; display: flex; align-items: center; gap: 10px;">';
        echo '<span style="font-size: 20px;">' . $category['icon'] . '</span>';
        echo $category['title'];
        echo '</h4>';
        echo '<p style="font-style: italic; color: #666; margin-bottom: 15px;">' . $category['description'] . '</p>';
        
        echo '<div class="feature-fields" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">';
        
        foreach ($category['fields'] as $field_key => $field_data) {
            $meta_key = $category_key . '_' . $field_key;
            $value = isset($meta[$meta_key]) ? $meta[$meta_key] : '';
            
            echo '<div class="feature-field" style="border: 1px solid #e1e1e1; padding: 12px; border-radius: 4px; background: white;">';
            echo '<label for="' . $meta_key . '" style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">' . $field_data['label'] . '</label>';
            echo '<input type="text" id="' . $meta_key . '" name="' . $meta_key . '" value="' . esc_attr($value) . '" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 3px;" placeholder="e.g., Yes, No, Unlimited, 1000" />';
            echo '<p class="description" style="font-size: 11px; margin-top: 4px; color: #666;">' . esc_html($field_data['tooltip']) . '</p>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
}

/**
 * Get pricing meta fields with defaults - Updated for comprehensive features
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
    
    // Add all comprehensive feature fields to defaults
    $feature_categories = yoursite_get_comparison_feature_categories();
    foreach ($feature_categories as $category_key => $category) {
        foreach ($category['fields'] as $field_key => $field_data) {
            $defaults[$category_key . '_' . $field_key] = '';
        }
    }
    
    $meta = array();
    foreach ($defaults as $key => $default) {
        $meta[$key] = get_post_meta($post_id, '_' . $key, true) ?: $default;
    }
    
    return $meta;
}

/**
 * Save pricing meta box data - Updated for comprehensive features
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
    
    // Add all comprehensive feature fields
    $feature_categories = yoursite_get_comparison_feature_categories();
    foreach ($feature_categories as $category_key => $category) {
        foreach ($category['fields'] as $field_key => $field_data) {
            $meta_fields[] = $category_key . '_' . $field_key;
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
        .pricing-features-comparison { max-height: 600px; overflow-y: auto; border: 1px solid #ddd; padding: 20px; background: white; }
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
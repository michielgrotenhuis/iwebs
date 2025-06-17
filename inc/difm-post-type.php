<?php
/**
 * DIFM (Do It For Me) Custom Post Type and Admin Functions
 * Add this to inc/post-types.php or create a new file inc/difm-post-type.php
 */

/**
 * Register DIFM Packages Custom Post Type
 */
function yoursite_register_difm_packages_post_type() {
    $labels = array(
        'name'                  => _x('DIFM Packages', 'Post type general name', 'yoursite'),
        'singular_name'         => _x('DIFM Package', 'Post type singular name', 'yoursite'),
        'menu_name'             => _x('DIFM Packages', 'Admin Menu text', 'yoursite'),
        'name_admin_bar'        => _x('DIFM Package', 'Add New on Toolbar', 'yoursite'),
        'add_new'               => __('Add New', 'yoursite'),
        'add_new_item'          => __('Add New Package', 'yoursite'),
        'new_item'              => __('New Package', 'yoursite'),
        'edit_item'             => __('Edit Package', 'yoursite'),
        'view_item'             => __('View Package', 'yoursite'),
        'all_items'             => __('All Packages', 'yoursite'),
        'search_items'          => __('Search Packages', 'yoursite'),
        'parent_item_colon'     => __('Parent Packages:', 'yoursite'),
        'not_found'             => __('No packages found.', 'yoursite'),
        'not_found_in_trash'    => __('No packages found in Trash.', 'yoursite'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'excerpt', 'page-attributes'),
        'show_in_nav_menus'  => false,
        'can_export'         => true,
    );

    register_post_type('difm_packages', $args);
}
add_action('init', 'yoursite_register_difm_packages_post_type');

/**
 * Register DIFM Requests Custom Post Type
 */
function yoursite_register_difm_requests_post_type() {
    $labels = array(
        'name'                  => _x('DIFM Requests', 'Post type general name', 'yoursite'),
        'singular_name'         => _x('DIFM Request', 'Post type singular name', 'yoursite'),
        'menu_name'             => _x('DIFM Requests', 'Admin Menu text', 'yoursite'),
        'name_admin_bar'        => _x('DIFM Request', 'Add New on Toolbar', 'yoursite'),
        'add_new'               => __('Add New', 'yoursite'),
        'add_new_item'          => __('Add New Request', 'yoursite'),
        'new_item'              => __('New Request', 'yoursite'),
        'edit_item'             => __('Edit Request', 'yoursite'),
        'view_item'             => __('View Request', 'yoursite'),
        'all_items'             => __('All Requests', 'yoursite'),
        'search_items'          => __('Search Requests', 'yoursite'),
        'not_found'             => __('No requests found.', 'yoursite'),
        'not_found_in_trash'    => __('No requests found in Trash.', 'yoursite'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => false,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 26,
        'menu_icon'          => 'dashicons-businessman',
        'supports'           => array('title'),
        'show_in_nav_menus'  => false,
        'can_export'         => true,
    );

    register_post_type('difm_requests', $args);
}
add_action('init', 'yoursite_register_difm_requests_post_type');

/**
 * Add meta boxes for DIFM packages
 */
function yoursite_add_difm_package_meta_boxes() {
    add_meta_box(
        'difm_package_details',
        __('Package Details', 'yoursite'),
        'yoursite_difm_package_meta_box_callback',
        'difm_packages',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'yoursite_add_difm_package_meta_boxes');

/**
 * DIFM Package meta box callback
 */
function yoursite_difm_package_meta_box_callback($post) {
    wp_nonce_field('yoursite_difm_package_meta_box', 'yoursite_difm_package_meta_box_nonce');
    
    $price = get_post_meta($post->ID, '_package_price', true);
    $currency = get_post_meta($post->ID, '_package_currency', true) ?: '$';
    $featured = get_post_meta($post->ID, '_package_featured', true);
    $features = get_post_meta($post->ID, '_package_features', true);
    $order = get_post_meta($post->ID, '_package_order', true);
    $order_url = get_post_meta($post->ID, '_package_order_url', true);
    
    ?>
    <style>
        .difm-meta-table { width: 100%; }
        .difm-meta-table th { text-align: left; padding: 15px 10px 15px 0; width: 150px; vertical-align: top; }
        .difm-meta-table td { padding: 15px 0; }
        .difm-meta-table input[type="text"], .difm-meta-table input[type="number"], .difm-meta-table select { width: 100%; max-width: 400px; }
        .difm-meta-table textarea { width: 100%; max-width: 600px; height: 120px; }
        .difm-meta-table .description { font-style: italic; color: #666; margin-top: 5px; }
    </style>
    
    <table class="difm-meta-table">
        <tr>
            <th><label for="package_price"><strong><?php _e('Price', 'yoursite'); ?></strong></label></th>
            <td>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <select id="package_currency" name="package_currency" style="width: 80px;">
                        <option value="$" <?php selected($currency, '$'); ?>>$ USD</option>
                        <option value="€" <?php selected($currency, '€'); ?>>€ EUR</option>
                        <option value="£" <?php selected($currency, '£'); ?>>£ GBP</option>
                        <option value="¥" <?php selected($currency, '¥'); ?>>¥ JPY</option>
                    </select>
                    <input type="number" id="package_price" name="package_price" value="<?php echo esc_attr($price); ?>" step="0.01" placeholder="120.00" style="width: 150px;" />
                </div>
                <p class="description"><?php _e('Package price (without currency symbol)', 'yoursite'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th><label for="package_featured"><strong><?php _e('Featured Package', 'yoursite'); ?></strong></label></th>
            <td>
                <input type="checkbox" id="package_featured" name="package_featured" value="1" <?php checked($featured, '1'); ?> />
                <label for="package_featured"><?php _e('Mark as featured package (will be highlighted)', 'yoursite'); ?></label>
            </td>
        </tr>
        
        <tr>
            <th><label for="package_order"><strong><?php _e('Display Order', 'yoursite'); ?></strong></label></th>
            <td>
                <input type="number" id="package_order" name="package_order" value="<?php echo esc_attr($order); ?>" placeholder="1" />
                <p class="description"><?php _e('Order for displaying packages (lower numbers first)', 'yoursite'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th><label for="package_features"><strong><?php _e('Features List', 'yoursite'); ?></strong></label></th>
            <td>
                <textarea id="package_features" name="package_features" placeholder="✅ Main page, product card, list&#10;✅ 2 versions&#10;✅ 2 changes&#10;❌ Favicon"><?php echo esc_textarea($features); ?></textarea>
                <p class="description"><?php _e('One feature per line. Use ✅ for included features and ❌ for not included features.', 'yoursite'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th><label for="package_order_url"><strong><?php _e('Custom Order URL', 'yoursite'); ?></strong></label></th>
            <td>
                <input type="url" id="package_order_url" name="package_order_url" value="<?php echo esc_attr($order_url); ?>" placeholder="https://example.com/order" />
                <p class="description"><?php _e('Optional: Custom URL for order button instead of onboarding wizard', 'yoursite'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save DIFM package meta box data
 */
function yoursite_save_difm_package_meta_box_data($post_id) {
    if (!isset($_POST['yoursite_difm_package_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['yoursite_difm_package_meta_box_nonce'], 'yoursite_difm_package_meta_box')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save package price
    if (isset($_POST['package_price'])) {
        $price = sanitize_text_field($_POST['package_price']);
        update_post_meta($post_id, '_package_price', $price);
    }

    // Save currency
    if (isset($_POST['package_currency'])) {
        $currency = sanitize_text_field($_POST['package_currency']);
        update_post_meta($post_id, '_package_currency', $currency);
    }

    // Save featured status
    $featured = isset($_POST['package_featured']) ? '1' : '0';
    update_post_meta($post_id, '_package_featured', $featured);

    // Save display order
    if (isset($_POST['package_order'])) {
        $order = intval($_POST['package_order']);
        update_post_meta($post_id, '_package_order', $order);
    }

    // Save features
    if (isset($_POST['package_features'])) {
        $features = sanitize_textarea_field($_POST['package_features']);
        update_post_meta($post_id, '_package_features', $features);
    }

    // Save order URL
    if (isset($_POST['package_order_url'])) {
        $order_url = esc_url_raw($_POST['package_order_url']);
        update_post_meta($post_id, '_package_order_url', $order_url);
    }
}
add_action('save_post', 'yoursite_save_difm_package_meta_box_data');

/**
 * Add meta boxes for DIFM requests
 */
function yoursite_add_difm_request_meta_boxes() {
    add_meta_box(
        'difm_request_details',
        __('Request Details', 'yoursite'),
        'yoursite_difm_request_meta_box_callback',
        'difm_requests',
        'normal',
        'high'
    );
    
    add_meta_box(
        'difm_request_status',
        __('Request Status', 'yoursite'),
        'yoursite_difm_request_status_meta_box_callback',
        'difm_requests',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'yoursite_add_difm_request_meta_boxes');

/**
 * DIFM Request details meta box callback
 */
function yoursite_difm_request_meta_box_callback($post) {
    $request_data = get_post_meta($post->ID, '_request_data', true);
    
    if (is_array($request_data)) :
    ?>
    <style>
        .request-details-table { width: 100%; border-collapse: collapse; }
        .request-details-table th, .request-details-table td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        .request-details-table th { background: #f9f9f9; font-weight: 600; width: 200px; }
        .request-details-table td { background: white; }
    </style>
    
    <table class="request-details-table">
        <tr>
            <th><?php _e('Package Selected', 'yoursite'); ?></th>
            <td><strong><?php echo esc_html($request_data['selected_package_name'] ?? ''); ?></strong> - <?php echo esc_html($request_data['selected_package_price'] ?? ''); ?></td>
        </tr>
        <tr>
            <th><?php _e('Client Name', 'yoursite'); ?></th>
            <td><?php echo esc_html(($request_data['first_name'] ?? '') . ' ' . ($request_data['last_name'] ?? '')); ?></td>
        </tr>
        <tr>
            <th><?php _e('Email', 'yoursite'); ?></th>
            <td><a href="mailto:<?php echo esc_attr($request_data['email'] ?? ''); ?>"><?php echo esc_html($request_data['email'] ?? ''); ?></a></td>
        </tr>
        <tr>
            <th><?php _e('Phone', 'yoursite'); ?></th>
            <td><?php echo esc_html($request_data['phone'] ?? 'Not provided'); ?></td>
        </tr>
        <tr>
            <th><?php _e('Company', 'yoursite'); ?></th>
            <td><?php echo esc_html($request_data['company_name'] ?? ''); ?></td>
        </tr>
        <tr>
            <th><?php _e('Business Type', 'yoursite'); ?></th>
            <td><?php echo esc_html($request_data['business_type'] ?? ''); ?></td>
        </tr>
        <tr>
            <th><?php _e('Website Purpose', 'yoursite'); ?></th>
            <td><?php echo esc_html($request_data['website_purpose'] ?? ''); ?></td>
        </tr>
        <tr>
            <th><?php _e('Design Style', 'yoursite'); ?></th>
            <td><?php echo esc_html($request_data['design_style'] ?? ''); ?></td>
        </tr>
        <tr>
            <th><?php _e('Color Preferences', 'yoursite'); ?></th>
            <td><?php echo esc_html($request_data['color_preferences'] ?? ''); ?></td>
        </tr>
        <tr>
            <th><?php _e('Has Logo', 'yoursite'); ?></th>
            <td><?php echo esc_html($request_data['has_logo'] ?? ''); ?></td>
        </tr>
        <tr>
            <th><?php _e('Reference Sites', 'yoursite'); ?></th>
            <td><?php echo nl2br(esc_html($request_data['reference_sites'] ?? '')); ?></td>
        </tr>
        <tr>
            <th><?php _e('Special Requests', 'yoursite'); ?></th>
            <td><?php echo nl2br(esc_html($request_data['special_requests'] ?? '')); ?></td>
        </tr>
        <tr>
            <th><?php _e('Submitted', 'yoursite'); ?></th>
            <td><?php echo esc_html($request_data['submitted_at'] ?? ''); ?></td>
        </tr>
    </table>
    <?php
    else :
    ?>
    <p><?php _e('No request data available.', 'yoursite'); ?></p>
    <?php
    endif;
}

/**
 * DIFM Request status meta box callback
 */
function yoursite_difm_request_status_meta_box_callback($post) {
    wp_nonce_field('yoursite_difm_request_status_meta_box', 'yoursite_difm_request_status_meta_box_nonce');
    
    $status = get_post_meta($post->ID, '_request_status', true) ?: 'new';
    $priority = get_post_meta($post->ID, '_request_priority', true) ?: 'normal';
    $assigned_to = get_post_meta($post->ID, '_assigned_to', true);
    $notes = get_post_meta($post->ID, '_admin_notes', true);
    
    ?>
    <p>
        <label for="request_status"><strong><?php _e('Status', 'yoursite'); ?></strong></label><br>
        <select id="request_status" name="request_status" style="width: 100%;">
            <option value="new" <?php selected($status, 'new'); ?>><?php _e('New', 'yoursite'); ?></option>
            <option value="contacted" <?php selected($status, 'contacted'); ?>><?php _e('Contacted', 'yoursite'); ?></option>
            <option value="in_progress" <?php selected($status, 'in_progress'); ?>><?php _e('In Progress', 'yoursite'); ?></option>
            <option value="review" <?php selected($status, 'review'); ?>><?php _e('Under Review', 'yoursite'); ?></option>
            <option value="completed" <?php selected($status, 'completed'); ?>><?php _e('Completed', 'yoursite'); ?></option>
            <option value="cancelled" <?php selected($status, 'cancelled'); ?>><?php _e('Cancelled', 'yoursite'); ?></option>
        </select>
    </p>
    
    <p>
        <label for="request_priority"><strong><?php _e('Priority', 'yoursite'); ?></strong></label><br>
        <select id="request_priority" name="request_priority" style="width: 100%;">
            <option value="low" <?php selected($priority, 'low'); ?>><?php _e('Low', 'yoursite'); ?></option>
            <option value="normal" <?php selected($priority, 'normal'); ?>><?php _e('Normal', 'yoursite'); ?></option>
            <option value="high" <?php selected($priority, 'high'); ?>><?php _e('High', 'yoursite'); ?></option>
            <option value="urgent" <?php selected($priority, 'urgent'); ?>><?php _e('Urgent', 'yoursite'); ?></option>
        </select>
    </p>
    
    <p>
        <label for="assigned_to"><strong><?php _e('Assigned To', 'yoursite'); ?></strong></label><br>
        <?php
        $users = get_users(array('capability' => 'edit_posts'));
        ?>
        <select id="assigned_to" name="assigned_to" style="width: 100%;">
            <option value=""><?php _e('Not Assigned', 'yoursite'); ?></option>
            <?php foreach ($users as $user) : ?>
                <option value="<?php echo $user->ID; ?>" <?php selected($assigned_to, $user->ID); ?>>
                    <?php echo esc_html($user->display_name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    
    <p>
        <label for="admin_notes"><strong><?php _e('Admin Notes', 'yoursite'); ?></strong></label><br>
        <textarea id="admin_notes" name="admin_notes" rows="5" style="width: 100%;"><?php echo esc_textarea($notes); ?></textarea>
    </p>
    <?php
}

/**
 * Save DIFM request status meta box data
 */
function yoursite_save_difm_request_status_meta_box_data($post_id) {
    if (!isset($_POST['yoursite_difm_request_status_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['yoursite_difm_request_status_meta_box_nonce'], 'yoursite_difm_request_status_meta_box')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save status
    if (isset($_POST['request_status'])) {
        $status = sanitize_text_field($_POST['request_status']);
        update_post_meta($post_id, '_request_status', $status);
    }

    // Save priority
    if (isset($_POST['request_priority'])) {
        $priority = sanitize_text_field($_POST['request_priority']);
        update_post_meta($post_id, '_request_priority', $priority);
    }

    // Save assigned user
    if (isset($_POST['assigned_to'])) {
        $assigned_to = intval($_POST['assigned_to']);
        update_post_meta($post_id, '_assigned_to', $assigned_to);
    }

    // Save admin notes
    if (isset($_POST['admin_notes'])) {
        $notes = sanitize_textarea_field($_POST['admin_notes']);
        update_post_meta($post_id, '_admin_notes', $notes);
    }
}
add_action('save_post', 'yoursite_save_difm_request_status_meta_box_data');

/**
 * Add custom columns to DIFM packages admin list
 */
function yoursite_difm_packages_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['price'] = __('Price', 'yoursite');
    $new_columns['featured'] = __('Featured', 'yoursite');
    $new_columns['order'] = __('Order', 'yoursite');
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_difm_packages_posts_columns', 'yoursite_difm_packages_admin_columns');

/**
 * Display custom column content for DIFM packages
 */function yoursite_difm_packages_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'price':
            $price = get_post_meta($post_id, '_package_price', true);
            $currency = get_post_meta($post_id, '_package_currency', true) ?: '';
            echo $price ? esc_html($currency . $price) : '-';
            break;
        case 'featured':
            $featured = get_post_meta($post_id, '_package_featured', true);
            echo $featured ? '<span style="color: green;">✓ Featured</span>' : '-';
            break;
        case 'order':
            $order = get_post_meta($post_id, '_package_order', true);
            echo $order ? esc_html($order) : '-';
            break;
    }

}
add_action('manage_difm_packages_posts_custom_column', 'yoursite_difm_packages_admin_column_content', 10, 2);

/**
 * Add custom columns to DIFM requests admin list
 */
function yoursite_difm_requests_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = __('Client', 'yoursite');
    $new_columns['package'] = __('Package', 'yoursite');
    $new_columns['email'] = __('Email', 'yoursite');
    $new_columns['status'] = __('Status', 'yoursite');
    $new_columns['priority'] = __('Priority', 'yoursite');
    $new_columns['assigned'] = __('Assigned To', 'yoursite');
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_difm_requests_posts_columns', 'yoursite_difm_requests_admin_columns');

/**
 * Display custom column content for DIFM requests
 */
function yoursite_difm_requests_admin_column_content($column, $post_id) {
    $request_data = get_post_meta($post_id, '_request_data', true);
    
    switch ($column) {
        case 'package':
            echo isset($request_data['selected_package_name']) ? esc_html($request_data['selected_package_name']) : '-';
            break;
        case 'email':
            $email = isset($request_data['email']) ? $request_data['email'] : '';
            echo $email ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>' : '-';
            break;
        case 'status':
            $status = get_post_meta($post_id, '_request_status', true) ?: 'new';
            $status_colors = array(
                'new' => '#d63638',
                'contacted' => '#dba617', 
                'in_progress' => '#72aee6',
                'review' => '#8b5cf6',
                'completed' => '#00a32a',
                'cancelled' => '#8c8f94'
            );
            $color = isset($status_colors[$status]) ? $status_colors[$status] : '#8c8f94';
            echo '<span style="color: ' . $color . '; font-weight: bold;">' . esc_html(ucfirst(str_replace('_', ' ', $status))) . '</span>';
            break;
        case 'priority':
            $priority = get_post_meta($post_id, '_request_priority', true) ?: 'normal';
            $priority_colors = array(
                'low' => '#8c8f94',
                'normal' => '#72aee6',
                'high' => '#dba617',
                'urgent' => '#d63638'
            );
            $color = isset($priority_colors[$priority]) ? $priority_colors[$priority] : '#72aee6';
            echo '<span style="color: ' . $color . '; font-weight: bold;">' . esc_html(ucfirst($priority)) . '</span>';
            break;
        case 'assigned':
            $assigned_to = get_post_meta($post_id, '_assigned_to', true);
            if ($assigned_to) {
                $user = get_user_by('ID', $assigned_to);
                echo $user ? esc_html($user->display_name) : '-';
            } else {
                echo '-';
            }
            break;
    }
}
add_action('manage_difm_requests_posts_custom_column', 'yoursite_difm_requests_admin_column_content', 10, 2);

/**
 * Create default DIFM packages on theme activation
 */
function yoursite_create_default_difm_packages() {
    // Check if packages already exist
    $existing_packages = get_posts(array(
        'post_type' => 'difm_packages',
        'numberposts' => 1
    ));
    
    if (!empty($existing_packages)) {
        return; // Already created
    }
    
    $default_packages = array(
        array(
            'title' => 'Standard',
            'content' => 'Perfect for new businesses just getting started with a professional online presence.',
            'excerpt' => 'Essential features for a professional website',
            'price' => '120.00',
            'currency' => 'USD',
            'featured' => false,
            'order' => 1,
            'features' => "✅ Main page, product card, list\n✅ 2 homepage project versions\n✅ 2 concept changes\n✅ Presenting first cut in 14 days\n✅ Web-based logo file type\n❌ Favicon\n✅ 3 banners\n❌ Newsletter\n✅ Free project implementation\n❌ Facebook cover page\n❌ Social media accounts"
        ),
        array(
            'title' => 'Optimum',
            'content' => 'Ideal for growing businesses that need more advanced features and marketing tools.',
            'excerpt' => 'Advanced features with marketing tools',
            'price' => '180.00',
            'currency' => 'USD',
            'featured' => true,
            'order' => 2,
            'features' => "✅ Main page, product card, list\n✅ 3 homepage project versions\n✅ 3 concept changes\n✅ Presenting first cut in 14 days\n✅ High-res logo, all extensions\n✅ Favicon\n✅ 4 banners\n✅ Newsletter (send to 1000 users)\n✅ Free project implementation\n✅ Facebook cover page\n✅ Social media accounts (Opening)"
        ),
        array(
            'title' => 'Prestige',
            'content' => 'Premium package for established businesses wanting the complete professional package.',
            'excerpt' => 'Complete premium package with full branding',
            'price' => '250.00',
            'currency' => 'USD',
            'featured' => false,
            'order' => 3,
            'features' => "✅ Main page, product card, list\n✅ 4 homepage project versions\n✅ 4 concept changes\n✅ Presenting first cut in 14 days\n✅ High-res logo, all extensions\n✅ Favicon\n✅ 5 banners\n✅ Newsletter (send to 1000 users)\n✅ Free project implementation\n✅ Facebook cover page\n✅ Social media accounts (Opening & Branding)"
        )
    );
    
    foreach ($default_packages as $package_data) {
        $post_id = wp_insert_post(array(
            'post_title' => $package_data['title'],
            'post_content' => $package_data['content'],
            'post_excerpt' => $package_data['excerpt'],
            'post_status' => 'publish',
            'post_type' => 'difm_packages'
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, '_package_price', $package_data['price']);
            update_post_meta($post_id, '_package_currency', $package_data['currency']);
            update_post_meta($post_id, '_package_featured', $package_data['featured'] ? '1' : '0');
            update_post_meta($post_id, '_package_order', $package_data['order']);
            update_post_meta($post_id, '_package_features', $package_data['features']);
        }
    }
}
add_action('after_switch_theme', 'yoursite_create_default_difm_packages');

/**
 * AJAX handler for DIFM request submission
 */
function yoursite_handle_difm_request_submission() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'difm_request_nonce')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    // Sanitize and collect form data
    $request_data = array(
        'selected_package_id' => intval($_POST['selected_package_id']),
        'selected_package_name' => sanitize_text_field($_POST['selected_package_name']),
        'selected_package_price' => sanitize_text_field($_POST['selected_package_price']),
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name' => sanitize_text_field($_POST['last_name']),
        'email' => sanitize_email($_POST['email']),
        'phone' => sanitize_text_field($_POST['phone']),
        'company_name' => sanitize_text_field($_POST['company_name']),
        'business_type' => sanitize_text_field($_POST['business_type']),
        'website_purpose' => sanitize_textarea_field($_POST['website_purpose']),
        'design_style' => sanitize_text_field($_POST['design_style']),
        'reference_sites' => sanitize_textarea_field($_POST['reference_sites']),
        'color_preferences' => sanitize_text_field($_POST['color_preferences']),
        'has_logo' => sanitize_text_field($_POST['has_logo']),
        'special_requests' => sanitize_textarea_field($_POST['special_requests']),
        'submitted_at' => current_time('mysql')
    );
    
    // Validate required fields
    $required_fields = array('first_name', 'last_name', 'email', 'company_name', 'business_type');
    foreach ($required_fields as $field) {
        if (empty($request_data[$field])) {
            wp_send_json_error('Please fill in all required fields');
            return;
        }
    }
    
    // Create the request post
    $client_name = $request_data['first_name'] . ' ' . $request_data['last_name'];
    $post_title = $client_name . ' - ' . $request_data['selected_package_name'] . ' Package';
    
    $post_id = wp_insert_post(array(
        'post_title' => $post_title,
        'post_content' => 'DIFM request from ' . $client_name . ' for ' . $request_data['selected_package_name'] . ' package.',
        'post_status' => 'publish',
        'post_type' => 'difm_requests'
    ));
    
    if ($post_id && !is_wp_error($post_id)) {
        // Save request data
        update_post_meta($post_id, '_request_data', $request_data);
        update_post_meta($post_id, '_request_status', 'new');
        update_post_meta($post_id, '_request_priority', 'normal');
        
        // Send notification email to admin
        $admin_email = get_option('admin_email');
        $subject = 'New DIFM Request: ' . $request_data['selected_package_name'] . ' Package';
        
        $message = "New DIFM request received:\n\n";
        $message .= "Package: " . $request_data['selected_package_name'] . " (" . $request_data['selected_package_price'] . ")\n";
        $message .= "Client: " . $client_name . "\n";
        $message .= "Email: " . $request_data['email'] . "\n";
        $message .= "Phone: " . $request_data['phone'] . "\n";
        $message .= "Company: " . $request_data['company_name'] . "\n";
        $message .= "Business Type: " . $request_data['business_type'] . "\n\n";
        $message .= "View full details: " . admin_url('post.php?post=' . $post_id . '&action=edit') . "\n";
        
        wp_mail($admin_email, $subject, $message);
        
        // Send confirmation email to client
        $client_subject = 'Your DIFM Request Has Been Received';
        $client_message = "Hi " . $request_data['first_name'] . ",\n\n";
        $client_message .= "Thank you for your DIFM request! We've received your information and will contact you within 24 hours to discuss your project.\n\n";
        $client_message .= "Package Selected: " . $request_data['selected_package_name'] . "\n";
        $client_message .= "Price: " . $request_data['selected_package_price'] . "\n\n";
        $client_message .= "We look forward to working with you!\n\n";
        $client_message .= "Best regards,\n";
        $client_message .= get_bloginfo('name');
        
        wp_mail($request_data['email'], $client_subject, $client_message);
        
        wp_send_json_success('Request submitted successfully');
    } else {
        wp_send_json_error('Failed to save request. Please try again.');
    }
}
add_action('wp_ajax_submit_difm_request', 'yoursite_handle_difm_request_submission');
add_action('wp_ajax_nopriv_submit_difm_request', 'yoursite_handle_difm_request_submission');
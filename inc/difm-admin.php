<?php
/**
 * DIFM Admin Interface for Managing Comparison Table
 * Add this to inc/admin-functions.php or create a new file inc/difm-admin.php
 */

/**
 * Add DIFM admin menu
 */
function yoursite_add_difm_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=difm_packages',
        __('Feature Comparison', 'yoursite'),
        __('Feature Comparison', 'yoursite'),
        'manage_options',
        'difm-feature-comparison',
        'yoursite_difm_comparison_admin_page'
    );
    
    add_submenu_page(
        'edit.php?post_type=difm_requests',
        __('Request Statistics', 'yoursite'),
        __('Statistics', 'yoursite'),
        'manage_options',
        'difm-statistics',
        'yoursite_difm_statistics_admin_page'
    );
}
add_action('admin_menu', 'yoursite_add_difm_admin_menu');

/**
 * DIFM Feature Comparison admin page
 */
function yoursite_difm_comparison_admin_page() {
    // Handle form submission
    if (isset($_POST['save_comparison_features']) && wp_verify_nonce($_POST['_wpnonce'], 'save_comparison_features')) {
        $features = array();
        
        if (isset($_POST['features']) && is_array($_POST['features'])) {
            foreach ($_POST['features'] as $index => $feature_data) {
                if (!empty($feature_data['name'])) {
                    $features[] = array(
                        'name' => sanitize_text_field($feature_data['name']),
                        'packages' => isset($feature_data['packages']) ? array_map('sanitize_text_field', $feature_data['packages']) : array()
                    );
                }
            }
        }
        
        update_option('difm_comparison_features', $features);
        echo '<div class="notice notice-success"><p>' . __('Comparison features saved successfully!', 'yoursite') . '</p></div>';
    }
    
    // Get existing features and packages
    $features = get_option('difm_comparison_features', array());
    $packages = get_posts(array(
        'post_type' => 'difm_packages',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_key' => '_package_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
    ));
    
    ?>
    <div class="wrap">
        <h1><?php _e('DIFM Feature Comparison Table', 'yoursite'); ?></h1>
        <p><?php _e('Manage the features shown in the comparison table on the DIFM page.', 'yoursite'); ?></p>
        
        <?php if (empty($packages)) : ?>
            <div class="notice notice-warning">
                <p><?php printf(__('No packages found. <a href="%s">Create some packages first</a> before setting up the comparison table.', 'yoursite'), admin_url('edit.php?post_type=difm_packages')); ?></p>
            </div>
        <?php else : ?>
            
            <form method="post">
                <?php wp_nonce_field('save_comparison_features'); ?>
                
                <div class="comparison-features-container">
                    <table class="wp-list-table widefat fixed striped" id="comparison-table">
                        <thead>
                            <tr>
                                <th width="300"><?php _e('Feature Name', 'yoursite'); ?></th>
                                <?php foreach ($packages as $package) : ?>
                                    <th class="text-center"><?php echo esc_html($package->post_title); ?></th>
                                <?php endforeach; ?>
                                <th width="80"><?php _e('Action', 'yoursite'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="features-tbody">
                            <?php 
                            if (!empty($features)) :
                                foreach ($features as $index => $feature) :
                            ?>
                                <tr class="feature-row">
                                    <td>
                                        <input type="text" name="features[<?php echo $index; ?>][name]" value="<?php echo esc_attr($feature['name']); ?>" class="regular-text" placeholder="<?php _e('Feature name', 'yoursite'); ?>" />
                                    </td>
                                    <?php foreach ($packages as $package) : 
                                        $package_value = isset($feature['packages'][$package->ID]) ? $feature['packages'][$package->ID] : '';
                                    ?>
                                        <td class="text-center">
                                            <select name="features[<?php echo $index; ?>][packages][<?php echo $package->ID; ?>]">
                                                <option value="✅" <?php selected($package_value, '✅'); ?>><?php _e('✅ Included', 'yoursite'); ?></option>
                                                <option value="❌" <?php selected($package_value, '❌'); ?>><?php _e('❌ Not Included', 'yoursite'); ?></option>
                                                <option value="" <?php selected($package_value, ''); ?>><?php _e('Custom Value', 'yoursite'); ?></option>
                                            </select>
                                            <input type="text" name="features[<?php echo $index; ?>][packages][<?php echo $package->ID; ?>]_custom" 
                                                   value="<?php echo (!in_array($package_value, ['✅', '❌'])) ? esc_attr($package_value) : ''; ?>" 
                                                   placeholder="<?php _e('Custom value', 'yoursite'); ?>" 
                                                   class="small-text custom-value-input" 
                                                   style="display: <?php echo (!in_array($package_value, ['✅', '❌']) && !empty($package_value)) ? 'block' : 'none'; ?>; margin-top: 5px;" />
                                        </td>
                                    <?php endforeach; ?>
                                    <td>
                                        <button type="button" class="button remove-feature" onclick="removeFeatureRow(this)"><?php _e('Remove', 'yoursite'); ?></button>
                                    </td>
                                </tr>
                            <?php 
                                endforeach;
                            else :
                                // Add a default empty row
                            ?>
                                <tr class="feature-row">
                                    <td>
                                        <input type="text" name="features[0][name]" value="" class="regular-text" placeholder="<?php _e('Feature name', 'yoursite'); ?>" />
                                    </td>
                                    <?php foreach ($packages as $package) : ?>
                                        <td class="text-center">
                                            <select name="features[0][packages][<?php echo $package->ID; ?>]">
                                                <option value="✅"><?php _e('✅ Included', 'yoursite'); ?></option>
                                                <option value="❌"><?php _e('❌ Not Included', 'yoursite'); ?></option>
                                                <option value=""><?php _e('Custom Value', 'yoursite'); ?></option>
                                            </select>
                                            <input type="text" name="features[0][packages][<?php echo $package->ID; ?>]_custom" 
                                                   value="" 
                                                   placeholder="<?php _e('Custom value', 'yoursite'); ?>" 
                                                   class="small-text custom-value-input" 
                                                   style="display: none; margin-top: 5px;" />
                                        </td>
                                    <?php endforeach; ?>
                                    <td>
                                        <button type="button" class="button remove-feature" onclick="removeFeatureRow(this)"><?php _e('Remove', 'yoursite'); ?></button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <div class="table-actions" style="margin-top: 15px;">
                        <button type="button" class="button" onclick="addFeatureRow()"><?php _e('Add Feature', 'yoursite'); ?></button>
                        <button type="submit" name="save_comparison_features" class="button button-primary"><?php _e('Save Changes', 'yoursite'); ?></button>
                    </div>
                </div>
            </form>
            
        <?php endif; ?>
        
        <div class="postbox" style="margin-top: 30px;">
            <div class="postbox-header">
                <h2><?php _e('Usage Instructions', 'yoursite'); ?></h2>
            </div>
            <div class="inside">
                <h4><?php _e('How to use the comparison table:', 'yoursite'); ?></h4>
                <ul>
                    <li><strong><?php _e('✅ Included:', 'yoursite'); ?></strong> <?php _e('Shows a green checkmark indicating the feature is included', 'yoursite'); ?></li>
                    <li><strong><?php _e('❌ Not Included:', 'yoursite'); ?></strong> <?php _e('Shows a red X indicating the feature is not included', 'yoursite'); ?></li>
                    <li><strong><?php _e('Custom Value:', 'yoursite'); ?></strong> <?php _e('Enter custom text like "2 versions", "Up to 1000 users", etc.', 'yoursite'); ?></li>
                </ul>
                
                <h4><?php _e('Example features you might add:', 'yoursite'); ?></h4>
                <ul>
                    <li><?php _e('Homepage versions', 'yoursite'); ?></li>
                    <li><?php _e('Concept changes', 'yoursite'); ?></li>
                    <li><?php _e('Logo file types', 'yoursite'); ?></li>
                    <li><?php _e('Number of banners', 'yoursite'); ?></li>
                    <li><?php _e('Newsletter capability', 'yoursite'); ?></li>
                    <li><?php _e('Social media setup', 'yoursite'); ?></li>
                </ul>
            </div>
        </div>
    </div>
    
    <style>
    .comparison-features-container {
        background: white;
        padding: 20px;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        margin-top: 20px;
    }
    
    .text-center {
        text-align: center;
    }
    
    .custom-value-input {
        width: 100%;
        max-width: 120px;
    }
    
    #comparison-table select {
        max-width: 140px;
        font-size: 12px;
    }
    
    .feature-row td {
        vertical-align: top;
        padding: 12px 8px;
    }
    
    .table-actions {
        border-top: 1px solid #ddd;
        padding-top: 15px;
    }
    </style>
    
    <script>
    let featureIndex = <?php echo !empty($features) ? count($features) : 1; ?>;
    
    function addFeatureRow() {
        const tbody = document.getElementById('features-tbody');
        const packages = <?php echo json_encode(array_map(function($p) { return $p->ID; }, $packages)); ?>;
        
        let row = '<tr class="feature-row">';
        row += '<td><input type="text" name="features[' + featureIndex + '][name]" value="" class="regular-text" placeholder="<?php _e('Feature name', 'yoursite'); ?>" /></td>';
        
        packages.forEach(function(packageId) {
            row += '<td class="text-center">';
            row += '<select name="features[' + featureIndex + '][packages][' + packageId + ']" onchange="toggleCustomInput(this)">';
            row += '<option value="✅"><?php _e('✅ Included', 'yoursite'); ?></option>';
            row += '<option value="❌"><?php _e('❌ Not Included', 'yoursite'); ?></option>';
            row += '<option value=""><?php _e('Custom Value', 'yoursite'); ?></option>';
            row += '</select>';
            row += '<input type="text" name="features[' + featureIndex + '][packages][' + packageId + ']_custom" value="" placeholder="<?php _e('Custom value', 'yoursite'); ?>" class="small-text custom-value-input" style="display: none; margin-top: 5px;" />';
            row += '</td>';
        });
        
        row += '<td><button type="button" class="button remove-feature" onclick="removeFeatureRow(this)"><?php _e('Remove', 'yoursite'); ?></button></td>';
        row += '</tr>';
        
        tbody.insertAdjacentHTML('beforeend', row);
        featureIndex++;
    }
    
    function removeFeatureRow(button) {
        const row = button.closest('tr');
        if (document.querySelectorAll('.feature-row').length > 1) {
            row.remove();
        } else {
            alert('<?php _e('You must have at least one feature row.', 'yoursite'); ?>');
        }
    }
    
    function toggleCustomInput(select) {
        const customInput = select.nextElementSibling;
        if (select.value === '') {
            customInput.style.display = 'block';
            customInput.focus();
        } else {
            customInput.style.display = 'none';
            customInput.value = '';
        }
    }
    
    // Initialize existing custom inputs
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('select[name*="[packages]"]').forEach(function(select) {
            const customInput = select.nextElementSibling;
            if (select.value === '' && customInput.value !== '') {
                customInput.style.display = 'block';
            }
            
            select.addEventListener('change', function() {
                toggleCustomInput(this);
            });
        });
        
        // Handle form submission to merge custom values
        document.querySelector('form').addEventListener('submit', function(e) {
            document.querySelectorAll('.custom-value-input').forEach(function(input) {
                if (input.style.display !== 'none' && input.value) {
                    const select = input.previousElementSibling;
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = select.name;
                    hiddenInput.value = input.value;
                    input.parentNode.appendChild(hiddenInput);
                }
            });
        });
    });
    </script>
    <?php
}

/**
 * DIFM Statistics admin page
 */
function yoursite_difm_statistics_admin_page() {
    // Get statistics
    $total_requests = wp_count_posts('difm_requests')->publish;
    
    $requests_by_status = array();
    $requests_by_package = array();
    $requests_by_month = array();
    
    $all_requests = get_posts(array(
        'post_type' => 'difm_requests',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ));
    
    foreach ($all_requests as $request) {
        // Status statistics
        $status = get_post_meta($request->ID, '_request_status', true) ?: 'new';
        if (!isset($requests_by_status[$status])) {
            $requests_by_status[$status] = 0;
        }
        $requests_by_status[$status]++;
        
        // Package statistics
        $request_data = get_post_meta($request->ID, '_request_data', true);
        if (isset($request_data['selected_package_name'])) {
            $package = $request_data['selected_package_name'];
            if (!isset($requests_by_package[$package])) {
                $requests_by_package[$package] = 0;
            }
            $requests_by_package[$package]++;
        }
        
        // Monthly statistics
        $month = date('Y-m', strtotime($request->post_date));
        if (!isset($requests_by_month[$month])) {
            $requests_by_month[$month] = 0;
        }
        $requests_by_month[$month]++;
    }
    
    // Sort monthly data
    ksort($requests_by_month);
    $recent_months = array_slice($requests_by_month, -6, 6, true);
    
    ?>
    <div class="wrap">
        <h1><?php _e('DIFM Request Statistics', 'yoursite'); ?></h1>
        
        <div class="dashboard-widgets-wrap">
            <div class="postbox-container" style="width: 100%;">
                
                <!-- Overview Stats -->
                <div class="postbox">
                    <div class="postbox-header">
                        <h2><?php _e('Overview', 'yoursite'); ?></h2>
                    </div>
                    <div class="inside">
                        <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                            <div class="stat-card" style="background: #f0f6ff; padding: 20px; border-radius: 8px; text-align: center;">
                                <div style="font-size: 32px; font-weight: bold; color: #1e40af;"><?php echo $total_requests; ?></div>
                                <div style="color: #64748b;"><?php _e('Total Requests', 'yoursite'); ?></div>
                            </div>
                            
                            <div class="stat-card" style="background: #f0fdf4; padding: 20px; border-radius: 8px; text-align: center;">
                                <div style="font-size: 32px; font-weight: bold; color: #16a34a;"><?php echo isset($requests_by_status['completed']) ? $requests_by_status['completed'] : 0; ?></div>
                                <div style="color: #64748b;"><?php _e('Completed', 'yoursite'); ?></div>
                            </div>
                            
                            <div class="stat-card" style="background: #fef3c7; padding: 20px; border-radius: 8px; text-align: center;">
                                <div style="font-size: 32px; font-weight: bold; color: #d97706;"><?php echo isset($requests_by_status['in_progress']) ? $requests_by_status['in_progress'] : 0; ?></div>
                                <div style="color: #64748b;"><?php _e('In Progress', 'yoursite'); ?></div>
                            </div>
                            
                            <div class="stat-card" style="background: #fef2f2; padding: 20px; border-radius: 8px; text-align: center;">
                                <div style="font-size: 32px; font-weight: bold; color: #dc2626;"><?php echo isset($requests_by_status['new']) ? $requests_by_status['new'] : 0; ?></div>
                                <div style="color: #64748b;"><?php _e('New Requests', 'yoursite'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Status Breakdown -->
                <div class="postbox">
                    <div class="postbox-header">
                        <h2><?php _e('Requests by Status', 'yoursite'); ?></h2>
                    </div>
                    <div class="inside">
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th><?php _e('Status', 'yoursite'); ?></th>
                                    <th><?php _e('Count', 'yoursite'); ?></th>
                                    <th><?php _e('Percentage', 'yoursite'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($requests_by_status as $status => $count) : 
                                    $percentage = $total_requests > 0 ? round(($count / $total_requests) * 100, 1) : 0;
                                ?>
                                    <tr>
                                        <td><strong><?php echo esc_html(ucfirst(str_replace('_', ' ', $status))); ?></strong></td>
                                        <td><?php echo $count; ?></td>
                                        <td>
                                            <div style="display: flex; align-items: center;">
                                                <div style="background: #e5e7eb; width: 100px; height: 20px; border-radius: 10px; margin-right: 10px; overflow: hidden;">
                                                    <div style="background: #3b82f6; height: 100%; width: <?php echo $percentage; ?>%; transition: width 0.3s ease;"></div>
                                                </div>
                                                <?php echo $percentage; ?>%
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Package Popularity -->
                <?php if (!empty($requests_by_package)) : ?>
                <div class="postbox">
                    <div class="postbox-header">
                        <h2><?php _e('Most Popular Packages', 'yoursite'); ?></h2>
                    </div>
                    <div class="inside">
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th><?php _e('Package', 'yoursite'); ?></th>
                                    <th><?php _e('Requests', 'yoursite'); ?></th>
                                    <th><?php _e('Percentage', 'yoursite'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                arsort($requests_by_package);
                                foreach ($requests_by_package as $package => $count) : 
                                    $percentage = $total_requests > 0 ? round(($count / $total_requests) * 100, 1) : 0;
                                ?>
                                    <tr>
                                        <td><strong><?php echo esc_html($package); ?></strong></td>
                                        <td><?php echo $count; ?></td>
                                        <td>
                                            <div style="display: flex; align-items: center;">
                                                <div style="background: #e5e7eb; width: 100px; height: 20px; border-radius: 10px; margin-right: 10px; overflow: hidden;">
<div style="background: #10b981; height: 100%; width: <?php echo $percentage; ?>%; transition: width 0.3s ease;"></div>
                                                </div>
                                                <?php echo $percentage; ?>%
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Monthly Trends -->
                <?php if (!empty($recent_months)) : ?>
                <div class="postbox">
                    <div class="postbox-header">
                        <h2><?php _e('Monthly Trends (Last 6 Months)', 'yoursite'); ?></h2>
                    </div>
                    <div class="inside">
                        <div style="display: flex; align-items: end; gap: 10px; padding: 20px; background: #f9fafb; border-radius: 8px;">
                            <?php 
                            $max_count = max($recent_months);
                            foreach ($recent_months as $month => $count) :
                                $height = $max_count > 0 ? ($count / $max_count) * 200 : 10;
                                $date = DateTime::createFromFormat('Y-m', $month);
                                $month_label = $date ? $date->format('M Y') : $month;
                            ?>
                                <div style="display: flex; flex-direction: column; align-items: center; flex: 1;">
                                    <div style="background: #6366f1; width: 40px; height: <?php echo $height; ?>px; border-radius: 4px 4px 0 0; margin-bottom: 8px; position: relative;">
                                        <div style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-weight: bold; font-size: 12px; color: #374151;"><?php echo $count; ?></div>
                                    </div>
                                    <div style="font-size: 11px; color: #6b7280; text-align: center; writing-mode: horizontal-tb; transform: rotate(-45deg); margin-top: 10px;"><?php echo $month_label; ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Recent Requests -->
                <div class="postbox">
                    <div class="postbox-header">
                        <h2><?php _e('Recent Requests', 'yoursite'); ?></h2>
                    </div>
                    <div class="inside">
                        <?php 
                        $recent_requests = get_posts(array(
                            'post_type' => 'difm_requests',
                            'posts_per_page' => 10,
                            'post_status' => 'publish',
                            'orderby' => 'date',
                            'order' => 'DESC'
                        ));
                        
                        if ($recent_requests) :
                        ?>
                            <table class="wp-list-table widefat fixed striped">
                                <thead>
                                    <tr>
                                        <th><?php _e('Client', 'yoursite'); ?></th>
                                        <th><?php _e('Package', 'yoursite'); ?></th>
                                        <th><?php _e('Status', 'yoursite'); ?></th>
                                        <th><?php _e('Date', 'yoursite'); ?></th>
                                        <th><?php _e('Action', 'yoursite'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_requests as $request) : 
                                        $request_data = get_post_meta($request->ID, '_request_data', true);
                                        $status = get_post_meta($request->ID, '_request_status', true) ?: 'new';
                                        $client_name = isset($request_data['first_name']) ? $request_data['first_name'] . ' ' . $request_data['last_name'] : 'Unknown';
                                        $package_name = isset($request_data['selected_package_name']) ? $request_data['selected_package_name'] : 'Unknown';
                                    ?>
                                        <tr>
                                            <td><strong><?php echo esc_html($client_name); ?></strong></td>
                                            <td><?php echo esc_html($package_name); ?></td>
                                            <td>
                                                <?php
                                                $status_colors = array(
                                                    'new' => '#dc2626',
                                                    'contacted' => '#d97706', 
                                                    'in_progress' => '#2563eb',
                                                    'review' => '#7c3aed',
                                                    'completed' => '#16a34a',
                                                    'cancelled' => '#6b7280'
                                                );
                                                $color = isset($status_colors[$status]) ? $status_colors[$status] : '#6b7280';
                                                ?>
                                                <span style="color: <?php echo $color; ?>; font-weight: bold;">
                                                    <?php echo esc_html(ucfirst(str_replace('_', ' ', $status))); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($request->post_date)); ?></td>
                                            <td>
                                                <a href="<?php echo admin_url('post.php?post=' . $request->ID . '&action=edit'); ?>" class="button button-small"><?php _e('View', 'yoursite'); ?></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            
                            <p style="margin-top: 15px;">
                                <a href="<?php echo admin_url('edit.php?post_type=difm_requests'); ?>" class="button"><?php _e('View All Requests', 'yoursite'); ?></a>
                            </p>
                        <?php else : ?>
                            <p><?php _e('No requests found.', 'yoursite'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Export Options -->
                <div class="postbox">
                    <div class="postbox-header">
                        <h2><?php _e('Export Data', 'yoursite'); ?></h2>
                    </div>
                    <div class="inside">
                        <p><?php _e('Export DIFM request data for analysis or backup purposes.', 'yoursite'); ?></p>
                        <div style="display: flex; gap: 10px; margin-top: 15px;">
                            <a href="<?php echo admin_url('admin.php?page=difm-statistics&export=csv'); ?>" class="button"><?php _e('Export as CSV', 'yoursite'); ?></a>
                            <a href="<?php echo admin_url('admin.php?page=difm-statistics&export=json'); ?>" class="button"><?php _e('Export as JSON', 'yoursite'); ?></a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <style>
    .dashboard-widgets-wrap .postbox {
        margin-bottom: 20px;
    }
    
    .stat-card {
        transition: transform 0.2s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }
    </style>
    <?php
    
    // Handle export requests
    if (isset($_GET['export'])) {
        yoursite_handle_difm_export($_GET['export']);
    }
}

/**
 * Handle DIFM data export
 */
function yoursite_handle_difm_export($format) {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have permission to access this page.', 'yoursite'));
    }
    
    $requests = get_posts(array(
        'post_type' => 'difm_requests',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ));
    
    $export_data = array();
    
    foreach ($requests as $request) {
        $request_data = get_post_meta($request->ID, '_request_data', true);
        $status = get_post_meta($request->ID, '_request_status', true) ?: 'new';
        $priority = get_post_meta($request->ID, '_request_priority', true) ?: 'normal';
        $assigned_to = get_post_meta($request->ID, '_assigned_to', true);
        
        $assigned_user = '';
        if ($assigned_to) {
            $user = get_user_by('ID', $assigned_to);
            $assigned_user = $user ? $user->display_name : '';
        }
        
        $export_data[] = array(
            'Request ID' => $request->ID,
            'Date' => $request->post_date,
            'Client Name' => isset($request_data['first_name']) ? $request_data['first_name'] . ' ' . $request_data['last_name'] : '',
            'Email' => isset($request_data['email']) ? $request_data['email'] : '',
            'Phone' => isset($request_data['phone']) ? $request_data['phone'] : '',
            'Company' => isset($request_data['company_name']) ? $request_data['company_name'] : '',
            'Business Type' => isset($request_data['business_type']) ? $request_data['business_type'] : '',
            'Package' => isset($request_data['selected_package_name']) ? $request_data['selected_package_name'] : '',
            'Package Price' => isset($request_data['selected_package_price']) ? $request_data['selected_package_price'] : '',
            'Status' => $status,
            'Priority' => $priority,
            'Assigned To' => $assigned_user,
            'Website Purpose' => isset($request_data['website_purpose']) ? $request_data['website_purpose'] : '',
            'Design Style' => isset($request_data['design_style']) ? $request_data['design_style'] : '',
            'Has Logo' => isset($request_data['has_logo']) ? $request_data['has_logo'] : '',
            'Color Preferences' => isset($request_data['color_preferences']) ? $request_data['color_preferences'] : '',
            'Reference Sites' => isset($request_data['reference_sites']) ? $request_data['reference_sites'] : '',
            'Special Requests' => isset($request_data['special_requests']) ? $request_data['special_requests'] : ''
        );
    }
    
    if ($format === 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="difm-requests-' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        if (!empty($export_data)) {
            fputcsv($output, array_keys($export_data[0]));
            foreach ($export_data as $row) {
                fputcsv($output, $row);
            }
        }
        
        fclose($output);
        exit;
        
    } elseif ($format === 'json') {
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="difm-requests-' . date('Y-m-d') . '.json"');
        
        echo json_encode($export_data, JSON_PRETTY_PRINT);
        exit;
    }
}

/**
 * Add dashboard widget for DIFM overview
 */
function yoursite_add_difm_dashboard_widget() {
    wp_add_dashboard_widget(
        'difm_overview_widget',
        __('DIFM Requests Overview', 'yoursite'),
        'yoursite_difm_dashboard_widget_content'
    );
}
add_action('wp_dashboard_setup', 'yoursite_add_difm_dashboard_widget');

/**
 * DIFM dashboard widget content
 */
function yoursite_difm_dashboard_widget_content() {
    $total_requests = wp_count_posts('difm_requests')->publish;
    $new_requests = get_posts(array(
        'post_type' => 'difm_requests',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_request_status',
                'value' => 'new',
                'compare' => '='
            )
        )
    ));
    
    $in_progress = get_posts(array(
        'post_type' => 'difm_requests',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_request_status',
                'value' => 'in_progress',
                'compare' => '='
            )
        )
    ));
    
    ?>
    <div class="difm-dashboard-stats">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px;">
            <div style="text-align: center; padding: 15px; background: #f0f6ff; border-radius: 4px;">
                <div style="font-size: 24px; font-weight: bold; color: #1e40af;"><?php echo $total_requests; ?></div>
                <div style="font-size: 12px; color: #64748b;"><?php _e('Total Requests', 'yoursite'); ?></div>
            </div>
            <div style="text-align: center; padding: 15px; background: <?php echo count($new_requests) > 0 ? '#fef2f2' : '#f9fafb'; ?>; border-radius: 4px;">
                <div style="font-size: 24px; font-weight: bold; color: <?php echo count($new_requests) > 0 ? '#dc2626' : '#6b7280'; ?>;"><?php echo count($new_requests); ?></div>
                <div style="font-size: 12px; color: #64748b;"><?php _e('New Requests', 'yoursite'); ?></div>
            </div>
            <div style="text-align: center; padding: 15px; background: #fef3c7; border-radius: 4px;">
                <div style="font-size: 24px; font-weight: bold; color: #d97706;"><?php echo count($in_progress); ?></div>
                <div style="font-size: 12px; color: #64748b;"><?php _e('In Progress', 'yoursite'); ?></div>
            </div>
        </div>
        
        <?php if (count($new_requests) > 0) : ?>
            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 4px; padding: 12px; margin-bottom: 15px;">
                <strong style="color: #dc2626;"><?php printf(_n('You have %d new DIFM request!', 'You have %d new DIFM requests!', count($new_requests), 'yoursite'), count($new_requests)); ?></strong>
            </div>
        <?php endif; ?>
        
        <p>
            <a href="<?php echo admin_url('edit.php?post_type=difm_requests'); ?>" class="button">
                <?php _e('View All Requests', 'yoursite'); ?>
            </a>
            <a href="<?php echo admin_url('admin.php?page=difm-statistics'); ?>" class="button">
                <?php _e('View Statistics', 'yoursite'); ?>
            </a>
        </p>
    </div>
    <?php
} 
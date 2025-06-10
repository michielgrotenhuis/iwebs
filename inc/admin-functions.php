<?php
/**
 * Admin panel functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu for subscribers
 */
function yoursite_admin_menu() {
    add_options_page(
        __('Newsletter Subscribers', 'yoursite'),
        __('Subscribers', 'yoursite'),
        'manage_options',
        'yoursite-subscribers',
        'yoursite_subscribers_page'
    );
    
    add_management_page(
        __('Demo Requests', 'yoursite'),
        __('Demo Requests', 'yoursite'),
        'manage_options',
        'yoursite-demo-requests',
        'yoursite_demo_requests_page'
    );
    
    add_management_page(
        __('Webinar Registrations', 'yoursite'),
        __('Webinar Registrations', 'yoursite'),
        'manage_options',
        'yoursite-webinar-registrations',
        'yoursite_webinar_registrations_page'
    );
    
    add_management_page(
        __('Security Log', 'yoursite'),
        __('Security Log', 'yoursite'),
        'manage_options',
        'yoursite-security-log',
        'yoursite_security_log_page'
    );
}
add_action('admin_menu', 'yoursite_admin_menu');

/**
 * Newsletter subscribers page
 */
function yoursite_subscribers_page() {
    $subscribers = get_option('yoursite_subscribers', array());
    
    // Handle remove action
    if (isset($_GET['remove']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'remove_subscriber')) {
        $index = intval($_GET['remove']);
        if (isset($subscribers[$index])) {
            unset($subscribers[$index]);
            update_option('yoursite_subscribers', array_values($subscribers));
            echo '<div class="notice notice-success"><p>' . __('Subscriber removed successfully.', 'yoursite') . '</p></div>';
            $subscribers = get_option('yoursite_subscribers', array());
        }
    }
    
    // Handle CSV export
    if (isset($_GET['export']) && $_GET['export'] === 'csv' && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'export_subscribers')) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="newsletter-subscribers.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Email Address', 'Date Added'));
        
        foreach ($subscribers as $email) {
            fputcsv($output, array($email, date('Y-m-d')));
        }
        
        fclose($output);
        exit;
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Newsletter Subscribers', 'yoursite'); ?></h1>
        
        <?php if (!empty($subscribers)) : ?>
            <p><?php printf(__('Total subscribers: %d', 'yoursite'), count($subscribers)); ?></p>
            <div class="tablenav top">
                <div class="alignleft actions">
                    <a href="<?php echo wp_nonce_url(admin_url('options-general.php?page=yoursite-subscribers&export=csv'), 'export_subscribers'); ?>" 
                       class="button"><?php _e('Export CSV', 'yoursite'); ?></a>
                </div>
            </div>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th scope="col"><?php _e('Email Address', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Actions', 'yoursite'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscribers as $index => $email) : ?>
                        <tr>
                            <td><?php echo esc_html($email); ?></td>
                            <td>
                                <a href="<?php echo wp_nonce_url(admin_url('options-general.php?page=yoursite-subscribers&remove=' . $index), 'remove_subscriber'); ?>" 
                                   onclick="return confirm('<?php _e('Remove this subscriber?', 'yoursite'); ?>')"
                                   class="button button-small"><?php _e('Remove', 'yoursite'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p><?php _e('No subscribers yet.', 'yoursite'); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Demo requests page
 */
function yoursite_demo_requests_page() {
    $demo_requests = get_option('yoursite_demo_requests', array());
    
    // Handle status update
    if (isset($_POST['update_status']) && isset($_POST['request_index']) && isset($_POST['new_status'])) {
        if (wp_verify_nonce($_POST['_wpnonce'], 'update_demo_status')) {
            $index = intval($_POST['request_index']);
            $new_status = sanitize_text_field($_POST['new_status']);
            
            if (isset($demo_requests[$index])) {
                $demo_requests[$index]['status'] = $new_status;
                update_option('yoursite_demo_requests', $demo_requests);
                echo '<div class="notice notice-success"><p>' . __('Status updated successfully.', 'yoursite') . '</p></div>';
            }
        }
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Demo Requests', 'yoursite'); ?></h1>
        
        <?php if (!empty($demo_requests)) : ?>
            <p><?php printf(__('Total requests: %d', 'yoursite'), count($demo_requests)); ?></p>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th scope="col"><?php _e('Name', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Company', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Email', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Phone', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Preferred Time', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Status', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Date', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Actions', 'yoursite'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($demo_requests as $index => $request) : ?>
                        <tr>
                            <td><strong><?php echo esc_html($request['name']); ?></strong></td>
                            <td><?php echo esc_html($request['company']); ?></td>
                            <td><a href="mailto:<?php echo esc_attr($request['email']); ?>"><?php echo esc_html($request['email']); ?></a></td>
                            <td><?php echo esc_html($request['phone']); ?></td>
                            <td><?php echo esc_html($request['preferred_time']); ?></td>
                            <td>
                                <span class="status-<?php echo esc_attr($request['status']); ?>">
                                    <?php echo esc_html(ucfirst($request['status'])); ?>
                                </span>
                            </td>
                            <td><?php echo esc_html(date('Y-m-d H:i', strtotime($request['requested_at']))); ?></td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <?php wp_nonce_field('update_demo_status'); ?>
                                    <input type="hidden" name="request_index" value="<?php echo $index; ?>">
                                    <select name="new_status" onchange="this.form.submit()">
                                        <option value="pending" <?php selected($request['status'], 'pending'); ?>><?php _e('Pending', 'yoursite'); ?></option>
                                        <option value="contacted" <?php selected($request['status'], 'contacted'); ?>><?php _e('Contacted', 'yoursite'); ?></option>
                                        <option value="scheduled" <?php selected($request['status'], 'scheduled'); ?>><?php _e('Scheduled', 'yoursite'); ?></option>
                                        <option value="completed" <?php selected($request['status'], 'completed'); ?>><?php _e('Completed', 'yoursite'); ?></option>
                                        <option value="cancelled" <?php selected($request['status'], 'cancelled'); ?>><?php _e('Cancelled', 'yoursite'); ?></option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                        </tr>
                        <?php if (!empty($request['message'])) : ?>
                        <tr>
                            <td colspan="8">
                                <strong><?php _e('Message:', 'yoursite'); ?></strong> <?php echo esc_html($request['message']); ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p><?php _e('No demo requests yet.', 'yoursite'); ?></p>
        <?php endif; ?>
    </div>
    
    <style>
    .status-pending { color: #d63638; }
    .status-contacted { color: #dba617; }
    .status-scheduled { color: #72aee6; }
    .status-completed { color: #00a32a; }
    .status-cancelled { color: #8c8f94; }
    </style>
    <?php
}

/**
 * Webinar registrations page
 */
function yoursite_webinar_registrations_page() {
    $registrations = get_option('yoursite_webinar_registrations', array());
    ?>
    <div class="wrap">
        <h1><?php _e('Webinar Registrations', 'yoursite'); ?></h1>
        
        <?php if (!empty($registrations)) : ?>
            <p><?php printf(__('Total registrations: %d', 'yoursite'), count($registrations)); ?></p>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th scope="col"><?php _e('Name', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Email', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Company', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Webinar', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Registration Date', 'yoursite'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrations as $registration) : ?>
                        <tr>
                            <td><strong><?php echo esc_html($registration['name']); ?></strong></td>
                            <td><a href="mailto:<?php echo esc_attr($registration['email']); ?>"><?php echo esc_html($registration['email']); ?></a></td>
                            <td><?php echo esc_html($registration['company']); ?></td>
                            <td>
                                <a href="<?php echo get_edit_post_link($registration['webinar_id']); ?>">
                                    <?php echo esc_html($registration['webinar_title']); ?>
                                </a>
                            </td>
                            <td><?php echo esc_html(date('Y-m-d H:i', strtotime($registration['registered_at']))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p><?php _e('No webinar registrations yet.', 'yoursite'); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Security log page
 */
function yoursite_security_log_page() {
    $security_log = get_option('yoursite_security_log', array());
    $security_log = array_reverse($security_log); // Show newest first
    ?>
    <div class="wrap">
        <h1><?php _e('Security Log', 'yoursite'); ?></h1>
        
        <?php if (!empty($security_log)) : ?>
            <p><?php printf(__('Showing last %d security events', 'yoursite'), count($security_log)); ?></p>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th scope="col"><?php _e('Date/Time', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Event', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('Description', 'yoursite'); ?></th>
                        <th scope="col"><?php _e('IP Address', 'yoursite'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($security_log as $entry) : ?>
                        <tr>
                            <td><?php echo esc_html(date('Y-m-d H:i:s', strtotime($entry['timestamp']))); ?></td>
                            <td>
                                <span class="event-<?php echo esc_attr($entry['event']); ?>">
                                    <?php echo esc_html(ucfirst(str_replace('_', ' ', $entry['event']))); ?>
                                </span>
                            </td>
                            <td><?php echo esc_html($entry['description']); ?></td>
                            <td><?php echo esc_html($entry['ip']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p><?php _e('No security events logged yet.', 'yoursite'); ?></p>
        <?php endif; ?>
    </div>
    
    <style>
    .event-failed_login { color: #d63638; font-weight: bold; }
    .event-successful_login { color: #00a32a; }
    </style>
    <?php
}

/**
 * Add admin dashboard widgets
 */
function yoursite_add_dashboard_widgets() {
    wp_add_dashboard_widget(
        'yoursite_stats_widget',
        __('YourSite Statistics', 'yoursite'),
        'yoursite_dashboard_stats_widget'
    );
}
add_action('wp_dashboard_setup', 'yoursite_add_dashboard_widgets');

/**
 * Dashboard stats widget
 */
function yoursite_dashboard_stats_widget() {
    $subscribers = get_option('yoursite_subscribers', array());
    $demo_requests = get_option('yoursite_demo_requests', array());
    $webinar_registrations = get_option('yoursite_webinar_registrations', array());
    
    $pending_demos = array_filter($demo_requests, function($request) {
        return $request['status'] === 'pending';
    });
    ?>
    <div class="yoursite-stats-widget">
        <style>
        .yoursite-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 15px 0;
        }
        .yoursite-stat-card {
            background: #f0f0f1;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
        }
        .yoursite-stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #1d2327;
            display: block;
        }
        .yoursite-stat-label {
            font-size: 12px;
            color: #646970;
            text-transform: uppercase;
        }
        .yoursite-pending {
            background: #fff2cd;
            border-left: 4px solid #dba617;
        }
        </style>
        
        <div class="yoursite-stats-grid">
            <div class="yoursite-stat-card">
                <span class="yoursite-stat-number"><?php echo count($subscribers); ?></span>
                <span class="yoursite-stat-label"><?php _e('Newsletter Subscribers', 'yoursite'); ?></span>
            </div>
            <div class="yoursite-stat-card">
                <span class="yoursite-stat-number"><?php echo count($demo_requests); ?></span>
                <span class="yoursite-stat-label"><?php _e('Demo Requests', 'yoursite'); ?></span>
            </div>
            <div class="yoursite-stat-card <?php echo !empty($pending_demos) ? 'yoursite-pending' : ''; ?>">
                <span class="yoursite-stat-number"><?php echo count($pending_demos); ?></span>
                <span class="yoursite-stat-label"><?php _e('Pending Demos', 'yoursite'); ?></span>
            </div>
            <div class="yoursite-stat-card">
                <span class="yoursite-stat-number"><?php echo count($webinar_registrations); ?></span>
                <span class="yoursite-stat-label"><?php _e('Webinar Registrations', 'yoursite'); ?></span>
            </div>
        </div>
        
        <p>
            <a href="<?php echo admin_url('options-general.php?page=yoursite-subscribers'); ?>" class="button">
                <?php _e('Manage Subscribers', 'yoursite'); ?>
            </a>
            <a href="<?php echo admin_url('tools.php?page=yoursite-demo-requests'); ?>" class="button">
                <?php _e('View Demo Requests', 'yoursite'); ?>
            </a>
        </p>
    </div>
    <?php
}

/**
 * Add admin notices for important events
 */
function yoursite_admin_notices() {
    // Check for pending demo requests
    $demo_requests = get_option('yoursite_demo_requests', array());
    $pending_demos = array_filter($demo_requests, function($request) {
        return $request['status'] === 'pending';
    });
    
    if (!empty($pending_demos)) {
        $count = count($pending_demos);
        ?>
        <div class="notice notice-warning">
            <p>
                <?php printf(
                    _n(
                        'You have %d pending demo request.',
                        'You have %d pending demo requests.',
                        $count,
                        'yoursite'
                    ),
                    $count
                ); ?>
                <a href="<?php echo admin_url('tools.php?page=yoursite-demo-requests'); ?>">
                    <?php _e('View requests', 'yoursite'); ?>
                </a>
            </p>
        </div>
        <?php
    }
    
    // Check for successful flush
    if (isset($_GET['flushed']) && $_GET['flushed'] === '1') {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Permalink structure refreshed successfully! Webinar URLs should now work properly.', 'yoursite'); ?></p>
        </div>
        <?php
    }
    
    // Check if we're on webinars admin page and show flush option
    global $pagenow, $post_type;
    if ($pagenow === 'edit.php' && isset($post_type) && $post_type === 'webinars') {
        ?>
        <div class="notice notice-info">
            <p>
                <?php _e('If webinar URLs are showing 404 errors, try refreshing the permalink structure:', 'yoursite'); ?>
                <a href="<?php echo admin_url('edit.php?post_type=webinars&flush_rewrites=1'); ?>" class="button button-secondary" style="margin-left: 10px;">
                    <?php _e('Fix Webinar URLs', 'yoursite'); ?>
                </a>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'yoursite_admin_notices');
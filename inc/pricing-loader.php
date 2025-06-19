<?php
/**
 * Pricing Components Loader
 * Add this to functions.php or create as inc/pricing-loader.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load all pricing-related components
 */
function yoursite_load_pricing_components() {
    $pricing_files = array(
        '/inc/pricing-meta-boxes.php',
        '/inc/pricing-comparison-table.php', 
        '/inc/pricing-shortcodes.php'
    );
    
    foreach ($pricing_files as $file) {
        $file_path = get_template_directory() . $file;
        if (file_exists($file_path)) {
            require_once $file_path;
        }
    }
}
add_action('after_setup_theme', 'yoursite_load_pricing_components', 10);

/**
 * Admin notice to guide users to create pricing plans
 */
function yoursite_pricing_admin_notice() {
    $screen = get_current_screen();
    
    // Only show on dashboard and pricing pages
    if (!in_array($screen->id, array('dashboard', 'edit-pricing', 'pricing'))) {
        return;
    }
    
    // Check if any pricing plans exist
    $pricing_plans = get_posts(array(
        'post_type' => 'pricing',
        'posts_per_page' => 1,
        'post_status' => 'publish'
    ));
    
    if (empty($pricing_plans)) {
        ?>
        <div class="notice notice-info is-dismissible">
            <h3><?php _e('Set up your pricing plans!', 'yoursite'); ?></h3>
            <p><?php _e('Your pricing page is ready, but you haven\'t created any pricing plans yet.', 'yoursite'); ?></p>
            <p>
                <a href="<?php echo admin_url('post-new.php?post_type=pricing'); ?>" class="button button-primary">
                    <?php _e('Create Your First Pricing Plan', 'yoursite'); ?>
                </a>
                <a href="<?php echo home_url('/pricing'); ?>" class="button" target="_blank">
                    <?php _e('View Pricing Page', 'yoursite'); ?>
                </a>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'yoursite_pricing_admin_notice');

/**
 * Add quick action links to pricing plans
 */
function yoursite_pricing_quick_actions() {
    $screen = get_current_screen();
    
    if ($screen->id === 'edit-pricing') {
        echo '<div class="pricing-quick-actions" style="margin: 20px 0; padding: 15px; background: #f0f6fc; border: 1px solid #c3dcf2; border-radius: 4px;">';
        echo '<h4 style="margin-top: 0;">' . __('Quick Actions', 'yoursite') . '</h4>';
        echo '<p>';
        echo '<a href="' . home_url('/pricing') . '" class="button" target="_blank">' . __('View Pricing Page', 'yoursite') . '</a> ';
        echo '<a href="' . admin_url('post-new.php?post_type=pricing') . '" class="button button-primary">' . __('Add New Plan', 'yoursite') . '</a> ';
        echo '<a href="' . admin_url('customize.php') . '" class="button">' . __('Customize Theme', 'yoursite') . '</a>';
        echo '</p>';
        echo '<p class="description">' . __('Tip: Use the comparison table to showcase detailed features and benefits of each plan.', 'yoursite') . '</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'yoursite_pricing_quick_actions');

/**
 * Add pricing help tab
 */
function yoursite_add_pricing_help_tab() {
    $screen = get_current_screen();
    
    if (in_array($screen->id, array('pricing', 'edit-pricing'))) {
        $screen->add_help_tab(array(
            'id' => 'pricing_help',
            'title' => __('Pricing Plans Help', 'yoursite'),
            'content' => '
                <h3>' . __('Creating Effective Pricing Plans', 'yoursite') . '</h3>
                <p>' . __('Here are some tips for creating compelling pricing plans:', 'yoursite') . '</p>
                <ul>
                    <li><strong>' . __('Clear Plan Names:', 'yoursite') . '</strong> ' . __('Use descriptive names like "Starter", "Professional", "Enterprise"', 'yoursite') . '</li>
                    <li><strong>' . __('Highlight Value:', 'yoursite') . '</strong> ' . __('Focus on benefits rather than just features', 'yoursite') . '</li>
                    <li><strong>' . __('Feature Comparison:', 'yoursite') . '</strong> ' . __('Use the comparison table to show differences clearly', 'yoursite') . '</li>
                    <li><strong>' . __('Featured Plan:', 'yoursite') . '</strong> ' . __('Mark your most popular plan as featured', 'yoursite') . '</li>
                    <li><strong>' . __('Call-to-Action:', 'yoursite') . '</strong> ' . __('Use action-oriented button text like "Get Started" or "Try Free"', 'yoursite') . '</li>
                </ul>
                
                <h4>' . __('Comparison Table Features', 'yoursite') . '</h4>
                <p>' . __('The comparison table supports these feature types:', 'yoursite') . '</p>
                <ul>
                    <li><strong>✓ or ✗:</strong> ' . __('For included/not included features', 'yoursite') . '</li>
                    <li><strong>Numbers:</strong> ' . __('For limits like "100 products" or "5GB storage"', 'yoursite') . '</li>
                    <li><strong>Text:</strong> ' . __('For descriptions like "Basic support" or "Premium only"', 'yoursite') . '</li>
                    <li><strong>Special values:</strong> ' . __('Use "Unlimited", "Advanced", "Premium" for highlighting', 'yoursite') . '</li>
                </ul>
            '
        ));
        
        $screen->add_help_tab(array(
            'id' => 'pricing_shortcodes',
            'title' => __('Pricing Shortcodes', 'yoursite'),
            'content' => '
                <h3>' . __('Available Shortcodes', 'yoursite') . '</h3>
                <p>' . __('You can use these shortcodes in posts and pages:', 'yoursite') . '</p>
                
                <h4>[pricing_comparison]</h4>
                <p>' . __('Displays the full pricing comparison table.', 'yoursite') . '</p>
                <code>[pricing_comparison]</code>
                
                <h4>[pricing_cards]</h4>
                <p>' . __('Displays pricing cards in a grid layout.', 'yoursite') . '</p>
                <code>[pricing_cards limit="3" featured="true"]</code>
                <ul>
                    <li><strong>limit:</strong> ' . __('Number of plans to show', 'yoursite') . '</li>
                    <li><strong>featured:</strong> ' . __('Show only featured plans', 'yoursite') . '</li>
                </ul>
                
                <h4>[compare_plans_button]</h4>
                <p>' . __('Creates a button that scrolls to the comparison table.', 'yoursite') . '</p>
                <code>[compare_plans_button text="Compare All Plans"]</code>
                
                <h4>[pricing_toggle]</h4>
                <p>' . __('Displays a monthly/yearly billing toggle.', 'yoursite') . '</p>
                <code>[pricing_toggle]</code>
            '
        ));
        
        $screen->set_help_sidebar('
            <p><strong>' . __('For more information:', 'yoursite') . '</strong></p>
            <p><a href="' . home_url('/pricing') . '" target="_blank">' . __('View Pricing Page', 'yoursite') . '</a></p>
            <p><a href="' . admin_url('customize.php') . '" target="_blank">' . __('Customize Theme', 'yoursite') . '</a></p>
        ');
    }
}
add_action('current_screen', 'yoursite_add_pricing_help_tab');

/**
 * Add pricing dashboard widget
 */
function yoursite_add_pricing_dashboard_widget() {
    wp_add_dashboard_widget(
        'yoursite_pricing_widget',
        __('Pricing Plans Status', 'yoursite'),
        'yoursite_pricing_dashboard_widget_content'
    );
}
add_action('wp_dashboard_setup', 'yoursite_add_pricing_dashboard_widget');

/**
 * Pricing dashboard widget content
 */
function yoursite_pricing_dashboard_widget_content() {
    $pricing_plans = get_posts(array(
        'post_type' => 'pricing',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ));
    
    $featured_plans = array_filter($pricing_plans, function($plan) {
        return get_post_meta($plan->ID, '_pricing_featured', true) === '1';
    });
    
    echo '<div class="pricing-widget-content">';
    
    if (empty($pricing_plans)) {
        echo '<p>' . __('No pricing plans created yet.', 'yoursite') . '</p>';
        echo '<p><a href="' . admin_url('post-new.php?post_type=pricing') . '" class="button button-primary">' . __('Create Your First Plan', 'yoursite') . '</a></p>';
    } else {
        echo '<div class="pricing-stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 15px; margin: 15px 0;">';
        
        echo '<div class="stat-card" style="text-align: center; padding: 15px; background: #f0f0f1; border-radius: 4px;">';
        echo '<div style="font-size: 24px; font-weight: bold; color: #1d2327;">' . count($pricing_plans) . '</div>';
        echo '<div style="font-size: 12px; color: #646970; text-transform: uppercase;">Total Plans</div>';
        echo '</div>';
        
        echo '<div class="stat-card" style="text-align: center; padding: 15px; background: #f0f0f1; border-radius: 4px;">';
        echo '<div style="font-size: 24px; font-weight: bold; color: #1d2327;">' . count($featured_plans) . '</div>';
        echo '<div style="font-size: 12px; color: #646970; text-transform: uppercase;">Featured</div>';
        echo '</div>';
        
        echo '</div>';
        
        echo '<p>';
        echo '<a href="' . admin_url('edit.php?post_type=pricing') . '" class="button">' . __('Manage Plans', 'yoursite') . '</a> ';
        echo '<a href="' . home_url('/pricing') . '" class="button" target="_blank">' . __('View Pricing Page', 'yoursite') . '</a>';
        echo '</p>';
        
        if (!empty($featured_plans)) {
            echo '<h4>' . __('Featured Plans:', 'yoursite') . '</h4>';
            echo '<ul>';
            foreach ($featured_plans as $plan) {
                $monthly_price = get_post_meta($plan->ID, '_pricing_monthly_price', true);
                $currency = get_post_meta($plan->ID, '_pricing_currency', true) ?: 'USD';
                echo '<li>';
                echo '<strong>' . esc_html($plan->post_title) . '</strong>';
                if ($monthly_price) {
                    echo ' - ' . $currency . ' ' . number_format($monthly_price, 2) . '/month';
                }
                echo ' <a href="' . get_edit_post_link($plan->ID) . '">Edit</a>';
                echo '</li>';
            }
            echo '</ul>';
        }
    }
    
    echo '</div>';
}

/**
 * Enqueue admin styles for pricing
 */
function yoursite_pricing_admin_styles() {
    $screen = get_current_screen();
    
    if (in_array($screen->id, array('pricing', 'edit-pricing'))) {
        wp_add_inline_style('wp-admin', '
            .pricing-quick-actions {
                background: #f0f6fc;
                border: 1px solid #c3dcf2;
                border-radius: 4px;
                padding: 15px;
                margin: 20px 0;
            }
            
            .pricing-quick-actions h4 {
                margin-top: 0;
                color: #0073aa;
            }
            
            .pricing-widget-content .stat-card {
                background: #f0f0f1;
                padding: 15px;
                border-radius: 4px;
                text-align: center;
            }
            
            .pricing-widget-content .stat-card div:first-child {
                font-size: 24px;
                font-weight: bold;
                color: #1d2327;
            }
            
            .pricing-widget-content .stat-card div:last-child {
                font-size: 12px;
                color: #646970;
                text-transform: uppercase;
            }
        ');
    }
}
add_action('admin_enqueue_scripts', 'yoursite_pricing_admin_styles');
?>
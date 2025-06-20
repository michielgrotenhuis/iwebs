<?php
/**
 * Enhanced Pricing Comparison Table Component with Tooltips
 * File: inc/pricing-comparison-table.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get feature categories with enhanced metadata
 */
function yoursite_get_comparison_feature_categories() {
    return array(
        'basics' => array(
            'title' => __('Essentials', 'yoursite'),
            'description' => __('Core features to get started', 'yoursite'),
            'icon' => '⚡',
            'fields' => array(
                'transaction_fee' => array(
                    'label' => __('Transaction Fee', 'yoursite'),
                    'tooltip' => __('No hidden fees! We only succeed when you do. Our transparent pricing means more profit in your pocket.', 'yoursite')
                ),
                'product_limit' => array(
                    'label' => __('Product Limit', 'yoursite'),
                    'tooltip' => __('List as many products as your plan allows. Perfect for businesses of any size, from boutiques to enterprise stores.', 'yoursite')
                ),
                'categories' => array(
                    'label' => __('Categories', 'yoursite'),
                    'tooltip' => __('Organize products your way with unlimited categories. Create the perfect shopping experience for your customers.', 'yoursite')
                ),
                'storage' => array(
                    'label' => __('Storage', 'yoursite'),
                    'tooltip' => __('Never worry about space. Upload high-quality images and videos to showcase your products beautifully.', 'yoursite')
                ),
            )
        ),
        'shopping_experience' => array(
            'title' => __('Shopping Experience', 'yoursite'),
            'description' => __('Create seamless shopping journeys', 'yoursite'),
            'icon' => '🛍️',
            'fields' => array(
                'adaptive_storefront' => array(
                    'label' => __('Adaptive Storefront Widget', 'yoursite'),
                    'tooltip' => __('Your store looks perfect on every device. Automatically optimized for desktop, tablet, and mobile shoppers.', 'yoursite')
                ),
                'wishlist' => array(
                    'label' => __('Favorites/Wishlist', 'yoursite'),
                    'tooltip' => __('Let customers save products for later. Increase sales with wish list reminders and sharing features.', 'yoursite')
                ),
                'single_product_widgets' => array(
                    'label' => __('Single Product Widgets', 'yoursite'),
                    'tooltip' => __('Embed products anywhere with customizable widgets. Perfect for blogs, landing pages, and social media.', 'yoursite')
                ),
                'faceted_search' => array(
                    'label' => __('Advanced Search & Filters', 'yoursite'),
                    'tooltip' => __('Help customers find exactly what they want with smart filters by price, color, size, brand, and more.', 'yoursite')
                ),
            )
        ),
        'online_store' => array(
            'title' => __('Online Store Builder', 'yoursite'),
            'description' => __('Build and customize your store', 'yoursite'),
            'icon' => '🌐',
            'fields' => array(
                'wordpress_plugin' => array(
                    'label' => __('WordPress Plugin', 'yoursite'),
                    'tooltip' => __('Seamlessly integrate with WordPress. Keep your existing site and add powerful ecommerce features instantly.', 'yoursite')
                ),
                'customizable_design' => array(
                    'label' => __('Customizable Design', 'yoursite'),
                    'tooltip' => __('Match your brand perfectly. Change colors, fonts, and layouts without touching code.', 'yoursite')
                ),
                'mobile_responsive' => array(
                    'label' => __('Mobile Responsive', 'yoursite'),
                    'tooltip' => __('60% of shoppers use mobile. Your store automatically adapts for the best mobile shopping experience.', 'yoursite')
                ),
                'seo_optimized' => array(
                    'label' => __('SEO Optimized', 'yoursite'),
                    'tooltip' => __('Get found on Google. Built-in SEO features help your products rank higher in search results.', 'yoursite')
                ),
            )
        ),
        'product_inventory' => array(
            'title' => __('Product & Inventory', 'yoursite'),
            'description' => __('Manage products efficiently', 'yoursite'),
            'icon' => '📦',
            'fields' => array(
                'bulk_import' => array(
                    'label' => __('Bulk Import/Export', 'yoursite'),
                    'tooltip' => __('Save hours with bulk operations. Import your entire catalog via CSV or sync with existing systems.', 'yoursite')
                ),
                'inventory_tracking' => array(
                    'label' => __('Inventory Tracking', 'yoursite'),
                    'tooltip' => __('Never oversell again. Real-time inventory updates across all sales channels keep stock accurate.', 'yoursite')
                ),
                'product_variants' => array(
                    'label' => __('Product Variants', 'yoursite'),
                    'tooltip' => __('Sell products in multiple sizes, colors, or styles. Manage variants easily with our intuitive interface.', 'yoursite')
                ),
                'digital_products' => array(
                    'label' => __('Digital Products', 'yoursite'),
                    'tooltip' => __('Sell downloads, courses, or services. Automated delivery and secure file hosting included.', 'yoursite')
                ),
            )
        ),
        'sales_channels' => array(
            'title' => __('Sales Channels', 'yoursite'),
            'description' => __('Sell everywhere your customers are', 'yoursite'),
            'icon' => '📲',
            'fields' => array(
                'link_in_bio' => array(
                    'label' => __('Link-in-Bio Store', 'yoursite'),
                    'tooltip' => __('Turn social media followers into customers. Create a shoppable link-in-bio page in seconds.', 'yoursite')
                ),
                'facebook_shop' => array(
                    'label' => __('Facebook Shop', 'yoursite'),
                    'tooltip' => __('Reach 3 billion Facebook users. Sync your catalog and sell directly on Facebook.', 'yoursite')
                ),
                'instagram_store' => array(
                    'label' => __('Instagram Shopping', 'yoursite'),
                    'tooltip' => __('Tag products in posts and stories. Turn your Instagram feed into a shoppable gallery.', 'yoursite')
                ),
                'marketplace_sync' => array(
                    'label' => __('Marketplace Integration', 'yoursite'),
                    'tooltip' => __('Expand to Amazon, eBay, and more. Manage all marketplaces from one dashboard.', 'yoursite')
                ),
            )
        ),
        'marketing' => array(
            'title' => __('Marketing Tools', 'yoursite'),
            'description' => __('Grow your audience and sales', 'yoursite'),
            'icon' => '📣',
            'fields' => array(
                'email_marketing' => array(
                    'label' => __('Email Marketing', 'yoursite'),
                    'tooltip' => __('Build customer relationships with automated emails. Welcome series, abandoned carts, and more.', 'yoursite')
                ),
                'discount_codes' => array(
                    'label' => __('Discount Codes', 'yoursite'),
                    'tooltip' => __('Create powerful promotions. Set up percentage, fixed amount, or BOGO discounts easily.', 'yoursite')
                ),
                'abandoned_cart' => array(
                    'label' => __('Abandoned Cart Recovery', 'yoursite'),
                    'tooltip' => __('Recover up to 30% of lost sales. Automatically remind customers about items left in their cart.', 'yoursite')
                ),
                'affiliate_program' => array(
                    'label' => __('Affiliate Program', 'yoursite'),
                    'tooltip' => __('Grow with word-of-mouth. Let partners promote your products and track commissions automatically.', 'yoursite')
                ),
            )
        ),
        'checkout_payment' => array(
            'title' => __('Checkout & Payment', 'yoursite'),
            'description' => __('Secure and flexible payments', 'yoursite'),
            'icon' => '💳',
            'fields' => array(
                'payment_gateways' => array(
                    'label' => __('Payment Methods', 'yoursite'),
                    'tooltip' => __('Accept all major payment methods. Credit cards, PayPal, Apple Pay, and 50+ more options.', 'yoursite')
                ),
                'one_page_checkout' => array(
                    'label' => __('One-Page Checkout', 'yoursite'),
                    'tooltip' => __('Reduce cart abandonment by 35%. Streamlined checkout gets customers through faster.', 'yoursite')
                ),
                'guest_checkout' => array(
                    'label' => __('Guest Checkout', 'yoursite'),
                    'tooltip' => __('Don\'t force registration. Let customers check out quickly without creating an account.', 'yoursite')
                ),
                'multi_currency' => array(
                    'label' => __('Multi-Currency', 'yoursite'),
                    'tooltip' => __('Sell globally with confidence. Display prices in customer\'s local currency automatically.', 'yoursite')
                ),
            )
        ),
        'analytics' => array(
            'title' => __('Analytics & Reports', 'yoursite'),
            'description' => __('Data-driven insights', 'yoursite'),
            'icon' => '📊',
            'fields' => array(
                'sales_analytics' => array(
                    'label' => __('Sales Analytics', 'yoursite'),
                    'tooltip' => __('Track what matters. See revenue, orders, and conversion rates in real-time dashboards.', 'yoursite')
                ),
                'customer_insights' => array(
                    'label' => __('Customer Insights', 'yoursite'),
                    'tooltip' => __('Know your customers better. Track lifetime value, purchase patterns, and demographics.', 'yoursite')
                ),
                'product_performance' => array(
                    'label' => __('Product Performance', 'yoursite'),
                    'tooltip' => __('Identify bestsellers and slow movers. Make data-driven decisions about inventory.', 'yoursite')
                ),
                'custom_reports' => array(
                    'label' => __('Custom Reports', 'yoursite'),
                    'tooltip' => __('Get exactly the data you need. Build custom reports and export to Excel or PDF.', 'yoursite')
                ),
            )
        ),
        'support' => array(
            'title' => __('Support & Success', 'yoursite'),
            'description' => __('We\'re here to help you succeed', 'yoursite'),
            'icon' => '💬',
            'fields' => array(
                'support_type' => array(
                    'label' => __('Support Type', 'yoursite'),
                    'tooltip' => __('Get help when you need it. From self-service to dedicated support, we\'ve got you covered.', 'yoursite')
                ),
                'response_time' => array(
                    'label' => __('Response Time', 'yoursite'),
                    'tooltip' => __('Fast responses when it matters. Priority support gets you answers in hours, not days.', 'yoursite')
                ),
                'onboarding' => array(
                    'label' => __('Onboarding Help', 'yoursite'),
                    'tooltip' => __('Start selling faster. Get personalized setup assistance and training for your team.', 'yoursite')
                ),
                'api_access' => array(
                    'label' => __('API Access', 'yoursite'),
                    'tooltip' => __('Build custom integrations. Full API access lets you connect any system or build unique features.', 'yoursite')
                ),
            )
        )
    );
}

/**
 * Render the pricing comparison table with enhanced UI
 */
function yoursite_render_pricing_comparison_table() {
    $plans = yoursite_get_pricing_plans_for_comparison();
    $categories = yoursite_get_comparison_feature_categories();
    
    if (empty($plans)) {
        return '<p class="text-center text-gray-500 dark:text-gray-400 py-8">' . __('No pricing plans available.', 'yoursite') . '</p>';
    }
    
    ob_start();
    ?>
    
    <div class="pricing-comparison-wrapper bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        
        <!-- Streamlined Header -->
        <div class="comparison-header sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 z-40 p-6">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    <?php _e('See What\'s Included in Each Plan', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php _e('Every feature designed to help your business grow', 'yoursite'); ?>
                </p>
            </div>
            
            <!-- Billing Period Toggle - Annual Default -->
            <div class="flex items-center justify-center mb-4">
                <span class="text-gray-700 dark:text-gray-300 mr-4 font-medium comparison-monthly-label">
                    <?php _e('Monthly', 'yoursite'); ?>
                </span>
                <div class="relative">
                    <input type="checkbox" id="comparison-billing-toggle" class="sr-only peer" checked>
                    <label for="comparison-billing-toggle" class="relative inline-flex items-center justify-between w-16 h-8 bg-gray-200 dark:bg-gray-700 rounded-full cursor-pointer transition-colors duration-300 peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800">
                        <span class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 peer-checked:translate-x-8"></span>
                    </label>
                </div>
                <span class="text-gray-700 dark:text-gray-300 ml-4 font-medium comparison-yearly-label">
                    <?php _e('Annual', 'yoursite'); ?>
                </span>
                <span class="bg-emerald-500 text-emerald-50 dark:text-white text-sm font-semibold px-3 py-1 rounded-full ml-3 shadow-md">
                    <?php _e('Save 20%', 'yoursite'); ?>
                </span>
            </div>
        </div>
        
        <!-- Comparison Table -->
        <div class="comparison-table-container overflow-x-auto">
            <table class="comparison-table w-full min-w-[800px]">
                
                <!-- Plan Headers (Sticky) -->
                <thead class="sticky top-[140px] bg-white dark:bg-gray-800 z-30 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="text-left p-4 w-64 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                <?php _e('Features', 'yoursite'); ?>
                            </span>
                        </th>
                        <?php foreach ($plans as $plan) : 
                            $meta = yoursite_get_pricing_meta_fields($plan->ID);
                            $is_featured = $meta['pricing_featured'] === '1';
                            $monthly_price = floatval($meta['pricing_monthly_price']);
                            $annual_price = floatval($meta['pricing_annual_price']);
                            $currency_symbol = yoursite_get_currency_symbol($meta['pricing_currency']);
                            
                            if ($annual_price == 0 && $monthly_price > 0) {
                                $annual_price = $monthly_price * 12 * 0.8;
                            }
                            $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
                            ?>
                            <th class="text-center p-4 border-r border-gray-200 dark:border-gray-700 <?php echo $is_featured ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-gray-800'; ?>">
                                <?php if ($is_featured) : ?>
                                    <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-1 text-xs font-semibold rounded-t-lg">
                                        <?php _e('Most Popular', 'yoursite'); ?>
                                    </div>
                                    <div class="mt-6">
                                <?php else : ?>
                                    <div class="mt-2">
                                <?php endif; ?>
                                
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                    <?php echo esc_html($plan->post_title); ?>
                                </h4>
                                
                                <div class="price-display mb-4">
                                    <div class="monthly-pricing hidden">
                                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                            <?php echo $currency_symbol . number_format($monthly_price, 0); ?>
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-400 text-sm">
                                            /<?php _e('month', 'yoursite'); ?>
                                        </span>
                                    </div>
                                    
                                    <div class="annual-pricing">
                                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                            <?php echo $currency_symbol . number_format($annual_monthly, 0); ?>
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-400 text-sm">
                                            /<?php _e('month', 'yoursite'); ?>
                                        </span>
                                        <div class="text-xs text-green-600 dark:text-green-400 mt-1">
                                            <?php printf(__('Billed annually (%s)', 'yoursite'), $currency_symbol . number_format($annual_price, 0)); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>" 
                                   class="<?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?> text-sm px-4 py-2 rounded-lg font-semibold inline-block transition-all duration-200">
                                    <?php echo esc_html($meta['pricing_button_text'] ?: __('Get Started', 'yoursite')); ?>
                                </a>
                                
                                </div>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                
                <!-- Feature Categories -->
                <tbody>
                    <?php foreach ($categories as $category_key => $category) : ?>
                        
                        <!-- Category Header -->
                        <tr class="bg-gray-50 dark:bg-gray-900">
                            <td colspan="<?php echo count($plans) + 1; ?>" class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3"><?php echo $category['icon']; ?></span>
                                    <div>
                                        <h5 class="text-lg font-bold text-gray-900 dark:text-white">
                                            <?php echo esc_html($category['title']); ?>
                                        </h5>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <?php echo esc_html($category['description']); ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Category Features -->
                        <?php foreach ($category['fields'] as $field_key => $field_data) : ?>
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="p-4 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
                                    <div class="feature-label-wrapper">
                                        <span class="font-medium text-gray-900 dark:text-white feature-label" data-tooltip="<?php echo esc_attr($field_data['tooltip']); ?>">
                                            <?php echo esc_html($field_data['label']); ?>
                                            <svg class="inline-block w-4 h-4 ml-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </td>
                                
                                <?php foreach ($plans as $plan) : 
                                    $meta = yoursite_get_pricing_meta_fields($plan->ID);
                                    $meta_key = $category_key . '_' . $field_key;
                                    $feature_value = isset($meta[$meta_key]) ? $meta[$meta_key] : '';
                                    $is_featured = $meta['pricing_featured'] === '1';
                                    ?>
                                    <td class="p-4 text-center border-r border-gray-200 dark:border-gray-700 <?php echo $is_featured ? 'bg-blue-50/30 dark:bg-blue-900/10' : ''; ?>">
                                        <?php echo yoursite_format_feature_value($feature_value); ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                        
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Bottom CTA -->
        <div class="comparison-footer bg-gray-50 dark:bg-gray-900 p-6 text-center border-t border-gray-200 dark:border-gray-700">
            <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                <?php _e('Still have questions?', 'yoursite'); ?>
            </h4>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                <?php _e('Our team is here to help you choose the right plan for your business.', 'yoursite'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-secondary">
                <?php _e('Contact Sales', 'yoursite'); ?>
            </a>
        </div>
    </div>
    
    <!-- Feature Tooltip Modal -->
    <div id="feature-tooltip" class="feature-tooltip hidden">
        <div class="tooltip-content">
            <p class="tooltip-text"></p>
        </div>
    </div>
    
    <?php
    return ob_get_clean();
}

/**
 * Get pricing plans for comparison
 */
function yoursite_get_pricing_plans_for_comparison() {
    $args = array(
        'post_type' => 'pricing',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_key' => '_pricing_monthly_price',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
    );
    
    return get_posts($args);
}

/**
 * Format feature value for display with enhanced styling
 */
function yoursite_format_feature_value($value) {
    if (empty($value)) {
        return '<span class="text-gray-400 dark:text-gray-600">—</span>';
    }
    
    $value = trim($value);
    $lower_value = strtolower($value);
    
    // Check marks
    if (in_array($lower_value, ['yes', 'included', 'true', '✓'])) {
        return '<span class="text-green-500 dark:text-green-400 text-xl">✓</span>';
    }
    
    // Cross marks
    if (in_array($lower_value, ['no', 'not included', 'false', '✗', '-'])) {
        return '<span class="text-gray-400 dark:text-gray-500 text-xl">—</span>';
    }
    
    // Numeric values
    if (is_numeric($value)) {
        return '<span class="font-semibold text-gray-900 dark:text-white">' . number_format($value) . '</span>';
    }
    
    // Special values
    if (strpos($lower_value, 'unlimited') !== false) {
        return '<span class="font-semibold text-blue-600 dark:text-blue-400">Unlimited</span>';
    }
    
    if (strpos($lower_value, 'custom') !== false || strpos($lower_value, 'enterprise') !== false) {
        return '<span class="font-semibold text-purple-600 dark:text-purple-400">' . esc_html($value) . '</span>';
    }
    
    // Fee percentages
    if (strpos($value, '%') !== false) {
        return '<span class="font-semibold text-gray-900 dark:text-white">' . esc_html($value) . '</span>';
    }
    
    // Support types
    if (strpos($lower_value, 'email') !== false) {
        return '<span class="text-gray-700 dark:text-gray-300">📧 ' . esc_html($value) . '</span>';
    }
    
    if (strpos($lower_value, 'priority') !== false || strpos($lower_value, 'phone') !== false) {
        return '<span class="font-semibold text-blue-600 dark:text-blue-400">⚡ ' . esc_html($value) . '</span>';
    }
    
    if (strpos($lower_value, 'dedicated') !== false || strpos($lower_value, '24/7') !== false) {
        return '<span class="font-semibold text-purple-600 dark:text-purple-400">🌟 ' . esc_html($value) . '</span>';
    }
    
    // Default
    return '<span class="text-gray-700 dark:text-gray-300">' . esc_html($value) . '</span>';
}
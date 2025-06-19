<?php
/**
 * Pricing Comparison Table Component
 * Create as: inc/pricing-comparison-table.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get all pricing plans for comparison table
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
 * Get feature categories for comparison
 */
function yoursite_get_comparison_feature_categories() {
    return array(
        'transaction_fees' => array(
            'title' => __('Transaction Fees', 'yoursite'),
            'description' => __('Fees charged per sale', 'yoursite'),
            'icon' => '💳',
            'fields' => array(
                'transaction_fee_percentage' => __('Transaction Fee %', 'yoursite'),
                'transaction_fee_fixed' => __('Fixed Fee per Transaction', 'yoursite'),
            )
        ),
        'ecommerce_website' => array(
            'title' => __('Ecommerce Website', 'yoursite'),
            'description' => __('Website and store features', 'yoursite'),
            'icon' => '🛒',
            'fields' => array(
                'add_store_existing_website' => __('Add store to existing website', 'yoursite'),
                'sell_multiple_sites' => __('Sell on multiple sites', 'yoursite'),
                'instant_site_builder' => __('Instant Site builder', 'yoursite'),
                'site_templates_count' => __('Site templates', 'yoursite'),
                'additional_pages_count' => __('Additional pages', 'yoursite'),
            )
        ),
        'domains' => array(
            'title' => __('Domains', 'yoursite'),
            'description' => __('Domain and URL features', 'yoursite'),
            'icon' => '🌐',
            'fields' => array(
                'free_subdomain' => __('Free subdomain', 'yoursite'),
                'connect_existing_domain' => __('Connect existing domain', 'yoursite'),
                'buy_custom_domain' => __('Buy custom domain', 'yoursite'),
                'custom_url_slugs' => __('Custom URL slugs', 'yoursite'),
            )
        ),
        'sales_channels' => array(
            'title' => __('Sales Channels', 'yoursite'),
            'description' => __('Additional selling platforms', 'yoursite'),
            'icon' => '📱',
            'fields' => array(
                'linkup_bio_page' => __('Link-in-bio page', 'yoursite'),
                'facebook_shop' => __('Facebook shop', 'yoursite'),
                'instagram_store' => __('Instagram store', 'yoursite'),
                'mobile_pos' => __('Mobile POS', 'yoursite'),
                'marketplace_selling' => __('Marketplace selling', 'yoursite'),
            )
        ),
        'support_analytics' => array(
            'title' => __('Support & Analytics', 'yoursite'),
            'description' => __('Customer support and analytics', 'yoursite'),
            'icon' => '📊',
            'fields' => array(
                'support_type' => __('Support Type', 'yoursite'),
                'analytics_level' => __('Analytics Level', 'yoursite'),
                'reporting_features' => __('Reporting Features', 'yoursite'),
                'api_access' => __('API Access', 'yoursite'),
            )
        ),
        'storage_limits' => array(
            'title' => __('Limits & Storage', 'yoursite'),
            'description' => __('Product and storage limitations', 'yoursite'),
            'icon' => '💾',
            'fields' => array(
                'product_limit' => __('Product Limit', 'yoursite'),
                'storage_limit' => __('Storage Space', 'yoursite'),
                'bandwidth_limit' => __('Bandwidth', 'yoursite'),
                'user_accounts' => __('Staff Accounts', 'yoursite'),
            )
        )
    );
}

/**
 * Render the pricing comparison table
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
        
        <!-- Billing Toggle (Sticky Header) -->
        <div class="comparison-header sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 z-40 p-6">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    <?php _e('Compare Plans & Features', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php _e('Choose the perfect plan with all the features you need', 'yoursite'); ?>
                </p>
            </div>
            
            <!-- Billing Period Toggle -->
            <div class="flex items-center justify-center mb-4">
                <span class="text-gray-700 dark:text-gray-300 mr-4 font-medium comparison-monthly-label">
                    <?php _e('Monthly', 'yoursite'); ?>
                </span>
                <div class="relative">
                    <input type="checkbox" id="comparison-billing-toggle" class="sr-only peer">
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
                            
                            // Calculate annual monthly equivalent if not set
                            if ($annual_price == 0 && $monthly_price > 0) {
                                $annual_price = $monthly_price * 12 * 0.8; // 20% discount
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
                                    <div class="monthly-pricing">
                                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                            <?php echo $currency_symbol . number_format($monthly_price, 0); ?>
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-400 text-sm">
                                            /<?php _e('month', 'yoursite'); ?>
                                        </span>
                                    </div>
                                    
                                    <div class="annual-pricing hidden">
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
                        <?php foreach ($category['fields'] as $field_key => $field_label) : ?>
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="p-4 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        <?php echo esc_html($field_label); ?>
                                    </span>
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
    
    <?php
    return ob_get_clean();
}

/**
 * Format feature value for display - FIXED VERSION
 */
function yoursite_format_feature_value($value) {
    if (empty($value)) {
        return '<span class="text-gray-400 dark:text-gray-600">—</span>';
    }
    
    // Handle common values
    $value = trim($value);
    $lower_value = strtolower($value);
    
    // Check marks and crosses
    if (in_array($value, ['✓', '✔', 'yes', 'included', 'true'])) {
        return '<span class="text-green-500 dark:text-green-400 text-xl">✓</span>';
    }
    
    if (in_array($value, ['✗', '✘', 'no', 'not included', 'false'])) {
        return '<span class="text-red-500 dark:text-red-400 text-xl">✗</span>';
    }
    
    // Numeric values with highlighting
    if (is_numeric($value)) {
        return '<span class="font-semibold text-gray-900 dark:text-white">' . esc_html($value) . '</span>';
    }
    
    // Special formatting for common patterns
    if (strpos($lower_value, 'unlimited') !== false || strpos($lower_value, 'no limit') !== false) {
        return '<span class="font-semibold text-blue-600 dark:text-blue-400">' . esc_html($value) . '</span>';
    }
    
    if (strpos($lower_value, 'premium') !== false || strpos($lower_value, 'advanced') !== false) {
        return '<span class="font-semibold text-purple-600 dark:text-purple-400">' . esc_html($value) . '</span>';
    }
    
    // Check for currency symbols and percentages
    if (strpos($value, '%') !== false || strpos($value, '$') !== false || strpos($value, 'EUR') !== false || strpos($value, 'USD') !== false) {
        return '<span class="font-semibold text-gray-900 dark:text-white">' . esc_html($value) . '</span>';
    }
    
    // Default formatting
    return '<span class="text-gray-700 dark:text-gray-300">' . esc_html($value) . '</span>';
}

/**
 * Get currency symbol - FIXED VERSION
 */
function yoursite_get_currency_symbol($currency_code) {
    $symbols = array(
        'USD' => '$',
        'EUR' => '&euro;',
        'GBP' => '&pound;',
        'CAD' => 'C$',
        'AUD' => 'A$'
    );
    
    return isset($symbols[$currency_code]) ? $symbols[$currency_code] : '$';
}

/**
 * Enqueue comparison table styles and scripts
 */
function yoursite_enqueue_comparison_table_assets() {
    if (is_page_template('page-pricing.php') || is_singular('pricing')) {
        wp_add_inline_style('theme-style', yoursite_get_comparison_table_css());
        wp_add_inline_script('theme-script', yoursite_get_comparison_table_js());
    }
}
add_action('wp_enqueue_scripts', 'yoursite_enqueue_comparison_table_assets');

/**
 * CSS for comparison table
 */
function yoursite_get_comparison_table_css() {
    return '
    /* Pricing Comparison Table Styles */
    .pricing-comparison-wrapper {
        position: relative;
        max-width: 100%;
        margin: 2rem 0;
    }
    
    .comparison-header {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .comparison-table-container {
        max-height: 70vh;
        overflow-y: auto;
        border-radius: 0 0 12px 12px;
    }
    
    .comparison-table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .comparison-table th,
    .comparison-table td {
        position: relative;
        vertical-align: middle;
    }
    
    .comparison-table th:first-child,
    .comparison-table td:first-child {
        position: sticky;
        left: 0;
        z-index: 20;
        min-width: 250px;
        max-width: 250px;
    }
    
    .comparison-table thead th {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    /* Billing toggle active states */
    .comparison-yearly-active .comparison-monthly-label {
        color: #9ca3af;
    }
    
    .comparison-yearly-active .comparison-yearly-label {
        color: #3b82f6;
        font-weight: 600;
    }
    
    .pricing-comparison-wrapper:not(.comparison-yearly-active) .comparison-monthly-label {
        color: #3b82f6;
        font-weight: 600;
    }
    
    .pricing-comparison-wrapper:not(.comparison-yearly-active) .comparison-yearly-label {
        color: #9ca3af;
    }
    
    /* Price display toggle */
    .comparison-yearly-active .monthly-pricing {
        display: none !important;
    }
    
    .comparison-yearly-active .annual-pricing {
        display: block !important;
    }
    
    /* Dark mode specific adjustments */
    .dark .comparison-yearly-active .comparison-monthly-label {
        color: #6b7280;
    }
    
    .dark .comparison-yearly-active .comparison-yearly-label {
        color: #60a5fa;
        font-weight: 600;
    }
    
    .dark .pricing-comparison-wrapper:not(.comparison-yearly-active) .comparison-monthly-label {
        color: #60a5fa;
        font-weight: 600;
    }
    
    .dark .pricing-comparison-wrapper:not(.comparison-yearly-active) .comparison-yearly-label {
        color: #6b7280;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .comparison-header {
            position: relative !important;
            top: auto !important;
        }
        
        .comparison-table thead {
            position: relative !important;
            top: auto !important;
        }
        
        .comparison-table-container {
            max-height: none;
        }
        
        .comparison-table th:first-child,
        .comparison-table td:first-child {
            min-width: 200px;
            max-width: 200px;
        }
    }
    
    @media (max-width: 768px) {
        .comparison-table th:first-child,
        .comparison-table td:first-child {
            min-width: 180px;
            max-width: 180px;
            font-size: 14px;
        }
        
        .comparison-table th,
        .comparison-table td {
            padding: 8px 12px;
            font-size: 14px;
        }
        
        .comparison-header {
            padding: 16px;
        }
    }
    
    /* Feature value styling */
    .feature-value-check {
        color: #10b981;
        font-size: 1.25rem;
    }
    
    .feature-value-cross {
        color: #ef4444;
        font-size: 1.25rem;
    }
    
    .feature-value-highlight {
        font-weight: 600;
        color: #1f2937;
    }
    
    .dark .feature-value-highlight {
        color: #f9fafb;
    }
    
    /* Smooth scrolling for mobile */
    .comparison-table-container {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Loading state */
    .comparison-table-loading {
        opacity: 0.7;
        pointer-events: none;
    }
    
    .comparison-table-loading::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        border-top: 2px solid #3b82f6;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    ';
}

/**
 * JavaScript for comparison table
 */
function yoursite_get_comparison_table_js() {
    return '
    document.addEventListener("DOMContentLoaded", function() {
        const comparisonToggle = document.getElementById("comparison-billing-toggle");
        const comparisonWrapper = document.querySelector(".pricing-comparison-wrapper");
        
        if (comparisonToggle && comparisonWrapper) {
            comparisonToggle.addEventListener("change", function() {
                if (this.checked) {
                    comparisonWrapper.classList.add("comparison-yearly-active");
                } else {
                    comparisonWrapper.classList.remove("comparison-yearly-active");
                }
            });
        }
        
        // Sync with main pricing toggle if it exists
        const mainPricingToggle = document.getElementById("billing-toggle");
        if (mainPricingToggle && comparisonToggle) {
            mainPricingToggle.addEventListener("change", function() {
                comparisonToggle.checked = this.checked;
                if (this.checked) {
                    comparisonWrapper.classList.add("comparison-yearly-active");
                } else {
                    comparisonWrapper.classList.remove("comparison-yearly-active");
                }
            });
            
            comparisonToggle.addEventListener("change", function() {
                mainPricingToggle.checked = this.checked;
                const pricingPage = document.querySelector(".pricing-page");
                if (pricingPage) {
                    if (this.checked) {
                        pricingPage.classList.add("yearly-active");
                    } else {
                        pricingPage.classList.remove("yearly-active");
                    }
                }
            });
        }
        
        // Smooth scroll to comparison table when clicking compare buttons
        const compareButtons = document.querySelectorAll("[data-scroll-to-comparison]");
        compareButtons.forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                const comparisonTable = document.querySelector(".pricing-comparison-wrapper");
                if (comparisonTable) {
                    comparisonTable.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                }
            });
        });
        
        // Add scroll indicator for mobile
        const tableContainer = document.querySelector(".comparison-table-container");
        if (tableContainer && window.innerWidth <= 768) {
            const scrollIndicator = document.createElement("div");
            scrollIndicator.className = "scroll-indicator";
            scrollIndicator.innerHTML = "← Scroll to see all features →";
            scrollIndicator.style.cssText = `
                position: sticky;
                top: 0;
                background: #f59e0b;
                color: white;
                text-align: center;
                padding: 8px;
                font-size: 12px;
                font-weight: 600;
                z-index: 50;
            `;
            
            tableContainer.insertBefore(scrollIndicator, tableContainer.firstChild);
            
            // Hide indicator after first scroll
            tableContainer.addEventListener("scroll", function() {
                if (this.scrollLeft > 50) {
                    scrollIndicator.style.display = "none";
                }
            }, { once: true });
        }
    });
    ';
}
?>
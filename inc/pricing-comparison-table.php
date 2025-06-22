<?php
/**
 * Enhanced Pricing Comparison Table Component with Complete Feature Set
 * File: inc/pricing-comparison-table.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the pricing comparison table with enhanced UI
 */
function yoursite_render_pricing_comparison_table() {
    $plans = yoursite_get_pricing_plans_for_comparison();
    $categories = yoursite_get_comparison_feature_categories(); // This function is defined in pricing-meta-boxes.php
    
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
        <div class="comparison-table-container overflow-x-auto relative">
            <table class="comparison-table w-full min-w-[800px]">
                
                <!-- Plan Headers (Sticky) -->
                <thead class="comparison-sticky-header bg-white dark:bg-gray-800 z-30 border-b border-gray-200 dark:border-gray-700">
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
                            <th class="text-center p-4 border-r border-gray-200 dark:border-gray-700 relative <?php echo $is_featured ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-gray-800'; ?>">
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
                                   class="<?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?> text-sm px-4 py-2 rounded-lg font-semibold inline-block transition-all duration-200 hover:transform hover:-translate-y-1">
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
    
    <!-- Enhanced Tooltip Styles and JavaScript -->
    <style>
    .feature-tooltip {
        position: fixed;
        z-index: 9999;
        background: #ffffff;
        color: #1f2937;
        padding: 12px 16px;
        border-radius: 8px;
        max-width: 320px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.05);
        font-size: 14px;
        line-height: 1.5;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.2s ease;
        pointer-events: none;
        border: 1px solid #e5e7eb;
    }
    
    .feature-tooltip.show {
        opacity: 1;
        transform: translateY(0);
    }
    
    .feature-tooltip::before {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 6px solid transparent;
        border-top-color: #ffffff;
    }
    
    .feature-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: #e5e7eb;
        margin-top: 1px;
    }
    
    .feature-label {
        cursor: help;
        position: relative;
    }
    
    .feature-label:hover svg {
        color: #3b82f6;
        transform: scale(1.1);
        transition: all 0.2s ease;
    }
    
    /* Dark mode tooltip styling */
    .dark .feature-tooltip {
        background: #1f2937;
        color: #f9fafb;
        border: 1px solid #374151;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.05);
    }
    
    .dark .feature-tooltip::before {
        border-top-color: #1f2937;
    }
    
    .dark .feature-tooltip::after {
        border-top-color: #374151;
    }
    
    /* Sticky table header - natural page flow */
    .comparison-sticky-header {
        position: sticky;
        top: 0;
        z-index: 100;
        background: white;
        transition: all 0.3s ease;
    }
    
    .dark .comparison-sticky-header {
        background: #1f2937;
    }
    
    /* Remove scrolling container constraints */
    .comparison-table-container {
        position: relative;
        /* Remove max-height and overflow-y constraints */
        border-radius: 12px;
    }
    
    /* Smooth scrolling for webkit browsers */
    .comparison-table-container {
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }
    
    /* Enhanced sticky header when it becomes fixed */
    .comparison-sticky-header.is-sticky {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.95);
    }
    
    .dark .comparison-sticky-header.is-sticky {
        background: rgba(31, 41, 55, 0.95);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    }
    
    /* Ensure table flows naturally */
    .comparison-table {
        display: table;
        width: 100%;
        border-collapse: collapse;
    }
    
    /* Make sure the thead doesn't create a separate scrolling context */
    .comparison-table thead {
        display: table-header-group;
    }
    
    .comparison-table tbody {
        display: table-row-group;
    }
    
    /* Better responsive handling */
    @media (max-width: 1024px) {
        .comparison-table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .comparison-sticky-header th {
            padding: 8px 4px;
            font-size: 14px;
        }
        
        .comparison-sticky-header.is-sticky {
            position: sticky; /* Use sticky instead of fixed on mobile */
            top: 0;
            left: auto;
            right: auto;
        }
    }
    
    /* Smooth transitions for sticky state */
    .comparison-sticky-header {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Hide/show animation for end of table */
    .comparison-sticky-header.fade-out {
        opacity: 0;
        transform: translateY(-100%);
        pointer-events: none;
    }
    
    /* Billing toggle animation */
    .comparison-header input[type="checkbox"]:checked + label span {
        transform: translateX(32px);
    }
    
    /* Price display animations */
    .price-display .monthly-pricing,
    .price-display .annual-pricing {
        transition: all 0.3s ease;
    }
    
    /* Default state: show annual pricing (yearly default) */
    .monthly-pricing {
        display: none !important;
    }
    
    .annual-pricing {
        display: block !important;
    }
    
    /* When monthly is active */
    .comparison-monthly-active .monthly-pricing {
        display: block !important;
    }
    
    .comparison-monthly-active .annual-pricing {
        display: none !important;
    }
    
    /* When yearly is active (default) */
    .comparison-yearly-active .monthly-pricing {
        display: none !important;
    }
    
    .comparison-yearly-active .annual-pricing {
        display: block !important;
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltip system
        const tooltip = document.getElementById('feature-tooltip');
        const tooltipText = tooltip.querySelector('.tooltip-text');
        const featureLabels = document.querySelectorAll('.feature-label[data-tooltip]');
        
        featureLabels.forEach(label => {
            label.addEventListener('mouseenter', function(e) {
                const tooltipContent = this.getAttribute('data-tooltip');
                if (tooltipContent) {
                    tooltipText.textContent = tooltipContent;
                    tooltip.classList.remove('hidden');
                    
                    setTimeout(() => {
                        tooltip.classList.add('show');
                    }, 10);
                    
                    updateTooltipPosition(e, tooltip);
                }
            });
            
            label.addEventListener('mouseleave', function() {
                tooltip.classList.remove('show');
                setTimeout(() => {
                    tooltip.classList.add('hidden');
                }, 200);
            });
            
            label.addEventListener('mousemove', function(e) {
                if (!tooltip.classList.contains('hidden')) {
                    updateTooltipPosition(e, tooltip);
                }
            });
        });
        
        function updateTooltipPosition(e, tooltip) {
            const rect = tooltip.getBoundingClientRect();
            const x = e.clientX;
            const y = e.clientY;
            
            let left = x - rect.width / 2;
            let top = y - rect.height - 10;
            
            // Keep tooltip within viewport
            if (left < 10) left = 10;
            if (left + rect.width > window.innerWidth - 10) {
                left = window.innerWidth - rect.width - 10;
            }
            if (top < 10) top = y + 10;
            
            tooltip.style.left = left + 'px';
            tooltip.style.top = top + 'px';
        }
        
        // Initialize billing toggle functionality
        const comparisonToggle = document.getElementById('comparison-billing-toggle');
        const comparisonWrapper = document.querySelector('.pricing-comparison-wrapper');
        const comparisonMonthlyLabel = document.querySelector('.comparison-monthly-label');
        const comparisonYearlyLabel = document.querySelector('.comparison-yearly-label');
        
        // Function to update comparison table display
        function updateComparisonDisplay(isYearly) {
            if (!comparisonWrapper) return;
            
            if (isYearly) {
                comparisonWrapper.classList.add('comparison-yearly-active');
                comparisonWrapper.classList.remove('comparison-monthly-active');
                // Update label styles
                if (comparisonYearlyLabel) {
                    comparisonYearlyLabel.style.color = '#3b82f6';
                    comparisonYearlyLabel.style.fontWeight = '600';
                }
                if (comparisonMonthlyLabel) {
                    comparisonMonthlyLabel.style.color = '#9ca3af';
                    comparisonMonthlyLabel.style.fontWeight = '400';
                }
            } else {
                comparisonWrapper.classList.remove('comparison-yearly-active');
                comparisonWrapper.classList.add('comparison-monthly-active');
                // Update label styles
                if (comparisonMonthlyLabel) {
                    comparisonMonthlyLabel.style.color = '#3b82f6';
                    comparisonMonthlyLabel.style.fontWeight = '600';
                }
                if (comparisonYearlyLabel) {
                    comparisonYearlyLabel.style.color = '#9ca3af';
                    comparisonYearlyLabel.style.fontWeight = '400';
                }
            }
        }
        
        // Set initial state to yearly (default)
        if (comparisonToggle && comparisonWrapper) {
            comparisonToggle.checked = true;
            updateComparisonDisplay(true);
            
            comparisonToggle.addEventListener('change', function() {
                const isYearly = this.checked;
                updateComparisonDisplay(isYearly);
                
                // Sync with main pricing toggle if exists
                const mainToggle = document.getElementById('billing-toggle');
                if (mainToggle && mainToggle !== this) {
                    mainToggle.checked = isYearly;
                    // Trigger change event for main toggle
                    const event = new Event('change', { bubbles: true });
                    mainToggle.dispatchEvent(event);
                }
            });
        }
        
        // Listen for changes from main pricing toggle
        const mainToggle = document.getElementById('billing-toggle');
        if (mainToggle && comparisonToggle && mainToggle !== comparisonToggle) {
            mainToggle.addEventListener('change', function() {
                const isYearly = this.checked;
                comparisonToggle.checked = isYearly;
                updateComparisonDisplay(isYearly);
            });
        }
        
        // Add smooth scrolling enhancement
        function addScrollIndicator() {
            const scrollIndicator = document.createElement('div');
            scrollIndicator.className = 'scroll-indicator';
            scrollIndicator.innerHTML = '← Scroll to see more features →';
            scrollIndicator.style.cssText = `
                position: sticky;
                left: 0;
                top: 0;
                background: linear-gradient(90deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));
                color: #3b82f6;
                text-align: center;
                padding: 8px;
                font-size: 12px;
                font-weight: 600;
                border-bottom: 1px solid #e5e7eb;
                z-index: 20;
            `;
            
            const tableContainer = document.querySelector('.comparison-table-container');
            if (tableContainer && tableContainer.scrollWidth > tableContainer.clientWidth) {
                tableContainer.prepend(scrollIndicator);
                
                tableContainer.addEventListener('scroll', function() {
                    const scrollPercentage = this.scrollLeft / (this.scrollWidth - this.clientWidth);
                    if (scrollPercentage > 0.9) {
                        scrollIndicator.style.display = 'none';
                    } else {
                        scrollIndicator.style.display = 'block';
                    }
                });
            }
        }
        
        // Enhanced sticky header management
        const tableContainer = document.querySelector('.comparison-table-container');
        const stickyHeader = document.querySelector('.comparison-sticky-header');
        const comparisonSection = document.querySelector('.pricing-comparison-wrapper');
        
        if (tableContainer && stickyHeader && comparisonSection) {
            let isSticky = false;
            
            function handleStickyHeader() {
                const sectionRect = comparisonSection.getBoundingClientRect();
                const containerRect = tableContainer.getBoundingClientRect();
                
                // Check if the comparison section is visible and being scrolled
                const shouldBeSticky = sectionRect.top <= 0 && sectionRect.bottom > 0;
                
                if (shouldBeSticky && !isSticky) {
                    isSticky = true;
                    stickyHeader.style.position = 'fixed';
                    stickyHeader.style.top = '0px';
                    stickyHeader.style.left = containerRect.left + 'px';
                    stickyHeader.style.width = containerRect.width + 'px';
                    stickyHeader.style.zIndex = '999';
                    stickyHeader.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                } else if (!shouldBeSticky && isSticky) {
                    isSticky = false;
                    stickyHeader.style.position = 'sticky';
                    stickyHeader.style.top = '0';
                    stickyHeader.style.left = 'auto';
                    stickyHeader.style.width = 'auto';
                    stickyHeader.style.zIndex = '100';
                    stickyHeader.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
                }
                
                // Hide sticky header when reaching the bottom of the table
                const tableBottom = comparisonSection.getBoundingClientRect().bottom;
                if (tableBottom <= window.innerHeight * 0.2) {
                    if (isSticky) {
                        stickyHeader.style.opacity = '0';
                        stickyHeader.style.transform = 'translateY(-100%)';
                    }
                } else if (isSticky) {
                    stickyHeader.style.opacity = '1';
                    stickyHeader.style.transform = 'translateY(0)';
                }
            }
            
            // Throttled scroll handler for performance
            let ticking = false;
            function handleScroll() {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        handleStickyHeader();
                        ticking = false;
                    });
                    ticking = true;
                }
            }
            
            // Handle window resize
            function handleResize() {
                if (isSticky) {
                    const containerRect = tableContainer.getBoundingClientRect();
                    stickyHeader.style.left = containerRect.left + 'px';
                    stickyHeader.style.width = containerRect.width + 'px';
                }
            }
            
            window.addEventListener('scroll', handleScroll);
            window.addEventListener('resize', handleResize);
            
            // Initial check
            handleStickyHeader();
        // Add scroll indicator on mobile
        if (window.innerWidth < 1024) {
            addScrollIndicator();
        }
    });
    </script>
    
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
    
    // Fee display
    if (strpos($lower_value, 'fee') !== false) {
        return '<span class="font-semibold text-orange-600 dark:text-orange-400">' . esc_html($value) . '</span>';
    }
    
    // Numeric values
    if (is_numeric($value)) {
        return '<span class="font-semibold text-gray-900 dark:text-white">' . number_format($value) . '</span>';
    }
    
    // Special values
    if (strpos($lower_value, 'unlimited') !== false) {
        return '<span class="font-semibold text-blue-600 dark:text-blue-400">∞ Unlimited</span>';
    }
    
    if (strpos($lower_value, 'custom') !== false || strpos($lower_value, 'enterprise') !== false) {
        return '<span class="font-semibold text-purple-600 dark:text-purple-400">' . esc_html($value) . '</span>';
    }
    
    // Storage sizes
    if (preg_match('/(\d+)\s*(mb|gb|tb)/i', $value, $matches)) {
        $size = $matches[1];
        $unit = strtoupper($matches[2]);
        return '<span class="font-semibold text-blue-600 dark:text-blue-400">' . $size . ' ' . $unit . '</span>';
    }
    
    // Language counts
    if (preg_match('/^(\d+)$/', $value) && $value <= 50) {
        return '<span class="font-semibold text-indigo-600 dark:text-indigo-400">' . $value . ' languages</span>';
    }
    
    // Default
    return '<span class="text-gray-700 dark:text-gray-300">' . esc_html($value) . '</span>';
}
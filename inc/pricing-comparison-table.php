<?php
/**
 * Enhanced Pricing Comparison Table Component with Dynamic Currency Support
 * File: inc/pricing-comparison-table.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the pricing comparison table with enhanced UI and dynamic currency support
 */
function yoursite_render_pricing_comparison_table() {
    $plans = yoursite_get_pricing_plans_for_comparison();
    $categories = yoursite_get_comparison_feature_categories(); // This function is defined in pricing-meta-boxes.php
    
    // Get current user currency
    $current_currency = yoursite_get_user_currency();
    
    if (empty($plans)) {
        return '<p class="text-center text-gray-500 dark:text-gray-400 py-8">' . __('No pricing plans available.', 'yoursite') . '</p>';
    }
    
    ob_start();
    ?>
    
    <div class="pricing-comparison-wrapper bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        
        <!-- Streamlined Header with Currency Selector -->
        <div class="comparison-header sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 z-40 p-6">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    <?php _e('See What\'s Included in Each Plan', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php _e('Every feature designed to help your business grow', 'yoursite'); ?>
                </p>
            </div>
            
            <!-- Currency Selector and Billing Toggle Container -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 mb-4">
                
                <!-- Currency Selector (if available) -->
                <?php if (function_exists('yoursite_should_display_currency_selector') && yoursite_should_display_currency_selector()) : ?>
                <div class="flex items-center gap-3">
                    <span class="text-gray-600 dark:text-gray-400 font-medium">
                        <?php _e('Currency:', 'yoursite'); ?>
                    </span>
                    <?php 
                    echo yoursite_render_currency_selector(array(
                        'style' => 'dropdown',
                        'show_flag' => true,
                        'show_name' => false,
                        'show_symbol' => true,
                        'class' => 'comparison-currency-selector'
                    )); 
                    ?>
                </div>
                <?php endif; ?>
                
                <!-- Billing Period Toggle - Annual Default -->
                <div class="flex items-center justify-center">
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
                            
                            // Get pricing in current currency
                            $monthly_price = function_exists('yoursite_get_pricing_plan_price') 
                                ? yoursite_get_pricing_plan_price($plan->ID, $current_currency['code'], 'monthly')
                                : floatval($meta['pricing_monthly_price']);
                            
                            $annual_price = function_exists('yoursite_get_pricing_plan_price') 
                                ? yoursite_get_pricing_plan_price($plan->ID, $current_currency['code'], 'annual')
                                : floatval($meta['pricing_annual_price']);
                            
                            if ($annual_price == 0 && $monthly_price > 0) {
                                $annual_price = $monthly_price * 12 * 0.8;
                            }
                            $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
                            
                            // Calculate savings
                            $savings = function_exists('yoursite_calculate_annual_savings') 
                                ? yoursite_calculate_annual_savings($plan->ID, $current_currency['code'])
                                : ($monthly_price * 12) - $annual_price;
                            ?>
                            <th class="text-center p-4 border-r border-gray-200 dark:border-gray-700 relative <?php echo $is_featured ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-gray-800'; ?>"
                                data-plan-id="<?php echo esc_attr($plan->ID); ?>">
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
                                            <span class="price-amount" data-price-type="monthly">
                                                <?php 
                                                if (function_exists('yoursite_format_currency')) {
                                                    echo yoursite_format_currency($monthly_price, $current_currency['code']);
                                                } else {
                                                    echo $current_currency['symbol'] . number_format($monthly_price, 0);
                                                }
                                                ?>
                                            </span>
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-400 text-sm">
                                            /<?php _e('month', 'yoursite'); ?>
                                        </span>
                                    </div>
                                    
                                    <div class="annual-pricing">
                                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                            <span class="price-amount" data-price-type="annual-monthly">
                                                <?php 
                                                if (function_exists('yoursite_format_currency')) {
                                                    echo yoursite_format_currency($annual_monthly, $current_currency['code']);
                                                } else {
                                                    echo $current_currency['symbol'] . number_format($annual_monthly, 0);
                                                }
                                                ?>
                                            </span>
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-400 text-sm">
                                            /<?php _e('month', 'yoursite'); ?>
                                        </span>
                                        <div class="text-xs text-green-600 dark:text-green-400 mt-1">
                                            <?php printf(__('Billed annually (%s)', 'yoursite'), '<span data-price-type="annual">' . (function_exists('yoursite_format_currency') ? yoursite_format_currency($annual_price, $current_currency['code']) : $current_currency['symbol'] . number_format($annual_price, 0)) . '</span>'); ?>
                                        </div>
                                        <?php if ($savings > 0) : ?>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Save <span data-savings-amount class="ml-1">
                                                    <?php 
                                                    if (function_exists('yoursite_format_currency')) {
                                                        echo yoursite_format_currency($savings, $current_currency['code']);
                                                    } else {
                                                        echo $current_currency['symbol'] . number_format($savings, 0);
                                                    }
                                                    ?>
                                                </span>/year
                                            </span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>" 
                                   class="<?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?> text-sm px-4 py-2 rounded-lg font-semibold inline-block transition-all duration-200 hover:transform hover:-translate-y-1 comparison-cta-button"
                                   data-monthly-url="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>"
                                   data-annual-url="<?php echo esc_url(str_replace('monthly', 'annual', $meta['pricing_button_url'] ?: '#')); ?>">
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
            position: sticky;
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
    
    /* Loading state for currency updates */
    .comparison-updating {
        position: relative;
        transition: opacity 0.3s ease;
    }

    .comparison-updating::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 40px;
        height: 40px;
        margin: -20px 0 0 -20px;
        border: 4px solid rgba(59, 130, 246, 0.2);
        border-top-color: #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 10;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .price-amount {
        transition: all 0.2s ease;
    }

    /* Currency change notification */
    .currency-change-notification {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Mobile responsive enhancements */
    @media (max-width: 640px) {
        .currency-change-notification {
            left: 1rem;
            right: 1rem;
            top: 1rem;
            transform: translateY(-100%);
        }
        
        .currency-change-notification.translate-x-0 {
            transform: translateY(0);
        }
        
        .currency-change-notification.translate-x-full {
            transform: translateY(-100%);
        }
    }

    /* Dark mode support for notifications */
    @media (prefers-color-scheme: dark) {
        .currency-change-notification {
            background-color: #10b981;
        }
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuration constants
        const CONFIG = {
            TOOLTIP_DELAY: 10,
            TOOLTIP_HIDE_DELAY: 200,
            TOOLTIP_MARGIN: 10,
            SCROLL_THROTTLE_DELAY: 16, // ~60fps
            STICKY_HEADER_OPACITY_THRESHOLD: 0.2
        };

        // Utility functions
        const utils = {
            throttle(func, delay) {
                let timeoutId;
                let lastExecTime = 0;
                return function (...args) {
                    const currentTime = Date.now();
                    if (currentTime - lastExecTime > delay) {
                        func.apply(this, args);
                        lastExecTime = currentTime;
                    } else {
                        clearTimeout(timeoutId);
                        timeoutId = setTimeout(() => {
                            func.apply(this, args);
                            lastExecTime = Date.now();
                        }, delay - (currentTime - lastExecTime));
                    }
                };
            },

            debounce(func, delay) {
                let timeoutId;
                return function (...args) {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => func.apply(this, args), delay);
                };
            },

            safeQuerySelector(selector) {
                try {
                    return document.querySelector(selector);
                } catch (error) {
                    console.warn(`Invalid selector: ${selector}`, error);
                    return null;
                }
            },

            safeQuerySelectorAll(selector) {
                try {
                    return document.querySelectorAll(selector);
                } catch (error) {
                    console.warn(`Invalid selector: ${selector}`, error);
                    return [];
                }
            }
        };

        // Tooltip system
        const TooltipManager = {
            init() {
                this.tooltip = utils.safeQuerySelector('#feature-tooltip');
                this.tooltipText = this.tooltip?.querySelector('.tooltip-text');
                this.featureLabels = utils.safeQuerySelectorAll('.feature-label[data-tooltip]');
                
                if (!this.tooltip || !this.tooltipText || !this.featureLabels.length) {
                    console.warn('Tooltip elements not found');
                    return;
                }

                this.bindEvents();
            },

            bindEvents() {
                this.featureLabels.forEach(label => {
                    label.addEventListener('mouseenter', this.handleMouseEnter.bind(this));
                    label.addEventListener('mouseleave', this.handleMouseLeave.bind(this));
                    label.addEventListener('mousemove', this.handleMouseMove.bind(this));
                });
            },

            handleMouseEnter(e) {
                const tooltipContent = e.currentTarget.getAttribute('data-tooltip');
                if (!tooltipContent) return;

                this.tooltipText.textContent = tooltipContent;
                this.tooltip.classList.remove('hidden');
                
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        this.tooltip.classList.add('show');
                    }, CONFIG.TOOLTIP_DELAY);
                });
                
                this.updateTooltipPosition(e);
            },

            handleMouseLeave() {
                this.tooltip.classList.remove('show');
                setTimeout(() => {
                    if (!this.tooltip.classList.contains('show')) {
                        this.tooltip.classList.add('hidden');
                    }
                }, CONFIG.TOOLTIP_HIDE_DELAY);
            },

            handleMouseMove(e) {
                if (!this.tooltip.classList.contains('hidden')) {
                    this.updateTooltipPosition(e);
                }
            },

            updateTooltipPosition(e) {
                const rect = this.tooltip.getBoundingClientRect();
                const { clientX: x, clientY: y } = e;
                
                let left = x - rect.width / 2;
                let top = y - rect.height - CONFIG.TOOLTIP_MARGIN;
                
                const viewportWidth = window.innerWidth;
                const viewportHeight = window.innerHeight;
                
                if (left < CONFIG.TOOLTIP_MARGIN) {
                    left = CONFIG.TOOLTIP_MARGIN;
                } else if (left + rect.width > viewportWidth - CONFIG.TOOLTIP_MARGIN) {
                    left = viewportWidth - rect.width - CONFIG.TOOLTIP_MARGIN;
                }
                
                if (top < CONFIG.TOOLTIP_MARGIN) {
                    top = y + CONFIG.TOOLTIP_MARGIN;
                }
                
                this.tooltip.style.left = `${left}px`;
                this.tooltip.style.top = `${top}px`;
            }
        };

        // Enhanced Billing toggle system with currency support
        const BillingToggleManager = {
            init() {
                this.comparisonToggle = utils.safeQuerySelector('#comparison-billing-toggle');
                this.comparisonWrapper = utils.safeQuerySelector('.pricing-comparison-wrapper');
                this.comparisonMonthlyLabel = utils.safeQuerySelector('.comparison-monthly-label');
                this.comparisonYearlyLabel = utils.safeQuerySelector('.comparison-yearly-label');
                this.mainToggle = utils.safeQuerySelector('#billing-toggle');

                if (!this.comparisonToggle || !this.comparisonWrapper) {
                    console.warn('Billing toggle elements not found');
                    return;
                }

                this.setupInitialState();
                this.bindEvents();
            },

            setupInitialState() {
                this.comparisonToggle.checked = true;
                this.updateComparisonDisplay(true);
            },

            bindEvents() {
                this.comparisonToggle.addEventListener('change', this.handleComparisonToggleChange.bind(this));
                
                if (this.mainToggle && this.mainToggle !== this.comparisonToggle) {
                    this.mainToggle.addEventListener('change', this.handleMainToggleChange.bind(this));
                }
            },

            handleComparisonToggleChange() {
                const isYearly = this.comparisonToggle.checked;
                this.updateComparisonDisplay(isYearly);
                this.syncWithMainToggle(isYearly);
                this.updateCTAButtons(isYearly);
            },

            handleMainToggleChange() {
                const isYearly = this.mainToggle.checked;
                this.comparisonToggle.checked = isYearly;
                this.updateComparisonDisplay(isYearly);
                this.updateCTAButtons(isYearly);
            },

            syncWithMainToggle(isYearly) {
                if (this.mainToggle && this.mainToggle !== this.comparisonToggle) {
                    this.mainToggle.checked = isYearly;
                    this.mainToggle.dispatchEvent(new Event('change', { bubbles: true }));
                }
            },

            updateComparisonDisplay(isYearly) {
                const yearlyClass = 'comparison-yearly-active';
                const monthlyClass = 'comparison-monthly-active';
                
                if (isYearly) {
                    this.comparisonWrapper.classList.add(yearlyClass);
                    this.comparisonWrapper.classList.remove(monthlyClass);
                    this.updateLabelStyles(true);
                } else {
                    this.comparisonWrapper.classList.remove(yearlyClass);
                    this.comparisonWrapper.classList.add(monthlyClass);
                    this.updateLabelStyles(false);
                }
            },

            updateLabelStyles(isYearly) {
                const activeStyle = { color: '#3b82f6', fontWeight: '600' };
                const inactiveStyle = { color: '#9ca3af', fontWeight: '400' };
                
                if (this.comparisonYearlyLabel) {
                    Object.assign(this.comparisonYearlyLabel.style, isYearly ? activeStyle : inactiveStyle);
                }
                
                if (this.comparisonMonthlyLabel) {
                    Object.assign(this.comparisonMonthlyLabel.style, isYearly ? inactiveStyle : activeStyle);
                }
            },

            updateCTAButtons(isYearly) {
                const ctaButtons = utils.safeQuerySelectorAll('.comparison-cta-button');
                ctaButtons.forEach(button => {
                    const newUrl = isYearly ? 
                        button.dataset.annualUrl : 
                        button.dataset.monthlyUrl;
                    
                    if (newUrl) {
                        button.href = newUrl;
                    }
                });
            }
        };

        // Enhanced Currency Manager for comparison table
        const CurrencyManager = {
            init() {
                this.comparisonWrapper = utils.safeQuerySelector('.pricing-comparison-wrapper');
                this.currencySelector = utils.safeQuerySelector('.comparison-currency-selector');
                
                if (!this.comparisonWrapper) {
                    console.warn('Comparison wrapper not found');
                    return;
                }

                this.bindEvents();
            },

            bindEvents() {
                // Listen for currency changes from main pricing section
                document.addEventListener('currencyChanged', this.handleCurrencyChange.bind(this));
                
                // Listen for currency selector changes within comparison table
                if (this.currencySelector) {
                    this.currencySelector.addEventListener('change', this.handleSelectorChange.bind(this));
                }
                
                // Listen for currency selector clicks (for dropdown style)
                document.addEventListener('click', this.handleCurrencyClick.bind(this));
            },

            handleCurrencyChange(e) {
                const newCurrency = e.detail.currency;
                this.updateComparisonPricing(newCurrency);
            },

            handleSelectorChange(e) {
                const newCurrency = e.target.value;
                this.updateComparisonPricing(newCurrency);
                this.dispatchCurrencyChangeEvent(newCurrency);
            },

            handleCurrencyClick(e) {
                const currencyItem = e.target.closest('[data-currency-code], [data-currency]');
                if (!currencyItem || !this.comparisonWrapper.contains(currencyItem)) return;
                
                const newCurrency = currencyItem.dataset.currency || currencyItem.dataset.currencyCode;
                if (newCurrency) {
                    this.updateComparisonPricing(newCurrency);
                    this.dispatchCurrencyChangeEvent(newCurrency);
                }
            },

            updateComparisonPricing(currencyCode) {
                // Show loading state
                this.comparisonWrapper.classList.add('comparison-updating');
                this.comparisonWrapper.style.opacity = '0.7';
                this.comparisonWrapper.style.pointerEvents = 'none';
                
                // Get all plan IDs from the comparison table
                const planHeaders = utils.safeQuerySelectorAll('[data-plan-id]');
                const planIds = Array.from(planHeaders).map(header => header.dataset.planId).filter(id => id);
                
                if (planIds.length > 0) {
                    // Fetch pricing for comparison table plans
                    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            action: 'get_comparison_pricing_in_currency',
                            currency: currencyCode,
                            plan_ids: planIds.join(','),
                            nonce: '<?php echo wp_create_nonce("get_comparison_pricing"); ?>'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data.pricing) {
                            this.updatePricingHeaders(data.data.pricing, data.data.currency_info);
                            this.showCurrencyChangeNotification(currencyCode);
                        } else {
                            console.error('Failed to update comparison pricing:', data.data);
                            this.updateCurrencySymbolsOnly(currencyCode);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating comparison pricing:', error);
                        this.updateCurrencySymbolsOnly(currencyCode);
                    })
                    .finally(() => {
                        // Remove loading state
                        this.comparisonWrapper.classList.remove('comparison-updating');
                        this.comparisonWrapper.style.opacity = '';
                        this.comparisonWrapper.style.pointerEvents = '';
                    });
                } else {
                    // No plans found, just remove loading state
                    this.comparisonWrapper.classList.remove('comparison-updating');
                    this.comparisonWrapper.style.opacity = '';
                    this.comparisonWrapper.style.pointerEvents = '';
                }
            },

            updatePricingHeaders(pricingData, currencyInfo) {
                Object.keys(pricingData).forEach(planId => {
                    const pricing = pricingData[planId];
                    const planHeader = utils.safeQuerySelector(`[data-plan-id="${planId}"]`);
                    
                    if (!planHeader) return;
                    
                    try {
                        // Update monthly price
                        const monthlyAmount = planHeader.querySelector('[data-price-type="monthly"]');
                        if (monthlyAmount && pricing.monthly_price_formatted) {
                            monthlyAmount.textContent = pricing.monthly_price_formatted.replace(/[^\d.,€£$¥₹₩]/g, '');
                        }
                        
                        // Update annual monthly equivalent
                        const annualMonthlyAmount = planHeader.querySelector('[data-price-type="annual-monthly"]');
                        if (annualMonthlyAmount && pricing.annual_monthly_equivalent_formatted) {
                            annualMonthlyAmount.textContent = pricing.annual_monthly_equivalent_formatted.replace(/[^\d.,€£$¥₹₩]/g, '');
                        }
                        
                        // Update annual total
                        const annualAmount = planHeader.querySelector('[data-price-type="annual"]');
                        if (annualAmount && pricing.annual_price_formatted) {
                            annualAmount.textContent = pricing.annual_price_formatted;
                        }
                        
                        // Update savings
                        const savingsAmount = planHeader.querySelector('[data-savings-amount]');
                        if (savingsAmount && pricing.savings_formatted) {
                            savingsAmount.textContent = pricing.savings_formatted;
                        }
                        
                        // Update currency symbols if they exist as separate elements
                        const currencySymbols = planHeader.querySelectorAll('.currency-symbol');
                        currencySymbols.forEach(symbol => {
                            if (currencyInfo && currencyInfo.symbol) {
                                symbol.textContent = currencyInfo.symbol;
                            }
                        });
                        
                    } catch (error) {
                        console.error('Error updating plan header pricing:', error, planId);
                    }
                });
            },

            updateCurrencySymbolsOnly(currencyCode) {
                // Fallback currency symbols
                const currencySymbols = {
                    'USD': ',
                    'EUR': '€',
                    'GBP': '£',
                    'CAD': 'C,
                    'AUD': 'A,
                    'JPY': '¥',
                    'CHF': 'CHF',
                    'SEK': 'kr',
                    'NOK': 'kr',
                    'DKK': 'kr',
                    'INR': '₹',
                    'KRW': '₩'
                };
                
                const symbol = currencySymbols[currencyCode] || ';
                
                // Update all price amounts in comparison table
                const planHeaders = utils.safeQuerySelectorAll('[data-plan-id]');
                planHeaders.forEach(header => {
                    const priceAmounts = header.querySelectorAll('.price-amount');
                    priceAmounts.forEach(amount => {
                        const currentText = amount.textContent;
                        const numericValue = currentText.replace(/[^\d]/g, '');
                        if (numericValue) {
                            amount.textContent = symbol + numericValue;
                        }
                    });
                    
                    // Update annual billing text
                    const annualTexts = header.querySelectorAll('[data-price-type="annual"]');
                    annualTexts.forEach(text => {
                        const currentText = text.textContent;
                        const numericValue = currentText.replace(/[^\d]/g, '');
                        if (numericValue) {
                            text.textContent = symbol + numericValue;
                        }
                    });
                    
                    // Update savings amounts
                    const savingsAmounts = header.querySelectorAll('[data-savings-amount]');
                    savingsAmounts.forEach(savings => {
                        const currentText = savings.textContent;
                        const numericValue = currentText.replace(/[^\d]/g, '');
                        if (numericValue) {
                            savings.textContent = symbol + numericValue;
                        }
                    });
                });
            },

            dispatchCurrencyChangeEvent(currencyCode) {
                const event = new CustomEvent('currencyChanged', {
                    detail: { currency: currencyCode },
                    bubbles: true
                });
                document.dispatchEvent(event);
            },

            showCurrencyChangeNotification(currencyCode) {
                // Remove any existing notifications
                const existingNotifications = document.querySelectorAll('.currency-change-notification');
                existingNotifications.forEach(n => n.remove());
                
                // Create notification
                const notification = document.createElement('div');
                notification.className = 'currency-change-notification fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Prices updated to ${currencyCode}</span>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Animate in
                requestAnimationFrame(() => {
                    notification.classList.remove('translate-x-full');
                    notification.classList.add('translate-x-0');
                });
                
                // Remove after 3 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }
        };

        // Scroll indicator system
        const ScrollIndicatorManager = {
            init() {
                this.tableContainer = utils.safeQuerySelector('.comparison-table-container');
                if (!this.tableContainer || !this.shouldShowScrollIndicator()) {
                    return;
                }
                
                this.addScrollIndicator();
            },

            shouldShowScrollIndicator() {
                return this.tableContainer.scrollWidth > this.tableContainer.clientWidth;
            },

            addScrollIndicator() {
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
                    transition: opacity 0.3s ease;
                `;
                
                this.tableContainer.prepend(scrollIndicator);
                this.bindScrollEvents(scrollIndicator);
            },

            bindScrollEvents(scrollIndicator) {
                const throttledScrollHandler = utils.throttle((e) => {
                    const { scrollLeft, scrollWidth, clientWidth } = e.target;
                    const scrollPercentage = scrollLeft / (scrollWidth - clientWidth);
                    
                    scrollIndicator.style.opacity = scrollPercentage > 0.9 ? '0' : '1';
                }, CONFIG.SCROLL_THROTTLE_DELAY);
                
                this.tableContainer.addEventListener('scroll', throttledScrollHandler);
            }
        };

        // Sticky header system
        const StickyHeaderManager = {
            init() {
                this.tableContainer = utils.safeQuerySelector('.comparison-table-container');
                this.stickyHeader = utils.safeQuerySelector('.comparison-sticky-header');
                this.comparisonSection = utils.safeQuerySelector('.pricing-comparison-wrapper');
                
                if (!this.tableContainer || !this.stickyHeader || !this.comparisonSection) {
                    console.warn('Sticky header elements not found');
                    return;
                }

                this.isSticky = false;
                this.bindEvents();
                this.handleStickyHeader(); // Initial check
            },

            bindEvents() {
                const throttledScrollHandler = utils.throttle(this.handleStickyHeader.bind(this), CONFIG.SCROLL_THROTTLE_DELAY);
                const debouncedResizeHandler = utils.debounce(this.handleResize.bind(this), 100);
                
                window.addEventListener('scroll', throttledScrollHandler);
                window.addEventListener('resize', debouncedResizeHandler);
            },

            handleStickyHeader() {
                const sectionRect = this.comparisonSection.getBoundingClientRect();
                const containerRect = this.tableContainer.getBoundingClientRect();
                
                const shouldBeSticky = sectionRect.top <= 0 && sectionRect.bottom > 0;
                
                if (shouldBeSticky && !this.isSticky) {
                    this.activateStickyMode(containerRect);
                } else if (!shouldBeSticky && this.isSticky) {
                    this.deactivateStickyMode();
                }
                
                this.handleStickyHeaderVisibility(sectionRect);
            },

            activateStickyMode(containerRect) {
                this.isSticky = true;
                Object.assign(this.stickyHeader.style, {
                    position: 'fixed',
                    top: '0px',
                    left: `${containerRect.left}px`,
                    width: `${containerRect.width}px`,
                    zIndex: '999',
                    boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
                    transition: 'opacity 0.3s ease, transform 0.3s ease'
                });
            },

            deactivateStickyMode() {
                this.isSticky = false;
                Object.assign(this.stickyHeader.style, {
                    position: 'sticky',
                    top: '0',
                    left: 'auto',
                    width: 'auto',
                    zIndex: '100',
                    boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
                    opacity: '1',
                    transform: 'translateY(0)'
                });
            },

            handleStickyHeaderVisibility(sectionRect) {
                if (!this.isSticky) return;
                
                const tableBottom = sectionRect.bottom;
                const threshold = window.innerHeight * CONFIG.STICKY_HEADER_OPACITY_THRESHOLD;
                
                if (tableBottom <= threshold) {
                    this.stickyHeader.style.opacity = '0';
                    this.stickyHeader.style.transform = 'translateY(-100%)';
                } else {
                    this.stickyHeader.style.opacity = '1';
                    this.stickyHeader.style.transform = 'translateY(0)';
                }
            },

            handleResize() {
                if (this.isSticky) {
                    const containerRect = this.tableContainer.getBoundingClientRect();
                    this.stickyHeader.style.left = `${containerRect.left}px`;
                    this.stickyHeader.style.width = `${containerRect.width}px`;
                }
            }
        };

        // Initialize all systems
        const initializeSystems = () => {
            try {
                TooltipManager.init();
                BillingToggleManager.init();
                CurrencyManager.init();
                StickyHeaderManager.init();
                
                // Add scroll indicator on mobile devices
                if (window.innerWidth < 1024) {
                    ScrollIndicatorManager.init();
                }
            } catch (error) {
                console.error('Error initializing comparison table systems:', error);
            }
        };

        // Run initialization
        initializeSystems();

        // Handle responsive changes
        const handleResponsiveChanges = utils.debounce(() => {
            const isMobile = window.innerWidth < 1024;
            const scrollIndicatorExists = utils.safeQuerySelector('.scroll-indicator');
            
            if (isMobile && !scrollIndicatorExists) {
                ScrollIndicatorManager.init();
            } else if (!isMobile && scrollIndicatorExists) {
                scrollIndicatorExists.remove();
            }
        }, 250);

        window.addEventListener('resize', handleResponsiveChanges);
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

/**
 * AJAX handler for getting comparison pricing in different currencies
 */
add_action('wp_ajax_get_comparison_pricing_in_currency', 'yoursite_ajax_get_comparison_pricing_in_currency');
add_action('wp_ajax_nopriv_get_comparison_pricing_in_currency', 'yoursite_ajax_get_comparison_pricing_in_currency');

function yoursite_ajax_get_comparison_pricing_in_currency() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'get_comparison_pricing')) {
        wp_die('Security check failed');
    }
    
    $currency_code = sanitize_text_field($_POST['currency']);
    $plan_ids = explode(',', sanitize_text_field($_POST['plan_ids']));
    
    $response_data = array();
    
    foreach ($plan_ids as $plan_id) {
        $plan_id = intval($plan_id);
        if ($plan_id <= 0) continue;
        
        // Get pricing in requested currency
        if (function_exists('yoursite_get_pricing_plan_price')) {
            $monthly_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'monthly');
            $annual_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'annual');
        } else {
            // Fallback to basic meta fields
            $monthly_price = floatval(get_post_meta($plan_id, '_pricing_monthly_price', true));
            $annual_price = floatval(get_post_meta($plan_id, '_pricing_annual_price', true));
        }
        
        // Calculate annual monthly equivalent if needed
        if ($annual_price == 0 && $monthly_price > 0) {
            $annual_price = $monthly_price * 12 * 0.8; // 20% discount
        }
        $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
        
        // Calculate savings
        $savings = ($monthly_price * 12) - $annual_price;
        
        // Format prices
        if (function_exists('yoursite_format_currency')) {
            $monthly_formatted = yoursite_format_currency($monthly_price, $currency_code);
            $annual_formatted = yoursite_format_currency($annual_price, $currency_code);
            $annual_monthly_formatted = yoursite_format_currency($annual_monthly, $currency_code);
            $savings_formatted = yoursite_format_currency($savings, $currency_code);
        } else {
            
  $currency_symbols = array(
    'USD' => '$',
    'EUR' => '€',
    'GBP' => '£',
    'CAD' => 'C$',
    'AUD' => 'A$',
    'JPY' => '¥',
    'CHF' => 'CHF',
    'SEK' => 'kr',
    'NOK' => 'kr',
    'DKK' => 'kr',
    'INR' => '₹',
    'KRW' => '₩'
);

$symbol = isset($currency_symbols[$currency_code]) ? $currency_symbols[$currency_code] : '';
            
            $monthly_formatted = $symbol . number_format($monthly_price, 0);
            $annual_formatted = $symbol . number_format($annual_price, 0);
            $annual_monthly_formatted = $symbol . number_format($annual_monthly, 0);
            $savings_formatted = $symbol . number_format($savings, 0);
        }
        
        $response_data[$plan_id] = array(
            'monthly_price' => $monthly_price,
            'annual_price' => $annual_price,
            'annual_monthly_equivalent' => $annual_monthly,
            'savings' => $savings,
            'monthly_price_formatted' => $monthly_formatted,
            'annual_price_formatted' => $annual_formatted,
            'annual_monthly_equivalent_formatted' => $annual_monthly_formatted,
            'savings_formatted' => $savings_formatted
        );
    }
    
    // Get currency info
    $currency_info = array();
    if (function_exists('yoursite_get_currency_info')) {
        $currency_info = yoursite_get_currency_info($currency_code);
    }
    
    wp_send_json_success(array(
        'pricing' => $response_data,
        'currency_info' => $currency_info
    ));
}
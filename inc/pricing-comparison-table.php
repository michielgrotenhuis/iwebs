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
            
            // Use requestAnimationFrame for smooth animation
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
            
            // Viewport boundary checking
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

    // Billing toggle system
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
            // Set initial state to yearly (default)
            this.comparisonToggle.checked = true;
            this.updateComparisonDisplay(true);
        },

        bindEvents() {
            this.comparisonToggle.addEventListener('change', this.handleComparisonToggleChange.bind(this));
            
            // Sync with main toggle if it exists
            if (this.mainToggle && this.mainToggle !== this.comparisonToggle) {
                this.mainToggle.addEventListener('change', this.handleMainToggleChange.bind(this));
            }
        },

        handleComparisonToggleChange() {
            const isYearly = this.comparisonToggle.checked;
            this.updateComparisonDisplay(isYearly);
            this.syncWithMainToggle(isYearly);
        },

        handleMainToggleChange() {
            const isYearly = this.mainToggle.checked;
            this.comparisonToggle.checked = isYearly;
            this.updateComparisonDisplay(isYearly);
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
            StickyHeaderManager.init();
            
            // Add scroll indicator on mobile devices
            if (window.innerWidth < 1024) {
                ScrollIndicatorManager.init();
            }
        } catch (error) {
            console.error('Error initializing pricing table systems:', error);
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
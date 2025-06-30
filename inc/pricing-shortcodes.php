<?php
/**
 * Enhanced Pricing Shortcodes with Currency Integration
 * File: inc/pricing-shortcodes.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enhanced Pricing Table Shortcode with Currency Support
 */
function yoursite_pricing_table_shortcode($atts) {
    $atts = shortcode_atts(array(
        'plans' => '', // Comma-separated plan IDs or 'all'
        'show_toggle' => 'true',
        'show_features' => 'true',
        'max_features' => '5',
        'columns' => 'auto', // auto, 2, 3, 4
        'featured_plan' => '', // Plan ID to highlight as featured
        'title' => '',
        'subtitle' => '',
        'show_trial_text' => 'true',
        'show_currency_selector' => 'true',
        'currency' => '' // Override default currency
    ), $atts, 'pricing_table');

    // Get pricing plans
    if ($atts['plans'] === 'all' || empty($atts['plans'])) {
        $plan_ids = get_posts(array(
            'post_type' => 'pricing',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'fields' => 'ids',
            'meta_key' => '_pricing_monthly_price',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        ));
    } else {
        $plan_ids = array_map('trim', explode(',', $atts['plans']));
    }

    if (empty($plan_ids)) {
        return '<p>' . __('No pricing plans found.', 'yoursite') . '</p>';
    }

    // Get plan objects
    $plans = array();
    foreach ($plan_ids as $plan_id) {
        $plan = get_post($plan_id);
        if ($plan && $plan->post_status === 'publish') {
            $plans[] = $plan;
        }
    }

    if (empty($plans)) {
        return '<p>' . __('No valid pricing plans found.', 'yoursite') . '</p>';
    }

    // Get current currency
    $current_currency = !empty($atts['currency']) ? yoursite_get_currency($atts['currency']) : yoursite_get_user_currency();
    if (!$current_currency) {
        $current_currency = yoursite_get_base_currency();
    }

    // Determine if we need horizontal scroll
    $plan_count = count($plans);
    $needs_scroll = $plan_count > 3;
    
    // Generate unique ID for this pricing table
    $table_id = 'pricing-table-' . uniqid();
    
    ob_start();
    ?>
    
    <div class="enhanced-pricing-section py-12 bg-white dark:bg-gray-800" 
         id="<?php echo esc_attr($table_id); ?>"
         data-currency="<?php echo esc_attr($current_currency['code']); ?>">
        
        <!-- Section Header -->
        <?php if (!empty($atts['title']) || !empty($atts['subtitle'])) : ?>
        <div class="container mx-auto px-4 mb-12">
            <div class="text-center">
                <?php if (!empty($atts['title'])) : ?>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo esc_html($atts['title']); ?>
                    </h2>
                <?php endif; ?>
                <?php if (!empty($atts['subtitle'])) : ?>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        <?php echo esc_html($atts['subtitle']); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Currency and Billing Controls -->
        <div class="container mx-auto px-4 mb-12">
            <div class="flex items-center justify-center flex-wrap gap-6">
                
                <!-- Currency Selector -->
                <?php if ($atts['show_currency_selector'] === 'true' && function_exists('yoursite_render_currency_selector')) : ?>
                <div class="flex items-center gap-3">
                    <span class="text-gray-700 dark:text-gray-300 font-medium">
                        <?php _e('Currency:', 'yoursite'); ?>
                    </span>
                    <?php echo yoursite_render_currency_selector(array(
                        'style' => 'dropdown',
                        'show_flag' => true,
                        'show_name' => false,
                        'show_symbol' => true,
                        'class' => 'pricing-currency-selector',
                        'container_class' => 'pricing-currency-container'
                    )); ?>
                </div>
                <?php endif; ?>
                
                <!-- Billing Toggle -->
                <?php if ($atts['show_toggle'] === 'true') : ?>
                <div class="flex items-center gap-4">
                    <span class="text-gray-700 dark:text-gray-300 font-medium pricing-monthly-label">
                        <?php _e('Monthly', 'yoursite'); ?>
                    </span>
                    <div class="relative">
                        <input type="checkbox" id="<?php echo esc_attr($table_id); ?>-billing-toggle" class="sr-only pricing-billing-toggle" checked>
                        <label for="<?php echo esc_attr($table_id); ?>-billing-toggle" class="relative inline-flex items-center justify-between w-16 h-8 bg-blue-600 rounded-full cursor-pointer transition-colors duration-300 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                            <span class="pricing-toggle-switch absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 translate-x-8"></span>
                        </label>
                    </div>
                    <span class="text-blue-600 dark:text-blue-400 font-semibold pricing-yearly-label">
                        <?php _e('Annual', 'yoursite'); ?>
                    </span>
                    <span class="bg-emerald-500 text-emerald-50 dark:text-white text-sm font-semibold px-3 py-1 rounded-full shadow-md">
                        <?php _e('Save 20%', 'yoursite'); ?>
                    </span>
                </div>
                <?php endif; ?>
                
            </div>
        </div>
        
        <!-- Loading Indicator -->
        <div class="pricing-loading-indicator hidden text-center py-8">
            <div class="inline-flex items-center px-4 py-2 bg-blue-50 dark:bg-blue-900 rounded-lg">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-blue-600 dark:text-blue-300 font-medium">
                    <?php _e('Updating prices...', 'yoursite'); ?>
                </span>
            </div>
        </div>
        
        <!-- Pricing Cards Container -->
        <div class="container mx-auto px-4">
            <?php if ($needs_scroll) : ?>
                <!-- Horizontal Scroll Layout for 4+ Plans -->
                <div class="pricing-scroll-wrapper relative">
                    <!-- Scroll Buttons -->
                    <button class="pricing-scroll-btn pricing-scroll-left absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white dark:bg-gray-800 shadow-lg rounded-full p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" style="margin-left: -20px;">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="pricing-scroll-btn pricing-scroll-right absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white dark:bg-gray-800 shadow-lg rounded-full p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" style="margin-right: -20px;">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <!-- Scrollable Container -->
                    <div class="pricing-scroll-container overflow-hidden">
                        <div class="pricing-cards-wrapper flex gap-6 transition-all duration-300 ease-in-out" style="width: <?php echo ($plan_count * 340) + (($plan_count - 1) * 24); ?>px;">
                            <?php foreach ($plans as $plan) : ?>
                                <?php echo yoursite_render_pricing_card_with_currency($plan, $atts, $current_currency); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Scroll Dots Indicator -->
                    <div class="pricing-scroll-dots flex justify-center mt-8 space-x-2">
                        <?php 
                        $total_pages = ceil($plan_count / 3);
                        for ($i = 0; $i < $total_pages; $i++) : ?>
                            <button class="pricing-dot w-3 h-3 rounded-full bg-gray-300 dark:bg-gray-600 transition-colors hover:bg-gray-400 dark:hover:bg-gray-500 <?php echo $i === 0 ? 'active' : ''; ?>" 
                                    data-page="<?php echo $i; ?>"></button>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php else : ?>
                <!-- Static Grid for 1-3 Plans -->
                <div class="pricing-static-grid grid gap-6 <?php echo 'grid-cols-1 md:grid-cols-' . min($plan_count, 2) . ' lg:grid-cols-' . min($plan_count, 3); ?>">
                    <?php foreach ($plans as $plan) : ?>
                        <?php echo yoursite_render_pricing_card_with_currency($plan, $atts, $current_currency); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Bottom CTA -->
        <?php if ($atts['show_trial_text'] === 'true') : ?>
        <div class="container mx-auto px-4 text-center mt-12">
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                <?php _e('All plans include a 14-day free trial. No credit card required.', 'yoursite'); ?>
            </p>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Enhanced Styles with Currency Support -->
    <style>
    /* Enhanced Pricing Section Styles */
    .enhanced-pricing-section .pricing-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 2rem;
        position: relative;
        height: auto;
        min-height: 600px;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 340px;
        margin: 0 auto;
    }
    
    .enhanced-pricing-section .pricing-card.featured {
        border-color: #667eea;
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
        transform: scale(1.02);
        z-index: 2;
    }
    
    .enhanced-pricing-section .pricing-card:hover {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transform: translateY(-4px);
    }
    
    .enhanced-pricing-section .pricing-card.featured:hover {
        transform: scale(1.02) translateY(-4px);
    }
    
    /* Currency Loading States */
    .enhanced-pricing-section.currency-loading .pricing-card {
        opacity: 0.7;
        pointer-events: none;
    }
    
    .enhanced-pricing-section.currency-loading .pricing-loading-indicator {
        display: block !important;
    }
    
    .pricing-loading-indicator.hidden {
        display: none;
    }
    
    /* Currency Price Updates */
    .pricing-price-amount {
        transition: all 0.3s ease;
    }
    
    .pricing-price-amount.updating {
        opacity: 0.5;
        transform: scale(0.95);
    }
    
    /* Horizontal Scroll Styles */
    .pricing-scroll-wrapper {
        position: relative;
        max-width: 100%;
        margin: 0 auto;
    }
    
    .pricing-scroll-container {
        overflow: hidden;
        mask: linear-gradient(to right, transparent 0px, black 40px, black calc(100% - 40px), transparent 100%);
        -webkit-mask: linear-gradient(to right, transparent 0px, black 40px, black calc(100% - 40px), transparent 100%);
    }
    
    .pricing-cards-wrapper {
        display: flex;
        gap: 1.5rem;
    }
    
    .pricing-cards-wrapper .pricing-card {
        flex: 0 0 340px;
        max-width: 340px;
    }
    
    /* Currency Selector Styling */
    .pricing-currency-container {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 8px 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .dark .pricing-currency-container {
        background: #1f2937;
        border-color: #374151;
    }
    
    /* Scroll Buttons */
    .pricing-scroll-btn {
        opacity: 1;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    
    .pricing-scroll-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .pricing-scroll-btn:hover:not(:disabled) {
        transform: translateY(-50%) scale(1.1);
    }
    
    /* Scroll Dots */
    .pricing-scroll-dots .pricing-dot.active {
        background-color: #667eea;
    }
    
    /* Pricing Toggle Enhancements */
    .pricing-billing-toggle:checked + label {
        background-color: #2563eb;
    }
    
    .pricing-billing-toggle:not(:checked) + label {
        background-color: #d1d5db;
    }
    
    .pricing-billing-toggle:checked + label .pricing-toggle-switch {
        transform: translateX(32px);
    }
    
    .pricing-billing-toggle:not(:checked) + label .pricing-toggle-switch {
        transform: translateX(0px);
    }
    
    /* Price Display Styles */
    .pricing-monthly-pricing,
    .pricing-annual-pricing {
        transition: all 0.3s ease;
    }
    
    .pricing-monthly-pricing {
        display: none;
    }
    
    .pricing-annual-pricing {
        display: block;
    }
    
    /* When monthly is active */
    .enhanced-pricing-section.monthly-active .pricing-monthly-pricing {
        display: block;
    }
    
    .enhanced-pricing-section.monthly-active .pricing-annual-pricing {
        display: none;
    }
    
    .enhanced-pricing-section.monthly-active .pricing-annual-savings {
        display: none;
    }
    
    /* Featured Badge */
    .pricing-featured-badge {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 24px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        z-index: 3;
    }
    
    /* Dark Mode */
    .dark .enhanced-pricing-section .pricing-card {
        background-color: #1f2937;
        border-color: #374151;
    }
    
    .dark .enhanced-pricing-section .pricing-card.featured {
        border-color: #667eea;
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
    }
    
    .dark .pricing-scroll-btn {
        background-color: #1f2937;
        border-color: #374151;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .enhanced-pricing-section .pricing-card {
            min-height: auto;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .enhanced-pricing-section .pricing-card.featured {
            transform: none;
            margin-top: 0;
        }
        
        .pricing-scroll-wrapper {
            margin: 0 -1rem;
            padding: 0 1rem;
        }
        
        .pricing-cards-wrapper {
            gap: 1rem;
        }
        
        .pricing-cards-wrapper .pricing-card {
            flex: 0 0 280px;
            max-width: 280px;
        }
        
        .pricing-scroll-container {
            mask: linear-gradient(to right, transparent 0px, black 20px, black calc(100% - 20px), transparent 100%);
            -webkit-mask: linear-gradient(to right, transparent 0px, black 20px, black calc(100% - 20px), transparent 100%);
        }
        
        .pricing-scroll-btn {
            display: none;
        }
        
        .pricing-featured-badge {
            position: relative;
            top: auto;
            left: auto;
            transform: none;
            margin-bottom: 1rem;
            display: inline-block;
        }
        
        /* Stack currency selector and billing toggle on mobile */
        .container .flex-wrap {
            flex-direction: column;
            gap: 1rem;
        }
    }
    
    @media (max-width: 480px) {
        .pricing-cards-wrapper .pricing-card {
            flex: 0 0 250px;
            max-width: 250px;
        }
    }
    
    /* Touch scrolling for mobile */
    @media (max-width: 1024px) {
        .pricing-scroll-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        
        .pricing-scroll-container::-webkit-scrollbar {
            display: none;
        }
    }
    </style>
    
    <!-- Enhanced JavaScript with Currency Integration -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        initializePricingTableWithCurrency('<?php echo $table_id; ?>');
    });
    
    function initializePricingTableWithCurrency(tableId) {
        const pricingSection = document.getElementById(tableId);
        if (!pricingSection) return;
        
        const billingToggle = pricingSection.querySelector('.pricing-billing-toggle');
        const monthlyLabel = pricingSection.querySelector('.pricing-monthly-label');
        const yearlyLabel = pricingSection.querySelector('.pricing-yearly-label');
        const scrollWrapper = pricingSection.querySelector('.pricing-scroll-wrapper');
        
        // Initialize billing toggle
        if (billingToggle) {
            // Set initial state (annual default)
            updatePricingDisplay(pricingSection, true);
            updateToggleLabels(monthlyLabel, yearlyLabel, true);
            
            billingToggle.addEventListener('change', function() {
                const isYearly = this.checked;
                updatePricingDisplay(pricingSection, isYearly);
                updateToggleLabels(monthlyLabel, yearlyLabel, isYearly);
            });
        }
        
        // Initialize horizontal scroll if needed
        if (scrollWrapper) {
            initializeHorizontalScroll(pricingSection);
        }
        
        // Listen for currency changes
        document.addEventListener('currencyChanged', function(e) {
            updatePricingCurrency(pricingSection, e.detail.currency);
        });
        
        // Handle currency selector within this table
        const currencySelector = pricingSection.querySelector('.pricing-currency-container');
        if (currencySelector) {
            currencySelector.addEventListener('click', function(e) {
                const currencyOption = e.target.closest('[data-currency-code], [data-currency]');
                if (currencyOption) {
                    e.preventDefault();
                    const newCurrency = currencyOption.dataset.currencyCode || currencyOption.dataset.currency;
                    updatePricingCurrency(pricingSection, newCurrency);
                    
                    // Dispatch global currency change event
                    const event = new CustomEvent('currencyChanged', {
                        detail: { currency: newCurrency }
                    });
                    document.dispatchEvent(event);
                }
            });
        }
    }
    
    function updatePricingDisplay(section, isYearly) {
        const monthlyPricing = section.querySelectorAll('.pricing-monthly-pricing');
        const annualPricing = section.querySelectorAll('.pricing-annual-pricing');
        const annualSavings = section.querySelectorAll('.pricing-annual-savings');
        
        if (isYearly) {
            section.classList.remove('monthly-active');
            monthlyPricing.forEach(el => el.style.display = 'none');
            annualPricing.forEach(el => el.style.display = 'block');
            annualSavings.forEach(el => el.style.display = 'block');
        } else {
            section.classList.add('monthly-active');
            monthlyPricing.forEach(el => el.style.display = 'block');
            annualPricing.forEach(el => el.style.display = 'none');
            annualSavings.forEach(el => el.style.display = 'none');
        }
    }
    
    function updateToggleLabels(monthlyLabel, yearlyLabel, isYearly) {
        if (!monthlyLabel || !yearlyLabel) return;
        
        if (isYearly) {
            monthlyLabel.style.color = '#9ca3af';
            monthlyLabel.style.fontWeight = '400';
            yearlyLabel.style.color = '#2563eb';
            yearlyLabel.style.fontWeight = '600';
        } else {
            monthlyLabel.style.color = '#2563eb';
            monthlyLabel.style.fontWeight = '600';
            yearlyLabel.style.color = '#9ca3af';
            yearlyLabel.style.fontWeight = '400';
        }
    }
    
    function updatePricingCurrency(section, newCurrency) {
        if (!newCurrency) return;
        
        // Show loading state
        section.classList.add('currency-loading');
        const loadingIndicator = section.querySelector('.pricing-loading-indicator');
        if (loadingIndicator) {
            loadingIndicator.classList.remove('hidden');
        }
        
        // Update section currency attribute
        section.setAttribute('data-currency', newCurrency);
        
        // Get all plan cards in this section
        const planCards = section.querySelectorAll('.pricing-card[data-plan-id]');
        
        // Update each plan's pricing
        const updatePromises = Array.from(planCards).map(card => {
            const planId = card.dataset.planId;
            return updateCardPricing(card, planId, newCurrency);
        });
        
        // Wait for all updates to complete
        Promise.all(updatePromises).then(() => {
            // Hide loading state
            section.classList.remove('currency-loading');
            if (loadingIndicator) {
                loadingIndicator.classList.add('hidden');
            }
            
            // Show success message
            showCurrencyChangeNotification('Prices updated to ' + newCurrency);
        }).catch(error => {
            console.error('Error updating pricing currency:', error);
            section.classList.remove('currency-loading');
            if (loadingIndicator) {
                loadingIndicator.classList.add('hidden');
            }
            showCurrencyChangeNotification('Error updating prices. Please try again.', true);
        });
    }
    
    function updateCardPricing(card, planId, currency) {
        return new Promise((resolve, reject) => {
            // If we have AJAX available, fetch new pricing
            if (typeof ajaxurl !== 'undefined') {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', ajaxurl);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                updateCardElements(card, response.data);
                                resolve();
                            } else {
                                reject(new Error(response.data || 'Failed to update pricing'));
                            }
                        } catch (e) {
                            reject(e);
                        }
                    } else {
                        reject(new Error('HTTP error: ' + xhr.status));
                    }
                };
                
                xhr.onerror = function() {
                    reject(new Error('Network error'));
                };
                
                const params = new URLSearchParams({
                    action: 'get_currency_pricing',
                    plan_id: planId,
                    currency: currency,
                    nonce: '<?php echo wp_create_nonce("get_pricing"); ?>'
                });
                
                xhr.send(params);
            } else {
                // Fallback: just resolve without updating
                resolve();
            }
        });
    }
    
    function updateCardElements(card, pricingData) {
        // Update monthly price
        const monthlyAmount = card.querySelector('[data-price-type="monthly"]');
        if (monthlyAmount && pricingData.monthly_price) {
            monthlyAmount.textContent = pricingData.monthly_price.replace(/[^\d.,]/g, '');
        }
        
        // Update annual prices
        const annualMonthlyAmount = card.querySelector('[data-price-type="annual-monthly"]');
        if (annualMonthlyAmount && pricingData.annual_monthly_equivalent) {
            annualMonthlyAmount.textContent = pricingData.annual_monthly_equivalent.replace(/[^\d.,]/g, '');
        }
        
        // Update currency symbols
        const currencySymbols = card.querySelectorAll('.currency-symbol');
        if (currencySymbols.length && pricingData.currency && pricingData.currency.symbol) {
            currencySymbols.forEach(symbol => {
                symbol.textContent = pricingData.currency.symbol;
            });
        }
        
        // Update savings amount
        const savingsAmount = card.querySelector('[data-savings-amount]');
        if (savingsAmount && pricingData.savings) {
            savingsAmount.textContent = pricingData.savings.replace(/[^\d.,]/g, '');
        }
        
        // Update billing text
        const billingTexts = card.querySelectorAll('.billing-text');
        if (billingTexts.length && pricingData.raw_annual) {
            billingTexts.forEach(text => {
                if (text.textContent.includes('Billed annually')) {
                    text.textContent = text.textContent.replace(/\([^)]+\)/, `(${pricingData.currency.symbol}${Math.round(pricingData.raw_annual)})`);
                }
            });
        }
    }
    
    function showCurrencyChangeNotification(message, isError = false) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-4 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full ${
            isError ? 'bg-red-500 text-white' : 'bg-green-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after delay
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }, isError ? 5000 : 3000);
    }
    
    function initializeHorizontalScroll(section) {
        const scrollContainer = section.querySelector('.pricing-scroll-container');
        const cardsWrapper = section.querySelector('.pricing-cards-wrapper');
        const leftBtn = section.querySelector('.pricing-scroll-left');
        const rightBtn = section.querySelector('.pricing-scroll-right');
        const dots = section.querySelectorAll('.pricing-dot');
        
        if (!scrollContainer || !cardsWrapper) return;
        
        let currentPage = 0;
        const cardsPerPage = 3;
        const cardWidth = 340;
        const gap = 24;
        const totalCards = cardsWrapper.children.length;
        const totalPages = Math.ceil(totalCards / cardsPerPage);
        
        // Update scroll position
        function updateScroll() {
            const translateX = currentPage * (cardsPerPage * (cardWidth + gap));
            cardsWrapper.style.transform = `translateX(-${translateX}px)`;
            
            // Update buttons
            if (leftBtn && rightBtn) {
                leftBtn.disabled = currentPage === 0;
                rightBtn.disabled = currentPage >= totalPages - 1;
            }
            
            // Update dots
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentPage);
            });
        }
        
        // Button events
        if (leftBtn) {
            leftBtn.addEventListener('click', () => {
                if (currentPage > 0) {
                    currentPage--;
                    updateScroll();
                }
            });
        }
        
        if (rightBtn) {
            rightBtn.addEventListener('click', () => {
                if (currentPage < totalPages - 1) {
                    currentPage++;
                    updateScroll();
                }
            });
        }
        
        // Dot events
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentPage = index;
                updateScroll();
            });
        });
        
        // Touch/swipe support for mobile
        let startX = 0;
        let currentX = 0;
        let isDragging = false;
        
        scrollContainer.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
        });
        
        scrollContainer.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
        });
        
        scrollContainer.addEventListener('touchend', () => {
            if (!isDragging) return;
            isDragging = false;
            
            const diffX = startX - currentX;
            const threshold = 50;
            
            if (diffX > threshold && currentPage < totalPages - 1) {
                currentPage++;
                updateScroll();
            } else if (diffX < -threshold && currentPage > 0) {
                currentPage--;
                updateScroll();
            }
        });
        
        // Initialize
        updateScroll();
        
        // Auto-adjust on window resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(updateScroll, 100);
        });
    }
    </script>
    
    <?php
    return ob_get_clean();
}

/**
 * Render individual pricing card with currency support
 */
function yoursite_render_pricing_card_with_currency($plan, $atts, $current_currency) {
    $meta = yoursite_get_pricing_meta_fields($plan->ID);
    $is_featured = $meta['pricing_featured'] === '1' || $plan->ID == $atts['featured_plan'];
    
    // Get pricing in current currency
    $monthly_price = 0;
    $annual_price = 0;
    
    if (function_exists('yoursite_get_pricing_plan_price')) {
        $monthly_price = yoursite_get_pricing_plan_price($plan->ID, $current_currency['code'], 'monthly');
        $annual_price = yoursite_get_pricing_plan_price($plan->ID, $current_currency['code'], 'annual');
    } else {
        // Fallback to meta values with conversion
        $base_monthly = floatval($meta['pricing_monthly_price']);
        $base_annual = floatval($meta['pricing_annual_price']);
        
        if (function_exists('yoursite_convert_price')) {
            $base_currency = yoursite_get_base_currency();
            $monthly_price = yoursite_convert_price($base_monthly, $base_currency['code'], $current_currency['code']);
            $annual_price = $base_annual > 0 ? yoursite_convert_price($base_annual, $base_currency['code'], $current_currency['code']) : 0;
        } else {
            $monthly_price = $base_monthly;
            $annual_price = $base_annual;
        }
    }
    
    // Calculate annual monthly equivalent if not set
    if ($annual_price == 0 && $monthly_price > 0) {
        $annual_price = $monthly_price * 12 * 0.8; // 20% discount
    }
    $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
    
    ob_start();
    ?>
    <div class="pricing-card <?php echo $is_featured ? 'featured' : ''; ?>" data-plan-id="<?php echo esc_attr($plan->ID); ?>">
        <!-- Featured Badge -->
        <?php if ($is_featured) : ?>
            <div class="pricing-featured-badge">
                <?php _e('Most Popular', 'yoursite'); ?>
            </div>
        <?php endif; ?>
        
        <div class="text-center mb-8 <?php echo $is_featured ? 'mt-4' : ''; ?>">
            <!-- Plan Name -->
            <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">
                <?php echo esc_html($plan->post_title); ?>
            </h3>
            
            <!-- Plan Description -->
            <?php if (!empty($plan->post_excerpt)) : ?>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    <?php echo esc_html($plan->post_excerpt); ?>
                </p>
            <?php endif; ?>
            
            <!-- Price Display with Currency -->
            <div class="mb-6">
                <!-- Monthly Pricing -->
                <div class="pricing-monthly-pricing">
                    <div class="flex items-baseline justify-center mb-2">
                        <span class="currency-symbol text-2xl font-bold text-gray-900 dark:text-white mr-1">
                            <?php echo esc_html($current_currency['symbol']); ?>
                        </span>
                        <span class="pricing-price-amount text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white" data-price-type="monthly">
                            <?php echo number_format($monthly_price, 0); ?>
                        </span>
                        <span class="text-gray-600 dark:text-gray-300 text-lg ml-2">
                            /<?php _e('month', 'yoursite'); ?>
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 billing-text">
                        <?php printf(__('Billed monthly (%s%s)', 'yoursite'), esc_html($current_currency['symbol']), number_format($monthly_price, 0)); ?>
                    </div>
                </div>
                
                <!-- Annual Pricing -->
                <div class="pricing-annual-pricing">
                    <div class="flex items-baseline justify-center mb-2">
                        <span class="currency-symbol text-2xl font-bold text-gray-900 dark:text-white mr-1">
                            <?php echo esc_html($current_currency['symbol']); ?>
                        </span>
                        <span class="pricing-price-amount text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white" data-price-type="annual-monthly">
                            <?php echo number_format($annual_monthly, 0); ?>
                        </span>
                        <span class="text-gray-600 dark:text-gray-300 text-lg ml-2">
                            /<?php _e('month', 'yoursite'); ?>
                        </span>
                    </div>
                    <?php if ($annual_price > 0) : ?>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-2 billing-text">
                            <?php printf(__('Billed annually (%s%s)', 'yoursite'), esc_html($current_currency['symbol']), number_format($annual_price, 0)); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Savings Badge (Annual) -->
                <?php if ($monthly_price > 0 && $annual_price > 0) : ?>
                    <div class="pricing-annual-savings">
                        <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-4 py-2 rounded-full text-sm font-semibold inline-block">
                            <?php printf(__('Save %s%s per year', 'yoursite'), esc_html($current_currency['symbol']), '<span data-savings-amount>' . number_format(($monthly_price * 12) - $annual_price, 0) . '</span>'); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Features List -->
        <?php if ($atts['show_features'] === 'true' && !empty($meta['pricing_features'])) : ?>
        <div class="mb-8 flex-grow">
            <ul class="space-y-3">
                <?php 
                $features = array_filter(explode("\n", $meta['pricing_features']));
                $max_features = intval($atts['max_features']);
                $display_features = array_slice($features, 0, $max_features);
                
                foreach ($display_features as $feature) :
                    $feature = trim($feature);
                    if (!empty($feature)) :
                ?>
                <li class="flex items-center text-gray-700 dark:text-gray-300">
                    <svg class="w-5 h-5 text-green-500 dark:text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm"><?php echo esc_html($feature); ?></span>
                </li>
                <?php 
                    endif;
                endforeach; 
                
                // Show "and more" if there are additional features
                if (count($features) > $max_features) : ?>
                    <li class="flex items-center text-gray-500 dark:text-gray-400">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="text-sm font-medium">
                            <?php printf(__('And %d more features...', 'yoursite'), count($features) - $max_features); ?>
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <!-- CTA Button -->
        <div class="text-center mt-auto">
            <a href="<?php echo esc_url($meta['pricing_button_url'] ?: home_url('/pricing')); ?>" 
               class="<?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?> w-full text-center block py-4 px-6 rounded-lg font-semibold text-lg transition-all duration-200 hover:transform hover:-translate-y-1"
               <?php echo $is_featured ? 'style="color: #ffffff !important;"' : ''; ?>>
                <?php echo esc_html($meta['pricing_button_text'] ?: __('Get Started', 'yoursite')); ?>
            </a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// Register the enhanced shortcode
add_shortcode('pricing_table', 'yoursite_pricing_table_shortcode');

/**
 * Enhanced pricing comparison shortcode with currency support
 */
function yoursite_pricing_comparison_shortcode($atts) {
    $atts = shortcode_atts(array(
        'plans' => 'all',
        'title' => __('Compare All Plans', 'yoursite'),
        'subtitle' => __('Choose the perfect plan for your business', 'yoursite'),
        'show_currency_selector' => 'true',
        'currency' => ''
    ), $atts, 'pricing_comparison');
    
    // Check if the comparison function exists
    if (!function_exists('yoursite_render_pricing_comparison_table_with_currency')) {
        return '<p>' . __('Pricing comparison feature not available.', 'yoursite') . '</p>';
    }
    
    ob_start();
    ?>
    <div class="pricing-comparison-section py-12" data-currency="<?php echo esc_attr($atts['currency']); ?>">
        <?php if (!empty($atts['title']) || !empty($atts['subtitle'])) : ?>
        <div class="container mx-auto px-4 mb-12">
            <div class="text-center">
                <?php if (!empty($atts['title'])) : ?>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo esc_html($atts['title']); ?>
                    </h2>
                <?php endif; ?>
                <?php if (!empty($atts['subtitle'])) : ?>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        <?php echo esc_html($atts['subtitle']); ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <!-- Currency Selector for Comparison Table -->
            <?php if ($atts['show_currency_selector'] === 'true' && function_exists('yoursite_render_currency_selector')) : ?>
            <div class="flex justify-center mt-8">
                <div class="flex items-center gap-3 bg-white dark:bg-gray-800 rounded-lg px-4 py-3 shadow-lg border border-gray-200 dark:border-gray-700">
                    <span class="text-gray-700 dark:text-gray-300 font-medium">
                        <?php _e('Show prices in:', 'yoursite'); ?>
                    </span>
                    <?php echo yoursite_render_currency_selector(array(
                        'style' => 'dropdown',
                        'show_flag' => true,
                        'show_name' => true,
                        'show_symbol' => false,
                        'class' => 'comparison-currency-selector',
                        'container_class' => 'comparison-currency-container'
                    )); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <?php echo yoursite_render_pricing_comparison_table_with_currency($atts); ?>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const comparisonSection = document.querySelector('.pricing-comparison-section');
        if (!comparisonSection) return;
        
        // Listen for currency changes
        document.addEventListener('currencyChanged', function(e) {
            updateComparisonTableCurrency(comparisonSection, e.detail.currency);
        });
        
        // Handle currency selector within comparison table
        const currencySelector = comparisonSection.querySelector('.comparison-currency-container');
        if (currencySelector) {
            currencySelector.addEventListener('click', function(e) {
                const currencyOption = e.target.closest('[data-currency-code], [data-currency]');
                if (currencyOption) {
                    e.preventDefault();
                    const newCurrency = currencyOption.dataset.currencyCode || currencyOption.dataset.currency;
                    updateComparisonTableCurrency(comparisonSection, newCurrency);
                    
                    // Dispatch global currency change event
                    const event = new CustomEvent('currencyChanged', {
                        detail: { currency: newCurrency }
                    });
                    document.dispatchEvent(event);
                }
            });
        }
    });
    
    function updateComparisonTableCurrency(section, newCurrency) {
        // Implementation depends on having the comparison table function
        // This will be handled by the comparison table's own currency update logic
        console.log('Updating comparison table currency to:', newCurrency);
    }
    </script>
    <?php
    
    return ob_get_clean();
}

add_shortcode('pricing_comparison', 'yoursite_pricing_comparison_shortcode');

/**
 * Simple pricing cards shortcode with currency support (legacy support)
 */
function yoursite_pricing_cards_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => '3',
        'columns' => '3',
        'show_currency_selector' => 'true'
    ), $atts, 'pricing_cards');
    
    // Get plans
    $plan_ids = get_posts(array(
        'post_type' => 'pricing',
        'posts_per_page' => intval($atts['count']),
        'post_status' => 'publish',
        'fields' => 'ids',
        'meta_key' => '_pricing_monthly_price',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
    ));
    
    if (empty($plan_ids)) {
        return '<p>' . __('No pricing plans found.', 'yoursite') . '</p>';
    }
    
    // Use the enhanced pricing table with currency support
    return yoursite_pricing_table_shortcode(array(
        'plans' => implode(',', $plan_ids),
        'show_toggle' => 'true',
        'show_features' => 'true',
        'max_features' => '5',
        'show_currency_selector' => $atts['show_currency_selector']
    ));
}

add_shortcode('pricing_cards', 'yoursite_pricing_cards_shortcode');

/**
 * Currency-specific pricing display shortcode
 */
function yoursite_currency_pricing_shortcode($atts) {
    $atts = shortcode_atts(array(
        'plan' => '',
        'currency' => '',
        'period' => 'monthly', // monthly, annual, both
        'format' => 'price_only', // price_only, with_currency, full_details
        'show_original' => 'false'
    ), $atts, 'currency_pricing');
    
    if (empty($atts['plan'])) {
        return '<span class="error">' . __('Plan ID required', 'yoursite') . '</span>';
    }
    
    $plan_id = intval($atts['plan']);
    $plan = get_post($plan_id);
    
    if (!$plan || $plan->post_type !== 'pricing') {
        return '<span class="error">' . __('Invalid plan', 'yoursite') . '</span>';
    }
    
    // Get currency
    $currency = !empty($atts['currency']) ? yoursite_get_currency($atts['currency']) : yoursite_get_user_currency();
    if (!$currency) {
        $currency = yoursite_get_base_currency();
    }
    
    // Get pricing
    $monthly_price = 0;
    $annual_price = 0;
    
    if (function_exists('yoursite_get_pricing_plan_price')) {
        $monthly_price = yoursite_get_pricing_plan_price($plan_id, $currency['code'], 'monthly');
        if ($atts['period'] === 'annual' || $atts['period'] === 'both') {
            $annual_price = yoursite_get_pricing_plan_price($plan_id, $currency['code'], 'annual');
        }
    }
    
    ob_start();
    ?>
    <span class="currency-pricing-display" data-plan-id="<?php echo esc_attr($plan_id); ?>" data-currency="<?php echo esc_attr($currency['code']); ?>">
        <?php if ($atts['period'] === 'monthly' || $atts['period'] === 'both') : ?>
            <span class="monthly-price">
                <?php if ($atts['format'] === 'with_currency' || $atts['format'] === 'full_details') : ?>
                    <?php echo esc_html($currency['symbol']); ?>
                <?php endif; ?>
                <span class="price-amount" data-price-type="monthly"><?php echo number_format($monthly_price, 0); ?></span>
                <?php if ($atts['format'] === 'full_details') : ?>
                    <span class="price-period">/<?php _e('month', 'yoursite'); ?></span>
                <?php endif; ?>
            </span>
        <?php endif; ?>
        
        <?php if ($atts['period'] === 'annual') : ?>
            <span class="annual-price">
                <?php if ($atts['format'] === 'with_currency' || $atts['format'] === 'full_details') : ?>
                    <?php echo esc_html($currency['symbol']); ?>
                <?php endif; ?>
                <span class="price-amount" data-price-type="annual"><?php echo number_format($annual_price, 0); ?></span>
                <?php if ($atts['format'] === 'full_details') : ?>
                    <span class="price-period">/<?php _e('year', 'yoursite'); ?></span>
                <?php endif; ?>
            </span>
        <?php endif; ?>
        
        <?php if ($atts['period'] === 'both' && $annual_price > 0) : ?>
            <?php _e(' or ', 'yoursite'); ?>
            <span class="annual-price">
                <?php if ($atts['format'] === 'with_currency' || $atts['format'] === 'full_details') : ?>
                    <?php echo esc_html($currency['symbol']); ?>
                <?php endif; ?>
                <span class="price-amount" data-price-type="annual"><?php echo number_format($annual_price, 0); ?></span>
                <?php if ($atts['format'] === 'full_details') : ?>
                    <span class="price-period">/<?php _e('year', 'yoursite'); ?></span>
                <?php endif; ?>
            </span>
        <?php endif; ?>
        
        <?php if ($atts['show_original'] === 'true' && $currency['code'] !== yoursite_get_base_currency()['code']) : ?>
            <?php
            $base_currency = yoursite_get_base_currency();
            $base_monthly = function_exists('yoursite_get_pricing_plan_price') 
                ? yoursite_get_pricing_plan_price($plan_id, $base_currency['code'], 'monthly')
                : floatval(get_post_meta($plan_id, '_pricing_monthly_price', true));
            ?>
            <span class="original-price text-sm text-gray-500 ml-2">
                (<?php echo esc_html($base_currency['symbol']) . number_format($base_monthly, 0); ?>/<?php _e('month', 'yoursite'); ?>)
            </span>
        <?php endif; ?>
    </span>
    
    <script>
    document.addEventListener('currencyChanged', function(e) {
        const pricingDisplays = document.querySelectorAll('.currency-pricing-display[data-plan-id="<?php echo $plan_id; ?>"]');
        pricingDisplays.forEach(display => {
            // Update currency display
            display.setAttribute('data-currency', e.detail.currency);
            // Update prices via AJAX if available
            updatePricingDisplay(display, e.detail.currency);
        });
    });
    
    function updatePricingDisplay(display, currency) {
        // This would update the individual pricing display
        // Implementation depends on having the currency conversion functions available
    }
    </script>
    <?php
    
    return ob_get_clean();
}

add_shortcode('currency_pricing', 'yoursite_currency_pricing_shortcode');

/**
 * Enhanced helper functions for currency integration
 */
if (!function_exists('yoursite_get_pricing_meta_fields')) {
    function yoursite_get_pricing_meta_fields($post_id) {
        $defaults = array(
            'pricing_monthly_price' => '0',
            'pricing_annual_price' => '0',
            'pricing_currency' => 'USD',
            'pricing_featured' => '0',
            'pricing_button_text' => __('Get Started', 'yoursite'),
            'pricing_button_url' => '',
            'pricing_features' => '',
        );
        
        $meta = array();
        foreach ($defaults as $key => $default) {
            $value = get_post_meta($post_id, '_' . $key, true);
            $meta[$key] = !empty($value) ? $value : $default;
        }
        
        return $meta;
    }
}

/**
 * Enhanced currency symbol helper with more currencies
 */
if (!function_exists('yoursite_get_currency_symbol')) {
    function yoursite_get_currency_symbol($currency = 'USD') {
        $symbols = array(
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'CAD' => 'C',
            'AUD' => 'A',
            'JPY' => '¥',
            'CHF' => 'CHF',
            'SEK' => 'kr',
            'NOK' => 'kr',
            'DKK' => 'kr',
            'CNY' => '¥',
            'INR' => '₹',
            'BRL' => 'R',
            'RUB' => '₽',
            'KRW' => '₩',
            'MXN' => 'MXN',
            'SGD' => 'S',
            'NZD' => 'NZ',
            'HKD' => 'HK',
            'BTC' => '₿',
            'ETH' => 'Ξ',
            'USDC' => 'USDC'
        );
        
return isset($symbols[$currency]) ? $symbols[$currency] : '';
    }
}

/**
 * Add currency update notifications
 */
 
function yoursite_add_pricing_currency_notifications() {
    ?>
    <style>
    .currency-update-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 300px;
        padding: 12px 16px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        font-weight: 500;
        transition: all 0.3s ease;
        transform: translateX(100%);
    }
    
    .currency-update-notification.show {
        transform: translateX(0);
    }
    
    .currency-update-notification.success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    .currency-update-notification.error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    
    @media (max-width: 768px) {
        .currency-update-notification {
            left: 16px;
            right: 16px;
            top: 16px;
            transform: translateY(-100%);
            max-width: none;
        }
        
        .currency-update-notification.show {
            transform: translateY(0);
        }
    }
    </style>
    <?php
}

add_action('wp_footer', 'yoursite_add_pricing_currency_notifications');

/**
 * Register enhanced pricing widgets with currency support
 */
class YourSite_Pricing_Table_Widget_Enhanced extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'yoursite_pricing_table_enhanced',
            __('Enhanced Pricing Table', 'yoursite'),
            array('description' => __('Display a currency-aware pricing table widget', 'yoursite'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        // Build shortcode attributes
        $shortcode_atts = array();
        
        if (!empty($instance['plans'])) {
            $shortcode_atts[] = 'plans="' . esc_attr($instance['plans']) . '"';
        }
        
        if (isset($instance['show_toggle']) && !$instance['show_toggle']) {
            $shortcode_atts[] = 'show_toggle="false"';
        }
        
        if (isset($instance['show_features']) && !$instance['show_features']) {
            $shortcode_atts[] = 'show_features="false"';
        }
        
        if (isset($instance['show_currency_selector']) && !$instance['show_currency_selector']) {
            $shortcode_atts[] = 'show_currency_selector="false"';
        }
        
        if (!empty($instance['max_features']) && $instance['max_features'] != 5) {
            $shortcode_atts[] = 'max_features="' . intval($instance['max_features']) . '"';
        }
        
        if (!empty($instance['subtitle'])) {
            $shortcode_atts[] = 'subtitle="' . esc_attr($instance['subtitle']) . '"';
        }
        
        if (!empty($instance['currency'])) {
            $shortcode_atts[] = 'currency="' . esc_attr($instance['currency']) . '"';
        }
        
        $shortcode = '[pricing_table ' . implode(' ', $shortcode_atts) . ']';
        echo do_shortcode($shortcode);
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : '';
        $plans = !empty($instance['plans']) ? $instance['plans'] : 'all';
        $currency = !empty($instance['currency']) ? $instance['currency'] : '';
        $show_toggle = isset($instance['show_toggle']) ? (bool) $instance['show_toggle'] : true;
        $show_features = isset($instance['show_features']) ? (bool) $instance['show_features'] : true;
        $show_currency_selector = isset($instance['show_currency_selector']) ? (bool) $instance['show_currency_selector'] : true;
        $max_features = !empty($instance['max_features']) ? $instance['max_features'] : 5;
        
        // Get available plans
        $available_plans = get_posts(array(
            'post_type' => 'pricing',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        ));
        
        // Get available currencies
        $available_currencies = function_exists('yoursite_get_active_currencies') ? yoursite_get_active_currencies() : array();
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>">
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('plans'); ?>"><?php _e('Plans to Show:', 'yoursite'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('plans'); ?>" name="<?php echo $this->get_field_name('plans'); ?>">
                <option value="all" <?php selected($plans, 'all'); ?>><?php _e('All Plans', 'yoursite'); ?></option>
                <?php foreach ($available_plans as $plan) : ?>
                    <option value="<?php echo $plan->ID; ?>" <?php selected($plans, $plan->ID); ?>>
                        <?php echo esc_html($plan->post_title); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        
        <?php if (!empty($available_currencies)) : ?>
        <p>
            <label for="<?php echo $this->get_field_id('currency'); ?>"><?php _e('Fixed Currency (optional):', 'yoursite'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('currency'); ?>" name="<?php echo $this->get_field_name('currency'); ?>">
                <option value="" <?php selected($currency, ''); ?>><?php _e('Use current user currency', 'yoursite'); ?></option>
                <?php foreach ($available_currencies as $curr) : ?>
                    <option value="<?php echo esc_attr($curr['code']); ?>" <?php selected($currency, $curr['code']); ?>>
                        <?php echo esc_html($curr['flag'] . ' ' . $curr['code'] . ' - ' . $curr['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php endif; ?>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_currency_selector); ?> id="<?php echo $this->get_field_id('show_currency_selector'); ?>" name="<?php echo $this->get_field_name('show_currency_selector'); ?>" />
            <label for="<?php echo $this->get_field_id('show_currency_selector'); ?>"><?php _e('Show currency selector', 'yoursite'); ?></label>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_toggle); ?> id="<?php echo $this->get_field_id('show_toggle'); ?>" name="<?php echo $this->get_field_name('show_toggle'); ?>" />
            <label for="<?php echo $this->get_field_id('show_toggle'); ?>"><?php _e('Show billing toggle', 'yoursite'); ?></label>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_features); ?> id="<?php echo $this->get_field_id('show_features'); ?>" name="<?php echo $this->get_field_name('show_features'); ?>" />
            <label for="<?php echo $this->get_field_id('show_features'); ?>"><?php _e('Show features list', 'yoursite'); ?></label>
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('max_features'); ?>"><?php _e('Max Features:', 'yoursite'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('max_features'); ?>" name="<?php echo $this->get_field_name('max_features'); ?>" type="number" step="1" min="1" max="20" value="<?php echo esc_attr($max_features); ?>" size="3" />
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['subtitle'] = (!empty($new_instance['subtitle'])) ? sanitize_text_field($new_instance['subtitle']) : '';
        $instance['plans'] = (!empty($new_instance['plans'])) ? sanitize_text_field($new_instance['plans']) : 'all';
        $instance['currency'] = (!empty($new_instance['currency'])) ? sanitize_text_field($new_instance['currency']) : '';
        $instance['show_currency_selector'] = !empty($new_instance['show_currency_selector']);
        $instance['show_toggle'] = !empty($new_instance['show_toggle']);
        $instance['show_features'] = !empty($new_instance['show_features']);
        $instance['max_features'] = (!empty($new_instance['max_features'])) ? absint($new_instance['max_features']) : 5;
        
        return $instance;
    }
}

// Register the enhanced widget
function yoursite_register_enhanced_pricing_widgets() {
    register_widget('YourSite_Pricing_Table_Widget_Enhanced');
}
add_action('widgets_init', 'yoursite_register_enhanced_pricing_widgets');

/**
 * Add currency-aware pricing assets
 */
function yoursite_enqueue_currency_pricing_assets() {
    // Only enqueue on pages that might have pricing shortcodes
    if (is_admin() || !is_singular()) {
        return;
    }
    
    global $post;
    if ($post && (has_shortcode($post->post_content, 'pricing_table') || 
                  has_shortcode($post->post_content, 'pricing_cards') || 
                  has_shortcode($post->post_content, 'pricing_comparison') ||
                  has_shortcode($post->post_content, 'currency_pricing'))) {
        
        // Enqueue necessary scripts
        wp_enqueue_script('jquery');
        
        // Add AJAX URL and nonces for currency updates
        wp_localize_script('jquery', 'pricingCurrencyAjax', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('pricing_currency_nonce'),
            'strings' => array(
                'updating' => __('Updating prices...', 'yoursite'),
                'updated' => __('Prices updated successfully', 'yoursite'),
                'error' => __('Error updating prices', 'yoursite')
            )
        ));
        
        // Add inline styles for better compatibility
        wp_add_inline_style('yoursite-style', '
            .pricing-scroll-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
            
            .pricing-scroll-container::-webkit-scrollbar {
                display: none;
            }
            
            .enhanced-pricing-section.currency-loading {
                position: relative;
            }
            
            .enhanced-pricing-section.currency-loading::after {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(255, 255, 255, 0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10;
            }
            
            .pricing-price-amount.updating {
                opacity: 0.5;
                transform: scale(0.95);
                transition: all 0.3s ease;
            }
            
            @media (max-width: 768px) {
                .pricing-card.featured {
                    transform: none !important;
                }
                
                .pricing-scroll-btn {
                    display: none !important;
                }
                
                .enhanced-pricing-section .container .flex-wrap {
                    flex-direction: column;
                    gap: 1rem;
                }
            }
        ');
    }
}
add_action('wp_enqueue_scripts', 'yoursite_enqueue_currency_pricing_assets', 20);

/**
 * Enhanced shortcode documentation with currency examples
 */
function yoursite_add_currency_pricing_shortcode_help() {
    $screen = get_current_screen();
    if ($screen && in_array($screen->id, array('edit-pricing', 'pricing'))) {
        $screen->add_help_tab(array(
            'id' => 'currency-pricing-shortcodes',
            'title' => __('Currency-Aware Shortcodes', 'yoursite'),
            'content' => '
                <h3>' . __('Currency-Enabled Shortcodes', 'yoursite') . '</h3>
                
                <h4>[pricing_table] - Enhanced with Currency</h4>
                <p>' . __('All pricing tables now support automatic currency switching.', 'yoursite') . '</p>
                <p><strong>' . __('New Parameters:', 'yoursite') . '</strong></p>
                <ul>
                    <li><code>show_currency_selector</code> - ' . __('Show currency selector (true/false)', 'yoursite') . '</li>
                    <li><code>currency</code> - ' . __('Force specific currency (USD, EUR, etc.)', 'yoursite') . '</li>
                </ul>
                
                <h4>[currency_pricing] - New Shortcode</h4>
                <p>' . __('Display individual plan pricing in any currency.', 'yoursite') . '</p>
                <p><strong>' . __('Parameters:', 'yoursite') . '</strong></p>
                <ul>
                    <li><code>plan</code> - ' . __('Plan ID (required)', 'yoursite') . '</li>
                    <li><code>currency</code> - ' . __('Currency code', 'yoursite') . '</li>
                    <li><code>period</code> - ' . __('monthly, annual, or both', 'yoursite') . '</li>
                    <li><code>format</code> - ' . __('price_only, with_currency, or full_details', 'yoursite') . '</li>
                    <li><code>show_original</code> - ' . __('Show original currency price', 'yoursite') . '</li>
                </ul>
                
                <h4>' . __('Examples:', 'yoursite') . '</h4>
                <code>[pricing_table show_currency_selector="true"]</code><br>
                <code>[pricing_table currency="EUR" show_currency_selector="false"]</code><br>
                <code>[currency_pricing plan="123" currency="GBP" period="both"]</code><br>
                <code>[currency_pricing plan="123" format="full_details" show_original="true"]</code>
                
                <h4>' . __('Currency Integration Features:', 'yoursite') . '</h4>
                <ul>
                    <li>' . __('Automatic price conversion between currencies', 'yoursite') . '</li>
                    <li>' . __('Real-time currency switching without page reload', 'yoursite') . '</li>
                    <li>' . __('Currency selector integration', 'yoursite') . '</li>
                    <li>' . __('Savings calculations in selected currency', 'yoursite') . '</li>
                    <li>' . __('Mobile-responsive currency controls', 'yoursite') . '</li>
                </ul>
            '
        ));
    }
}
add_action('admin_head', 'yoursite_add_currency_pricing_shortcode_help');

/**
 * Add currency pricing to quicktags
 */
function yoursite_add_currency_pricing_quicktags() {
    if (wp_script_is('quicktags')) {
        ?>
        <script type="text/javascript">
        if (typeof QTags !== 'undefined') {
            QTags.addButton('pricing_table_currency', '💰🌍 Pricing+Currency', '[pricing_table show_currency_selector="true"]', '', '', '<?php _e('Insert Currency-Aware Pricing Table', 'yoursite'); ?>');
            QTags.addButton('currency_pricing', '💱 Price', '[currency_pricing plan="" currency=""]', '', '', '<?php _e('Insert Currency Pricing', 'yoursite'); ?>');
        }
        </script>
        <?php
    }
}
add_action('admin_print_footer_scripts', 'yoursite_add_currency_pricing_quicktags');

/**
 * Currency pricing AJAX handler
 */
function yoursite_ajax_get_currency_pricing_enhanced() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'pricing_currency_nonce')) {
        wp_send_json_error(__('Security check failed', 'yoursite'));
    }
    
    $plan_id = intval($_POST['plan_id'] ?? 0);
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (!$plan_id || !$currency_code) {
        wp_send_json_error(__('Invalid parameters', 'yoursite'));
    }
    
    // Get plan
    $plan = get_post($plan_id);
    if (!$plan || $plan->post_type !== 'pricing') {
        wp_send_json_error(__('Plan not found', 'yoursite'));
    }
    
    // Get currency
    $currency = function_exists('yoursite_get_currency') ? yoursite_get_currency($currency_code) : null;
    if (!$currency) {
        wp_send_json_error(__('Currency not found', 'yoursite'));
    }
    
    // Get pricing
    $monthly_price = 0;
    $annual_price = 0;
    
    if (function_exists('yoursite_get_pricing_plan_price')) {
        $monthly_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'monthly');
        $annual_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'annual');
    } else {
        // Fallback to meta values
        $meta = yoursite_get_pricing_meta_fields($plan_id);
        $monthly_price = floatval($meta['pricing_monthly_price']);
        $annual_price = floatval($meta['pricing_annual_price']);
        
        // Convert if currency system is available
        if (function_exists('yoursite_convert_price') && $currency_code !== 'USD') {
            $base_currency = function_exists('yoursite_get_base_currency') ? yoursite_get_base_currency() : array('code' => 'USD');
            $monthly_price = yoursite_convert_price($monthly_price, $base_currency['code'], $currency_code);
            if ($annual_price > 0) {
                $annual_price = yoursite_convert_price($annual_price, $base_currency['code'], $currency_code);
            }
        }
    }
    
    // Calculate derived values
    if ($annual_price == 0 && $monthly_price > 0) {
        $annual_price = $monthly_price * 12 * 0.8; // 20% discount
    }
    
    $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
    $savings = ($monthly_price * 12) - $annual_price;
    
    // Format prices
    $response_data = array(
        'monthly_price' => $currency['symbol'] . number_format($monthly_price, 0),
        'annual_price' => $currency['symbol'] . number_format($annual_price, 0),
        'annual_monthly_equivalent' => $currency['symbol'] . number_format($annual_monthly, 0),
        'savings' => $savings > 0 ? $currency['symbol'] . number_format($savings, 0) : '',
        'raw_monthly' => $monthly_price,
        'raw_annual' => $annual_price,
        'raw_annual_monthly' => $annual_monthly,
        'raw_savings' => $savings,
        'currency' => $currency
    );
    
    wp_send_json_success($response_data);
}
add_action('wp_ajax_get_currency_pricing_enhanced', 'yoursite_ajax_get_currency_pricing_enhanced');
add_action('wp_ajax_nopriv_get_currency_pricing_enhanced', 'yoursite_ajax_get_currency_pricing_enhanced');

// Also handle the original action name for compatibility
add_action('wp_ajax_get_currency_pricing', 'yoursite_ajax_get_currency_pricing_enhanced');
add_action('wp_ajax_nopriv_get_currency_pricing', 'yoursite_ajax_get_currency_pricing_enhanced');

/**
 * Cached pricing plans with currency support
 */
function yoursite_get_cached_pricing_plans_with_currency($args = array()) {
    $current_currency = function_exists('yoursite_get_user_currency') ? yoursite_get_user_currency() : array('code' => 'USD');
    $cache_key = 'yoursite_pricing_plans_currency_' . $current_currency['code'] . '_' . md5(serialize($args));
    $cached_plans = get_transient($cache_key);
    
    if (false === $cached_plans) {
        $default_args = array(
            'post_type' => 'pricing',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_key' => '_pricing_monthly_price',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        );
        
        $query_args = wp_parse_args($args, $default_args);
        $cached_plans = get_posts($query_args);
        
        // Cache for 30 minutes (shorter than regular cache due to currency changes)
        set_transient($cache_key, $cached_plans, 30 * MINUTE_IN_SECONDS);
    }
    
    return $cached_plans;
}

/**
 * Clear currency pricing cache when plans or currencies are updated
 */
function yoursite_clear_currency_pricing_cache($post_id = null) {
    if ($post_id && get_post_type($post_id) !== 'pricing') {
        return;
    }
    
    // Clear all currency pricing related transients
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_yoursite_pricing_plans_currency_%'");
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_yoursite_pricing_plans_currency_%'");
}
add_action('save_post', 'yoursite_clear_currency_pricing_cache');
add_action('delete_post', 'yoursite_clear_currency_pricing_cache');

// Clear cache when currency rates are updated
add_action('yoursite_currency_rates_updated', 'yoursite_clear_currency_pricing_cache');

/**
 * Enhanced admin interface updates for currency-aware shortcodes
 */
function yoursite_enhanced_pricing_shortcode_modal_updates() {
    static $modal_updated = false;
    if ($modal_updated) return;
    $modal_updated = true;
    
    // Update the existing modal to include currency options
    add_action('admin_footer', function() {
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Add currency options to existing modal if currency system is available
            if (typeof currencyAjax !== 'undefined') {
                const currencyRow = `
                    <tr class="pricing-table-options">
                        <th><label for="currency-selector"><?php _e('Currency', 'yoursite'); ?></label></th>
                        <td>
                            <select id="currency-selector">
                                <option value=""><?php _e('Use current user currency', 'yoursite'); ?></option>
                                <option value="USD">🇺🇸 USD - US Dollar</option>
                                <option value="EUR">🇪🇺 EUR - Euro</option>
                                <option value="GBP">🇬🇧 GBP - British Pound</option>
                                <option value="CAD">🇨🇦 CAD - Canadian Dollar</option>
                                <option value="AUD">🇦🇺 AUD - Australian Dollar</option>
                            </select>
                            <p class="description"><?php _e('Force specific currency or leave empty for user selection', 'yoursite'); ?></p>
                        </td>
                    </tr>
                    <tr class="pricing-table-options">
                        <th><label for="show-currency-selector"><?php _e('Currency Selector', 'yoursite'); ?></label></th>
                        <td>
                            <label>
                                <input type="checkbox" id="show-currency-selector" checked>
                                <?php _e('Show currency selector widget', 'yoursite'); ?>
                            </label>
                        </td>
                    </tr>
                `;
                
                // Insert after existing options
                $('#show-features').closest('tr').after(currencyRow);
                
                // Update the preview function to include currency options
                const originalUpdatePreview = updateShortcodePreview;
                updateShortcodePreview = function() {
                    originalUpdatePreview();
                    
                    let shortcode = $('#shortcode-preview').text();
                    
                    const currency = $('#currency-selector').val();
                    if (currency) {
                        shortcode = shortcode.slice(0, -1) + ' currency="' + currency + '"]';
                    }
                    
                    if (!$('#show-currency-selector').is(':checked')) {
                        shortcode = shortcode.slice(0, -1) + ' show_currency_selector="false"]';
                    }
                    
                    $('#shortcode-preview').text(shortcode);
                };
                
                // Update event listeners
                $('#currency-selector, #show-currency-selector').on('change', updateShortcodePreview);
            }
        });
        </script>
        <?php
    });
}
add_action('admin_init', 'yoursite_enhanced_pricing_shortcode_modal_updates');
?>
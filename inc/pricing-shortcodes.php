<?php
/**
 * Enhanced Pricing Shortcodes with Homepage-Style Layout and Horizontal Scroll
 * File: inc/pricing-shortcodes.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enhanced Pricing Table Shortcode with Homepage-Style Design
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
        'show_trial_text' => 'true'
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

    // Determine if we need horizontal scroll
    $plan_count = count($plans);
    $needs_scroll = $plan_count > 3;
    $grid_class = $needs_scroll ? 'pricing-scroll-container' : 'pricing-static-grid';
    
    // Generate unique ID for this pricing table
    $table_id = 'pricing-table-' . uniqid();
    
    ob_start();
    ?>
    
    <div class="enhanced-pricing-section py-12 bg-white dark:bg-gray-800" id="<?php echo esc_attr($table_id); ?>">
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
        
        <!-- Billing Toggle -->
        <?php if ($atts['show_toggle'] === 'true') : ?>
        <div class="container mx-auto px-4 mb-12">
            <div class="flex items-center justify-center flex-wrap gap-4">
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
        </div>
        <?php endif; ?>
        
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
                        <div class="pricing-cards-wrapper flex gap-6 transition-transform duration-300 ease-in-out" style="width: <?php echo ($plan_count * 340) + (($plan_count - 1) * 24); ?>px;">
                            <?php foreach ($plans as $plan) : ?>
                                <?php echo yoursite_render_pricing_card($plan, $atts); ?>
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
                        <?php echo yoursite_render_pricing_card($plan, $atts); ?>
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
    
    <!-- Enhanced Styles -->
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
    
    <!-- Enhanced JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        initializePricingTable('<?php echo $table_id; ?>');
    });
    
    function initializePricingTable(tableId) {
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
 * Render individual pricing card with homepage styling
 */
function yoursite_render_pricing_card($plan, $atts) {
    $meta = yoursite_get_pricing_meta_fields($plan->ID);
    $is_featured = $meta['pricing_featured'] === '1' || $plan->ID == $atts['featured_plan'];
    $monthly_price = floatval($meta['pricing_monthly_price']);
    $annual_price = floatval($meta['pricing_annual_price']);
    $currency_symbol = yoursite_get_currency_symbol($meta['pricing_currency']);
    
    // Calculate annual monthly equivalent if not set
    if ($annual_price == 0 && $monthly_price > 0) {
        $annual_price = $monthly_price * 12 * 0.8; // 20% discount
    }
    $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
    
    ob_start();
    ?>
    <div class="pricing-card <?php echo $is_featured ? 'featured' : ''; ?>">
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
            
            <!-- Price Display with Toggle -->
            <div class="mb-6">
                <!-- Monthly Pricing -->
                <div class="pricing-monthly-pricing">
                    <div class="flex items-baseline justify-center mb-2">
                        <span class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">
                            <?php echo $currency_symbol . number_format($monthly_price, 0); ?>
                        </span>
                        <span class="text-gray-600 dark:text-gray-300 text-lg ml-2">
                            /<?php _e('month', 'yoursite'); ?>
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <?php printf(__('Billed monthly (%s)', 'yoursite'), $currency_symbol . number_format($monthly_price, 0)); ?>
                    </div>
                </div>
                
                <!-- Annual Pricing -->
                <div class="pricing-annual-pricing">
                    <div class="flex items-baseline justify-center mb-2">
                        <span class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">
                            <?php echo $currency_symbol . number_format($annual_monthly, 0); ?>
                        </span>
                        <span class="text-gray-600 dark:text-gray-300 text-lg ml-2">
                            /<?php _e('month', 'yoursite'); ?>
                        </span>
                    </div>
                    <?php if ($annual_price > 0) : ?>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <?php printf(__('Billed annually (%s)', 'yoursite'), $currency_symbol . number_format($annual_price, 0)); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Savings Badge (Annual) -->
                <?php if ($monthly_price > 0 && $annual_price > 0) : ?>
                    <div class="pricing-annual-savings">
                        <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-4 py-2 rounded-full text-sm font-semibold inline-block">
                            <?php printf(__('Save %s per year', 'yoursite'), $currency_symbol . number_format(($monthly_price * 12) - $annual_price, 0)); ?>
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
 * Simple pricing cards shortcode (legacy support)
 */
function yoursite_pricing_cards_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => '3',
        'columns' => '3'
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
    
    // Use the enhanced pricing table
    return yoursite_pricing_table_shortcode(array(
        'plans' => implode(',', $plan_ids),
        'show_toggle' => 'true',
        'show_features' => 'true',
        'max_features' => '5'
    ));
}

add_shortcode('pricing_cards', 'yoursite_pricing_cards_shortcode');

/**
 * Enhanced pricing comparison shortcode
 */
function yoursite_pricing_comparison_shortcode($atts) {
    $atts = shortcode_atts(array(
        'plans' => 'all',
        'title' => __('Compare All Plans', 'yoursite'),
        'subtitle' => __('Choose the perfect plan for your business', 'yoursite')
    ), $atts, 'pricing_comparison');
    
    // Check if the comparison function exists
    if (!function_exists('yoursite_render_pricing_comparison_table')) {
        return '<p>' . __('Pricing comparison feature not available.', 'yoursite') . '</p>';
    }
    
    ob_start();
    ?>
    <div class="pricing-comparison-section py-12">
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
        
        <?php echo yoursite_render_pricing_comparison_table(); ?>
    </div>
    <?php
    
    return ob_get_clean();
}

add_shortcode('pricing_comparison', 'yoursite_pricing_comparison_shortcode');

/**
 * Get currency symbol helper function - FIXED SYNTAX
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
            'DKK' => 'kr'
        );
return isset($symbols[$currency]) ? $symbols[$currency] : '$';
    }
}

/**
 * Add admin interface for easy shortcode generation
 */

function yoursite_add_pricing_shortcode_button() {
    if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
        add_action('media_buttons', 'yoursite_pricing_shortcode_button');
    }
    
}add_action('admin_init', 'yoursite_add_pricing_shortcode_button');

function yoursite_pricing_shortcode_button() {
    echo '<button type="button" class="button pricing-shortcode-button" data-editor="content">
        <span class="dashicons dashicons-money-alt" style="vertical-align: middle;"></span> ' . __('Add Pricing Table', 'yoursite') . '
    </button>';
    
    // Add modal for shortcode generation
    add_action('admin_footer', 'yoursite_pricing_shortcode_modal');
}

function yoursite_pricing_shortcode_modal() {
    static $modal_added = false;
    if ($modal_added) return;
    $modal_added = true;
    
    // Get available pricing plans
    $plans = get_posts(array(
        'post_type' => 'pricing',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    ?>
    
    <div id="pricing-shortcode-modal" style="display: none;">
        <div class="pricing-shortcode-modal-content">
            <h3><?php _e('Insert Pricing Table', 'yoursite'); ?></h3>
            
            <table class="form-table">
                <tr>
                    <th><label for="shortcode-type"><?php _e('Table Type', 'yoursite'); ?></label></th>
                    <td>
                        <select id="shortcode-type">
                            <option value="pricing_table"><?php _e('Enhanced Pricing Cards', 'yoursite'); ?></option>
                            <option value="pricing_comparison"><?php _e('Feature Comparison Table', 'yoursite'); ?></option>
                        </select>
                    </td>
                </tr>
                
                <tr class="pricing-table-options">
                    <th><label for="selected-plans"><?php _e('Plans to Show', 'yoursite'); ?></label></th>
                    <td>
                        <select id="selected-plans" multiple style="height: 120px; width: 100%;">
                            <option value="all" selected><?php _e('All Plans', 'yoursite'); ?></option>
                            <?php foreach ($plans as $plan) : ?>
                                <option value="<?php echo $plan->ID; ?>"><?php echo esc_html($plan->post_title); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description"><?php _e('Hold Ctrl/Cmd to select multiple plans', 'yoursite'); ?></p>
                    </td>
                </tr>
                
                <tr class="pricing-table-options">
                    <th><label for="show-toggle"><?php _e('Billing Toggle', 'yoursite'); ?></label></th>
                    <td>
                        <label>
                            <input type="checkbox" id="show-toggle" checked>
                            <?php _e('Show monthly/annual toggle', 'yoursite'); ?>
                        </label>
                    </td>
                </tr>
                
                <tr class="pricing-table-options">
                    <th><label for="show-features"><?php _e('Features List', 'yoursite'); ?></label></th>
                    <td>
                        <label>
                            <input type="checkbox" id="show-features" checked>
                            <?php _e('Show features list', 'yoursite'); ?>
                        </label>
                    </td>
                </tr>
                
                <tr class="pricing-table-options">
                    <th><label for="max-features"><?php _e('Max Features', 'yoursite'); ?></label></th>
                    <td>
                        <input type="number" id="max-features" value="5" min="1" max="20">
                        <p class="description"><?php _e('Maximum number of features to display per plan', 'yoursite'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th><label for="section-title"><?php _e('Section Title', 'yoursite'); ?></label></th>
                    <td>
                        <input type="text" id="section-title" placeholder="<?php _e('Optional section title', 'yoursite'); ?>">
                    </td>
                </tr>
                
                <tr>
                    <th><label for="section-subtitle"><?php _e('Section Subtitle', 'yoursite'); ?></label></th>
                    <td>
                        <input type="text" id="section-subtitle" placeholder="<?php _e('Optional section subtitle', 'yoursite'); ?>">
                    </td>
                </tr>
            </table>
            
            <div class="pricing-shortcode-preview">
                <h4><?php _e('Shortcode Preview:', 'yoursite'); ?></h4>
                <code id="shortcode-preview">[pricing_table]</code>
            </div>
            
            <div class="pricing-shortcode-actions">
                <button type="button" class="button-primary" id="insert-pricing-shortcode">
                    <?php _e('Insert Shortcode', 'yoursite'); ?>
                </button>
                <button type="button" class="button" id="cancel-pricing-shortcode">
                    <?php _e('Cancel', 'yoursite'); ?>
                </button>
            </div>
        </div>
    </div>
    
    <style>
    #pricing-shortcode-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .pricing-shortcode-modal-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .pricing-shortcode-modal-content h3 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 18px;
    }
    
    .pricing-shortcode-preview {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 4px;
        margin: 20px 0;
    }
    
    .pricing-shortcode-preview code {
        background: white;
        padding: 10px;
        border-radius: 4px;
        display: block;
        font-family: monospace;
        word-wrap: break-word;
    }
    
    .pricing-shortcode-actions {
        text-align: right;
        margin-top: 20px;
    }
    
    .pricing-shortcode-actions .button {
        margin-left: 10px;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Open modal
        $(document).on('click', '.pricing-shortcode-button', function(e) {
            e.preventDefault();
            $('#pricing-shortcode-modal').show();
            updateShortcodePreview();
        });
        
        // Close modal
        $('#cancel-pricing-shortcode, #pricing-shortcode-modal').on('click', function(e) {
            if (e.target === this) {
                $('#pricing-shortcode-modal').hide();
            }
        });
        
        // Update preview when options change
        $('#shortcode-type, #selected-plans, #show-toggle, #show-features, #max-features, #section-title, #section-subtitle').on('change keyup', function() {
            updateShortcodePreview();
            toggleOptions();
        });
        
        // Toggle options based on shortcode type
        function toggleOptions() {
            const type = $('#shortcode-type').val();
            if (type === 'pricing_comparison') {
                $('.pricing-table-options').hide();
            } else {
                $('.pricing-table-options').show();
            }
        }
        
        // Update shortcode preview
        function updateShortcodePreview() {
            const type = $('#shortcode-type').val();
            let shortcode = '[' + type;
            
            // Add parameters based on type
            if (type === 'pricing_table') {
                const selectedPlans = $('#selected-plans').val();
                if (selectedPlans && selectedPlans.length > 0 && !selectedPlans.includes('all')) {
                    shortcode += ' plans="' + selectedPlans.join(',') + '"';
                }
                
                if (!$('#show-toggle').is(':checked')) {
                    shortcode += ' show_toggle="false"';
                }
                
                if (!$('#show-features').is(':checked')) {
                    shortcode += ' show_features="false"';
                } else {
                    const maxFeatures = $('#max-features').val();
                    if (maxFeatures && maxFeatures !== '5') {
                        shortcode += ' max_features="' + maxFeatures + '"';
                    }
                }
            }
            
            // Add title and subtitle
            const title = $('#section-title').val().trim();
            const subtitle = $('#section-subtitle').val().trim();
            
            if (title) {
                shortcode += ' title="' + title + '"';
            }
            
            if (subtitle) {
                shortcode += ' subtitle="' + subtitle + '"';
            }
            
            shortcode += ']';
            
            $('#shortcode-preview').text(shortcode);
        }
        
        // Insert shortcode
        $('#insert-pricing-shortcode').on('click', function() {
            const shortcode = $('#shortcode-preview').text();
            
            // Insert into editor
            if (typeof tinymce !== 'undefined' && tinymce.activeEditor && !tinymce.activeEditor.isHidden()) {
                tinymce.activeEditor.insertContent(shortcode);
            } else {
                // Insert into text editor
                const editor = document.getElementById('content');
                if (editor) {
                    const startPos = editor.selectionStart;
                    const endPos = editor.selectionEnd;
                    editor.value = editor.value.substring(0, startPos) + shortcode + editor.value.substring(endPos, editor.value.length);
                    editor.selectionStart = editor.selectionEnd = startPos + shortcode.length;
                }
            }
            
            $('#pricing-shortcode-modal').hide();
        });
        
        // Initialize
        toggleOptions();
    });
    </script>
    <?php
}

/**
 * Enhanced helper functions for better compatibility
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
 * Register pricing table widget for use in sidebars
 */
class YourSite_Pricing_Table_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'yoursite_pricing_table',
            __('Pricing Table', 'yoursite'),
            array('description' => __('Display a pricing table widget', 'yoursite'))
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
        
        if (!empty($instance['max_features']) && $instance['max_features'] != 5) {
            $shortcode_atts[] = 'max_features="' . intval($instance['max_features']) . '"';
        }
        
        if (!empty($instance['subtitle'])) {
            $shortcode_atts[] = 'subtitle="' . esc_attr($instance['subtitle']) . '"';
        }
        
        $shortcode = '[pricing_table ' . implode(' ', $shortcode_atts) . ']';
        echo do_shortcode($shortcode);
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : '';
        $plans = !empty($instance['plans']) ? $instance['plans'] : 'all';
        $show_toggle = isset($instance['show_toggle']) ? (bool) $instance['show_toggle'] : true;
        $show_features = isset($instance['show_features']) ? (bool) $instance['show_features'] : true;
        $max_features = !empty($instance['max_features']) ? $instance['max_features'] : 5;
        
        // Get available plans
        $available_plans = get_posts(array(
            'post_type' => 'pricing',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        ));
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
        $instance['show_toggle'] = !empty($new_instance['show_toggle']);
        $instance['show_features'] = !empty($new_instance['show_features']);
        $instance['max_features'] = (!empty($new_instance['max_features'])) ? absint($new_instance['max_features']) : 5;
        
        return $instance;
    }
}

// Register the widget
function yoursite_register_pricing_widgets() {
    register_widget('YourSite_Pricing_Table_Widget');
}
add_action('widgets_init', 'yoursite_register_pricing_widgets');

/**
 * Add CSS and JS dependencies 
 */
function yoursite_enqueue_pricing_assets() {
    // Only enqueue on pages that might have pricing shortcodes
    if (is_admin() || !is_singular()) {
        return;
    }
    
    global $post;
    if ($post && (has_shortcode($post->post_content, 'pricing_table') || 
                  has_shortcode($post->post_content, 'pricing_cards') || 
                  has_shortcode($post->post_content, 'pricing_comparison'))) {
        
        // Enqueue any additional CSS/JS if needed
        wp_enqueue_script('jquery');
        
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
            
            @media (max-width: 768px) {
                .pricing-card.featured {
                    transform: none !important;
                }
                
                .pricing-scroll-btn {
                    display: none !important;
                }
            }
        ');
    }
}
add_action('wp_enqueue_scripts', 'yoursite_enqueue_pricing_assets', 20);

/**
 * Add pricing table button to classic editor
 */
function yoursite_add_pricing_quicktags() {
    if (wp_script_is('quicktags')) {
        ?>
        <script type="text/javascript">
        if (typeof QTags !== 'undefined') {
            QTags.addButton('pricing_table', '💰 Pricing', '[pricing_table]', '', '', '<?php _e('Insert Pricing Table', 'yoursite'); ?>');
            QTags.addButton('pricing_comparison', '📊 Compare', '[pricing_comparison]', '', '', '<?php _e('Insert Pricing Comparison', 'yoursite'); ?>');
        }
        </script>
        <?php
    }
}
add_action('admin_print_footer_scripts', 'yoursite_add_pricing_quicktags');

/**
 * Add pricing shortcode documentation to admin
 */
function yoursite_add_pricing_shortcode_help() {
    $screen = get_current_screen();
    if ($screen && in_array($screen->id, array('edit-pricing', 'pricing'))) {
        $screen->add_help_tab(array(
            'id' => 'pricing-shortcodes',
            'title' => __('Pricing Shortcodes', 'yoursite'),
            'content' => '
                <h3>' . __('Available Shortcodes', 'yoursite') . '</h3>
                <h4>[pricing_table]</h4>
                <p>' . __('Display pricing cards with homepage-style design.', 'yoursite') . '</p>
                <p><strong>' . __('Parameters:', 'yoursite') . '</strong></p>
                <ul>
                    <li><code>plans</code> - ' . __('Comma-separated plan IDs or "all"', 'yoursite') . '</li>
                    <li><code>show_toggle</code> - ' . __('Show billing toggle (true/false)', 'yoursite') . '</li>
                    <li><code>show_features</code> - ' . __('Show features list (true/false)', 'yoursite') . '</li>
                    <li><code>max_features</code> - ' . __('Maximum features to display', 'yoursite') . '</li>
                    <li><code>title</code> - ' . __('Section title', 'yoursite') . '</li>
                    <li><code>subtitle</code> - ' . __('Section subtitle', 'yoursite') . '</li>
                    <li><code>featured_plan</code> - ' . __('Plan ID to highlight as featured', 'yoursite') . '</li>
                </ul>
                
                <h4>[pricing_comparison]</h4>
                <p>' . __('Display detailed feature comparison table.', 'yoursite') . '</p>
                
                <h4>' . __('Examples:', 'yoursite') . '</h4>
                <code>[pricing_table plans="1,2,3" title="Choose Your Plan"]</code><br>
                <code>[pricing_comparison title="Compare All Plans"]</code>
            '
        ));
    }
}
add_action('admin_head', 'yoursite_add_pricing_shortcode_help');

/**
 * Cache pricing plans for better performance
 */
function yoursite_get_cached_pricing_plans($args = array()) {
    $cache_key = 'yoursite_pricing_plans_' . md5(serialize($args));
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
        
        // Cache for 1 hour
        set_transient($cache_key, $cached_plans, HOUR_IN_SECONDS);
    }
    
    return $cached_plans;
}

/**
 * Clear pricing cache when plans are updated
 */
function yoursite_clear_pricing_cache($post_id) {
    if (get_post_type($post_id) === 'pricing') {
        // Clear all pricing related transients
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_yoursite_pricing_plans_%'");
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_yoursite_pricing_plans_%'");
    }
}
add_action('save_post', 'yoursite_clear_pricing_cache');
add_action('delete_post', 'yoursite_clear_pricing_cache');

/**
 * Add support for pricing shortcodes in excerpts
 */
function yoursite_pricing_shortcodes_in_excerpts($content) {
    if (has_shortcode($content, 'pricing_table') || 
        has_shortcode($content, 'pricing_cards') || 
        has_shortcode($content, 'pricing_comparison')) {
        return do_shortcode($content);
    }
    return $content;
}
add_filter('the_excerpt', 'yoursite_pricing_shortcodes_in_excerpts');

/**
 * Add pricing shortcode examples to the help section
 */
function yoursite_add_pricing_examples_help() {
    $screen = get_current_screen();
    if ($screen && ($screen->post_type === 'page' || $screen->post_type === 'post')) {
        $screen->add_help_tab(array(
            'id' => 'pricing-shortcode-examples',
            'title' => __('Pricing Shortcode Examples', 'yoursite'),
            'content' => '
                <h3>' . __('Quick Examples', 'yoursite') . '</h3>
                <h4>' . __('Basic pricing table:', 'yoursite') . '</h4>
                <code>[pricing_table]</code>
                
                <h4>' . __('With custom title:', 'yoursite') . '</h4>
                <code>[pricing_table title="Choose Your Plan" subtitle="Perfect for every business"]</code>
                
                <h4>' . __('Specific plans only:', 'yoursite') . '</h4>
                <code>[pricing_table plans="1,2,3"]</code>
                
                <h4>' . __('No billing toggle:', 'yoursite') . '</h4>
                <code>[pricing_table show_toggle="false"]</code>
                
                <h4>' . __('Limited features:', 'yoursite') . '</h4>
                <code>[pricing_table max_features="3"]</code>
                
                <h4>' . __('Comparison table:', 'yoursite') . '</h4>
                <code>[pricing_comparison title="Compare All Features"]</code>
            '
        ));
    }
}
add_action('load-post.php', 'yoursite_add_pricing_examples_help');
add_action('load-post-new.php', 'yoursite_add_pricing_examples_help');
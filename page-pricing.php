<!-- Complete Clean Pricing Page CSS with Carousel -->
<style>
/* Homepage-style pricing grid for 1-3 plans */
.homepage-pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

/* Pricing card base styling */
.pricing-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    display: flex;
    flex-direction: column;
    min-height: 500px;
    position: relative;
    transition: all 0.3s ease;
}

/* Carousel-specific card styling */
.pricing-card-carousel {
    width: 320px;
    margin-right: 2rem;
    flex-shrink: 0;
}

/* Featured card styling */
.pricing-card.featured {
    border: 2px solid #3b82f6;
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
    transform: scale(1.02);
}

/* Carousel wrapper */
.pricing-carousel-wrapper {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 60px; /* Space for navigation arrows */
}

/* Carousel container */
.pricing-carousel-container {
    overflow: hidden;
    border-radius: 12px;
    margin: 0 auto;
    max-width: 1020px; /* 3 cards × 320px + 2 gaps × 32px */
}

/* Carousel track */
.pricing-carousel-track {
    display: flex;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
}

/* Navigation buttons */
.pricing-nav-btn {
    width: 48px;
    height: 48px;
    border: 1px solid #e5e7eb;
    backdrop-filter: blur(8px);
    z-index: 20;
    opacity: 1;
    transition: all 0.3s ease;
}

.pricing-nav-btn:hover:not(:disabled) {
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.pricing-nav-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    transform: translateY(-50%) scale(0.9);
}

/* Carousel dots */
.carousel-dots {
    margin-top: 2rem;
}

.carousel-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #d1d5db;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.carousel-dot:hover {
    background-color: #9ca3af;
    transform: scale(1.2);
}

.carousel-dot.active {
    background-color: #3b82f6;
    transform: scale(1.3);
}

/* Dark mode pricing cards */
.dark .pricing-card {
    background: #1f2937;
    border-color: #374151;
}

.dark .pricing-card.featured {
    border-color: #3b82f6;
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
}

.dark .pricing-nav-btn {
    background-color: #1f2937;
    border-color: #374151;
}

.dark .carousel-dot {
    background-color: #4b5563;
}

.dark .carousel-dot:hover {
    background-color: #6b7280;
}

.dark .carousel-dot.active {
    background-color: #3b82f6;
}

/* Toggle Switch Styling */
#pricing-billing-toggle:checked + label,
#comparison-billing-toggle:checked + label {
    background-color: #2563eb !important;
}

#pricing-billing-toggle:not(:checked) + label,
#comparison-billing-toggle:not(:checked) + label {
    background-color: #d1d5db !important;
}

#pricing-billing-toggle:checked + label .toggle-switch,
#comparison-billing-toggle:checked + label span {
    transform: translateX(32px) !important;
}

#pricing-billing-toggle:not(:checked) + label .toggle-switch,
#comparison-billing-toggle:not(:checked) + label span {
    transform: translateX(0px) !important;
}

/* Label Styling - Main Pricing Section */
.pricing-page.show-annual .pricing-yearly-label {
    color: #2563eb !important;
    font-weight: 600 !important;
}

.pricing-page.show-annual .pricing-monthly-label {
    color: #9ca3af !important;
    font-weight: 400 !important;
}

.pricing-page.show-monthly .pricing-monthly-label {
    color: #2563eb !important;
    font-weight: 600 !important;
}

.pricing-page.show-monthly .pricing-yearly-label {
    color: #9ca3af !important;
    font-weight: 400 !important;
}

/* Default state - annual active */
.pricing-page .pricing-yearly-label {
    color: #2563eb !important;
    font-weight: 600 !important;
}

.pricing-page .pricing-monthly-label {
    color: #9ca3af !important;
    font-weight: 400 !important;
}

/* Price Display Toggle - Main Pricing Section */
.pricing-page.show-annual .homepage-monthly-pricing {
    display: none !important;
}

.pricing-page.show-annual .homepage-annual-pricing {
    display: block !important;
}

.pricing-page.show-annual .homepage-annual-savings {
    display: block !important;
}

.pricing-page.show-monthly .homepage-monthly-pricing {
    display: block !important;
}

.pricing-page.show-monthly .homepage-annual-pricing {
    display: none !important;
}

.pricing-page.show-monthly .homepage-annual-savings {
    display: none !important;
}

/* Default state shows annual */
.pricing-page .homepage-monthly-pricing {
    display: none !important;
}

.pricing-page .homepage-annual-pricing {
    display: block !important;
}

.pricing-page .homepage-annual-savings {
    display: block !important;
}

/* Comparison Table Price Display Toggle */
.pricing-comparison-wrapper .monthly-pricing {
    display: none !important;
}

.pricing-comparison-wrapper .annual-pricing {
    display: block !important;
}

.pricing-comparison-wrapper.comparison-monthly-active .monthly-pricing {
    display: block !important;
}

.pricing-comparison-wrapper.comparison-monthly-active .annual-pricing {
    display: none !important;
}

.pricing-comparison-wrapper.comparison-yearly-active .annual-pricing {
    display: block !important;
}

/* FAQ toggle styles */
.faq-toggle svg {
    transition: transform 0.3s ease;
}

.faq-toggle.active svg {
    transform: rotate(180deg);
}

.faq-content {
    transition: all 0.3s ease;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .homepage-pricing-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .pricing-card.featured {
        transform: none;
        border: 2px solid #3b82f6;
    }
    
    .pricing-card {
        padding: 1.5rem;
        min-height: auto;
    }
    
    /* Mobile carousel adjustments */
    .pricing-carousel-wrapper {
        padding: 0 20px;
    }
    
    .pricing-carousel-container {
        max-width: 280px; /* Single card on mobile */
        padding: 30px 0; /* More padding on mobile for featured cards */
    }
    
    .pricing-card-carousel {
        width: 280px;
        margin: 0 5px;
    }
    
    .pricing-nav-btn {
        width: 40px;
        height: 40px;
    }
    
    .pricing-nav-prev {
        margin-left: -10px !important;
    }
    
    .pricing-nav-next {
        margin-right: -10px !important;
    }
    
    /* Mobile featured card adjustments */
    .pricing-carousel-track .pricing-card.featured {
        transform: none; /* No scaling on mobile */
        margin-top: 0;
        margin-bottom: 0;
        border: 2px solid #3b82f6;
    }
    
    .pricing-carousel-track .pricing-card.featured:hover {
        transform: translateY(-4px);
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .homepage-pricing-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    /* Tablet carousel - show 2 cards */
    .pricing-carousel-container {
        max-width: 680px; /* 2 cards × 320px + 1 gap × 32px + margins */
        padding: 25px 0;
    }
    
    .pricing-card-carousel {
        margin: 0 8px;
    }
}

@media (min-width: 1025px) {
    .homepage-pricing-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }
}

/* Touch scrolling for carousel on mobile */
@media (max-width: 1024px) {
    .pricing-carousel-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    
    .pricing-carousel-container::-webkit-scrollbar {
        display: none;
    }
    
    .pricing-carousel-track {
        transition: none; /* Disable JS transitions on mobile for native scroll */
    }
}

/* Smooth animations */
.pricing-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.pricing-card.featured:hover {
    transform: scale(1.02) translateY(-4px);
}

/* Carousel performance optimizations */
.pricing-carousel-track {
    backface-visibility: hidden;
    perspective: 1000px;
}

.pricing-card-carousel {
    backface-visibility: hidden;
}
</style><?php
/**
 * Template Name: Pricing Page - Complete Clean Version
 * No syntax errors, complete implementation
 */

get_header();

// Load required files
require_once get_template_directory() . '/inc/pricing-comparison-table.php';
require_once get_template_directory() . '/inc/pricing-shortcodes.php';

// Get customizer settings
$hero_enable = get_theme_mod('pricing_hero_enable', true);
$hero_title = get_theme_mod('pricing_hero_title', 'Simple, Transparent Pricing');
$hero_subtitle = get_theme_mod('pricing_hero_subtitle', 'Choose the perfect plan for your business. Start free, upgrade when you\'re ready.');
$monthly_text = get_theme_mod('pricing_billing_monthly_text', 'Monthly');
$yearly_text = get_theme_mod('pricing_billing_yearly_text', 'Annual');
$save_text = get_theme_mod('pricing_billing_save_text', 'Save 20%');

$comparison_enable = get_theme_mod('pricing_comparison_enable', true);
$comparison_title = get_theme_mod('pricing_comparison_title', 'See What\'s Included in Each Plan');
$comparison_subtitle = get_theme_mod('pricing_comparison_subtitle', 'Every feature designed to help your business grow');

$faq_enable = get_theme_mod('pricing_faq_enable', true);
$faq_title = get_theme_mod('pricing_faq_title', 'Frequently Asked Questions');
$faq_subtitle = get_theme_mod('pricing_faq_subtitle', 'Quick answers to common pricing questions');

$cta_enable = get_theme_mod('pricing_cta_enable', true);
$cta_title = get_theme_mod('pricing_cta_title', 'Ready to grow your business?');
$cta_subtitle = get_theme_mod('pricing_cta_subtitle', 'Join thousands of successful merchants using our platform');
$cta_primary_text = get_theme_mod('pricing_cta_primary_text', 'Start Your Free Trial');
$cta_primary_url = get_theme_mod('pricing_cta_primary_url', '#');
$cta_secondary_text = get_theme_mod('pricing_cta_secondary_text', 'Talk to Sales');
$cta_secondary_url = get_theme_mod('pricing_cta_secondary_url', '/contact');

// Helper function for currency symbols
function get_pricing_currency_symbol($currency = 'USD') {
    $symbols = array(
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'CAD' => 'C$',
        'AUD' => 'A$'
    );
    return isset($symbols[$currency]) ? $symbols[$currency] : '$';
}
?>

<div class="pricing-page bg-gray-50 dark:bg-gray-900 min-h-screen">
    
    <?php if ($hero_enable) : ?>
    <!-- Hero Section -->
    <section class="bg-white dark:bg-gray-800 py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                    <?php echo esc_html($hero_title); ?>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Pricing Cards Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-900" id="pricing-cards">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                
                <!-- Billing Toggle - Moved to Gray Section -->
                <div class="flex items-center justify-center mb-16 flex-wrap gap-4">
                    <span class="text-gray-700 dark:text-gray-300 font-medium pricing-monthly-label">
                        <?php echo esc_html($monthly_text); ?>
                    </span>
                    <div class="relative">
                        <input type="checkbox" id="pricing-billing-toggle" class="sr-only" checked>
                        <label for="pricing-billing-toggle" class="relative inline-flex items-center justify-between w-16 h-8 bg-blue-600 rounded-full cursor-pointer transition-colors duration-300 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                            <span class="toggle-switch absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 translate-x-8"></span>
                        </label>
                    </div>
                    <span class="text-blue-600 dark:text-blue-400 font-semibold pricing-yearly-label">
                        <?php echo esc_html($yearly_text); ?>
                    </span>
                    <span class="bg-emerald-500 text-sm font-semibold px-3 py-1 rounded-full shadow-md" style="color: black !important;">
                        <?php echo esc_html($save_text); ?>
                    </span>
                </div>
                
                <!-- Dynamic Pricing Cards from WP-Admin -->
                <?php
                $args = array(
                    'post_type' => 'pricing',
                    'posts_per_page' => -1, // Get all plans
                    'post_status' => 'publish',
                    'meta_key' => '_pricing_monthly_price',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC'
                );
                
                $plans = get_posts($args);
                $plan_count = count($plans);
                $use_carousel = $plan_count > 3; // Use carousel for 4+ plans
                
                if (!empty($plans)) : ?>
                    
                    <?php if ($use_carousel) : ?>
                    <!-- Carousel Layout for 4+ Plans -->
                    <div class="pricing-carousel-wrapper relative" style="padding: 40px 60px;">
                        <!-- Navigation Arrows -->
                        <button class="pricing-nav-btn pricing-nav-prev absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white dark:bg-gray-800 shadow-lg rounded-full p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed" style="margin-left: -20px;">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button class="pricing-nav-btn pricing-nav-next absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white dark:bg-gray-800 shadow-lg rounded-full p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed" style="margin-right: -20px;">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        
                        <!-- Carousel Container -->
                        <div class="pricing-carousel-container" style="overflow: hidden; margin: 0 auto; max-width: 1020px;">
                            <div class="pricing-carousel-track flex transition-transform duration-500 ease-in-out" data-total-plans="<?php echo $plan_count; ?>" style="margin: 0 -10px; padding: 25px 10px;">
                    <?php else : ?>
                    <!-- Standard Grid for 1-3 Plans -->
                    <div class="pricing-grid homepage-pricing-grid">
                    <?php endif; ?>
                    
                        <?php foreach ($plans as $index => $plan) : 
                            if (!function_exists('yoursite_get_pricing_meta_fields')) {
                                require_once get_template_directory() . '/inc/pricing-meta-boxes.php';
                            }
                            $meta = yoursite_get_pricing_meta_fields($plan->ID);
                            $is_featured = $meta['pricing_featured'] === '1';
                            $monthly_price = floatval($meta['pricing_monthly_price']);
                            $annual_price = floatval($meta['pricing_annual_price']);
                            
                            // Auto-calculate annual price if not set (20% discount)
                            if ($annual_price == 0 && $monthly_price > 0) {
                                $annual_price = $monthly_price * 12 * 0.8;
                            }
                            $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
                            
                            $currency_symbol = get_pricing_currency_symbol($meta['pricing_currency']);
                            
                            // Card classes for carousel vs grid
                            $card_classes = $use_carousel ? 'pricing-card-carousel flex-shrink-0' : '';
                            ?>
                            <div class="pricing-card <?php echo $is_featured ? 'featured' : ''; ?> <?php echo $card_classes; ?> relative transition-all duration-300 hover:shadow-xl">
                                
                                <!-- Featured Badge -->
                                <?php if ($is_featured) : ?>
                                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-10">
                                        <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                            Most Popular
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="text-center mb-8 <?php echo $is_featured ? 'mt-4' : ''; ?>">
                                    <!-- Plan Name -->
                                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">
                                        <?php echo esc_html($plan->post_title); ?>
                                    </h3>
                                    
                                    <!-- Plan Description -->
                                    <?php if ($plan->post_excerpt) : ?>
                                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                                            <?php echo esc_html($plan->post_excerpt); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <!-- Price Display with Toggle -->
                                    <div class="mb-6">
                                        <!-- Monthly Pricing (Hidden by default since annual is default) -->
                                        <div class="homepage-monthly-pricing" style="display: none;">
                                            <span class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">
                                                <?php echo $currency_symbol . number_format($monthly_price, 0); ?>
                                            </span>
                                            <span class="text-gray-600 dark:text-gray-300 text-lg">
                                                /month
                                            </span>
                                        </div>
                                        
                                        <!-- Annual Pricing (Visible by default) -->
                                        <div class="homepage-annual-pricing" style="display: block;">
                                            <span class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">
                                                <?php echo $currency_symbol . number_format($annual_monthly, 0); ?>
                                            </span>
                                            <span class="text-gray-600 dark:text-gray-300 text-lg">
                                                /month
                                            </span>
                                            <?php if ($annual_price > 0) : ?>
                                                <div class="text-sm text-green-600 dark:text-green-400 mt-1">
                                                    Billed annually (<?php echo $currency_symbol . number_format($annual_price, 0); ?>)
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Savings Badge (Annual) - Visible by default -->
                                        <?php if ($monthly_price > 0 && $annual_price > 0) : ?>
                                            <div class="homepage-annual-savings mt-2" style="display: block;">
                                                <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium">
                                                    Save <?php echo $currency_symbol . number_format(($monthly_price * 12) - $annual_price, 0); ?> per year
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Features List -->
                                <?php if (!empty($meta['pricing_features'])) : ?>
                                    <div class="mb-8 flex-grow">
                                        <ul class="space-y-3">
                                            <?php 
                                            $features = array_filter(explode("\n", $meta['pricing_features']));
                                            foreach ($features as $feature) : 
                                                $feature = trim($feature);
                                                if (!empty($feature)) :
                                            ?>
                                                <li class="flex items-center text-gray-700 dark:text-gray-300">
                                                    <svg class="w-5 h-5 text-green-500 dark:text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span class="text-sm"><?php echo esc_html($feature); ?></span>
                                                </li>
                                            <?php endif; endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- CTA Button -->
                                <div class="text-center mt-auto">
                                    <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>" 
                                       class="<?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?> w-full text-center block py-4 px-6 rounded-lg font-semibold text-lg transition-all duration-200 hover:transform hover:-translate-y-1"
                                       <?php echo $is_featured ? 'style="color: #ffffff !important;"' : ''; ?>>
                                        <?php echo esc_html($meta['pricing_button_text'] ?: __('Get Started', 'yoursite')); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                    <?php if ($use_carousel) : ?>
                            </div> <!-- End carousel track -->
                        </div> <!-- End carousel container -->
                        
                        <!-- Carousel Dots Navigation -->
                        <div class="carousel-dots flex justify-center mt-8 space-x-3">
                            <?php 
                            $dots_count = ceil($plan_count / 3); // Show 3 plans per view
                            for ($i = 0; $i < $dots_count; $i++) : ?>
                                <button class="carousel-dot w-3 h-3 rounded-full transition-all duration-300 <?php echo $i === 0 ? 'bg-blue-600' : 'bg-gray-300 hover:bg-gray-400'; ?>" 
                                        data-slide="<?php echo $i; ?>"></button>
                            <?php endfor; ?>
                        </div>
                        
                    </div> <!-- End carousel wrapper -->
                    <?php else : ?>
                    </div> <!-- End standard grid -->
                    <?php endif; ?>
                    
                    <!-- Compare All Features Button -->
                    <?php if ($comparison_enable) : ?>
                    <div class="text-center mt-16">
                        <button class="btn-secondary hover:bg-gray-100 dark:hover:bg-gray-700 text-lg px-8 py-4" data-scroll-to-comparison onclick="document.querySelector('.pricing-comparison-wrapper').scrollIntoView({behavior: 'smooth'})">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                Compare All Features
                            </span>
                        </button>
                    </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400 text-lg mb-4">No pricing plans available yet.</p>
                        <?php if (current_user_can('manage_options')) : ?>
                            <a href="<?php echo admin_url('post-new.php?post_type=pricing'); ?>" class="btn-primary">
                                Create Your First Pricing Plan
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
    </section>

    <?php if ($comparison_enable) : ?>
    <!-- Enhanced Plans Comparison Section -->
    <section class="py-20 bg-white dark:bg-gray-800" id="plans-comparison">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <?php echo yoursite_render_pricing_comparison_table(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($faq_enable) : ?>
    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo esc_html($faq_title); ?>
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300">
                        <?php echo esc_html($faq_subtitle); ?>
                    </p>
                </div>
                
                <div class="space-y-6">
                    <?php 
                    $faq_count = 0;
                    
                    // Default FAQ data in case customizer is empty
                    $default_faqs = array(
                        1 => array('question' => 'Can I change plans anytime?', 'answer' => 'Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle, and we\'ll prorate any differences.'),
                        2 => array('question' => 'Is there a free trial?', 'answer' => 'Yes, all paid plans come with a 14-day free trial. No credit card required to get started. You can also use our Free plan indefinitely.'),
                        3 => array('question' => 'What payment methods do you accept?', 'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers for enterprise customers.'),
                        4 => array('question' => 'Do you offer refunds?', 'answer' => 'Yes, we offer a 30-day money-back guarantee. If you\'re not satisfied with our service, contact us within 30 days for a full refund.'),
                        5 => array('question' => 'Can I cancel anytime?', 'answer' => 'Absolutely! You can cancel your subscription at any time. Your account will remain active until the end of your current billing period.')
                    );
                    
                    for ($i = 1; $i <= 5; $i++) : 
                        // Check if FAQ is enabled (default to true)
                        $faq_enabled = get_theme_mod("pricing_faq_{$i}_enable", true);
                        
                        // Get question and answer (with defaults)
                        $question = get_theme_mod("pricing_faq_{$i}_question", $default_faqs[$i]['question']);
                        $answer = get_theme_mod("pricing_faq_{$i}_answer", $default_faqs[$i]['answer']);
                        
                        // Debug info for admins
                        if (current_user_can('manage_options')) {
                            echo "<!-- FAQ {$i}: enabled=" . ($faq_enabled ? 'true' : 'false') . ", question='" . esc_attr(substr($question, 0, 30)) . "...', answer_length=" . strlen($answer) . " -->";
                        }
                        
                        // Skip if disabled or empty
                        if (!$faq_enabled || empty(trim($question)) || empty(trim($answer))) {
                            continue;
                        }
                        
                        $faq_count++;
                    ?>
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <button class="flex justify-between items-center w-full text-left faq-toggle">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white"><?php echo esc_html($question); ?></h3>
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="faq-content hidden mt-4">
                                <p class="text-gray-600 dark:text-gray-300"><?php echo esc_html($answer); ?></p>
                            </div>
                        </div>
                    <?php endfor; 
                    
                    // Show admin notice only if really no FAQs and user is admin
                    if ($faq_count === 0 && current_user_can('manage_options')) : ?>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                            <p class="text-yellow-800"><strong>Admin Notice:</strong> No FAQ items are being displayed. Check <strong>Appearance → Customize → Pricing Page</strong> to configure your FAQs.</p>
                            <p class="text-sm text-yellow-600 mt-2">FAQ Section Enabled: <?php echo $faq_enable ? 'Yes' : 'No'; ?></p>
                        </div>
                    <?php elseif ($faq_count === 0) : ?>
                        <!-- If no FAQs and not admin, show nothing -->
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($cta_enable) : ?>
    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-6"><?php echo esc_html($cta_title); ?></h2>
                <p class="text-xl text-blue-100 mb-8"><?php echo esc_html($cta_subtitle); ?></p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn-primary bg-white text-blue-600 hover:bg-gray-100 text-lg px-8 py-4 inline-block">
                        <?php echo esc_html($cta_primary_text); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url($cta_secondary_url)); ?>" class="btn-secondary border-white text-white hover:bg-white hover:text-blue-600 text-lg px-8 py-4 inline-block">
                        <?php echo esc_html($cta_secondary_text); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</div>

<!-- Complete Clean Pricing Page CSS -->
<style>
/* Homepage-style pricing grid */
.homepage-pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

/* Pricing card base styling */
.pricing-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    display: flex;
    flex-direction: column;
    min-height: 500px;
    position: relative;
}

/* Featured card styling */
.pricing-card.featured {
    border: 2px solid #3b82f6;
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
    transform: scale(1.02);
}

/* Dark mode pricing cards */
.dark .pricing-card {
    background: #1f2937;
    border-color: #374151;
}

.dark .pricing-card.featured {
    border-color: #3b82f6;
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
}

/* Toggle Switch Styling */
#pricing-billing-toggle:checked + label,
#comparison-billing-toggle:checked + label {
    background-color: #2563eb !important;
}

#pricing-billing-toggle:not(:checked) + label,
#comparison-billing-toggle:not(:checked) + label {
    background-color: #d1d5db !important;
}

#pricing-billing-toggle:checked + label .toggle-switch,
#comparison-billing-toggle:checked + label span {
    transform: translateX(32px) !important;
}

#pricing-billing-toggle:not(:checked) + label .toggle-switch,
#comparison-billing-toggle:not(:checked) + label span {
    transform: translateX(0px) !important;
}

/* Label Styling - Main Pricing Section */
.pricing-page.show-annual .pricing-yearly-label {
    color: #2563eb !important;
    font-weight: 600 !important;
}

.pricing-page.show-annual .pricing-monthly-label {
    color: #9ca3af !important;
    font-weight: 400 !important;
}

.pricing-page.show-monthly .pricing-monthly-label {
    color: #2563eb !important;
    font-weight: 600 !important;
}

.pricing-page.show-monthly .pricing-yearly-label {
    color: #9ca3af !important;
    font-weight: 400 !important;
}

/* Default state - annual active */
.pricing-page .pricing-yearly-label {
    color: #2563eb !important;
    font-weight: 600 !important;
}

.pricing-page .pricing-monthly-label {
    color: #9ca3af !important;
    font-weight: 400 !important;
}

/* Price Display Toggle - Main Pricing Section */
.pricing-page.show-annual .homepage-monthly-pricing {
    display: none !important;
}

.pricing-page.show-annual .homepage-annual-pricing {
    display: block !important;
}

.pricing-page.show-annual .homepage-annual-savings {
    display: block !important;
}

.pricing-page.show-monthly .homepage-monthly-pricing {
    display: block !important;
}

.pricing-page.show-monthly .homepage-annual-pricing {
    display: none !important;
}

.pricing-page.show-monthly .homepage-annual-savings {
    display: none !important;
}

/* Default state shows annual */
.pricing-page .homepage-monthly-pricing {
    display: none !important;
}

.pricing-page .homepage-annual-pricing {
    display: block !important;
}

.pricing-page .homepage-annual-savings {
    display: block !important;
}

/* Comparison Table Price Display Toggle */
.pricing-comparison-wrapper .monthly-pricing {
    display: none !important;
}

.pricing-comparison-wrapper .annual-pricing {
    display: block !important;
}

.pricing-comparison-wrapper.comparison-monthly-active .monthly-pricing {
    display: block !important;
}

.pricing-comparison-wrapper.comparison-monthly-active .annual-pricing {
    display: none !important;
}

.pricing-comparison-wrapper.comparison-yearly-active .monthly-pricing {
    display: none !important;
}

.pricing-comparison-wrapper.comparison-yearly-active .annual-pricing {
    display: block !important;
}

/* FAQ toggle styles */
.faq-toggle svg {
    transition: transform 0.3s ease;
}

.faq-toggle.active svg {
    transform: rotate(180deg);
}

.faq-content {
    transition: all 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .homepage-pricing-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .pricing-card.featured {
        transform: none;
        border: 2px solid #3b82f6;
    }
    
    .pricing-card {
        padding: 1.5rem;
        min-height: auto;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .homepage-pricing-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1025px) {
    .homepage-pricing-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }
}
</style>

<!-- Complete Clean JavaScript - No Syntax Errors -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== PRICING DEBUG START ===');
    
    // Find elements with detailed logging
    var pricingPage = document.querySelector('.pricing-page');
    var billingToggle = document.getElementById('pricing-billing-toggle');
    var comparisonToggle = document.getElementById('comparison-billing-toggle');
    
    console.log('Elements found:', {
        pricingPage: pricingPage,
        billingToggle: billingToggle,
        comparisonToggle: comparisonToggle
    });
    
    // Find all pricing elements
    var mainMonthlyPricing = document.querySelectorAll('.homepage-monthly-pricing');
    var mainAnnualPricing = document.querySelectorAll('.homepage-annual-pricing');
    var mainAnnualSavings = document.querySelectorAll('.homepage-annual-savings');
    var comparisonMonthlyPricing = document.querySelectorAll('.monthly-pricing');
    var comparisonAnnualPricing = document.querySelectorAll('.annual-pricing');
    
    console.log('Pricing elements found:', {
        mainMonthly: mainMonthlyPricing.length,
        mainAnnual: mainAnnualPricing.length,
        mainSavings: mainAnnualSavings.length,
        comparisonMonthly: comparisonMonthlyPricing.length,
        comparisonAnnual: comparisonAnnualPricing.length
    });
    
    // Set initial state
    if (billingToggle) billingToggle.checked = true;
    if (comparisonToggle) comparisonToggle.checked = true;
    
    // Initial display setup
    showYearlyPricing();
    
    function showYearlyPricing() {
        console.log('=== SHOWING YEARLY PRICING ===');
        
        // Update main pricing cards
        for (var i = 0; i < mainMonthlyPricing.length; i++) {
            mainMonthlyPricing[i].style.display = 'none';
            console.log('Hiding main monthly pricing', i);
        }
        
        for (var i = 0; i < mainAnnualPricing.length; i++) {
            mainAnnualPricing[i].style.display = 'block';
            console.log('Showing main annual pricing', i);
        }
        
        for (var i = 0; i < mainAnnualSavings.length; i++) {
            mainAnnualSavings[i].style.display = 'block';
            console.log('Showing main annual savings', i);
        }
        
        // Update comparison table
        for (var i = 0; i < comparisonMonthlyPricing.length; i++) {
            comparisonMonthlyPricing[i].style.display = 'none';
            console.log('Hiding comparison monthly pricing', i);
        }
        
        for (var i = 0; i < comparisonAnnualPricing.length; i++) {
            comparisonAnnualPricing[i].style.display = 'block';
            console.log('Showing comparison annual pricing', i);
        }
        
        // Update page classes
        if (pricingPage) {
            pricingPage.classList.add('show-annual');
            pricingPage.classList.remove('show-monthly');
            console.log('Added show-annual class to pricing page');
        }
        
        // Update comparison wrapper classes
        var comparisonWrapper = document.querySelector('.pricing-comparison-wrapper');
        if (comparisonWrapper) {
            comparisonWrapper.classList.add('comparison-yearly-active');
            comparisonWrapper.classList.remove('comparison-monthly-active');
            console.log('Added comparison-yearly-active class');
        }
        
        updateLabels(true);
    }
    
    function showMonthlyPricing() {
        console.log('=== SHOWING MONTHLY PRICING ===');
        
        // Update main pricing cards
        for (var i = 0; i < mainMonthlyPricing.length; i++) {
            mainMonthlyPricing[i].style.display = 'block';
            console.log('Showing main monthly pricing', i);
        }
        
        for (var i = 0; i < mainAnnualPricing.length; i++) {
            mainAnnualPricing[i].style.display = 'none';
            console.log('Hiding main annual pricing', i);
        }
        
        for (var i = 0; i < mainAnnualSavings.length; i++) {
            mainAnnualSavings[i].style.display = 'none';
            console.log('Hiding main annual savings', i);
        }
        
        // Update comparison table
        for (var i = 0; i < comparisonMonthlyPricing.length; i++) {
            comparisonMonthlyPricing[i].style.display = 'block';
            console.log('Showing comparison monthly pricing', i);
        }
        
        for (var i = 0; i < comparisonAnnualPricing.length; i++) {
            comparisonAnnualPricing[i].style.display = 'none';
            console.log('Hiding comparison annual pricing', i);
        }
        
        // Update page classes
        if (pricingPage) {
            pricingPage.classList.remove('show-annual');
            pricingPage.classList.add('show-monthly');
            console.log('Added show-monthly class to pricing page');
        }
        
        // Update comparison wrapper classes
        var comparisonWrapper = document.querySelector('.pricing-comparison-wrapper');
        if (comparisonWrapper) {
            comparisonWrapper.classList.remove('comparison-yearly-active');
            comparisonWrapper.classList.add('comparison-monthly-active');
            console.log('Added comparison-monthly-active class');
        }
        
        updateLabels(false);
    }
    
    function updateLabels(isYearly) {
        console.log('Updating labels for:', isYearly ? 'yearly' : 'monthly');
        
        // Update main labels
        var mainMonthlyLabel = document.querySelector('.pricing-monthly-label');
        var mainYearlyLabel = document.querySelector('.pricing-yearly-label');
        
        if (mainMonthlyLabel && mainYearlyLabel) {
            if (isYearly) {
                mainYearlyLabel.style.color = '#2563eb';
                mainYearlyLabel.style.fontWeight = '600';
                mainMonthlyLabel.style.color = '#9ca3af';
                mainMonthlyLabel.style.fontWeight = '400';
            } else {
                mainMonthlyLabel.style.color = '#2563eb';
                mainMonthlyLabel.style.fontWeight = '600';
                mainYearlyLabel.style.color = '#9ca3af';
                mainYearlyLabel.style.fontWeight = '400';
            }
            console.log('Updated main labels');
        }
        
        // Update comparison labels
        var comparisonMonthlyLabel = document.querySelector('.comparison-monthly-label');
        var comparisonYearlyLabel = document.querySelector('.comparison-yearly-label');
        
        if (comparisonMonthlyLabel && comparisonYearlyLabel) {
            if (isYearly) {
                comparisonYearlyLabel.style.color = '#2563eb';
                comparisonYearlyLabel.style.fontWeight = '600';
                comparisonMonthlyLabel.style.color = '#9ca3af';
                comparisonMonthlyLabel.style.fontWeight = '400';
            } else {
                comparisonMonthlyLabel.style.color = '#2563eb';
                comparisonMonthlyLabel.style.fontWeight = '600';
                comparisonYearlyLabel.style.color = '#9ca3af';
                comparisonYearlyLabel.style.fontWeight = '400';
            }
            console.log('Updated comparison labels');
        }
    }
    
    // Main toggle event
    if (billingToggle) {
        billingToggle.addEventListener('change', function() {
            var isYearly = this.checked;
            console.log('🔄 MAIN toggle changed to:', isYearly ? 'YEARLY' : 'MONTHLY');
            
            // Sync comparison toggle
            if (comparisonToggle) {
                comparisonToggle.checked = isYearly;
                console.log('Synced comparison toggle to:', isYearly);
            }
            
            // Update displays
            if (isYearly) {
                showYearlyPricing();
            } else {
                showMonthlyPricing();
            }
        });
        console.log('Main toggle event listener added');
    }
    
    // Comparison toggle event
    if (comparisonToggle) {
        comparisonToggle.addEventListener('change', function() {
            var isYearly = this.checked;
            console.log('🔄 COMPARISON toggle changed to:', isYearly ? 'YEARLY' : 'MONTHLY');
            
            // Sync main toggle
            if (billingToggle) {
                billingToggle.checked = isYearly;
                console.log('Synced main toggle to:', isYearly);
            }
            
            // Update displays
            if (isYearly) {
                showYearlyPricing();
            } else {
                showMonthlyPricing();
            }
        });
        console.log('Comparison toggle event listener added');
    }
    
    // FAQ toggle functionality
    var faqToggles = document.querySelectorAll('.faq-toggle');
    
    for (var i = 0; i < faqToggles.length; i++) {
        faqToggles[i].addEventListener('click', function() {
            var content = this.nextElementSibling;
            var icon = this.querySelector('svg');
            var currentToggle = this;
            
            // Close other FAQs
            for (var j = 0; j < faqToggles.length; j++) {
                if (faqToggles[j] !== currentToggle) {
                    var otherContent = faqToggles[j].nextElementSibling;
                    var otherIcon = faqToggles[j].querySelector('svg');
                    if (otherContent) otherContent.classList.add('hidden');
                    if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                    faqToggles[j].classList.remove('active');
                }
            }
            
            // Toggle current FAQ
            if (content && content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                if (icon) icon.style.transform = 'rotate(180deg)';
                this.classList.add('active');
            } else if (content) {
                content.classList.add('hidden');
                if (icon) icon.style.transform = 'rotate(0deg)';
                this.classList.remove('active');
            }
        });
    }
    
    // Smooth scroll functionality
    var scrollButtons = document.querySelectorAll('[data-scroll-to-comparison]');
    for (var i = 0; i < scrollButtons.length; i++) {
        scrollButtons[i].addEventListener('click', function(e) {
            e.preventDefault();
            var target = document.querySelector('.pricing-comparison-wrapper');
            if (target) {
                var offset = 20;
                var targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Add highlight effect
                target.style.boxShadow = '0 0 0 4px rgba(59, 130, 246, 0.3)';
                setTimeout(function() {
                    target.style.boxShadow = '';
                }, 2000);
            }
        });
    }
    
    // Initialize Pricing Carousel
    initializePricingCarousel();
    
    function initializePricingCarousel() {
        var carouselWrapper = document.querySelector('.pricing-carousel-wrapper');
        if (!carouselWrapper) {
            console.log('No carousel found - using standard grid');
            return;
        }
        
        // Force container styles to prevent clipping while maintaining 3-card view
        var carouselContainer = document.querySelector('.pricing-carousel-container');
        var carouselTrack = document.querySelector('.pricing-carousel-track');
        
        if (carouselContainer) {
            carouselContainer.style.overflow = 'hidden'; // Keep hidden to show only 3 cards
            carouselContainer.style.maxWidth = '1020px';
            console.log('Applied proper overflow to carousel container');
        }
        
        if (carouselTrack) {
            carouselTrack.style.margin = '0 -10px';
            carouselTrack.style.padding = '25px 10px'; // Internal padding for featured card scaling
            console.log('Applied internal padding to carousel track');
        }
        
        // Force featured card styles
        var featuredCards = document.querySelectorAll('.pricing-carousel-track .pricing-card.featured');
        for (var i = 0; i < featuredCards.length; i++) {
            featuredCards[i].style.position = 'relative';
            featuredCards[i].style.zIndex = '10';
            featuredCards[i].style.transform = 'scale(1.02)';
            console.log('Applied featured card styling to card', i);
        }
        
        var prevBtn = document.querySelector('.pricing-nav-prev');
        var nextBtn = document.querySelector('.pricing-nav-next');
        var dots = document.querySelectorAll('.carousel-dot');
        
        if (!carouselTrack) {
            console.log('Carousel track not found');
            return;
        }
        
        var totalPlans = parseInt(carouselTrack.getAttribute('data-total-plans'));
        var currentSlide = 0;
        var cardsPerView = 3; // Default for desktop
        var maxSlides = Math.max(0, Math.ceil(totalPlans / cardsPerView) - 1);
        
        console.log('Carousel initialized:', {
            totalPlans: totalPlans,
            cardsPerView: cardsPerView,
            maxSlides: maxSlides
        });
        
        // Responsive cards per view
        function updateCardsPerView() {
            if (window.innerWidth < 769) {
                cardsPerView = 1; // Mobile: 1 card
            } else if (window.innerWidth < 1025) {
                cardsPerView = 2; // Tablet: 2 cards
            } else {
                cardsPerView = 3; // Desktop: 3 cards
            }
            maxSlides = Math.max(0, Math.ceil(totalPlans / cardsPerView) - 1);
            currentSlide = Math.min(currentSlide, maxSlides);
            updateCarousel();
        }
        
        function updateCarousel() {
            if (!carouselTrack) return;
            
            var cardWidth = 320; // Fixed card width
            var gap = 20; // Gap between cards (margin: 0 10px = 20px total)
            var translateX = currentSlide * cardsPerView * (cardWidth + gap);
            
            carouselTrack.style.transform = 'translateX(-' + translateX + 'px)';
            
            // Update navigation buttons
            if (prevBtn) {
                prevBtn.disabled = currentSlide === 0;
            }
            if (nextBtn) {
                nextBtn.disabled = currentSlide >= maxSlides;
            }
            
            // Update dots
            for (var i = 0; i < dots.length; i++) {
                if (i === currentSlide) {
                    dots[i].classList.add('active');
                } else {
                    dots[i].classList.remove('active');
                }
            }
            
            console.log('Carousel updated:', {
                currentSlide: currentSlide,
                translateX: translateX,
                maxSlides: maxSlides
            });
        }
        
        // Navigation button events
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                if (currentSlide > 0) {
                    currentSlide--;
                    updateCarousel();
                }
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                if (currentSlide < maxSlides) {
                    currentSlide++;
                    updateCarousel();
                }
            });
        }
        
        // Dot navigation
        for (var i = 0; i < dots.length; i++) {
            dots[i].addEventListener('click', function() {
                var slideIndex = parseInt(this.getAttribute('data-slide'));
                currentSlide = slideIndex;
                updateCarousel();
            });
        }
        
        // Touch/swipe support
        var startX = 0;
        var currentX = 0;
        var isDragging = false;
        var threshold = 50;
        
        carouselTrack.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            isDragging = true;
            carouselTrack.style.transition = 'none';
        });
        
        carouselTrack.addEventListener('touchmove', function(e) {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
            var diffX = currentX - startX;
            
            // Add some resistance at the edges
            if ((currentSlide === 0 && diffX > 0) || (currentSlide >= maxSlides && diffX < 0)) {
                diffX = diffX * 0.3;
            }
            
            var cardWidth = 320;
            var gap = 20; // Updated to match CSS
            var baseTranslateX = currentSlide * cardsPerView * (cardWidth + gap);
            carouselTrack.style.transform = 'translateX(-' + (baseTranslateX - diffX) + 'px)';
        });
        
        carouselTrack.addEventListener('touchend', function() {
            if (!isDragging) return;
            isDragging = false;
            
            carouselTrack.style.transition = 'transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            
            var diffX = currentX - startX;
            
            if (Math.abs(diffX) > threshold) {
                if (diffX > 0 && currentSlide > 0) {
                    currentSlide--;
                } else if (diffX < 0 && currentSlide < maxSlides) {
                    currentSlide++;
                }
            }
            
            updateCarousel();
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (!carouselWrapper || document.activeElement.tagName === 'INPUT') return;
            
            if (e.key === 'ArrowLeft' && currentSlide > 0) {
                currentSlide--;
                updateCarousel();
                e.preventDefault();
            } else if (e.key === 'ArrowRight' && currentSlide < maxSlides) {
                currentSlide++;
                updateCarousel();
                e.preventDefault();
            }
        });
        
        // Window resize handler
        var resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                updateCardsPerView();
            }, 150);
        });
        
        // Initialize
        updateCardsPerView();
        updateCarousel();
        
        console.log('Pricing carousel fully initialized');
    }
    
    console.log('=== PRICING DEBUG END ===');
    console.log('Setup complete - toggles and carousel should work');
});
</script>

<?php get_footer(); ?>
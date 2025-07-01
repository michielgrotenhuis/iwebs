<?php
/**
 * Template Name: Pricing Page - Enhanced with Dynamic Currency Support
 * Complete implementation with hero and pricing in one section
 */

get_header();

// Load required files
require_once get_template_directory() . '/inc/pricing-comparison-table.php';
require_once get_template_directory() . '/inc/pricing-shortcodes.php';

// Get current user currency
$current_currency = function_exists('yoursite_get_user_currency') ? yoursite_get_user_currency() : array('code' => 'USD', 'symbol' => '$');

// Get customizer settings
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
        'AUD' => 'A$',
        'JPY' => '¥',
        'CHF' => 'CHF',
        'SEK' => 'kr',
        'NOK' => 'kr',
        'DKK' => 'kr'
    );
    return isset($symbols[$currency]) ? $symbols[$currency] : '$';
}
?>

<!-- Complete Unified Pricing Page CSS -->
<style>
/* Unified section styling */
.unified-pricing-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.unified-pricing-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
    pointer-events: none;
}

.unified-content {
    position: relative;
    z-index: 1;
}

/* Hero text styling within unified section */
.hero-content h1 {
    color: white !important;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.hero-content p {
    color: rgba(255, 255, 255, 0.9) !important;
}

/* Currency Selector Styling */
.currency-selector-wrapper {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    margin: 2rem auto;
    max-width: 600px;
}

.currency-selector-wrapper .currency-selector {
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    color: #374151;
    font-weight: 500;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.currency-selector-wrapper .currency-selector:hover {
    background: rgba(255, 255, 255, 1);
    border-color: rgba(255, 255, 255, 0.5);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Billing toggle in unified section */
.billing-toggle-wrapper {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    margin: 3rem auto;
}

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
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    display: flex;
    flex-direction: column;
    min-height: 500px;
    position: relative;
    transition: all 0.3s ease;
}

/* Featured card styling */
.pricing-card.featured {
    background: rgba(255, 255, 255, 1);
    border: 2px solid #3b82f6;
    box-shadow: 0 30px 60px rgba(59, 130, 246, 0.2);
    transform: scale(1.05);
}

/* Currency updating state */
.pricing-updating {
    position: relative;
    transition: opacity 0.3s ease;
}

.pricing-updating::after {
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

/* Compare button styling for unified section */
.unified-compare-btn {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.unified-compare-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Dark mode adjustments */
.dark .pricing-card {
    background: rgba(31, 41, 55, 0.95);
    border-color: rgba(75, 85, 99, 0.3);
}

.dark .pricing-card.featured {
    background: rgba(31, 41, 55, 1);
    border-color: #3b82f6;
    box-shadow: 0 30px 60px rgba(59, 130, 246, 0.3);
}

/* Toggle Switch Styling */
#pricing-billing-toggle:checked + label,
#comparison-billing-toggle:checked + label {
    background-color: rgba(255, 255, 255, 0.9) !important;
}

#pricing-billing-toggle:not(:checked) + label,
#comparison-billing-toggle:not(:checked) + label {
    background-color: rgba(255, 255, 255, 0.3) !important;
}

#pricing-billing-toggle:checked + label .toggle-switch,
#comparison-billing-toggle:checked + label span {
    transform: translateX(32px) !important;
    background-color: #2563eb !important;
}

#pricing-billing-toggle:not(:checked) + label .toggle-switch,
#comparison-billing-toggle:not(:checked) + label span {
    transform: translateX(0px) !important;
    background-color: #2563eb !important;
}

/* Label Styling for unified section */
.unified-pricing-section .pricing-yearly-label,
.unified-pricing-section .pricing-monthly-label {
    color: white !important;
    font-weight: 600 !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.pricing-page.show-annual .pricing-yearly-label {
    opacity: 1 !important;
}

.pricing-page.show-annual .pricing-monthly-label {
    opacity: 0.7 !important;
}

.pricing-page.show-monthly .pricing-monthly-label {
    opacity: 1 !important;
}

.pricing-page.show-monthly .pricing-yearly-label {
    opacity: 0.7 !important;
}

/* Price Display Toggle - Main Pricing Section */
.pricing-page.show-annual .homepage-monthly-pricing,
.pricing-page.show-annual .monthly-pricing {
    display: none !important;
}

.pricing-page.show-annual .homepage-annual-pricing,
.pricing-page.show-annual .annual-pricing {
    display: block !important;
}

.pricing-page.show-annual .homepage-annual-savings,
.pricing-page.show-annual .annual-savings {
    display: block !important;
}

.pricing-page.show-monthly .homepage-monthly-pricing,
.pricing-page.show-monthly .monthly-pricing {
    display: block !important;
}

.pricing-page.show-monthly .homepage-annual-pricing,
.pricing-page.show-monthly .annual-pricing {
    display: none !important;
}

.pricing-page.show-monthly .homepage-annual-savings,
.pricing-page.show-monthly .annual-savings {
    display: none !important;
}

/* Default state shows annual */
.pricing-page .homepage-monthly-pricing,
.pricing-page .monthly-pricing {
    display: none !important;
}

.pricing-page .homepage-annual-pricing,
.pricing-page .annual-pricing {
    display: block !important;
}

.pricing-page .homepage-annual-savings,
.pricing-page .annual-savings {
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

/* Pricing display transitions */
.pricing-display {
    transition: all 0.3s ease;
}

.price-amount {
    transition: all 0.2s ease;
}

/* Currency change notification */
.currency-change-notification {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .homepage-pricing-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .pricing-card.featured {
        transform: scale(1.02);
        border: 2px solid #3b82f6;
    }
    
    .pricing-card {
        padding: 1.5rem;
        min-height: auto;
    }
    
    .billing-toggle-wrapper,
    .currency-selector-wrapper {
        padding: 1rem;
        margin: 2rem auto;
    }
    
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

/* Smooth animations */
.pricing-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
}

.pricing-card.featured:hover {
    transform: scale(1.05) translateY(-4px);
}

/* Dark mode support for notifications */
@media (prefers-color-scheme: dark) {
    .currency-change-notification {
        background-color: #10b981;
    }
}
</style>

<div class="pricing-page bg-gray-50 dark:bg-gray-900 min-h-screen">
    
    <!-- Unified Hero & Pricing Cards Section -->
    <section class="unified-pricing-section py-20 min-h-screen">
        <div class="unified-content">
            <div class="container mx-auto px-4">
                <div class="max-w-7xl mx-auto">
                    
                    <!-- Hero Content -->
                    <div class="hero-content max-w-4xl mx-auto text-center mb-12">
                        <h1 class="text-4xl lg:text-6xl font-bold mb-6">
                            <?php echo esc_html($hero_title); ?>
                        </h1>
                        <p class="text-xl max-w-3xl mx-auto mb-8">
                            <?php echo esc_html($hero_subtitle); ?>
                        </p>
                    </div>
                    
                    <!-- Currency & Billing Controls -->
                    <div class="max-w-4xl mx-auto">
                        
                        <!-- Currency Selector -->
                        <?php if (function_exists('yoursite_should_display_currency_selector') && yoursite_should_display_currency_selector()) : ?>
                        <div class="currency-selector-wrapper">
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                                <div class="flex items-center gap-3">
                                    <span class="text-white font-medium">
                                        <?php _e('Currency:', 'yoursite'); ?>
                                    </span>
                                    <?php 
                                    echo yoursite_render_currency_selector(array(
                                        'style' => 'dropdown',
                                        'show_flag' => true,
                                        'show_name' => false,
                                        'show_symbol' => true,
                                        'class' => 'pricing-currency-selector currency-selector'
                                    )); 
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Billing Toggle -->
                        <div class="billing-toggle-wrapper max-w-md mx-auto">
                            <div class="flex items-center justify-center flex-wrap gap-4">
                                <span class="text-white font-medium pricing-monthly-label">
                                    <?php echo esc_html($monthly_text); ?>
                                </span>
                                <div class="relative">
                                    <input type="checkbox" id="pricing-billing-toggle" class="sr-only" checked>
                                    <label for="pricing-billing-toggle" class="relative inline-flex items-center justify-between w-16 h-8 rounded-full cursor-pointer transition-colors duration-300 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                                        <span class="toggle-switch absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 translate-x-8"></span>
                                    </label>
                                </div>
                                <span class="text-white font-semibold pricing-yearly-label">
                                    <?php echo esc_html($yearly_text); ?>
                                </span>
                                <span class="bg-emerald-500 text-black text-sm font-semibold px-3 py-1 rounded-full shadow-md">
                                    <?php echo esc_html($save_text); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dynamic Pricing Cards from WP-Admin -->
                    <?php
                    $args = array(
                        'post_type' => 'pricing',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'meta_key' => '_pricing_monthly_price',
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC'
                    );
                    
                    $plans = get_posts($args);
                    $plan_count = count($plans);
                    
                    // Helper function
                    if (!function_exists('yoursite_get_pricing_meta_fields')) {
                        function yoursite_get_pricing_meta_fields($post_id) {
                            return array(
                                'pricing_featured' => get_post_meta($post_id, '_pricing_featured', true),
                                'pricing_monthly_price' => get_post_meta($post_id, '_pricing_monthly_price', true),
                                'pricing_annual_price' => get_post_meta($post_id, '_pricing_annual_price', true),
                                'pricing_currency' => get_post_meta($post_id, '_pricing_currency', true) ?: 'USD',
                                'pricing_features' => get_post_meta($post_id, '_pricing_features', true),
                                'pricing_button_text' => get_post_meta($post_id, '_pricing_button_text', true),
                                'pricing_button_url' => get_post_meta($post_id, '_pricing_button_url', true)
                            );
                        }
                    }
                    
                    if (!empty($plans)) : ?>
                        
                        <!-- Enhanced Pricing Cards with Dynamic Currency -->
                        <div class="homepage-pricing-grid" id="pricing-cards-container">
                            <?php foreach ($plans as $index => $plan) : 
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
                                    $annual_price = $monthly_price * 12 * 0.8; // 20% discount
                                }
                                $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
                                
                                // Calculate savings
                                $savings = function_exists('yoursite_calculate_annual_savings') 
                                    ? yoursite_calculate_annual_savings($plan->ID, $current_currency['code'])
                                    : ($monthly_price * 12) - $annual_price;
                                
                                $currency_symbol = get_pricing_currency_symbol($current_currency['code']);
                            ?>
                            
                            <!-- Pricing Card -->
                            <div class="pricing-card relative <?php echo $is_featured ? 'featured' : ''; ?>"
                                 data-plan-id="<?php echo esc_attr($plan->ID); ?>">
                                
                                <?php if ($is_featured) : ?>
                                    <!-- Featured Plan Badge -->
                                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-20">
                                        <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                                            <?php _e('Most Popular', 'yoursite'); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Plan Header -->
                                <div class="text-center mb-6 <?php echo $is_featured ? 'pt-8' : ''; ?>">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                        <?php echo esc_html($plan->post_title); ?>
                                    </h3>
                                    
                                    <?php if ($plan->post_excerpt) : ?>
                                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                                            <?php echo esc_html($plan->post_excerpt); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Dynamic Price Display -->
                                <div class="price-section mb-6 text-center">
                                    <!-- Monthly Pricing -->
                                    <div class="monthly-pricing pricing-display homepage-monthly-pricing" style="display: none;">
                                        <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                            <span class="price-amount" data-price-type="monthly" data-plan-id="<?php echo esc_attr($plan->ID); ?>">
                                                <?php 
                                                if (function_exists('yoursite_format_currency')) {
                                                    echo yoursite_format_currency($monthly_price, $current_currency['code']);
                                                } else {
                                                    echo $currency_symbol . number_format($monthly_price, 0);
                                                }
                                                ?>
                                            </span>
                                            <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/month</span>
                                        </div>
                                        <?php if ($monthly_price > 0) : ?>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                                <?php _e('Billed monthly', 'yoursite'); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Annual Pricing (Default) -->
                                    <div class="annual-pricing pricing-display homepage-annual-pricing">
                                        <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                            <span class="price-amount" data-price-type="annual-monthly" data-plan-id="<?php echo esc_attr($plan->ID); ?>">
                                                <?php 
                                                if (function_exists('yoursite_format_currency')) {
                                                    echo yoursite_format_currency($annual_monthly, $current_currency['code']);
                                                } else {
                                                    echo $currency_symbol . number_format($annual_monthly, 0);
                                                }
                                                ?>
                                            </span>
                                            <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/month</span>
                                        </div>
                                        <?php if ($annual_price > 0) : ?>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                <span>
                                                    <?php 
                                                    printf(
                                                        __('Billed annually (%s/year)', 'yoursite'), 
                                                        '<span data-price-type="annual" data-plan-id="' . esc_attr($plan->ID) . '">' . 
                                                        (function_exists('yoursite_format_currency') 
                                                            ? yoursite_format_currency($annual_price, $current_currency['code'])
                                                            : $currency_symbol . number_format($annual_price, 0)
                                                        ) . '</span>'
                                                    ); 
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="homepage-annual-savings mt-2">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    <?php _e('Save', 'yoursite'); ?> 
                                                    <span data-savings-amount data-plan-id="<?php echo esc_attr($plan->ID); ?>" class="ml-1">
                                                        <?php 
                                                        if (function_exists('yoursite_format_currency')) {
                                                            echo yoursite_format_currency($savings, $current_currency['code']);
                                                        } else {
                                                            echo $currency_symbol . number_format($savings, 0);
                                                        }
                                                        ?>
                                                    </span>/year
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Features List -->
                                <?php if (!empty($meta['pricing_features'])) : ?>
                                    <div class="features-section mb-6 flex-grow">
                                        <ul class="space-y-3">
                                            <?php 
                                            $features = array_filter(explode("\n", $meta['pricing_features']));
                                            foreach ($features as $feature_index => $feature) : 
                                                $feature = trim($feature);
                                                if (!empty($feature)) :
                                            ?>
                                                <li class="flex items-start">
                                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span class="text-gray-700 dark:text-gray-300">
                                                        <?php echo esc_html($feature); ?>
                                                    </span>
                                                </li>
                                            <?php endif; endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- CTA Button -->
                                <div class="cta-section mt-auto">
                                    <?php if ($is_featured) : ?>
                                        <!-- Featured Plan CTA -->
                                        <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>" 
                                           class="pricing-button w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 mb-4 inline-block text-center focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg"
                                           data-monthly-url="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>"
                                           data-annual-url="<?php echo esc_url(str_replace('monthly', 'annual', $meta['pricing_button_url'] ?: '#')); ?>">
                                            <?php echo esc_html($meta['pricing_button_text'] ?: __('Start Free Trial', 'yoursite')); ?>
                                        </a>
                                    <?php else : ?>
                                        <!-- Regular Plan CTA -->
                                        <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>" 
                                           class="pricing-button w-full bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 mb-4 inline-block text-center focus:outline-none focus:ring-4 focus:ring-gray-300"
                                           data-monthly-url="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>"
                                           data-annual-url="<?php echo esc_url(str_replace('monthly', 'annual', $meta['pricing_button_url'] ?: '#')); ?>">
                                            <?php echo esc_html($meta['pricing_button_text'] ?: __('Start Free Trial', 'yoursite')); ?>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <!-- Trust Signal -->
                                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                                        <?php _e('14-day free trial • No credit card required', 'yoursite'); ?>
                                    </p>
                                </div>
                            </div>
                            
                            <?php endforeach; ?>
                        </div>
                        
                    <?php else : ?>
                        <!-- Fallback Pricing if no pricing posts exist -->
                        <div class="homepage-pricing-grid" id="pricing-cards-container">
                            <!-- Free Plan -->
                            <div class="pricing-card" data-plan-id="free">
                                <div class="text-center mb-6">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Free</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Perfect for getting started</p>
                                </div>
                                <div class="price-section mb-6 text-center">
                                    <div class="monthly-pricing pricing-display homepage-monthly-pricing" style="display: none;">
                                        <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                            <span class="price-amount"><?php echo $current_currency['symbol']; ?>0</span>
                                            <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/month</span>
                                        </div>
                                    </div>
                                    <div class="annual-pricing pricing-display homepage-annual-pricing">
                                        <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                            <span class="price-amount"><?php echo $current_currency['symbol']; ?>0</span>
                                            <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/month</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="cta-section mt-auto">
                                    <a href="#signup" class="pricing-button w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 inline-block text-center">
                                        Start Free
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Pro Plan -->
                            <div class="pricing-card featured" data-plan-id="pro">
                                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-20">
                                    <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                                        Most Popular
                                    </span>
                                </div>
                                <div class="text-center mb-6 pt-8">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Pro</h3>
                                    <p class="text-gray-600 dark:text-gray-300">For growing businesses</p>
                                </div>
                                <div class="price-section mb-6 text-center">
                                    <div class="monthly-pricing pricing-display homepage-monthly-pricing" style="display: none;">
                                        <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                            <span class="price-amount"><?php echo $current_currency['symbol']; ?>29</span>
                                            <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/month</span>
                                        </div>
                                    </div>
                                    <div class="annual-pricing pricing-display homepage-annual-pricing">
                                        <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                            <span class="price-amount"><?php echo $current_currency['symbol']; ?>23</span>
                                            <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/month</span>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Billed annually (<?php echo $current_currency['symbol']; ?>276/year)
                                        </div>
                                    </div>
                                </div>
                                <div class="cta-section mt-auto">
                                    <a href="#signup" class="pricing-button w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 inline-block text-center shadow-lg">
                                        Start Free Trial
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Enterprise Plan -->
                            <div class="pricing-card" data-plan-id="enterprise">
                                <div class="text-center mb-6">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Enterprise</h3>
                                    <p class="text-gray-600 dark:text-gray-300">For large organizations</p>
                                </div>
                                <div class="price-section mb-6 text-center">
                                    <div class="monthly-pricing pricing-display homepage-monthly-pricing" style="display: none;">
                                        <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                            <span class="price-amount"><?php echo $current_currency['symbol']; ?>99</span>
                                            <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/month</span>
                                        </div>
                                    </div>
                                    <div class="annual-pricing pricing-display homepage-annual-pricing">
                                        <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                            <span class="price-amount"><?php echo $current_currency['symbol']; ?>79</span>
                                            <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/month</span>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Billed annually (<?php echo $current_currency['symbol']; ?>948/year)
                                        </div>
                                    </div>
                                </div>
                                <div class="cta-section mt-auto">
                                    <a href="#contact" class="pricing-button w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 inline-block text-center">
                                        Contact Sales
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Trust Signals Section -->
                    <div class="trust-signals-section bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mt-12">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                            <div class="trust-signal-item">
                                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-4 mx-auto">
                                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    <?php _e('30-Day Money Back', 'yoursite'); ?>
                                </h4>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <?php _e('Full refund if not satisfied', 'yoursite'); ?>
                                </p>
                            </div>
                            
                            <div class="trust-signal-item">
                                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-4 mx-auto">
                                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    <?php _e('Setup in Minutes', 'yoursite'); ?>
                                </h4>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <?php _e('Quick and easy onboarding', 'yoursite'); ?>
                                </p>
                            </div>
                            
                            <div class="trust-signal-item">
                                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mb-4 mx-auto">
                                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    <?php _e('24/7 Support', 'yoursite'); ?>
                                </h4>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <?php _e('Always here to help you succeed', 'yoursite'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Compare All Features Button -->
                    <?php if ($comparison_enable) : ?>
                    <div class="text-center mt-16">
                        <button class="unified-compare-btn hover:bg-gray-100 dark:hover:bg-gray-700 text-lg px-8 py-4 rounded-lg font-semibold" data-scroll-to-comparison onclick="document.querySelector('.pricing-comparison-wrapper').scrollIntoView({behavior: 'smooth'})">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                Compare All Features
                            </span>
                        </button>
                    </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- DIFM Banner Section -->
    <section class="py-16 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 border-y border-gray-200 dark:border-gray-600">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    
                    <!-- Background Pattern -->
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-purple-600/5 dark:from-blue-400/10 dark:to-purple-400/10"></div>
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-full transform translate-x-16 -translate-y-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-purple-500/10 to-pink-500/10 rounded-full transform -translate-x-12 translate-y-12"></div>
                        
                        <!-- Content -->
                        <div class="relative px-8 py-12 lg:px-12 lg:py-16">
                            <div class="grid lg:grid-cols-2 gap-12 items-center">
                                
                                <!-- Left Content -->
                                <div class="text-center lg:text-left">
                                    <!-- Badge -->
                                    <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full text-sm font-semibold text-blue-700 dark:text-blue-300 mb-6">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <?php echo esc_html(get_theme_mod('difm_banner_badge_text', 'Done-For-You Service')); ?>
                                    </div>
                                    
                                    <!-- Main Heading -->
                                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                                        <?php echo esc_html(get_theme_mod('difm_banner_title', 'Don\'t Want to Build It Yourself?')); ?>
                                    </h2>
                                    
                                    <!-- Subheading -->
                                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                                        <?php echo esc_html(get_theme_mod('difm_banner_subtitle', 'Let our expert team build your perfect website while you focus on your business.')); ?>
                                    </p>
                                    
                                    <!-- Features List -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8 text-left">
                                        <?php 
                                        $features = array(
                                            get_theme_mod('difm_banner_feature_1', 'Professional Design'),
                                            get_theme_mod('difm_banner_feature_2', 'Fast Delivery'),
                                            get_theme_mod('difm_banner_feature_3', 'Full Setup Included'),
                                            get_theme_mod('difm_banner_feature_4', 'Ongoing Support')
                                        );
                                        
                                        $feature_icons = array(
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>',
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>',
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>'
                                        );
                                        
                                        foreach ($features as $index => $feature) :
                                            if (!empty(trim($feature))) :
                                        ?>
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400 mr-3">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <?php echo $feature_icons[$index]; ?>
                                                    </svg>
                                                </div>
                                                <span class="text-gray-700 dark:text-gray-300 text-sm font-medium"><?php echo esc_html($feature); ?></span>
                                            </div>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    </div>
                                    
                                    <!-- CTA Buttons -->
                                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                        <!-- Primary CTA - Build My Website -->
                                        <a href="<?php echo esc_url(home_url(get_theme_mod('difm_banner_primary_url', '/build-my-website'))); ?>" 
                                           class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4"></path>
                                            </svg>
                                            <?php echo esc_html(get_theme_mod('difm_banner_primary_text', 'Build My Website')); ?>
                                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- Secondary CTA - Contact -->
                                        <a href="<?php echo esc_url(home_url(get_theme_mod('difm_banner_secondary_url', '/contact'))); ?>" 
                                           class="group inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            <?php echo esc_html(get_theme_mod('difm_banner_secondary_text', 'Ask Questions')); ?>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Right Visual Element -->
                                <div class="relative hidden lg:block">
                                    <div class="relative w-full max-w-md mx-auto">
                                        <!-- Main illustration container -->
                                        <div class="relative bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl p-8 border border-blue-100 dark:border-blue-800">
                                            <!-- Computer/Website mockup -->
                                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                                <!-- Browser bar -->
                                                <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                                                    <div class="flex items-center space-x-2">
                                                        <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                                        <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                                        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                                        <div class="flex-1 bg-white dark:bg-gray-600 rounded-sm h-6 ml-4 flex items-center px-3">
                                                            <div class="w-3 h-3 bg-gray-300 dark:bg-gray-500 rounded mr-2"></div>
                                                            <div class="w-24 h-2 bg-gray-200 dark:bg-gray-500 rounded"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Website content -->
                                                <div class="p-6">
                                                    <div class="space-y-4">
                                                        <div class="h-4 bg-gradient-to-r from-blue-200 to-purple-200 dark:from-blue-700 dark:to-purple-700 rounded w-3/4"></div>
                                                        <div class="h-3 bg-gray-200 dark:bg-gray-600 rounded w-full"></div>
                                                        <div class="h-3 bg-gray-200 dark:bg-gray-600 rounded w-5/6"></div>
                                                        <div class="flex space-x-3 mt-4">
                                                            <div class="w-20 h-12 bg-gradient-to-r from-blue-400 to-purple-400 rounded"></div>
                                                            <div class="w-20 h-12 bg-gray-200 dark:bg-gray-600 rounded"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Floating elements -->
                                            <div class="absolute -top-4 -right-4 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center shadow-lg">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            
                                            <div class="absolute -bottom-3 -left-3 w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center shadow-lg">
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    
                    // Default FAQ data
                    $default_faqs = array(
                        1 => array('question' => 'Can I change plans anytime?', 'answer' => 'Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle, and we\'ll prorate any differences.'),
                        2 => array('question' => 'Is there a free trial?', 'answer' => 'Yes, all paid plans come with a 14-day free trial. No credit card required to get started. You can also use our Free plan indefinitely.'),
                        3 => array('question' => 'What payment methods do you accept?', 'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers for enterprise customers.'),
                        4 => array('question' => 'Do you offer refunds?', 'answer' => 'Yes, we offer a 30-day money-back guarantee. If you\'re not satisfied with our service, contact us within 30 days for a full refund.'),
                        5 => array('question' => 'Can I cancel anytime?', 'answer' => 'Absolutely! You can cancel your subscription at any time. Your account will remain active until the end of your current billing period.')
                    );
                    
                    for ($i = 1; $i <= 5; $i++) : 
                        $faq_enabled = get_theme_mod("pricing_faq_{$i}_enable", true);
                        $question = get_theme_mod("pricing_faq_{$i}_question", $default_faqs[$i]['question']);
                        $answer = get_theme_mod("pricing_faq_{$i}_answer", $default_faqs[$i]['answer']);
                        
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
                    
                    if ($faq_count === 0 && current_user_can('manage_options')) : ?>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                            <p class="text-yellow-800"><strong>Admin Notice:</strong> No FAQ items are being displayed. Check <strong>Appearance → Customize → Pricing Page</strong> to configure your FAQs.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</div>

<!-- Enhanced JavaScript for Dynamic Currency and Billing -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== ENHANCED PRICING PAGE WITH DYNAMIC CURRENCY LOADED ===');
    
    // Find elements
    var pricingPage = document.querySelector('.pricing-page');
    var billingToggle = document.getElementById('pricing-billing-toggle');
    var comparisonToggle = document.getElementById('comparison-billing-toggle');
    var currencySelector = document.querySelector('.pricing-currency-selector');
    
    // Find all pricing elements
    var mainMonthlyPricing = document.querySelectorAll('.homepage-monthly-pricing, .monthly-pricing');
    var mainAnnualPricing = document.querySelectorAll('.homepage-annual-pricing, .annual-pricing');
    var mainAnnualSavings = document.querySelectorAll('.homepage-annual-savings, .annual-savings');
    var comparisonMonthlyPricing = document.querySelectorAll('.monthly-pricing');
    var comparisonAnnualPricing = document.querySelectorAll('.annual-pricing');
    
    // Set initial state
    if (billingToggle) billingToggle.checked = true;
    if (comparisonToggle) comparisonToggle.checked = true;
    
    // Initial display setup
    showYearlyPricing();
    
    function showYearlyPricing() {
        console.log('Showing yearly pricing');
        
        // Update main pricing cards
        for (var i = 0; i < mainMonthlyPricing.length; i++) {
            mainMonthlyPricing[i].style.display = 'none';
        }
        
        for (var i = 0; i < mainAnnualPricing.length; i++) {
            mainAnnualPricing[i].style.display = 'block';
        }
        
        for (var i = 0; i < mainAnnualSavings.length; i++) {
            mainAnnualSavings[i].style.display = 'block';
        }
        
        // Update comparison table
        for (var i = 0; i < comparisonMonthlyPricing.length; i++) {
            comparisonMonthlyPricing[i].style.display = 'none';
        }
        
        for (var i = 0; i < comparisonAnnualPricing.length; i++) {
            comparisonAnnualPricing[i].style.display = 'block';
        }
        
        // Update page classes
        if (pricingPage) {
            pricingPage.classList.add('show-annual');
            pricingPage.classList.remove('show-monthly');
        }
        
        // Update comparison wrapper classes
        var comparisonWrapper = document.querySelector('.pricing-comparison-wrapper');
        if (comparisonWrapper) {
            comparisonWrapper.classList.add('comparison-yearly-active');
            comparisonWrapper.classList.remove('comparison-monthly-active');
        }
        
        updateLabels(true);
    }
    
    function showMonthlyPricing() {
        console.log('Showing monthly pricing');
        
        // Update main pricing cards
        for (var i = 0; i < mainMonthlyPricing.length; i++) {
            mainMonthlyPricing[i].style.display = 'block';
        }
        
        for (var i = 0; i < mainAnnualPricing.length; i++) {
            mainAnnualPricing[i].style.display = 'none';
        }
        
        for (var i = 0; i < mainAnnualSavings.length; i++) {
            mainAnnualSavings[i].style.display = 'none';
        }
        
        // Update comparison table
        for (var i = 0; i < comparisonMonthlyPricing.length; i++) {
            comparisonMonthlyPricing[i].style.display = 'block';
        }
        
        for (var i = 0; i < comparisonAnnualPricing.length; i++) {
            comparisonAnnualPricing[i].style.display = 'none';
        }
        
        // Update page classes
        if (pricingPage) {
            pricingPage.classList.remove('show-annual');
            pricingPage.classList.add('show-monthly');
        }
        
        // Update comparison wrapper classes
        var comparisonWrapper = document.querySelector('.pricing-comparison-wrapper');
        if (comparisonWrapper) {
            comparisonWrapper.classList.remove('comparison-yearly-active');
            comparisonWrapper.classList.add('comparison-monthly-active');
        }
        
        updateLabels(false);
    }
    
    function updateLabels(isYearly) {
        // Update main labels
        var mainMonthlyLabel = document.querySelector('.pricing-monthly-label');
        var mainYearlyLabel = document.querySelector('.pricing-yearly-label');
        
        if (mainMonthlyLabel && mainYearlyLabel) {
            if (isYearly) {
                mainYearlyLabel.style.opacity = '1';
                mainMonthlyLabel.style.opacity = '0.7';
            } else {
                mainMonthlyLabel.style.opacity = '1';
                mainYearlyLabel.style.opacity = '0.7';
            }
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
        }
    }
    
    // Main toggle event
    if (billingToggle) {
        billingToggle.addEventListener('change', function() {
            var isYearly = this.checked;
            console.log('Main toggle changed to:', isYearly ? 'YEARLY' : 'MONTHLY');
            
            // Sync comparison toggle
            if (comparisonToggle) {
                comparisonToggle.checked = isYearly;
            }
            
            // Update displays
            if (isYearly) {
                showYearlyPricing();
            } else {
                showMonthlyPricing();
            }
            
            // Update button URLs
            updateButtonUrls(isYearly);
        });
    }
    
    // Comparison toggle event
    if (comparisonToggle) {
        comparisonToggle.addEventListener('change', function() {
            var isYearly = this.checked;
            console.log('Comparison toggle changed to:', isYearly ? 'YEARLY' : 'MONTHLY');
            
            // Sync main toggle
            if (billingToggle) {
                billingToggle.checked = isYearly;
            }
            
            // Update displays
            if (isYearly) {
                showYearlyPricing();
            } else {
                showMonthlyPricing();
            }
            
            // Update button URLs
            updateButtonUrls(isYearly);
        });
    }
    
    function updateButtonUrls(isAnnual) {
        var pricingButtons = document.querySelectorAll('.pricing-button');
        pricingButtons.forEach(function(button) {
            var newUrl = isAnnual ? 
                button.dataset.annualUrl : 
                button.dataset.monthlyUrl;
            
            if (newUrl) {
                button.href = newUrl;
            }
        });
    }
    
    // Currency change functionality
    document.addEventListener('currencyChanged', function(e) {
        updateAllPricing(e.detail.currency);
    });
    
    // Listen for currency selector changes
    document.addEventListener('click', function(e) {
        var currencyItem = e.target.closest('[data-currency-code], [data-currency]');
        if (!currencyItem) return;
        
        var newCurrency = currencyItem.dataset.currency || currencyItem.dataset.currencyCode;
        if (newCurrency) {
            updateAllPricing(newCurrency);
        }
    });
    
    function updateAllPricing(currencyCode) {
        console.log('Updating all pricing to currency:', currencyCode);
        
        // Show loading state
        var pricingSection = document.querySelector('.unified-pricing-section');
        if (pricingSection) {
            pricingSection.classList.add('pricing-updating');
            pricingSection.style.opacity = '0.7';
            pricingSection.style.pointerEvents = 'none';
        }
        
        // Get all plan IDs
        var planCards = document.querySelectorAll('[data-plan-id]');
        var planIds = Array.from(planCards).map(function(card) { 
            return card.dataset.planId; 
        }).filter(function(id) { 
            return id && id !== 'free' && id !== 'pro' && id !== 'enterprise'; 
        });
        
        if (planIds.length > 0) {
            // Fetch pricing for real plans
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_all_pricing_in_currency',
                    currency: currencyCode,
                    plan_ids: planIds.join(','),
                    nonce: '<?php echo wp_create_nonce("get_pricing"); ?>'
                })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success && data.data.pricing) {
                    updatePricingCards(data.data.pricing, data.data.currency_info);
                    showCurrencyChangeNotification(currencyCode);
                } else {
                    console.error('Failed to update pricing:', data.data);
                    // Fallback: update currency symbols only
                    updateCurrencySymbolsOnly(currencyCode);
                    showCurrencyChangeNotification(currencyCode);
                }
            })
            .catch(function(error) {
                console.error('Error updating pricing:', error);
                // Fallback: update currency symbols only
                updateCurrencySymbolsOnly(currencyCode);
                showCurrencyChangeNotification(currencyCode);
            })
            .finally(function() {
                // Remove loading state
                if (pricingSection) {
                    pricingSection.classList.remove('pricing-updating');
                    pricingSection.style.opacity = '';
                    pricingSection.style.pointerEvents = '';
                }
            });
        } else {
            // Update fallback pricing cards
            updateCurrencySymbolsOnly(currencyCode);
            showCurrencyChangeNotification(currencyCode);
            if (pricingSection) {
                pricingSection.classList.remove('pricing-updating');
                pricingSection.style.opacity = '';
                pricingSection.style.pointerEvents = '';
            }
        }
    }
    
    function updatePricingCards(pricingData, currencyInfo) {
        Object.keys(pricingData).forEach(function(planId) {
            var pricing = pricingData[planId];
            var card = document.querySelector('[data-plan-id="' + planId + '"]');
            
            if (!card) return;
            
            try {
                // Update monthly price
                var monthlyAmount = card.querySelector('[data-price-type="monthly"][data-plan-id="' + planId + '"]');
                if (monthlyAmount && pricing.monthly_price_formatted) {
                    monthlyAmount.textContent = pricing.monthly_price_formatted.replace(/[^\d.,€£$¥]/g, '');
                }
                
                // Update annual monthly equivalent
                var annualMonthlyAmount = card.querySelector('[data-price-type="annual-monthly"][data-plan-id="' + planId + '"]');
                if (annualMonthlyAmount && pricing.annual_monthly_equivalent_formatted) {
                    annualMonthlyAmount.textContent = pricing.annual_monthly_equivalent_formatted.replace(/[^\d.,€£$¥]/g, '');
                }
                
                // Update annual total
                var annualAmount = card.querySelector('[data-price-type="annual"][data-plan-id="' + planId + '"]');
                if (annualAmount && pricing.annual_price_formatted) {
                    annualAmount.textContent = pricing.annual_price_formatted;
                }
                
                // Update savings
                var savingsAmount = card.querySelector('[data-savings-amount][data-plan-id="' + planId + '"]');
                if (savingsAmount && pricing.savings_formatted) {
                    savingsAmount.textContent = pricing.savings_formatted;
                }
                
                // Update currency symbols if they exist as separate elements
                var currencySymbols = card.querySelectorAll('.currency-symbol');
                currencySymbols.forEach(function(symbol) {
                    if (currencyInfo && currencyInfo.symbol) {
                        symbol.textContent = currencyInfo.symbol;
                    }
                });
                
            } catch (error) {
                console.error('Error updating card pricing:', error, planId);
            }
        });
    }
    
    function updateCurrencySymbolsOnly(currencyCode) {
        // Get currency symbol based on code
        var currencySymbols = {
            'USD': '$',
            'EUR': '€',
            'GBP': '£',
            'CAD': 'C',
            'AUD': 'A',
            'JPY': '¥',
            'CHF': 'CHF',
            'SEK': 'kr',
            'NOK': 'kr',
            'DKK': 'kr'
        };
        
        var symbol = currencySymbols[currencyCode] || '$';
        
        // Update fallback pricing if exists
        var fallbackCards = document.querySelectorAll('[data-plan-id="free"], [data-plan-id="pro"], [data-plan-id="enterprise"]');
        
        fallbackCards.forEach(function(card) {
            var priceAmounts = card.querySelectorAll('.price-amount');
            priceAmounts.forEach(function(amount) {
                var currentText = amount.textContent;
                var numericValue = currentText.replace(/[^\d]/g, '');
                if (numericValue) {
                    amount.textContent = symbol + numericValue;
                }
            });
            
            // Update annual billing text
            var annualTexts = card.querySelectorAll('p, div');
            annualTexts.forEach(function(text) {
                if (text.textContent.includes('Billed annually')) {
                    var matches = text.textContent.match(/\d+/);
                    if (matches) {
                        var planId = card.dataset.planId;
                        var annualPrice;
                        
                        switch(planId) {
                            case 'pro':
                                annualPrice = 276;
                                break;
                            case 'enterprise':
                                annualPrice = 948;
                                break;
                            default:
                                annualPrice = parseInt(matches[0]);
                        }
                        
                        // Simple currency conversion estimation (you'd want real rates)
                        if (currencyCode === 'EUR') {
                            annualPrice = Math.round(annualPrice * 0.85);
                        } else if (currencyCode === 'GBP') {
                            annualPrice = Math.round(annualPrice * 0.75);
                        }
                        
                        text.innerHTML = text.innerHTML.replace(/[$€£¥]\d+/, symbol + annualPrice);
                    }
                }
            });
        });
    }
    
    function showCurrencyChangeNotification(currencyCode) {
        // Remove any existing notifications
        var existingNotifications = document.querySelectorAll('.currency-change-notification');
        existingNotifications.forEach(function(n) { n.remove(); });
        
        // Create notification
        var notification = document.createElement('div');
        notification.className = 'currency-change-notification fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
        notification.innerHTML = '\
            <div class="flex items-center">\
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">\
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>\
                </svg>\
                <span>Prices updated to ' + currencyCode + '</span>\
            </div>\
        ';
        
        document.body.appendChild(notification);
        
        // Animate in
        requestAnimationFrame(function() {
            notification.classList.remove('translate-x-full');
            notification.classList.add('translate-x-0');
        });
        
        // Remove after 3 seconds
        setTimeout(function() {
            notification.classList.add('translate-x-full');
            setTimeout(function() { 
                if (notification.parentNode) {
                    notification.remove(); 
                }
            }, 300);
        }, 3000);
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
    
    // Enhanced currency change listener
    document.addEventListener('currencyChanged', function(e) {
        console.log('Currency changed event received:', e.detail.currency);
        updateAllPricing(e.detail.currency);
    });
    
    console.log('Enhanced pricing page setup complete');
});
</script>

<?php get_footer(); ?>
<?php
/**
 * Template Name: Pricing Page with Comparison Table
 * Updated page-pricing.php
 */

get_header();

// Load required files
require_once get_template_directory() . '/inc/pricing-comparison-table.php';
require_once get_template_directory() . '/inc/pricing-shortcodes.php';
?>

<div class="pricing-page bg-gray-50 dark:bg-gray-900 min-h-screen">
    
    <!-- Hero Section -->
    <section class="bg-white dark:bg-gray-800 py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                    Simple, Transparent Pricing
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8">
                    Choose the perfect plan for your business. Start free, upgrade when you're ready.
                </p>
                
                <!-- Billing Toggle -->
                <div class="flex items-center justify-center mb-8">
                    <span class="text-gray-700 dark:text-gray-300 mr-4 font-medium billing-monthly">Monthly</span>
                    <div class="relative">
                        <input type="checkbox" id="billing-toggle" class="sr-only peer">
                        <label for="billing-toggle" class="relative inline-flex items-center justify-between w-16 h-8 bg-gray-200 dark:bg-gray-700 rounded-full cursor-pointer transition-colors duration-300 peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800">
                            <span class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 peer-checked:translate-x-8"></span>
                        </label>
                    </div>
                    <span class="text-gray-700 dark:text-gray-300 ml-4 font-medium billing-yearly">Yearly</span>
                    <span class="bg-emerald-500 text-emerald-50 dark:text-white text-sm font-semibold px-3 py-1 rounded-full ml-3 shadow-md">Save 20%</span>
                </div>
                
                <!-- Compare Plans Button -->
                <div class="mb-4">
                    <button class="btn-secondary" data-scroll-to-comparison onclick="document.querySelector('.pricing-comparison-wrapper').scrollIntoView({behavior: 'smooth'})">
                        📊 Compare All Plans & Features
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Cards -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-8xl mx-auto">
                
                <!-- Pricing Cards Container -->
                <div class="pricing-cards-container relative">
                    <!-- Navigation Buttons -->
                    <button id="prev-btn" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 bg-white dark:bg-gray-800 shadow-lg rounded-full p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 hidden lg:block">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    
                    <button id="next-btn" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 bg-white dark:bg-gray-800 shadow-lg rounded-full p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 hidden lg:block">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <div class="pricing-slider overflow-hidden">
                        <div class="pricing-cards-wrapper flex transition-transform duration-300 ease-in-out" id="pricing-cards-wrapper">
                            
                            <?php
                            // Get pricing plans from database first
                            $pricing_plans = get_posts(array(
                                'post_type' => 'pricing',
                                'posts_per_page' => -1,
                                'post_status' => 'publish',
                                'meta_key' => '_pricing_monthly_price',
                                'orderby' => 'meta_value_num',
                                'order' => 'ASC'
                            ));
                            
                            // If no custom plans exist, use default plans
                            if (empty($pricing_plans)) {
                                $default_plans = array(
                                    array(
                                        'name' => 'Free',
                                        'description' => 'Perfect for trying out our platform',
                                        'price' => 0,
                                        'featured' => false,
                                        'button_text' => 'Get Started Free',
                                        'features' => array(
                                            'Up to 50 products',
                                            'Basic analytics',
                                            'Email support',
                                            'SSL certificate',
                                            'Mobile responsive'
                                        )
                                    ),
                                    array(
                                        'name' => 'Starter',
                                        'description' => 'Perfect for small businesses getting started',
                                        'price' => 19,
                                        'featured' => false,
                                        'button_text' => 'Get Started',
                                        'features' => array(
                                            'Up to 500 products',
                                            'Advanced analytics',
                                            'Priority support',
                                            'Custom domain',
                                            'Payment processing',
                                            'Inventory management'
                                        )
                                    ),
                                    array(
                                        'name' => 'Professional',
                                        'description' => 'Best for growing businesses',
                                        'price' => 49,
                                        'featured' => true,
                                        'button_text' => 'Get Started',
                                        'features' => array(
                                            'Up to 2,000 products',
                                            'Advanced analytics',
                                            'Priority support',
                                            'Custom integrations',
                                            'Marketing automation',
                                            'Multi-location support',
                                            'Advanced SEO tools'
                                        )
                                    ),
                                    array(
                                        'name' => 'Business',
                                        'description' => 'For established businesses',
                                        'price' => 79,
                                        'featured' => false,
                                        'button_text' => 'Get Started',
                                        'features' => array(
                                            'Up to 5,000 products',
                                            'Advanced reporting',
                                            'Phone support',
                                            'API access',
                                            'Advanced integrations',
                                            'Team collaboration',
                                            'White-label options'
                                        )
                                    ),
                                    array(
                                        'name' => 'Enterprise',
                                        'description' => 'For large scale operations',
                                        'price' => 149,
                                        'featured' => false,
                                        'button_text' => 'Contact Sales',
                                        'features' => array(
                                            'Unlimited products',
                                            'Custom integrations',
                                            'Dedicated support',
                                            'White-label solution',
                                            'API access',
                                            'Custom reporting',
                                            'SLA guarantee'
                                        )
                                    )
                                );
                                
                                foreach ($default_plans as $plan) :
                                    $yearly_price = $plan['price'] * 12 * 0.8; // 20% discount
                                ?>
                                    <div class="pricing-card-slide flex-shrink-0 px-4">
                                        <div class="pricing-card <?php echo $plan['featured'] ? 'featured-card' : ''; ?> bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden h-full border border-gray-200 dark:border-gray-700">
                                            
                                            <?php if ($plan['featured']) : ?>
                                                <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-2 text-sm font-semibold">
                                                    Most Popular
                                                </div>
                                                <div class="pt-10 pb-8 px-8">
                                            <?php else : ?>
                                                <div class="p-8">
                                            <?php endif; ?>
                                            
                                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2"><?php echo $plan['name']; ?></h3>
                                                <p class="text-gray-600 dark:text-gray-300 mb-6"><?php echo $plan['description']; ?></p>
                                                
                                                <div class="mb-8">
                                                    <div class="price-display">
                                                        <span class="text-5xl font-bold text-gray-900 dark:text-white monthly-price">
                                                            $<?php echo number_format($plan['price'], 0); ?>
                                                        </span>
                                                        <span class="text-5xl font-bold text-gray-900 dark:text-white yearly-price hidden">
                                                            $<?php echo number_format($yearly_price / 12, 0); ?>
                                                        </span>
                                                        <span class="text-gray-600 dark:text-gray-400 text-lg ml-2">
                                                            <span class="monthly-period">/month</span>
                                                            <span class="yearly-period hidden">/month</span>
                                                        </span>
                                                    </div>
                                                    <?php if ($plan['price'] > 0) : ?>
                                                        <div class="yearly-savings text-green-600 dark:text-green-400 text-sm font-medium mt-2 hidden">
                                                            Save $<?php echo number_format(($plan['price'] * 12) - $yearly_price, 0); ?> per year
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <a href="#" class="<?php echo $plan['featured'] ? 'btn-primary' : 'btn-secondary'; ?> w-full text-center py-4 px-6 rounded-lg font-semibold text-lg mb-8 block transition-all duration-200 hover:transform hover:-translate-y-1">
                                                    <?php echo $plan['button_text']; ?>
                                                </a>
                                                
                                                <ul class="space-y-4">
                                                    <?php foreach ($plan['features'] as $feature) : ?>
                                                        <li class="flex items-center">
                                                            <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                            <span class="text-gray-700 dark:text-gray-300"><?php echo $feature; ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;
                            } else {
                                // Display custom pricing plans from database
                                foreach ($pricing_plans as $plan) :
                                    if (!function_exists('yoursite_get_pricing_meta_fields')) {
                                        require_once get_template_directory() . '/inc/pricing-meta-boxes.php';
                                    }
                                    $meta = yoursite_get_pricing_meta_fields($plan->ID);
                                    $is_featured = $meta['pricing_featured'] === '1';
                                    $monthly_price = floatval($meta['pricing_monthly_price']);
                                    $annual_price = floatval($meta['pricing_annual_price']);
                                    $currency_symbol = yoursite_get_currency_symbol($meta['pricing_currency']);
                                    
                                    if ($annual_price == 0 && $monthly_price > 0) {
                                        $annual_price = $monthly_price * 12 * 0.8; // 20% discount
                                    }
                                    $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
                                ?>
                                    <div class="pricing-card-slide flex-shrink-0 px-4">
                                        <div class="pricing-card <?php echo $is_featured ? 'featured-card' : ''; ?> bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden h-full border border-gray-200 dark:border-gray-700">
                                            
                                            <?php if ($is_featured) : ?>
                                                <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-2 text-sm font-semibold">
                                                    Most Popular
                                                </div>
                                                <div class="pt-10 pb-8 px-8">
                                            <?php else : ?>
                                                <div class="p-8">
                                            <?php endif; ?>
                                            
                                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2"><?php echo esc_html($plan->post_title); ?></h3>
                                                <p class="text-gray-600 dark:text-gray-300 mb-6"><?php echo esc_html($plan->post_excerpt); ?></p>
                                                
                                                <div class="mb-8">
                                                    <div class="price-display">
                                                        <span class="text-5xl font-bold text-gray-900 dark:text-white monthly-price">
                                                            <?php echo $currency_symbol . number_format($monthly_price, 0); ?>
                                                        </span>
                                                        <span class="text-5xl font-bold text-gray-900 dark:text-white yearly-price hidden">
                                                            <?php echo $currency_symbol . number_format($annual_monthly, 0); ?>
                                                        </span>
                                                        <span class="text-gray-600 dark:text-gray-400 text-lg ml-2">
                                                            <span class="monthly-period">/month</span>
                                                            <span class="yearly-period hidden">/month</span>
                                                        </span>
                                                    </div>
                                                    <?php if ($monthly_price > 0) : ?>
                                                        <div class="yearly-savings text-green-600 dark:text-green-400 text-sm font-medium mt-2 hidden">
                                                            Save <?php echo $currency_symbol . number_format(($monthly_price * 12) - $annual_price, 0); ?> per year
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>" class="<?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?> w-full text-center py-4 px-6 rounded-lg font-semibold text-lg mb-8 block transition-all duration-200 hover:transform hover:-translate-y-1">
                                                    <?php echo esc_html($meta['pricing_button_text'] ?: 'Get Started'); ?>
                                                </a>
                                                
                                                <?php if (!empty($meta['pricing_features'])) : ?>
                                                    <ul class="space-y-4">
                                                        <?php 
                                                        $features = array_filter(explode("\n", $meta['pricing_features']));
                                                        foreach ($features as $feature) : 
                                                            $feature = trim($feature);
                                                            if (!empty($feature)) :
                                                        ?>
                                                            <li class="flex items-center">
                                                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                                <span class="text-gray-700 dark:text-gray-300"><?php echo esc_html($feature); ?></span>
                                                            </li>
                                                        <?php endif; endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;
                            } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Plans Comparison Table Section -->
    <section class="py-20 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Compare Plans & Features
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        Get a detailed comparison of all plans and features to make the best choice for your business.
                    </p>
                </div>
                
                <!-- Comparison Table -->
                <?php echo yoursite_render_pricing_comparison_table(); ?>
                
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Frequently Asked Questions
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300">
                        Quick answers to common pricing questions
                    </p>
                </div>
                
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <button class="flex justify-between items-center w-full text-left faq-toggle">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Can I change plans anytime?</h3>
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600 dark:text-gray-300">Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle, and we'll prorate any differences.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <button class="flex justify-between items-center w-full text-left faq-toggle">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Is there a free trial?</h3>
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600 dark:text-gray-300">Yes, all paid plans come with a 14-day free trial. No credit card required to get started. You can also use our Free plan indefinitely.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <button class="flex justify-between items-center w-full text-left faq-toggle">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">What payment methods do you accept?</h3>
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600 dark:text-gray-300">We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers for enterprise customers.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <button class="flex justify-between items-center w-full text-left faq-toggle">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Do you offer refunds?</h3>
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600 dark:text-gray-300">Yes, we offer a 30-day money-back guarantee. If you're not satisfied with our service, contact us within 30 days for a full refund.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <button class="flex justify-between items-center w-full text-left faq-toggle">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Can I cancel anytime?</h3>
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600 dark:text-gray-300">Absolutely! You can cancel your subscription at any time. Your account will remain active until the end of your current billing period.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gray-900 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-6">Ready to get started?</h2>
                <p class="text-xl text-gray-300 mb-8">Join thousands of businesses already using our platform</p>
                <a href="#" class="btn-primary text-lg px-8 py-4 inline-block">
                    Start Your Free Trial
                </a>
            </div>
        </div>
    </section>
</div>

<style>
/* Enhanced pricing page specific styles */
.featured-card {
    transform: scale(1.02);
    border: 2px solid #3b82f6 !important;
    position: relative;
}

.pricing-card {
    transition: all 0.3s ease;
}

.pricing-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.featured-card:hover {
    transform: scale(1.02) translateY(-4px);
}

/* Slider styles */
.pricing-cards-container {
    position: relative;
}

.pricing-slider {
    overflow: hidden;
}

.pricing-cards-wrapper {
    display: flex;
    transition: transform 0.3s ease-in-out;
}

.pricing-card-slide {
    flex: 0 0 auto;
    min-width: 0;
}

/* Show navigation buttons when there are more than visible cards */
.show-navigation #prev-btn,
.show-navigation #next-btn {
    display: block !important;
}

#prev-btn:disabled,
#next-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsive card widths - Better sizing for large screens */
@media (max-width: 768px) {
    .pricing-card-slide {
        flex: 0 0 100%;
        width: 100%;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .pricing-card-slide {
        flex: 0 0 50%;
        width: 50%;
    }
}

@media (min-width: 1025px) and (max-width: 1439px) {
    .pricing-card-slide {
        flex: 0 0 33.333%;
        width: 33.333%;
    }
}

@media (min-width: 1440px) {
    .pricing-card-slide {
        flex: 0 0 33.333%;
        width: 33.333%;
        max-width: 420px;
    }
}

/* Container max width for better large screen experience */
@media (min-width: 1440px) {
    .pricing-cards-container {
        max-width: 1400px;
        margin: 0 auto;
    }
}

/* Billing toggle styles - Improved for better visibility */
.billing-toggle-container {
    position: relative;
}

#billing-toggle:checked + label {
    background-color: #3b82f6;
}

#billing-toggle:checked + label span {
    transform: translateX(2rem);
}

#billing-toggle:focus + label {
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.3);
}

/* Active state text styling */
.yearly-active .billing-monthly {
    color: #9ca3af;
}

.yearly-active .billing-yearly {
    color: #3b82f6;
    font-weight: 600;
}

.pricing-page:not(.yearly-active) .billing-monthly {
    color: #3b82f6;
    font-weight: 600;
}

.pricing-page:not(.yearly-active) .billing-yearly {
    color: #9ca3af;
}

/* Dark mode text colors */
.dark .yearly-active .billing-monthly {
    color: #6b7280;
}

.dark .yearly-active .billing-yearly {
    color: #60a5fa;
    font-weight: 600;
}

.dark .pricing-page:not(.yearly-active) .billing-monthly {
    color: #60a5fa;
    font-weight: 600;
}

.dark .pricing-page:not(.yearly-active) .billing-yearly {
    color: #6b7280;
}

/* Price toggle functionality */
.yearly-active .monthly-price,
.yearly-active .monthly-period {
    display: none !important;
}

.yearly-active .yearly-price,
.yearly-active .yearly-period,
.yearly-active .yearly-savings {
    display: block !important;
}

/* FAQ styles matching contact page */
.faq-toggle svg {
    transition: transform 0.3s ease;
}

.faq-toggle.active svg {
    transform: rotate(180deg);
}

.faq-content {
    transition: all 0.3s ease;
}

/* Compare plans button styling */
[data-scroll-to-comparison] {
    position: relative;
    overflow: hidden;
}

[data-scroll-to-comparison]:hover {
    transform: translateY(-1px);
}

[data-scroll-to-comparison]:active {
    transform: translateY(0);
}

/* Smooth scroll indicator */
.scroll-to-comparison-indicator {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #3b82f6;
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 1000;
}

.scroll-to-comparison-indicator:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
}

/* Section spacing improvements */
.pricing-page section + section {
    position: relative;
}

.pricing-page section + section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 1px;
    background: linear-gradient(to right, transparent, #e5e7eb, transparent);
}

.dark .pricing-page section + section::before {
    background: linear-gradient(to right, transparent, #374151, transparent);
}

/* Enhanced card animations */
@keyframes cardFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.pricing-card:hover {
    animation: cardFloat 2s ease-in-out infinite;
}

.featured-card {
    animation: cardFloat 3s ease-in-out infinite;
}

/* Loading state for comparison table */
.comparison-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4rem 2rem;
    background: rgba(255, 255, 255, 0.8);
}

.comparison-loading::before {
    content: '';
    width: 40px;
    height: 40px;
    border: 3px solid #e5e7eb;
    border-top: 3px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Pricing page specific responsive improvements */
@media (max-width: 640px) {
    .pricing-page .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .pricing-card {
        margin: 0 8px;
    }
    
    .hero-gradient h1 {
        font-size: 2rem;
        line-height: 1.2;
    }
    
    .hero-gradient p {
        font-size: 1rem;
    }
    
    .pricing-comparison-wrapper {
        margin: 1rem -1rem;
        border-radius: 0;
    }
}

/* Print styles for pricing page */
@media print {
    .pricing-page {
        background: white !important;
    }
    
    .pricing-card {
        border: 1px solid #000 !important;
        margin-bottom: 2rem;
        break-inside: avoid;
    }
    
    .pricing-slider,
    .pricing-cards-wrapper {
        display: block !important;
        transform: none !important;
    }
    
    .pricing-card-slide {
        width: 100% !important;
        margin-bottom: 2rem;
    }
    
    #prev-btn,
    #next-btn,
    [data-scroll-to-comparison] {
        display: none !important;
    }
    
    .comparison-header {
        position: static !important;
    }
    
    .comparison-table thead {
        position: static !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Billing toggle functionality
    const billingToggle = document.getElementById('billing-toggle');
    const pricingPage = document.querySelector('.pricing-page');
    
    if (billingToggle) {
        billingToggle.addEventListener('change', function() {
            if (this.checked) {
                pricingPage.classList.add('yearly-active');
            } else {
                pricingPage.classList.remove('yearly-active');
            }
        });
    }
    
    // Pricing slider functionality
    const wrapper = document.getElementById('pricing-cards-wrapper');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const container = document.querySelector('.pricing-cards-container');
    
    if (wrapper && prevBtn && nextBtn) {
        const cards = wrapper.querySelectorAll('.pricing-card-slide');
        const totalCards = cards.length;
        let currentIndex = 0;
        let cardsPerView = getCardsPerView();
        
        // Determine cards per view based on screen size
        function getCardsPerView() {
            const width = window.innerWidth;
            if (width < 769) {
                return 1;
            } else if (width < 1025) {
                return 2;
            } else {
                return 3; // Always show 3 cards on desktop for better spacing
            }
        }
        
        function updateSliderVisibility() {
            cardsPerView = getCardsPerView();
            
            // Show/hide navigation based on whether slider is needed
            if (totalCards > cardsPerView) {
                container.classList.add('show-navigation');
                prevBtn.style.display = 'block';
                nextBtn.style.display = 'block';
            } else {
                container.classList.remove('show-navigation');
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
                currentIndex = 0;
                updateSliderPosition();
            }
        }
        
        // Update slider position
        function updateSliderPosition() {
            const slideWidth = 100 / cardsPerView; // Width of visible area in percentage
            const translateX = -(currentIndex * slideWidth);
            wrapper.style.transform = `translateX(${translateX}%)`;
            
            // Update button states
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= totalCards - cardsPerView;
            
            prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
            nextBtn.style.opacity = currentIndex >= totalCards - cardsPerView ? '0.5' : '1';
        }
        
        // Previous button
        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateSliderPosition();
            }
        });
        
        // Next button
        nextBtn.addEventListener('click', function() {
            if (currentIndex < totalCards - cardsPerView) {
                currentIndex++;
                updateSliderPosition();
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            updateSliderVisibility();
            // Reset position if current index is invalid
            if (currentIndex >= totalCards - cardsPerView) {
                currentIndex = Math.max(0, totalCards - cardsPerView);
            }
            updateSliderPosition();
        });
        
        // Initialize
        updateSliderVisibility();
        updateSliderPosition();
    }
    
    // FAQ toggle functionality (matching contact page style)
    const faqToggles = document.querySelectorAll('.faq-toggle');
    
    faqToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const icon = this.querySelector('svg');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
                this.classList.add('active');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
                this.classList.remove('active');
            }
        });
    });
    
    // Smooth scroll to comparison table
    const compareButton = document.querySelector('[data-scroll-to-comparison]');
    if (compareButton) {
        compareButton.addEventListener('click', function() {
            const comparisonTable = document.querySelector('.pricing-comparison-wrapper');
            if (comparisonTable) {
                comparisonTable.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Add a brief highlight effect
                comparisonTable.style.boxShadow = '0 0 0 4px rgba(59, 130, 246, 0.3)';
                setTimeout(() => {
                    comparisonTable.style.boxShadow = '';
                }, 2000);
            }
        });
    }
    
    // Add scroll indicator for comparison table
    function addScrollIndicator() {
        const comparisonSection = document.querySelector('.pricing-comparison-wrapper');
        if (comparisonSection && window.innerWidth <= 1024) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !document.querySelector('.scroll-to-comparison-indicator')) {
                        const indicator = document.createElement('div');
                        indicator.className = 'scroll-to-comparison-indicator';
                        indicator.textContent = '📊 View Full Comparison';
                        indicator.onclick = () => {
                            comparisonSection.scrollIntoView({behavior: 'smooth'});
                            indicator.remove();
                        };
                        
                        document.body.appendChild(indicator);
                        
                        // Remove after 10 seconds
                        setTimeout(() => {
                            if (indicator.parentNode) {
                                indicator.remove();
                            }
                        }, 10000);
                    }
                });
            }, { threshold: 0.1 });
            
            // Only show indicator when not viewing comparison
            const pricingCards = document.querySelector('.pricing-cards-container');
            if (pricingCards) {
                observer.observe(pricingCards);
            }
        }
    }
    
    // Initialize scroll indicator
    addScrollIndicator();
    
    // Handle pricing card interactions
    const pricingCards = document.querySelectorAll('.pricing-card');
    pricingCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            if (!this.classList.contains('featured-card')) {
                this.style.transform = 'translateY(0) scale(1)';
            } else {
                this.style.transform = 'scale(1.02)';
            }
            this.style.zIndex = '1';
        });
    });
    
    // Enhanced billing toggle with animation
    if (billingToggle) {
        billingToggle.addEventListener('change', function() {
            const label = this.nextElementSibling;
            const slider = label.querySelector('span');
            
            // Add a small bounce effect
            slider.style.transform = this.checked ? 'translateX(2rem) scale(1.1)' : 'scale(1.1)';
            
            setTimeout(() => {
                slider.style.transform = this.checked ? 'translateX(2rem)' : 'translateX(0)';
            }, 150);
        });
    }
    
    // Lazy load comparison table if not immediately visible
    const comparisonWrapper = document.querySelector('.pricing-comparison-wrapper');
    if (comparisonWrapper) {
        const loadComparison = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add any lazy loading logic here if needed
                    loadComparison.unobserve(entry.target);
                }
            });
        }, { 
            rootMargin: '100px' // Load when 100px away from viewport
        });
        
        loadComparison.observe(comparisonWrapper);
    }
});
</script>

<?php get_footer(); ?>
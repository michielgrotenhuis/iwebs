<?php
/**
 * Template Name: Pricing Page
 */

get_header();
?>

<div class="pricing-page bg-gray-50 min-h-screen">
    
    <!-- Hero Section -->
    <section class="bg-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                    Simple, Transparent Pricing
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                    Choose the perfect plan for your business. Start free, upgrade when you're ready.
                </p>
                
                <!-- Billing Toggle -->
                <div class="flex items-center justify-center mb-12">
                    <span class="text-gray-700 mr-3">Monthly</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="billing-toggle" class="sr-only">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                    <span class="text-gray-700 ml-3">Yearly</span>
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded-full ml-2">Save 20%</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Cards -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                
                <?php
                // Get pricing plans
                $pricing_query = get_pricing_plans();
                
                if ($pricing_query->have_posts()) :
                ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php while ($pricing_query->have_posts()) : $pricing_query->the_post(); 
                            // Get custom fields
                            $price = get_post_meta(get_the_ID(), '_pricing_price', true);
                            $period = get_post_meta(get_the_ID(), '_pricing_period', true);
                            $features = get_post_meta(get_the_ID(), '_pricing_features', true);
                            $featured = get_post_meta(get_the_ID(), '_pricing_featured', true);
                            $purchase_url = get_post_meta(get_the_ID(), '_pricing_purchase_url', true);
                            $button_text = get_post_meta(get_the_ID(), '_pricing_button_text', true);
                            $base_currency = get_post_meta(get_the_ID(), '_pricing_base_currency', true);
                            
                            // Set defaults
                            if (!$price) $price = '0';
                            if (!$period) $period = 'month';
                            if (!$button_text) $button_text = 'Get Started';
                            if (!$base_currency) $base_currency = 'USD';
                            if (!$purchase_url) $purchase_url = '#';
                            
                            $currency_symbol = get_currency_symbol($base_currency);
                            $yearly_price = $period === 'year' ? $price : ($price * 12 * 0.8); // 20% discount for yearly
                        ?>
                            <div class="pricing-card <?php echo $featured ? 'featured-card' : ''; ?> bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                                
                                <?php if ($featured) : ?>
                                    <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-2 text-sm font-semibold">
                                        Most Popular
                                    </div>
                                    <div class="pt-10 pb-8 px-8">
                                <?php else : ?>
                                    <div class="p-8">
                                <?php endif; ?>
                                
                                    <!-- Plan Name -->
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                        <?php the_title(); ?>
                                    </h3>
                                    
                                    <!-- Plan Description -->
                                    <p class="text-gray-600 mb-6">
                                        <?php echo get_the_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 15); ?>
                                    </p>
                                    
                                    <!-- Price -->
                                    <div class="mb-8">
                                        <div class="price-display">
                                            <span class="text-5xl font-bold text-gray-900 monthly-price">
                                                <?php echo $currency_symbol . number_format($price, 0); ?>
                                            </span>
                                            <span class="text-5xl font-bold text-gray-900 yearly-price hidden">
                                                <?php echo $currency_symbol . number_format($yearly_price / 12, 0); ?>
                                            </span>
                                            <span class="text-gray-600 text-lg ml-2">
                                                <span class="monthly-period">/month</span>
                                                <span class="yearly-period hidden">/month</span>
                                            </span>
                                        </div>
                                        <div class="yearly-savings text-green-600 text-sm font-medium mt-2 hidden">
                                            Save <?php echo $currency_symbol . number_format(($price * 12) - $yearly_price, 0); ?> per year
                                        </div>
                                    </div>
                                    
                                    <!-- CTA Button -->
                                    <a href="<?php echo esc_url($purchase_url); ?>" 
                                       class="<?php echo $featured ? 'btn-primary' : 'btn-secondary'; ?> w-full text-center py-4 px-6 rounded-lg font-semibold text-lg mb-8 block transition-all duration-200 hover:transform hover:-translate-y-1">
                                        <?php echo esc_html($button_text); ?>
                                    </a>
                                    
                                    <!-- Features List -->
                                    <?php if ($features) : ?>
                                        <ul class="space-y-4">
                                            <?php 
                                            $feature_list = explode("\n", $features);
                                            foreach ($feature_list as $feature) : 
                                                $feature = trim($feature);
                                                if ($feature) :
                                            ?>
                                                <li class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span class="text-gray-700"><?php echo esc_html($feature); ?></span>
                                                </li>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </ul>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                
                <?php else : ?>
                    <!-- Default pricing plans if none exist -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                        <!-- Starter Plan -->
                        <div class="pricing-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
                            <p class="text-gray-600 mb-6">Perfect for small businesses getting started</p>
                            
                            <div class="mb-8">
                                <span class="text-5xl font-bold text-gray-900">$19</span>
                                <span class="text-gray-600 text-lg ml-2">/month</span>
                            </div>
                            
                            <a href="#" class="btn-secondary w-full text-center py-4 px-6 rounded-lg font-semibold text-lg mb-8 block">
                                Get Started
                            </a>
                            
                            <ul class="space-y-4">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Up to 100 products
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Free SSL certificate
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    24/7 support
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Professional Plan -->
                        <div class="pricing-card featured-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-2 text-sm font-semibold">
                                Most Popular
                            </div>
                            <div class="pt-10 pb-8 px-8">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Professional</h3>
                                <p class="text-gray-600 mb-6">Best for growing businesses</p>
                                
                                <div class="mb-8">
                                    <span class="text-5xl font-bold text-gray-900">$49</span>
                                    <span class="text-gray-600 text-lg ml-2">/month</span>
                                </div>
                                
                                <a href="#" class="btn-primary w-full text-center py-4 px-6 rounded-lg font-semibold text-lg mb-8 block">
                                    Get Started
                                </a>
                                
                                <ul class="space-y-4">
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Up to 1,000 products
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Advanced analytics
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Priority support
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Enterprise Plan -->
                        <div class="pricing-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
                            <p class="text-gray-600 mb-6">For large scale operations</p>
                            
                            <div class="mb-8">
                                <span class="text-5xl font-bold text-gray-900">$99</span>
                                <span class="text-gray-600 text-lg ml-2">/month</span>
                            </div>
                            
                            <a href="#" class="btn-secondary w-full text-center py-4 px-6 rounded-lg font-semibold text-lg mb-8 block">
                                Contact Sales
                            </a>
                            
                            <ul class="space-y-4">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Unlimited products
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Custom integrations
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Dedicated support
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="bg-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">
                    Frequently Asked Questions
                </h2>
                
                <div class="space-y-8">
                    <div class="faq-item">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Can I change plans anytime?</h3>
                        <p class="text-gray-600">Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle.</p>
                    </div>
                    
                    <div class="faq-item">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Is there a free trial?</h3>
                        <p class="text-gray-600">Yes, all plans come with a 14-day free trial. No credit card required to get started.</p>
                    </div>
                    
                    <div class="faq-item">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">What payment methods do you accept?</h3>
                        <p class="text-gray-600">We accept all major credit cards, PayPal, and bank transfers for enterprise customers.</p>
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
/* Pricing page specific styles */
.featured-card {
    transform: scale(1.05);
    border: 2px solid #667eea;
}

.pricing-card:hover {
    transform: translateY(-4px);
}

.featured-card:hover {
    transform: scale(1.05) translateY(-4px);
}

/* Billing toggle styles */
#billing-toggle:checked + div {
    background-color: #667eea;
}

/* Price toggle functionality */
.yearly-active .monthly-price,
.yearly-active .monthly-period {
    display: none;
}

.yearly-active .yearly-price,
.yearly-active .yearly-period,
.yearly-active .yearly-savings {
    display: block !important;
}
</style>

<script>
// Billing toggle functionality
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>

<?php
get_footer();
?>
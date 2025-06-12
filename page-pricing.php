<?php
/**
 * Template Name: Pricing Page
 */

get_header();
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
                <div class="flex items-center justify-center mb-12">
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
                                ),
                                array(
                                    'name' => 'Custom',
                                    'description' => 'Tailored solutions for unique needs',
                                    'price' => 299,
                                    'featured' => false,
                                    'button_text' => 'Contact Us',
                                    'features' => array(
                                        'Everything in Enterprise',
                                        'Custom development',
                                        'Dedicated account manager',
                                        'Custom training',
                                        'Priority feature requests',
                                        'Custom SLA',
                                        'On-site support'
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
                            <?php endforeach; ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20">
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
/* Pricing page specific styles */
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
});
</script>

<?php get_footer(); ?>
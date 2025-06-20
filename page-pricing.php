<?php
/**
 * Template Name: Pricing Page with Enhanced Comparison
 * Updated page-pricing.php with improved comparison table
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
                
                <!-- Billing Toggle - Annual Default -->
                <div class="flex items-center justify-center mb-8">
                    <span class="text-gray-700 dark:text-gray-300 mr-4 font-medium billing-monthly">Monthly</span>
                    <div class="relative">
                        <input type="checkbox" id="billing-toggle" class="sr-only peer" checked>
                        <label for="billing-toggle" class="relative inline-flex items-center justify-between w-16 h-8 bg-gray-200 dark:bg-gray-700 rounded-full cursor-pointer transition-colors duration-300 peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800">
                            <span class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 peer-checked:translate-x-8"></span>
                        </label>
                    </div>
                    <span class="text-gray-700 dark:text-gray-300 ml-4 font-medium billing-yearly">Annual</span>
                    <span class="bg-emerald-500 text-emerald-50 dark:text-white text-sm font-semibold px-3 py-1 rounded-full ml-3 shadow-md">Save 20%</span>
                </div>
                
                <!-- Scroll to Comparison Button -->
                <div class="mb-4">
                    <button class="btn-secondary hover:bg-gray-100 dark:hover:bg-gray-700" data-scroll-to-comparison onclick="document.querySelector('.pricing-comparison-wrapper').scrollIntoView({behavior: 'smooth'})">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            Compare All Features
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <!-- Pricing cards code remains the same -->
            <?php echo do_shortcode('[pricing_cards limit="4" show_features="true"]'); ?>
        </div>
    </section>

    <!-- Enhanced Plans Comparison Section -->
    <section class="py-20 bg-white dark:bg-gray-800" id="plans-comparison">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
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
                    <?php
                    $faqs = array(
                        array(
                            'question' => 'Can I change plans anytime?',
                            'answer' => 'Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle, and we\'ll prorate any differences.'
                        ),
                        array(
                            'question' => 'Is there a free trial?',
                            'answer' => 'Yes, all paid plans come with a 14-day free trial. No credit card required to get started. You can also use our Starter plan free forever with basic features.'
                        ),
                        array(
                            'question' => 'What payment methods do you accept?',
                            'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers for enterprise customers. We also support multiple currencies.'
                        ),
                        array(
                            'question' => 'Do you offer refunds?',
                            'answer' => 'Yes, we offer a 30-day money-back guarantee. If you\'re not satisfied with our service, contact us within 30 days for a full refund.'
                        ),
                        array(
                            'question' => 'Can I cancel anytime?',
                            'answer' => 'Absolutely! You can cancel your subscription at any time. Your account will remain active until the end of your current billing period, and you\'ll retain access to export your data.'
                        )
                    );
                    
                    foreach ($faqs as $faq) : ?>
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <button class="flex justify-between items-center w-full text-left faq-toggle">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white"><?php echo esc_html($faq['question']); ?></h3>
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="faq-content hidden mt-4">
                                <p class="text-gray-600 dark:text-gray-300"><?php echo esc_html($faq['answer']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-6">Ready to grow your business?</h2>
                <p class="text-xl text-blue-100 mb-8">Join thousands of successful merchants using Storeicu</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#" class="btn-primary bg-white text-blue-600 hover:bg-gray-100 text-lg px-8 py-4 inline-block">
                        Start Your Free Trial
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-secondary border-white text-white hover:bg-white hover:text-blue-600 text-lg px-8 py-4 inline-block">
                        Talk to Sales
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Enhanced Styles for Pricing Page -->
<style>
/* Annual billing default styles */
.pricing-page.yearly-active .billing-yearly,
.pricing-comparison-wrapper.comparison-yearly-active .comparison-yearly-label {
    color: #3b82f6;
    font-weight: 600;
}

.pricing-page.yearly-active .billing-monthly,
.pricing-comparison-wrapper.comparison-yearly-active .comparison-monthly-label {
    color: #9ca3af;
}

.pricing-page:not(.yearly-active) .billing-monthly,
.pricing-comparison-wrapper:not(.comparison-yearly-active) .comparison-monthly-label {
    color: #3b82f6;
    font-weight: 600;
}

.pricing-page:not(.yearly-active) .billing-yearly,
.pricing-comparison-wrapper:not(.comparison-yearly-active) .comparison-yearly-label {
    color: #9ca3af;
}

/* Price display toggles */
.yearly-active .monthly-price,
.yearly-active .monthly-period {
    display: none !important;
}

.yearly-active .yearly-price,
.yearly-active .yearly-period,
.yearly-active .yearly-savings {
    display: block !important;
}

/* Dark mode adjustments */
.dark .pricing-page.yearly-active .billing-yearly,
.dark .pricing-comparison-wrapper.comparison-yearly-active .comparison-yearly-label {
    color: #60a5fa;
}

.dark .pricing-page.yearly-active .billing-monthly,
.dark .pricing-comparison-wrapper.comparison-yearly-active .comparison-monthly-label {
    color: #6b7280;
}

/* Smooth scroll indicator */
[data-scroll-to-comparison] {
    position: relative;
    overflow: hidden;
}

[data-scroll-to-comparison]:hover {
    transform: translateY(-1px);
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
</style>

<!-- Enhanced JavaScript for Pricing Page -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize with annual billing as default
    const pricingPage = document.querySelector('.pricing-page');
    const billingToggle = document.getElementById('billing-toggle');
    
    // Set initial state to annual
    if (pricingPage && billingToggle) {
        pricingPage.classList.add('yearly-active');
        billingToggle.checked = true;
    }
    
    // Billing toggle functionality
    if (billingToggle) {
        billingToggle.addEventListener('change', function() {
            if (this.checked) {
                pricingPage.classList.add('yearly-active');
            } else {
                pricingPage.classList.remove('yearly-active');
            }
        });
    }
    
    // FAQ toggle functionality
    const faqToggles = document.querySelectorAll('.faq-toggle');
    
    faqToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const icon = this.querySelector('svg');
            
            // Close other FAQs
            faqToggles.forEach(otherToggle => {
                if (otherToggle !== this) {
                    const otherContent = otherToggle.nextElementSibling;
                    const otherIcon = otherToggle.querySelector('svg');
                    otherContent.classList.add('hidden');
                    otherIcon.classList.remove('rotate-180');
                    otherToggle.classList.remove('active');
                }
            });
            
            // Toggle current FAQ
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
    
    // Smooth scroll enhancement
    const scrollButtons = document.querySelectorAll('[data-scroll-to-comparison]');
    scrollButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector('.pricing-comparison-wrapper');
            if (target) {
                const offset = 100; // Offset for fixed header
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Add highlight effect
                target.style.boxShadow = '0 0 0 4px rgba(59, 130, 246, 0.3)';
                setTimeout(() => {
                    target.style.boxShadow = '';
                }, 2000);
            }
        });
    });
    
    // Add scroll progress indicator
    let scrollIndicator = null;
    function checkScrollPosition() {
        const comparisonSection = document.querySelector('.pricing-comparison-wrapper');
        if (!comparisonSection) return;
        
        const rect = comparisonSection.getBoundingClientRect();
        const isNearComparison = rect.top < window.innerHeight && rect.bottom > 0;
        
        if (isNearComparison && !scrollIndicator) {
            // Remove any existing indicator
            const existing = document.querySelector('.comparison-scroll-hint');
            if (existing) existing.remove();
        }
    }
    
    // Check scroll position on scroll
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(checkScrollPosition, 100);
    });
    
    // Initial check
    checkScrollPosition();
});
</script>

<?php get_footer(); ?>
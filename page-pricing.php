<?php
/**
 * Template Name: Pricing Page - Complete Version
 * Uses Customizer for content and WP-Admin for pricing plans
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
$yearly_text = get_theme_mod('pricing_billing_yearly_text', 'Yearly');
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
                
                <!-- Billing Toggle - Annual Default -->
                <div class="flex items-center justify-center mb-8">
                    <span class="text-gray-700 dark:text-gray-300 mr-4 font-medium billing-monthly"><?php echo esc_html($monthly_text); ?></span>
                    <div class="relative">
                        <input type="checkbox" id="billing-toggle" class="sr-only peer" checked>
                        <label for="billing-toggle" class="relative inline-flex items-center justify-between w-16 h-8 bg-gray-200 dark:bg-gray-700 rounded-full cursor-pointer transition-colors duration-300 peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800">
                            <span class="toggle-switch absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300"></span>
                        </label>
                    </div>
                    <span class="text-gray-700 dark:text-gray-300 ml-4 font-medium billing-yearly"><?php echo esc_html($yearly_text); ?></span>
                    <span class="bg-emerald-500 text-emerald-50 dark:text-white text-sm font-semibold px-3 py-1 rounded-full ml-3 shadow-md"><?php echo esc_html($save_text); ?></span>
                </div>
                
                <?php if ($comparison_enable) : ?>
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
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Pricing Cards Section -->
    <section class="py-20" id="pricing-cards">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                
                <!-- Dynamic Pricing Cards from WP-Admin -->
                <?php
                $args = array(
                    'post_type' => 'pricing',
                    'posts_per_page' => 4,
                    'post_status' => 'publish',
                    'meta_key' => '_pricing_monthly_price',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC'
                );
                
                $plans = get_posts($args);
                
                if (!empty($plans)) : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo count($plans) <= 3 ? count($plans) : '4'; ?> gap-8">
                        <?php foreach ($plans as $plan) : 
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
                            
                            if (!function_exists('yoursite_get_currency_symbol')) {
                                function yoursite_get_currency_symbol($currency = 'USD') {
                                    $symbols = array('USD' => '$', 'EUR' => '€', 'GBP' => '£', 'CAD' => 'C$', 'AUD' => 'A$');
                                    return isset($symbols[$currency]) ? $symbols[$currency] : '$';
                                }
                            }
                            $currency_symbol = yoursite_get_currency_symbol($meta['pricing_currency']);
                            ?>
                            <div class="pricing-card <?php echo $is_featured ? 'featured-card' : ''; ?> bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden border border-gray-200 dark:border-gray-700">
                                
                                <?php if ($is_featured) : ?>
                                    <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-2 text-sm font-semibold">
                                        <?php _e('Most Popular', 'yoursite'); ?>
                                    </div>
                                    <div class="pt-10 pb-8 px-8">
                                <?php else : ?>
                                    <div class="p-8">
                                <?php endif; ?>
                                
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                        <?php echo esc_html($plan->post_title); ?>
                                    </h3>
                                    
                                    <?php if ($plan->post_excerpt) : ?>
                                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                                            <?php echo esc_html($plan->post_excerpt); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <div class="mb-8 price-container">
                                        <!-- Monthly Pricing (Hidden by Default) -->
                                        <div class="monthly-price hidden">
                                            <span class="text-5xl font-bold text-gray-900 dark:text-white">
                                                <?php echo $currency_symbol . number_format($monthly_price, 0); ?>
                                            </span>
                                            <span class="text-gray-600 dark:text-gray-400 text-lg ml-2">
                                                /<?php _e('month', 'yoursite'); ?>
                                            </span>
                                        </div>
                                        
                                        <!-- Annual Pricing (Shown by Default) -->
                                        <div class="yearly-price">
                                            <span class="text-5xl font-bold text-gray-900 dark:text-white">
                                                <?php echo $currency_symbol . number_format($annual_monthly, 0); ?>
                                            </span>
                                            <span class="text-gray-600 dark:text-gray-400 text-lg ml-2">
                                                /<?php _e('month', 'yoursite'); ?>
                                            </span>
                                            <?php if ($annual_price > 0) : ?>
                                                <div class="text-sm text-green-600 dark:text-green-400 mt-1">
                                                    <?php printf(__('Billed annually (%s)', 'yoursite'), $currency_symbol . number_format($annual_price, 0)); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>" 
                                       class="<?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?> w-full text-center py-4 px-6 rounded-lg font-semibold text-lg mb-8 block transition-all duration-200 hover:transform hover:-translate-y-1">
                                        <?php echo esc_html($meta['pricing_button_text'] ?: __('Get Started', 'yoursite')); ?>
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
                        <?php endforeach; ?>
                    </div>
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
                <div class="text-center mb-8">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo esc_html($comparison_title); ?>
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300">
                        <?php echo esc_html($comparison_subtitle); ?>
                    </p>
                </div>
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
                    <?php for ($i = 1; $i <= 5; $i++) : 
                        $faq_enabled = get_theme_mod("pricing_faq_{$i}_enable", true);
                        if (!$faq_enabled) continue;
                        
                        $question = get_theme_mod("pricing_faq_{$i}_question", '');
                        $answer = get_theme_mod("pricing_faq_{$i}_answer", '');
                        
                        if (empty($question) || empty($answer)) continue;
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
                    <?php endfor; ?>
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

<!-- Enhanced Styles for Pricing Page -->
<style>
/* Toggle Switch Animation */
.toggle-switch {
    transition: transform 0.3s ease;
}

#billing-toggle:checked + label .toggle-switch {
    transform: translateX(32px);
}

/* Pricing Toggle States */
.pricing-page.yearly-active .billing-yearly {
    color: #3b82f6 !important;
    font-weight: 600 !important;
}

.pricing-page.yearly-active .billing-monthly {
    color: #9ca3af !important;
    font-weight: 400 !important;
}

.pricing-page:not(.yearly-active) .billing-monthly {
    color: #3b82f6 !important;
    font-weight: 600 !important;
}

.pricing-page:not(.yearly-active) .billing-yearly {
    color: #9ca3af !important;
    font-weight: 400 !important;
}

/* Price Display Toggle */
.pricing-page.yearly-active .monthly-price {
    display: none !important;
}

.pricing-page.yearly-active .yearly-price {
    display: block !important;
}

.pricing-page:not(.yearly-active) .monthly-price {
    display: block !important;
}

.pricing-page:not(.yearly-active) .yearly-price {
    display: none !important;
}

/* Dark mode adjustments */
.dark .pricing-page.yearly-active .billing-yearly {
    color: #60a5fa !important;
}

.dark .pricing-page.yearly-active .billing-monthly {
    color: #6b7280 !important;
}

.dark .pricing-page:not(.yearly-active) .billing-monthly {
    color: #60a5fa !important;
}

.dark .pricing-page:not(.yearly-active) .billing-yearly {
    color: #6b7280 !important;
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

/* Enhanced pricing card animations */
.pricing-card {
    transition: all 0.3s ease;
}

.pricing-card:hover {
    transform: translateY(-4px);
}

.featured-card {
    transform: scale(1.05);
    border: 2px solid #3b82f6;
}

.featured-card:hover {
    transform: scale(1.05) translateY(-4px);
}

/* Responsive improvements */
@media (max-width: 768px) {
    .pricing-card {
        margin-bottom: 2rem;
    }
    
    .featured-card {
        transform: none;
        border: 2px solid #3b82f6;
    }
    
    .featured-card:hover {
        transform: translateY(-2px);
    }
}
</style>

<!-- Enhanced JavaScript for Pricing Page -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize pricing page
    const pricingPage = document.querySelector('.pricing-page');
    const billingToggle = document.getElementById('billing-toggle');
    const comparisonToggle = document.getElementById('comparison-billing-toggle');
    
    // Set initial state to annual (yearly)
    if (pricingPage) {
        pricingPage.classList.add('yearly-active');
    }
    
    if (billingToggle) {
        billingToggle.checked = true;
    }
    
    // Main billing toggle functionality
    if (billingToggle) {
        billingToggle.addEventListener('change', function() {
            const isYearly = this.checked;
            
            if (isYearly) {
                pricingPage.classList.add('yearly-active');
                pricingPage.classList.remove('monthly-active');
            } else {
                pricingPage.classList.remove('yearly-active');
                pricingPage.classList.add('monthly-active');
            }
            
            // Sync with comparison toggle
            if (comparisonToggle && comparisonToggle !== this) {
                comparisonToggle.checked = isYearly;
                const event = new Event('change', { bubbles: true });
                comparisonToggle.dispatchEvent(event);
            }
            
            // Add smooth transition animation
            const priceContainers = document.querySelectorAll('.price-container');
            priceContainers.forEach(container => {
                container.style.opacity = '0.5';
                setTimeout(() => {
                    container.style.opacity = '1';
                }, 150);
            });
        });
    }
    
    // Listen for changes from comparison toggle
    if (comparisonToggle && billingToggle) {
        comparisonToggle.addEventListener('change', function() {
            if (this !== document.activeElement) return; // Prevent loop
            
            const isYearly = this.checked;
            billingToggle.checked = isYearly;
            
            const event = new Event('change', { bubbles: true });
            billingToggle.dispatchEvent(event);
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
                    otherIcon.style.transform = 'rotate(0deg)';
                    otherToggle.classList.remove('active');
                }
            });
            
            // Toggle current FAQ
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
                this.classList.add('active');
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
                this.classList.remove('active');
            }
        });
    });
    
    // Smooth scroll enhancement with offset for sticky header
    const scrollButtons = document.querySelectorAll('[data-scroll-to-comparison]');
    scrollButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector('.pricing-comparison-wrapper');
            if (target) {
                const offset = 20; // Offset for better positioning
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
    
    // Enhanced pricing card hover effects
    const pricingCards = document.querySelectorAll('.pricing-card');
    pricingCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            if (!this.classList.contains('featured-card')) {
                this.style.borderColor = '#3b82f6';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            if (!this.classList.contains('featured-card')) {
                this.style.borderColor = '#e5e7eb';
            }
        });
    });
    
    // Intersection Observer for pricing cards animation
    const observeCards = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });
    
    pricingCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observeCards.observe(card);
    });
});
</script>

<?php get_footer(); ?>
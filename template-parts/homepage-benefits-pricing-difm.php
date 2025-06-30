<?php
/**
 * Template part for homepage - Benefits, Pricing & DIFM sections
 * Enhanced with Dynamic Currency Support
 */

// Get current user currency
$current_currency = yoursite_get_user_currency();
?>

<!-- Key Benefits - Feature Rich -->
<?php if (get_theme_mod('benefits_enable', true)) : ?>
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('benefits_title', __('Everything You Need to Succeed Online', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    <?php echo esc_html(get_theme_mod('benefits_subtitle', __('From beautiful storefronts to powerful analytics, we\'ve got you covered', 'yoursite'))); ?>
                </p>
            </div>
            
            <!-- Benefits Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                for ($i = 1; $i <= 6; $i++) {
                    $title = get_theme_mod("benefit_{$i}_title", '');
                    $description = get_theme_mod("benefit_{$i}_description", '');
                    $color = get_theme_mod("benefit_{$i}_color", 'blue');
                    $icon = get_theme_mod("benefit_{$i}_icon", '');
                    
                    // Default icons if none specified
                    $default_icons = array(
                        1 => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                        2 => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                        3 => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                        4 => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        5 => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100-4m0 4v2m0-6V4',
                        6 => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'
                    );
                    
                    if (empty($icon) && isset($default_icons[$i])) {
                        $icon = $default_icons[$i];
                    }
                    
                    // Skip if no title
                    if (empty($title)) continue;
                ?>
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-gray-200 dark:border-gray-700">
                    <div class="w-14 h-14 bg-<?php echo esc_attr($color); ?>-100 dark:bg-<?php echo esc_attr($color); ?>-900/50 rounded-xl mx-auto mb-6 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <?php if (!empty($icon)) : ?>
                        <svg class="w-7 h-7 text-<?php echo esc_attr($color); ?>-600 dark:text-<?php echo esc_attr($color); ?>-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($icon); ?>"></path>
                        </svg>
                        <?php else : ?>
                        <!-- Fallback icon -->
                        <div class="w-7 h-7 bg-<?php echo esc_attr($color); ?>-600 dark:bg-<?php echo esc_attr($color); ?>-400 rounded"></div>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white text-center">
                        <?php echo esc_html($title); ?>
                    </h3>
                    <?php if (!empty($description)) : ?>
                    <p class="text-gray-600 dark:text-gray-300 text-center leading-relaxed">
                        <?php echo esc_html($description); ?>
                    </p>
                    <?php endif; ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Pricing Section - Enhanced with Dynamic Currency -->
<?php if (get_theme_mod('pricing_enable', true)) : ?>
<section class="py-20 bg-white dark:bg-gray-800" id="pricing-section">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header with Currency Selector -->
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('pricing_title', __('Simple, Transparent Pricing', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8">
                    <?php echo esc_html(get_theme_mod('pricing_subtitle', __('Start free, then choose the plan that scales with your business', 'yoursite'))); ?>
                </p>
                
                <!-- Currency Selector -->
                <?php if (function_exists('yoursite_should_display_currency_selector') && yoursite_should_display_currency_selector()) : ?>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6 mb-8">
                    <div class="flex items-center gap-3">
                        <span class="text-gray-600 dark:text-gray-400 font-medium">
                            <?php _e('Currency:', 'yoursite'); ?>
                        </span>
                        <?php 
                        echo yoursite_render_currency_selector(array(
                            'style' => 'dropdown',
                            'show_flag' => true,
                            'show_name' => false,
                            'show_symbol' => true,
                            'class' => 'pricing-currency-selector'
                        )); 
                        ?>
                    </div>
                    
                    <!-- Billing Toggle -->
                    <div class="inline-flex items-center bg-gray-100 dark:bg-gray-700 rounded-xl p-1">
                        <button class="billing-btn monthly-btn px-6 py-2 rounded-lg font-medium transition-all duration-200 text-gray-700 dark:text-gray-300">
                            Monthly
                        </button>
                        <button class="billing-btn annual-btn px-6 py-2 rounded-lg font-medium transition-all duration-200 bg-blue-600 text-white shadow-md">
                            Annual
                            <span class="ml-2 px-2 py-1 bg-green-500 text-xs font-bold rounded-full">Save 20%</span>
                        </button>
                    </div>
                </div>
                <?php else : ?>
                <!-- Just Billing Toggle if no currency selector -->
                <div class="inline-flex items-center bg-gray-100 dark:bg-gray-700 rounded-xl p-1 mb-8">
                    <button class="billing-btn monthly-btn px-6 py-2 rounded-lg font-medium transition-all duration-200 text-gray-700 dark:text-gray-300">
                        Monthly
                    </button>
                    <button class="billing-btn annual-btn px-6 py-2 rounded-lg font-medium transition-all duration-200 bg-blue-600 text-white shadow-md">
                        Annual
                        <span class="ml-2 px-2 py-1 bg-green-500 text-xs font-bold rounded-full">Save 20%</span>
                    </button>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Pricing Cards -->
            <?php
            // Get pricing plans
            $pricing_count = get_theme_mod('homepage_pricing_count', 3);
            $pricing_args = array(
                'post_type' => 'pricing',
                'posts_per_page' => $pricing_count,
                'post_status' => 'publish',
                'meta_key' => '_pricing_monthly_price',
                'orderby' => 'meta_value_num',
                'order' => 'ASC'
            );

            $pricing_plans = get_posts($pricing_args);

            if (!empty($pricing_plans)) :
                // Helper functions
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
            ?>
            
            <div class="grid md:grid-cols-<?php echo min(count($pricing_plans), 3); ?> gap-8 max-w-5xl mx-auto" id="pricing-cards-container">
                <?php foreach ($pricing_plans as $index => $plan) : 
                    $meta = yoursite_get_pricing_meta_fields($plan->ID);
                    $is_featured = $meta['pricing_featured'] === '1';
                    $features = $meta['pricing_features'];
                    $button_text = $meta['pricing_button_text'];
                    $button_url = $meta['pricing_button_url'];
                    
                    // Get pricing in current currency
                    $monthly_price = function_exists('yoursite_get_pricing_plan_price') 
                        ? yoursite_get_pricing_plan_price($plan->ID, $current_currency['code'], 'monthly')
                        : floatval($meta['pricing_monthly_price']);
                    
                    $annual_price = function_exists('yoursite_get_pricing_plan_price') 
                        ? yoursite_get_pricing_plan_price($plan->ID, $current_currency['code'], 'annual')
                        : floatval($meta['pricing_annual_price']);
                    
                    if ($annual_price == 0 && $monthly_price > 0) {
                        $annual_price = $monthly_price * 12 * 0.8;
                    }
                    $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
                    
                    // Calculate savings
                    $savings = function_exists('yoursite_calculate_annual_savings') 
                        ? yoursite_calculate_annual_savings($plan->ID, $current_currency['code'])
                        : ($monthly_price * 12) - $annual_price;
                ?>
                
                <div class="pricing-card relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 <?php echo $is_featured ? 'scale-105 border-blue-500 dark:border-blue-400' : 'hover:-translate-y-2'; ?>"
                     data-plan-id="<?php echo esc_attr($plan->ID); ?>">
                    
                    <?php if ($is_featured) : ?>
                    <!-- Featured Badge -->
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                            Most Popular
                        </span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="p-8 <?php echo $is_featured ? 'pt-12' : ''; ?>">
                        <!-- Plan Header -->
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                <?php echo esc_html($plan->post_title); ?>
                            </h3>
                            
                            <?php if ($plan->post_excerpt) : ?>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                <?php echo esc_html($plan->post_excerpt); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Pricing Display -->
                        <div class="text-center mb-8">
                            <!-- Monthly Price -->
                            <div class="monthly-pricing pricing-display active">
                                <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                    <span class="price-amount" data-price-type="monthly">
                                        <?php 
                                        if (function_exists('yoursite_format_currency')) {
                                            echo yoursite_format_currency($monthly_price, $current_currency['code']);
                                        } else {
                                            echo $current_currency['symbol'] . number_format($monthly_price, 0);
                                        }
                                        ?>
                                    </span>
                                    <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                                </div>
                                <?php if ($monthly_price > 0) : ?>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                    Billed monthly
                                </p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Annual Price -->
                            <div class="annual-pricing pricing-display" style="display: none;">
                                <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                    <span class="price-amount" data-price-type="annual-monthly">
                                        <?php 
                                        if (function_exists('yoursite_format_currency')) {
                                            echo yoursite_format_currency($annual_monthly, $current_currency['code']);
                                        } else {
                                            echo $current_currency['symbol'] . number_format($annual_monthly, 0);
                                        }
                                        ?>
                                    </span>
                                    <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                                </div>
                                <?php if ($annual_price > 0) : ?>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                    Billed annually (<span data-price-type="annual">
                                        <?php 
                                        if (function_exists('yoursite_format_currency')) {
                                            echo yoursite_format_currency($annual_price, $current_currency['code']);
                                        } else {
                                            echo $current_currency['symbol'] . number_format($annual_price, 0);
                                        }
                                        ?>
                                    </span>)
                                </p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Save <span data-savings-amount class="ml-1">
                                            <?php 
                                            if (function_exists('yoursite_format_currency')) {
                                                echo yoursite_format_currency($savings, $current_currency['code']);
                                            } else {
                                                echo $current_currency['symbol'] . number_format($savings, 0);
                                            }
                                            ?>
                                        </span>/year
                                    </span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Features -->
                        <?php if (!empty($features)) : ?>
                        <div class="mb-8">
                            <ul class="space-y-4">
                                <?php 
                                $features_array = array_filter(explode("\n", $features));
                                $max_features = 6;
                                $display_features = array_slice($features_array, 0, $max_features);
                                
                                foreach ($display_features as $feature) :
                                    $feature = trim($feature);
                                    if (!empty($feature)) :
                                ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300"><?php echo esc_html($feature); ?></span>
                                </li>
                                <?php endif; endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        
                        <!-- CTA Button -->
                        <div class="text-center">
                            <a href="<?php echo esc_url($button_url ?: '#signup'); ?>" 
                               class="pricing-button block w-full py-4 px-6 rounded-xl font-bold text-lg transition-all duration-200 <?php echo $is_featured ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:from-blue-600 hover:to-purple-700 shadow-lg hover:shadow-xl' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600'; ?>"
                               data-monthly-url="<?php echo esc_url($button_url ?: '#signup'); ?>"
                               data-annual-url="<?php echo esc_url(str_replace('monthly', 'annual', $button_url ?: '#signup')); ?>">
                                <?php echo esc_html($button_text ?: __('Get Started', 'yoursite')); ?>
                            </a>
                            
                            <?php if ($index === 0) : ?>
                            <p class="text-gray-500 dark:text-gray-400 text-xs mt-3">
                                No credit card required
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php else : ?>
            <!-- Fallback Pricing if no pricing posts exist -->
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto" id="pricing-cards-container">
                <!-- Free Plan -->
                <div class="pricing-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-200 dark:border-gray-700" data-plan-id="free">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Free</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Perfect for getting started</p>
                    </div>
                    <div class="text-center mb-8">
                        <div class="monthly-pricing pricing-display active">
                            <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                <span class="price-amount"><?php echo $current_currency['symbol']; ?>0</span>
                                <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                            </div>
                        </div>
                        <div class="annual-pricing pricing-display" style="display: none;">
                            <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                <span class="price-amount"><?php echo $current_currency['symbol']; ?>0</span>
                                <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                            </div>
                        </div>
                    </div>
                    <a href="#signup" class="pricing-button block w-full py-4 px-6 rounded-xl font-bold text-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 text-center transition-all duration-200">
                        Start Free
                    </a>
                </div>
                
                <!-- Pro Plan -->
                <div class="pricing-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border-2 border-blue-500 dark:border-blue-400 scale-105 relative" data-plan-id="pro">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                            Most Popular
                        </span>
                    </div>
                    <div class="text-center mb-8 pt-4">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Pro</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">For growing businesses</p>
                    </div>
                    <div class="text-center mb-8">
                        <div class="monthly-pricing pricing-display active">
                            <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                <span class="price-amount"><?php echo $current_currency['symbol']; ?>29</span>
                                <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                            </div>
                        </div>
                        <div class="annual-pricing pricing-display" style="display: none;">
                            <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                <span class="price-amount"><?php echo $current_currency['symbol']; ?>23</span>
                                <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                Billed annually (<?php echo $current_currency['symbol']; ?>276)
                            </p>
                        </div>
                    </div>
                    <a href="#signup" class="pricing-button block w-full py-4 px-6 rounded-xl font-bold text-lg bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:from-blue-600 hover:to-purple-700 text-center transition-all duration-200 shadow-lg hover:shadow-xl">
                        Start Free Trial
                    </a>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="pricing-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-200 dark:border-gray-700" data-plan-id="enterprise">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Enterprise</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">For large organizations</p>
                    </div>
                    <div class="text-center mb-8">
                        <div class="monthly-pricing pricing-display active">
                            <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                <span class="price-amount"><?php echo $current_currency['symbol']; ?>99</span>
                                <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                            </div>
                        </div>
                        <div class="annual-pricing pricing-display" style="display: none;">
                            <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                <span class="price-amount"><?php echo $current_currency['symbol']; ?>79</span>
                                <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                Billed annually (<?php echo $current_currency['symbol']; ?>948)
                            </p>
                        </div>
                    </div>
                    <a href="#contact" class="pricing-button block w-full py-4 px-6 rounded-xl font-bold text-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 text-center transition-all duration-200">
                        Contact Sales
                    </a>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Bottom CTA -->
            <div class="text-center mt-12">
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    <?php echo esc_html(get_theme_mod('pricing_cta_text', __('All plans include 14-day free trial • No setup fees • Cancel anytime', 'yoursite'))); ?>
                </p>
                <a href="<?php echo home_url('/pricing'); ?>" class="text-blue-600 dark:text-blue-400 font-medium hover:underline">
                    <?php echo esc_html(get_theme_mod('pricing_link_text', __('Compare all features →', 'yoursite'))); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced JavaScript for Dynamic Currency and Billing -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Billing toggle functionality
    const billingButtons = document.querySelectorAll('.billing-btn');
    const pricingCards = document.querySelectorAll('.pricing-card');
    
    billingButtons.forEach(button => {
        button.addEventListener('click', function() {
            const isAnnual = this.classList.contains('annual-btn');
            
            // Update button states
            billingButtons.forEach(btn => {
                if (btn.classList.contains('annual-btn') === isAnnual) {
                    btn.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                    btn.classList.remove('text-gray-700', 'dark:text-gray-300');
                } else {
                    btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                    btn.classList.add('text-gray-700', 'dark:text-gray-300');
                }
            });
            
            // Switch pricing displays
            switchBillingDisplay(isAnnual);
        });
    });
    
    function switchBillingDisplay(isAnnual) {
        pricingCards.forEach(card => {
            const monthlyDisplay = card.querySelector('.monthly-pricing');
            const annualDisplay = card.querySelector('.annual-pricing');
            const pricingButton = card.querySelector('.pricing-button');
            
            if (monthlyDisplay && annualDisplay) {
                if (isAnnual) {
                    monthlyDisplay.style.display = 'none';
                    monthlyDisplay.classList.remove('active');
                    annualDisplay.style.display = 'block';
                    annualDisplay.classList.add('active');
                } else {
                    monthlyDisplay.style.display = 'block';
                    monthlyDisplay.classList.add('active');
                    annualDisplay.style.display = 'none';
                    annualDisplay.classList.remove('active');
                }
            }
            
            // Update button URL if available
            if (pricingButton) {
                const newUrl = isAnnual ? 
                    pricingButton.dataset.annualUrl : 
                    pricingButton.dataset.monthlyUrl;
                
                if (newUrl) {
                    pricingButton.href = newUrl;
                }
            }
        });
    }
    
    // Currency change functionality
    document.addEventListener('currencyChanged', function(e) {
        updateAllPricing(e.detail.currency);
    });
    
    // Listen for currency selector changes
    document.addEventListener('click', function(e) {
        const currencyItem = e.target.closest('[data-currency-code], [data-currency]');
        if (!currencyItem) return;
        
        const newCurrency = currencyItem.dataset.currency || currencyItem.dataset.currencyCode;
        if (newCurrency) {
            updateAllPricing(newCurrency);
        }
    });
    
    function updateAllPricing(currencyCode) {
        // Show loading state
        const pricingSection = document.getElementById('pricing-section');
        if (pricingSection) {
            pricingSection.classList.add('pricing-updating');
            pricingSection.style.opacity = '0.7';
            pricingSection.style.pointerEvents = 'none';
        }
        
        // Get all plan IDs
        const planCards = document.querySelectorAll('[data-plan-id]');
        const planIds = Array.from(planCards).map(card => card.dataset.planId).filter(id => id && id !== 'free' && id !== 'pro' && id !== 'enterprise');
        
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
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.pricing) {
                    updatePricingCards(data.data.pricing, data.data.currency_info);
                } else {
                    console.error('Failed to update pricing:', data.data);
                    // Fallback: update currency symbols only
                    updateCurrencySymbolsOnly(currencyCode);
                }
            })
            .catch(error => {
                console.error('Error updating pricing:', error);
                // Fallback: update currency symbols only
                updateCurrencySymbolsOnly(currencyCode);
            })
            .finally(() => {
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
            if (pricingSection) {
                pricingSection.classList.remove('pricing-updating');
                pricingSection.style.opacity = '';
                pricingSection.style.pointerEvents = '';
            }
        }
    }
    
    function updatePricingCards(pricingData, currencyInfo) {
        Object.keys(pricingData).forEach(planId => {
            const pricing = pricingData[planId];
            const card = document.querySelector(`[data-plan-id="${planId}"]`);
            
            if (!card) return;
            
            try {
                // Update monthly price
                const monthlyAmount = card.querySelector('[data-price-type="monthly"]');
                if (monthlyAmount && pricing.monthly_price_formatted) {
                    monthlyAmount.textContent = pricing.monthly_price_formatted.replace(/[^\d.,€£$¥]/g, '');
                }
                
                // Update annual monthly equivalent
                const annualMonthlyAmount = card.querySelector('[data-price-type="annual-monthly"]');
                if (annualMonthlyAmount && pricing.annual_monthly_equivalent_formatted) {
                    annualMonthlyAmount.textContent = pricing.annual_monthly_equivalent_formatted.replace(/[^\d.,€£$¥]/g, '');
                }
                
                // Update annual total
                const annualAmount = card.querySelector('[data-price-type="annual"]');
                if (annualAmount && pricing.annual_price_formatted) {
                    annualAmount.textContent = pricing.annual_price_formatted;
                }
                
                // Update savings
                const savingsAmount = card.querySelector('[data-savings-amount]');
                if (savingsAmount && pricing.savings_formatted) {
                    savingsAmount.textContent = pricing.savings_formatted;
                }
                
                // Update currency symbols if they exist as separate elements
                const currencySymbols = card.querySelectorAll('.currency-symbol');
                currencySymbols.forEach(symbol => {
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
        const currencySymbols = {
            'USD': ',
            'EUR': '€',
            'GBP': '£',
            'CAD': 'C,
            'AUD': 'A,
            'JPY': '¥',
            'CHF': 'CHF',
            'SEK': 'kr',
            'NOK': 'kr',
            'DKK': 'kr'
        };
        
        const symbol = currencySymbols[currencyCode] || ';
        
        // Update fallback pricing if exists
        const fallbackCards = document.querySelectorAll('[data-plan-id="free"], [data-plan-id="pro"], [data-plan-id="enterprise"]');
        
        fallbackCards.forEach(card => {
            const priceAmounts = card.querySelectorAll('.price-amount');
            priceAmounts.forEach(amount => {
                const currentText = amount.textContent;
                const numericValue = currentText.replace(/[^\d]/g, '');
                if (numericValue) {
                    amount.textContent = symbol + numericValue;
                }
            });
            
            // Update annual billing text
            const annualTexts = card.querySelectorAll('p');
            annualTexts.forEach(text => {
                if (text.textContent.includes('Billed annually')) {
                    const matches = text.textContent.match(/\d+/);
                    if (matches) {
                        const planId = card.dataset.planId;
                        let annualPrice;
                        
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
                        
                        text.innerHTML = text.innerHTML.replace(/\$\d+/, symbol + annualPrice);
                    }
                }
            });
        });
    }
    
    // Show success message when currency changes
    function showCurrencyChangeNotification(currencyCode) {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.currency-change-notification');
        existingNotifications.forEach(n => n.remove());
        
        // Create notification
        const notification = document.createElement('div');
        notification.className = 'currency-change-notification fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Prices updated to ${currencyCode}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        requestAnimationFrame(() => {
            notification.classList.remove('translate-x-full');
            notification.classList.add('translate-x-0');
        });
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Enhanced currency change listener
    document.addEventListener('currencyChanged', function(e) {
        showCurrencyChangeNotification(e.detail.currency);
    });
});
</script>

<!-- Additional CSS for loading states and animations -->
<style>
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

.pricing-display {
    transition: all 0.3s ease;
}

.price-amount {
    transition: all 0.2s ease;
}

.currency-change-notification {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Mobile responsive enhancements */
@media (max-width: 640px) {
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

/* Dark mode support for notifications */
@media (prefers-color-scheme: dark) {
    .currency-change-notification {
        background-color: #10b981;
    }
}
</style>
<?php endif; ?>

<!-- DIFM Banner Section - Conversion Focused -->
<?php if (get_theme_mod('difm_banner_enable', true)) : ?>
<section class="py-20 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 border-y border-gray-200 dark:border-gray-600">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                
                <!-- Background Pattern -->
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-purple-600/5 dark:from-blue-400/10 dark:to-purple-400/10"></div>
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-full transform translate-x-20 -translate-y-20"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-purple-500/10 to-pink-500/10 rounded-full transform -translate-x-16 translate-y-16"></div>
                    
                    <!-- Content -->
                    <div class="relative px-8 py-16 lg:px-16 lg:py-20">
                        <div class="grid lg:grid-cols-2 gap-12 items-center">
                            
                            <!-- Left Content -->
                            <div class="text-center lg:text-left">
                                <!-- Badge -->
                                <?php 
                                $badge_text = get_theme_mod('difm_banner_badge_text', __('Done-For-You Service', 'yoursite'));
                                if (!empty($badge_text)) :
                                ?>
                                <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full text-sm font-bold text-blue-700 dark:text-blue-300 mb-8">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4"></path>
                                    </svg>
                                    <?php echo esc_html($badge_text); ?>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Main Heading -->
                                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                                    <?php echo esc_html(get_theme_mod('difm_banner_title', __('Don\'t Want to Build It Yourself?', 'yoursite'))); ?>
                                </h2>
                                
                                <!-- Subheading -->
                                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                                    <?php echo esc_html(get_theme_mod('difm_banner_subtitle', __('Let our expert team build your perfect store while you focus on your business. Professional results, guaranteed.', 'yoursite'))); ?>
                                </p>
                                
                                <!-- Value Props -->
                                <div class="grid grid-cols-2 gap-4 mb-8">
                                    <?php 
                                    // Default icons for value props
                                    $value_prop_icons = array(
                                        1 => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                                        2 => 'M13 10V3L4 14h7v7l9-11h-7z',
                                        3 => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                        4 => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'
                                    );
                                    
                                    for ($i = 1; $i <= 4; $i++) {
                                        $feature_text = get_theme_mod("difm_banner_feature_{$i}", '');
                                        if (!empty(trim($feature_text))) :
                                    ?>
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-6 h-6 text-blue-600 dark:text-blue-400 mr-3">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($value_prop_icons[$i]); ?>"></path>
                                                </svg>
                                            </div>
                                            <span class="text-gray-700 dark:text-gray-300 font-medium"><?php echo esc_html($feature_text); ?></span>
                                        </div>
                                    <?php 
                                        endif;
                                    }
                                    ?>
                                </div>
                                
                                <!-- CTA Buttons -->
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <!-- PRIMARY CTA BUTTON WITH GUARANTEED WHITE TEXT -->
                                    <?php 
                                    $primary_text = get_theme_mod('difm_banner_primary_text', __('Build My Store', 'yoursite'));
                                    $primary_url = get_theme_mod('difm_banner_primary_url', '/build-my-website');
                                    if (!empty($primary_text)) :
                                    ?>
                                    <a href="<?php echo esc_url(home_url($primary_url)); ?>" 
                                       class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200"
                                       style="color: #ffffff !important; text-decoration: none !important;">
                                        <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-200" 
                                             style="color: #ffffff !important; stroke: #ffffff !important;" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4"></path>
                                        </svg>
                                        <span style="color: #ffffff !important;">
                                            <?php echo esc_html($primary_text); ?>
                                        </span>
                                        <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform duration-200" 
                                             style="color: #ffffff !important; stroke: #ffffff !important;" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <!-- Secondary CTA -->
                                    <?php 
                                    $secondary_text = get_theme_mod('difm_banner_secondary_text', __('Ask Questions', 'yoursite'));
                                    $secondary_url = get_theme_mod('difm_banner_secondary_url', '/contact');
                                    if (!empty($secondary_text)) :
                                    ?>
                                    <a href="<?php echo esc_url(home_url($secondary_url)); ?>" 
                                       class="group inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-bold rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <?php echo esc_html($secondary_text); ?>
                                    </a>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Trust Elements -->
                                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-center lg:justify-start space-x-6 text-sm text-gray-600 dark:text-gray-400">
                                        <?php 
                                        $trust_rating = get_theme_mod('difm_banner_trust_rating', __('4.9/5 rating', 'yoursite'));
                                        if (!empty($trust_rating)) :
                                        ?>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="font-medium"><?php echo esc_html($trust_rating); ?></span>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php 
                                        $trust_count = get_theme_mod('difm_banner_trust_count', __('500+ stores built', 'yoursite'));
                                        if (!empty($trust_count)) :
                                        ?>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="font-medium"><?php echo esc_html($trust_count); ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Visual Element -->
                            <div class="relative hidden lg:block">
                                <div class="relative w-full max-w-md mx-auto">
                                    <!-- Main illustration container -->
                                    <div class="relative bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-3xl p-8 border-2 border-blue-100 dark:border-blue-800">
                                        <!-- Website mockup -->
                                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-300">
                                            <!-- Browser bar -->
                                            <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                                                <div class="flex items-center space-x-2">
                                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                                    <div class="flex-1 bg-white dark:bg-gray-600 rounded-sm h-6 ml-4 flex items-center px-3">
                                                        <div class="w-3 h-3 text-green-500 mr-2">🔒</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">yourstore.com</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Website content -->
                                            <div class="p-6">
                                                <div class="space-y-4">
                                                    <div class="h-4 bg-gradient-to-r from-blue-200 to-purple-200 dark:from-blue-700 dark:to-purple-700 rounded w-3/4"></div>
                                                    <div class="h-3 bg-gray-200 dark:bg-gray-600 rounded w-full"></div>
                                                    <div class="h-3 bg-gray-200 dark:bg-gray-600 rounded w-5/6"></div>
                                                    <div class="grid grid-cols-2 gap-3 mt-4">
                                                        <div class="h-16 bg-gradient-to-r from-blue-400 to-purple-400 rounded-lg"></div>
                                                        <div class="h-16 bg-gray-200 dark:bg-gray-600 rounded-lg"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Floating elements -->
                                        <div class="absolute -top-4 -right-4 w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        
                                        <div class="absolute -bottom-3 -left-3 w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
<?php endif; ?>
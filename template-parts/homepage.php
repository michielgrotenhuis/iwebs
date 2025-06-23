<?php
/**
 * Template part for displaying optimized homepage content - CONVERSION FOCUSED
 * Built for maximum conversions with proven SaaS landing page patterns
 */

// Get background settings for hero
$hero_background_type = get_theme_mod('hero_background_type', 'gradient');
$hero_bg_image = get_theme_mod('hero_background_image', '');

// Build hero classes
$hero_classes = 'hero-gradient main-hero text-white py-20 lg:py-32 relative overflow-hidden';

if (in_array($hero_background_type, array('image', 'image_with_gradient')) && $hero_bg_image) {
    $hero_classes .= ' has-background-image';
}
?>

<!-- Hero Section - Conversion Optimized -->
<?php if (get_theme_mod('hero_enable', true)) : ?>
<section class="<?php echo esc_attr($hero_classes); ?>">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-1/2 -right-1/2 w-full h-full bg-gradient-to-br from-blue-400/10 to-purple-600/10 rounded-full animate-pulse"></div>
        <div class="absolute -bottom-1/2 -left-1/2 w-full h-full bg-gradient-to-tr from-purple-400/10 to-pink-600/10 rounded-full animate-pulse delay-1000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                <!-- Left Column - Hero Content -->
                <div class="text-center lg:text-left fade-in-up">
                    <!-- Trust Badge -->
                    <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium text-white/90 mb-6 border border-white/20">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?php echo esc_html(get_theme_mod('hero_trust_badge', __('Trusted by 50,000+ merchants', 'yoursite'))); ?>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                        <?php echo esc_html(get_theme_mod('hero_title', __('Launch Your Online Store in Minutes', 'yoursite'))); ?>
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-400">
                            <?php echo esc_html(get_theme_mod('hero_highlight', __('Not Hours', 'yoursite'))); ?>
                        </span>
                    </h1>

                    <!-- Value Proposition -->
                    <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        <?php echo esc_html(get_theme_mod('hero_subtitle', __('The easiest way to build, launch, and scale your e-commerce business. No coding required, results guaranteed.', 'yoursite'))); ?>
                    </p>

                    <!-- Key Benefits Pills -->
                    <div class="flex flex-wrap gap-3 justify-center lg:justify-start mb-8">
                        <?php 
                        $benefits = array(
                            get_theme_mod('hero_benefit_1', '✓ 14-day free trial'),
                            get_theme_mod('hero_benefit_2', '✓ No credit card required'),
                            get_theme_mod('hero_benefit_3', '✓ Setup in 5 minutes')
                        );
                        foreach ($benefits as $benefit) :
                            if (!empty(trim($benefit))) :
                        ?>
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium text-white border border-white/30">
                                <?php echo esc_html($benefit); ?>
                            </span>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>

                    <!-- Primary CTA -->
                    <div class="space-y-4 lg:space-y-0 lg:space-x-4 lg:flex lg:items-center">
                        <!-- Main CTA Button -->
                        <a href="<?php echo esc_url(get_theme_mod('cta_primary_url', '#signup')); ?>" 
                           class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-900 font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 w-full lg:w-auto">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <?php echo esc_html(get_theme_mod('cta_primary_text', __('Start Your Free Store', 'yoursite'))); ?>
                            <svg class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <!-- Secondary CTA -->
                        <a href="<?php echo esc_url(get_theme_mod('cta_secondary_url', '#demo')); ?>" 
                           class="group inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white/40 hover:border-white/80 text-white font-semibold text-lg rounded-xl hover:bg-white/10 transition-all duration-200 w-full lg:w-auto">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <?php echo esc_html(get_theme_mod('cta_secondary_text', __('Watch Demo', 'yoursite'))); ?>
                        </a>
                    </div>

                    <!-- Risk Reversal -->
                    <p class="text-white/70 text-sm mt-4">
                        <?php echo esc_html(get_theme_mod('hero_risk_reversal', __('Cancel anytime. 30-day money-back guarantee.', 'yoursite'))); ?>
                    </p>
                </div>

                <!-- Right Column - Hero Visual -->
                <div class="relative lg:mt-0 mt-12">
                    <!-- Main Dashboard/Product Image -->
                    <div class="relative z-10">
                        <?php 
                        $dashboard_image = get_theme_mod('hero_dashboard_image');
                        $video_url = get_theme_mod('hero_video_url');
                        if ($dashboard_image) : ?>
                            <div class="relative bg-white rounded-2xl shadow-2xl p-4 transform rotate-1 hover:rotate-0 transition-transform duration-500 group <?php echo $video_url ? 'cursor-pointer video-thumbnail' : ''; ?>" 
                                 <?php if ($video_url) : ?>data-video-url="<?php echo esc_url($video_url); ?>"<?php endif; ?>>
                                
                                <!-- Browser Chrome -->
                                <div class="bg-gray-100 rounded-t-xl px-4 py-3">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                        <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                        <div class="flex-1 bg-white rounded-sm h-6 ml-4 flex items-center px-3">
                                            <div class="w-3 h-3 text-gray-400 mr-2">🔒</div>
                                            <div class="text-xs text-gray-500 font-mono">yourstore.com</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dashboard Image -->
                                <div class="rounded-b-xl overflow-hidden relative">
                                    <img src="<?php echo esc_url($dashboard_image); ?>" 
                                         alt="<?php _e('Store Dashboard Preview', 'yoursite'); ?>" 
                                         class="w-full h-auto object-cover">
                                    
                                    <?php if ($video_url) : ?>
                                    <!-- Play Button Overlay -->
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <button class="video-play-button bg-white rounded-full p-6 shadow-lg hover:scale-110 transition-transform duration-200">
                                            <svg class="w-8 h-8 text-blue-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <!-- Fallback placeholder -->
                            <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
                                <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl mx-auto mb-6"></div>
                                <h3 class="text-gray-900 font-bold text-xl mb-2"><?php _e('Beautiful Dashboard', 'yoursite'); ?></h3>
                                <p class="text-gray-600"><?php _e('Intuitive interface designed for success', 'yoursite'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Floating Elements -->
                    <div class="absolute -top-4 -right-4 w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                        <svg class="w-8 h-8 text-yellow-900" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>

                    <div class="absolute -bottom-4 -left-4 w-12 h-12 bg-green-400 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                        <svg class="w-6 h-6 text-green-900" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Social Proof Banner -->
<?php if (get_theme_mod('social_proof_enable', true)) : ?>
<section class="bg-gray-50 dark:bg-gray-900 py-8 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <p class="text-gray-600 dark:text-gray-300 text-sm font-medium mb-6">
                <?php echo esc_html(get_theme_mod('social_proof_text', __('Trusted by 50,000+ merchants in 180+ countries', 'yoursite'))); ?>
            </p>
            
            <!-- Customer Logos -->
            <div class="flex items-center justify-center space-x-8 opacity-60 hover:opacity-80 transition-opacity duration-300">
                <?php for ($i = 1; $i <= 5; $i++) : 
                    $logo = get_theme_mod("social_proof_logo_{$i}");
                    if ($logo) : ?>
                        <div class="h-8 flex items-center">
                            <img src="<?php echo esc_url($logo); ?>" 
                                 alt="<?php printf(__('Customer Logo %d', 'yoursite'), $i); ?>" 
                                 class="max-h-full max-w-24 object-contain grayscale hover:grayscale-0 transition-all duration-300">
                        </div>
                    <?php else : ?>
                        <div class="h-8 w-24 bg-gray-300 dark:bg-gray-600 rounded opacity-50"></div>
                    <?php endif;
                endfor; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Problem/Solution Section -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                <?php echo esc_html(get_theme_mod('problem_title', __('Tired of Complex E-commerce Solutions?', 'yoursite'))); ?>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-12 max-w-3xl mx-auto">
                <?php echo esc_html(get_theme_mod('problem_subtitle', __('Most platforms are either too basic or overwhelmingly complex. We\'ve built the perfect middle ground.', 'yoursite'))); ?>
            </p>
            
            <!-- Before vs After -->
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- Before -->
                <div class="bg-red-50 dark:bg-red-900/20 rounded-2xl p-8 border border-red-200 dark:border-red-800">
                    <h3 class="text-xl font-bold text-red-900 dark:text-red-300 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Before: Traditional Platforms
                    </h3>
                    <ul class="space-y-3 text-left">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <span class="text-red-800 dark:text-red-300">Weeks of setup and configuration</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <span class="text-red-800 dark:text-red-300">Expensive monthly fees + hidden costs</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <span class="text-red-800 dark:text-red-300">Need developers for customization</span>
                        </li>
                    </ul>
                </div>

                <!-- After -->
                <div class="bg-green-50 dark:bg-green-900/20 rounded-2xl p-8 border border-green-200 dark:border-green-800">
                    <h3 class="text-xl font-bold text-green-900 dark:text-green-300 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        After: Our Platform
                    </h3>
                    <ul class="space-y-3 text-left">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-green-800 dark:text-green-300">Live in 5 minutes with templates</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-green-800 dark:text-green-300">Transparent pricing, no surprises</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-green-800 dark:text-green-300">Drag & drop - no coding needed</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

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
                $benefits = array(
                    array(
                        'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                        'title' => get_theme_mod('benefit_1_title', 'Drag & Drop Builder'),
                        'description' => get_theme_mod('benefit_1_description', 'Create stunning pages without any coding. Our visual builder makes it simple.'),
                        'color' => 'blue'
                    ),
                    array(
                        'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                        'title' => get_theme_mod('benefit_2_title', 'Secure Payments'),
                        'description' => get_theme_mod('benefit_2_description', 'Accept all major payment methods with bank-level security and fraud protection.'),
                        'color' => 'green'
                    ),
                    array(
                        'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                        'title' => get_theme_mod('benefit_3_title', 'Advanced Analytics'),
                        'description' => get_theme_mod('benefit_3_description', 'Track sales, customers, and growth with detailed reports and insights.'),
                        'color' => 'purple'
                    ),
                    array(
                        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        'title' => get_theme_mod('benefit_4_title', 'Global Shipping'),
                        'description' => get_theme_mod('benefit_4_description', 'Ship anywhere with integrated carriers and automated label printing.'),
                        'color' => 'orange'
                    ),
                    array(
                        'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100-4m0 4v2m0-6V4',
                        'title' => get_theme_mod('benefit_5_title', 'Marketing Tools'),
                        'description' => get_theme_mod('benefit_5_description', 'Built-in SEO, email marketing, and social media integration to grow your reach.'),
                        'color' => 'pink'
                    ),
                    array(
                        'icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z',
                        'title' => get_theme_mod('benefit_6_title', '24/7 Support'),
                        'description' => get_theme_mod('benefit_6_description', 'Get help when you need it with our dedicated support team and knowledge base.'),
                        'color' => 'indigo'
                    )
                );

                foreach ($benefits as $benefit) : ?>
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-gray-200 dark:border-gray-700">
                    <div class="w-14 h-14 bg-<?php echo esc_attr($benefit['color']); ?>-100 dark:bg-<?php echo esc_attr($benefit['color']); ?>-900/50 rounded-xl mx-auto mb-6 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-<?php echo esc_attr($benefit['color']); ?>-600 dark:text-<?php echo esc_attr($benefit['color']); ?>-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($benefit['icon']); ?>"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white text-center">
                        <?php echo esc_html($benefit['title']); ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-center leading-relaxed">
                        <?php echo esc_html($benefit['description']); ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Pricing Section - Conversion Focused -->
<?php if (get_theme_mod('pricing_enable', true)) : ?>
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('pricing_title', __('Simple, Transparent Pricing', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8">
                    <?php echo esc_html(get_theme_mod('pricing_subtitle', __('Start free, then choose the plan that scales with your business', 'yoursite'))); ?>
                </p>
                
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
            
          <!-- Pricing Cards -->
<?php
// Get pricing plans
$pricing_args = array(
    'post_type' => 'pricing',
    'posts_per_page' => 3,
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
    
    if (!function_exists('yoursite_get_currency_symbol')) {
        function yoursite_get_currency_symbol($currency = 'USD') {
            switch ($currency) {
                case 'EUR':
                    return '€';
                case 'GBP':
                    return '£';
                case 'USD':
                default:
                    return '$';
            }
        }
    }
?>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <?php foreach ($pricing_plans as $index => $plan) : 
                    $meta = yoursite_get_pricing_meta_fields($plan->ID);
                    $is_featured = $meta['pricing_featured'] === '1';
                    $monthly_price = floatval($meta['pricing_monthly_price']);
                    $annual_price = floatval($meta['pricing_annual_price']);
                    $currency_symbol = yoursite_get_currency_symbol($meta['pricing_currency']);
                    
                    if ($annual_price == 0 && $monthly_price > 0) {
                        $annual_price = $monthly_price * 12 * 0.8;
                    }
                    $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
                ?>
                
                <div class="pricing-card relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 <?php echo $is_featured ? 'scale-105 border-blue-500 dark:border-blue-400' : 'hover:-translate-y-2'; ?>">
                    
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
                            <div class="monthly-pricing">
                                <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                    <?php echo $currency_symbol . number_format($monthly_price, 0); ?>
                                    <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                                </div>
                                <?php if ($monthly_price > 0) : ?>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                    Billed monthly
                                </p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Annual Price -->
                            <div class="annual-pricing hidden">
                                <div class="text-4xl font-bold text-gray-900 dark:text-white">
                                    <?php echo $currency_symbol . number_format($annual_monthly, 0); ?>
                                    <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                                </div>
                                <?php if ($annual_price > 0) : ?>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                    Billed annually (<?php echo $currency_symbol . number_format($annual_price, 0); ?>)
                                </p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Save <?php echo $currency_symbol . number_format(($monthly_price * 12) - $annual_price, 0); ?>/year
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
                               class="block w-full py-4 px-6 rounded-xl font-bold text-lg transition-all duration-200 <?php echo $is_featured ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:from-blue-600 hover:to-purple-700 shadow-lg hover:shadow-xl' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600'; ?>">
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
            <!-- Fallback Pricing -->
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Free Plan -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-200 dark:border-gray-700">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Free</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Perfect for getting started</p>
                    </div>
                    <div class="text-center mb-8">
                        <div class="text-4xl font-bold text-gray-900 dark:text-white">
                            $0<span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                        </div>
                    </div>
                    <a href="#signup" class="block w-full py-4 px-6 rounded-xl font-bold text-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 text-center transition-all duration-200">
                        Start Free
                    </a>
                </div>
                
                <!-- Pro Plan -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border-2 border-blue-500 dark:border-blue-400 scale-105 relative">
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
                        <div class="text-4xl font-bold text-gray-900 dark:text-white">
                            $29<span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                        </div>
                    </div>
                    <a href="#signup" class="block w-full py-4 px-6 rounded-xl font-bold text-lg bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:from-blue-600 hover:to-purple-700 text-center transition-all duration-200 shadow-lg hover:shadow-xl">
                        Start Free Trial
                    </a>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-200 dark:border-gray-700">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Enterprise</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">For large organizations</p>
                    </div>
                    <div class="text-center mb-8">
                        <div class="text-4xl font-bold text-gray-900 dark:text-white">
                            $99<span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mo</span>
                        </div>
                    </div>
                    <a href="#contact" class="block w-full py-4 px-6 rounded-xl font-bold text-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 text-center transition-all duration-200">
                        Contact Sales
                    </a>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Bottom CTA -->
            <div class="text-center mt-12">
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    All plans include 14-day free trial • No setup fees • Cancel anytime
                </p>
                <a href="<?php echo home_url('/pricing'); ?>" class="text-blue-600 dark:text-blue-400 font-medium hover:underline">
                    Compare all features →
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- DIFM Banner Section - Conversion Focused -->
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
                                <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full text-sm font-bold text-blue-700 dark:text-blue-300 mb-8">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4"></path>
                                    </svg>
                                    <?php echo esc_html(get_theme_mod('difm_banner_badge_text', 'Done-For-You Service')); ?>
                                </div>
                                
                                <!-- Main Heading -->
                                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                                    <?php echo esc_html(get_theme_mod('difm_banner_title', 'Don\'t Want to Build It Yourself?')); ?>
                                </h2>
                                
                                <!-- Subheading -->
                                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                                    <?php echo esc_html(get_theme_mod('difm_banner_subtitle', 'Let our expert team build your perfect store while you focus on your business. Professional results, guaranteed.')); ?>
                                </p>
                                
                                <!-- Value Props -->
                                <div class="grid grid-cols-2 gap-4 mb-8">
                                    <?php 
                                    $value_props = array(
                                        array('icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'text' => get_theme_mod('difm_banner_feature_1', 'Professional Design')),
                                        array('icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'text' => get_theme_mod('difm_banner_feature_2', '5-Day Delivery')),
                                        array('icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => get_theme_mod('difm_banner_feature_3', 'Money-Back Guarantee')),
                                        array('icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', 'text' => get_theme_mod('difm_banner_feature_4', 'Ongoing Support'))
                                    );
                                    
                                    foreach ($value_props as $prop) :
                                        if (!empty(trim($prop['text']))) :
                                    ?>
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-6 h-6 text-blue-600 dark:text-blue-400 mr-3">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($prop['icon']); ?>"></path>
                                                </svg>
                                            </div>
                                            <span class="text-gray-700 dark:text-gray-300 font-medium"><?php echo esc_html($prop['text']); ?></span>
                                        </div>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                                
                                <!-- CTA Buttons -->
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <!-- Primary CTA -->
                                    <a href="<?php echo esc_url(home_url(get_theme_mod('difm_banner_primary_url', '/build-my-website'))); ?>" 
                                       class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                                        <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4"></path>
                                        </svg>
                                        <?php echo esc_html(get_theme_mod('difm_banner_primary_text', 'Build My Store')); ?>
                                        <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    
                                    <!-- Secondary CTA -->
                                    <a href="<?php echo esc_url(home_url(get_theme_mod('difm_banner_secondary_url', '/contact'))); ?>" 
                                       class="group inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-bold rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <?php echo esc_html(get_theme_mod('difm_banner_secondary_text', 'Ask Questions')); ?>
                                    </a>
                                </div>
                                
                                <!-- Trust Elements -->
                                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-center lg:justify-start space-x-6 text-sm text-gray-600 dark:text-gray-400">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="font-medium">4.9/5 rating</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="font-medium">500+ stores built</span>
                                        </div>
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

<!-- Testimonials - Social Proof -->
<?php if (get_theme_mod('testimonials_enable', true)) : ?>
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('testimonials_title', __('Loved by 50,000+ Merchants Worldwide', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('testimonials_subtitle', __('See why businesses choose us to power their online success', 'yoursite'))); ?>
                </p>
            </div>
            
            <!-- Testimonials Grid -->
            <?php
            $testimonials_count = get_theme_mod('testimonials_count', 3);
            $testimonials = get_testimonials($testimonials_count);
            if ($testimonials && $testimonials->have_posts()) :
            ?>
            <div class="grid md:grid-cols-3 gap-8">
                <?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <!-- Rating -->
                    <div class="flex text-yellow-400 mb-6">
                        <?php for ($i = 0; $i < 5; $i++) : ?>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        <?php endfor; ?>
                    </div>
                    
                    <!-- Testimonial Content -->
                    <blockquote class="text-gray-700 dark:text-gray-300 mb-6 text-lg leading-relaxed">
                        "<?php the_content(); ?>"
                    </blockquote>
                    
                    <!-- Author -->
                    <div class="flex items-center">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="mr-4">
                                <?php the_post_thumbnail('thumbnail', array('class' => 'w-14 h-14 rounded-full object-cover')); ?>
                            </div>
                        <?php else : ?>
                            <div class="w-14 h-14 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-lg"><?php echo substr(get_the_title(), 0, 1); ?></span>
                            </div>
                        <?php endif; ?>
                        <div>
                            <div class="font-bold text-gray-900 dark:text-white"><?php the_title(); ?></div>
                            <div class="text-gray-600 dark:text-gray-400 text-sm"><?php the_excerpt(); ?></div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php 
            wp_reset_postdata();
            else : 
            ?>
            <!-- Fallback testimonials -->
            <div class="grid md:grid-cols-3 gap-8">
                <?php 
                $default_testimonials = array(
                    array(
                        'content' => 'This platform transformed our business. We went from zero to $50k in monthly sales in just 3 months!',
                        'name' => 'Sarah Chen',
                        'title' => 'Founder, EcoProducts'
                    ),
                    array(
                        'content' => 'The easiest e-commerce platform I\'ve ever used. Setup was literally 5 minutes and we were selling immediately.',
                        'name' => 'Mike Rodriguez',
                        'title' => 'CEO, TechGadgets'
                    ),
                    array(
                        'content' => 'Customer support is incredible. They helped us customize everything perfectly for our unique needs.',
                        'name' => 'Emily Johnson',
                        'title' => 'Owner, Handmade Haven'
                    )
                );
                
                foreach ($default_testimonials as $index => $testimonial) : ?>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="flex text-yellow-400 mb-6">
                        <?php for ($i = 0; $i < 5; $i++) : ?>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        <?php endfor; ?>
                    </div>
                    <blockquote class="text-gray-700 dark:text-gray-300 mb-6 text-lg leading-relaxed">
                        "<?php echo esc_html($testimonial['content']); ?>"
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg"><?php echo substr($testimonial['name'], 0, 1); ?></span>
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 dark:text-white"><?php echo esc_html($testimonial['name']); ?></div>
                            <div class="text-gray-600 dark:text-gray-400 text-sm"><?php echo esc_html($testimonial['title']); ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Stats/Numbers Section -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo esc_html(get_theme_mod('stats_title', __('Trusted by Growing Businesses', 'yoursite'))); ?>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-12">
                <?php echo esc_html(get_theme_mod('stats_subtitle', __('Join thousands of successful merchants who chose us', 'yoursite'))); ?>
            </p>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                $stats = array(
                    array(
                        'number' => get_theme_mod('stat_1_number', '50K+'),
                        'label' => get_theme_mod('stat_1_label', 'Active Stores'),
                        'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4'
                    ),
                    array(
                        'number' => get_theme_mod('stat_2_number', '$2B+'),
                        'label' => get_theme_mod('stat_2_label', 'Sales Processed'),
                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    ),
                    array(
                        'number' => get_theme_mod('stat_3_number', '180+'),
                        'label' => get_theme_mod('stat_3_label', 'Countries'),
                        'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    ),
                    array(
                        'number' => get_theme_mod('stat_4_number', '99.9%'),
                        'label' => get_theme_mod('stat_4_label', 'Uptime'),
                        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
                    )
                );
                
                foreach ($stats as $stat) : ?>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($stat['icon']); ?>"></path>
                        </svg>
                    </div>
                    <div class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                        <?php echo esc_html($stat['number']); ?>
                    </div>
                    <div class="text-gray-600 dark:text-gray-300 font-medium">
                        <?php echo esc_html($stat['label']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('faq_title', __('Frequently Asked Questions', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('faq_subtitle', __('Everything you need to know to get started', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="space-y-6">
                <?php 
                $faqs = array(
                    array(
                        'question' => get_theme_mod('faq_1_question', 'How quickly can I launch my store?'),
                        'answer' => get_theme_mod('faq_1_answer', 'You can have a fully functional store live in under 5 minutes using our templates and quick setup wizard.')
                    ),
                    array(
                        'question' => get_theme_mod('faq_2_question', 'Do I need any technical skills?'),
                        'answer' => get_theme_mod('faq_2_answer', 'Not at all! Our drag-and-drop builder is designed for anyone to use, regardless of technical background.')
                    ),
                    array(
                        'question' => get_theme_mod('faq_3_question', 'What payment methods can I accept?'),
                        'answer' => get_theme_mod('faq_3_answer', 'We support all major credit cards, PayPal, Apple Pay, Google Pay, and many regional payment methods.')
                    ),
                    array(
                        'question' => get_theme_mod('faq_4_question', 'Is there a free trial?'),
                        'answer' => get_theme_mod('faq_4_answer', 'Yes! All paid plans include a 14-day free trial. No credit card required to get started.')
                    ),
                    array(
                        'question' => get_theme_mod('faq_5_question', 'Can I migrate from another platform?'),
                        'answer' => get_theme_mod('faq_5_answer', 'Absolutely! We offer free migration assistance to help you move your store from any platform.')
                    )
                );
                
                foreach ($faqs as $index => $faq) :
                    if (!empty(trim($faq['question'])) && !empty(trim($faq['answer']))) :
                ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <button class="faq-toggle w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200" data-index="<?php echo $index; ?>">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white pr-8">
                                <?php echo esc_html($faq['question']); ?>
                            </h3>
                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400 transform transition-transform duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-8 pb-6">
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                <?php echo esc_html($faq['answer']); ?>
                            </p>
                        </div>
                    </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA Section - Ultra High Converting -->
<?php if (get_theme_mod('final_cta_enable', true)) : ?>
<section class="final-cta-section relative py-20 bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 text-white overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/90 to-purple-600/90"></div>
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-white/5 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-white/5 rounded-full animate-pulse delay-1000"></div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Trust Badge -->
            <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium mb-6 border border-white/20">
                <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Join 50,000+ successful merchants
            </div>
            
            <!-- Main Headline -->
            <h2 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                <?php echo esc_html(get_theme_mod('final_cta_title', __('Ready to Launch Your Dream Store?', 'yoursite'))); ?>
            </h2>
            
            <!-- Subheadline -->
            <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-3xl mx-auto leading-relaxed">
                <?php echo esc_html(get_theme_mod('final_cta_subtitle', __('Start your 14-day free trial today. No credit card required, no setup fees, cancel anytime.', 'yoursite'))); ?>
            </p>
            
            <!-- Urgency/Scarcity -->
            <div class="bg-yellow-400 text-yellow-900 px-6 py-3 rounded-full inline-block font-bold text-lg mb-8">
                🔥 Limited Time: Free setup worth $200
            </div>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <!-- Primary CTA -->
                <a href="<?php echo esc_url(get_theme_mod('final_cta_primary_url', '#signup')); ?>" 
                   class="group inline-flex items-center justify-center px-10 py-5 bg-white text-gray-900 font-bold text-xl rounded-2xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300 min-w-[280px]">
                    <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <?php echo esc_html(get_theme_mod('final_cta_primary_text', __('Start Your Free Store Now', 'yoursite'))); ?>
                    <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                <!-- Secondary CTA -->
                <a href="<?php echo esc_url(get_theme_mod('final_cta_secondary_url', '#demo')); ?>" 
                   class="group inline-flex items-center justify-center px-10 py-5 bg-transparent border-2 border-white/60 hover:border-white text-white font-bold text-xl rounded-2xl hover:bg-white/10 transition-all duration-300 min-w-[280px]">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <?php echo esc_html(get_theme_mod('final_cta_secondary_text', __('Watch Live Demo', 'yoursite'))); ?>
                </a>
            </div>
            
            <!-- Risk Reversal & Trust Elements -->
            <div class="flex flex-wrap justify-center items-center gap-6 text-sm opacity-90">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    14-day free trial
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    No credit card required
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    30-day money-back guarantee
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Cancel anytime
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Video Modal -->
<div id="video-modal" class="fixed inset-0 z-50 hidden" style="z-index: 9999;">
    <div class="absolute inset-0 bg-black bg-opacity-90 backdrop-blur-sm"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="relative max-w-6xl w-full">
            <button id="close-video-modal" class="absolute -top-16 right-0 text-white hover:text-gray-300 transition-colors z-50 p-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="bg-black rounded-xl shadow-2xl overflow-hidden" style="padding-top: 56.25%; position: relative;">
                <iframe id="video-iframe" 
                        class="absolute top-0 left-0 w-full h-full" 
                        src="" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<style>
/* Enhanced Animation Styles */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

/* Hover Effects */
.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Mobile Responsive Utilities */
@media (max-width: 640px) {
    .mobile-stack {
        flex-direction: column;
        gap: 1rem;
    }
    
    .mobile-stack > * {
        width: 100%;
    }
    
    .mobile-full-width {
        width: 100% !important;
    }
}

/* Pricing Toggle Styles */
.billing-btn.active {
    background-color: #2563eb !important;
    color: white !important;
    box-shadow: 0 4px 14px 0 rgba(37, 99, 235, 0.3);
}

.billing-btn:not(.active) {
    color: #6b7280;
}

/* FAQ Styles */
.faq-toggle.active svg {
    transform: rotate(180deg);
}

.faq-content {
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-content.active {
    max-height: 200px;
    padding-bottom: 1.5rem;
}

/* Dark Mode Enhancements */
body.dark-mode .final-cta-section {
    background: linear-gradient(135deg, #1e40af 0%, #7c3aed 50%, #1e40af 100%) !important;
}

body.dark-mode .pricing-card {
    background: rgba(31, 41, 55, 0.95) !important;
    border-color: rgba(75, 85, 99, 0.3) !important;
}

body.dark-mode .pricing-card.featured {
    border-color: #3b82f6 !important;
    background: rgba(31, 41, 55, 1) !important;
}

/* Performance Optimizations */
.pricing-card,
.feature-card {
    will-change: transform;
    backface-visibility: hidden;
}

/* Enhanced Button Styles */
.btn-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    background-size: 200% 200%;
    animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Testimonial Cards Enhancement */
.testimonial-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.dark .testimonial-card {
    background: linear-gradient(145deg, #374151 0%, #1f2937 100%);
    border: 1px solid rgba(255, 255, 255, 0.05);
}

/* Scroll-triggered animations */
.scroll-reveal {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease;
}

.scroll-reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}

/* Enhanced video modal */
#video-modal {
    backdrop-filter: blur(8px);
}

#video-modal.loading::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-top: 3px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    z-index: 100;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Mobile optimizations */
@media (max-width: 768px) {
    .hero-gradient h1 {
        font-size: 2.5rem !important;
        line-height: 1.2 !important;
    }
    
    .hero-gradient p {
        font-size: 1.125rem !important;
    }
    
    .grid.md\\:grid-cols-2,
    .grid.md\\:grid-cols-3 {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }
    
    .pricing-card {
        margin-bottom: 2rem;
    }
    
    .scale-105 {
        transform: scale(1.02) !important;
    }
}

/* Accessibility improvements */
.focus\\:ring-4:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.3);
}

button:focus,
a:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

/* Loading states */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* Enhanced trust indicators */
.trust-badge {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.2);
    color: #059669;
}

.dark .trust-badge {
    background: rgba(16, 185, 129, 0.2);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: #10b981;
}

/* Pricing animation */
.pricing-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.pricing-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

/* Stats counter animation */
.stat-number {
    font-variant-numeric: tabular-nums;
}

/* Improved gradient overlays */
.gradient-overlay {
    background: linear-gradient(135deg, 
        rgba(102, 126, 234, 0.9) 0%, 
        rgba(118, 75, 162, 0.9) 100%);
}

/* Enhanced social proof */
.social-proof-logos img {
    filter: grayscale(100%) opacity(60%);
    transition: all 0.3s ease;
}

.social-proof-logos img:hover {
    filter: grayscale(0%) opacity(100%);
    transform: scale(1.05);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 High-Converting Homepage Loaded');
    
    // ===== PRICING TOGGLE FUNCTIONALITY =====
    initializePricingToggle();
    
    function initializePricingToggle() {
        const monthlyBtn = document.querySelector('.monthly-btn');
        const annualBtn = document.querySelector('.annual-btn');
        const monthlyPricing = document.querySelectorAll('.monthly-pricing');
        const annualPricing = document.querySelectorAll('.annual-pricing');
        
        if (!monthlyBtn || !annualBtn) return;
        
        // Set initial state (annual active)
        setActiveToggle('annual');
        
        monthlyBtn.addEventListener('click', () => setActiveToggle('monthly'));
        annualBtn.addEventListener('click', () => setActiveToggle('annual'));
        
        function setActiveToggle(type) {
            // Update button states
            monthlyBtn.classList.toggle('active', type === 'monthly');
            annualBtn.classList.toggle('active', type === 'annual');
            
            // Update pricing display
            monthlyPricing.forEach(el => {
                el.style.display = type === 'monthly' ? 'block' : 'none';
            });
            annualPricing.forEach(el => {
                el.style.display = type === 'annual' ? 'block' : 'none';
            });
            
            // Add animation
            document.querySelectorAll('.pricing-card').forEach((card, index) => {
                card.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    card.style.transform = '';
                }, index * 50);
            });
        }
    }
    
    // ===== FAQ FUNCTIONALITY =====
    initializeFAQ();
    
    function initializeFAQ() {
        const faqToggles = document.querySelectorAll('.faq-toggle');
        
        faqToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const icon = this.querySelector('svg');
                const isActive = this.classList.contains('active');
                
                // Close all other FAQs
                faqToggles.forEach(otherToggle => {
                    if (otherToggle !== this) {
                        otherToggle.classList.remove('active');
                        const otherContent = otherToggle.nextElementSibling;
                        const otherIcon = otherToggle.querySelector('svg');
                        otherContent.style.maxHeight = '0';
                        otherContent.classList.remove('active');
                        otherIcon.style.transform = 'rotate(0deg)';
                    }
                });
                
                // Toggle current FAQ
                if (isActive) {
                    this.classList.remove('active');
                    content.style.maxHeight = '0';
                    content.classList.remove('active');
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    this.classList.add('active');
                    content.style.maxHeight = content.scrollHeight + 'px';
                    content.classList.add('active');
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        });
    }
    
    // ===== VIDEO MODAL FUNCTIONALITY =====
    initializeVideoModal();
    
    function initializeVideoModal() {
        const videoModal = document.getElementById('video-modal');
        const videoIframe = document.getElementById('video-iframe');
        const closeButton = document.getElementById('close-video-modal');
        const videoThumbnails = document.querySelectorAll('.video-thumbnail');
        
        videoThumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function(e) {
                e.preventDefault();
                const videoUrl = this.getAttribute('data-video-url');
                if (videoUrl) openVideoModal(videoUrl);
            });
        });
        
        if (closeButton) {
            closeButton.addEventListener('click', closeVideoModal);
        }
        
        if (videoModal) {
            videoModal.addEventListener('click', function(e) {
                if (e.target === this || e.target.classList.contains('bg-black')) {
                    closeVideoModal();
                }
            });
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && videoModal && !videoModal.classList.contains('hidden')) {
                closeVideoModal();
            }
        });
        
        function openVideoModal(videoUrl) {
            const embedUrl = convertToEmbedUrl(videoUrl);
            if (!embedUrl || !videoModal || !videoIframe) return;
            
            videoModal.classList.add('loading');
            videoIframe.src = embedUrl;
            videoModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            videoIframe.onload = () => {
                videoModal.classList.remove('loading');
            };
            
            setTimeout(() => closeButton?.focus(), 100);
        }
        
        function closeVideoModal() {
            if (!videoModal || videoModal.classList.contains('hidden')) return;
            
            videoModal.classList.add('hidden');
            videoModal.classList.remove('loading');
            if (videoIframe) videoIframe.src = '';
            document.body.style.overflow = '';
        }
        
        function convertToEmbedUrl(url) {
            if (!url) return null;
            
            let videoId = null;
            
            if (url.includes('youtube.com/watch?v=')) {
                videoId = url.split('v=')[1].split('&')[0];
            } else if (url.includes('youtu.be/')) {
                videoId = url.split('youtu.be/')[1].split('?')[0];
            } else if (url.includes('youtube.com/embed/')) {
                videoId = url.split('embed/')[1].split('?')[0];
            }
            
            return videoId ? `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1` : null;
        }
    }
    
    // ===== SCROLL ANIMATIONS =====
    initializeScrollAnimations();
    
    function initializeScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    
                    // Animate stats numbers
                    if (entry.target.classList.contains('stat-number')) {
                        animateNumber(entry.target);
                    }
                }
            });
        }, observerOptions);
        
        // Observe elements for scroll animations
        document.querySelectorAll('.feature-card, .pricing-card, .testimonial-card, .stat-number').forEach(el => {
            el.classList.add('scroll-reveal');
            observer.observe(el);
        });
    }
    
    // ===== STATS COUNTER ANIMATION =====
    function animateNumber(element) {
        const text = element.textContent;
        const number = parseInt(text.replace(/\D/g, ''));
        if (isNaN(number)) return;
        
        const suffix = text.replace(/[\d,]/g, '');
        const duration = 2000;
        const steps = 60;
        const increment = number / steps;
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= number) {
                current = number;
                clearInterval(timer);
            }
            
            const formatted = Math.floor(current).toLocaleString();
            element.textContent = formatted + suffix;
        }, duration / steps);
    }
    
    // ===== ENHANCED BUTTON INTERACTIONS =====
    initializeButtonEnhancements();
    
    function initializeButtonEnhancements() {
        // Add loading states to CTA buttons
        document.querySelectorAll('a[href*="signup"], a[href*="trial"]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.href.includes('#signup') || this.href.includes('#trial')) {
                    e.preventDefault();
                    
                    this.classList.add('btn-loading');
                    
                    // Simulate loading for demo purposes
                    setTimeout(() => {
                        this.classList.remove('btn-loading');
                        // In real implementation, redirect to signup
                        window.location.href = '/signup';
                    }, 1500);
                }
            });
        });
        
        // Add hover effects to feature cards
        document.querySelectorAll('.feature-card, .pricing-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
    }
    
    // ===== PROGRESSIVE ENHANCEMENT =====
    initializeProgressiveEnhancements();
    
    function initializeProgressiveEnhancements() {
        // Lazy load images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
        
        // Preload critical resources
        const criticalResources = [
            '/signup',
            '/pricing',
            '/demo'
        ];
        
        criticalResources.forEach(url => {
            const link = document.createElement('link');
            link.rel = 'prefetch';
            link.href = url;
            document.head.appendChild(link);
        });
        
        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }
    
    // ===== CONVERSION TRACKING =====
    initializeConversionTracking();
    
    function initializeConversionTracking() {
        // Track CTA button clicks
        document.querySelectorAll('.btn-primary, .cta-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Track conversion event
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'cta_click', {
                        'event_category': 'conversion',
                        'event_label': this.textContent.trim(),
                        'button_location': getButtonLocation(this)
                    });
                }
                
                console.log('🎯 CTA Clicked:', this.textContent.trim());
            });
        });
        
        // Track scroll depth
        let maxScroll = 0;
        window.addEventListener('scroll', throttle(() => {
            const scrollPercent = Math.round((window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100);
            
            if (scrollPercent > maxScroll && scrollPercent % 25 === 0) {
                maxScroll = scrollPercent;
                
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'scroll_depth', {
                        'event_category': 'engagement',
                        'event_label': scrollPercent + '%'
                    });
                }
                
                console.log('📊 Scroll Depth:', scrollPercent + '%');
            }
        }, 250));
        
        function getButtonLocation(button) {
            const section = button.closest('section');
            if (section) {
                if (section.classList.contains('hero-gradient')) return 'hero';
                if (section.classList.contains('final-cta-section')) return 'final_cta';
                if (section.querySelector('h2')) {
                    return section.querySelector('h2').textContent.toLowerCase().replace(/\s+/g, '_');
                }
            }
            return 'unknown';
        }
        
        function throttle(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            }
        }
    }
    
    // ===== PERFORMANCE MONITORING =====
    initializePerformanceMonitoring();
    
    function initializePerformanceMonitoring() {
        // Monitor page load performance
        window.addEventListener('load', () => {
            setTimeout(() => {
                const perfData = performance.getEntriesByType('navigation')[0];
                console.log('⚡ Page Load Time:', Math.round(perfData.loadEventEnd - perfData.loadEventStart) + 'ms');
                
                // Track Core Web Vitals
                if ('web-vitals' in window) {
                    getCLS(console.log);
                    getFID(console.log);
                    getLCP(console.log);
                }
            }, 0);
        });
    }
    
    console.log('✅ Homepage initialization complete');
});

// ===== UTILITY FUNCTIONS =====
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Helper function for testimonials
function get_testimonials(count) {
    // This would typically be implemented in PHP
    return false;
}
</script>
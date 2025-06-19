<?php
/**
 * Template part for displaying customizable homepage content
 */

// Get background image for hero
$hero_bg_image = get_theme_mod('hero_background_image');
$hero_bg_style = $hero_bg_image ? 'background-image: url(' . esc_url($hero_bg_image) . '); background-size: cover; background-position: center;' : '';
?>

<?php if (get_theme_mod('hero_enable', true)) : ?>
<!-- Hero Section -->
<section class="hero-gradient text-white py-20 lg:py-32" style="<?php echo $hero_bg_style; ?>">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center fade-in-up">
            <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                <?php echo esc_html(get_theme_mod('hero_title', __('Build Your Online Store in Minutes', 'yoursite'))); ?>
            </h1>
            <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-3xl mx-auto">
                <?php echo esc_html(get_theme_mod('hero_subtitle', __('No code. No hassle. Just launch and sell.', 'yoursite'))); ?>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="<?php echo esc_url(get_theme_mod('cta_primary_url', '#')); ?>" class="btn-primary text-lg px-8 py-4 rounded-lg font-semibold hover-lift" style="color: #7c3aed !important;">
                    <?php echo esc_html(get_theme_mod('cta_primary_text', __('Start Free Trial', 'yoursite'))); ?>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('cta_secondary_url', '#demo')); ?>" class="btn-secondary text-lg px-8 py-4 rounded-lg font-semibold hover-lift">
                    <?php echo esc_html(get_theme_mod('cta_secondary_text', __('View Demo', 'yoursite'))); ?>
                </a>
            </div>
        </div>
        
        <!-- Hero Image/Dashboard Preview -->
        <div class="mt-16 max-w-5xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl p-8 transform rotate-1 hover:rotate-0 transition-transform duration-300">
                <?php 
                $dashboard_image = get_theme_mod('hero_dashboard_image');
                $video_url = get_theme_mod('hero_video_url');
                if ($dashboard_image) : ?>
                    <div class="rounded-lg overflow-hidden relative group <?php echo $video_url ? 'cursor-pointer video-thumbnail' : ''; ?>" <?php if ($video_url) : ?>data-video-url="<?php echo esc_url($video_url); ?>"<?php endif; ?>>
                        <img src="<?php echo esc_url($dashboard_image); ?>" alt="<?php _e('Dashboard Preview', 'yoursite'); ?>" class="w-full h-96 object-cover">
                        <?php if ($video_url) : ?>
                        <!-- Play Button Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="video-play-button bg-white rounded-full p-4 shadow-lg hover:scale-110 transition-transform">
                                <svg class="w-12 h-12 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg h-96 flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg mx-auto mb-4"></div>
                            <p class="text-gray-600 dark:text-gray-300 font-medium"><?php _e('Dashboard Preview', 'yoursite'); ?></p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><?php _e('Beautiful, intuitive store builder', 'yoursite'); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Video Modal -->
<div id="video-modal" class="fixed inset-0 z-50 hidden" style="z-index: 9999;">
    <div class="absolute inset-0 bg-black bg-opacity-75"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="relative max-w-4xl w-full">
            <button id="close-video-modal" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors z-50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="bg-black rounded-lg shadow-2xl" style="padding-top: 56.25%; position: relative;">
                <iframe id="video-iframe" 
                        class="absolute top-0 left-0 w-full h-full rounded-lg" 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                        src="" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (get_theme_mod('social_proof_enable', true)) : ?>
<!-- Social Proof -->
<section class="bg-gray-50 dark:bg-gray-900 py-12">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <p class="text-gray-600 dark:text-gray-300 mb-8"><?php echo esc_html(get_theme_mod('social_proof_text', __('Trusted by over 10,000 merchants worldwide', 'yoursite'))); ?></p>
            <div class="flex justify-center items-center flex-wrap gap-8 opacity-60">
                <?php for ($i = 1; $i <= 5; $i++) : 
                    $logo = get_theme_mod("social_proof_logo_{$i}");
                    if ($logo) : ?>
                        <div class="w-24 h-12 flex items-center justify-center">
                            <img src="<?php echo esc_url($logo); ?>" alt="<?php printf(__('Partner Logo %d', 'yoursite'), $i); ?>" class="max-w-full max-h-full object-contain grayscale hover:grayscale-0 transition-all">
                        </div>
                    <?php else : ?>
                        <div class="w-24 h-12 bg-gray-300 dark:bg-gray-700 rounded flex items-center justify-center">
                            <span class="text-xs text-gray-500 dark:text-gray-400"><?php _e('Logo', 'yoursite'); ?></span>
                        </div>
                    <?php endif;
                endfor; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('benefits_enable', true)) : ?>
<!-- Key Benefits -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('benefits_title', __('Everything you need to sell online', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    <?php echo esc_html(get_theme_mod('benefits_subtitle', __('From store building to shipping, we\'ve got all the tools to help you succeed', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php 
                $benefit_icons = array(
                    'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                    'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                    'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                    'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'
                );
                
                // Default benefits data
                $default_benefits = array(
                    array(
                        'title' => __('Drag & Drop Builder', 'yoursite'),
                        'description' => __('Build your store with our intuitive drag & drop interface. No coding required.', 'yoursite'),
                        'color' => 'blue'
                    ),
                    array(
                        'title' => __('Secure Payments', 'yoursite'),
                        'description' => __('Accept payments safely with our secure checkout and multiple payment options.', 'yoursite'),
                        'color' => 'green'
                    ),
                    array(
                        'title' => __('Marketing & SEO', 'yoursite'),
                        'description' => __('Built-in marketing tools and SEO optimization to grow your business.', 'yoursite'),
                        'color' => 'purple'
                    ),
                    array(
                        'title' => __('Shipping Made Simple', 'yoursite'),
                        'description' => __('Manage inventory and shipping with automated tools and integrations.', 'yoursite'),
                        'color' => 'orange'
                    )
                );
                
                for ($i = 1; $i <= 4; $i++) : 
                    // Get custom values or use defaults
                    $title = get_theme_mod("benefit_{$i}_title", $default_benefits[$i-1]['title']);
                    $description = get_theme_mod("benefit_{$i}_description", $default_benefits[$i-1]['description']);
                    $color = get_theme_mod("benefit_{$i}_color", $default_benefits[$i-1]['color']);
                    $custom_image = get_theme_mod("benefit_{$i}_image");
                    ?>
                    <div class="text-center feature-card p-6 rounded-lg">
                        <div class="w-16 h-16 bg-<?php echo esc_attr($color); ?>-100 dark:bg-<?php echo esc_attr($color); ?>-900 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <?php if ($custom_image) : ?>
                                <img src="<?php echo esc_url($custom_image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-8 h-8 object-contain">
                            <?php else : ?>
                                <svg class="w-8 h-8 text-<?php echo esc_attr($color); ?>-600 dark:text-<?php echo esc_attr($color); ?>-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($benefit_icons[$i-1]); ?>"></path>
                                </svg>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white"><?php echo esc_html($title); ?></h3>
                        <p class="text-gray-600 dark:text-gray-300"><?php echo esc_html($description); ?></p>
                    </div>
                    <?php
                endfor; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('features_enable', true)) : ?>
<!-- Features Grid -->
<?php
$features_count = get_theme_mod('features_count', 6);
$features = get_features($features_count);
if ($features->have_posts()) :
?>
<section class="bg-gray-50 dark:bg-gray-900 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('features_title', __('Powerful features for every business', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('features_subtitle', __('Everything you need to create, customize, and grow your online store', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($features->have_posts()) : $features->the_post(); ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-8 feature-card border border-gray-200 dark:border-gray-700">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="mb-6">
                            <?php the_post_thumbnail('medium', array('class' => 'w-full h-48 object-cover rounded-lg')); ?>
                        </div>
                    <?php endif; ?>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white"><?php the_title(); ?></h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4"><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="text-blue-600 dark:text-blue-400 font-medium hover:text-blue-800 dark:hover:text-blue-300">
                        <?php _e('Learn More', 'yoursite'); ?> →
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="<?php echo home_url('/features'); ?>" class="btn-secondary"><?php _e('View All Features', 'yoursite'); ?></a>
            </div>
        </div>
    </div>
</section>
<?php
wp_reset_postdata();
endif;
?>
<?php endif; ?>

<?php
/**
 * Enhanced Dynamic Pricing Section for Homepage
 * Replace the pricing section in template-parts/homepage.php with this code
 */

if (get_theme_mod('pricing_enable', true)) : ?>
<!-- Dynamic Pricing Section -->
<?php
// Get pricing plans from your new pricing post type
$pricing_args = array(
    'post_type' => 'pricing',
    'posts_per_page' => get_theme_mod('homepage_pricing_count', 3), // Allow customization of how many to show
    'post_status' => 'publish',
    'meta_key' => '_pricing_monthly_price',
    'orderby' => 'meta_value_num',
    'order' => 'ASC'
);

// Option to show only featured plans on homepage
if (get_theme_mod('homepage_show_featured_only', false)) {
    $pricing_args['meta_query'] = array(
        array(
            'key' => '_pricing_featured',
            'value' => '1',
            'compare' => '='
        )
    );
}

$pricing_plans = get_posts($pricing_args);

if (!empty($pricing_plans)) :
?>
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('pricing_title', __('Simple, transparent pricing', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    <?php echo esc_html(get_theme_mod('pricing_subtitle', __('Choose the plan that\'s right for your business', 'yoursite'))); ?>
                </p>
            </div>
            
            <!-- Billing Toggle for Homepage -->
            <?php if (get_theme_mod('homepage_show_billing_toggle', true)) : ?>
            <div class="flex items-center justify-center mb-12">
                <span class="text-gray-700 dark:text-gray-300 mr-4 font-medium homepage-monthly-label">
                    <?php _e('Monthly', 'yoursite'); ?>
                </span>
                <div class="relative">
                    <input type="checkbox" id="homepage-billing-toggle" class="sr-only peer">
                    <label for="homepage-billing-toggle" class="relative inline-flex items-center justify-between w-16 h-8 bg-gray-200 dark:bg-gray-700 rounded-full cursor-pointer transition-colors duration-300 peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800">
                        <span class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 peer-checked:translate-x-8"></span>
                    </label>
                </div>
                <span class="text-gray-700 dark:text-gray-300 ml-4 font-medium homepage-yearly-label">
                    <?php _e('Annual', 'yoursite'); ?>
                </span>
                <span class="bg-emerald-500 text-emerald-50 dark:text-white text-sm font-semibold px-3 py-1 rounded-full ml-3 shadow-md">
                    <?php _e('Save 20%', 'yoursite'); ?>
                </span>
            </div>
            <?php endif; ?>
            
            <!-- Dynamic Pricing Cards -->
            <div class="grid md:grid-cols-2 lg:grid-cols-<?php echo min(count($pricing_plans), 4); ?> gap-8 homepage-pricing-grid">
                <?php 
                // Load pricing meta functions if not already loaded
                if (!function_exists('yoursite_get_pricing_meta_fields')) {
                    require_once get_template_directory() . '/inc/pricing-meta-boxes.php';
                }
                
                foreach ($pricing_plans as $plan) : 
                    $meta = yoursite_get_pricing_meta_fields($plan->ID);
                    $is_featured = $meta['pricing_featured'] === '1';
                    $monthly_price = floatval($meta['pricing_monthly_price']);
                    $annual_price = floatval($meta['pricing_annual_price']);
                    $currency_symbol = yoursite_get_currency_symbol($meta['pricing_currency']);
                    
                    // Calculate annual monthly equivalent if not set
                    if ($annual_price == 0 && $monthly_price > 0) {
                        $annual_price = $monthly_price * 12 * 0.8; // 20% discount
                    }
                    $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
                ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-8 border-2 border-gray-200 dark:border-gray-700 feature-card relative transition-all duration-300 hover:shadow-xl <?php echo $is_featured ? 'border-blue-500 dark:border-blue-400 shadow-lg scale-105' : ''; ?>">
                    
                    <!-- Featured Badge -->
                    <?php if ($is_featured) : ?>
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-10">
                            <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                <?php _e('Most Popular', 'yoursite'); ?>
                            </span>
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
                            <div class="homepage-monthly-pricing">
                                <span class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">
                                    <?php echo $currency_symbol . number_format($monthly_price, 0); ?>
                                </span>
                                <span class="text-gray-600 dark:text-gray-300 text-lg">
                                    /<?php _e('month', 'yoursite'); ?>
                                </span>
                            </div>
                            
                            <!-- Annual Pricing (Hidden by default) -->
                            <div class="homepage-annual-pricing hidden">
                                <span class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">
                                    <?php echo $currency_symbol . number_format($annual_monthly, 0); ?>
                                </span>
                                <span class="text-gray-600 dark:text-gray-300 text-lg">
                                    /<?php _e('month', 'yoursite'); ?>
                                </span>
                                <?php if ($annual_monthly > 0) : ?>
                                    <div class="text-sm text-green-600 dark:text-green-400 mt-1">
                                        <?php printf(__('Billed annually (%s)', 'yoursite'), $currency_symbol . number_format($annual_price, 0)); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Savings Badge (Annual) -->
                            <?php if ($monthly_price > 0 && $annual_price > 0) : ?>
                                <div class="homepage-annual-savings hidden mt-2">
                                    <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium">
                                        <?php printf(__('Save %s per year', 'yoursite'), $currency_symbol . number_format(($monthly_price * 12) - $annual_price, 0)); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Features List -->
                    <?php if (!empty($meta['pricing_features'])) : ?>
                    <div class="mb-8">
                        <ul class="space-y-3">
                            <?php 
                            $features = array_filter(explode("\n", $meta['pricing_features']));
                            $max_features = get_theme_mod('homepage_max_features', 5); // Limit features shown on homepage
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
                    <div class="text-center">
                        <a href="<?php echo esc_url($meta['pricing_button_url'] ?: home_url('/pricing')); ?>" 
   class="<?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?> w-full text-center block py-4 px-6 rounded-lg font-semibold text-lg transition-all duration-200 hover:transform hover:-translate-y-1" 
   <?php echo $is_featured ? 'style="color: #ffffff !important;"' : ''; ?>>
                            <?php echo esc_html($meta['pricing_button_text'] ?: __('Get Started', 'yoursite')); ?>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Bottom CTA -->
            <div class="text-center mt-12">
                <a href="<?php echo home_url('/pricing'); ?>" class="btn-secondary text-lg px-8 py-4">
                    <?php _e('View All Plans & Features', 'yoursite'); ?>
                </a>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-4">
                    <?php _e('All plans include a 14-day free trial. No credit card required.', 'yoursite'); ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Homepage Pricing JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const homepageBillingToggle = document.getElementById('homepage-billing-toggle');
    const homepagePricingGrid = document.querySelector('.homepage-pricing-grid');
    
    if (homepageBillingToggle && homepagePricingGrid) {
        homepageBillingToggle.addEventListener('change', function() {
            const isYearly = this.checked;
            
            // Update toggle labels
            updateToggleLabels(isYearly);
            
            // Update pricing display
            updatePricingDisplay(isYearly);
            
            // Sync with other toggles on the page
            syncOtherToggles(isYearly);
        });
    }
    
    function updateToggleLabels(isYearly) {
        const monthlyLabel = document.querySelector('.homepage-monthly-label');
        const yearlyLabel = document.querySelector('.homepage-yearly-label');
        
        if (monthlyLabel && yearlyLabel) {
            if (isYearly) {
                monthlyLabel.style.color = '#9ca3af';
                monthlyLabel.style.fontWeight = '400';
                yearlyLabel.style.color = '#3b82f6';
                yearlyLabel.style.fontWeight = '600';
            } else {
                monthlyLabel.style.color = '#3b82f6';
                monthlyLabel.style.fontWeight = '600';
                yearlyLabel.style.color = '#9ca3af';
                yearlyLabel.style.fontWeight = '400';
            }
        }
    }
    
    function updatePricingDisplay(isYearly) {
        const monthlyPricing = document.querySelectorAll('.homepage-monthly-pricing');
        const annualPricing = document.querySelectorAll('.homepage-annual-pricing');
        const annualSavings = document.querySelectorAll('.homepage-annual-savings');
        
        monthlyPricing.forEach(element => {
            element.style.display = isYearly ? 'none' : 'block';
        });
        
        annualPricing.forEach(element => {
            element.style.display = isYearly ? 'block' : 'none';
        });
        
        annualSavings.forEach(element => {
            element.style.display = isYearly ? 'block' : 'none';
        });
    }
    
    function syncOtherToggles(isYearly) {
        // Sync with main pricing page toggle if it exists
        const mainBillingToggle = document.getElementById('billing-toggle');
        if (mainBillingToggle) {
            mainBillingToggle.checked = isYearly;
            // Trigger change event to update main pricing page
            mainBillingToggle.dispatchEvent(new Event('change'));
        }
        
        // Sync with comparison table toggle if it exists
        const comparisonToggle = document.getElementById('comparison-billing-toggle');
        if (comparisonToggle) {
            comparisonToggle.checked = isYearly;
            comparisonToggle.dispatchEvent(new Event('change'));
        }
    }
    
    // Listen for changes from other toggles
    document.addEventListener('change', function(e) {
        if (e.target.id === 'billing-toggle' || e.target.id === 'comparison-billing-toggle') {
            if (homepageBillingToggle && homepageBillingToggle !== e.target) {
                homepageBillingToggle.checked = e.target.checked;
                updateToggleLabels(e.target.checked);
                updatePricingDisplay(e.target.checked);
            }
        }
    });
});
</script>

<!-- Homepage Pricing Styles -->
<style>
/* Homepage pricing specific styles */
.homepage-pricing-grid .feature-card {
    transition: all 0.3s ease;
}

.homepage-pricing-grid .feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

/* Featured plan always slightly elevated */
.homepage-pricing-grid .feature-card.scale-105 {
    transform: scale(1.05);
}

.homepage-pricing-grid .feature-card.scale-105:hover {
    transform: scale(1.05) translateY(-4px);
}

/* Dark mode adjustments */
.dark .homepage-monthly-label,
.dark .homepage-yearly-label {
    color: #d1d5db;
}

/* Responsive grid adjustments */
@media (max-width: 768px) {
    .homepage-pricing-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .homepage-pricing-grid .feature-card.scale-105 {
        transform: none;
    }
    
    .homepage-pricing-grid .feature-card:hover {
        transform: translateY(-2px);
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .homepage-pricing-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Animation for price switching */
.homepage-monthly-pricing,
.homepage-annual-pricing,
.homepage-annual-savings {
    transition: all 0.3s ease;
}

/* Enhanced billing toggle styling */
#homepage-billing-toggle:checked + label {
    background-color: #3b82f6;
}

#homepage-billing-toggle:focus + label {
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.3);
}

/* Grid responsive classes */
.lg\:grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
.lg\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
</style>

<?php
wp_reset_postdata();
else :
    // Fallback content if no pricing plans exist
    ?>
    <section class="py-20 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('pricing_title', __('Simple, transparent pricing', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                    <?php _e('Choose the plan that works best for your business', 'yoursite'); ?>
                </p>
                <a href="<?php echo home_url('/pricing'); ?>" class="btn-primary text-lg px-8 py-4">
                    <?php _e('View Our Pricing Plans', 'yoursite'); ?>
                </a>
            </div>
        </div>
    </section>
    <?php
endif;
?>
<?php endif; ?>

<?php if (get_theme_mod('testimonials_enable', true)) : ?>
<!-- Testimonials -->
<?php
$testimonials_count = get_theme_mod('testimonials_count', 3);
$testimonials = get_testimonials($testimonials_count);
if ($testimonials->have_posts()) :
?>
<section class="bg-gray-50 dark:bg-gray-900 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('testimonials_title', __('Loved by thousands of merchants', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('testimonials_subtitle', __('See what our customers have to say about their success', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-8 feature-card border border-gray-200 dark:border-gray-700">
                    <div class="mb-6">
                        <div class="flex text-yellow-400 mb-4">
                            <?php for ($i = 0; $i < 5; $i++) : ?>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <blockquote class="text-gray-700 dark:text-gray-300 mb-4">
                            "<?php the_content(); ?>"
                        </blockquote>
                    </div>
                    
                    <div class="flex items-center">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="mr-4">
                                <?php the_post_thumbnail('thumbnail', array('class' => 'w-12 h-12 rounded-full object-cover')); ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <div class="font-semibold text-gray-900 dark:text-white"><?php the_title(); ?></div>
                            <div class="text-gray-600 dark:text-gray-400 text-sm"><?php the_excerpt(); ?></div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>
<?php
wp_reset_postdata();
endif;
?>
<?php endif; ?>

<?php if (get_theme_mod('final_cta_enable', true)) : ?>
<!-- Final CTA Section -->
<section class="hero-gradient text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-5xl font-bold mb-6">
                <?php echo esc_html(get_theme_mod('final_cta_title', __('Ready to launch your store?', 'yoursite'))); ?>
            </h2>
            <p class="text-xl mb-8 opacity-90">
                <?php echo esc_html(get_theme_mod('final_cta_subtitle', __('Start free today—no credit card required. Join thousands of successful merchants.', 'yoursite'))); ?>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="<?php echo esc_url(get_theme_mod('final_cta_primary_url', '#')); ?>" class="btn-primary text-lg px-8 py-4 bg-white hover:bg-gray-100" style="color: #7c3aed !important;">
                    <?php echo esc_html(get_theme_mod('final_cta_primary_text', __('Start Free Trial', 'yoursite'))); ?>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('final_cta_secondary_url', '/contact')); ?>" class="btn-secondary text-lg px-8 py-4 border-white text-white hover:bg-white" style="hover:color: #7c3aed !important;">
                    <?php echo esc_html(get_theme_mod('final_cta_secondary_text', __('Book a Demo', 'yoursite'))); ?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
// ==========================================================================
// YOUTUBE MODAL - FIXED JAVASCRIPT
// ==========================================================================

document.addEventListener('DOMContentLoaded', function() {
    const videoModal = document.getElementById('video-modal');
    const videoIframe = document.getElementById('video-iframe');
    const closeButton = document.getElementById('close-video-modal');
    const videoThumbnail = document.querySelector('.video-thumbnail');
    
    // Debug logging
    console.log('Modal elements found:', {
        videoModal: !!videoModal,
        videoIframe: !!videoIframe,
        closeButton: !!closeButton,
        videoThumbnail: !!videoThumbnail
    });
    
    if (videoThumbnail && videoModal) {
        // Make the entire thumbnail clickable
        videoThumbnail.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const videoUrl = this.getAttribute('data-video-url');
            console.log('Video URL:', videoUrl);
            
            if (videoUrl && videoIframe) {
                openVideoModal(videoUrl);
            }
        });
    }
    
    function openVideoModal(videoUrl) {
        // Convert YouTube URL to privacy-enhanced embed format
        let embedUrl = convertToEmbedUrl(videoUrl);
        console.log('Embed URL:', embedUrl);
        
        if (embedUrl) {
            // Set loading state
            videoModal.classList.add('loading');
            
            // Set iframe source
            videoIframe.src = embedUrl;
            
            // Show modal
            videoModal.classList.remove('hidden');
            videoModal.classList.add('active');
            document.body.classList.add('modal-open');
            document.body.style.overflow = 'hidden';
            
            // Remove loading state after iframe loads
            videoIframe.onload = function() {
                videoModal.classList.remove('loading');
            };
            
            // Focus close button for accessibility
            if (closeButton) {
                setTimeout(() => closeButton.focus(), 100);
            }
        }
    }
    
    function closeVideoModal() {
        console.log('Closing modal');
        
        if (videoModal && !videoModal.classList.contains('hidden')) {
            // Hide modal
            videoModal.classList.add('hidden');
            videoModal.classList.remove('active', 'loading');
            
            // Clear iframe source to stop video
            if (videoIframe) {
                videoIframe.src = '';
            }
            
            // Restore body scroll
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            
            // Return focus to thumbnail for accessibility
            if (videoThumbnail) {
                videoThumbnail.focus();
            }
        }
    }
    
    function convertToEmbedUrl(url) {
        if (!url) return null;
        
        let videoId = null;
        
        // Extract video ID from different YouTube URL formats
        if (url.includes('youtube.com/watch?v=')) {
            videoId = url.split('v=')[1].split('&')[0];
        } else if (url.includes('youtu.be/')) {
            videoId = url.split('youtu.be/')[1].split('?')[0];
        } else if (url.includes('youtube.com/embed/')) {
            videoId = url.split('embed/')[1].split('?')[0];
        } else if (url.includes('youtube-nocookie.com/embed/')) {
            videoId = url.split('embed/')[1].split('?')[0];
        }
        
        if (videoId) {
            // Create privacy-enhanced embed URL with autoplay
            return `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1&showinfo=0`;
        }
        
        return null;
    }
    
    // Event listeners for closing modal
    if (closeButton) {
        closeButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeVideoModal();
        });
    }
    
    // Close when clicking on backdrop
    if (videoModal) {
        videoModal.addEventListener('click', function(e) {
            // Only close if clicking on the modal backdrop, not the content
            if (e.target === videoModal || e.target.classList.contains('bg-black')) {
                closeVideoModal();
            }
        });
    }
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && videoModal && videoModal.classList.contains('active')) {
            closeVideoModal();
        }
    });
    
    // Handle window resize to maintain modal positioning
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (videoModal && videoModal.classList.contains('active')) {
                // Force modal to recalculate positioning
                videoModal.style.display = 'none';
                videoModal.offsetHeight; // Force reflow
                videoModal.style.display = 'flex';
            }
        }, 100);
    });
});
</script>
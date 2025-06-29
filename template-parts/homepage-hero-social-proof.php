<?php
/**
 * Template part for homepage - Hero & Social Proof sections
 * Part 1 of 3 - Fully Dynamic Version
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
                    <?php 
                    $trust_badge = get_theme_mod('hero_trust_badge', __('Trusted by 50,000+ merchants', 'yoursite'));
                    if (!empty($trust_badge)) :
                    ?>
                    <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium text-white/90 mb-6 border border-white/20">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <?php echo esc_html($trust_badge); ?>
                    </div>
                    <?php endif; ?>

                    <!-- Main Headline -->
                    <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                        <?php echo esc_html(get_theme_mod('hero_title', __('Launch Your Online Store in Minutes', 'yoursite'))); ?>
                        <?php 
                        $highlight_text = get_theme_mod('hero_highlight', __('Not Hours', 'yoursite'));
                        if (!empty($highlight_text)) :
                        ?>
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-400">
                            <?php echo esc_html($highlight_text); ?>
                        </span>
                        <?php endif; ?>
                    </h1>

                    <!-- Value Proposition -->
                    <?php 
                    $hero_subtitle = get_theme_mod('hero_subtitle', __('The easiest way to build, launch, and scale your e-commerce business. No coding required, results guaranteed.', 'yoursite'));
                    if (!empty($hero_subtitle)) :
                    ?>
                    <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        <?php echo esc_html($hero_subtitle); ?>
                    </p>
                    <?php endif; ?>

                    <!-- Key Benefits Pills -->
                    <div class="flex flex-wrap gap-3 justify-center lg:justify-start mb-8">
                        <?php 
                        for ($i = 1; $i <= 3; $i++) {
                            $benefit = get_theme_mod("hero_benefit_{$i}", '');
                            if (!empty(trim($benefit))) :
                        ?>
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium text-white border border-white/30">
                                <?php echo esc_html($benefit); ?>
                            </span>
                        <?php 
                            endif;
                        }
                        ?>
                    </div>

                    <!-- Primary CTA -->
                    <div class="space-y-4 lg:space-y-0 lg:space-x-4 lg:flex lg:items-center">
                        <!-- Main CTA Button -->
                        <?php 
                        $primary_text = get_theme_mod('cta_primary_text', __('Start Your Free Store', 'yoursite'));
                        $primary_url = get_theme_mod('cta_primary_url', '#signup');
                        if (!empty($primary_text)) :
                        ?>
                        <a href="<?php echo esc_url($primary_url); ?>" 
                           class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-900 font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 w-full lg:w-auto">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <?php echo esc_html($primary_text); ?>
                            <svg class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <?php endif; ?>

                        <!-- Secondary CTA -->
                        <?php 
                        $secondary_text = get_theme_mod('cta_secondary_text', __('Watch Demo', 'yoursite'));
                        $secondary_url = get_theme_mod('cta_secondary_url', '#demo');
                        if (!empty($secondary_text)) :
                        ?>
                        <a href="<?php echo esc_url($secondary_url); ?>" 
                           class="group inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white/40 hover:border-white/80 text-white font-semibold text-lg rounded-xl hover:bg-white/10 transition-all duration-200 w-full lg:w-auto">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <?php echo esc_html($secondary_text); ?>
                        </a>
                        <?php endif; ?>
                    </div>

                    <!-- Risk Reversal -->
                    <?php 
                    $risk_reversal = get_theme_mod('hero_risk_reversal', __('Cancel anytime. 30-day money-back guarantee.', 'yoursite'));
                    if (!empty($risk_reversal)) :
                    ?>
                    <p class="text-white/70 text-sm mt-4">
                        <?php echo esc_html($risk_reversal); ?>
                    </p>
                    <?php endif; ?>
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
            <?php 
            $social_proof_text = get_theme_mod('social_proof_text', __('Trusted by 50,000+ merchants in 180+ countries', 'yoursite'));
            if (!empty($social_proof_text)) :
            ?>
            <p class="text-gray-600 dark:text-gray-300 text-sm font-medium mb-6">
                <?php echo esc_html($social_proof_text); ?>
            </p>
            <?php endif; ?>
            
            <!-- Customer Logos -->
            <div class="flex items-center justify-center space-x-8 opacity-60 hover:opacity-80 transition-opacity duration-300">
                <?php 
                $has_logos = false;
                for ($i = 1; $i <= 5; $i++) : 
                    $logo = get_theme_mod("social_proof_logo_{$i}");
                    if ($logo) :
                        $has_logos = true;
                ?>
                        <div class="h-8 flex items-center">
                            <img src="<?php echo esc_url($logo); ?>" 
                                 alt="<?php printf(__('Customer Logo %d', 'yoursite'), $i); ?>" 
                                 class="max-h-full max-w-24 object-contain grayscale hover:grayscale-0 transition-all duration-300">
                        </div>
                    <?php 
                    endif;
                endfor; 
                
                // Show placeholder logos if no logos are uploaded
                if (!$has_logos) :
                    for ($i = 1; $i <= 5; $i++) :
                ?>
                        <div class="h-8 w-24 bg-gray-300 dark:bg-gray-600 rounded opacity-50"></div>
                    <?php 
                    endfor;
                endif;
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Problem/Solution Section -->
<?php if (get_theme_mod('problem_section_enable', true)) : ?>
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
                        <?php _e('Before: Traditional Platforms', 'yoursite'); ?>
                    </h3>
                    <ul class="space-y-3 text-left">
                        <?php 
                        for ($i = 1; $i <= 3; $i++) {
                            $before_item = get_theme_mod("problem_before_{$i}", '');
                            if (!empty($before_item)) :
                        ?>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span class="text-red-800 dark:text-red-300"><?php echo esc_html($before_item); ?></span>
                        </li>
                        <?php 
                            endif;
                        }
                        ?>
                    </ul>
                </div>

                <!-- After -->
                <div class="bg-green-50 dark:bg-green-900/20 rounded-2xl p-8 border border-green-200 dark:border-green-800">
                    <h3 class="text-xl font-bold text-green-900 dark:text-green-300 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?php _e('After: Our Platform', 'yoursite'); ?>
                    </h3>
                    <ul class="space-y-3 text-left">
                        <?php 
                        for ($i = 1; $i <= 3; $i++) {
                            $after_item = get_theme_mod("problem_after_{$i}", '');
                            if (!empty($after_item)) :
                        ?>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-green-800 dark:text-green-300"><?php echo esc_html($after_item); ?></span>
                        </li>
                        <?php 
                            endif;
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
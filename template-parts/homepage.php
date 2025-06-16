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

<style>
/* Ensure primary button text is always visible */
.btn-primary {
    color: #7c3aed !important; /* Purple color for light mode */
}
.dark .btn-primary {
    color: #6d28d9 !important; /* Darker purple for dark mode */
}

/* Final CTA buttons */
.hero-gradient .btn-primary {
    color: #7c3aed !important;
}
.dark .hero-gradient .btn-primary {
    color: #6d28d9 !important;
}
.hero-gradient .btn-secondary:hover {
    color: #7c3aed !important;
}
.dark .hero-gradient .btn-secondary:hover {
    color: #6d28d9 !important;
}

/* Video Modal Styles */
#video-modal {
    display: none;
}
#video-modal.active {
    display: block !important;
}
#video-modal .video-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    background: #000;
    border-radius: 0.5rem;
}
#video-modal iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoModal = document.getElementById('video-modal');
    const videoIframe = document.getElementById('video-iframe');
    const closeButton = document.getElementById('close-video-modal');
    const videoThumbnail = document.querySelector('.video-thumbnail');
    
    if (videoThumbnail && videoModal) {
        // Make the entire thumbnail clickable
        videoThumbnail.addEventListener('click', function(e) {
            e.preventDefault();
            const videoUrl = this.getAttribute('data-video-url');
            if (videoUrl && videoIframe) {
                // Convert YouTube URL to privacy-enhanced embed format
                let embedUrl = videoUrl;
                if (videoUrl.includes('youtube.com/watch?v=')) {
                    const videoId = videoUrl.split('v=')[1].split('&')[0];
                    embedUrl = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0`;
                } else if (videoUrl.includes('youtu.be/')) {
                    const videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
                    embedUrl = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0`;
                } else if (videoUrl.includes('youtube.com/embed/')) {
                    // Already an embed URL, convert to privacy-enhanced
                    embedUrl = videoUrl.replace('youtube.com', 'youtube-nocookie.com');
                    if (!embedUrl.includes('?')) {
                        embedUrl += '?autoplay=1&rel=0';
                    }
                }
                
                videoIframe.src = embedUrl;
                videoModal.classList.remove('hidden');
                videoModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    }
    
    function closeModal() {
        if (videoModal && !videoModal.classList.contains('hidden')) {
            videoModal.classList.add('hidden');
            videoModal.classList.remove('active');
            if (videoIframe) {
                videoIframe.src = '';
            }
            document.body.style.overflow = '';
        }
    }
    
    if (closeButton) {
        closeButton.addEventListener('click', closeModal);
    }
    
    // Close when clicking outside the video
    if (videoModal) {
        videoModal.addEventListener('click', function(e) {
            // Check if clicked on backdrop (first child) or the modal itself
            if (e.target === videoModal || e.target === videoModal.querySelector('.absolute.inset-0.bg-black')) {
                closeModal();
            }
        });
    }
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && videoModal && videoModal.classList.contains('active')) {
            closeModal();
        }
    });
});
</script>
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
                
                for ($i = 1; $i <= 4; $i++) : 
                    $title = get_theme_mod("benefit_{$i}_title");
                    $description = get_theme_mod("benefit_{$i}_description");
                    $color = get_theme_mod("benefit_{$i}_color", 'blue');
                    $custom_image = get_theme_mod("benefit_{$i}_image");
                    
                    if ($title || $description) : ?>
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
                            <?php if ($title) : ?>
                                <h3 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white"><?php echo esc_html($title); ?></h3>
                            <?php endif; ?>
                            <?php if ($description) : ?>
                                <p class="text-gray-600 dark:text-gray-300"><?php echo esc_html($description); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif;
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

<?php if (get_theme_mod('pricing_enable', true)) : ?>
<!-- Pricing Section -->
<?php
$pricing_plans = get_pricing_plans();
if ($pricing_plans->have_posts()) :
?>
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('pricing_title', __('Simple, transparent pricing', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('pricing_subtitle', __('Choose the plan that\'s right for your business', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php while ($pricing_plans->have_posts()) : $pricing_plans->the_post(); 
                    $price = get_post_meta(get_the_ID(), '_pricing_price', true);
                    $period = get_post_meta(get_the_ID(), '_pricing_period', true);
                    $features = get_post_meta(get_the_ID(), '_pricing_features', true);
                    $featured = get_post_meta(get_the_ID(), '_pricing_featured', true);
                    $purchase_url = get_post_meta(get_the_ID(), '_pricing_purchase_url', true) ?: '#';
                    $button_text = get_post_meta(get_the_ID(), '_pricing_button_text', true) ?: __('Get Started', 'yoursite');
                ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-8 border-2 border-gray-200 dark:border-gray-700 feature-card relative <?php echo $featured ? 'border-blue-500 dark:border-blue-400 shadow-lg' : ''; ?>">
                    <?php if ($featured) : ?>
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-medium"><?php _e('Most Popular', 'yoursite'); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white"><?php the_title(); ?></h3>
                        <div class="mb-4">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">$<?php echo number_format($price, 2); ?></span>
                            <span class="text-gray-600 dark:text-gray-300">/ <?php echo esc_html($period); ?></span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300"><?php the_excerpt(); ?></p>
                    </div>
                    
                    <?php if ($features) : ?>
                    <div class="mb-8">
                        <ul class="space-y-3">
                            <?php 
                            $feature_list = explode("\n", $features);
                            foreach ($feature_list as $feature) :
                                if (trim($feature)) :
                            ?>
                            <li class="flex items-center text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <?php echo esc_html(trim($feature)); ?>
                            </li>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <a href="<?php echo esc_url($purchase_url); ?>" class="<?php echo $featured ? 'btn-primary' : 'btn-secondary'; ?> w-full text-center block" <?php echo $featured ? 'style="color: #7c3aed !important;"' : ''; ?>>
                        <?php echo esc_html($button_text); ?>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="<?php echo home_url('/pricing'); ?>" class="btn-secondary"><?php _e('View Full Pricing', 'yoursite'); ?></a>
            </div>
        </div>
    </div>
</section>
<?php
wp_reset_postdata();
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
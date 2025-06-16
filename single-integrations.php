<?php
/**
 * Template for single integration posts - RESPONSIVE FIXED VERSION
 */

get_header(); ?>

<div class="min-h-screen bg-gray-50">
    <?php while (have_posts()) : the_post(); 
        // Get integration meta data
        $integration_icon = get_post_meta(get_the_ID(), '_integration_icon', true);
        $integration_color = get_post_meta(get_the_ID(), '_integration_color', true) ?: 'blue';
        $integration_website = get_post_meta(get_the_ID(), '_integration_website', true);
        $integration_setup_url = get_post_meta(get_the_ID(), '_integration_setup_url', true);
        $integration_status = get_post_meta(get_the_ID(), '_integration_status', true) ?: 'available';
        $integration_popularity = get_post_meta(get_the_ID(), '_integration_popularity', true) ?: '4.5';
        $integration_features = get_post_meta(get_the_ID(), '_integration_features', true);
        $integration_countries = get_post_meta(get_the_ID(), '_integration_countries', true);
        $integration_pricing = get_post_meta(get_the_ID(), '_integration_pricing', true);
        
        // Get category
        $categories = get_the_terms(get_the_ID(), 'integration_category');
        $category = $categories ? $categories[0] : null;
    ?>
    
    <!-- Hero Section -->
    <section class="bg-white py-8 md:py-16 border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-6 md:mb-8">
                    <div class="flex items-center space-x-2 text-sm text-gray-600 overflow-x-auto">
                        <a href="/" class="hover:text-blue-600 whitespace-nowrap">Home</a>
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="/integrations" class="hover:text-blue-600 whitespace-nowrap">Integrations</a>
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-900 truncate"><?php the_title(); ?></span>
                    </div>
                </nav>

                <div class="flex flex-col xl:flex-row gap-6 lg:gap-8 items-start">
                    <!-- Left Column - Main Info -->
                    <div class="flex-1 w-full">
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-start mb-6">
                            <!-- Integration Icon -->
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-<?php echo $integration_color; ?>-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="font-bold text-<?php echo $integration_color; ?>-600 text-lg sm:text-xl">
                                    <?php echo $integration_icon ?: substr(get_the_title(), 0, 2); ?>
                                </span>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-2">
                                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 break-words"><?php the_title(); ?></h1>
                                    
                                    <!-- Status Badge -->
                                    <?php if ($integration_status === 'available') : ?>
                                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium self-start">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Available
                                        </span>
                                    <?php elseif ($integration_status === 'coming_soon') : ?>
                                        <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium self-start">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            Coming Soon
                                        </span>
                                    <?php elseif ($integration_status === 'beta') : ?>
                                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium self-start">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                            </svg>
                                            Beta
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Category & Rating -->
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-sm text-gray-600">
                                    <?php if ($category) : ?>
                                        <span class="bg-gray-100 px-2 py-1 rounded text-xs font-medium self-start">
                                            <?php echo $category->name; ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($integration_popularity) : ?>
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                    <svg class="w-4 h-4 <?php echo $i <= floatval($integration_popularity) ? 'text-yellow-400' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="ml-1 font-medium"><?php echo $integration_popularity; ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Short Description -->
                        <?php if (has_excerpt()) : ?>
                            <p class="text-lg sm:text-xl text-gray-600 mb-6 leading-relaxed"><?php the_excerpt(); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Right Column - Actions (Mobile: Full width, Desktop: Fixed width) -->
                    <div class="w-full xl:w-80 xl:flex-shrink-0">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <?php if ($integration_status === 'available') : ?>
                                <button class="btn-primary w-full text-base sm:text-lg py-3 mb-4 rounded-lg font-semibold">
                                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Install Integration
                                </button>
                            <?php elseif ($integration_status === 'coming_soon') : ?>
                                <button class="btn-secondary w-full text-base sm:text-lg py-3 mb-4 rounded-lg font-semibold" disabled>
                                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Coming Soon
                                </button>
                            <?php endif; ?>
                            
                            <div class="space-y-3 text-sm">
                                <?php if ($integration_website) : ?>
                                    <a href="<?php echo esc_url($integration_website); ?>" target="_blank" class="action-link flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors text-gray-900 dark:text-white">
                                        <span class="action-link-content flex items-center min-w-0">
                                            <svg class="action-link-icon w-4 h-4 mr-2 text-gray-500 dark:text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            <span class="action-link-text truncate">Visit Website</span>
                                        </span>
                                        <svg class="action-link-arrow w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($integration_setup_url) : ?>
                                    <a href="<?php echo esc_url($integration_setup_url); ?>" target="_blank" class="action-link flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors text-gray-900 dark:text-white">
                                        <span class="action-link-content flex items-center min-w-0">
                                            <svg class="action-link-icon w-4 h-4 mr-2 text-gray-500 dark:text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="action-link-text truncate">Setup Guide</span>
                                        </span>
                                        <svg class="action-link-arrow w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Quick Info -->
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Quick Info</h4>
                                <div class="space-y-2 text-sm">
                                    <?php if ($integration_countries) : ?>
                                        <div class="quick-info-item flex flex-col sm:flex-row sm:justify-between gap-1">
                                            <span class="text-gray-600 dark:text-gray-300">Availability:</span>
                                            <span class="quick-info-value font-medium break-words text-gray-900 dark:text-white"><?php echo esc_html($integration_countries); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($integration_pricing) : ?>
                                        <div class="quick-info-item flex flex-col sm:flex-row sm:justify-between gap-1">
                                            <span class="text-gray-600 dark:text-gray-300">Pricing:</span>
                                            <span class="quick-info-value font-medium break-words text-gray-900 dark:text-white"><?php echo esc_html($integration_pricing); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-8 md:py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                    <!-- Content Column -->
                    <div class="lg:col-span-2 space-y-6 lg:space-y-8">
                        <!-- Main Description -->
                        <div class="integration-content-card bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 lg:p-8 shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="integration-prose prose prose-sm sm:prose-base lg:prose-lg max-w-none dark:prose-invert">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                        <!-- Features -->
                        <?php if ($integration_features) : ?>
                            <div class="integration-content-card bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 lg:p-8 shadow-sm border border-gray-200 dark:border-gray-700">
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Key Features</h3>
                                <div class="features-list grid gap-3 sm:gap-4">
                                    <?php 
                                    $features = explode("\n", $integration_features);
                                    foreach ($features as $feature) : 
                                        $feature = trim($feature);
                                        if (!empty($feature)) :
                                    ?>
                                        <div class="feature-item flex items-start">
                                            <svg class="feature-icon w-5 h-5 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="feature-text text-gray-700 dark:text-gray-300 text-sm sm:text-base break-words"><?php echo esc_html($feature); ?></span>
                                        </div>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Sidebar -->
                    <div class="space-y-4 sm:space-y-6">
                        <!-- Support -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Need Help?</h4>
                            <div class="space-y-3">
                                <a href="/contact" class="support-link flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors text-sm text-gray-900 dark:text-white">
                                    <svg class="support-link-icon w-4 h-4 mr-2 text-gray-500 dark:text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <span class="support-link-text truncate">Contact Support</span>
                                </a>
                                <a href="/api" class="support-link flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors text-sm text-gray-900 dark:text-white">
                                    <svg class="support-link-icon w-4 h-4 mr-2 text-gray-500 dark:text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                    <span class="support-link-text truncate">API Documentation</span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Related Integrations -->
                        <?php if ($category) : 
                            $related = get_posts(array(
                                'post_type' => 'integrations',
                                'posts_per_page' => 3,
                                'post__not_in' => array(get_the_ID()),
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'integration_category',
                                        'field' => 'term_id',
                                        'terms' => $category->term_id
                                    )
                                )
                            ));
                            
                            if ($related) :
                        ?>
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Related Integrations</h4>
                                <div class="related-integrations-list space-y-3">
                                    <?php foreach ($related as $related_post) : 
                                        $related_icon = get_post_meta($related_post->ID, '_integration_icon', true);
                                        $related_color = get_post_meta($related_post->ID, '_integration_color', true) ?: 'blue';
                                    ?>
                                        <a href="<?php echo get_permalink($related_post->ID); ?>" class="related-integration-item flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                            <div class="related-integration-icon w-8 h-8 bg-<?php echo $related_color; ?>-100 dark:bg-<?php echo $related_color; ?>-900 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                                <span class="font-bold text-<?php echo $related_color; ?>-600 dark:text-<?php echo $related_color; ?>-300 text-xs">
                                                    <?php echo $related_icon ?: substr($related_post->post_title, 0, 2); ?>
                                                </span>
                                            </div>
                                            <div class="related-integration-content flex-1 min-w-0">
                                                <div class="related-integration-title font-medium text-gray-900 dark:text-white truncate text-sm"><?php echo $related_post->post_title; ?></div>
                                                <div class="related-integration-excerpt text-xs text-gray-500 dark:text-gray-400 truncate"><?php echo wp_trim_words(get_the_excerpt($related_post->ID), 8); ?></div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php 
                            endif;
                        endif; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
<?php
/**
 * Template for single integration posts
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
    <section class="bg-white py-16 border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <a href="/" class="hover:text-blue-600">Home</a>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="/integrations" class="hover:text-blue-600">Integrations</a>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-900"><?php the_title(); ?></span>
                    </div>
                </nav>

                <div class="flex flex-col lg:flex-row gap-8 items-start">
                    <!-- Left Column - Main Info -->
                    <div class="flex-1">
                        <div class="flex items-center mb-6">
                            <!-- Integration Icon -->
                            <div class="w-16 h-16 bg-<?php echo $integration_color; ?>-100 rounded-xl flex items-center justify-center mr-6 flex-shrink-0">
                                <span class="font-bold text-<?php echo $integration_color; ?>-600 text-xl">
                                    <?php echo $integration_icon ?: substr(get_the_title(), 0, 2); ?>
                                </span>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900"><?php the_title(); ?></h1>
                                    
                                    <!-- Status Badge -->
                                    <?php if ($integration_status === 'available') : ?>
                                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Available
                                        </span>
                                    <?php elseif ($integration_status === 'coming_soon') : ?>
                                        <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            Coming Soon
                                        </span>
                                    <?php elseif ($integration_status === 'beta') : ?>
                                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                            </svg>
                                            Beta
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Category & Rating -->
                                <div class="flex items-center gap-4 text-sm text-gray-600">
                                    <?php if ($category) : ?>
                                        <span class="bg-gray-100 px-2 py-1 rounded text-xs font-medium">
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
                            <p class="text-xl text-gray-600 mb-6 leading-relaxed"><?php the_excerpt(); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Right Column - Actions -->
                    <div class="lg:w-80 w-full">
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                            <?php if ($integration_status === 'available') : ?>
                                <button class="btn-primary w-full text-lg py-3 mb-4 rounded-lg font-semibold">
                                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Install Integration
                                </button>
                            <?php elseif ($integration_status === 'coming_soon') : ?>
                                <button class="btn-secondary w-full text-lg py-3 mb-4 rounded-lg font-semibold" disabled>
                                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Coming Soon
                                </button>
                            <?php endif; ?>
                            
                            <div class="space-y-3 text-sm">
                                <?php if ($integration_website) : ?>
                                    <a href="<?php echo esc_url($integration_website); ?>" target="_blank" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            Visit Website
                                        </span>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($integration_setup_url) : ?>
                                    <a href="<?php echo esc_url($integration_setup_url); ?>" target="_blank" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Setup Guide
                                        </span>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Quick Info -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h4 class="font-semibold text-gray-900 mb-3">Quick Info</h4>
                                <div class="space-y-2 text-sm">
                                    <?php if ($integration_countries) : ?>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Availability:</span>
                                            <span class="font-medium"><?php echo esc_html($integration_countries); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($integration_pricing) : ?>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Pricing:</span>
                                            <span class="font-medium"><?php echo esc_html($integration_pricing); ?></span>
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
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Content Column -->
                    <div class="lg:col-span-2">
                        <!-- Main Description -->
                        <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200 mb-8">
                            <div class="prose prose-lg max-w-none">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                        <!-- Features -->
                        <?php if ($integration_features) : ?>
                            <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Key Features</h3>
                                <div class="grid gap-4">
                                    <?php 
                                    $features = explode("\n", $integration_features);
                                    foreach ($features as $feature) : 
                                        $feature = trim($feature);
                                        if (!empty($feature)) :
                                    ?>
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-gray-700"><?php echo esc_html($feature); ?></span>
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
                    <div class="space-y-6">
                        <!-- Support -->
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-4">Need Help?</h4>
                            <div class="space-y-3">
                                <a href="/contact" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-sm">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Contact Support
                                </a>
                                <a href="/api" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-sm">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                    API Documentation
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
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                                <h4 class="font-semibold text-gray-900 mb-4">Related Integrations</h4>
                                <div class="space-y-3">
                                    <?php foreach ($related as $related_post) : 
                                        $related_icon = get_post_meta($related_post->ID, '_integration_icon', true);
                                        $related_color = get_post_meta($related_post->ID, '_integration_color', true) ?: 'blue';
                                    ?>
                                        <a href="<?php echo get_permalink($related_post->ID); ?>" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                            <div class="w-8 h-8 bg-<?php echo $related_color; ?>-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                                <span class="font-bold text-<?php echo $related_color; ?>-600 text-xs">
                                                    <?php echo $related_icon ?: substr($related_post->post_title, 0, 2); ?>
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-gray-900 truncate"><?php echo $related_post->post_title; ?></div>
                                                <div class="text-xs text-gray-500 truncate"><?php echo get_the_excerpt($related_post->ID); ?></div>
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
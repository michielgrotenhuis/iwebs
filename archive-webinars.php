<?php
/**
 * Archive template for webinars
 */

get_header(); ?>

<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">All Webinars</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">Explore our complete collection of expert-led webinars covering eCommerce strategies, marketing tactics, and business growth.</p>
    </div>

    <?php if (have_posts()) : ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while (have_posts()) : the_post(); 
                // Get webinar meta data
                $webinar_date = get_post_meta(get_the_ID(), '_webinar_date', true);
                $webinar_time = get_post_meta(get_the_ID(), '_webinar_time', true);
                $webinar_timezone = get_post_meta(get_the_ID(), '_webinar_timezone', true);
                $webinar_speaker = get_post_meta(get_the_ID(), '_webinar_speaker', true);
                $webinar_status = get_post_meta(get_the_ID(), '_webinar_status', true);
                $webinar_price = get_post_meta(get_the_ID(), '_webinar_price', true);
            ?>
                <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="aspect-video bg-gray-200">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover')); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <!-- Status Badge -->
                        <?php if ($webinar_status === 'live') : ?>
                            <div class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold mb-3">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                LIVE NOW
                            </div>
                        <?php elseif ($webinar_status === 'upcoming') : ?>
                            <div class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold mb-3">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                UPCOMING
                            </div>
                        <?php elseif ($webinar_status === 'completed') : ?>
                            <div class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold mb-3">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a1 1 0 001 1h4M9 10V9a1 1 0 011-1h4a1 1 0 011 1v1M12 5l0 0"></path>
                                </svg>
                                RECORDED
                            </div>
                        <?php endif; ?>
                        
                        <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                            <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        
                        <?php if (has_excerpt()) : ?>
                            <p class="text-gray-600 mb-4 line-clamp-3"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        <?php endif; ?>
                        
                        <!-- Webinar Details -->
                        <div class="space-y-2 mb-4 text-sm text-gray-500">
                            <?php if ($webinar_date && $webinar_time) : ?>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <?php echo date('M j, Y', strtotime($webinar_date)) . ' at ' . $webinar_time . ' ' . $webinar_timezone; ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($webinar_speaker) : ?>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <?php echo esc_html($webinar_speaker); ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($webinar_price) : ?>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                <?php echo esc_html($webinar_price); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="btn-primary w-full text-center py-3 rounded-lg font-semibold transition-all">
                            <?php if ($webinar_status === 'upcoming') : ?>
                                Register Now
                            <?php elseif ($webinar_status === 'completed') : ?>
                                Watch Recording
                            <?php elseif ($webinar_status === 'live') : ?>
                                Join Live
                            <?php else : ?>
                                Learn More
                            <?php endif; ?>
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        
        <!-- Pagination -->
        <?php if (function_exists('the_posts_pagination')) : ?>
            <div class="mt-12">
                <?php the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('&larr; Previous', 'yoursite'),
                    'next_text' => __('Next &rarr;', 'yoursite'),
                    'class' => 'pagination-wrapper'
                )); ?>
            </div>
        <?php endif; ?>
        
    <?php else : ?>
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No webinars found</h3>
                <p class="text-gray-600 mb-6">We're working on scheduling exciting new webinars. Check back soon!</p>
                <a href="/contact" class="btn-primary px-6 py-3 rounded-lg font-semibold">Contact Us</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
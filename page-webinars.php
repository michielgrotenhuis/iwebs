<?php
/**
 * Template Name: Webinars Page
 */

get_header();

// Get current filter
$filter = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : 'all';

// Custom query for webinars
$webinars_query = get_webinars($filter);

// If no webinars exist, we'll show sample data
$has_webinars = $webinars_query->have_posts();
?>

<div class="webinars-page bg-gray-50 min-h-screen">
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 via-purple-600 to-blue-800 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl lg:text-6xl font-bold mb-6">
                    Expert Webinars
                </h1>
                <p class="text-xl lg:text-2xl mb-8 opacity-90">
                    Learn from industry experts and grow your eCommerce business with our exclusive webinar series
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="#upcoming" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors duration-200 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        View Upcoming Webinars
                    </a>
                    <a href="#register" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-blue-600 transition-all duration-200 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h8a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Register for Updates
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Tabs -->
    <section class="bg-white py-8 border-b border-gray-200 sticky top-16 z-40">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-wrap justify-center gap-2">
                    <a href="<?php echo get_permalink(); ?>" 
                       class="webinar-filter <?php echo $filter === 'all' ? 'active' : ''; ?> px-6 py-3 rounded-full font-medium transition-all duration-200">
                        All Webinars
                    </a>
                    <a href="<?php echo add_query_arg('filter', 'upcoming', get_permalink()); ?>" 
                       class="webinar-filter <?php echo $filter === 'upcoming' ? 'active' : ''; ?> px-6 py-3 rounded-full font-medium transition-all duration-200">
                        Upcoming
                    </a>
                    <a href="<?php echo add_query_arg('filter', 'past', get_permalink()); ?>" 
                       class="webinar-filter <?php echo $filter === 'past' ? 'active' : ''; ?> px-6 py-3 rounded-full font-medium transition-all duration-200">
                        Past Webinars
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Webinars Section -->
    <section class="py-16" id="webinars">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <?php if ($webinars_query && $webinars_query->have_posts()) : ?>
                    
                    <!-- Dynamic Webinars -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <?php while ($webinars_query->have_posts()) : $webinars_query->the_post(); 
                            $webinar_date = get_post_meta(get_the_ID(), '_webinar_date', true);
                            $webinar_time = get_post_meta(get_the_ID(), '_webinar_time', true);
                            $webinar_timezone = get_post_meta(get_the_ID(), '_webinar_timezone', true);
                            $webinar_duration = get_post_meta(get_the_ID(), '_webinar_duration', true);
                            $webinar_speaker = get_post_meta(get_the_ID(), '_webinar_speaker', true);
                            $webinar_register_url = get_post_meta(get_the_ID(), '_webinar_register_url', true);
                            $webinar_recording_url = get_post_meta(get_the_ID(), '_webinar_recording_url', true);
                            $webinar_status = get_post_meta(get_the_ID(), '_webinar_status', true);
                            $webinar_price = get_post_meta(get_the_ID(), '_webinar_price', true);
                            
                            $is_past = ($webinar_status === 'completed');
                            $is_live = ($webinar_status === 'live');
                        ?>
                            <div class="webinar-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="webinar-thumbnail relative">
                                        <?php the_post_thumbnail('large', array('class' => 'w-full h-48 object-cover')); ?>
                                        <div class="absolute top-4 right-4">
                                            <?php if ($is_live) : ?>
                                                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium animate-pulse">
                                                    🔴 Live Now
                                                </span>
                                            <?php elseif ($is_past) : ?>
                                                <span class="bg-gray-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                    Recorded
                                                </span>
                                            <?php else : ?>
                                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                    Upcoming
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="p-6">
                                    <!-- Date & Time -->
                                    <div class="flex items-center text-sm text-gray-600 mb-4">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <?php if ($webinar_date) echo date('F j, Y', strtotime($webinar_date)); ?>
                                        <?php if ($webinar_time) : ?>
                                            <span class="mx-2">•</span>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <?php echo $webinar_time; ?>
                                            <?php if ($webinar_timezone) echo ' ' . $webinar_timezone; ?>
                                        <?php endif; ?>
                                        <?php if ($webinar_duration) : ?>
                                            <span class="mx-2">•</span>
                                            <?php echo $webinar_duration; ?>
                                        <?php endif; ?>
                                        <?php if ($webinar_price && $webinar_price !== 'Free') : ?>
                                            <span class="mx-2">•</span>
                                            <span class="text-green-600 font-medium"><?php echo esc_html($webinar_price); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Title -->
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                        <?php the_title(); ?>
                                    </h3>
                                    
                                    <!-- Excerpt -->
                                    <div class="text-gray-600 mb-4">
                                        <?php echo wp_trim_words(get_the_excerpt() ? get_the_excerpt() : get_the_content(), 20); ?>
                                    </div>
                                    
                                    <!-- Speaker -->
                                    <?php if ($webinar_speaker) : ?>
                                        <div class="flex items-center text-sm text-gray-600 mb-6">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Speaker: <strong><?php echo esc_html($webinar_speaker); ?></strong>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- CTA Button -->
                                    <div class="flex space-x-3">
                                        <?php if ($is_live && $webinar_register_url) : ?>
                                            <a href="<?php echo esc_url($webinar_register_url); ?>" 
                                               class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors duration-200 inline-flex items-center flex-1 justify-center animate-pulse">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                Join Live Now
                                            </a>
                                        <?php elseif ($is_past && $webinar_recording_url) : ?>
                                            <a href="<?php echo esc_url($webinar_recording_url); ?>" 
                                               class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200 inline-flex items-center flex-1 justify-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1"></path>
                                                </svg>
                                                Watch Recording
                                            </a>
                                        <?php elseif (!$is_past && $webinar_register_url) : ?>
                                            <a href="<?php echo esc_url($webinar_register_url); ?>" 
                                               class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-200 inline-flex items-center flex-1 justify-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h8a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                Register Now
                                            </a>
                                        <?php else : ?>
                                            <a href="<?php the_permalink(); ?>" 
                                               class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors duration-200 inline-flex items-center flex-1 justify-center">
                                                Learn More
                                            </a>
                                        <?php endif; ?>
                                        
                                        <a href="<?php the_permalink(); ?>" 
                                           class="border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:border-gray-400 hover:text-gray-900 transition-colors duration-200 inline-flex items-center justify-center">
                                            Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    
                <?php else : ?>
                    
                    <!-- Sample Webinars -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Upcoming Webinar 1 -->
                        <div class="webinar-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                            <div class="webinar-thumbnail relative bg-gradient-to-br from-blue-500 to-purple-600 h-48 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <h4 class="text-xl font-semibold">Live Webinar</h4>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        Upcoming
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-600 mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?php echo date('F j, Y', strtotime('+7 days')); ?>
                                    <span class="mx-2">•</span>
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    2:00 PM EST
                                    <span class="mx-2">•</span>
                                    60 min
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                    eCommerce Success Strategies for 2025
                                </h3>
                                
                                <div class="text-gray-600 mb-4">
                                    Learn the latest trends and strategies that will help your online store thrive in 2025. Discover proven techniques for increasing conversions and customer retention.
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600 mb-6">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Speaker: <strong>Sarah Johnson, eCommerce Expert</strong>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <a href="#register" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-200 inline-flex items-center flex-1 justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h8a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Register Now
                                    </a>
                                    <a href="#details" class="border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:border-gray-400 hover:text-gray-900 transition-colors duration-200 inline-flex items-center justify-center">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Upcoming Webinar 2 -->
                        <div class="webinar-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                            <div class="webinar-thumbnail relative bg-gradient-to-br from-purple-500 to-pink-600 h-48 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <h4 class="text-xl font-semibold">Marketing Masterclass</h4>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        Upcoming
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-600 mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?php echo date('F j, Y', strtotime('+14 days')); ?>
                                    <span class="mx-2">•</span>
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    3:00 PM EST
                                    <span class="mx-2">•</span>
                                    90 min
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                    Digital Marketing That Actually Works
                                </h3>
                                
                                <div class="text-gray-600 mb-4">
                                    Stop wasting money on marketing that doesn't convert. Learn data-driven strategies that generate real ROI and sustainable growth for your business.
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600 mb-6">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Speaker: <strong>Mike Chen, Growth Strategist</strong>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <a href="#register" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-200 inline-flex items-center flex-1 justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h8a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Register Now
                                    </a>
                                    <a href="#details" class="border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:border-gray-400 hover:text-gray-900 transition-colors duration-200 inline-flex items-center justify-center">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Past Webinar -->
                        <div class="webinar-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                            <div class="webinar-thumbnail relative bg-gradient-to-br from-gray-500 to-gray-700 h-48 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1"></path>
                                    </svg>
                                    <h4 class="text-xl font-semibold">Recorded Session</h4>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <span class="bg-gray-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        Recorded
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-600 mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?php echo date('F j, Y', strtotime('-14 days')); ?>
                                    <span class="mx-2">•</span>
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    45 min recording
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                    Building Customer Loyalty in eCommerce
                                </h3>
                                
                                <div class="text-gray-600 mb-4">
                                    Learn proven strategies to turn one-time buyers into loyal customers. Discover how successful brands build lasting relationships that drive repeat sales.
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600 mb-6">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Speaker: <strong>Lisa Rodriguez, CX Specialist</strong>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <a href="#watch" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200 inline-flex items-center flex-1 justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1"></path>
                                        </svg>
                                        Watch Recording
                                    </a>
                                    <a href="#details" class="border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:border-gray-400 hover:text-gray-900 transition-colors duration-200 inline-flex items-center justify-center">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Past Webinar 2 -->
                        <div class="webinar-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                            <div class="webinar-thumbnail relative bg-gradient-to-br from-indigo-500 to-blue-600 h-48 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <h4 class="text-xl font-semibold">Power Session</h4>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <span class="bg-gray-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        Recorded
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-600 mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?php echo date('F j, Y', strtotime('-30 days')); ?>
                                    <span class="mx-2">•</span>
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    75 min recording
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                    Scaling Your Online Store to 7 Figures
                                </h3>
                                
                                <div class="text-gray-600 mb-4">
                                    From startup to success - learn the exact strategies and systems used by 7-figure eCommerce businesses to scale efficiently and sustainably.
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600 mb-6">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Speaker: <strong>David Kim, Scaling Expert</strong>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <a href="#watch" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200 inline-flex items-center flex-1 justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1"></path>
                                        </svg>
                                        Watch Recording
                                    </a>
                                    <a href="#details" class="border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:border-gray-400 hover:text-gray-900 transition-colors duration-200 inline-flex items-center justify-center">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                <?php endif; ?>
                
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Attend Our Webinars?</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Join thousands of successful entrepreneurs who have transformed their businesses through our expert-led sessions
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Expert Knowledge</h3>
                        <p class="text-gray-600">Learn from industry leaders with proven track records</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Live Interaction</h3>
                        <p class="text-gray-600">Ask questions and get real-time answers from experts</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Actionable Insights</h3>
                        <p class="text-gray-600">Get practical strategies you can implement immediately</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0l1.5 14A2 2 0 005.5 20h13a2 2 0 002-1.986L22 4H2"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Free Resources</h3>
                        <p class="text-gray-600">Download templates, checklists, and guides</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="bg-gray-900 text-white py-16" id="register">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-4">Never Miss a Webinar</h2>
                <p class="text-xl text-gray-300 mb-8">Get notified about upcoming webinars and receive exclusive resources</p>
                
                <form class="webinar-newsletter-form max-w-md mx-auto flex mb-6" data-nonce="<?php echo wp_create_nonce('newsletter_nonce'); ?>">
                    <input type="email" 
                           name="email" 
                           placeholder="Enter your email" 
                           required
                           class="flex-1 px-4 py-3 rounded-l-lg border-0 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-3 rounded-r-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                        Subscribe
                    </button>
                </form>
                
                <div class="webinar-newsletter-message hidden"></div>
                
                <p class="text-sm text-gray-400">
                    Join 25,000+ entrepreneurs getting our weekly insights. Unsubscribe anytime.
                </p>
            </div>
        </div>
    </section>

   <!-- FAQ Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Quick answers to common questions about our platform</p>
            </div>
            
            <div class="space-y-4">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left p-6 hover:bg-gray-50 transition-colors faq-toggle" data-target="faq-1">
                        <h3 class="text-lg font-semibold text-gray-900 pr-4">How quickly can I get my store online?</h3>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq-1" class="faq-content hidden border-t border-gray-100">
                        <div class="p-6 pt-4">
                            <p class="text-gray-600 leading-relaxed">Most merchants can set up their store and start selling within minutes using our templates and drag-and-drop builder. For custom designs, it may take a few hours to get everything exactly how you want it. Our quick-start wizard guides you through the essential steps to get your store live fast.</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left p-6 hover:bg-gray-50 transition-colors faq-toggle" data-target="faq-2">
                        <h3 class="text-lg font-semibold text-gray-900 pr-4">What payment methods do you support?</h3>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq-2" class="faq-content hidden border-t border-gray-100">
                        <div class="p-6 pt-4">
                            <p class="text-gray-600 leading-relaxed">We support all major credit cards (Visa, Mastercard, American Express, Discover), PayPal, Apple Pay, Google Pay, Shop Pay, and many other payment methods. Our platform integrates seamlessly with leading payment processors like Stripe, Square, and PayPal, ensuring secure and reliable transactions for your customers.</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left p-6 hover:bg-gray-50 transition-colors faq-toggle" data-target="faq-3">
                        <h3 class="text-lg font-semibold text-gray-900 pr-4">Do you offer customer support?</h3>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq-3" class="faq-content hidden border-t border-gray-100">
                        <div class="p-6 pt-4">
                            <p class="text-gray-600 leading-relaxed">Yes! We provide comprehensive support including 24/7 live chat support, email support with guaranteed 24-hour response times, phone support during business hours (9 AM - 6 PM EST), and an extensive help center with step-by-step tutorials, video guides, and detailed documentation.</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left p-6 hover:bg-gray-50 transition-colors faq-toggle" data-target="faq-4">
                        <h3 class="text-lg font-semibold text-gray-900 pr-4">Can I migrate my existing store?</h3>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq-4" class="faq-content hidden border-t border-gray-100">
                        <div class="p-6 pt-4">
                            <p class="text-gray-600 leading-relaxed">Absolutely! We offer free migration services to help you seamlessly transfer your products, customers, order history, and other important data from platforms like Shopify, WooCommerce, Magento, BigCommerce, and others. Our dedicated migration team handles all the technical details, ensuring zero downtime and data integrity throughout the process.</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left p-6 hover:bg-gray-50 transition-colors faq-toggle" data-target="faq-5">
                        <h3 class="text-lg font-semibold text-gray-900 pr-4">What's included in the free trial?</h3>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq-5" class="faq-content hidden border-t border-gray-100">
                        <div class="p-6 pt-4">
                            <p class="text-gray-600 leading-relaxed">Our 14-day free trial includes access to all premium features, unlimited products, all premium templates and themes, full customer support, payment processing capabilities, and all integrations. No credit card required to start, and you can upgrade, downgrade, or cancel anytime with no hidden fees or commitments.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left p-6 hover:bg-gray-50 transition-colors faq-toggle" data-target="faq-6">
                        <h3 class="text-lg font-semibold text-gray-900 pr-4">Are there any transaction fees?</h3>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq-6" class="faq-content hidden border-t border-gray-100">
                        <div class="p-6 pt-4">
                            <p class="text-gray-600 leading-relaxed">We don't charge any transaction fees on top of your monthly subscription. You'll only pay the standard payment processing fees charged by your payment provider (typically 2.9% + 30¢ per transaction for Stripe). This means more money stays in your pocket compared to platforms that charge additional transaction fees.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left p-6 hover:bg-gray-50 transition-colors faq-toggle" data-target="faq-7">
                        <h3 class="text-lg font-semibold text-gray-900 pr-4">Can I use my own domain name?</h3>
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq-7" class="faq-content hidden border-t border-gray-100">
                        <div class="p-6 pt-4">
                            <p class="text-gray-600 leading-relaxed">Yes! You can connect your existing domain or purchase a new one through our platform. We provide free SSL certificates for all custom domains, and our team can help you with the setup process. If you don't have a domain yet, we also provide free subdomains to get you started (e.g., yourstore.ourplatform.com).</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Still have questions CTA -->
            <div class="text-center mt-12 p-8 bg-white rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Still have questions?</h3>
                <p class="text-gray-600 mb-6">Our support team is here to help you get started</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/contact" class="btn-primary inline-flex items-center justify-center px-6 py-3 rounded-lg font-semibold transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Contact Support
                    </a>
                    <a href="/webinars" class="btn-secondary inline-flex items-center justify-center px-6 py-3 rounded-lg font-semibold transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Join a Webinar
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqToggles = document.querySelectorAll('.faq-toggle');
    
    faqToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetContent = document.getElementById(targetId);
            const icon = this.querySelector('svg');
            
            // Close all other FAQ items
            faqToggles.forEach(otherToggle => {
                if (otherToggle !== this) {
                    const otherTargetId = otherToggle.getAttribute('data-target');
                    const otherContent = document.getElementById(otherTargetId);
                    const otherIcon = otherToggle.querySelector('svg');
                    
                    otherContent.classList.add('hidden');
                    otherIcon.style.transform = 'rotate(0deg)';
                }
            });
            
            // Toggle current FAQ item
            if (targetContent.classList.contains('hidden')) {
                targetContent.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                targetContent.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });
});
</script>

<style>
/* Webinars page specific styles */
.webinar-filter {
    border: 2px solid #e5e7eb;
    color: #6b7280;
    background: white;
    text-decoration: none;
}

.webinar-filter:hover {
    border-color: #3b82f6;
    color: #3b82f6;
    background: #eff6ff;
    text-decoration: none;
}

.webinar-filter.active {
    border-color: #1d4ed8;
    background: #1d4ed8;
    color: white;
    text-decoration: none;
}

.webinar-card {
    transition: all 0.3s ease;
}

.webinar-card:hover {
    transform: translateY(-2px);
}

.webinar-thumbnail {
    background-size: cover;
    background-position: center;
}

/* Newsletter form */
.webinar-newsletter-form input:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* FAQ hover effects */
.faq-item {
    transition: all 0.2s ease;
}

.faq-item:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Admin bar adjustment */
.sticky {
    top: 64px;
}

body.admin-bar .sticky {
    top: 96px;
}

@media screen and (max-width: 782px) {
    body.admin-bar .sticky {
        top: 110px;
    }
}

/* Button animations */
.webinar-card a {
    position: relative;
    overflow: hidden;
}

.webinar-card a:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.3s ease, height 0.3s ease;
}

.webinar-card a:hover:before {
    width: 300px;
    height: 300px;
}
</style>

<script>
// Newsletter signup functionality
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.querySelector('.webinar-newsletter-form');
    const messageDiv = document.querySelector('.webinar-newsletter-message');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'newsletter_signup');
            formData.append('nonce', this.dataset.nonce);
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Subscribing...';
            submitBtn.disabled = true;
            
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                messageDiv.classList.remove('hidden');
                
                if (data.success) {
                    messageDiv.className = 'webinar-newsletter-message text-green-400 mb-4';
                    messageDiv.textContent = data.data;
                    newsletterForm.reset();
                } else {
                    messageDiv.className = 'webinar-newsletter-message text-red-400 mb-4';
                    messageDiv.textContent = data.data;
                }
            })
            .catch(error => {
                messageDiv.classList.remove('hidden');
                messageDiv.className = 'webinar-newsletter-message text-red-400 mb-4';
                messageDiv.textContent = 'An error occurred. Please try again.';
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
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
});
</script>

<?php
get_footer();
?>
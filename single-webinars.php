<?php
/**
 * Template for single webinar posts
 */

get_header(); ?>

<div class="container mx-auto px-4 py-8">
    <?php while (have_posts()) : the_post(); 
        // Get webinar meta data
        $webinar_date = get_post_meta(get_the_ID(), '_webinar_date', true);
        $webinar_time = get_post_meta(get_the_ID(), '_webinar_time', true);
        $webinar_timezone = get_post_meta(get_the_ID(), '_webinar_timezone', true);
        $webinar_duration = get_post_meta(get_the_ID(), '_webinar_duration', true);
        $webinar_speaker = get_post_meta(get_the_ID(), '_webinar_speaker', true);
        $webinar_speaker_bio = get_post_meta(get_the_ID(), '_webinar_speaker_bio', true);
        $webinar_register_url = get_post_meta(get_the_ID(), '_webinar_register_url', true);
        $webinar_recording_url = get_post_meta(get_the_ID(), '_webinar_recording_url', true);
        $webinar_price = get_post_meta(get_the_ID(), '_webinar_price', true);
        $webinar_status = get_post_meta(get_the_ID(), '_webinar_status', true);
        $webinar_platform = get_post_meta(get_the_ID(), '_webinar_platform', true);
    ?>
    
    <article class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <?php if ($webinar_status === 'live') : ?>
                <div class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-full text-sm font-semibold mb-4">
                    <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                    LIVE NOW
                </div>
            <?php elseif ($webinar_status === 'upcoming') : ?>
                <div class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-full text-sm font-semibold mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    UPCOMING
                </div>
            <?php elseif ($webinar_status === 'completed') : ?>
                <div class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    RECORDED
                </div>
            <?php endif; ?>
            
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6"><?php the_title(); ?></h1>
            
            <?php if (has_excerpt()) : ?>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto"><?php the_excerpt(); ?></p>
            <?php endif; ?>
        </div>

        <!-- Webinar Info Cards -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Date & Time Card -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Date & Time
                </h3>
                <?php if ($webinar_date) : ?>
                    <p class="text-gray-700 mb-2">
                        <strong>Date:</strong> <?php echo date('F j, Y', strtotime($webinar_date)); ?>
                    </p>
                <?php endif; ?>
                <?php if ($webinar_time && $webinar_timezone) : ?>
                    <p class="text-gray-700 mb-2">
                        <strong>Time:</strong> <?php echo esc_html($webinar_time . ' ' . $webinar_timezone); ?>
                    </p>
                <?php endif; ?>
                <?php if ($webinar_duration) : ?>
                    <p class="text-gray-700">
                        <strong>Duration:</strong> <?php echo esc_html($webinar_duration); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Speaker Card -->
            <?php if ($webinar_speaker) : ?>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Speaker
                </h3>
                <p class="text-gray-900 font-semibold mb-2"><?php echo esc_html($webinar_speaker); ?></p>
                <?php if ($webinar_speaker_bio) : ?>
                    <p class="text-gray-600 text-sm"><?php echo esc_html($webinar_speaker_bio); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mb-12">
            <?php if ($webinar_status === 'upcoming' && $webinar_register_url) : ?>
                <a href="<?php echo esc_url($webinar_register_url); ?>" class="btn-primary text-lg px-8 py-4 rounded-lg font-semibold mr-4 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Register for Free
                </a>
            <?php elseif ($webinar_status === 'completed' && $webinar_recording_url) : ?>
                <a href="<?php echo esc_url($webinar_recording_url); ?>" class="btn-primary text-lg px-8 py-4 rounded-lg font-semibold mr-4 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a1 1 0 001 1h4M9 10V9a1 1 0 011-1h4a1 1 0 011 1v1M12 5l0 0"></path>
                    </svg>
                    Watch Recording
                </a>
            <?php elseif ($webinar_status === 'live' && $webinar_register_url) : ?>
                <a href="<?php echo esc_url($webinar_register_url); ?>" class="btn-primary text-lg px-8 py-4 rounded-lg font-semibold mr-4 inline-flex items-center bg-red-600 hover:bg-red-700">
                    <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                    Join Live Now
                </a>
            <?php endif; ?>
            
            <a href="/webinars" class="btn-secondary text-lg px-6 py-4 rounded-lg font-semibold inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                All Webinars
            </a>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-200 mb-12">
            <div class="prose prose-lg max-w-none">
                <?php the_content(); ?>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="grid md:grid-cols-3 gap-6 text-center">
            <?php if ($webinar_price) : ?>
            <div class="bg-green-50 p-6 rounded-lg">
                <div class="text-green-600 text-2xl font-bold mb-2"><?php echo esc_html($webinar_price); ?></div>
                <div class="text-green-700 font-medium">Investment</div>
            </div>
            <?php endif; ?>
            
            <?php if ($webinar_platform) : ?>
            <div class="bg-blue-50 p-6 rounded-lg">
                <div class="text-blue-600 text-2xl font-bold mb-2"><?php echo esc_html(ucfirst($webinar_platform)); ?></div>
                <div class="text-blue-700 font-medium">Platform</div>
            </div>
            <?php endif; ?>
            
            <div class="bg-purple-50 p-6 rounded-lg">
                <div class="text-purple-600 text-2xl font-bold mb-2">Q&A</div>
                <div class="text-purple-700 font-medium">Live Questions</div>
            </div>
        </div>

    </article>
    
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
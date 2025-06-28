<?php
/**
 * Archive template for feature pages
 * File: archive-feature_pages.php
 */

get_header(); ?>

<style>
.feature-archive-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.feature-archive-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}
.feature-category-filter {
    background: #f3f4f6;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
    cursor: pointer;
}
.feature-category-filter:hover {
    background: #e5e7eb;
}
.feature-category-filter.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}
</style>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                <?php echo esc_html(get_theme_mod('features_archive_title', __('Powerful Features', 'yoursite'))); ?>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                <?php echo esc_html(get_theme_mod('features_archive_description', __('Discover all the tools and capabilities that make our platform the perfect choice for your business growth.', 'yoursite'))); ?>
            </p>
            
            <?php 
            // Count total features
            $feature_count = wp_count_posts('feature_pages');
            if ($feature_count && $feature_count->publish > 0) :
            ?>
                <div class="inline-block bg-white rounded-full px-6 py-3 text-gray-700 font-semibold">
                    <span class="text-blue-600 font-bold"><?php echo $feature_count->publish; ?></span> powerful features available
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Breadcrumbs -->
<nav class="breadcrumbs py-4 bg-gray-50">
    <div class="container mx-auto px-4">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="<?php echo home_url(); ?>" class="hover:text-blue-600">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900">Features</li>
        </ol>
    </div>
</nav>

<!-- Features Grid -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            
            <?php if (have_posts()) : ?>
                
                <!-- Search and Filter Bar -->
                <div class="mb-12">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex-1">
                            <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="relative max-w-md">
                                <input type="search" 
                                       name="s" 
                                       value="<?php echo get_search_query(); ?>"
                                       placeholder="Search features..."
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <input type="hidden" name="post_type" value="feature_pages">
                                <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </form>
                        </div>
                        
                        <div class="text-sm text-gray-600">
                            Showing <?php echo $wp_query->post_count; ?> of <?php echo $wp_query->found_posts; ?> features
                        </div>
                    </div>
                </div>
                
                <!-- Features Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
                        $capabilities = get_post_meta(get_the_ID(), '_feature_capabilities', true);
                        $capability_count = is_array($capabilities) ? count($capabilities) : 0;
                        $hero_bg_type = get_post_meta(get_the_ID(), '_feature_hero_bg_type', true);
                        $case_study_enabled = get_post_meta(get_the_ID(), '_feature_case_study_enable', true);
                        ?>
                        
                        <article class="feature-archive-card bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="aspect-w-16 aspect-h-9">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('large', array('class' => 'w-full h-48 object-cover')); ?>
                                    </a>
                                </div>
                            <?php else : ?>
                                <!-- Fallback gradient background -->
                                <div class="h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                    <h3 class="text-white text-xl font-semibold text-center px-4">
                                        <?php the_title(); ?>
                                    </h3>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-2">
                                        <?php if ($hero_bg_type) : ?>
                                            <span class="inline-block w-3 h-3 rounded-full <?php 
                                                echo $hero_bg_type === 'gradient' ? 'bg-blue-400' : 
                                                    ($hero_bg_type === 'image' ? 'bg-green-400' : 'bg-yellow-400'); 
                                            ?>"></span>
                                        <?php endif; ?>
                                        
                                        <?php if ($case_study_enabled) : ?>
                                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full font-medium">
                                                Case Study
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($capability_count > 0) : ?>
                                        <span class="text-xs text-gray-500">
                                            <?php echo $capability_count; ?> capabilities
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <h2 class="text-xl font-semibold text-gray-900 mb-3 hover:text-blue-600 transition-colors">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                
                                <?php if (has_excerpt()) : ?>
                                    <p class="text-gray-600 mb-4 text-sm">
                                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                    </p>
                                <?php else : ?>
                                    <p class="text-gray-600 mb-4 text-sm">
                                        <?php echo wp_trim_words(get_the_content(), 15); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <!-- Quick preview of capabilities -->
                                <?php if (!empty($capabilities) && is_array($capabilities)) : ?>
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Key Features:</h4>
                                        <ul class="text-xs text-gray-600 space-y-1">
                                            <?php 
                                            $preview_capabilities = array_slice($capabilities, 0, 3);
                                            foreach ($preview_capabilities as $capability) :
                                                if (!empty($capability['title'])) :
                                            ?>
                                                <li class="flex items-center">
                                                    <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span><?php echo esc_html($capability['title']); ?></span>
                                                </li>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            
                                            if (count($capabilities) > 3) :
                                            ?>
                                                <li class="text-blue-600">
                                                    + <?php echo count($capabilities) - 3; ?> more features
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="flex items-center justify-between">
                                    <a href="<?php the_permalink(); ?>" class="text-blue-600 font-medium hover:text-blue-700 transition-colors text-sm">
                                        Learn more →
                                    </a>
                                    <time class="text-xs text-gray-400" datetime="<?php echo get_the_date('c'); ?>">
                                        Updated <?php echo get_the_modified_date('M j, Y'); ?>
                                    </time>
                                </div>
                            </div>
                        </article>
                        
                    <?php endwhile; ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($wp_query->max_num_pages > 1) : ?>
                    <div class="mt-16">
                        <nav class="flex justify-center">
                            <?php
                            echo paginate_links(array(
                                'total' => $wp_query->max_num_pages,
                                'current' => max(1, get_query_var('paged')),
                                'format' => '?paged=%#%',
                                'show_all' => false,
                                'end_size' => 1,
                                'mid_size' => 2,
                                'prev_next' => true,
                                'prev_text' => __('← Previous', 'yoursite'),
                                'next_text' => __('Next →', 'yoursite'),
                                'type' => 'list',
                                'add_args' => false,
                                'add_fragment' => '',
                                'before_page_number' => '',
                                'after_page_number' => ''
                            ));
                            ?>
                        </nav>
                    </div>
                <?php endif; ?>
                
            <?php else : ?>
                
                <!-- No Features Found -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.529.94-6.071 2.611l-.54.54c-.3.3-.678.47-1.089.47H3a1 1 0 01-1-1v-1.5c0-.621.504-1.125 1.125-1.125H4.5c.621 0 1.125-.504 1.125-1.125V12c0-7.069 5.931-13 13-13s13 5.931 13 13c0 2.39-.814 4.587-2.18 6.344z"></path>
                        </svg>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">No features found</h2>
                        <p class="text-gray-600 mb-6">
                            <?php if (is_search()) : ?>
                                We couldn't find any features matching "<strong><?php echo get_search_query(); ?></strong>". Try a different search term.
                            <?php else : ?>
                                No feature pages have been published yet. Check back soon!
                            <?php endif; ?>
                        </p>
                        
                        <?php if (is_search()) : ?>
                            <a href="<?php echo get_post_type_archive_link('feature_pages'); ?>" class="btn-primary">
                                View All Features
                            </a>
                        <?php else : ?>
                            <a href="<?php echo home_url(); ?>" class="btn-primary">
                                Back to Home
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-4xl font-bold mb-6">
                <?php echo esc_html(get_theme_mod('features_archive_cta_title', __('Ready to unlock these features?', 'yoursite'))); ?>
            </h2>
            <p class="text-xl mb-8 opacity-90">
                <?php echo esc_html(get_theme_mod('features_archive_cta_description', __('Join thousands of businesses already using our platform to grow their revenue and streamline operations.', 'yoursite'))); ?>
            </p>
            <div class="space-x-4">
                <a href="<?php echo home_url('/pricing'); ?>" class="inline-block bg-white text-blue-600 font-semibold px-8 py-4 rounded-lg text-lg hover:bg-gray-100 transition-colors">
                    View Pricing Plans
                </a>
                <a href="<?php echo home_url('/demo'); ?>" class="inline-block border-2 border-white text-white font-semibold px-8 py-4 rounded-lg text-lg hover:bg-white hover:text-blue-600 transition-colors">
                    Request Demo
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
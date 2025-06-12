<?php
/**
 * Template for displaying guide category archives
 * Save as: taxonomy-guide_category.php
 */

get_header();

$current_term = get_queried_object();
$term_slug = $current_term->slug;

// Get search parameters
$search_params = yoursite_sanitize_guide_search_params($_GET);
$search_params['category'] = $term_slug; // Force current category

// Build query args
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$guides_query = new WP_Query(yoursite_build_guide_query_args($search_params, 12));

// Get related categories
$all_categories = get_terms(array(
    'taxonomy' => 'guide_category',
    'hide_empty' => false,
    'exclude' => array($current_term->term_id),
    'orderby' => 'name',
    'order' => 'ASC'
));

// Define category icons and colors
$category_data = array(
    'getting-started' => array(
        'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
        'color' => 'green'
    ),
    'design' => array(
        'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M15 5l3 3m-3-3l3 3',
        'color' => 'purple'
    ),
    'products' => array(
        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
        'color' => 'blue'
    ),
    'marketing' => array(
        'icon' => 'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a1 1 0 01-1-1V9a1 1 0 011-1h1a2 2 0 100-4H4a1 1 0 01-1-1V4a1 1 0 011-1h3a1 1 0 001-1v-1a2 2 0 012-2z',
        'color' => 'red'
    ),
    'payments' => array(
        'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
        'color' => 'yellow'
    ),
    'analytics' => array(
        'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        'color' => 'orange'
    )
);

$current_category_info = isset($category_data[$term_slug]) ? $category_data[$term_slug] : $category_data['products'];

?>

<div class="guide-category-archive">
    <!-- Header Section -->
    <header class="bg-gradient-to-r from-<?php echo $current_category_info['color']; ?>-50 to-<?php echo $current_category_info['color']; ?>-100 py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="text-sm text-gray-600 mb-6">
                    <a href="<?php echo home_url(); ?>" class="hover:text-blue-600">Home</a>
                    <span class="mx-2">/</span>
                    <a href="<?php echo get_post_type_archive_link('guide'); ?>" class="hover:text-blue-600">Guides</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-400"><?php echo esc_html($current_term->name); ?></span>
                </nav>
                
                <div class="flex items-start gap-6">
                    <!-- Category Icon -->
                    <div class="w-16 h-16 bg-<?php echo $current_category_info['color']; ?>-200 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-<?php echo $current_category_info['color']; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $current_category_info['icon']; ?>"></path>
                        </svg>
                    </div>
                    
                    <div class="flex-1">
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                            <?php echo esc_html($current_term->name); ?> Guides
                        </h1>
                        
                        <?php if ($current_term->description) : ?>
                            <p class="text-xl text-gray-600 mb-6 leading-relaxed">
                                <?php echo esc_html($current_term->description); ?>
                            </p>
                        <?php endif; ?>
                        
                        <!-- Category Stats -->
                        <div class="grid md:grid-cols-3 gap-4">
                            <div class="bg-white/70 backdrop-blur-sm rounded-lg p-4">
                                <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $guides_query->found_posts; ?></div>
                                <div class="text-sm text-gray-600">Guides Available</div>
                            </div>
                            <div class="bg-white/70 backdrop-blur-sm rounded-lg p-4">
                                <div class="text-2xl font-bold text-gray-900 mb-1">
                                    <?php 
                                    // Calculate average reading time
                                    $total_time = 0;
                                    $count = 0;
                                    if ($guides_query->have_posts()) {
                                        while ($guides_query->have_posts()) {
                                            $guides_query->the_post();
                                            $total_time += yoursite_get_reading_time(get_the_ID());
                                            $count++;
                                        }
                                        wp_reset_postdata();
                                    }
                                    echo $count > 0 ? round($total_time / $count) : 0;
                                    ?>min
                                </div>
                                <div class="text-sm text-gray-600">Avg. Reading Time</div>
                            </div>
                            <div class="bg-white/70 backdrop-blur-sm rounded-lg p-4">
                                <div class="text-2xl font-bold text-gray-900 mb-1">Free</div>
                                <div class="text-sm text-gray-600">Always Updated</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Search and Filter Section -->
    <section class="py-8 bg-white border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <form method="GET" class="bg-gray-50 rounded-lg p-6">
                    <input type="hidden" name="category" value="<?php echo esc_attr($term_slug); ?>">
                    
                    <div class="grid md:grid-cols-3 gap-4">
                        <!-- Search Input -->
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search in <?php echo esc_html($current_term->name); ?></label>
                            <div class="relative">
                                <input type="text" id="search" name="search" 
                                       value="<?php echo esc_attr($search_params['search'] ?? ''); ?>"
                                       placeholder="Search guides in this category..." 
                                       class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Difficulty Filter -->
                        <div>
                            <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                            <select id="difficulty" name="difficulty" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Levels</option>
                                <option value="beginner" <?php selected($search_params['difficulty'] ?? '', 'beginner'); ?>>Beginner</option>
                                <option value="intermediate" <?php selected($search_params['difficulty'] ?? '', 'intermediate'); ?>>Intermediate</option>
                                <option value="advanced" <?php selected($search_params['difficulty'] ?? '', 'advanced'); ?>>Advanced</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center gap-4">
                            <button type="submit" class="btn-primary px-6 py-3 rounded-lg font-semibold">
                                Apply Filters
                            </button>
                            
                            <?php if (!empty($search_params['search']) || !empty($search_params['difficulty'])) : ?>
                                <a href="<?php echo get_term_link($current_term); ?>" class="text-gray-600 hover:text-gray-800 underline">
                                    Clear Filters
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="text-sm text-gray-600">
                            Showing <?php echo $guides_query->found_posts; ?> guides
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
    <!-- Guides Grid -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <?php if ($guides_query->have_posts()) : ?>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        <?php 
                        // Reset query for display
                        $guides_query = new WP_Query(yoursite_build_guide_query_args($search_params, 12));
                        while ($guides_query->have_posts()) : $guides_query->the_post(); 
                            $guide_id = get_the_ID();
                            $reading_time = yoursite_get_reading_time($guide_id);
                            $difficulty = get_post_meta($guide_id, '_guide_difficulty', true) ?: 'beginner';
                            $is_featured = get_post_meta($guide_id, '_featured_guide', true);
                            $progress = yoursite_get_guide_progress($guide_id, $term_slug);
                        ?>
                            <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                                <a href="<?php the_permalink(); ?>" class="block">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="aspect-video bg-gray-200 overflow-hidden">
                                            <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300')); ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="aspect-video bg-gradient-to-br from-<?php echo $current_category_info['color']; ?>-50 to-<?php echo $current_category_info['color']; ?>-100 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-<?php echo $current_category_info['color']; ?>-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $current_category_info['icon']; ?>"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="p-6">
                                        <!-- Tags -->
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <?php if ($is_featured) : ?>
                                                <span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    Featured
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php echo yoursite_get_difficulty_badge($difficulty); ?>
                                            
                                            <?php if ($progress > 0) : ?>
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                    <?php echo $progress; ?>% Progress
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">
                                            <?php the_title(); ?>
                                        </h3>
                                        
                                        <?php if (has_excerpt()) : ?>
                                            <p class="text-gray-600 mb-4 line-clamp-3">
                                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <!-- Meta Info -->
                                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <?php echo $reading_time; ?> min read
                                            </div>
                                            
                                            <span class="text-blue-600 font-medium group-hover:text-blue-700 transition-colors">
                                                Read Guide →
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php
                    $pagination_args = array(
                        'total' => $guides_query->max_num_pages,
                        'current' => $paged,
                        'format' => '?paged=%#%',
                        'show_all' => false,
                        'end_size' => 1,
                        'mid_size' => 2,
                        'prev_next' => true,
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                        'type' => 'array'
                    );
                    
                    $pagination_links = paginate_links($pagination_args);
                    
                    if ($pagination_links && $guides_query->max_num_pages > 1) :
                    ?>
                        <nav class="flex justify-center">
                            <div class="flex items-center space-x-2">
                                <?php foreach ($pagination_links as $link) : ?>
                                    <div class="pagination-item">
                                        <?php echo str_replace(
                                            array('page-numbers', 'current'),
                                            array('px-4 py-2 text-sm font-medium rounded-lg border transition-colors', 'bg-blue-600 text-white border-blue-600'),
                                            $link
                                        ); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </nav>
                    <?php endif; ?>
                    
                <?php else : ?>
                    <!-- No Results -->
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.5-1.201-5.5-3.291M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-2">No guides found</h3>
                        <p class="text-gray-600 mb-6">
                            <?php if (!empty($search_params['search']) || !empty($search_params['difficulty'])) : ?>
                                No guides in this category match your current filters. Try adjusting your search criteria.
                            <?php else : ?>
                                No guides have been published in this category yet. Check back soon!
                            <?php endif; ?>
                        </p>
                        
                        <?php if (!empty($search_params['search']) || !empty($search_params['difficulty'])) : ?>
                            <a href="<?php echo get_term_link($current_term); ?>" class="btn-primary">
                                View All <?php echo esc_html($current_term->name); ?> Guides
                            </a>
                        <?php else : ?>
                            <a href="<?php echo get_post_type_archive_link('guide'); ?>" class="btn-primary">
                                Browse All Guides
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Other Categories Section -->
    <?php if (!empty($all_categories)) : ?>
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Explore Other Topics</h2>
                        <p class="text-xl text-gray-600">Discover more guides in different categories</p>
                    </div>
                    
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach (array_slice($all_categories, 0, 6) as $category) : 
                            $cat_info = isset($category_data[$category->slug]) ? $category_data[$category->slug] : $category_data['products'];
                            $category_guide_count = get_posts(array(
                                'post_type' => 'guide',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'guide_category',
                                        'field' => 'term_id',
                                        'terms' => $category->term_id
                                    )
                                ),
                                'fields' => 'ids'
                            ));
                        ?>
                            <a href="<?php echo get_term_link($category); ?>" class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 group">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-10 h-10 bg-<?php echo $cat_info['color']; ?>-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-<?php echo $cat_info['color']; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $cat_info['icon']; ?>"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        <?php echo esc_html($category->name); ?>
                                    </h3>
                                </div>
                                
                                <p class="text-gray-600 text-sm mb-4">
                                    <?php echo esc_html($category->description ?: 'Learn about ' . $category->name); ?>
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">
                                        <?php echo count($category_guide_count); ?> guides
                                    </span>
                                    <span class="text-blue-600 group-hover:text-blue-700 transition-colors font-medium">
                                        Explore →
                                    </span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if (count($all_categories) > 6) : ?>
                        <div class="text-center mt-8">
                            <a href="<?php echo get_post_type_archive_link('guide'); ?>" class="btn-secondary">
                                View All Categories
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>

<!-- Custom CSS -->
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.pagination-item a,
.pagination-item span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    text-decoration: none;
    border: 1px solid #d1d5db;
    color: #374151;
    transition: all 0.2s;
}

.pagination-item a:hover {
    background-color: #f3f4f6;
    border-color: #9ca3af;
}

.pagination-item .current {
    background-color: #3b82f6 !important;
    color: white !important;
    border-color: #3b82f6 !important;
}
</style>

<?php
wp_reset_postdata();
get_footer();
?>
<?php
/**
 * The main template file for blog posts
 */

get_header();
?>

<div class="blog-page bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <section class="bg-white py-16 border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    <?php 
                    if (is_home() && !is_front_page()) {
                        echo get_the_title(get_option('page_for_posts'));
                    } elseif (is_category()) {
                        single_cat_title('Category: ');
                    } elseif (is_tag()) {
                        single_tag_title('Tag: ');
                    } elseif (is_author()) {
                        echo 'Author: ' . get_the_author();
                    } elseif (is_date()) {
                        echo 'Archives';
                    } else {
                        echo 'Latest News & Updates';
                    }
                    ?>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Stay updated with the latest features, tips, and news from our team.
                </p>
            </div>
        </div>
    </section>

    <!-- Blog Posts -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <?php if (have_posts()) : ?>
                    
                    <!-- Posts Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden'); ?>>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>" class="block">
                                            <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-48 object-cover')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="p-6">
                                    <!-- Categories -->
                                    <?php 
                                    $categories = get_the_category();
                                    if (!empty($categories)) : 
                                    ?>
                                        <div class="mb-3">
                                            <?php foreach ($categories as $category) : ?>
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2">
                                                    <?php echo esc_html($category->name); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Title -->
                                    <h2 class="text-xl font-semibold text-gray-900 mb-3 leading-tight">
                                        <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors duration-200">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    
                                    <!-- Excerpt -->
                                    <div class="text-gray-600 mb-4 line-clamp-3">
                                        <?php 
                                        if (has_excerpt()) {
                                            the_excerpt();
                                        } else {
                                            echo wp_trim_words(get_the_content(), 20, '...');
                                        }
                                        ?>
                                    </div>
                                    
                                    <!-- Meta -->
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <?php echo get_the_date(); ?>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <?php echo get_the_author(); ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Read More -->
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center">
                                            Read More
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if (function_exists('wp_pagenavi')) : ?>
                        <?php wp_pagenavi(); ?>
                    <?php else : ?>
                        <div class="pagination-wrapper flex justify-center">
                            <?php
                            the_posts_pagination(array(
                                'mid_size'  => 2,
                                'prev_text' => '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Previous',
                                'next_text' => 'Next <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
                                'class'     => 'blog-pagination',
                            ));
                            ?>
                        </div>
                    <?php endif; ?>
                    
                <?php else : ?>
                    
                    <!-- No Posts Found -->
                    <div class="text-center py-16">
                        <div class="max-w-md mx-auto">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-2">No posts found</h2>
                            <p class="text-gray-600 mb-6">
                                <?php if (is_search()) : ?>
                                    Sorry, no posts matched your search criteria. Please try again with different keywords.
                                <?php else : ?>
                                    There are no blog posts to display at the moment. Check back soon for updates!
                                <?php endif; ?>
                            </p>
                            
                            <?php if (is_search()) : ?>
                                <div class="max-w-sm mx-auto">
                                    <?php get_search_form(); ?>
                                </div>
                            <?php else : ?>
                                <a href="<?php echo home_url(); ?>" class="btn-primary inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Back to Home
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<style>
/* Blog specific styles */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Pagination styles */
.blog-pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 2rem;
}

.blog-pagination .page-numbers {
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    color: #374151;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
}

.blog-pagination .page-numbers:hover,
.blog-pagination .page-numbers.current {
    background-color: #667eea;
    border-color: #667eea;
    color: white;
}

.blog-pagination .page-numbers.dots {
    border: none;
    background: none;
    cursor: default;
}

.blog-pagination .page-numbers.dots:hover {
    background: none;
    color: #374151;
}
</style>

<?php
get_sidebar();
get_footer();
?>
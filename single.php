<?php
/**
 * The template for displaying single posts
 */

get_header();
?>

<div class="single-post-page bg-gray-50 min-h-screen">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Hero Section -->
        <section class="bg-white py-16 border-b border-gray-200">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    
                    <!-- Categories -->
                    <?php 
                    $categories = get_the_category();
                    if (!empty($categories)) : 
                    ?>
                        <div class="mb-4">
                            <?php foreach ($categories as $category) : ?>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                                   class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mr-2 hover:bg-blue-200 transition-colors duration-200">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Title -->
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        <?php the_title(); ?>
                    </h1>
                    
                    <!-- Meta -->
                    <div class="flex flex-wrap items-center text-gray-600 mb-8 space-x-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>By <?php echo get_the_author(); ?></span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span><?php echo get_the_date(); ?></span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span><?php echo reading_time(); ?> min read</span>
                        </div>
                    </div>
                    
                    <!-- Featured Image -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="mb-8">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-64 lg:h-96 object-cover rounded-lg shadow-md')); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Content Section -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="prose prose-lg max-w-none">
                        <?php the_content(); ?>
                    </div>
                    
                    <!-- Tags -->
                    <?php 
                    $tags = get_the_tags();
                    if ($tags) : 
                    ?>
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                                       class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-200 transition-colors duration-200">
                                        #<?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Share Buttons -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Share this post</h3>
                        <div class="flex space-x-4">
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                               target="_blank" rel="noopener"
                               class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                                Twitter
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
                               target="_blank" rel="noopener"
                               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" 
                               target="_blank" rel="noopener"
                               class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                LinkedIn
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Author Bio -->
        <section class="bg-white py-16">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-gray-50 rounded-lg p-8">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <?php echo get_avatar(get_the_author_meta('ID'), 80, '', '', array('class' => 'w-20 h-20 rounded-full')); ?>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                    <?php echo get_the_author(); ?>
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    <?php echo get_the_author_meta('description') ? get_the_author_meta('description') : 'This author has not provided a bio yet.'; ?>
                                </p>
                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" 
                                   class="text-blue-600 hover:text-blue-700 font-medium">
                                    View all posts by <?php echo get_the_author(); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Posts -->
        <?php
        $related_posts = get_posts(array(
            'numberposts' => 3,
            'category__in' => wp_get_post_categories(get_the_ID()),
            'post__not_in' => array(get_the_ID()),
            'orderby' => 'rand'
        ));
        
        if ($related_posts) :
        ?>
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="max-w-6xl mx-auto">
                        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">
                            Related Articles
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                                <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                                    
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="post-thumbnail">
                                            <a href="<?php the_permalink(); ?>" class="block">
                                                <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-48 object-cover')); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="p-6">
                                        <h3 class="text-xl font-semibold text-gray-900 mb-3 leading-tight">
                                            <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors duration-200">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        
                                        <div class="text-gray-600 mb-4">
                                            <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                                        </div>
                                        
                                        <div class="flex items-center text-sm text-gray-500">
                                            <span><?php echo get_the_date(); ?></span>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php 
        endif;
        wp_reset_postdata();
        ?>

        <!-- Post Navigation -->
        <section class="bg-white py-16 border-t border-gray-200">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="flex justify-between items-center">
                        
                        <?php 
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        
                        <!-- Previous Post -->
                        <div class="flex-1 mr-4">
                            <?php if ($prev_post) : ?>
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" 
                                   class="group flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-gray-400 mr-3 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    <div>
                                        <div class="text-sm text-gray-500 mb-1">Previous</div>
                                        <div class="font-medium text-gray-900 group-hover:text-blue-600">
                                            <?php echo wp_trim_words($prev_post->post_title, 8); ?>
                                        </div>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Next Post -->
                        <div class="flex-1 ml-4">
                            <?php if ($next_post) : ?>
                                <a href="<?php echo get_permalink($next_post->ID); ?>" 
                                   class="group flex items-center justify-end text-right p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div>
                                        <div class="text-sm text-gray-500 mb-1">Next</div>
                                        <div class="font-medium text-gray-900 group-hover:text-blue-600">
                                            <?php echo wp_trim_words($next_post->post_title, 8); ?>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 ml-3 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Comments Section -->
        <?php if (comments_open() || get_comments_number()) : ?>
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto">
                        <?php comments_template(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    <?php endwhile; ?>
</div>

<style>
/* Single post specific styles */
.prose {
    color: #374151;
}

.prose h1,
.prose h2,
.prose h3,
.prose h4,
.prose h5,
.prose h6 {
    color: #111827;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose h2 {
    font-size: 1.875rem;
    line-height: 2.25rem;
}

.prose h3 {
    font-size: 1.5rem;
    line-height: 2rem;
}

.prose p {
    margin-bottom: 1.5rem;
    line-height: 1.75;
}

.prose a {
    color: #667eea;
    text-decoration: underline;
}

.prose a:hover {
    color: #5b21b6;
}

.prose img {
    border-radius: 0.5rem;
    margin: 2rem 0;
}

.prose blockquote {
    border-left: 4px solid #667eea;
    padding-left: 1rem;
    font-style: italic;
    color: #6b7280;
    margin: 2rem 0;
}

.prose ul,
.prose ol {
    margin: 1.5rem 0;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose code {
    background-color: #f3f4f6;
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.prose pre {
    background-color: #1f2937;
    color: #f9fafb;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.prose pre code {
    background: none;
    padding: 0;
}

/* Share buttons hover effects */
.share-button:hover {
    transform: translateY(-1px);
}
</style>

<?php
get_footer();

// Helper function for reading time
function reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    return $reading_time;
}
?>
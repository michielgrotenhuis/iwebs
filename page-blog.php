<?php
/**
 * Template Name: Blog Page
 * Dynamic blog page that shows actual WordPress posts
 */

get_header();

// Get current page number for pagination
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Get selected category from URL parameter
$selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

// Set up the query arguments
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 9, // Show 9 posts per page
    'paged' => $paged
);

// Add category filter if selected
if (!empty($selected_category) && $selected_category !== 'all') {
    // Check if category exists
    $category = get_category_by_slug($selected_category);
    if ($category) {
        $args['cat'] = $category->term_id;
    }
}

// Custom query
$blog_query = new WP_Query($args);

// Get all categories for filter
$categories = get_categories(array(
    'hide_empty' => true,
    'number' => 10
));
?>

<div class="blog-page bg-gray-50 min-h-screen">
    
    <!-- Hero Section -->
    <section class="bg-white py-20 border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                    <?php echo get_the_title(); ?>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                    <?php 
                    echo get_the_content() ? wp_trim_words(get_the_content(), 25) : 'Stay updated with the latest news, tips, and insights from our team. Discover industry trends, product updates, and expert advice to help grow your business.';
                    ?>
                </p>
                
                <!-- Search Form -->
                <div class="max-w-md mx-auto">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex">
                        <input type="search" 
                               name="s" 
                               placeholder="Search articles..." 
                               value="<?php echo get_search_query(); ?>"
                               class="flex-1 px-4 py-3 border border-gray-300 border-r-0 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-3 rounded-r-lg hover:bg-blue-700 transition-colors duration-200 flex items-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Filter -->
    <?php if (!empty($categories)) : ?>
        <section class="bg-white py-8 border-b border-gray-200 sticky top-16 z-40">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <div class="flex flex-wrap justify-center gap-3">
                        <!-- All Categories -->
                        <a href="<?php echo get_permalink(); ?>" 
                           class="category-filter <?php echo empty($selected_category) || $selected_category === 'all' ? 'active' : ''; ?> px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border-2">
                            All Posts
                        </a>
                        
                        <!-- Dynamic Categories -->
                        <?php foreach ($categories as $category) : ?>
                            <a href="<?php echo esc_url(add_query_arg('category', $category->slug, get_permalink())); ?>" 
                               class="category-filter <?php echo $selected_category === $category->slug ? 'active' : ''; ?> px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border-2">
                                <?php echo esc_html($category->name); ?>
                                <span class="ml-1 text-xs opacity-75">(<?php echo $category->count; ?>)</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Blog Posts Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <?php if ($blog_query->have_posts()) : ?>
                    
                    <!-- Results Info -->
                    <div class="mb-8">
                        <p class="text-gray-600">
                            <?php
                            $total_posts = $blog_query->found_posts;
                            $posts_per_page = $blog_query->query_vars['posts_per_page'];
                            $current_page = max(1, get_query_var('paged'));
                            $start = ($current_page - 1) * $posts_per_page + 1;
                            $end = min($current_page * $posts_per_page, $total_posts);
                            
                            if (!empty($selected_category) && $selected_category !== 'all') {
                                $category_obj = get_category_by_slug($selected_category);
                                if ($category_obj) {
                                    echo "Showing {$start}-{$end} of {$total_posts} posts in <strong>" . esc_html($category_obj->name) . "</strong>";
                                } else {
                                    echo "Showing {$start}-{$end} of {$total_posts} posts";
                                }
                            } else {
                                echo "Showing {$start}-{$end} of {$total_posts} posts";
                            }
                            ?>
                        </p>
                    </div>
                    
                    <!-- Featured Post (First Post) -->
                    <?php if ($paged <= 1) : ?>
                        <?php $blog_query->the_post(); ?>
                        <article class="featured-post bg-white rounded-xl shadow-lg overflow-hidden mb-12 hover:shadow-xl transition-shadow duration-300">
                            <div class="lg:flex">
                                <div class="lg:w-1/2">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>" class="block">
                                            <?php the_post_thumbnail('large', array('class' => 'w-full h-64 lg:h-full object-cover')); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="lg:w-1/2 p-8 lg:p-12">
                                    <!-- Featured Badge -->
                                    <div class="mb-4">
                                        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                                            Featured Post
                                        </span>
                                    </div>
                                    
                                    <!-- Categories -->
                                    <?php 
                                    $post_categories = get_the_category();
                                    if (!empty($post_categories)) : 
                                    ?>
                                        <div class="mb-4">
                                            <?php foreach ($post_categories as $cat) : ?>
                                                <a href="<?php echo esc_url(add_query_arg('category', $cat->slug, get_permalink(get_the_ID()))); ?>" 
                                                   class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full mr-2 hover:bg-gray-200 transition-colors duration-200">
                                                    <?php echo esc_html($cat->name); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Title -->
                                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                                        <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors duration-200">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    
                                    <!-- Excerpt -->
                                    <div class="text-gray-600 mb-6 text-lg leading-relaxed">
                                        <?php 
                                        if (has_excerpt()) {
                                            echo wp_trim_words(get_the_excerpt(), 25);
                                        } else {
                                            echo wp_trim_words(get_the_content(), 25);
                                        }
                                        ?>
                                    </div>
                                    
                                    <!-- Meta -->
                                    <div class="flex items-center text-sm text-gray-500 mb-6">
                                        <div class="flex items-center mr-6">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <?php echo get_the_date(); ?>
                                        </div>
                                        <div class="flex items-center mr-6">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <?php echo get_the_author(); ?>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <?php echo reading_time(); ?> min read
                                        </div>
                                    </div>
                                    
                                    <!-- Read More -->
                                    <div class="mt-6">
                                        <a href="<?php the_permalink(); ?>" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-lg group">
                                            Read Full Article
                                            <svg class="w-4 h-4 ml-2 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endif; ?>
                    
                    <!-- Regular Posts Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                            <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden group">
                                
                                <!-- Post Thumbnail -->
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail overflow-hidden">
                                        <a href="<?php the_permalink(); ?>" class="block">
                                            <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="p-6">
                                    <!-- Categories -->
                                    <?php 
                                    $post_categories = get_the_category();
                                    if (!empty($post_categories)) : 
                                    ?>
                                        <div class="mb-3">
                                            <?php foreach (array_slice($post_categories, 0, 2) as $cat) : ?>
                                                <a href="<?php echo esc_url(add_query_arg('category', $cat->slug, get_permalink(get_the_ID()))); ?>" 
                                                   class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2 hover:bg-blue-200 transition-colors duration-200">
                                                    <?php echo esc_html($cat->name); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Title -->
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3 leading-tight">
                                        <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors duration-200 group-hover:text-blue-600">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    
                                    <!-- Excerpt -->
                                    <div class="text-gray-600 mb-4 line-clamp-3">
                                        <?php 
                                        if (has_excerpt()) {
                                            echo wp_trim_words(get_the_excerpt(), 15);
                                        } else {
                                            echo wp_trim_words(get_the_content(), 15);
                                        }
                                        ?>
                                    </div>
                                    
                                    <!-- Meta -->
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <?php echo get_the_date('M j'); ?>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <?php echo reading_time(); ?> min
                                        </div>
                                    </div>
                                    
                                    <!-- Read More -->
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors duration-200 group">
                                            Read More
                                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($blog_query->max_num_pages > 1) : ?>
                        <div class="pagination-wrapper mt-16 flex justify-center">
                            <?php
                            $pagination_args = array(
                                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'format' => '?paged=%#%',
                                'current' => max(1, get_query_var('paged')),
                                'total' => $blog_query->max_num_pages,
                                'mid_size' => 2,
                                'prev_text' => '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Previous',
                                'next_text' => 'Next <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
                            );
                            
                            // Add category parameter to pagination links if filtered
                            if (!empty($selected_category) && $selected_category !== 'all') {
                                $pagination_args['add_args'] = array('category' => $selected_category);
                            }
                            
                            echo paginate_links($pagination_args);
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
                                <?php if (!empty($selected_category)) : ?>
                                    No posts found in this category. Try browsing all posts or select a different category.
                                <?php else : ?>
                                    There are no blog posts to display at the moment. Check back soon for updates!
                                <?php endif; ?>
                            </p>
                            
                            <div class="space-y-4">
                                <?php if (!empty($selected_category)) : ?>
                                    <a href="<?php echo get_permalink(); ?>" class="btn-primary inline-flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                        </svg>
                                        View All Posts
                                    </a>
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
                    </div>
                    
                <?php endif; ?>
                
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="bg-gray-900 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
                <p class="text-xl text-gray-300 mb-8">Get the latest articles delivered straight to your inbox</p>
                
                <form class="newsletter-form max-w-md mx-auto flex" data-nonce="<?php echo wp_create_nonce('newsletter_nonce'); ?>">
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
                
                <div class="newsletter-message mt-4 hidden"></div>
            </div>
        </div>
    </section>
</div>

<style>
/* Blog page specific styles */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Category filter styles */
.category-filter {
    border-color: #e5e7eb;
    color: #6b7280;
    background: white;
    text-decoration: none;
}

.category-filter:hover {
    border-color: #3b82f6;
    color: #3b82f6;
    background: #eff6ff;
    text-decoration: none;
}

.category-filter.active {
    border-color: #1d4ed8;
    background: #1d4ed8;
    color: white !important;
    text-decoration: none;
}

.category-filter.active:hover {
    border-color: #1e40af;
    background: #1e40af;
    color: white !important;
    text-decoration: none;
}

/* Fix number visibility in active category buttons */
.category-filter.active span {
    color: rgba(255, 255, 255, 0.9) !important;
    opacity: 1 !important;
}

.category-filter.active:hover span {
    color: rgba(255, 255, 255, 0.95) !important;
}

/* Pagination styles */
.page-numbers {
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    margin: 0 4px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    color: #374151;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
}

.page-numbers:hover,
.page-numbers.current {
    background-color: #667eea;
    border-color: #667eea;
    color: white;
    text-decoration: none;
}

.page-numbers.dots {
    border: none;
    background: none;
    cursor: default;
}

/* Featured post hover effects */
.featured-post:hover .post-thumbnail img {
    transform: scale(1.05);
}

/* Smooth animations */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

.group:hover .group-hover\:translate-x-1 {
    transform: translateX(0.25rem);
}

.group:hover .group-hover\:text-blue-600,
.group:hover .group-hover\:text-blue-700 {
    color: #2563eb;
}

/* Newsletter form */
.newsletter-form input:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Featured post button styling */
.featured-post .btn-primary,
.featured-post a[class*="bg-blue-600"] {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border: none;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
}

.featured-post .btn-primary:hover,
.featured-post a[class*="bg-blue-600"]:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4);
    color: white;
    text-decoration: none;
    transform: none; /* Remove the translateY effect */
}

/* Arrow slide effect only */
.featured-post .group:hover .group-hover\:translate-x-1 {
    transform: translateX(0.25rem);
}

/* Category filter improvements */
.category-filter {
    white-space: nowrap;
    user-select: none;
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
</style>

<script>
// Newsletter signup functionality
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.querySelector('.newsletter-form');
    const messageDiv = document.querySelector('.newsletter-message');
    
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
                    messageDiv.className = 'newsletter-message mt-4 text-green-400';
                    messageDiv.textContent = data.data;
                    newsletterForm.reset();
                } else {
                    messageDiv.className = 'newsletter-message mt-4 text-red-400';
                    messageDiv.textContent = data.data;
                }
            })
            .catch(error => {
                messageDiv.classList.remove('hidden');
                messageDiv.className = 'newsletter-message mt-4 text-red-400';
                messageDiv.textContent = 'An error occurred. Please try again.';
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>

<?php
get_footer();
?>
<?php
/**
 * The sidebar containing the main widget area
 * 
 * @package YourSite.biz
 * @since 1.0.0
 */

// Don't display sidebar if no widgets are active
if (!is_active_sidebar('sidebar-1') && !is_active_sidebar('sidebar-2')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
    
    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <!-- Primary Sidebar -->
        <div class="primary-sidebar">
            <?php dynamic_sidebar('sidebar-1'); ?>
        </div>
    <?php endif; ?>
    
    <?php if (is_active_sidebar('sidebar-2')) : ?>
        <!-- Secondary Sidebar -->
        <div class="secondary-sidebar border-t border-gray-200 dark:border-gray-700">
            <?php dynamic_sidebar('sidebar-2'); ?>
        </div>
    <?php endif; ?>
    
    <?php if (!is_active_sidebar('sidebar-1') && !is_active_sidebar('sidebar-2')) : ?>
        <!-- Default Content When No Widgets -->
        <div class="default-sidebar-content p-6">
            
            <!-- Search Widget -->
            <div class="widget widget-search mb-8">
                <h3 class="widget-title text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                    <?php _e('Search', 'yoursite'); ?>
                </h3>
                <div class="widget-content">
                    <?php get_search_form(); ?>
                </div>
            </div>
            
            <!-- Recent Posts Widget -->
            <div class="widget widget-recent-posts mb-8">
                <h3 class="widget-title text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                    <?php _e('Recent Posts', 'yoursite'); ?>
                </h3>
                <div class="widget-content">
                    <?php
                    $recent_posts = wp_get_recent_posts(array(
                        'numberposts' => 5,
                        'post_status' => 'publish'
                    ));
                    
                    if ($recent_posts) :
                    ?>
                        <ul class="recent-posts-list space-y-3">
                            <?php foreach ($recent_posts as $post) : ?>
                                <li class="recent-post-item">
                                    <a href="<?php echo get_permalink($post['ID']); ?>" 
                                       class="block group hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg p-3 transition-colors duration-200">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 mb-1 line-clamp-2">
                                            <?php echo esc_html($post['post_title']); ?>
                                        </h4>
                                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <?php echo get_the_date('M j, Y', $post['ID']); ?>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            <?php _e('No recent posts found.', 'yoursite'); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Categories Widget -->
            <?php 
            $categories = get_categories(array('hide_empty' => true, 'number' => 8));
            if ($categories) :
            ?>
                <div class="widget widget-categories mb-8">
                    <h3 class="widget-title text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                        <?php _e('Categories', 'yoursite'); ?>
                    </h3>
                    <div class="widget-content">
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($categories as $category) : ?>
                                <a href="<?php echo get_category_link($category->term_id); ?>" 
                                   class="inline-block bg-gray-100 dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-blue-800 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-300 text-xs px-3 py-1 rounded-full transition-colors duration-200">
                                    <?php echo esc_html($category->name); ?>
                                    <span class="ml-1 opacity-60">(<?php echo $category->count; ?>)</span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Newsletter Signup -->
            <div class="widget widget-newsletter mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-lg p-6 border border-blue-100 dark:border-blue-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        <?php _e('Stay Updated', 'yoursite'); ?>
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                        <?php _e('Get the latest updates and exclusive content delivered to your inbox.', 'yoursite'); ?>
                    </p>
                    <form class="sidebar-newsletter-form" data-nonce="<?php echo wp_create_nonce('newsletter_nonce'); ?>">
                        <div class="flex flex-col gap-2">
                            <input type="email" 
                                   name="email"
                                   placeholder="<?php _e('Enter your email', 'yoursite'); ?>" 
                                   required
                                   class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-all duration-200 transform hover:scale-105">
                                <?php _e('Subscribe', 'yoursite'); ?>
                            </button>
                        </div>
                        <div class="newsletter-message mt-2 hidden"></div>
                    </form>
                </div>
            </div>
            
            <!-- Tags Cloud (if tags exist) -->
            <?php 
            $tags = get_tags(array('number' => 20, 'orderby' => 'count', 'order' => 'DESC'));
            if ($tags) :
            ?>
                <div class="widget widget-tags mb-8">
                    <h3 class="widget-title text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                        <?php _e('Popular Tags', 'yoursite'); ?>
                    </h3>
                    <div class="widget-content">
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?php echo get_tag_link($tag->term_id); ?>" 
                                   class="inline-block bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-xs px-2 py-1 rounded transition-colors duration-200"
                                   style="font-size: <?php echo min(16, max(10, 10 + ($tag->count * 2))); ?>px;">
                                    <?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Social Links -->
            <?php if (get_theme_mod('show_sidebar_social', true)) : ?>
                <div class="widget widget-social">
                    <h3 class="widget-title text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                        <?php _e('Follow Us', 'yoursite'); ?>
                    </h3>
                    <div class="widget-content">
                        <div class="flex flex-wrap gap-2">
                            <?php
                            $social_platforms = array(
                                'twitter' => array('icon' => 'M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z', 'label' => 'Twitter', 'color' => 'bg-blue-500'),
                                'linkedin' => array('icon' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z', 'label' => 'LinkedIn', 'color' => 'bg-blue-600'),
                                'youtube' => array('icon' => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z', 'label' => 'YouTube', 'color' => 'bg-red-600'),
                                'instagram' => array('icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.405a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z', 'label' => 'Instagram', 'color' => 'bg-pink-500')
                            );
                            
                            foreach ($social_platforms as $platform => $data) {
                                $url = get_theme_mod("social_{$platform}_url", '');
                                if (!empty($url)) {
                                    echo '<a href="' . esc_url($url) . '" class="inline-flex items-center justify-center w-10 h-10 rounded-lg ' . $data['color'] . ' hover:opacity-80 text-white transition-opacity duration-200" aria-label="' . esc_attr($data['label']) . '" target="_blank" rel="noopener noreferrer">';
                                    echo '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">';
                                    echo '<path d="' . esc_attr($data['icon']) . '"/>';
                                    echo '</svg>';
                                    echo '</a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    <?php endif; ?>
    
</aside><!-- #secondary -->

<style>
/* Sidebar Specific Styles */
.sidebar {
    position: sticky;
    top: 100px;
    max-height: calc(100vh - 120px);
    overflow-y: auto;
}

/* Widget Styling */
.widget {
    padding: 1.5rem;
    border-bottom: 1px solid theme('colors.gray.200');
}

.dark .widget {
    border-bottom-color: theme('colors.gray.700');
}

.widget:last-child {
    border-bottom: none;
}

.widget-title {
    position: relative;
}

.widget-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 30px;
    height: 2px;
    background: linear-gradient(to right, #667eea, #764ba2);
    border-radius: 2px;
}

/* Recent Posts Styling */
.recent-posts-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.recent-post-item {
    border-radius: 8px;
    overflow: hidden;
}

/* Tags Cloud Styling */
.widget-tags a {
    transition: all 0.2s ease;
}

.widget-tags a:hover {
    transform: translateY(-1px);
}

/* Newsletter Form Styling */
.sidebar-newsletter-form input:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.sidebar-newsletter-form button {
    position: relative;
    overflow: hidden;
}

.sidebar-newsletter-form button:hover {
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

/* Social Links Styling */
.widget-social a {
    transition: all 0.2s ease;
}

.widget-social a:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

/* Search Form Styling */
.sidebar .search-form {
    display: flex;
    gap: 0;
}

.sidebar .search-form .search-field {
    flex: 1;
    border-right: none;
    border-radius: 6px 0 0 6px;
    padding: 8px 12px;
    font-size: 14px;
}

.sidebar .search-form .search-submit {
    background: linear-gradient(to right, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 0 6px 6px 0;
    padding: 8px 16px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s ease;
}

.sidebar .search-form .search-submit:hover {
    background: linear-gradient(to right, #5a6fd8, #6b4190);
}

/* Line Clamp Utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive Adjustments */
@media (max-width: 1024px) {
    .sidebar {
        position: static;
        max-height: none;
    }
}

@media (max-width: 768px) {
    .widget {
        padding: 1rem;
    }
    
    .widget-title {
        font-size: 1rem;
        margin-bottom: 0.75rem;
    }
    
    .sidebar-newsletter-form .flex {
        flex-direction: column;
    }
    
    .widget-social .flex {
        gap: 0.5rem;
    }
    
    .widget-social a {
        width: 2.25rem;
        height: 2.25rem;
    }
}

/* Custom Scrollbar */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: theme('colors.gray.100');
    border-radius: 3px;
}

.dark .sidebar::-webkit-scrollbar-track {
    background: theme('colors.gray.700');
}

.sidebar::-webkit-scrollbar-thumb {
    background: theme('colors.gray.300');
    border-radius: 3px;
}

.dark .sidebar::-webkit-scrollbar-thumb {
    background: theme('colors.gray.600');
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: theme('colors.gray.400');
}

.dark .sidebar::-webkit-scrollbar-thumb:hover {
    background: theme('colors.gray.500');
}

/* Message States */
.newsletter-message {
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 4px;
    text-align: center;
}

.newsletter-message.success {
    background-color: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.newsletter-message.error {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.dark .newsletter-message.success {
    background-color: #166534;
    color: #dcfce7;
    border-color: #15803d;
}

.dark .newsletter-message.error {
    background-color: #991b1b;
    color: #fee2e2;
    border-color: #dc2626;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Newsletter Form Handler
    const sidebarNewsletterForm = document.querySelector('.sidebar-newsletter-form');
    
    if (sidebarNewsletterForm) {
        sidebarNewsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'newsletter_signup');
            formData.append('nonce', this.dataset.nonce);
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const messageDiv = this.querySelector('.newsletter-message');
            const originalText = submitBtn.textContent;
            
            // Show loading state
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
                    messageDiv.className = 'newsletter-message success mt-2';
                    messageDiv.textContent = data.data || 'Successfully subscribed!';
                    sidebarNewsletterForm.reset();
                } else {
                    messageDiv.className = 'newsletter-message error mt-2';
                    messageDiv.textContent = data.data || 'Subscription failed. Please try again.';
                }
            })
            .catch(error => {
                console.error('Newsletter signup error:', error);
                messageDiv.classList.remove('hidden');
                messageDiv.className = 'newsletter-message error mt-2';
                messageDiv.textContent = 'An error occurred. Please try again.';
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                
                // Hide message after 5 seconds
                setTimeout(() => {
                    messageDiv.classList.add('hidden');
                }, 5000);
            });
        });
    }
    
    // Smooth scroll for sidebar links
    const sidebarLinks = document.querySelectorAll('.sidebar a[href^="#"]');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
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
<?php
/**
 * Helper functions - FIXED VERSION with reading_time() function
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Simple reading_time() function that page-blog.php expects
 */
function reading_time($post_id = null) {
    return yoursite_get_reading_time($post_id);
}

/**
 * FIXED: Helper function for reading time calculation
 */
function yoursite_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    // Get both regular content and markdown content
    $content = get_post_field('post_content', $post_id);
    $markdown_content = get_post_meta($post_id, '_markdown_content', true);
    
    // Use markdown content if available, otherwise use regular content
    $text_to_analyze = !empty($markdown_content) ? $markdown_content : $content;
    
    // Check if reading time is manually set
    $manual_reading_time = get_post_meta($post_id, '_reading_time', true);
    if (!empty($manual_reading_time) && is_numeric($manual_reading_time)) {
        return intval($manual_reading_time);
    }
    
    // Calculate reading time automatically
    $word_count = str_word_count(strip_tags($text_to_analyze ?: ''));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    
    return max(1, $reading_time); // Minimum 1 minute
}

/**
 * FIXED: Helper function to format guide content for display
 */
function yoursite_format_guide_content($content) {
    // Check if content is null or empty first
    if (empty($content)) {
        return $content;
    }
    
    // Ensure proper spacing between blocks
    $content = preg_replace('/<!-- \/wp:(.*?) -->(\s*)<!-- wp:(.*?) -->/', '<!-- /wp:$1 -->$2$2<!-- wp:$3 -->', $content);
    
    // Enhanced code block styling
    $content = preg_replace(
        '/<pre class="wp-block-code"><code([^>]*)>/',
        '<pre class="wp-block-code bg-gray-900 text-white p-4 rounded-lg overflow-x-auto text-sm"><code$1 class="language-code">',
        $content
    );
    
    // Enhanced table styling
    $content = preg_replace(
        '/<table([^>]*)>/',
        '<div class="table-wrapper overflow-x-auto my-6"><table$1 class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg">',
        $content
    );
    
    $content = str_replace('</table>', '</table></div>', $content);
    
    // Style table headers
    $content = preg_replace(
        '/<th([^>]*)>/',
        '<th$1 class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">',
        $content
    );
    
    // Style table cells
    $content = preg_replace(
        '/<td([^>]*)>/',
        '<td$1 class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-100">',
        $content
    );
    
    // Enhanced blockquote styling
    $content = preg_replace(
        '/<blockquote class="wp-block-quote">/',
        '<blockquote class="wp-block-quote border-l-4 border-blue-500 bg-blue-50 p-4 my-6 rounded-r-lg">',
        $content
    );
    
    // Style lists properly
    $content = preg_replace(
        '/<ul class="wp-block-list">/',
        '<ul class="wp-block-list list-disc list-inside space-y-2 my-4 ml-4">',
        $content
    );
    
    $content = preg_replace(
        '/<ol class="wp-block-list">/',
        '<ol class="wp-block-list list-decimal list-inside space-y-2 my-4 ml-4">',
        $content
    );
    
    // Style list items
    $content = preg_replace(
        '/<li>([^<]*(?:<(?!\/li>)[^>]*>[^<]*<\/[^>]*>[^<]*)*)<\/li>/',
        '<li class="leading-relaxed">$1</li>',
        $content
    );
    
    // Enhanced paragraph styling
    $content = preg_replace(
        '/<p class="wp-block-paragraph">/',
        '<p class="wp-block-paragraph leading-relaxed mb-4">',
        $content
    );
    
    // Style headings with proper spacing
    $content = preg_replace(
        '/<h([1-6]) class="wp-block-heading">/',
        '<h$1 class="wp-block-heading font-bold text-gray-900 mt-8 mb-4 leading-tight">',
        $content
    );
    
    // Add specific styling for different heading levels
    $content = preg_replace(
        '/<h1 class="wp-block-heading font-bold text-gray-900 mt-8 mb-4 leading-tight">/',
        '<h1 class="wp-block-heading font-bold text-gray-900 text-3xl mt-8 mb-6 leading-tight">',
        $content
    );
    
    $content = preg_replace(
        '/<h2 class="wp-block-heading font-bold text-gray-900 mt-8 mb-4 leading-tight">/',
        '<h2 class="wp-block-heading font-bold text-gray-900 text-2xl mt-8 mb-4 leading-tight">',
        $content
    );
    
    $content = preg_replace(
        '/<h3 class="wp-block-heading font-bold text-gray-900 mt-8 mb-4 leading-tight">/',
        '<h3 class="wp-block-heading font-bold text-gray-900 text-xl mt-6 mb-3 leading-tight">',
        $content
    );
    
    // Style inline code
    $content = preg_replace(
        '/<code>([^<]+)<\/code>/',
        '<code class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm font-mono">$1</code>',
        $content
    );
    
    // Style images
    $content = preg_replace(
        '/<img([^>]*)class="wp-image-markdown"([^>]*)>/',
        '<img$1class="wp-image-markdown rounded-lg shadow-md my-6 max-w-full h-auto"$2>',
        $content
    );
    
    // Wrap images in figure tags for better styling
    $content = preg_replace(
        '/<img([^>]*class="wp-image-markdown[^"]*"[^>]*)>/',
        '<figure class="wp-block-image my-6"><img$1></figure>',
        $content
    );
    
    return $content;
}

/**
 * Helper function to get guide difficulty badge HTML
 */
function yoursite_get_difficulty_badge($difficulty) {
    $badges = array(
        'beginner' => '<span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Beginner</span>',
        'intermediate' => '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Intermediate</span>',
        'advanced' => '<span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Advanced</span>'
    );
    
    return isset($badges[$difficulty]) ? $badges[$difficulty] : $badges['beginner'];
}

/**
 * Helper function to get guide category link
 */
function yoursite_get_guide_category_link($post_id) {
    $categories = get_the_terms($post_id, 'guide_category');
    if ($categories && !is_wp_error($categories)) {
        $category = $categories[0];
        return '<a href="' . get_term_link($category) . '" class="text-blue-600 hover:text-blue-800">' . esc_html($category->name) . '</a>';
    }
    return '';
}

/**
 * Helper function to get related guides
 */
function yoursite_get_related_guides($post_id, $limit = 3) {
    $categories = get_the_terms($post_id, 'guide_category');
    
    if (!$categories || is_wp_error($categories)) {
        return array();
    }
    
    $category_ids = wp_list_pluck($categories, 'term_id');
    
    $args = array(
        'post_type' => 'guide',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'post__not_in' => array($post_id),
        'tax_query' => array(
            array(
                'taxonomy' => 'guide_category',
                'field' => 'term_id',
                'terms' => $category_ids,
                'operator' => 'IN'
            )
        ),
        'orderby' => 'rand'
    );
    
    return get_posts($args);
}

/**
 * Helper function to get guide navigation (prev/next)
 */
function yoursite_get_guide_navigation($post_id) {
    $categories = get_the_terms($post_id, 'guide_category');
    
    if (!$categories || is_wp_error($categories)) {
        return array('prev' => null, 'next' => null);
    }
    
    $category_ids = wp_list_pluck($categories, 'term_id');
    
    // Get all guides in the same category, ordered by menu order or date
    $guides = get_posts(array(
        'post_type' => 'guide',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'guide_category',
                'field' => 'term_id',
                'terms' => $category_ids,
                'operator' => 'IN'
            )
        ),
        'orderby' => array('menu_order' => 'ASC', 'date' => 'ASC'),
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_guide_order',
                'compare' => 'EXISTS'
            ),
            array(
                'key' => '_guide_order',
                'compare' => 'NOT EXISTS'
            )
        )
    ));
    
    $current_index = null;
    foreach ($guides as $index => $guide) {
        if ($guide->ID == $post_id) {
            $current_index = $index;
            break;
        }
    }
    
    $prev_guide = ($current_index > 0) ? $guides[$current_index - 1] : null;
    $next_guide = ($current_index < count($guides) - 1) ? $guides[$current_index + 1] : null;
    
    return array(
        'prev' => $prev_guide,
        'next' => $next_guide
    );
}

/**
 * Helper function to get guide progress percentage
 */
function yoursite_get_guide_progress($post_id, $category_slug = null) {
    if (!$category_slug) {
        $categories = get_the_terms($post_id, 'guide_category');
        if ($categories && !is_wp_error($categories)) {
            $category_slug = $categories[0]->slug;
        } else {
            return 0;
        }
    }
    
    // Get all guides in category
    $total_guides = get_posts(array(
        'post_type' => 'guide',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'guide_category',
                'field' => 'slug',
                'terms' => $category_slug
            )
        ),
        'fields' => 'ids'
    ));
    
    // Get current guide position
    $guides_ordered = get_posts(array(
        'post_type' => 'guide',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'guide_category',
                'field' => 'slug',
                'terms' => $category_slug
            )
        ),
        'orderby' => array('menu_order' => 'ASC', 'date' => 'ASC'),
        'fields' => 'ids'
    ));
    
    $current_position = array_search($post_id, $guides_ordered);
    
    if ($current_position === false || count($total_guides) === 0) {
        return 0;
    }
    
    return round((($current_position + 1) / count($total_guides)) * 100);
}

/**
 * Helper function to get pricing plans with proper ordering
 */
function get_pricing_plans() {
    $args = array(
        'post_type' => 'pricing',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_key' => '_pricing_price',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
    );
    
    return new WP_Query($args);
}

/**
 * Helper function to get features
 */
function get_features($limit = -1) {
    $args = array(
        'post_type' => 'features',
        'posts_per_page' => $limit,
        'post_status' => 'publish'
    );
    return new WP_Query($args);
}

/**
 * Helper function to get testimonials
 */
function get_testimonials($limit = 3) {
    $args = array(
        'post_type' => 'testimonials',
        'posts_per_page' => $limit,
        'post_status' => 'publish'
    );
    return new WP_Query($args);
}

/**
 * Helper function to get guides
 */
function get_guides($args = array()) {
    $default_args = array(
        'post_type' => 'guide',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    $args = wp_parse_args($args, $default_args);
    return new WP_Query($args);
}

/**
 * Helper function to get guides by category
 */
function get_guides_by_category($category_slug, $limit = -1) {
    $args = array(
        'post_type' => 'guide',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'guide_category',
                'field' => 'slug',
                'terms' => $category_slug
            )
        ),
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    return new WP_Query($args);
}

/**
 * Helper function to get featured guides
 */
function get_featured_guides($limit = 3) {
    $args = array(
        'post_type' => 'guide',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_featured_guide',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    return new WP_Query($args);
}

/**
 * Helper function to get webinars with improved filtering
 */
function get_webinars($status = 'all', $limit = -1) {
    $args = array(
        'post_type' => 'webinars',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'meta_key' => '_webinar_date',
        'orderby' => 'meta_value',
        'order' => 'ASC'
    );
    
    if ($status !== 'all') {
        if ($status === 'upcoming') {
            $args['meta_query'] = array(
                'relation' => 'OR',
                array(
                    'key' => '_webinar_status',
                    'value' => 'upcoming',
                    'compare' => '='
                ),
                array(
                    'key' => '_webinar_status',
                    'value' => 'live',
                    'compare' => '='
                )
            );
        } elseif ($status === 'past') {
            // Only show webinars explicitly marked as completed
            $args['meta_query'] = array(
                array(
                    'key' => '_webinar_status',
                    'value' => 'completed',
                    'compare' => '='
                )
            );
            $args['order'] = 'DESC'; // Show most recent completed first
        }
    }
    
    return new WP_Query($args);
}

/**
 * Fallback menu for desktop
 */
function yoursite_fallback_menu() {
    ?>
    <ul class="flex items-center space-x-8">
        <li><a href="<?php echo home_url('/features'); ?>" class="text-gray-700 hover:text-blue-600 px-4 py-2 transition-colors duration-200"><?php _e('Features', 'yoursite'); ?></a></li>
        <li><a href="<?php echo home_url('/pricing'); ?>" class="text-gray-700 hover:text-blue-600 px-4 py-2 transition-colors duration-200"><?php _e('Pricing', 'yoursite'); ?></a></li>
        <li><a href="<?php echo home_url('/templates'); ?>" class="text-gray-700 hover:text-blue-600 px-4 py-2 transition-colors duration-200"><?php _e('Templates', 'yoursite'); ?></a></li>
        <li><a href="<?php echo home_url('/guides'); ?>" class="text-gray-700 hover:text-blue-600 px-4 py-2 transition-colors duration-200"><?php _e('Guides', 'yoursite'); ?></a></li>
        <li><a href="<?php echo home_url('/blog'); ?>" class="text-gray-700 hover:text-blue-600 px-4 py-2 transition-colors duration-200"><?php _e('Blog', 'yoursite'); ?></a></li>
        <li><a href="<?php echo home_url('/contact'); ?>" class="text-gray-700 hover:text-blue-600 px-4 py-2 transition-colors duration-200"><?php _e('Contact', 'yoursite'); ?></a></li>
    </ul>
    <?php
}

/**
 * Fallback menu for mobile
 */
function yoursite_mobile_fallback_menu() {
    ?>
    <ul class="mobile-menu-list">
        <li><a href="<?php echo home_url('/features'); ?>"><?php _e('Features', 'yoursite'); ?></a></li>
        <li><a href="<?php echo home_url('/pricing'); ?>"><?php _e('Pricing', 'yoursite'); ?></a></li>
        <li><a href="<?php echo home_url('/templates'); ?>"><?php _e('Templates', 'yoursite'); ?></a></li>
        <li><a href="<?php echo home_url('/guides'); ?>"><?php _e('Guides', 'yoursite'); ?></a></li>
        <li><a href="<?php echo home_url('/blog'); ?>"><?php _e('Blog', 'yoursite'); ?></a></li>
        <li><a href="<?php echo home_url('/contact'); ?>"><?php _e('Contact', 'yoursite'); ?></a></li>
    </ul>
    <?php
}

/**
 * Helper function to sanitize and validate guide search parameters
 */
function yoursite_sanitize_guide_search_params($params) {
    $sanitized = array();
    
    // Search term
    if (isset($params['search']) && !empty($params['search'])) {
        $sanitized['search'] = sanitize_text_field($params['search']);
    }
    
    // Category filter
    if (isset($params['category']) && !empty($params['category'])) {
        $category = get_term_by('slug', sanitize_text_field($params['category']), 'guide_category');
        if ($category) {
            $sanitized['category'] = $category->slug;
        }
    }
    
    // Difficulty filter
    if (isset($params['difficulty']) && !empty($params['difficulty'])) {
        $valid_difficulties = array('beginner', 'intermediate', 'advanced');
        $difficulty = sanitize_text_field($params['difficulty']);
        if (in_array($difficulty, $valid_difficulties)) {
            $sanitized['difficulty'] = $difficulty;
        }
    }
    
    // Tag filter
    if (isset($params['tag']) && !empty($params['tag'])) {
        $tag = get_term_by('slug', sanitize_text_field($params['tag']), 'guide_tag');
        if ($tag) {
            $sanitized['tag'] = $tag->slug;
        }
    }
    
    return $sanitized;
}

/**
 * Helper function to build guide query args from search parameters
 */
function yoursite_build_guide_query_args($search_params, $posts_per_page = 12) {
    $args = array(
        'post_type' => 'guide',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    // Add pagination
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args['paged'] = $paged;
    
    // Text search
    if (!empty($search_params['search'])) {
        $args['s'] = $search_params['search'];
    }
    
    $tax_query = array();
    $meta_query = array();
    
    // Category filter
    if (!empty($search_params['category'])) {
        $tax_query[] = array(
            'taxonomy' => 'guide_category',
            'field' => 'slug',
            'terms' => $search_params['category']
        );
    }
    
    // Tag filter
    if (!empty($search_params['tag'])) {
        $tax_query[] = array(
            'taxonomy' => 'guide_tag',
            'field' => 'slug',
            'terms' => $search_params['tag']
        );
    }
    
    // Difficulty filter
    if (!empty($search_params['difficulty'])) {
        $meta_query[] = array(
            'key' => '_guide_difficulty',
            'value' => $search_params['difficulty'],
            'compare' => '='
        );
    }
    
    // Add tax_query if we have taxonomy filters
    if (!empty($tax_query)) {
        if (count($tax_query) > 1) {
            $tax_query['relation'] = 'AND';
        }
        $args['tax_query'] = $tax_query;
    }
    
    // Add meta_query if we have meta filters
    if (!empty($meta_query)) {
        if (count($meta_query) > 1) {
            $meta_query['relation'] = 'AND';
        }
        $args['meta_query'] = $meta_query;
    }
    
    return $args;
}

?>
<?php
/**
 * Helper functions
 */

if (!defined('ABSPATH')) {
    exit;
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
 * Currency conversion functions
 */
function get_user_currency_by_country($country_code) {
    $currency_map = array(
        'US' => 'USD', 'CA' => 'CAD', 'GB' => 'GBP', 'AU' => 'AUD',
        'DE' => 'EUR', 'FR' => 'EUR', 'IT' => 'EUR', 'ES' => 'EUR', 
        'NL' => 'EUR', 'BE' => 'EUR', 'AT' => 'EUR', 'PT' => 'EUR',
        'JP' => 'JPY', 'CH' => 'CHF', 'SE' => 'SEK', 'NO' => 'NOK', 
        'DK' => 'DKK'
    );
    
    return isset($currency_map[$country_code]) ? $currency_map[$country_code] : 'USD';
}

function get_currency_symbol($currency_code) {
    $symbols = array(
        'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'CAD' => '$',
        'AUD' => '$', 'JPY' => '¥', 'CHF' => 'CHF', 'SEK' => 'kr',
        'NOK' => 'kr', 'DKK' => 'kr'
    );
    
    return isset($symbols[$currency_code]) ? $symbols[$currency_code] : $currency_code;
}

function convert_price($amount, $from_currency, $to_currency) {
    if ($from_currency === $to_currency) {
        return $amount;
    }
    
    // Simple conversion rates (in production, use real API)
    $rates = array(
        'USD' => 1,
        'EUR' => 0.85,
        'GBP' => 0.73,
        'CAD' => 1.25,
        'AUD' => 1.35,
        'JPY' => 110,
        'CHF' => 0.92,
        'SEK' => 8.5,
        'NOK' => 8.7,
        'DKK' => 6.3
    );
    
    if (isset($rates[$from_currency]) && isset($rates[$to_currency])) {
        $usd_amount = $amount / $rates[$from_currency];
        return $usd_amount * $rates[$to_currency];
    }
    
    return $amount;
}

function get_user_location() {
    // Simple location detection - can be enhanced with IP geolocation
    return 'US'; // Default fallback
}

/**
 * Helper function for reading time calculation
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
    $word_count = str_word_count(strip_tags($text_to_analyze));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    
    return max(1, $reading_time); // Minimum 1 minute
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
 * Custom comment form styling
 */
function yoursite_comment_form_args($args) {
    $args['class_form'] = 'space-y-6';
    $args['class_submit'] = 'btn-primary';
    $args['title_reply'] = '<h3 class="text-2xl font-bold text-gray-900 mb-6">' . __('Leave a Comment', 'yoursite') . '</h3>';
    $args['comment_notes_before'] = '<p class="text-gray-600 mb-6">' . __('Your email address will not be published. Required fields are marked *', 'yoursite') . '</p>';
    
    return $args;
}
add_filter('comment_form_defaults', 'yoursite_comment_form_args');

/**
 * Style comment form fields
 */
function yoursite_comment_form_field_comment($field) {
    $field = '<div class="mb-6">
        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">' . __('Comment *', 'yoursite') . '</label>
        <textarea id="comment" name="comment" cols="45" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></textarea>
    </div>';
    return $field;
}
add_filter('comment_form_field_comment', 'yoursite_comment_form_field_comment');

/**
 * Remove default WordPress widgets that cause footer issues
 */
function yoursite_remove_default_widgets() {
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Tag_Cloud');
}
add_action('widgets_init', 'yoursite_remove_default_widgets', 1);

/**
 * Helper function to format guide content for display
 */
function yoursite_format_guide_content($content) {
    // Add syntax highlighting classes for code blocks
    $content = preg_replace(
        '/<pre class="wp-block-code"><code([^>]*)>/',
        '<pre class="wp-block-code bg-gray-900 text-white p-4 rounded-lg overflow-x-auto"><code$1 class="language-code">',
        $content
    );
    
    // Enhance table styling
    $content = preg_replace(
        '/<table([^>]*)>/',
        '<div class="overflow-x-auto"><table$1 class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg">',
        $content
    );
    
    $content = str_replace('</table>', '</table></div>', $content);
    
    // Style table headers
    $content = preg_replace(
        '/<th([^>]*)>/',
        '<th$1 class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">',
        $content
    );
    
    // Style table cells
    $content = preg_replace(
        '/<td([^>]*)>/',
        '<td$1 class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">',
        $content
    );
    
    return $content;
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
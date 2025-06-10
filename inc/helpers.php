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
 * Helper function for reading time (renamed to avoid conflicts)
 */
function yoursite_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    return $reading_time;
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
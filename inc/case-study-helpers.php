<?php
/**
 * Case Study Helper Functions
 * File inc/case-study-helpers.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get all case study meta fields for a post
 */
function yoursite_get_case_study_meta_fields($post_id) {
    return array(
        'case_study_client' => get_post_meta($post_id, '_case_study_client', true) ?: '',
        'case_study_industry_text' => get_post_meta($post_id, '_case_study_industry', true) ?: '',
        'case_study_website' => get_post_meta($post_id, '_case_study_url', true) ?: '',
        'case_study_duration' => get_post_meta($post_id, '_case_study_duration', true) ?: '',
        'case_study_technologies' => get_post_meta($post_id, '_case_study_technologies', true) ?: '',
        'case_study_challenge' => get_post_meta($post_id, '_case_study_challenge', true) ?: '',
        'case_study_solution' => get_post_meta($post_id, '_case_study_solution', true) ?: '',
        'case_study_results' => get_post_meta($post_id, '_case_study_results', true) ?: '',
        'case_study_testimonial' => get_post_meta($post_id, '_case_study_testimonial', true) ?: '',
        'case_study_testimonial_author' => get_post_meta($post_id, '_case_study_testimonial_author', true) ?: '',
        'case_study_metric_1_label' => get_post_meta($post_id, '_case_study_metric_1_label', true) ?: '',
        'case_study_metric_1_value' => get_post_meta($post_id, '_case_study_metric_1_value', true) ?: '',
        'case_study_metric_2_label' => get_post_meta($post_id, '_case_study_metric_2_label', true) ?: '',
        'case_study_metric_2_value' => get_post_meta($post_id, '_case_study_metric_2_value', true) ?: '',
        'case_study_metric_3_label' => get_post_meta($post_id, '_case_study_metric_3_label', true) ?: '',
        'case_study_metric_3_value' => get_post_meta($post_id, '_case_study_metric_3_value', true) ?: '',
        'case_study_featured' => get_post_meta($post_id, '_case_study_featured', true) ?: '0'
    );
}

/**
 * Get case study by status
 */
function yoursite_get_case_studies_by_status($status = 'all', $limit = -1) {
    $args = array(
        'post_type' => 'case_studies',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    if ($status === 'featured') {
        $args['meta_query'] = array(
            array(
                'key' => '_case_study_featured',
                'value' => '1',
                'compare' => '='
            )
        );
    }
    
    return get_posts($args);
}

/**
 * Get case studies by industry
 */
function yoursite_get_case_studies_by_industry($industry_slug, $limit = -1) {
    $args = array(
        'post_type' => 'case_studies',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'case_study_industry',
                'field' => 'slug',
                'terms' => $industry_slug
            )
        ),
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    return get_posts($args);
}

/**
 * Get case studies by service
 */
function yoursite_get_case_studies_by_service($service_slug, $limit = -1) {
    $args = array(
        'post_type' => 'case_studies',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'case_study_service',
                'field' => 'slug',
                'terms' => $service_slug
            )
        ),
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    return get_posts($args);
}

/**
 * Get related case studies
 */
function yoursite_get_related_case_studies($post_id, $limit = 3) {
    // Get current post's terms
    $industries = get_the_terms($post_id, 'case_study_industry');
    $services = get_the_terms($post_id, 'case_study_service');
    
    $tax_query = array('relation' => 'OR');
    
    if ($industries && !is_wp_error($industries)) {
        $tax_query[] = array(
            'taxonomy' => 'case_study_industry',
            'field' => 'term_id',
            'terms' => wp_list_pluck($industries, 'term_id')
        );
    }
    
    if ($services && !is_wp_error($services)) {
        $tax_query[] = array(
            'taxonomy' => 'case_study_service',
            'field' => 'term_id',
            'terms' => wp_list_pluck($services, 'term_id')
        );
    }
    
    $args = array(
        'post_type' => 'case_studies',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'post__not_in' => array($post_id),
        'orderby' => 'rand'
    );
    
    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }
    
    $related = get_posts($args);
    
    // If no related posts found, get random ones
    if (empty($related)) {
        $args = array(
            'post_type' => 'case_studies',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'post__not_in' => array($post_id),
            'orderby' => 'rand'
        );
        $related = get_posts($args);
    }
    
    return $related;
}

/**
 * Display case study metrics in a formatted way
 */
function yoursite_display_case_study_metrics($post_id, $layout = 'horizontal') {
    $meta = yoursite_get_case_study_meta_fields($post_id);
    
    $metrics = array();
    for ($i = 1; $i <= 3; $i++) {
        if (!empty($meta["case_study_metric_{$i}_label"]) && !empty($meta["case_study_metric_{$i}_value"])) {
            $metrics[] = array(
                'label' => $meta["case_study_metric_{$i}_label"],
                'value' => $meta["case_study_metric_{$i}_value"]
            );
        }
    }
    
    if (empty($metrics)) {
        return '';
    }
    
    $grid_class = 'grid-cols-' . min(count($metrics), 3);
    if ($layout === 'vertical') {
        $grid_class = 'grid-cols-1';
    }
    
    ob_start();
    ?>
    <div class="grid <?php echo $grid_class; ?> gap-6">
        <?php foreach ($metrics as $metric) : ?>
            <div class="text-center">
                <div class="text-3xl lg:text-4xl font-bold text-blue-600 mb-2">
                    <?php echo esc_html($metric['value']); ?>
                </div>
                <div class="text-gray-600 font-medium">
                    <?php echo esc_html($metric['label']); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Get case study excerpt with fallback
 */
function yoursite_get_case_study_excerpt($post_id, $length = 20) {
    $excerpt = get_the_excerpt($post_id);
    
    if (empty($excerpt)) {
        $content = get_post_field('post_content', $post_id);
        $excerpt = wp_trim_words(strip_tags($content), $length);
    }
    
    return $excerpt;
}

/**
 * Get case study industries as formatted string
 */
function yoursite_get_case_study_industries_string($post_id) {
    $industries = get_the_terms($post_id, 'case_study_industry');
    
    if (!$industries || is_wp_error($industries)) {
        return '';
    }
    
    return implode(', ', wp_list_pluck($industries, 'name'));
}

/**
 * Get case study services as formatted string
 */
function yoursite_get_case_study_services_string($post_id) {
    $services = get_the_terms($post_id, 'case_study_service');
    
    if (!$services || is_wp_error($services)) {
        return '';
    }
    
    return implode(', ', wp_list_pluck($services, 'name'));
}

/**
 * Check if case study is featured
 */
function yoursite_is_case_study_featured($post_id) {
    return get_post_meta($post_id, '_case_study_featured', true) === '1';
}

/**
 * Get case study stats for admin dashboard
 */
function yoursite_get_case_study_stats() {
    $total = wp_count_posts('case_studies')->publish;
    
    $featured = get_posts(array(
        'post_type' => 'case_studies',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_case_study_featured',
                'value' => '1',
                'compare' => '='
            )
        ),
        'fields' => 'ids'
    ));
    
    $industries = wp_count_terms(array(
        'taxonomy' => 'case_study_industry',
        'hide_empty' => true
    ));
    
    return array(
        'total' => $total,
        'featured' => count($featured),
        'industries' => $industries
    );
}

/**
 * Format case study technologies as badges
 */
function yoursite_format_case_study_technologies($technologies) {
    if (empty($technologies)) {
        return '';
    }
    
    $techs = array_map('trim', explode(',', $technologies));
    $output = '<div class="flex flex-wrap gap-2">';
    
    foreach ($techs as $tech) {
        if (!empty($tech)) {
            $output .= '<span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-sm">' . esc_html($tech) . '</span>';
        }
    }
    
    $output .= '</div>';
    
    return $output;
}
?>
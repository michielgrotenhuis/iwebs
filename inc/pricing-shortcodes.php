<?php
/**
 * Pricing Shortcodes
 * Create as: inc/pricing-shortcodes.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Shortcode for pricing comparison table
 * Usage: [pricing_comparison]
 */
function yoursite_pricing_comparison_shortcode($atts) {
    // Include the comparison table file if not already included
    if (!function_exists('yoursite_render_pricing_comparison_table')) {
        require_once get_template_directory() . '/inc/pricing-comparison-table.php';
    }
    
    $atts = shortcode_atts(array(
        'show_header' => 'true',
        'max_plans' => '6',
        'featured_only' => 'false'
    ), $atts, 'pricing_comparison');
    
    return yoursite_render_pricing_comparison_table();
}
add_shortcode('pricing_comparison', 'yoursite_pricing_comparison_shortcode');

/**
 * Shortcode for simple pricing cards
 * Usage: [pricing_cards limit="3" featured="true"]
 */
function yoursite_pricing_cards_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => '3',
        'featured' => 'false',
        'layout' => 'grid',
        'show_features' => 'true'
    ), $atts, 'pricing_cards');
    
    $args = array(
        'post_type' => 'pricing',
        'posts_per_page' => intval($atts['limit']),
        'post_status' => 'publish',
        'meta_key' => '_pricing_monthly_price',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
    );
    
    if ($atts['featured'] === 'true') {
        $args['meta_query'] = array(
            array(
                'key' => '_pricing_featured',
                'value' => '1',
                'compare' => '='
            )
        );
    }
    
    $plans = get_posts($args);
    
    if (empty($plans)) {
        return '<p class="text-center text-gray-500">' . __('No pricing plans found.', 'yoursite') . '</p>';
    }
    
    ob_start();
    ?>
    <div class="pricing-cards-shortcode">
        <div class="grid <?php echo count($plans) == 1 ? 'grid-cols-1' : (count($plans) == 2 ? 'grid-cols-1 md:grid-cols-2' : 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3'); ?> gap-8">
            <?php foreach ($plans as $plan) : 
                $meta = yoursite_get_pricing_meta_fields($plan->ID);
                $is_featured = $meta['pricing_featured'] === '1';
                $monthly_price = floatval($meta['pricing_monthly_price']);
                $currency_symbol = yoursite_get_currency_symbol($meta['pricing_currency']);
                ?>
                <div class="pricing-card <?php echo $is_featured ? 'featured-card' : ''; ?> bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden border border-gray-200 dark:border-gray-700">
                    
                    <?php if ($is_featured) : ?>
                        <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-2 text-sm font-semibold">
                            <?php _e('Most Popular', 'yoursite'); ?>
                        </div>
                        <div class="pt-10 pb-8 px-8">
                    <?php else : ?>
                        <div class="p-8">
                    <?php endif; ?>
                    
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            <?php echo esc_html($plan->post_title); ?>
                        </h3>
                        
                        <?php if ($plan->post_excerpt) : ?>
                            <p class="text-gray-600 dark:text-gray-300 mb-6">
                                <?php echo esc_html($plan->post_excerpt); ?>
                            </p>
                        <?php endif; ?>
                        
                        <div class="mb-8">
                            <span class="text-5xl font-bold text-gray-900 dark:text-white">
                                <?php echo $currency_symbol . number_format($monthly_price, 0); ?>
                            </span>
                            <span class="text-gray-600 dark:text-gray-400 text-lg ml-2">
                                /<?php _e('month', 'yoursite'); ?>
                            </span>
                        </div>
                        
                        <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>" 
                           class="<?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?> w-full text-center py-4 px-6 rounded-lg font-semibold text-lg mb-8 block transition-all duration-200 hover:transform hover:-translate-y-1">
                            <?php echo esc_html($meta['pricing_button_text'] ?: __('Get Started', 'yoursite')); ?>
                        </a>
                        
                        <?php if ($atts['show_features'] === 'true' && !empty($meta['pricing_features'])) : ?>
                            <ul class="space-y-4">
                                <?php 
                                $features = array_filter(explode("\n", $meta['pricing_features']));
                                foreach ($features as $feature) : 
                                    $feature = trim($feature);
                                    if (!empty($feature)) :
                                ?>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300"><?php echo esc_html($feature); ?></span>
                                    </li>
                                <?php endif; endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    
    return ob_get_clean();
}
add_shortcode('pricing_cards', 'yoursite_pricing_cards_shortcode');

/**
 * Shortcode for compare plans button
 * Usage: [compare_plans_button text="Compare All Plans"]
 */
function yoursite_compare_plans_button_shortcode($atts) {
    $atts = shortcode_atts(array(
        'text' => __('Compare All Plans', 'yoursite'),
        'class' => 'btn-secondary',
        'scroll_target' => '.pricing-comparison-wrapper'
    ), $atts, 'compare_plans_button');
    
    return sprintf(
        '<button class="%s" data-scroll-to-comparison="%s" onclick="document.querySelector(\'%s\').scrollIntoView({behavior: \'smooth\'})">%s</button>',
        esc_attr($atts['class']),
        esc_attr($atts['scroll_target']),
        esc_attr($atts['scroll_target']),
        esc_html($atts['text'])
    );
}
add_shortcode('compare_plans_button', 'yoursite_compare_plans_button_shortcode');

/**
 * Shortcode for pricing toggle
 * Usage: [pricing_toggle]
 */
function yoursite_pricing_toggle_shortcode($atts) {
    $atts = shortcode_atts(array(
        'monthly_text' => __('Monthly', 'yoursite'),
        'yearly_text' => __('Annual', 'yoursite'),
        'save_text' => __('Save 20%', 'yoursite'),
        'id' => 'shortcode-billing-toggle'
    ), $atts, 'pricing_toggle');
    
    ob_start();
    ?>
    <div class="pricing-toggle-shortcode flex items-center justify-center mb-8">
        <span class="text-gray-700 dark:text-gray-300 mr-4 font-medium shortcode-monthly-label">
            <?php echo esc_html($atts['monthly_text']); ?>
        </span>
        <div class="relative">
            <input type="checkbox" id="<?php echo esc_attr($atts['id']); ?>" class="sr-only peer">
            <label for="<?php echo esc_attr($atts['id']); ?>" class="relative inline-flex items-center justify-between w-16 h-8 bg-gray-200 dark:bg-gray-700 rounded-full cursor-pointer transition-colors duration-300 peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800">
                <span class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 peer-checked:translate-x-8"></span>
            </label>
        </div>
        <span class="text-gray-700 dark:text-gray-300 ml-4 font-medium shortcode-yearly-label">
            <?php echo esc_html($atts['yearly_text']); ?>
        </span>
        <span class="bg-emerald-500 text-emerald-50 dark:text-white text-sm font-semibold px-3 py-1 rounded-full ml-3 shadow-md">
            <?php echo esc_html($atts['save_text']); ?>
        </span>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const shortcodeToggle = document.getElementById('<?php echo esc_js($atts['id']); ?>');
        const mainToggle = document.getElementById('billing-toggle');
        const comparisonToggle = document.getElementById('comparison-billing-toggle');
        
        if (shortcodeToggle) {
            shortcodeToggle.addEventListener('change', function() {
                // Sync with main pricing toggle
                if (mainToggle) {
                    mainToggle.checked = this.checked;
                    mainToggle.dispatchEvent(new Event('change'));
                }
                
                // Sync with comparison toggle
                if (comparisonToggle) {
                    comparisonToggle.checked = this.checked;
                    comparisonToggle.dispatchEvent(new Event('change'));
                }
            });
        }
    });
    </script>
    <?php
    
    return ob_get_clean();
}
add_shortcode('pricing_toggle', 'yoursite_pricing_toggle_shortcode');

/**
 * Include required files for shortcodes
 */
function yoursite_load_pricing_shortcode_dependencies() {
    // Load pricing meta functions if not already loaded
    if (!function_exists('yoursite_get_pricing_meta_fields')) {
        require_once get_template_directory() . '/inc/pricing-meta-boxes.php';
    }
    
    // Load comparison table functions if not already loaded
    if (!function_exists('yoursite_render_pricing_comparison_table')) {
        require_once get_template_directory() . '/inc/pricing-comparison-table.php';
    }
}
add_action('init', 'yoursite_load_pricing_shortcode_dependencies');
?>
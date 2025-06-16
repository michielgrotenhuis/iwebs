<?php
/**
 * YourSite.biz Theme Functions - FIXED VERSION (No Duplicates)
 * Main functions file that loads modular components
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('YOURSITE_THEME_VERSION', '1.0.0');
define('YOURSITE_THEME_DIR', get_template_directory());
define('YOURSITE_THEME_URI', get_template_directory_uri());

/**
 * Create inc directory if it doesn't exist
 */
function yoursite_create_inc_directory() {
    $inc_dir = YOURSITE_THEME_DIR . '/inc';
    if (!file_exists($inc_dir)) {
        wp_mkdir_p($inc_dir);
    }
}
add_action('after_setup_theme', 'yoursite_create_inc_directory', 1);

/**
 * Load theme components
 */
function yoursite_load_components() {
    $components = array(
        'theme-setup.php',           // Theme setup and support
        'enqueue-scripts.php',       // Scripts and styles
        'customizer.php',            // Theme customizer
        'post-types.php',            // Custom post types
        'meta-boxes.php',            // Meta boxes for custom fields
        'widgets.php',               // Widget areas
        'helpers.php',               // Helper functions
        'ajax-handlers.php',         // AJAX form handlers
        'admin-functions.php',       // Admin panel functions
        'security.php',              // Security enhancements
        'theme-activation.php',      // Theme activation hooks
        'theme-modes.php'            // Dark/Light mode functionality
    );
    
    foreach ($components as $component) {
        $file = YOURSITE_THEME_DIR . '/inc/' . $component;
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
add_action('after_setup_theme', 'yoursite_load_components', 5);

/**
 * GUIDE CONTENT FORMATTING FIXES - IMPROVED VERSION
 * These functions ensure proper display of guide content
 * Note: These are NEW functions that don't exist in inc files
 */

/**
 * Ensure proper content formatting for guides - FIXED
 */
function yoursite_fix_guide_content_display($content) {
    // Check if content is null or empty
    if (empty($content)) {
        return $content;
    }
    
    // Only apply to guide posts
    if (get_post_type() !== 'guide') {
        return $content;
    }
    
    // Ensure paragraphs are properly wrapped
    if (!has_blocks($content)) {
        // For classic editor content, apply wpautop
        $content = wpautop($content);
    }
    
    // Fix common spacing issues - with proper escaping
    $content = str_replace("\n\n\n", "\n\n", $content);
    $content = str_replace("<p></p>", "", $content);
    
    // Ensure proper spacing around headings - FIXED regex
    $content = preg_replace('/<\/p>\s*(<h[1-6][^>]*>)/', "</p>\n\n$1", $content);
    $content = preg_replace('/(<\/h[1-6]>)\s*<p>/', "$1\n\n<p", $content);
    
    // Fix list spacing - FIXED regex
    $content = preg_replace('/<\/p>\s*(<[ou]l[^>]*>)/', "</p>\n\n$1", $content);
    $content = preg_replace('/(<\/[ou]l>)\s*<p>/', "$1\n\n<p", $content);
    
    return $content;
}
add_filter('the_content', 'yoursite_fix_guide_content_display', 9);

/**
 * Ensure proper paragraph spacing for guides - FIXED
 */
function yoursite_guide_paragraph_spacing($content) {
    // Check if content is null or empty
    if (empty($content)) {
        return $content;
    }
    
    if (get_post_type() === 'guide' && !has_blocks($content)) {
        // Apply wpautop with better spacing
        $content = wpautop($content, true);
        
        // Add extra spacing for readability
        $content = str_replace('</p>', "</p>\n", $content);
    }
    
    return $content;
}
add_filter('the_content', 'yoursite_guide_paragraph_spacing', 8);

/**
 * Add reading time tracking (simple view counter)
 */
function yoursite_track_guide_page_views() {
    if (is_singular('guide')) {
        $post_id = get_the_ID();
        $views = get_post_meta($post_id, 'guide_views', true);
        $views = $views ? intval($views) + 1 : 1;
        update_post_meta($post_id, 'guide_views', $views);
    }
}
add_action('wp_head', 'yoursite_track_guide_page_views');

/**
 * Fix block editor content for guides - FIXED
 */
function yoursite_fix_guide_block_spacing($content) {
    // Check if content is null or empty
    if (empty($content)) {
        return $content;
    }
    
    if (get_post_type() !== 'guide') {
        return $content;
    }
    
    // Ensure blocks have proper spacing - FIXED regex
    $content = preg_replace('/<!-- \/wp:paragraph -->\s*<!-- wp:paragraph -->/', "<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->", $content);
    
    // Fix heading spacing - FIXED regex
    $content = preg_replace('/<!-- \/wp:(paragraph|list|quote) -->\s*<!-- wp:heading/', "<!-- /wp:$1 -->\n\n<!-- wp:heading", $content);
    $content = preg_replace('/<!-- \/wp:heading -->\s*<!-- wp:(paragraph|list|quote)/', "<!-- /wp:heading -->\n\n<!-- wp:$1", $content);
    
    return $content;
}
add_filter('the_content', 'yoursite_fix_guide_block_spacing', 7);

/**
 * Ensure code blocks are properly formatted - FIXED
 */
function yoursite_format_guide_code_blocks($content) {
    // Check if content is null or empty
    if (empty($content)) {
        return $content;
    }
    
    if (get_post_type() !== 'guide') {
        return $content;
    }
    
    // Add language class to code blocks if missing
    $content = preg_replace('/<pre class="wp-block-code"><code>/', '<pre class="wp-block-code"><code class="language-text">', $content);
    
    // Ensure pre tags have proper classes
    $content = preg_replace('/<pre(?![^>]*class=)/', '<pre class="wp-block-code"', $content);
    
    return $content;
}
add_filter('the_content', 'yoursite_format_guide_code_blocks', 10);

/**
 * Add custom body class for guides to help with styling
 */
function yoursite_add_guide_body_classes($classes) {
    if (is_singular('guide')) {
        $classes[] = 'single-guide-page';
        
        // Add difficulty class
        $difficulty = get_post_meta(get_the_ID(), '_guide_difficulty', true);
        if ($difficulty) {
            $classes[] = 'guide-difficulty-' . $difficulty;
        }
        
        // Add category class
        $categories = get_the_terms(get_the_ID(), 'guide_category');
        if ($categories && !is_wp_error($categories)) {
            $classes[] = 'guide-category-' . $categories[0]->slug;
        }
    }
    
    return $classes;
}
add_filter('body_class', 'yoursite_add_guide_body_classes');

/**
 * Add schema markup for guides
 */
function yoursite_add_guide_schema() {
    if (is_singular('guide')) {
        $post_id = get_the_ID();
        
        // Use helper function if it exists, otherwise calculate reading time
        if (function_exists('yoursite_get_reading_time')) {
            $reading_time = yoursite_get_reading_time($post_id);
        } else {
            $content = get_post_field('post_content', $post_id);
            $word_count = str_word_count(strip_tags($content));
            $reading_time = max(1, ceil($word_count / 200));
        }
        
        $difficulty = get_post_meta($post_id, '_guide_difficulty', true) ?: 'beginner';
        $categories = get_the_terms($post_id, 'guide_category');
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'HowTo',
            'name' => get_the_title(),
            'description' => get_the_excerpt() ?: wp_trim_words(get_the_content(), 20),
            'url' => get_permalink(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name')
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name')
            ),
            'totalTime' => 'PT' . $reading_time . 'M',
            'difficulty' => ucfirst($difficulty)
        );
        
        if ($categories && !is_wp_error($categories)) {
            $schema['about'] = array(
                '@type' => 'Thing',
                'name' => $categories[0]->name
            );
        }
        
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}
add_action('wp_head', 'yoursite_add_guide_schema');

/**
 * Add print styles for guides
 */
function yoursite_add_guide_print_styles() {
    if (is_singular('guide')) {
        ?>
        <style media="print">
        @page {
            margin: 1in;
        }
        
        .site-header,
        .site-footer,
        .guide-navigation,
        .sidebar,
        .breadcrumbs,
        .guide-meta,
        .quick-links,
        .related-guides,
        .copy-code-btn {
            display: none !important;
        }
        
        .guide-content {
            font-size: 12pt !important;
            line-height: 1.4 !important;
            color: #000 !important;
        }
        
        .guide-content h1,
        .guide-content h2,
        .guide-content h3,
        .guide-content h4,
        .guide-content h5,
        .guide-content h6 {
            page-break-after: avoid !important;
            font-weight: bold !important;
            color: #000 !important;
        }
        
        .guide-content pre,
        .guide-content code {
            background: #f5f5f5 !important;
            border: 1px solid #ccc !important;
            page-break-inside: avoid !important;
        }
        
        .guide-content img {
            max-width: 100% !important;
            page-break-inside: avoid !important;
        }
        
        .guide-content a {
            color: #000 !important;
            text-decoration: underline !important;
        }
        
        .guide-content blockquote {
            border-left: 2px solid #ccc !important;
            background: #f9f9f9 !important;
            page-break-inside: avoid !important;
        }
        </style>
        <?php
    }
}
add_action('wp_head', 'yoursite_add_guide_print_styles');

/**
 * Fix WordPress autop for better guide formatting - FIXED
 */
function yoursite_improve_guide_autop($content) {
    // Check if content is null or empty
    if (empty($content)) {
        return $content;
    }
    
    if (get_post_type() === 'guide') {
        // Remove autop from shortcodes and code blocks - FIXED regex
        $content = preg_replace('/<p>(\s*)(<pre[^>]*>.*?<\/pre>)(\s*)<\/p>/s', '$1$2$3', $content);
        $content = preg_replace('/<p>(\s*)(<blockquote[^>]*>.*?<\/blockquote>)(\s*)<\/p>/s', '$1$2$3', $content);
        
        // Ensure proper spacing after headings - FIXED regex
        $content = preg_replace('/(<\/h[1-6]>)(\s*)(<p>)/', "$1\n\n$3", $content);
    }
    
    return $content;
}
add_filter('the_content', 'yoursite_improve_guide_autop', 11);

/**
 * Ensure guides work with WordPress 6.0+ features
 */
function yoursite_enhance_guide_compatibility() {
    // Add support for block editor features
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    
    // Ensure guide post type supports block editor
    add_post_type_support('guide', 'editor');
    add_post_type_support('guide', 'custom-fields');
}
add_action('after_setup_theme', 'yoursite_enhance_guide_compatibility', 15);

/**
 * Fallback functions in case inc files don't load
 */
if (!function_exists('yoursite_theme_setup_fallback')) {
    function yoursite_theme_setup_fallback() {
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('custom-logo');
    }
    add_action('after_setup_theme', 'yoursite_theme_setup_fallback', 20);
}

if (!function_exists('yoursite_enqueue_scripts_fallback')) {
    function yoursite_enqueue_scripts_fallback() {
        wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), YOURSITE_THEME_VERSION);
    }
    add_action('wp_enqueue_scripts', 'yoursite_enqueue_scripts_fallback', 20);
}
?>
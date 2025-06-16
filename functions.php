<?php
/**
 * YourSite.biz Theme Functions - FIXED VERSION WITH COMPLETE LOGO GENERATOR
 * Main functions file that loads modular components and includes logo generator
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

// =============================================================================
// COMPLETE LOGO GENERATOR SYSTEM - FIXED VERSION
// =============================================================================

/**
 * Complete Logo Generator Class - FIXED WITH ALL METHODS
 */
if (!class_exists('YourSite_Logo_Generator')) {
    
    class YourSite_Logo_Generator {
        
        private $cache_dir;
        private $cache_url;
        
        public function __construct() {
            $upload_dir = wp_upload_dir();
            $this->cache_dir = $upload_dir['basedir'] . '/logo-cache/';
            $this->cache_url = $upload_dir['baseurl'] . '/logo-cache/';
            
            // Create cache directory
            if (!file_exists($this->cache_dir)) {
                wp_mkdir_p($this->cache_dir);
            }
            
            // Add AJAX hooks
            add_action('wp_ajax_generate_logo_pack', array($this, 'ajax_generate_logo_pack'));
            add_action('wp_ajax_nopriv_generate_logo_pack', array($this, 'ajax_generate_logo_pack'));
            add_action('wp_ajax_download_logo_zip', array($this, 'ajax_download_logo_zip'));
            add_action('wp_ajax_nopriv_download_logo_zip', array($this, 'ajax_download_logo_zip'));
        }
        
        /**
         * Get the current site logo
         */
        private function get_site_logo() {
            $custom_logo_id = get_theme_mod('custom_logo');
            if (!$custom_logo_id) {
                return false;
            }
            
            return array(
                'id' => $custom_logo_id,
                'url' => wp_get_attachment_url($custom_logo_id),
                'path' => get_attached_file($custom_logo_id),
                'mime_type' => get_post_mime_type($custom_logo_id)
            );
        }
        
        /**
         * Generate actual logo variations
         */
        public function generate_logo_variations() {
            $logo = $this->get_site_logo();
            if (!$logo) {
                return array();
            }
            
            $variations = array();
            
            // Check if we can process images
            if (!extension_loaded('gd')) {
                // Return original logo for all variations if GD not available
                return $this->get_fallback_variations($logo);
            }
            
            try {
                // Generate primary (original optimized)
                $variations['primary'] = $this->create_primary_variation($logo);
                
                // Generate white version - FIXED
                $variations['white'] = $this->create_white_variation($logo);
                
                // Generate black version - FIXED
                $variations['black'] = $this->create_black_variation($logo);
                
                // Generate grayscale version - FIXED
                $variations['grayscale'] = $this->create_grayscale_variation($logo);
                
                // Generate transparent version
                $variations['transparent'] = $this->create_transparent_variation($logo);
                
            } catch (Exception $e) {
                // Fallback if image processing fails
                error_log('Logo generation error: ' . $e->getMessage());
                return $this->get_fallback_variations($logo);
            }
            
            return $variations;
        }
        
        /**
         * Create primary logo variation (optimized original)
         */
        private function create_primary_variation($logo) {
            $filename = 'primary-logo-' . $logo['id'] . '.png';
            $output_path = $this->cache_dir . $filename;
            $output_url = $this->cache_url . $filename;
            
            // Check if file exists and is newer than original
            if (file_exists($output_path) && filemtime($output_path) >= filemtime($logo['path'])) {
                return array(
                    'url' => $output_url,
                    'path' => $output_path,
                    'type' => 'primary'
                );
            }
            
            // For SVG, just copy the file
            if ($logo['mime_type'] === 'image/svg+xml') {
                copy($logo['path'], $output_path);
                return array(
                    'url' => $output_url,
                    'path' => $output_path,
                    'type' => 'primary'
                );
            }
            
            // Load and save as optimized PNG
            $image = $this->load_image($logo['path']);
            if ($image) {
                // Preserve transparency
                imagealphablending($image, false);
                imagesavealpha($image, true);
                imagepng($image, $output_path, 9);
                imagedestroy($image);
                
                return array(
                    'url' => $output_url,
                    'path' => $output_path,
                    'type' => 'primary'
                );
            }
            
            return false;
        }
        
    /**
         * COMPLETELY FIXED: Create white logo variation - SIMPLE APPROACH
         */
        private function create_white_variation($logo) {
            $filename = 'white-logo-' . $logo['id'] . '.png';
            $output_path = $this->cache_dir . $filename;
            $output_url = $this->cache_url . $filename;
            
            if (file_exists($output_path) && filemtime($output_path) >= filemtime($logo['path'])) {
                return array(
                    'url' => $output_url,
                    'path' => $output_path,
                    'type' => 'white'
                );
            }
            
            // Handle SVG
            if ($logo['mime_type'] === 'image/svg+xml') {
                return $this->create_svg_variation($logo, 'white', $output_path, $output_url);
            }
            
            // SIMPLE APPROACH: Just change non-transparent pixels to white
            $image = $this->load_image($logo['path']);
            if (!$image) return false;
            
            $width = imagesx($image);
            $height = imagesy($image);
            
            // Create new image
            $white_image = imagecreatetruecolor($width, $height);
            imagealphablending($white_image, false);
            imagesavealpha($white_image, true);
            
            // Fill with transparent background
            $transparent = imagecolorallocatealpha($white_image, 0, 0, 0, 127);
            imagefill($white_image, 0, 0, $transparent);
            
            // Simple conversion: any non-transparent pixel becomes white
            for ($x = 0; $x < $width; $x++) {
                for ($y = 0; $y < $height; $y++) {
                    $rgba = imagecolorat($image, $x, $y);
                    $alpha = ($rgba & 0x7F000000) >> 24;
                    
                    // If pixel is not fully transparent, make it white with same transparency
                    if ($alpha < 127) {
                        $white_color = imagecolorallocatealpha($white_image, 255, 255, 255, $alpha);
                        imagesetpixel($white_image, $x, $y, $white_color);
                    }
                }
            }
            
            imagepng($white_image, $output_path, 9);
            imagedestroy($image);
            imagedestroy($white_image);
            
            return array(
                'url' => $output_url,
                'path' => $output_path,
                'type' => 'white'
            );
        }
        
        /**
         * COMPLETELY FIXED: Create black logo variation - SIMPLE APPROACH
         */
        private function create_black_variation($logo) {
            $filename = 'black-logo-' . $logo['id'] . '.png';
            $output_path = $this->cache_dir . $filename;
            $output_url = $this->cache_url . $filename;
            
            if (file_exists($output_path) && filemtime($output_path) >= filemtime($logo['path'])) {
                return array(
                    'url' => $output_url,
                    'path' => $output_path,
                    'type' => 'black'
                );
            }
            
            // Handle SVG
            if ($logo['mime_type'] === 'image/svg+xml') {
                return $this->create_svg_variation($logo, 'black', $output_path, $output_url);
            }
            
            // SIMPLE APPROACH: Just change non-transparent pixels to black
            $image = $this->load_image($logo['path']);
            if (!$image) return false;
            
            $width = imagesx($image);
            $height = imagesy($image);
            
            // Create new image
            $black_image = imagecreatetruecolor($width, $height);
            imagealphablending($black_image, false);
            imagesavealpha($black_image, true);
            
            // Fill with transparent background
            $transparent = imagecolorallocatealpha($black_image, 0, 0, 0, 127);
            imagefill($black_image, 0, 0, $transparent);
            
            // Simple conversion: any non-transparent pixel becomes black
            for ($x = 0; $x < $width; $x++) {
                for ($y = 0; $y < $height; $y++) {
                    $rgba = imagecolorat($image, $x, $y);
                    $alpha = ($rgba & 0x7F000000) >> 24;
                    
                    // If pixel is not fully transparent, make it black with same transparency
                    if ($alpha < 127) {
                        $black_color = imagecolorallocatealpha($black_image, 0, 0, 0, $alpha);
                        imagesetpixel($black_image, $x, $y, $black_color);
                    }
                }
            }
            
            imagepng($black_image, $output_path, 9);
            imagedestroy($image);
            imagedestroy($black_image);
            
            return array(
                'url' => $output_url,
                'path' => $output_path,
                'type' => 'black'
            );
        }
        
        /**
         * ALTERNATIVE METHOD: Create white logo using colorize filter
         */
        private function create_white_variation_alternative($logo) {
            $filename = 'white-logo-' . $logo['id'] . '.png';
            $output_path = $this->cache_dir . $filename;
            $output_url = $this->cache_url . $filename;
            
            if (file_exists($output_path) && filemtime($output_path) >= filemtime($logo['path'])) {
                return array(
                    'url' => $output_url,
                    'path' => $output_path,
                    'type' => 'white'
                );
            }
            
            // Handle SVG
            if ($logo['mime_type'] === 'image/svg+xml') {
                return $this->create_svg_variation($logo, 'white', $output_path, $output_url);
            }
            
            $image = $this->load_image($logo['path']);
            if (!$image) return false;
            
            // Method 2: Use imagefilter with colorize
            // First convert to grayscale, then colorize to white
            imagefilter($image, IMG_FILTER_GRAYSCALE);
            imagefilter($image, IMG_FILTER_COLORIZE, 255, 255, 255);
            
            imagepng($image, $output_path, 9);
            imagedestroy($image);
            
            return array(
                'url' => $output_url,
                'path' => $output_path,
                'type' => 'white'
            );
        }
        
        /**
         * ALTERNATIVE METHOD: Create black logo using colorize filter
         */
        private function create_black_variation_alternative($logo) {
            $filename = 'black-logo-' . $logo['id'] . '.png';
            $output_path = $this->cache_dir . $filename;
            $output_url = $this->cache_url . $filename;
            
            if (file_exists($output_path) && filemtime($output_path) >= filemtime($logo['path'])) {
                return array(
                    'url' => $output_url,
                    'path' => $output_path,
                    'type' => 'black'
                );
            }
            
            // Handle SVG
            if ($logo['mime_type'] === 'image/svg+xml') {
                return $this->create_svg_variation($logo, 'black', $output_path, $output_url);
            }
            
            $image = $this->load_image($logo['path']);
            if (!$image) return false;
            
            // Method 2: Use imagefilter with colorize
            // First convert to grayscale, then colorize to black
            imagefilter($image, IMG_FILTER_GRAYSCALE);
            imagefilter($image, IMG_FILTER_COLORIZE, -255, -255, -255);
            
            imagepng($image, $output_path, 9);
            imagedestroy($image);
            
            return array(
                'url' => $output_url,
                'path' => $output_path,
                'type' => 'black'
            );
        }
        
        /**
         * FIXED: Create grayscale logo variation
         */
        private function create_grayscale_variation($logo) {
            $filename = 'grayscale-logo-' . $logo['id'] . '.png';
            $output_path = $this->cache_dir . $filename;
            $output_url = $this->cache_url . $filename;
            
            if (file_exists($output_path) && filemtime($output_path) >= filemtime($logo['path'])) {
                return array(
                    'url' => $output_url,
                    'path' => $output_path,
                    'type' => 'grayscale'
                );
            }
            
            // Handle SVG
            if ($logo['mime_type'] === 'image/svg+xml') {
                return $this->create_svg_variation($logo, 'grayscale', $output_path, $output_url);
            }
            
            $image = $this->load_image($logo['path']);
            if (!$image) return false;
            
            // Preserve transparency
            imagealphablending($image, false);
            imagesavealpha($image, true);
            
            // Try built-in grayscale filter first
            if (!imagefilter($image, IMG_FILTER_GRAYSCALE)) {
                // Fallback: manual grayscale conversion
                $width = imagesx($image);
                $height = imagesy($image);
                
                for ($x = 0; $x < $width; $x++) {
                    for ($y = 0; $y < $height; $y++) {
                        $rgba = imagecolorat($image, $x, $y);
                        $alpha = ($rgba & 0x7F000000) >> 24;
                        $red = ($rgba >> 16) & 0xFF;
                        $green = ($rgba >> 8) & 0xFF;
                        $blue = $rgba & 0xFF;
                        
                        // Convert to grayscale using luminance formula
                        $gray = intval(0.299 * $red + 0.587 * $green + 0.114 * $blue);
                        
                        $gray_color = imagecolorallocatealpha($image, $gray, $gray, $gray, $alpha);
                        imagesetpixel($image, $x, $y, $gray_color);
                    }
                }
            }
            
            imagepng($image, $output_path, 9);
            imagedestroy($image);
            
            return array(
                'url' => $output_url,
                'path' => $output_path,
                'type' => 'grayscale'
            );
        }
        
        /**
         * Create transparent logo variation
         */
        private function create_transparent_variation($logo) {
            $filename = 'transparent-logo-' . $logo['id'] . '.png';
            $output_path = $this->cache_dir . $filename;
            $output_url = $this->cache_url . $filename;
            
            if (file_exists($output_path) && filemtime($output_path) >= filemtime($logo['path'])) {
                return array(
                    'url' => $output_url,
                    'path' => $output_path,
                    'type' => 'transparent'
                );
            }
            
            // For SVG, just copy as it's already transparent
            if ($logo['mime_type'] === 'image/svg+xml') {
                copy($logo['path'], str_replace('.png', '.svg', $output_path));
                return array(
                    'url' => str_replace('.png', '.svg', $output_url),
                    'path' => str_replace('.png', '.svg', $output_path),
                    'type' => 'transparent'
                );
            }
            
            $image = $this->load_image($logo['path']);
            if (!$image) return false;
            
            // Ensure transparency is preserved
            imagealphablending($image, false);
            imagesavealpha($image, true);
            
            imagepng($image, $output_path, 9);
            imagedestroy($image);
            
            return array(
                'url' => $output_url,
                'path' => $output_path,
                'type' => 'transparent'
            );
        }
        
        /**
         * Create SVG variations
         */
        private function create_svg_variation($logo, $type, $output_path, $output_url) {
            $svg_content = file_get_contents($logo['path']);
            
            switch ($type) {
                case 'white':
                    // Replace fill colors with white (but not none/transparent)
                    $svg_content = preg_replace('/fill\s*=\s*["\'][^"\']*["\'](?![^>]*fill\s*=\s*["\'](?:none|transparent)["\'])/i', 'fill="white"', $svg_content);
                    $svg_content = preg_replace('/stroke\s*=\s*["\'][^"\']*["\'](?![^>]*stroke\s*=\s*["\'](?:none|transparent)["\'])/i', 'stroke="white"', $svg_content);
                    break;
                    
                case 'black':
                    // Replace fill colors with black (but not none/transparent)
                    $svg_content = preg_replace('/fill\s*=\s*["\'][^"\']*["\'](?![^>]*fill\s*=\s*["\'](?:none|transparent)["\'])/i', 'fill="black"', $svg_content);
                    $svg_content = preg_replace('/stroke\s*=\s*["\'][^"\']*["\'](?![^>]*stroke\s*=\s*["\'](?:none|transparent)["\'])/i', 'stroke="black"', $svg_content);
                    break;
                    
                case 'grayscale':
                    // Add grayscale filter
                    $filter = '<defs><filter id="grayscale" x="0%" y="0%" width="100%" height="100%">
                        <feColorMatrix type="matrix" values="0.299 0.587 0.114 0 0
                                                             0.299 0.587 0.114 0 0  
                                                             0.299 0.587 0.114 0 0
                                                             0     0     0     1 0"/>
                    </filter></defs>';
                    
                    if (preg_match('/<svg[^>]*>/', $svg_content, $matches)) {
                        $svg_tag = $matches[0];
                        // Add filter
                        if (strpos($svg_tag, 'style=') !== false) {
                            $svg_tag = preg_replace('/style="([^"]*)"/', 'style="$1; filter: url(#grayscale);"', $svg_tag);
                        } else {
                            $svg_tag = str_replace('>', ' style="filter: url(#grayscale);">', $svg_tag);
                        }
                        $svg_content = str_replace($matches[0], $filter . $svg_tag, $svg_content);
                    }
                    break;
            }
            
            // Save as SVG
            $svg_path = str_replace('.png', '.svg', $output_path);
            $svg_url = str_replace('.png', '.svg', $output_url);
            
            file_put_contents($svg_path, $svg_content);
            
            return array(
                'url' => $svg_url,
                'path' => $svg_path,
                'type' => $type
            );
        }
        
        /**
         * Load image from file with proper transparency handling
         */
        private function load_image($path) {
            $image_info = getimagesize($path);
            if (!$image_info) return false;
            
            $image = false;
            
            switch ($image_info['mime']) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($path);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($path);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($path);
                    break;
                case 'image/webp':
                    if (function_exists('imagecreatefromwebp')) {
                        $image = imagecreatefromwebp($path);
                    } else {
                        return false;
                    }
                    break;
                default:
                    return false;
            }
            
            // Enable alpha blending for transparency
            if ($image) {
                imagealphablending($image, false);
                imagesavealpha($image, true);
            }
            
            return $image;
        }
        
        /**
         * Get fallback variations (same logo for all if processing fails)
         */
        private function get_fallback_variations($logo) {
            return array(
                'primary' => array('url' => $logo['url'], 'type' => 'primary'),
                'white' => array('url' => $logo['url'], 'type' => 'white'),
                'black' => array('url' => $logo['url'], 'type' => 'black'),
                'grayscale' => array('url' => $logo['url'], 'type' => 'grayscale'),
                'transparent' => array('url' => $logo['url'], 'type' => 'transparent')
            );
        }
        
        /**
         * Get logo variations for display
         */
        public function get_logo_variations_for_display() {
            $variations = $this->generate_logo_variations();
            
            $display_data = array();
            $variation_info = array(
                'primary' => array('name' => 'Primary Logo', 'desc' => 'Full color logo for light backgrounds'),
                'white' => array('name' => 'White Logo', 'desc' => 'White logo for dark backgrounds'),
                'black' => array('name' => 'Black Logo', 'desc' => 'Black logo for light backgrounds'),
                'grayscale' => array('name' => 'Grayscale Logo', 'desc' => 'Monochrome logo for special uses'),
                'transparent' => array('name' => 'Transparent Logo', 'desc' => 'Logo with transparent background')
            );
            
            foreach ($variations as $type => $variation) {
                if ($variation && isset($variation['url'])) {
                    $info = $variation_info[$type];
                    $display_data[$type] = array(
                        'name' => $info['name'],
                        'description' => $info['desc'],
                        'preview_url' => $variation['url'],
                        'sizes' => array() // Could add different sizes here
                    );
                }
            }
            
            return $display_data;
        }
        
        /**
         * FIXED: Clear logo cache method
         */
        public function clear_logo_cache() {
            $files = glob($this->cache_dir . '*');
            $deleted = 0;
            
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $deleted++;
                }
            }
            
            // Clear transients
            global $wpdb;
            $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_logo_variations_%'");
            $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_logo_variations_%'");
            
            return $deleted;
        }
        
        /**
         * DEBUGGING: Add a method to test image processing
         */
        public function debug_image_processing($logo_id) {
            $logo = $this->get_site_logo();
            if (!$logo) {
                return 'No logo found';
            }
            
            $debug_info = array();
            $debug_info['original'] = array(
                'path' => $logo['path'],
                'url' => $logo['url'],
                'mime_type' => $logo['mime_type'],
                'exists' => file_exists($logo['path']),
                'readable' => is_readable($logo['path']),
                'size' => filesize($logo['path'])
            );
            
            // Test image loading
            $test_image = $this->load_image($logo['path']);
            $debug_info['image_loading'] = array(
                'loaded' => $test_image !== false,
                'gd_enabled' => extension_loaded('gd'),
                'gd_info' => function_exists('gd_info') ? gd_info() : 'gd_info not available'
            );
            
            if ($test_image) {
                $debug_info['image_properties'] = array(
                    'width' => imagesx($test_image),
                    'height' => imagesy($test_image),
                    'type' => 'resource'
                );
                imagedestroy($test_image);
            }
            
            return $debug_info;
        }
        
        /**
         * Create downloadable ZIP package
         */
        public function create_logo_package() {
            if (!class_exists('ZipArchive')) {
                return new WP_Error('zip_not_available', 'ZIP extension not available');
            }
            
            $variations = $this->generate_logo_variations();
            if (empty($variations)) {
                return new WP_Error('no_variations', 'No logo variations available');
            }
            
            $zip_filename = 'logo-package-' . time() . '.zip';
            $zip_path = $this->cache_dir . $zip_filename;
            $zip_url = $this->cache_url . $zip_filename;
            
            $zip = new ZipArchive();
            if ($zip->open($zip_path, ZipArchive::CREATE) !== TRUE) {
                return new WP_Error('zip_create_failed', 'Cannot create ZIP file');
            }
            
            // Add logo files to ZIP
            foreach ($variations as $type => $variation) {
                if ($variation && isset($variation['path']) && file_exists($variation['path'])) {
                    $zip->addFile($variation['path'], $type . '/' . basename($variation['path']));
                }
            }
            
            // Add README
            $readme = $this->generate_readme();
            $zip->addFromString('README.txt', $readme);
            
            $zip->close();
            
            return array(
                'url' => $zip_url,
                'path' => $zip_path,
                'filename' => $zip_filename
            );
        }
        
        /**
         * Generate README content
         */
        private function generate_readme() {
            $site_name = get_bloginfo('name');
            $date = date('Y-m-d H:i:s');
            
            return "Logo Package for {$site_name}
Generated: {$date}

This package contains various formats of the {$site_name} logo:

VARIATIONS:
- primary/: Original logo in high quality
- white/: White version for dark backgrounds  
- black/: Black version for light backgrounds
- grayscale/: Grayscale version
- transparent/: Transparent background version

USAGE GUIDELINES:
- Use appropriate variation for your background
- Maintain aspect ratio when resizing
- Don't modify colors or add effects
- Provide adequate white space around logo

© " . date('Y') . " {$site_name}. All rights reserved.";
        }
        
        /**
         * AJAX handlers
         */
        public function ajax_generate_logo_pack() {
            if (!wp_verify_nonce($_POST['nonce'] ?? '', 'logo_generator_nonce')) {
                wp_send_json_error('Security check failed');
            }
            
            $variations = $this->get_logo_variations_for_display();
            wp_send_json_success($variations);
        }
        
        public function ajax_download_logo_zip() {
            if (!wp_verify_nonce($_POST['nonce'] ?? '', 'logo_generator_nonce')) {
                wp_send_json_error('Security check failed');
            }
            
            $package = $this->create_logo_package();
            
            if (is_wp_error($package)) {
                wp_send_json_error($package->get_error_message());
            }
            
            wp_send_json_success($package);
        }
    }
    
    // Initialize the logo generator
    new YourSite_Logo_Generator();
}

// =============================================================================
// LOGO GENERATOR ADMIN INTERFACE
// =============================================================================

/**
 * Add admin menu for logo generator
 */
function yoursite_add_logo_generator_menu() {
    add_submenu_page(
        'tools.php',
        'Logo Generator',
        'Logo Generator',
        'manage_options',
        'logo-generator',
        'yoursite_logo_generator_admin_page'
    );
}
add_action('admin_menu', 'yoursite_add_logo_generator_menu');

/**
 * Logo generator admin page
 */
function yoursite_logo_generator_admin_page() {
    $custom_logo_id = get_theme_mod('custom_logo');
    
    // Handle cache clearing
    if (isset($_POST['clear_cache']) && wp_verify_nonce($_POST['_wpnonce'], 'clear_logo_cache')) {
        yoursite_clear_logo_cache();
        echo '<div class="notice notice-success"><p>Logo cache cleared successfully!</p></div>';
    }
    
    // Handle test generation
    if (isset($_POST['test_generation']) && wp_verify_nonce($_POST['_wpnonce'], 'test_generation')) {
        if (class_exists('YourSite_Logo_Generator')) {
            $generator = new YourSite_Logo_Generator();
            $variations = $generator->get_logo_variations_for_display();
            echo '<div class="notice notice-success"><p>Generated ' . count($variations) . ' logo variations!</p></div>';
        }
    }
    
    ?>
    <div class="wrap">
        <h1>Logo Generator</h1>
        
        <?php if ($custom_logo_id): ?>
            <div class="card">
                <h2>Current Logo</h2>
                <div style="background: #f9f9f9; padding: 20px; display: inline-block; margin: 10px 0;">
                    <?php echo wp_get_attachment_image($custom_logo_id, 'medium'); ?>
                </div>
                <p><strong>Logo ID:</strong> <?php echo $custom_logo_id; ?></p>
                <p><strong>File:</strong> <?php echo basename(get_attached_file($custom_logo_id)); ?></p>
                <p><strong>Type:</strong> <?php echo get_post_mime_type($custom_logo_id); ?></p>
            </div>
            
            <div class="card">
                <h2>System Status</h2>
                <table class="widefat">
                    <tr>
                        <td>PHP GD Extension</td>
                        <td><?php echo extension_loaded('gd') ? '<span style="color:green;">✓ Available</span>' : '<span style="color:red;">✗ Missing</span>'; ?></td>
                    </tr>
                    <tr>
                        <td>PHP ZIP Extension</td>
                        <td><?php echo extension_loaded('zip') ? '<span style="color:green;">✓ Available</span>' : '<span style="color:red;">✗ Missing</span>'; ?></td>
                    </tr>
                    <tr>
                        <td>Cache Directory</td>
                        <td>
                            <?php 
                            $upload_dir = wp_upload_dir();
                            $cache_dir = $upload_dir['basedir'] . '/logo-cache/';
                            echo is_writable($cache_dir) ? '<span style="color:green;">✓ Writable</span>' : '<span style="color:red;">✗ Not writable</span>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Logo Generator Class</td>
                        <td><?php echo class_exists('YourSite_Logo_Generator') ? '<span style="color:green;">✓ Loaded</span>' : '<span style="color:red;">✗ Not loaded</span>'; ?></td>
                    </tr>
                </table>
            </div>
            
            <?php if (class_exists('YourSite_Logo_Generator')): ?>
                <div class="card">
                    <h2>Test Logo Generation</h2>
                    <form method="post">
                        <?php wp_nonce_field('test_generation'); ?>
                        <p>
                            <input type="submit" name="test_generation" class="button button-primary" value="Generate Logo Variations">
                        </p>
                    </form>
                    
                    <?php
                    // Show current variations
                    $generator = new YourSite_Logo_Generator();
                    $variations = $generator->get_logo_variations_for_display();
                    
                    if (!empty($variations)):
                    ?>
                        <h3>Generated Variations</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0;">
                            <?php foreach ($variations as $type => $variation): ?>
                                <div style="border: 1px solid #ddd; padding: 15px; text-align: center;">
                                    <h4><?php echo esc_html($variation['name']); ?></h4>
                                    
                                    <?php if ($type === 'white'): ?>
                                        <div style="background: #333; padding: 20px; margin: 10px 0;">
                                            <img src="<?php echo esc_url($variation['preview_url']); ?>" style="max-width: 100px; max-height: 50px;" alt="<?php echo esc_attr($variation['name']); ?>">
                                        </div>
                                    <?php else: ?>
                                        <div style="background: #f9f9f9; padding: 20px; margin: 10px 0;">
                                            <img src="<?php echo esc_url($variation['preview_url']); ?>" style="max-width: 100px; max-height: 50px;" alt="<?php echo esc_attr($variation['name']); ?>">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <p><small><?php echo esc_html($variation['description']); ?></small></p>
                                    <p>
                                        <a href="<?php echo esc_url($variation['preview_url']); ?>" target="_blank" class="button button-small">View Full Size</a>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="card">
                    <h2>Cache Management</h2>
                    <?php
                    $upload_dir = wp_upload_dir();
                    $cache_dir = $upload_dir['basedir'] . '/logo-cache/';
                    $cache_files = glob($cache_dir . '*');
                    $cache_size = 0;
                    if ($cache_files) {
                        foreach ($cache_files as $file) {
                            if (is_file($file)) {
                                $cache_size += filesize($file);
                            }
                        }
                    }
                    ?>
                    <p><strong>Cache files:</strong> <?php echo count($cache_files); ?></p>
                    <p><strong>Cache size:</strong> <?php echo yoursite_format_bytes($cache_size); ?></p>
                    <p><strong>Cache directory:</strong> <code><?php echo $cache_dir; ?></code></p>
                    
                    <form method="post">
                        <?php wp_nonce_field('clear_logo_cache'); ?>
                        <p>
                            <input type="submit" name="clear_cache" class="button" value="Clear Cache" onclick="return confirm('Are you sure you want to clear the logo cache?')">
                        </p>
                    </form>
                </div>
                
                <div class="card">
                    <h2>Quick Links</h2>
                    <p>
                        <a href="<?php echo admin_url('customize.php?autofocus[control]=custom_logo'); ?>" class="button">Change Logo</a>
                        <a href="<?php echo site_url('/press-kit/'); ?>" class="button button-primary">View Press Kit</a>
                    </p>
                </div>
                
            <?php else: ?>
                <div class="notice notice-error">
                    <p><strong>Logo Generator class not found!</strong> Please ensure the logo generator code is properly included in your functions.php file.</p>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="notice notice-warning">
                <p>
                    <strong>No logo uploaded.</strong> 
                    <a href="<?php echo admin_url('customize.php?autofocus[control]=custom_logo'); ?>">Upload a logo</a> 
                    to enable the logo generator.
                </p>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Clear logo cache function
 */
function yoursite_clear_logo_cache() {
    $upload_dir = wp_upload_dir();
    $cache_dir = $upload_dir['basedir'] . '/logo-cache/';
    
    $files = glob($cache_dir . '*');
    $deleted = 0;
    
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            $deleted++;
        }
    }
    
    return $deleted;
}

/**
 * Format bytes function (if not already exists)
 */
if (!function_exists('yoursite_format_bytes')) {
    function yoursite_format_bytes($size, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB');
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
}

/**
 * Add press kit customizer options
 */
function yoursite_add_press_kit_customizer($wp_customize) {
    // Add Press Kit Section
    $wp_customize->add_section('press_kit_section', array(
        'title' => __('Press Kit Information', 'yoursite'),
        'priority' => 40,
    ));
    
    // Company Founded
    $wp_customize->add_setting('company_founded', array(
        'default' => '2020',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('company_founded', array(
        'label' => __('Company Founded Year', 'yoursite'),
        'section' => 'press_kit_section',
        'type' => 'text',
    ));
    
    // Company Location
    $wp_customize->add_setting('company_location', array(
        'default' => 'San Francisco, CA, USA',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('company_location', array(
        'label' => __('Company Location', 'yoursite'),
        'section' => 'press_kit_section',
        'type' => 'text',
    ));
    
    // Company Industry
    $wp_customize->add_setting('company_industry', array(
        'default' => 'E-commerce Technology & SaaS',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('company_industry', array(
        'label' => __('Company Industry', 'yoursite'),
        'section' => 'press_kit_section',
        'type' => 'text',
    ));
    
    // Company Employees
    $wp_customize->add_setting('company_employees', array(
        'default' => '50-100',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('company_employees', array(
        'label' => __('Number of Employees', 'yoursite'),
        'section' => 'press_kit_section',
        'type' => 'text',
    ));
    
    // Mission Statement
    $wp_customize->add_setting('company_mission', array(
        'default' => 'To empower businesses of all sizes with seamless integrations that drive growth, efficiency, and customer satisfaction in the digital economy.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('company_mission', array(
        'label' => __('Mission Statement', 'yoursite'),
        'section' => 'press_kit_section',
        'type' => 'textarea',
    ));
    
    // Vision Statement
    $wp_customize->add_setting('company_vision', array(
        'default' => 'To be the world\'s leading platform for e-commerce integrations, connecting every business tool and service in a unified ecosystem.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('company_vision', array(
        'label' => __('Vision Statement', 'yoursite'),
        'section' => 'press_kit_section',
        'type' => 'textarea',
    ));
    
    // Statistics
    $stats = array(
        'stat_users' => array('label' => 'Active Users', 'default' => '100K+'),
        'stat_integrations' => array('label' => 'Integrations', 'default' => '50+'),
        'stat_countries' => array('label' => 'Countries Served', 'default' => '180+'),
        'stat_uptime' => array('label' => 'Uptime', 'default' => '99.9%')
    );
    
    foreach ($stats as $stat_key => $stat_data) {
        $wp_customize->add_setting($stat_key, array(
            'default' => $stat_data['default'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control($stat_key, array(
            'label' => $stat_data['label'],
            'section' => 'press_kit_section',
            'type' => 'text',
        ));
    }
}
add_action('customize_register', 'yoursite_add_press_kit_customizer');

// =============================================================================
// DEBUG FUNCTIONS (TEMPORARY)
// =============================================================================

// Add this to functions.php temporarily to debug
function debug_logo_generation() {
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }
    
    if (isset($_GET['debug_logos']) && $_GET['debug_logos'] === '1') {
        echo '<div style="background: white; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
        echo '<h2>Logo Debug Information</h2>';
        
        if (class_exists('YourSite_Logo_Generator')) {
            $generator = new YourSite_Logo_Generator();
            
            // Check if method exists (since we're adding it)
            if (method_exists($generator, 'debug_image_processing')) {
                $debug_info = $generator->debug_image_processing(null);
                echo '<pre>' . print_r($debug_info, true) . '</pre>';
            }
            
            // Test generating variations
            echo '<h3>Testing Logo Variations</h3>';
            $variations = $generator->generate_logo_variations();
            if (is_wp_error($variations)) {
                echo '<p style="color: red;">Error: ' . $variations->get_error_message() . '</p>';
            } else {
                foreach ($variations as $type => $variation) {
                    echo '<h4>' . ucfirst($type) . ' Logo</h4>';
                    if (is_wp_error($variation)) {
                        echo '<p style="color: red;">Error: ' . $variation->get_error_message() . '</p>';
                    } else {
                        echo '<p>Status: ' . (file_exists($variation['path']) ? 'Generated successfully' : 'File not found') . '</p>';
                        if (isset($variation['url'])) {
                            echo '<p>URL: <a href="' . $variation['url'] . '" target="_blank">' . $variation['url'] . '</a></p>';
                            echo '<p>Path: ' . $variation['path'] . '</p>';
                            if (file_exists($variation['path'])) {
                                echo '<p>File size: ' . filesize($variation['path']) . ' bytes</p>';
                                echo '<img src="' . $variation['url'] . '" style="max-width: 200px; max-height: 100px; margin: 10px; border: 1px solid #ddd; background: ' . ($type === 'white' ? '#333' : '#fff') . ';" alt="' . $type . '">';
                            }
                        }
                    }
                }
            }
        } else {
            echo '<p style="color: red;">YourSite_Logo_Generator class not found</p>';
        }
        
        echo '</div>';
        
        // Also check server capabilities
        echo '<div style="background: #f0f0f0; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
        echo '<h3>Server Capabilities</h3>';
        echo '<p>GD Extension: ' . (extension_loaded('gd') ? 'Enabled' : 'Not Available') . '</p>';
        if (extension_loaded('gd')) {
            $gd_info = gd_info();
            echo '<pre>' . print_r($gd_info, true) . '</pre>';
        }
        echo '<p>Upload Directory: ' . wp_upload_dir()['basedir'] . '</p>';
        echo '<p>Upload Directory Writable: ' . (wp_is_writable(wp_upload_dir()['basedir']) ? 'Yes' : 'No') . '</p>';
        
        $cache_dir = wp_upload_dir()['basedir'] . '/logo-cache/';
        echo '<p>Cache Directory: ' . $cache_dir . '</p>';
        echo '<p>Cache Directory Exists: ' . (file_exists($cache_dir) ? 'Yes' : 'No') . '</p>';
        echo '<p>Cache Directory Writable: ' . (is_writable($cache_dir) ? 'Yes' : 'No') . '</p>';
        
        echo '</div>';
        
        // Add clear cache button
        if (isset($_GET['clear_cache']) && $_GET['clear_cache'] === '1') {
            if (class_exists('YourSite_Logo_Generator')) {
                $generator = new YourSite_Logo_Generator();
                $generator->clear_logo_cache();
                echo '<div style="background: #dff0d8; padding: 10px; margin: 20px; border: 1px solid #d6e9c6; color: #3c763d;">Cache cleared successfully!</div>';
            }
        }
        
        echo '<div style="margin: 20px;"><a href="' . admin_url('?debug_logos=1&clear_cache=1') . '" class="button">Clear Logo Cache</a></div>';
    }
}
add_action('admin_notices', 'debug_logo_generation');

// Add admin notice with debug link
function add_logo_debug_link() {
    if (current_user_can('manage_options') && !isset($_GET['debug_logos'])) {
        $debug_url = admin_url('?debug_logos=1');
        echo '<div class="notice notice-info is-dismissible"><p>Debug logo generation: <a href="' . $debug_url . '" class="button button-secondary">Debug Logos</a></p></div>';
    }
}
add_action('admin_notices', 'add_logo_debug_link');

// Helper function to manually trigger logo generation
function manual_logo_regeneration() {
    if (isset($_GET['regenerate_logos']) && $_GET['regenerate_logos'] === '1' && current_user_can('manage_options')) {
        if (class_exists('YourSite_Logo_Generator')) {
            $generator = new YourSite_Logo_Generator();
            $generator->clear_logo_cache(); // Clear first
            $variations = $generator->generate_logo_variations(); // Then regenerate
            
            if (is_wp_error($variations)) {
                add_action('admin_notices', function() use ($variations) {
                    echo '<div class="notice notice-error"><p>Logo regeneration failed: ' . $variations->get_error_message() . '</p></div>';
                });
            } else {
                add_action('admin_notices', function() {
                    echo '<div class="notice notice-success"><p>Logos regenerated successfully!</p></div>';
                });
            }
        }
    }
}
add_action('admin_init', 'manual_logo_regeneration');

// Add regeneration link to admin bar
function add_logo_regen_admin_bar($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $wp_admin_bar->add_node(array(
        'id' => 'regenerate-logos',
        'title' => 'Regenerate Logos',
        'href' => admin_url('?regenerate_logos=1'),
        'meta' => array(
            'title' => 'Force regeneration of all logo variations'
        )
    ));
}
add_action('admin_bar_menu', 'add_logo_regen_admin_bar', 100);

// =============================================================================
// FALLBACK FUNCTIONS
// =============================================================================

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
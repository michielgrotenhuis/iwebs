<?php
/**
 * YourSite.biz Theme Functions - UPDATED WITH LOGO GENERATOR
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
// LOGO GENERATOR INTEGRATION - COMPLETE SYSTEM
// =============================================================================

/**
 * Complete Logo Generator Class
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
                
                // Generate white version
                $variations['white'] = $this->create_white_variation($logo);
                
                // Generate black version  
                $variations['black'] = $this->create_black_variation($logo);
                
                // Generate grayscale version
                $variations['grayscale'] = $this->create_grayscale_variation($logo);
                
                // Generate transparent version (if not already transparent)
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
         * Create white logo variation
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
            
            // Create white silhouette
            $image = $this->load_image($logo['path']);
            if (!$image) return false;
            
            $width = imagesx($image);
            $height = imagesy($image);
            
            // Create new image with transparency
            $white_image = imagecreatetruecolor($width, $height);
            imagealphablending($white_image, false);
            imagesavealpha($white_image, true);
            
            // Fill with transparent background
            $transparent = imagecolorallocatealpha($white_image, 0, 0, 0, 127);
            imagefill($white_image, 0, 0, $transparent);
            
            // Convert non-transparent pixels to white
            for ($x = 0; $x < $width; $x++) {
                for ($y = 0; $y < $height; $y++) {
                    $rgba = imagecolorat($image, $x, $y);
                    $alpha = ($rgba & 0x7F000000) >> 24;
                    
                    if ($alpha < 127) { // Not transparent
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
         * Create black logo variation
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
            
            // Create black silhouette
            $image = $this->load_image($logo['path']);
            if (!$image) return false;
            
            $width = imagesx($image);
            $height = imagesy($image);
            
            $black_image = imagecreatetruecolor($width, $height);
            imagealphablending($black_image, false);
            imagesavealpha($black_image, true);
            
            $transparent = imagecolorallocatealpha($black_image, 0, 0, 0, 127);
            imagefill($black_image, 0, 0, $transparent);
            
            // Convert non-transparent pixels to black
            for ($x = 0; $x < $width; $x++) {
                for ($y = 0; $y < $height; $y++) {
                    $rgba = imagecolorat($image, $x, $y);
                    $alpha = ($rgba & 0x7F000000) >> 24;
                    
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
         * Create grayscale logo variation
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
            
            // Apply grayscale filter
            imagefilter($image, IMG_FILTER_GRAYSCALE);
            
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
                    // Replace fill colors with white
                    $svg_content = preg_replace('/fill\s*=\s*["\'][^"\']*["\']/', 'fill="white"', $svg_content);
                    $svg_content = preg_replace('/stroke\s*=\s*["\'][^"\']*["\']/', 'stroke="white"', $svg_content);
                    break;
                    
                case 'black':
                    // Replace fill colors with black
                    $svg_content = preg_replace('/fill\s*=\s*["\'][^"\']*["\']/', 'fill="black"', $svg_content);
                    $svg_content = preg_replace('/stroke\s*=\s*["\'][^"\']*["\']/', 'stroke="black"', $svg_content);
                    break;
                    
                case 'grayscale':
                    // Add grayscale filter
                    $filter = '<defs><filter id="grayscale"><feColorMatrix type="saturate" values="0"/></filter></defs>';
                    $svg_content = preg_replace('/<svg([^>]*)>/', '<svg$1>' . $filter, $svg_content);
                    $svg_content = preg_replace('/<svg([^>]*)>/', '<svg$1 style="filter: url(#grayscale);">', $svg_content);
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
         * Load image from file
         */
        private function load_image($path) {
            $image_info = getimagesize($path);
            if (!$image_info) return false;
            
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

/**
 * Add dashboard widget for logo generator
 */
function yoursite_logo_generator_dashboard_widget() {
    wp_add_dashboard_widget(
        'yoursite_logo_generator_status',
        'Logo Generator Status',
        'yoursite_logo_generator_dashboard_widget_content'
    );
}
add_action('wp_dashboard_setup', 'yoursite_logo_generator_dashboard_widget');

/**
 * Dashboard widget content
 */
function yoursite_logo_generator_dashboard_widget_content() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $class_exists = class_exists('YourSite_Logo_Generator');
    
    if ($custom_logo_id && $class_exists) {
        $upload_dir = wp_upload_dir();
        $cache_dir = $upload_dir['basedir'] . '/logo-cache/';
        $cache_files = glob($cache_dir . '*');
        
        echo '<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; text-align: center;">';
        
        echo '<div style="padding: 15px; background: #d1e7dd; border-radius: 4px;">';
        echo '<div style="font-size: 18px; font-weight: bold; color: #0f5132;">✓</div>';
        echo '<div style="font-size: 12px; color: #0f5132;">Logo Uploaded</div>';
        echo '</div>';
        
        echo '<div style="padding: 15px; background: #cff4fc; border-radius: 4px;">';
        echo '<div style="font-size: 18px; font-weight: bold; color: #055160;">' . count($cache_files) . '</div>';
        echo '<div style="font-size: 12px; color: #055160;">Generated Files</div>';
        echo '</div>';
        
        echo '<div style="padding: 15px; background: #e2e3e5; border-radius: 4px;">';
        echo '<div style="font-size: 18px; font-weight: bold; color: #41464b;">Ready</div>';
        echo '<div style="font-size: 12px; color: #41464b;">Status</div>';
        echo '</div>';
        
        echo '</div>';
        
        echo '<p style="margin-top: 15px;">';
        echo '<a href="' . site_url('/press-kit/') . '" class="button button-primary">View Press Kit</a> ';
        echo '<a href="' . admin_url('tools.php?page=logo-generator') . '" class="button">Manage</a>';
        echo '</p>';
        
    } else {
        echo '<div style="text-align: center; padding: 20px;">';
        
        if (!$custom_logo_id) {
            echo '<div style="color: #d63638; margin-bottom: 10px;">⚠</div>';
            echo '<p>No logo uploaded</p>';
            echo '<a href="' . admin_url('customize.php?autofocus[control]=custom_logo') . '" class="button button-primary">Upload Logo</a>';
        } elseif (!$class_exists) {
            echo '<div style="color: #d63638; margin-bottom: 10px;">✗</div>';
            echo '<p>Logo generator not loaded</p>';
            echo '<p><small>Check functions.php file</small></p>';
        }
        
        echo '</div>';
    }
}

/**
 * Add admin notices for logo generator status
 */
function yoursite_logo_generator_admin_notices() {
    $screen = get_current_screen();
    
    // Only show on relevant admin pages
    if (!in_array($screen->id, ['dashboard', 'tools_page_logo-generator'])) {
        return;
    }
    
    $custom_logo_id = get_theme_mod('custom_logo');
    
    if ($custom_logo_id && class_exists('YourSite_Logo_Generator')) {
        // Check if we need to generate variations
        $upload_dir = wp_upload_dir();
        $cache_dir = $upload_dir['basedir'] . '/logo-cache/';
        $cache_files = glob($cache_dir . '*');
        
        if (empty($cache_files)) {
            ?>
            <div class="notice notice-info is-dismissible">
                <p>
                    <strong>Logo Generator Ready!</strong> 
                    Your logo is uploaded but variations haven't been generated yet. 
                    <a href="<?php echo admin_url('tools.php?page=logo-generator'); ?>">Generate variations now</a> 
                    or visit your <a href="<?php echo site_url('/press-kit/'); ?>">press kit page</a>.
                </p>
            </div>
            <?php
        }
    } elseif (!$custom_logo_id) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p>
                <strong>Logo Generator:</strong> 
                <a href="<?php echo admin_url('customize.php?autofocus[control]=custom_logo'); ?>">Upload a logo</a> 
                to enable automatic logo generation for your press kit.
            </p>
        </div>
        <?php
    } elseif (!class_exists('YourSite_Logo_Generator')) {
        ?>
        <div class="notice notice-error">
            <p>
                <strong>Logo Generator Error:</strong> 
                The logo generator class is not loaded. Please check your functions.php file.
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'yoursite_logo_generator_admin_notices');

/**
 * Check system requirements and show warnings
 */
function yoursite_check_logo_generator_requirements() {
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }
    
    $missing = array();
    
    if (!extension_loaded('gd')) {
        $missing[] = 'PHP GD extension (required for image processing)';
    }
    
    if (!extension_loaded('zip')) {
        $missing[] = 'PHP ZIP extension (required for package downloads)';
    }
    
    if (!empty($missing)) {
        ?>
        <div class="notice notice-error">
            <p><strong>Logo Generator Requirements Missing:</strong></p>
            <ul>
                <?php foreach ($missing as $requirement): ?>
                    <li><?php echo esc_html($requirement); ?></li>
                <?php endforeach; ?>
            </ul>
            <p>Please contact your hosting provider to enable these PHP extensions.</p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'yoursite_check_logo_generator_requirements');

// =============================================================================
// ORIGINAL GUIDE CONTENT FORMATTING FUNCTIONS
// =============================================================================

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
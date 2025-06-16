<?php
/**
 * Dynamic Logo Generator for Press Kit
 * Generates different logo formats and variations automatically
 */

// Add to inc/logo-generator.php

if (!defined('ABSPATH')) {
    exit;
}

class YourSite_Logo_Generator {
    
    private $cache_dir;
    private $cache_url;
    private $supported_formats = ['png', 'jpg', 'svg'];
    
    public function __construct() {
        $this->cache_dir = wp_upload_dir()['basedir'] . '/logo-cache/';
        $this->cache_url = wp_upload_dir()['baseurl'] . '/logo-cache/';
        
        // Create cache directory if it doesn't exist
        if (!file_exists($this->cache_dir)) {
            wp_mkdir_p($this->cache_dir);
        }
        
        // Add hooks
        add_action('wp_ajax_generate_logo_pack', array($this, 'ajax_generate_logo_pack'));
        add_action('wp_ajax_nopriv_generate_logo_pack', array($this, 'ajax_generate_logo_pack'));
        add_action('wp_ajax_download_logo_zip', array($this, 'ajax_download_logo_zip'));
        add_action('wp_ajax_nopriv_download_logo_zip', array($this, 'ajax_download_logo_zip'));
        
        // Clean cache when logo is updated
        add_action('customize_save_after', array($this, 'clear_logo_cache'));
    }
    
    /**
     * Get the current site logo
     */
    private function get_site_logo() {
        $custom_logo_id = get_theme_mod('custom_logo');
        if (!$custom_logo_id) {
            return false;
        }
        
        $logo_data = wp_get_attachment_metadata($custom_logo_id);
        $logo_url = wp_get_attachment_url($custom_logo_id);
        $logo_path = get_attached_file($custom_logo_id);
        
        return array(
            'id' => $custom_logo_id,
            'url' => $logo_url,
            'path' => $logo_path,
            'metadata' => $logo_data,
            'mime_type' => get_post_mime_type($custom_logo_id)
        );
    }
    
    /**
     * Generate logo variations
     */
    public function generate_logo_variations() {
        $logo = $this->get_site_logo();
        if (!$logo) {
            return new WP_Error('no_logo', 'No logo found');
        }
        
        $variations = array();
        $cache_key = 'logo_variations_' . $logo['id'] . '_' . filemtime($logo['path']);
        
        // Check if variations are already cached
        $cached = get_transient($cache_key);
        if ($cached !== false) {
            return $cached;
        }
        
        try {
            // Create different variations
            $variations['primary'] = $this->create_primary_logo($logo);
            $variations['white'] = $this->create_white_logo($logo);
            $variations['black'] = $this->create_black_logo($logo);
            $variations['grayscale'] = $this->create_grayscale_logo($logo);
            $variations['transparent'] = $this->create_transparent_logo($logo);
            
            // Create different sizes for each variation
            foreach ($variations as $type => &$variation) {
                if ($variation && !is_wp_error($variation)) {
                    $variation['sizes'] = $this->create_logo_sizes($variation['path'], $type);
                }
            }
            
            // Cache for 24 hours
            set_transient($cache_key, $variations, DAY_IN_SECONDS);
            
            return $variations;
            
        } catch (Exception $e) {
            return new WP_Error('generation_failed', $e->getMessage());
        }
    }
    
    /**
     * Create primary logo (original with optimization)
     */
    private function create_primary_logo($logo) {
        $filename = 'primary-logo-' . $logo['id'] . '.' . $this->get_file_extension($logo['path']);
        $output_path = $this->cache_dir . $filename;
        $output_url = $this->cache_url . $filename;
        
        if (file_exists($output_path) && filemtime($output_path) > filemtime($logo['path'])) {
            return array('path' => $output_path, 'url' => $output_url, 'type' => 'primary');
        }
        
        // For SVG files, just copy
        if ($logo['mime_type'] === 'image/svg+xml') {
            copy($logo['path'], $output_path);
            return array('path' => $output_path, 'url' => $output_url, 'type' => 'primary');
        }
        
        // For raster images, optimize
        $image = $this->load_image($logo['path']);
        if (!$image) return false;
        
        $this->save_image($image, $output_path, 'png', 90);
        imagedestroy($image);
        
        return array('path' => $output_path, 'url' => $output_url, 'type' => 'primary');
    }
    
    /**
     * Create white logo for dark backgrounds
     */
    private function create_white_logo($logo) {
        if ($logo['mime_type'] === 'image/svg+xml') {
            return $this->process_svg_logo($logo, 'white');
        }
        
        $filename = 'white-logo-' . $logo['id'] . '.png';
        $output_path = $this->cache_dir . $filename;
        $output_url = $this->cache_url . $filename;
        
        if (file_exists($output_path) && filemtime($output_path) > filemtime($logo['path'])) {
            return array('path' => $output_path, 'url' => $output_url, 'type' => 'white');
        }
        
        $image = $this->load_image($logo['path']);
        if (!$image) return false;
        
        // Create white version
        $width = imagesx($image);
        $height = imagesy($image);
        $white_image = imagecreatetruecolor($width, $height);
        
        // Enable alpha blending
        imagealphablending($white_image, false);
        imagesavealpha($white_image, true);
        
        // Make background transparent
        $transparent = imagecolorallocatealpha($white_image, 0, 0, 0, 127);
        imagefill($white_image, 0, 0, $transparent);
        
        // Convert to white silhouette
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgba = imagecolorat($image, $x, $y);
                $alpha = ($rgba & 0x7F000000) >> 24;
                
                if ($alpha < 127) { // Not fully transparent
                    $white = imagecolorallocatealpha($white_image, 255, 255, 255, $alpha);
                    imagesetpixel($white_image, $x, $y, $white);
                }
            }
        }
        
        $this->save_image($white_image, $output_path, 'png');
        imagedestroy($image);
        imagedestroy($white_image);
        
        return array('path' => $output_path, 'url' => $output_url, 'type' => 'white');
    }
    
    /**
     * Create black logo
     */
    private function create_black_logo($logo) {
        if ($logo['mime_type'] === 'image/svg+xml') {
            return $this->process_svg_logo($logo, 'black');
        }
        
        $filename = 'black-logo-' . $logo['id'] . '.png';
        $output_path = $this->cache_dir . $filename;
        $output_url = $this->cache_url . $filename;
        
        if (file_exists($output_path) && filemtime($output_path) > filemtime($logo['path'])) {
            return array('path' => $output_path, 'url' => $output_url, 'type' => 'black');
        }
        
        $image = $this->load_image($logo['path']);
        if (!$image) return false;
        
        // Create black version (similar to white but with black color)
        $width = imagesx($image);
        $height = imagesy($image);
        $black_image = imagecreatetruecolor($width, $height);
        
        imagealphablending($black_image, false);
        imagesavealpha($black_image, true);
        
        $transparent = imagecolorallocatealpha($black_image, 0, 0, 0, 127);
        imagefill($black_image, 0, 0, $transparent);
        
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgba = imagecolorat($image, $x, $y);
                $alpha = ($rgba & 0x7F000000) >> 24;
                
                if ($alpha < 127) {
                    $black = imagecolorallocatealpha($black_image, 0, 0, 0, $alpha);
                    imagesetpixel($black_image, $x, $y, $black);
                }
            }
        }
        
        $this->save_image($black_image, $output_path, 'png');
        imagedestroy($image);
        imagedestroy($black_image);
        
        return array('path' => $output_path, 'url' => $output_url, 'type' => 'black');
    }
    
    /**
     * Create grayscale logo
     */
    private function create_grayscale_logo($logo) {
        if ($logo['mime_type'] === 'image/svg+xml') {
            return $this->process_svg_logo($logo, 'grayscale');
        }
        
        $filename = 'grayscale-logo-' . $logo['id'] . '.png';
        $output_path = $this->cache_dir . $filename;
        $output_url = $this->cache_url . $filename;
        
        if (file_exists($output_path) && filemtime($output_path) > filemtime($logo['path'])) {
            return array('path' => $output_path, 'url' => $output_url, 'type' => 'grayscale');
        }
        
        $image = $this->load_image($logo['path']);
        if (!$image) return false;
        
        // Apply grayscale filter
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        
        $this->save_image($image, $output_path, 'png');
        imagedestroy($image);
        
        return array('path' => $output_path, 'url' => $output_url, 'type' => 'grayscale');
    }
    
    /**
     * Create transparent background logo
     */
    private function create_transparent_logo($logo) {
        $filename = 'transparent-logo-' . $logo['id'] . '.png';
        $output_path = $this->cache_dir . $filename;
        $output_url = $this->cache_url . $filename;
        
        if (file_exists($output_path) && filemtime($output_path) > filemtime($logo['path'])) {
            return array('path' => $output_path, 'url' => $output_url, 'type' => 'transparent');
        }
        
        if ($logo['mime_type'] === 'image/svg+xml') {
            // SVG is already transparent
            copy($logo['path'], $output_path);
            return array('path' => $output_path, 'url' => $output_url, 'type' => 'transparent');
        }
        
        $image = $this->load_image($logo['path']);
        if (!$image) return false;
        
        // Ensure transparency is preserved
        imagealphablending($image, false);
        imagesavealpha($image, true);
        
        $this->save_image($image, $output_path, 'png');
        imagedestroy($image);
        
        return array('path' => $output_path, 'url' => $output_url, 'type' => 'transparent');
    }
    
    /**
     * Process SVG logos for different variations
     */
    private function process_svg_logo($logo, $type) {
        $filename = $type . '-logo-' . $logo['id'] . '.svg';
        $output_path = $this->cache_dir . $filename;
        $output_url = $this->cache_url . $filename;
        
        if (file_exists($output_path) && filemtime($output_path) > filemtime($logo['path'])) {
            return array('path' => $output_path, 'url' => $output_url, 'type' => $type);
        }
        
        $svg_content = file_get_contents($logo['path']);
        
        switch ($type) {
            case 'white':
                $svg_content = preg_replace('/fill="[^"]*"/', 'fill="white"', $svg_content);
                $svg_content = preg_replace('/stroke="[^"]*"/', 'stroke="white"', $svg_content);
                break;
            case 'black':
                $svg_content = preg_replace('/fill="[^"]*"/', 'fill="black"', $svg_content);
                $svg_content = preg_replace('/stroke="[^"]*"/', 'stroke="black"', $svg_content);
                break;
            case 'grayscale':
                // Add a grayscale filter to SVG
                $filter = '<defs><filter id="grayscale"><feColorMatrix type="saturate" values="0"/></filter></defs>';
                $svg_content = str_replace('<svg', $filter . '<svg style="filter: url(#grayscale)"', $svg_content);
                break;
        }
        
        file_put_contents($output_path, $svg_content);
        
        return array('path' => $output_path, 'url' => $output_url, 'type' => $type);
    }
    
    /**
     * Create different sizes for each logo variation
     */
    private function create_logo_sizes($logo_path, $type) {
        $sizes = array(
            'small' => 128,
            'medium' => 256,
            'large' => 512,
            'xl' => 1024,
            'favicon' => 32
        );
        
        $size_variations = array();
        
        foreach ($sizes as $size_name => $size_px) {
            $filename = $type . '-logo-' . $size_name . '-' . $size_px . 'px.png';
            $output_path = $this->cache_dir . $filename;
            $output_url = $this->cache_url . $filename;
            
            if (!file_exists($output_path) || filemtime($output_path) < filemtime($logo_path)) {
                $resized = $this->resize_image($logo_path, $size_px, $size_px);
                if ($resized) {
                    $this->save_image($resized, $output_path, 'png');
                    imagedestroy($resized);
                }
            }
            
            if (file_exists($output_path)) {
                $size_variations[$size_name] = array(
                    'url' => $output_url,
                    'path' => $output_path,
                    'size' => $size_px . 'x' . $size_px,
                    'filesize' => $this->format_bytes(filesize($output_path))
                );
            }
        }
        
        return $size_variations;
    }
    
    /**
     * Load image from file
     */
    private function load_image($path) {
        $image_info = getimagesize($path);
        if (!$image_info) return false;
        
        switch ($image_info['mime']) {
            case 'image/jpeg':
                return imagecreatefromjpeg($path);
            case 'image/png':
                return imagecreatefrompng($path);
            case 'image/gif':
                return imagecreatefromgif($path);
            case 'image/webp':
                return imagecreatefromwebp($path);
            default:
                return false;
        }
    }
    
    /**
     * Save image to file
     */
    private function save_image($image, $path, $format = 'png', $quality = 100) {
        switch (strtolower($format)) {
            case 'jpeg':
            case 'jpg':
                return imagejpeg($image, $path, $quality);
            case 'png':
                imagealphablending($image, false);
                imagesavealpha($image, true);
                return imagepng($image, $path, 9);
            case 'gif':
                return imagegif($image, $path);
            case 'webp':
                return imagewebp($image, $path, $quality);
            default:
                return false;
        }
    }
    
    /**
     * Resize image maintaining aspect ratio
     */
    private function resize_image($source_path, $max_width, $max_height) {
        $source = $this->load_image($source_path);
        if (!$source) return false;
        
        $orig_width = imagesx($source);
        $orig_height = imagesy($source);
        
        // Calculate new dimensions
        $ratio = min($max_width / $orig_width, $max_height / $orig_height);
        $new_width = intval($orig_width * $ratio);
        $new_height = intval($orig_height * $ratio);
        
        // Create new image
        $resized = imagecreatetruecolor($new_width, $new_height);
        
        // Enable alpha blending for transparency
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        
        // Make background transparent
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefill($resized, 0, 0, $transparent);
        
        // Resize the image
        imagecopyresampled($resized, $source, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);
        
        imagedestroy($source);
        
        return $resized;
    }
    
    /**
     * Get file extension from path
     */
    private function get_file_extension($path) {
        return strtolower(pathinfo($path, PATHINFO_EXTENSION));
    }
    
    /**
     * Format bytes to human readable
     */
    private function format_bytes($size, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB');
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
    
    /**
     * Create downloadable ZIP package
     */
    public function create_logo_package() {
        $variations = $this->generate_logo_variations();
        if (is_wp_error($variations)) {
            return $variations;
        }
        
        $zip_filename = 'logo-package-' . time() . '.zip';
        $zip_path = $this->cache_dir . $zip_filename;
        $zip_url = $this->cache_url . $zip_filename;
        
        $zip = new ZipArchive();
        if ($zip->open($zip_path, ZipArchive::CREATE) !== TRUE) {
            return new WP_Error('zip_failed', 'Cannot create ZIP file');
        }
        
        foreach ($variations as $type => $variation) {
            if (!$variation || is_wp_error($variation)) continue;
            
            // Add main variation
            if (isset($variation['path']) && file_exists($variation['path'])) {
                $zip->addFile($variation['path'], $type . '/' . basename($variation['path']));
            }
            
            // Add sizes
            if (isset($variation['sizes'])) {
                foreach ($variation['sizes'] as $size_name => $size_data) {
                    if (file_exists($size_data['path'])) {
                        $zip->addFile($size_data['path'], $type . '/sizes/' . basename($size_data['path']));
                    }
                }
            }
        }
        
        // Add README file
        $readme_content = $this->generate_readme_content();
        $zip->addFromString('README.txt', $readme_content);
        
        $zip->close();
        
        return array(
            'path' => $zip_path,
            'url' => $zip_url,
            'filename' => $zip_filename
        );
    }
    
    /**
     * Generate README content for logo package
     */
    private function generate_readme_content() {
        $site_name = get_bloginfo('name');
        $date = date('Y-m-d H:i:s');
        
        return "Logo Package for {$site_name}
Generated on: {$date}

This package contains various formats and sizes of the {$site_name} logo:

VARIATIONS:
- primary/: Original logo in high quality
- white/: White version for dark backgrounds
- black/: Black version for light backgrounds  
- grayscale/: Grayscale version
- transparent/: Transparent background version

SIZES:
Each variation includes multiple sizes:
- favicon (32x32px): For website favicons
- small (128x128px): For small displays
- medium (256x256px): For standard use
- large (512x512px): For high-resolution displays
- xl (1024x1024px): For print and large formats

USAGE GUIDELINES:
- Use appropriate variation for your background
- Maintain aspect ratio when resizing
- Don't modify colors or add effects
- Provide adequate white space around logo

For questions about logo usage, please contact: " . get_option('admin_email') . "

© " . date('Y') . " {$site_name}. All rights reserved.";
    }
    
    /**
     * AJAX handler for generating logo pack
     */
    public function ajax_generate_logo_pack() {
        check_ajax_referer('logo_generator_nonce', 'nonce');
        
        $variations = $this->generate_logo_variations();
        
        if (is_wp_error($variations)) {
            wp_send_json_error($variations->get_error_message());
        }
        
        wp_send_json_success($variations);
    }
    
    /**
     * AJAX handler for downloading ZIP
     */
    public function ajax_download_logo_zip() {
        check_ajax_referer('logo_generator_nonce', 'nonce');
        
        $package = $this->create_logo_package();
        
        if (is_wp_error($package)) {
            wp_send_json_error($package->get_error_message());
        }
        
        wp_send_json_success($package);
    }
    
    /**
     * Clear logo cache
     */
    public function clear_logo_cache() {
        $files = glob($this->cache_dir . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        
        // Clear transients
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_logo_variations_%'");
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_logo_variations_%'");
    }
    
    /**
     * Get logo variations for display
     */
    public function get_logo_variations_for_display() {
        $variations = $this->generate_logo_variations();
        
        if (is_wp_error($variations)) {
            return array();
        }
        
        $display_data = array();
        
        foreach ($variations as $type => $variation) {
            if (!$variation || is_wp_error($variation)) continue;
            
            $display_data[$type] = array(
                'name' => $this->get_variation_name($type),
                'description' => $this->get_variation_description($type),
                'preview_url' => isset($variation['url']) ? $variation['url'] : '',
                'sizes' => isset($variation['sizes']) ? $variation['sizes'] : array()
            );
        }
        
        return $display_data;
    }
    
    /**
     * Get human-readable variation name
     */
    private function get_variation_name($type) {
        $names = array(
            'primary' => 'Primary Logo',
            'white' => 'White Logo',
            'black' => 'Black Logo', 
            'grayscale' => 'Grayscale Logo',
            'transparent' => 'Transparent Logo'
        );
        
        return isset($names[$type]) ? $names[$type] : ucfirst($type) . ' Logo';
    }
    
    /**
     * Get variation description
     */
    private function get_variation_description($type) {
        $descriptions = array(
            'primary' => 'Full color logo for light backgrounds',
            'white' => 'White logo for dark backgrounds',
            'black' => 'Black logo for light backgrounds',
            'grayscale' => 'Monochrome logo for special uses',
            'transparent' => 'Logo with transparent background'
        );
        
        return isset($descriptions[$type]) ? $descriptions[$type] : '';
    }
}

// Initialize the logo generator
new YourSite_Logo_Generator();
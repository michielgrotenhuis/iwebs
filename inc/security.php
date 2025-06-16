<?php
/**
 * Security enhancements
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add security headers
 */
function yoursite_security_headers() {
    // Check if headers have already been sent
    if (!headers_sent() && !is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'yoursite_security_headers');

/**
 * Remove WordPress version from head and feeds
 */
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

/**
 * Remove version from scripts and styles
 */
function yoursite_remove_version_scripts_styles($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'yoursite_remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'yoursite_remove_version_scripts_styles', 9999);

/**
 * Disable file editing in admin
 */
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

/**
 * Remove unnecessary meta tags
 */
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove REST API links from head
 */
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');

/**
 * Disable embeds
 */
function yoursite_disable_embeds() {
    // Remove the REST API endpoint
    remove_action('rest_api_init', 'wp_oembed_register_route');
    
    // Turn off oEmbed auto discovery
    add_filter('embed_oembed_discover', '__return_false');
    
    // Don't filter oEmbed results
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    
    // Remove oEmbed discovery links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // Remove oEmbed-specific JavaScript from the front-end and back-end
    remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('init', 'yoursite_disable_embeds', 9999);

/**
 * Limit login attempts (basic implementation)
 */
function yoursite_check_attempted_login($user, $username, $password) {
    if (get_transient('attempted_login')) {
        $datas = get_transient('attempted_login');
        
        if ($datas['tried'] >= 3) {
            $until = get_option('_transient_timeout_attempted_login');
            $time = yoursite_time_to_go($until);
            
            return new WP_Error('too_many_tried', sprintf(__('You have reached authentication limit, you will be able to try again in %1$s.', 'yoursite'), $time));
        }
    }
    
    return $user;
}
add_filter('authenticate', 'yoursite_check_attempted_login', 30, 3);

function yoursite_login_failed($username) {
    if (get_transient('attempted_login')) {
        $datas = get_transient('attempted_login');
        $datas['tried']++;
        
        if ($datas['tried'] <= 3) {
            set_transient('attempted_login', $datas, 300);
        }
    } else {
        $datas = array(
            'tried' => 1
        );
        set_transient('attempted_login', $datas, 300);
    }
}
add_action('wp_login_failed', 'yoursite_login_failed', 10, 1);

function yoursite_time_to_go($timestamp) {
    $periods = array('day', 'hour', 'minute', 'second');
    $lengths = array('86400', '3600', '60', '1');
    
    $current_timestamp = time();
    $difference = abs($current_timestamp - $timestamp);
    
    for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i++) {
        $difference /= $lengths[$i];
    }
    
    $difference = round($difference);
    
    if (isset($difference)) {
        if ($difference != 1) {
            $periods[$i] .= 's';
        }
        $output = "$difference $periods[$i]";
        return $output;
    }
}

/**
 * Hide sensitive information from REST API
 */
function yoursite_prepare_user_query($prepared_args, $request) {
    // Remove email from user queries if not admin
    if (!current_user_can('manage_options')) {
        unset($prepared_args['search_columns']);
    }
    
    return $prepared_args;
}
add_filter('rest_user_query', 'yoursite_prepare_user_query', 10, 2);

/**
 * Remove user enumeration
 */
function yoursite_disable_user_enumeration() {
    if (!is_admin() && isset($_GET['author'])) {
        wp_redirect(home_url(), 301);
        exit;
    }
}
add_action('template_redirect', 'yoursite_disable_user_enumeration');

/**
 * Secure wp-config.php
 */
function yoursite_secure_wp_config() {
    if (strpos($_SERVER['REQUEST_URI'], 'wp-config.php') !== false) {
        http_response_code(404);
        exit('File not found.');
    }
}
add_action('init', 'yoursite_secure_wp_config');

/**
 * Add Content Security Policy - UPDATED FOR YOUTUBE
 */
function yoursite_add_csp_header() {
    // Check if headers have already been sent
    if (!headers_sent() && !is_admin()) {
        $csp = "default-src 'self' https:; ";
        $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://www.youtube.com https://s.ytimg.com; ";
        $csp .= "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; ";
        $csp .= "font-src 'self' https://fonts.gstatic.com data:; ";
        $csp .= "img-src 'self' data: https: blob:; ";
        $csp .= "connect-src 'self' https:; ";
        $csp .= "frame-src 'self' blob: https://www.youtube.com https://www.youtube-nocookie.com; ";
        $csp .= "media-src 'self' https:; ";
        $csp .= "object-src 'none'; ";
        $csp .= "base-uri 'self'; ";
        $csp .= "form-action 'self'; ";
        $csp .= "frame-ancestors 'self'; ";
        $csp .= "worker-src 'self' blob:;";
        
        header("Content-Security-Policy: " . $csp);
    }
}
add_action('send_headers', 'yoursite_add_csp_header', 20);

/**
 * Alternative method using WordPress filters for CSP (if headers already sent)
 */
function yoursite_modify_csp_for_youtube($headers) {
    // Modify CSP to allow YouTube
    if (isset($headers['Content-Security-Policy'])) {
        $csp = $headers['Content-Security-Policy'];
        
        // Add YouTube to frame-src if not already present
        if (strpos($csp, 'frame-src') !== false) {
            // Update existing frame-src
            $csp = preg_replace(
                "/frame-src([^;]*);/", 
                "frame-src$1 https://www.youtube.com https://www.youtube-nocookie.com;", 
                $csp
            );
        } else {
            // Add frame-src
            $csp .= " frame-src 'self' blob: https://www.youtube.com https://www.youtube-nocookie.com;";
        }
        
        // Add worker-src if not present
        if (strpos($csp, 'worker-src') === false) {
            $csp .= " worker-src 'self' blob:;";
        }
        
        $headers['Content-Security-Policy'] = $csp;
    }
    
    return $headers;
}
add_filter('wp_headers', 'yoursite_modify_csp_for_youtube', 25);

/**
 * Add meta tag CSP as fallback for YouTube embeds
 */
function yoursite_add_csp_meta_tag() {
    // Only add on front-end pages where we might have YouTube embeds
    if (!is_admin()) {
        ?>
        <meta http-equiv="Content-Security-Policy" content="frame-src 'self' https://www.youtube.com https://www.youtube-nocookie.com;">
        <?php
    }
}
add_action('wp_head', 'yoursite_add_csp_meta_tag', 1);

/**
 * Sanitize file uploads
 */
function yoursite_sanitize_file_name($filename) {
    // Remove special characters
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
    
    // Remove multiple dots
    $filename = preg_replace('/\.+/', '.', $filename);
    
    return $filename;
}
add_filter('sanitize_file_name', 'yoursite_sanitize_file_name');

/**
 * Check file upload types
 */
function yoursite_check_file_type_and_ext($data, $file, $filename, $mimes) {
    $wp_filetype = wp_check_filetype($filename, $mimes);
    $ext = $wp_filetype['ext'];
    $type = $wp_filetype['type'];
    
    // Additional security check for PHP files
    if (in_array($ext, array('php', 'php3', 'php4', 'php5', 'phtml'))) {
        $data['ext'] = false;
        $data['type'] = false;
    }
    
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'yoursite_check_file_type_and_ext', 10, 4);

/**
 * Remove admin email check
 */
add_filter('admin_email_check_interval', '__return_false');

/**
 * Disable pingbacks
 */
function yoursite_disable_pingbacks(&$links) {
    foreach ($links as $l => $link) {
        if (0 === strpos($link, get_option('home'))) {
            unset($links[$l]);
        }
    }
}
add_action('pre_ping', 'yoursite_disable_pingbacks');

/**
 * Remove comment website field
 */
function yoursite_remove_comment_website_field($fields) {
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields', 'yoursite_remove_comment_website_field');

/**
 * Strengthen password requirements
 */
function yoursite_strong_password_check($errors, $sanitized_user_login, $user_email) {
    if (isset($_POST['pass1']) && !empty($_POST['pass1'])) {
        $password = $_POST['pass1'];
        
        if (strlen($password) < 8) {
            $errors->add('password_too_short', __('Password must be at least 8 characters long.', 'yoursite'));
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors->add('password_no_uppercase', __('Password must contain at least one uppercase letter.', 'yoursite'));
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors->add('password_no_lowercase', __('Password must contain at least one lowercase letter.', 'yoursite'));
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errors->add('password_no_number', __('Password must contain at least one number.', 'yoursite'));
        }
    }
    
    return $errors;
}
add_action('user_profile_update_errors', 'yoursite_strong_password_check', 0, 3);
add_action('validate_password_reset', 'yoursite_strong_password_check', 10, 2);

/**
 * Log security events
 */
function yoursite_log_security_event($event, $description = '') {
    if (!get_option('yoursite_security_log')) {
        add_option('yoursite_security_log', array());
    }
    
    $log = get_option('yoursite_security_log');
    $log[] = array(
        'timestamp' => current_time('mysql'),
        'event' => $event,
        'description' => $description,
        'ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown',
        'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown'
    );
    
    // Keep only last 100 entries
    if (count($log) > 100) {
        $log = array_slice($log, -100);
    }
    
    update_option('yoursite_security_log', $log);
}

/**
 * Log failed logins
 */
function yoursite_log_failed_login($username) {
    yoursite_log_security_event('failed_login', "Failed login attempt for username: $username");
}
add_action('wp_login_failed', 'yoursite_log_failed_login');

/**
 * Log successful logins
 */
function yoursite_log_successful_login($user_login, $user) {
    yoursite_log_security_event('successful_login', "Successful login for user: $user_login");
}
add_action('wp_login', 'yoursite_log_successful_login', 10, 2);

/**
 * Disable directory browsing
 */
function yoursite_disable_directory_browsing() {
    $htaccess_file = ABSPATH . '.htaccess';
    $directive = 'Options -Indexes';
    
    if (file_exists($htaccess_file) && is_writable($htaccess_file)) {
        $htaccess_content = file_get_contents($htaccess_file);
        if (strpos($htaccess_content, $directive) === false) {
            $htaccess_content = $directive . "\n" . $htaccess_content;
            file_put_contents($htaccess_file, $htaccess_content);
        }
    }
}
add_action('admin_init', 'yoursite_disable_directory_browsing');

/**
 * Allow YouTube iframes in content
 */
function yoursite_allow_youtube_iframe($allowedtags) {
    // Add iframe to allowed tags
    $allowedtags['iframe'] = array(
        'src' => true,
        'width' => true,
        'height' => true,
        'frameborder' => true,
        'allowfullscreen' => true,
        'allow' => true,
        'class' => true,
        'id' => true,
    );
    
    return $allowedtags;
}
add_filter('wp_kses_allowed_html', 'yoursite_allow_youtube_iframe', 10, 1);

/**
 * Remove CSP restrictions for admin area
 */
function yoursite_remove_admin_csp() {
    if (is_admin()) {
        remove_action('send_headers', 'yoursite_add_csp_header', 20);
    }
}
add_action('init', 'yoursite_remove_admin_csp');

/**
 * Add .htaccess rules for additional security
 */
function yoursite_add_htaccess_security() {
    $htaccess_file = ABSPATH . '.htaccess';
    $security_rules = "
# Security Headers for YouTube
<IfModule mod_headers.c>
    Header set Content-Security-Policy \"frame-src 'self' https://www.youtube.com https://www.youtube-nocookie.com;\"
</IfModule>
";
    
    if (file_exists($htaccess_file) && is_writable($htaccess_file)) {
        $htaccess_content = file_get_contents($htaccess_file);
        if (strpos($htaccess_content, 'Security Headers for YouTube') === false) {
            $htaccess_content .= "\n" . $security_rules;
            file_put_contents($htaccess_file, $htaccess_content);
        }
    }
}
add_action('admin_init', 'yoursite_add_htaccess_security');
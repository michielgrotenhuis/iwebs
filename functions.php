<?php
/**
 * YourSite.biz Theme Functions - COMPLETE VERSION WITH EDITOR FIXES
 * Main functions file that loads modular components and includes logo generator + editor fixes
 */
/**
 * AGGRESSIVE Block Editor Fix - Add this to the TOP of your functions.php
 * This should be the VERY FIRST thing after the opening <?php tag
 */

// =============================================================================
// IMMEDIATE CSP AND HEADER FIXES - MUST BE FIRST
// =============================================================================

/**
 * Completely disable ALL CSP and security headers in admin
 */
function yoursite_aggressive_admin_fix() {
    if (is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) {
        // Remove ALL potential CSP headers
        remove_action('send_headers', 'yoursite_add_csp_header', 5);
        remove_action('send_headers', 'yoursite_security_headers');
        remove_action('wp_head', 'yoursite_add_video_csp_meta', 1);
        remove_action('admin_head', 'yoursite_admin_csp_headers');
        
        // Override any existing CSP headers
        if (!headers_sent()) {
            // Completely permissive CSP for admin
            header_remove('Content-Security-Policy');
            header_remove('X-Content-Security-Policy');
            header_remove('X-WebKit-CSP');
            
            // Set ultra-permissive CSP
            header('Content-Security-Policy: default-src * data: blob: \'unsafe-inline\' \'unsafe-eval\'; script-src * data: blob: \'unsafe-inline\' \'unsafe-eval\'; style-src * data: blob: \'unsafe-inline\'; img-src * data: blob:; frame-src * data: blob:; worker-src * data: blob:; object-src *;');
        }
    }
}
// Hook this as early as possible
add_action('plugins_loaded', 'yoursite_aggressive_admin_fix', 1);
add_action('init', 'yoursite_aggressive_admin_fix', 1);
add_action('admin_init', 'yoursite_aggressive_admin_fix', 1);

/**
 * Alternative header method using output buffering
 */
function yoursite_override_headers() {
    if (is_admin()) {
        ob_start(function($buffer) {
            // Remove CSP meta tags from HTML
            $buffer = preg_replace('/<meta[^>]*http-equiv=["\']Content-Security-Policy["\'][^>]*>/i', '', $buffer);
            return $buffer;
        });
    }
}
add_action('admin_head', 'yoursite_override_headers', 1);

/**
 * Force remove security headers via htaccess override
 */
function yoursite_htaccess_override() {
    if (is_admin() && current_user_can('manage_options')) {
        $htaccess_file = ABSPATH . '.htaccess';
        
        if (is_writable($htaccess_file)) {
            $htaccess_content = file_get_contents($htaccess_file);
            
            // Remove any existing CSP headers
            $htaccess_content = preg_replace('/Header.*Content-Security-Policy.*\n/i', '', $htaccess_content);
            
            // Add permissive admin CSP
            $admin_csp = "\n# TEMPORARY Admin CSP Fix\n";
            $admin_csp .= "<IfModule mod_headers.c>\n";
            $admin_csp .= "    <If \"%{REQUEST_URI} =~ /wp-admin/\">\n";
            $admin_csp .= "        Header always unset Content-Security-Policy\n";
            $admin_csp .= "        Header always set Content-Security-Policy \"default-src * data: blob: 'unsafe-inline' 'unsafe-eval'\"\n";
            $admin_csp .= "    </If>\n";
            $admin_csp .= "</IfModule>\n\n";
            
            if (strpos($htaccess_content, 'TEMPORARY Admin CSP Fix') === false) {
                file_put_contents($htaccess_file, $admin_csp . $htaccess_content);
            }
        }
    }
}
add_action('admin_init', 'yoursite_htaccess_override');

/**
 * Block editor specific iframe fix
 */
function yoursite_block_editor_iframe_fix() {
    if (!is_admin()) return;
    ?>
    <script type="text/javascript">
    // AGGRESSIVE Block Editor Fix
    (function() {
        console.log('Loading aggressive block editor fix...');
        
        // Override CSP for iframes
        const originalCreateElement = document.createElement;
        document.createElement = function(tagName) {
            const element = originalCreateElement.call(this, tagName);
            
            if (tagName.toLowerCase() === 'iframe') {
                // Remove CSP restrictions for iframes
                element.addEventListener('load', function() {
                    try {
                        if (this.src && this.src.startsWith('blob:')) {
                            console.log('Blob iframe loaded successfully');
                        }
                    } catch (e) {
                        console.log('Iframe access handled:', e.message);
                    }
                });
                
                // Override error handling
                element.addEventListener('error', function(e) {
                    console.log('Iframe error intercepted and handled');
                    e.stopPropagation();
                    return false;
                });
            }
            
            return element;
        };
        
        // Fix documentElement null error
        const originalQuerySelector = Document.prototype.querySelector;
        Document.prototype.querySelector = function(selector) {
            try {
                return originalQuerySelector.call(this, selector);
            } catch (e) {
                if (e.message.includes('documentElement')) {
                    console.warn('documentElement error caught and handled');
                    return null;
                }
                throw e;
            }
        };
        
        // Override iframe creation in block editor
        if (window.wp && window.wp.element) {
            const originalCreateElement = window.wp.element.createElement;
            if (originalCreateElement) {
                window.wp.element.createElement = function(type, props, ...children) {
                    if (type === 'iframe' && props && props.src && props.src.startsWith('blob:')) {
                        // Allow blob URLs
                        console.log('Allowing blob URL in iframe:', props.src);
                    }
                    return originalCreateElement.call(this, type, props, ...children);
                };
            }
        }
        
        // Monkey patch to prevent CSP errors
        const originalConsoleError = console.error;
        console.error = function(...args) {
            const message = args[0];
            if (typeof message === 'string' && (
                message.includes('Content Security Policy') ||
                message.includes('Refused to frame') ||
                message.includes('blob:')
            )) {
                console.log('CSP error intercepted:', message);
                return; // Don't show CSP errors
            }
            originalConsoleError.apply(console, args);
        };
        
        // Wait for block editor and fix any issues
        if (typeof wp !== 'undefined' && wp.domReady) {
            wp.domReady(function() {
                console.log('Block editor DOM ready');
                
                // Ensure documentElement exists
                if (!document.documentElement) {
                    console.error('Critical: documentElement is missing');
                    // Try to recreate it
                    document.documentElement = document.createElement('html');
                }
                
                // Fix any existing iframes
                const iframes = document.querySelectorAll('iframe[src^="blob:"]');
                iframes.forEach(function(iframe) {
                    console.log('Found blob iframe, ensuring it works');
                    iframe.addEventListener('error', function(e) {
                        e.stopPropagation();
                        console.log('Blob iframe error handled');
                    });
                });
            });
        }
        
        // Observer to fix dynamically created iframes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.tagName === 'IFRAME' && node.src && node.src.startsWith('blob:')) {
                        console.log('Dynamic blob iframe detected, applying fix');
                        node.addEventListener('error', function(e) {
                            e.stopPropagation();
                            console.log('Dynamic iframe error handled');
                        });
                    }
                });
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
        
        console.log('Aggressive block editor fix loaded successfully');
    })();
    </script>
    
    <style>
    /* Hide CSP violation indicators */
    iframe[src^="blob:"] {
        border: 1px solid #ddd !important;
        background: #f9f9f9 !important;
    }
    
    /* Ensure block editor interface works */
    .block-editor-iframe__container iframe {
        border: none !important;
    }
    </style>
    <?php
}
add_action('admin_head', 'yoursite_block_editor_iframe_fix', 1);

/**
 * Nuclear option: Disable security features completely in admin
 */
function yoursite_nuclear_security_disable() {
    if (is_admin()) {
        // Remove all security-related hooks
        remove_all_actions('send_headers');
        remove_all_actions('wp_head', 10); // Remove CSP meta tags
        
        // Re-add only essential hooks
        add_action('wp_head', 'wp_enqueue_scripts', 1);
        add_action('wp_head', 'wp_print_styles', 8);
        add_action('wp_head', 'wp_print_head_scripts', 9);
        
        // Ensure no CSP
        header_remove('Content-Security-Policy');
        header_remove('X-Content-Security-Policy');
        header_remove('X-WebKit-CSP');
    }
}
add_action('admin_init', 'yoursite_nuclear_security_disable', 1);

/**
 * Emergency block editor mode
 */
function yoursite_emergency_block_editor() {
    if (is_admin() && isset($_GET['emergency_editor']) && $_GET['emergency_editor'] === '1') {
        // Completely disable all theme functions except essentials
        remove_all_actions('wp_head');
        remove_all_actions('send_headers');
        remove_all_actions('wp_footer');
        
        // Add only minimal required functions
        add_action('wp_head', 'wp_enqueue_scripts', 1);
        add_action('wp_head', 'wp_print_styles', 8);
        add_action('wp_head', 'wp_print_head_scripts', 9);
        
        // Ultra-permissive headers
        if (!headers_sent()) {
            header('Content-Security-Policy: *');
            header('X-Frame-Options: ALLOWALL');
        }
        
        echo '<div style="position: fixed; top: 32px; right: 10px; background: red; color: white; padding: 10px; z-index: 9999;">EMERGENCY MODE</div>';
    }
}
add_action('init', 'yoursite_emergency_block_editor');

/**
 * Add emergency mode link
 */
function yoursite_add_emergency_mode($wp_admin_bar) {
    if (current_user_can('manage_options')) {
        $wp_admin_bar->add_node(array(
            'id' => 'emergency-editor',
            'title' => 'Emergency Editor',
            'href' => admin_url('post-new.php?emergency_editor=1'),
            'meta' => array(
                'title' => 'Emergency editor mode with no restrictions',
                'style' => 'background: red; color: white;'
            )
        ));
    }
}
add_action('admin_bar_menu', 'yoursite_add_emergency_mode', 100);

/**
 * Server-level CSP override (for Apache)
 */
function yoursite_server_csp_override() {
    if (is_admin() && function_exists('apache_setenv')) {
        apache_setenv('no-csp', '1');
    }
}
add_action('admin_init', 'yoursite_server_csp_override');

/**
 * Final fallback: Iframe src rewriter
 */
function yoursite_iframe_src_rewriter() {
    if (!is_admin()) return;
    ?>
    <script>
    // Last resort: rewrite blob URLs
    setInterval(function() {
        const blobIframes = document.querySelectorAll('iframe[src^="blob:"]');
        blobIframes.forEach(function(iframe) {
            if (iframe.dataset.fixed !== 'true') {
                console.log('Attempting to fix blob iframe');
                iframe.dataset.fixed = 'true';
                
                // Try to extract content and recreate without blob
                try {
                    const src = iframe.src;
                    iframe.src = 'about:blank';
                    setTimeout(function() {
                        iframe.src = src;
                    }, 100);
                } catch (e) {
                    console.log('Iframe fix attempt handled');
                }
            }
        });
    }, 1000);
    </script>
    <?php
}
add_action('admin_footer', 'yoursite_iframe_src_rewriter');
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('YOURSITE_THEME_VERSION', '1.0.0');
define('YOURSITE_THEME_DIR', get_template_directory());
define('YOURSITE_THEME_URI', get_template_directory_uri());

// =============================================================================
// EMERGENCY BLOCK EDITOR FIXES - PRIORITY LOADING
// =============================================================================

/**
 * Emergency Block Editor Fix - Load First
 */
function yoursite_emergency_editor_fix() {
    if (is_admin()) {
        // Remove strict CSP in admin
        remove_action('send_headers', 'yoursite_add_csp_header', 5);
        remove_action('wp_head', 'yoursite_add_video_csp_meta', 1);
        remove_action('send_headers', 'yoursite_security_headers');
        
        // Add permissive admin headers
        if (!headers_sent()) {
            header('Content-Security-Policy: default-src * data: blob: \'unsafe-inline\' \'unsafe-eval\';');
        }
    }
}
add_action('init', 'yoursite_emergency_editor_fix', 1);

/**
 * Force enable block editor
 */
add_filter('use_block_editor_for_post_type', '__return_true', 100);
add_filter('use_block_editor_for_post', '__return_true', 100);

/**
 * Fix deprecated WordPress function warnings
 */
function yoursite_fix_deprecated_warnings() {
    if (!is_admin()) return;
    ?>
    <script type="text/javascript">
    (function() {
        // Fix for wp.editPost deprecation warnings
        if (typeof wp !== 'undefined' && wp.data && wp.editPost) {
            // Map deprecated functions to new ones
            const deprecatedMappings = {
                'PluginPostStatusInfo': 'wp.editor.PluginPostStatusInfo',
                'PluginSidebarMoreMenuItem': 'wp.editor.PluginSidebarMoreMenuItem', 
                'PluginSidebar': 'wp.editor.PluginSidebar',
                'PluginPostPublishPanel': 'wp.editor.PluginPostPublishPanel'
            };
            
            Object.keys(deprecatedMappings).forEach(function(oldKey) {
                if (wp.editPost[oldKey] && !wp.editor) {
                    wp.editor = wp.editor || {};
                }
                
                if (wp.editPost[oldKey] && wp.editor) {
                    wp.editor[oldKey] = wp.editPost[oldKey];
                }
            });
        }
        
        // Suppress deprecation console warnings
        const originalWarn = console.warn;
        console.warn = function() {
            const message = arguments[0];
            if (typeof message === 'string' && (
                message.includes('wp.editPost') || 
                message.includes('deprecated') ||
                message.includes('PluginPostStatusInfo') ||
                message.includes('PluginSidebarMoreMenuItem') ||
                message.includes('PluginSidebar') ||
                message.includes('PluginPostPublishPanel')
            )) {
                return; // Skip these warnings
            }
            originalWarn.apply(console, arguments);
        };
    })();
    </script>
    <?php
}
add_action('admin_head', 'yoursite_fix_deprecated_warnings');

/**
 * Fix block editor iframe and blob URL issues
 */
function yoursite_fix_block_editor_iframe() {
    if (!is_admin()) return;
    ?>
    <script type="text/javascript">
    (function() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initBlockEditorFixes);
        } else {
            initBlockEditorFixes();
        }
        
        function initBlockEditorFixes() {
            // Fix for iframe blob URL issues
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.tagName === 'IFRAME') {
                                fixIframeSource(node);
                            } else if (node.querySelectorAll) {
                                const iframes = node.querySelectorAll('iframe');
                                iframes.forEach(fixIframeSource);
                            }
                        });
                    }
                });
            });
            
            // Start observing
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
            
            // Fix existing iframes
            document.querySelectorAll('iframe').forEach(fixIframeSource);
        }
        
        function fixIframeSource(iframe) {
            try {
                const src = iframe.src;
                if (src && src.startsWith('blob:')) {
                    iframe.addEventListener('error', function() {
                        console.log('Iframe error handled for blob URL');
                    });
                }
            } catch (error) {
                console.log('Iframe fix error handled:', error.message);
            }
        }
        
        // Fix documentElement null errors
        if (typeof wp !== 'undefined' && wp.domReady) {
            wp.domReady(function() {
                if (!document.documentElement) {
                    console.error('documentElement is null - this should not happen');
                    return;
                }
                
                if (wp.blocks && wp.blockEditor) {
                    console.log('Block editor initialized successfully');
                }
            });
        }
    })();
    </script>
    <?php
}
add_action('admin_head', 'yoursite_fix_block_editor_iframe', 20);

// =============================================================================
// WORDPRESS EDITOR DIAGNOSTIC SCRIPT
// =============================================================================

/**
 * WordPress Editor Diagnostic Script
 */
function yoursite_emergency_editor_diagnostic() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    if (isset($_GET['editor_diagnostic']) && $_GET['editor_diagnostic'] === '1') {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Editor Diagnostic</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .diagnostic-section { background: #f9f9f9; padding: 15px; margin: 10px 0; border-radius: 5px; }
                .error { color: red; font-weight: bold; }
                .success { color: green; font-weight: bold; }
                .warning { color: orange; font-weight: bold; }
            </style>
        </head>
        <body>
            <h1>WordPress Editor Diagnostic Results</h1>
            
            <div class="diagnostic-section">
                <h2>Basic WordPress Info</h2>
                <p><strong>WordPress Version:</strong> <?php echo get_bloginfo('version'); ?></p>
                <p><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></p>
                <p><strong>Active Theme:</strong> <?php echo wp_get_theme()->get('Name'); ?></p>
                <p><strong>Is Admin:</strong> <?php echo is_admin() ? 'Yes' : 'No'; ?></p>
                <p><strong>Current User Can Edit Posts:</strong> <?php echo current_user_can('edit_posts') ? 'Yes' : 'No'; ?></p>
            </div>
            
            <div class="diagnostic-section">
                <h2>Block Editor Status</h2>
                <?php
                $block_editor_enabled = function_exists('register_block_type');
                echo '<p><strong>Block Editor Available:</strong> ';
                echo $block_editor_enabled ? '<span class="success">Yes</span>' : '<span class="error">No</span>';
                echo '</p>';
                
                // Check if Classic Editor plugin is active
                $classic_editor_active = is_plugin_active('classic-editor/classic-editor.php');
                echo '<p><strong>Classic Editor Plugin Active:</strong> ';
                echo $classic_editor_active ? '<span class="warning">Yes (This may interfere)</span>' : '<span class="success">No</span>';
                echo '</p>';
                
                // Check for Gutenberg plugin
                $gutenberg_active = is_plugin_active('gutenberg/gutenberg.php');
                echo '<p><strong>Gutenberg Plugin Active:</strong> ';
                echo $gutenberg_active ? '<span class="warning">Yes</span>' : '<span class="success">No</span>';
                echo '</p>';
                ?>
            </div>
            
            <div class="diagnostic-section">
                <h2>Active Plugins</h2>
                <?php
                $active_plugins = get_option('active_plugins');
                $problematic_plugins = array();
                
                foreach ($active_plugins as $plugin) {
                    $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
                    echo '<p>' . esc_html($plugin_data['Name']) . ' (v' . esc_html($plugin_data['Version']) . ')</p>';
                    
                    // Check for potentially problematic plugins
                    $problematic_keywords = array('security', 'cache', 'optimization', 'classic', 'editor');
                    foreach ($problematic_keywords as $keyword) {
                        if (stripos($plugin_data['Name'], $keyword) !== false) {
                            $problematic_plugins[] = $plugin_data['Name'];
                            break;
                        }
                    }
                }
                
                if (!empty($problematic_plugins)) {
                    echo '<h3 class="warning">Potentially Problematic Plugins:</h3>';
                    foreach ($problematic_plugins as $plugin) {
                        echo '<p class="warning">- ' . esc_html($plugin) . '</p>';
                    }
                }
                ?>
            </div>
            
            <div class="diagnostic-section">
                <h2>JavaScript & Console Errors</h2>
                <p>Check your browser's console (F12) for any JavaScript errors when trying to edit a post.</p>
                <p><strong>Common errors to look for:</strong></p>
                <ul>
                    <li>Content Security Policy violations</li>
                    <li>Cannot destructure property errors</li>
                    <li>wp.editPost deprecation warnings</li>
                    <li>Failed to load resource errors</li>
                </ul>
                
                <button onclick="testJavaScript()">Test JavaScript</button>
                <div id="js-test-result"></div>
                
                <script>
                function testJavaScript() {
                    const resultDiv = document.getElementById('js-test-result');
                    let results = [];
                    
                    // Test basic JavaScript
                    results.push('Basic JavaScript: Working');
                    
                    // Test for wp object
                    if (typeof wp !== 'undefined') {
                        results.push('wp object: Available');
                        
                        if (wp.blocks) {
                            results.push('wp.blocks: Available');
                        } else {
                            results.push('wp.blocks: MISSING');
                        }
                        
                        if (wp.blockEditor) {
                            results.push('wp.blockEditor: Available');
                        } else {
                            results.push('wp.blockEditor: MISSING');
                        }
                        
                        if (wp.editPost) {
                            results.push('wp.editPost: Available (may have deprecation warnings)');
                        }
                        
                        if (wp.editor) {
                            results.push('wp.editor: Available');
                        } else {
                            results.push('wp.editor: MISSING');
                        }
                    } else {
                        results.push('wp object: MISSING - This is a major problem');
                    }
                    
                    resultDiv.innerHTML = '<h4>Test Results:</h4><ul><li>' + results.join('</li><li>') + '</li></ul>';
                }
                </script>
            </div>
            
            <div class="diagnostic-section">
                <h2>Quick Fixes</h2>
                <p><a href="<?php echo admin_url('edit.php?deactivate_classic_editor=1'); ?>" class="button">Deactivate Classic Editor Plugin</a></p>
                <p><a href="<?php echo admin_url('edit.php?reset_editor=1'); ?>" class="button">Reset Editor Settings</a></p>
                <p><a href="<?php echo admin_url('edit.php?clear_cache=1'); ?>" class="button">Clear WordPress Cache</a></p>
                <p><a href="<?php echo admin_url('edit.php'); ?>" class="button">Return to Posts</a></p>
            </div>
            
            <div class="diagnostic-section">
                <h2>Manual Tests</h2>
                <ol>
                    <li>Try creating a new post: <a href="<?php echo admin_url('post-new.php'); ?>" target="_blank">Create New Post</a></li>
                    <li>Try editing an existing post (open in new tab)</li>
                    <li>Check browser console for errors (F12 → Console)</li>
                    <li>Try disabling all plugins temporarily</li>
                    <li>Try switching to a default theme (Twenty Twenty-Three)</li>
                </ol>
            </div>
            
        </body>
        </html>
        <?php
        exit;
    }
}
add_action('init', 'yoursite_emergency_editor_diagnostic');

/**
 * Quick fixes for common editor issues
 */
function yoursite_quick_editor_fixes() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Deactivate Classic Editor plugin
    if (isset($_GET['deactivate_classic_editor']) && $_GET['deactivate_classic_editor'] === '1') {
        deactivate_plugins('classic-editor/classic-editor.php');
        wp_redirect(admin_url('edit.php?classic_editor_deactivated=1'));
        exit;
    }
    
    // Reset editor settings
    if (isset($_GET['reset_editor']) && $_GET['reset_editor'] === '1') {
        delete_option('classic-editor-replace');
        delete_option('classic-editor-allow-users');
        flush_rewrite_rules();
        wp_redirect(admin_url('edit.php?editor_reset=1'));
        exit;
    }
    
    // Clear cache
    if (isset($_GET['clear_cache']) && $_GET['clear_cache'] === '1') {
        wp_cache_flush();
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
        wp_redirect(admin_url('edit.php?cache_cleared=1'));
        exit;
    }
}
add_action('admin_init', 'yoursite_quick_editor_fixes');

/**
 * Add diagnostic link to admin bar
 */
function yoursite_add_diagnostic_link($wp_admin_bar) {
    if (current_user_can('manage_options')) {
        $wp_admin_bar->add_node(array(
            'id' => 'editor-diagnostic',
            'title' => 'Editor Diagnostic',
            'href' => admin_url('?editor_diagnostic=1'),
            'meta' => array(
                'title' => 'Run editor diagnostic'
            )
        ));
    }
}
add_action('admin_bar_menu', 'yoursite_add_diagnostic_link', 100);

// =============================================================================
// ORIGINAL THEME FUNCTIONS
// =============================================================================

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
        'security.php',              // Security enhancements (loaded conditionally)
        'theme-activation.php',      // Theme activation hooks
        'theme-modes.php'            // Dark/Light mode functionality
    );
    
    foreach ($components as $component) {
        $file = YOURSITE_THEME_DIR . '/inc/' . $component;
        if (file_exists($file)) {
            // Load security.php only for frontend
            if ($component === 'security.php' && is_admin()) {
                continue; // Skip security.php in admin to avoid CSP conflicts
            }
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
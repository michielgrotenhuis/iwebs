<?php
/**
 * Enqueue scripts and styles
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue styles and scripts with proper loading order
 */
function yoursite_enqueue_scripts() {
    // Enqueue Google Fonts first
    wp_enqueue_style(
        'google-fonts', 
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', 
        array(), 
        null
    );
    
    // Enqueue Tailwind CSS
    wp_enqueue_style(
        'tailwind-css', 
        'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', 
        array(), 
        '2.2.19'
    );
    
    // Enqueue theme stylesheet LAST with high priority
    wp_enqueue_style(
        'theme-style', 
        get_stylesheet_uri(), 
        array('tailwind-css'), 
        YOURSITE_THEME_VERSION, 
        'all'
    );
    
    // Add inline CSS for critical styles
    $custom_css = yoursite_get_inline_css();
    wp_add_inline_style('theme-style', $custom_css);
    
    // Enqueue JavaScript
    $js_file = get_template_directory() . '/js/main.js';
    if (file_exists($js_file)) {
        wp_enqueue_script(
            'theme-script', 
            get_template_directory_uri() . '/js/main.js', 
            array('jquery'), 
            filemtime($js_file), 
            true
        );
        
        // Localize script for AJAX
        wp_localize_script('theme-script', 'yoursite_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('yoursite_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'yoursite_enqueue_scripts');

/**
 * Get inline CSS for critical styles
 */
function yoursite_get_inline_css() {
    return "
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            padding: 12px 24px !important;
            border-radius: 6px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            display: inline-block !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }
        .btn-primary:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3) !important;
            color: white !important;
            text-decoration: none !important;
        }
        .btn-secondary {
            background: white !important;
            border: 2px solid #e5e7eb !important;
            color: #374151 !important;
            padding: 12px 24px !important;
            border-radius: 6px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            display: inline-block !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }
        .btn-secondary:hover {
            border-color: #667eea !important;
            color: #667eea !important;
            text-decoration: none !important;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
        }
        .hero-gradient h1,
        .hero-gradient h2,
        .hero-gradient h3,
        .hero-gradient h4,
        .hero-gradient h5,
        .hero-gradient h6,
        .hero-gradient p,
        .hero-gradient span,
        .hero-gradient div {
            color: white !important;
        }
        .hero-gradient .btn-primary {
            background: white !important;
            color: #764ba2 !important;
        }
        .hero-gradient .btn-primary:hover {
            background: #f9fafb !important;
            color: #764ba2 !important;
        }
        .hero-gradient .btn-secondary {
            background: transparent !important;
            border: 2px solid white !important;
            color: white !important;
        }
        .hero-gradient .btn-secondary:hover {
            background: white !important;
            color: #764ba2 !important;
        }
        .text-white {
            color: white !important;
        }
        .bg-white {
            background-color: white !important;
        }
        .bg-gray-900 {
            background-color: #111827 !important;
            color: white !important;
        }
        .bg-gray-900 *,
        .bg-gray-900 h1,
        .bg-gray-900 h2,
        .bg-gray-900 h3,
        .bg-gray-900 h4,
        .bg-gray-900 h5,
        .bg-gray-900 h6,
        .bg-gray-900 p {
            color: white !important;
        }
        .feature-card {
            transition: all 0.3s ease !important;
        }
        .feature-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
            transform: translateY(-2px) !important;
        }
        
        /* Dark mode support for buttons */
        body.dark-mode .btn-secondary {
            background: var(--bg-secondary) !important;
            border-color: var(--border-secondary) !important;
            color: var(--text-primary) !important;
        }
        
        body.dark-mode .btn-secondary:hover {
            border-color: #667eea !important;
            color: #667eea !important;
        }
        
        /* Dark mode hero adjustments */
        body.dark-mode .hero-gradient .btn-secondary {
            background: transparent !important;
            border: 2px solid white !important;
            color: white !important;
        }
        
        body.dark-mode .hero-gradient .btn-secondary:hover {
            background: white !important;
            color: #764ba2 !important;
        }
    ";
}

/**
 * Add critical CSS inline in head
 */
function yoursite_critical_css() {
    echo '<style id="yoursite-critical">' . yoursite_get_inline_css() . '</style>';
}
add_action('wp_head', 'yoursite_critical_css', 1);

/**
 * Fix admin bar spacing
 */
function yoursite_admin_bar_styles() {
    if (is_admin_bar_showing()) {
        ?>
        <style>
        html {
            margin-top: 32px !important;
        }
        
        .site-header {
            top: 32px !important;
        }
        
        @media screen and (max-width: 782px) {
            html {
                margin-top: 46px !important;
            }
            
            .site-header {
                top: 46px !important;
            }
        }
        </style>
        <?php
    }
}
add_action('wp_head', 'yoursite_admin_bar_styles');

/**
 * Add dark mode preload script to prevent flash
 */
function yoursite_preload_dark_mode() {
    ?>
    <script>
    // Prevent flash of unstyled content for dark mode
    (function() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const defaultTheme = '<?php echo esc_js(get_theme_mod('default_theme_mode', 'light')); ?>';
        
        let theme = savedTheme;
        if (savedTheme === 'auto' || (!savedTheme && defaultTheme === 'auto')) {
            theme = prefersDark ? 'dark' : 'light';
        } else if (!savedTheme && defaultTheme !== 'light') {
            theme = defaultTheme;
        }
        
        if (theme === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    })();
    </script>
    <?php
}
add_action('wp_head', 'yoursite_preload_dark_mode', 0);
?>
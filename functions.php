<?php
/**
 * YourSite.biz Theme Functions - CLEAN VERSION WITH FIXED HERO SYSTEM
 */
// Temporary error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
require_once get_template_directory() . '/inc/pricing-loader.php';

// Define theme constants
define('YOURSITE_THEME_VERSION', '1.0.0');
define('YOURSITE_THEME_DIR', get_template_directory());
define('YOURSITE_THEME_URI', get_template_directory_uri());

// =============================================================================
// DARK MODE SYSTEM
// =============================================================================

/**
 * Add dark mode CSS variables
 */
function yoursite_add_dark_mode_vars() {
    echo '<style id="dark-mode-vars">
        :root {
            --text-primary: #111827;
            --text-secondary: #374151;
            --text-tertiary: #6b7280;
            --bg-primary: #ffffff;
            --bg-secondary: #f9fafb;
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
        }
        
        body.dark-mode {
            --text-primary: #f9fafb;
            --text-secondary: #e5e7eb;
            --text-tertiary: #d1d5db;
            --bg-primary: #111827;
            --bg-secondary: #1f2937;
            --card-bg: #1f2937;
            --border-color: #374151;
        }
    </style>';
}
add_action('wp_head', 'yoursite_add_dark_mode_vars', 1);

/**
 * Dark mode detection script
 */
function yoursite_dark_mode_detection() {
    echo '<script>
        (function() {
            const isDarkMode = localStorage.getItem("darkMode") === "enabled" ||
                             (localStorage.getItem("darkMode") === null && 
                              window.matchMedia && 
                              window.matchMedia("(prefers-color-scheme: dark)").matches);
            
            if (isDarkMode) {
                document.documentElement.classList.add("dark-mode");
                document.body.classList.add("dark-mode");
            }
        })();
    </script>';
}
add_action('wp_head', 'yoursite_dark_mode_detection', 0);

/**
 * Emergency dark mode fixes
 */
function yoursite_dark_mode_fixes() {
    echo '<style id="dark-mode-fixes">
        body.dark-mode {
            background-color: #111827 !important;
            color: #e5e7eb !important;
        }
        
        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6 {
            color: #f9fafb !important;
        }
        
        body.dark-mode .text-gray-900 {
            color: #f9fafb !important;
        }
        
        body.dark-mode .text-gray-600,
        body.dark-mode .text-gray-700 {
            color: #e5e7eb !important;
        }
        
        body.dark-mode .text-gray-500 {
            color: #d1d5db !important;
        }
        
        body.dark-mode .bg-white {
            background-color: #1f2937 !important;
        }
        
        body.dark-mode .bg-gray-50 {
            background-color: #374151 !important;
        }
        
        body.dark-mode .border-gray-200,
        body.dark-mode .border-gray-300 {
            border-color: #374151 !important;
        }
        
        body.dark-mode .hero-gradient *,
        body.dark-mode .templates-cta-section *,
        body.dark-mode .bg-gradient-to-br *,
        body.dark-mode .bg-gradient-to-r * {
            color: white !important;
        }
        
        /* Ensure final CTA (footer banner) maintains its gradient */
        body.dark-mode .final-cta-section,
        body.dark-mode section.hero-gradient:last-of-type {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }
        
        body.dark-mode .feature-card,
        body.dark-mode .pricing-card,
        body.dark-mode .webinar-card,
        body.dark-mode .template-card,
        body.dark-mode .templates-card {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        
        body.dark-mode .site-header {
            background-color: #111827 !important;
            border-bottom-color: #374151 !important;
        }
        
        body.dark-mode .site-header a {
            color: #e5e7eb !important;
        }
        
        body.dark-mode input,
        body.dark-mode textarea,
        body.dark-mode select {
            background-color: #374151 !important;
            border-color: #4b5563 !important;
            color: #f9fafb !important;
        }
        
        body.dark-mode .btn-secondary {
            background-color: #374151 !important;
            color: #f9fafb !important;
            border-color: #4b5563 !important;
        }
        
        body.dark-mode a {
            color: #60a5fa !important;
        }
        
        body.dark-mode .template-filter-btn {
            background-color: #1f2937 !important;
            color: #f9fafb !important;
            border-color: #374151 !important;
        }
        
        body.dark-mode .template-filter-btn.active {
            background-color: #8b5cf6 !important;
            color: white !important;
        }
        
        body.dark-mode .webinar-filter {
            background-color: #1f2937 !important;
            color: #f9fafb !important;
            border-color: #374151 !important;
        }
        
        body.dark-mode .webinar-filter.active {
            background-color: #1d4ed8 !important;
            color: white !important;
        }
    </style>';
}
add_action('wp_head', 'yoursite_dark_mode_fixes', 2);

/**
 * Dark mode toggle button
 */
function yoursite_dark_mode_toggle() {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if device is mobile
            function isMobile() {
                return window.innerWidth <= 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }
            
            // Only create toggle on desktop
            if (isMobile()) {
                return; // Exit early on mobile devices
            }
            
            let toggle = document.querySelector(".dark-mode-toggle");
            
            if (!toggle) {
                toggle = document.createElement("button");
                toggle.className = "dark-mode-toggle";
                toggle.innerHTML = `
                    <svg class="sun-icon" style="width:20px;height:20px;display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg class="moon-icon" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                `;
                toggle.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                    background: var(--card-bg);
                    border: 1px solid var(--border-color);
                    border-radius: 8px;
                    padding: 8px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                `;
                
                document.body.appendChild(toggle);
            }
            
            toggle.addEventListener("click", function() {
                const isDarkMode = document.body.classList.contains("dark-mode");
                
                if (isDarkMode) {
                    document.documentElement.classList.remove("dark-mode");
                    document.body.classList.remove("dark-mode");
                    localStorage.setItem("darkMode", "disabled");
                } else {
                    document.documentElement.classList.add("dark-mode");
                    document.body.classList.add("dark-mode");
                    localStorage.setItem("darkMode", "enabled");
                }
                
                updateToggleAppearance();
            });
            
            function updateToggleAppearance() {
                const isDarkMode = document.body.classList.contains("dark-mode");
                const sunIcon = toggle.querySelector(".sun-icon");
                const moonIcon = toggle.querySelector(".moon-icon");
                
                if (isDarkMode) {
                    sunIcon.style.display = "block";
                    moonIcon.style.display = "none";
                } else {
                    sunIcon.style.display = "none";
                    moonIcon.style.display = "block";
                }
            }
            
            updateToggleAppearance();
            
            // Hide toggle on window resize if screen becomes mobile size
            window.addEventListener("resize", function() {
                if (isMobile() && toggle) {
                    toggle.style.display = "none";
                } else if (toggle) {
                    toggle.style.display = "flex";
                }
            });
        });
    </script>';
}
add_action('wp_footer', 'yoursite_dark_mode_toggle');

// =============================================================================
// THEME SETUP
// =============================================================================

/**
 * Fallback theme setup (only if not already defined)
 */
if (!function_exists('yoursite_theme_setup')) {
    function yoursite_theme_setup_fallback() {
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('custom-logo');
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    }
    add_action('after_setup_theme', 'yoursite_theme_setup_fallback', 20);
}

/**
 * Enqueue scripts and styles
 */
function yoursite_scripts_minimal() {
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), YOURSITE_THEME_VERSION);
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'yoursite_scripts_minimal');

// =============================================================================
// COMPONENT LOADING
// =============================================================================

/**
 * Load theme components
 */
function yoursite_load_components() {
    $components = array(
        'theme-setup.php',
        'enqueue-scripts.php',
        'customizer.php',
        'post-types.php',
        'meta-boxes.php',
        'widgets.php',
        'helpers.php',
        'ajax-handlers.php',
        'admin-functions.php',
        'theme-activation.php',
        'theme-modes.php'
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
// PRESS KIT CUSTOMIZER
// =============================================================================

/**
 * Add press kit customizer options
 */
function yoursite_press_kit_customizer($wp_customize) {
    $wp_customize->add_section('press_kit_section', array(
        'title' => 'Press Kit Information',
        'priority' => 40,
    ));
    
    $settings = array(
        'company_founded' => array('label' => 'Company Founded Year', 'default' => '2020'),
        'company_location' => array('label' => 'Company Location', 'default' => 'San Francisco, CA, USA'),
        'company_industry' => array('label' => 'Company Industry', 'default' => 'E-commerce Technology & SaaS'),
        'company_employees' => array('label' => 'Number of Employees', 'default' => '50-100'),
        'stat_users' => array('label' => 'Active Users', 'default' => '100K+'),
        'stat_integrations' => array('label' => 'Integrations', 'default' => '50+'),
        'stat_countries' => array('label' => 'Countries Served', 'default' => '180+'),
        'stat_uptime' => array('label' => 'Uptime', 'default' => '99.9%')
    );
    
    foreach ($settings as $setting_key => $setting_data) {
        $wp_customize->add_setting($setting_key, array(
            'default' => $setting_data['default'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control($setting_key, array(
            'label' => $setting_data['label'],
            'section' => 'press_kit_section',
            'type' => 'text',
        ));
    }
    
    // Textarea settings
    $textarea_settings = array(
        'company_mission' => array(
            'label' => 'Mission Statement', 
            'default' => 'To empower businesses of all sizes with seamless integrations that drive growth, efficiency, and customer satisfaction in the digital economy.'
        ),
        'company_vision' => array(
            'label' => 'Vision Statement', 
            'default' => 'To be the world\'s leading platform for e-commerce integrations, connecting every business tool and service in a unified ecosystem.'
        )
    );
    
    foreach ($textarea_settings as $setting_key => $setting_data) {
        $wp_customize->add_setting($setting_key, array(
            'default' => $setting_data['default'],
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        
        $wp_customize->add_control($setting_key, array(
            'label' => $setting_data['label'],
            'section' => 'press_kit_section',
            'type' => 'textarea',
        ));
    }
}
add_action('customize_register', 'yoursite_press_kit_customizer');

// =============================================================================
// HERO BACKGROUND SYSTEM - SINGLE CLEAN IMPLEMENTATION
// =============================================================================

/**
 * Hero Background Image System - Main Customizer Function
 */
function yoursite_hero_background_customizer($wp_customize) {
    
    // Add section if it doesn't exist
    if (!$wp_customize->get_section('homepage_editor')) {
        $wp_customize->add_section('homepage_editor', array(
            'title' => __('Homepage', 'yoursite'),
            'priority' => 30,
        ));
    }
    
    // Hero Background Type
    $wp_customize->add_setting('hero_background_type', array(
        'default' => 'gradient',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_background_type', array(
        'label' => __('Hero Background Type', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'select',
        'choices' => array(
            'gradient' => __('Gradient Background', 'yoursite'),
            'image' => __('Image Background', 'yoursite'),
            'image_with_gradient' => __('Image with Gradient Overlay', 'yoursite'),
        ),
        'priority' => 13,
    ));
    
    // Hero Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label' => __('Hero Background Image', 'yoursite'),
        'section' => 'homepage_editor',
        'description' => __('Upload an image to use as hero background', 'yoursite'),
        'priority' => 14,
    )));
    
    // Gradient Primary Color
    $wp_customize->add_setting('hero_gradient_primary', array(
        'default' => '#667eea',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hero_gradient_primary', array(
        'label' => __('Gradient Primary Color', 'yoursite'),
        'section' => 'homepage_editor',
        'priority' => 15,
    )));
    
    // Gradient Secondary Color
    $wp_customize->add_setting('hero_gradient_secondary', array(
        'default' => '#764ba2',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hero_gradient_secondary', array(
        'label' => __('Gradient Secondary Color', 'yoursite'),
        'section' => 'homepage_editor',
        'priority' => 16,
    )));
    
    // Overlay Opacity
    $wp_customize->add_setting('hero_overlay_opacity', array(
        'default' => 40,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_overlay_opacity', array(
        'label' => __('Background Overlay Opacity (%)', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 0,
            'max' => 80,
            'step' => 5,
        ),
        'priority' => 17,
    ));
}
add_action('customize_register', 'yoursite_hero_background_customizer');

/**
 * Helper function for hex to rgba conversion
 */
function yoursite_hero_hex_to_rgba($hex, $alpha = 1) {
    $hex = str_replace('#', '', $hex);
    
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }
    
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    return 'rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $alpha . ')';
}

/**
 * Output the dynamic hero CSS - MAIN HERO ONLY
 */
function yoursite_hero_background_css() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    $background_type = get_theme_mod('hero_background_type', 'gradient');
    $background_image = get_theme_mod('hero_background_image', '');
    $gradient_primary = get_theme_mod('hero_gradient_primary', '#667eea');
    $gradient_secondary = get_theme_mod('hero_gradient_secondary', '#764ba2');
    $overlay_opacity = get_theme_mod('hero_overlay_opacity', 40);
    
    $css = '';
    switch ($background_type) {
        case 'gradient':
            $css = 'background: linear-gradient(135deg, ' . esc_attr($gradient_primary) . ' 0%, ' . esc_attr($gradient_secondary) . ' 100%) !important;';
            break;
            
        case 'image':
            if ($background_image) {
                $css = 'background: url("' . esc_url($background_image) . '") !important; background-size: cover !important; background-position: center !important; background-repeat: no-repeat !important;';
            }
            break;
            
        case 'image_with_gradient':
            if ($background_image) {
                $primary_rgba = yoursite_hero_hex_to_rgba($gradient_primary, 0.8);
                $secondary_rgba = yoursite_hero_hex_to_rgba($gradient_secondary, 0.8);
                $css = 'background: linear-gradient(135deg, ' . $primary_rgba . ' 0%, ' . $secondary_rgba . ' 100%), url("' . esc_url($background_image) . '") !important; background-size: cover !important; background-position: center !important; background-repeat: no-repeat !important;';
            }
            break;
    }
    
    echo '<style id="hero-background-dynamic">' . "\n";
    
    // Target only the FIRST hero section (main hero), not the final CTA
    echo '.hero-gradient:first-of-type, section.hero-gradient:first-of-type {' . "\n";
    echo '    position: relative !important;' . "\n";
    echo '    min-height: 600px !important;' . "\n";
    echo '    display: flex !important;' . "\n";
    echo '    align-items: center !important;' . "\n";
    echo '    color: white !important;' . "\n";
    echo '    ' . $css . "\n";
    echo '}' . "\n";
    
    // Ensure the final CTA keeps its default gradient
    echo 'section.hero-gradient:last-of-type, .final-cta-section {' . "\n";
    echo '    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;' . "\n";
    echo '}' . "\n";
    
    // Text styling for main hero only
    echo '.hero-gradient:first-of-type h1, .hero-gradient:first-of-type p, .hero-gradient:first-of-type .text-white {' . "\n";
    echo '    color: white !important;' . "\n";
    echo '}' . "\n";
    
    echo '</style>' . "\n";
}
add_action('wp_head', 'yoursite_hero_background_css', 20);

// =============================================================================
// INCLUDE ADDITIONAL FILES
// =============================================================================

// Include additional files if they exist
$additional_files = array(
    '/inc/difm-admin.php',
    '/inc/difm-post-type.php',
    '/inc/case-study-helpers.php'
);

foreach ($additional_files as $file) {
    $file_path = get_template_directory() . $file;
    if (file_exists($file_path)) {
        require_once $file_path;
    }
}

/**
 * Clean up any debug functions
 */
function yoursite_cleanup_debug() {
    // Remove debug actions that might be leftover
    remove_action('wp_head', 'test_wp_head_working');
    remove_action('wp_head', 'check_customizer_file');
    remove_action('wp_head', 'debug_hero_output');
    remove_action('wp_head', 'test_customizer_loading');
}
add_action('init', 'yoursite_cleanup_debug');

function yoursite_get_currency_symbol() {
    $currency = get_option('yoursite_currency', 'USD'); // fallback to USD if not set

    $symbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'AUD' => 'A$',
        'CAD' => 'C$',
        'JPY' => '¥',
        'INR' => '₹',
        // Add more currencies if needed
    ];

    return isset($symbols[$currency]) ? $symbols[$currency] : '$';
}

?>
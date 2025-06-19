<?php
/**
 * YourSite.biz Theme Functions - MINIMAL WORKING VERSION
 */

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

?>
<?php
/**
 * YourSite.biz Theme Functions - COMPLETE VERSION WITH UPDATED PRICING SYSTEM
 */
// Temporary error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

add_action('wp_ajax_switch_user_currency', 'yoursite_ajax_switch_user_currency');
add_action('wp_ajax_nopriv_switch_user_currency', 'yoursite_ajax_switch_user_currency');

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Load pricing system components
require_once get_template_directory() . '/inc/pricing-loader.php';
require_once get_template_directory() . '/inc/currency-loader.php';


// Define theme constants
define('YOURSITE_THEME_VERSION', '1.0.0');
define('YOURSITE_THEME_DIR', get_template_directory());
define('YOURSITE_THEME_URI', get_template_directory_uri());
if (function_exists('yoursite_add_header_currency_selector')) {
    add_action('wp_head', 'yoursite_add_header_currency_selector');
}


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
    document.addEventListener("DOMContentLoaded", function() {
        const isDarkMode = localStorage.getItem("darkMode") === "enabled" ||
                          (localStorage.getItem("darkMode") === null && 
                           window.matchMedia && 
                           window.matchMedia("(prefers-color-scheme: dark)").matches);
        
        if (isDarkMode) {
            document.documentElement.classList.add("dark-mode");
            document.body.classList.add("dark-mode");
        }
    });
</script>
';
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
        'theme-modes.php',
        'feature-pages.php'
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
// UPDATED PRICING SYSTEM INTEGRATION - CLEANED VERSION
// =============================================================================

/**
 * Remove old pricing plan customizer sections
 */
function yoursite_remove_old_pricing_customizer($wp_customize) {
    // Remove any existing pricing plan controls from customizer
    $old_controls = array(
        'pricing_plans_enable',
        'pricing_plan_1_enable', 'pricing_plan_1_name', 'pricing_plan_1_description', 'pricing_plan_1_price', 'pricing_plan_1_features', 'pricing_plan_1_button_text',
        'pricing_plan_2_enable', 'pricing_plan_2_name', 'pricing_plan_2_description', 'pricing_plan_2_price', 'pricing_plan_2_features', 'pricing_plan_2_button_text',
        'pricing_plan_3_enable', 'pricing_plan_3_featured', 'pricing_plan_3_name', 'pricing_plan_3_description', 'pricing_plan_3_price', 'pricing_plan_3_features', 'pricing_plan_3_button_text'
    );
    
    foreach ($old_controls as $control) {
        $wp_customize->remove_control($control);
        $wp_customize->remove_setting($control);
    }
}
add_action('customize_register', 'yoursite_remove_old_pricing_customizer', 99);

/**
 * Main admin notice to guide users to the new pricing system
 * (This is the MAIN one - the loader has a different one for dashboard only)
 */
function yoursite_pricing_admin_notice() {
    $screen = get_current_screen();
    
    // Only show on relevant admin pages (not dashboard - that's handled by loader)
    if (!$screen || (!strpos($screen->id, 'customize') && $screen->id !== 'edit-pricing' && $screen->id !== 'pricing')) {
        return;
    }
    
    // Don't show on dashboard
    if ($screen->id === 'dashboard') {
        return;
    }
    
    // Check if this notice has been dismissed
    $dismissed = get_user_meta(get_current_user_id(), 'yoursite_pricing_notice_dismissed', true);
    
    if (!$dismissed) {
        ?>
        <div class="notice notice-info is-dismissible" data-notice="yoursite-pricing-update">
            <h3><?php _e('🎉 Pricing Plans System Updated!', 'yoursite'); ?></h3>
            <p><?php _e('Great news! Your pricing plans are now managed directly in WP-Admin for better flexibility.', 'yoursite'); ?></p>
            <p><strong><?php _e('What changed:', 'yoursite'); ?></strong></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><?php _e('Pricing plans are now managed in <strong>WP-Admin → Pricing Plans</strong>', 'yoursite'); ?></li>
                <li><?php _e('Each plan has comprehensive feature settings for the comparison table', 'yoursite'); ?></li>
                <li><?php _e('Page content (hero, FAQ, CTA) is still customized in <strong>Appearance → Customize → Pricing Page</strong>', 'yoursite'); ?></li>
            </ul>
            <p>
                <a href="<?php echo admin_url('edit.php?post_type=pricing'); ?>" class="button button-primary">
                    <?php _e('Manage Pricing Plans', 'yoursite'); ?>
                </a>
                <a href="<?php echo admin_url('customize.php?autofocus[section]=pricing_page_editor'); ?>" class="button">
                    <?php _e('Customize Page Content', 'yoursite'); ?>
                </a>
                <a href="<?php echo home_url('/pricing'); ?>" class="button" target="_blank">
                    <?php _e('View Pricing Page', 'yoursite'); ?>
                </a>
            </p>
        </div>
        <script>
        jQuery(document).ready(function($) {
            $(document).on('click', '.notice[data-notice="yoursite-pricing-update"] .notice-dismiss', function() {
                $.post(ajaxurl, {
                    action: 'dismiss_yoursite_pricing_notice',
                    nonce: '<?php echo wp_create_nonce('dismiss_pricing_notice'); ?>'
                });
            });
        });
        </script>
        <?php
    }
}
add_action('admin_notices', 'yoursite_pricing_admin_notice');

/**
 * Handle dismissal of pricing notice
 */
function yoursite_dismiss_pricing_notice() {
    if (wp_verify_nonce($_POST['nonce'], 'dismiss_pricing_notice')) {
        update_user_meta(get_current_user_id(), 'yoursite_pricing_notice_dismissed', true);
    }
    wp_die();
}
add_action('wp_ajax_dismiss_yoursite_pricing_notice', 'yoursite_dismiss_pricing_notice');

/**
 * Clean up old pricing plan theme mods (run once)
 */
function yoursite_cleanup_old_pricing_mods() {
    // Only run this once
    if (get_option('yoursite_pricing_cleanup_done')) {
        return;
    }
    
    // Remove old pricing plan theme mods
    $old_mods = array(
        'pricing_plans_enable',
        'pricing_plan_1_enable', 'pricing_plan_1_name', 'pricing_plan_1_description', 'pricing_plan_1_price', 'pricing_plan_1_features', 'pricing_plan_1_button_text',
        'pricing_plan_2_enable', 'pricing_plan_2_name', 'pricing_plan_2_description', 'pricing_plan_2_price', 'pricing_plan_2_features', 'pricing_plan_2_button_text',
        'pricing_plan_3_enable', 'pricing_plan_3_featured', 'pricing_plan_3_name', 'pricing_plan_3_description', 'pricing_plan_3_price', 'pricing_plan_3_features', 'pricing_plan_3_button_text',
    );
    
    foreach ($old_mods as $mod) {
        remove_theme_mod($mod);
    }
    
    // Mark cleanup as done
    update_option('yoursite_pricing_cleanup_done', true);
}
add_action('after_switch_theme', 'yoursite_cleanup_old_pricing_mods');

/**
 * Ensure pricing comparison table gets latest data
 */
function yoursite_refresh_pricing_data() {
    // Clear any cached pricing data when plans are updated
    delete_transient('yoursite_pricing_plans_cache');
}
add_action('save_post_pricing', 'yoursite_refresh_pricing_data');
add_action('delete_post', 'yoursite_refresh_pricing_data');

// =============================================================================
// ENHANCED ADMIN EXPERIENCE FOR PRICING
// =============================================================================

/**
 * Add pricing plans to admin menu with counter
 */
function yoursite_enhance_pricing_admin_menu() {
    global $menu, $submenu;
    
    // Find the pricing plans menu item and add a counter
    foreach ($menu as $key => $item) {
        if (isset($item[2]) && $item[2] === 'edit.php?post_type=pricing') {
            $count = wp_count_posts('pricing');
            if ($count && $count->publish > 0) {
                $menu[$key][0] .= ' <span class="awaiting-mod">' . $count->publish . '</span>';
            }
            break;
        }
    }
}
add_action('admin_menu', 'yoursite_enhance_pricing_admin_menu', 999);

/**
 * Add pricing management to admin bar
 */
function yoursite_add_pricing_admin_bar($admin_bar) {
    if (!current_user_can('edit_posts')) {
        return;
    }
    
    $admin_bar->add_menu(array(
        'id' => 'pricing-management',
        'title' => '💰 Pricing',
        'href' => admin_url('edit.php?post_type=pricing'),
        'meta' => array(
            'title' => __('Manage Pricing Plans', 'yoursite'),
        ),
    ));
    
    $admin_bar->add_menu(array(
        'id' => 'add-pricing-plan',
        'parent' => 'pricing-management',
        'title' => 'Add New Plan',
        'href' => admin_url('post-new.php?post_type=pricing'),
    ));
    
    $admin_bar->add_menu(array(
        'id' => 'view-pricing-page',
        'parent' => 'pricing-management',
        'title' => 'View Pricing Page',
        'href' => home_url('/pricing'),
        'meta' => array('target' => '_blank'),
    ));
    
    $admin_bar->add_menu(array(
        'id' => 'customize-pricing',
        'parent' => 'pricing-management',
        'title' => 'Customize Content',
        'href' => admin_url('customize.php?autofocus[section]=pricing_page_editor'),
    ));
}
add_action('admin_bar_menu', 'yoursite_add_pricing_admin_bar', 80);

/**
 * Enhanced admin styles for pricing
 */
function yoursite_pricing_admin_styles() {
    $screen = get_current_screen();
    
    if (in_array($screen->id, array('pricing', 'edit-pricing'))) {
        ?>
        <style>
        .pricing-admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        
        .pricing-admin-header h2 {
            color: white;
            margin: 0 0 10px 0;
        }
        
        .pricing-feature-category {
            background: #fafafa;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .pricing-feature-category h4 {
            background: #667eea;
            color: white;
            margin: 0;
            padding: 15px;
            border-radius: 6px 6px 0 0;
        }
        
        .pricing-tips {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .pricing-tips h4 {
            margin-top: 0;
            color: #856404;
        }
        
        .feature-field {
            position: relative;
        }
        
        .feature-field input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 1px #667eea;
        }
        
        .pricing-meta-table input[type="number"]:focus,
        .pricing-meta-table input[type="text"]:focus,
        .pricing-meta-table input[type="url"]:focus,
        .pricing-meta-table select:focus,
        .pricing-meta-table textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 1px #667eea;
        }
        
        .admin-color-fresh .pricing-admin-header {
            background: linear-gradient(135deg, #00a0d2 0%, #0073aa 100%);
        }
        
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            // Add helpful header to pricing admin
            if ($('.wrap h1').length && $('.wrap h1').text().includes('Pricing')) {
                $('.wrap h1').after(`
                    <div class="pricing-admin-header">
                        <h2>💰 Pricing Plans Management</h2>
                        <p>Create and manage your pricing plans here. Each plan will automatically appear on your pricing page and in the comparison table.</p>
                        <p><strong>Tip:</strong> Use the detailed feature fields to populate the comprehensive comparison table with all your plan features.</p>
                    </div>
                `);
            }
            
            // Add quick actions for new pricing plans
            if ($('.page-title-action').length) {
                $('.page-title-action').after(`
                    <a href="<?php echo home_url('/pricing'); ?>" class="button" target="_blank" style="margin-left: 10px;">
                        👁️ View Pricing Page
                    </a>
                    <a href="<?php echo admin_url('customize.php?autofocus[section]=pricing_page_editor'); ?>" class="button" style="margin-left: 5px;">
                        🎨 Customize Content
                    </a>
                `);
            }
            
            // Add tips for feature fields
            if ($('.pricing-features-comparison').length) {
                $('.pricing-features-comparison').before(`
                    <div class="pricing-tips">
                        <h4>💡 Feature Configuration Tips</h4>
                        <ul>
                            <li><strong>"Yes" or "✓"</strong> - Shows a green checkmark</li>
                            <li><strong>"No" or "✗"</strong> - Shows a dash</li>
                            <li><strong>Numbers</strong> - Like "100", "1000" for limits</li>
                            <li><strong>"Unlimited"</strong> - Shows infinity symbol</li>
                            <li><strong>Descriptive text</strong> - Like "Basic support", "24/7 Premium"</li>
                        </ul>
                    </div>
                `);
            }
            
            // Auto-calculate annual price with 20% discount
            $('#pricing_monthly_price').on('input', function() {
                const monthlyPrice = parseFloat($(this).val());
                const annualField = $('#pricing_annual_price');
                
                if (monthlyPrice > 0 && !annualField.val()) {
                    const annualPrice = (monthlyPrice * 12 * 0.8).toFixed(2);
                    annualField.val(annualPrice);
                    annualField.css('background-color', '#f0f8ff');
                    
                    // Show helpful message
                    if (!annualField.next('.auto-calc-note').length) {
                        annualField.after('<p class="auto-calc-note" style="color: #0073aa; font-size: 12px; margin-top: 5px;">💡 Auto-calculated with 20% annual discount</p>');
                    }
                }
            });
            
            // Clear auto-calc styling when user manually edits
            $('#pricing_annual_price').on('input', function() {
                $(this).css('background-color', '');
                $(this).next('.auto-calc-note').remove();
            });
        });
        </script>
        <?php
    }
}
add_action('admin_head', 'yoursite_pricing_admin_styles');

/**
 * Add contextual help for pricing plans
 */
function yoursite_add_pricing_help() {
    $screen = get_current_screen();
    
    if ($screen->id === 'pricing') {
        $screen->add_help_tab(array(
            'id' => 'pricing_overview',
            'title' => __('Pricing Plans Overview'),
            'content' => '
                <h3>Managing Your Pricing Plans</h3>
                <p>This is where you create and manage individual pricing plans that appear on your pricing page.</p>
                
                <h4>Basic Information</h4>
                <ul>
                    <li><strong>Title:</strong> The name of your plan (e.g., "Starter", "Professional", "Enterprise")</li>
                    <li><strong>Excerpt:</strong> Short description that appears under the plan name</li>
                    <li><strong>Monthly/Annual Price:</strong> Set your pricing (annual price auto-calculates with 20% discount)</li>
                    <li><strong>Featured Plan:</strong> Mark your most popular plan to highlight it</li>
                </ul>
                
                <h4>Features Configuration</h4>
                <p>The detailed features section is used to populate the comprehensive comparison table. Use these values:</p>
                <ul>
                    <li><strong>"Yes", "✓", "Included"</strong> - Shows as a green checkmark</li>
                    <li><strong>"No", "✗", "-"</strong> - Shows as a dash</li>
                    <li><strong>Numbers</strong> - Display as-is (e.g., "100", "1000")</li>
                    <li><strong>"Unlimited"</strong> - Shows with infinity symbol</li>
                    <li><strong>Custom text</strong> - Any descriptive text (e.g., "Basic support", "Premium only")</li>
                </ul>
            '
        ));
        
        $screen->add_help_tab(array(
            'id' => 'pricing_tips',
            'title' => __('Best Practices'),
            'content' => '
                <h3>Pricing Page Best Practices</h3>
                
                <h4>Plan Structure</h4>
                <ul>
                    <li>Limit to 3-4 plans maximum for better decision-making</li>
                    <li>Mark one plan as "Featured" to guide customer choice</li>
                    <li>Use clear, descriptive plan names</li>
                    <li>Include brief but compelling plan descriptions</li>
                </ul>
                
                <h4>Pricing Strategy</h4>
                <ul>
                    <li>Annual pricing typically offers 15-25% discount</li>
                    <li>Featured plan should be your target customer choice</li>
                    <li>Include a free or low-cost entry plan when possible</li>
                    <li>Clear value progression between plans</li>
                </ul>
                
                <h4>Feature Presentation</h4>
                <ul>
                    <li>Lead with benefits, not just features</li>
                    <li>Use consistent language across all plans</li>
                    <li>Highlight unique features in higher-tier plans</li>
                    <li>Consider what matters most to your customers</li>
                </ul>
            '
        ));
    }
}
add_action('current_screen', 'yoursite_add_pricing_help');

/**
 * Add pricing plan templates/presets
 */
function yoursite_add_pricing_presets() {
    // Only add on new pricing plan page
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'pricing' && isset($_GET['preset'])) {
        add_action('admin_footer', function() {
            $preset = sanitize_text_field($_GET['preset']);
            
            $presets = array(
                'saas' => array(
                    'title' => 'Professional',
                    'excerpt' => 'Perfect for growing businesses',
                    'monthly_price' => '49',
                    'features' => "Unlimited products\nAdvanced analytics\nPriority support\nCustom integrations\nAPI access"
                ),
                'ecommerce' => array(
                    'title' => 'Store Builder',
                    'excerpt' => 'Everything you need to sell online',
                    'monthly_price' => '29',
                    'features' => "Up to 1,000 products\nPayment processing\nInventory management\nSEO tools\nMobile responsive"
                ),
                'enterprise' => array(
                    'title' => 'Enterprise',
                    'excerpt' => 'For large organizations with custom needs',
                    'monthly_price' => '199',
                    'features' => "Unlimited everything\nDedicated support\nCustom development\nSLA guarantee\nWhite-label options"
                )
            );
            
            if (isset($presets[$preset])) {
                $data = $presets[$preset];
                ?>
                <script>
                jQuery(document).ready(function($) {
                    $('#title').val('<?php echo esc_js($data['title']); ?>');
                    $('#excerpt').val('<?php echo esc_js($data['excerpt']); ?>');
                    $('#pricing_monthly_price').val('<?php echo esc_js($data['monthly_price']); ?>').trigger('input');
                    $('#pricing_features').val('<?php echo esc_js($data['features']); ?>');
                    
                    // Show success message
                    $('<div class="notice notice-success"><p><strong>Preset loaded!</strong> You can now customize these values to match your needs.</p></div>')
                        .insertAfter('.wrap h1');
                });
                </script>
                <?php
            }
        });
    }
}
add_action('admin_init', 'yoursite_add_pricing_presets');

// =============================================================================
// PERFORMANCE AND OPTIMIZATION
// =============================================================================

/**
 * Optimize pricing queries
 */
function yoursite_optimize_pricing_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_page_template('page-pricing.php') || is_page('pricing')) {
            // Preload pricing plans to avoid multiple queries
            $pricing_plans = get_posts(array(
                'post_type' => 'pricing',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'meta_key' => '_pricing_monthly_price',
                'orderby' => 'meta_value_num',
                'order' => 'ASC'
            ));
            
            // Cache the results
            set_transient('yoursite_pricing_plans_cache', $pricing_plans, HOUR_IN_SECONDS);
        }
    }
}
add_action('pre_get_posts', 'yoursite_optimize_pricing_queries');

/**
 * Add pricing plans to sitemap
 */
function yoursite_add_pricing_to_sitemap($provider, $name) {
    if ('posts' !== $name) {
        return $provider;
    }
    
    $provider->add_sitemap('pricing-plans', array(
        'loc' => home_url('/pricing'),
        'lastmod' => get_the_modified_date('c', get_option('page_for_posts')),
        'changefreq' => 'monthly',
        'priority' => 0.8
    ));
    
    return $provider;
}
add_filter('wp_sitemaps_posts_provider', 'yoursite_add_pricing_to_sitemap', 10, 2);

// =============================================================================
// BACKWARDS COMPATIBILITY AND MIGRATION
// =============================================================================

/**
 * Handle migration from old pricing system
 */
function yoursite_migrate_old_pricing_data() {
    // Check if migration has already been done
    if (get_option('yoursite_pricing_migrated')) {
        return;
    }
    
    // Check for old customizer pricing plans
    $old_plans = array();
    for ($i = 1; $i <= 3; $i++) {
        $plan_enabled = get_theme_mod("pricing_plan_{$i}_enable", false);
        if ($plan_enabled) {
            $old_plans[] = array(
                'name' => get_theme_mod("pricing_plan_{$i}_name", "Plan {$i}"),
                'description' => get_theme_mod("pricing_plan_{$i}_description", ''),
                'price' => get_theme_mod("pricing_plan_{$i}_price", '0'),
                'features' => get_theme_mod("pricing_plan_{$i}_features", ''),
                'featured' => get_theme_mod("pricing_plan_{$i}_featured", false),
                'button_text' => get_theme_mod("pricing_plan_{$i}_button_text", 'Get Started'),
            );
        }
    }
    
    // Migrate old plans to new post type
    if (!empty($old_plans)) {
        foreach ($old_plans as $plan) {
            $post_id = wp_insert_post(array(
                'post_title' => $plan['name'],
                'post_excerpt' => $plan['description'],
                'post_status' => 'publish',
                'post_type' => 'pricing'
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                update_post_meta($post_id, '_pricing_monthly_price', floatval($plan['price']));
                update_post_meta($post_id, '_pricing_annual_price', floatval($plan['price']) * 12 * 0.8);
                update_post_meta($post_id, '_pricing_currency', 'USD');
                update_post_meta($post_id, '_pricing_featured', $plan['featured'] ? '1' : '0');
                update_post_meta($post_id, '_pricing_button_text', $plan['button_text']);
                update_post_meta($post_id, '_pricing_button_url', '#');
                update_post_meta($post_id, '_pricing_features', $plan['features']);
            }
        }
        
        // Add admin notice about migration
        add_option('yoursite_pricing_migration_notice', true);
    }
    
    // Mark migration as complete
    update_option('yoursite_pricing_migrated', true);
}
add_action('after_switch_theme', 'yoursite_migrate_old_pricing_data');

/**
 * Show migration notice
 */
function yoursite_show_migration_notice() {
    if (get_option('yoursite_pricing_migration_notice')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <h3><?php _e('✅ Pricing Plans Migrated Successfully!', 'yoursite'); ?></h3>
            <p><?php _e('Your existing pricing plans have been automatically migrated to the new system.', 'yoursite'); ?></p>
            <p>
                <a href="<?php echo admin_url('edit.php?post_type=pricing'); ?>" class="button button-primary">
                    <?php _e('Review Your Pricing Plans', 'yoursite'); ?>
                </a>
            </p>
        </div>
        <?php
        delete_option('yoursite_pricing_migration_notice');
    }
}
add_action('admin_notices', 'yoursite_show_migration_notice');

?>
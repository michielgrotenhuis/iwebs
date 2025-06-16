<?php
/**
 * Dark/Light Mode Functionality - MOBILE FIXED VERSION
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create theme toggle button HTML - MOBILE IMPROVED
 */
function yoursite_get_theme_toggle_button() {
    return '
    <button id="theme-toggle" class="theme-toggle" aria-label="Toggle dark mode" title="Toggle dark mode" type="button">
        <div class="theme-toggle-slider">
            <svg class="theme-icon-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <svg class="theme-icon-moon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </div>
    </button>';
}

/**
 * Create mobile-specific theme toggle button
 */
function yoursite_get_mobile_theme_toggle_button() {
    return '
    <button id="mobile-theme-toggle" class="mobile-theme-toggle" aria-label="Toggle dark mode" title="Toggle dark mode" type="button">
        <div class="mobile-theme-toggle-slider">
            <svg class="mobile-theme-icon-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <svg class="mobile-theme-icon-moon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </div>
    </button>';
}

/**
 * Add dark mode toggle styles and scripts - MOBILE ENHANCED
 */
function yoursite_add_dark_mode_assets() {
    ?>
    <style id="dark-mode-styles">
    /* Desktop Dark Mode Toggle Button */
    .theme-toggle {
        position: relative;
        background: #f3f4f6;
        border: 2px solid #e5e7eb;
        border-radius: 50px;
        padding: 4px;
        width: 60px;
        height: 32px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        outline: none;
        -webkit-tap-highlight-color: transparent;
    }
    
    .theme-toggle:hover {
        border-color: #9ca3af;
        background: #e5e7eb;
    }
    
    .theme-toggle:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }
    
    .theme-toggle-slider {
        position: absolute;
        background: #374151;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        top: 4px;
        left: 4px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .theme-toggle-slider svg {
        width: 12px;
        height: 12px;
        color: white;
        transition: opacity 0.2s ease;
    }
    
    /* Mobile Dark Mode Toggle Button */
    .mobile-theme-toggle {
        position: relative;
        background: #f3f4f6;
        border: 2px solid #e5e7eb;
        border-radius: 50px;
        padding: 6px;
        width: 70px;
        height: 38px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        outline: none;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
        user-select: none;
    }
    
    .mobile-theme-toggle:hover,
    .mobile-theme-toggle:active {
        border-color: #9ca3af;
        background: #e5e7eb;
    }
    
    .mobile-theme-toggle:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }
    
    .mobile-theme-toggle-slider {
        position: absolute;
        background: #374151;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        top: 5px;
        left: 5px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .mobile-theme-toggle-slider svg {
        width: 14px;
        height: 14px;
        color: white;
        transition: opacity 0.2s ease;
    }
    
    /* Icon states - Desktop */
    .theme-toggle .theme-icon-sun {
        display: block;
    }
    
    .theme-toggle .theme-icon-moon {
        display: none;
    }
    
    /* Icon states - Mobile */
    .mobile-theme-toggle .mobile-theme-icon-sun {
        display: block;
    }
    
    .mobile-theme-toggle .mobile-theme-icon-moon {
        display: none;
    }
    
    /* Dark mode active state - Desktop */
    body.dark-mode .theme-toggle {
        border-color: #4b5563;
        background: #374151;
    }
    
    body.dark-mode .theme-toggle:hover {
        border-color: #6b7280;
        background: #4b5563;
    }
    
    body.dark-mode .theme-toggle-slider {
        transform: translateX(28px);
        background: #fbbf24;
    }
    
    body.dark-mode .theme-toggle .theme-icon-sun {
        display: none;
    }
    
    body.dark-mode .theme-toggle .theme-icon-moon {
        display: block;
        color: #374151;
    }
    
    /* Dark mode active state - Mobile */
    body.dark-mode .mobile-theme-toggle {
        border-color: #4b5563;
        background: #374151;
    }
    
    body.dark-mode .mobile-theme-toggle:hover,
    body.dark-mode .mobile-theme-toggle:active {
        border-color: #6b7280;
        background: #4b5563;
    }
    
    body.dark-mode .mobile-theme-toggle-slider {
        transform: translateX(32px);
        background: #fbbf24;
    }
    
    body.dark-mode .mobile-theme-toggle .mobile-theme-icon-sun {
        display: none;
    }
    
    body.dark-mode .mobile-theme-toggle .mobile-theme-icon-moon {
        display: block;
        color: #374151;
    }
    
    /* Dark Mode Variables */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f9fafb;
        --bg-tertiary: #f3f4f6;
        --text-primary: #111827;
        --text-secondary: #374151;
        --text-tertiary: #6b7280;
        --border-primary: #e5e7eb;
        --border-secondary: #d1d5db;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    body.dark-mode {
        --bg-primary: #111827;
        --bg-secondary: #1f2937;
        --bg-tertiary: #374151;
        --text-primary: #f9fafb;
        --text-secondary: #e5e7eb;
        --text-tertiary: #9ca3af;
        --border-primary: #374151;
        --border-secondary: #4b5563;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.4);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
    }
    
    /* Apply dark mode styles */
    body.dark-mode {
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }
    
    /* Header dark mode */
    body.dark-mode .site-header {
        background: rgba(17, 24, 39, 0.95) !important;
        backdrop-filter: blur(10px);
        border-color: var(--border-primary) !important;
    }
    
    body.dark-mode .site-title a,
    body.dark-mode .site-title a:hover,
    body.dark-mode .site-title a:visited,
    body.dark-mode .site-title a:focus {
        color: var(--text-primary) !important;
    }
    
    body.dark-mode .site-description {
        color: var(--text-tertiary) !important;
    }
    
    /* Navigation dark mode */
    body.dark-mode #primary-menu a {
        color: var(--text-secondary) !important;
    }
    
    body.dark-mode #primary-menu a:hover {
        color: #667eea !important;
        background-color: var(--bg-tertiary) !important;
    }
    
    body.dark-mode .mobile-menu-list a {
        color: var(--text-secondary) !important;
    }
    
    body.dark-mode .mobile-menu-list a:hover {
        color: #667eea !important;
        background-color: var(--bg-tertiary) !important;
    }
    
    /* Mobile navigation */
    body.dark-mode #mobile-navigation {
        background-color: var(--bg-primary) !important;
        border-color: var(--border-primary) !important;
    }
    
    /* Buttons dark mode */
    body.dark-mode .mobile-menu-toggle {
        border-color: var(--border-secondary) !important;
        color: var(--text-secondary) !important;
    }
    
    body.dark-mode .mobile-menu-toggle:hover {
        color: var(--text-primary) !important;
        border-color: var(--border-primary) !important;
    }
    
    body.dark-mode .login-btn {
        color: var(--text-secondary) !important;
    }
    
    body.dark-mode .login-btn:hover {
        color: #667eea !important;
    }
    
    /* Cards and content areas */
    body.dark-mode .bg-white {
        background-color: var(--bg-secondary) !important;
    }
    
    body.dark-mode .bg-gray-50 {
        background-color: var(--bg-tertiary) !important;
    }
    
    body.dark-mode .bg-gray-100 {
        background-color: var(--bg-tertiary) !important;
    }
    
    /* Text colors */
    body.dark-mode .text-gray-900,
    body.dark-mode h1,
    body.dark-mode h2,
    body.dark-mode h3,
    body.dark-mode h4,
    body.dark-mode h5,
    body.dark-mode h6 {
        color: var(--text-primary) !important;
    }
    
    body.dark-mode .text-gray-800 {
        color: var(--text-primary) !important;
    }
    
    body.dark-mode .text-gray-700,
    body.dark-mode p {
        color: var(--text-secondary) !important;
    }
    
    body.dark-mode .text-gray-600 {
        color: var(--text-tertiary) !important;
    }
    
    body.dark-mode .text-gray-500 {
        color: var(--text-tertiary) !important;
    }
    
    /* Mobile responsive toggle styles */
    @media (max-width: 1023px) {
        .theme-toggle {
            display: none;
        }
    }
    
    @media (min-width: 1024px) {
        .mobile-theme-toggle {
            display: none;
        }
    }
    
    /* Mobile actions styling improvements */
    .mobile-actions {
        background-color: rgba(249, 250, 251, 0.5);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }
    
    body.dark-mode .mobile-actions {
        background-color: rgba(55, 65, 81, 0.5);
    }
    
    .mobile-theme-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
    }
    
    .mobile-theme-label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }
    
    body.dark-mode .mobile-theme-label {
        color: var(--text-secondary);
    }
    
    /* Smooth transitions */
    * {
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }
    </style>
    
    <script id="dark-mode-script">
    document.addEventListener('DOMContentLoaded', function() {
        initThemeToggle();
    });
    
    function initThemeToggle() {
        // Check for saved theme preference or default to light mode
        const savedTheme = localStorage.getItem('theme') || 'light';
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = savedTheme === 'auto' ? (prefersDark ? 'dark' : 'light') : savedTheme;
        
        // Apply initial theme
        applyTheme(theme);
        
        // Desktop theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleTheme(this);
            });
            
            // Add touch event for mobile browsers accessing desktop element
            themeToggle.addEventListener('touchend', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleTheme(this);
            });
        }
        
        // Mobile theme toggle functionality
        const mobileThemeToggle = document.getElementById('mobile-theme-toggle');
        if (mobileThemeToggle) {
            mobileThemeToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleTheme(this);
            });
            
            mobileThemeToggle.addEventListener('touchend', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleTheme(this);
            });
        }
        
        // Listen for system theme changes
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                if (localStorage.getItem('theme') === 'auto') {
                    applyTheme(e.matches ? 'dark' : 'light');
                }
            });
        }
    }
    
    function toggleTheme(toggleButton) {
        const currentTheme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        applyTheme(newTheme);
        localStorage.setItem('theme', newTheme);
        
        // Add visual feedback
        if (toggleButton) {
            toggleButton.style.transform = 'scale(0.95)';
            setTimeout(() => {
                toggleButton.style.transform = 'scale(1)';
            }, 150);
        }
        
        console.log('Theme toggled to:', newTheme);
    }
    
    function applyTheme(theme) {
        const body = document.body;
        const themeToggle = document.getElementById('theme-toggle');
        const mobileThemeToggle = document.getElementById('mobile-theme-toggle');
        
        if (theme === 'dark') {
            body.classList.add('dark-mode');
            
            // Update desktop toggle
            if (themeToggle) {
                themeToggle.setAttribute('aria-label', 'Switch to light mode');
                themeToggle.title = 'Switch to light mode';
            }
            
            // Update mobile toggle
            if (mobileThemeToggle) {
                mobileThemeToggle.setAttribute('aria-label', 'Switch to light mode');
                mobileThemeToggle.title = 'Switch to light mode';
            }
        } else {
            body.classList.remove('dark-mode');
            
            // Update desktop toggle
            if (themeToggle) {
                themeToggle.setAttribute('aria-label', 'Switch to dark mode');
                themeToggle.title = 'Switch to dark mode';
            }
            
            // Update mobile toggle
            if (mobileThemeToggle) {
                mobileThemeToggle.setAttribute('aria-label', 'Switch to dark mode');
                mobileThemeToggle.title = 'Switch to dark mode';
            }
        }
        
        // Update meta theme-color for mobile browsers
        updateThemeColor(theme);
    }
    
    function updateThemeColor(theme) {
        let themeColorMeta = document.querySelector('meta[name="theme-color"]');
        if (!themeColorMeta) {
            themeColorMeta = document.createElement('meta');
            themeColorMeta.name = 'theme-color';
            document.head.appendChild(themeColorMeta);
        }
        
        themeColorMeta.content = theme === 'dark' ? '#111827' : '#ffffff';
    }
    
    // Prevent flash of unstyled content
    (function() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = savedTheme === 'auto' ? (prefersDark ? 'dark' : 'light') : savedTheme;
        
        if (theme === 'dark') {
            document.documentElement.classList.add('dark-mode');
            document.body.classList.add('dark-mode');
        }
    })();
    </script>
    <?php
}
add_action('wp_head', 'yoursite_add_dark_mode_assets', 1);

/**
 * Add dark mode body class helper
 */
function yoursite_add_dark_mode_body_class($classes) {
    // The class will be added/removed by JavaScript based on user preference
    return $classes;
}
add_filter('body_class', 'yoursite_add_dark_mode_body_class');

/**
 * Add prefers-color-scheme support
 */
function yoursite_add_color_scheme_meta() {
    echo '<meta name="color-scheme" content="light dark">';
}
add_action('wp_head', 'yoursite_add_color_scheme_meta', 1);

/**
 * Add dark mode customizer option
 */
function yoursite_add_dark_mode_customizer($wp_customize) {
    // Add Dark Mode Section
    $wp_customize->add_section('dark_mode_section', array(
        'title' => __('Dark Mode Settings', 'yoursite'),
        'priority' => 35,
    ));
    
    // Default theme setting
    $wp_customize->add_setting('default_theme_mode', array(
        'default' => 'light',
        'sanitize_callback' => 'yoursite_sanitize_theme_mode',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('default_theme_mode', array(
        'label' => __('Default Theme Mode', 'yoursite'),
        'section' => 'dark_mode_section',
        'type' => 'select',
        'choices' => array(
            'light' => __('Light Mode', 'yoursite'),
            'dark' => __('Dark Mode', 'yoursite'),
            'auto' => __('Auto (System Preference)', 'yoursite'),
        ),
    ));
    
    // Show toggle in header
    $wp_customize->add_setting('show_theme_toggle', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_theme_toggle', array(
        'label' => __('Show Theme Toggle in Header', 'yoursite'),
        'section' => 'dark_mode_section',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'yoursite_add_dark_mode_customizer');

/**
 * Sanitize theme mode setting
 */
function yoursite_sanitize_theme_mode($input) {
    $valid_modes = array('light', 'dark', 'auto');
    return in_array($input, $valid_modes) ? $input : 'light';
}

/**
 * Add dark mode support to existing functions
 */
function yoursite_dark_mode_customizer_css() {
    $default_theme = get_theme_mod('default_theme_mode', 'light');
    
    if ($default_theme !== 'light') {
        ?>
        <script>
        // Set default theme based on customizer setting
        (function() {
            const defaultTheme = '<?php echo esc_js($default_theme); ?>';
            if (!localStorage.getItem('theme')) {
                localStorage.setItem('theme', defaultTheme);
                if (defaultTheme === 'dark' || (defaultTheme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark-mode');
                    document.body.classList.add('dark-mode');
                }
            }
        })();
        </script>
        <?php
    }
}
add_action('wp_head', 'yoursite_dark_mode_customizer_css', 2);
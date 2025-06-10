<?php
/**
 * Dark/Light Mode Functionality
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add dark mode toggle styles and scripts
 */
function yoursite_add_dark_mode_assets() {
    ?>
    <style id="dark-mode-styles">
    /* Dark Mode Toggle Button */
    .theme-toggle {
        position: relative;
        background: transparent;
        border: 2px solid #e5e7eb;
        border-radius: 50px;
        padding: 4px;
        width: 60px;
        height: 32px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }
    
    .theme-toggle:hover {
        border-color: #9ca3af;
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
    }
    
    .theme-toggle-slider svg {
        width: 12px;
        height: 12px;
        color: white;
    }
    
    /* Dark mode active state */
    body.dark-mode .theme-toggle {
        border-color: #4b5563;
        background: #1f2937;
    }
    
    body.dark-mode .theme-toggle-slider {
        transform: translateX(28px);
        background: #fbbf24;
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
        background: rgba(17, 24, 39, 0.95);
        backdrop-filter: blur(10px);
        border-color: var(--border-primary);
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
        background-color: var(--bg-primary);
        border-color: var(--border-primary);
    }
    
    /* Buttons dark mode */
    body.dark-mode .mobile-menu-toggle {
        border-color: var(--border-secondary);
        color: var(--text-secondary);
    }
    
    body.dark-mode .mobile-menu-toggle:hover {
        color: var(--text-primary);
        border-color: var(--border-primary);
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
    
    /* Ensure all text elements inherit proper colors */
    body.dark-mode {
        color: var(--text-primary);
    }
    
    body.dark-mode *:not(.hero-gradient *):not(.bg-gray-900 *):not(.btn-primary *):not(.text-white):not(.text-blue-600):not(.text-green-500):not(.text-yellow-400) {
        color: inherit;
    }
    
    /* Specific text element overrides */
    body.dark-mode .text-xl,
    body.dark-mode .text-2xl,
    body.dark-mode .text-3xl,
    body.dark-mode .text-4xl,
    body.dark-mode .text-5xl,
    body.dark-mode .text-6xl {
        color: var(--text-primary) !important;
    }
    
    body.dark-mode .text-sm {
        color: var(--text-tertiary) !important;
    }
    
    body.dark-mode .text-base {
        color: var(--text-secondary) !important;
    }
    
    /* Font weight classes */
    body.dark-mode .font-bold,
    body.dark-mode .font-semibold,
    body.dark-mode .font-medium {
        color: var(--text-primary) !important;
    }
    
    /* Borders */
    body.dark-mode .border-gray-200 {
        border-color: var(--border-primary) !important;
    }
    
    body.dark-mode .border-gray-300 {
        border-color: var(--border-secondary) !important;
    }
    
    /* Form inputs */
    body.dark-mode input[type="text"],
    body.dark-mode input[type="email"],
    body.dark-mode input[type="tel"],
    body.dark-mode input[type="url"],
    body.dark-mode input[type="number"],
    body.dark-mode input[type="date"],
    body.dark-mode select,
    body.dark-mode textarea {
        background-color: var(--bg-tertiary);
        border-color: var(--border-secondary);
        color: var(--text-primary);
    }
    
    body.dark-mode input:focus,
    body.dark-mode select:focus,
    body.dark-mode textarea:focus {
        border-color: #667eea;
        background-color: var(--bg-secondary);
    }
    
    /* Feature cards */
    body.dark-mode .feature-card {
        background-color: var(--bg-secondary);
        border-color: var(--border-primary);
    }
    
    body.dark-mode .feature-card:hover {
        box-shadow: var(--shadow-lg);
    }
    
    /* Shadows */
    body.dark-mode .shadow-sm {
        box-shadow: var(--shadow-sm);
    }
    
    body.dark-mode .shadow-md {
        box-shadow: var(--shadow-md);
    }
    
    body.dark-mode .shadow-lg {
        box-shadow: var(--shadow-lg);
    }
    
    /* Footer */
    body.dark-mode .bg-gray-900 {
        background-color: #0f172a !important;
    }
    
    /* Smooth transitions */
    * {
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }
    
    /* Gradients remain unchanged for branding */
    .hero-gradient,
    .btn-primary {
        /* Keep original gradients for brand consistency */
    }
    
    /* Mobile responsive toggle */
    @media (max-width: 640px) {
        .theme-toggle {
            width: 50px;
            height: 28px;
        }
        
        .theme-toggle-slider {
            width: 18px;
            height: 18px;
            top: 3px;
            left: 3px;
        }
        
        body.dark-mode .theme-toggle-slider {
            transform: translateX(22px);
        }
        
        .theme-toggle-slider svg {
            width: 10px;
            height: 10px;
        }
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
        
        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                const currentTheme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                applyTheme(newTheme);
                localStorage.setItem('theme', newTheme);
                
                // Add a subtle animation
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
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
    
    function applyTheme(theme) {
        const body = document.body;
        const themeToggle = document.getElementById('theme-toggle');
        
        if (theme === 'dark') {
            body.classList.add('dark-mode');
            if (themeToggle) {
                themeToggle.setAttribute('aria-label', 'Switch to light mode');
                themeToggle.title = 'Switch to light mode';
            }
        } else {
            body.classList.remove('dark-mode');
            if (themeToggle) {
                themeToggle.setAttribute('aria-label', 'Switch to dark mode');
                themeToggle.title = 'Switch to dark mode';
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
 * Create theme toggle button HTML
 */
function yoursite_get_theme_toggle_button() {
    return '
    <button id="theme-toggle" class="theme-toggle" aria-label="Toggle dark mode" title="Toggle dark mode">
        <div class="theme-toggle-slider">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
    </button>';
}

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
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'yoursite'); ?></a>

    <!-- Announcement Bar (Optional) -->
    <?php if (get_theme_mod('show_announcement_bar', true)) : ?>
    <div class="announcement-bar bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm py-2 px-4 text-center relative">
        <div class="container mx-auto flex items-center justify-center">
            <span class="animate-pulse mr-2">🎉</span>
            <span><?php echo esc_html(get_theme_mod('announcement_text', 'Limited Time: Get 50% OFF on all annual plans! Use code SAVE50')); ?></span>
            <a href="<?php echo esc_url(get_theme_mod('announcement_link', '/pricing')); ?>" class="ml-3 underline font-semibold hover:no-underline">
                <?php echo esc_html(get_theme_mod('announcement_cta', 'Claim Now')); ?> →
            </a>
        </div>
        <button class="announcement-close absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-200" aria-label="Close announcement">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <?php endif; ?>

    <header id="masthead" class="site-header bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                
                <!-- Logo -->
                <div class="site-branding flex items-center">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <div class="site-title-wrapper">
                            <h1 class="site-title text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </h1>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Desktop Navigation -->
                <nav id="site-navigation" class="main-navigation hidden lg:flex items-center space-x-8">
                    <!-- Main Menu -->
                    <div class="nav-menu-wrapper">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'menu_class'     => 'flex items-center space-x-6',
                            'container'      => false,
                            'fallback_cb'    => 'yoursite_fallback_menu',
                            'walker'         => class_exists('YourSite_Dropdown_Walker') ? new YourSite_Dropdown_Walker() : '',
                        ));
                        ?>
                    </div>
                    
                    <!-- Header Actions -->
                    <div class="header-actions flex items-center space-x-4">
                        
                        <!-- Theme Toggle -->
                        <?php if (get_theme_mod('show_theme_toggle', true)) : ?>
                            <div class="theme-toggle-wrapper">
                                <?php if (function_exists('yoursite_get_theme_toggle_button')) {
                                    echo yoursite_get_theme_toggle_button();
                                } ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Login Button -->
                        <a href="<?php echo esc_url(get_theme_mod('header_login_url', '/login')); ?>" 
                           class="login-btn text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">
                            <?php echo esc_html(get_theme_mod('header_login_text', 'Login')); ?>
                        </a>
                        
                        <!-- Primary CTA Button -->
                        <a href="<?php echo esc_url(get_theme_mod('header_cta_url', '/signup')); ?>" 
                           class="cta-btn relative bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2.5 rounded-full font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 overflow-hidden group">
                            <span class="relative z-10 flex items-center">
                                <?php echo esc_html(get_theme_mod('header_cta_text', 'Start Free Trial')); ?>
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </span>
                            <span class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </a>
                    </div>
                </nav>

                <!-- Mobile Menu Button -->
                <button class="mobile-menu-toggle lg:hidden flex items-center justify-center w-10 h-10 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors" aria-label="Menu" aria-expanded="false">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Overlay -->
        <div id="mobile-navigation" class="mobile-navigation fixed inset-0 z-40 lg:hidden hidden">
            <!-- Overlay Background -->
            <div class="mobile-overlay absolute inset-0 bg-black bg-opacity-50"></div>
            
            <!-- Mobile Menu Panel -->
            <nav class="mobile-menu-panel absolute right-0 top-0 h-full w-80 max-w-full bg-white shadow-2xl transform translate-x-full transition-transform duration-300">
                <!-- Mobile Menu Header -->
                <div class="mobile-menu-header flex items-center justify-between p-4 border-b border-gray-200">
                    <span class="text-lg font-semibold text-gray-900">Menu</span>
                    <button class="mobile-menu-close p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Mobile Menu Content -->
                <div class="mobile-menu-content p-4 space-y-6 overflow-y-auto max-h-[calc(100vh-200px)]">
                    <!-- Mobile Search -->
                    <form role="search" method="get" class="mobile-search" action="<?php echo home_url('/'); ?>">
                        <div class="relative">
                            <input type="search" 
                                   class="w-full px-4 py-3 pr-10 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500" 
                                   placeholder="Search..." 
                                   value="<?php echo get_search_query(); ?>" 
                                   name="s" />
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Mobile Menu -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'mobile-menu',
                        'menu_class'     => 'mobile-menu-list space-y-2',
                        'container'      => false,
                        'fallback_cb'    => 'yoursite_mobile_fallback_menu',
                    ));
                    ?>
                    
                    <!-- Mobile Theme Toggle -->
                    <?php if (get_theme_mod('show_theme_toggle', true)) : ?>
                        <div class="mobile-theme-toggle-wrapper pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 font-medium">Dark Mode</span>
                                <?php if (function_exists('yoursite_get_mobile_theme_toggle_button')) {
                                    echo yoursite_get_mobile_theme_toggle_button();
                                } ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile CTA Section -->
                <div class="mobile-cta-section absolute bottom-0 left-0 right-0 p-4 bg-gray-50 border-t border-gray-200">
                    <a href="<?php echo esc_url(get_theme_mod('header_login_url', '/login')); ?>" 
                       class="block w-full text-center px-4 py-3 mb-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-white transition-colors">
                        <?php echo esc_html(get_theme_mod('header_login_text', 'Login')); ?>
                    </a>
                    
                    <a href="<?php echo esc_url(get_theme_mod('header_cta_url', '/signup')); ?>" 
                       class="block w-full text-center px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold shadow-lg">
                        <?php echo esc_html(get_theme_mod('header_cta_text', 'Start Free Trial')); ?>
                    </a>
                    
                    <!-- Trust Indicators -->
                    <div class="flex items-center justify-center mt-3 text-xs text-gray-600">
                        <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>No credit card required</span>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <style>
    /* ==========================================================================
       RESPONSIVE HEADER STYLES - COMPLETE SOLUTION
       ========================================================================== */
    
    /* Header Styles */
    .site-header {
        transition: all 0.3s ease;
    }
    
    .site-header.scrolled {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    /* Announcement Bar */
    .announcement-bar {
        font-size: 14px;
    }
    
    .announcement-bar.hidden {
        display: none;
    }
    
    /* ==========================================================================
       RESPONSIVE NAVIGATION - FIXED VERSION
       ========================================================================== */
    
    /* Desktop Navigation - Show on large screens only */
    .main-navigation {
        display: none;
    }
    
    @media (min-width: 1024px) {
        .main-navigation {
            display: flex !important;
        }
    }
    
    /* Mobile Menu Button - Show on small/medium screens only */
    .mobile-menu-toggle {
        display: flex;
    }
    
    @media (min-width: 1024px) {
        .mobile-menu-toggle {
            display: none !important;
        }
    }
    
    /* Mobile Navigation - Hide on large screens */
    .mobile-navigation {
        display: none;
    }
    
    @media (max-width: 1023px) {
        .mobile-navigation.active {
            display: block !important;
        }
    }
    
    @media (min-width: 1024px) {
        .mobile-navigation {
            display: none !important;
        }
    }
    
    /* Header Actions - Responsive visibility */
    .header-actions {
        display: none;
    }
    
    @media (min-width: 1024px) {
        .header-actions {
            display: flex !important;
        }
    }
    
    /* ==========================================================================
       HAMBURGER ICON ANIMATION
       ========================================================================== */
    
    .hamburger-icon {
        width: 24px;
        height: 18px;
        position: relative;
        display: block;
    }
    
    .hamburger-icon span {
        display: block;
        position: absolute;
        height: 2px;
        width: 100%;
        background: #374151;
        border-radius: 2px;
        opacity: 1;
        left: 0;
        transform: rotate(0deg);
        transition: 0.25s ease-in-out;
    }
    
    .hamburger-icon span:nth-child(1) {
        top: 0px;
    }
    
    .hamburger-icon span:nth-child(2) {
        top: 8px;
    }
    
    .hamburger-icon span:nth-child(3) {
        top: 16px;
    }
    
    .mobile-menu-toggle.active .hamburger-icon span:nth-child(1) {
        top: 8px;
        transform: rotate(135deg);
    }
    
    .mobile-menu-toggle.active .hamburger-icon span:nth-child(2) {
        opacity: 0;
        left: -60px;
    }
    
    .mobile-menu-toggle.active .hamburger-icon span:nth-child(3) {
        top: 8px;
        transform: rotate(-135deg);
    }
    
    /* ==========================================================================
       MOBILE NAVIGATION PANEL
       ========================================================================== */
    
    #mobile-navigation.active .mobile-menu-panel {
        transform: translateX(0);
    }
    
    .mobile-menu-list a {
        display: block;
        padding: 12px 16px;
        color: #374151;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .mobile-menu-list a:hover {
        background: #f3f4f6;
        color: #667eea;
    }
    
    /* ==========================================================================
       DROPDOWN MENU STYLES
       ========================================================================== */
    
    .nav-menu-wrapper .menu-item-has-children {
        position: relative;
    }
    
    .nav-menu-wrapper .sub-menu {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 220px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        padding: 8px;
        z-index: 9999;
    }
    
    .nav-menu-wrapper .menu-item-has-children:hover .sub-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .nav-menu-wrapper .sub-menu a {
        display: block;
        padding: 10px 16px;
        color: #374151;
        border-radius: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .nav-menu-wrapper .sub-menu a:hover {
        background: #f3f4f6;
        color: #667eea;
    }
    
    /* ==========================================================================
       DARK MODE ADJUSTMENTS
       ========================================================================== */
    
    body.dark-mode .site-header {
        background-color: rgba(31, 41, 55, 0.95);
        border-bottom-color: #374151;
    }
    
    body.dark-mode .site-header a {
        color: #e5e7eb;
    }
    
    body.dark-mode .site-header a:hover {
        color: #60a5fa;
    }
    
    body.dark-mode .announcement-bar {
        background: linear-gradient(to right, #4338ca, #7c3aed);
    }
    
    body.dark-mode .mobile-menu-panel {
        background-color: #1f2937;
    }
    
    body.dark-mode .mobile-menu-header {
        border-bottom-color: #374151;
        color: #f9fafb;
    }
    
    body.dark-mode .mobile-menu-list a {
        color: #e5e7eb;
    }
    
    body.dark-mode .mobile-menu-list a:hover {
        background: #374151;
        color: #60a5fa;
    }
    
    body.dark-mode .hamburger-icon span {
        background: #e5e7eb;
    }
    
    body.dark-mode .mobile-theme-toggle-wrapper {
        border-top-color: #374151;
    }
    
    body.dark-mode .mobile-cta-section {
        background-color: #374151;
        border-top-color: #4b5563;
    }
    
    body.dark-mode .nav-menu-wrapper .sub-menu {
        background-color: #1f2937;
        border-color: #374151;
    }
    
    body.dark-mode .nav-menu-wrapper .sub-menu a {
        color: #e5e7eb;
    }
    
    body.dark-mode .nav-menu-wrapper .sub-menu a:hover {
        background: #374151;
        color: #60a5fa;
    }
    
    /* ==========================================================================
       RESPONSIVE ADJUSTMENTS
       ========================================================================== */
    
    @media (max-width: 380px) {
        .site-header .container {
            padding-left: 12px;
            padding-right: 12px;
        }
        
        .mobile-menu-panel {
            width: 100%;
        }
    }
    
    /* Fix header flex layout */
    .site-header .flex {
        align-items: center;
        justify-content: space-between;
    }
    
    /* Ensure proper spacing */
    @media (min-width: 1024px) {
        .site-branding {
            flex: 0 0 auto;
        }
        
        .main-navigation {
            flex: 1 1 auto;
            justify-content: flex-end;
        }
    }
    
    /* Navigation menu items spacing */
    .nav-menu-wrapper #primary-menu {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .nav-menu-wrapper #primary-menu li {
        margin: 0;
    }
    
    .nav-menu-wrapper #primary-menu a {
        color: #374151;
        text-decoration: none;
        font-weight: 500;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .nav-menu-wrapper #primary-menu a:hover {
        color: #667eea;
        background-color: rgba(102, 126, 234, 0.1);
    }
    
    /* Mobile menu styling */
    .mobile-menu-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .mobile-menu-list li {
        margin: 0;
    }
    
    /* Prevent body scroll when mobile menu is open */
    body.mobile-menu-open {
        overflow: hidden;
        height: 100vh;
    }
    
    /* Logo responsive sizing */
    .custom-logo {
        max-height: 50px;
        width: auto;
    }
    
    @media (max-width: 768px) {
        .custom-logo {
            max-height: 40px;
        }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile Menu Toggle - COMPLETE SOLUTION
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mobileNav = document.querySelector('#mobile-navigation');
        const mobileOverlay = document.querySelector('.mobile-overlay');
        const mobileClose = document.querySelector('.mobile-menu-close');
        
        function toggleMobileMenu() {
            if (!mobileToggle || !mobileNav) return;
            
            mobileToggle.classList.toggle('active');
            mobileNav.classList.toggle('active');
            document.body.classList.toggle('mobile-menu-open');
            
            // Update ARIA attributes
            const isExpanded = mobileNav.classList.contains('active');
            mobileToggle.setAttribute('aria-expanded', isExpanded);
        }
        
        function closeMobileMenu() {
            if (!mobileToggle || !mobileNav) return;
            
            mobileToggle.classList.remove('active');
            mobileNav.classList.remove('active');
            document.body.classList.remove('mobile-menu-open');
            mobileToggle.setAttribute('aria-expanded', 'false');
        }
        
        // Event listeners
        if (mobileToggle) {
            mobileToggle.addEventListener('click', toggleMobileMenu);
        }
        
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', closeMobileMenu);
        }
        
        if (mobileClose) {
            mobileClose.addEventListener('click', closeMobileMenu);
        }
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileNav && mobileNav.classList.contains('active')) {
                closeMobileMenu();
                if (mobileToggle) mobileToggle.focus();
            }
        });
        
        // Close menu when window is resized to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024 && mobileNav && mobileNav.classList.contains('active')) {
                closeMobileMenu();
            }
        });
        
        // Announcement Bar Close
        const announcementClose = document.querySelector('.announcement-close');
        const announcementBar = document.querySelector('.announcement-bar');
        
        if (announcementClose && announcementBar) {
            announcementClose.addEventListener('click', function() {
                announcementBar.classList.add('hidden');
                // Save to localStorage to remember user preference
                localStorage.setItem('announcementClosed', 'true');
            });
            
            // Check if announcement was previously closed
            if (localStorage.getItem('announcementClosed') === 'true') {
                announcementBar.classList.add('hidden');
            }
        }
        
        // Header Scroll Effect
        let lastScroll = 0;
        const header = document.querySelector('.site-header');
        
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            lastScroll = currentScroll;
        });
    });
    </script>

    <main id="primary" class="site-main">

<?php
// Fallback menu function if it doesn't exist
if (!function_exists('yoursite_fallback_menu')) {
    function yoursite_fallback_menu() {
        echo '<ul class="flex items-center space-x-6">';
        echo '<li><a href="' . esc_url(home_url('/')) . '" class="text-gray-700 hover:text-blue-600 font-medium">Home</a></li>';
        echo '<li><a href="' . esc_url(home_url('/about')) . '" class="text-gray-700 hover:text-blue-600 font-medium">About</a></li>';
        echo '<li><a href="' . esc_url(home_url('/pricing')) . '" class="text-gray-700 hover:text-blue-600 font-medium">Pricing</a></li>';
        echo '<li><a href="' . esc_url(home_url('/contact')) . '" class="text-gray-700 hover:text-blue-600 font-medium">Contact</a></li>';
        echo '</ul>';
    }
}

// Mobile fallback menu function
if (!function_exists('yoursite_mobile_fallback_menu')) {
    function yoursite_mobile_fallback_menu() {
        echo '<ul class="mobile-menu-list space-y-2">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
        echo '<li><a href="' . esc_url(home_url('/about')) . '">About</a></li>';
        echo '<li><a href="' . esc_url(home_url('/pricing')) . '">Pricing</a></li>';
        echo '<li><a href="' . esc_url(home_url('/contact')) . '">Contact</a></li>';
        echo '</ul>';
    }
}

// Custom Walker for Dropdown Menus
if (!class_exists('YourSite_Dropdown_Walker')) {
    class YourSite_Dropdown_Walker extends Walker_Nav_Menu {
        function start_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        }
        
        function end_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }
        
        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';
            
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            
            $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';
            
            $output .= $indent . '<li' . $id . $class_names .'>';
            
            $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
            $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
            $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
            $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
            
            $item_output = isset($args->before) ? $args->before : '';
            $item_output .= '<a' . $attributes .'>';
            $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
            $item_output .= '</a>';
            $item_output .= isset($args->after) ? $args->after : '';
            
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }
}
?>
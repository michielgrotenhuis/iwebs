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

    <header id="masthead" class="site-header bg-white shadow-sm border-b border-gray-200" style="margin-top: <?php echo is_admin_bar_showing() ? '32px' : '0'; ?>;">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                
                <!-- Logo -->
                <div class="site-branding flex items-center">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php 
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            if ($logo) :
                            ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="custom-logo-link">
                                    <img src="<?php echo esc_url($logo[0]); ?>" 
                                         alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                                         class="custom-logo">
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <div class="site-title-wrapper">
                            <h1 class="site-title text-xl font-bold text-gray-900 no-hover-effect">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="text-gray-900 hover:text-gray-900 no-underline">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </h1>
                            <?php
                            $description = get_bloginfo('description', 'display');
                            if ($description || is_customize_preview()) :
                            ?>
                                <p class="site-description text-xs text-gray-600 mt-0.5"><?php echo $description; ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Desktop Navigation -->
                <nav id="site-navigation" class="main-navigation hidden lg:block">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'flex items-center space-x-6',
                        'container'      => false,
                        'fallback_cb'    => 'yoursite_fallback_menu',
                    ));
                    ?>
                </nav>

                <!-- Header Actions (CTA Buttons + Theme Toggle) -->
                <div class="header-actions hidden lg:flex items-center space-x-3">
                    <!-- Theme Toggle -->
                    <?php if (get_theme_mod('show_theme_toggle', true)) : ?>
                        <div class="theme-toggle-wrapper">
                            <?php echo yoursite_get_theme_toggle_button(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Login Button -->
                    <a href="<?php echo esc_url(get_theme_mod('header_login_url', '/login')); ?>" 
                       class="login-btn flex items-center px-3 py-1.5 text-sm text-gray-700 hover:text-blue-600 transition-colors duration-200 font-medium">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <?php echo esc_html(get_theme_mod('header_login_text', 'Login')); ?>
                    </a>
                    
                    <!-- CTA Button -->
                    <a href="<?php echo esc_url(get_theme_mod('header_cta_url', '/signup')); ?>" 
                       class="cta-btn bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-1.5 rounded-md text-sm font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <?php echo esc_html(get_theme_mod('header_cta_text', 'Start Free Trial')); ?>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="mobile-menu-toggle lg:hidden flex items-center justify-center w-9 h-9 border border-gray-300 rounded-md text-gray-600 hover:text-gray-800 hover:border-gray-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <nav id="mobile-navigation" class="mobile-navigation hidden lg:hidden border-t border-gray-200 py-4">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'mobile-menu',
                    'menu_class'     => 'mobile-menu-list',
                    'container'      => false,
                    'fallback_cb'    => 'yoursite_mobile_fallback_menu',
                ));
                ?>
                
                <!-- Mobile Actions -->
                <div class="mobile-actions mt-4 pt-4 border-t border-gray-200 space-y-3">
                    <!-- Mobile Theme Toggle -->
                    <?php if (get_theme_mod('show_theme_toggle', true)) : ?>
                        <div class="mobile-theme-toggle-row">
                            <span class="mobile-theme-label"><?php esc_html_e('Dark Mode', 'yoursite'); ?></span>
                            <?php echo yoursite_get_mobile_theme_toggle_button(); ?>
                        </div>
                        <div class="border-t border-gray-200 pt-3"></div>
                    <?php endif; ?>
                    
                    <!-- Mobile CTA Buttons -->
                    <a href="<?php echo esc_url(get_theme_mod('header_login_url', '/login')); ?>" 
                       class="mobile-login-btn flex items-center justify-center w-full px-4 py-2.5 text-sm text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors duration-200 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <?php echo esc_html(get_theme_mod('header_login_text', 'Login')); ?>
                    </a>
                    
                    <a href="<?php echo esc_url(get_theme_mod('header_cta_url', '/signup')); ?>" 
                       class="mobile-cta-btn bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2.5 rounded-md text-sm font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-sm flex items-center justify-center w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <?php echo esc_html(get_theme_mod('header_cta_text', 'Start Free Trial')); ?>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <style>
    /* Header Specific Styles - Improved and Cleaner */
    .site-header {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        position: relative;
        min-height: 64px;
    }
    
    /* Logo Styles */
    .site-title a,
    .site-title a:hover,
    .site-title a:visited,
    .site-title a:focus {
        color: #111827 !important;
        text-decoration: none !important;
    }
    
    .no-hover-effect a:hover {
        color: inherit !important;
    }
    
    /* Custom Logo Styles */
    .custom-logo-link {
        display: inline-block !important;
        max-width: 160px !important;
        width: auto !important;
        height: auto !important;
    }

    .custom-logo {
        max-width: 100% !important;
        width: auto !important;
        height: auto !important;
        max-height: 40px !important;
        object-fit: contain !important;
        display: block !important;
        transition: opacity 0.3s ease !important;
    }

    .custom-logo-link:hover .custom-logo {
        opacity: 0.8 !important;
    }

    /* Mobile responsive logo */
    @media (max-width: 768px) {
        .custom-logo-link {
            max-width: 120px !important;
        }
        
        .custom-logo {
            max-height: 32px !important;
        }
    }
    
    /* Navigation Menu Styling */
    #primary-menu {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    #primary-menu li {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    #primary-menu a {
        color: #374151 !important;
        font-weight: 500 !important;
        font-size: 1rem !important;
        padding: 6px 12px !important;
        border-radius: 4px !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        display: block !important;
    }
    
    #primary-menu a:hover {
        color: #667eea !important;
        background-color: #f3f4f6 !important;
        text-decoration: none !important;
    }
    
    /* Mobile Menu */
    .mobile-menu-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .mobile-menu-list li {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .mobile-menu-list a {
        color: #374151 !important;
        font-weight: 500 !important;
        font-size: 0.875rem !important;
        padding: 10px 12px !important;
        border-radius: 4px !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        display: block !important;
        margin-bottom: 2px !important;
    }
    
    .mobile-menu-list a:hover {
        color: #667eea !important;
        background-color: #f3f4f6 !important;
        text-decoration: none !important;
    }
    
    /* Mobile Navigation Responsive Visibility */
    #mobile-navigation {
        display: none;
    }
    
    @media (max-width: 1023px) {
        #mobile-navigation.hidden {
            display: none !important;
        }
        
        #mobile-navigation:not(.hidden) {
            display: block !important;
        }
    }
    
    @media (min-width: 1024px) {
        #mobile-navigation {
            display: none !important;
        }
    }
    
    /* Admin Bar Adjustment */
    body.admin-bar .site-header {
        margin-top: 32px !important;
    }
    
    @media screen and (max-width: 782px) {
        body.admin-bar .site-header {
            margin-top: 46px !important;
        }
    }
    
    /* Better CTA Button Styling */
    .cta-btn {
        font-size: 0.875rem !important;
        padding: 0.375rem 1rem !important;
        border-radius: 0.375rem !important;
        line-height: 1.5 !important;
    }
    
    .cta-btn:hover {
        transform: translateY(-1px) !important;
    }
    
    /* Login Button Styling */
    .login-btn {
        font-size: 0.875rem !important;
        line-height: 1.5 !important;
    }
    
    /* Mobile Menu Toggle Button */
    .mobile-menu-toggle {
        display: none;
        width: 36px !important;
        height: 36px !important;
        padding: 0 !important;
        border-radius: 0.375rem !important;
        transition: all 0.2s ease !important;
    }
    
    @media (max-width: 1023px) {
        .mobile-menu-toggle {
            display: flex !important;
        }
    }
    
    @media (min-width: 1024px) {
        .mobile-menu-toggle {
            display: none !important;
        }
    }
    
    .mobile-menu-toggle:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }
    
    .mobile-menu-toggle:active {
        transform: scale(0.95);
    }
    
    /* Header Actions Spacing */
    .header-actions {
        align-items: center;
        gap: 0.75rem;
    }
    
    .theme-toggle-wrapper {
        display: flex;
        align-items: center;
    }
    
    /* Theme Toggle Size Adjustment */
    .theme-toggle {
        width: 52px !important;
        height: 28px !important;
        padding: 3px !important;
    }
    
    .theme-toggle-slider {
        width: 18px !important;
        height: 18px !important;
        top: 3px !important;
        left: 3px !important;
    }
    
    .theme-toggle-slider svg {
        width: 10px !important;
        height: 10px !important;
    }
    
    body.dark-mode .theme-toggle-slider {
        transform: translateX(24px) !important;
    }
    
    /* Mobile Actions Styling */
    .mobile-actions {
        background-color: rgba(249, 250, 251, 0.5);
        border-radius: 6px;
        padding: 0.75rem;
        margin-top: 0.75rem;
    }
    
    .mobile-theme-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 6px 0;
    }
    
    .mobile-theme-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
    }
    
    body.dark-mode .mobile-theme-label {
        color: var(--text-secondary);
    }
    
    /* Site branding flex adjustments */
    .site-branding {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
    }

    .site-logo {
        flex-shrink: 0 !important;
    }

    .site-title-wrapper {
        min-width: 0 !important;
    }
    
    /* Ensure proper header height and alignment */
    .site-header > .container > .flex {
        min-height: 64px !important;
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }
    
    /* Smooth transitions */
    * {
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }
    
    /* Dark mode support */
    body.dark-mode .site-header {
        background: rgba(17, 24, 39, 0.98) !important;
        border-color: var(--border-primary) !important;
    }
    
    body.dark-mode .mobile-menu-toggle {
        border-color: var(--border-secondary) !important;
        color: var(--text-secondary) !important;
    }
    
    body.dark-mode .mobile-menu-toggle:hover {
        color: var(--text-primary) !important;
        border-color: var(--border-primary) !important;
        background-color: rgba(55, 65, 81, 0.5) !important;
    }
    
    body.dark-mode .login-btn {
        color: var(--text-secondary) !important;
    }
    
    body.dark-mode .login-btn:hover {
        color: #667eea !important;
    }
    
    body.dark-mode #primary-menu a,
    body.dark-mode .mobile-menu-list a {
        color: var(--text-secondary) !important;
    }
    
    body.dark-mode #primary-menu a:hover,
    body.dark-mode .mobile-menu-list a:hover {
        color: #667eea !important;
        background-color: var(--bg-tertiary) !important;
    }
    
    body.dark-mode #mobile-navigation {
        background-color: var(--bg-primary) !important;
        border-color: var(--border-primary) !important;
    }
    
    body.dark-mode .mobile-actions {
        background-color: rgba(55, 65, 81, 0.5);
    }
    </style>

    <script>
    // Mobile Menu Toggle - Improved
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mobileNav = document.querySelector('#mobile-navigation');
        
        if (mobileToggle && mobileNav) {
            mobileToggle.addEventListener('click', function(e) {
                e.preventDefault();
                mobileNav.classList.toggle('hidden');
                
                // Update button icon
                const icon = mobileToggle.querySelector('svg path');
                if (mobileNav.classList.contains('hidden')) {
                    icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                } else {
                    icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
                }
                
                // Add animation
                mobileToggle.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    mobileToggle.style.transform = 'scale(1)';
                }, 100);
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileToggle.contains(e.target) && !mobileNav.contains(e.target) && !mobileNav.classList.contains('hidden')) {
                    mobileNav.classList.add('hidden');
                    const icon = mobileToggle.querySelector('svg path');
                    icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                }
            });
        }
    });
    </script>

    <main id="primary" class="site-main">
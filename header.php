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

    <header id="masthead" class="site-header bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50" style="margin-top: <?php echo is_admin_bar_showing() ? '32px' : '0'; ?>;">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4 h-16">
                
                <!-- Logo -->
                <div class="site-branding flex items-center">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <div class="site-title-wrapper">
                            <h1 class="site-title text-2xl font-bold text-gray-900 no-hover-effect">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="text-gray-900 hover:text-gray-900 no-underline">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </h1>
                            <?php
                            $description = get_bloginfo('description', 'display');
                            if ($description || is_customize_preview()) :
                            ?>
                                <p class="site-description text-sm text-gray-600 mt-1"><?php echo $description; ?></p>
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
                        'menu_class'     => 'flex items-center space-x-8',
                        'container'      => false,
                        'fallback_cb'    => 'yoursite_fallback_menu',
                    ));
                    ?>
                </nav>

                <!-- Header Actions (CTA Buttons + Theme Toggle) -->
                <div class="header-actions hidden lg:flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <?php if (get_theme_mod('show_theme_toggle', true)) : ?>
                        <div class="theme-toggle-wrapper">
                            <?php echo yoursite_get_theme_toggle_button(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Login Button -->
                    <a href="<?php echo esc_url(get_theme_mod('header_login_url', '/login')); ?>" 
                       class="login-btn flex items-center px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-200 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <?php echo esc_html(get_theme_mod('header_login_text', 'Login')); ?>
                    </a>
                    
                    <!-- CTA Button -->
                    <a href="<?php echo esc_url(get_theme_mod('header_cta_url', '/signup')); ?>" 
                       class="cta-btn bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <?php echo esc_html(get_theme_mod('header_cta_text', 'Start Free Trial')); ?>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="mobile-menu-toggle lg:hidden flex items-center px-3 py-2 border border-gray-300 rounded text-gray-500 hover:text-gray-600 hover:border-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <nav id="mobile-navigation" class="mobile-navigation lg:hidden hidden border-t border-gray-200 py-4">
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
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Dark Mode</span>
                            <?php echo yoursite_get_theme_toggle_button(); ?>
                        </div>
                        <div class="border-t border-gray-200 pt-3"></div>
                    <?php endif; ?>
                    
                    <!-- Mobile CTA Buttons -->
                    <a href="<?php echo esc_url(get_theme_mod('header_login_url', '/login')); ?>" 
                       class="mobile-login-btn flex items-center justify-center w-full px-4 py-3 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <?php echo esc_html(get_theme_mod('header_login_text', 'Login')); ?>
                    </a>
                    
                    <a href="<?php echo esc_url(get_theme_mod('header_cta_url', '/signup')); ?>" 
                       class="mobile-cta-btn bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-md flex items-center justify-center w-full">
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
    /* Header Specific Styles */
    .site-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    
    /* Logo - No hover effect */
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
        padding: 8px 16px !important;
        border-radius: 6px !important;
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
        padding: 12px 16px !important;
        border-radius: 6px !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        display: block !important;
        margin-bottom: 4px !important;
    }
    
    .mobile-menu-list a:hover {
        color: #667eea !important;
        background-color: #f3f4f6 !important;
        text-decoration: none !important;
    }
    
    /* Admin Bar Adjustment */
    body.admin-bar .site-header {
        top: 32px;
    }
    
    @media screen and (max-width: 782px) {
        body.admin-bar .site-header {
            top: 46px;
        }
    }
    
    /* Better CTA Button Hover */
    .cta-btn:hover {
        transform: translateY(-1px) !important;
    }
    
    /* Mobile Menu Toggle */
    .mobile-menu-toggle:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }
    
    /* Header Actions Spacing */
    .header-actions {
        align-items: center;
        gap: 1rem;
    }
    
    .theme-toggle-wrapper {
        display: flex;
        align-items: center;
    }
    
    /* Mobile Actions Styling */
    .mobile-actions {
        background-color: rgba(249, 250, 251, 0.5);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }
    </style>

    <script>
    // Mobile Menu Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mobileNav = document.querySelector('#mobile-navigation');
        
        if (mobileToggle && mobileNav) {
            mobileToggle.addEventListener('click', function() {
                mobileNav.classList.toggle('hidden');
                
                // Update button icon
                const icon = mobileToggle.querySelector('svg path');
                if (mobileNav.classList.contains('hidden')) {
                    icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                } else {
                    icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
                }
            });
        }
    });
    </script>

    <main id="primary" class="site-main">
<?php
/**
 * Press Kit Page Customizer Settings
 * Add this file as: inc/customizer/customizer-press-kit.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Press Kit Page customizer options
 */
function yoursite_press_kit_page_customizer($wp_customize) {
    
    // Press Kit Page Section
    $wp_customize->add_section('press_kit_page_editor', array(
        'title' => __('Press Kit Page', 'yoursite'),
        'description' => __('Customize all elements of the Press Kit page', 'yoursite'),
        'panel' => 'yoursite_pages',
        'priority' => 60,
    ));
    
    // ========================================
    // HERO SECTION
    // ========================================
    
    // Hero Enable/Disable
    $wp_customize->add_setting('press_kit_hero_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Hero Title
    $wp_customize->add_setting('press_kit_hero_title', array(
        'default' => 'Press Kit',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 11,
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('press_kit_hero_subtitle', array(
        'default' => 'Download logos, product screenshots, company information, and other brand assets for media coverage, partnerships, and promotional use.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'textarea',
        'priority' => 12,
    ));
    
    // Hero Button Text
    $wp_customize->add_setting('press_kit_hero_button_text', array(
        'default' => 'Media Inquiries',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_hero_button_text', array(
        'label' => __('Hero Button Text', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 13,
    ));
    
    // ========================================
    // COMPANY OVERVIEW SECTION
    // ========================================
    
    // Company Overview Enable
    $wp_customize->add_setting('press_kit_company_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_company_enable', array(
        'label' => __('Enable Company Overview Section', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'checkbox',
        'priority' => 21,
    ));
    
    // Company Overview Title
    $wp_customize->add_setting('press_kit_company_title', array(
        'default' => 'About Our Company',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_company_title', array(
        'label' => __('Company Section Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 22,
    ));
    
    // Company Overview Subtitle
    $wp_customize->add_setting('press_kit_company_subtitle', array(
        'default' => 'Essential information for media coverage and partnerships',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_company_subtitle', array(
        'label' => __('Company Section Subtitle', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 23,
    ));
    
    // Company Founded Year
    $wp_customize->add_setting('press_kit_company_founded', array(
        'default' => '2020',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_company_founded', array(
        'label' => __('Company Founded Year', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 24,
    ));
    
    // Company Headquarters
    $wp_customize->add_setting('press_kit_company_headquarters', array(
        'default' => 'San Francisco, CA, USA',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_company_headquarters', array(
        'label' => __('Company Headquarters', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 25,
    ));
    
    // Company Industry
    $wp_customize->add_setting('press_kit_company_industry', array(
        'default' => 'E-commerce Technology & SaaS',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_company_industry', array(
        'label' => __('Company Industry', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 26,
    ));
    
    // Company Employees
    $wp_customize->add_setting('press_kit_company_employees', array(
        'default' => '50-100',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_company_employees', array(
        'label' => __('Number of Employees', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 27,
    ));
    
    // Mission Statement
    $wp_customize->add_setting('press_kit_company_mission', array(
        'default' => 'To empower businesses of all sizes with seamless integrations that drive growth, efficiency, and customer satisfaction in the digital economy.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_company_mission', array(
        'label' => __('Mission Statement', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'textarea',
        'priority' => 28,
    ));
    
    // Vision Statement
    $wp_customize->add_setting('press_kit_company_vision', array(
        'default' => 'To be the world\'s leading platform for e-commerce integrations, connecting every business tool and service in a unified ecosystem.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_company_vision', array(
        'label' => __('Vision Statement', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'textarea',
        'priority' => 29,
    ));
    
    // Core Values
    $wp_customize->add_setting('press_kit_company_values', array(
        'default' => "Innovation & Excellence\nCustomer Success\nTransparency & Trust\nGlobal Accessibility",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_company_values', array(
        'label' => __('Core Values (one per line)', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'textarea',
        'priority' => 30,
    ));
    
    // ========================================
    // KEY STATISTICS SECTION
    // ========================================
    
    // Statistics Enable
    $wp_customize->add_setting('press_kit_stats_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_stats_enable', array(
        'label' => __('Enable Key Statistics Section', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'checkbox',
        'priority' => 31,
    ));
    
    // Statistics Title
    $wp_customize->add_setting('press_kit_stats_title', array(
        'default' => 'Key Statistics',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_stats_title', array(
        'label' => __('Statistics Section Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 32,
    ));
    
    // Statistics Subtitle
    $wp_customize->add_setting('press_kit_stats_subtitle', array(
        'default' => 'Numbers that tell our story',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_stats_subtitle', array(
        'label' => __('Statistics Section Subtitle', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 33,
    ));
    
    // Statistics
    $default_stats = array(
        array('number' => '100K+', 'label' => 'Active Users'),
        array('number' => '50+', 'label' => 'Integrations'),
        array('number' => '180+', 'label' => 'Countries Served'),
        array('number' => '99.9%', 'label' => 'Uptime')
    );
    
    for ($i = 1; $i <= 4; $i++) {
        $stat = $default_stats[$i - 1];
        
        $wp_customize->add_setting("press_kit_stat_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_stat_{$i}_enable", array(
            'label' => __("Enable Statistic {$i}", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'checkbox',
            'priority' => 34 + ($i - 1) * 3,
        ));
        
        $wp_customize->add_setting("press_kit_stat_{$i}_number", array(
            'default' => $stat['number'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_stat_{$i}_number", array(
            'label' => __("Statistic {$i} Number", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'text',
            'priority' => 35 + ($i - 1) * 3,
        ));
        
        $wp_customize->add_setting("press_kit_stat_{$i}_label", array(
            'default' => $stat['label'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_stat_{$i}_label", array(
            'label' => __("Statistic {$i} Label", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'text',
            'priority' => 36 + ($i - 1) * 3,
        ));
    }
    
    // ========================================
    // LEADERSHIP TEAM SECTION
    // ========================================
    
    // Leadership Enable
    $wp_customize->add_setting('press_kit_leadership_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_leadership_enable', array(
        'label' => __('Enable Leadership Section', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'checkbox',
        'priority' => 47,
    ));
    
    // Leadership Title
    $wp_customize->add_setting('press_kit_leadership_title', array(
        'default' => 'Leadership Team',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_leadership_title', array(
        'label' => __('Leadership Section Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 48,
    ));
    
    // Leadership Subtitle
    $wp_customize->add_setting('press_kit_leadership_subtitle', array(
        'default' => 'Meet the people behind our success',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_leadership_subtitle', array(
        'label' => __('Leadership Section Subtitle', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 49,
    ));
    
    // Leadership Team Members
    $default_leaders = array(
        array('name' => 'John Doe', 'title' => 'CEO & Co-Founder', 'initials' => 'JD', 'bio' => 'Former VP of Engineering at Stripe. 15+ years in fintech and e-commerce platforms.'),
        array('name' => 'Jane Smith', 'title' => 'CTO & Co-Founder', 'initials' => 'JS', 'bio' => 'Former Lead Engineer at PayPal. Expert in distributed systems and API architecture.'),
        array('name' => 'Mike Johnson', 'title' => 'VP of Sales', 'initials' => 'MJ', 'bio' => 'Former Sales Director at Shopify. 12+ years building and scaling SaaS sales teams.')
    );
    
    for ($i = 1; $i <= 3; $i++) {
        $leader = $default_leaders[$i - 1];
        
        $wp_customize->add_setting("press_kit_leader_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_leader_{$i}_enable", array(
            'label' => __("Enable Leader {$i}", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'checkbox',
            'priority' => 50 + ($i - 1) * 5,
        ));
        
        $wp_customize->add_setting("press_kit_leader_{$i}_name", array(
            'default' => $leader['name'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_leader_{$i}_name", array(
            'label' => __("Leader {$i} Name", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'text',
            'priority' => 51 + ($i - 1) * 5,
        ));
        
        $wp_customize->add_setting("press_kit_leader_{$i}_title", array(
            'default' => $leader['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_leader_{$i}_title", array(
            'label' => __("Leader {$i} Title", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'text',
            'priority' => 52 + ($i - 1) * 5,
        ));
        
        $wp_customize->add_setting("press_kit_leader_{$i}_initials", array(
            'default' => $leader['initials'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_leader_{$i}_initials", array(
            'label' => __("Leader {$i} Initials", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'text',
            'priority' => 53 + ($i - 1) * 5,
        ));
        
        $wp_customize->add_setting("press_kit_leader_{$i}_bio", array(
            'default' => $leader['bio'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_leader_{$i}_bio", array(
            'label' => __("Leader {$i} Bio", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'textarea',
            'priority' => 54 + ($i - 1) * 5,
        ));
    }
    
    // ========================================
    // BRAND ASSETS SECTION
    // ========================================
    
    // Brand Assets Enable
    $wp_customize->add_setting('press_kit_assets_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_assets_enable', array(
        'label' => __('Enable Brand Assets Section', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'checkbox',
        'priority' => 66,
    ));
    
    // Brand Assets Title
    $wp_customize->add_setting('press_kit_assets_title', array(
        'default' => 'Brand Assets',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_assets_title', array(
        'label' => __('Brand Assets Section Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 67,
    ));
    
    // Brand Assets Subtitle
    $wp_customize->add_setting('press_kit_assets_subtitle', array(
        'default' => 'Download our logos, screenshots, and brand materials',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_assets_subtitle', array(
        'label' => __('Brand Assets Section Subtitle', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 68,
    ));
    
    // Logo Package Title
    $wp_customize->add_setting('press_kit_logo_package_title', array(
        'default' => 'Logo Package',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_logo_package_title', array(
        'label' => __('Logo Package Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 69,
    ));
    
    // Product Screenshots Title
    $wp_customize->add_setting('press_kit_screenshots_title', array(
        'default' => 'Product Screenshots',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_screenshots_title', array(
        'label' => __('Product Screenshots Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 70,
    ));
    
    // Brand Guidelines Title
    $wp_customize->add_setting('press_kit_guidelines_title', array(
        'default' => 'Brand Guidelines',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_guidelines_title', array(
        'label' => __('Brand Guidelines Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 71,
    ));
    
    // ========================================
    // RECENT NEWS SECTION
    // ========================================
    
    // Recent News Enable
    $wp_customize->add_setting('press_kit_news_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_news_enable', array(
        'label' => __('Enable Recent News Section', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'checkbox',
        'priority' => 72,
    ));
    
    // Recent News Title
    $wp_customize->add_setting('press_kit_news_title', array(
        'default' => 'Recent News & Coverage',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_news_title', array(
        'label' => __('Recent News Section Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 73,
    ));
    
    // Recent News Subtitle
    $wp_customize->add_setting('press_kit_news_subtitle', array(
        'default' => 'Latest press mentions and company announcements',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_news_subtitle', array(
        'label' => __('Recent News Section Subtitle', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 74,
    ));
    
    // News Items
    $default_news = array(
        array(
            'source' => 'TechCrunch',
            'title' => 'E-commerce Integration Platform Raises $25M Series A',
            'excerpt' => 'Platform aims to simplify e-commerce integrations for businesses of all sizes with new funding round...',
            'date' => 'March 15, 2024'
        ),
        array(
            'source' => 'VentureBeat',
            'title' => 'The Future of E-commerce: Seamless Integrations',
            'excerpt' => 'How modern businesses are leveraging integration platforms to streamline operations and improve customer experience...',
            'date' => 'February 28, 2024'
        ),
        array(
            'source' => 'Forbes',
            'title' => 'Top 10 SaaS Startups to Watch in 2024',
            'excerpt' => 'Forbes highlights the most promising SaaS companies poised for growth in the coming year...',
            'date' => 'January 10, 2024'
        )
    );
    
    for ($i = 1; $i <= 3; $i++) {
        $news = $default_news[$i - 1];
        
        $wp_customize->add_setting("press_kit_news_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_news_{$i}_enable", array(
            'label' => __("Enable News Item {$i}", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'checkbox',
            'priority' => 75 + ($i - 1) * 5,
        ));
        
        $wp_customize->add_setting("press_kit_news_{$i}_source", array(
            'default' => $news['source'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_news_{$i}_source", array(
            'label' => __("News {$i} Source", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'text',
            'priority' => 76 + ($i - 1) * 5,
        ));
        
        $wp_customize->add_setting("press_kit_news_{$i}_title", array(
            'default' => $news['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_news_{$i}_title", array(
            'label' => __("News {$i} Title", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'text',
            'priority' => 77 + ($i - 1) * 5,
        ));
        
        $wp_customize->add_setting("press_kit_news_{$i}_excerpt", array(
            'default' => $news['excerpt'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_news_{$i}_excerpt", array(
            'label' => __("News {$i} Excerpt", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'textarea',
            'priority' => 78 + ($i - 1) * 5,
        ));
        
        $wp_customize->add_setting("press_kit_news_{$i}_date", array(
            'default' => $news['date'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("press_kit_news_{$i}_date", array(
            'label' => __("News {$i} Date", 'yoursite'),
            'section' => 'press_kit_page_editor',
            'type' => 'text',
            'priority' => 79 + ($i - 1) * 5,
        ));
    }
    
    // ========================================
    // MEDIA CONTACT SECTION
    // ========================================
    
    // Media Contact Enable
    $wp_customize->add_setting('press_kit_contact_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_contact_enable', array(
        'label' => __('Enable Media Contact Section', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'checkbox',
        'priority' => 91,
    ));
    
    // Media Contact Title
    $wp_customize->add_setting('press_kit_contact_title', array(
        'default' => 'Media Contact',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_contact_title', array(
        'label' => __('Media Contact Section Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 92,
    ));
    
    // Media Contact Subtitle
    $wp_customize->add_setting('press_kit_contact_subtitle', array(
        'default' => 'For press inquiries, interviews, or additional information',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_contact_subtitle', array(
        'label' => __('Media Contact Section Subtitle', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 93,
    ));
    
    // Press Contact Information
    $wp_customize->add_setting('press_kit_press_contact_name', array(
        'default' => 'Sarah Wilson',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_press_contact_name', array(
        'label' => __('Press Contact Name', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 94,
    ));
    
    $wp_customize->add_setting('press_kit_press_contact_title', array(
        'default' => 'Director of Communications',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_press_contact_title', array(
        'label' => __('Press Contact Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 95,
    ));
    
    $wp_customize->add_setting('press_kit_press_contact_email', array(
        'default' => 'press@company.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_press_contact_email', array(
        'label' => __('Press Contact Email', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'email',
        'priority' => 96,
    ));
    
    $wp_customize->add_setting('press_kit_press_contact_phone', array(
        'default' => '+1 (555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_press_contact_phone', array(
        'label' => __('Press Contact Phone', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'tel',
        'priority' => 97,
    ));
    
    // Business Contact Information
    $wp_customize->add_setting('press_kit_business_contact_name', array(
        'default' => 'Alex Chen',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_business_contact_name', array(
        'label' => __('Business Contact Name', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 98,
    ));
    
    $wp_customize->add_setting('press_kit_business_contact_title', array(
        'default' => 'VP of Business Development',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_business_contact_title', array(
        'label' => __('Business Contact Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 99,
    ));
    
    $wp_customize->add_setting('press_kit_business_contact_email', array(
        'default' => 'partnerships@company.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_business_contact_email', array(
        'label' => __('Business Contact Email', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'email',
        'priority' => 100,
    ));
    
    $wp_customize->add_setting('press_kit_business_contact_phone', array(
        'default' => '+1 (555) 123-4568',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_business_contact_phone', array(
        'label' => __('Business Contact Phone', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'tel',
        'priority' => 101,
    ));
    
    // Contact CTA Button Text
    $wp_customize->add_setting('press_kit_contact_button_text', array(
        'default' => 'Contact Us',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_contact_button_text', array(
        'label' => __('Contact Button Text', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 102,
    ));
    
    // ========================================
    // USAGE TERMS SECTION
    // ========================================
    
    // Usage Terms Enable
    $wp_customize->add_setting('press_kit_terms_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_terms_enable', array(
        'label' => __('Enable Usage Terms Section', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'checkbox',
        'priority' => 103,
    ));
    
    // Usage Terms Title
    $wp_customize->add_setting('press_kit_terms_title', array(
        'default' => 'Asset Usage Terms',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_terms_title', array(
        'label' => __('Usage Terms Title', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'text',
        'priority' => 104,
    ));
    
    // Usage Terms Text
    $wp_customize->add_setting('press_kit_terms_text', array(
        'default' => 'The assets provided in this press kit are for editorial and promotional use only. By downloading these materials, you agree to use them in accordance with our brand guidelines and not to modify, alter, or create derivative works. For commercial usage rights or custom assets, please contact our media team.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('press_kit_terms_text', array(
        'label' => __('Usage Terms Text', 'yoursite'),
        'section' => 'press_kit_page_editor',
        'type' => 'textarea',
        'priority' => 105,
    ));
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_press_kit_page_customizer');
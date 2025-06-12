<?php
/**
 * About Page Customizer Settings
 * Create this file as: inc/customizer/customizer-about.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add About Page customizer options
 */
function yoursite_about_page_customizer($wp_customize) {
    
    // About Page Section (goes under the main Edit Pages panel)
    $wp_customize->add_section('about_page_editor', array(
        'title' => __('About Page', 'yoursite'),
        'description' => __('Customize all elements of the About page', 'yoursite'),
        'panel' => 'yoursite_pages',
        'priority' => 80,
    ));
    
    // ========================================
    // HERO SECTION
    // ========================================
    
    // Hero Enable/Disable
    $wp_customize->add_setting('about_hero_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Hero Title
    $wp_customize->add_setting('about_hero_title', array(
        'default' => __('We\'re making eCommerce accessible for everyone', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 11,
        'active_callback' => function() {
            return get_theme_mod('about_hero_enable', true);
        },
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('about_hero_subtitle', array(
        'default' => __('Founded in 2020, YourSite.biz started with a simple mission: to democratize online commerce by providing powerful, easy-to-use tools that help anyone build a successful online store.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'textarea',
        'priority' => 12,
        'active_callback' => function() {
            return get_theme_mod('about_hero_enable', true);
        },
    ));
    
    // ========================================
    // STORY SECTION
    // ========================================
    
    // Story Separator
    $wp_customize->add_setting('about_separator_1', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_separator_1', array(
        'label' => __('── Our Story Section ──', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 20,
        'description' => __('Configure the company story section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Story Section Enable
    $wp_customize->add_setting('about_story_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_story_enable', array(
        'label' => __('Enable Story Section', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'checkbox',
        'priority' => 21,
    ));
    
    // Story Title
    $wp_customize->add_setting('about_story_title', array(
        'default' => __('Our Story', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_story_title', array(
        'label' => __('Story Title', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 22,
        'active_callback' => function() {
            return get_theme_mod('about_story_enable', true);
        },
    ));
    
    // Story Paragraph 1
    $wp_customize->add_setting('about_story_paragraph_1', array(
        'default' => __('When we saw small businesses struggling with complicated and expensive eCommerce platforms, we knew there had to be a better way. We believed that powerful online store capabilities shouldn\'t be reserved for large enterprises with big budgets.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_story_paragraph_1', array(
        'label' => __('Story Paragraph 1', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'textarea',
        'priority' => 23,
        'active_callback' => function() {
            return get_theme_mod('about_story_enable', true);
        },
    ));
    
    // Story Paragraph 2
    $wp_customize->add_setting('about_story_paragraph_2', array(
        'default' => __('Today, we\'re proud to serve over 50,000 merchants worldwide, from solo entrepreneurs to growing businesses. Our platform has processed over $2 billion in sales, helping our customers achieve their dreams of online success.', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_story_paragraph_2', array(
        'label' => __('Story Paragraph 2', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'textarea',
        'priority' => 24,
        'active_callback' => function() {
            return get_theme_mod('about_story_enable', true);
        },
    ));
    
    // Story Stats
    $stats_defaults = array(
        1 => array('number' => '50K+', 'label' => 'Active Merchants'),
        2 => array('number' => '$2B+', 'label' => 'Sales Processed'),
        3 => array('number' => '99.9%', 'label' => 'Uptime')
    );
    
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("about_story_stat_{$i}_number", array(
            'default' => $stats_defaults[$i]['number'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_story_stat_{$i}_number", array(
            'label' => sprintf(__('Stat %d Number', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'text',
            'priority' => 24 + ($i * 2),
            'active_callback' => function() {
                return get_theme_mod('about_story_enable', true);
            },
        ));
        
        $wp_customize->add_setting("about_story_stat_{$i}_label", array(
            'default' => $stats_defaults[$i]['label'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_story_stat_{$i}_label", array(
            'label' => sprintf(__('Stat %d Label', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'text',
            'priority' => 25 + ($i * 2),
            'active_callback' => function() {
                return get_theme_mod('about_story_enable', true);
            },
        ));
    }
    
    // ========================================
    // VALUES SECTION
    // ========================================
    
    // Values Separator
    $wp_customize->add_setting('about_separator_2', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_separator_2', array(
        'label' => __('── Our Values Section ──', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 40,
        'description' => __('Configure the company values section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Values Section Enable
    $wp_customize->add_setting('about_values_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_values_enable', array(
        'label' => __('Enable Values Section', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'checkbox',
        'priority' => 41,
    ));
    
    // Values Title
    $wp_customize->add_setting('about_values_title', array(
        'default' => __('Our Values', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_values_title', array(
        'label' => __('Values Title', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 42,
        'active_callback' => function() {
            return get_theme_mod('about_values_enable', true);
        },
    ));
    
    // Values Subtitle
    $wp_customize->add_setting('about_values_subtitle', array(
        'default' => __('The principles that guide everything we do', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_values_subtitle', array(
        'label' => __('Values Subtitle', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 43,
        'active_callback' => function() {
            return get_theme_mod('about_values_enable', true);
        },
    ));
    
    // Values (6 values)
    $values_defaults = array(
        1 => array('title' => __('Customer First', 'yoursite'), 'desc' => __('Every decision we make is guided by what\'s best for our customers and their success.', 'yoursite'), 'color' => '#3b82f6'),
        2 => array('title' => __('Simplicity', 'yoursite'), 'desc' => __('We believe powerful tools should be simple to use. Complexity is the enemy of execution.', 'yoursite'), 'color' => '#10b981'),
        3 => array('title' => __('Innovation', 'yoursite'), 'desc' => __('We\'re constantly pushing boundaries to deliver cutting-edge solutions for modern commerce.', 'yoursite'), 'color' => '#8b5cf6'),
        4 => array('title' => __('Transparency', 'yoursite'), 'desc' => __('We believe in open communication, honest pricing, and building trust through transparency.', 'yoursite'), 'color' => '#f97316'),
        5 => array('title' => __('Empathy', 'yoursite'), 'desc' => __('We understand the challenges of running a business because we\'ve been there ourselves.', 'yoursite'), 'color' => '#ef4444'),
        6 => array('title' => __('Excellence', 'yoursite'), 'desc' => __('We\'re committed to delivering the highest quality products and exceptional customer service.', 'yoursite'), 'color' => '#eab308')
    );
    
    for ($i = 1; $i <= 6; $i++) {
        $wp_customize->add_setting("about_value_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_value_{$i}_enable", array(
            'label' => sprintf(__('Enable Value %d', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'checkbox',
            'priority' => 43 + ($i * 4),
            'active_callback' => function() {
                return get_theme_mod('about_values_enable', true);
            },
        ));
        
        $wp_customize->add_setting("about_value_{$i}_title", array(
            'default' => $values_defaults[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_value_{$i}_title", array(
            'label' => sprintf(__('Value %d Title', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'text',
            'priority' => 44 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('about_values_enable', true) && get_theme_mod("about_value_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("about_value_{$i}_description", array(
            'default' => $values_defaults[$i]['desc'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_value_{$i}_description", array(
            'label' => sprintf(__('Value %d Description', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'textarea',
            'priority' => 45 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('about_values_enable', true) && get_theme_mod("about_value_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("about_value_{$i}_color", array(
            'default' => $values_defaults[$i]['color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "about_value_{$i}_color", array(
            'label' => sprintf(__('Value %d Icon Color', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'priority' => 46 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('about_values_enable', true) && get_theme_mod("about_value_{$i}_enable", true);
            },
        )));
    }
    
    // ========================================
    // TEAM SECTION
    // ========================================
    
    // Team Separator
    $wp_customize->add_setting('about_separator_3', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_separator_3', array(
        'label' => __('── Team Section ──', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 70,
        'description' => __('Configure the team section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Team Section Enable
    $wp_customize->add_setting('about_team_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_team_enable', array(
        'label' => __('Enable Team Section', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'checkbox',
        'priority' => 71,
    ));
    
    // Team Title
    $wp_customize->add_setting('about_team_title', array(
        'default' => __('Meet Our Team', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_team_title', array(
        'label' => __('Team Title', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 72,
        'active_callback' => function() {
            return get_theme_mod('about_team_enable', true);
        },
    ));
    
    // Team Subtitle
    $wp_customize->add_setting('about_team_subtitle', array(
        'default' => __('The people behind YourSite.biz', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_team_subtitle', array(
        'label' => __('Team Subtitle', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 73,
        'active_callback' => function() {
            return get_theme_mod('about_team_enable', true);
        },
    ));
    
    // Team Members (4 members)
    $team_defaults = array(
        1 => array('name' => 'John Smith', 'position' => 'CEO & Co-Founder', 'bio' => 'Former Amazon executive with 15+ years in eCommerce and technology leadership.', 'initials' => 'JS', 'color' => '#3b82f6'),
        2 => array('name' => 'Sarah Johnson', 'position' => 'CTO & Co-Founder', 'bio' => 'Tech visionary and former Google engineer specializing in scalable web applications.', 'initials' => 'SJ', 'color' => '#8b5cf6'),
        3 => array('name' => 'Mike Chen', 'position' => 'VP of Product', 'bio' => 'Product strategist with a passion for user experience and data-driven design decisions.', 'initials' => 'MC', 'color' => '#10b981'),
        4 => array('name' => 'Lisa Wang', 'position' => 'Head of Customer Success', 'bio' => 'Customer advocate ensuring every merchant gets the support they need to succeed.', 'initials' => 'LW', 'color' => '#f97316')
    );
    
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("about_team_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_team_{$i}_enable", array(
            'label' => sprintf(__('Enable Team Member %d', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'checkbox',
            'priority' => 73 + ($i * 6),
            'active_callback' => function() {
                return get_theme_mod('about_team_enable', true);
            },
        ));
        
        $wp_customize->add_setting("about_team_{$i}_name", array(
            'default' => $team_defaults[$i]['name'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_team_{$i}_name", array(
            'label' => sprintf(__('Team Member %d Name', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'text',
            'priority' => 74 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('about_team_enable', true) && get_theme_mod("about_team_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("about_team_{$i}_position", array(
            'default' => $team_defaults[$i]['position'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_team_{$i}_position", array(
            'label' => sprintf(__('Team Member %d Position', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'text',
            'priority' => 75 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('about_team_enable', true) && get_theme_mod("about_team_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("about_team_{$i}_bio", array(
            'default' => $team_defaults[$i]['bio'],
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_team_{$i}_bio", array(
            'label' => sprintf(__('Team Member %d Bio', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'textarea',
            'priority' => 76 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('about_team_enable', true) && get_theme_mod("about_team_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("about_team_{$i}_initials", array(
            'default' => $team_defaults[$i]['initials'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_team_{$i}_initials", array(
            'label' => sprintf(__('Team Member %d Initials', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'text',
            'priority' => 77 + ($i * 6),
            'description' => __('2-3 characters for avatar display', 'yoursite'),
            'active_callback' => function() use ($i) {
                return get_theme_mod('about_team_enable', true) && get_theme_mod("about_team_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("about_team_{$i}_color", array(
            'default' => $team_defaults[$i]['color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "about_team_{$i}_color", array(
            'label' => sprintf(__('Team Member %d Avatar Color', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'priority' => 78 + ($i * 6),
            'active_callback' => function() use ($i) {
                return get_theme_mod('about_team_enable', true) && get_theme_mod("about_team_{$i}_enable", true);
            },
        )));
    }
    
    // ========================================
    // AWARDS SECTION
    // ========================================
    
    // Awards Separator
    $wp_customize->add_setting('about_separator_4', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_separator_4', array(
        'label' => __('── Awards Section ──', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 100,
        'description' => __('Configure the awards and recognition section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // Awards Section Enable
    $wp_customize->add_setting('about_awards_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_awards_enable', array(
        'label' => __('Enable Awards Section', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'checkbox',
        'priority' => 101,
    ));
    
    // Awards Title
    $wp_customize->add_setting('about_awards_title', array(
        'default' => __('Awards & Recognition', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_awards_title', array(
        'label' => __('Awards Title', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 102,
        'active_callback' => function() {
            return get_theme_mod('about_awards_enable', true);
        },
    ));
    
    // Awards Subtitle
    $wp_customize->add_setting('about_awards_subtitle', array(
        'default' => __('Honored to be recognized by industry leaders', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_awards_subtitle', array(
        'label' => __('Awards Subtitle', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 103,
        'active_callback' => function() {
            return get_theme_mod('about_awards_enable', true);
        },
    ));
    
    // Awards (4 awards)
    $awards_defaults = array(
        1 => array('title' => 'Best eCommerce Platform', 'source' => 'TechCrunch Awards 2024', 'color' => '#eab308'),
        2 => array('title' => 'Top SaaS Startup', 'source' => 'Forbes 30 Under 30 2023', 'color' => '#3b82f6'),
        3 => array('title' => 'Customer Choice Award', 'source' => 'G2 Winter 2024', 'color' => '#10b981'),
        4 => array('title' => 'Innovation Award', 'source' => 'SaaS Awards 2023', 'color' => '#8b5cf6')
    );
    
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("about_award_{$i}_enable", array(
            'default' => true,
            'sanitize_callback' => 'yoursite_sanitize_checkbox',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_award_{$i}_enable", array(
            'label' => sprintf(__('Enable Award %d', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'checkbox',
            'priority' => 103 + ($i * 4),
            'active_callback' => function() {
                return get_theme_mod('about_awards_enable', true);
            },
        ));
        
        $wp_customize->add_setting("about_award_{$i}_title", array(
            'default' => $awards_defaults[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_award_{$i}_title", array(
            'label' => sprintf(__('Award %d Title', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'text',
            'priority' => 104 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('about_awards_enable', true) && get_theme_mod("about_award_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("about_award_{$i}_source", array(
            'default' => $awards_defaults[$i]['source'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("about_award_{$i}_source", array(
            'label' => sprintf(__('Award %d Source', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'type' => 'text',
            'priority' => 105 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('about_awards_enable', true) && get_theme_mod("about_award_{$i}_enable", true);
            },
        ));
        
        $wp_customize->add_setting("about_award_{$i}_color", array(
            'default' => $awards_defaults[$i]['color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "about_award_{$i}_color", array(
            'label' => sprintf(__('Award %d Icon Color', 'yoursite'), $i),
            'section' => 'about_page_editor',
            'priority' => 106 + ($i * 4),
            'active_callback' => function() use ($i) {
                return get_theme_mod('about_awards_enable', true) && get_theme_mod("about_award_{$i}_enable", true);
            },
        )));
    }
    
    // ========================================
    // CTA SECTION
    // ========================================
    
    // CTA Separator
    $wp_customize->add_setting('about_separator_5', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_separator_5', array(
        'label' => __('── Call-to-Action Section ──', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 120,
        'description' => __('Configure the final CTA section', 'yoursite'),
        'input_attrs' => array('readonly' => 'readonly', 'style' => 'background: #f0f0f0; border: none; text-align: center; font-weight: bold;'),
    ));
    
    // CTA Enable
    $wp_customize->add_setting('about_cta_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_cta_enable', array(
        'label' => __('Enable CTA Section', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'checkbox',
        'priority' => 121,
    ));
    
    // CTA Title
    $wp_customize->add_setting('about_cta_title', array(
        'default' => __('Ready to join our mission?', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_cta_title', array(
        'label' => __('CTA Title', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 122,
        'active_callback' => function() {
            return get_theme_mod('about_cta_enable', true);
        },
    ));
    
    // CTA Description
    $wp_customize->add_setting('about_cta_description', array(
        'default' => __('Whether you\'re looking to build your store or join our team, we\'d love to connect', 'yoursite'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_cta_description', array(
        'label' => __('CTA Description', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'textarea',
        'priority' => 123,
        'active_callback' => function() {
            return get_theme_mod('about_cta_enable', true);
        },
    ));
    
    // CTA Primary Button
    $wp_customize->add_setting('about_cta_primary_text', array(
        'default' => __('Start Your Store', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_cta_primary_text', array(
        'label' => __('Primary Button Text', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 124,
        'active_callback' => function() {
            return get_theme_mod('about_cta_enable', true);
        },
    ));
    
    $wp_customize->add_setting('about_cta_primary_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_cta_primary_url', array(
        'label' => __('Primary Button URL', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'url',
        'priority' => 125,
        'active_callback' => function() {
            return get_theme_mod('about_cta_enable', true);
        },
    ));
    
    // CTA Secondary Button
    $wp_customize->add_setting('about_cta_secondary_text', array(
        'default' => __('View Careers', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_cta_secondary_text', array(
        'label' => __('Secondary Button Text', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'text',
        'priority' => 126,
        'active_callback' => function() {
            return get_theme_mod('about_cta_enable', true);
        },
    ));
    
    $wp_customize->add_setting('about_cta_secondary_url', array(
        'default' => '/careers',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('about_cta_secondary_url', array(
        'label' => __('Secondary Button URL', 'yoursite'),
        'section' => 'about_page_editor',
        'type' => 'url',
        'priority' => 127,
        'active_callback' => function() {
            return get_theme_mod('about_cta_enable', true);
        },
    ));
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_about_page_customizer');
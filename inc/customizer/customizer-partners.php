<?php
/**
 * Partners Page Customizer Settings - FIXED VERSION
 * Add this file as: inc/customizer/customizer-partners.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Partners Page customizer options
 */
function yoursite_partners_page_customizer($wp_customize) {
    
    // Partners Page Section (goes under the main Edit Pages panel)
    $wp_customize->add_section('partners_page_editor', array(
        'title' => __('Partners Page', 'yoursite'),
        'description' => __('Customize all elements of the Partners page', 'yoursite'),
        'panel' => 'yoursite_pages', // Use the main panel
        'priority' => 40,
    ));
    
    // ========================================
    // HERO SECTION
    // ========================================
    
    // Hero Enable/Disable
    $wp_customize->add_setting('partners_hero_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_hero_enable', array(
        'label' => __('Enable Hero Section', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Hero Title
    $wp_customize->add_setting('partners_hero_title', array(
        'default' => 'Become a Partner',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 11,
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('partners_hero_subtitle', array(
        'default' => 'Join our global network of resellers, agencies, and consultants. Help businesses grow while building your own success with our comprehensive partner program.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 12,
    ));
    
    // Hero Stats
    $wp_customize->add_setting('partners_hero_stat1_number', array(
        'default' => '500+',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_hero_stat1_number', array(
        'label' => __('Stat 1 Number', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 13,
    ));
    
    $wp_customize->add_setting('partners_hero_stat1_label', array(
        'default' => 'Active Partners',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_hero_stat1_label', array(
        'label' => __('Stat 1 Label', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 14,
    ));
    
    $wp_customize->add_setting('partners_hero_stat2_number', array(
        'default' => '40%',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_hero_stat2_number', array(
        'label' => __('Stat 2 Number', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 15,
    ));
    
    $wp_customize->add_setting('partners_hero_stat2_label', array(
        'default' => 'Commission Rate',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_hero_stat2_label', array(
        'label' => __('Stat 2 Label', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 16,
    ));
    
    $wp_customize->add_setting('partners_hero_stat3_number', array(
        'default' => '24/7',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_hero_stat3_number', array(
        'label' => __('Stat 3 Number', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 17,
    ));
    
    $wp_customize->add_setting('partners_hero_stat3_label', array(
        'default' => 'Partner Support',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_hero_stat3_label', array(
        'label' => __('Stat 3 Label', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 18,
    ));
    
    // ========================================
    // PARTNERSHIP TYPES SECTION
    // ========================================
    
    // Partnership Types Enable
    $wp_customize->add_setting('partners_types_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_types_enable', array(
        'label' => __('Enable Partnership Types Section', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 21,
    ));
    
    // Partnership Types Title
    $wp_customize->add_setting('partners_types_title', array(
        'default' => 'Partnership Opportunities',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_types_title', array(
        'label' => __('Section Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 22,
    ));
    
    // Partnership Types Subtitle
    $wp_customize->add_setting('partners_types_subtitle', array(
        'default' => 'Choose the partnership model that fits your business',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_types_subtitle', array(
        'label' => __('Section Subtitle', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 23,
    ));
    
    // Partnership Type 1 - Reseller
    $wp_customize->add_setting('partners_type_1_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_1_enable', array(
        'label' => __('Enable Reseller Partner Type', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 24,
    ));
    
    $wp_customize->add_setting('partners_type_1_title', array(
        'default' => 'Reseller',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_1_title', array(
        'label' => __('Reseller Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 25,
    ));
    
    $wp_customize->add_setting('partners_type_1_description', array(
        'default' => 'Sell our solutions directly to your clients with full white-label support and competitive margins.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_1_description', array(
        'label' => __('Reseller Description', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 26,
    ));
    
    $wp_customize->add_setting('partners_type_1_features', array(
        'default' => "Up to 40% commission\nWhite-label options\nMarketing materials\nTraining & certification",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_1_features', array(
        'label' => __('Reseller Features (one per line)', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 27,
    ));
    
    // Partnership Type 2 - Affiliate
    $wp_customize->add_setting('partners_type_2_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_2_enable', array(
        'label' => __('Enable Affiliate Partner Type', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 28,
    ));
    
    $wp_customize->add_setting('partners_type_2_title', array(
        'default' => 'Affiliate',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_2_title', array(
        'label' => __('Affiliate Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 29,
    ));
    
    $wp_customize->add_setting('partners_type_2_description', array(
        'default' => 'Refer customers and earn commissions on every successful conversion through your unique link.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_2_description', array(
        'label' => __('Affiliate Description', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('partners_type_2_features', array(
        'default' => "25% recurring commission\nReal-time tracking\nMonthly payouts\nPerformance bonuses",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_2_features', array(
        'label' => __('Affiliate Features (one per line)', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 31,
    ));
    
    // Partnership Type 3 - Agency
    $wp_customize->add_setting('partners_type_3_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_3_enable', array(
        'label' => __('Enable Agency Partner Type', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 32,
    ));
    
    $wp_customize->add_setting('partners_type_3_title', array(
        'default' => 'Agency',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_3_title', array(
        'label' => __('Agency Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 33,
    ));
    
    $wp_customize->add_setting('partners_type_3_description', array(
        'default' => 'Integrate our platform into your agency services with dedicated support and resources.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_3_description', array(
        'label' => __('Agency Description', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 34,
    ));
    
    $wp_customize->add_setting('partners_type_3_features', array(
        'default' => "Custom pricing tiers\nDedicated account manager\nAPI access & tools\nCo-marketing opportunities",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_3_features', array(
        'label' => __('Agency Features (one per line)', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 35,
    ));
    
    // Partnership Type 4 - Technology
    $wp_customize->add_setting('partners_type_4_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_4_enable', array(
        'label' => __('Enable Technology Partner Type', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 36,
    ));
    
    $wp_customize->add_setting('partners_type_4_title', array(
        'default' => 'Technology',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_4_title', array(
        'label' => __('Technology Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 37,
    ));
    
    $wp_customize->add_setting('partners_type_4_description', array(
        'default' => 'Build integrations and complementary solutions that extend our platform\'s capabilities.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_4_description', array(
        'label' => __('Technology Description', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 38,
    ));
    
    $wp_customize->add_setting('partners_type_4_features', array(
        'default' => "Revenue sharing\nTechnical support\nJoint go-to-market\nFeatured listings",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_type_4_features', array(
        'label' => __('Technology Features (one per line)', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 39,
    ));
    
    // ========================================
    // BENEFITS SECTION
    // ========================================
    
    // Benefits Enable
    $wp_customize->add_setting('partners_benefits_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefits_enable', array(
        'label' => __('Enable Benefits Section', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 51,
    ));
    
    // Benefits Title
    $wp_customize->add_setting('partners_benefits_title', array(
        'default' => 'Partner Benefits',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefits_title', array(
        'label' => __('Benefits Section Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 52,
    ));
    
    // Benefits Subtitle
    $wp_customize->add_setting('partners_benefits_subtitle', array(
        'default' => 'Everything you need to succeed with our platform',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefits_subtitle', array(
        'label' => __('Benefits Section Subtitle', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 53,
    ));
    
    // Benefit 1
    $wp_customize->add_setting('partners_benefit_1_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_1_enable', array(
        'label' => __('Enable Benefit 1', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 54,
    ));
    
    $wp_customize->add_setting('partners_benefit_1_title', array(
        'default' => 'Competitive Commissions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_1_title', array(
        'label' => __('Benefit 1 Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 55,
    ));
    
    $wp_customize->add_setting('partners_benefit_1_description', array(
        'default' => 'Earn up to 40% commission on all sales with transparent tracking and monthly payouts.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_1_description', array(
        'label' => __('Benefit 1 Description', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 56,
    ));
    
    // Benefit 2
    $wp_customize->add_setting('partners_benefit_2_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_2_enable', array(
        'label' => __('Enable Benefit 2', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 57,
    ));
    
    $wp_customize->add_setting('partners_benefit_2_title', array(
        'default' => 'Training & Certification',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_2_title', array(
        'label' => __('Benefit 2 Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 58,
    ));
    
    $wp_customize->add_setting('partners_benefit_2_description', array(
        'default' => 'Comprehensive onboarding program with ongoing training and official certification.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_2_description', array(
        'label' => __('Benefit 2 Description', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 59,
    ));
    
    // Benefit 3
    $wp_customize->add_setting('partners_benefit_3_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_3_enable', array(
        'label' => __('Enable Benefit 3', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 60,
    ));
    
    $wp_customize->add_setting('partners_benefit_3_title', array(
        'default' => 'Marketing Support',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_3_title', array(
        'label' => __('Benefit 3 Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 61,
    ));
    
    $wp_customize->add_setting('partners_benefit_3_description', array(
        'default' => 'Access to marketing materials, co-branded content, and campaign support.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_3_description', array(
        'label' => __('Benefit 3 Description', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 62,
    ));
    
    // Benefit 4
    $wp_customize->add_setting('partners_benefit_4_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_4_enable', array(
        'label' => __('Enable Benefit 4', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 63,
    ));
    
    $wp_customize->add_setting('partners_benefit_4_title', array(
        'default' => 'Technical Resources',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_4_title', array(
        'label' => __('Benefit 4 Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 64,
    ));
    
    $wp_customize->add_setting('partners_benefit_4_description', array(
        'default' => 'Developer tools, API documentation, and technical support for implementations.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_4_description', array(
        'label' => __('Benefit 4 Description', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 65,
    ));
    
    // Benefit 5
    $wp_customize->add_setting('partners_benefit_5_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_5_enable', array(
        'label' => __('Enable Benefit 5', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 66,
    ));
    
    $wp_customize->add_setting('partners_benefit_5_title', array(
        'default' => 'Dedicated Support',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_5_title', array(
        'label' => __('Benefit 5 Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 67,
    ));
    
    $wp_customize->add_setting('partners_benefit_5_description', array(
        'default' => 'Personal account manager and priority support for you and your clients.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_5_description', array(
        'label' => __('Benefit 5 Description', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 68,
    ));
    
    // Benefit 6
    $wp_customize->add_setting('partners_benefit_6_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_6_enable', array(
        'label' => __('Enable Benefit 6', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 69,
    ));
    
    $wp_customize->add_setting('partners_benefit_6_title', array(
        'default' => 'Performance Tracking',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_6_title', array(
        'label' => __('Benefit 6 Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 70,
    ));
    
    $wp_customize->add_setting('partners_benefit_6_description', array(
        'default' => 'Real-time dashboard to track sales, commissions, and customer metrics.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_benefit_6_description', array(
        'label' => __('Benefit 6 Description', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 71,
    ));
    
    // ========================================
    // SUCCESS STORIES SECTION
    // ========================================
    
    // Success Stories Enable
    $wp_customize->add_setting('partners_stories_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_stories_enable', array(
        'label' => __('Enable Success Stories Section', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 76,
    ));
    
    // Success Stories Title
    $wp_customize->add_setting('partners_stories_title', array(
        'default' => 'Partner Success Stories',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_stories_title', array(
        'label' => __('Success Stories Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 77,
    ));
    
    // Success Stories Subtitle
    $wp_customize->add_setting('partners_stories_subtitle', array(
        'default' => 'See how our partners are growing their businesses',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_stories_subtitle', array(
        'label' => __('Success Stories Subtitle', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 78,
    ));
    
    // Success Story 1
    $wp_customize->add_setting('partners_story_1_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_1_enable', array(
        'label' => __('Enable Success Story 1', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 79,
    ));
    
    $wp_customize->add_setting('partners_story_1_company', array(
        'default' => 'TechWave Solutions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_1_company', array(
        'label' => __('Story 1 Company Name', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 80,
    ));
    
    $wp_customize->add_setting('partners_story_1_type', array(
        'default' => 'Reseller Partner',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_1_type', array(
        'label' => __('Story 1 Partner Type', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 81,
    ));
    
    $wp_customize->add_setting('partners_story_1_quote', array(
        'default' => 'Partnering with this platform increased our revenue by 300% in the first year. The support team is incredible and the commission structure is very competitive.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_1_quote', array(
        'label' => __('Story 1 Quote', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 82,
    ));
    
    $wp_customize->add_setting('partners_story_1_metric', array(
        'default' => '$2.5M+',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_1_metric', array(
        'label' => __('Story 1 Metric Number', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 83,
    ));
    
    $wp_customize->add_setting('partners_story_1_metric_label', array(
        'default' => 'Annual Revenue Generated',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_1_metric_label', array(
        'label' => __('Story 1 Metric Label', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 84,
    ));
    
    // Success Story 2
    $wp_customize->add_setting('partners_story_2_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_2_enable', array(
        'label' => __('Enable Success Story 2', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 85,
    ));
    
    $wp_customize->add_setting('partners_story_2_company', array(
        'default' => 'Digital Apex',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_2_company', array(
        'label' => __('Story 2 Company Name', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 86,
    ));
    
    $wp_customize->add_setting('partners_story_2_type', array(
        'default' => 'Agency Partner',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_2_type', array(
        'label' => __('Story 2 Partner Type', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 87,
    ));
    
    $wp_customize->add_setting('partners_story_2_quote', array(
        'default' => 'The white-label solutions allow us to offer enterprise-grade integrations under our own brand. Our clients love the seamless experience.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_2_quote', array(
        'label' => __('Story 2 Quote', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 88,
    ));
    
    $wp_customize->add_setting('partners_story_2_metric', array(
        'default' => '150+',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_2_metric', array(
        'label' => __('Story 2 Metric Number', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 89,
    ));
    
    $wp_customize->add_setting('partners_story_2_metric_label', array(
        'default' => 'Successful Implementations',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_2_metric_label', array(
        'label' => __('Story 2 Metric Label', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 90,
    ));
    
    // Success Story 3
    $wp_customize->add_setting('partners_story_3_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_3_enable', array(
        'label' => __('Enable Success Story 3', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 91,
    ));
    
    $wp_customize->add_setting('partners_story_3_company', array(
        'default' => 'E-Commerce Experts',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_3_company', array(
        'label' => __('Story 3 Company Name', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 92,
    ));
    
    $wp_customize->add_setting('partners_story_3_type', array(
        'default' => 'Affiliate Partner',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_3_type', array(
        'label' => __('Story 3 Partner Type', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 93,
    ));
    
    $wp_customize->add_setting('partners_story_3_quote', array(
        'default' => 'Started as an affiliate and now earning consistent monthly commissions. The tracking is transparent and payouts are always on time.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_3_quote', array(
        'label' => __('Story 3 Quote', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 94,
    ));
    
    $wp_customize->add_setting('partners_story_3_metric', array(
        'default' => '$50K+',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_3_metric', array(
        'label' => __('Story 3 Metric Number', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 95,
    ));
    
    $wp_customize->add_setting('partners_story_3_metric_label', array(
        'default' => 'Monthly Commission',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_story_3_metric_label', array(
        'label' => __('Story 3 Metric Label', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 96,
    ));
    
    // ========================================
    // APPLICATION FORM SECTION
    // ========================================
    
    // Application Form Enable
    $wp_customize->add_setting('partners_form_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_form_enable', array(
        'label' => __('Enable Application Form Section', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 101,
    ));
    
    // Form Title
    $wp_customize->add_setting('partners_form_title', array(
        'default' => 'Apply to Become a Partner',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_form_title', array(
        'label' => __('Application Form Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 102,
    ));
    
    // Form Subtitle
    $wp_customize->add_setting('partners_form_subtitle', array(
        'default' => 'Fill out the form below and we\'ll get back to you within 3-5 business days',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_form_subtitle', array(
        'label' => __('Application Form Subtitle', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 103,
    ));
    
    // ========================================
    // FAQ SECTION
    // ========================================
    
    // FAQ Enable
    $wp_customize->add_setting('partners_faq_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_enable', array(
        'label' => __('Enable FAQ Section', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 111,
    ));
    
    // FAQ Title
    $wp_customize->add_setting('partners_faq_title', array(
        'default' => 'Frequently Asked Questions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_title', array(
        'label' => __('FAQ Section Title', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 112,
    ));
    
    // FAQ Subtitle
    $wp_customize->add_setting('partners_faq_subtitle', array(
        'default' => 'Get answers to common partner program questions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_subtitle', array(
        'label' => __('FAQ Section Subtitle', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 113,
    ));
    
    // FAQ 1
    $wp_customize->add_setting('partners_faq_1_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_1_enable', array(
        'label' => __('Enable FAQ 1', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 114,
    ));
    
    $wp_customize->add_setting('partners_faq_1_question', array(
        'default' => 'How long does the application process take?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_1_question', array(
        'label' => __('FAQ 1 Question', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 115,
    ));
    
    $wp_customize->add_setting('partners_faq_1_answer', array(
        'default' => 'We typically review applications within 3-5 business days. If approved, you\'ll receive onboarding materials and access to our partner portal immediately.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_1_answer', array(
        'label' => __('FAQ 1 Answer', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 116,
    ));
    
    // FAQ 2
    $wp_customize->add_setting('partners_faq_2_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_2_enable', array(
        'label' => __('Enable FAQ 2', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 117,
    ));
    
    $wp_customize->add_setting('partners_faq_2_question', array(
        'default' => 'What are the commission rates?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_2_question', array(
        'label' => __('FAQ 2 Question', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 118,
    ));
    
    $wp_customize->add_setting('partners_faq_2_answer', array(
        'default' => 'Commission rates vary by partner type: Affiliates earn 25% recurring, Resellers up to 40%, and custom rates are available for Agencies and Technology partners.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_2_answer', array(
        'label' => __('FAQ 2 Answer', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 119,
    ));
    
    // FAQ 3
    $wp_customize->add_setting('partners_faq_3_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_3_enable', array(
        'label' => __('Enable FAQ 3', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 120,
    ));
    
    $wp_customize->add_setting('partners_faq_3_question', array(
        'default' => 'Is there a minimum sales requirement?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_3_question', array(
        'label' => __('FAQ 3 Question', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 121,
    ));
    
    $wp_customize->add_setting('partners_faq_3_answer', array(
        'default' => 'There\'s no minimum sales requirement to maintain your partner status. However, active partners who consistently drive sales receive additional benefits and higher commission tiers.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_3_answer', array(
        'label' => __('FAQ 3 Answer', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 122,
    ));
    
    // FAQ 4
    $wp_customize->add_setting('partners_faq_4_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_4_enable', array(
        'label' => __('Enable FAQ 4', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 123,
    ));
    
    $wp_customize->add_setting('partners_faq_4_question', array(
        'default' => 'What marketing materials do you provide?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_4_question', array(
        'label' => __('FAQ 4 Question', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 124,
    ));
    
    $wp_customize->add_setting('partners_faq_4_answer', array(
        'default' => 'We provide logos, brochures, case studies, demo videos, email templates, and co-branded materials. Custom materials can be created for qualified partners.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_4_answer', array(
        'label' => __('FAQ 4 Answer', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 125,
    ));
    
    // FAQ 5
    $wp_customize->add_setting('partners_faq_5_enable', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_5_enable', array(
        'label' => __('Enable FAQ 5', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'checkbox',
        'priority' => 126,
    ));
    
    $wp_customize->add_setting('partners_faq_5_question', array(
        'default' => 'Can I offer white-label solutions?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_5_question', array(
        'label' => __('FAQ 5 Question', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'text',
        'priority' => 127,
    ));
    
    $wp_customize->add_setting('partners_faq_5_answer', array(
        'default' => 'Yes! Reseller and Agency partners can access white-label options to offer our solutions under their own brand with full customization support.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('partners_faq_5_answer', array(
        'label' => __('FAQ 5 Answer', 'yoursite'),
        'section' => 'partners_page_editor',
        'type' => 'textarea',
        'priority' => 128,
    ));
}

// Hook the function to the customizer
add_action('customize_register', 'yoursite_partners_page_customizer');
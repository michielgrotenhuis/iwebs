<?php
/**
 * Header customizer options - UPDATED VERSION
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add comprehensive header customizer options
 */
function yoursite_header_customizer($wp_customize) {
    
    // Header Section
    $wp_customize->add_section('header_section', array(
        'title' => __('Header Settings', 'yoursite'),
        'priority' => 25,
        'panel' => 'yoursite_theme_options',
    ));
    
    // Announcement Bar Subsection
    $wp_customize->add_setting('show_announcement_bar', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_announcement_bar', array(
        'label' => __('Show Announcement Bar', 'yoursite'),
        'section' => 'header_section',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    $wp_customize->add_setting('announcement_text', array(
        'default' => __('Limited Time: Get 50% OFF on all annual plans! Use code SAVE50', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('announcement_text', array(
        'label' => __('Announcement Text', 'yoursite'),
        'section' => 'header_section',
        'type' => 'textarea',
        'priority' => 11,
    ));
    
    $wp_customize->add_setting('announcement_link', array(
        'default' => '/pricing',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('announcement_link', array(
        'label' => __('Announcement Link URL', 'yoursite'),
        'section' => 'header_section',
        'type' => 'url',
        'priority' => 12,
    ));
    
    $wp_customize->add_setting('announcement_cta', array(
        'default' => __('Claim Now', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('announcement_cta', array(
        'label' => __('Announcement CTA Text', 'yoursite'),
        'section' => 'header_section',
        'type' => 'text',
        'priority' => 13,
    ));
    
    // Theme Toggle Settings
    $wp_customize->add_setting('show_theme_toggle', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_theme_toggle', array(
        'label' => __('Show Dark Mode Toggle', 'yoursite'),
        'section' => 'header_section',
        'type' => 'checkbox',
        'priority' => 20,
    ));
    
    // Login Button
    $wp_customize->add_setting('header_login_text', array(
        'default' => __('Login', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('header_login_text', array(
        'label' => __('Login Button Text', 'yoursite'),
        'section' => 'header_section',
        'type' => 'text',
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('header_login_url', array(
        'default' => '/login',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('header_login_url', array(
        'label' => __('Login Button URL', 'yoursite'),
        'section' => 'header_section',
        'type' => 'url',
        'priority' => 31,
    ));
    
    // CTA Button
    $wp_customize->add_setting('header_cta_text', array(
        'default' => __('Start Free Trial', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('header_cta_text', array(
        'label' => __('Header CTA Button Text', 'yoursite'),
        'section' => 'header_section',
        'type' => 'text',
        'priority' => 40,
    ));
    
    $wp_customize->add_setting('header_cta_url', array(
        'default' => '/signup',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('header_cta_url', array(
        'label' => __('Header CTA Button URL', 'yoursite'),
        'section' => 'header_section',
        'type' => 'url',
        'priority' => 41,
    ));
}
add_action('customize_register', 'yoursite_header_customizer');

/**
 * Note: Theme toggle helper functions are already defined in inc/theme-modes.php
 * This file only contains the customizer settings for the header options.
 * 
 * Available functions from theme-modes.php:
 * - yoursite_get_theme_toggle_button()
 * - yoursite_get_mobile_theme_toggle_button()
 */
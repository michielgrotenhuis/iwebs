<?php
/**
 * Header customizer options
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add header customizer options
 */
function yoursite_header_customizer($wp_customize) {
    
    // Header Section
    $wp_customize->add_section('header_section', array(
        'title' => __('Header Settings', 'yoursite'),
        'priority' => 25,
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
    ));
}
add_action('customize_register', 'yoursite_header_customizer');
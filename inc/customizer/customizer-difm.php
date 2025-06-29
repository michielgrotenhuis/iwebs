<?php
/**
 * DIFM (Done-It-For-Me) Page customizer options - CLEAN VERSION
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add DIFM page customizer options
 */
function yoursite_difm_customizer($wp_customize) {
    
    // DIFM Page Section
    $wp_customize->add_section('difm_page_section', array(
        'title' => __('DIFM Page Settings', 'yoursite'),
        'priority' => 50,
        'panel' => 'yoursite_pages',
        'description' => __('Customize the Done-It-For-Me service page content', 'yoursite'),
    ));
    
    // Hero Section
    $wp_customize->add_setting('difm_hero_title', array(
        'default' => __('Let Us Build Your Store For You', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_title', array(
        'label' => __('Hero Title', 'yoursite'),
        'section' => 'difm_page_section',
        'type' => 'text',
        'priority' => 10,
    ));
    
    $wp_customize->add_setting('difm_hero_subtitle', array(
        'default' => __('Our experts will create a professional online store tailored to your business needs', 'yoursite'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'yoursite'),
        'section' => 'difm_page_section',
        'type' => 'textarea',
        'priority' => 20,
    ));
    
    // Service Features
    $wp_customize->add_setting('difm_features_title', array(
        'default' => __('What\'s Included in Our Service', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_features_title', array(
        'label' => __('Features Section Title', 'yoursite'),
        'section' => 'difm_page_section',
        'type' => 'text',
        'priority' => 30,
    ));
    
    // Pricing
    $wp_customize->add_setting('difm_price', array(
        'default' => __('$2,999', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_price', array(
        'label' => __('DIFM Service Price', 'yoursite'),
        'section' => 'difm_page_section',
        'type' => 'text',
        'priority' => 40,
    ));
    
    // CTA Button
    $wp_customize->add_setting('difm_cta_text', array(
        'default' => __('Get Started Today', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_cta_text', array(
        'label' => __('CTA Button Text', 'yoursite'),
        'section' => 'difm_page_section',
        'type' => 'text',
        'priority' => 50,
    ));
    
    $wp_customize->add_setting('difm_cta_url', array(
        'default' => '/contact',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('difm_cta_url', array(
        'label' => __('CTA Button URL', 'yoursite'),
        'section' => 'difm_page_section',
        'type' => 'url',
        'priority' => 60,
    ));
}
add_action('customize_register', 'yoursite_difm_customizer');
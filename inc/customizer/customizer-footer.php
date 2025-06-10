<?php
/**
 * Footer customizer options
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add footer customizer options
 */
function yoursite_footer_customizer($wp_customize) {
    
    // Footer Section
    $wp_customize->add_section('footer_section', array(
        'title' => __('Footer Settings', 'yoursite'),
        'priority' => 45,
    ));
    
    $wp_customize->add_setting('footer_text', array(
        'default' => sprintf(__('© %s YourSite.biz. All rights reserved.', 'yoursite'), date('Y')),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_text', array(
        'label' => __('Footer Copyright Text', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'textarea',
    ));
    
    $wp_customize->add_setting('show_footer_newsletter', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_footer_newsletter', array(
        'label' => __('Show Newsletter Signup in Footer', 'yoursite'),
        'section' => 'footer_section',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'yoursite_footer_customizer');
<?php
/**
 * Company information customizer options
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add company information customizer options
 */
function yoursite_company_customizer($wp_customize) {
    
    // Company Information Section
    $wp_customize->add_section('company_info', array(
        'title' => __('Company Information', 'yoursite'),
        'priority' => 35,
    ));
    
    $wp_customize->add_setting('company_address', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_address', array(
        'label' => __('Company Address', 'yoursite'),
        'section' => 'company_info',
        'type' => 'textarea',
    ));
    
    $wp_customize->add_setting('company_phone', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_phone', array(
        'label' => __('Company Phone', 'yoursite'),
        'section' => 'company_info',
        'type' => 'tel',
    ));
    
    $wp_customize->add_setting('company_email', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_email', array(
        'label' => __('Company Email', 'yoursite'),
        'section' => 'company_info',
        'type' => 'email',
    ));
}
add_action('customize_register', 'yoursite_company_customizer');
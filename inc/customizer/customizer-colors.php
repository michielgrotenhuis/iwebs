<?php
/**
 * Colors and typography customizer options
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add colors and typography customizer options
 */
function yoursite_colors_customizer($wp_customize) {
    
    // Colors Section (extend existing colors)
    $wp_customize->add_setting('primary_color', array(
        'default' => '#667eea',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => __('Primary Color', 'yoursite'),
        'section' => 'colors',
        'settings' => 'primary_color',
    )));
    
    $wp_customize->add_setting('secondary_color', array(
        'default' => '#764ba2',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label' => __('Secondary Color', 'yoursite'),
        'section' => 'colors',
        'settings' => 'secondary_color',
    )));
    
    // Typography Section
    $wp_customize->add_section('typography', array(
        'title' => __('Typography', 'yoursite'),
        'priority' => 50,
    ));
    
    $wp_customize->add_setting('body_font_family', array(
        'default' => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('body_font_family', array(
        'label' => __('Body Font Family', 'yoursite'),
        'section' => 'typography',
        'type' => 'select',
        'choices' => array(
            'Inter' => 'Inter',
            'Roboto' => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Lato' => 'Lato',
            'Montserrat' => 'Montserrat',
            'Poppins' => 'Poppins',
        ),
    ));
    
    $wp_customize->add_setting('heading_font_family', array(
        'default' => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('heading_font_family', array(
        'label' => __('Heading Font Family', 'yoursite'),
        'section' => 'typography',
        'type' => 'select',
        'choices' => array(
            'Inter' => 'Inter',
            'Roboto' => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Lato' => 'Lato',
            'Montserrat' => 'Montserrat',
            'Poppins' => 'Poppins',
        ),
    ));
}
add_action('customize_register', 'yoursite_colors_customizer');
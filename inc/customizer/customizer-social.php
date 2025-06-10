<?php
/**
 * Social media links customizer options
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add social media customizer options
 */
function yoursite_social_customizer($wp_customize) {
    
    // Social Media Section
    $wp_customize->add_section('social_media', array(
        'title' => __('Social Media Links', 'yoursite'),
        'priority' => 40,
    ));
    
    $social_platforms = array(
        'facebook' => __('Facebook', 'yoursite'),
        'twitter' => __('Twitter', 'yoursite'),
        'linkedin' => __('LinkedIn', 'yoursite'),
        'instagram' => __('Instagram', 'yoursite'),
        'youtube' => __('YouTube', 'yoursite'),
        'github' => __('GitHub', 'yoursite'),
    );
    
    foreach ($social_platforms as $platform => $label) {
        $wp_customize->add_setting('social_' . $platform, array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control('social_' . $platform, array(
            'label' => sprintf(__('%s URL', 'yoursite'), $label),
            'section' => 'social_media',
            'type' => 'url',
        ));
    }
}
add_action('customize_register', 'yoursite_social_customizer');
<?php
/**
 * Debug file to check customizer settings
 * Add this temporarily to your page-contact.php or create a separate debug page
 * Remove this in production!
 */

// Only show to administrators
if (current_user_can('administrator')) {
    echo '<div style="background: #fff; border: 2px solid #ccc; padding: 20px; margin: 20px; font-family: monospace;">';
    echo '<h2>Customizer Debug Information</h2>';
    
    echo '<h3>Contact Options Section:</h3>';
    echo 'contact_options_enable: ' . (get_theme_mod('contact_options_enable', true) ? 'true' : 'false') . '<br>';
    
    for ($i = 1; $i <= 4; $i++) {
        echo "<h4>Contact Option $i:</h4>";
        echo "contact_option_{$i}_enable: " . (get_theme_mod("contact_option_{$i}_enable", true) ? 'true' : 'false') . '<br>';
        echo "contact_option_{$i}_title: " . esc_html(get_theme_mod("contact_option_{$i}_title", 'Not set')) . '<br>';
        echo "contact_option_{$i}_description: " . esc_html(get_theme_mod("contact_option_{$i}_description", 'Not set')) . '<br>';
        echo "contact_option_{$i}_button_text: " . esc_html(get_theme_mod("contact_option_{$i}_button_text", 'Not set')) . '<br>';
        echo "contact_option_{$i}_button_url: " . esc_html(get_theme_mod("contact_option_{$i}_button_url", 'Not set')) . '<br>';
        echo "contact_option_{$i}_icon_color: " . esc_html(get_theme_mod("contact_option_{$i}_icon_color", 'Not set')) . '<br><br>';
    }
    
    echo '<h3>Other Sections:</h3>';
    echo 'contact_hero_enable: ' . (get_theme_mod('contact_hero_enable', true) ? 'true' : 'false') . '<br>';
    echo 'contact_form_enable: ' . (get_theme_mod('contact_form_enable', true) ? 'true' : 'false') . '<br>';
    echo 'contact_faq_enable: ' . (get_theme_mod('contact_faq_enable', true) ? 'true' : 'false') . '<br>';
    echo 'contact_office_enable: ' . (get_theme_mod('contact_office_enable', true) ? 'true' : 'false') . '<br>';
    
    echo '<h3>All Theme Mods:</h3>';
    $theme_mods = get_theme_mods();
    if ($theme_mods) {
        foreach ($theme_mods as $key => $value) {
            if (strpos($key, 'contact_') === 0) {
                echo "$key: " . (is_bool($value) ? ($value ? 'true' : 'false') : esc_html($value)) . '<br>';
            }
        }
    } else {
        echo 'No theme mods found!';
    }
    
    echo '</div>';
}
?>
<?php
/**
 * Social media customizer options - UPDATED VERSION
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add comprehensive social media customizer options
 */
function yoursite_social_customizer($wp_customize) {
    
    // Social Media Section
    $wp_customize->add_section('social_media_section', array(
        'title' => __('Social Media Links', 'yoursite'),
        'priority' => 50,
        'panel' => 'yoursite_theme_options',
        'description' => __('Add your social media profile URLs. Leave blank to hide.', 'yoursite'),
    ));
    
    // Show Social Links Setting
    $wp_customize->add_setting('show_social_links', array(
        'default' => true,
        'sanitize_callback' => 'yoursite_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_social_links', array(
        'label' => __('Show Social Media Links in Footer', 'yoursite'),
        'section' => 'social_media_section',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    // Define social media platforms with their labels
    $social_platforms = array(
        'twitter' => array(
            'label' => __('Twitter/X URL', 'yoursite'),
            'description' => __('Enter your Twitter/X profile URL', 'yoursite'),
            'default' => ''
        ),
        'linkedin' => array(
            'label' => __('LinkedIn URL', 'yoursite'),
            'description' => __('Enter your LinkedIn company page URL', 'yoursite'),
            'default' => ''
        ),
        'youtube' => array(
            'label' => __('YouTube URL', 'yoursite'),
            'description' => __('Enter your YouTube channel URL', 'yoursite'),
            'default' => ''
        ),
        'instagram' => array(
            'label' => __('Instagram URL', 'yoursite'),
            'description' => __('Enter your Instagram profile URL', 'yoursite'),
            'default' => ''
        ),
        'facebook' => array(
            'label' => __('Facebook URL', 'yoursite'),
            'description' => __('Enter your Facebook page URL', 'yoursite'),
            'default' => ''
        ),
        'github' => array(
            'label' => __('GitHub URL', 'yoursite'),
            'description' => __('Enter your GitHub organization URL', 'yoursite'),
            'default' => ''
        ),
        'discord' => array(
            'label' => __('Discord URL', 'yoursite'),
            'description' => __('Enter your Discord server invite URL', 'yoursite'),
            'default' => ''
        ),
        'tiktok' => array(
            'label' => __('TikTok URL', 'yoursite'),
            'description' => __('Enter your TikTok profile URL', 'yoursite'),
            'default' => ''
        ),
        'twitch' => array(
            'label' => __('Twitch URL', 'yoursite'),
            'description' => __('Enter your Twitch channel URL', 'yoursite'),
            'default' => ''
        ),
        'reddit' => array(
            'label' => __('Reddit URL', 'yoursite'),
            'description' => __('Enter your Reddit community URL', 'yoursite'),
            'default' => ''
        ),
        'medium' => array(
            'label' => __('Medium URL', 'yoursite'),
            'description' => __('Enter your Medium publication URL', 'yoursite'),
            'default' => ''
        ),
        'pinterest' => array(
            'label' => __('Pinterest URL', 'yoursite'),
            'description' => __('Enter your Pinterest profile URL', 'yoursite'),
            'default' => ''
        )
    );
    
    // Create customizer controls for each platform
    $priority = 20;
    foreach ($social_platforms as $platform => $data) {
        $wp_customize->add_setting("social_{$platform}_url", array(
            'default' => $data['default'],
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("social_{$platform}_url", array(
            'label' => $data['label'],
            'description' => $data['description'],
            'section' => 'social_media_section',
            'type' => 'url',
            'priority' => $priority,
        ));
        
        $priority += 5;
    }
    
    // Social Links Target Setting
    $wp_customize->add_setting('social_links_target', array(
        'default' => '_blank',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('social_links_target', array(
        'label' => __('Social Links Target', 'yoursite'),
        'description' => __('Choose how social links should open', 'yoursite'),
        'section' => 'social_media_section',
        'type' => 'select',
        'choices' => array(
            '_blank' => __('New Tab/Window', 'yoursite'),
            '_self' => __('Same Tab/Window', 'yoursite'),
        ),
        'priority' => 100,
    ));
    
    // Social Links Style
    $wp_customize->add_setting('social_links_style', array(
        'default' => 'icons',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('social_links_style', array(
        'label' => __('Social Links Style', 'yoursite'),
        'description' => __('Choose how to display social media links', 'yoursite'),
        'section' => 'social_media_section',
        'type' => 'select',
        'choices' => array(
            'icons' => __('Icons Only', 'yoursite'),
            'text' => __('Text Only', 'yoursite'),
            'both' => __('Icons and Text', 'yoursite'),
        ),
        'priority' => 105,
    ));
}
add_action('customize_register', 'yoursite_social_customizer');

/**
 * Helper function to get social media links
 */
function yoursite_get_social_links() {
    if (!get_theme_mod('show_social_links', true)) {
        return array();
    }
    
    $social_platforms = array(
        'twitter' => array(
            'url' => get_theme_mod('social_twitter_url', ''),
            'label' => __('Twitter', 'yoursite'),
            'icon' => 'M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z'
        ),
        'linkedin' => array(
            'url' => get_theme_mod('social_linkedin_url', ''),
            'label' => __('LinkedIn', 'yoursite'),
            'icon' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z'
        ),
        'youtube' => array(
            'url' => get_theme_mod('social_youtube_url', ''),
            'label' => __('YouTube', 'yoursite'),
            'icon' => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z'
        ),
        'instagram' => array(
            'url' => get_theme_mod('social_instagram_url', ''),
            'label' => __('Instagram', 'yoursite'),
            'icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.405a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z'
        ),
        'facebook' => array(
            'url' => get_theme_mod('social_facebook_url', ''),
            'label' => __('Facebook', 'yoursite'),
            'icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'
        ),
        'github' => array(
            'url' => get_theme_mod('social_github_url', ''),
            'label' => __('GitHub', 'yoursite'),
            'icon' => 'M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z'
        ),
        'discord' => array(
            'url' => get_theme_mod('social_discord_url', ''),
            'label' => __('Discord', 'yoursite'),
            'icon' => 'M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419-.0002 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9554 2.4189-2.1568 2.4189Z'
        ),
        'tiktok' => array(
            'url' => get_theme_mod('social_tiktok_url', ''),
            'label' => __('TikTok', 'yoursite'),
            'icon' => 'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z'
        ),
        'twitch' => array(
            'url' => get_theme_mod('social_twitch_url', ''),
            'label' => __('Twitch', 'yoursite'),
            'icon' => 'M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714Z'
        ),
        'reddit' => array(
            'url' => get_theme_mod('social_reddit_url', ''),
            'label' => __('Reddit', 'yoursite'),
            'icon' => 'M12 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0zm5.01 4.744c.688 0 1.25.561 1.25 1.249a1.25 1.25 0 0 1-2.498.056l-2.597-.547-.8 3.747c1.824.07 3.48.632 4.674 1.488.308-.309.73-.491 1.207-.491.968 0 1.754.786 1.754 1.754 0 .716-.435 1.333-1.01 1.614a3.111 3.111 0 0 1 .042.52c0 2.694-3.13 4.87-7.004 4.87-3.874 0-7.004-2.176-7.004-4.87 0-.183.015-.366.043-.534A1.748 1.748 0 0 1 4.028 12c0-.968.786-1.754 1.754-1.754.463 0 .898.196 1.207.49 1.207-.883 2.878-1.43 4.744-1.487l.885-4.182a.342.342 0 0 1 .14-.197.35.35 0 0 1 .238-.042l2.906.617a1.214 1.214 0 0 1 1.108-.701zM9.25 12C8.561 12 8 12.562 8 13.25c0 .687.561 1.248 1.25 1.248.687 0 1.248-.561 1.248-1.249 0-.688-.561-1.249-1.249-1.249zm5.5 0c-.687 0-1.248.561-1.248 1.25 0 .687.561 1.248 1.249 1.248.688 0 1.249-.561 1.249-1.249 0-.687-.562-1.249-1.25-1.249zm-5.466 3.99a.327.327 0 0 0-.231.094.33.33 0 0 0 0 .463c.842.842 2.484.913 2.961.913.477 0 2.105-.056 2.961-.913a.361.361 0 0 0 .029-.463.33.33 0 0 0-.464 0c-.547.533-1.684.73-2.512.73-.828 0-1.979-.196-2.512-.73a.326.326 0 0 0-.232-.095z'
        ),
        'medium' => array(
            'url' => get_theme_mod('social_medium_url', ''),
            'label' => __('Medium', 'yoursite'),
            'icon' => 'M13.54 12a6.8 6.8 0 01-6.77 6.82A6.8 6.8 0 010 12a6.8 6.8 0 016.77-6.82A6.8 6.8 0 0113.54 12zM20.96 12c0 3.54-1.51 6.42-3.38 6.42-1.87 0-3.39-2.88-3.39-6.42s1.52-6.42 3.39-6.42 3.38 2.88 3.38 6.42M24 12c0 3.17-.53 5.75-1.19 5.75-.66 0-1.19-2.58-1.19-5.75s.53-5.75 1.19-5.75C23.47 6.25 24 8.83 24 12z'
        ),
        'pinterest' => array(
            'url' => get_theme_mod('social_pinterest_url', ''),
            'label' => __('Pinterest', 'yoursite'),
            'icon' => 'M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.098.119.112.224.083.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.749-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z'
        )
    );
    
    // Filter out empty URLs
    return array_filter($social_platforms, function($platform) {
        return !empty($platform['url']);
    });
}

/**
 * Helper function to render social media links
 */
function yoursite_render_social_links($wrapper_class = 'flex space-x-4') {
    $social_links = yoursite_get_social_links();
    $target = get_theme_mod('social_links_target', '_blank');
    $style = get_theme_mod('social_links_style', 'icons');
    
    if (empty($social_links)) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($wrapper_class); ?>">
        <?php foreach ($social_links as $platform => $data) : ?>
            <a href="<?php echo esc_url($data['url']); ?>" 
               target="<?php echo esc_attr($target); ?>"
               rel="noopener noreferrer"
               class="social-link"
               aria-label="<?php echo esc_attr($data['label']); ?>">
                <?php if ($style === 'icons' || $style === 'both') : ?>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="<?php echo esc_attr($data['icon']); ?>"/>
                    </svg>
                <?php endif; ?>
                <?php if ($style === 'text' || $style === 'both') : ?>
                    <?php if ($style === 'both') : ?>
                        <span class="ml-2"><?php echo esc_html($data['label']); ?></span>
                    <?php else : ?>
                        <span><?php echo esc_html($data['label']); ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
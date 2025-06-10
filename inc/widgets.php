<?php
/**
 * Widget areas and functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register widget areas
 */
function yoursite_widgets_init() {
    register_sidebar(array(
        'name' => __('Footer Widget Area', 'yoursite'),
        'id' => 'footer-widgets',
        'description' => __('Widgets for the footer area', 'yoursite'),
        'before_widget' => '<div class="footer-widget mb-8">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-lg font-semibold mb-4 text-white">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Main Sidebar', 'yoursite'),
        'id' => 'main-sidebar',
        'description' => __('Main sidebar widget area', 'yoursite'),
        'before_widget' => '<div class="widget mb-8">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-lg font-semibold mb-4">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Header CTA Area', 'yoursite'),
        'id' => 'header-cta',
        'description' => __('Widget area for header call-to-action', 'yoursite'),
        'before_widget' => '<div class="header-cta-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="sr-only">',
        'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => __('Blog Sidebar', 'yoursite'),
        'id' => 'blog-sidebar',
        'description' => __('Sidebar for blog pages', 'yoursite'),
        'before_widget' => '<div class="blog-widget mb-8 p-6 bg-white rounded-lg shadow-sm">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-xl font-bold mb-4 text-gray-900">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Contact Page Sidebar', 'yoursite'),
        'id' => 'contact-sidebar',
        'description' => __('Sidebar for contact page', 'yoursite'),
        'before_widget' => '<div class="contact-widget mb-8 p-6 bg-gray-50 rounded-lg">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-lg font-semibold mb-4 text-gray-900">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'yoursite_widgets_init');

/**
 * Custom widgets
 */

/**
 * Newsletter signup widget
 */
class YourSite_Newsletter_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'yoursite_newsletter',
            __('Newsletter Signup', 'yoursite'),
            array('description' => __('Newsletter subscription form', 'yoursite'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $button_text = !empty($instance['button_text']) ? $instance['button_text'] : __('Subscribe', 'yoursite');
        
        ?>
        <div class="newsletter-widget">
            <?php if ($description) : ?>
                <p class="mb-4 text-gray-600"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
            
            <form class="newsletter-form flex flex-col sm:flex-row gap-2" data-nonce="<?php echo wp_create_nonce('newsletter_nonce'); ?>">
                <input type="email" name="email" placeholder="<?php _e('Enter your email', 'yoursite'); ?>" required class="flex-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="btn-primary"><?php echo esc_html($button_text); ?></button>
            </form>
            
            <div class="newsletter-message mt-2 text-sm"></div>
        </div>
        <?php
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $button_text = !empty($instance['button_text']) ? $instance['button_text'] : __('Subscribe', 'yoursite');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'yoursite'); ?></label>
            <textarea class="widefat" rows="3" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_textarea($description); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e('Button Text:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo esc_attr($button_text); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? sanitize_textarea_field($new_instance['description']) : '';
        $instance['button_text'] = (!empty($new_instance['button_text'])) ? sanitize_text_field($new_instance['button_text']) : '';
        
        return $instance;
    }
}

/**
 * Recent posts widget with custom styling
 */
class YourSite_Recent_Posts_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'yoursite_recent_posts',
            __('Recent Posts (Custom)', 'yoursite'),
            array('description' => __('Display recent posts with custom styling', 'yoursite'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $number = !empty($instance['number']) ? absint($instance['number']) : 3;
        $show_date = isset($instance['show_date']) ? $instance['show_date'] : true;
        $show_excerpt = isset($instance['show_excerpt']) ? $instance['show_excerpt'] : false;
        
        $recent_posts = wp_get_recent_posts(array(
            'numberposts' => $number,
            'post_status' => 'publish'
        ));
        
        if ($recent_posts) {
            echo '<div class="recent-posts-widget">';
            foreach ($recent_posts as $post) {
                $post_id = $post['ID'];
                $post_title = $post['post_title'];
                $post_date = get_the_date('', $post_id);
                $post_excerpt = get_the_excerpt($post_id);
                $post_url = get_permalink($post_id);
                $post_thumbnail = get_the_post_thumbnail($post_id, 'thumbnail', array('class' => 'w-16 h-16 object-cover rounded'));
                
                echo '<div class="recent-post-item flex items-start gap-3 mb-4 pb-4 border-b border-gray-200 last:border-b-0">';
                
                if ($post_thumbnail) {
                    echo '<div class="flex-shrink-0">' . $post_thumbnail . '</div>';
                }
                
                echo '<div class="flex-1 min-w-0">';
                echo '<h4 class="text-sm font-medium text-gray-900 leading-tight mb-1">';
                echo '<a href="' . esc_url($post_url) . '" class="hover:text-blue-600 transition-colors">' . esc_html($post_title) . '</a>';
                echo '</h4>';
                
                if ($show_date) {
                    echo '<p class="text-xs text-gray-500 mb-1">' . esc_html($post_date) . '</p>';
                }
                
                if ($show_excerpt && $post_excerpt) {
                    echo '<p class="text-xs text-gray-600 line-clamp-2">' . wp_trim_words($post_excerpt, 15) . '</p>';
                }
                
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Posts', 'yoursite');
        $number = !empty($instance['number']) ? absint($instance['number']) : 3;
        $show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : true;
        $show_excerpt = isset($instance['show_excerpt']) ? (bool) $instance['show_excerpt'] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:', 'yoursite'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_date); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>">
            <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Show post date?', 'yoursite'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_excerpt); ?> id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>">
            <label for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _e('Show excerpt?', 'yoursite'); ?></label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset($new_instance['show_date']) ? (bool) $new_instance['show_date'] : false;
        $instance['show_excerpt'] = isset($new_instance['show_excerpt']) ? (bool) $new_instance['show_excerpt'] : false;
        
        return $instance;
    }
}

/**
 * Social media links widget
 */
class YourSite_Social_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'yoursite_social',
            __('Social Media Links', 'yoursite'),
            array('description' => __('Display social media links', 'yoursite'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $social_links = array(
            'facebook' => !empty($instance['facebook']) ? $instance['facebook'] : '',
            'twitter' => !empty($instance['twitter']) ? $instance['twitter'] : '',
            'linkedin' => !empty($instance['linkedin']) ? $instance['linkedin'] : '',
            'instagram' => !empty($instance['instagram']) ? $instance['instagram'] : '',
            'youtube' => !empty($instance['youtube']) ? $instance['youtube'] : '',
        );
        
        echo '<div class="social-links flex flex-wrap gap-3">';
        
        foreach ($social_links as $platform => $url) {
            if (!empty($url)) {
                $icon = $this->get_social_icon($platform);
                echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer" class="social-link w-10 h-10 bg-gray-800 text-white rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors" title="' . ucfirst($platform) . '">';
                echo $icon;
                echo '</a>';
            }
        }
        
        echo '</div>';
        
        echo $args['after_widget'];
    }
    
    private function get_social_icon($platform) {
        $icons = array(
            'facebook' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
            'twitter' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
            'linkedin' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
            'instagram' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C8.396 0 7.989.016 6.756.072 5.526.127 4.71.334 3.999.63 3.26.945 2.632 1.378 2.004 2.006 1.376 2.634.943 3.262.63 4.001.334 4.712.127 5.528.072 6.758.016 7.991 0 8.398 0 12.017c0 3.619.016 4.026.072 5.259.055 1.23.262 2.046.558 2.757.315.739.748 1.367 1.376 1.995.628.628 1.256 1.061 1.995 1.376.711.296 1.527.503 2.757.558 1.233.056 1.64.072 5.259.072 3.619 0 4.026-.016 5.259-.072 1.23-.055 2.046-.262 2.757-.558.739-.315 1.367-.748 1.995-1.376.628-.628 1.061-1.256 1.376-1.995.296-.711.503-1.527.558-2.757.056-1.233.072-1.64.072-5.259 0-3.619-.016-4.026-.072-5.259-.055-1.23-.262-2.046-.558-2.757-.315-.739-.748-1.367-1.376-1.995C20.634.943 20.006.51 19.267.195 18.556-.101 17.74-.308 16.51-.363 15.277-.419 14.87-.435 11.251-.435L12.017 0zm-.764 1.99c.63-.007 1.14-.01 2.395-.01 3.569 0 3.99.017 5.199.069 1.255.057 1.937.272 2.39.451.6.233 1.03.511 1.482.963.452.452.73.882.963 1.482.179.453.394 1.135.451 2.39.052 1.209.069 1.63.069 5.199 0 3.569-.017 3.99-.069 5.199-.057 1.255-.272 1.937-.451 2.39-.233.6-.511 1.03-.963 1.482-.452.452-.882.73-1.482.963-.453.179-1.135.394-2.39.451-1.209.052-1.63.069-5.199.069-3.569 0-3.99-.017-5.199-.069-1.255-.057-1.937-.272-2.39-.451-.6-.233-1.03-.511-1.482-.963-.452-.452-.73-.882-.963-1.482-.179-.453-.394-1.135-.451-2.39-.052-1.209-.069-1.63-.069-5.199 0-3.569.017-3.99.069-5.199.057-1.255.272-1.937.451-2.39.233-.6.511-1.03.963-1.482.452-.452.882-.73 1.482-.963.453-.179 1.135-.394 2.39-.451 1.058-.048 1.467-.059 4.435-.064v.007zm6.125 1.628a1.4 1.4 0 11-2.8 0 1.4 1.4 0 012.8 0zM12.017 5.9a6.117 6.117 0 100 12.234 6.117 6.117 0 000-12.234zm0 1.99a4.125 4.125 0 110 8.25 4.125 4.125 0 010-8.25z"/></svg>',
            'youtube' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>'
        );
        
        return isset($icons[$platform]) ? $icons[$platform] : '';
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Follow Us', 'yoursite');
        $facebook = !empty($instance['facebook']) ? $instance['facebook'] : '';
        $twitter = !empty($instance['twitter']) ? $instance['twitter'] : '';
        $linkedin = !empty($instance['linkedin']) ? $instance['linkedin'] : '';
        $instagram = !empty($instance['instagram']) ? $instance['instagram'] : '';
        $youtube = !empty($instance['youtube']) ? $instance['youtube'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="url" value="<?php echo esc_attr($facebook); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="url" value="<?php echo esc_attr($twitter); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('LinkedIn URL:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="url" value="<?php echo esc_attr($linkedin); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram URL:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="url" value="<?php echo esc_attr($instagram); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube URL:', 'yoursite'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="url" value="<?php echo esc_attr($youtube); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['facebook'] = (!empty($new_instance['facebook'])) ? esc_url_raw($new_instance['facebook']) : '';
        $instance['twitter'] = (!empty($new_instance['twitter'])) ? esc_url_raw($new_instance['twitter']) : '';
        $instance['linkedin'] = (!empty($new_instance['linkedin'])) ? esc_url_raw($new_instance['linkedin']) : '';
        $instance['instagram'] = (!empty($new_instance['instagram'])) ? esc_url_raw($new_instance['instagram']) : '';
        $instance['youtube'] = (!empty($new_instance['youtube'])) ? esc_url_raw($new_instance['youtube']) : '';
        
        return $instance;
    }
}

/**
 * Register custom widgets
 */
function yoursite_register_widgets() {
    register_widget('YourSite_Newsletter_Widget');
    register_widget('YourSite_Recent_Posts_Widget');
    register_widget('YourSite_Social_Widget');
}
add_action('widgets_init', 'yoursite_register_widgets');
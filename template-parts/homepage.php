<?php
/**
 * Template part for displaying optimized homepage content - FULLY DYNAMIC VERSION
 * Main template that loads all homepage sections from separate files
 * Built for maximum conversions with proven SaaS landing page patterns
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Helper function to get testimonials
 * This function tries to get testimonials from custom post type
 * Falls back to customizer settings if no testimonials post type exists
 */
if (!function_exists('get_testimonials')) {
    function get_testimonials($count = 3) {
        // Try to get testimonials from custom post type
        $args = array(
            'post_type' => 'testimonial',
            'posts_per_page' => $count,
            'post_status' => 'publish',
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        
        $testimonials = new WP_Query($args);
        
        // Return the query if we found testimonials
        if ($testimonials->have_posts()) {
            return $testimonials;
        }
        
        // If no testimonials post type, return false to use customizer fallbacks
        return false;
    }
}

/**
 * Enqueue homepage-specific styles and scripts
 */
function yoursite_homepage_assets() {
    // Only load on homepage
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    // Enqueue homepage CSS
    wp_enqueue_style(
        'yoursite-homepage',
        get_template_directory_uri() . '/assets/css/homepage.css',
        array(),
        get_theme_mod('theme_version', '1.0.0')
    );
    
    // Enqueue homepage JavaScript
    wp_enqueue_script(
        'yoursite-homepage',
        get_template_directory_uri() . '/assets/js/homepage.js',
        array('jquery'),
        get_theme_mod('theme_version', '1.0.0'),
        true
    );
    
    // Localize script for AJAX and settings
    wp_localize_script('yoursite-homepage', 'yoursiteHomepage', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('yoursite_homepage_nonce'),
        'isPremium' => get_theme_mod('premium_features_enabled', false),
        'trackingEnabled' => get_theme_mod('conversion_tracking_enabled', true),
    ));
}
add_action('wp_enqueue_scripts', 'yoursite_homepage_assets');

/**
 * Add structured data for homepage
 */
function yoursite_homepage_structured_data() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    $company_name = get_bloginfo('name');
    $company_description = get_bloginfo('description');
    $site_url = home_url();
    $logo_url = get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '';
    
    $structured_data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $company_name,
        'description' => $company_description,
        'url' => $site_url,
        'logo' => $logo_url,
        'sameAs' => array(
            get_theme_mod('social_facebook', ''),
            get_theme_mod('social_twitter', ''),
            get_theme_mod('social_linkedin', ''),
            get_theme_mod('social_instagram', ''),
        ),
        'contactPoint' => array(
            '@type' => 'ContactPoint',
            'contactType' => 'customer service',
            'availableLanguage' => 'English'
        )
    );
    
    // Remove empty social media links
    $structured_data['sameAs'] = array_filter($structured_data['sameAs']);
    
    echo '<script type="application/ld+json">' . json_encode($structured_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'yoursite_homepage_structured_data');

/**
 * Add critical CSS for homepage above the fold content
 */
function yoursite_homepage_critical_css() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    ?>
    <style id="yoursite-critical-css">
    /* Critical CSS for above-the-fold content */
    .hero-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 600px;
        display: flex;
        align-items: center;
        color: white;
    }
    
    .fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Prevent layout shift */
    .hero-gradient img,
    .pricing-card,
    .feature-card {
        aspect-ratio: attr(width) / attr(height);
    }
    
    /* Loading states */
    .btn-loading {
        position: relative;
        color: transparent !important;
    }
    
    .btn-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
    </style>
    <?php
}
add_action('wp_head', 'yoursite_homepage_critical_css', 1);

/**
 * Preload critical resources
 */
function yoursite_homepage_preload_resources() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    // Preload hero image if set
    $hero_image = get_theme_mod('hero_dashboard_image');
    if ($hero_image) {
        echo '<link rel="preload" as="image" href="' . esc_url($hero_image) . '">' . "\n";
    }
    
    // Preload fonts (if using custom fonts)
    $custom_fonts = get_theme_mod('custom_fonts', array());
    foreach ($custom_fonts as $font_url) {
        if (!empty($font_url)) {
            echo '<link rel="preload" as="font" type="font/woff2" href="' . esc_url($font_url) . '" crossorigin>' . "\n";
        }
    }
    
    // DNS prefetch for external resources
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//www.google-analytics.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//www.youtube.com">' . "\n";
}
add_action('wp_head', 'yoursite_homepage_preload_resources', 5);

/**
 * Add performance monitoring
 */
function yoursite_homepage_performance_monitoring() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    if (!get_theme_mod('performance_monitoring_enabled', false)) {
        return;
    }
    ?>
    <script>
    // Core Web Vitals monitoring
    (function() {
        // Largest Contentful Paint
        new PerformanceObserver((list) => {
            const entries = list.getEntries();
            const lastEntry = entries[entries.length - 1];
            console.log('LCP:', lastEntry.startTime);
            
            // Send to analytics if available
            if (typeof gtag !== 'undefined') {
                gtag('event', 'web_vitals', {
                    'metric_name': 'LCP',
                    'metric_value': Math.round(lastEntry.startTime),
                    'metric_delta': Math.round(lastEntry.startTime)
                });
            }
        }).observe({entryTypes: ['largest-contentful-paint']});
        
        // First Input Delay
        new PerformanceObserver((list) => {
            const entries = list.getEntries();
            entries.forEach((entry) => {
                console.log('FID:', entry.processingStart - entry.startTime);
                
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'web_vitals', {
                        'metric_name': 'FID',
                        'metric_value': Math.round(entry.processingStart - entry.startTime),
                        'metric_delta': Math.round(entry.processingStart - entry.startTime)
                    });
                }
            });
        }).observe({entryTypes: ['first-input']});
        
        // Cumulative Layout Shift
        let clsValue = 0;
        new PerformanceObserver((list) => {
            const entries = list.getEntries();
            entries.forEach((entry) => {
                if (!entry.hadRecentInput) {
                    clsValue += entry.value;
                }
            });
            console.log('CLS:', clsValue);
            
            if (typeof gtag !== 'undefined') {
                gtag('event', 'web_vitals', {
                    'metric_name': 'CLS',
                    'metric_value': Math.round(clsValue * 1000),
                    'metric_delta': Math.round(clsValue * 1000)
                });
            }
        }).observe({entryTypes: ['layout-shift']});
    })();
    </script>
    <?php
}
add_action('wp_footer', 'yoursite_homepage_performance_monitoring');

/**
 * Add conversion tracking pixels
 */
function yoursite_homepage_conversion_tracking() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    if (!get_theme_mod('conversion_tracking_enabled', false)) {
        return;
    }
    
    // Facebook Pixel
    $facebook_pixel_id = get_theme_mod('facebook_pixel_id');
    if ($facebook_pixel_id) {
        ?>
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo esc_js($facebook_pixel_id); ?>');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=<?php echo esc_attr($facebook_pixel_id); ?>&ev=PageView&noscript=1"
        /></noscript>
        <?php
    }
    
    // Google Analytics 4
    $ga4_id = get_theme_mod('google_analytics_4_id');
    if ($ga4_id) {
        ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga4_id); ?>"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo esc_js($ga4_id); ?>', {
            'anonymize_ip': true,
            'custom_map': {
                'custom_parameter_1': 'page_type'
            }
        });
        
        // Track homepage view
        gtag('event', 'page_view', {
            'page_type': 'homepage',
            'page_location': window.location.href,
            'page_title': document.title
        });
        </script>
        <?php
    }
}
add_action('wp_head', 'yoursite_homepage_conversion_tracking');

// ===== MAIN HOMEPAGE CONTENT =====
?>

<!-- Load Homepage Part 1: Hero & Social Proof -->
<?php get_template_part('template-parts/homepage', 'hero-social-proof'); ?>

<!-- Load Homepage Part 2: Benefits, Pricing & DIFM -->
<?php get_template_part('template-parts/homepage', 'benefits-pricing-difm'); ?>

<!-- Load Homepage Part 3: Testimonials, Stats, FAQ & Final CTA -->
<?php get_template_part('template-parts/homepage', 'testimonials-final'); ?>

<?php
/**
 * Add homepage-specific footer scripts
 */
function yoursite_homepage_footer_scripts() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    ?>
    <script>
    // Homepage-specific initialization
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🏠 Homepage Fully Loaded');
        
        // Initialize performance monitoring
        if (window.performance && window.performance.mark) {
            window.performance.mark('homepage-interactive');
        }
        });
        
        // Add intersection observer for conversion tracking
        const conversionElements = document.querySelectorAll('.pricing-card, .cta-btn, .hero-gradient');
        const conversionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const elementType = entry.target.classList.contains('pricing-card') ? 'pricing_viewed' :
                                      entry.target.classList.contains('cta-btn') ? 'cta_viewed' :
                                      entry.target.classList.contains('hero-gradient') ? 'hero_viewed' : 'element_viewed';
                    
                    if (typeof gtag !== 'undefined') {
                        gtag('event', elementType, {
                            'event_category': 'engagement',
                            'event_label': elementType
                        });
                    }
                    
                    // Stop observing once viewed
                    conversionObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        });
        
        conversionElements.forEach(el => conversionObserver.observe(el));
        
        // Add exit-intent detection
        let exitIntentShown = false;
        document.addEventListener('mouseleave', function(e) {
            if (e.clientY <= 0 && !exitIntentShown) {
                exitIntentShown = true;
                
                // Track exit intent
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'exit_intent', {
                        'event_category': 'engagement',
                        'event_label': 'homepage_exit_intent'
                    });
                }
                
                // You could show an exit-intent popup here
                console.log('🚪 Exit intent detected');
            }
        });
        
        // Add scroll depth tracking (enhanced)
        let scrollDepthMarks = [25, 50, 75, 90, 100];
        let scrollDepthReached = [];
        
        window.addEventListener('scroll', throttle(() => {
            const scrollPercent = Math.round((window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100);
            
            scrollDepthMarks.forEach(mark => {
                if (scrollPercent >= mark && !scrollDepthReached.includes(mark)) {
                    scrollDepthReached.push(mark);
                    
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'scroll_depth', {
                            'event_category': 'engagement',
                            'event_label': mark + '%',
                            'value': mark
                        });
                    }
                    
                    console.log('📏 Scroll depth:', mark + '%');
                }
            });
        }, 500));
        
        function throttle(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            }
        }
        
        // Add time on page tracking
        let timeOnPageStart = Date.now();
        let timeOnPageTracked = false;
        
        setTimeout(() => {
            if (!timeOnPageTracked) {
                timeOnPageTracked = true;
                const timeSpent = Math.round((Date.now() - timeOnPageStart) / 1000);
                
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'time_on_page', {
                        'event_category': 'engagement',
                        'event_label': 'homepage_30_seconds',
                        'value': timeSpent
                    });
                }
                
                console.log('⏱️ Time on page: 30+ seconds');
            }
        }, 30000); // Track after 30 seconds
        
        // Track before page unload
        window.addEventListener('beforeunload', function() {
            if (!timeOnPageTracked) {
                const timeSpent = Math.round((Date.now() - timeOnPageStart) / 1000);
                
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'time_on_page', {
                        'event_category': 'engagement',
                        'event_label': 'homepage_total',
                        'value': timeSpent
                    });
                }
            }
        });    </script>
    <?php
}
add_action('wp_footer', 'yoursite_homepage_footer_scripts', 99);

/**
 * Add schema markup for pricing
 */
function yoursite_homepage_pricing_schema() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    if (!get_theme_mod('pricing_enable', true)) {
        return;
    }
    
    // Get pricing plans for schema
    $pricing_args = array(
        'post_type' => 'pricing',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_key' => '_pricing_monthly_price',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
    );
    
    $pricing_plans = get_posts($pricing_args);
    
    if (!empty($pricing_plans)) {
        $offers = array();
        
        foreach ($pricing_plans as $plan) {
            $monthly_price = get_post_meta($plan->ID, '_pricing_monthly_price', true);
            $annual_price = get_post_meta($plan->ID, '_pricing_annual_price', true);
            $currency = get_post_meta($plan->ID, '_pricing_currency', true) ?: 'USD';
            $features = get_post_meta($plan->ID, '_pricing_features', true);
            
            if ($monthly_price > 0) {
                $offers[] = array(
                    '@type' => 'Offer',
                    'name' => $plan->post_title,
                    'description' => $plan->post_excerpt ?: $plan->post_title . ' plan',
                    'price' => $monthly_price,
                    'priceCurrency' => $currency,
                    'priceSpecification' => array(
                        '@type' => 'PriceSpecification',
                        'price' => $monthly_price,
                        'priceCurrency' => $currency,
                        'billingIncrement' => 'P1M'
                    ),
                    'seller' => array(
                        '@type' => 'Organization',
                        'name' => get_bloginfo('name')
                    )
                );
            }
        }
        
        if (!empty($offers)) {
            $pricing_schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => get_bloginfo('name') . ' - E-commerce Platform',
                'description' => get_bloginfo('description'),
                'brand' => array(
                    '@type' => 'Brand',
                    'name' => get_bloginfo('name')
                ),
                'offers' => $offers
            );
            
            echo '<script type="application/ld+json">' . json_encode($pricing_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
        }
    }
}
add_action('wp_footer', 'yoursite_homepage_pricing_schema');

/**
 * Add FAQ schema markup
 */
function yoursite_homepage_faq_schema() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    if (!get_theme_mod('faq_enable', true)) {
        return;
    }
    
    $faq_items = array();
    
    for ($i = 1; $i <= 5; $i++) {
        $question = get_theme_mod("faq_{$i}_question", '');
        $answer = get_theme_mod("faq_{$i}_answer", '');
        
        if (!empty($question) && !empty($answer)) {
            $faq_items[] = array(
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => $answer
                )
            );
        }
    }
    
    if (!empty($faq_items)) {
        $faq_schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faq_items
        );
        
        echo '<script type="application/ld+json">' . json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_footer', 'yoursite_homepage_faq_schema');

/**
 * Add breadcrumb schema
 */
function yoursite_homepage_breadcrumb_schema() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    $breadcrumb_schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => array(
            array(
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => home_url()
            )
        )
    );
    
    echo '<script type="application/ld+json">' . json_encode($breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_footer', 'yoursite_homepage_breadcrumb_schema');

/**
 * Add service schema markup
 */
function yoursite_homepage_service_schema() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    $service_schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'provider' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'url' => home_url()
        ),
        'serviceType' => 'E-commerce Platform',
        'areaServed' => 'Worldwide',
        'hasOfferCatalog' => array(
            '@type' => 'OfferCatalog',
            'name' => 'E-commerce Solutions',
            'itemListElement' => array(
                array(
                    '@type' => 'Offer',
                    'itemOffered' => array(
                        '@type' => 'Service',
                        'name' => 'Online Store Builder'
                    )
                ),
                array(
                    '@type' => 'Offer',
                    'itemOffered' => array(
                        '@type' => 'Service',
                        'name' => 'Payment Processing'
                    )
                ),
                array(
                    '@type' => 'Offer',
                    'itemOffered' => array(
                        '@type' => 'Service',
                        'name' => 'Inventory Management'
                    )
                )
            )
        )
    );
    
    echo '<script type="application/ld+json">' . json_encode($service_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_footer', 'yoursite_homepage_service_schema');

/**
 * Add open graph meta tags
 */
function yoursite_homepage_open_graph() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    $site_name = get_bloginfo('name');
    $site_description = get_bloginfo('description');
    $site_url = home_url();
    $hero_image = get_theme_mod('hero_dashboard_image');
    
    // Fallback to site logo if no hero image
    if (!$hero_image) {
        $custom_logo = get_theme_mod('custom_logo');
        if ($custom_logo) {
            $hero_image = wp_get_attachment_image_url($custom_logo, 'full');
        }
    }
    
    echo '<meta property="og:title" content="' . esc_attr($site_name) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($site_description) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($site_url) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
    
    if ($hero_image) {
        echo '<meta property="og:image" content="' . esc_url($hero_image) . '">' . "\n";
        echo '<meta property="og:image:width" content="1200">' . "\n";
        echo '<meta property="og:image:height" content="630">' . "\n";
    }
    
    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($site_name) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($site_description) . '">' . "\n";
    
    if ($hero_image) {
        echo '<meta name="twitter:image" content="' . esc_url($hero_image) . '">' . "\n";
    }
    
    $twitter_handle = get_theme_mod('social_twitter_handle');
    if ($twitter_handle) {
        echo '<meta name="twitter:site" content="@' . esc_attr(str_replace('@', '', $twitter_handle)) . '">' . "\n";
    }
}
add_action('wp_head', 'yoursite_homepage_open_graph', 5);

/**
 * Add custom CSS from customizer
 */
function yoursite_homepage_custom_css() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    $custom_css = get_theme_mod('homepage_custom_css', '');
    if (!empty($custom_css)) {
        echo '<style id="yoursite-homepage-custom-css">' . wp_strip_all_tags($custom_css) . '</style>' . "\n";
    }
}
add_action('wp_head', 'yoursite_homepage_custom_css', 99);

/**
 * Add A/B testing support
 */
function yoursite_homepage_ab_testing() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    if (!get_theme_mod('ab_testing_enabled', false)) {
        return;
    }
    
    $ab_test_id = get_theme_mod('ab_test_id', '');
    if (empty($ab_test_id)) {
        return;
    }
    ?>
    <script>
    // Simple A/B testing implementation
    (function() {
        const testId = '<?php echo esc_js($ab_test_id); ?>';
        const userId = localStorage.getItem('yoursite_user_id') || 'user_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('yoursite_user_id', userId);
        
        // Simple hash function to determine variant
        function simpleHash(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                const char = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + char;
                hash = hash & hash; // Convert to 32bit integer
            }
            return Math.abs(hash);
        }
        
        const variant = simpleHash(userId + testId) % 2 === 0 ? 'A' : 'B';
        
        // Store variant for later use
        window.yoursiteABVariant = variant;
        
        // Add body class for CSS targeting
        document.body.classList.add('ab-test-' + variant.toLowerCase());
        
        // Track variant assignment
        if (typeof gtag !== 'undefined') {
            gtag('event', 'ab_test_assignment', {
                'event_category': 'ab_testing',
                'event_label': testId + '_' + variant,
                'custom_parameter_1': variant
            });
        }
        
        console.log('🧪 A/B Test Variant:', variant);
    })();
    </script>
    <?php
}
add_action('wp_head', 'yoursite_homepage_ab_testing', 10);

/**
 * Add GDPR compliance notice
 */
function yoursite_homepage_gdpr_notice() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    if (!get_theme_mod('gdpr_notice_enabled', false)) {
        return;
    }
    ?>
    <div id="gdpr-notice" class="fixed bottom-0 left-0 right-0 bg-gray-900 text-white p-4 transform translate-y-full transition-transform duration-300 z-50" style="display: none;">
        <div class="container mx-auto flex flex-col sm:flex-row items-center justify-between">
            <div class="mb-4 sm:mb-0">
                <p class="text-sm">
                    <?php echo esc_html(get_theme_mod('gdpr_notice_text', __('We use cookies to enhance your browsing experience and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.', 'yoursite'))); ?>
                    <a href="<?php echo esc_url(get_theme_mod('privacy_policy_url', '/privacy-policy')); ?>" class="underline ml-2">
                        <?php _e('Privacy Policy', 'yoursite'); ?>
                    </a>
                </p>
            </div>
            <div class="flex space-x-4">
                <button id="gdpr-accept" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-sm font-medium transition-colors">
                    <?php _e('Accept All', 'yoursite'); ?>
                </button>
                <button id="gdpr-decline" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded text-sm font-medium transition-colors">
                    <?php _e('Decline', 'yoursite'); ?>
                </button>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const notice = document.getElementById('gdpr-notice');
        const acceptBtn = document.getElementById('gdpr-accept');
        const declineBtn = document.getElementById('gdpr-decline');
        
        // Check if user has already made a choice
        const gdprChoice = localStorage.getItem('gdpr_choice');
        
        if (!gdprChoice) {
            // Show notice after 2 seconds
            setTimeout(() => {
                notice.style.display = 'block';
                setTimeout(() => {
                    notice.classList.remove('translate-y-full');
                }, 100);
            }, 2000);
        }
        
        acceptBtn.addEventListener('click', function() {
            localStorage.setItem('gdpr_choice', 'accepted');
            hideNotice();
            
            // Track acceptance
            if (typeof gtag !== 'undefined') {
                gtag('event', 'gdpr_consent', {
                    'event_category': 'privacy',
                    'event_label': 'accepted'
                });
            }
        });
        
        declineBtn.addEventListener('click', function() {
            localStorage.setItem('gdpr_choice', 'declined');
            hideNotice();
            
            // Track decline
            if (typeof gtag !== 'undefined') {
                gtag('event', 'gdpr_consent', {
                    'event_category': 'privacy',
                    'event_label': 'declined'
                });
            }
        });
        
        function hideNotice() {
            notice.classList.add('translate-y-full');
            setTimeout(() => {
                notice.style.display = 'none';
            }, 300);
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'yoursite_homepage_gdpr_notice');

/**
 * Debug mode for development
 */
function yoursite_homepage_debug_mode() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    if (!defined('WP_DEBUG') || !WP_DEBUG || !current_user_can('manage_options')) {
        return;
    }
    ?>
    <script>
    console.group('🏠 YourSite Homepage Debug Info');
    console.log('WordPress Version:', '<?php echo get_bloginfo("version"); ?>');
    console.log('Theme Version:', '<?php echo get_theme_mod("theme_version", "1.0.0"); ?>');
    console.log('Current User Can Edit:', <?php echo current_user_can('edit_posts') ? 'true' : 'false'; ?>);
    console.log('Dark Mode Enabled:', document.body.classList.contains('dark-mode'));
    console.log('Sections Enabled:', {
        hero: <?php echo get_theme_mod('hero_enable', true) ? 'true' : 'false'; ?>,
        socialProof: <?php echo get_theme_mod('social_proof_enable', true) ? 'true' : 'false'; ?>,
        benefits: <?php echo get_theme_mod('benefits_enable', true) ? 'true' : 'false'; ?>,
        pricing: <?php echo get_theme_mod('pricing_enable', true) ? 'true' : 'false'; ?>,
        difm: <?php echo get_theme_mod('difm_banner_enable', true) ? 'true' : 'false'; ?>,
        testimonials: <?php echo get_theme_mod('testimonials_enable', true) ? 'true' : 'false'; ?>,
        stats: <?php echo get_theme_mod('stats_enable', true) ? 'true' : 'false'; ?>,
        faq: <?php echo get_theme_mod('faq_enable', true) ? 'true' : 'false'; ?>,
        finalCta: <?php echo get_theme_mod('final_cta_enable', true) ? 'true' : 'false'; ?>
    });
    console.groupEnd();
    </script>
    <?php
}
add_action('wp_footer', 'yoursite_homepage_debug_mode', 999);

/**
 * File names for the split template parts (for reference)
 * 
 * Save these parts as:
 * - template-parts/homepage-hero-social-proof.php (Part 1)
 * - template-parts/homepage-benefits-pricing-difm.php (Part 2) 
 * - template-parts/homepage-testimonials-final.php (Part 3)
 * 
 * Or use the get_template_part naming convention:
 * - template-parts/homepage/hero-social-proof.php
 * - template-parts/homepage/benefits-pricing-difm.php
 * - template-parts/homepage/testimonials-final.php
 */
?>
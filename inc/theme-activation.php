<?php
/**
 * Theme activation hooks and setup
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create customizer directory structure and files
 */
function yoursite_create_customizer_files() {
    $customizer_dir = get_template_directory() . '/inc/customizer';
    
    // Create directory if it doesn't exist
    if (!file_exists($customizer_dir)) {
        wp_mkdir_p($customizer_dir);
    }
    
    // Array of customizer files to create
    $customizer_files = array(
        'customizer-homepage.php' => '<?php
/**
 * Homepage customizer options - Auto-generated
 * Edit through WordPress Admin > Appearance > Customize > Edit Pages > Homepage
 */

if (!defined("ABSPATH")) {
    exit;
}

// This file is automatically loaded by the main customizer.php
// The actual customizer options are defined in the main customizer system
',
        'customizer-header.php' => '<?php
/**
 * Header customizer options - Auto-generated  
 * Edit through WordPress Admin > Appearance > Customize > Header Settings
 */

if (!defined("ABSPATH")) {
    exit;
}

// This file is automatically loaded by the main customizer.php
',
        'customizer-footer.php' => '<?php
/**
 * Footer customizer options - Auto-generated
 * Edit through WordPress Admin > Appearance > Customize > Footer Settings  
 */

if (!defined("ABSPATH")) {
    exit;
}

// This file is automatically loaded by the main customizer.php
',
        'customizer-colors.php' => '<?php
/**
 * Colors and typography customizer options - Auto-generated
 * Edit through WordPress Admin > Appearance > Customize > Colors & Typography
 */

if (!defined("ABSPATH")) {
    exit;
}

// This file is automatically loaded by the main customizer.php
',
        'customizer-company.php' => '<?php
/**
 * Company information customizer options - Auto-generated
 * Edit through WordPress Admin > Appearance > Customize > Company Information
 */

if (!defined("ABSPATH")) {
    exit;
}

// This file is automatically loaded by the main customizer.php
',
        'customizer-social.php' => '<?php
/**
 * Social media customizer options - Auto-generated
 * Edit through WordPress Admin > Appearance > Customize > Social Media Links
 */

if (!defined("ABSPATH")) {
    exit;
}

// This file is automatically loaded by the main customizer.php
'
    );
    
    // Create placeholder files if they don't exist
    foreach ($customizer_files as $filename => $content) {
        $file_path = $customizer_dir . '/' . $filename;
        if (!file_exists($file_path)) {
            file_put_contents($file_path, $content);
        }
    }
}

/**
 * Create demo case studies
 */
function yoursite_create_demo_case_studies() {
    // Check if case studies already exist
    $existing_case_studies = get_posts(array(
        'post_type' => 'case_studies',
        'numberposts' => 1
    ));
    
    if (!empty($existing_case_studies)) {
        return; // Already created
    }
    
    // Create case study categories first
    yoursite_create_case_study_categories();
    
    // Get category IDs
    $ecommerce_cat = get_term_by('slug', 'ecommerce', 'case_study_industry');
    $healthcare_cat = get_term_by('slug', 'healthcare', 'case_study_industry');
    $fintech_cat = get_term_by('slug', 'fintech', 'case_study_industry');
    $education_cat = get_term_by('slug', 'education', 'case_study_industry');
    
    $web_dev_service = get_term_by('slug', 'web-development', 'case_study_service');
    $marketing_service = get_term_by('slug', 'digital-marketing', 'case_study_service');
    $consulting_service = get_term_by('slug', 'consulting', 'case_study_service');
    
    $case_studies_data = array(
        array(
            'title' => 'Fashion Retailer Triples Online Sales in 6 Months',
            'content' => '<p>StyleHub, a premium fashion retailer, was struggling with an outdated e-commerce platform that couldn\'t handle their growing inventory and customer base. Their conversion rates were below industry standards, and they were losing customers to competitors with better online experiences.</p>

<p>We partnered with StyleHub to completely redesign their online presence, implementing a modern, mobile-first e-commerce platform with advanced personalization features and streamlined checkout processes.</p>

<h3>Key Improvements Made:</h3>
<ul>
<li>Complete platform migration to a scalable solution</li>
<li>Implementation of AI-powered product recommendations</li>
<li>Mobile-optimized design with improved UX/UI</li>
<li>Advanced inventory management system</li>
<li>Integrated customer loyalty program</li>
<li>Performance optimization for faster load times</li>
</ul>

<p>The results exceeded expectations, with StyleHub seeing immediate improvements in both user experience and business metrics. The new platform not only solved their immediate challenges but also positioned them for continued growth in the competitive fashion market.</p>',
            'excerpt' => 'How StyleHub transformed their outdated e-commerce platform and achieved a 200% increase in online revenue through strategic redesign and optimization.',
            'industry' => $ecommerce_cat ? $ecommerce_cat->term_id : null,
            'service' => $web_dev_service ? $web_dev_service->term_id : null,
            'meta' => array(
                '_case_study_client' => 'StyleHub Fashion',
                '_case_study_industry_text' => 'Fashion & Retail',
                '_case_study_website' => 'https://stylehub-demo.com',
                '_case_study_duration' => '6 months',
                '_case_study_technologies' => 'WooCommerce, React, Progressive Web App, AI Recommendations, Analytics',
                '_case_study_challenge' => 'StyleHub was losing customers due to their slow, outdated website that provided a poor mobile experience. Their conversion rate was 40% below industry average, and they couldn\'t effectively manage their growing product catalog.',
                '_case_study_solution' => 'We built a completely new e-commerce platform using modern technologies, focusing on mobile-first design, personalized shopping experiences, and seamless checkout processes. We also integrated advanced analytics and inventory management systems.',
                '_case_study_results' => 'Within 6 months, StyleHub saw a 200% increase in online sales, 85% improvement in mobile conversion rates, and 60% reduction in cart abandonment. Customer satisfaction scores increased by 45%, and average order value grew by 35%.',
                '_case_study_metric_1_label' => 'Sales Increase',
                '_case_study_metric_1_value' => '200%',
                '_case_study_metric_2_label' => 'Mobile Conversion',
                '_case_study_metric_2_value' => '+85%',
                '_case_study_metric_3_label' => 'Cart Abandonment',
                '_case_study_metric_3_value' => '-60%',
                '_case_study_testimonial' => 'The transformation has been incredible. Our new platform not only looks amazing but performs exceptionally well. Sales have tripled, and our customers love the new shopping experience.',
                '_case_study_testimonial_author' => 'Sarah Mitchell, CEO of StyleHub Fashion',
                '_case_study_featured' => '1'
            )
        ),
        // Add more case studies here if needed...
    );
    
    // Create case study posts
    foreach ($case_studies_data as $case_study) {
        $post_id = wp_insert_post(array(
            'post_title' => $case_study['title'],
            'post_content' => $case_study['content'],
            'post_excerpt' => $case_study['excerpt'],
            'post_status' => 'publish',
            'post_type' => 'case_studies'
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            // Set categories
            if ($case_study['industry']) {
                wp_set_post_terms($post_id, array($case_study['industry']), 'case_study_industry');
            }
            if ($case_study['service']) {
                wp_set_post_terms($post_id, array($case_study['service']), 'case_study_service');
            }
            
            // Add meta fields
            foreach ($case_study['meta'] as $key => $value) {
                update_post_meta($post_id, $key, $value);
            }
        }
    }
}

/**
 * Create case study categories
 */
function yoursite_create_case_study_categories() {
    // Industries
    $industries = array(
        array(
            'name' => 'E-commerce',
            'slug' => 'ecommerce',
            'description' => 'Online retail and e-commerce platforms'
        ),
        array(
            'name' => 'Healthcare',
            'slug' => 'healthcare',
            'description' => 'Healthcare technology and medical platforms'
        ),
        array(
            'name' => 'Financial Technology',
            'slug' => 'fintech',
            'description' => 'Banking, payments, and financial services'
        ),
        array(
            'name' => 'Education',
            'slug' => 'education',
            'description' => 'Educational technology and learning platforms'
        ),
        array(
            'name' => 'Manufacturing',
            'slug' => 'manufacturing',
            'description' => 'Industrial and manufacturing solutions'
        ),
        array(
            'name' => 'SaaS',
            'slug' => 'saas',
            'description' => 'Software as a Service platforms'
        )
    );
    
    foreach ($industries as $industry) {
        if (!term_exists($industry['slug'], 'case_study_industry')) {
            wp_insert_term(
                $industry['name'],
                'case_study_industry',
                array(
                    'slug' => $industry['slug'],
                    'description' => $industry['description']
                )
            );
        }
    }
    
    // Services
    $services = array(
        array(
            'name' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Custom web application development'
        ),
        array(
            'name' => 'Digital Marketing',
            'slug' => 'digital-marketing',
            'description' => 'SEO, PPC, and digital marketing services'
        ),
        array(
            'name' => 'Consulting',
            'slug' => 'consulting',
            'description' => 'Strategic consulting and digital transformation'
        ),
        array(
            'name' => 'Mobile Development',
            'slug' => 'mobile-development',
            'description' => 'iOS and Android app development'
        ),
        array(
            'name' => 'UI/UX Design',
            'slug' => 'ui-ux-design',
            'description' => 'User interface and experience design'
        )
    );
    
    foreach ($services as $service) {
        if (!term_exists($service['slug'], 'case_study_service')) {
            wp_insert_term(
                $service['name'],
                'case_study_service',
                array(
                    'slug' => $service['slug'],
                    'description' => $service['description']
                )
            );
        }
    }
}

/**
 * Create default integrations and categories
 */
function yoursite_create_default_integrations() {
    // First create categories
    yoursite_create_integration_categories();
    
    // Check if integrations already exist
    $existing_integrations = get_posts(array(
        'post_type' => 'integrations',
        'numberposts' => 1
    ));
    
    if (!empty($existing_integrations)) {
        return; // Already created
    }
    
    // Get category IDs
    $payment_cat = get_term_by('slug', 'payment-gateways', 'integration_category');
    $shipping_cat = get_term_by('slug', 'shipping-fulfillment', 'integration_category');
    $analytics_cat = get_term_by('slug', 'analytics-reporting', 'integration_category');
    $marketing_cat = get_term_by('slug', 'marketing', 'integration_category');
    
    $integrations_data = array(
        // Payment Gateways
        array(
            'title' => 'Nicky',
            'content' => '<h2>Cryptocurrency Payment Solutions</h2>
            <p>Nicky.me offers cutting-edge cryptocurrency payment solutions for your online store, making digital currency transactions fast, secure, and seamless for both merchants and customers.</p>
            
            <h3>Why Choose Nicky?</h3>
            <ul>
            <li><strong>Multi-Currency Support</strong> - Accept Bitcoin, Ethereum, and 50+ cryptocurrencies</li>
            <li><strong>Instant Settlements</strong> - Get paid immediately with real-time processing</li>
            <li><strong>Low Fees</strong> - Competitive rates with transparent pricing</li>
            <li><strong>Secure</strong> - Bank-level security with advanced fraud protection</li>
            <li><strong>Global Reach</strong> - Accept payments from customers worldwide</li>
            </ul>
            
            <h3>Perfect For</h3>
            <p>E-commerce stores, digital services, subscription businesses, and any merchant looking to tap into the growing cryptocurrency market.</p>',
            'excerpt' => 'Accept cryptocurrency payments with Nicky.me\'s secure and fast digital currency processing solutions.',
            'category' => $payment_cat ? $payment_cat->term_id : null,
            'meta' => array(
                '_integration_icon' => 'N',
                '_integration_color' => 'purple',
                '_integration_website' => 'https://nicky.me',
                '_integration_status' => 'available',
                '_integration_popularity' => '4.3',
                '_integration_features' => "Accept 50+ cryptocurrencies\nInstant settlements\nLow transaction fees\nAdvanced security\nGlobal availability",
                '_integration_countries' => 'Global',
                '_integration_pricing' => '1.5% per transaction'
            )
        ),
        // Add more integrations here if needed...
    );
    
    // Create integration posts
    foreach ($integrations_data as $integration) {
        $post_id = wp_insert_post(array(
            'post_title' => $integration['title'],
            'post_content' => $integration['content'],
            'post_excerpt' => $integration['excerpt'],
            'post_status' => 'publish',
            'post_type' => 'integrations'
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            // Set category
            if ($integration['category']) {
                wp_set_post_terms($post_id, array($integration['category']), 'integration_category');
            }
            
            // Add meta fields
            foreach ($integration['meta'] as $key => $value) {
                update_post_meta($post_id, $key, $value);
            }
        }
    }
}

/**
 * Create integration categories
 */
function yoursite_create_integration_categories() {
    $categories = array(
        array(
            'name' => 'Payment Gateways',
            'slug' => 'payment-gateways',
            'description' => 'Accept payments from customers worldwide'
        ),
        array(
            'name' => 'Shipping & Fulfillment',
            'slug' => 'shipping-fulfillment', 
            'description' => 'Manage shipping and order fulfillment'
        ),
        array(
            'name' => 'Analytics & Reporting',
            'slug' => 'analytics-reporting',
            'description' => 'Track performance and gain insights'
        ),
        array(
            'name' => 'Marketing',
            'slug' => 'marketing',
            'description' => 'Promote your business and reach customers'
        )
    );
    
    foreach ($categories as $category) {
        if (!term_exists($category['slug'], 'integration_category')) {
            wp_insert_term(
                $category['name'],
                'integration_category',
                array(
                    'slug' => $category['slug'],
                    'description' => $category['description']
                )
            );
        }
    }
}

/**
 * Theme activation hook
 */
function yoursite_theme_activation() {
    // Create customizer files first
    yoursite_create_customizer_files();
    
    // Create default pages
    yoursite_create_default_pages();
    
    // Create default posts
    yoursite_create_default_posts();
    
    // Create integrations
    yoursite_create_default_integrations();
    
    // Create demo content
    yoursite_create_demo_content();
    
    // Set homepage settings
    yoursite_setup_homepage();
    
    // Clean up default content
    yoursite_remove_default_posts();
    
    // Create template parts directory
    yoursite_create_template_parts();
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'yoursite_theme_activation');

/**
 * Create default pages
 */
function yoursite_create_default_pages() {
    $pages = array(
        'Features' => array(
            'post_title' => __('Features', 'yoursite'),
            'post_content' => __('Discover the powerful features that make our platform the perfect choice for your online store.', 'yoursite'),
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => 'page-features.php'
        ),
        'Pricing' => array(
            'post_title' => __('Pricing', 'yoursite'),
            'post_content' => __('Choose the perfect plan for your business. All plans include our core features with no hidden fees.', 'yoursite'),
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => 'page-pricing.php'
        ),
        'Templates' => array(
            'post_title' => __('Templates', 'yoursite'),
            'post_content' => __('Browse our collection of professionally designed templates to get your store up and running quickly.', 'yoursite'),
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => 'page-templates.php'
        ),
        'Contact' => array(
            'post_title' => __('Contact', 'yoursite'),
            'post_content' => __('Get in touch with our team. We\'re here to help you succeed with your online store.', 'yoursite'),
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => 'page-contact.php'
        ),
        'About' => array(
            'post_title' => __('About', 'yoursite'),
            'post_content' => __('Learn about our mission to help businesses succeed online with powerful, easy-to-use eCommerce tools.', 'yoursite'),
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => 'page-about.php'
        ),
        'Blog' => array(
            'post_title' => __('Blog', 'yoursite'),
            'post_content' => __('Stay updated with the latest eCommerce trends, tips, and insights from our experts.', 'yoursite'),
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => 'page-blog.php'
        ),
        'API' => array(
            'post_title' => __('API', 'yoursite'),
            'post_content' => __('Integrate with our powerful API to extend your store\'s functionality and connect with other services.', 'yoursite'),
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => 'page-api.php'
        ),
        'Integrations' => array(
            'post_title' => __('Integrations', 'yoursite'),
            'post_content' => __('Connect your store with popular tools and services to streamline your business operations.', 'yoursite'),
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => 'page-integrations.php'
        ),
        'Webinars' => array(
            'post_title' => __('Webinars', 'yoursite'),
            'post_content' => __('Join our expert-led webinar series and learn from industry leaders. Discover the latest trends, strategies, and best practices to grow your business.', 'yoursite'),
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => 'page-webinars.php'
        )
    );
    
    foreach ($pages as $page_data) {
        $existing_page = get_page_by_title($page_data['post_title']);
        if (!$existing_page) {
            $page_id = wp_insert_post($page_data);
            if ($page_id && isset($page_data['page_template'])) {
                update_post_meta($page_id, '_wp_page_template', $page_data['page_template']);
            }
        }
    }
}

/**
 * Set up homepage
 */
function yoursite_setup_homepage() {
    // Create homepage if it doesn't exist
    $homepage = get_page_by_title('Home');
    if (!$homepage) {
        $homepage_id = wp_insert_post(array(
            'post_title' => __('Home', 'yoursite'),
            'post_content' => __('Welcome to your new eCommerce platform.', 'yoursite'),
            'post_status' => 'publish',
            'post_type' => 'page'
        ));
    } else {
        $homepage_id = $homepage->ID;
    }
    
    // Set static front page
    update_option('show_on_front', 'page');
    update_option('page_on_front', $homepage_id);
    
    // Create blog page
    $blog_page = get_page_by_title('News');
    if (!$blog_page) {
        $blog_page_id = wp_insert_post(array(
            'post_title' => __('News', 'yoursite'),
            'post_content' => __('Stay updated with our latest news and insights.', 'yoursite'),
            'post_status' => 'publish',
            'post_type' => 'page'
        ));
        update_option('page_for_posts', $blog_page_id);
    }
}

/**
 * Create default posts
 */
function yoursite_create_default_posts() {
    // Check if we have any posts
    $posts = get_posts(array('numberposts' => 1));
    
    if (empty($posts)) {
        // Create sample blog posts
        $sample_posts = array(
            array(
                'post_title' => __('Welcome to Your New eCommerce Platform', 'yoursite'),
                'post_content' => __('We\'re excited to introduce you to the future of online retail. Our platform makes it easier than ever to create, manage, and grow your online store. Whether you\'re just starting out or looking to scale your existing business, we have the tools and features you need to succeed.', 'yoursite'),
                'post_excerpt' => __('Discover how our eCommerce platform can help you build and grow your online store with ease.', 'yoursite'),
                'post_status' => 'publish',
                'post_author' => 1,
                'post_category' => array(1)
            ),
            // Add more sample posts here if needed...
        );
        
        foreach ($sample_posts as $post_data) {
            wp_insert_post($post_data);
        }
    }
}

/**
 * Create demo content
 */
function yoursite_create_demo_content() {
    yoursite_create_demo_features();
    yoursite_create_demo_testimonials();
    yoursite_create_demo_pricing();
    yoursite_create_demo_webinars();
}

/**
 * Create demo features
 */
function yoursite_create_demo_features() {
    $existing_features = get_posts(array('post_type' => 'features', 'numberposts' => 1));
    
    if (empty($existing_features)) {
        $demo_features = array(
            array(
                'title' => __('Drag & Drop Store Builder', 'yoursite'),
                'content' => __('Create your perfect online store with our intuitive drag-and-drop interface. No coding required - just drag, drop, and customize to match your brand.', 'yoursite'),
                'excerpt' => __('Build your store visually with our easy-to-use drag-and-drop interface.', 'yoursite')
            ),
            array(
                'title' => __('Mobile-First Design', 'yoursite'),
                'content' => __('All our templates are mobile-responsive and optimized for every device. Your customers will have a seamless shopping experience whether they\'re on desktop, tablet, or mobile.', 'yoursite'),
                'excerpt' => __('Responsive design that looks perfect on all devices.', 'yoursite')
            ),
            array(
                'title' => __('Secure Payment Processing', 'yoursite'),
                'content' => __('Accept payments safely with our PCI-compliant payment processing. Support for all major credit cards, PayPal, Apple Pay, and more payment methods.', 'yoursite'),
                'excerpt' => __('Secure, PCI-compliant payment processing with multiple payment options.', 'yoursite')
            ),
            array(
                'title' => __('Advanced Analytics', 'yoursite'),
                'content' => __('Track your store\'s performance with detailed analytics and reporting. Monitor sales, customer behavior, traffic sources, and conversion rates all in one dashboard.', 'yoursite'),
                'excerpt' => __('Comprehensive analytics to track your store\'s performance and growth.', 'yoursite')
            ),
            array(
                'title' => __('Inventory Management', 'yoursite'),
                'content' => __('Keep track of your products with our powerful inventory management system. Set up automatic low-stock alerts, manage variants, and sync across multiple sales channels.', 'yoursite'),
                'excerpt' => __('Powerful inventory management with automatic alerts and multi-channel sync.', 'yoursite')
            ),
            array(
                'title' => __('SEO Optimization', 'yoursite'),
                'content' => __('Built-in SEO tools help your products get found on search engines. Optimize meta tags, generate sitemaps, and improve your search rankings automatically.', 'yoursite'),
                'excerpt' => __('Built-in SEO tools to help customers find your products online.', 'yoursite')
            )
        );
        
        foreach ($demo_features as $feature_data) {
            wp_insert_post(array(
                'post_title' => $feature_data['title'],
                'post_content' => $feature_data['content'],
                'post_excerpt' => $feature_data['excerpt'],
                'post_status' => 'publish',
                'post_type' => 'features'
            ));
        }
    }
}

/**
 * Create demo testimonials
 */
function yoursite_create_demo_testimonials() {
    $existing_testimonials = get_posts(array('post_type' => 'testimonials', 'numberposts' => 1));
    
    if (empty($existing_testimonials)) {
        $demo_testimonials = array(
            array(
                'title' => 'Sarah Johnson, Fashion Boutique Owner',
                'content' => __('This platform transformed my business! I went from zero to $50K in monthly sales within 6 months. The templates are beautiful and the support team is incredibly helpful.', 'yoursite')
            ),
            array(
                'title' => 'Mike Chen, Electronics Retailer',
                'content' => __('The inventory management features alone saved me 20 hours per week. I can focus on growing my business instead of managing spreadsheets. Highly recommended!', 'yoursite')
            ),
            array(
                'title' => 'Lisa Rodriguez, Handmade Crafts',
                'content' => __('As someone who\'s not tech-savvy, I was worried about building an online store. This platform made it so easy! I had my store up and running in under an hour.', 'yoursite')
            ),
            array(
                'title' => 'David Kim, Fitness Equipment',
                'content' => __('The mobile optimization is fantastic. Over 70% of my customers shop on their phones, and the checkout process is smooth and fast. My conversion rates improved significantly.', 'yoursite')
            )
        );
        
        foreach ($demo_testimonials as $testimonial_data) {
            wp_insert_post(array(
                'post_title' => $testimonial_data['title'],
                'post_content' => $testimonial_data['content'],
                'post_status' => 'publish',
                'post_type' => 'testimonials'
            ));
        }
    }
}

/**
 * Create demo pricing plans
 */
function yoursite_create_demo_pricing() {
    $existing_pricing = get_posts(array('post_type' => 'pricing', 'numberposts' => 1));
    
    if (empty($existing_pricing)) {
        $demo_pricing = array(
            array(
                'title' => __('Starter', 'yoursite'),
                'content' => __('Perfect for new businesses just getting started with online sales.', 'yoursite'),
                'meta' => array(
                    '_pricing_price' => '19',
                    '_pricing_period' => 'month',
                    '_pricing_base_currency' => 'USD',
                    '_pricing_purchase_url' => '#',
                    '_pricing_button_text' => __('Start Free Trial', 'yoursite'),
                    '_pricing_features' => "Up to 100 products\nFree SSL certificate\nEmail support\nMobile responsive themes\nBasic analytics",
                    '_pricing_featured' => '0'
                )
            ),
            array(
                'title' => __('Professional', 'yoursite'),
                'content' => __('Ideal for growing businesses that need more advanced features.', 'yoursite'),
                'meta' => array(
                    '_pricing_price' => '49',
                    '_pricing_period' => 'month',
                    '_pricing_base_currency' => 'USD',
                    '_pricing_purchase_url' => '#',
                    '_pricing_button_text' => __('Start Free Trial', 'yoursite'),
                    '_pricing_features' => "Up to 1,000 products\nFree SSL certificate\nPriority support\nAdvanced analytics\nInventory management\nDiscount codes\nAbandoned cart recovery",
                    '_pricing_featured' => '1'
                )
            ),
            array(
                'title' => __('Enterprise', 'yoursite'),
                'content' => __('For large businesses with high volume and custom requirements.', 'yoursite'),
                'meta' => array(
                    '_pricing_price' => '149',
                    '_pricing_period' => 'month',
                    '_pricing_base_currency' => 'USD',
                    '_pricing_purchase_url' => '#',
                    '_pricing_button_text' => __('Contact Sales', 'yoursite'),
                    '_pricing_features' => "Unlimited products\nDedicated SSL certificate\n24/7 phone support\nAdvanced reporting\nMulti-channel selling\nAPI access\nCustom integrations\nDedicated account manager",
                    '_pricing_featured' => '0'
                )
            )
        );
        
        foreach ($demo_pricing as $plan_data) {
            $post_id = wp_insert_post(array(
                'post_title' => $plan_data['title'],
                'post_content' => $plan_data['content'],
                'post_status' => 'publish',
                'post_type' => 'pricing'
            ));
            
            if ($post_id) {
                foreach ($plan_data['meta'] as $key => $value) {
                    update_post_meta($post_id, $key, $value);
                }
            }
        }
    }
}

/**
 * Create demo webinars
 */
function yoursite_create_demo_webinars() {
    $existing_webinars = get_posts(array('post_type' => 'webinars', 'numberposts' => 1));
    
    if (empty($existing_webinars)) {
        $demo_webinars = array(
            array(
                'title' => __('eCommerce Success Strategies for 2025', 'yoursite'),
                'content' => __('<h2>What You\'ll Learn</h2>
<p>Join us for an in-depth exploration of the latest eCommerce trends and strategies that will help your online store thrive in 2025.</p>

<h3>Key Topics:</h3>
<ul>
<li>Mobile-first shopping experiences</li>
<li>AI-powered personalization</li>
<li>Conversion rate optimization</li>
<li>Customer retention strategies</li>
<li>Marketing automation tactics</li>
</ul>

<h3>Who Should Attend:</h3>
<ul>
<li>eCommerce store owners</li>
<li>Digital marketing managers</li>
<li>Online business consultants</li>
<li>Anyone looking to grow their online sales</li>
</ul>

<p>This comprehensive session includes live Q&A, downloadable resources, and actionable takeaways you can implement immediately.</p>', 'yoursite'),
                'excerpt' => __('Learn the latest trends and strategies that will help your online store thrive in 2025.', 'yoursite'),
                'meta' => array(
                    '_webinar_date' => date('Y-m-d', strtotime('+7 days')),
                    '_webinar_time' => '2:00 PM',
                    '_webinar_timezone' => 'EST',
                    '_webinar_duration' => '60 minutes',
                    '_webinar_speaker' => __('Sarah Johnson, eCommerce Expert', 'yoursite'),
                    '_webinar_speaker_bio' => __('Sarah has helped over 500 online stores increase their revenue by an average of 147%. She\'s the founder of eCommerce Growth Academy.', 'yoursite'),
                    '_webinar_register_url' => '#register',
                    '_webinar_price' => __('Free', 'yoursite'),
                    '_webinar_max_attendees' => '500',
                    '_webinar_status' => 'upcoming',
                    '_webinar_platform' => 'zoom'
                )
            ),
            array(
                'title' => __('Digital Marketing That Actually Works', 'yoursite'),
                'content' => __('<h2>Stop Wasting Money on Marketing</h2>
<p>Learn data-driven strategies that generate real ROI and sustainable growth for your business.</p>

<h3>What We\'ll Cover:</h3>
<ul>
<li>ROI-focused marketing strategies</li>
<li>Social media advertising that converts</li>
<li>Email marketing automation</li>
<li>Content marketing that drives sales</li>
<li>Analytics and performance tracking</li>
</ul>

<p>This 90-minute masterclass includes real case studies, live examples, and a comprehensive Q&A session.</p>', 'yoursite'),
                'excerpt' => __('Learn data-driven strategies that generate real ROI and sustainable growth.', 'yoursite'),
                'meta' => array(
                    '_webinar_date' => date('Y-m-d', strtotime('+14 days')),
                    '_webinar_time' => '3:00 PM',
                    '_webinar_timezone' => 'EST',
                    '_webinar_duration' => '90 minutes',
                    '_webinar_speaker' => __('Mike Chen, Growth Strategist', 'yoursite'),
                    '_webinar_speaker_bio' => __('Mike is a digital marketing strategist who has generated over $50M in revenue for his clients.', 'yoursite'),
                    '_webinar_register_url' => '#register',
                    '_webinar_price' => __('Free', 'yoursite'),
                    '_webinar_max_attendees' => '300',
                    '_webinar_status' => 'upcoming',
                    '_webinar_platform' => 'zoom'
                )
            )
        );
        
        foreach ($demo_webinars as $webinar_data) {
            $post_id = wp_insert_post(array(
                'post_title' => $webinar_data['title'],
                'post_content' => $webinar_data['content'],
                'post_excerpt' => $webinar_data['excerpt'],
                'post_status' => 'publish',
                'post_type' => 'webinars'
            ));
            
            if ($post_id) {
                foreach ($webinar_data['meta'] as $key => $value) {
                    update_post_meta($post_id, $key, $value);
                }
            }
        }
    }
}

/**
 * Clean up WordPress default content
 */
function yoursite_remove_default_posts() {
    // Remove default post
    $default_post = get_post(1);
    if ($default_post && $default_post->post_title === 'Hello world!') {
        wp_delete_post(1, true);
    }
    
    // Remove default page
    $default_page = get_page_by_title('Sample Page');
    if ($default_page) {
        wp_delete_post($default_page->ID, true);
    }
}

/**
 * Create template-parts directory and files
 */
function yoursite_create_template_parts() {
    $template_parts_dir = get_template_directory() . '/template-parts';
    
    if (!file_exists($template_parts_dir)) {
        wp_mkdir_p($template_parts_dir);
    }
    
    $homepage_template = $template_parts_dir . '/homepage.php';
    
    if (!file_exists($homepage_template)) {
        $homepage_content = '<?php
/**
 * Template part for displaying homepage content
 */
?>
<section class="hero-gradient text-white py-20 lg:py-32">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                <?php echo get_theme_mod("hero_title", __("Build Your Online Store in Minutes", "yoursite")); ?>
            </h1>
            <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-3xl mx-auto">
                <?php echo get_theme_mod("hero_subtitle", __("No code. No hassle. Just launch and sell.", "yoursite")); ?>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="<?php echo get_theme_mod("cta_primary_url", "#"); ?>" class="btn-primary text-lg px-8 py-4 rounded-lg font-semibold hover-lift">
                    <?php echo get_theme_mod("cta_primary_text", __("Start Free Trial", "yoursite")); ?>
                </a>
                <a href="<?php echo get_theme_mod("cta_secondary_url", "#demo"); ?>" class="btn-secondary text-lg px-8 py-4 rounded-lg font-semibold hover-lift">
                    <?php echo get_theme_mod("cta_secondary_text", __("View Demo", "yoursite")); ?>
                </a>
            </div>
        </div>
    </div>
</section>';
        
        file_put_contents($homepage_template, $homepage_content);
    }
}
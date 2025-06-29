<?php
/**
 * Company information customizer options - UPDATED VERSION
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add comprehensive company information customizer options
 */
function yoursite_company_customizer($wp_customize) {
    
    // Company Information Section
    $wp_customize->add_section('company_info_section', array(
        'title' => __('Company Information', 'yoursite'),
        'priority' => 35,
        'panel' => 'yoursite_theme_options',
        'description' => __('Manage your company details used throughout the site', 'yoursite'),
    ));
    
    // Basic Company Information
    $wp_customize->add_setting('company_name', array(
        'default' => get_bloginfo('name'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_name', array(
        'label' => __('Company Name', 'yoursite'),
        'description' => __('Your official company name', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 10,
    ));
    
    $wp_customize->add_setting('company_tagline', array(
        'default' => __('Build Your Online Store in Minutes', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_tagline', array(
        'label' => __('Company Tagline', 'yoursite'),
        'description' => __('A brief description of what your company does', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 20,
    ));
    
    $wp_customize->add_setting('company_description', array(
        'default' => __('We help businesses create powerful online stores with our easy-to-use eCommerce platform. No coding required - just drag, drop, and sell.', 'yoursite'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_description', array(
        'label' => __('Company Description', 'yoursite'),
        'description' => __('Detailed description of your company (used in about sections)', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'textarea',
        'priority' => 30,
    ));
    
    // Contact Information
    $wp_customize->add_setting('company_email', array(
        'default' => get_option('admin_email'),
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_email', array(
        'label' => __('Company Email', 'yoursite'),
        'description' => __('Main contact email address', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'email',
        'priority' => 40,
    ));
    
    $wp_customize->add_setting('company_phone', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_phone', array(
        'label' => __('Company Phone', 'yoursite'),
        'description' => __('Main contact phone number', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'tel',
        'priority' => 50,
    ));
    
    $wp_customize->add_setting('company_address', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_address', array(
        'label' => __('Company Address', 'yoursite'),
        'description' => __('Physical business address', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'textarea',
        'priority' => 60,
    ));
    
    // Business Information
    $wp_customize->add_setting('company_founded', array(
        'default' => date('Y'),
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_founded', array(
        'label' => __('Year Founded', 'yoursite'),
        'description' => __('Year your company was established', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1900,
            'max' => date('Y'),
            'step' => 1,
        ),
        'priority' => 70,
    ));
    
    $wp_customize->add_setting('company_employees', array(
        'default' => __('50-100', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_employees', array(
        'label' => __('Number of Employees', 'yoursite'),
        'description' => __('Employee count or range (e.g., "50-100", "500+")', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 80,
    ));
    
    $wp_customize->add_setting('company_location', array(
        'default' => __('San Francisco, CA, USA', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_location', array(
        'label' => __('Company Location', 'yoursite'),
        'description' => __('Primary business location (city, state, country)', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 90,
    ));
    
    $wp_customize->add_setting('company_industry', array(
        'default' => __('E-commerce Technology & SaaS', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_industry', array(
        'label' => __('Industry', 'yoursite'),
        'description' => __('Your business industry or sector', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 100,
    ));
    
    // Mission and Vision
    $wp_customize->add_setting('company_mission', array(
        'default' => __('To empower businesses of all sizes with seamless integrations that drive growth, efficiency, and customer satisfaction in the digital economy.', 'yoursite'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_mission', array(
        'label' => __('Mission Statement', 'yoursite'),
        'description' => __('Your company\'s mission statement', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'textarea',
        'priority' => 110,
    ));
    
    $wp_customize->add_setting('company_vision', array(
        'default' => __('To be the world\'s leading platform for e-commerce integrations, connecting every business tool and service in a unified ecosystem.', 'yoursite'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_vision', array(
        'label' => __('Vision Statement', 'yoursite'),
        'description' => __('Your company\'s vision statement', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'textarea',
        'priority' => 120,
    ));
    
    // Key Statistics
    $wp_customize->add_setting('stat_users', array(
        'default' => __('100K+', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('stat_users', array(
        'label' => __('Active Users Statistic', 'yoursite'),
        'description' => __('Number of active users (e.g., "100K+", "1M+")', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 130,
    ));
    
    $wp_customize->add_setting('stat_integrations', array(
        'default' => __('50+', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('stat_integrations', array(
        'label' => __('Integrations Statistic', 'yoursite'),
        'description' => __('Number of integrations available', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 140,
    ));
    
    $wp_customize->add_setting('stat_countries', array(
        'default' => __('180+', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('stat_countries', array(
        'label' => __('Countries Served Statistic', 'yoursite'),
        'description' => __('Number of countries you serve', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 150,
    ));
    
    $wp_customize->add_setting('stat_uptime', array(
        'default' => __('99.9%', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('stat_uptime', array(
        'label' => __('Uptime Statistic', 'yoursite'),
        'description' => __('Service uptime percentage', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 160,
    ));
    
    // Support Information
    $wp_customize->add_setting('support_hours', array(
        'default' => __('24/7', 'yoursite'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('support_hours', array(
        'label' => __('Support Hours', 'yoursite'),
        'description' => __('Customer support availability', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 170,
    ));
    
    $wp_customize->add_setting('support_email', array(
        'default' => 'support@' . str_replace('www.', '', parse_url(home_url(), PHP_URL_HOST)),
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('support_email', array(
        'label' => __('Support Email', 'yoursite'),
        'description' => __('Customer support email address', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'email',
        'priority' => 180,
    ));
    
    $wp_customize->add_setting('support_phone', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('support_phone', array(
        'label' => __('Support Phone', 'yoursite'),
        'description' => __('Customer support phone number', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'tel',
        'priority' => 190,
    ));
    
    // Legal Information
    $wp_customize->add_setting('company_legal_name', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_legal_name', array(
        'label' => __('Legal Company Name', 'yoursite'),
        'description' => __('Full legal business name (for legal pages)', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 200,
    ));
    
    $wp_customize->add_setting('company_registration', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_registration', array(
        'label' => __('Business Registration Number', 'yoursite'),
        'description' => __('Company registration or tax ID number', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 210,
    ));
    
    // VAT Information
    $wp_customize->add_setting('company_vat', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('company_vat', array(
        'label' => __('VAT Number', 'yoursite'),
        'description' => __('VAT registration number (if applicable)', 'yoursite'),
        'section' => 'company_info_section',
        'type' => 'text',
        'priority' => 220,
    ));
}
add_action('customize_register', 'yoursite_company_customizer');

/**
 * Helper functions to get company information
 */

/**
 * Get company statistics array
 */
function yoursite_get_company_stats() {
    return array(
        'users' => array(
            'label' => __('Active Users', 'yoursite'),
            'value' => get_theme_mod('stat_users', '100K+'),
            'icon' => 'users'
        ),
        'integrations' => array(
            'label' => __('Integrations', 'yoursite'),
            'value' => get_theme_mod('stat_integrations', '50+'),
            'icon' => 'puzzle'
        ),
        'countries' => array(
            'label' => __('Countries Served', 'yoursite'),
            'value' => get_theme_mod('stat_countries', '180+'),
            'icon' => 'globe'
        ),
        'uptime' => array(
            'label' => __('Uptime', 'yoursite'),
            'value' => get_theme_mod('stat_uptime', '99.9%'),
            'icon' => 'shield'
        )
    );
}

/**
 * Get company contact information
 */
function yoursite_get_company_contact() {
    return array(
        'email' => get_theme_mod('company_email', get_option('admin_email')),
        'phone' => get_theme_mod('company_phone', ''),
        'address' => get_theme_mod('company_address', ''),
        'support_email' => get_theme_mod('support_email', 'support@' . str_replace('www.', '', parse_url(home_url(), PHP_URL_HOST))),
        'support_phone' => get_theme_mod('support_phone', ''),
        'support_hours' => get_theme_mod('support_hours', '24/7')
    );
}

/**
 * Get company profile information
 */
function yoursite_get_company_profile() {
    return array(
        'name' => get_theme_mod('company_name', get_bloginfo('name')),
        'tagline' => get_theme_mod('company_tagline', 'Build Your Online Store in Minutes'),
        'description' => get_theme_mod('company_description', 'We help businesses create powerful online stores with our easy-to-use eCommerce platform.'),
        'founded' => get_theme_mod('company_founded', date('Y')),
        'employees' => get_theme_mod('company_employees', '50-100'),
        'location' => get_theme_mod('company_location', 'San Francisco, CA, USA'),
        'industry' => get_theme_mod('company_industry', 'E-commerce Technology & SaaS'),
        'mission' => get_theme_mod('company_mission', 'To empower businesses of all sizes with seamless integrations that drive growth, efficiency, and customer satisfaction in the digital economy.'),
        'vision' => get_theme_mod('company_vision', 'To be the world\'s leading platform for e-commerce integrations, connecting every business tool and service in a unified ecosystem.')
    );
}

/**
 * Get company legal information
 */
function yoursite_get_company_legal() {
    return array(
        'legal_name' => get_theme_mod('company_legal_name', get_theme_mod('company_name', get_bloginfo('name'))),
        'registration' => get_theme_mod('company_registration', ''),
        'vat' => get_theme_mod('company_vat', '')
    );
}

/**
 * Render company statistics
 */
function yoursite_render_company_stats($wrapper_class = 'grid grid-cols-2 lg:grid-cols-4 gap-8') {
    $stats = yoursite_get_company_stats();
    
    if (empty($stats)) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($wrapper_class); ?>">
        <?php foreach ($stats as $stat_key => $stat) : ?>
            <div class="text-center">
                <div class="text-3xl lg:text-4xl font-bold text-primary mb-2">
                    <?php echo esc_html($stat['value']); ?>
                </div>
                <div class="text-gray-600 font-medium">
                    <?php echo esc_html($stat['label']); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Helper function to display company information in structured data format
 */
function yoursite_output_company_schema() {
    $company = yoursite_get_company_profile();
    $contact = yoursite_get_company_contact();
    
    $schema = array(
        "@context" => "https://schema.org",
        "@type" => "Organization",
        "name" => $company['name'],
        "description" => $company['description'],
        "url" => home_url(),
        "foundingDate" => $company['founded'],
        "industry" => $company['industry'],
        "address" => array(
            "@type" => "PostalAddress",
            "addressLocality" => $company['location']
        )
    );
    
    if (!empty($contact['email'])) {
        $schema['email'] = $contact['email'];
    }
    
    if (!empty($contact['phone'])) {
        $schema['telephone'] = $contact['phone'];
    }
    
    // Add logo if custom logo is set
    if (has_custom_logo()) {
        $logo_id = get_theme_mod('custom_logo');
        $logo_data = wp_get_attachment_image_src($logo_id, 'full');
        if ($logo_data) {
            $schema['logo'] = $logo_data[0];
        }
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
}
add_action('wp_head', 'yoursite_output_company_schema');
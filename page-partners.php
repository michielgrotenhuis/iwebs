<?php
/**
 * Template Name: Partners Page - FIXED VERSION
 * Fixes: Dark mode hero text contrast, FAQ section, missing customizer content
 */

get_header(); 

// Handle form submission
if (isset($_POST['submit_partner_application'])) {
    $partner_data = array(
        'post_title' => sanitize_text_field($_POST['partner_company']) . ' - ' . sanitize_text_field($_POST['partner_name']),
        'post_type' => 'partner_applications',
        'post_status' => 'publish'
    );
    
    $partner_id = wp_insert_post($partner_data);
    
    if ($partner_id && !is_wp_error($partner_id)) {
        // Save meta fields
        update_post_meta($partner_id, '_partner_name', sanitize_text_field($_POST['partner_name']));
        update_post_meta($partner_id, '_partner_email', sanitize_email($_POST['partner_email']));
        update_post_meta($partner_id, '_partner_phone', sanitize_text_field($_POST['partner_phone']));
        update_post_meta($partner_id, '_partner_company', sanitize_text_field($_POST['partner_company']));
        update_post_meta($partner_id, '_partner_website', esc_url_raw($_POST['partner_website']));
        update_post_meta($partner_id, '_partner_type', sanitize_text_field($_POST['partner_type']));
        update_post_meta($partner_id, '_partner_experience', sanitize_text_field($_POST['partner_experience']));
        update_post_meta($partner_id, '_partner_clients', intval($_POST['partner_clients']));
        update_post_meta($partner_id, '_partner_revenue', sanitize_text_field($_POST['partner_revenue']));
        update_post_meta($partner_id, '_partner_message', sanitize_textarea_field($_POST['partner_message']));
        update_post_meta($partner_id, '_partner_status', 'pending');
        
        $form_submitted = true;
        
        // Send notification email
        $admin_email = get_option('admin_email');
        $subject = 'New Partner Application: ' . $_POST['partner_company'];
        $message = "A new partner application has been submitted.\n\n";
        $message .= "Company: " . $_POST['partner_company'] . "\n";
        $message .= "Contact: " . $_POST['partner_name'] . "\n";
        $message .= "Email: " . $_POST['partner_email'] . "\n\n";
        $message .= "Review the application in your WordPress admin.";
        
        wp_mail($admin_email, $subject, $message);
    }
}
?>

<?php if (get_theme_mod('partners_hero_enable', true)) : ?>
<!-- Hero Section - FIXED WITH PROPER DARK MODE CONTRAST -->
<section class="partners-hero-section bg-gradient-to-br from-green-50 to-blue-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="partners-hero-title text-4xl lg:text-6xl font-bold mb-6">
                <?php echo esc_html(get_theme_mod('partners_hero_title', __('Become a Partner', 'yoursite'))); ?>
            </h1>
            <p class="partners-hero-subtitle text-xl mb-8 max-w-3xl mx-auto">
                <?php echo esc_html(get_theme_mod('partners_hero_subtitle', __('Join our global network of resellers, agencies, and consultants. Help businesses grow while building your own success with our comprehensive partner program.', 'yoursite'))); ?>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-green-600"><?php echo esc_html(get_theme_mod('partners_hero_stat1_number', __('500+', 'yoursite'))); ?></div>
                    <div class="text-sm text-gray-600"><?php echo esc_html(get_theme_mod('partners_hero_stat1_label', __('Active Partners', 'yoursite'))); ?></div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-blue-600"><?php echo esc_html(get_theme_mod('partners_hero_stat2_number', __('40%', 'yoursite'))); ?></div>
                    <div class="text-sm text-gray-600"><?php echo esc_html(get_theme_mod('partners_hero_stat2_label', __('Commission Rate', 'yoursite'))); ?></div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-purple-600"><?php echo esc_html(get_theme_mod('partners_hero_stat3_number', __('24/7', 'yoursite'))); ?></div>
                    <div class="text-sm text-gray-600"><?php echo esc_html(get_theme_mod('partners_hero_stat3_label', __('Partner Support', 'yoursite'))); ?></div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#apply" class="btn-primary text-lg px-8 py-4 rounded-lg font-semibold hover-lift">
                    <?php _e('Apply Now', 'yoursite'); ?>
                </a>
                <a href="#benefits" class="btn-secondary text-lg px-8 py-4 rounded-lg font-semibold hover-lift">
                    <?php _e('Learn More', 'yoursite'); ?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('partners_types_enable', true)) : ?>
<!-- Partner Types -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <?php echo esc_html(get_theme_mod('partners_types_title', __('Partnership Opportunities', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600">
                    <?php echo esc_html(get_theme_mod('partners_types_subtitle', __('Choose the partnership model that fits your business', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php 
                $icons = array(
                    'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 
                    'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1', 
                    'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 
                    'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'
                );
                $colors = array('blue', 'green', 'purple', 'orange');
                $type_names = array('Reseller', 'Affiliate', 'Agency', 'Technology');
                $type_descriptions = array(
                    'Sell our solutions directly to your clients with full white-label support and competitive margins.',
                    'Refer customers and earn commissions on every successful conversion through your unique link.',
                    'Integrate our platform into your agency services with dedicated support and resources.',
                    'Build integrations and complementary solutions that extend our platform\'s capabilities.'
                );
                $type_features = array(
                    array('Up to 40% commission', 'White-label options', 'Marketing materials', 'Training & certification'),
                    array('25% recurring commission', 'Real-time tracking', 'Monthly payouts', 'Performance bonuses'),
                    array('Custom pricing tiers', 'Dedicated account manager', 'API access & tools', 'Co-marketing opportunities'),
                    array('Revenue sharing', 'Technical support', 'Joint go-to-market', 'Featured listings')
                );
                
                for ($i = 1; $i <= 4; $i++) : 
                    if (get_theme_mod("partners_type_{$i}_enable", true)) :
                        $title = get_theme_mod("partners_type_{$i}_title", $type_names[$i-1]);
                        $description = get_theme_mod("partners_type_{$i}_description", $type_descriptions[$i-1]);
                        $features = get_theme_mod("partners_type_{$i}_features", implode("\n", $type_features[$i-1]));
                ?>
                    <div class="text-center p-6 rounded-xl border-2 border-gray-200 hover:border-<?php echo $colors[$i-1]; ?>-500 transition-all hover:shadow-lg">
                        <div class="w-16 h-16 bg-<?php echo $colors[$i-1]; ?>-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-<?php echo $colors[$i-1]; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $icons[$i-1]; ?>"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">
                            <?php echo esc_html($title); ?>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            <?php echo esc_html($description); ?>
                        </p>
                        <ul class="text-sm text-gray-600 text-left space-y-1">
                            <?php 
                            if ($features) {
                                $feature_lines = explode("\n", $features);
                                foreach ($feature_lines as $feature) {
                                    if (trim($feature)) {
                                        echo '<li>• ' . esc_html(trim($feature)) . '</li>';
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                <?php 
                    endif;
                endfor; 
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('partners_benefits_enable', true)) : ?>
<!-- Benefits Section -->
<section class="py-20 bg-gray-50" id="benefits">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <?php echo esc_html(get_theme_mod('partners_benefits_title', __('Partner Benefits', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600">
                    <?php echo esc_html(get_theme_mod('partners_benefits_subtitle', __('Everything you need to succeed with our platform', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                $benefit_icons = array(
                    'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                    'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z',
                    'M13 10V3L4 14h7v7l9-11h-7z',
                    'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                    'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'
                );
                $benefit_colors = array('blue', 'green', 'purple', 'yellow', 'red', 'indigo');
                $benefit_titles = array(
                    'Competitive Commissions',
                    'Training & Certification', 
                    'Marketing Support',
                    'Technical Resources',
                    'Dedicated Support',
                    'Performance Tracking'
                );
                $benefit_descriptions = array(
                    'Earn up to 40% commission on all sales with transparent tracking and monthly payouts.',
                    'Comprehensive onboarding program with ongoing training and official certification.',
                    'Access to marketing materials, co-branded content, and campaign support.',
                    'Developer tools, API documentation, and technical support for implementations.',
                    'Personal account manager and priority support for you and your clients.',
                    'Real-time dashboard to track sales, commissions, and customer metrics.'
                );
                
                for ($i = 1; $i <= 6; $i++) : 
                    if (get_theme_mod("partners_benefit_{$i}_enable", true)) :
                        $title = get_theme_mod("partners_benefit_{$i}_title", $benefit_titles[$i-1]);
                        $description = get_theme_mod("partners_benefit_{$i}_description", $benefit_descriptions[$i-1]);
                ?>
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <div class="w-12 h-12 bg-<?php echo $benefit_colors[$i-1]; ?>-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-<?php echo $benefit_colors[$i-1]; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $benefit_icons[$i-1]; ?>"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-3">
                            <?php echo esc_html($title); ?>
                        </h3>
                        <p class="text-gray-600">
                            <?php echo esc_html($description); ?>
                        </p>
                    </div>
                <?php 
                    endif;
                endfor; 
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('partners_stories_enable', true)) : ?>
<!-- Success Stories -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <?php echo esc_html(get_theme_mod('partners_stories_title', __('Partner Success Stories', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600">
                    <?php echo esc_html(get_theme_mod('partners_stories_subtitle', __('See how our partners are growing their businesses', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <?php 
                $story_colors = array('blue', 'purple', 'green');
                $story_companies = array('TechWave Solutions', 'Digital Apex', 'E-Commerce Experts');
                $story_types = array('Reseller Partner', 'Agency Partner', 'Affiliate Partner');
                $story_quotes = array(
                    'Partnering with this platform increased our revenue by 300% in the first year. The support team is incredible and the commission structure is very competitive.',
                    'The white-label solutions allow us to offer enterprise-grade integrations under our own brand. Our clients love the seamless experience.',
                    'Started as an affiliate and now earning consistent monthly commissions. The tracking is transparent and payouts are always on time.'
                );
                $story_metrics = array('$2.5M+', '150+', '$50K+');
                $story_metric_labels = array('Annual Revenue Generated', 'Successful Implementations', 'Monthly Commission');
                
                for ($i = 1; $i <= 3; $i++) : 
                    if (get_theme_mod("partners_story_{$i}_enable", true)) :
                        $company = get_theme_mod("partners_story_{$i}_company", $story_companies[$i-1]);
                        $type = get_theme_mod("partners_story_{$i}_type", $story_types[$i-1]);
                        $quote = get_theme_mod("partners_story_{$i}_quote", $story_quotes[$i-1]);
                        $metric = get_theme_mod("partners_story_{$i}_metric", $story_metrics[$i-1]);
                        $metric_label = get_theme_mod("partners_story_{$i}_metric_label", $story_metric_labels[$i-1]);
                        
                        $initials = '';
                        if ($company) {
                            $words = explode(' ', $company);
                            $initials = substr($words[0], 0, 1);
                            if (isset($words[1])) {
                                $initials .= substr($words[1], 0, 1);
                            }
                        }
                ?>
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-<?php echo $story_colors[$i-1]; ?>-600 rounded-full flex items-center justify-content text-white font-bold mr-4">
                                <?php echo esc_html($initials); ?>
                            </div>
                            <div>
                                <h4 class="font-semibold">
                                    <?php echo esc_html($company); ?>
                                </h4>
                                <p class="text-sm text-gray-600">
                                    <?php echo esc_html($type); ?>
                                </p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">
                            "<?php echo esc_html($quote); ?>"
                        </p>
                        <div class="text-2xl font-bold text-green-600">
                            <?php echo esc_html($metric); ?>
                        </div>
                        <div class="text-sm text-gray-600">
                            <?php echo esc_html($metric_label); ?>
                        </div>
                    </div>
                <?php 
                    endif;
                endfor; 
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('partners_form_enable', true)) : ?>
<!-- Application Form -->
<section class="py-20 bg-gray-50" id="apply">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <?php if (isset($form_submitted) && $form_submitted) : ?>
                <!-- Success Message -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Application Submitted Successfully!</h3>
                    <p class="text-gray-600 mb-6">Thank you for your interest in becoming a partner. We'll review your application and get back to you within 3-5 business days.</p>
                    <a href="/partners" class="btn-primary px-6 py-3 rounded-lg font-semibold">Submit Another Application</a>
                </div>
            <?php else : ?>
                <!-- Application Form -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        <?php echo esc_html(get_theme_mod('partners_form_title', __('Apply to Become a Partner', 'yoursite'))); ?>
                    </h2>
                    <p class="text-xl text-gray-600">
                        <?php echo esc_html(get_theme_mod('partners_form_subtitle', __('Fill out the form below and we\'ll get back to you within 3-5 business days', 'yoursite'))); ?>
                    </p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <form method="POST" action="#apply" class="space-y-6">
                        <!-- Contact Information -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="partner_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                    <input type="text" id="partner_name" name="partner_name" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="partner_email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                    <input type="email" id="partner_email" name="partner_email" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="partner_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" id="partner_phone" name="partner_phone" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="partner_company" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                                    <input type="text" id="partner_company" name="partner_company" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div class="mt-6">
                                <label for="partner_website" class="block text-sm font-medium text-gray-700 mb-2">Company Website</label>
                                <input type="url" id="partner_website" name="partner_website" placeholder="https://" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <!-- Business Information -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Business Information</h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="partner_type" class="block text-sm font-medium text-gray-700 mb-2">Partner Type *</label>
                                    <select id="partner_type" name="partner_type" required 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Partner Type</option>
                                        <option value="reseller">Reseller</option>
                                        <option value="affiliate">Affiliate</option>
                                        <option value="agency">Agency</option>
                                        <option value="consultant">Consultant</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="partner_experience" class="block text-sm font-medium text-gray-700 mb-2">Years of Experience *</label>
                                    <select id="partner_experience" name="partner_experience" required 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Experience</option>
                                        <option value="0-1">0-1 years</option>
                                        <option value="2-5">2-5 years</option>
                                        <option value="6-10">6-10 years</option>
                                        <option value="10+">10+ years</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="partner_clients" class="block text-sm font-medium text-gray-700 mb-2">Number of Current Clients</label>
                                    <input type="number" id="partner_clients" name="partner_clients" min="0" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="partner_revenue" class="block text-sm font-medium text-gray-700 mb-2">Annual Revenue Range</label>
                                    <select id="partner_revenue" name="partner_revenue" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Revenue Range</option>
                                        <option value="0-50k">$0 - $50k</option>
                                        <option value="50k-100k">$50k - $100k</option>
                                        <option value="100k-500k">$100k - $500k</option>
                                        <option value="500k+">$500k+</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Message -->
                        <div>
                            <label for="partner_message" class="block text-sm font-medium text-gray-700 mb-2">Tell us about your business and why you'd like to partner with us</label>
                            <textarea id="partner_message" name="partner_message" rows="5" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                      placeholder="Describe your business, your experience with e-commerce platforms, and what you hope to achieve through our partnership..."></textarea>
                        </div>
                        
                        <!-- Terms and Submit -->
                        <div class="pt-6">
                            <div class="flex items-start mb-6">
                                <input type="checkbox" id="terms" name="terms" required 
                                       class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="terms" class="ml-3 text-sm text-gray-600">
                                    I agree to the <a href="/terms" class="text-blue-600 hover:underline">Terms of Service</a> and 
                                    <a href="/privacy" class="text-blue-600 hover:underline">Privacy Policy</a>
                                </label>
                            </div>
                            
                            <button type="submit" name="submit_partner_application" 
                                    class="w-full bg-blue-600 text-white py-4 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                Submit Partner Application
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('partners_faq_enable', true)) : ?>
<!-- FAQ Section - FIXED AND ADDED -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <?php echo esc_html(get_theme_mod('partners_faq_title', __('Frequently Asked Questions', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600">
                    <?php echo esc_html(get_theme_mod('partners_faq_subtitle', __('Get answers to common partner program questions', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="space-y-6">
                <?php 
                // Default FAQ data in case customizer hasn't been set
                $default_faqs = array(
                    array(
                        'question' => 'How long does the application process take?',
                        'answer' => 'We typically review applications within 3-5 business days. If approved, you\'ll receive onboarding materials and access to our partner portal immediately.'
                    ),
                    array(
                        'question' => 'What are the commission rates?',
                        'answer' => 'Commission rates vary by partner type: Affiliates earn 25% recurring, Resellers up to 40%, and custom rates are available for Agencies and Technology partners.'
                    ),
                    array(
                        'question' => 'Is there a minimum sales requirement?',
                        'answer' => 'There\'s no minimum sales requirement to maintain your partner status. However, active partners who consistently drive sales receive additional benefits and higher commission tiers.'
                    ),
                    array(
                        'question' => 'What marketing materials do you provide?',
                        'answer' => 'We provide logos, brochures, case studies, demo videos, email templates, and co-branded materials. Custom materials can be created for qualified partners.'
                    ),
                    array(
                        'question' => 'Can I offer white-label solutions?',
                        'answer' => 'Yes! Reseller and Agency partners can access white-label options to offer our solutions under their own brand with full customization support.'
                    )
                );
                
                for ($i = 1; $i <= 5; $i++) : 
                    if (get_theme_mod("partners_faq_{$i}_enable", true)) :
                        $question = get_theme_mod("partners_faq_{$i}_question", $default_faqs[$i-1]['question']);
                        $answer = get_theme_mod("partners_faq_{$i}_answer", $default_faqs[$i-1]['answer']);
                        if ($question && $answer) :
                ?>
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <button class="faq-toggle w-full text-left p-6 focus:outline-none focus:bg-gray-100 transition-colors" 
                                onclick="toggleFAQ(<?php echo $i; ?>)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900 pr-8">
                                    <?php echo esc_html($question); ?>
                                </h3>
                                <svg class="faq-icon w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div id="faq-answer-<?php echo $i; ?>" class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo esc_html($answer); ?>
                            </p>
                        </div>
                    </div>
                <?php 
                        endif;
                    endif;
                endfor; 
                ?>
            </div>
            
            <!-- Contact CTA -->
            <div class="text-center mt-12 p-8 bg-blue-50 rounded-xl">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Still have questions?</h3>
                <p class="text-gray-600 mb-6">Our partner team is here to help you succeed. Get in touch for personalized support.</p>
                <a href="/contact" class="btn-primary px-6 py-3 rounded-lg font-semibold">Contact Partner Team</a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Additional CSS for dark mode fixes and FAQ functionality -->
<style>
/* DARK MODE HERO SECTION FIXES */
.partners-hero-section {
    position: relative;
}

/* Light mode - default */
.partners-hero-title {
    color: #111827 !important;
}

.partners-hero-subtitle {
    color: #4b5563 !important;
}

/* Dark mode fixes for hero section */
body.dark-mode .partners-hero-section {
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%) !important;
}

body.dark-mode .partners-hero-title {
    color: #f9fafb !important;
}

body.dark-mode .partners-hero-subtitle {
    color: #e5e7eb !important;
}

/* Ensure stat cards remain readable in dark mode */
body.dark-mode .partners-hero-section .bg-white\/80 {
    background-color: rgba(31, 41, 55, 0.9) !important;
    backdrop-filter: blur(10px) !important;
}

body.dark-mode .partners-hero-section .text-gray-600 {
    color: #d1d5db !important;
}

/* FAQ Interactive Styles */
.faq-toggle:hover {
    background-color: #f3f4f6;
}

.faq-toggle.active .faq-icon {
    transform: rotate(180deg);
}

.faq-answer {
    transition: all 0.3s ease;
}

.faq-answer.show {
    display: block !important;
}

/* Dark mode FAQ styles */
body.dark-mode .faq-toggle {
    background-color: var(--bg-tertiary) !important;
}

body.dark-mode .faq-toggle:hover {
    background-color: var(--bg-secondary) !important;
}

body.dark-mode .faq-toggle h3 {
    color: var(--text-primary) !important;
}

body.dark-mode .faq-answer p {
    color: var(--text-secondary) !important;
}

/* Button fixes for dark mode */
body.dark-mode .btn-secondary {
    background-color: var(--bg-secondary) !important;
    border-color: var(--border-secondary) !important;
    color: var(--text-primary) !important;
}

body.dark-mode .btn-secondary:hover {
    border-color: #667eea !important;
    color: #667eea !important;
}

/* Partner type cards dark mode */
body.dark-mode .partner-type-card {
    background-color: var(--bg-secondary) !important;
    border-color: var(--border-primary) !important;
}

body.dark-mode .partner-type-card h3 {
    color: var(--text-primary) !important;
}

body.dark-mode .partner-type-card p {
    color: var(--text-secondary) !important;
}
</style>

<!-- FAQ JavaScript -->
<script>
function toggleFAQ(index) {
    const answer = document.getElementById('faq-answer-' + index);
    const button = answer.previousElementSibling;
    const icon = button.querySelector('.faq-icon');
    
    // Close all other FAQs
    const allAnswers = document.querySelectorAll('.faq-answer');
    const allButtons = document.querySelectorAll('.faq-toggle');
    const allIcons = document.querySelectorAll('.faq-icon');
    
    allAnswers.forEach((item, i) => {
        if (i !== index - 1) {
            item.classList.add('hidden');
            item.classList.remove('show');
        }
    });
    
    allButtons.forEach((item, i) => {
        if (i !== index - 1) {
            item.classList.remove('active');
        }
    });
    
    allIcons.forEach((item, i) => {
        if (i !== index - 1) {
            item.style.transform = 'rotate(0deg)';
        }
    });
    
    // Toggle current FAQ
    if (answer.classList.contains('hidden')) {
        answer.classList.remove('hidden');
        answer.classList.add('show');
        button.classList.add('active');
        icon.style.transform = 'rotate(180deg)';
    } else {
        answer.classList.add('hidden');
        answer.classList.remove('show');
        button.classList.remove('active');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Close FAQ when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.faq-toggle') && !event.target.closest('.faq-answer')) {
        const allAnswers = document.querySelectorAll('.faq-answer');
        const allButtons = document.querySelectorAll('.faq-toggle');
        const allIcons = document.querySelectorAll('.faq-icon');
        
        allAnswers.forEach(item => {
            item.classList.add('hidden');
            item.classList.remove('show');
        });
        
        allButtons.forEach(item => {
            item.classList.remove('active');
        });
        
        allIcons.forEach(item => {
            item.style.transform = 'rotate(0deg)';
        });
    }
});
</script>

<?php get_footer(); ?>
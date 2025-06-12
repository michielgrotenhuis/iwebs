<?php
/**
 * Template Name: Partners Page
 * Updated version with Customizer integration
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
<!-- Hero Section -->
<section class="bg-gradient-to-br from-green-50 to-blue-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                <?php echo esc_html(get_theme_mod('partners_hero_title', __('Become a Partner', 'yoursite'))); ?>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
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
                $icons = array('M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1', 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4');
                $colors = array('blue', 'green', 'purple', 'orange');
                
                for ($i = 1; $i <= 4; $i++) : 
                    if (get_theme_mod("partners_type_{$i}_enable", true)) :
                ?>
                    <div class="text-center p-6 rounded-xl border-2 border-gray-200 hover:border-<?php echo $colors[$i-1]; ?>-500 transition-all hover:shadow-lg">
                        <div class="w-16 h-16 bg-<?php echo $colors[$i-1]; ?>-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-<?php echo $colors[$i-1]; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $icons[$i-1]; ?>"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">
                            <?php echo esc_html(get_theme_mod("partners_type_{$i}_title", '')); ?>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            <?php echo esc_html(get_theme_mod("partners_type_{$i}_description", '')); ?>
                        </p>
                        <ul class="text-sm text-gray-600 text-left space-y-1">
                            <?php 
                            $features = get_theme_mod("partners_type_{$i}_features", '');
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
<section class="py-20 bg-gray-50">
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
                
                for ($i = 1; $i <= 6; $i++) : 
                    if (get_theme_mod("partners_benefit_{$i}_enable", true)) :
                ?>
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <div class="w-12 h-12 bg-<?php echo $benefit_colors[$i-1]; ?>-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-<?php echo $benefit_colors[$i-1]; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $benefit_icons[$i-1]; ?>"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-3">
                            <?php echo esc_html(get_theme_mod("partners_benefit_{$i}_title", '')); ?>
                        </h3>
                        <p class="text-gray-600">
                            <?php echo esc_html(get_theme_mod("partners_benefit_{$i}_description", '')); ?>
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
                
                for ($i = 1; $i <= 3; $i++) : 
                    if (get_theme_mod("partners_story_{$i}_enable", true)) :
                        $company = get_theme_mod("partners_story_{$i}_company", '');
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
                            <div class="w-12 h-12 bg-<?php echo $story_colors[$i-1]; ?>-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                                <?php echo esc_html($initials); ?>
                            </div>
                            <div>
                                <h4 class="font-semibold">
                                    <?php echo esc_html(get_theme_mod("partners_story_{$i}_company", '')); ?>
                                </h4>
                                <p class="text-sm text-gray-600">
                                    <?php echo esc_html(get_theme_mod("partners_story_{$i}_type", '')); ?>
                                </p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">
                            "<?php echo esc_html(get_theme_mod("partners_story_{$i}_quote", '')); ?>"
                        </p>
                        <div class="text-2xl font-bold text-green-600">
                            <?php echo esc_html(get_theme_mod("partners_story_{$i}_metric", '')); ?>
                        </div>
                        <div class="text-sm text-gray-600">
                            <?php echo esc_html(get_theme_mod("partners_story_{$i}_metric_label", '')); ?>
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
<!-- FAQ Section -->
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
                <?php for ($i = 1; $i <= 5; $i++) : 
                    if (get_theme_mod("partners_faq_{$i}_enable", true)) :
                        $question = get_theme_mod("partners_faq_{$i}_question", '');
                        $answer = get_theme_mod("partners_faq_{$i}_answer", '');
                        if ($question && $answer) :
                ?>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">
                            <?php echo esc_html($question); ?>
                        </h3>
                        <p class="text-gray-600">
                            <?php echo esc_html($answer); ?>
                        </p>
                    </div>
                <?php 
                        endif;
                    endif;
                endfor; 
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
.bg-gradient-to-br {
    background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
}
</style>

<?php get_footer(); ?>
<?php
/*
Template Name: Contact Page
*/

get_header(); ?>

<?php if (get_theme_mod('contact_hero_enable', true)) : ?>
<!-- Hero Section -->
<section class="py-20 bg-gray-900 dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6">
                <?php echo esc_html(get_theme_mod('contact_hero_title', __('Get in touch with us', 'yoursite'))); ?>
            </h1>
            <p class="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">
                <?php echo esc_html(get_theme_mod('contact_hero_subtitle', __('Have questions about our platform? Need help getting started? Our team is here to help you succeed.', 'yoursite'))); ?>
            </p>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('contact_options_enable', true)) : ?>
<!-- Contact Options -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                <?php 
                // Contact option icons
                $contact_icons = array(
                    1 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>',
                    2 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>',
                    3 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>',
                    4 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>'
                );
                
                for ($i = 1; $i <= 4; $i++) {
                    if (get_theme_mod("contact_option_{$i}_enable", true)) :
                        $title = get_theme_mod("contact_option_{$i}_title", '');
                        $description = get_theme_mod("contact_option_{$i}_description", '');
                        $button_text = get_theme_mod("contact_option_{$i}_button_text", '');
                        $button_url = get_theme_mod("contact_option_{$i}_button_url", '#');
                        $icon_color = get_theme_mod("contact_option_{$i}_icon_color", '#3b82f6');
                        ?>
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-lg mx-auto mb-4 flex items-center justify-center" style="background-color: <?php echo esc_attr($icon_color); ?>20;">
                                <svg class="w-8 h-8" style="color: <?php echo esc_attr($icon_color); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php echo $contact_icons[$i]; ?>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2"><?php echo esc_html($title); ?></h3>
                            <p class="text-gray-600 mb-4 dark:text-gray-300"><?php echo esc_html($description); ?></p>
                            <?php if (strpos($button_url, 'mailto:') === 0) : ?>
                                <a href="<?php echo esc_url($button_url); ?>" style="color: <?php echo esc_attr($icon_color); ?>;" class="hover:opacity-80 font-medium"><?php echo esc_html($button_text); ?></a>
                            <?php elseif (strpos($button_url, 'tel:') === 0) : ?>
                                <a href="<?php echo esc_url($button_url); ?>" style="color: <?php echo esc_attr($icon_color); ?>;" class="hover:opacity-80 font-medium"><?php echo esc_html($button_text); ?></a>
                            <?php else : ?>
                                <button onclick="window.open('<?php echo esc_url($button_url); ?>', '_blank')" style="color: <?php echo esc_attr($icon_color); ?>;" class="hover:opacity-80 font-medium"><?php echo esc_html($button_text); ?></button>
                            <?php endif; ?>
                        </div>
                        <?php
                    endif;
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('contact_form_enable', true)) : ?>
<!-- Contact Form -->
<section class="py-20" style="background-color: <?php echo esc_attr(get_theme_mod('contact_form_bg_color', '#f9fafb')); ?>;">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('contact_form_title', __('Send us a message', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('contact_form_subtitle', __('We\'d love to hear from you. Fill out the form below and we\'ll get back to you soon.', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 lg:p-12 border border-gray-200 dark:border-gray-700">
                <form class="space-y-6" id="contact-form">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name *</label>
                            <input type="text" id="first_name" name="first_name" required 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name *</label>
                            <input type="text" id="last_name" name="last_name" required 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" required 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                    </div>
                    
                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Company</label>
                        <input type="text" id="company" name="company" 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject *</label>
                        <select id="subject" name="subject" required 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="support">Technical Support</option>
                            <option value="sales">Sales Question</option>
                            <option value="partnership">Partnership Opportunity</option>
                            <option value="feedback">Product Feedback</option>
                            <option value="billing">Billing Question</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message *</label>
                        <textarea id="message" name="message" rows="6" required 
                                  placeholder="Tell us more about your inquiry..."
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"></textarea>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="newsletter" name="newsletter" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700">
                        <label for="newsletter" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            I'd like to receive updates about new features and product news
                        </label>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn-primary text-lg px-8 py-4">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('contact_faq_enable', true)) : ?>
<!-- FAQ Section -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('contact_faq_title', __('Frequently Asked Questions', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('contact_faq_subtitle', __('Quick answers to common questions', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="space-y-6">
                <?php 
                // Simply loop through all FAQ items and display enabled ones with content
                $faq_count = 0;
                
                for ($i = 1; $i <= 5; $i++) {
                    if (get_theme_mod("contact_faq_{$i}_enable", true)) {
                        $question = get_theme_mod("contact_faq_{$i}_question", '');
                        $answer = get_theme_mod("contact_faq_{$i}_answer", '');
                        
                        if (!empty($question) && !empty($answer)) {
                            $faq_count++;
                ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <button class="flex justify-between items-center w-full text-left faq-toggle">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white"><?php echo esc_html($question); ?></h3>
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden mt-4">
                        <p class="text-gray-600 dark:text-gray-300"><?php echo esc_html($answer); ?></p>
                    </div>
                </div>
                <?php 
                        }
                    }
                }
                
                // Show a message if no FAQs are configured (only for logged-in admins)
                if ($faq_count === 0 && current_user_can('manage_options')) {
                    echo '<div class="text-center p-8 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">';
                    echo '<p class="text-yellow-800 dark:text-yellow-200">No FAQ items are configured. <a href="' . admin_url('customize.php?autofocus[section]=contact_page_editor') . '" class="underline">Configure them here</a>.</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('contact_office_enable', true)) : ?>
<!-- Office Location -->
<section class="bg-gray-50 dark:bg-gray-900 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('contact_office_title', __('Visit Our Office', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('contact_office_subtitle', __('We\'d love to meet you in person', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-8 shadow-sm border border-gray-200 dark:border-gray-700">
                        <h3 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">
                            <?php echo esc_html(get_theme_mod('contact_office_name', __('San Francisco Headquarters', 'yoursite'))); ?>
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Address</p>
                                    <p class="text-gray-600 dark:text-gray-300"><?php echo wp_kses_post(get_theme_mod('contact_office_address', __('123 Market Street, Suite 456<br>San Francisco, CA 94105', 'yoursite'))); ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Office Hours</p>
                                    <p class="text-gray-600 dark:text-gray-300"><?php echo wp_kses_post(get_theme_mod('contact_office_hours', __('Monday - Friday: 9:00 AM - 6:00 PM PST<br>Weekend: By appointment only', 'yoursite'))); ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">General Inquiries</p>
                                    <p class="text-gray-600 dark:text-gray-300"><?php echo esc_html(get_theme_mod('contact_office_email', __('hello@yoursite.biz', 'yoursite'))); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                Planning a visit? We'd love to give you a tour and demo our platform. Please schedule ahead of time.
                            </p>
                            <button class="btn-secondary">Schedule a Visit</button>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-200 dark:bg-gray-700 rounded-lg h-96 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gray-400 dark:bg-gray-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">Interactive Map</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo esc_html(get_theme_mod('contact_office_name', __('San Francisco Office Location', 'yoursite'))); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact form handling
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            
            // Show loading state
            button.textContent = 'Sending...';
            button.disabled = true;
            
            // Simulate form submission (replace with actual implementation)
            setTimeout(() => {
                // Show success message
                const successMessage = document.createElement('div');
                successMessage.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4';
                successMessage.innerHTML = '<strong>Success!</strong> Your message has been sent. We\'ll get back to you soon.';
                
                this.insertBefore(successMessage, this.firstChild);
                
                // Reset form
                this.reset();
                button.textContent = originalText;
                button.disabled = false;
                
                // Remove success message after 5 seconds
                setTimeout(() => {
                    successMessage.remove();
                }, 5000);
            }, 2000);
        });
    }
    
    // FAQ toggle functionality
    const faqToggles = document.querySelectorAll('.faq-toggle');
    
    faqToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const icon = this.querySelector('svg');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        });
    });
});
</script>

<?php get_footer(); ?>
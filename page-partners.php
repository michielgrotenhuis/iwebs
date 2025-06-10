<?php
/**
 * Template Name: Partners Page
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
        
        // Send notification email (optional)
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

<!-- Hero Section -->
<section class="bg-gradient-to-br from-green-50 to-blue-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                Become a Partner
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Join our global network of resellers, agencies, and consultants. Help businesses grow while building your own success with our comprehensive partner program.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-green-600">500+</div>
                    <div class="text-sm text-gray-600">Active Partners</div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-blue-600">40%</div>
                    <div class="text-sm text-gray-600">Commission Rate</div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-purple-600">24/7</div>
                    <div class="text-sm text-gray-600">Partner Support</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partner Types -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Partnership Opportunities</h2>
                <p class="text-xl text-gray-600">Choose the partnership model that fits your business</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Reseller Partner -->
                <div class="text-center p-6 rounded-xl border-2 border-gray-200 hover:border-blue-500 transition-all hover:shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Reseller</h3>
                    <p class="text-gray-600 mb-4">Sell our solutions directly to your clients with full white-label support and competitive margins.</p>
                    <ul class="text-sm text-gray-600 text-left space-y-1">
                        <li>• Up to 40% commission</li>
                        <li>• White-label options</li>
                        <li>• Marketing materials</li>
                        <li>• Training & certification</li>
                    </ul>
                </div>
                
                <!-- Affiliate Partner -->
                <div class="text-center p-6 rounded-xl border-2 border-gray-200 hover:border-green-500 transition-all hover:shadow-lg">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Affiliate</h3>
                    <p class="text-gray-600 mb-4">Refer customers and earn commissions on every successful conversion through your unique link.</p>
                    <ul class="text-sm text-gray-600 text-left space-y-1">
                        <li>• 25% recurring commission</li>
                        <li>• Real-time tracking</li>
                        <li>• Monthly payouts</li>
                        <li>• Performance bonuses</li>
                    </ul>
                </div>
                
                <!-- Agency Partner -->
                <div class="text-center p-6 rounded-xl border-2 border-gray-200 hover:border-purple-500 transition-all hover:shadow-lg">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Agency</h3>
                    <p class="text-gray-600 mb-4">Integrate our platform into your agency services with dedicated support and resources.</p>
                    <ul class="text-sm text-gray-600 text-left space-y-1">
                        <li>• Custom pricing tiers</li>
                        <li>• Dedicated account manager</li>
                        <li>• API access & tools</li>
                        <li>• Co-marketing opportunities</li>
                    </ul>
                </div>
                
                <!-- Technology Partner -->
                <div class="text-center p-6 rounded-xl border-2 border-gray-200 hover:border-orange-500 transition-all hover:shadow-lg">
                    <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Technology</h3>
                    <p class="text-gray-600 mb-4">Build integrations and complementary solutions that extend our platform's capabilities.</p>
                    <ul class="text-sm text-gray-600 text-left space-y-1">
                        <li>• Revenue sharing</li>
                        <li>• Technical support</li>
                        <li>• Joint go-to-market</li>
                        <li>• Featured listings</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Partner Benefits</h2>
                <p class="text-xl text-gray-600">Everything you need to succeed with our platform</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Benefit 1 -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-3">Competitive Commissions</h3>
                    <p class="text-gray-600">Earn up to 40% commission on all sales with transparent tracking and monthly payouts.</p>
                </div>
                
                <!-- Benefit 2 -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-3">Training & Certification</h3>
                    <p class="text-gray-600">Comprehensive onboarding program with ongoing training and official certification.</p>
                </div>
                
                <!-- Benefit 3 -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-3">Marketing Support</h3>
                    <p class="text-gray-600">Access to marketing materials, co-branded content, and campaign support.</p>
                </div>
                
                <!-- Benefit 4 -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-3">Technical Resources</h3>
                    <p class="text-gray-600">Developer tools, API documentation, and technical support for implementations.</p>
                </div>
                
                <!-- Benefit 5 -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-3">Dedicated Support</h3>
                    <p class="text-gray-600">Personal account manager and priority support for you and your clients.</p>
                </div>
                
                <!-- Benefit 6 -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-3">Performance Tracking</h3>
                    <p class="text-gray-600">Real-time dashboard to track sales, commissions, and customer metrics.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Stories -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Partner Success Stories</h2>
                <p class="text-xl text-gray-600">See how our partners are growing their businesses</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Success Story 1 -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                            TW
                        </div>
                        <div>
                            <h4 class="font-semibold">TechWave Solutions</h4>
                            <p class="text-sm text-gray-600">Reseller Partner</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"Partnering with this platform increased our revenue by 300% in the first year. The support team is incredible and the commission structure is very competitive."</p>
                    <div class="text-2xl font-bold text-green-600">$2.5M+</div>
                    <div class="text-sm text-gray-600">Annual Revenue Generated</div>
                </div>
                
                <!-- Success Story 2 -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                            DA
                        </div>
                        <div>
                            <h4 class="font-semibold">Digital Apex</h4>
                            <p class="text-sm text-gray-600">Agency Partner</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"The white-label solutions allow us to offer enterprise-grade integrations under our own brand. Our clients love the seamless experience."</p>
                    <div class="text-2xl font-bold text-green-600">150+</div>
                    <div class="text-sm text-gray-600">Successful Implementations</div>
                </div>
                
                <!-- Success Story 3 -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                            EC
                        </div>
                        <div>
                            <h4 class="font-semibold">E-Commerce Experts</h4>
                            <p class="text-sm text-gray-600">Affiliate Partner</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"Started as an affiliate and now earning consistent monthly commissions. The tracking is transparent and payouts are always on time."</p>
                    <div class="text-2xl font-bold text-green-600">$50K+</div>
                    <div class="text-sm text-gray-600">Monthly Commission</div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Apply to Become a Partner</h2>
                    <p class="text-xl text-gray-600">Fill out the form below and we'll get back to you within 3-5 business days</p>
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

<!-- FAQ Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Get answers to common partner program questions</p>
            </div>
            
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">How long does the application process take?</h3>
                    <p class="text-gray-600">We typically review applications within 3-5 business days. If approved, you'll receive onboarding materials and access to our partner portal immediately.</p>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">What are the commission rates?</h3>
                    <p class="text-gray-600">Commission rates vary by partner type: Affiliates earn 25% recurring, Resellers up to 40%, and custom rates are available for Agencies and Technology partners.</p>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Is there a minimum sales requirement?</h3>
                    <p class="text-gray-600">There's no minimum sales requirement to maintain your partner status. However, active partners who consistently drive sales receive additional benefits and higher commission tiers.</p>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">What marketing materials do you provide?</h3>
                    <p class="text-gray-600">We provide logos, brochures, case studies, demo videos, email templates, and co-branded materials. Custom materials can be created for qualified partners.</p>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Can I offer white-label solutions?</h3>
                    <p class="text-gray-600">Yes! Reseller and Agency partners can access white-label options to offer our solutions under their own brand with full customization support.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.bg-gradient-to-br {
    background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
}
</style>

<?php get_footer(); ?>
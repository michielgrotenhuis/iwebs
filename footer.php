<?php
/**
 * The template for displaying the footer
 * Enhanced with Dynamic Currency Support for Limited Time Offer
 */

// Get current user currency
$current_currency = yoursite_get_user_currency();

// Base USD amount for the free setup offer
$base_usd_amount = 200;

// Function to convert USD to target currency with realistic rates
function convert_usd_to_currency($usd_amount, $target_currency) {
    // Exchange rates (you should ideally fetch these from an API)
    $exchange_rates = array(
        'USD' => 1.00,
        'EUR' => 0.85,
        'GBP' => 0.75,
        'CAD' => 1.25,
        'AUD' => 1.35,
        'JPY' => 110.0,
        'CHF' => 0.92,
        'SEK' => 9.50,
        'NOK' => 9.80,
        'DKK' => 6.30,
        'PLN' => 3.80,
        'CZK' => 22.0,
        'HUF' => 320.0,
        'BGN' => 1.66,
        'RON' => 4.20,
        'HRK' => 6.40,
        'RUB' => 75.0,
        'CNY' => 6.45,
        'INR' => 74.0,
        'KRW' => 1180.0,
        'SGD' => 1.35,
        'HKD' => 7.80,
        'MXN' => 20.0,
        'BRL' => 5.20,
        'ARS' => 98.0,
        'CLP' => 800.0,
        'COP' => 3800.0,
        'PEN' => 3.60,
        'UYU' => 43.0,
        'ZAR' => 14.5,
        'EGP' => 15.7,
        'NGN' => 411.0,
        'KES' => 108.0,
        'GHS' => 6.10,
        'TND' => 2.75,
        'MAD' => 9.00,
        'THB' => 33.0,
        'PHP' => 50.0,
        'VND' => 23000.0,
        'IDR' => 14300.0,
        'MYR' => 4.15,
        'ILS' => 3.25,
        'AED' => 3.67,
        'SAR' => 3.75,
        'QAR' => 3.64,
        'KWD' => 0.30,
        'BHD' => 0.38,
        'OMR' => 0.38,
        'JOD' => 0.71,
        'LBP' => 1507.0,
        'TRY' => 8.50,
        'IRR' => 42000.0,
        'PKR' => 170.0,
        'BDT' => 85.0,
        'LKR' => 200.0,
        'NPR' => 118.0,
        'BTN' => 74.0,
        'MVR' => 15.4,
        'AFN' => 80.0,
        'UZS' => 10600.0,
        'KZT' => 426.0,
        'KGS' => 84.0,
        'TJS' => 11.3,
        'TMT' => 3.50,
        'AZN' => 1.70,
        'GEL' => 3.30,
        'AMD' => 522.0,
        'BYN' => 2.60,
        'MDL' => 17.8,
        'UAH' => 27.0,
        'RSD' => 100.0,
        'MKD' => 52.0,
        'ALL' => 104.0,
        'BAM' => 1.66,
        'ISK' => 127.0,
    );
    
    $rate = isset($exchange_rates[$target_currency]) ? $exchange_rates[$target_currency] : 1.00;
    $converted_amount = $usd_amount * $rate;
    
    // Round to appropriate decimal places based on currency
    if (in_array($target_currency, ['JPY', 'KRW', 'VND', 'IDR', 'IRR', 'UZS', 'LBP', 'CLP', 'COP', 'HUF', 'CZK'])) {
        // Currencies that don't use decimal places
        return round($converted_amount);
    } elseif (in_array($target_currency, ['KWD', 'BHD', 'OMR', 'JOD'])) {
        // Currencies with 3 decimal places
        return round($converted_amount, 3);
    } else {
        // Most currencies use 2 decimal places, but round to whole numbers for offers
        return round($converted_amount);
    }
}

// Format the currency display
function format_currency_for_offer($amount, $currency_code, $currency_symbol) {
    // For certain currencies, show without decimals
    if (in_array($currency_code, ['JPY', 'KRW', 'VND', 'IDR', 'IRR', 'UZS', 'LBP', 'CLP', 'COP', 'HUF', 'CZK'])) {
        return $currency_symbol . number_format($amount, 0);
    } elseif (in_array($currency_code, ['KWD', 'BHD', 'OMR', 'JOD'])) {
        return $currency_symbol . number_format($amount, 3);
    } else {
        // For offers, always show round numbers
        return $currency_symbol . number_format($amount, 0);
    }
}

// Calculate the converted amount
$converted_amount = convert_usd_to_currency($base_usd_amount, $current_currency['code']);
$formatted_amount = format_currency_for_offer($converted_amount, $current_currency['code'], $current_currency['symbol']);
?>

</main><!-- #primary -->

    <!-- Pre-Footer CTA Section -->
   <!-- Pre-Footer CTA Section - Updated to Match Homepage -->
    <section class="final-cta-section relative py-20 bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 text-white overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/90 to-purple-600/90"></div>
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-white/5 rounded-full animate-pulse"></div>
                <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-white/5 rounded-full animate-pulse delay-1000"></div>
            </div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Trust Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium mb-6 border border-white/20">
                    <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Join 50,000+ successful merchants
                </div>
                
                <!-- Main Headline -->
                <h2 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight text-white">
                    Ready to Launch Your Dream Store?
                </h2>
                
                <!-- Subheadline -->
                <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-3xl mx-auto leading-relaxed text-white">
                    Start your 14-day free trial today. No credit card required, no setup fees, cancel anytime.
                </p>
                
                <!-- Dynamic Currency Limited Time Offer -->
                <div class="limited-time-offer bg-yellow-400 text-yellow-900 px-6 py-3 rounded-full inline-block font-bold text-lg mb-8" 
                     data-base-amount="<?php echo esc_attr($base_usd_amount); ?>"
                     data-current-currency="<?php echo esc_attr($current_currency['code']); ?>"
                     data-current-amount="<?php echo esc_attr($converted_amount); ?>">
                    🔥 <span class="offer-text">Limited Time: Free setup worth <span class="offer-amount"><?php echo esc_html($formatted_amount); ?></span></span>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                    <!-- Primary CTA -->
                    <a href="/signup" 
                       class="group inline-flex items-center justify-center px-10 py-5 bg-white text-gray-900 font-bold text-xl rounded-2xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300 min-w-[280px]">
                        <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Start Your Free Store Now
                        <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    
                    <!-- Secondary CTA -->
                    <a href="/demo" 
                       class="group inline-flex items-center justify-center px-10 py-5 bg-transparent border-2 border-white/60 hover:border-white text-white font-bold text-xl rounded-2xl hover:bg-white/10 transition-all duration-300 min-w-[280px]">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Book a Demo
                    </a>
                </div>
                
                <!-- Risk Reversal & Trust Elements -->
                <div class="flex flex-wrap justify-center items-center gap-6 text-sm opacity-90">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        14-day free trial
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        No credit card required
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        30-day money-back guarantee
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Cancel anytime
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Background Pattern -->
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
    </section>

    <footer id="colophon" class="site-footer bg-gray-900 text-gray-300">
        <!-- Main Footer Content -->
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8 mb-12">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="mb-6">
                        <?php if (has_custom_logo()) : ?>
                            <div class="footer-logo mb-4">
                                <?php
                                $custom_logo_id = get_theme_mod('custom_logo');
                                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                                if ($logo) {
                                    echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="h-8 filter brightness-0 invert">';
                                }
                                ?>
                            </div>
                        <?php else : ?>
                            <h3 class="text-2xl font-bold text-white mb-4">
                                <?php bloginfo('name'); ?>
                            </h3>
                        <?php endif; ?>
                        
                        <p class="text-gray-400 mb-6 max-w-sm">
                            <?php echo esc_html(get_theme_mod('footer_company_description', __('Build and scale your online store with confidence. Trusted by 100,000+ businesses worldwide.', 'yoursite'))); ?>
                        </p>
                        
                        <!-- Trust Badges -->
                        <?php if (get_theme_mod('show_trust_badges', true)) : ?>
                        <div class="flex flex-wrap gap-4 mb-6">
                            <!-- SOC2 Badge -->
                            <div class="trust-badge group">
                                <svg class="h-10 w-auto" viewBox="0 0 120 40" fill="none">
                                    <rect x="0.5" y="0.5" width="119" height="39" rx="3.5" fill="#1a1a1a" stroke="#333"/>
                                    <circle cx="20" cy="20" r="12" fill="#2563eb"/>
                                    <path d="M18 20l2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <text x="38" y="18" font-family="Arial, sans-serif" font-size="11" font-weight="bold" fill="#2563eb">SOC 2</text>
                                    <text x="38" y="28" font-family="Arial, sans-serif" font-size="9" fill="#666">Type II Compliant</text>
                                </svg>
                            </div>
                            
                            <!-- GDPR Badge -->
                            <div class="trust-badge group">
                                <svg class="h-10 w-auto" viewBox="0 0 120 40" fill="none">
                                    <rect x="0.5" y="0.5" width="119" height="39" rx="3.5" fill="#1a1a1a" stroke="#333"/>
                                    <g transform="translate(12, 8)">
                                        <circle cx="12" cy="12" r="11" fill="#10b981" stroke="#10b981" stroke-width="2"/>
                                        <circle cx="12" cy="12" r="8" fill="none" stroke="white" stroke-width="1.5"/>
                                        <circle cx="12" cy="12" r="5" fill="none" stroke="white" stroke-width="1.5"/>
                                        <circle cx="12" cy="12" r="2" fill="white"/>
                                    </g>
                                    <text x="38" y="18" font-family="Arial, sans-serif" font-size="11" font-weight="bold" fill="#10b981">GDPR</text>
                                    <text x="38" y="28" font-family="Arial, sans-serif" font-size="9" fill="#666">Compliant</text>
                                </svg>
                            </div>
                            
                            <!-- PCI DSS Badge -->
                            <div class="trust-badge group">
                                <svg class="h-10 w-auto" viewBox="0 0 120 40" fill="none">
                                    <rect x="0.5" y="0.5" width="119" height="39" rx="3.5" fill="#1a1a1a" stroke="#333"/>
                                    <g transform="translate(12, 10)">
                                        <rect x="0" y="0" width="20" height="20" rx="2" fill="#f59e0b"/>
                                        <path d="M10 5v10m-5-7.5v5m10-5v5" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    </g>
                                    <text x="38" y="18" font-family="Arial, sans-serif" font-size="11" font-weight="bold" fill="#f59e0b">PCI DSS</text>
                                    <text x="38" y="28" font-family="Arial, sans-serif" font-size="9" fill="#666">Level 1 Certified</text>
                                </svg>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Social Links -->
                        <?php if (get_theme_mod('show_social_links', true)) : ?>
                        <div class="flex space-x-4">
                            <?php
                            // Get social links from customizer
                            $social_platforms = array(
                                'twitter' => array('icon' => 'M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z', 'label' => 'Twitter'),
                                'linkedin' => array('icon' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z', 'label' => 'LinkedIn'),
                                'youtube' => array('icon' => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z', 'label' => 'YouTube'),
                                'instagram' => array('icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.405a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z', 'label' => 'Instagram')
                            );
                            
                            foreach ($social_platforms as $platform => $data) {
                                $url = get_theme_mod("social_{$platform}_url", '');
                                if (!empty($url)) {
                                    echo '<a href="' . esc_url($url) . '" class="social-link" aria-label="' . esc_attr($data['label']) . '" target="' . esc_attr(get_theme_mod('social_links_target', '_blank')) . '" rel="noopener noreferrer">';
                                    echo '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">';
                                    echo '<path d="' . esc_attr($data['icon']) . '"/>';
                                    echo '</svg>';
                                    echo '</a>';
                                }
                            }
                            ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Product -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Product</h4>
                    <ul class="space-y-3">
                        <li><a href="/features" class="footer-link">Features</a></li>
                        <li><a href="/pricing" class="footer-link">Pricing</a></li>
                        <li><a href="/templates" class="footer-link">Templates</a></li>
                        <li><a href="/integrations" class="footer-link">Integrations</a></li>
                        <li><a href="/build-my-website" class="footer-link">Build My Website</a></li>
                        <li><a href="/api" class="footer-link">API</a></li>
                    </ul>
                </div>

                <!-- Free Tools -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Free Tools <span class="text-xs bg-blue-500 text-white px-2 py-0.5 rounded-full ml-2">New</span></h4>
                    <ul class="space-y-3">
                        <li><a href="/tools/privacy-policy-generator" class="footer-link">Privacy Policy Generator</a></li>
                        <li><a href="/tools/product-description-generator" class="footer-link">Product Description AI</a></li>
                        <li><a href="/tools/slogan-generator" class="footer-link">Slogan Generator</a></li>
                        <li><a href="/tools" class="footer-link">All Business Tools →</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Learn</h4>
                    <ul class="space-y-3">
                        <li><a href="/blog" class="footer-link">Blog</a></li>
                        <li><a href="/guides" class="footer-link">Guides</a></li>
                        <li><a href="/webinars" class="footer-link">Webinars</a></li>
                        <li><a href="/case-studies" class="footer-link">Case Studies</a></li>
                        <li><a href="/help" class="footer-link">Help Center</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="/about" class="footer-link">About Us</a></li>
                        <li><a href="/careers" class="footer-link">Careers</a></li>
                        <li><a href="/partners" class="footer-link">Partners</a></li>
                        <li><a href="/press-kit" class="footer-link">Press Kit</a></li>
                        <li><a href="/contact" class="footer-link">Contact</a></li>
                    </ul>
                </div>
            </div>

            <!-- Newsletter Section -->
            <?php if (get_theme_mod('show_footer_newsletter', true)) : ?>
            <div class="border-t border-gray-800 pt-8 mb-8">
                <div class="max-w-2xl mx-auto text-center">
                    <h3 class="text-xl font-semibold text-white mb-3"><?php echo esc_html(get_theme_mod('newsletter_title', __('Stay in the Loop', 'yoursite'))); ?></h3>
                    <p class="text-gray-400 mb-6"><?php echo esc_html(get_theme_mod('newsletter_description', __('Get the latest updates, tips, and exclusive offers delivered to your inbox.', 'yoursite'))); ?></p>
                    
                    <form class="newsletter-form flex flex-col sm:flex-row gap-3 max-w-md mx-auto" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
                        <input type="hidden" name="action" value="newsletter_signup">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('newsletter_nonce'); ?>">
                        <input 
                            type="email" 
                            name="email"
                            placeholder="Enter your email" 
                            required
                            class="flex-1 px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        >
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-200 whitespace-nowrap"
                        >
                            Subscribe
                        </button>
                    </form>
                    <p class="text-xs text-gray-500 mt-3">
                        By subscribing, you agree to our <a href="/privacy" class="underline hover:text-gray-400">Privacy Policy</a>
                    </p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Payment Methods & Certifications -->
            <?php if (get_theme_mod('show_payment_methods', true) || get_theme_mod('show_customer_support', true)) : ?>
            <div class="border-t border-gray-800 pt-8 mb-8">
                <div class="flex flex-col md:flex-row items-center justify-center gap-8">
                    <!-- Payment Methods -->
                    <?php if (get_theme_mod('show_payment_methods', true)) : ?>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-400 text-sm">Accepted payments:</span>
                        <div class="flex gap-2">
                            <svg class="h-8 w-12 opacity-70 hover:opacity-100 transition-opacity" viewBox="0 0 48 32" fill="none">
                                <rect width="48" height="32" rx="4" fill="#1434CB"/>
                                <path d="M19.2 21.6H16.8L18.4 10.4H20.8L19.2 21.6Z" fill="white"/>
                                <path d="M27.2 10.6C26.72 10.4 25.92 10.2 24.96 10.2C22.56 10.2 20.88 11.4 20.88 13.2C20.88 14.5 22.08 15.2 23.04 15.6C24 16 24.32 16.3 24.32 16.7C24.32 17.3 23.6 17.6 22.96 17.6C21.92 17.6 21.36 17.4 20.56 17L20.24 16.8L19.92 19C20.56 19.3 21.6 19.5 22.72 19.5C25.28 19.5 26.88 18.3 26.88 16.4C26.88 15.3 26.24 14.5 24.8 13.8C23.92 13.4 23.44 13.1 23.44 12.6C23.44 12.2 23.92 11.8 24.8 11.8C25.52 11.8 26.08 11.9 26.48 12.1L26.72 12.2L27.04 10.1L27.2 10.6Z" fill="white"/>
                                <path d="M32.64 10.4H30.72C30.08 10.4 29.6 10.6 29.36 11.2L25.6 21.6H28.16L28.64 20H31.68L31.92 21.6H34.08L32.16 10.4H32.64ZM29.44 18C29.44 18 30.88 13.9 30.88 13.9L31.52 16.3C31.52 16.3 31.84 17.7 31.92 18H29.44Z" fill="white"/>
                                <path d="M14.4 10.4L12 17.3L11.76 16C11.28 14.6 9.76 13 8 12L10.08 21.6H12.64L16.96 10.4H14.4Z" fill="white"/>
                                <path d="M9.28 10.4H5.12L5.12 10.6C8.32 11.4 10.56 13.5 11.36 15.6L10.56 11.2C10.4 10.6 9.92 10.4 9.28 10.4Z" fill="#EC982D"/>
                            </svg>
                            <svg class="h-8 w-12 opacity-70 hover:opacity-100 transition-opacity" viewBox="0 0 48 32" fill="none">
                                <rect width="48" height="32" rx="4" fill="#EB001B"/>
                                <circle cx="19" cy="16" r="8" fill="#FF5F00"/>
                                <circle cx="29" cy="16" r="8" fill="#F79E1B"/>
                            </svg>
                            <svg class="h-8 w-12 opacity-70 hover:opacity-100 transition-opacity" viewBox="0 0 48 32" fill="none">
                                <rect width="48" height="32" rx="4" fill="#635BFF"/>
                                <path d="M14 12C14 10.8954 14.8954 10 16 10H20V14H16C14.8954 14 14 13.1046 14 12Z" fill="white"/>
                                <path d="M20 18H16C14.8954 18 14 19.1046 14 20C14 21.1046 14.8954 22 16 22H20V18Z" fill="white"/>
                                <rect x="20" y="10" width="14" height="12" fill="white"/>
                            </svg>
                            <svg class="h-8 w-12 opacity-70 hover:opacity-100 transition-opacity" viewBox="0 0 48 32" fill="none">
                                <rect width="48" height="32" rx="4" fill="#108043"/>
                                <path d="M20 10L16 22H20L24 10H20Z" fill="white"/>
                                <path d="M28 10L24 22H28L32 10H28Z" fill="white"/>
                            </svg>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Customer Support -->
                    <?php if (get_theme_mod('show_customer_support', true)) : ?>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="text-gray-400 text-sm"><?php echo esc_html(get_theme_mod('support_hours', '24/7')); ?> Customer Support</span>
                        <span class="text-gray-500">•</span>
                        <a href="<?php echo esc_url(get_theme_mod('support_link_url', '/contact')); ?>" class="text-blue-400 hover:text-blue-300 text-sm font-medium"><?php echo esc_html(get_theme_mod('support_link_text', __('Get Help Now', 'yoursite'))); ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                    <!-- Copyright -->
                    <div class="text-gray-400 text-sm text-center lg:text-left">
                        <?php echo wp_kses_post(get_theme_mod('footer_text', sprintf(__('© %s %s. All rights reserved.', 'yoursite'), date('Y'), get_bloginfo('name')))); ?>
                    </div>
                    
                    <!-- Legal Links -->
                    <?php if (get_theme_mod('show_legal_links', true)) : ?>
                    <div class="flex flex-wrap justify-center items-center gap-6 text-sm">
                        <a href="/privacy-policy" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                        <a href="/terms-of-service" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                        <a href="/cookie-policy" class="text-gray-400 hover:text-white transition-colors">Cookie Policy</a>
                        <a href="/sitemap" class="text-gray-400 hover:text-white transition-colors">Sitemap</a>
                    </div>
                    <?php endif; ?>
                    
 <!-- Language/Currency Selector - FIXED VERSION -->
<?php if (get_theme_mod('show_language_selector', true) || get_theme_mod('show_currency_selector', true)) : ?>
<div class="flex items-center gap-3">
    <!-- Language Selector -->
    <?php if (get_theme_mod('show_language_selector', true)) : ?>
    <div class="fancy-selector-wrapper">
        <button class="fancy-selector" id="language-toggle" type="button" aria-expanded="false">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
            </svg>
            <span class="selector-text"><?php echo esc_html(get_theme_mod('default_language', 'EN')); ?></span>
            <svg class="w-4 h-4 text-gray-400 chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="fancy-dropdown hidden" id="language-dropdown" role="listbox" aria-hidden="true">
            <a href="#" data-lang="en" data-code="EN" class="dropdown-item active" role="option">
                <span class="flag">🇺🇸</span> English
            </a>
            <a href="#" data-lang="es" data-code="ES" class="dropdown-item" role="option">
                <span class="flag">🇪🇸</span> Español
            </a>
            <a href="#" data-lang="fr" data-code="FR" class="dropdown-item" role="option">
                <span class="flag">🇫🇷</span> Français
            </a>
            <a href="#" data-lang="de" data-code="DE" class="dropdown-item" role="option">
                <span class="flag">🇩🇪</span> Deutsch
            </a>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Currency Selector -->
    <?php if (get_theme_mod('show_currency_selector', true)) : ?>
        <?php echo yoursite_render_currency_selector(array(
            'style' => 'dropdown', 
            'show_flag' => false,
            'show_name' => false,
            'show_symbol' => true,
            'wrapper_class' => 'fancy-selector-wrapper',
            'toggle_class' => 'fancy-selector',
            'dropdown_class' => 'fancy-dropdown',
            'item_class' => 'dropdown-item',
            'active_class' => 'active'
        )); ?>
    <?php endif; ?>
</div>
<?php endif; ?>

<style>
/* ENHANCED FANCY SELECTOR STYLES - MATCHING LANGUAGE SELECTOR */
.fancy-selector-wrapper {
    position: relative;
    display: inline-block;
}

.fancy-selector {
    display: flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
    border: 1px solid rgba(99, 102, 241, 0.3);
    color: #e5e7eb;
    font-size: 14px;
    padding: 10px 16px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    position: relative;
    overflow: hidden;
    min-width: 120px;
    justify-content: space-between;
}

.fancy-selector::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s ease;
}

.fancy-selector:hover::before {
    left: 100%;
}

.fancy-selector:hover {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
    border-color: rgba(99, 102, 241, 0.5);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
}

.fancy-selector .currency-symbol {
    color: #60a5fa;
    font-weight: 600;
    font-size: 16px;
}

.fancy-selector .selector-text {
    flex: 1;
    text-align: left;
}

.fancy-selector .chevron {
    transition: transform 0.3s ease;
    flex-shrink: 0;
}

.fancy-selector-wrapper.active .chevron {
    transform: rotate(180deg);
}

/* DROPDOWN STYLES */
.fancy-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    min-width: 180px;
    background: rgba(17, 24, 39, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1000;
    padding: 8px;
    max-height: 300px;
    overflow-y: auto;
}

.fancy-selector-wrapper.active .fancy-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    color: #d1d5db;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s ease;
    font-size: 14px;
    cursor: pointer;
}

.dropdown-item:hover {
    background: rgba(99, 102, 241, 0.2);
    color: #ffffff;
    transform: translateX(4px);
    text-decoration: none;
}

.dropdown-item.active {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.3) 0%, rgba(139, 92, 246, 0.3) 100%);
    color: #ffffff;
}

.dropdown-item .flag,
.dropdown-item .currency-flag {
    font-size: 18px;
    flex-shrink: 0;
}

.dropdown-item .currency-details {
    display: flex;
    align-items: center;
    gap: 6px;
}

.dropdown-item .currency-symbol {
    color: #60a5fa;
    font-weight: 600;
    min-width: 20px;
}

.dropdown-item .currency-code {
    font-weight: 500;
    min-width: 40px;
}

.dropdown-item .currency-name {
    color: #9ca3af;
    font-size: 12px;
}

/* LIMITED TIME OFFER STYLES */
.limited-time-offer {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.limited-time-offer:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.offer-amount {
    font-weight: 800;
    display: inline-block;
    transition: opacity 0.15s ease, transform 0.15s ease;
}

/* Animation for amount changes */
.offer-amount.updating {
    opacity: 0.6;
    transform: scale(0.95);
}

/* DARK MODE ADJUSTMENTS */
body.dark-mode .fancy-selector,
body.dark-mode .fancy-dropdown,
body.dark-mode .dropdown-item {
    /* Already optimized for dark mode */
}

/* MOBILE RESPONSIVE */
@media (max-width: 768px) {
    .fancy-selector {
        padding: 8px 12px;
        font-size: 13px;
        min-width: 100px;
    }
    
    .fancy-dropdown {
        left: auto;
        right: 0;
        min-width: 160px;
    }
    
    .dropdown-item {
        padding: 8px 10px;
        font-size: 13px;
    }
    
    .limited-time-offer {
        font-size: 1rem;
        padding: 1rem 1.5rem;
    }
}

/* ENSURE NO EXTRA SPACING */
.fancy-selector-wrapper {
    margin: 0;
    padding: 0;
}

.fancy-dropdown {
    margin: 0;
}

/* FIX FOR FOOTER SPACING ISSUES */
.site-footer .flex.items-center.gap-3 {
    margin: 0;
    padding: 0;
    flex-wrap: nowrap;
}

/* REMOVE ANY EXTRA WHITE SPACE */
.site-footer .bottom-bar {
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

.site-footer .bottom-bar .flex {
    margin-bottom: 0 !important;
}

/* PREVENT DROPDOWN FROM CAUSING LAYOUT SHIFTS */
.fancy-dropdown {
    position: absolute;
    width: max-content;
}

/* ACCESSIBILITY IMPROVEMENTS */
.fancy-selector:focus {
    outline: 2px solid rgba(99, 102, 241, 0.5);
    outline-offset: 2px;
}

.dropdown-item:focus {
    background: rgba(99, 102, 241, 0.3);
    color: #ffffff;
    outline: 1px solid rgba(99, 102, 241, 0.5);
}

/* HIGH CONTRAST MODE SUPPORT */
@media (prefers-contrast: high) {
    .fancy-selector {
        border-width: 2px;
        background: #000;
        color: #fff;
    }
    
    .fancy-dropdown {
        background: #000;
        border-width: 2px;
    }
    
    .dropdown-item {
        color: #fff;
    }
    
    .limited-time-offer {
        border: 2px solid #000;
        font-weight: 900;
    }
}

/* REDUCED MOTION SUPPORT */
@media (prefers-reduced-motion: reduce) {
    .fancy-selector,
    .fancy-dropdown,
    .dropdown-item,
    .chevron,
    .limited-time-offer,
    .offer-amount {
        transition: none;
    }
    
    .fancy-selector::before {
        display: none;
    }
    
    .limited-time-offer:hover {
        transform: none;
    }
}

/* DARK MODE ENHANCEMENTS */
@media (prefers-color-scheme: dark) {
    .limited-time-offer {
        background: linear-gradient(45deg, #fbbf24, #f59e0b);
        color: #92400e;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Exchange rates object - same as PHP version
    const exchangeRates = {
        'USD': 1.00,
        'EUR': 0.85,
        'GBP': 0.75,
        'CAD': 1.25,
        'AUD': 1.35,
        'JPY': 110.0,
        'CHF': 0.92,
        'SEK': 9.50,
        'NOK': 9.80,
        'DKK': 6.30,
        'PLN': 3.80,
        'CZK': 22.0,
        'HUF': 320.0,
        'BGN': 1.66,
        'RON': 4.20,
        'HRK': 6.40,
        'RUB': 75.0,
        'CNY': 6.45,
        'INR': 74.0,
        'KRW': 1180.0,
        'SGD': 1.35,
        'HKD': 7.80,
        'MXN': 20.0,
        'BRL': 5.20,
        'ARS': 98.0,
        'CLP': 800.0,
        'COP': 3800.0,
        'PEN': 3.60,
        'UYU': 43.0,
        'ZAR': 14.5,
        'EGP': 15.7,
        'NGN': 411.0,
        'KES': 108.0,
        'GHS': 6.10,
        'TND': 2.75,
        'MAD': 9.00,
        'THB': 33.0,
        'PHP': 50.0,
        'VND': 23000.0,
        'IDR': 14300.0,
        'MYR': 4.15,
        'ILS': 3.25,
        'AED': 3.67,
        'SAR': 3.75,
        'QAR': 3.64,
        'KWD': 0.30,
        'BHD': 0.38,
        'OMR': 0.38,
        'JOD': 0.71,
        'LBP': 1507.0,
        'TRY': 8.50,
        'IRR': 42000.0,
        'PKR': 170.0,
        'BDT': 85.0,
        'LKR': 200.0,
        'NPR': 118.0,
        'BTN': 74.0,
        'MVR': 15.4,
        'AFN': 80.0,
        'UZS': 10600.0,
        'KZT': 426.0,
        'KGS': 84.0,
        'TJS': 11.3,
        'TMT': 3.50,
        'AZN': 1.70,
        'GEL': 3.30,
        'AMD': 522.0,
        'BYN': 2.60,
        'MDL': 17.8,
        'UAH': 27.0,
        'RSD': 100.0,
        'MKD': 52.0,
        'ALL': 104.0,
        'BAM': 1.66,
        'ISK': 127.0
    };

    // Currency symbols mapping
    const currencySymbols = {
        'USD': '                ,
        'EUR': '€',
        'GBP': '£',
        'CAD': 'C                ,
        'AUD': 'A                ,
        'JPY': '¥',
        'CHF': 'CHF ',
        'SEK': 'kr',
        'NOK': 'kr',
        'DKK': 'kr',
        'PLN': 'zł',
        'CZK': 'Kč',
        'HUF': 'Ft',
        'BGN': 'лв',
        'RON': 'lei',
        'HRK': 'kn',
        'RUB': '₽',
        'CNY': '¥',
        'INR': '₹',
        'KRW': '₩',
        'SGD': 'S                ,
        'HKD': 'HK                ,
        'MXN': '                ,
        'BRL': 'R                ,
        'ARS': '                ,
        'CLP': '                ,
        'COP': '                ,
        'PEN': 'S/',
        'UYU': '$U',
        'ZAR': 'R',
        'EGP': 'E£',
        'NGN': '₦',
        'KES': 'KSh',
        'GHS': 'GH₵',
        'TND': 'د.ت',
        'MAD': 'د.م.',
        'THB': '฿',
        'PHP': '₱',
        'VND': '₫',
        'IDR': 'Rp',
        'MYR': 'RM',
        'ILS': '₪',
        'AED': 'د.إ',
        'SAR': '﷼',
        'QAR': 'ر.ق',
        'KWD': 'د.ك',
        'BHD': '.د.ب',
        'OMR': 'ر.ع.',
        'JOD': 'د.ا',
        'LBP': 'ل.ل',
        'TRY': '₺',
        'IRR': '﷼',
        'PKR': '₨',
        'BDT': '৳',
        'LKR': '₨',
        'NPR': '₨',
        'BTN': 'Nu.',
        'MVR': 'Rf',
        'AFN': '؋',
        'UZS': 'лв',
        'KZT': '₸',
        'KGS': 'лв',
        'TJS': 'смн',
        'TMT': 'T',
        'AZN': '₼',
        'GEL': '₾',
        'AMD': '֏',
        'BYN': 'Br',
        'MDL': 'lei',
        'UAH': '₴',
        'RSD': 'дин.',
        'MKD': 'ден',
        'ALL': 'L',
        'BAM': 'КМ',
        'ISK': 'kr'
    };

    // Convert USD to target currency
    function convertUsdToCurrency(usdAmount, targetCurrency) {
        const rate = exchangeRates[targetCurrency] || 1.00;
        const convertedAmount = usdAmount * rate;
        
        // Round based on currency type
        if (['JPY', 'KRW', 'VND', 'IDR', 'IRR', 'UZS', 'LBP', 'CLP', 'COP', 'HUF', 'CZK'].includes(targetCurrency)) {
            return Math.round(convertedAmount);
        } else if (['KWD', 'BHD', 'OMR', 'JOD'].includes(targetCurrency)) {
            return Math.round(convertedAmount * 1000) / 1000;
        } else {
            return Math.round(convertedAmount);
        }
    }

    // Format currency for display
    function formatCurrencyForOffer(amount, currencyCode) {
        const symbol = currencySymbols[currencyCode] || '                ;
        
        if (['JPY', 'KRW', 'VND', 'IDR', 'IRR', 'UZS', 'LBP', 'CLP', 'COP', 'HUF', 'CZK'].includes(currencyCode)) {
            return symbol + new Intl.NumberFormat().format(amount);
        } else if (['KWD', 'BHD', 'OMR', 'JOD'].includes(currencyCode)) {
            return symbol + new Intl.NumberFormat(undefined, {minimumFractionDigits: 3, maximumFractionDigits: 3}).format(amount);
        } else {
            return symbol + new Intl.NumberFormat().format(amount);
        }
    }

    // Update offer amount when currency changes
    function updateOfferAmount(newCurrencyCode) {
        const offerElement = document.querySelector('.limited-time-offer');
        const offerAmountElement = document.querySelector('.offer-amount');
        
        if (!offerElement || !offerAmountElement) return;
        
        const baseAmount = parseInt(offerElement.dataset.baseAmount) || 200;
        const convertedAmount = convertUsdToCurrency(baseAmount, newCurrencyCode);
        const formattedAmount = formatCurrencyForOffer(convertedAmount, newCurrencyCode);
        
        //
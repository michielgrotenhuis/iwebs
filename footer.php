</main><!-- #primary -->

    <footer id="colophon" class="site-footer bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-8">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="mb-6">
                        <?php
                        if (has_custom_logo()) {
                            // Get custom logo and modify for footer (white version)
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            if ($logo) {
                                echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="h-8 filter brightness-0 invert">';
                            }
                        } else {
                            ?>
                            <h3 class="text-2xl font-bold text-white">
                                <?php bloginfo('name'); ?>
                            </h3>
                            <?php
                        }
                        ?>
                    </div>
                    <p class="text-gray-300 mb-6 max-w-md">
                        Build your online store in minutes with our powerful, easy-to-use eCommerce platform. 
                        No coding required - just launch and sell.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition-colors" aria-label="Twitter">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors" aria-label="Facebook">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors" aria-label="LinkedIn">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors" aria-label="Instagram">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.89 2.747.099.12.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.747 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Product Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Product</h4>
                    <ul class="space-y-3">
                        <li><a href="<?php echo home_url('/features'); ?>" class="text-gray-300 hover:text-white transition-colors">Features</a></li>
                        <li><a href="<?php echo home_url('/templates'); ?>" class="text-gray-300 hover:text-white transition-colors">Templates</a></li>
                        <li><a href="<?php echo home_url('/pricing'); ?>" class="text-gray-300 hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="<?php echo home_url('/integrations'); ?>" class="text-gray-300 hover:text-white transition-colors">Integrations</a></li>
                        <li><a href="<?php echo home_url('/api'); ?>" class="text-gray-300 hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>

                <!-- Resources Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Resources</h4>
                    <ul class="space-y-3">
                        <li><a href="<?php echo home_url('/blog'); ?>" class="text-gray-300 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="<?php echo home_url('/help'); ?>" class="text-gray-300 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="<?php echo home_url('/guides'); ?>" class="text-gray-300 hover:text-white transition-colors">Guides</a></li>
                        <li><a href="<?php echo home_url('/webinars'); ?>" class="text-gray-300 hover:text-white transition-colors">Webinars</a></li>
                        <li><a href="<?php echo home_url('/case-studies'); ?>" class="text-gray-300 hover:text-white transition-colors">Case Studies</a></li>
                    </ul>
                </div>

                <!-- Company Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="<?php echo home_url('/about'); ?>" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="<?php echo home_url('/careers'); ?>" class="text-gray-300 hover:text-white transition-colors">Careers</a></li>
                        <li><a href="<?php echo home_url('/partners'); ?>" class="text-gray-300 hover:text-white transition-colors">Partners</a></li>
                        <li><a href="<?php echo home_url('/contact'); ?>" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="<?php echo home_url('/press'); ?>" class="text-gray-300 hover:text-white transition-colors">Press Kit</a></li>
                    </ul>
                </div>
            </div>

            <!-- Newsletter Signup -->
            <div class="border-t border-gray-800 pt-8 mt-12">
                <div class="max-w-md">
                    <h4 class="text-lg font-semibold mb-4">Stay updated</h4>
                    <p class="text-gray-300 mb-4">Get the latest news, updates, and tips delivered to your inbox.</p>
                    <form class="flex flex-col sm:flex-row gap-3" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
                        <input type="hidden" name="action" value="newsletter_signup">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('newsletter_nonce'); ?>">
                        <input 
                            type="email" 
                            name="email"
                            placeholder="Enter your email" 
                            required
                            class="flex-1 px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        >
                        <button 
                            type="submit" 
                            class="btn-primary px-6 py-3 whitespace-nowrap"
                        >
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 pt-8 mt-12">
                <div class="flex flex-col lg:flex-row justify-between items-center">
                    <div class="text-gray-300 text-sm mb-4 lg:mb-0">
                        © <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
                    </div>
                    
                    <!-- Footer Navigation -->
                    <div class="flex flex-wrap justify-center lg:justify-end items-center space-x-6 text-sm">
                        <?php
                        if (has_nav_menu('footer')) {
                            wp_nav_menu(array(
                                'theme_location' => 'footer',
                                'menu_class' => 'flex flex-wrap items-center space-x-6',
                                'container' => false,
                                'fallback_cb' => 'yoursite_footer_menu',
                                'walker' => new YourSite_Footer_Walker_Nav_Menu(),
                            ));
                        } else {
                            yoursite_footer_menu();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu functionality
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (mobileMenu && !mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
            mobileMenu.classList.add('hidden');
        }
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Newsletter form submission
    const newsletterForm = document.querySelector('form[action*="admin-ajax.php"]');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            
            button.textContent = 'Subscribing...';
            button.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.reset();
                    button.textContent = 'Subscribed!';
                    setTimeout(() => {
                        button.textContent = originalText;
                        button.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(data.data || 'Subscription failed');
                }
            })
            .catch(error => {
                console.error('Newsletter signup error:', error);
                button.textContent = 'Try Again';
                setTimeout(() => {
                    button.textContent = originalText;
                    button.disabled = false;
                }, 2000);
            });
        });
    }
    
    // Add animation classes on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    document.querySelectorAll('.feature-card, .hero-gradient > div').forEach(el => {
        observer.observe(el);
    });
});
</script>

</body>
</html>

<?php
// Default footer menu fallback
function yoursite_footer_menu() {
    ?>
    <div class="flex flex-wrap items-center space-x-6">
        <a href="<?php echo home_url('/privacy-policy'); ?>" class="text-gray-300 hover:text-white transition-colors">Privacy Policy</a>
        <a href="<?php echo home_url('/terms-of-service'); ?>" class="text-gray-300 hover:text-white transition-colors">Terms of Service</a>
        <a href="<?php echo home_url('/cookie-policy'); ?>" class="text-gray-300 hover:text-white transition-colors">Cookie Policy</a>
        <a href="<?php echo home_url('/sitemap'); ?>" class="text-gray-300 hover:text-white transition-colors">Sitemap</a>
    </div>
    <?php
}

// Custom Walker class for footer navigation
class YourSite_Footer_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        // No submenus in footer
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        // No submenus in footer
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url) ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        $item_output = '<a class="text-gray-300 hover:text-white transition-colors"' . $attributes .'>';
        $item_output .= apply_filters('the_title', $item->title, $item->ID);
        $item_output .= '</a>';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        // Items are inline, no closing tags needed
    }
}
?>

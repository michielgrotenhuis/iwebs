<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="error-404 not-found py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                
                <!-- 404 Hero -->
                <div class="mb-12">
                    <div class="text-9xl font-bold text-gray-200 mb-4">404</div>
                    <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                        Page Not Found
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                        Sorry, we couldn't find the page you're looking for. The page might have been moved, deleted, or the URL might be incorrect.
                    </p>
                </div>

                <!-- Search Form -->
                <div class="mb-12">
                    <div class="max-w-md mx-auto">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Try searching for what you need</h2>
                        <div class="relative">
                            <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                                <div class="flex">
                                    <input type="search" 
                                           class="search-field flex-1 px-4 py-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           placeholder="Search our site..." 
                                           value="<?php echo get_search_query(); ?>" 
                                           name="s" />
                                    <button type="submit" 
                                            class="search-submit btn-primary px-6 py-3 rounded-r-lg border-l-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    <div class="bg-white rounded-lg p-6 feature-card border border-gray-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-2">Homepage</h3>
                        <p class="text-gray-600 text-sm mb-3">Go back to our main page</p>
                        <a href="<?php echo home_url('/'); ?>" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">Go Home →</a>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6 feature-card border border-gray-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-2">Pricing</h3>
                        <p class="text-gray-600 text-sm mb-3">View our subscription plans</p>
                        <a href="<?php echo home_url('/pricing'); ?>" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">View Plans →</a>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6 feature-card border border-gray-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-2">Features</h3>
                        <p class="text-gray-600 text-sm mb-3">Explore platform capabilities</p>
                        <a href="<?php echo home_url('/features'); ?>" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">See Features →</a>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6 feature-card border border-gray-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-2">Support</h3>
                        <p class="text-gray-600 text-sm mb-3">Get help from our team</p>
                        <a href="<?php echo home_url('/contact'); ?>" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">Contact Us →</a>
                    </div>
                </div>

                <!-- Popular Content -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-8">Popular Content</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        <?php
                        // Get recent blog posts
                        $recent_posts = get_posts(array(
                            'numberposts' => 3,
                            'post_status' => 'publish'
                        ));
                        
                        if ($recent_posts) :
                            foreach ($recent_posts as $post) : setup_postdata($post);
                        ?>
                            <article class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-500">Blog Post</span>
                                </div>
                                <h3 class="font-semibold mb-2 line-clamp-2">
                                    <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-blue-600 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                </p>
                                <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                                    Read More →
                                </a>
                            </article>
                        <?php 
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>

                        <?php
                        // Get recent case studies if they exist
                        $case_studies = get_posts(array(
                            'post_type' => 'case_studies',
                            'numberposts' => 2,
                            'post_status' => 'publish'
                        ));
                        
                        if ($case_studies) :
                            foreach (array_slice($case_studies, 0, 2) as $case_study) : setup_postdata($case_study);
                        ?>
                            <article class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-500">Case Study</span>
                                </div>
                                <h3 class="font-semibold mb-2 line-clamp-2">
                                    <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-blue-600 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                </p>
                                <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                                    View Case Study →
                                </a>
                            </article>
                        <?php 
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>

                        <?php
                        // Get webinars if they exist
                        $webinars = get_posts(array(
                            'post_type' => 'webinars',
                            'numberposts' => 1,
                            'post_status' => 'publish'
                        ));
                        
                        if ($webinars) :
                            foreach ($webinars as $webinar) : setup_postdata($webinar);
                        ?>
                            <article class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-500">Webinar</span>
                                </div>
                                <h3 class="font-semibold mb-2 line-clamp-2">
                                    <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-blue-600 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                </p>
                                <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                                    View Webinar →
                                </a>
                            </article>
                        <?php 
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Help Resources -->
                <div class="bg-gray-50 rounded-lg p-8 mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Need More Help?</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold mb-2">Documentation</h3>
                            <p class="text-gray-600 text-sm mb-3">Browse our comprehensive guides and tutorials</p>
                            <a href="<?php echo home_url('/help'); ?>" class="text-blue-600 hover:text-blue-800 font-medium">View Docs →</a>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold mb-2">Live Chat</h3>
                            <p class="text-gray-600 text-sm mb-3">Get instant help from our support team</p>
                            <button onclick="openChat()" class="text-blue-600 hover:text-blue-800 font-medium">Start Chat →</button>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold mb-2">Email Support</h3>
                            <p class="text-gray-600 text-sm mb-3">Send us a message and we'll respond within 24 hours</p>
                            <a href="mailto:support@yoursite.biz" class="text-blue-600 hover:text-blue-800 font-medium">Email Us →</a>
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg p-8">
                    <h2 class="text-2xl font-bold mb-4">Ready to Build Your Online Store?</h2>
                    <p class="text-blue-100 mb-6">Don't let a missing page stop you. Start creating your dream store today with our powerful platform.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?php echo home_url('/pricing'); ?>" class="btn-primary bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition-all">
                            Start Free Trial
                        </a>
                        <a href="<?php echo home_url('/features'); ?>" class="btn-secondary border-white text-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-semibold transition-all">
                            Explore Features
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.feature-card {
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-2px);
}

.search-form .search-submit {
    border-left: none !important;
}

.search-form .search-field:focus + .search-submit {
    border-color: #3b82f6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add some interactive behavior
    const cards = document.querySelectorAll('.feature-card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Live chat function (placeholder)
    window.openChat = function() {
        // Replace with your actual chat widget opening code
        alert('Chat feature would open here. Integrate with your actual chat service.');
    };
    
    // Track 404 errors for analytics (optional)
    if (typeof gtag !== 'undefined') {
        gtag('event', '404_error', {
            'page_location': window.location.href,
            'page_title': document.title
        });
    }
});
</script>

<?php
get_footer();
?>
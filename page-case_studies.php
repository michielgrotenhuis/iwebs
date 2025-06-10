<?php
/**
 * Template Name: Case Studies Page
 * Custom page template for case studies landing page
 * Save as: page-case-studies.php
 */

get_header(); 

// Get featured case studies
$featured_case_studies = get_posts(array(
    'post_type' => 'case_studies',
    'posts_per_page' => 3,
    'meta_query' => array(
        array(
            'key' => '_case_study_featured',
            'value' => '1',
            'compare' => '='
        )
    )
));

// If no featured studies, get latest ones
if (empty($featured_case_studies)) {
    $featured_case_studies = get_posts(array(
        'post_type' => 'case_studies',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC'
    ));
}

// Get all case studies for stats
$all_case_studies = get_posts(array(
    'post_type' => 'case_studies',
    'posts_per_page' => -1,
    'post_status' => 'publish'
));

// Get industries for filter
$industries = get_terms(array(
    'taxonomy' => 'case_study_industry',
    'hide_empty' => true
));

?>

<!-- Hero Section -->
<section class="hero-gradient text-white py-20 lg:py-32">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                Real Results for Real Businesses
            </h1>
            <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-3xl mx-auto">
                Discover how we've helped companies like yours achieve extraordinary growth through innovative solutions and strategic partnerships.
            </p>
            
            <!-- Hero Stats -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-3xl font-bold mb-2"><?php echo count($all_case_studies); ?>+</div>
                    <div class="text-white/80">Success Stories</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-3xl font-bold mb-2">150%</div>
                    <div class="text-white/80">Average Growth</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-3xl font-bold mb-2">25+</div>
                    <div class="text-white/80">Industries Served</div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#featured-studies" class="btn-primary text-lg px-8 py-4 bg-white text-blue-600 hover:bg-gray-100 rounded-lg font-semibold">
                    View Success Stories
                </a>
                <a href="/contact" class="btn-secondary text-lg px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-blue-600 rounded-lg font-semibold">
                    Start Your Project
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Trust Indicators -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Trusted by Industry Leaders</h2>
                <p class="text-gray-600">We've partnered with companies across various industries to drive success</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center opacity-60">
                <!-- Placeholder for client logos -->
                <?php for ($i = 0; $i < 6; $i++) : ?>
                    <div class="bg-gray-200 h-12 rounded flex items-center justify-center">
                        <span class="text-gray-500 text-sm font-medium">Client Logo</span>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<!-- Featured Case Studies -->
<?php if (!empty($featured_case_studies)) : ?>
<section id="featured-studies" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Featured Success Stories</h2>
                <p class="text-xl text-gray-600">See how our clients achieved remarkable results</p>
            </div>
            
            <div class="grid lg:grid-cols-3 gap-8">
                <?php foreach ($featured_case_studies as $study) : 
                    $study_meta = yoursite_get_case_study_meta_fields($study->ID);
                    $industries = get_the_terms($study->ID, 'case_study_industry');
                ?>
                    <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                        <a href="<?php echo get_permalink($study->ID); ?>" class="block">
                            <?php if (has_post_thumbnail($study->ID)) : ?>
                                <div class="aspect-video bg-gray-200 overflow-hidden">
                                    <?php echo get_the_post_thumbnail($study->ID, 'medium', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300')); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <!-- Featured Badge -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        Featured
                                    </span>
                                    
                                    <?php if ($study_meta['case_study_industry_text']) : ?>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                            <?php echo esc_html($study_meta['case_study_industry_text']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                    <?php echo get_the_title($study->ID); ?>
                                </h3>
                                
                                <?php if ($study_meta['case_study_client']) : ?>
                                    <p class="text-blue-600 font-medium mb-3">
                                        <?php echo esc_html($study_meta['case_study_client']); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if (has_excerpt($study->ID)) : ?>
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        <?php echo wp_trim_words(get_the_excerpt($study->ID), 20); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <!-- Key Metric -->
                                <?php if ($study_meta['case_study_metric_1_label'] && $study_meta['case_study_metric_1_value']) : ?>
                                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-4 mb-4">
                                        <div class="text-2xl font-bold text-blue-600">
                                            <?php echo esc_html($study_meta['case_study_metric_1_value']); ?>
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <?php echo esc_html($study_meta['case_study_metric_1_label']); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <span class="text-blue-600 font-medium group-hover:text-blue-700 transition-colors">
                                    Read Full Story →
                                </span>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Industries We Serve -->
<?php if (!empty($industries)) : ?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Industries We Serve</h2>
                <p class="text-xl text-gray-600">Expertise across diverse sectors and business models</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach (array_slice($industries, 0, 6) as $industry) : 
                    $industry_count = $industry->count;
                ?>
                    <div class="bg-gray-50 rounded-lg p-6 hover:bg-blue-50 transition-colors group">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                <?php echo esc_html($industry->name); ?>
                            </h3>
                            <span class="text-sm text-gray-500 bg-white px-2 py-1 rounded">
                                <?php echo $industry_count; ?> case<?php echo $industry_count !== 1 ? 's' : ''; ?>
                            </span>
                        </div>
                        
                        <?php if ($industry->description) : ?>
                            <p class="text-gray-600 text-sm mb-4">
                                <?php echo esc_html($industry->description); ?>
                            </p>
                        <?php endif; ?>
                        
                        <a href="<?php echo get_post_type_archive_link('case_studies') . '?industry=' . $industry->slug; ?>" 
                           class="text-blue-600 text-sm font-medium group-hover:text-blue-700 transition-colors">
                            View Case Studies →
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Process Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Our Proven Process</h2>
                <p class="text-xl text-gray-600">How we deliver exceptional results for every client</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-blue-600">1</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Discovery</h3>
                    <p class="text-gray-600">We deep-dive into your business goals, challenges, and requirements to create a tailored strategy.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-green-600">2</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Strategy</h3>
                    <p class="text-gray-600">We develop a comprehensive plan with clear milestones and measurable outcomes.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-purple-600">3</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Execution</h3>
                    <p class="text-gray-600">Our expert team implements the solution with precision, keeping you informed every step of the way.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-orange-600">4</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Results</h3>
                    <p class="text-gray-600">We measure success, optimize performance, and provide ongoing support for continued growth.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Browse All Case Studies CTA -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Ready to Explore More Success Stories?
            </h2>
            <p class="text-xl text-gray-600 mb-8">
                Browse our complete collection of case studies to see how we've helped businesses achieve their goals.
            </p>
            <a href="<?php echo get_post_type_archive_link('case_studies'); ?>" 
               class="btn-primary text-lg px-8 py-4 rounded-lg font-semibold">
                View All Case Studies
            </a>
        </div>
    </div>
</section>

<!-- Final CTA -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-5xl font-bold mb-6">
                Your Success Story Starts Here
            </h2>
            <p class="text-xl mb-8 opacity-90">
                Join our growing list of successful clients and transform your business with our expert solutions.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="/contact" class="btn-primary text-lg px-8 py-4 bg-white text-blue-600 hover:bg-gray-100 rounded-lg font-semibold">
                    Get Started Today
                </a>
                <a href="/pricing" class="btn-secondary text-lg px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-blue-600 rounded-lg font-semibold">
                    View Our Plans
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<?php get_footer(); ?>
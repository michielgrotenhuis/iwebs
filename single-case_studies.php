<?php
/**
 * Single Case Study Template
 * Save as: single-case_studies.php
 */

get_header(); 

while (have_posts()) : the_post();
    $case_study_meta = yoursite_get_case_study_meta_fields(get_the_ID());
    $industries = get_the_terms(get_the_ID(), 'case_study_industry');
    $services = get_the_terms(get_the_ID(), 'case_study_service');
?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-50 to-purple-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <!-- Breadcrumb -->
                    <nav class="mb-6">
                        <ol class="flex items-center space-x-2 text-sm text-gray-600">
                            <li><a href="<?php echo home_url(); ?>" class="hover:text-blue-600">Home</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li><a href="<?php echo get_post_type_archive_link('case_studies'); ?>" class="hover:text-blue-600">Case Studies</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li class="text-gray-900 font-medium"><?php the_title(); ?></li>
                        </ol>
                    </nav>

                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        <?php the_title(); ?>
                    </h1>
                    
                    <?php if ($case_study_meta['case_study_client']) : ?>
                        <p class="text-xl text-blue-600 font-semibold mb-4">
                            Client: <?php echo esc_html($case_study_meta['case_study_client']); ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if (has_excerpt()) : ?>
                        <div class="text-lg text-gray-600 mb-8 leading-relaxed">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Quick Stats -->
                    <div class="flex flex-wrap gap-4">
                        <?php if ($case_study_meta['case_study_industry_text']) : ?>
                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                <?php echo esc_html($case_study_meta['case_study_industry_text']); ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if ($case_study_meta['case_study_duration']) : ?>
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                <?php echo esc_html($case_study_meta['case_study_duration']); ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if ($services) : ?>
                            <?php foreach ($services as $service) : ?>
                                <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                    <?php echo esc_html($service->name); ?>
                                </span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="lg:text-right">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="rounded-xl overflow-hidden shadow-xl">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-auto')); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Key Metrics Section -->
<?php 
$metrics = array();
if ($case_study_meta['case_study_metric_1_label'] && $case_study_meta['case_study_metric_1_value']) {
    $metrics[] = array(
        'label' => $case_study_meta['case_study_metric_1_label'],
        'value' => $case_study_meta['case_study_metric_1_value']
    );
}
if ($case_study_meta['case_study_metric_2_label'] && $case_study_meta['case_study_metric_2_value']) {
    $metrics[] = array(
        'label' => $case_study_meta['case_study_metric_2_label'],
        'value' => $case_study_meta['case_study_metric_2_value']
    );
}
if ($case_study_meta['case_study_metric_3_label'] && $case_study_meta['case_study_metric_3_value']) {
    $metrics[] = array(
        'label' => $case_study_meta['case_study_metric_3_label'],
        'value' => $case_study_meta['case_study_metric_3_value']
    );
}
?>

<?php if (!empty($metrics)) : ?>
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-12">Key Results</h2>
            
            <div class="grid md:grid-cols-<?php echo min(count($metrics), 3); ?> gap-8">
                <?php foreach ($metrics as $metric) : ?>
                    <div class="text-center">
                        <div class="text-4xl lg:text-5xl font-bold text-blue-600 mb-2">
                            <?php echo esc_html($metric['value']); ?>
                        </div>
                        <div class="text-gray-600 font-medium">
                            <?php echo esc_html($metric['label']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Main Content -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-200 mb-8">
                        <div class="prose prose-lg max-w-none">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    
                    <!-- Challenge, Solution, Results -->
                    <?php if ($case_study_meta['case_study_challenge']) : ?>
                    <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-200 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            The Challenge
                        </h3>
                        <div class="prose prose-lg max-w-none text-gray-600">
                            <?php echo wpautop(esc_html($case_study_meta['case_study_challenge'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($case_study_meta['case_study_solution']) : ?>
                    <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-200 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            Our Solution
                        </h3>
                        <div class="prose prose-lg max-w-none text-gray-600">
                            <?php echo wpautop(esc_html($case_study_meta['case_study_solution'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($case_study_meta['case_study_results']) : ?>
                    <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-200 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            Results & Impact
                        </h3>
                        <div class="prose prose-lg max-w-none text-gray-600">
                            <?php echo wpautop(esc_html($case_study_meta['case_study_results'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Testimonial -->
                    <?php if ($case_study_meta['case_study_testimonial']) : ?>
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-8 border border-blue-200">
                        <div class="text-center">
                            <svg class="w-8 h-8 text-blue-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                            </svg>
                            <blockquote class="text-xl italic text-gray-700 mb-6 leading-relaxed">
                                "<?php echo esc_html($case_study_meta['case_study_testimonial']); ?>"
                            </blockquote>
                            <?php if ($case_study_meta['case_study_testimonial_author']) : ?>
                                <cite class="text-gray-600 font-semibold">
                                    — <?php echo esc_html($case_study_meta['case_study_testimonial_author']); ?>
                                </cite>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Project Details Card -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 mb-8 sticky top-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Project Details</h3>
                        
                        <div class="space-y-4">
                            <?php if ($case_study_meta['case_study_client']) : ?>
                            <div class="flex justify-between items-start">
                                <span class="text-gray-600 font-medium">Client:</span>
                                <span class="text-gray-900 text-right"><?php echo esc_html($case_study_meta['case_study_client']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($case_study_meta['case_study_industry_text']) : ?>
                            <div class="flex justify-between items-start">
                                <span class="text-gray-600 font-medium">Industry:</span>
                                <span class="text-gray-900 text-right"><?php echo esc_html($case_study_meta['case_study_industry_text']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($case_study_meta['case_study_duration']) : ?>
                            <div class="flex justify-between items-start">
                                <span class="text-gray-600 font-medium">Duration:</span>
                                <span class="text-gray-900 text-right"><?php echo esc_html($case_study_meta['case_study_duration']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($case_study_meta['case_study_technologies']) : ?>
                            <div>
                                <span class="text-gray-600 font-medium block mb-2">Technologies:</span>
                                <div class="flex flex-wrap gap-2">
                                    <?php 
                                    $techs = array_map('trim', explode(',', $case_study_meta['case_study_technologies']));
                                    foreach ($techs as $tech) :
                                        if (!empty($tech)) :
                                    ?>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-sm"><?php echo esc_html($tech); ?></span>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($case_study_meta['case_study_website']) : ?>
                            <div class="pt-4 border-t border-gray-200">
                                <a href="<?php echo esc_url($case_study_meta['case_study_website']); ?>" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="btn-primary w-full text-center py-3 rounded-lg font-semibold inline-flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Visit Website
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Share Card -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Share This Case Study</h3>
                        
                        <div class="flex gap-3">
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                               target="_blank" rel="noopener noreferrer"
                               class="flex-1 bg-blue-500 text-white text-center py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                Twitter
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" 
                               target="_blank" rel="noopener noreferrer"
                               class="flex-1 bg-blue-700 text-white text-center py-2 rounded-lg hover:bg-blue-800 transition-colors">
                                LinkedIn
                            </a>
                            <button onclick="navigator.share ? navigator.share({title: '<?php echo esc_js(get_the_title()); ?>', url: '<?php echo get_permalink(); ?>'}) : copyToClipboard('<?php echo get_permalink(); ?>')"
                                    class="flex-1 bg-gray-600 text-white text-center py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                Share
                            </button>
                        </div>
                    </div>
                    
                    <!-- CTA Card -->
                    <div class="bg-gradient-to-br from-blue-600 to-purple-600 text-white rounded-lg p-6">
                        <h3 class="text-xl font-bold mb-3">Ready to Start Your Project?</h3>
                        <p class="text-blue-100 mb-4">
                            Let's discuss how we can help you achieve similar results for your business.
                        </p>
                        <a href="/contact" class="btn-secondary border-white text-white hover:bg-white hover:text-blue-600 w-full text-center py-3 rounded-lg font-semibold transition-all">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Case Studies -->
<?php
$related_studies = get_posts(array(
    'post_type' => 'case_studies',
    'posts_per_page' => 3,
    'post__not_in' => array(get_the_ID()),
    'orderby' => 'rand'
));

if ($related_studies) :
?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">More Case Studies</h2>
                <p class="text-xl text-gray-600">Explore how we've helped other clients achieve success</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($related_studies as $study) : 
                    $study_meta = yoursite_get_case_study_meta_fields($study->ID);
                ?>
                    <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300 group">
                        <a href="<?php echo get_permalink($study->ID); ?>" class="block">
                            <?php if (has_post_thumbnail($study->ID)) : ?>
                                <div class="aspect-video bg-gray-200 overflow-hidden">
                                    <?php echo get_the_post_thumbnail($study->ID, 'medium', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300')); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
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
                                        <?php echo get_the_excerpt($study->ID); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <span class="text-blue-600 font-medium group-hover:text-blue-700">
                                    Read Case Study →
                                </span>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="<?php echo get_post_type_archive_link('case_studies'); ?>" 
                   class="btn-primary px-8 py-3 rounded-lg font-semibold">
                    View All Case Studies
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show a temporary success message
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        setTimeout(() => {
            button.textContent = originalText;
        }, 2000);
    });
}
</script>

<?php endwhile; ?>

<?php get_footer(); ?>
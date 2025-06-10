<?php
/**
 * Archive template for case studies
 * Save as: archive-case_studies.php
 */

get_header(); ?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-50 to-purple-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                Client Success Stories
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Discover how we've helped businesses like yours achieve remarkable growth and success through our innovative solutions and expert guidance.
            </p>
            
            <!-- Quick Stats -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-blue-600">
                        <?php 
                        $case_studies_count = wp_count_posts('case_studies');
                        echo $case_studies_count->publish;
                        ?>
                    </div>
                    <div class="text-sm text-gray-600">Success Stories</div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-green-600">150%</div>
                    <div class="text-sm text-gray-600">Avg. Growth</div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-purple-600">50+</div>
                    <div class="text-sm text-gray-600">Industries</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="py-8 bg-white border-b border-gray-200 sticky top-0 z-10">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <!-- Search -->
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input type="text" id="case-study-search" placeholder="Search case studies..." 
                               class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Filters -->
                <div class="flex gap-3">
                    <select id="industry-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Industries</option>
                        <?php
                        $industries = get_terms(array(
                            'taxonomy' => 'case_study_industry',
                            'hide_empty' => true
                        ));
                        foreach ($industries as $industry) :
                        ?>
                            <option value="<?php echo $industry->slug; ?>"><?php echo $industry->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <select id="service-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Services</option>
                        <?php
                        $services = get_terms(array(
                            'taxonomy' => 'case_study_service',
                            'hide_empty' => true
                        ));
                        foreach ($services as $service) :
                        ?>
                            <option value="<?php echo $service->slug; ?>"><?php echo $service->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <button id="reset-filters" class="px-4 py-3 text-gray-600 hover:text-gray-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Case Studies Grid -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <?php if (have_posts()) : ?>
                <div id="case-studies-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php while (have_posts()) : the_post(); 
                        $case_study_meta = yoursite_get_case_study_meta_fields(get_the_ID());
                        $industries = get_the_terms(get_the_ID(), 'case_study_industry');
                        $services = get_the_terms(get_the_ID(), 'case_study_service');
                        
                        // Build data attributes for filtering
                        $industry_slugs = $industries ? implode(' ', wp_list_pluck($industries, 'slug')) : '';
                        $service_slugs = $services ? implode(' ', wp_list_pluck($services, 'slug')) : '';
                    ?>
                        <article class="case-study-card bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group" 
                                 data-title="<?php echo strtolower(get_the_title()); ?>"
                                 data-client="<?php echo strtolower($case_study_meta['case_study_client']); ?>"
                                 data-industries="<?php echo $industry_slugs; ?>"
                                 data-services="<?php echo $service_slugs; ?>">
                            
                            <a href="<?php the_permalink(); ?>" class="block">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="aspect-video bg-gray-200 overflow-hidden">
                                        <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300')); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="p-6">
                                    <!-- Tags -->
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <?php if ($case_study_meta['case_study_industry_text']) : ?>
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                <?php echo esc_html($case_study_meta['case_study_industry_text']); ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if ($services) : ?>
                                            <?php foreach (array_slice($services, 0, 2) as $service) : ?>
                                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">
                                                    <?php echo esc_html($service->name); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">
                                        <?php the_title(); ?>
                                    </h3>
                                    
                                    <?php if ($case_study_meta['case_study_client']) : ?>
                                        <p class="text-blue-600 font-medium mb-3">
                                            <?php echo esc_html($case_study_meta['case_study_client']); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <?php if (has_excerpt()) : ?>
                                        <p class="text-gray-600 mb-4 line-clamp-3">
                                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <!-- Key Metrics Preview -->
                                    <?php if ($case_study_meta['case_study_metric_1_label'] && $case_study_meta['case_study_metric_1_value']) : ?>
                                        <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                            <div class="text-lg font-bold text-blue-600">
                                                <?php echo esc_html($case_study_meta['case_study_metric_1_value']); ?>
                                            </div>
                                            <div class="text-xs text-gray-600">
                                                <?php echo esc_html($case_study_meta['case_study_metric_1_label']); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-blue-600 font-medium group-hover:text-blue-700 transition-colors">
                                            Read Case Study →
                                        </span>
                                        
                                        <?php if ($case_study_meta['case_study_duration']) : ?>
                                            <span class="text-xs text-gray-500">
                                                <?php echo esc_html($case_study_meta['case_study_duration']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <!-- Pagination -->
                <div class="mt-16">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('← Previous', 'yoursite'),
                        'next_text' => __('Next →', 'yoursite'),
                        'class' => 'pagination-wrapper'
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                <!-- No Case Studies -->
                <div class="text-center py-20">
                    <div class="max-w-md mx-auto">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No case studies found</h3>
                        <p class="text-gray-600 mb-6">We're working on adding more success stories. Check back soon!</p>
                        <a href="/contact" class="btn-primary px-6 py-3 rounded-lg font-semibold">Contact Us</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-5xl font-bold mb-6">
                Ready to Be Our Next Success Story?
            </h2>
            <p class="text-xl mb-8 opacity-90">
                Join hundreds of satisfied clients who have transformed their businesses with our solutions
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="/contact" class="btn-primary text-lg px-8 py-4 bg-white text-blue-600 hover:bg-gray-100 rounded-lg font-semibold transition-all">
                    Start Your Project
                </a>
                <a href="/pricing" class="btn-secondary text-lg px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-blue-600 rounded-lg font-semibold transition-all">
                    View Pricing
                </a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('case-study-search');
    const industryFilter = document.getElementById('industry-filter');
    const serviceFilter = document.getElementById('service-filter');
    const resetButton = document.getElementById('reset-filters');
    const caseStudyCards = document.querySelectorAll('.case-study-card');
    
    function filterCaseStudies() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedIndustry = industryFilter.value;
        const selectedService = serviceFilter.value;
        
        let visibleCount = 0;
        
        caseStudyCards.forEach(card => {
            const title = card.getAttribute('data-title') || '';
            const client = card.getAttribute('data-client') || '';
            const industries = card.getAttribute('data-industries') || '';
            const services = card.getAttribute('data-services') || '';
            
            let showCard = true;
            
            // Search filter
            if (searchTerm && !title.includes(searchTerm) && !client.includes(searchTerm)) {
                showCard = false;
            }
            
            // Industry filter
            if (selectedIndustry && !industries.includes(selectedIndustry)) {
                showCard = false;
            }
            
            // Service filter
            if (selectedService && !services.includes(selectedService)) {
                showCard = false;
            }
            
            if (showCard) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        updateResultsMessage(visibleCount);
    }
    
    function updateResultsMessage(count) {
        const grid = document.getElementById('case-studies-grid');
        let noResultsMsg = document.getElementById('no-results-message');
        
        if (count === 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'no-results-message';
                noResultsMsg.className = 'col-span-full text-center py-20';
                noResultsMsg.innerHTML = `
                    <div class="max-w-md mx-auto">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No case studies match your filters</h3>
                        <p class="text-gray-600 mb-6">Try adjusting your search criteria or browse all case studies.</p>
                        <button onclick="resetFilters()" class="btn-primary px-6 py-3 rounded-lg font-semibold">Clear Filters</button>
                    </div>
                `;
                grid.appendChild(noResultsMsg);
            }
            noResultsMsg.style.display = 'block';
        } else {
            if (noResultsMsg) {
                noResultsMsg.style.display = 'none';
            }
        }
    }
    
    function resetFilters() {
        searchInput.value = '';
        industryFilter.value = '';
        serviceFilter.value = '';
        filterCaseStudies();
    }
    
    // Make resetFilters globally available
    window.resetFilters = resetFilters;
    
    // Add event listeners
    searchInput.addEventListener('input', filterCaseStudies);
    industryFilter.addEventListener('change', filterCaseStudies);
    serviceFilter.addEventListener('change', filterCaseStudies);
    resetButton.addEventListener('click', resetFilters);
    
    // Add smooth scrolling animation for filtered results
    function smoothScrollToResults() {
        const grid = document.getElementById('case-studies-grid');
        grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    // Trigger scroll after filtering (debounced)
    let filterTimeout;
    function debouncedFilter() {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(() => {
            filterCaseStudies();
            if (searchInput.value || industryFilter.value || serviceFilter.value) {
                setTimeout(smoothScrollToResults, 100);
            }
        }, 300);
    }
    
    searchInput.addEventListener('input', debouncedFilter);
});
</script>

<style>
.case-study-card {
    transform: translateY(0);
    transition: all 0.3s ease;
}

.case-study-card:hover {
    transform: translateY(-5px);
}

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

/* Custom pagination styles */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}

.pagination-wrapper .nav-links {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.pagination-wrapper a,
.pagination-wrapper span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1rem;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    color: #374151;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
    min-width: 2.5rem;
}

.pagination-wrapper a:hover {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
    text-decoration: none;
}

.pagination-wrapper .current {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.pagination-wrapper .dots {
    background: transparent;
    border: none;
    color: #9ca3af;
}

/* Filter sticky behavior */
@media (max-width: 1024px) {
    .sticky {
        position: relative !important;
    }
}
</style>

<?php get_footer(); ?>
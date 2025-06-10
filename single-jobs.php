<?php
/**
 * Template for single job posts
 */

get_header(); ?>

<div class="min-h-screen bg-gray-50">
    <?php while (have_posts()) : the_post(); 
        // Get job meta data
        $job_meta = yoursite_get_job_meta_fields(get_the_ID());
        
        // Get taxonomies
        $departments = get_the_terms(get_the_ID(), 'job_department');
        $job_types = get_the_terms(get_the_ID(), 'job_type');
        $locations = get_the_terms(get_the_ID(), 'job_location');
        
        $department = $departments ? $departments[0] : null;
        $job_type = $job_types ? $job_types[0] : null;
        $location = $locations ? $locations[0] : null;
    ?>
    
    <!-- Breadcrumb -->
    <section class="bg-white py-6 border-b border-gray-200">
        <div class="container mx-auto px-4">
            <nav class="max-w-4xl mx-auto">
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <a href="/" class="hover:text-blue-600">Home</a>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="/careers" class="hover:text-blue-600">Careers</a>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-900"><?php the_title(); ?></span>
                </div>
            </nav>
        </div>
    </section>

    <!-- Job Header -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-8">
                    <!-- Job Info -->
                    <div class="flex-1">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4"><?php the_title(); ?></h1>
                        
                        <!-- Job Meta -->
                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            <?php if ($department) : ?>
                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    <?php echo $department->name; ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($job_type) : ?>
                                <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    <?php echo $job_type->name; ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($job_meta['job_remote'] === 'yes') : ?>
                                <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Remote
                                </span>
                            <?php elseif ($job_meta['job_remote'] === 'hybrid') : ?>
                                <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                    Hybrid
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($location) : ?>
                                <span class="text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <?php echo $location->name; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Salary & Experience -->
                        <div class="space-y-2 text-gray-600">
                            <?php if ($job_meta['job_salary_min'] || $job_meta['job_salary_max']) : ?>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span><strong>Salary:</strong> 
                                        <?php if ($job_meta['job_salary_min'] && $job_meta['job_salary_max']) : ?>
                                            <?php echo number_format($job_meta['job_salary_min']); ?> - <?php echo number_format($job_meta['job_salary_max']); ?> <?php echo $job_meta['job_salary_currency']; ?>
                                        <?php elseif ($job_meta['job_salary_min']) : ?>
                                            From <?php echo number_format($job_meta['job_salary_min']); ?> <?php echo $job_meta['job_salary_currency']; ?>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($job_meta['job_experience']) : ?>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                    </svg>
                                    <span><strong>Experience:</strong> 
                                        <?php 
                                        $experience_labels = array(
                                            'entry' => 'Entry Level',
                                            'mid' => 'Mid Level', 
                                            'senior' => 'Senior Level',
                                            'lead' => 'Lead/Principal',
                                            'executive' => 'Executive'
                                        );
                                        echo $experience_labels[$job_meta['job_experience']] ?? $job_meta['job_experience'];
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Apply Button -->
                    <div class="lg:w-80">
                        <div class="bg-gray-50 rounded-xl p-6">
                            <?php if ($job_meta['job_status'] === 'open') : ?>
                                <?php if ($job_meta['job_application_url']) : ?>
                                    <a href="<?php echo esc_url($job_meta['job_application_url']); ?>" target="_blank" 
                                       class="btn-primary w-full text-center py-3 px-6 rounded-lg font-semibold mb-4 block">
                                        Apply Now
                                    </a>
                                <?php elseif ($job_meta['job_application_email']) : ?>
                                    <a href="mailto:<?php echo esc_attr($job_meta['job_application_email']); ?>?subject=Application for <?php echo urlencode(get_the_title()); ?>" 
                                       class="btn-primary w-full text-center py-3 px-6 rounded-lg font-semibold mb-4 block">
                                        Apply via Email
                                    </a>
                                <?php else : ?>
                                    <a href="/contact" class="btn-primary w-full text-center py-3 px-6 rounded-lg font-semibold mb-4 block">
                                        Apply Now
                                    </a>
                                <?php endif; ?>
                            <?php else : ?>
                                <div class="btn-secondary w-full text-center py-3 px-6 rounded-lg font-semibold mb-4 opacity-50 cursor-not-allowed">
                                    Position Closed
                                </div>
                            <?php endif; ?>
                            
                            <div class="space-y-3 text-sm">
                                <a href="/careers" class="flex items-center justify-between p-3 bg-white rounded-lg hover:bg-gray-100 transition-colors">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                        </svg>
                                        View All Jobs
                                    </span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                
                                <a href="/contact" class="flex items-center justify-between p-3 bg-white rounded-lg hover:bg-gray-100 transition-colors">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        Questions?
                                    </span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="grid lg:grid-cols-3 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Job Description -->
                        <div class="bg-white rounded-xl p-8 shadow-sm">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Job Description</h2>
                            <?php if (has_excerpt()) : ?>
                                <div class="text-lg text-gray-600 mb-6 p-4 bg-blue-50 rounded-lg">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>
                            <div class="prose prose-lg max-w-none">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                        <!-- Requirements -->
                        <?php if ($job_meta['job_requirements']) : ?>
                        <div class="bg-white rounded-xl p-8 shadow-sm">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Requirements</h2>
                            <div class="space-y-3">
                                <?php 
                                $requirements = explode("\n", $job_meta['job_requirements']);
                                foreach ($requirements as $requirement) : 
                                    $requirement = trim($requirement);
                                    if (!empty($requirement)) :
                                ?>
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <span class="text-gray-700"><?php echo esc_html($requirement); ?></span>
                                    </div>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Benefits -->
                        <?php if ($job_meta['job_benefits']) : ?>
                        <div class="bg-white rounded-xl p-8 shadow-sm">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Benefits & Perks</h2>
                            <div class="space-y-3">
                                <?php 
                                $benefits = explode("\n", $job_meta['job_benefits']);
                                foreach ($benefits as $benefit) : 
                                    $benefit = trim($benefit);
                                    if (!empty($benefit)) :
                                ?>
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-700"><?php echo esc_html($benefit); ?></span>
                                    </div>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Quick Info -->
                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Details</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Department:</span>
                                    <span class="font-medium"><?php echo $department ? $department->name : 'General'; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Job Type:</span>
                                    <span class="font-medium"><?php echo $job_type ? $job_type->name : 'Full-time'; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Location:</span>
                                    <span class="font-medium"><?php echo $location ? $location->name : 'Remote'; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Experience:</span>
                                    <span class="font-medium">
                                        <?php 
                                        $experience_labels = array(
                                            'entry' => 'Entry Level',
                                            'mid' => 'Mid Level', 
                                            'senior' => 'Senior Level',
                                            'lead' => 'Lead/Principal',
                                            'executive' => 'Executive'
                                        );
                                        echo $experience_labels[$job_meta['job_experience']] ?? 'Not specified';
                                        ?>
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Remote Work:</span>
                                    <span class="font-medium">
                                        <?php 
                                        if ($job_meta['job_remote'] === 'yes') echo 'Fully Remote';
                                        elseif ($job_meta['job_remote'] === 'hybrid') echo 'Hybrid';
                                        else echo 'Office';
                                        ?>
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Posted:</span>
                                    <span class="font-medium"><?php echo get_the_date('M j, Y'); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Share Job -->
                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Share This Job</h3>
                            <div class="flex gap-2">
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode('Check out this job: ' . get_the_title()); ?>" 
                                   target="_blank" 
                                   class="flex-1 bg-blue-500 text-white text-center py-2 px-3 rounded text-sm hover:bg-blue-600 transition-colors">
                                    Twitter
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" 
                                   target="_blank" 
                                   class="flex-1 bg-blue-700 text-white text-center py-2 px-3 rounded text-sm hover:bg-blue-800 transition-colors">
                                    LinkedIn
                                </a>
                                <button onclick="navigator.clipboard.writeText('<?php echo get_permalink(); ?>'); alert('Link copied!');" 
                                        class="flex-1 bg-gray-600 text-white text-center py-2 px-3 rounded text-sm hover:bg-gray-700 transition-colors">
                                    Copy Link
                                </button>
                            </div>
                        </div>
                        
                        <!-- Related Jobs -->
                        <?php 
                        $related_jobs = get_posts(array(
                            'post_type' => 'jobs',
                            'posts_per_page' => 3,
                            'post__not_in' => array(get_the_ID()),
                            'meta_query' => array(
                                array(
                                    'key' => '_job_status',
                                    'value' => 'open',
                                    'compare' => '='
                                )
                            ),
                            'tax_query' => $department ? array(
                                array(
                                    'taxonomy' => 'job_department',
                                    'field' => 'term_id',
                                    'terms' => $department->term_id
                                )
                            ) : array()
                        ));
                        
                        if ($related_jobs) :
                        ?>
                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Jobs</h3>
                            <div class="space-y-3">
                                <?php foreach ($related_jobs as $related_job) : ?>
                                    <a href="<?php echo get_permalink($related_job->ID); ?>" 
                                       class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="font-medium text-gray-900 text-sm mb-1"><?php echo $related_job->post_title; ?></div>
                                        <?php 
                                        $related_departments = get_the_terms($related_job->ID, 'job_department');
                                        if ($related_departments) :
                                        ?>
                                            <div class="text-xs text-gray-500"><?php echo $related_departments[0]->name; ?></div>
                                        <?php endif; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
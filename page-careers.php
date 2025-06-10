<?php
/**
 * Template Name: Careers Page
 */

get_header(); 

// Get all open job listings
$jobs = get_posts(array(
    'post_type' => 'jobs',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_query' => array(
        array(
            'key' => '_job_status',
            'value' => 'open',
            'compare' => '='
        )
    ),
    'orderby' => 'date',
    'order' => 'DESC'
));

// Group jobs by department
$jobs_by_department = array();
$departments = get_terms(array(
    'taxonomy' => 'job_department',
    'hide_empty' => true
));

foreach ($jobs as $job) {
    $job_departments = get_the_terms($job->ID, 'job_department');
    $department_name = $job_departments ? $job_departments[0]->name : 'Other';
    
    if (!isset($jobs_by_department[$department_name])) {
        $jobs_by_department[$department_name] = array();
    }
    
    $jobs_by_department[$department_name][] = $job;
}
?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-purple-50 to-blue-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                Join Our Amazing Team
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                We're building the future of e-commerce, one integration at a time. Join our passionate team and help businesses around the world grow and succeed.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-blue-600"><?php echo count($jobs); ?></div>
                    <div class="text-sm text-gray-600">Open Positions</div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-green-600">Remote</div>
                    <div class="text-sm text-gray-600">Work Options</div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-6 py-3">
                    <div class="text-2xl font-bold text-purple-600">Global</div>
                    <div class="text-sm text-gray-600">Team</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company Culture -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Why Work With Us?</h2>
                <p class="text-xl text-gray-600">Join a company that values innovation, collaboration, and personal growth</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Culture Point 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Innovation First</h3>
                    <p class="text-gray-600">We're constantly pushing boundaries and exploring new technologies to stay ahead of the curve.</p>
                </div>
                
                <!-- Culture Point 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Collaborative Team</h3>
                    <p class="text-gray-600">Work with talented individuals from around the world in a supportive, inclusive environment.</p>
                </div>
                
                <!-- Culture Point 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Growth Focused</h3>
                    <p class="text-gray-600">Continuous learning opportunities, mentorship programs, and clear career advancement paths.</p>
                </div>
                
                <!-- Culture Point 4 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Global Impact</h3>
                    <p class="text-gray-600">Help millions of businesses worldwide succeed with our platform and integrations.</p>
                </div>
                
                <!-- Culture Point 5 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Work-Life Balance</h3>
                    <p class="text-gray-600">Flexible schedules, unlimited PTO, and a culture that respects your time and well-being.</p>
                </div>
                
                <!-- Culture Point 6 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Competitive Benefits</h3>
                    <p class="text-gray-600">Great salary, equity, health benefits, and perks that make a real difference.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Open Positions -->
<?php if (!empty($jobs)) : ?>
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Open Positions</h2>
                <p class="text-xl text-gray-600">Find your next opportunity with us</p>
            </div>
            
            <!-- Search and Filter -->
            <div class="flex flex-col lg:flex-row gap-4 mb-8">
                <div class="flex-1">
                    <input type="text" id="job-search" placeholder="Search jobs..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex gap-2">
                    <select id="department-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Departments</option>
                        <?php foreach ($departments as $department) : ?>
                            <option value="<?php echo $department->slug; ?>"><?php echo $department->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="remote-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Locations</option>
                        <option value="yes">Remote</option>
                        <option value="hybrid">Hybrid</option>
                        <option value="no">Office</option>
                    </select>
                </div>
            </div>
            
            <!-- Job Listings -->
            <?php foreach ($jobs_by_department as $department_name => $department_jobs) : ?>
            <div class="mb-12 department-section" data-department="<?php echo sanitize_title($department_name); ?>">
                <h3 class="text-2xl font-bold text-gray-900 mb-6"><?php echo $department_name; ?></h3>
                
                <div class="space-y-4">
                    <?php foreach ($department_jobs as $job) : 
                        $job_meta = yoursite_get_job_meta_fields($job->ID);
                        $job_types = get_the_terms($job->ID, 'job_type');
                        $job_locations = get_the_terms($job->ID, 'job_location');
                    ?>
                    <div class="job-card bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300" 
                         data-title="<?php echo strtolower($job->post_title); ?>"
                         data-department="<?php echo sanitize_title($department_name); ?>"
                         data-remote="<?php echo $job_meta['job_remote']; ?>">
                        
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex-1">
                                <div class="flex items-start gap-4">
                                    <div class="flex-1">
                                        <h4 class="text-xl font-semibold text-gray-900 mb-2"><?php echo $job->post_title; ?></h4>
                                        
                                        <div class="flex flex-wrap items-center gap-4 mb-3">
                                            <!-- Department -->
                                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                                <?php echo $department_name; ?>
                                            </span>
                                            
                                            <!-- Job Type -->
                                            <?php if ($job_types) : ?>
                                                <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                                    <?php echo $job_types[0]->name; ?>
                                                </span>
                                            <?php endif; ?>
                                            
                                            <!-- Remote Badge -->
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
                                            
                                            <!-- Location -->
                                            <?php if ($job_locations) : ?>
                                                <span class="text-sm text-gray-600">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <?php echo $job_locations[0]->name; ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Job Description -->
                                        <?php if ($job->post_excerpt) : ?>
                                            <p class="text-gray-600 mb-4"><?php echo $job->post_excerpt; ?></p>
                                        <?php endif; ?>
                                        
                                        <!-- Salary Range -->
                                        <?php if ($job_meta['job_salary_min'] || $job_meta['job_salary_max']) : ?>
                                            <div class="text-sm text-gray-600">
                                                <strong>Salary:</strong>
                                                <?php if ($job_meta['job_salary_min'] && $job_meta['job_salary_max']) : ?>
                                                    <?php echo number_format($job_meta['job_salary_min']); ?> - <?php echo number_format($job_meta['job_salary_max']); ?> <?php echo $job_meta['job_salary_currency']; ?>
                                                <?php elseif ($job_meta['job_salary_min']) : ?>
                                                    From <?php echo number_format($job_meta['job_salary_min']); ?> <?php echo $job_meta['job_salary_currency']; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 lg:mt-0 lg:ml-6">
                                <a href="<?php echo get_permalink($job->ID); ?>" 
                                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                    View Details
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php else : ?>
<!-- No Jobs Available -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">No Open Positions Right Now</h3>
            <p class="text-gray-600 mb-6">We're not actively hiring at the moment, but we're always looking for exceptional talent. Feel free to send us your resume for future opportunities.</p>
            <a href="/contact" class="btn-primary px-8 py-3 rounded-lg font-semibold">Send Your Resume</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-5xl font-bold mb-6">
                Ready to Make an Impact?
            </h2>
            <p class="text-xl mb-8 opacity-90">
                Join our mission to empower businesses worldwide with seamless integrations
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <?php if (!empty($jobs)) : ?>
                    <a href="#" onclick="document.querySelector('.job-card').scrollIntoView({behavior: 'smooth'})" 
                       class="btn-primary text-lg px-8 py-4 bg-white text-blue-600 hover:bg-gray-100 rounded-lg font-semibold transition-all">
                        View Open Positions
                    </a>
                <?php endif; ?>
                <a href="/contact" class="btn-secondary text-lg px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-blue-600 rounded-lg font-semibold transition-all">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('job-search');
    const departmentFilter = document.getElementById('department-filter');
    const remoteFilter = document.getElementById('remote-filter');
    const jobCards = document.querySelectorAll('.job-card');
    const departmentSections = document.querySelectorAll('.department-section');
    
    function filterJobs() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedDepartment = departmentFilter.value;
        const selectedRemote = remoteFilter.value;
        
        departmentSections.forEach(section => {
            let hasVisibleJobs = false;
            const sectionJobs = section.querySelectorAll('.job-card');
            
            sectionJobs.forEach(card => {
                const title = card.getAttribute('data-title');
                const department = card.getAttribute('data-department');
                const remote = card.getAttribute('data-remote');
                
                let showCard = true;
                
                // Search filter
                if (searchTerm && !title.includes(searchTerm)) {
                    showCard = false;
                }
                
                // Department filter
                if (selectedDepartment && department !== selectedDepartment) {
                    showCard = false;
                }
                
                // Remote filter
                if (selectedRemote && remote !== selectedRemote) {
                    showCard = false;
                }
                
                if (showCard) {
                    card.style.display = 'block';
                    hasVisibleJobs = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show/hide department section
            section.style.display = hasVisibleJobs ? 'block' : 'none';
        });
    }
    
    // Add event listeners
    searchInput.addEventListener('input', filterJobs);
    departmentFilter.addEventListener('change', filterJobs);
    remoteFilter.addEventListener('change', filterJobs);
});
</script>

<style>
.job-card:hover {
    transform: translateY(-2px);
}
</style>

<?php get_footer(); ?>
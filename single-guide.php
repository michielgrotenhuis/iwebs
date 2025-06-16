<?php
/**
 * Template for displaying single guide posts - IMPROVED VERSION
 * Save as: single-guide.php (replace existing)
 */

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        
        $guide_id = get_the_ID();
        $reading_time = yoursite_get_reading_time($guide_id);
        $difficulty = get_post_meta($guide_id, '_guide_difficulty', true) ?: 'beginner';
        $guide_order = get_post_meta($guide_id, '_guide_order', true);
        $categories = get_the_terms($guide_id, 'guide_category');
        $tags = get_the_terms($guide_id, 'guide_tag');
        $progress = yoursite_get_guide_progress($guide_id);
        $navigation = yoursite_get_guide_navigation($guide_id);
        $related_guides = yoursite_get_related_guides($guide_id, 3);
        
        ?>
        <article class="guide-single">
            <!-- Guide Header -->
            <header class="bg-gradient-to-r from-blue-50 to-purple-50 py-16">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto">
                        <!-- Breadcrumb -->
                        <nav class="text-sm text-gray-600 mb-6" aria-label="Breadcrumb">
                            <ol class="flex flex-wrap items-center space-x-2">
                                <li>
                                    <a href="<?php echo home_url(); ?>" class="hover:text-blue-600 transition-colors">Home</a>
                                </li>
                                <li class="text-gray-400">/</li>
                                <li>
                                    <a href="<?php echo get_post_type_archive_link('guide'); ?>" class="hover:text-blue-600 transition-colors">Guides</a>
                                </li>
                                <?php if ($categories && !is_wp_error($categories)) : ?>
                                    <li class="text-gray-400">/</li>
                                    <li>
                                        <a href="<?php echo get_term_link($categories[0]); ?>" class="hover:text-blue-600 transition-colors">
                                            <?php echo esc_html($categories[0]->name); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li class="text-gray-400">/</li>
                                <li class="text-gray-400 truncate">
                                    <?php the_title(); ?>
                                </li>
                            </ol>
                        </nav>
                        
                        <!-- Guide Meta -->
                        <div class="flex flex-wrap gap-3 mb-6">
                            <?php echo yoursite_get_difficulty_badge($difficulty); ?>
                            
                            <?php if ($categories && !is_wp_error($categories)) : ?>
                                <a href="<?php echo get_term_link($categories[0]); ?>" class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium hover:bg-blue-200 transition-colors">
                                    <?php echo esc_html($categories[0]->name); ?>
                                </a>
                            <?php endif; ?>
                            
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?php echo $reading_time; ?> min read
                            </span>
                            
                            <?php if ($progress > 0) : ?>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    Progress: <?php echo $progress; ?>%
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Guide Title -->
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                            <?php the_title(); ?>
                        </h1>
                        
                        <!-- Guide Excerpt -->
                        <?php if (has_excerpt()) : ?>
                            <div class="text-xl text-gray-600 leading-relaxed mb-8">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Guide Meta Info -->
                        <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Last updated: <?php echo get_the_modified_date(); ?>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <?php echo get_post_meta($guide_id, 'guide_views', true) ?: '0'; ?> views
                            </div>
                            
                            <?php if ($tags && !is_wp_error($tags)) : ?>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Tags: 
                                    <?php 
                                    $tag_links = array();
                                    foreach ($tags as $tag) {
                                        $tag_links[] = '<a href="' . get_term_link($tag) . '" class="hover:text-blue-600 transition-colors">' . esc_html($tag->name) . '</a>';
                                    }
                                    echo implode(', ', $tag_links);
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="container mx-auto px-4 py-12">
                <div class="max-w-4xl mx-auto">
                    <div class="grid lg:grid-cols-4 gap-12">
                        <!-- Main Content -->
                        <div class="lg:col-span-3">
                            <!-- Table of Contents (if content has headings) -->
                            <div id="table-of-contents" class="bg-gray-50 rounded-lg p-6 mb-8 hidden">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                    Table of Contents
                                </h3>
                                <div id="toc-list" class="space-y-2"></div>
                            </div>
                            
                            <!-- Guide Content -->
                            <div class="guide-content prose prose-lg max-w-none">
                                <?php 
                                // Get the content and format it properly
                                $content = get_the_content();
                                
                                // Apply WordPress content filters (important for blocks)
                                $content = apply_filters('the_content', $content);
                                
                                // Apply our custom formatting
                                $content = yoursite_format_guide_content($content);
                                
                                // Ensure proper paragraph breaks and spacing
                                $content = wpautop($content);
                                
                                echo $content;
                                ?>
                            </div>
                            
                            <!-- Tags -->
                            <?php if ($tags && !is_wp_error($tags)) : ?>
                                <div class="mt-12 pt-8 border-t border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags</h3>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach ($tags as $tag) : ?>
                                            <a href="<?php echo get_term_link($tag); ?>" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-blue-100 hover:text-blue-800 transition-colors">
                                                #<?php echo esc_html($tag->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Guide Navigation -->
                            <?php if ($navigation['prev'] || $navigation['next']) : ?>
                                <nav class="mt-12 pt-8 border-t border-gray-200" aria-label="Guide navigation">
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <!-- Previous Guide -->
                                        <?php if ($navigation['prev']) : ?>
                                            <a href="<?php echo get_permalink($navigation['prev']->ID); ?>" class="group flex items-center p-6 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                                                <div class="flex-shrink-0 mr-4">
                                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-sm text-gray-500 mb-1">Previous Guide</div>
                                                    <div class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors"><?php echo esc_html($navigation['prev']->post_title); ?></div>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <!-- Next Guide -->
                                        <?php if ($navigation['next']) : ?>
                                            <a href="<?php echo get_permalink($navigation['next']->ID); ?>" class="group flex items-center justify-end p-6 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors <?php echo !$navigation['prev'] ? 'md:col-start-2' : ''; ?>">
                                                <div class="text-right mr-4">
                                                    <div class="text-sm text-gray-500 mb-1">Next Guide</div>
                                                    <div class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors"><?php echo esc_html($navigation['next']->post_title); ?></div>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </nav>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="sticky top-8 space-y-8">
                                <!-- Progress Indicator -->
                                <?php if ($progress > 0) : ?>
                                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Progress</h3>
                                        <div class="relative">
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: <?php echo $progress; ?>%"></div>
                                            </div>
                                            <div class="text-sm text-gray-600 mt-2"><?php echo $progress; ?>% Complete</div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Quick Links -->
                                <div class="bg-white border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
                                    <div class="space-y-3">
                                        <?php if ($categories && !is_wp_error($categories)) : ?>
                                            <a href="<?php echo get_term_link($categories[0]); ?>" class="flex items-center text-gray-600 hover:text-blue-600 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                                All <?php echo esc_html($categories[0]->name); ?> Guides
                                            </a>
                                        <?php endif; ?>
                                        
                                        <a href="<?php echo get_post_type_archive_link('guide'); ?>" class="flex items-center text-gray-600 hover:text-blue-600 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            Browse All Guides
                                        </a>
                                        
                                        <a href="#" onclick="window.print(); return false;" class="flex items-center text-gray-600 hover:text-blue-600 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                            Print Guide
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Related Guides -->
                                <?php if (!empty($related_guides)) : ?>
                                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Guides</h3>
                                        <div class="space-y-4">
                                            <?php foreach ($related_guides as $related) : ?>
                                                <a href="<?php echo get_permalink($related->ID); ?>" class="block group">
                                                    <h4 class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 mb-1">
                                                        <?php echo esc_html($related->post_title); ?>
                                                    </h4>
                                                    <div class="text-sm text-gray-500">
                                                        <?php echo yoursite_get_reading_time($related->ID); ?> min read
                                                    </div>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        
        <!-- Enhanced JavaScript for guide functionality -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            generateTableOfContents();
            trackReadingProgress();
            improveLinkTargets();
            addCopyCodeButtons();
        });
        
        function generateTableOfContents() {
            const headings = document.querySelectorAll('.guide-content h2, .guide-content h3, .guide-content h4');
            const tocContainer = document.getElementById('table-of-contents');
            const tocList = document.getElementById('toc-list');
            
            if (headings.length < 2) return;
            
            tocContainer.classList.remove('hidden');
            
            headings.forEach((heading, index) => {
                const id = `heading-${index}`;
                heading.id = id;
                
                const link = document.createElement('a');
                link.href = `#${id}`;
                link.textContent = heading.textContent;
                link.className = `block text-sm text-gray-600 hover:text-blue-600 transition-colors py-1 ${
                    heading.tagName === 'H3' ? 'pl-4' : heading.tagName === 'H4' ? 'pl-8' : ''
                }`;
                
                // Smooth scroll
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    heading.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    window.history.pushState(null, null, `#${id}`);
                });
                
                tocList.appendChild(link);
            });
        }
        
        function trackReadingProgress() {
            let maxScroll = 0;
            window.addEventListener('scroll', function() {
                const scrollPercent = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
                if (scrollPercent > maxScroll) {
                    maxScroll = scrollPercent;
                    
                    // Update progress bar if it exists
                    const progressBar = document.querySelector('.bg-blue-600');
                    if (progressBar) {
                        const currentProgress = parseInt(progressBar.style.width) || 0;
                        const newProgress = Math.min(100, Math.max(currentProgress, Math.round(scrollPercent)));
                        progressBar.style.width = newProgress + '%';
                        
                        const progressText = document.querySelector('.bg-white .text-sm.text-gray-600');
                        if (progressText) {
                            progressText.textContent = newProgress + '% Complete';
                        }
                    }
                }
            });
        }
        
        function improveLinkTargets() {
            // Open external links in new tab
            const links = document.querySelectorAll('.guide-content a[href^="http"]');
            links.forEach(link => {
                if (!link.href.includes(window.location.hostname)) {
                    link.target = '_blank';
                    link.rel = 'noopener noreferrer';
                }
            });
        }
        
        function addCopyCodeButtons() {
            const codeBlocks = document.querySelectorAll('.guide-content pre code');
            codeBlocks.forEach(code => {
                const pre = code.parentElement;
                pre.style.position = 'relative';
                
                const button = document.createElement('button');
                button.className = 'copy-code-btn absolute top-2 right-2 bg-gray-700 text-white px-2 py-1 rounded text-xs hover:bg-gray-600 transition-colors opacity-75 hover:opacity-100';
                button.textContent = 'Copy';
                button.setAttribute('aria-label', 'Copy code to clipboard');
                
                button.addEventListener('click', function() {
                    const text = code.textContent;
                    navigator.clipboard.writeText(text).then(function() {
                        button.textContent = 'Copied!';
                        button.className = button.className.replace('bg-gray-700 hover:bg-gray-600', 'bg-green-600 hover:bg-green-700');
                        setTimeout(function() {
                            button.textContent = 'Copy';
                            button.className = button.className.replace('bg-green-600 hover:bg-green-700', 'bg-gray-700 hover:bg-gray-600');
                        }, 2000);
                    });
                });
                
                pre.appendChild(button);
            });
        }
        </script>
        
        <?php
    endwhile;
endif;

get_footer();
?>
<?php
/*
Template Name: DIFM - Do It For Me Page
*/

get_header(); ?>

<?php if (get_theme_mod('difm_hero_enable', true)) : ?>
<!-- Hero Section -->
<section class="py-20 bg-gray-900 dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6">
                <?php echo esc_html(get_theme_mod('difm_hero_title', __('Let Us Build Your Dream Website', 'yoursite'))); ?>
            </h1>
            <p class="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">
                <?php echo esc_html(get_theme_mod('difm_hero_subtitle', __('Professional website design and development service. Choose your package and let our experts handle everything while you focus on your business.', 'yoursite'))); ?>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#packages" class="btn-primary text-lg px-8 py-4 rounded-lg font-semibold hover-lift">
                    <?php echo esc_html(get_theme_mod('difm_hero_cta_text', __('View Packages', 'yoursite'))); ?>
                </a>
                <a href="#how-it-works" class="btn-secondary text-lg px-8 py-4 rounded-lg font-semibold hover-lift">
                    <?php echo esc_html(get_theme_mod('difm_hero_secondary_cta', __('How It Works', 'yoursite'))); ?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('difm_benefits_enable', true)) : ?>
<!-- Benefits Section -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('difm_benefits_title', __('Why Choose Our DIFM Service?', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('difm_benefits_subtitle', __('Professional results without the hassle', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php 
                $benefits_icons = array(
                    1 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>',
                    2 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                    3 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                    4 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>'
                );
                
                for ($i = 1; $i <= 4; $i++) {
                    if (get_theme_mod("difm_benefit_{$i}_enable", true)) :
                        $title = get_theme_mod("difm_benefit_{$i}_title", '');
                        $description = get_theme_mod("difm_benefit_{$i}_description", '');
                        $color = get_theme_mod("difm_benefit_{$i}_color", '#3b82f6');
                        ?>
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-lg mx-auto mb-4 flex items-center justify-center" style="background-color: <?php echo esc_attr($color); ?>20;">
                                <svg class="w-8 h-8" style="color: <?php echo esc_attr($color); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php echo $benefits_icons[$i]; ?>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 dark:text-white"><?php echo esc_html($title); ?></h3>
                            <p class="text-gray-600 dark:text-gray-300"><?php echo esc_html($description); ?></p>
                        </div>
                        <?php
                    endif;
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('difm_packages_enable', true)) : ?>
<!-- Packages Section -->
<section id="packages" class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('difm_packages_title', __('Choose Your Perfect Package', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('difm_packages_subtitle', __('All packages include free project implementation and professional design', 'yoursite'))); ?>
                </p>
            </div>
            
            <!-- Package Cards -->
            <div class="grid lg:grid-cols-3 gap-8 mb-16">
                <?php
                // Get DIFM packages from database
                $packages = get_posts(array(
                    'post_type' => 'difm_packages',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'meta_key' => '_package_order',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC'
                ));
                
                if ($packages) :
                    foreach ($packages as $package) :
                        $package_id = $package->ID;
                        $price = get_post_meta($package_id, '_package_price', true);
                        $currency = get_post_meta($package_id, '_package_currency', true) ?: '$';
                        $featured = get_post_meta($package_id, '_package_featured', true);
                        $features = get_post_meta($package_id, '_package_features', true);
                        $order_url = get_post_meta($package_id, '_package_order_url', true);
                        ?>
                        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-8 <?php echo $featured ? 'ring-2 ring-blue-500' : ''; ?>">
                            <?php if ($featured) : ?>
                                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                    <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-1 rounded-full text-sm font-medium">
                                        <?php _e('Most Popular', 'yoursite'); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="text-center mb-8">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2"><?php echo esc_html($package->post_title); ?></h3>
                                <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                                    <?php echo esc_html($currency . $price); ?>
                                    <span class="text-lg font-normal text-gray-500">.00</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300"><?php echo esc_html($package->post_excerpt); ?></p>
                            </div>
                            
                            <?php if ($features) : ?>
                                <ul class="space-y-3 mb-8">
                                    <?php 
                                    $features_array = explode("\n", $features);
                                    foreach ($features_array as $feature) :
                                        $feature = trim($feature);
                                        if (!empty($feature)) :
                                            $included = strpos($feature, '✅') !== false;
                                            $feature_text = str_replace(array('✅', '❌'), '', $feature);
                                    ?>
                                        <li class="flex items-center">
                                            <?php if ($included) : ?>
                                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            <?php else : ?>
                                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            <?php endif; ?>
                                            <span class="text-gray-700 dark:text-gray-300"><?php echo esc_html(trim($feature_text)); ?></span>
                                        </li>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </ul>
                            <?php endif; ?>
                            
                            <button class="w-full <?php echo $featured ? 'btn-primary' : 'btn-secondary'; ?> py-3 px-6 rounded-lg font-semibold transition-all duration-200 hover-lift"
                                    onclick="startOnboarding('<?php echo esc_js($package->post_title); ?>', '<?php echo esc_js($currency . $price); ?>', <?php echo esc_js($package_id); ?>)">
                                <?php _e('Order Now', 'yoursite'); ?>
                            </button>
                        </div>
                        <?php
                    endforeach;
                else :
                    // Fallback if no packages exist
                    ?>
                    <div class="col-span-3 text-center py-12">
                        <p class="text-gray-600 dark:text-gray-300"><?php _e('No packages available at the moment. Please check back soon!', 'yoursite'); ?></p>
                    </div>
                    <?php
                endif;
                ?>
            </div>
            
            <!-- Feature Comparison Table -->
            <?php if (get_theme_mod('difm_comparison_enable', true)) : ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <?php echo esc_html(get_theme_mod('difm_comparison_title', __('Detailed Feature Comparison', 'yoursite'))); ?>
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Feature</th>
                                <?php if ($packages) : foreach ($packages as $package) : ?>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <?php echo esc_html($package->post_title); ?>
                                    </th>
                                <?php endforeach; endif; ?>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <?php
                            // Get comparison features
                            $comparison_features = get_option('difm_comparison_features', array());
                            if (!empty($comparison_features)) :
                                foreach ($comparison_features as $feature) :
                            ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        <?php echo esc_html($feature['name']); ?>
                                    </td>
                                    <?php if ($packages) : foreach ($packages as $package) : 
                                        $package_id = $package->ID;
                                        $feature_value = isset($feature['packages'][$package_id]) ? $feature['packages'][$package_id] : '';
                                    ?>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            <?php if ($feature_value === '✅') : ?>
                                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            <?php elseif ($feature_value === '❌') : ?>
                                                <svg class="w-5 h-5 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            <?php else : ?>
                                                <span class="text-gray-700 dark:text-gray-300"><?php echo esc_html($feature_value); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; endif; ?>
                                </tr>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('difm_process_enable', true)) : ?>
<!-- How It Works Section -->
<section id="how-it-works" class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('difm_process_title', __('How Our Process Works', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('difm_process_subtitle', __('Simple, straightforward, and professional', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-4 gap-8">
                <?php 
                $process_steps = array(
                    1 => array('icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>'),
                    2 => array('icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011 1v8a1 1 0 01-1 1m-1 0H8a1 1 0 01-1-1V4m2 5V6a1 1 0 011-1h4a1 1 0 011 1v3M9 21v-1a1 1 0 011-1h4a1 1 0 011 1v1"></path>'),
                    3 => array('icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>'),
                    4 => array('icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>')
                );
                
                for ($i = 1; $i <= 4; $i++) {
                    if (get_theme_mod("difm_step_{$i}_enable", true)) :
                        $title = get_theme_mod("difm_step_{$i}_title", '');
                        $description = get_theme_mod("difm_step_{$i}_description", '');
                        ?>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full mx-auto mb-4 flex items-center justify-center">
                                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400"><?php echo $i; ?></span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 dark:text-white"><?php echo esc_html($title); ?></h3>
                            <p class="text-gray-600 dark:text-gray-300"><?php echo esc_html($description); ?></p>
                        </div>
                        <?php
                    endif;
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Onboarding Modal -->
<div id="onboarding-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl max-w-2xl w-full max-h-screen overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Let's Get Started</h3>
                    <button onclick="closeOnboarding()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progress</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300" id="progress-text">1 of 4</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" id="progress-bar" style="width: 25%"></div>
                    </div>
                </div>
                
                <!-- Onboarding Form -->
                <form id="onboarding-form">
                    <!-- Step 1: Package Selection -->
                    <div class="step-content" id="step-1">
                        <h4 class="text-xl font-semibold mb-4 dark:text-white">Package Selected</h4>
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg mb-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h5 class="font-semibold text-blue-900 dark:text-blue-100" id="selected-package">Standard Package</h5>
                                    <p class="text-blue-700 dark:text-blue-300">Professional website design service</p>
                                </div>
                                <div class="text-2xl font-bold text-blue-900 dark:text-blue-100" id="selected-price">$120.00</div>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">Let's gather some basic information to get started with your project.</p>
                    </div>
                    
                    <!-- Step 2: Contact Information -->
                    <div class="step-content hidden" id="step-2">
                        <h4 class="text-xl font-semibold mb-4 dark:text-white">Contact Information</h4>
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name *</label>
                                <input type="text" id="first_name" name="first_name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name *</label>
                                <input type="text" id="last_name" name="last_name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                    </div>
                    
                    <!-- Step 3: Business Information -->
                    <div class="step-content hidden" id="step-3">
                        <h4 class="text-xl font-semibold mb-4 dark:text-white">Business Information</h4>
                        <div class="mb-4">
                            <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Company Name *</label>
                            <input type="text" id="company_name" name="company_name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div class="mb-4">
                            <label for="business_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type of Business *</label>
                            <select id="business_type" name="business_type" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select business type</option>
                                <option value="e-commerce">E-commerce Store</option>
                                <option value="service">Service Business</option>
                                <option value="restaurant">Restaurant/Food</option>
                                <option value="healthcare">Healthcare</option>
                                <option value="education">Education</option>
                                <option value="nonprofit">Non-profit</option>
                                <option value="portfolio">Portfolio/Personal</option>
                                <option value="blog">Blog/Content</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="website_purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Main Purpose of Website</label>
                            <textarea id="website_purpose" name="website_purpose" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Tell us what you want to achieve with your website..."></textarea>
                        </div>
                    </div>
                    
                    <!-- Step 4: Design Preferences -->
                    <div class="step-content hidden" id="step-4">
                        <h4 class="text-xl font-semibold mb-4 dark:text-white">Design Preferences</h4>
                        <div class="mb-4">
                            <label for="design_style" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preferred Design Style</label>
                            <select id="design_style" name="design_style" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select style preference</option>
                                <option value="modern">Modern & Clean</option>
                                <option value="classic">Classic & Traditional</option>
                                <option value="creative">Creative & Artistic</option>
                                <option value="minimal">Minimal & Simple</option>
                                <option value="bold">Bold & Colorful</option>
                                <option value="professional">Professional & Corporate</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="reference_sites" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reference Websites</label>
                            <textarea id="reference_sites" name="reference_sites" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Share any websites you like the design of..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="color_preferences" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Color Preferences</label>
                            <input type="text" id="color_preferences" name="color_preferences" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="e.g., Blue and white, earth tones, bright colors...">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Do you have a logo?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio" name="has_logo" value="yes" class="mr-2">
                                    <span class="text-gray-700 dark:text-gray-300">Yes, I have a logo</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="has_logo" value="no" class="mr-2">
                                    <span class="text-gray-700 dark:text-gray-300">No, I need one created</span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Special Requests or Requirements</label>
                            <textarea id="special_requests" name="special_requests" rows="4" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Any specific features, functionality, or requirements you'd like to mention..."></textarea>
                        </div>
                    </div>
                    
                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-8">
                        <button type="button" id="prev-btn" onclick="previousStep()" class="btn-secondary px-6 py-2 rounded-lg hidden">
                            Previous
                        </button>
                        <div class="flex-1"></div>
                        <button type="button" id="next-btn" onclick="nextStep()" class="btn-primary px-6 py-2 rounded-lg">
                            Next
                        </button>
                        <button type="submit" id="submit-btn" class="btn-primary px-6 py-2 rounded-lg hidden">
                            Submit Project Request
                        </button>
                    </div>
                    
                    <!-- Hidden fields -->
                    <input type="hidden" id="selected_package_id" name="selected_package_id">
                    <input type="hidden" id="selected_package_name" name="selected_package_name">
                    <input type="hidden" id="selected_package_price" name="selected_package_price">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let currentStep = 1;
const totalSteps = 4;

function startOnboarding(packageName, packagePrice, packageId) {
    document.getElementById('selected-package').textContent = packageName;
    document.getElementById('selected-price').textContent = packagePrice;
    document.getElementById('selected_package_id').value = packageId;
    document.getElementById('selected_package_name').value = packageName;
    document.getElementById('selected_package_price').value = packagePrice;
    
    document.getElementById('onboarding-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    currentStep = 1;
    updateStep();
}

function closeOnboarding() {
    document.getElementById('onboarding-modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Reset form
    document.getElementById('onboarding-form').reset();
    currentStep = 1;
    updateStep();
}

function nextStep() {
    if (validateCurrentStep()) {
        if (currentStep < totalSteps) {
            currentStep++;
            updateStep();
        }
    }
}

function previousStep() {
    if (currentStep > 1) {
        currentStep--;
        updateStep();
    }
}

function updateStep() {
    // Hide all steps
    document.querySelectorAll('.step-content').forEach(step => {
        step.classList.add('hidden');
    });
    
    // Show current step
    document.getElementById(`step-${currentStep}`).classList.remove('hidden');
    
    // Update progress bar
    const progress = (currentStep / totalSteps) * 100;
    document.getElementById('progress-bar').style.width = `${progress}%`;
    document.getElementById('progress-text').textContent = `${currentStep} of ${totalSteps}`;
    
    // Update buttons
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-btn');
    
    if (currentStep === 1) {
        prevBtn.classList.add('hidden');
    } else {
        prevBtn.classList.remove('hidden');
    }
    
    if (currentStep === totalSteps) {
        nextBtn.classList.add('hidden');
        submitBtn.classList.remove('hidden');
    } else {
        nextBtn.classList.remove('hidden');
        submitBtn.classList.add('hidden');
    }
}

function validateCurrentStep() {
    const currentStepElement = document.getElementById(`step-${currentStep}`);
    const requiredFields = currentStepElement.querySelectorAll('[required]');
    
    for (let field of requiredFields) {
        if (!field.value.trim()) {
            field.focus();
            field.classList.add('border-red-500');
            setTimeout(() => {
                field.classList.remove('border-red-500');
            }, 3000);
            return false;
        }
    }
    
    return true;
}

// Form submission
document.getElementById('onboarding-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!validateCurrentStep()) {
        return;
    }
    
    const formData = new FormData(this);
    formData.append('action', 'submit_difm_request');
    formData.append('nonce', '<?php echo wp_create_nonce('difm_request_nonce'); ?>');
    
    const submitBtn = document.getElementById('submit-btn');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Submitting...';
    submitBtn.disabled = true;
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            alert('Thank you! Your project request has been submitted. We\'ll contact you within 24 hours to discuss your project.');
            closeOnboarding();
        } else {
            alert('There was an error submitting your request. Please try again or contact us directly.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error submitting your request. Please try again or contact us directly.');
    })
    .finally(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
});

// Close modal when clicking outside
document.getElementById('onboarding-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeOnboarding();
    }
});

// Smooth scroll to packages section
document.addEventListener('DOMContentLoaded', function() {
    const packagesLink = document.querySelector('a[href="#packages"]');
    if (packagesLink) {
        packagesLink.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('packages').scrollIntoView({
                behavior: 'smooth'
            });
        });
    }
    
    const howItWorksLink = document.querySelector('a[href="#how-it-works"]');
    if (howItWorksLink) {
        howItWorksLink.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('how-it-works').scrollIntoView({
                behavior: 'smooth'
            });
        });
    }
});
</script>

<?php get_footer(); ?>
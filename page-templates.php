<?php
/*
Template Name: Templates Page
*/

get_header(); ?>

<?php if (get_theme_mod('templates_hero_enable', true)) : ?>
<!-- Hero Section -->
<section class="templates-hero-section py-20" style="background: linear-gradient(to bottom right, <?php echo esc_attr(get_theme_mod('templates_hero_bg_color', '#f3e8ff')); ?>, <?php echo esc_attr(get_theme_mod('templates_hero_bg_color_end', '#fce7f3')); ?>);">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="templates-hero-title text-4xl lg:text-6xl font-bold mb-6">
                <?php echo esc_html(get_theme_mod('templates_hero_title', __('Beautiful templates for every business', 'yoursite'))); ?>
            </h1>
            <p class="templates-hero-subtitle text-xl mb-8 max-w-3xl mx-auto">
                <?php echo esc_html(get_theme_mod('templates_hero_subtitle', __('Choose from 100+ professionally designed templates. All mobile-responsive, SEO-optimized, and ready to customize for your brand.', 'yoursite'))); ?>
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <button class="template-filter-btn active px-6 py-3 bg-purple-500 text-white rounded-lg font-medium hover:bg-purple-600 transition-colors" data-filter="all">All Templates</button>
                <button class="template-filter-btn px-6 py-3 bg-white text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors" data-filter="fashion">Fashion</button>
                <button class="template-filter-btn px-6 py-3 bg-white text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors" data-filter="electronics">Electronics</button>
                <button class="template-filter-btn px-6 py-3 bg-white text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors" data-filter="food">Food & Drink</button>
                <button class="template-filter-btn px-6 py-3 bg-white text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors" data-filter="home">Home & Garden</button>
                <button class="template-filter-btn px-6 py-3 bg-white text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors" data-filter="beauty">Beauty</button>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('templates_featured_enable', true)) : ?>
<!-- Featured Templates -->
<section class="templates-featured-section py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="templates-section-title text-3xl lg:text-4xl font-bold mb-4">
                    <?php echo esc_html(get_theme_mod('templates_featured_title', __('Featured Templates', 'yoursite'))); ?>
                </h2>
                <p class="templates-section-subtitle text-xl">
                    <?php echo esc_html(get_theme_mod('templates_featured_subtitle', __('Our most popular and versatile designs', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                <?php 
                // Featured Template Icons
                $template_icons = array(
                    1 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>',
                    2 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>',
                    3 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m-2.4 0L5 21h14"></path>'
                );
                
                for ($i = 1; $i <= 3; $i++) :
                    if (get_theme_mod("templates_featured_template_{$i}_enable", true)) :
                        $template_name = get_theme_mod("templates_featured_template_{$i}_name", "Template {$i}");
                        $template_desc = get_theme_mod("templates_featured_template_{$i}_description", "Professional template description");
                        $template_category = get_theme_mod("templates_featured_template_{$i}_category", "Business");
                        $template_rating = get_theme_mod("templates_featured_template_{$i}_rating", '4.8');
                        $icon_color = get_theme_mod("templates_featured_template_{$i}_icon_color", '#ec4899');
                ?>
                <!-- Template <?php echo $i; ?> -->
                <div class="template-card <?php echo strtolower(str_replace(' ', '', $template_category)); ?> templates-card bg-white rounded-lg shadow-sm overflow-hidden feature-card border border-gray-200">
                    <div class="relative group">
                        <div class="aspect-w-16 aspect-h-12 h-48" style="background: linear-gradient(to bottom right, <?php echo esc_attr($icon_color); ?>20, <?php echo esc_attr($icon_color); ?>40);">
                            <div class="flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-20 h-20 rounded-lg mx-auto mb-4 flex items-center justify-center" style="background-color: <?php echo esc_attr($icon_color); ?>40;">
                                        <svg class="w-10 h-10" style="color: <?php echo esc_attr($icon_color); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <?php echo $template_icons[$i]; ?>
                                        </svg>
                                    </div>
                                    <p class="template-preview-text text-gray-600 font-medium"><?php echo esc_html($template_category); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="#" class="btn-primary mr-3">Preview</a>
                                <a href="#" class="btn-secondary">Use Template</a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="template-card-title text-xl font-semibold mb-2"><?php echo esc_html($template_name); ?></h3>
                        <p class="template-card-description text-gray-600 mb-4"><?php echo esc_html($template_desc); ?></p>
                        <div class="flex items-center justify-between">
                            <span class="template-card-category text-sm text-gray-500"><?php echo esc_html($template_category); ?></span>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="template-card-rating text-sm text-gray-600 ml-1"><?php echo esc_html($template_rating); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    endif;
                endfor; 
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('templates_grid_enable', true)) : ?>
<!-- All Templates Grid -->
<section class="templates-grid-section py-20" style="background-color: <?php echo esc_attr(get_theme_mod('templates_grid_bg_color', '#f9fafb')); ?>;">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="templates-section-title text-3xl lg:text-4xl font-bold mb-4">
                    <?php echo esc_html(get_theme_mod('templates_grid_title', __('All Templates', 'yoursite'))); ?>
                </h2>
                <p class="templates-section-subtitle text-xl">
                    <?php echo esc_html(get_theme_mod('templates_grid_subtitle', __('Browse our complete collection of templates', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6" id="templates-grid">
                <!-- Template Grid Items -->
                <div class="template-card home templates-card bg-white rounded-lg shadow-sm overflow-hidden feature-card border border-gray-200">
                    <div class="relative group">
                        <div class="bg-gradient-to-br from-green-100 to-teal-100 h-32">
                            <div class="flex items-center justify-center h-full">
                                <div class="w-16 h-16 bg-green-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="#" class="text-white bg-white bg-opacity-20 px-4 py-2 rounded-lg mr-2 hover:bg-opacity-30">Preview</a>
                                <a href="#" class="text-white bg-blue-500 px-4 py-2 rounded-lg hover:bg-blue-600">Use</a>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="template-grid-title font-semibold mb-1">Organic Market</h4>
                        <p class="template-grid-category text-sm text-gray-600 mb-2">Food & Drink</p>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="template-grid-rating text-sm text-gray-600 ml-1">4.6</span>
                        </div>
                    </div>
                </div>

                <div class="template-card home templates-card bg-white rounded-lg shadow-sm overflow-hidden feature-card border border-gray-200">
                    <div class="relative group">
                        <div class="bg-gradient-to-br from-teal-100 to-green-100 h-32">
                            <div class="flex items-center justify-center h-full">
                                <div class="w-16 h-16 bg-teal-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="#" class="text-white bg-white bg-opacity-20 px-4 py-2 rounded-lg mr-2 hover:bg-opacity-30">Preview</a>
                                <a href="#" class="text-white bg-blue-500 px-4 py-2 rounded-lg hover:bg-blue-600">Use</a>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="template-grid-title font-semibold mb-1">Garden Oasis</h4>
                        <p class="template-grid-category text-sm text-gray-600 mb-2">Home & Garden</p>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="template-grid-rating text-sm text-gray-600 ml-1">4.4</span>
                        </div>
                    </div>
                </div>

                <div class="template-card beauty templates-card bg-white rounded-lg shadow-sm overflow-hidden feature-card border border-gray-200">
                    <div class="relative group">
                        <div class="bg-gradient-to-br from-rose-100 to-pink-100 h-32">
                            <div class="flex items-center justify-center h-full">
                                <div class="w-16 h-16 bg-rose-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="#" class="text-white bg-white bg-opacity-20 px-4 py-2 rounded-lg mr-2 hover:bg-opacity-30">Preview</a>
                                <a href="#" class="text-white bg-blue-500 px-4 py-2 rounded-lg hover:bg-blue-600">Use</a>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="template-grid-title font-semibold mb-1">Glow Studio</h4>
                        <p class="template-grid-category text-sm text-gray-600 mb-2">Beauty</p>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="template-grid-rating text-sm text-gray-600 ml-1">4.9</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Load More Button -->
            <div class="text-center mt-12">
                <button class="btn-secondary">Load More Templates</button>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('templates_features_enable', true)) : ?>
<!-- Template Features -->
<section class="templates-features-section py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="templates-section-title text-3xl lg:text-4xl font-bold mb-4">
                    <?php echo esc_html(get_theme_mod('templates_features_title', __('Why Choose Our Templates?', 'yoursite'))); ?>
                </h2>
                <p class="templates-section-subtitle text-xl">
                    <?php echo esc_html(get_theme_mod('templates_features_subtitle', __('Every template is built with best practices and conversion optimization', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php 
                // Feature icons
                $feature_icons = array(
                    1 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>',
                    2 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>',
                    3 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>',
                    4 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>'
                );
                $feature_colors = array(1 => 'blue', 2 => 'green', 3 => 'purple', 4 => 'orange');
                
                for ($i = 1; $i <= 4; $i++) :
                    if (get_theme_mod("templates_feature_{$i}_enable", true)) :
                        $feature_title = get_theme_mod("templates_feature_{$i}_title", "Feature {$i}");
                        $feature_desc = get_theme_mod("templates_feature_{$i}_description", "Feature description");
                ?>
                <div class="text-center">
                    <div class="w-16 h-16 bg-<?php echo $feature_colors[$i]; ?>-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-<?php echo $feature_colors[$i]; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?php echo $feature_icons[$i]; ?>
                        </svg>
                    </div>
                    <h3 class="templates-feature-title text-xl font-semibold mb-3">
                        <?php echo esc_html($feature_title); ?>
                    </h3>
                    <p class="templates-feature-description">
                        <?php echo esc_html($feature_desc); ?>
                    </p>
                </div>
                <?php 
                    endif;
                endfor; 
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>



<style>
/* Templates Page Dark Mode Styles */

/* Hero Section */
.templates-hero-section {
    background: linear-gradient(to bottom right, rgb(250 245 255), rgb(252 231 243));
}

body.dark-mode .templates-hero-section {
    background: linear-gradient(to bottom right, var(--bg-secondary), var(--bg-tertiary));
}

.templates-hero-title {
    color: var(--text-primary);
}

.templates-hero-subtitle {
    color: var(--text-tertiary);
}

/* Featured Templates Section */
.templates-featured-section {
    background-color: var(--bg-primary);
}

/* Grid Section */
.templates-grid-section {
    background-color: var(--bg-secondary);
}

/* Features Section */
.templates-features-section {
    background-color: var(--bg-primary);
}

/* CTA Section */
.templates-cta-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Template Cards */
.template-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.template-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Filter Buttons */
.template-filter-btn.active {
    background-color: #8b5cf6;
    color: white;
}

.template-filter-btn:hover {
    background-color: #f3f4f6;
}

.template-filter-btn.active:hover {
    background-color: #7c3aed;
}

/* Button Styles */
.btn-primary {
    background-color: #3b82f6;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #2563eb;
}

.btn-secondary {
    background-color: white;
    color: #374151;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    text-decoration: none;
    border: 1px solid #d1d5db;
    transition: background-color 0.3s ease;
}

.btn-secondary:hover {
    background-color: #f9fafb;
}

.templates-cta-primary {
    background-color: white;
    color: #1f2937;
    border-radius: 0.5rem;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.templates-cta-primary:hover {
    background-color: #f9fafb;
    transform: translateY(-2px);
}

.templates-cta-secondary {
    background-color: transparent;
    color: white;
    border: 2px solid white;
    border-radius: 0.5rem;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.templates-cta-secondary:hover {
    background-color: white;
    color: #1f2937;
    transform: translateY(-2px);
}

/* Dark mode styles */
body.dark-mode .template-card {
    background-color: var(--bg-secondary);
    border-color: var(--border-color);
}

body.dark-mode .templates-section-title {
    color: var(--text-primary);
}

body.dark-mode .templates-section-subtitle {
    color: var(--text-secondary);
}

body.dark-mode .template-card-title {
    color: var(--text-primary);
}

body.dark-mode .template-card-description {
    color: var(--text-secondary);
}

body.dark-mode .template-grid-title {
    color: var(--text-primary);
}

body.dark-mode .templates-feature-title {
    color: var(--text-primary);
}

body.dark-mode .templates-feature-description {
    color: var(--text-secondary);
}

body.dark-mode .template-filter-btn {
    background-color: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

body.dark-mode .template-filter-btn:hover {
    background-color: var(--bg-tertiary);
}

body.dark-mode .template-filter-btn.active {
    background-color: #8b5cf6;
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .templates-hero-title {
        font-size: 2.5rem;
        line-height: 1.2;
    }
    
    .templates-hero-subtitle {
        font-size: 1.125rem;
    }
    
    .grid.md\\:grid-cols-2.lg\\:grid-cols-3 {
        grid-template-columns: 1fr;
    }
    
    .grid.md\\:grid-cols-2.lg\\:grid-cols-4 {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .flex.flex-wrap.justify-center.gap-4 {
        flex-direction: column;
        align-items: stretch;
    }
    
    .template-filter-btn {
        width: 100%;
        text-align: center;
    }
}
</style>

<script>
// Template filtering functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.template-filter-btn');
    const templateCards = document.querySelectorAll('.template-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter templates
            templateCards.forEach(card => {
                if (filter === 'all' || card.classList.contains(filter.toLowerCase())) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.5s ease-in-out';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Load more functionality
    const loadMoreBtn = document.querySelector('.btn-secondary');
    if (loadMoreBtn && loadMoreBtn.textContent.includes('Load More')) {
        loadMoreBtn.addEventListener('click', function() {
            // This would typically load more templates via AJAX
            console.log('Loading more templates...');
            this.textContent = 'Loading...';
            
            // Simulate loading delay
            setTimeout(() => {
                this.textContent = 'Load More Templates';
                // Add your AJAX logic here
            }, 1000);
        });
    }
});

// Add fade-in animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);
</script>

<?php get_footer(); ?>
<?php
/**
 * Template for single feature pages
 * File: single-feature_pages.php
 */

get_header();

// Get feature page data
$post_id = get_the_ID();
$hero_subtitle = get_post_meta($post_id, '_feature_hero_subtitle', true);
$hero_bg_type = get_post_meta($post_id, '_feature_hero_bg_type', true) ?: 'gradient';
$hero_bg_image = get_post_meta($post_id, '_feature_hero_bg_image', true);
$hero_gradient_primary = get_post_meta($post_id, '_feature_hero_gradient_primary', true) ?: '#1e3a8a';
$hero_gradient_secondary = get_post_meta($post_id, '_feature_hero_gradient_secondary', true) ?: '#7c3aed';
$hero_cta_text = get_post_meta($post_id, '_feature_hero_cta_text', true) ?: 'Learn More';
$hero_cta_url = get_post_meta($post_id, '_feature_hero_cta_url', true);

$capabilities = get_post_meta($post_id, '_feature_capabilities', true) ?: array();
$setup_steps = get_post_meta($post_id, '_feature_setup_steps', true);
$api_info = get_post_meta($post_id, '_feature_api_info', true);
$technical_notes = get_post_meta($post_id, '_feature_technical_notes', true);

$case_study_enable = get_post_meta($post_id, '_feature_case_study_enable', true);
$case_study_company = get_post_meta($post_id, '_feature_case_study_company', true);
$case_study_challenge = get_post_meta($post_id, '_feature_case_study_challenge', true);
$case_study_implementation = get_post_meta($post_id, '_feature_case_study_implementation', true);
$case_study_results = get_post_meta($post_id, '_feature_case_study_results', true);
$case_study_quote = get_post_meta($post_id, '_feature_case_study_quote', true);
$case_study_quote_author = get_post_meta($post_id, '_feature_case_study_quote_author', true);

$faqs = get_post_meta($post_id, '_feature_faqs', true) ?: array();
$related_features = get_post_meta($post_id, '_feature_related_features', true) ?: array();

// Get USP sections
$usp_sections = get_post_meta($post_id, '_feature_usp_sections', true) ?: array();

// Get all published feature pages for navigation
$all_features = get_posts(array(
    'post_type' => 'feature_pages',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'menu_order title',
    'order' => 'ASC'
));

// Generate hero background CSS
$hero_bg_css = '';
switch ($hero_bg_type) {
    case 'gradient':
        $hero_bg_css = 'background: linear-gradient(135deg, ' . esc_attr($hero_gradient_primary) . ' 0%, ' . esc_attr($hero_gradient_secondary) . ' 100%);';
        break;
    case 'image':
        if ($hero_bg_image) {
            $hero_bg_css = 'background: url("' . esc_url($hero_bg_image) . '") center/cover no-repeat;';
        }
        break;
    case 'image_gradient':
        if ($hero_bg_image) {
            $hero_bg_css = 'background: linear-gradient(135deg, ' . esc_attr($hero_gradient_primary) . '80 0%, ' . esc_attr($hero_gradient_secondary) . '80 100%), url("' . esc_url($hero_bg_image) . '") center/cover no-repeat;';
        }
        break;
}
?>

<style>
/* Feature Navigation Styles */
.feature-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: white;
    border-right: 1px solid #e5e7eb;
    overflow-y: auto;
    z-index: 40;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

.feature-sidebar.open {
    transform: translateX(0);
}

.feature-sidebar-header {
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
}

.feature-nav-list {
    padding: 0;
    margin: 0;
    list-style: none;
}

.feature-nav-item {
    border-bottom: 1px solid #f3f4f6;
}

.feature-nav-link {
    display: block;
    padding: 16px 20px;
    text-decoration: none;
    color: #374151;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
}

.feature-nav-link:hover {
    background: #f9fafb;
    color: #1f2937;
    border-left-color: #e5e7eb;
}

.feature-nav-link.current {
    background: #eff6ff;
    color: #1d4ed8;
    border-left-color: #3b82f6;
    font-weight: 600;
}

.feature-nav-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.feature-nav-excerpt {
    font-size: 12px;
    color: #6b7280;
    line-height: 1.4;
}

/* Mobile Top Bar */
.mobile-feature-nav {
    position: sticky;
    top: 0;
    background: white;
    border-bottom: 1px solid #e5e7eb;
    z-index: 50;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.mobile-nav-dropdown {
    position: relative;
    flex: 1;
    max-width: 280px;
}

.mobile-nav-trigger {
    width: 100%;
    padding: 12px 16px;
    background: #f9fafb;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: all 0.2s ease;
}

.mobile-nav-trigger:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
}

.mobile-nav-dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    max-height: 70vh;
    overflow-y: auto;
    z-index: 60;
    display: none;
}

.mobile-nav-dropdown-menu.open {
    display: block;
}

.mobile-nav-item {
    border-bottom: 1px solid #f3f4f6;
}

.mobile-nav-item:last-child {
    border-bottom: none;
}

.mobile-nav-link {
    display: block;
    padding: 12px 16px;
    text-decoration: none;
    color: #374151;
    transition: background 0.2s ease;
}

.mobile-nav-link:hover {
    background: #f9fafb;
}

.mobile-nav-link.current {
    background: #eff6ff;
    color: #1d4ed8;
    font-weight: 600;
}

/* Sidebar Toggle Button */
.sidebar-toggle {
    position: fixed;
    top: 50%;
    left: 20px;
    transform: translateY(-50%);
    background: #3b82f6;
    color: white;
    border: none;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 45;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar-toggle:hover {
    background: #2563eb;
    transform: translateY(-50%) scale(1.1);
}

.sidebar-toggle.hidden {
    transform: translateY(-50%) translateX(-80px);
    opacity: 0;
}

/* Overlay */
.sidebar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 35;
    display: none;
}

.sidebar-overlay.active {
    display: block;
}

/* Main Content Adjustments */
.feature-content {
    transition: margin-left 0.3s ease;
}

.feature-content.sidebar-open {
    margin-left: 280px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .feature-sidebar {
        width: 300px;
    }
    
    .sidebar-toggle {
        display: none;
    }
    
    .feature-content.sidebar-open {
        margin-left: 0;
    }
    
    .mobile-feature-nav {
        display: flex;
    }
}

@media (min-width: 1025px) {
    .mobile-feature-nav {
        display: none;
    }
}

/* Feature Page Specific Styles */
.feature-hero {
    <?php echo $hero_bg_css; ?>
    color: white;
    position: relative;
}
.feature-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.1);
    pointer-events: none;
}
.feature-capability-item {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.feature-capability-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}
.faq-item {
    border-bottom: 1px solid #e5e7eb;
    transition: background-color 0.2s ease;
}
.faq-item:hover {
    background-color: #f9fafb;
}
.faq-toggle {
    cursor: pointer;
    user-select: none;
}
.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}
.faq-answer.open {
    max-height: 500px;
}
.integration-code {
    background: #1f2937;
    color: #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    overflow-x: auto;
    font-family: 'Monaco', 'Consolas', monospace;
    font-size: 14px;
    line-height: 1.6;
}

/* Progress Indicator */
.feature-progress {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: #e5e7eb;
    z-index: 100;
}

.feature-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6);
    width: 0%;
    transition: width 0.1s ease;
}

/* USP Section Styles */
.usp-section {
    padding: 80px 0;
}

.usp-section:nth-child(even) {
    background: #f9fafb;
}

.usp-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.usp-content.reverse {
    direction: rtl;
}

.usp-content.reverse > * {
    direction: ltr;
}

.usp-text h3 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #111827;
    margin-bottom: 24px;
    line-height: 1.2;
}

.usp-text p {
    font-size: 1.125rem;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 20px;
}

.usp-visual img {
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.usp-svg {
    padding: 40px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.usp-svg svg {
    max-width: 100%;
    height: auto;
}

@media (max-width: 768px) {
    .usp-content {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
    }
    
    .usp-content.reverse {
        direction: ltr;
    }
    
    .usp-text h3 {
        font-size: 2rem;
    }
    
    .usp-section {
        padding: 60px 0;
    }
}
</style>

<!-- Reading Progress Bar -->
<div class="feature-progress">
    <div class="feature-progress-bar" id="progressBar"></div>
</div>

<!-- Sidebar Toggle Button (Desktop) -->
<button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Feature Sidebar Navigation (Desktop) -->
<aside class="feature-sidebar" id="featureSidebar">
    <div class="feature-sidebar-header">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Features</h3>
            <button onclick="closeSidebar()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <p class="text-sm text-gray-600 mt-2">Explore our powerful capabilities</p>
    </div>
    
    <nav>
        <ul class="feature-nav-list">
            <?php foreach ($all_features as $feature) : ?>
                <li class="feature-nav-item">
                    <a href="<?php echo get_permalink($feature->ID); ?>" 
                       class="feature-nav-link <?php echo ($feature->ID == $post_id) ? 'current' : ''; ?>">
                        <div class="feature-nav-title"><?php echo esc_html($feature->post_title); ?></div>
                        <?php 
                        $excerpt = get_the_excerpt($feature->ID);
                        if ($excerpt) :
                        ?>
                            <div class="feature-nav-excerpt"><?php echo wp_trim_words($excerpt, 12); ?></div>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <div class="p-4 border-t border-gray-200 mt-4">
            <a href="<?php echo get_post_type_archive_link('feature_pages'); ?>" 
               class="block text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                View All Features
            </a>
        </div>
    </nav>
</aside>

<!-- Mobile Top Navigation -->
<div class="mobile-feature-nav lg:hidden">
    <div class="mobile-nav-dropdown">
        <button class="mobile-nav-trigger" onclick="toggleMobileDropdown()">
            <div>
                <div class="text-sm font-medium text-gray-900"><?php the_title(); ?></div>
                <div class="text-xs text-gray-500">Tap to switch features</div>
            </div>
            <svg class="w-5 h-5 text-gray-400 transition-transform" id="mobileDropdownIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        
        <div class="mobile-nav-dropdown-menu" id="mobileDropdownMenu">
            <?php foreach ($all_features as $feature) : ?>
                <div class="mobile-nav-item">
                    <a href="<?php echo get_permalink($feature->ID); ?>" 
                       class="mobile-nav-link <?php echo ($feature->ID == $post_id) ? 'current' : ''; ?>">
                        <div class="font-medium"><?php echo esc_html($feature->post_title); ?></div>
                        <?php 
                        $excerpt = get_the_excerpt($feature->ID);
                        if ($excerpt) :
                        ?>
                            <div class="text-xs text-gray-500 mt-1"><?php echo wp_trim_words($excerpt, 8); ?></div>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach; ?>
            
            <div class="p-3 border-t border-gray-200">
                <a href="<?php echo get_post_type_archive_link('feature_pages'); ?>" 
                   class="block text-center bg-blue-600 text-white py-2 px-3 rounded text-sm font-medium">
                    View All Features
                </a>
            </div>
        </div>
    </div>
    
    <div class="flex space-x-2">
        <a href="<?php echo home_url('/pricing'); ?>" class="text-xs bg-blue-600 text-white px-3 py-2 rounded font-medium">
            Pricing
        </a>
        <a href="<?php echo home_url('/demo'); ?>" class="text-xs border border-blue-600 text-blue-600 px-3 py-2 rounded font-medium">
            Demo
        </a>
    </div>
</div>

<!-- Main Content Wrapper -->
<div class="feature-content" id="featureContent">

<!-- Hero Section -->
<section class="feature-hero py-20 lg:py-32 relative">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold mb-6">
                <?php the_title(); ?>
            </h1>
            <?php if ($hero_subtitle) : ?>
                <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-3xl mx-auto">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>
            <?php endif; ?>
            <?php if ($hero_cta_url) : ?>
                <a href="<?php echo esc_url($hero_cta_url); ?>" class="inline-block bg-white text-gray-900 font-semibold px-8 py-4 rounded-lg text-lg hover:bg-gray-100 transition-colors">
                    <?php echo esc_html($hero_cta_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Overview Section -->
<?php if (get_the_content()) : ?>
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">Overview</h2>
            </div>
            <div class="prose prose-lg max-w-none">
                <?php 
                // Get excerpt if available, otherwise use content
                if (has_excerpt()) {
                    echo '<div class="text-xl text-gray-600 mb-8">' . get_the_excerpt() . '</div>';
                }
                the_content(); 
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- USP Sections -->
<?php if (!empty($usp_sections)) : ?>
    <?php foreach ($usp_sections as $index => $usp) : ?>
        <section class="usp-section">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <div class="usp-content <?php echo ($index % 2 === 1) ? 'reverse' : ''; ?>">
                        <div class="usp-text">
                            <h3><?php echo esc_html($usp['title']); ?></h3>
                            <div class="text-content">
                                <?php echo wpautop(wp_kses_post($usp['description'])); ?>
                            </div>
                        </div>
                        <div class="usp-visual">
                            <?php if ($usp['type'] === 'image' && !empty($usp['image'])) : ?>
                                <img src="<?php echo esc_url($usp['image']); ?>" alt="<?php echo esc_attr($usp['title']); ?>" loading="lazy">
                            <?php elseif ($usp['type'] === 'svg' && !empty($usp['svg_code'])) : ?>
                                <div class="usp-svg">
                                    <?php 
                                    // Output SVG with minimal sanitization to preserve functionality
                                    $allowed_svg = array(
                                        'svg' => array(
                                            'class' => array(),
                                            'aria-hidden' => array(),
                                            'aria-labelledby' => array(),
                                            'role' => array(),
                                            'xmlns' => array(),
                                            'width' => array(),
                                            'height' => array(),
                                            'viewbox' => array(), // lowercase
                                            'viewBox' => array(), // camelCase
                                            'fill' => array(),
                                            'stroke' => array(),
                                            'stroke-width' => array(),
                                            'stroke-linecap' => array(),
                                            'stroke-linejoin' => array(),
                                            'style' => array(),
                                        ),
                                        'g' => array(
                                            'fill' => array(),
                                            'stroke' => array(),
                                            'stroke-width' => array(),
                                            'transform' => array(),
                                            'class' => array(),
                                        ),
                                        'path' => array(
                                            'd' => array(),
                                            'fill' => array(),
                                            'stroke' => array(),
                                            'stroke-width' => array(),
                                            'stroke-linecap' => array(),
                                            'stroke-linejoin' => array(),
                                            'transform' => array(),
                                            'class' => array(),
                                        ),
                                        'defs' => array(),
                                        'clippath' => array('id' => array()),
                                        'clipPath' => array('id' => array()),
                                        'circle' => array(
                                            'cx' => array(),
                                            'cy' => array(),
                                            'r' => array(),
                                            'fill' => array(),
                                            'stroke' => array(),
                                            'stroke-width' => array(),
                                            'class' => array(),
                                        ),
                                        'rect' => array(
                                            'x' => array(),
                                            'y' => array(),
                                            'width' => array(),
                                            'height' => array(),
                                            'fill' => array(),
                                            'stroke' => array(),
                                            'stroke-width' => array(),
                                            'rx' => array(),
                                            'ry' => array(),
                                            'class' => array(),
                                        ),
                                        'line' => array(
                                            'x1' => array(),
                                            'y1' => array(),
                                            'x2' => array(),
                                            'y2' => array(),
                                            'stroke' => array(),
                                            'stroke-width' => array(),
                                            'class' => array(),
                                        ),
                                        'polyline' => array(
                                            'points' => array(),
                                            'fill' => array(),
                                            'stroke' => array(),
                                            'stroke-width' => array(),
                                            'class' => array(),
                                        ),
                                        'polygon' => array(
                                            'points' => array(),
                                            'fill' => array(),
                                            'stroke' => array(),
                                            'stroke-width' => array(),
                                            'class' => array(),
                                        ),
                                        'text' => array(
                                            'x' => array(),
                                            'y' => array(),
                                            'font-family' => array(),
                                            'font-size' => array(),
                                            'font-weight' => array(),
                                            'text-anchor' => array(),
                                            'fill' => array(),
                                            'class' => array(),
                                        ),
                                        'tspan' => array(
                                            'x' => array(),
                                            'y' => array(),
                                            'font-family' => array(),
                                            'font-size' => array(),
                                            'font-weight' => array(),
                                            'fill' => array(),
                                        ),
                                        'marker' => array(
                                            'id' => array(),
                                            'markerWidth' => array(),
                                            'markerHeight' => array(),
                                            'refX' => array(),
                                            'refY' => array(),
                                            'orient' => array(),
                                            'markerUnits' => array(),
                                        ),
                                        'linearGradient' => array(
                                            'id' => array(),
                                            'x1' => array(),
                                            'y1' => array(),
                                            'x2' => array(),
                                            'y2' => array(),
                                        ),
                                        'stop' => array(
                                            'offset' => array(),
                                            'stop-color' => array(),
                                            'stop-opacity' => array(),
                                        ),
                                    );
                                    
                                    echo wp_kses($usp['svg_code'], $allowed_svg);
                                    ?>
                                </div>
                            <?php else: ?>
                                <!-- Debug: Show what we have -->
                                <div class="usp-debug" style="background: #f3f4f6; padding: 20px; border-radius: 8px; font-family: monospace; font-size: 12px;">
                                    <strong>Debug Info:</strong><br>
                                    Type: <?php echo esc_html($usp['type']); ?><br>
                                    Image: <?php echo esc_html($usp['image']); ?><br>
                                    SVG Length: <?php echo strlen($usp['svg_code']); ?> chars<br>
                                    <?php if (!empty($usp['svg_code'])): ?>
                                        SVG Preview: <?php echo esc_html(substr($usp['svg_code'], 0, 100)); ?>...<br>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach; ?>
<?php else: ?>
    <!-- Debug: No USP sections found -->
    <section class="py-20 bg-yellow-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-2xl font-bold text-yellow-800 mb-4">Debug: No USP Sections</h2>
                <p class="text-yellow-700">No USP sections found. Please add some in the admin panel.</p>
                <div class="mt-4 p-4 bg-white rounded border text-left text-sm">
                    <strong>Debug Info:</strong><br>
                    Post ID: <?php echo $post_id; ?><br>
                    USP Sections: <?php var_dump($usp_sections); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Key Capabilities Section -->
<?php if (!empty($capabilities)) : ?>
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Key Capabilities</h2>
                <p class="text-xl text-gray-600">Everything you need to succeed</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($capabilities as $index => $capability) : ?>
                    <div class="bg-white rounded-lg p-8 feature-capability-item border border-gray-200">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900">
                            <?php echo esc_html($capability['title']); ?>
                        </h3>
                        <p class="text-gray-600">
                            <?php echo esc_html($capability['description']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Integration Details Section -->
<?php if ($setup_steps || $api_info || $technical_notes) : ?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Integration Details</h2>
                <p class="text-xl text-gray-600">Easy setup and implementation</p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-12">
                <?php if ($setup_steps) : ?>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Setup Process</h3>
                        <div class="space-y-4">
                            <?php 
                            $steps = explode("\n", $setup_steps);
                            foreach ($steps as $index => $step) :
                                $step = trim($step);
                                if (!empty($step)) :
                            ?>
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold text-sm flex-shrink-0">
                                        <?php echo $index + 1; ?>
                                    </div>
                                    <p class="text-gray-700 pt-1"><?php echo esc_html($step); ?></p>
                                </div>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="space-y-8">
                    <?php if ($api_info) : ?>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">API Information</h3>
                            <div class="integration-code">
                                <?php echo nl2br(esc_html($api_info)); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($technical_notes) : ?>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Technical Notes</h3>
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                                <p class="text-gray-700"><?php echo nl2br(esc_html($technical_notes)); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Case Study Section -->
<?php if ($case_study_enable && $case_study_company) : ?>
<section class="py-20 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Success Story</h2>
                <p class="text-xl text-gray-600">Real results from real customers</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-8 lg:p-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">
                    Case Study: <?php echo esc_html($case_study_company); ?>
                </h3>
                
                <div class="grid lg:grid-cols-3 gap-8 mb-8">
                    <?php if ($case_study_challenge) : ?>
                        <div>
                            <h4 class="text-lg font-semibold text-red-600 mb-3">Challenge</h4>
                            <p class="text-gray-700"><?php echo esc_html($case_study_challenge); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($case_study_implementation) : ?>
                        <div>
                            <h4 class="text-lg font-semibold text-blue-600 mb-3">Implementation</h4>
                            <p class="text-gray-700"><?php echo esc_html($case_study_implementation); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($case_study_results) : ?>
                        <div>
                            <h4 class="text-lg font-semibold text-green-600 mb-3">Results</h4>
                            <p class="text-gray-700"><?php echo esc_html($case_study_results); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($case_study_quote) : ?>
                    <blockquote class="border-l-4 border-blue-400 pl-6 italic text-lg text-gray-700 bg-gray-50 p-6 rounded-r">
                        "<?php echo esc_html($case_study_quote); ?>"
                        <?php if ($case_study_quote_author) : ?>
                            <footer class="text-sm text-gray-500 mt-2 not-italic">
                                — <?php echo esc_html($case_study_quote_author); ?>
                            </footer>
                        <?php endif; ?>
                    </blockquote>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQ Section -->
<?php if (!empty($faqs)) : ?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Everything you need to know</p>
            </div>
            
            <div class="space-y-1">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <div class="faq-item border border-gray-200 rounded-lg">
                        <div class="faq-toggle p-6 flex justify-between items-center" onclick="toggleFAQ(<?php echo $index; ?>)">
                            <h3 class="text-lg font-semibold text-gray-900 pr-4">
                                <?php echo esc_html($faq['question']); ?>
                            </h3>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-icon-<?php echo $index; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div class="faq-answer faq-answer-<?php echo $index; ?>">
                            <div class="px-6 pb-6 text-gray-700">
                                <?php echo nl2br(esc_html($faq['answer'])); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Related Features Section -->
<?php if (!empty($related_features)) : ?>
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Related Features</h2>
                <p class="text-xl text-gray-600">Explore more powerful capabilities</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                $related_posts = get_posts(array(
                    'post_type' => 'feature_pages',
                    'include' => $related_features,
                    'post_status' => 'publish'
                ));
                
                foreach ($related_posts as $related_post) :
                    $related_excerpt = get_the_excerpt($related_post->ID);
                    if (empty($related_excerpt)) {
                        $related_excerpt = wp_trim_words($related_post->post_content, 20);
                    }
                ?>
                    <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <?php if (has_post_thumbnail($related_post->ID)) : ?>
                            <div class="mb-4">
                                <?php echo get_the_post_thumbnail($related_post->ID, 'medium', array('class' => 'w-full h-48 object-cover rounded')); ?>
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">
                            <a href="<?php echo get_permalink($related_post->ID); ?>" class="hover:text-blue-600 transition-colors">
                                <?php echo esc_html($related_post->post_title); ?>
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 mb-4">
                            <?php echo esc_html($related_excerpt); ?>
                        </p>
                        
                        <a href="<?php echo get_permalink($related_post->ID); ?>" class="text-blue-600 font-medium hover:text-blue-700 transition-colors">
                            Learn more →
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-4xl font-bold mb-6">Ready to get started?</h2>
            <p class="text-xl mb-8 opacity-90">
                Join thousands of businesses already using <?php the_title(); ?> to grow their revenue.
            </p>
            <div class="space-x-4">
                <a href="<?php echo home_url('/pricing'); ?>" class="inline-block bg-white text-blue-600 font-semibold px-8 py-4 rounded-lg text-lg hover:bg-gray-100 transition-colors">
                    View Pricing
                </a>
                <a href="<?php echo home_url('/contact'); ?>" class="inline-block border-2 border-white text-white font-semibold px-8 py-4 rounded-lg text-lg hover:bg-white hover:text-blue-600 transition-colors">
                    Contact Sales
                </a>
            </div>
        </div>
    </div>
</section>

</div> <!-- End feature-content wrapper -->

<script>
// Sidebar functionality
function toggleSidebar() {
    const sidebar = document.getElementById('featureSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const content = document.getElementById('featureContent');
    const toggle = document.getElementById('sidebarToggle');
    
    const isOpen = sidebar.classList.contains('open');
    
    if (isOpen) {
        closeSidebar();
    } else {
        sidebar.classList.add('open');
        overlay.classList.add('active');
        
        if (window.innerWidth >= 1025) {
            content.classList.add('sidebar-open');
            toggle.classList.add('hidden');
        }
    }
}

function closeSidebar() {
    const sidebar = document.getElementById('featureSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const content = document.getElementById('featureContent');
    const toggle = document.getElementById('sidebarToggle');
    
    sidebar.classList.remove('open');
    overlay.classList.remove('active');
    content.classList.remove('sidebar-open');
    toggle.classList.remove('hidden');
}

// Mobile dropdown functionality
function toggleMobileDropdown() {
    const menu = document.getElementById('mobileDropdownMenu');
    const icon = document.getElementById('mobileDropdownIcon');
    
    menu.classList.toggle('open');
    
    if (menu.classList.contains('open')) {
        icon.style.transform = 'rotate(180deg)';
    } else {
        icon.style.transform = 'rotate(0deg)';
    }
}

// Close mobile dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.querySelector('.mobile-nav-dropdown');
    const menu = document.getElementById('mobileDropdownMenu');
    const icon = document.getElementById('mobileDropdownIcon');
    
    if (dropdown && !dropdown.contains(event.target)) {
        menu.classList.remove('open');
        icon.style.transform = 'rotate(0deg)';
    }
});

// Reading progress bar
function updateProgressBar() {
    const progress = document.getElementById('progressBar');
    const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
    const scrollTop = window.pageYOffset;
    const scrollProgress = (scrollTop / scrollHeight) * 100;
    
    progress.style.width = scrollProgress + '%';
}

// FAQ functionality
function toggleFAQ(index) {
    const answer = document.querySelector('.faq-answer-' + index);
    const icon = document.querySelector('.faq-icon-' + index);
    
    answer.classList.toggle('open');
    icon.style.transform = answer.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
}

// Smooth scrolling for anchor links
function setupSmoothScrolling() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 80; // Account for sticky header
                
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    // ESC key closes sidebar
    if (e.key === 'Escape') {
        closeSidebar();
        
        const menu = document.getElementById('mobileDropdownMenu');
        const icon = document.getElementById('mobileDropdownIcon');
        menu.classList.remove('open');
        icon.style.transform = 'rotate(0deg)';
    }
    
    // Arrow keys for feature navigation
    if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
        const currentFeatures = <?php echo json_encode(array_map(function($f) { return $f->ID; }, $all_features)); ?>;
        const currentIndex = currentFeatures.indexOf(<?php echo $post_id; ?>);
        
        if (currentIndex !== -1) {
            let newIndex;
            if (e.key === 'ArrowLeft') {
                newIndex = currentIndex > 0 ? currentIndex - 1 : currentFeatures.length - 1;
            } else {
                newIndex = currentIndex < currentFeatures.length - 1 ? currentIndex + 1 : 0;
            }
            
            // Only navigate if Alt key is held (to avoid interfering with normal browsing)
            if (e.altKey) {
                e.preventDefault();
                const nextFeatureId = currentFeatures[newIndex];
                const nextFeature = <?php echo json_encode(array_reduce($all_features, function($acc, $f) { 
                    $acc[$f->ID] = get_permalink($f->ID); 
                    return $acc; 
                }, array())); ?>;
                
                if (nextFeature[nextFeatureId]) {
                    window.location.href = nextFeature[nextFeatureId];
                }
            }
        }
    }
});

// Initialize everything when page loads
document.addEventListener('DOMContentLoaded', function() {
    setupSmoothScrolling();
    
    // Add scroll listener for progress bar
    window.addEventListener('scroll', updateProgressBar);
    
    // Initialize progress bar
    updateProgressBar();
    
    // Auto-close mobile dropdown when navigating
    const mobileLinks = document.querySelectorAll('.mobile-nav-link');
    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (this.href !== window.location.href) {
                const menu = document.getElementById('mobileDropdownMenu');
                const icon = document.getElementById('mobileDropdownIcon');
                menu.classList.remove('open');
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });
    
    // Analytics tracking (if needed)
    function trackFeatureInteraction(action, feature) {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'feature_interaction', {
                'action': action,
                'feature_name': feature,
                'page_title': '<?php echo esc_js(get_the_title()); ?>'
            });
        }
    }
    
    // Track sidebar usage
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        trackFeatureInteraction('sidebar_toggle', '<?php echo esc_js(get_the_title()); ?>');
    });
    
    // Track mobile dropdown usage
    document.querySelector('.mobile-nav-trigger').addEventListener('click', function() {
        trackFeatureInteraction('mobile_dropdown_toggle', '<?php echo esc_js(get_the_title()); ?>');
    });
});

// Handle window resize
window.addEventListener('resize', function() {
    if (window.innerWidth >= 1025) {
        // Close mobile dropdown on desktop
        const menu = document.getElementById('mobileDropdownMenu');
        const icon = document.getElementById('mobileDropdownIcon');
        menu.classList.remove('open');
        icon.style.transform = 'rotate(0deg)';
    } else {
        // Close sidebar on mobile
        closeSidebar();
    }
});
</script>

<?php get_footer(); ?>
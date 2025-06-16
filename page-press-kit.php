<?php
/**
 * Template Name: Press Kit Page - Fixed Version
 */

get_header(); 

// Check if logo generator class exists, if not provide fallback
$logo_variations = array();
if (class_exists('YourSite_Logo_Generator')) {
    $logo_generator = new YourSite_Logo_Generator();
    $logo_variations = $logo_generator->get_logo_variations_for_display();
} else {
    // Fallback: get basic logo info
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo_url = wp_get_attachment_url($custom_logo_id);
        // Create basic variations structure for fallback
        $logo_variations = array(
            'primary' => array(
                'name' => 'Primary Logo',
                'description' => 'Original logo file',
                'preview_url' => $logo_url,
                'sizes' => array()
            )
        );
    }
}
?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-gray-50 to-blue-50 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                Press Kit
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Download logos, product screenshots, company information, and other brand assets for media coverage, partnerships, and promotional use.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <?php if (class_exists('YourSite_Logo_Generator') && !empty($logo_variations)): ?>
                    <button id="download-complete-package" class="btn-primary px-8 py-3 rounded-lg font-semibold">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                        </svg>
                        Download Complete Logo Package
                    </button>
                <?php endif; ?>
                <a href="/contact" class="btn-secondary px-8 py-3 rounded-lg font-semibold">
                    Media Inquiries
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Company Overview -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">About Our Company</h2>
                <p class="text-xl text-gray-600">Essential information for media coverage and partnerships</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Company Info -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Company Information</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900">Founded</h4>
                            <p class="text-gray-600"><?php echo get_theme_mod('company_founded', '2020'); ?></p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Headquarters</h4>
                            <p class="text-gray-600"><?php echo get_theme_mod('company_location', 'San Francisco, CA, USA'); ?></p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Industry</h4>
                            <p class="text-gray-600"><?php echo get_theme_mod('company_industry', 'E-commerce Technology & SaaS'); ?></p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Employees</h4>
                            <p class="text-gray-600"><?php echo get_theme_mod('company_employees', '50-100'); ?></p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Website</h4>
                            <p class="text-gray-600">
                                <a href="/" class="text-blue-600 hover:underline"><?php echo home_url(); ?></a>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Mission & Vision -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Mission & Vision</h3>
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Mission Statement</h4>
                            <p class="text-gray-600"><?php echo get_theme_mod('company_mission', 'To empower businesses of all sizes with seamless integrations that drive growth, efficiency, and customer satisfaction in the digital economy.'); ?></p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Vision</h4>
                            <p class="text-gray-600"><?php echo get_theme_mod('company_vision', 'To be the world\'s leading platform for e-commerce integrations, connecting every business tool and service in a unified ecosystem.'); ?></p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Core Values</h4>
                            <ul class="text-gray-600 space-y-1">
                                <li>• Innovation & Excellence</li>
                                <li>• Customer Success</li>
                                <li>• Transparency & Trust</li>
                                <li>• Global Accessibility</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Key Statistics -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Key Statistics</h2>
                <p class="text-xl text-gray-600">Numbers that tell our story</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl font-bold text-blue-600 mb-2"><?php echo get_theme_mod('stat_users', '100K+'); ?></div>
                    <div class="text-gray-600">Active Users</div>
                </div>
                <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl font-bold text-green-600 mb-2"><?php echo get_theme_mod('stat_integrations', '50+'); ?></div>
                    <div class="text-gray-600">Integrations</div>
                </div>
                <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl font-bold text-purple-600 mb-2"><?php echo get_theme_mod('stat_countries', '180+'); ?></div>
                    <div class="text-gray-600">Countries Served</div>
                </div>
                <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl font-bold text-orange-600 mb-2"><?php echo get_theme_mod('stat_uptime', '99.9%'); ?></div>
                    <div class="text-gray-600">Uptime</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dynamic Brand Assets Section -->
<section class="py-20 bg-white" id="downloads">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Brand Assets</h2>
                <p class="text-xl text-gray-600">Download our logos in various formats and sizes</p>
                
                <?php if (class_exists('YourSite_Logo_Generator')): ?>
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg inline-block">
                        <p class="text-sm text-blue-800">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            All logos are automatically generated from your uploaded website logo
                        </p>
                    </div>
                <?php else: ?>
                    <div class="mt-4 p-4 bg-yellow-50 rounded-lg inline-block">
                        <p class="text-sm text-yellow-800">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Logo generator not available. Please ensure the logo-generator.php file is properly included.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Logo Package -->
            <div class="bg-white rounded-xl p-8 shadow-sm mb-8 border border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Logo Variations</h3>
                    <?php if (class_exists('YourSite_Logo_Generator') && !empty($logo_variations)): ?>
                        <div class="flex gap-3">
                            <button id="refresh-logos" class="btn-secondary text-sm py-2 px-4 rounded">
                                <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh
                            </button>
                            <button id="download-all-formats" class="btn-primary text-sm py-2 px-4 rounded">
                                <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                </svg>
                                Download All
                            </button>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="logo-variations-container">
                    <?php if (empty($logo_variations)): ?>
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Logo Found</h3>
                            <p class="text-gray-600 mb-4">Please upload a logo in WordPress Customizer → Site Identity → Logo to generate variations.</p>
                            <a href="<?php echo admin_url('customize.php?autofocus[control]=custom_logo'); ?>" class="btn-primary px-6 py-2 rounded-lg text-sm">
                                Upload Logo
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="logo-grid">
                            <?php foreach ($logo_variations as $type => $variation): ?>
                                <div class="text-center logo-variation" data-type="<?php echo esc_attr($type); ?>">
                                    <div class="logo-preview-container mb-4 relative">
                                        <?php if ($type === 'white'): ?>
                                            <div class="bg-gray-800 rounded-lg p-8 mb-2 flex items-center justify-center min-h-32">
                                                <img src="<?php echo esc_url($variation['preview_url']); ?>" 
                                                     alt="<?php echo esc_attr($variation['name']); ?>" 
                                                     class="max-h-16 max-w-full object-contain">
                                            </div>
                                        <?php elseif ($type === 'black'): ?>
                                            <div class="bg-gray-100 rounded-lg p-8 mb-2 flex items-center justify-center min-h-32">
                                                <img src="<?php echo esc_url($variation['preview_url']); ?>" 
                                                     alt="<?php echo esc_attr($variation['name']); ?>" 
                                                     class="max-h-16 max-w-full object-contain">
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-gray-50 rounded-lg p-8 mb-2 flex items-center justify-center min-h-32 border-2 border-dashed border-gray-200">
                                                <img src="<?php echo esc_url($variation['preview_url']); ?>" 
                                                     alt="<?php echo esc_attr($variation['name']); ?>" 
                                                     class="max-h-16 max-w-full object-contain">
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Loading overlay -->
                                        <div class="loading-overlay absolute inset-0 bg-white bg-opacity-75 rounded-lg hidden items-center justify-center">
                                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                                        </div>
                                    </div>
                                    
                                    <h4 class="font-semibold mb-2"><?php echo esc_html($variation['name']); ?></h4>
                                    <p class="text-sm text-gray-600 mb-4"><?php echo esc_html($variation['description']); ?></p>
                                    
                                    <!-- Download options -->
                                    <div class="space-y-2">
                                        <?php if (!empty($variation['sizes'])): ?>
                                            <div class="sizes-container">
                                                <div class="grid grid-cols-2 gap-2 text-xs">
                                                    <?php foreach ($variation['sizes'] as $size_name => $size_data): ?>
                                                        <a href="<?php echo esc_url($size_data['url']); ?>" 
                                                           download
                                                           class="bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded text-gray-700 transition-colors">
                                                            <?php echo ucfirst($size_name); ?> (<?php echo $size_data['size']; ?>)
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Main download button -->
                                        <a href="<?php echo esc_url($variation['preview_url']); ?>" 
                                           download="<?php echo esc_attr($type . '-logo.png'); ?>"
                                           class="download-variation btn-primary text-sm py-2 px-4 rounded w-full inline-block text-center">
                                            Download <?php echo esc_html($variation['name']); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Package download section -->
                <?php if (class_exists('YourSite_Logo_Generator') && !empty($logo_variations)): ?>
                    <div class="mt-12 pt-8 border-t border-gray-200 text-center">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Complete Logo Package</h4>
                        <p class="text-gray-600 mb-6">Download all logo variations and sizes in a single ZIP file</p>
                        <button id="download-logo-package" class="btn-primary px-8 py-3 rounded-lg font-semibold">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M7 7h.01M7 3h5l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                            </svg>
                            <span class="download-text">Download Complete Package</span>
                            <span class="loading-text hidden">Generating Package...</span>
                        </button>
                        <p class="text-sm text-gray-500 mt-2">Includes all variations, sizes, and usage guidelines</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Brand Guidelines -->
            <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Brand Guidelines</h3>
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Colors -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Brand Colors</h4>
                        <div class="space-y-3">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-600 rounded"></div>
                                <div>
                                    <div class="font-medium">Primary Blue</div>
                                    <div class="text-sm text-gray-600">#2563EB</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-purple-600 rounded"></div>
                                <div>
                                    <div class="font-medium">Secondary Purple</div>
                                    <div class="text-sm text-gray-600">#7C3AED</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-900 rounded"></div>
                                <div>
                                    <div class="font-medium">Dark Gray</div>
                                    <div class="text-sm text-gray-600">#111827</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-400 rounded"></div>
                                <div>
                                    <div class="font-medium">Light Gray</div>
                                    <div class="text-sm text-gray-600">#9CA3AF</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Typography -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Typography</h4>
                        <div class="space-y-3">
                            <div>
                                <div class="font-bold text-xl mb-1">Inter Bold</div>
                                <div class="text-sm text-gray-600">Headings and emphasis</div>
                            </div>
                            <div>
                                <div class="font-semibold text-lg mb-1">Inter Semibold</div>
                                <div class="text-sm text-gray-600">Subheadings</div>
                            </div>
                            <div>
                                <div class="text-base mb-1">Inter Regular</div>
                                <div class="text-sm text-gray-600">Body text and paragraphs</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Usage Guidelines -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Usage Guidelines</h4>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h5 class="font-medium text-green-600 mb-2">✓ Do</h5>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Use official logo files only</li>
                                <li>• Maintain proper spacing around logo</li>
                                <li>• Use brand colors consistently</li>
                                <li>• Keep logo proportions intact</li>
                                <li>• Choose appropriate variation for background</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-medium text-red-600 mb-2">✗ Don't</h5>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Modify or recreate the logo</li>
                                <li>• Use unapproved color variations</li>
                                <li>• Place logo on busy backgrounds</li>
                                <li>• Stretch or distort the logo</li>
                                <li>• Add effects or animations</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript for Dynamic Functionality -->
<?php if (class_exists('YourSite_Logo_Generator')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoGenerator = new LogoPackageManager();
});

class LogoPackageManager {
    constructor() {
        this.ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
        this.nonce = '<?php echo wp_create_nonce('logo_generator_nonce'); ?>';
        this.init();
    }
    
    init() {
        this.bindEvents();
    }
    
    bindEvents() {
        // Download complete package
        const downloadBtn = document.getElementById('download-logo-package');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', () => this.downloadLogoPackage());
        }
        
        // Download all formats button
        const downloadAllBtn = document.getElementById('download-all-formats');
        if (downloadAllBtn) {
            downloadAllBtn.addEventListener('click', () => this.downloadLogoPackage());
        }
        
        // Download complete package (hero section)
        const heroDownloadBtn = document.getElementById('download-complete-package');
        if (heroDownloadBtn) {
            heroDownloadBtn.addEventListener('click', () => this.downloadLogoPackage());
        }
        
        // Refresh logos
        const refreshBtn = document.getElementById('refresh-logos');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => this.refreshLogos());
        }
    }
    
    async downloadLogoPackage() {
        const btn = document.getElementById('download-logo-package') || 
                   document.getElementById('download-all-formats') ||
                   document.getElementById('download-complete-package');
        
        if (!btn) return;
        
        const downloadText = btn.querySelector('.download-text');
        const loadingText = btn.querySelector('.loading-text');
        
        try {
            this.setButtonLoading(btn, true);
            if (downloadText && loadingText) {
                downloadText.classList.add('hidden');
                loadingText.classList.remove('hidden');
            }
            
            const response = await fetch(this.ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'download_logo_zip',
                    nonce: this.nonce
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Create download link
                const link = document.createElement('a');
                link.href = result.data.url;
                link.download = result.data.filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                this.showNotification('Logo package downloaded successfully!', 'success');
            } else {
                throw new Error(result.data || 'Failed to generate logo package');
            }
        } catch (error) {
            console.error('Download error:', error);
            this.showNotification('Error generating logo package: ' + error.message, 'error');
        } finally {
            this.setButtonLoading(btn, false);
            if (downloadText && loadingText) {
                downloadText.classList.remove('hidden');
                loadingText.classList.add('hidden');
            }
        }
    }
    
    async refreshLogos() {
        const btn = document.getElementById('refresh-logos');
        
        try {
            this.setButtonLoading(btn, true);
            
            const response = await fetch(this.ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'generate_logo_pack',
                    nonce: this.nonce
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Reload the page to show updated logos
                window.location.reload();
            } else {
                throw new Error(result.data || 'Failed to refresh logos');
            }
        } catch (error) {
            console.error('Refresh error:', error);
            this.showNotification('Error refreshing logos: ' + error.message, 'error');
        } finally {
            this.setButtonLoading(btn, false);
        }
    }
    
    setButtonLoading(button, loading) {
        if (loading) {
            button.disabled = true;
            button.classList.add('opacity-75', 'cursor-not-allowed');
        } else {
            button.disabled = false;
            button.classList.remove('opacity-75', 'cursor-not-allowed');
        }
    }
    
    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm ${
            type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' :
            type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' :
            'bg-blue-100 text-blue-800 border border-blue-200'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <button class="ml-4 text-current hover:opacity-75" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }
}
</script>
<?php endif; ?>

<!-- Leadership Team -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Leadership Team</h2>
                <p class="text-xl text-gray-600">Meet the people behind our success</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- CEO -->
                <div class="text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">JD</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">John Doe</h3>
                    <p class="text-blue-600 font-medium mb-3">CEO & Co-Founder</p>
                    <p class="text-gray-600 text-sm">Former VP of Engineering at Stripe. 15+ years in fintech and e-commerce platforms.</p>
                </div>
                
                <!-- CTO -->
                <div class="text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-green-400 to-green-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">JS</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Jane Smith</h3>
                    <p class="text-green-600 font-medium mb-3">CTO & Co-Founder</p>
                    <p class="text-gray-600 text-sm">Former Lead Engineer at PayPal. Expert in distributed systems and API architecture.</p>
                </div>
                
                <!-- VP of Sales -->
                <div class="text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">MJ</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Mike Johnson</h3>
                    <p class="text-purple-600 font-medium mb-3">VP of Sales</p>
                    <p class="text-gray-600 text-sm">Former Sales Director at Shopify. 12+ years building and scaling SaaS sales teams.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Media Contact -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">Media Contact</h2>
            <p class="text-xl text-gray-600 mb-8">For press inquiries, interviews, or additional information</p>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-2xl mx-auto">
                <!-- Press Contact -->
                <div class="bg-gray-50 rounded-xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Press Inquiries</h3>
                    <div class="space-y-2 text-gray-600">
                        <div><strong>Sarah Wilson</strong></div>
                        <div>Director of Communications</div>
                        <div>
                            <a href="mailto:press@<?php echo parse_url(home_url(), PHP_URL_HOST); ?>" class="text-blue-600 hover:underline">press@<?php echo parse_url(home_url(), PHP_URL_HOST); ?></a>
                        </div>
                        <div>+1 (555) 123-4567</div>
                    </div>
                </div>
                
                <!-- Business Contact -->
                <div class="bg-gray-50 rounded-xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Business Inquiries</h3>
                    <div class="space-y-2 text-gray-600">
                        <div><strong>Alex Chen</strong></div>
                        <div>VP of Business Development</div>
                        <div>
                            <a href="mailto:partnerships@<?php echo parse_url(home_url(), PHP_URL_HOST); ?>" class="text-blue-600 hover:underline">partnerships@<?php echo parse_url(home_url(), PHP_URL_HOST); ?></a>
                        </div>
                        <div>+1 (555) 123-4568</div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <a href="/contact" class="btn-primary px-8 py-3 rounded-lg font-semibold">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Usage Terms -->
<section class="py-12 bg-gray-50 border-t border-gray-200">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Asset Usage Terms</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
                The assets provided in this press kit are for editorial and promotional use only. By downloading these materials, 
                you agree to use them in accordance with our brand guidelines and not to modify, alter, or create derivative works. 
                For commercial usage rights or custom assets, please contact our media team.
            </p>
        </div>
    </div>
</section>

<style>
.aspect-video {
    aspect-ratio: 16 / 9;
}

/* Logo loading animations */
.loading-overlay {
    background: rgba(255, 255, 255, 0.9);
}

.logo-variation {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.logo-variation:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.logo-preview-container {
    position: relative;
    overflow: hidden;
}

.sizes-container {
    border-top: 1px solid #e5e7eb;
    padding-top: 0.75rem;
    margin-top: 0.75rem;
}

/* Notification styles */
.notification-enter {
    transform: translateX(100%);
    opacity: 0;
}

.notification-enter-active {
    transform: translateX(0);
    opacity: 1;
    transition: all 0.3s ease;
}

/* Loading states */
.btn-primary:disabled,
.btn-secondary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Mobile responsive improvements */
@media (max-width: 768px) {
    .logo-grid {
        grid-template-columns: 1fr;
    }
    
    .sizes-container .grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
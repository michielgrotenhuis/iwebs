<?php
/**
 * Template Name: Press Kit Page
 */

get_header(); ?>

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
                            <p class="text-gray-600">2020</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Headquarters</h4>
                            <p class="text-gray-600">San Francisco, CA, USA</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Industry</h4>
                            <p class="text-gray-600">E-commerce Technology & SaaS</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Employees</h4>
                            <p class="text-gray-600">50-100</p>
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
                            <p class="text-gray-600">To empower businesses of all sizes with seamless integrations that drive growth, efficiency, and customer satisfaction in the digital economy.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Vision</h4>
                            <p class="text-gray-600">To be the world's leading platform for e-commerce integrations, connecting every business tool and service in a unified ecosystem.</p>
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
                    <div class="text-3xl font-bold text-blue-600 mb-2">100K+</div>
                    <div class="text-gray-600">Active Users</div>
                </div>
                <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl font-bold text-green-600 mb-2">50+</div>
                    <div class="text-gray-600">Integrations</div>
                </div>
                <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl font-bold text-purple-600 mb-2">180+</div>
                    <div class="text-gray-600">Countries Served</div>
                </div>
                <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl font-bold text-orange-600 mb-2">99.9%</div>
                    <div class="text-gray-600">Uptime</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Team -->
<section class="py-20 bg-white">
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

<!-- Brand Assets -->
<section class="py-20 bg-gray-50" id="downloads">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Brand Assets</h2>
                <p class="text-xl text-gray-600">Download our logos, screenshots, and brand materials</p>
            </div>
            
            <!-- Logo Package -->
            <div class="bg-white rounded-xl p-8 shadow-sm mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Logo Package</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Primary Logo -->
                    <div class="text-center">
                        <div class="bg-gray-100 rounded-lg p-8 mb-4 flex items-center justify-center min-h-32">
                            <div class="text-2xl font-bold text-blue-600">LOGO</div>
                        </div>
                        <h4 class="font-semibold mb-2">Primary Logo</h4>
                        <p class="text-sm text-gray-600 mb-4">Full color logo for light backgrounds</p>
                        <div class="space-y-2">
                            <a href="#" class="block btn-secondary text-sm py-2 px-4 rounded">PNG (High-res)</a>
                            <a href="#" class="block btn-secondary text-sm py-2 px-4 rounded">SVG (Vector)</a>
                        </div>
                    </div>
                    
                    <!-- White Logo -->
                    <div class="text-center">
                        <div class="bg-gray-800 rounded-lg p-8 mb-4 flex items-center justify-center min-h-32">
                            <div class="text-2xl font-bold text-white">LOGO</div>
                        </div>
                        <h4 class="font-semibold mb-2">White Logo</h4>
                        <p class="text-sm text-gray-600 mb-4">White logo for dark backgrounds</p>
                        <div class="space-y-2">
                            <a href="#" class="block btn-secondary text-sm py-2 px-4 rounded">PNG (High-res)</a>
                            <a href="#" class="block btn-secondary text-sm py-2 px-4 rounded">SVG (Vector)</a>
                        </div>
                    </div>
                    
                    <!-- Monochrome Logo -->
                    <div class="text-center">
                        <div class="bg-gray-100 rounded-lg p-8 mb-4 flex items-center justify-center min-h-32">
                            <div class="text-2xl font-bold text-gray-800">LOGO</div>
                        </div>
                        <h4 class="font-semibold mb-2">Monochrome</h4>
                        <p class="text-sm text-gray-600 mb-4">Black/gray logo for special uses</p>
                        <div class="space-y-2">
                            <a href="#" class="block btn-secondary text-sm py-2 px-4 rounded">PNG (High-res)</a>
                            <a href="#" class="block btn-secondary text-sm py-2 px-4 rounded">SVG (Vector)</a>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 text-center">
                    <a href="#" class="btn-primary px-8 py-3 rounded-lg font-semibold">
                        Download Complete Logo Package
                    </a>
                </div>
            </div>
            
            <!-- Product Screenshots -->
            <div class="bg-white rounded-xl p-8 shadow-sm mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Product Screenshots</h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-100 rounded-lg aspect-video flex items-center justify-center">
                        <span class="text-gray-500">Dashboard Screenshot</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg aspect-video flex items-center justify-center">
                        <span class="text-gray-500">Integrations Page</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg aspect-video flex items-center justify-center">
                        <span class="text-gray-500">Analytics View</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg aspect-video flex items-center justify-center">
                        <span class="text-gray-500">Payment Setup</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg aspect-video flex items-center justify-center">
                        <span class="text-gray-500">API Documentation</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg aspect-video flex items-center justify-center">
                        <span class="text-gray-500">Mobile App</span>
                    </div>
                </div>
                <div class="mt-8 text-center">
                    <a href="#" class="btn-primary px-8 py-3 rounded-lg font-semibold">
                        Download All Screenshots
                    </a>
                </div>
            </div>
            
            <!-- Brand Guidelines -->
            <div class="bg-white rounded-xl p-8 shadow-sm">
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
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-medium text-red-600 mb-2">✗ Don't</h5>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Modify or recreate the logo</li>
                                <li>• Use unapproved color variations</li>
                                <li>• Place logo on busy backgrounds</li>
                                <li>• Stretch or distort the logo</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 text-center">
                    <a href="#" class="btn-primary px-8 py-3 rounded-lg font-semibold">
                        Download Brand Guidelines PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent News & Coverage -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Recent News & Coverage</h2>
                <p class="text-xl text-gray-600">Latest press mentions and company announcements</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- News Item 1 -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="text-sm text-blue-600 font-medium mb-2">TechCrunch</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">E-commerce Integration Platform Raises $25M Series A</h3>
                    <p class="text-gray-600 text-sm mb-4">Platform aims to simplify e-commerce integrations for businesses of all sizes with new funding round...</p>
                    <div class="text-sm text-gray-500">March 15, 2024</div>
                </div>
                
                <!-- News Item 2 -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="text-sm text-blue-600 font-medium mb-2">VentureBeat</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">The Future of E-commerce: Seamless Integrations</h3>
                    <p class="text-gray-600 text-sm mb-4">How modern businesses are leveraging integration platforms to streamline operations and improve customer experience...</p>
                    <div class="text-sm text-gray-500">February 28, 2024</div>
                </div>
                
                <!-- News Item 3 -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="text-sm text-blue-600 font-medium mb-2">Forbes</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Top 10 SaaS Startups to Watch in 2024</h3>
                    <p class="text-gray-600 text-sm mb-4">Forbes highlights the most promising SaaS companies poised for growth in the coming year...</p>
                    <div class="text-sm text-gray-500">January 10, 2024</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Media Contact -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">Media Contact</h2>
            <p class="text-xl text-gray-600 mb-8">For press inquiries, interviews, or additional information</p>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-2xl mx-auto">
                <!-- Press Contact -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Press Inquiries</h3>
                    <div class="space-y-2 text-gray-600">
                        <div><strong>Sarah Wilson</strong></div>
                        <div>Director of Communications</div>
                        <div>
                            <a href="mailto:press@company.com" class="text-blue-600 hover:underline">press@company.com</a>
                        </div>
                        <div>+1 (555) 123-4567</div>
                    </div>
                </div>
                
                <!-- Business Contact -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Business Inquiries</h3>
                    <div class="space-y-2 text-gray-600">
                        <div><strong>Alex Chen</strong></div>
                        <div>VP of Business Development</div>
                        <div>
                            <a href="mailto:partnerships@company.com" class="text-blue-600 hover:underline">partnerships@company.com</a>
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
<section class="py-12 bg-white border-t border-gray-200">
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
</style>

<?php get_footer(); ?>
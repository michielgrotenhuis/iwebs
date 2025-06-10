<?php
/*
Template Name: Features Page
*/

get_header(); ?>

<?php if (get_theme_mod('features_hero_enable', true)) : ?>
<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                <?php echo esc_html(get_theme_mod('features_hero_title', __('Everything you need to sell online', 'yoursite'))); ?>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                <?php echo esc_html(get_theme_mod('features_hero_description', __('From store building to payment processing, marketing to analytics - discover all the powerful features that make your eCommerce dreams a reality.', 'yoursite'))); ?>
            </p>
            <a href="<?php echo esc_url(get_theme_mod('features_hero_button_url', '#features')); ?>" class="btn-primary text-lg px-8 py-4">
                <?php echo esc_html(get_theme_mod('features_hero_button_text', __('Explore Features', 'yoursite'))); ?>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Feature Categories -->
<section class="py-20" id="features">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            
            <?php if (get_theme_mod('features_store_building_enable', true)) : ?>
            <!-- Store Building -->
            <div class="mb-20">
                <div class="text-center mb-16">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        <?php echo esc_html(get_theme_mod('features_store_building_title', __('Store Building', 'yoursite'))); ?>
                    </h2>
                    <p class="text-xl text-gray-600">
                        <?php echo esc_html(get_theme_mod('features_store_building_description', __('Create stunning online stores without any coding knowledge', 'yoursite'))); ?>
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php if (get_theme_mod('features_store_building_feature_1_enable', true)) : ?>
                    <div class="bg-white rounded-lg p-8 feature-card border border-gray-200">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">
                            <?php echo esc_html(get_theme_mod('features_store_building_feature_1_title', __('Drag & Drop Builder', 'yoursite'))); ?>
                        </h3>
                        <p class="text-gray-600">
                            <?php echo esc_html(get_theme_mod('features_store_building_feature_1_description', __('Intuitive visual editor to customize your store layout, add products, and arrange elements exactly how you want them.', 'yoursite'))); ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (get_theme_mod('features_store_building_feature_2_enable', true)) : ?>
                    <div class="bg-white rounded-lg p-8 feature-card border border-gray-200">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">
                            <?php echo esc_html(get_theme_mod('features_store_building_feature_2_title', __('Professional Templates', 'yoursite'))); ?>
                        </h3>
                        <p class="text-gray-600">
                            <?php echo esc_html(get_theme_mod('features_store_building_feature_2_description', __('Choose from 100+ mobile-responsive templates designed for conversion and optimized for your industry.', 'yoursite'))); ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (get_theme_mod('features_store_building_feature_3_enable', true)) : ?>
                    <div class="bg-white rounded-lg p-8 feature-card border border-gray-200">
                        <div class="w-12 h-12 bg-green-100 rounded-lg mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">
                            <?php echo esc_html(get_theme_mod('features_store_building_feature_3_title', __('Mobile Optimized', 'yoursite'))); ?>
                        </h3>
                        <p class="text-gray-600">
                            <?php echo esc_html(get_theme_mod('features_store_building_feature_3_description', __('Every store is automatically optimized for mobile devices, ensuring perfect shopping experience across all screen sizes.', 'yoursite'))); ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if (get_theme_mod('features_payments_enable', true)) : ?>
            <!-- Payment & Checkout -->
            <div class="mb-20">
                <div class="text-center mb-16">
                    <div class="w-16 h-16 bg-green-100 rounded-lg mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        <?php echo esc_html(get_theme_mod('features_payments_title', __('Payments & Checkout', 'yoursite'))); ?>
                    </h2>
                    <p class="text-xl text-gray-600">
                        <?php echo esc_html(get_theme_mod('features_payments_description', __('Secure, fast checkout that converts browsers into buyers', 'yoursite'))); ?>
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php 
                    $payment_icons = array(
                        1 => '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
                        2 => '<svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>',
                        3 => '<svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path></svg>'
                    );
                    $payment_colors = array(1 => 'green', 2 => 'orange', 3 => 'purple');
                    
                    for ($i = 1; $i <= 3; $i++) :
                        if (get_theme_mod("features_payments_feature_{$i}_enable", true)) :
                    ?>
                    <div class="bg-white rounded-lg p-8 feature-card border border-gray-200">
                        <div class="w-12 h-12 bg-<?php echo $payment_colors[$i]; ?>-100 rounded-lg mb-4 flex items-center justify-center">
                            <?php echo $payment_icons[$i]; ?>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">
                            <?php echo esc_html(get_theme_mod("features_payments_feature_{$i}_title", '')); ?>
                        </h3>
                        <p class="text-gray-600">
                            <?php echo esc_html(get_theme_mod("features_payments_feature_{$i}_description", '')); ?>
                        </p>
                    </div>
                    <?php 
                        endif;
                    endfor; 
                    ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if (get_theme_mod('features_marketing_enable', true)) : ?>
            <!-- Marketing & SEO -->
            <div class="mb-20">
                <div class="text-center mb-16">
                    <div class="w-16 h-16 bg-purple-100 rounded-lg mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        <?php echo esc_html(get_theme_mod('features_marketing_title', __('Marketing & SEO', 'yoursite'))); ?>
                    </h2>
                    <p class="text-xl text-gray-600">
                        <?php echo esc_html(get_theme_mod('features_marketing_description', __('Built-in tools to drive traffic and increase sales', 'yoursite'))); ?>
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php 
                    $marketing_icons = array(
                        1 => '<svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>',
                        2 => '<svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
                        3 => '<svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'
                    );
                    $marketing_colors = array(1 => 'purple', 2 => 'red', 3 => 'yellow');
                    
                    for ($i = 1; $i <= 3; $i++) :
                        if (get_theme_mod("features_marketing_feature_{$i}_enable", true)) :
                    ?>
                    <div class="bg-white rounded-lg p-8 feature-card border border-gray-200">
                        <div class="w-12 h-12 bg-<?php echo $marketing_colors[$i]; ?>-100 rounded-lg mb-4 flex items-center justify-center">
                            <?php echo $marketing_icons[$i]; ?>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">
                            <?php echo esc_html(get_theme_mod("features_marketing_feature_{$i}_title", '')); ?>
                        </h3>
                        <p class="text-gray-600">
                            <?php echo esc_html(get_theme_mod("features_marketing_feature_{$i}_description", '')); ?>
                        </p>
                    </div>
                    <?php 
                        endif;
                    endfor; 
                    ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if (get_theme_mod('features_inventory_enable', true)) : ?>
            <!-- Inventory & Orders -->
            <div class="mb-20">
                <div class="text-center mb-16">
                    <div class="w-16 h-16 bg-orange-100 rounded-lg mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        <?php echo esc_html(get_theme_mod('features_inventory_title', __('Inventory & Orders', 'yoursite'))); ?>
                    </h2>
                    <p class="text-xl text-gray-600">
                        <?php echo esc_html(get_theme_mod('features_inventory_description', __('Streamlined management for products, inventory, and fulfillment', 'yoursite'))); ?>
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php 
                    $inventory_icons = array(
                        1 => '<svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>',
                        2 => '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>',
                        3 => '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>'
                    );
                    $inventory_colors = array(1 => 'orange', 2 => 'blue', 3 => 'green');
                    
                    for ($i = 1; $i <= 3; $i++) :
                        if (get_theme_mod("features_inventory_feature_{$i}_enable", true)) :
                    ?>
                    <div class="bg-white rounded-lg p-8 feature-card border border-gray-200">
                        <div class="w-12 h-12 bg-<?php echo $inventory_colors[$i]; ?>-100 rounded-lg mb-4 flex items-center justify-center">
                            <?php echo $inventory_icons[$i]; ?>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">
                            <?php echo esc_html(get_theme_mod("features_inventory_feature_{$i}_title", '')); ?>
                        </h3>
                        <p class="text-gray-600">
                            <?php echo esc_html(get_theme_mod("features_inventory_feature_{$i}_description", '')); ?>
                        </p>
                    </div>
                    <?php 
                        endif;
                    endfor; 
                    ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (get_theme_mod('features_comparison_enable', true)) : ?>
<!-- Feature Comparison -->
<section class="bg-gray-50 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <?php echo esc_html(get_theme_mod('features_comparison_title', __('Compare Our Plans', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600">
                    <?php echo esc_html(get_theme_mod('features_comparison_description', __('See which features are included in each pricing tier', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Features</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Starter</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 bg-blue-50">Professional</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Business</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Enterprise</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">Products</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">1,000</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600 bg-blue-50">10,000</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Unlimited</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Unlimited</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">Storage</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">10GB</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600 bg-blue-50">100GB</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">500GB</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Unlimited</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">Email Marketing</td>
                                <td class="px-6 py-4 text-center">
                                    <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </td>
                                <td class="px-6 py-4 text-center bg-blue-50">
                                    <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">Priority Support</td>
                                <td class="px-6 py-4 text-center">
                                    <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </td>
                                <td class="px-6 py-4 text-center bg-blue-50">
                                    <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('features_cta_enable', true)) : ?>
<!-- CTA Section -->
<section class="hero-gradient text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-5xl font-bold mb-6">
                <?php echo esc_html(get_theme_mod('features_cta_title', __('Ready to explore all features?', 'yoursite'))); ?>
            </h2>
            <p class="text-xl mb-8 opacity-90">
                <?php echo esc_html(get_theme_mod('features_cta_description', __('Start your free trial and experience the power of our platform', 'yoursite'))); ?>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="<?php echo esc_url(get_theme_mod('features_cta_primary_url', '#')); ?>" class="btn-primary text-lg px-8 py-4 bg-white text-purple-600 hover:bg-gray-100">
                    <?php echo esc_html(get_theme_mod('features_cta_primary_text', __('Start Free Trial', 'yoursite'))); ?>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('features_cta_secondary_url', '/pricing')); ?>" class="btn-secondary text-lg px-8 py-4 border-white text-white hover:bg-white hover:text-purple-600">
                    <?php echo esc_html(get_theme_mod('features_cta_secondary_text', __('View Pricing', 'yoursite'))); ?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
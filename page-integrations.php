<?php
/*
Template Name: Integrations Page
*/

get_header(); 

// Define your actual integrations
$integrations = array(
    // Payment Gateways
    array(
        'name' => 'Nicky',
        'category' => 'payment',
        'description' => 'Nicky.me offers cryptocurrency payment solutions for your online store, making digital currency transactions fast and secure.',
        'icon' => 'N',
        'color' => 'purple',
        'status' => 'available'
    ),
    array(
        'name' => 'Flutterwave',
        'category' => 'payment',
        'description' => 'Flutterwave is a robust payment gateway operating in multiple countries, including Nigeria, Ghana, Kenya, and the US, empowering merchants to accept payments from all over the world.',
        'icon' => 'FW',
        'color' => 'orange',
        'status' => 'available'
    ),
    array(
        'name' => 'Stripe',
        'category' => 'payment',
        'description' => 'Stripe provides a convenient way to receive payments in your store using various credit and debit cards like Visa, MasterCard, American Express, and more. Secure and simple.',
        'icon' => 'S',
        'color' => 'blue',
        'status' => 'available'
    ),
    array(
        'name' => 'PayPal',
        'category' => 'payment',
        'description' => 'PayPal is a popular payment provider that allows you to accept payments in your online store with ease and security, trusted worldwide.',
        'icon' => 'PP',
        'color' => 'blue',
        'status' => 'available'
    ),
    array(
        'name' => 'RazorPay',
        'category' => 'payment',
        'description' => 'Razorpay is India\'s leading converged payments solution, enabling businesses to accept, process, and disburse payments effortlessly.',
        'icon' => 'RP',
        'color' => 'blue',
        'status' => 'available'
    ),
    array(
        'name' => 'Cash Free',
        'category' => 'payment',
        'description' => 'Cash Free offers seamless payment gateway services for businesses in India, facilitating secure and hassle-free transactions.',
        'icon' => 'CF',
        'color' => 'green',
        'status' => 'available'
    ),
    array(
        'name' => 'Paystack',
        'category' => 'payment',
        'description' => 'Paystack offers a seamless payment gateway in Africa, including Kenya, Nigeria, Ghana, and South Africa, helping businesses grow through secure payments.',
        'icon' => 'PS',
        'color' => 'blue',
        'status' => 'available'
    ),
    array(
        'name' => 'Mercado Pago',
        'category' => 'payment',
        'description' => 'Mercado Pago makes payments easier for businesses in Latin America with a comprehensive suite of solutions tailored to meet the diverse needs of online merchants.',
        'icon' => 'MP',
        'color' => 'blue',
        'status' => 'available'
    ),
    array(
        'name' => 'Mollie',
        'category' => 'payment',
        'description' => 'Mollie is a European payment provider that enables merchants to accept online payments through an easy and reliable system.',
        'icon' => 'M',
        'color' => 'orange',
        'status' => 'available'
    ),
    array(
        'name' => 'Vipps',
        'category' => 'payment',
        'description' => 'Vipps is a Norwegian mobile payment service that enables fast and secure payments with just a few taps.',
        'icon' => 'V',
        'color' => 'orange',
        'status' => 'available'
    ),
    array(
        'name' => 'Epoint',
        'category' => 'payment',
        'description' => 'Epoint, based in Azerbaijan, is a payment system that enables secure electronic payments for various services and products.',
        'icon' => 'E',
        'color' => 'red',
        'status' => 'available'
    ),
    array(
        'name' => 'Iyzico',
        'category' => 'payment',
        'description' => 'Iyzico offers a reliable payment solution platform, simplifying ePayments for businesses in Turkey and beyond.',
        'icon' => 'I',
        'color' => 'purple',
        'status' => 'available'
    ),
    array(
        'name' => 'Payriff',
        'category' => 'payment',
        'description' => 'Payriff provides secure and efficient payment processing solutions for businesses across various industries.',
        'icon' => 'PR',
        'color' => 'blue',
        'status' => 'available'
    ),
    array(
        'name' => 'Yoco',
        'category' => 'payment',
        'description' => 'Yoco provides South African businesses with a complete financial platform to manage payments, invoices, and more—empowering entrepreneurs to grow.',
        'icon' => 'Y',
        'color' => 'green',
        'status' => 'available'
    ),
    array(
        'name' => 'Mamo Pay',
        'category' => 'payment',
        'description' => 'Mamo Pay is an all-in-one payment platform for SMEs, offering a seamless and efficient payment solution.',
        'icon' => 'MP',
        'color' => 'purple',
        'status' => 'available'
    ),
    
    // Shipping & Fulfillment
    array(
        'name' => 'MyParcel',
        'category' => 'shipping',
        'description' => 'Exciting news for merchants! MyParcel offers streamlined shipping and fulfillment solutions directly integrated into our platform.',
        'icon' => 'MP',
        'color' => 'blue',
        'status' => 'available'
    ),
    array(
        'name' => 'The Courier Guy',
        'category' => 'shipping',
        'description' => 'The Courier Guy brings efficient and reliable shipping solutions, providing you with fast deliveries for your customers.',
        'icon' => 'TCG',
        'color' => 'orange',
        'status' => 'available'
    ),
    
    // Analytics & Marketing
    array(
        'name' => 'Google Analytics',
        'category' => 'analytics',
        'description' => 'Google Analytics offers detailed website traffic analysis, helping you understand how visitors interact with your site, which drives better decision-making.',
        'icon' => 'GA',
        'color' => 'red',
        'status' => 'available'
    ),
    array(
        'name' => 'Meta Pixel',
        'category' => 'marketing',
        'description' => 'Meta Pixel allows you to track customer behavior and ad performance, offering valuable insights to optimize your Facebook and Instagram marketing campaigns.',
        'icon' => 'FB',
        'color' => 'blue',
        'status' => 'available'
    ),
    array(
        'name' => 'TikTok Pixel',
        'category' => 'marketing',
        'description' => 'The TikTok Pixel integration lets you track and analyze ad performance, conversion metrics, and customer interactions directly from your online store.',
        'icon' => 'TT',
        'color' => 'pink',
        'status' => 'available'
    ),
    array(
        'name' => 'Google Tag Manager',
        'category' => 'marketing',
        'description' => 'Google Tag Manager streamlines website tag management, enabling you to add and update tags like tracking codes quickly and efficiently.',
        'icon' => 'GTM',
        'color' => 'blue',
        'status' => 'available'
    )
);

$categories = array(
    'payment' => array('name' => 'Payment Gateways', 'icon' => 'credit-card', 'color' => 'blue'),
    'shipping' => array('name' => 'Shipping & Fulfillment', 'icon' => 'truck', 'color' => 'purple'),
    'analytics' => array('name' => 'Analytics & Reporting', 'icon' => 'chart-bar', 'color' => 'green'),
    'marketing' => array('name' => 'Marketing', 'icon' => 'speakerphone', 'color' => 'yellow')
);
?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-50 to-purple-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                Connect with your favorite tools
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Seamlessly integrate with <?php echo count($integrations); ?>+ apps and services to streamline your workflow and grow your business faster.
            </p>
            
            <!-- Fixed Search Bar -->
            <div class="flex justify-center mb-8">
                <div class="w-full max-w-md">
                    <input type="text" 
                           id="integration-search"
                           placeholder="Search integrations..." 
                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-base">
                </div>
            </div>
            
            <!-- Category Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-3">
                <button class="integration-filter-btn active px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors" data-filter="all">
                    All (<?php echo count($integrations); ?>)
                </button>
                <?php foreach ($categories as $key => $category) : 
                    $count = count(array_filter($integrations, function($item) use ($key) { return $item['category'] === $key; }));
                ?>
                <button class="integration-filter-btn px-4 py-2 bg-white text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors" data-filter="<?php echo $key; ?>">
                    <?php echo $category['name']; ?> (<?php echo $count; ?>)
                </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Integrations Grid -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            
            <?php foreach ($categories as $cat_key => $category) : 
                $cat_integrations = array_filter($integrations, function($item) use ($cat_key) { 
                    return $item['category'] === $cat_key; 
                });
                if (empty($cat_integrations)) continue;
            ?>
            
            <!-- Category Section -->
            <div class="category-section mb-16" data-category="<?php echo $cat_key; ?>">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center">
                    <div class="w-8 h-8 bg-<?php echo $category['color']; ?>-100 rounded-lg flex items-center justify-center mr-3">
                        <?php if ($cat_key === 'payment') : ?>
                            <svg class="w-5 h-5 text-<?php echo $category['color']; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        <?php elseif ($cat_key === 'shipping') : ?>
                            <svg class="w-5 h-5 text-<?php echo $category['color']; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        <?php elseif ($cat_key === 'analytics') : ?>
                            <svg class="w-5 h-5 text-<?php echo $category['color']; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        <?php else : ?>
                            <svg class="w-5 h-5 text-<?php echo $category['color']; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <?php echo $category['name']; ?>
                </h3>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($cat_integrations as $integration) : ?>
                    <div class="integration-card <?php echo $integration['category']; ?> bg-white rounded-lg p-6 feature-card border border-gray-200 hover:shadow-lg transition-all duration-300 cursor-pointer" 
                         data-name="<?php echo strtolower($integration['name']); ?>" 
                         data-description="<?php echo strtolower($integration['description']); ?>">
                        <div class="text-center">
                            <!-- Integration Icon -->
                            <div class="w-12 h-12 bg-<?php echo $integration['color']; ?>-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                                <span class="font-bold text-<?php echo $integration['color']; ?>-600 text-sm">
                                    <?php echo $integration['icon']; ?>
                                </span>
                            </div>
                            
                            <!-- Integration Name & Status -->
                            <div class="flex items-center justify-center gap-2 mb-2">
                                <h4 class="font-semibold text-lg"><?php echo $integration['name']; ?></h4>
                                <?php if (isset($integration['status']) && $integration['status'] === 'coming_soon') : ?>
                                    <span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                        Soon
                                    </span>
                                <?php elseif (isset($integration['status']) && $integration['status'] === 'beta') : ?>
                                    <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                        Beta
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4 leading-relaxed line-clamp-3">
                                <?php echo $integration['description']; ?>
                            </p>
                            
                            <!-- Action Button -->
                            <button class="btn-primary text-sm w-full py-2 rounded-lg font-medium transition-all hover:shadow-md bg-blue-600 text-white hover:bg-blue-700">
                                <?php echo (isset($integration['status']) && $integration['status'] === 'beta') ? 'Try Beta' : 'View Details'; ?>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <?php endforeach; ?>
            
        </div>
    </div>
</section>

<!-- Custom Integration -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                Need a custom integration?
            </h2>
            <p class="text-xl text-gray-600 mb-8">
                Our API makes it easy to connect with any service. Build custom integrations or request new ones.
            </p>
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div class="bg-gray-50 rounded-xl p-8 hover:bg-gray-100 transition-colors">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Use Our API</h3>
                    <p class="text-gray-600 mb-6">Build custom integrations with our comprehensive REST API and webhooks.</p>
                    <a href="/api" class="btn-secondary px-6 py-2 rounded-lg font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors">View API Docs</a>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 hover:bg-gray-100 transition-colors">
                    <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Request Integration</h3>
                    <p class="text-gray-600 mb-6">Can't find what you need? Let us know and we'll consider adding it to our roadmap.</p>
                    <a href="/contact" class="btn-secondary px-6 py-2 rounded-lg font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors">Request Integration</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="hero-gradient bg-gradient-to-r from-purple-600 to-blue-600 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-5xl font-bold mb-6">
                Ready to connect your tools?
            </h2>
            <p class="text-xl mb-8 opacity-90">
                Start your free trial and integrate with your favorite apps today
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#" class="btn-primary text-lg px-8 py-4 bg-white text-purple-600 hover:bg-gray-100 rounded-lg font-semibold transition-all">
                    Start Free Trial
                </a>
                <a href="/api" class="btn-secondary text-lg px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-purple-600 rounded-lg font-semibold transition-all">
                    View API Docs
                </a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Integration filtering
    const filterButtons = document.querySelectorAll('.integration-filter-btn');
    const integrationCards = document.querySelectorAll('.integration-card');
    const categorySections = document.querySelectorAll('.category-section');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white');
                btn.classList.add('bg-white', 'text-gray-700');
            });
            
            // Add active class to clicked button
            this.classList.add('active', 'bg-blue-600', 'text-white');
            this.classList.remove('bg-white', 'text-gray-700');
            
            const filter = this.getAttribute('data-filter');
            
            if (filter === 'all') {
                // Show all sections
                categorySections.forEach(section => {
                    section.style.display = 'block';
                });
            } else {
                // Hide all sections first
                categorySections.forEach(section => {
                    section.style.display = 'none';
                });
                
                // Show only the selected category section
                const targetSection = document.querySelector(`[data-category="${filter}"]`);
                if (targetSection) {
                    targetSection.style.display = 'block';
                }
            }
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('integration-search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            if (searchTerm === '') {
                // Show all sections and cards
                categorySections.forEach(section => {
                    section.style.display = 'block';
                });
                integrationCards.forEach(card => {
                    card.style.display = 'block';
                });
                return;
            }
            
            categorySections.forEach(section => {
                let sectionHasVisibleCards = false;
                const sectionCards = section.querySelectorAll('.integration-card');
                
                sectionCards.forEach(card => {
                    const name = card.getAttribute('data-name') || '';
                    const description = card.getAttribute('data-description') || '';
                    
                    if (name.includes(searchTerm) || description.includes(searchTerm)) {
                        card.style.display = 'block';
                        sectionHasVisibleCards = true;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Show/hide section based on whether it has visible cards
                section.style.display = sectionHasVisibleCards ? 'block' : 'none';
            });
        });
    }
});
</script>

<style>
/* Custom styles for better UX */
.integration-card {
    cursor: pointer;
}

.integration-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.btn-primary {
    display: inline-block;
    text-align: center;
    text-decoration: none;
}

.btn-secondary {
    display: inline-block;
    text-align: center;
    text-decoration: none;
}

.hero-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

<?php get_footer(); ?>
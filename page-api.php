<?php
/*
Template Name: API Documentation Page
*/

get_header(); ?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-gray-900 to-blue-900 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold mb-6" style="color: white !important;">
                Powerful API for developers
            </h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto" style="color: white !important; opacity: 0.9;">
                Build custom integrations, automate workflows, and extend your store's functionality with our comprehensive REST API.
            </p>
            <div class="flex justify-center items-center">
                <a href="#get-started" class="btn-primary text-lg px-8 py-4 bg-white text-gray-900 hover:bg-gray-100 rounded-lg font-semibold transition-all">
                    Get Started
                </a>
            </div>
        </div>
    </div>
</section>

<!-- API Overview -->
<section class="py-20 bg-white" id="get-started">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Everything you need to integrate</h2>
                <p class="text-xl text-gray-600">RESTful API, webhooks, SDKs, and comprehensive documentation</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-900">REST API</h3>
                    <p class="text-gray-600">Simple, predictable REST endpoints for all your eCommerce data</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-lg mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-900">Webhooks</h3>
                    <p class="text-gray-600">Real-time notifications for orders, payments, and inventory changes</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-lg mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-900">SDKs</h3>
                    <p class="text-gray-600">Official SDKs for Python, Node.js, PHP, and more</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-lg mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-900">Documentation</h3>
                    <p class="text-gray-600">Comprehensive guides, examples, and interactive API explorer</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Code Examples -->
<section class="bg-gray-900 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4 text-white">Quick Start</h2>
                <p class="text-xl text-white opacity-90">Get up and running with our API in minutes</p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-2xl font-semibold mb-6 text-white">Authentication</h3>
                    <div class="bg-gray-800 rounded-lg p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-400">API Authentication</span>
                            <button class="text-sm bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded copy-btn text-white transition-colors" data-copy="curl">Copy</button>
                        </div>
                        <pre class="text-sm text-green-400 overflow-x-auto"><code>curl -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  https://api.yoursite.biz/v1/products</code></pre>
                    </div>
                    
                    <h3 class="text-2xl font-semibold mb-6 text-white">Create a Product</h3>
                    <div class="bg-gray-800 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-400">POST /v1/products</span>
                            <button class="text-sm bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded copy-btn text-white transition-colors" data-copy="product">Copy</button>
                        </div>
                        <pre class="text-sm text-green-400 overflow-x-auto"><code>{
  "name": "Awesome T-Shirt",
  "description": "Super comfortable cotton t-shirt",
  "price": "29.99",
  "inventory": 100,
  "images": [
    "https://example.com/image1.jpg"
  ],
  "categories": ["clothing", "t-shirts"]
}</code></pre>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-2xl font-semibold mb-6 text-white">Retrieve Orders</h3>
                    <div class="bg-gray-800 rounded-lg p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-400">GET /v1/orders</span>
                            <button class="text-sm bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded copy-btn text-white transition-colors" data-copy="orders">Copy</button>
                        </div>
                        <pre class="text-sm text-blue-400 overflow-x-auto"><code>GET /v1/orders?status=completed&limit=10

Response:
{
  "orders": [
    {
      "id": "ord_123456",
      "status": "completed",
      "total": "89.97",
      "customer": {
        "email": "customer@example.com"
      },
      "items": [...]
    }
  ],
  "pagination": {...}
}</code></pre>
                    </div>
                    
                    <h3 class="text-2xl font-semibold mb-6 text-white">Webhook Example</h3>
                    <div class="bg-gray-800 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-400">Order Created Webhook</span>
                            <button class="text-sm bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded copy-btn text-white transition-colors" data-copy="webhook">Copy</button>
                        </div>
                        <pre class="text-sm text-yellow-400 overflow-x-auto"><code>{
  "event": "order.created",
  "data": {
    "id": "ord_789012",
    "status": "pending",
    "total": "49.99",
    "created_at": "2024-01-15T10:30:00Z"
  }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- API Endpoints -->
<section class="py-20 bg-gray-50" id="documentation">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">API Endpoints</h2>
                <p class="text-xl text-gray-600">Complete reference for all available endpoints</p>
            </div>
            
            <div class="space-y-8">
                <!-- Products -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xl font-semibold flex items-center text-gray-900">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            Products
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded mr-3">GET</span>
                                    <code class="text-sm text-gray-700 font-mono">/v1/products</code>
                                </div>
                                <span class="text-sm text-gray-500">List all products</span>
                            </div>
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded mr-3">GET</span>
                                    <code class="text-sm text-gray-700 font-mono">/v1/products/{id}</code>
                                </div>
                                <span class="text-sm text-gray-500">Retrieve a product</span>
                            </div>
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded mr-3">POST</span>
                                    <code class="text-sm text-gray-700 font-mono">/v1/products</code>
                                </div>
                                <span class="text-sm text-gray-500">Create a product</span>
                            </div>
                            <div class="flex items-center justify-between py-3">
                                <div class="flex items-center">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded mr-3">PUT</span>
                                    <code class="text-sm text-gray-700 font-mono">/v1/products/{id}</code>
                                </div>
                                <span class="text-sm text-gray-500">Update a product</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xl font-semibold flex items-center text-gray-900">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            Orders
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded mr-3">GET</span>
                                    <code class="text-sm text-gray-700 font-mono">/v1/orders</code>
                                </div>
                                <span class="text-sm text-gray-500">List all orders</span>
                            </div>
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded mr-3">GET</span>
                                    <code class="text-sm text-gray-700 font-mono">/v1/orders/{id}</code>
                                </div>
                                <span class="text-sm text-gray-500">Retrieve an order</span>
                            </div>
                            <div class="flex items-center justify-between py-3">
                                <div class="flex items-center">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded mr-3">PUT</span>
                                    <code class="text-sm text-gray-700 font-mono">/v1/orders/{id}</code>
                                </div>
                                <span class="text-sm text-gray-500">Update order status</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customers -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xl font-semibold flex items-center text-gray-900">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            Customers
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded mr-3">GET</span>
                                    <code class="text-sm text-gray-700 font-mono">/v1/customers</code>
                                </div>
                                <span class="text-sm text-gray-500">List all customers</span>
                            </div>
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded mr-3">GET</span>
                                    <code class="text-sm text-gray-700 font-mono">/v1/customers/{id}</code>
                                </div>
                                <span class="text-sm text-gray-500">Retrieve a customer</span>
                            </div>
                            <div class="flex items-center justify-between py-3">
                                <div class="flex items-center">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded mr-3">POST</span>
                                    <code class="text-sm text-gray-700 font-mono">/v1/customers</code>
                                </div>
                                <span class="text-sm text-gray-500">Create a customer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SDKs Section -->
<section class="bg-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Official SDKs</h2>
                <p class="text-xl text-gray-600">Get started quickly with our official libraries</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg p-6 text-center feature-card border border-gray-200 hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                        <span class="font-bold text-blue-600">JS</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">JavaScript</h3>
                    <p class="text-gray-600 text-sm mb-4">Node.js & Browser</p>
                    <a href="#" class="btn-secondary text-sm px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg transition-colors">Install</a>
                </div>
                
                <div class="bg-white rounded-lg p-6 text-center feature-card border border-gray-200 hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                        <span class="font-bold text-green-600">PY</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Python</h3>
                    <p class="text-gray-600 text-sm mb-4">Python 3.7+</p>
                    <a href="#" class="btn-secondary text-sm px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg transition-colors">Install</a>
                </div>
                
                <div class="bg-white rounded-lg p-6 text-center feature-card border border-gray-200 hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                        <span class="font-bold text-purple-600">PHP</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">PHP</h3>
                    <p class="text-gray-600 text-sm mb-4">PHP 7.4+</p>
                    <a href="#" class="btn-secondary text-sm px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg transition-colors">Install</a>
                </div>
                
                <div class="bg-white rounded-lg p-6 text-center feature-card border border-gray-200 hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-red-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                        <span class="font-bold text-red-600">RB</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Ruby</h3>
                    <p class="text-gray-600 text-sm mb-4">Ruby 2.7+</p>
                    <a href="#" class="btn-secondary text-sm px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg transition-colors">Install</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-purple-600 to-blue-600 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-5xl font-bold mb-6 text-white">
                Ready to start building?
            </h2>
            <p class="text-xl mb-8 text-white opacity-90">
                Get your API key and start integrating with our platform today
            </p>
            <div class="flex justify-center items-center">
                <a href="<?php echo home_url('/contact'); ?>" class="btn-primary text-lg px-8 py-4 bg-white text-purple-600 hover:bg-gray-100 rounded-lg font-semibold transition-all">
                    Get API Key
                </a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copy button functionality
    document.querySelectorAll('.copy-btn').forEach(button => {
        button.addEventListener('click', function() {
            const codeBlock = this.closest('.bg-gray-800').querySelector('code');
            const text = codeBlock.textContent;
            
            navigator.clipboard.writeText(text).then(() => {
                const originalText = this.textContent;
                this.textContent = 'Copied!';
                this.classList.remove('bg-gray-700');
                this.classList.add('bg-green-600');
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.classList.remove('bg-green-600');
                    this.classList.add('bg-gray-700');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        });
    });
});
</script>

<style>
/* Additional styles for better button visibility and functionality */
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

.feature-card {
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-2px);
}

.copy-btn {
    cursor: pointer;
}

code {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
}
</style>

<?php get_footer(); ?>
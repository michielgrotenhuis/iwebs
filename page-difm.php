<?php
/*
Template Name: DIFM - Do It For Me Page
*/

get_header(); ?>
 <style>
        
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .trust-badge {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }
        
        .feature-card {
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .testimonial-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        }
        
        .price-tag {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .stat-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        }
        
        .process-step {
            position: relative;
        }
        
        .process-step::before {
            content: '';
            position: absolute;
            top: 50%;
            right: -2rem;
            width: 3rem;
            height: 2px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transform: translateY(-50%);
        }
        
        .process-step:last-child::before {
            display: none;
        }
        
        .comparison-table {
            overflow-x: auto;
        }
        
        .comparison-table table {
            min-width: 800px;
        }
        
        .featured-plan {
            border: 2px solid #667eea;
            background: linear-gradient(145deg, #ffffff 0%, #f0f4ff 100%);
            transform: scale(1.02);
        }
        
        .checkmark {
            color: #10b981;
        }
        
        .x-mark {
            color: #ef4444;
        }
        
        .guarantee-badge {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .modal {
            backdrop-filter: blur(10px);
            background: rgba(0, 0, 0, 0.5);
        }
        
        .onboarding-step {
            display: none;
        }
        
        .onboarding-step.active {
            display: block;
        }
        
        .progress-bar {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s ease;
        }
    </style>

<?php if (get_theme_mod('difm_hero_enable', true)) : ?>

<!-- Hero Section -->
 <!-- DIFM Banner Section (for homepage) -->
    <section class="py-20 bg-gradient-to-br from-indigo-50 via-white to-purple-50 border-y border-gray-200" id="difm-banner">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden">
                    
                    <!-- Background Pattern -->
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-purple-600/5"></div>
                        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-full transform translate-x-20 -translate-y-20"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-purple-500/10 to-pink-500/10 rounded-full transform -translate-x-16 translate-y-16"></div>
                        
                        <!-- Content -->
                        <div class="relative px-8 py-16 lg:px-16 lg:py-20">
                            <div class="grid lg:grid-cols-2 gap-12 items-center">
                                
                                <!-- Left Content -->
                                <div class="text-center lg:text-left">
                                    <!-- Badge -->
                                    <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-100 to-purple-100 rounded-full text-sm font-bold text-blue-700 mb-8">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4"></path>
                                        </svg>
                                        Done-For-You Service
                                    </div>
                                    
                                    <!-- Main Heading -->
                                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                                        Don't Want to Build It Yourself?
                                    </h2>
                                    
                                    <!-- Subheading -->
                                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                                        Let our expert team build your perfect store while you focus on your business. Professional results, guaranteed.
                                    </p>
                                    
                                    <!-- Value Props -->
                                    <div class="grid grid-cols-2 gap-4 mb-8">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-6 h-6 text-blue-600 mr-3">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-gray-700 font-medium">Professional Design</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-6 h-6 text-blue-600 mr-3">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-gray-700 font-medium">5-Day Delivery</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-6 h-6 text-blue-600 mr-3">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-gray-700 font-medium">Money-Back Guarantee</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-6 h-6 text-blue-600 mr-3">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-gray-700 font-medium">Ongoing Support</span>
                                        </div>
                                    </div>
                                    
                                    <!-- CTA Buttons -->
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        <!-- Primary CTA -->
                                        <a href="#packages" class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                                            <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4"></path>
                                            </svg>
                                            Build My Store
                                            <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- Secondary CTA -->
                                        <a href="#how-it-works" class="group inline-flex items-center justify-center px-8 py-4 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl border-2 border-gray-200 hover:border-gray-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                            <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            Ask Questions
                                        </a>
                                    </div>
                                    
                                    <!-- Trust Elements -->
                                    <div class="mt-8 pt-8 border-t border-gray-200">
                                        <div class="flex items-center justify-center lg:justify-start space-x-6 text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                                <span class="font-medium">4.9/5 rating</span>
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span class="font-medium">500+ stores built</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Visual Element -->
                                <div class="relative hidden lg:block">
                                    <div class="relative w-full max-w-md mx-auto">
                                        <!-- Main illustration container -->
                                        <div class="relative bg-gradient-to-br from-blue-50 to-purple-50 rounded-3xl p-8 border-2 border-blue-100">
                                            <!-- Website mockup -->
                                            <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden transform hover:scale-105 transition-transform duration-300">
                                                <!-- Browser bar -->
                                                <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                                                    <div class="flex items-center space-x-2">
                                                        <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                                        <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                                        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                                        <div class="flex-1 bg-white rounded-sm h-6 ml-4 flex items-center px-3">
                                                            <div class="w-3 h-3 text-green-500 mr-2">🔒</div>
                                                            <div class="text-xs text-gray-500 font-mono">yourstore.com</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Website content -->
                                                <div class="p-6">
                                                    <div class="space-y-4">
                                                        <div class="h-4 bg-gradient-to-r from-blue-200 to-purple-200 rounded w-3/4"></div>
                                                        <div class="h-3 bg-gray-200 rounded w-full"></div>
                                                        <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                                                        <div class="grid grid-cols-2 gap-3 mt-4">
                                                            <div class="h-16 bg-gradient-to-r from-blue-400 to-purple-400 rounded-lg"></div>
                                                            <div class="h-16 bg-gray-200 rounded-lg"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Floating elements -->
                                            <div class="absolute -top-4 -right-4 w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            
                                            <div class="absolute -bottom-3 -left-3 w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="hero-gradient py-24 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-48 -translate-y-48"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-48 translate-y-48"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Trust Badges -->
                <div class="flex flex-wrap justify-center gap-4 mb-8">
                    <div class="trust-badge px-4 py-2 rounded-full text-white text-sm font-medium">
                        ⭐ 4.9/5 Rating
                    </div>
                    <div class="trust-badge px-4 py-2 rounded-full text-white text-sm font-medium">
                        🚀 500+ Projects Completed
                    </div>
                    <div class="trust-badge px-4 py-2 rounded-full text-white text-sm font-medium">
                        🔒 100% Money-Back Guarantee
                    </div>
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                    Professional Website Development
                    <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                        Done For You
                    </span>
                </h1>
                
                <p class="text-xl lg:text-2xl text-white/90 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Skip the hassle of DIY website building. Our expert team creates stunning, conversion-optimized websites that work from day one. 
                    <strong>Focus on your business while we handle the tech.</strong>
                </p>
                
                <!-- Main CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    <button onclick="openOnboarding()" class="bg-white text-blue-600 font-bold px-8 py-4 rounded-xl shadow-lg hover:bg-gray-50 transform hover:-translate-y-1 transition-all duration-200 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Get Started Now - Free Consultation
                    </button>
                    <a href="#packages" class="border-2 border-white text-white font-semibold px-8 py-4 rounded-xl hover:bg-white hover:text-blue-600 transition-all duration-200">
                        View Our Packages
                    </a>
                </div>
                
                <!-- Key Results -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                    <div class="stat-card p-6 rounded-xl">
                        <div class="text-3xl font-bold text-blue-600 mb-2">5-14</div>
                        <div class="text-gray-600 text-sm">Days to Launch</div>
                    </div>
                    <div class="stat-card p-6 rounded-xl">
                        <div class="text-3xl font-bold text-green-600 mb-2">98%</div>
                        <div class="text-gray-600 text-sm">Client Satisfaction</div>
                    </div>
                    <div class="stat-card p-6 rounded-xl">
                        <div class="text-3xl font-bold text-purple-600 mb-2">24/7</div>
                        <div class="text-gray-600 text-sm">Support Available</div>
                    </div>
                    <div class="stat-card p-6 rounded-xl">
                        <div class="text-3xl font-bold text-orange-600 mb-2">500+</div>
                        <div class="text-gray-600 text-sm">Websites Built</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        Why 500+ Businesses Trust Us With Their Online Presence
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Building a professional website is complex. Let our proven team handle it while you focus on what you do best - running your business.
                    </p>
                </div>
                
                <div class="grid lg:grid-cols-3 gap-8 mb-16">
                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Not satisfied? Get your money back. No questions asked.</h3>
                    <p class="text-lg opacity-90">
                        We're so confident in our work that we offer a complete money-back guarantee. If you're not 100% satisfied with your website, we'll refund every penny within 30 days.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof / Testimonials -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        What Our Clients Say About Working With Us
                    </h2>
                    <p class="text-xl text-gray-600">Real results from real businesses</p>
                </div>
                
                <div class="grid lg:grid-cols-3 gap-8 mb-12">
                    <div class="testimonial-card p-8 rounded-2xl border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                ★★★★★
                            </div>
                        </div>
                        <p class="text-gray-700 mb-6 italic">
                            "They delivered exactly what we needed in just 7 days. Our new website has increased our leads by 300% in the first month alone. Best investment we've made for our business."
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center text-white font-bold mr-4">
                                SM
                            </div>
                            <div>
                                <div class="font-semibold">Sarah Mitchell</div>
                                <div class="text-sm text-gray-500">CEO, Mitchell Marketing</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card p-8 rounded-2xl border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                ★★★★★
                            </div>
                        </div>
                        <p class="text-gray-700 mb-6 italic">
                            "Professional, fast, and incredibly knowledgeable. They understood our vision immediately and delivered beyond our expectations. The ongoing support has been fantastic too."
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-400 rounded-full flex items-center justify-center text-white font-bold mr-4">
                                JR
                            </div>
                            <div>
                                <div class="font-semibold">James Rodriguez</div>
                                <div class="text-sm text-gray-500">Founder, TechStart Solutions</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card p-8 rounded-2xl border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                ★★★★★
                            </div>
                        </div>
                        <p class="text-gray-700 mb-6 italic">
                            "After struggling with DIY website builders for months, hiring them was a game-changer. They built our e-commerce store in 10 days and we started making sales immediately."
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-white font-bold mr-4">
                                AL
                            </div>
                            <div>
                                <div class="font-semibold">Amanda Liu</div>
                                <div class="text-sm text-gray-500">Owner, Artisan Jewelry Co.</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Trust Logos -->
                <div class="text-center">
                    <p class="text-gray-500 mb-8">Trusted by companies of all sizes</p>
                    <div class="flex justify-center items-center space-x-12 opacity-60">
                        <div class="text-2xl font-bold text-gray-400">Company A</div>
                        <div class="text-2xl font-bold text-gray-400">Brand B</div>
                        <div class="text-2xl font-bold text-gray-400">Business C</div>
                        <div class="text-2xl font-bold text-gray-400">Startup D</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Process -->
    <section id="how-it-works" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        Our Proven 4-Step Process
                    </h2>
                    <p class="text-xl text-gray-600">
                        From idea to launch in just 5-14 days. Here's exactly how we do it.
                    </p>
                </div>
                
                <div class="grid lg:grid-cols-4 gap-8">
                    <div class="process-step text-center">
                        <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-2xl mx-auto mb-6">
                            1
                        </div>
                        <h3 class="text-xl font-bold mb-4">Discovery Call</h3>
                        <p class="text-gray-600">
                            We learn about your business, goals, and vision in a detailed 30-minute consultation.
                        </p>
                    </div>
                    
                    <div class="process-step text-center">
                        <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-2xl mx-auto mb-6">
                            2
                        </div>
                        <h3 class="text-xl font-bold mb-4">Strategy & Design</h3>
                        <p class="text-gray-600">
                            Our team creates a custom strategy and design mockups tailored to your industry and goals.
                        </p>
                    </div>
                    
                    <div class="process-step text-center">
                        <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-2xl mx-auto mb-6">
                            3
                        </div>
                        <h3 class="text-xl font-bold mb-4">Development</h3>
                        <p class="text-gray-600">
                            We build your website with daily updates and opportunities for feedback throughout the process.
                        </p>
                    </div>
                    
                    <div class="process-step text-center">
                        <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center text-white font-bold text-2xl mx-auto mb-6">
                            4
                        </div>
                        <h3 class="text-xl font-bold mb-4">Launch & Support</h3>
                        <p class="text-gray-600">
                            We launch your site, provide training, and offer 30 days of support to ensure your success.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        Choose Your Perfect Package
                    </h2>
                    <p class="text-xl text-gray-600">
                        All packages include professional design, development, and launch support
                    </p>
                </div>
                
                <!-- Package Cards -->
                <div class="grid lg:grid-cols-3 gap-8 mb-16">
                    <!-- Standard Package -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold mb-2">Standard</h3>
                            <div class="price-tag text-white px-4 py-2 rounded-full inline-block mb-4">
                                <span class="text-3xl font-bold">$1,200</span>
                            </div>
                            <p class="text-gray-600">Perfect for small businesses and startups</p>
                        </div>
                        
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Up to 5 pages (Home, About, Services, Contact, etc.)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Mobile responsive design</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Basic SEO optimization</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Contact form integration</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>14-day delivery</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>30-day support</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 x-mark mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-gray-400">E-commerce functionality</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 x-mark mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-gray-400">Advanced integrations</span>
                            </li>
                        </ul>
                        
                        <button onclick="startOnboarding('Standard', '$1,200', 1)" class="w-full bg-gray-900 text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition-all duration-200">
                            Get Started
                        </button>
                    </div>
                    
                    <!-- Professional Package (Featured) -->
                    <div class="featured-plan rounded-2xl p-8 shadow-xl relative">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-bold">
                                Most Popular
                            </span>
                        </div>
                        
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold mb-2">Professional</h3>
                            <div class="price-tag text-white px-4 py-2 rounded-full inline-block mb-4">
                                <span class="text-3xl font-bold">$2,400</span>
                            </div>
                            <p class="text-gray-600">Ideal for growing businesses</p>
                        </div>
                        
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Up to 10 pages</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Premium design & animations</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Advanced SEO optimization</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Basic e-commerce (up to 50 products)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Payment gateway integration</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>7-day delivery</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>60-day support</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Analytics & tracking setup</span>
                            </li>
                        </ul>
                        
                        <button onclick="startOnboarding('Professional', '$2,400', 2)" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-4 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-200">
                            Get Started
                        </button>
                    </div>
                    
                    <!-- Enterprise Package -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold mb-2">Enterprise</h3>
                            <div class="price-tag text-white px-4 py-2 rounded-full inline-block mb-4">
                                <span class="text-3xl font-bold">$4,800</span>
                            </div>
                            <p class="text-gray-600">For established businesses</p>
                        </div>
                        
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Unlimited pages</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Custom design & branding</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Full e-commerce (unlimited products)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Advanced integrations (CRM, email, etc.)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Performance optimization</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>5-day delivery</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>90-day support</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Dedicated project manager</span>
                            </li>
                        </ul>
                        
                        <button onclick="startOnboarding('Enterprise', '$4,800', 3)" class="w-full bg-gray-900 text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition-all duration-200">
                            Get Started
                        </button>
                    </div>
                </div>
                
                <!-- Feature Comparison Table -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Detailed Feature Comparison</h3>
                    </div>
                    <div class="comparison-table overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Feature</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Standard</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Professional</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Enterprise</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Number of Pages</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Up to 5</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Up to 10</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Unlimited</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Design Revisions</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">2 rounds</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">3 rounds</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Unlimited</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Mobile Responsive</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <svg class="w-5 h-5 text-green-500 mx-auto checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <svg class="w-5 h-5 text-green-500 mx-auto checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <svg class="w-5 h-5 text-green-500 mx-auto checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">SEO Optimization</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Basic</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Advanced</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Premium</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">E-commerce Functionality</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <svg class="w-5 h-5 text-red-500 mx-auto x-mark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Up to 50 products</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Unlimited</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Payment Integration</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <svg class="w-5 h-5 text-red-500 mx-auto x-mark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <svg class="w-5 h-5 text-green-500 mx-auto checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <svg class="w-5 h-5 text-green-500 mx-auto checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Analytics Setup</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Basic</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <svg class="w-5 h-5 text-green-500 mx-auto checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Advanced</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Custom Integrations</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <svg class="w-5 h-5 text-red-500 mx-auto x-mark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">2 integrations</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Unlimited</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Delivery Time</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">14 days</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">7 days</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">5 days</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Support Period</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">30 days</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">60 days</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">90 days</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Training Included</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Video tutorials</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Live training session</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Multiple sessions</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Project Manager</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <svg class="w-5 h-5 text-red-500 mx-auto x-mark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Shared</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">Dedicated</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        Frequently Asked Questions
                    </h2>
                    <p class="text-xl text-gray-600">
                        Everything you need to know about our done-for-you website service
                    </p>
                </div>
                
                <div class="space-y-6">
                    <div class="border border-gray-200 rounded-xl">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 rounded-xl" onclick="toggleFaq(this)">
                            <span class="font-semibold text-gray-900">How long does it really take to build my website?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">
                                Our delivery times are guaranteed: 14 days for Standard, 7 days for Professional, and 5 days for Enterprise packages. These timelines include design, development, testing, and launch. We provide daily updates so you know exactly where we are in the process.
                            </p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-xl">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 rounded-xl" onclick="toggleFaq(this)">
                            <span class="font-semibold text-gray-900">What if I'm not satisfied with the final result?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">
                                We offer a 100% money-back guarantee within 30 days of project completion. If you're not completely satisfied with your website, we'll refund your entire payment - no questions asked. We're confident in our work because we've delivered 500+ successful projects.
                            </p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-xl">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 rounded-xl" onclick="toggleFaq(this)">
                            <span class="font-semibold text-gray-900">Do I own the website and can I make changes later?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">
                                Yes, you own 100% of your website, domain, and all content. We build your site using popular platforms that give you full control. We also provide comprehensive training so you can make updates yourself, or you can hire us for ongoing maintenance and updates.
                            </p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-xl">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 rounded-xl" onclick="toggleFaq(this)">
                            <span class="font-semibold text-gray-900">What information do you need from me to get started?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">
                                We'll gather everything we need during our discovery call. This includes your business goals, target audience, brand preferences, content, and any specific functionality requirements. Don't worry if you don't have everything ready - we'll guide you through the entire process.
                            </p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-xl">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 rounded-xl" onclick="toggleFaq(this)">
                            <span class="font-semibold text-gray-900">Can you help with content creation and copywriting?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">
                                Absolutely! Our team includes professional copywriters who can create compelling content for your website. We can also help source high-quality images and create graphics. Content creation is included in Professional and Enterprise packages, and available as an add-on for Standard packages.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-20 hero-gradient">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center text-white">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                    Ready to Get Your Professional Website Built?
                </h2>
                <p class="text-xl mb-8 opacity-90">
                    Join 500+ businesses who chose to focus on their business while we handled their website. 
                    <strong>Your success is our guarantee.</strong>
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                    <button onclick="openOnboarding()" class="bg-white text-blue-600 font-bold px-8 py-4 rounded-xl shadow-lg hover:bg-gray-50 transform hover:-translate-y-1 transition-all duration-200 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Start Your Project Today
                    </button>
                    <a href="tel:+1234567890" class="border-2 border-white text-white font-semibold px-8 py-4 rounded-xl hover:bg-white hover:text-blue-600 transition-all duration-200 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Call Us Now
                    </a>
                </div>
                
                <div class="flex justify-center items-center space-x-8 text-sm opacity-75">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        No upfront payment
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        30-day guarantee
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Expert team
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Onboarding Modal -->
    <div id="onboarding-modal" class="modal fixed inset-0 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-2xl max-w-2xl w-full mx-4 max-h-screen overflow-y-auto">
            <div class="p-8">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-3xl font-bold text-gray-900">Let's Build Your Website</h3>
                    <button onclick="closeOnboarding()" class="text-gray-400 hover:text-gray-600 text-2xl">
                        ×
                    </button>
                </div>
                
                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Progress</span>
                        <span class="text-sm font-medium text-gray-700" id="progress-text">1 of 4</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="progress-bar h-2 rounded-full" id="progress-bar" style="width: 25%"></div>
                    </div>
                </div>
                
                <!-- Onboarding Form -->
                <form id="onboarding-form">
                    <!-- Step 1: Package Selection -->
                    <div class="onboarding-step active" id="step-1">
                        <h4 class="text-xl font-semibold mb-6">Package Selected</h4>
                        <div class="bg-blue-50 p-6 rounded-xl mb-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h5 class="font-semibold text-blue-900" id="selected-package">Professional Package</h5>
                                    <p class="text-blue-700">Perfect for growing businesses</p>
                                </div>
                                <div class="text-3xl font-bold text-blue-900" id="selected-price">$2,400</div>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-6">Let's gather some information to create your perfect website.</p>
                    </div>
                    
                    <!-- Step 2: Contact Information -->
                    <div class="onboarding-step" id="step-2">
                        <h4 class="text-xl font-semibold mb-6">Contact Information</h4>
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                <input type="text" id="first_name" name="first_name" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                <input type="text" id="last_name" name="last_name" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <!-- Step 3: Business Information -->
                    <div class="onboarding-step" id="step-3">
                        <h4 class="text-xl font-semibold mb-6">Business Information</h4>
                        <div class="mb-4">
                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                            <input type="text" id="company_name" name="company_name" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="business_type" class="block text-sm font-medium text-gray-700 mb-2">Type of Business *</label>
                            <select id="business_type" name="business_type" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                            <label for="website_purpose" class="block text-sm font-medium text-gray-700 mb-2">Main Purpose of Website</label>
                            <textarea id="website_purpose" name="website_purpose" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tell us what you want to achieve with your website..."></textarea>
                        </div>
                    </div>
                    
                    <!-- Step 4: Project Details -->
                    <div class="onboarding-step" id="step-4">
                        <h4 class="text-xl font-semibold mb-6">Project Details</h4>
                        <div class="mb-4">
                            <label for="timeline" class="block text-sm font-medium text-gray-700 mb-2">Preferred Launch Date</label>
                            <select id="timeline" name="timeline" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select timeline</option>
                                <option value="asap">As soon as possible</option>
                                <option value="1-2weeks">1-2 weeks</option>
                                <option value="2-4weeks">2-4 weeks</option>
                                <option value="1-2months">1-2 months</option>
                                <option value="flexible">I'm flexible</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="design_style" class="block text-sm font-medium text-gray-700 mb-2">Preferred Design Style</label>
                            <select id="design_style" name="design_style" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-2">Special Requirements or Features</label>
                            <textarea id="special_requests" name="special_requests" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Any specific features, functionality, or requirements you'd like to mention..."></textarea>
                        </div>
                    </div>
                    
                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-8">
                        <button type="button" id="prev-btn" onclick="previousStep()" class="bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-xl hover:bg-gray-300 transition-all duration-200 hidden">
                            Previous
                        </button>
                        <div class="flex-1"></div>
                        <button type="button" id="next-btn" onclick="nextStep()" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold px-6 py-3 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-200">
                            Next Step
                        </button>
                        <button type="submit" id="submit-btn" class="bg-gradient-to-r from-green-600 to-blue-600 text-white font-semibold px-8 py-3 rounded-xl hover:from-green-700 hover:to-blue-700 transition-all duration-200 hidden">
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

    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function startOnboarding(packageName, packagePrice, packageId) {
            document.getElementById('selected-package').textContent = packageName + ' Package';
            document.getElementById('selected-price').textContent = packagePrice;
            document.getElementById('selected_package_id').value = packageId;
            document.getElementById('selected_package_name').value = packageName;
            document.getElementById('selected_package_price').value = packagePrice;
            
            document.getElementById('onboarding-modal').classList.remove('hidden');
            document.getElementById('onboarding-modal').classList.add('flex');
            document.body.style.overflow = 'hidden';
            
            currentStep = 1;
            updateStep();
        }

        function openOnboarding() {
            // Default to Professional package if opened from CTA
            startOnboarding('Professional', '$2,400', 2);
        }

        function closeOnboarding() {
            document.getElementById('onboarding-modal').classList.add('hidden');
            document.getElementById('onboarding-modal').classList.remove('flex');
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
            document.querySelectorAll('.onboarding-step').forEach(step => {
                step.classList.remove('active');
            });
            
            // Show current step
            document.getElementById(`step-${currentStep}`).classList.add('active');
            
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

        function toggleFaq(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Form submission
        document.getElementById('onboarding-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!validateCurrentStep()) {
                return;
            }
            
            const formData = new FormData(this);
            const submitBtn = document.getElementById('submit-btn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Submitting...';
            submitBtn.disabled = true;
            
            // Simulate form submission (replace with actual endpoint)
            setTimeout(() => {
                alert('Thank you! Your project request has been submitted. We\'ll contact you within 24 hours to discuss your project and schedule your discovery call.');
                closeOnboarding();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });

        // Close modal when clicking outside
        document.getElementById('onboarding-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeOnboarding();
            }
        });

        // Smooth scroll to sections
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="#"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.feature-card, .testimonial-card, .stat-card');
            animateElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        });
    </script>

<?php
                    endif; get_footer(); ?>
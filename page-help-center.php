<?php
/**
 * Template Name: Help Center Page
 * Custom page template for help center and support resources
 * Save as: page-help-center.php
 */

get_header(); 
?>

<!-- Hero Section -->
<section class="hero-gradient text-white py-20 lg:py-32">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                How can we help you?
            </h1>
            <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-3xl mx-auto">
                Find answers, learn new skills, and get the support you need to succeed with our platform.
            </p>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <a href="https://iwebs.in/guides/" class="btn-primary text-lg px-8 py-4 bg-white text-blue-600 hover:bg-gray-100 rounded-lg font-semibold">
                    Browse All Guides
                </a>
                <a href="https://iwebs.in/contact/" class="btn-secondary text-lg px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-blue-600 rounded-lg font-semibold">
                    Get Personal Help
                </a>
            </div>
            
            <!-- Quick Stats -->
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-3xl font-bold mb-2">500+</div>
                    <div class="text-white/80">Help Articles</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-3xl font-bold mb-2">24/7</div>
                    <div class="text-white/80">Support Available</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-3xl font-bold mb-2">&lt;2hr</div>
                    <div class="text-white/80">Average Response</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Help Options -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Get Help Fast</h2>
                <p class="text-xl text-gray-600">Choose the support option that works best for you</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Live Chat -->
                <div class="bg-blue-50 rounded-xl p-6 text-center hover:bg-blue-100 transition-colors group">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Live Chat</h3>
                    <p class="text-gray-600 mb-4">Get instant answers from our support team</p>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Start Chat
                    </button>
                </div>

                <!-- Email Support -->
                <div class="bg-green-50 rounded-xl p-6 text-center hover:bg-green-100 transition-colors group">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-600 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Email Support</h3>
                    <p class="text-gray-600 mb-4">We'll respond within 24 hours</p>
                    <a href="https://iwebs.in/contact/" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors inline-block">
                        Send Email
                    </a>
                </div>

                <!-- Phone Support -->
                <div class="bg-purple-50 rounded-xl p-6 text-center hover:bg-purple-100 transition-colors group">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Phone Support</h3>
                    <p class="text-gray-600 mb-4">Mon-Fri, 9AM-6PM EST</p>
                    <a href="tel:+1-555-123-4567" class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition-colors inline-block">
                        Call Now
                    </a>
                </div>

                <!-- Schedule Demo -->
                <div class="bg-orange-50 rounded-xl p-6 text-center hover:bg-orange-100 transition-colors group">
                    <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-600 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Schedule Demo</h3>
                    <p class="text-gray-600 mb-4">Get personalized help with setup</p>
                    <a href="https://iwebs.in/contact/" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors inline-block">
                        Book Demo
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Help Resources -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Find What You Need</h2>
                <p class="text-xl text-gray-600">Comprehensive resources to help you succeed</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Guides & Tutorials -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                    <div class="bg-gradient-to-br from-blue-500 to-purple-600 p-8 text-white">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Guides & Tutorials</h3>
                        <p class="text-white/90 mb-4">Step-by-step guides to master every feature</p>
                        <span class="text-sm bg-white/20 px-3 py-1 rounded-full">100+ Articles</span>
                    </div>
                    <div class="p-8">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Getting started tutorials
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Advanced feature guides
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Best practices & tips
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Video tutorials
                            </li>
                        </ul>
                        <a href="https://iwebs.in/guides/" class="btn-primary w-full text-center py-3 rounded-lg font-semibold">
                            Browse Guides →
                        </a>
                    </div>
                </div>

                <!-- Live Webinars -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                    <div class="bg-gradient-to-br from-green-500 to-teal-600 p-8 text-white">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Live Webinars</h3>
                        <p class="text-white/90 mb-4">Join expert-led sessions and Q&A</p>
                        <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Weekly Sessions</span>
                    </div>
                    <div class="p-8">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Live expert instruction
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Interactive Q&A sessions
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Recorded for later viewing
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Free to attend
                            </li>
                        </ul>
                        <a href="https://iwebs.in/webinars/" class="btn-primary w-full text-center py-3 rounded-lg font-semibold">
                            View Schedule →
                        </a>
                    </div>
                </div>

                <!-- API Documentation -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                    <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-8 text-white">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">API Documentation</h3>
                        <p class="text-white/90 mb-4">Complete reference for developers</p>
                        <span class="text-sm bg-white/20 px-3 py-1 rounded-full">RESTful API</span>
                    </div>
                    <div class="p-8">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Complete API reference
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Code examples & SDKs
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Authentication guides
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Webhook documentation
                            </li>
                        </ul>
                        <a href="https://iwebs.in/api/" class="btn-primary w-full text-center py-3 rounded-lg font-semibold">
                            View Docs →
                        </a>
                    </div>
                </div>

                <!-- Integrations -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                    <div class="bg-gradient-to-br from-orange-500 to-red-600 p-8 text-white">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a1 1 0 01-1-1V9a1 1 0 011-1h1a2 2 0 100-4H4a1 1 0 01-1-1V4a1 1 0 011-1h3a1 1 0 001-1v-1a2 2 0 012-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Integrations</h3>
                        <p class="text-white/90 mb-4">Connect with your favorite tools</p>
                        <span class="text-sm bg-white/20 px-3 py-1 rounded-full">100+ Apps</span>
                    </div>
                    <div class="p-8">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Payment gateways
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Shipping & fulfillment
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Marketing & analytics
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Setup instructions
                            </li>
                        </ul>
                        <a href="https://iwebs.in/integrations/" class="btn-primary w-full text-center py-3 rounded-lg font-semibold">
                            Browse Apps →
                        </a>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                    <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-8 text-white">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Contact Support</h3>
                        <p class="text-white/90 mb-4">Get personal help from our team</p>
                        <span class="text-sm bg-white/20 px-3 py-1 rounded-full">24/7 Available</span>
                    </div>
                    <div class="p-8">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Priority support tickets
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Technical assistance
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Account & billing help
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Custom solutions
                            </li>
                        </ul>
                        <a href="https://iwebs.in/contact/" class="btn-primary w-full text-center py-3 rounded-lg font-semibold">
                            Contact Us →
                        </a>
                    </div>
                </div>

                <!-- Status & Updates -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                    <div class="bg-gradient-to-br from-teal-500 to-cyan-600 p-8 text-white">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">System Status</h3>
                        <p class="text-white/90 mb-4">Check platform status & updates</p>
                        <span class="text-sm bg-white/20 px-3 py-1 rounded-full">All Systems ✓</span>
                    </div>
                    <div class="p-8">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Real-time status updates
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Maintenance schedules
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Performance metrics
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Subscribe to updates
                            </li>
                        </ul>
                        <a href="/status" class="btn-primary w-full text-center py-3 rounded-lg font-semibold">
                            View Status →
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

<!-- Popular Topics -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Popular Help Topics</h2>
                <p class="text-xl text-gray-600">Quick answers to the most common questions</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Getting Started -->
                <div class="bg-gray-50 rounded-lg p-6 hover:bg-gray-100 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">🚀 Getting Started</h3>
                    <ul class="space-y-2">
                        <li><a href="https://iwebs.in/guides/getting-started/" class="text-blue-600 hover:text-blue-800">Getting Started Guide</a></li>
                        <li><a href="https://iwebs.in/guides/setup-ecommerce-store/" class="text-blue-600 hover:text-blue-800">How to Setup an eCommerce Store</a></li>
                        <li><a href="https://iwebs.in/guides/creating-products/" class="text-blue-600 hover:text-blue-800">Creating Your First Products</a></li>
                        <li><a href="https://iwebs.in/guides/branding/" class="text-blue-600 hover:text-blue-800">Setting Up Your Branding</a></li>
                    </ul>
                </div>

                <!-- Payments -->
                <div class="bg-gray-50 rounded-lg p-6 hover:bg-gray-100 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">💳 Payments</h3>
                    <ul class="space-y-2">
                        <li><a href="https://iwebs.in/guides/payments/" class="text-blue-600 hover:text-blue-800">Payment Setup Guide</a></li>
                        <li><a href="https://iwebs.in/guides/stripe/" class="text-blue-600 hover:text-blue-800">Stripe Integration</a></li>
                        <li><a href="https://iwebs.in/guides/paypal/" class="text-blue-600 hover:text-blue-800">PayPal Setup</a></li>
                        <li><a href="https://iwebs.in/guides/payment-methods/" class="text-blue-600 hover:text-blue-800">Managing Payment Methods</a></li>
                    </ul>
                </div>

                <!-- Store Management -->
                <div class="bg-gray-50 rounded-lg p-6 hover:bg-gray-100 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">🏪 Store Management</h3>
                    <ul class="space-y-2">
                        <li><a href="https://iwebs.in/guides/store-management/" class="text-blue-600 hover:text-blue-800">Store Management Overview</a></li>
                        <li><a href="https://iwebs.in/guides/inventory-management/" class="text-blue-600 hover:text-blue-800">Managing Your Inventory</a></li>
                        <li><a href="https://iwebs.in/guides/products/" class="text-blue-600 hover:text-blue-800">Product Management</a></li>
                        <li><a href="https://iwebs.in/guides/product-collections/" class="text-blue-600 hover:text-blue-800">Creating Product Collections</a></li>
                    </ul>
                </div>

                <!-- Shipping -->
                <div class="bg-gray-50 rounded-lg p-6 hover:bg-gray-100 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">📦 Shipping & Fulfillment</h3>
                    <ul class="space-y-2">
                        <li><a href="https://iwebs.in/guides/shipping-methods/" class="text-blue-600 hover:text-blue-800">Setting Up Shipping Methods</a></li>
                        <li><a href="https://iwebs.in/guides/creating-shipping-rules/" class="text-blue-600 hover:text-blue-800">Creating Shipping Rules</a></li>
                        <li><a href="https://iwebs.in/guides/myparcel/" class="text-blue-600 hover:text-blue-800">MyParcel Integration</a></li>
                        <li><a href="https://iwebs.in/guides/local-pickup/" class="text-blue-600 hover:text-blue-800">Setting Up Local Pickup</a></li>
                    </ul>
                </div>

                <!-- Marketing & Analytics -->
                <div class="bg-gray-50 rounded-lg p-6 hover:bg-gray-100 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">📈 Marketing & Analytics</h3>
                    <ul class="space-y-2">
                        <li><a href="https://iwebs.in/guides/google-analytics-integration/" class="text-blue-600 hover:text-blue-800">Google Analytics Setup</a></li>
                        <li><a href="https://iwebs.in/guides/meta-pixel-integration/" class="text-blue-600 hover:text-blue-800">Meta Pixel Integration</a></li>
                        <li><a href="https://iwebs.in/guides/google-tag-manager-integration/" class="text-blue-600 hover:text-blue-800">Google Tag Manager</a></li>
                        <li><a href="https://iwebs.in/guides/tiktok-pixel-integration/" class="text-blue-600 hover:text-blue-800">TikTok Pixel Setup</a></li>
                    </ul>
                </div>

                <!-- Account & Billing -->
                <div class="bg-gray-50 rounded-lg p-6 hover:bg-gray-100 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">👤 Account & Billing</h3>
                    <ul class="space-y-2">
                        <li><a href="https://iwebs.in/guides/account-management/" class="text-blue-600 hover:text-blue-800">Account Management</a></li>
                        <li><a href="https://iwebs.in/guides/billing-subscription/" class="text-blue-600 hover:text-blue-800">Billing & Subscriptions</a></li>
                        <li><a href="https://iwebs.in/guides/password-reset-change/" class="text-blue-600 hover:text-blue-800">Password Reset & Change</a></li>
                        <li><a href="https://iwebs.in/guides/canceling-a-subscription-plan/" class="text-blue-600 hover:text-blue-800">Canceling Your Plan</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Community Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                Join Our Community
            </h2>
            <p class="text-xl text-gray-600 mb-8">
                Connect with other merchants, share tips, and get peer support
            </p>
            
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- Community Forum -->
                <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200 hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Community Forum</h3>
                    <p class="text-gray-600 mb-6">Ask questions, share experiences, and learn from thousands of merchants</p>
                    <a href="/community" class="btn-primary px-6 py-2 rounded-lg font-medium">
                        Join Forum
                    </a>
                </div>

                <!-- Discord Community -->
                <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200 hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Discord Server</h3>
                    <p class="text-gray-600 mb-6">Real-time chat with merchants, get quick help, and network with peers</p>
                    <a href="#" class="btn-primary px-6 py-2 rounded-lg font-medium">
                        Join Discord
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any interactive functionality here if needed
    console.log('Help Center page loaded');
});
</script>

<style>
/* Additional Help Center specific styles */
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

/* Hover effects for cards */
.hover\:shadow-lg:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Smooth transitions */
.transition-all {
    transition: all 0.3s ease;
}

.transition-colors {
    transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
}

/* Focus styles for accessibility */
input:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-gradient {
        padding: 60px 0;
    }
    
    .hero-gradient h1 {
        font-size: 2.5rem;
        line-height: 1.2;
    }
}
</style>

<?php get_footer(); ?>
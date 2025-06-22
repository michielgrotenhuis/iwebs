<?php
/**
 * Shared Pricing Features Helper Functions
 * File: inc/pricing-features-helper.php
 * 
 * This file contains shared functions used by both pricing-meta-boxes.php
 * and pricing-comparison-table.php to avoid duplicate declarations.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get feature categories with comprehensive metadata based on the comparison table
 * This is the single source of truth for all pricing feature definitions
 */
if (!function_exists('yoursite_get_comparison_feature_categories')) {
    function yoursite_get_comparison_feature_categories() {
        return array(
            'shopping_experience' => array(
                'title' => __('Shopping Experience', 'yoursite'),
                'description' => __('Create seamless shopping journeys that convert visitors into customers', 'yoursite'),
                'icon' => '🛍️',
                'fields' => array(
                    'adaptive_storefront' => array(
                        'label' => __('Adaptive Storefront Widget', 'yoursite'),
                        'tooltip' => __('Your store looks perfect on every device. Automatically optimized for desktop, tablet, and mobile shoppers with responsive design.', 'yoursite')
                    ),
                    'favorites_wishlist' => array(
                        'label' => __('Favorites/Wishlist', 'yoursite'),
                        'tooltip' => __('Let customers save products for later. Increase sales with wish list reminders and sharing features that drive repeat visits.', 'yoursite')
                    ),
                    'single_product_widgets' => array(
                        'label' => __('Single Product Widgets', 'yoursite'),
                        'tooltip' => __('Embed products anywhere with customizable widgets. Perfect for blogs, landing pages, and social media integration.', 'yoursite')
                    ),
                    'faceted_search' => array(
                        'label' => __('Faceted Search & Product Filters', 'yoursite'),
                        'tooltip' => __('Help customers find exactly what they want with smart filters by keywords, attributes, price range, and category. Reduce bounce rates significantly.', 'yoursite')
                    ),
                    'products_in_cart_marked' => array(
                        'label' => __('Products in Cart Marked in List', 'yoursite'),
                        'tooltip' => __('Smart shopping experience that shows customers which items are already in their cart, making shopping easier and preventing duplicates.', 'yoursite')
                    ),
                    'realtime_shipping' => array(
                        'label' => __('Real-time Shipping Estimates', 'yoursite'),
                        'tooltip' => __('Based on customer IP location, show accurate shipping costs before checkout. Reduces cart abandonment by eliminating surprise fees.', 'yoursite')
                    ),
                    'customer_profiles' => array(
                        'label' => __('Customer Profile or Guest Checkout', 'yoursite'),
                        'tooltip' => __('Configurable options allow customers to create profiles for faster future checkouts or complete purchases as guests without registration.', 'yoursite')
                    ),
                    'address_book' => array(
                        'label' => __('Address Book for Customers', 'yoursite'),
                        'tooltip' => __('Registered customers can save multiple addresses (home, work, gift recipients) for quick and convenient future purchases.', 'yoursite')
                    ),
                    'media_rich_descriptions' => array(
                        'label' => __('Media Rich Category & Product Descriptions', 'yoursite'),
                        'tooltip' => __('Showcase products with high-quality images, videos, and rich text descriptions that help customers make informed buying decisions.', 'yoursite')
                    ),
                    'terms_conditions' => array(
                        'label' => __('Accept Terms and Conditions', 'yoursite'),
                        'tooltip' => __('Legal compliance made easy. Customers must accept your terms and conditions before completing their order, protecting your business.', 'yoursite')
                    ),
                    'product_navigation' => array(
                        'label' => __('Next/Previous Product Navigation', 'yoursite'),
                        'tooltip' => __('Seamless product browsing with intuitive navigation links that keep customers engaged and exploring your catalog longer.', 'yoursite')
                    ),
                    'javascript_api' => array(
                        'label' => __('JavaScript API', 'yoursite'),
                        'tooltip' => __('Advanced customization capabilities for developers. Integrate custom functionality and create unique shopping experiences with our comprehensive API.', 'yoursite')
                    ),
                    'automatic_price_adjustment' => array(
                        'label' => __('Automatic Price Adjustment for Options', 'yoursite'),
                        'tooltip' => __('Dynamic pricing that automatically updates when customers select different product options like size, color, or material. No confusion, no surprises.', 'yoursite')
                    ),
                    'cdn_delivery' => array(
                        'label' => __('Fast Content Delivery with CDN', 'yoursite'),
                        'tooltip' => __('Lightning-fast loading times worldwide. Our global CDN ensures your store loads quickly for customers anywhere, improving SEO and conversions.', 'yoursite')
                    ),
                    'customizable_css' => array(
                        'label' => __('Customizable CSS Design Schemes', 'yoursite'),
                        'tooltip' => __('Make your store uniquely yours. Customize colors, fonts, layouts, and styling to perfectly match your brand without any coding knowledge.', 'yoursite')
                    ),
                )
            ),
            'catalog_management' => array(
                'title' => __('Catalog Management', 'yoursite'),
                'description' => __('Powerful tools to organize and showcase your products effectively', 'yoursite'),
                'icon' => '📦',
                'fields' => array(
                    'storefront_translations' => array(
                        'label' => __('Built-in Storefront Translations', 'yoursite'),
                        'tooltip' => __('Reach global customers with 45 built-in language translations for your storefront. Expand internationally without language barriers.', 'yoursite')
                    ),
                    'backend_translations' => array(
                        'label' => __('Built-in Backend Translations', 'yoursite'),
                        'tooltip' => __('Manage your store in your preferred language. From 1 language on Starter to unlimited on Premium plans.', 'yoursite')
                    ),
                    'inventory_tracking' => array(
                        'label' => __('Inventory Tracking', 'yoursite'),
                        'tooltip' => __('Never oversell again. Real-time inventory updates across all sales channels keep stock levels accurate and prevent disappointed customers.', 'yoursite')
                    ),
                    'product_options' => array(
                        'label' => __('Product Options', 'yoursite'),
                        'tooltip' => __('Versatile product variations with drop-downs, radio buttons, text fields, date pickers, file uploads, and checkboxes for any product type.', 'yoursite')
                    ),
                    'stock_control_combinations' => array(
                        'label' => __('Stock Control for Options & Combinations', 'yoursite'),
                        'tooltip' => __('Advanced inventory management for product variations. Track stock for each size/color combination separately for precise inventory control.', 'yoursite')
                    ),
                    'e_goods' => array(
                        'label' => __('Digital Products (E-goods)', 'yoursite'),
                        'tooltip' => __('Sell digital downloads, courses, software, or services. Automated delivery and secure file hosting included with purchase confirmation.', 'yoursite')
                    ),
                    'e_goods_max_size' => array(
                        'label' => __('E-goods Maximum File Size', 'yoursite'),
                        'tooltip' => __('Upload capacity for digital products: 100MB on Essentials, 1GB on Premium, up to 10GB on Unlimited plans.', 'yoursite')
                    ),
                    'e_goods_protection' => array(
                        'label' => __('E-goods Download Protection', 'yoursite'),
                        'tooltip' => __('Secure digital delivery with download link expiration, download limits, and customer authentication to protect your digital assets.', 'yoursite')
                    ),
                    'customer_file_attachments' => array(
                        'label' => __('Customer File Attachments to Orders', 'yoursite'),
                        'tooltip' => __('Let customers upload files with their orders - perfect for custom printing, personalization, or specification requirements.', 'yoursite')
                    ),
                    'image_gallery' => array(
                        'label' => __('Image Gallery', 'yoursite'),
                        'tooltip' => __('Showcase products with multiple high-quality images. Customers can view products from every angle to make confident purchase decisions.', 'yoursite')
                    ),
                    'wysiwyg_editor' => array(
                        'label' => __('WYSIWYG Editor for Product Descriptions', 'yoursite'),
                        'tooltip' => __('Create rich, formatted product descriptions without HTML knowledge. Add images, videos, tables, and styling with an intuitive editor.', 'yoursite')
                    ),
                    'automatic_thumbnails' => array(
                        'label' => __('Automatic Thumbnail Generation', 'yoursite'),
                        'tooltip' => __('Professional-looking product images automatically optimized and sharpened for fast loading and crisp display across all devices.', 'yoursite')
                    ),
                    'multiple_categories' => array(
                        'label' => __('Product in Multiple Categories', 'yoursite'),
                        'tooltip' => __('Organize products logically by assigning them to multiple categories. A winter coat can be in both "Outerwear" and "Winter Collection" categories.', 'yoursite')
                    ),
                    'product_types_attributes' => array(
                        'label' => __('Product Types and Attributes', 'yoursite'),
                        'tooltip' => __('Advanced product organization with custom types and attributes. Perfect for complex catalogs with technical specifications or detailed characteristics.', 'yoursite')
                    ),
                    'product_filters' => array(
                        'label' => __('Product Filters', 'yoursite'),
                        'tooltip' => __('Help customers find products quickly with configurable filters. Filter by price, brand, color, size, rating, and custom attributes.', 'yoursite')
                    ),
                    'product_dimensions' => array(
                        'label' => __('Product Dimensions', 'yoursite'),
                        'tooltip' => __('Essential for shipping calculations and customer information. Store and display length, width, height, and weight for accurate logistics.', 'yoursite')
                    ),
                    'multi_currency' => array(
                        'label' => __('Multi-Currency Support', 'yoursite'),
                        'tooltip' => __('Sell globally with confidence. Display prices in customers\' local currencies with automatic conversion rates for seamless international sales.', 'yoursite')
                    ),
                )
            ),
            'shipping_tax' => array(
                'title' => __('Shipping and Tax', 'yoursite'),
                'description' => __('Comprehensive shipping and tax management for global sales', 'yoursite'),
                'icon' => '🚚',
                'fields' => array(
                    'delivery_zones' => array(
                        'label' => __('Delivery Zones', 'yoursite'),
                        'tooltip' => __('Unlimited delivery zones let you set different shipping rates and rules for any geographic area, from local neighborhoods to international regions.', 'yoursite')
                    ),
                    'shipping_wizard' => array(
                        'label' => __('Shipping Configuration Wizard', 'yoursite'),
                        'tooltip' => __('Step-by-step setup makes shipping configuration simple. Set up complex shipping rules and rates without technical expertise.', 'yoursite')
                    ),
                    'automatic_tax' => array(
                        'label' => __('Automatic Tax Calculations', 'yoursite'),
                        'tooltip' => __('Automated tax compliance for US, Canada, UK, EU, and Australia. Always accurate rates that update automatically with changing tax laws.', 'yoursite')
                    ),
                    'manual_shipping_tax' => array(
                        'label' => __('Manual Shipping/Tax Configuration', 'yoursite'),
                        'tooltip' => __('Full control over shipping zones, rates, and tax rules. Create custom configurations for unique business requirements and complex scenarios.', 'yoursite')
                    ),
                    'tax_exempt_customers' => array(
                        'label' => __('Tax Exempt Customers', 'yoursite'),
                        'tooltip' => __('Handle wholesale and B2B customers with tax exemption status. Automatically apply tax-free pricing for qualified business customers.', 'yoursite')
                    ),
                    'vat_reverse_charge' => array(
                        'label' => __('VAT Reverse Charge', 'yoursite'),
                        'tooltip' => __('EU B2B compliance made easy. Automatically handle reverse charge VAT for qualifying business-to-business transactions within the EU.', 'yoursite')
                    ),
                    'shipment_tracking' => array(
                        'label' => __('Real-time Shipment Tracking', 'yoursite'),
                        'tooltip' => __('Keep customers informed with live tracking updates. Integration with major carriers provides automatic tracking information and delivery notifications.', 'yoursite')
                    ),
                    'store_pickup' => array(
                        'label' => __('In-Store Order Pickup', 'yoursite'),
                        'tooltip' => __('Offer local customers convenient pickup options. Reduce shipping costs while providing flexible fulfillment for nearby customers.', 'yoursite')
                    ),
                    'handling_fees' => array(
                        'label' => __('Handling Fees', 'yoursite'),
                        'tooltip' => __('Add handling charges for special packaging, insurance, or processing. Flexible fee structure covers additional costs transparently.', 'yoursite')
                    ),
                    'courier_guy' => array(
                        'label' => __('The Courier Guy Shipments', 'yoursite'),
                        'tooltip' => __('Integrated South African shipping solution with real-time rates, tracking, and streamlined fulfillment for local and regional deliveries.', 'yoursite')
                    ),
                    'myparcel_integration' => array(
                        'label' => __('PostNL, DHL, DPD, UPS via Myparcel', 'yoursite'),
                        'tooltip' => __('European shipping made simple. One integration connects you to multiple carriers with competitive rates and unified tracking.', 'yoursite')
                    ),
                )
            ),
            'promotions' => array(
                'title' => __('Promotions', 'yoursite'),
                'description' => __('Powerful marketing tools to drive sales and customer engagement', 'yoursite'),
                'icon' => '🎯',
                'fields' => array(
                    'discount_coupons' => array(
                        'label' => __('Discount Coupons', 'yoursite'),
                        'tooltip' => __('Create flexible discount codes with percentage, fixed amount, or free shipping offers. Set usage limits, expiration dates, and customer restrictions.', 'yoursite')
                    ),
                    'volume_discounts' => array(
                        'label' => __('Volume Discounts & Multi-tier Prices', 'yoursite'),
                        'tooltip' => __('Encourage larger orders with quantity-based pricing. Perfect for wholesale customers or bulk sale incentives with automatic tier calculations.', 'yoursite')
                    ),
                    'promotional_pricing' => array(
                        'label' => __('Sale and Promotional Pricing', 'yoursite'),
                        'tooltip' => __('Run time-limited sales with special pricing. Schedule promotions in advance and automatically revert to regular prices when sales end.', 'yoursite')
                    ),
                    'customer_group_discounts' => array(
                        'label' => __('Discounts for Customer Groups', 'yoursite'),
                        'tooltip' => __('Reward loyalty with group-specific pricing. Create VIP, wholesale, or member pricing tiers that automatically apply to qualified customers.', 'yoursite')
                    ),
                    'facebook_like' => array(
                        'label' => __('Facebook Like Buttons', 'yoursite'),
                        'tooltip' => __('Social media integration that lets customers like your products and pages, expanding your reach through their social networks organically.', 'yoursite')
                    ),
                    'facebook_comments' => array(
                        'label' => __('Facebook Comments', 'yoursite'),
                        'tooltip' => __('Enable social commenting on products using Facebook\'s system. Builds community engagement and provides social proof for your products.', 'yoursite')
                    ),
                    'social_sharing_purchase' => array(
                        'label' => __('Share Purchase on Social Media', 'yoursite'),
                        'tooltip' => __('Let happy customers share their purchases on Facebook and Twitter, creating authentic social proof and driving word-of-mouth marketing.', 'yoursite')
                    ),
                    'social_sharing_product' => array(
                        'label' => __('Share Product on Social Media', 'yoursite'),
                        'tooltip' => __('Enable product sharing on Facebook, Pinterest, and Twitter with optimized images and descriptions for maximum social media impact.', 'yoursite')
                    ),
                    'ask_friends' => array(
                        'label' => __('Ask Friends Feature', 'yoursite'),
                        'tooltip' => __('Social shopping feature that lets customers ask friends for opinions on products, increasing engagement and building purchase confidence.', 'yoursite')
                    ),
                )
            ),
            'marketing_integrations' => array(
                'title' => __('Marketing Integrations', 'yoursite'),
                'description' => __('Connect with essential marketing and analytics platforms', 'yoursite'),
                'icon' => '📈',
                'fields' => array(
                    'google_shopping' => array(
                        'label' => __('Google Shopping Feeds', 'yoursite'),
                        'tooltip' => __('Automatically sync your products to Google Shopping with optimized feeds. Reach customers actively searching for your products on Google.', 'yoursite')
                    ),
                    'google_analytics_remarketing' => array(
                        'label' => __('Remarketing with Google Analytics', 'yoursite'),
                        'tooltip' => __('Track customer behavior and create remarketing campaigns. Re-engage visitors who didn\'t purchase with targeted ads across the Google network.', 'yoursite')
                    ),
                    'onboarding_wizard' => array(
                        'label' => __('Interactive Onboarding Wizard', 'yoursite'),
                        'tooltip' => __('Step-by-step guided setup gets your store running quickly. Interactive tutorials help you configure settings and understand features easily.', 'yoursite')
                    ),
                    'google_tag_manager' => array(
                        'label' => __('Google Tag Manager', 'yoursite'),
                        'tooltip' => __('Powerful tag management for advanced tracking and marketing integrations. Easily add conversion tracking, analytics, and marketing pixels.', 'yoursite')
                    ),
                    'meta_pixel' => array(
                        'label' => __('Meta Pixel (Facebook)', 'yoursite'),
                        'tooltip' => __('Track conversions and optimize Facebook advertising campaigns. Essential for retargeting and measuring Facebook ad performance accurately.', 'yoursite')
                    ),
                    'tiktok_pixel' => array(
                        'label' => __('TikTok Pixel', 'yoursite'),
                        'tooltip' => __('Measure and optimize TikTok advertising campaigns. Track conversions and build custom audiences for this rapidly growing platform.', 'yoursite')
                    ),
                )
            ),
            'orders' => array(
                'title' => __('Orders Management', 'yoursite'),
                'description' => __('Comprehensive order processing and management tools', 'yoursite'),
                'icon' => '📋',
                'fields' => array(
                    'email_notifications' => array(
                        'label' => __('Customizable Email Notifications', 'yoursite'),
                        'tooltip' => __('Professional branded emails for order confirmations, shipping updates, and customer communications. Customize templates to match your brand.', 'yoursite')
                    ),
                    'order_history' => array(
                        'label' => __('Order History', 'yoursite'),
                        'tooltip' => __('Complete order tracking for both customers and administrators. Full visibility into order status, payment history, and shipping information.', 'yoursite')
                    ),
                    'multiple_recipients' => array(
                        'label' => __('Order Email to Multiple Recipients', 'yoursite'),
                        'tooltip' => __('Automatically notify multiple team members about new orders. Keep sales, fulfillment, and management teams informed in real-time.', 'yoursite')
                    ),
                    'edit_create_orders' => array(
                        'label' => __('Edit/Create Orders', 'yoursite'),
                        'tooltip' => __('Full order management flexibility. Create manual orders for phone sales or edit existing orders to accommodate customer changes.', 'yoursite')
                    ),
                    'payment_shipping_status' => array(
                        'label' => __('Track Payment and Shipping Status', 'yoursite'),
                        'tooltip' => __('Real-time order status tracking from payment processing through delivery. Keep customers informed at every step of their order journey.', 'yoursite')
                    ),
                    'customer_ip_tracking' => array(
                        'label' => __('Customer IP in Order Details', 'yoursite'),
                        'tooltip' => __('Fraud prevention and analytics tool that records customer IP addresses with orders for security monitoring and geographic insights.', 'yoursite')
                    ),
                    'ip_country_warning' => array(
                        'label' => __('IP/Billing Country Mismatch Warning', 'yoursite'),
                        'tooltip' => __('Fraud detection alert when customer IP location differs from billing country. Helps identify potentially fraudulent transactions early.', 'yoursite')
                    ),
                    'abandoned_cart_recovery' => array(
                        'label' => __('Automatic Abandoned Cart Recovery', 'yoursite'),
                        'tooltip' => __('Recover up to 30% of lost sales with automated email sequences. Smart timing and personalized messages bring customers back to complete purchases.', 'yoursite')
                    ),
                    'invoice_printing' => array(
                        'label' => __('Invoice Printing', 'yoursite'),
                        'tooltip' => __('Generate professional invoices for orders with your branding and business information. Essential for B2B sales and record keeping.', 'yoursite')
                    ),
                    'bulk_invoice_printing' => array(
                        'label' => __('Bulk Invoice Printing', 'yoursite'),
                        'tooltip' => __('Process multiple invoices simultaneously for efficient batch operations. Save time on administrative tasks with bulk processing capabilities.', 'yoursite')
                    ),
                    'edit_invoice' => array(
                        'label' => __('Edit Invoice', 'yoursite'),
                        'tooltip' => __('Modify invoices after creation to correct errors, add details, or accommodate special customer requirements while maintaining audit trails.', 'yoursite')
                    ),
                    'order_comments' => array(
                        'label' => __('Order Comments Field', 'yoursite'),
                        'tooltip' => __('Let customers add special instructions, delivery notes, or comments during checkout. Improves service quality and customer satisfaction.', 'yoursite')
                    ),
                    'order_amount_limits' => array(
                        'label' => __('Min/Max Order Amount Limits', 'yoursite'),
                        'tooltip' => __('Set minimum order values to ensure profitability or maximum limits for security. Configurable rules help manage business requirements.', 'yoursite')
                    ),
                    'staff_order_notes' => array(
                        'label' => __('Staff Order Notes', 'yoursite'),
                        'tooltip' => __('Internal notes system for staff communication about orders. Track special handling, customer preferences, or processing instructions.', 'yoursite')
                    ),
                    'low_stock_notifications' => array(
                        'label' => __('Low Stock Notifications', 'yoursite'),
                        'tooltip' => __('Automated alerts when inventory levels reach your specified thresholds. Never miss restocking opportunities or disappoint customers.', 'yoursite')
                    ),
                    'order_number_control' => array(
                        'label' => __('Set Next Order Number', 'yoursite'),
                        'tooltip' => __('Customize order numbering sequence for consistency with existing systems or specific business requirements. Maintain professional order tracking.', 'yoursite')
                    ),
                )
            ),
            'data_management' => array(
                'title' => __('Data Management', 'yoursite'),
                'description' => __('Import, export, and manage your business data efficiently', 'yoursite'),
                'icon' => '💾',
                'fields' => array(
                    'csv_export' => array(
                        'label' => __('CSV Export (Orders, Products, Customers)', 'yoursite'),
                        'tooltip' => __('Complete data portability with CSV exports of all your business data. Perfect for accounting, analysis, or migrating to other systems.', 'yoursite')
                    ),
                    'csv_import' => array(
                        'label' => __('CSV Import for Product Data', 'yoursite'),
                        'tooltip' => __('Bulk product upload saves hours of manual entry. Import your entire catalog with images, descriptions, pricing, and inventory data.', 'yoursite')
                    ),
                    'configurable_formats' => array(
                        'label' => __('Configurable Units, Formats & Currency', 'yoursite'),
                        'tooltip' => __('Adapt your store to local preferences with customizable measurement units, date/time formats, and currency symbols for any market.', 'yoursite')
                    ),
                )
            ),
            'seo' => array(
                'title' => __('SEO & Analytics', 'yoursite'),
                'description' => __('Optimize for search engines and track performance', 'yoursite'),
                'icon' => '🔍',
                'fields' => array(
                    'google_indexing' => array(
                        'label' => __('Direct Indexing by Google', 'yoursite'),
                        'tooltip' => __('SEO-optimized structure ensures Google can easily crawl and index your products. Built-in sitemap generation and clean URLs boost rankings.', 'yoursite')
                    ),
                    'seo_fields' => array(
                        'label' => __('SEO Fields for Products', 'yoursite'),
                        'tooltip' => __('Optimize every product page with custom meta titles, descriptions, and keywords. Take control of how your products appear in search results.', 'yoursite')
                    ),
                    'tracking_reporting' => array(
                        'label' => __('Tracking and Reporting', 'yoursite'),
                        'tooltip' => __('Comprehensive analytics dashboard shows sales trends, customer behavior, and performance metrics to drive data-driven business decisions.', 'yoursite')
                    ),
                    'google_analytics' => array(
                        'label' => __('Google Analytics E-commerce Tracking', 'yoursite'),
                        'tooltip' => __('Deep integration with Google Analytics provides detailed e-commerce insights including conversion rates, revenue tracking, and customer journey analysis.', 'yoursite')
                    ),
                    'universal_analytics' => array(
                        'label' => __('Universal Analytics Support', 'yoursite'),
                        'tooltip' => __('Full compatibility with Google\'s analytics platforms for comprehensive tracking of user behavior, conversions, and business performance.', 'yoursite')
                    ),
                    'custom_tracking' => array(
                        'label' => __('Custom Tracking Code on Thank You Page', 'yoursite'),
                        'tooltip' => __('Add conversion tracking for advertising platforms or custom analytics. Essential for measuring ROI from marketing campaigns accurately.', 'yoursite')
                    ),
                )
            ),
            'partner_features' => array(
                'title' => __('Features for Partners', 'yoursite'),
                'description' => __('Tools for agencies and resellers to manage multiple clients', 'yoursite'),
                'icon' => '🤝',
                'fields' => array(
                    'white_label' => array(
                        'label' => __('White Label Option', 'yoursite'),
                        'tooltip' => __('Remove our branding and use your own. Perfect for agencies offering e-commerce solutions under their brand to maintain client relationships.', 'yoursite')
                    ),
                    'provisioning_api' => array(
                        'label' => __('Provisioning API for Partners', 'yoursite'),
                        'tooltip' => __('Automate client onboarding with API integration. Create and manage multiple client stores programmatically for efficient agency operations.', 'yoursite')
                    ),
                    'reseller_panel' => array(
                        'label' => __('Web-based Reseller Panel', 'yoursite'),
                        'tooltip' => __('Comprehensive partner dashboard to manage multiple client accounts, track usage, billing, and provide support from one central location.', 'yoursite')
                    ),
                    'single_sign_on' => array(
                        'label' => __('Single Sign On (SSO)', 'yoursite'),
                        'tooltip' => __('Seamless access across multiple client stores with one login. Simplifies management for agencies handling numerous e-commerce projects.', 'yoursite')
                    ),
                    'embeddable_control_panel' => array(
                        'label' => __('Embeddable Control Panel', 'yoursite'),
                        'tooltip' => __('Integrate store management directly into your existing client portals or dashboards. Maintain brand consistency while providing powerful tools.', 'yoursite')
                    ),
                )
            ),
            'payment_options' => array(
                'title' => __('Payment Options', 'yoursite'),
                'description' => __('Comprehensive payment gateway support for global commerce', 'yoursite'),
                'icon' => '💳',
                'fields' => array(
                    'two_checkout' => array(
                        'label' => __('2Checkout', 'yoursite'),
                        'tooltip' => __('Global payment processing with support for multiple currencies and payment methods. Ideal for international e-commerce businesses.', 'yoursite')
                    ),
                    'cashfree_india' => array(
                        'label' => __('Cash Free (India)', 'yoursite'),
                        'tooltip' => __('Leading Indian payment gateway supporting UPI, wallets, net banking, and cards. Essential for serving the Indian market effectively.', 'yoursite')
                    ),
                    'epoint' => array(
                        'label' => __('Epoint', 'yoursite'),
                        'tooltip' => __('Secure payment processing solution with competitive rates and reliable transaction handling for growing e-commerce businesses.', 'yoursite')
                    ),
                    'first_data' => array(
                        'label' => __('First Data Global Gateway e4', 'yoursite'),
                        'tooltip' => __('Enterprise-grade payment processing from a trusted global provider. Robust security and reliability for high-volume merchants.', 'yoursite')
                    ),
                    'flutterwave' => array(
                        'label' => __('Flutterwave', 'yoursite'),
                        'tooltip' => __('African payment infrastructure supporting mobile money, bank transfers, and cards across multiple African countries and currencies.', 'yoursite')
                    ),
                    'ideal_mollie' => array(
                        'label' => __('iDEAL (via Mollie)', 'yoursite'),
                        'tooltip' => __('Netherlands\' most popular payment method for online banking. Essential for serving Dutch customers effectively and reducing cart abandonment.', 'yoursite')
                    ),
                    'iyzico' => array(
                        'label' => __('Iyzico', 'yoursite'),
                        'tooltip' => __('Turkish payment gateway supporting local payment methods, installments, and marketplace solutions for the Turkish e-commerce market.', 'yoursite')
                    ),
                    'mamo_pay' => array(
                        'label' => __('Mamo Pay', 'yoursite'),
                        'tooltip' => __('Middle East payment solution supporting regional payment preferences and currencies. Perfect for serving MENA markets effectively.', 'yoursite')
                    ),
                    'mercado_pago' => array(
                        'label' => __('Mercado Pago', 'yoursite'),
                        'tooltip' => __('Latin America\'s leading payment platform supporting local payment methods, installments, and currencies across multiple countries.', 'yoursite')
                    ),
                    'mollie_cards' => array(
                        'label' => __('Mollie (Cards & More)', 'yoursite'),
                        'tooltip' => __('European payment specialist supporting Visa, MasterCard, American Express, and 20+ local payment methods across Europe.', 'yoursite')
                    ),
                    'nicky_crypto' => array(
                        'label' => __('Nicky.me (Crypto Payments)', 'yoursite'),
                        'tooltip' => __('Accept Bitcoin, Ethereum, and other cryptocurrencies. Tap into the growing crypto economy with secure blockchain payment processing.', 'yoursite')
                    ),
                    'offline_payments' => array(
                        'label' => __('Offline Payments', 'yoursite'),
                        'tooltip' => __('Accept bank transfers, checks, or cash on delivery. Perfect for B2B customers or markets where traditional payment methods are preferred.', 'yoursite')
                    ),
                    'paypal_suite' => array(
                        'label' => __('PayPal Standard, Express & Pro', 'yoursite'),
                        'tooltip' => __('Complete PayPal integration including Standard, Express Checkout, and Pro options. Accept payments from 200+ countries with buyer protection.', 'yoursite')
                    ),
                    'payriff' => array(
                        'label' => __('Payriff', 'yoursite'),
                        'tooltip' => __('Azerbaijan payment gateway supporting local cards and banking systems. Essential for serving customers in the Caucasus region effectively.', 'yoursite')
                    ),
                    'paystack' => array(
                        'label' => __('Paystack', 'yoursite'),
                        'tooltip' => __('African payment infrastructure supporting cards, bank transfers, and mobile money across Nigeria, Ghana, South Africa, and Kenya.', 'yoursite')
                    ),
                    'payu_biz' => array(
                        'label' => __('PayU Biz: India', 'yoursite'),
                        'tooltip' => __('Comprehensive Indian payment solution supporting cards, net banking, UPI, and wallets. Optimized for Indian market preferences and regulations.', 'yoursite')
                    ),
                    'payu_money' => array(
                        'label' => __('PayU Money: India', 'yoursite'),
                        'tooltip' => __('Popular Indian payment gateway with extensive local payment method support. Trusted by millions of Indian consumers for online transactions.', 'yoursite')
                    ),
                    'razorpay' => array(
                        'label' => __('RazorPay', 'yoursite'),
                        'tooltip' => __('Leading Indian fintech supporting 100+ payment methods including UPI, cards, net banking, and wallets. Real-time settlements available.', 'yoursite')
                    ),
                    'stripe' => array(
                        'label' => __('Stripe (Credit Cards)', 'yoursite'),
                        'tooltip' => __('Global payment leader with superior developer experience. Accept cards worldwide with advanced fraud protection and instant settlements.', 'yoursite')
                    ),
                    'vipps_norway' => array(
                        'label' => __('Vipps (Norwegian Mobile Payments)', 'yoursite'),
                        'tooltip' => __('Norway\'s most popular mobile payment app used by 90% of the population. Essential for serving Norwegian customers effectively.', 'yoursite')
                    ),
                    'yoco_south_africa' => array(
                        'label' => __('Yoco (South Africa Payment Gateway)', 'yoursite'),
                        'tooltip' => __('South African payment specialist supporting local cards and banking preferences. Optimized for the South African e-commerce market.', 'yoursite')
                    ),
                )
            )
        );
    }
}
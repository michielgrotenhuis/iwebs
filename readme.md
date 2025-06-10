# YourSite.biz - SaaS Store Builder WordPress Theme

A modern, professional WordPress theme designed for SaaS eCommerce platform businesses, inspired by Shopify's clean and conversion-focused design.

## 🚀 Features

### Design & Layout
- **Shopify-inspired design** - Clean, modern, and conversion-focused
- **Fully responsive** - Looks great on all devices
- **Tailwind CSS** - Utility-first CSS framework for rapid development
- **Premium animations** - Smooth transitions and hover effects
- **Dark/light mode ready** - Easy to customize color schemes

### SaaS-Focused Components
- **Hero section** with customizable CTAs
- **Pricing tables** with toggle between monthly/yearly
- **Feature showcase** with custom post types
- **Customer testimonials** carousel
- **Social proof** sections
- **Newsletter signup** forms
- **FAQ sections** with accordion functionality

### WordPress Integration
- **Custom post types** for Features, Testimonials, and Pricing Plans
- **Theme customizer** integration for easy content management
- **Widget areas** for flexible content placement
- **SEO optimized** with proper heading structure
- **Accessibility ready** with proper ARIA labels

### Performance & UX
- **Fast loading** with optimized assets
- **Mobile-first** responsive design
- **Smooth scrolling** navigation
- **Lazy loading** for images
- **Interactive elements** with JavaScript enhancements

## 📁 File Structure

```
yoursite-theme/
├── style.css              # Main stylesheet with Tailwind imports
├── functions.php          # Theme functionality and customization
├── index.php             # Homepage template
├── header.php            # Site header with navigation
├── footer.php            # Site footer with links and widgets
├── single.php            # Single post template
├── page-pricing.php      # Custom pricing page template
├── js/
│   └── main.js           # JavaScript functionality
└── README.md             # This file
```

## 🛠️ Installation

1. **Download the theme files** and upload to your WordPress `wp-content/themes/` directory
2. **Activate the theme** in WordPress Admin → Appearance → Themes
3. **Install recommended plugins** (if any)
4. **Customize your site** using the WordPress Customizer

## ⚙️ Configuration

### Theme Customizer Options

Navigate to **Appearance → Customize** to configure:

- **Hero Section**
  - Hero title and subtitle
  - Primary and secondary CTA buttons
  - Button URLs and text

- **Site Identity**
  - Logo upload
  - Site title and tagline
  - Favicon

### Custom Post Types

The theme includes three custom post types:

#### 1. Features (`/wp-admin/edit.php?post_type=features`)
- Add your product features
- Include feature images and descriptions
- Automatically displayed on homepage

#### 2. Testimonials (`/wp-admin/edit.php?post_type=testimonials`)
- Customer testimonials and reviews
- Include customer photos and company info
- Star ratings and quotes

#### 3. Pricing Plans (`/wp-admin/edit.php?post_type=pricing`)
- Create your pricing tiers
- Set prices for monthly/yearly billing
- List features for each plan
- Mark featured/popular plans

### Navigation Menus

Set up your menus in **Appearance → Menus**:

- **Primary Menu** - Main site navigation
- **Footer Menu** - Footer links (Privacy, Terms, etc.)

### Widget Areas

- **Footer Widget Area** - Add widgets to the footer section

## 🎨 Customization

### Colors and Branding

The theme uses CSS custom properties for easy color customization. You can modify colors in the `style.css` file:

```css
:root {
  --primary-color: #667eea;
  --secondary-color: #764ba2;
  --text-color: #374151;
  --background-color: #ffffff;
}
```

### Adding Custom CSS

Add custom styles through **Appearance → Customize → Additional CSS** or by editing the `style.css` file.

### JavaScript Customization

Modify the `js/main.js` file to add custom JavaScript functionality.

## 📄 Page Templates

### Homepage (index.php)
- Hero section with CTAs
- Social proof logos
- Key benefits grid
- Features showcase
- Pricing preview
- Customer testimonials
- Final CTA section

### Pricing Page (page-pricing.php)
- Full pricing comparison table
- Monthly/yearly toggle
- Featured plan highlighting
- FAQ section
- Contact sales CTA

### Single Post (single.php)
- Article content with typography
- Author bio section
- Related posts
- Social sharing buttons
- Comments section

## 🔧 Required Plugins

While the theme works independently, these plugins enhance functionality:

- **Contact Form 7** - For contact forms
- **Yoast SEO** - For SEO optimization
- **WP Rocket** - For caching and performance

## 📱 Responsive Breakpoints

The theme follows standard Tailwind CSS breakpoints:

- `sm: 640px` - Small devices
- `md: 768px` - Medium devices  
- `lg: 1024px` - Large devices
- `xl: 1280px` - Extra large devices

## 🌐 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- IE 11+ (limited support)

## 📞 Support

For theme support and customization:

1. Check the documentation first
2. Search existing support topics
3. Create a new support ticket with:
   - WordPress version
   - Theme version
   - Description of the issue
   - Screenshots if applicable

## 🔄 Updates

### Version 1.0.0
- Initial release
- Shopify-inspired design
- SaaS-focused components
- Full Tailwind CSS integration
- Custom post types for content management

## 📄 License

This theme is licensed under the GPL v2 or later.

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 🙏 Credits

- **Tailwind CSS** - Utility-first CSS framework
- **Heroicons** - Beautiful hand-crafted SVG icons
- **Google Fonts** - Inter font family
- **WordPress** - Content management system

---

**Happy building! 🚀**

Transform your SaaS idea into a professional online presence with this conversion-optimized WordPress theme.
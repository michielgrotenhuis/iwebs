// Enhanced JavaScript for Comparison Table
document.addEventListener('DOMContentLoaded', function() {
    // Billing toggle functionality with annual as default
    const comparisonToggle = document.getElementById('comparison-billing-toggle');
    const comparisonWrapper = document.querySelector('.pricing-comparison-wrapper');
    
    if (comparisonToggle && comparisonWrapper) {
        // Set initial state to annual (checked)
        comparisonWrapper.classList.add('comparison-yearly-active');
        
        comparisonToggle.addEventListener('change', function() {
            if (this.checked) {
                comparisonWrapper.classList.add('comparison-yearly-active');
            } else {
                comparisonWrapper.classList.remove('comparison-yearly-active');
            }
        });
    }
    
    // Feature tooltip functionality
    const tooltip = document.getElementById('feature-tooltip');
    const tooltipText = tooltip ? tooltip.querySelector('.tooltip-text') : null;
    let currentLabel = null;
    
    // Show tooltip on hover
    document.querySelectorAll('.feature-label').forEach(label => {
        label.addEventListener('mouseenter', function(e) {
            if (!tooltip || !tooltipText) return;
            
            const tooltipContent = this.getAttribute('data-tooltip');
            if (!tooltipContent) return;
            
            currentLabel = this;
            tooltipText.textContent = tooltipContent;
            
            // Position tooltip
            const rect = this.getBoundingClientRect();
            const tooltipWidth = 300;
            let left = rect.left + rect.width + 10;
            let top = rect.top + (rect.height / 2);
            
            // Adjust if tooltip would go off screen
            if (left + tooltipWidth > window.innerWidth) {
                left = rect.left - tooltipWidth - 10;
            }
            
            // Keep tooltip on screen vertically
            if (top + 100 > window.innerHeight) {
                top = window.innerHeight - 120;
            }
            
            tooltip.style.left = left + 'px';
            tooltip.style.top = top + 'px';
            tooltip.classList.remove('hidden');
            
            setTimeout(() => {
                tooltip.classList.add('show');
            }, 10);
        });
        
        label.addEventListener('mouseleave', function() {
            if (!tooltip) return;
            
            tooltip.classList.remove('show');
            setTimeout(() => {
                if (!tooltip.classList.contains('show')) {
                    tooltip.classList.add('hidden');
                }
            }, 200);
        });
    });
    
    // Mobile touch support for tooltips
    if ('ontouchstart' in window) {
        document.querySelectorAll('.feature-label').forEach(label => {
            label.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (!tooltip || !tooltipText) return;
                
                const tooltipContent = this.getAttribute('data-tooltip');
                if (!tooltipContent) return;
                
                // Close other tooltips
                if (currentLabel && currentLabel !== this) {
                    tooltip.classList.add('hidden');
                }
                
                if (tooltip.classList.contains('hidden') || currentLabel !== this) {
                    // Show tooltip
                    currentLabel = this;
                    tooltipText.textContent = tooltipContent;
                    
                    const rect = this.getBoundingClientRect();
                    tooltip.style.left = '50%';
                    tooltip.style.transform = 'translateX(-50%)';
                    tooltip.style.top = (rect.bottom + 10) + 'px';
                    
                    tooltip.classList.remove('hidden');
                    setTimeout(() => {
                        tooltip.classList.add('show');
                    }, 10);
                } else {
                    // Hide tooltip
                    tooltip.classList.remove('show');
                    setTimeout(() => {
                        tooltip.classList.add('hidden');
                    }, 200);
                    currentLabel = null;
                }
            });
        });
        
        // Close tooltip when clicking elsewhere
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.feature-label') && !e.target.closest('.feature-tooltip')) {
                if (tooltip) {
                    tooltip.classList.remove('show');
                    setTimeout(() => {
                        tooltip.classList.add('hidden');
                    }, 200);
                    currentLabel = null;
                }
            }
        });
    }
    
    // Sync with main pricing toggle if exists
    const mainPricingToggle = document.getElementById('billing-toggle');
    if (mainPricingToggle && comparisonToggle) {
        // Set main toggle to annual too
        mainPricingToggle.checked = true;
        const pricingPage = document.querySelector('.pricing-page');
        if (pricingPage) {
            pricingPage.classList.add('yearly-active');
        }
        
        mainPricingToggle.addEventListener('change', function() {
            comparisonToggle.checked = this.checked;
            if (this.checked) {
                comparisonWrapper.classList.add('comparison-yearly-active');
            } else {
                comparisonWrapper.classList.remove('comparison-yearly-active');
            }
        });
        
        comparisonToggle.addEventListener('change', function() {
            mainPricingToggle.checked = this.checked;
            const pricingPage = document.querySelector('.pricing-page');
            if (pricingPage) {
                if (this.checked) {
                    pricingPage.classList.add('yearly-active');
                } else {
                    pricingPage.classList.remove('yearly-active');
                }
            }
        });
    }
    
    // Smooth scroll to comparison table
    document.querySelectorAll('[data-scroll-to-comparison]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const comparisonTable = document.querySelector('.pricing-comparison-wrapper');
            if (comparisonTable) {
                comparisonTable.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                    inline: 'nearest'
                });
            }
        });
    });
});


// Main JavaScript file for YourSite.biz theme
// Enhanced with better error handling, performance, and maintainability

class SiteManager {
    constructor() {
        this.config = {
            animationDelay: 5000,
            formMessageTimeout: 5000,
            observerThreshold: 0.1,
            scrollOffset: 20
        };
        
        this.observers = [];
        this.eventListeners = [];
        
        this.init();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initializeComponents());
        } else {
            this.initializeComponents();
        }
    }

    initializeComponents() {
        try {
            this.initMobileMenu();
            this.initSmoothScrolling();
            this.initScrollAnimations();
            this.initFormHandling();
            this.initLazyLoading();
            this.initPricingInteractions();
            this.initTestimonialCarousel();
            this.injectStyles();
        } catch (error) {
            console.error('Error initializing components:', error);
        }
    }

    /**
     * Initialize mobile menu functionality with accessibility features
     */
    initMobileMenu() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (!mobileMenuButton || !mobileMenu) return;

        const toggleMenu = () => {
            const isHidden = mobileMenu.classList.toggle('hidden');
            const isExpanded = !isHidden;
            
            // Update ARIA attributes for accessibility
            mobileMenuButton.setAttribute('aria-expanded', isExpanded);
            mobileMenu.setAttribute('aria-hidden', isHidden);
            
            // Toggle hamburger icon
            this.updateMenuIcon(mobileMenuButton, isExpanded);
        };

        const closeMenu = () => {
            mobileMenu.classList.add('hidden');
            mobileMenuButton.setAttribute('aria-expanded', 'false');
            mobileMenu.setAttribute('aria-hidden', 'true');
            this.updateMenuIcon(mobileMenuButton, false);
        };

        // Event listeners
        this.addEventListener(mobileMenuButton, 'click', toggleMenu);
        
        this.addEventListener(document, 'click', (event) => {
            if (!mobileMenu.contains(event.target) && 
                !mobileMenuButton.contains(event.target) && 
                !mobileMenu.classList.contains('hidden')) {
                closeMenu();
            }
        });
        
        this.addEventListener(document, 'keydown', (event) => {
            if (event.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                closeMenu();
                mobileMenuButton.focus(); // Return focus for accessibility
            }
        });
    }

    updateMenuIcon(button, isExpanded) {
        const icon = button.querySelector('svg');
        if (!icon) return;
        
        const hamburgerPath = 'M4 6h16M4 12h16M4 18h16';
        const closePath = 'M6 18L18 6M6 6l12 12';
        
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${isExpanded ? closePath : hamburgerPath}"></path>`;
    }

/**
 * Initialize smooth scrolling for anchor links
 */
initSmoothScrolling() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');

    anchorLinks.forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const href = anchor.getAttribute('href');
            const target = document.querySelector(href);

            if (!target) return;

            e.preventDefault();

            const header = document.querySelector('header');
            const headerHeight = header ? header.offsetHeight : 0;
            const scrollOffset = this.config?.scrollOffset || 0;
            const targetPosition = target.offsetTop - headerHeight - scrollOffset;

            window.scrollTo({
                top: Math.max(0, targetPosition),
                behavior: 'smooth'
            });
        });
    });
}


    /**
     * Initialize scroll animations using Intersection Observer
     */
    initScrollAnimations() {
        const observerOptions = {
            threshold: this.config.observerThreshold,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    element.classList.add('fade-in-up');
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                    observer.unobserve(element); // Stop observing once animated
                }
            });
        }, observerOptions);
        
        this.observers.push(observer);
        
        // Observe elements for animation
        const animateElements = document.querySelectorAll('.feature-card, .hero-gradient > div, .fade-in-up');
        animateElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            observer.observe(el);
        });
    }

    /**
     * Initialize form handling with better error management
     */
    initFormHandling() {
        // Newsletter signup forms
        const newsletterForms = document.querySelectorAll('form[action*="newsletter"], form[action*="subscribe"]');
        newsletterForms.forEach(form => this.setupNewsletterForm(form));
        
        // Contact forms
        const contactForms = document.querySelectorAll('form[action*="contact"]');
        contactForms.forEach(form => this.setupContactForm(form));
    }

    setupNewsletterForm(form) {
        this.addEventListener(form, 'submit', async (e) => {
            e.preventDefault();
            
            const emailInput = form.querySelector('input[type="email"]');
            const button = form.querySelector('button[type="submit"]');
            
            if (!emailInput || !button) return;
            
            const email = emailInput.value.trim();
            const originalText = button.textContent;
            
            if (!this.isValidEmail(email)) {
                this.showFormMessage(form, 'Please enter a valid email address.', 'error');
                return;
            }
            
            try {
                this.setButtonLoading(button, 'Subscribing...');
                
                // Simulate API call (replace with actual implementation)
                await this.delay(1500);
                
                this.showFormMessage(form, 'Thank you for subscribing!', 'success');
                form.reset();
            } catch (error) {
                this.showFormMessage(form, 'Something went wrong. Please try again.', 'error');
            } finally {
                this.resetButton(button, originalText);
            }
        });
    }

    setupContactForm(form) {
        this.addEventListener(form, 'submit', async (e) => {
            e.preventDefault();
            
            const button = form.querySelector('button[type="submit"]');
            if (!button) return;
            
            const originalText = button.textContent;
            
            try {
                this.setButtonLoading(button, 'Sending...');
                
                // Simulate API call (replace with actual implementation)
                await this.delay(2000);
                
                this.showFormMessage(form, 'Message sent successfully! We\'ll get back to you soon.', 'success');
                form.reset();
            } catch (error) {
                this.showFormMessage(form, 'Failed to send message. Please try again.', 'error');
            } finally {
                this.resetButton(button, originalText);
            }
        });
    }

    setButtonLoading(button, text) {
        button.textContent = text;
        button.disabled = true;
        button.classList.add('loading');
    }

    resetButton(button, originalText) {
        button.textContent = originalText;
        button.disabled = false;
        button.classList.remove('loading');
    }

    /**
     * Show form message with auto-removal
     */
    showFormMessage(form, message, type) {
        // Remove existing message
        const existingMessage = form.querySelector('.form-message');
        if (existingMessage) {
            existingMessage.remove();
        }
        
        // Create new message
        const messageDiv = document.createElement('div');
        messageDiv.className = `form-message mt-4 p-3 rounded-lg text-sm ${
            type === 'error' 
                ? 'bg-red-100 text-red-700 border border-red-200' 
                : 'bg-green-100 text-green-700 border border-green-200'
        }`;
        messageDiv.textContent = message;
        messageDiv.setAttribute('role', type === 'error' ? 'alert' : 'status');
        
        form.appendChild(messageDiv);
        
        // Auto-remove message
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, this.config.formMessageTimeout);
    }

    /**
     * Validate email address
     */
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Initialize lazy loading for images
     */
    initLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');
        if (images.length === 0) return;
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.addEventListener('load', () => {
                            img.classList.add('loaded');
                        });
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            this.observers.push(imageObserver);
            images.forEach(img => imageObserver.observe(img));
        } else {
            // Fallback for browsers without Intersection Observer
            images.forEach(img => {
                img.src = img.dataset.src;
                img.classList.remove('lazy');
            });
        }
    }

    /**
     * Initialize pricing interactions
     */
    initPricingInteractions() {
        const pricingCards = document.querySelectorAll('.pricing-card, .feature-card');
        
        pricingCards.forEach(card => {
            this.addEventListener(card, 'mouseenter', () => {
                card.style.transform = 'translateY(-8px)';
                card.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.15)';
            });
            
            this.addEventListener(card, 'mouseleave', () => {
                if (!card.classList.contains('scale-105')) {
                    card.style.transform = 'translateY(0)';
                    card.style.boxShadow = '';
                }
            });
        });
        
        // CTA button interactions
        const ctaButtons = document.querySelectorAll('.btn-primary, .btn-secondary');
        ctaButtons.forEach(button => {
            this.addEventListener(button, 'click', (e) => this.createRippleEffect(e, button));
        });
    }

    createRippleEffect(event, button) {
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        Object.assign(ripple.style, {
            width: size + 'px',
            height: size + 'px',
            left: x + 'px',
            top: y + 'px'
        });
        
        ripple.classList.add('ripple');
        button.appendChild(ripple);
        
        setTimeout(() => {
            if (ripple.parentNode) {
                ripple.remove();
            }
        }, 600);
    }

    /**
     * Initialize testimonial carousel
     */
    initTestimonialCarousel() {
        const testimonialContainer = document.querySelector('.testimonial-carousel');
        if (!testimonialContainer) return;
        
        const testimonials = testimonialContainer.querySelectorAll('.testimonial-item');
        if (testimonials.length <= 1) return;
        
        let currentIndex = 0;
        let carouselInterval;
        
        const showTestimonial = (index) => {
            testimonials.forEach((testimonial, i) => {
                testimonial.style.display = i === index ? 'block' : 'none';
                testimonial.setAttribute('aria-hidden', i !== index);
            });
        };
        
        const nextTestimonial = () => {
            currentIndex = (currentIndex + 1) % testimonials.length;
            showTestimonial(currentIndex);
        };
        
        const startCarousel = () => {
            carouselInterval = setInterval(nextTestimonial, this.config.animationDelay);
        };
        
        const stopCarousel = () => {
            if (carouselInterval) {
                clearInterval(carouselInterval);
                carouselInterval = null;
            }
        };
        
        // Initialize carousel
        showTestimonial(0);
        startCarousel();
        
        // Pause on hover
        this.addEventListener(testimonialContainer, 'mouseenter', stopCarousel);
        this.addEventListener(testimonialContainer, 'mouseleave', startCarousel);
        
        // Store interval for cleanup
        this.carouselInterval = carouselInterval;
    }

    /**
     * Utility method for adding event listeners with cleanup tracking
     */
    addEventListener(element, event, handler) {
        element.addEventListener(event, handler);
        this.eventListeners.push({ element, event, handler });
    }

    /**
     * Promise-based delay utility
     */
    delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    /**
     * Inject required CSS styles
     */
    injectStyles() {
        const styles = `
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                pointer-events: none;
            }

            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }

            .btn-primary.loading,
            .btn-secondary.loading {
                opacity: 0.7;
                cursor: not-allowed;
            }

            img.lazy {
                opacity: 0;
                transition: opacity 0.3s;
            }

            img.loaded {
                opacity: 1;
            }

            .fade-in-up {
                animation: fadeInUp 0.6s ease-out;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        
        const styleSheet = document.createElement('style');
        styleSheet.textContent = styles;
        document.head.appendChild(styleSheet);
    }

    /**
     * Cleanup method for removing event listeners and observers
     */
    cleanup() {
        // Remove event listeners
        this.eventListeners.forEach(({ element, event, handler }) => {
            element.removeEventListener(event, handler);
        });
        this.eventListeners = [];
        
        // Disconnect observers
        this.observers.forEach(observer => observer.disconnect());
        this.observers = [];
        
        // Clear carousel interval
        if (this.carouselInterval) {
            clearInterval(this.carouselInterval);
        }
    }
}

// Initialize the site manager
const siteManager = new SiteManager();

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    siteManager.cleanup();
});

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = SiteManager;
}
/**
 * Dark Mode Global Handler
 * Ensures proper text contrast and handles dynamic content
 */

class DarkModeHandler {
    constructor() {
        this.init();
    }

    init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    setup() {
        // Initialize dark mode state
        this.initializeDarkMode();
        
        // Fix any remaining contrast issues
        this.fixContrastIssues();
        
        // Set up observers for dynamic content
        this.setupObservers();
        
        // Handle theme switching
        this.setupThemeToggle();
        
        // Fix on window resize (for responsive elements)
        window.addEventListener('resize', () => this.fixContrastIssues());
    }

    initializeDarkMode() {
        // Check if dark mode is enabled (adjust based on your theme's implementation)
        const isDarkMode = document.body.classList.contains('dark-mode') || 
                          localStorage.getItem('darkMode') === 'enabled' ||
                          this.detectSystemDarkMode();

        if (isDarkMode && !document.body.classList.contains('dark-mode')) {
            document.body.classList.add('dark-mode');
        }
    }

    detectSystemDarkMode() {
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    fixContrastIssues() {
        if (!document.body.classList.contains('dark-mode')) return;

        // Fix common contrast problems
        this.fixLightTextOnLightBackground();
        this.fixDarkTextOnDarkBackground();
        this.fixGradientTextContrast();
        this.fixCardContrast();
        this.fixButtonContrast();
    }

    fixLightTextOnLightBackground() {
        // Find elements with light text on light backgrounds
        const lightTextElements = document.querySelectorAll(`
            .text-white,
            .text-gray-100,
            .text-gray-200,
            .text-gray-300
        `);

        lightTextElements.forEach(element => {
            const bgColor = window.getComputedStyle(element).backgroundColor;
            const parentBgColor = window.getComputedStyle(element.parentElement).backgroundColor;
            
            // Check if background is light
            if (this.isLightBackground(bgColor) || this.isLightBackground(parentBgColor)) {
                // Skip if it's in a hero/gradient section where white text is intended
                if (!element.closest('.hero-gradient, .templates-cta-section, .bg-gradient-to-r, .bg-gradient-to-br')) {
                    element.style.color = 'var(--text-primary)';
                }
            }
        });
    }

    fixDarkTextOnDarkBackground() {
        // Find elements with dark text on dark backgrounds
        const darkTextSelectors = [
            '.text-gray-900',
            '.text-gray-800',
            '.text-gray-700',
            '.text-black'
        ];

        darkTextSelectors.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                const bgColor = window.getComputedStyle(element).backgroundColor;
                const parentBgColor = window.getComputedStyle(element.parentElement).backgroundColor;
                
                if (this.isDarkBackground(bgColor) || this.isDarkBackground(parentBgColor)) {
                    element.style.color = 'var(--text-primary)';
                }
            });
        });
    }

    fixGradientTextContrast() {
        // Ensure text in gradient sections is always white
        const gradientSections = document.querySelectorAll(`
            .hero-gradient,
            .templates-cta-section,
            .bg-gradient-to-r,
            .bg-gradient-to-br,
            .bg-gradient-to-l,
            .bg-gradient-to-t,
            .bg-gradient-to-b
        `);

        gradientSections.forEach(section => {
            const textElements = section.querySelectorAll('h1, h2, h3, h4, h5, h6, p, span, div');
            textElements.forEach(element => {
                // Only apply if it doesn't already have important styles
                if (!element.style.color || element.style.color === 'inherit') {
                    element.style.color = 'white';
                }
            });
        });
    }

    fixCardContrast() {
        // Fix card elements
        const cardSelectors = [
            '.feature-card',
            '.pricing-card',
            '.webinar-card',
            '.template-card',
            '.templates-card',
            '.bg-white',
            '.card'
        ];

        cardSelectors.forEach(selector => {
            const cards = document.querySelectorAll(selector);
            cards.forEach(card => {
                // Ensure card background is correct
                if (!card.style.backgroundColor) {
                    card.style.backgroundColor = 'var(--card-bg)';
                }
                
                // Fix text in cards
                const headings = card.querySelectorAll('h1, h2, h3, h4, h5, h6');
                headings.forEach(heading => {
                    if (!heading.closest('.hero-gradient, .templates-cta-section')) {
                        heading.style.color = 'var(--text-primary)';
                    }
                });
                
                const paragraphs = card.querySelectorAll('p');
                paragraphs.forEach(p => {
                    if (!p.closest('.hero-gradient, .templates-cta-section')) {
                        p.style.color = 'var(--text-secondary)';
                    }
                });
            });
        });
    }

    fixButtonContrast() {
        // Fix button text contrast
        const buttons = document.querySelectorAll(`
            .btn-primary,
            .btn-secondary,
            .template-filter-btn,
            .webinar-filter,
            button
        `);

        buttons.forEach(button => {
            if (button.classList.contains('btn-primary')) {
                // Primary buttons should have white text
                button.style.color = 'white';
            } else if (button.classList.contains('btn-secondary')) {
                // Secondary buttons should adapt to theme
                button.style.color = 'var(--text-primary)';
                button.style.borderColor = 'var(--border-color)';
            }
        });
    }

    isLightBackground(color) {
        if (!color || color === 'transparent' || color === 'rgba(0, 0, 0, 0)') return false;
        
        // Convert color to RGB and calculate luminance
        const rgb = this.getRGBValues(color);
        if (!rgb) return false;
        
        const luminance = (0.299 * rgb.r + 0.587 * rgb.g + 0.114 * rgb.b) / 255;
        return luminance > 0.5; // Light background if luminance > 50%
    }

    isDarkBackground(color) {
        if (!color || color === 'transparent' || color === 'rgba(0, 0, 0, 0)') return false;
        
        const rgb = this.getRGBValues(color);
        if (!rgb) return false;
        
        const luminance = (0.299 * rgb.r + 0.587 * rgb.g + 0.114 * rgb.b) / 255;
        return luminance < 0.3; // Dark background if luminance < 30%
    }

    getRGBValues(color) {
        if (!color) return null;
        
        // Handle rgb() format
        const rgbMatch = color.match(/rgb\((\d+),\s*(\d+),\s*(\d+)\)/);
        if (rgbMatch) {
            return {
                r: parseInt(rgbMatch[1]),
                g: parseInt(rgbMatch[2]),
                b: parseInt(rgbMatch[3])
            };
        }
        
        // Handle rgba() format
        const rgbaMatch = color.match(/rgba\((\d+),\s*(\d+),\s*(\d+),\s*[\d.]+\)/);
        if (rgbaMatch) {
            return {
                r: parseInt(rgbaMatch[1]),
                g: parseInt(rgbaMatch[2]),
                b: parseInt(rgbaMatch[3])
            };
        }
        
        return null;
    }

    setupObservers() {
        // Observe for dynamically added content
        const observer = new MutationObserver((mutations) => {
            let shouldFix = false;
            
            mutations.forEach(mutation => {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    shouldFix = true;
                }
                
                if (mutation.type === 'attributes' && 
                    (mutation.attributeName === 'class' || mutation.attributeName === 'style')) {
                    shouldFix = true;
                }
            });
            
            if (shouldFix) {
                // Debounce the fix to avoid too many calls
                clearTimeout(this.fixTimeout);
                this.fixTimeout = setTimeout(() => this.fixContrastIssues(), 100);
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['class', 'style']
        });
    }

    setupThemeToggle() {
        // Listen for theme changes
        const themeToggle = document.querySelector('.theme-toggle, .dark-mode-toggle, [data-theme-toggle]');
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                // Wait for theme to be applied
                setTimeout(() => this.fixContrastIssues(), 100);
            });
        }

        // Listen for system theme changes
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                // Wait a bit for any theme switching logic to complete
                setTimeout(() => this.fixContrastIssues(), 200);
            });
        }

        // Listen for class changes on body
        const bodyObserver = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const target = mutation.target;
                    if (target.classList.contains('dark-mode') !== this.wasDarkMode) {
                        this.wasDarkMode = target.classList.contains('dark-mode');
                        setTimeout(() => this.fixContrastIssues(), 50);
                    }
                }
            });
        });

        bodyObserver.observe(document.body, {
            attributes: true,
            attributeFilter: ['class']
        });

        this.wasDarkMode = document.body.classList.contains('dark-mode');
    }

    // Utility method to force refresh of styles
    refreshStyles() {
        // Force a repaint
        document.body.style.display = 'none';
        document.body.offsetHeight; // Trigger reflow
        document.body.style.display = '';
        
        // Re-apply fixes
        this.fixContrastIssues();
    }

    // Public method to manually trigger fixes
    static fix() {
        if (window.darkModeHandler) {
            window.darkModeHandler.fixContrastIssues();
        }
    }
}

// Initialize the dark mode handler
window.darkModeHandler = new DarkModeHandler();

// Also expose the fix method globally for manual calls
window.fixDarkModeContrast = () => DarkModeHandler.fix();

// Additional utility for WordPress/theme developers
window.addEventListener('load', () => {
    // Final check after everything has loaded
    setTimeout(() => {
        if (window.darkModeHandler) {
            window.darkModeHandler.fixContrastIssues();
        }
    }, 500);
});

// Debug helper (remove in production)
window.debugDarkMode = () => {
    if (!document.body.classList.contains('dark-mode')) {
        console.log('Dark mode is not enabled');
        return;
    }
    
    const lightTextOnLightBg = [];
    const darkTextOnDarkBg = [];
    
    document.querySelectorAll('*').forEach(el => {
        const style = window.getComputedStyle(el);
        const color = style.color;
        const bgColor = style.backgroundColor;
        
        if (color && bgColor && bgColor !== 'rgba(0, 0, 0, 0)') {
            // Simple check for contrast issues
            if (color.includes('255') && bgColor.includes('255')) {
                lightTextOnLightBg.push(el);
            }
            if (color.includes('0') && bgColor.includes('0')) {
                darkTextOnDarkBg.push(el);
            }
        }
    });
    
    console.log('Potential light text on light background:', lightTextOnLightBg);
    console.log('Potential dark text on dark background:', darkTextOnDarkBg);
};
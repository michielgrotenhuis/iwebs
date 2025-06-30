<?php
/**
 * Enhanced Currency Display Functions
 * File: inc/currency/currency-display.php
 * 
 * Complete file with PHP 7.0+ compatibility and enhanced functionality
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enhanced Currency Selector Component - Matching Language Selector Styling
 * Render currency selector with consistent styling and multiple display options
 */
function yoursite_render_currency_selector($args = array()) {
    $defaults = array(
        'style' => 'dropdown', // dropdown, flags, compact
        'show_flag' => true,
        'show_name' => false,
        'show_symbol' => true,
        'wrapper_class' => 'fancy-selector-wrapper',
        'toggle_class' => 'fancy-selector',
        'dropdown_class' => 'fancy-dropdown',
        'item_class' => 'dropdown-item',
        'active_class' => 'active',
        'class' => 'currency-selector',
        'container_class' => 'currency-selector-container'
    );
    
    $args = wp_parse_args($args, $defaults);
    
    $active_currencies = yoursite_get_active_currencies();
    $current_currency = yoursite_get_user_currency();
    
    if (count($active_currencies) <= 1) {
        return ''; // Don't show selector if only one currency
    }
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($args['wrapper_class']); ?> <?php echo esc_attr($args['container_class']); ?>" 
         data-style="<?php echo esc_attr($args['style']); ?>"
         role="region" 
         aria-label="<?php esc_attr_e('Currency selector', 'yoursite'); ?>">
        
        <?php if ($args['style'] === 'dropdown') : ?>
            <?php yoursite_render_dropdown_currency_selector($active_currencies, $current_currency, $args); ?>
        <?php elseif ($args['style'] === 'flags') : ?>
            <?php yoursite_render_flags_currency_selector($active_currencies, $current_currency, $args); ?>
        <?php elseif ($args['style'] === 'compact') : ?>
            <?php yoursite_render_compact_currency_selector($active_currencies, $current_currency, $args); ?>
        <?php endif; ?>
        
    </div>
    
    <?php if (!wp_script_is('currency-selector-enhanced', 'enqueued')) : ?>
    <script id="currency-selector-enhanced">
    (function() {
        'use strict';
        
        // Prevent multiple initializations
        if (window.currencySelectorInitialized) return;
        window.currencySelectorInitialized = true;
        
        var isProcessing = false;
        var currencyContainers = null;
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeCurrencySelector();
        });

        function initializeCurrencySelector() {
            // Cache DOM elements
            currencyContainers = document.querySelectorAll('.fancy-selector-wrapper, .currency-selector-container');
            
            // Single event delegation handler for all currency interactions
            document.addEventListener('click', handleCurrencyClick);
            
            // Keyboard accessibility
            document.addEventListener('keydown', handleCurrencyKeydown);
            
            // Close dropdowns on escape or outside click
            document.addEventListener('keyup', function(e) {
                if (e.key === 'Escape') {
                    closeAllCurrencySelectors();
                }
            });
            
            // Initialize from cookie/session on page load
            initializeFromStoredCurrency();
        }
        
        function initializeFromStoredCurrency() {
            // Check if we have a stored currency preference
            var storedCurrency = getCookieValue('yoursite_preferred_currency');
            if (storedCurrency && window.YourSiteCurrency) {
                window.YourSiteCurrency.currentCurrency = storedCurrency;
                updateCurrencySelectors(storedCurrency, null);
            }
        }
        
        function getCookieValue(name) {
            var value = '; ' + document.cookie;
            var parts = value.split('; ' + name + '=');
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }
        
        function setCookie(name, value, days) {
            days = days || 30;
            var expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/;SameSite=Lax';
        }
        
        function handleCurrencyClick(e) {
            try {
                // Handle currency selector toggle
                var toggle = e.target.closest('.currency-selector-toggle, .currency-dropdown-toggle');
                if (toggle) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleCurrencySelector(toggle);
                    return;
                }
                
                // Handle currency selection
                var currencyItem = e.target.closest('.currency-selector-item, .currency-dropdown-item, [data-currency-code], [data-currency]');
                if (currencyItem) {
                    e.preventDefault();
                    var currency = currencyItem.dataset.currency || currencyItem.dataset.currencyCode;
                    var symbol = currencyItem.dataset.symbol;
                    switchCurrency(currency, symbol, currencyItem);
                    return;
                }
                
                // Close all dropdowns when clicking outside
                if (!e.target.closest('.fancy-selector-wrapper, .currency-selector-container')) {
                    closeAllCurrencySelectors();
                }
            } catch (error) {
                console.error('Currency click handler error:', error);
            }
        }
        
        function handleCurrencyKeydown(e) {
            var target = e.target.closest('.currency-selector-toggle, .currency-dropdown-toggle, .currency-selector-item, .currency-dropdown-item, [data-currency-code], [data-currency]');
            if (!target) return;
            
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                target.click();
            } else if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                handleArrowNavigation(e);
            }
        }
        
        function handleArrowNavigation(e) {
            var container = e.target.closest('.fancy-selector-wrapper, .currency-selector-container');
            if (!container) return;
            
            var dropdown = container.querySelector('.currency-selector-dropdown, .currency-dropdown, .fancy-dropdown');
            if (!dropdown || (!dropdown.classList.contains('active') && dropdown.classList.contains('hidden'))) return;
            
            e.preventDefault();
            var items = dropdown.querySelectorAll('[data-currency-code], [data-currency]');
            var currentIndex = Array.from(items).findIndex(function(item) { return item === document.activeElement; });
            
            var nextIndex;
            if (e.key === 'ArrowDown') {
                nextIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
            } else {
                nextIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
            }
            
            items[nextIndex].focus();
        }
        
        function toggleCurrencySelector(toggle) {
            try {
                var wrapper = toggle.closest('.fancy-selector-wrapper, .currency-selector-container');
                var dropdown = wrapper.querySelector('.currency-selector-dropdown, .currency-dropdown, .fancy-dropdown');
                
                // Close other selectors first
                closeAllCurrencySelectors();
                
                var isActive = wrapper.classList.toggle('active');
                toggle.setAttribute('aria-expanded', isActive);
                toggle.classList.toggle('active', isActive);
                
                if (dropdown) {
                    if (isActive) {
                        // Check if selector is in footer and adjust positioning
                        var isInFooter = wrapper.closest('.site-footer, .footer-currency-selector, footer') !== null;
                        
                        if (isInFooter) {
                            // Position dropdown above for footer
                            dropdown.style.top = 'auto';
                            dropdown.style.bottom = '100%';
                            dropdown.style.marginTop = '0';
                            dropdown.style.marginBottom = '4px';
                            dropdown.style.transform = 'translateY(8px)';
                        } else {
                            // Default positioning below
                            dropdown.style.top = '100%';
                            dropdown.style.bottom = 'auto';
                            dropdown.style.marginTop = '4px';
                            dropdown.style.marginBottom = '0';
                            dropdown.style.transform = 'translateY(-8px)';
                        }
                        
                        dropdown.classList.remove('hidden');
                        dropdown.classList.add('active');
                        dropdown.removeAttribute('aria-hidden');
                        
                        // Trigger reflow and animate
                        requestAnimationFrame(function() {
                            dropdown.style.opacity = '1';
                            dropdown.style.visibility = 'visible';
                            dropdown.style.transform = 'translateY(0)';
                        });
                        
                        // Focus first option
                        var firstOption = dropdown.querySelector('[data-currency-code], [data-currency]');
                        if (firstOption) {
                            setTimeout(function() { firstOption.focus(); }, 100);
                        }
                    } else {
                        // Remove focus from dropdown items before hiding
                        var focusedItem = dropdown.querySelector(':focus');
                        if (focusedItem) {
                            focusedItem.blur();
                            toggle.focus(); // Return focus to toggle button
                        }
                        
                        // Reset styles and hide
                        dropdown.style.opacity = '0';
                        dropdown.style.visibility = 'hidden';
                        
                        var isInFooter = wrapper.closest('.site-footer, .footer-currency-selector, footer') !== null;
                        dropdown.style.transform = isInFooter ? 'translateY(8px)' : 'translateY(-8px)';
                        
                        setTimeout(function() {
                            dropdown.classList.add('hidden');
                            dropdown.classList.remove('active');
                            dropdown.setAttribute('aria-hidden', 'true');
                        }, 200);
                    }
                }
            } catch (error) {
                console.error('Error toggling dropdown:', error);
            }
        }
        
        function closeAllCurrencySelectors() {
            if (!currencyContainers) return;
            
            currencyContainers.forEach(function(wrapper) {
                wrapper.classList.remove('active');
                var toggle = wrapper.querySelector('.currency-selector-toggle, .currency-dropdown-toggle');
                var dropdown = wrapper.querySelector('.currency-selector-dropdown, .currency-dropdown, .fancy-dropdown');
                
                if (toggle) {
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.classList.remove('active');
                }
                if (dropdown) {
                    // Remove focus from any focused items before hiding
                    var focusedItem = dropdown.querySelector(':focus');
                    if (focusedItem) {
                        focusedItem.blur();
                        // Return focus to the toggle button if it exists
                        var relatedToggle = wrapper.querySelector('.currency-selector-toggle, .currency-dropdown-toggle');
                        if (relatedToggle) {
                            relatedToggle.focus();
                        }
                    }
                    
                    dropdown.classList.add('hidden');
                    dropdown.classList.remove('active');
                    dropdown.setAttribute('aria-hidden', 'true');
                }
            });
        }
        
        function switchCurrency(currency, symbol, clickedItem) {
            if (isProcessing || !currency) return;
            
            isProcessing = true;
            showCurrencyLoadingState();
            
            // Close dropdown and manage focus before making request
            var dropdown = clickedItem.closest('.currency-selector-dropdown, .currency-dropdown, .fancy-dropdown');
            if (dropdown) {
                var wrapper = dropdown.closest('.fancy-selector-wrapper, .currency-selector-container');
                var toggle = wrapper.querySelector('.currency-selector-toggle, .currency-dropdown-toggle');
                
                // Remove focus from clicked item and close dropdown
                clickedItem.blur();
                closeAllCurrencySelectors();
                
                // Return focus to toggle button
                if (toggle) {
                    setTimeout(function() { toggle.focus(); }, 100);
                }
            }
            
            // Set cookie immediately for instant feedback
            setCookie('yoursite_preferred_currency', currency, 30);
            
            // Update global currency state immediately
            if (window.YourSiteCurrency) {
                window.YourSiteCurrency.currentCurrency = currency;
            }
            
            // Update UI immediately
            updateCurrencySelectors(currency, symbol);
            
            var requestData = new URLSearchParams({
                action: 'switch_user_currency',
                currency: currency,
                nonce: '<?php echo wp_create_nonce("currency_switch"); ?>'
            });
            
            fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: requestData,
                credentials: 'same-origin'
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    // Update pricing displays if present
                    updatePricingDisplays(currency);
                    
                    // Show success notification
                    showNotification(data.data.message || 'Currency updated successfully', 'success');
                    
                    // Store in localStorage as additional backup
                    try {
                        localStorage.setItem('yoursite_preferred_currency', currency);
                    } catch (e) {
                        console.warn('localStorage not available:', e);
                    }
                } else {
                    throw new Error(data.data || 'Failed to switch currency');
                }
            })
            .catch(function(error) {
                console.error('Currency switch error:', error);
                
                // Revert UI changes on error
                var previousCurrency = getCookieValue('yoursite_preferred_currency');
                if (previousCurrency && previousCurrency !== currency) {
                    updateCurrencySelectors(previousCurrency, null);
                }
                
                showNotification(error.message || 'Failed to switch currency. Please try again.', 'error');
            })
            .finally(function() {
                hideCurrencyLoadingState();
                isProcessing = false;
            });
        }
        
        function updateCurrencySelectors(currency, symbol) {
            if (!currencyContainers) return;
            
            currencyContainers.forEach(function(wrapper) {
                try {
                    // Update toggle button
                    var toggle = wrapper.querySelector('.currency-selector-toggle, .currency-dropdown-toggle');
                    if (toggle) {
                        var symbolSpan = toggle.querySelector('.currency-symbol');
                        var codeSpan = toggle.querySelector('.selector-text, .currency-code');
                        
                        if (symbolSpan && symbol) symbolSpan.textContent = symbol;
                        if (codeSpan) codeSpan.textContent = currency;
                    }
                    
                    // Update active states in dropdown
                    wrapper.querySelectorAll('[data-currency-code], [data-currency]').forEach(function(item) {
                        var itemCurrency = item.dataset.currency || item.dataset.currencyCode;
                        var isActive = itemCurrency === currency;
                        item.classList.toggle('active', isActive);
                        item.setAttribute('aria-current', isActive ? 'true' : 'false');
                        if (item.setAttribute) {
                            item.setAttribute('aria-checked', isActive ? 'true' : 'false');
                        }
                    });
                } catch (error) {
                    console.error('Error updating selector state:', error);
                }
            });
        }
        
        function updatePricingDisplays(currency) {
            // Update pricing cards
            updatePricingCards(currency);
            
            // Update any pricing elements on the page
            var pricingCards = document.querySelectorAll('[data-plan-id]');
            pricingCards.forEach(function(card) {
                // Trigger pricing updates if implemented
                var event = new CustomEvent('currencyChanged', {
                    detail: { currency: currency }
                });
                document.dispatchEvent(event);
            });
        }
        
        function updatePricingCards(currencyCode) {
            return fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_all_pricing_in_currency',
                    currency: currencyCode,
                    nonce: '<?php echo wp_create_nonce("get_pricing"); ?>'
                }),
                credentials: 'same-origin'
            })
            .then(function(response) {
                if (!response.ok) throw new Error('HTTP error! status: ' + response.status);
                return response.json();
            })
            .then(function(data) {
                if (data.success && data.data.pricing) {
                    Object.keys(data.data.pricing).forEach(function(planId) {
                        var pricing = data.data.pricing[planId];
                        updatePlanPricing(planId, pricing);
                    });
                }
            })
            .catch(function(error) {
                console.error('Error updating pricing cards:', error);
            });
        }
        
        function updatePlanPricing(planId, pricing) {
            if (!pricing) return;
            
            try {
                // Update monthly prices
                var monthlySelector = '[data-plan-id="' + planId + '"] .monthly-price-display, [data-plan-id="' + planId + '"] .pricing-monthly-pricing';
                document.querySelectorAll(monthlySelector).forEach(function(el) {
                    var priceElement = el.querySelector('.price-amount, .text-4xl, .text-5xl');
                    if (priceElement && pricing.monthly_price) {
                        priceElement.textContent = pricing.monthly_price.replace(/[^0-9.,]/g, '');
                    }
                });
                
                // Update annual prices
                var annualSelector = '[data-plan-id="' + planId + '"] .annual-price-display, [data-plan-id="' + planId + '"] .pricing-annual-pricing';
                document.querySelectorAll(annualSelector).forEach(function(el) {
                    var priceElement = el.querySelector('.price-amount, .text-4xl, .text-5xl');
                    if (priceElement && pricing.annual_monthly_equivalent) {
                        priceElement.textContent = pricing.annual_monthly_equivalent.replace(/[^0-9.,]/g, '');
                    }
                });
                
                // Update savings
                if (pricing.savings) {
                    var savingsSelector = '[data-plan-id="' + planId + '"] .annual-savings, [data-plan-id="' + planId + '"] .pricing-annual-savings';
                    document.querySelectorAll(savingsSelector).forEach(function(el) {
                        var savingsText = el.querySelector('.savings-amount');
                        if (savingsText) {
                            savingsText.textContent = pricing.savings;
                        }
                    });
                }
            } catch (error) {
                console.error('Error updating plan pricing:', error);
            }
        }
        
        function showCurrencyLoadingState() {
            if (!currencyContainers) return;
            
            currencyContainers.forEach(function(container) {
                container.classList.add('loading');
                container.setAttribute('aria-busy', 'true');
                container.style.cursor = 'wait';
            });
        }
        
        function hideCurrencyLoadingState() {
            if (!currencyContainers) return;
            
            currencyContainers.forEach(function(container) {
                container.classList.remove('loading');
                container.setAttribute('aria-busy', 'false');
                container.style.cursor = '';
            });
        }
        
        function showNotification(message, type) {
            type = type || 'success';
            
            // Remove existing notifications
            document.querySelectorAll('.currency-notification').forEach(function(n) { n.remove(); });
            
            var notification = document.createElement('div');
            notification.className = 'currency-notification ' + type;
            notification.textContent = message;
            notification.setAttribute('role', 'alert');
            notification.setAttribute('aria-live', 'polite');
            
            // Style the notification
            Object.assign(notification.style, {
                position: 'fixed',
                top: '20px',
                right: '20px',
                padding: '12px 20px',
                borderRadius: '6px',
                zIndex: '10000',
                maxWidth: '300px',
                boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
                fontSize: '14px',
                fontWeight: '500',
                backgroundColor: type === 'success' ? '#10b981' : '#ef4444',
                color: 'white',
                transform: 'translateX(100%)',
                transition: 'transform 0.3s ease',
                opacity: '0'
            });
            
            document.body.appendChild(notification);
            
            // Animate in
            requestAnimationFrame(function() {
                notification.style.transform = 'translateX(0)';
                notification.style.opacity = '1';
            });
            
            // Remove after delay
            var timeout = type === 'error' ? 5000 : 3000;
            setTimeout(function() {
                notification.style.transform = 'translateX(100%)';
                notification.style.opacity = '0';
                setTimeout(function() {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, timeout);
        }
        
        // Public API
        window.currencySelector = {
            switch: switchCurrency,
            close: closeAllCurrencySelectors,
            showNotification: showNotification,
            getCurrentCurrency: function() { 
                return window.YourSiteCurrency ? window.YourSiteCurrency.currentCurrency : 'USD'; 
            }
        };
        
    })();
    </script>
    
    <style id="currency-selector-enhanced-styles">
    /* Enhanced Currency Selector Styles - Combining both approaches */
    .fancy-selector-wrapper, .currency-selector-container {
        position: relative;
        display: inline-block;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    .fancy-selector-wrapper.loading, .currency-selector-container.loading {
        opacity: 0.7;
        pointer-events: none;
    }
    
    .fancy-selector-wrapper[aria-busy="true"]::after, .currency-selector-container[aria-busy="true"]::after {
        content: '';
        position: absolute;
        top: 50%;
        right: 8px;
        width: 12px;
        height: 12px;
        border: 2px solid #ccc;
        border-top-color: #007cba;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        transform: translateY(-50%);
    }
    
    @keyframes spin {
        to { transform: translateY(-50%) rotate(360deg); }
    }
    
    /* Enhanced toggle button styles */
    .currency-selector-toggle, .currency-dropdown-toggle, .fancy-selector {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        background: #fff;
        border: 1px solid #dddde3;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        outline: none;
        position: relative;
        min-width: 120px;
        text-decoration: none;
        color: #1e1e1e;
    }
    
    .currency-selector-toggle:hover, .currency-dropdown-toggle:hover {
        border-color: #007cba;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .currency-selector-toggle:focus, .currency-dropdown-toggle:focus {
        border-color: #007cba;
        box-shadow: 0 0 0 2px rgba(0,124,186,0.2);
    }
    
    .currency-selector-toggle.active, .currency-dropdown-toggle.active {
        border-color: #007cba;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    
    .currency-selector-toggle .chevron, .currency-dropdown-toggle .currency-chevron,
    .currency-selector-toggle svg, .currency-dropdown-toggle svg {
        margin-left: auto;
        transition: transform 0.2s ease;
        width: 12px;
        height: 12px;
    }
    
    .currency-selector-toggle.active .chevron, .currency-dropdown-toggle.active .currency-chevron,
    .currency-selector-toggle.active svg, .currency-dropdown-toggle.active svg {
        transform: rotate(180deg);
    }
    
    /* Enhanced dropdown styles */
    .currency-selector-dropdown, .currency-dropdown, .fancy-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #dddde3;
        border-radius: 8px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        z-index: 1000;
        margin-top: 4px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: all 0.2s ease;
        max-height: 300px;
        overflow-y: auto;
    }
    
    /* Footer-specific dropdown positioning - opens upward */
    .site-footer .currency-selector-dropdown,
    .site-footer .currency-dropdown,
    .site-footer .fancy-dropdown,
    .footer-currency-selector .currency-selector-dropdown,
    .footer-currency-selector .currency-dropdown,
    .footer-currency-selector .fancy-dropdown {
        top: auto !important;
        bottom: 100% !important;
        margin-top: 0 !important;
        margin-bottom: 4px !important;
        transform: translateY(8px) !important;
    }
    
    .site-footer .fancy-selector-wrapper.active .currency-selector-dropdown,
    .site-footer .currency-selector-container.active .currency-dropdown,
    .footer-currency-selector .fancy-selector-wrapper.active .currency-selector-dropdown,
    .footer-currency-selector .currency-selector-container.active .currency-dropdown {
        transform: translateY(0) !important;
    }
    
    .currency-selector-dropdown.active, .currency-dropdown.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .fancy-dropdown:not(.hidden) {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    /* Footer dropdown animation fix */
    .site-footer .fancy-dropdown:not(.hidden),
    .footer-currency-selector .fancy-dropdown:not(.hidden) {
        transform: translateY(0) !important;
    }
    
    /* Enhanced dropdown item styles */
    .currency-selector-item, .currency-dropdown-item, .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        text-decoration: none;
        color: #1e1e1e;
        border-bottom: 1px solid #f6f7f7;
        transition: all 0.15s ease;
        cursor: pointer;
        outline: none;
    }
    
    .currency-selector-item:last-child, .currency-dropdown-item:last-child {
        border-bottom: none;
    }
    
    .currency-selector-item:hover, .currency-dropdown-item:hover,
    .currency-selector-item:focus, .currency-dropdown-item:focus {
        background: #f6f7f7;
        color: #007cba;
    }
    
    .currency-selector-item.active, .currency-dropdown-item.active {
        background: #e7f3ff;
        color: #005177;
        font-weight: 600;
    }
    
    .currency-flag {
        font-size: 16px;
        width: 20px;
        text-align: center;
    }
    
    .currency-code, .selector-text {
        font-weight: 500;
        min-width: 40px;
    }
    
    .currency-symbol {
        font-weight: 500;
    }
    
    .currency-name {
        font-size: 13px;
        color: #666;
    }
    
    /* Flag selector styles */
    .currency-flags-selector {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }
    
    .currency-flag-item {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        background: #fff;
        border: 1px solid #dddde3;
        border-radius: 6px;
        text-decoration: none;
        color: #1e1e1e;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        outline: none;
    }
    
    .currency-flag-item:hover, .currency-flag-item:focus {
        border-color: #007cba;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transform: translateY(-1px);
    }
    
    .currency-flag-item.active {
        background: #007cba;
        border-color: #005177;
        color: #fff;
        box-shadow: 0 2px 8px rgba(0,124,186,0.3);
    }
    
    /* Compact selector styles */
    .currency-compact-selector {
        display: flex;
        background: #fff;
        border: 1px solid #dddde3;
        border-radius: 6px;
        overflow: hidden;
    }
    
    .currency-compact-item {
        padding: 10px 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        color: #1e1e1e;
        border-right: 1px solid #dddde3;
        font-size: 13px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        outline: none;
    }
    
    .currency-compact-item:last-child {
        border-right: none;
    }
    
    .currency-compact-item:hover, .currency-compact-item:focus {
        background: #f6f7f7;
        color: #007cba;
    }
    
    .currency-compact-item.active {
        background: #007cba;
        color: #fff;
    }
    
    /* Notification styles */
    .currency-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 14px 18px;
        border-radius: 8px;
        color: #fff;
        font-weight: 500;
        font-size: 14px;
        z-index: 10000;
        max-width: 350px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    
    .currency-notification.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .currency-notification.error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    
    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .currency-selector-toggle, .currency-dropdown-toggle, .fancy-selector,
        .currency-dropdown, .currency-selector-dropdown, .fancy-dropdown,
        .currency-flag-item, .currency-compact-selector {
            background: #1e1e1e;
            border-color: #3c4043;
            color: #e8eaed;
        }
        
        .currency-selector-item, .currency-dropdown-item, .dropdown-item {
            color: #e8eaed;
            border-bottom-color: #3c4043;
        }
        
        .currency-selector-item:hover, .currency-dropdown-item:hover,
        .currency-selector-item:focus, .currency-dropdown-item:focus,
        .currency-flag-item:hover, .currency-flag-item:focus,
        .currency-compact-item:hover, .currency-compact-item:focus {
            background: #3c4043;
            color: #8ab4f8;
        }
        
        .currency-selector-item.active, .currency-dropdown-item.active {
            background: #1a472a;
            color: #81c995;
        }
        
        .currency-flag-item.active, .currency-compact-item.active {
            background: #1a73e8;
            border-color: #185abc;
        }
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .currency-dropdown, .currency-selector-dropdown, .fancy-dropdown {
            min-width: 200px;
            right: 0;
            left: auto;
        }
        
        /* Footer mobile positioning */
        .site-footer .currency-dropdown,
        .site-footer .currency-selector-dropdown,
        .site-footer .fancy-dropdown,
        .footer-currency-selector .currency-dropdown,
        .footer-currency-selector .currency-selector-dropdown,
        .footer-currency-selector .fancy-dropdown {
            right: 0 !important;
            left: auto !important;
            bottom: 100% !important;
            top: auto !important;
        }
        
        .currency-flags-selector {
            gap: 4px;
        }
        
        .currency-flag-item {
            padding: 6px 10px;
            font-size: 12px;
        }
        
        .currency-notification {
            left: 16px;
            right: 16px;
            top: 16px;
            text-align: center;
        }
        
        .currency-selector-toggle, .currency-dropdown-toggle {
            min-width: 100px;
            padding: 8px 12px;
        }
    }
    
    /* High contrast support */
    @media (prefers-contrast: high) {
        .currency-selector-toggle, .currency-dropdown-toggle,
        .currency-selector-item, .currency-dropdown-item,
        .currency-flag-item, .currency-compact-item {
            border-width: 2px;
        }
        
        .currency-selector-toggle:focus, .currency-dropdown-toggle:focus,
        .currency-selector-item:focus, .currency-dropdown-item:focus,
        .currency-flag-item:focus, .currency-compact-item:focus {
            outline: 3px solid;
            outline-offset: 2px;
        }
    }
    
    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        .currency-selector-toggle, .currency-dropdown-toggle,
        .currency-dropdown, .currency-selector-dropdown, .fancy-dropdown,
        .currency-selector-item, .currency-dropdown-item,
        .currency-flag-item, .currency-compact-item,
        .currency-notification {
            transition: none;
        }
        
        .currency-selector-toggle .chevron, .currency-dropdown-toggle .currency-chevron,
        .currency-selector-toggle svg, .currency-dropdown-toggle svg {
            transition: none;
        }
    }
    
    /* Container alignment helpers */
    .shortcode-container.align-center { text-align: center; }
    .shortcode-container.align-right { text-align: right; }
    .header-currency-selector { display: inline-block; }
    .footer-currency-selector { display: flex; align-items: center; gap: 8px; }
    </style>
    <?php endif; ?>
    
    <?php
    return ob_get_clean();
}

/**
 * Render dropdown currency selector
 */
function yoursite_render_dropdown_currency_selector($currencies, $current_currency, $args) {
    ?>
    <button class="currency-selector-toggle currency-dropdown-toggle <?php echo esc_attr($args['toggle_class']); ?>" 
            type="button"
            aria-expanded="false"
            aria-haspopup="listbox"
            aria-label="<?php esc_attr_e('Select currency', 'yoursite'); ?>">
        
        <?php if ($args['show_flag']) : ?>
            <span class="currency-flag" aria-hidden="true"><?php echo esc_html($current_currency['flag']); ?></span>
        <?php endif; ?>
        
        <?php if ($args['show_symbol']) : ?>
            <span class="currency-symbol"><?php echo esc_html($current_currency['symbol']); ?></span>
        <?php endif; ?>
        
        <span class="selector-text currency-code"><?php echo esc_html($current_currency['code']); ?></span>
        
        <?php if ($args['show_name']) : ?>
            <span class="currency-name"><?php echo esc_html($current_currency['name']); ?></span>
        <?php endif; ?>
        
        <svg class="w-4 h-4 text-gray-400 chevron currency-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    
    <div class="currency-selector-dropdown currency-dropdown <?php echo esc_attr($args['dropdown_class']); ?> hidden" 
         role="listbox" 
         aria-hidden="true"
         aria-label="<?php esc_attr_e('Currency options', 'yoursite'); ?>">
        <?php foreach ($currencies as $currency) : ?>
            <a href="#" 
               class="currency-selector-item currency-dropdown-item <?php echo esc_attr($args['item_class']); ?> <?php echo $currency['code'] === $current_currency['code'] ? $args['active_class'] : ''; ?>"
               data-currency="<?php echo esc_attr($currency['code']); ?>"
               data-currency-code="<?php echo esc_attr($currency['code']); ?>"
               data-symbol="<?php echo esc_attr($currency['symbol']); ?>"
               role="option"
               aria-current="<?php echo $currency['code'] === $current_currency['code'] ? 'true' : 'false'; ?>"
               aria-label="<?php echo esc_attr(sprintf(__('Switch to %s (%s)', 'yoursite'), $currency['name'], $currency['code'])); ?>"
               tabindex="0">
                
                <?php if ($args['show_flag']) : ?>
                    <span class="currency-flag" aria-hidden="true"><?php echo esc_html($currency['flag']); ?></span>
                <?php endif; ?>
                
                <span class="currency-details">
                    <?php if ($args['show_symbol']) : ?>
                        <span class="currency-symbol"><?php echo esc_html($currency['symbol']); ?></span>
                    <?php endif; ?>
                    <span class="currency-code"><?php echo esc_html($currency['code']); ?></span>
                    <?php if ($args['show_name']) : ?>
                        <span class="currency-name"><?php echo esc_html($currency['name']); ?></span>
                    <?php endif; ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Render flags currency selector
 */
function yoursite_render_flags_currency_selector($currencies, $current_currency, $args) {
    ?>
    <div class="currency-flags-selector <?php echo esc_attr($args['class']); ?>" 
         role="radiogroup" 
         aria-label="<?php esc_attr_e('Select currency', 'yoursite'); ?>">
        <?php foreach ($currencies as $currency) : ?>
            <a href="#" 
               class="currency-flag-item <?php echo $currency['code'] === $current_currency['code'] ? 'active' : ''; ?>"
               data-currency="<?php echo esc_attr($currency['code']); ?>"
               data-currency-code="<?php echo esc_attr($currency['code']); ?>"
               data-symbol="<?php echo esc_attr($currency['symbol']); ?>"
               role="radio"
               aria-checked="<?php echo $currency['code'] === $current_currency['code'] ? 'true' : 'false'; ?>"
               aria-label="<?php echo esc_attr(sprintf(__('Switch to %s (%s)', 'yoursite'), $currency['name'], $currency['code'])); ?>"
               title="<?php echo esc_attr($currency['name'] . ' (' . $currency['symbol'] . ')'); ?>"
               tabindex="0">
                
                <?php if ($args['show_flag']) : ?>
                    <span class="currency-flag" aria-hidden="true"><?php echo esc_html($currency['flag']); ?></span>
                <?php endif; ?>
                
                <span class="currency-code"><?php echo esc_html($currency['code']); ?></span>
                
                <?php if ($args['show_symbol']) : ?>
                    <span class="currency-symbol"><?php echo esc_html($currency['symbol']); ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Render compact currency selector
 */
function yoursite_render_compact_currency_selector($currencies, $current_currency, $args) {
    ?>
    <div class="currency-compact-selector <?php echo esc_attr($args['class']); ?>" 
         role="radiogroup" 
         aria-label="<?php esc_attr_e('Select currency', 'yoursite'); ?>">
        <?php foreach ($currencies as $currency) : ?>
            <a href="#" 
               class="currency-compact-item <?php echo $currency['code'] === $current_currency['code'] ? 'active' : ''; ?>"
               data-currency="<?php echo esc_attr($currency['code']); ?>"
               data-currency-code="<?php echo esc_attr($currency['code']); ?>"
               data-symbol="<?php echo esc_attr($currency['symbol']); ?>"
               role="radio"
               aria-checked="<?php echo $currency['code'] === $current_currency['code'] ? 'true' : 'false'; ?>"
               aria-label="<?php echo esc_attr(sprintf(__('Switch to %s', 'yoursite'), $currency['name'])); ?>"
               title="<?php echo esc_attr($currency['name']); ?>"
               tabindex="0">
                
                <?php if ($args['show_flag']) : ?>
                    <span class="currency-flag" aria-hidden="true"><?php echo esc_html($currency['flag']); ?></span>
                <?php endif; ?>
                
                <span class="currency-code"><?php echo esc_html($currency['code']); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Enhanced pricing display for multi-currency
 */
function yoursite_display_multi_currency_price($plan_id, $period = 'monthly', $args = array()) {
    $defaults = array(
        'show_currency_options' => true,
        'show_original_price' => false,
        'format' => 'standard', // standard, compact, detailed
        'class' => 'multi-currency-price',
        'cache_duration' => 300 // 5 minutes cache
    );
    
    $args = wp_parse_args($args, $defaults);
    $current_currency = yoursite_get_user_currency();
    
    // Cache key for pricing data
    $cache_key = "pricing_{$plan_id}_{$current_currency['code']}_{$period}";
    $price = wp_cache_get($cache_key, 'yoursite_pricing');
    
    if ($price === false) {
        $price = yoursite_get_pricing_plan_price($plan_id, $current_currency['code'], $period);
        wp_cache_set($cache_key, $price, 'yoursite_pricing', $args['cache_duration']);
    }
    
    if ($price <= 0) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($args['class']); ?>" 
         data-plan-id="<?php echo esc_attr($plan_id); ?>" 
         data-period="<?php echo esc_attr($period); ?>"
         data-currency="<?php echo esc_attr($current_currency['code']); ?>">
        
        <div class="primary-price" role="text" aria-label="<?php echo esc_attr(sprintf(__('Price: %s per %s', 'yoursite'), yoursite_format_currency($price, $current_currency['code']), $period)); ?>">
            <?php echo yoursite_format_currency($price, $current_currency['code']); ?>
        </div>
        
        <?php if ($args['show_original_price'] && $current_currency['code'] !== yoursite_get_base_currency()['code']) : ?>
            <div class="original-price" role="text" aria-label="<?php esc_attr_e('Original price', 'yoursite'); ?>">
                <?php 
                $base_currency = yoursite_get_base_currency();
                $base_cache_key = "pricing_{$plan_id}_{$base_currency['code']}_{$period}";
                $base_price = wp_cache_get($base_cache_key, 'yoursite_pricing');
                
                if ($base_price === false) {
                    $base_price = yoursite_get_pricing_plan_price($plan_id, $base_currency['code'], $period);
                    wp_cache_set($base_cache_key, $base_price, 'yoursite_pricing', $args['cache_duration']);
                }
                
                echo yoursite_format_currency($base_price, $base_currency['code']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if ($args['show_currency_options']) : ?>
            <div class="currency-options">
                <?php echo yoursite_render_currency_selector(array('style' => 'compact')); ?>
            </div>
        <?php endif; ?>
        
    </div>
    <?php
    
    return ob_get_clean();
}

/**
 * Enhanced Widget for displaying currency selector
 */
class YourSite_Currency_Selector_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'yoursite_currency_selector',
            __('Currency Selector', 'yoursite'),
            array(
                'description' => __('Display a currency selector widget with customizable options', 'yoursite'),
                'classname' => 'yoursite-currency-selector-widget'
            )
        );
    }
    
    public function widget($args, $instance) {
        // Check if we should display the widget
        if (!yoursite_should_display_currency_selector()) {
            return;
        }
        
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
        
        echo $args['before_widget'];
        
        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        
        $selector_args = array(
            'style' => isset($instance['style']) ? $instance['style'] : 'dropdown',
            'show_flag' => !empty($instance['show_flag']),
            'show_name' => !empty($instance['show_name']),
            'show_symbol' => !empty($instance['show_symbol']),
            'class' => 'widget-currency-selector'
        );
        
        echo yoursite_render_currency_selector($selector_args);
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $defaults = array(
            'title' => '',
            'style' => 'dropdown',
            'show_flag' => true,
            'show_name' => false,
            'show_symbol' => true
        );
        
        $instance = wp_parse_args($instance, $defaults);
        
        // Extract variables for easier access
        extract($instance);
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'yoursite'); ?></label>
            <input class="widefat" 
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>"
                   placeholder="<?php esc_attr_e('Currency Selector', 'yoursite'); ?>">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('style')); ?>"><?php esc_html_e('Display Style:', 'yoursite'); ?></label>
            <select class="widefat" 
                    id="<?php echo esc_attr($this->get_field_id('style')); ?>" 
                    name="<?php echo esc_attr($this->get_field_name('style')); ?>">
                <option value="dropdown" <?php selected($style, 'dropdown'); ?>><?php esc_html_e('Dropdown', 'yoursite'); ?></option>
                <option value="flags" <?php selected($style, 'flags'); ?>><?php esc_html_e('Flag Buttons', 'yoursite'); ?></option>
                <option value="compact" <?php selected($style, 'compact'); ?>><?php esc_html_e('Compact', 'yoursite'); ?></option>
            </select>
        </p>
        
        <fieldset>
            <legend><?php esc_html_e('Display Options:', 'yoursite'); ?></legend>
            
            <p>
                <input class="checkbox" 
                       type="checkbox" 
                       <?php checked($show_flag); ?> 
                       id="<?php echo esc_attr($this->get_field_id('show_flag')); ?>" 
                       name="<?php echo esc_attr($this->get_field_name('show_flag')); ?>" 
                       value="1" />
                <label for="<?php echo esc_attr($this->get_field_id('show_flag')); ?>"><?php esc_html_e('Show country flags', 'yoursite'); ?></label>
            </p>
            
            <p>
                <input class="checkbox" 
                       type="checkbox" 
                       <?php checked($show_name); ?> 
                       id="<?php echo esc_attr($this->get_field_id('show_name')); ?>" 
                       name="<?php echo esc_attr($this->get_field_name('show_name')); ?>" 
                       value="1" />
                <label for="<?php echo esc_attr($this->get_field_id('show_name')); ?>"><?php esc_html_e('Show currency names', 'yoursite'); ?></label>
            </p>
            
            <p>
                <input class="checkbox" 
                       type="checkbox" 
                       <?php checked($show_symbol); ?> 
                       id="<?php echo esc_attr($this->get_field_id('show_symbol')); ?>" 
                       name="<?php echo esc_attr($this->get_field_name('show_symbol')); ?>" 
                       value="1" />
                <label for="<?php echo esc_attr($this->get_field_id('show_symbol')); ?>"><?php esc_html_e('Show currency symbols', 'yoursite'); ?></label>
            </p>
        </fieldset>
        
        <p class="description">
            <?php esc_html_e('Configure how the currency selector appears in your widget area.', 'yoursite'); ?>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = sanitize_text_field(isset($new_instance['title']) ? $new_instance['title'] : '');
        $instance['style'] = in_array(isset($new_instance['style']) ? $new_instance['style'] : '', array('dropdown', 'flags', 'compact')) ? $new_instance['style'] : 'dropdown';
        $instance['show_flag'] = !empty($new_instance['show_flag']);
        $instance['show_name'] = !empty($new_instance['show_name']);
        $instance['show_symbol'] = !empty($new_instance['show_symbol']);
        
        // Clear any cached widget output
        wp_cache_delete('yoursite_currency_widget_' . $this->id, 'widget');
        
        return $instance;
    }
}

// Register the widget
function yoursite_register_currency_widgets() {
    register_widget('YourSite_Currency_Selector_Widget');
}
add_action('widgets_init', 'yoursite_register_currency_widgets');

/**
 * Enhanced shortcode for currency selector
 */
function yoursite_currency_selector_shortcode($atts, $content = null) {
    // Don't display if currency functionality is disabled
    if (!yoursite_should_display_currency_selector()) {
        return '';
    }
    
    $atts = shortcode_atts(array(
        'style' => 'dropdown',
        'show_flag' => 'true',
        'show_name' => 'false',
        'show_symbol' => 'true',
        'class' => 'currency-selector-shortcode',
        'align' => 'left' // left, center, right
    ), $atts, 'currency_selector');
    
    // Validate style parameter
    if (!in_array($atts['style'], array('dropdown', 'flags', 'compact'))) {
        $atts['style'] = 'dropdown';
    }
    
    $args = array(
        'style' => $atts['style'],
        'show_flag' => $atts['show_flag'] === 'true',
        'show_name' => $atts['show_name'] === 'true',
        'show_symbol' => $atts['show_symbol'] === 'true',
        'class' => sanitize_html_class($atts['class']),
        'container_class' => 'currency-selector-container shortcode-container align-' . sanitize_html_class($atts['align'])
    );
    
    return yoursite_render_currency_selector($args);
}
add_shortcode('currency_selector', 'yoursite_currency_selector_shortcode');

/**
 * Helper function to check if currency selector should be displayed
 */
function yoursite_should_display_currency_selector() {
    $settings = get_option('yoursite_currency_settings', array());
    $active_currencies = yoursite_get_active_currencies();
    
    // Don't show if disabled in settings or only one currency
    if (empty($settings['enable_currency_selector']) || count($active_currencies) <= 1) {
        return false;
    }
    
    // Allow filtering by other plugins/themes
    return apply_filters('yoursite_display_currency_selector', true);
}

/**
 * Add currency selector to header/footer
 */
function yoursite_add_header_currency_selector() {
    $settings = get_option('yoursite_currency_settings', array());
    
    if (isset($settings['display_currency_selector']) ? $settings['display_currency_selector'] : true) {
        echo '<div class="header-currency-selector" style="margin: 0 15px;">';
        echo yoursite_render_currency_selector(array(
            'style' => 'compact',
            'show_flag' => true,
            'show_name' => false,
            'show_symbol' => false,
            'class' => 'header-currency-widget'
        ));
        echo '</div>';
    }
}

/**
 * Add structured data for currency information
 */
function yoursite_add_currency_structured_data() {
    if (!is_page() && !is_single()) {
        return;
    }
    
    $current_currency = yoursite_get_user_currency();
    $structured_data = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'mainEntity' => array(
            '@type' => 'PriceSpecification',
            'priceCurrency' => $current_currency['code']
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($structured_data) . '</script>';
}
add_action('wp_head', 'yoursite_add_currency_structured_data');

/**
 * Enqueue necessary styles and scripts
 */
function yoursite_enqueue_currency_assets() {
    if (!yoursite_should_display_currency_selector()) {
        return;
    }
    
    // Add inline styles for better compatibility
    wp_add_inline_style('theme-style', '
        .shortcode-container.align-center { text-align: center; }
        .shortcode-container.align-right { text-align: right; }
        .header-currency-selector { display: inline-block; }
        .footer-currency-selector { display: flex; align-items: center; gap: 8px; }
    ');
}
add_action('wp_enqueue_scripts', 'yoursite_enqueue_currency_assets');

// Hook functions to appropriate actions based on theme/plugin configuration
// These can be called from theme files or hooked to specific actions
// add_action('wp_head', 'yoursite_add_currency_selector_to_header');
// add_action('wp_footer', 'yoursite_add_currency_selector_to_footer');

?>
/**
 * Complete Currency Frontend JavaScript
 * Add this to your theme's main JS file or create: assets/js/currency.js
 * 
 * WORKS WITH: The new currency-ajax.php rewrite
 * HANDLES: All currency switching, pricing updates, UI changes
 */

(function($) {
    'use strict';
    
    // Initialize currency management system
    window.YourSiteCurrency = window.YourSiteCurrency || {
        current: 'USD',
        ajaxUrl: '/wp-admin/admin-ajax.php',
        nonce: '',
        cookieName: 'yoursite_preferred_currency',
        debug: false,
        currencies: {},
        isLoading: false
    };
    
    const Currency = {
        
        /**
         * Initialize the currency system
         */
        init: function() {
            this.loadSavedCurrency();
            this.bindEvents();
            this.loadAvailableCurrencies();
            this.updateAllPricing();
            
            if (window.YourSiteCurrency.debug) {
                console.log('YourSite Currency System Initialized');
                console.log('Current Currency:', window.YourSiteCurrency.current);
            }
        },
        
        /**
         * Bind all currency-related events
         */
        bindEvents: function() {
            // Currency selector dropdowns
            $(document).on('change', '.currency-selector', this.handleDropdownChange.bind(this));
            
            // Currency buttons
            $(document).on('click', '.currency-btn, [data-currency]', this.handleButtonClick.bind(this));
            
            // Billing period toggles (monthly/annual)
            $(document).on('change', '.billing-period-toggle', this.handleBillingPeriodChange.bind(this));
            
            // Plan selection buttons
            $(document).on('click', '.plan-select-btn', this.handlePlanSelection.bind(this));
            
            // Currency refresh button (if exists)
            $(document).on('click', '.currency-refresh-btn', this.refreshPricing.bind(this));
            
            // Debug toggle
            $(document).on('click', '.currency-debug-toggle', this.toggleDebug.bind(this));
        },
        
        /**
         * Handle dropdown currency changes
         */
        handleDropdownChange: function(e) {
            const currencyCode = $(e.target).val();
            if (currencyCode && currencyCode !== window.YourSiteCurrency.current) {
                this.switchCurrency(currencyCode);
            }
        },
        
        /**
         * Handle currency button clicks
         */
        handleButtonClick: function(e) {
            e.preventDefault();
            
            const $target = $(e.target);
            const currencyCode = $target.data('currency') || 
                               $target.closest('[data-currency]').data('currency') ||
                               $target.attr('data-currency');
            
            if (currencyCode && currencyCode !== window.YourSiteCurrency.current) {
                this.switchCurrency(currencyCode);
            }
        },
        
        /**
         * Handle billing period changes (monthly/annual)
         */
        handleBillingPeriodChange: function(e) {
            const period = $(e.target).val() || $(e.target).data('period');
            this.updateBillingPeriodDisplay(period);
        },
        
        /**
         * Handle plan selection with currency consideration
         */
        handlePlanSelection: function(e) {
            const $btn = $(e.target);
            const planId = $btn.data('plan-id');
            const currentCurrency = window.YourSiteCurrency.current;
            
            // Add currency info to plan selection
            $btn.data('selected-currency', currentCurrency);
            
            // Trigger custom event for other scripts to listen
            $(document).trigger('currencyPlanSelected', {
                planId: planId,
                currency: currentCurrency,
                button: $btn
            });
        },
        
        /**
         * Main currency switching function
         */
        switchCurrency: function(currencyCode) {
            if (this.isLoading) {
                if (window.YourSiteCurrency.debug) {
                    console.log('Currency switch already in progress');
                }
                return;
            }
            
            if (currencyCode === window.YourSiteCurrency.current) {
                if (window.YourSiteCurrency.debug) {
                    console.log('Currency already selected:', currencyCode);
                }
                return;
            }
            
            this.isLoading = true;
            this.showLoading();
            
            // 1. Set cookie immediately (most important for persistence)
            this.setCookie(window.YourSiteCurrency.cookieName, currencyCode, 30);
            
            // 2. Update current currency
            const oldCurrency = window.YourSiteCurrency.current;
            window.YourSiteCurrency.current = currencyCode;
            
            // 3. Update UI immediately for better UX
            this.updateCurrencySelectors(currencyCode);
            
            // 4. Update server-side storage
            this.updateServerCurrency(currencyCode)
                .then(() => {
                    // 5. Update all pricing
                    return this.updateAllPricing();
                })
                .then(() => {
                    // 6. Show success message
                    this.showSuccessMessage(currencyCode);
                    
                    // 7. Trigger custom events
                    $(document).trigger('currencyChanged', {
                        oldCurrency: oldCurrency,
                        newCurrency: currencyCode
                    });
                })
                .catch((error) => {
                    // Rollback on error
                    window.YourSiteCurrency.current = oldCurrency;
                    this.updateCurrencySelectors(oldCurrency);
                    this.showErrorMessage('Failed to switch currency: ' + error.message);
                    
                    if (window.YourSiteCurrency.debug) {
                        console.error('Currency switch error:', error);
                    }
                })
                .finally(() => {
                    this.isLoading = false;
                    this.hideLoading();
                });
        },
        
        /**
         * Update server-side currency storage
         */
        updateServerCurrency: function(currencyCode) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: window.YourSiteCurrency.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'switch_user_currency',
                        currency: currencyCode,
                        nonce: window.YourSiteCurrency.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            if (window.YourSiteCurrency.debug) {
                                console.log('Server currency updated:', response.data);
                            }
                            resolve(response.data);
                        } else {
                            reject(new Error(response.data || 'Server update failed'));
                        }
                    },
                    error: function(xhr, status, error) {
                        // Don't fail completely if server update fails
                        if (window.YourSiteCurrency.debug) {
                            console.warn('Server currency update failed:', error);
                        }
                        resolve(); // Continue with local changes
                    }
                });
            });
        },
        
        /**
         * Update all pricing displays
         */
        updateAllPricing: function() {
            const currencyCode = window.YourSiteCurrency.current;
            
            // Update individual pricing cards
            const pricingCards = $('.pricing-card, .pricing-plan, [data-plan-id]');
            const updatePromises = [];
            
            pricingCards.each((index, element) => {
                const $card = $(element);
                const planId = $card.data('plan-id') || 
                              $card.find('[data-plan-id]').first().data('plan-id');
                
                if (planId) {
                    updatePromises.push(this.updatePlanPricing($card, planId, currencyCode));
                }
            });
            
            // Update individual price elements
            this.updateIndividualPrices(currencyCode);
            
            // Update currency symbols throughout the page
            this.updateCurrencySymbols(currencyCode);
            
            return Promise.all(updatePromises);
        },
        
        /**
         * Update pricing for a specific plan
         */
        updatePlanPricing: function($card, planId, currencyCode) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: window.YourSiteCurrency.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'get_currency_pricing',
                        plan_id: planId,
                        currency: currencyCode,
                        nonce: window.YourSiteCurrency.nonce
                    },
                    success: (response) => {
                        if (response.success) {
                            this.applyPricingToCard($card, response.data);
                            resolve(response.data);
                        } else {
                            reject(new Error(response.data || 'Pricing update failed'));
                        }
                    },
                    error: (xhr, status, error) => {
                        reject(new Error(error));
                    }
                });
            });
        },
        
        /**
         * Apply pricing data to a card element
         */
        applyPricingToCard: function($card, pricingData) {
            const pricing = pricingData.pricing;
            
            // Update monthly prices
            $card.find('.monthly-price, .price-monthly, [data-price-type="monthly"]')
                .text(pricing.monthly.formatted);
            
            // Update annual prices
            $card.find('.annual-price, .price-annual, [data-price-type="annual"]')
                .text(pricing.annual.formatted);
            
            // Update annual monthly equivalent
            $card.find('.annual-monthly-equivalent, .price-annual-monthly')
                .text(pricing.annual.monthly_equivalent.formatted);
            
            // Update savings information
            if (pricing.savings.raw > 0) {
                $card.find('.savings-amount').text(pricing.savings.formatted);
                $card.find('.savings-percentage').text(pricing.savings.percentage + '%');
                $card.find('.savings-container, .savings-badge').show();
            } else {
                $card.find('.savings-container, .savings-badge').hide();
            }
            
            // Update currency symbols
            const symbol = pricingData.currency.symbol || pricingData.currency.code;
            $card.find('.currency-symbol').text(symbol);
            
            // Update data attributes for potential further processing
            $card.attr('data-currency', pricingData.currency_code);
            $card.attr('data-monthly-raw', pricing.monthly.raw);
            $card.attr('data-annual-raw', pricing.annual.raw);
            
            // Add animation class
            $card.addClass('pricing-updated');
            setTimeout(() => {
                $card.removeClass('pricing-updated');
            }, 500);
        },
        
        /**
         * Update individual price elements with data-price attributes
         */
        updateIndividualPrices: function(currencyCode) {
            $('[data-price]').each((index, element) => {
                const $element = $(element);
                const basePrice = parseFloat($element.data('price'));
                const baseCurrency = $element.data('base-currency') || 'USD';
                const priceType = $element.data('price-type') || 'amount';
                
                if (basePrice && baseCurrency !== currencyCode) {
                    this.convertIndividualPrice($element, basePrice, baseCurrency, currencyCode);
                }
            });
        },
        
        /**
         * Convert and display individual price
         */
        convertIndividualPrice: function($element, basePrice, baseCurrency, targetCurrency) {
            $.ajax({
                url: window.YourSiteCurrency.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'convert_currency_price',
                    from_currency: baseCurrency,
                    to_currency: targetCurrency,
                    amount: basePrice,
                    nonce: window.YourSiteCurrency.nonce
                },
                success: (response) => {
                    if (response.success) {
                        $element.text(response.data.formatted_amount);
                        $element.attr('data-converted-price', response.data.converted_amount);
                    }
                }
            });
        },
        
        /**
         * Update currency symbols throughout the page
         */
        updateCurrencySymbols: function(currencyCode) {
            const currency = window.YourSiteCurrency.currencies[currencyCode];
            if (currency) {
                $('.current-currency-code').text(currencyCode);
                $('.current-currency-name').text(currency.name);
                $('.current-currency-symbol').text(currency.symbol || currencyCode);
                $('.current-currency-flag').text(currency.flag || '');
            }
        },
        
        /**
         * Update billing period display
         */
        updateBillingPeriodDisplay: function(period) {
            const $pricingContainer = $('.pricing-container, .pricing-plans');
            
            $pricingContainer.removeClass('show-monthly show-annual');
            $pricingContainer.addClass('show-' + period);
            
            $('.billing-period-toggle').removeClass('active');
            $('.billing-period-toggle[value="' + period + '"], .billing-period-toggle[data-period="' + period + '"]')
                .addClass('active');
            
            // Update price displays based on period
            if (period === 'annual') {
                $('.monthly-price-container').hide();
                $('.annual-price-container').show();
                $('.savings-container').show();
            } else {
                $('.monthly-price-container').show();
                $('.annual-price-container').hide();
                $('.savings-container').hide();
            }
        },
        
        /**
         * Update currency selector UI elements
         */
        updateCurrencySelectors: function(currencyCode) {
            // Update dropdown selectors
            $('.currency-selector').val(currencyCode);
            
            // Update button states
            $('.currency-btn').removeClass('active selected');
            $('.currency-btn[data-currency="' + currencyCode + '"]').addClass('active selected');
            
            // Update current currency displays
            $('.current-currency').text(currencyCode);
            
            // Update any currency flag displays
            const currency = window.YourSiteCurrency.currencies[currencyCode];
            if (currency && currency.flag) {
                $('.current-currency-flag').text(currency.flag);
            }
        },
        
        /**
         * Load available currencies from server
         */
        loadAvailableCurrencies: function() {
            $.ajax({
                url: window.YourSiteCurrency.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'get_available_currencies',
                    nonce: window.YourSiteCurrency.nonce
                },
                success: (response) => {
                    if (response.success) {
                        window.YourSiteCurrency.currencies = {};
                        response.data.currencies.forEach(currency => {
                            window.YourSiteCurrency.currencies[currency.code] = currency;
                        });
                        
                        if (window.YourSiteCurrency.debug) {
                            console.log('Available currencies loaded:', window.YourSiteCurrency.currencies);
                        }
                    }
                }
            });
        },
        
        /**
         * Load saved currency from cookie
         */
        loadSavedCurrency: function() {
            const savedCurrency = this.getCookie(window.YourSiteCurrency.cookieName);
            if (savedCurrency && savedCurrency !== window.YourSiteCurrency.current) {
                window.YourSiteCurrency.current = savedCurrency;
                this.updateCurrencySelectors(savedCurrency);
                
                if (window.YourSiteCurrency.debug) {
                    console.log('Loaded saved currency from cookie:', savedCurrency);
                }
            }
        },
        
        /**
         * Cookie management functions
         */
        setCookie: function(name, value, days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            
            const cookieString = name + '=' + encodeURIComponent(value) + 
                               '; expires=' + expires.toUTCString() + 
                               '; path=/; SameSite=Lax';
            
            document.cookie = cookieString;
            
            if (window.YourSiteCurrency.debug) {
                console.log('Cookie set:', cookieString);
            }
        },
        
        getCookie: function(name) {
            const nameEQ = name + '=';
            const cookies = document.cookie.split(';');
            
            for (let i = 0; i < cookies.length; i++) {
                let cookie = cookies[i].trim();
                if (cookie.indexOf(nameEQ) === 0) {
                    return decodeURIComponent(cookie.substring(nameEQ.length));
                }
            }
            return null;
        },
        
        /**
         * UI feedback functions
         */
        showLoading: function() {
            $('body').addClass('currency-loading');
            $('.pricing-card, .pricing-plan').addClass('updating');
            
            // Show loading overlay
            if (!$('.currency-loading-overlay').length) {
                $('body').append(`
                    <div class="currency-loading-overlay">
                        <div class="currency-spinner">
                            <div class="spinner-icon">💱</div>
                            <div class="spinner-text">Updating prices...</div>
                        </div>
                    </div>
                `);
            }
            $('.currency-loading-overlay').fadeIn(200);
        },
        
        hideLoading: function() {
            $('body').removeClass('currency-loading');
            $('.pricing-card, .pricing-plan').removeClass('updating');
            $('.currency-loading-overlay').fadeOut(200);
        },
        
        showSuccessMessage: function(currencyCode) {
            const currency = window.YourSiteCurrency.currencies[currencyCode];
            const message = currency ? 
                `Currency switched to ${currency.name} (${currencyCode})` :
                `Currency switched to ${currencyCode}`;
            
            this.showToast(message, 'success');
        },
        
        showErrorMessage: function(message) {
            this.showToast(message, 'error');
        },
        
        showToast: function(message, type = 'info') {
            const toastClass = 'currency-toast-' + type;
            const $toast = $(`
                <div class="currency-toast ${toastClass}">
                    <div class="toast-content">
                        <span class="toast-icon">${type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ'}</span>
                        <span class="toast-message">${message}</span>
                    </div>
                </div>
            `);
            
            $('body').append($toast);
            
            // Animate in
            setTimeout(() => {
                $toast.addClass('show');
            }, 100);
            
            // Animate out
            setTimeout(() => {
                $toast.removeClass('show');
                setTimeout(() => {
                    $toast.remove();
                }, 300);
            }, 3000);
        },
        
        /**
         * Utility functions
         */
        refreshPricing: function() {
            this.showLoading();
            this.updateAllPricing()
                .then(() => {
                    this.showSuccessMessage('Prices updated');
                })
                .catch((error) => {
                    this.showErrorMessage('Failed to refresh prices');
                })
                .finally(() => {
                    this.hideLoading();
                });
        },
        
        toggleDebug: function() {
            window.YourSiteCurrency.debug = !window.YourSiteCurrency.debug;
            console.log('Currency debug mode:', window.YourSiteCurrency.debug ? 'enabled' : 'disabled');
        },
        
        getCurrentCurrency: function() {
            return window.YourSiteCurrency.current;
        },
        
        getCurrencyInfo: function(currencyCode) {
            return window.YourSiteCurrency.currencies[currencyCode || window.YourSiteCurrency.current];
        }
    };
    
    // CSS for currency system
    const currencyCSS = `
        <style id="currency-system-styles">
        /* Loading states */
        .currency-loading .pricing-card,
        .currency-loading .pricing-plan {
            pointer-events: none;
        }
        
        .pricing-card.updating,
        .pricing-plan.updating {
            opacity: 0.7;
            transform: scale(0.99);
            transition: all 0.3s ease;
        }
        
        .pricing-updated {
            animation: pricingPulse 0.5s ease;
        }
        
        @keyframes pricingPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        /* Loading overlay */
        .currency-loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }
        
        .currency-spinner {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .spinner-icon {
            font-size: 48px;
            animation: spin 2s linear infinite;
        }
        
        .spinner-text {
            margin-top: 15px;
            font-size: 16px;
            color: #666;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Toast notifications */
        .currency-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 300px;
            padding: 0;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            transform: translateX(400px);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        
        .currency-toast.show {
            transform: translateX(0);
        }
        
        .currency-toast-success {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }
        
        .currency-toast-error {
            background: linear-gradient(135deg, #f44336, #da190b);
            color: white;
        }
        
        .currency-toast-info {
            background: linear-gradient(135deg, #2196F3, #0b7dda);
            color: white;
        }
        
        .toast-content {
            padding: 15px 20px;
            display: flex;
            align-items: center;
        }
        
        .toast-icon {
            font-size: 18px;
            margin-right: 12px;
            font-weight: bold;
        }
        
        .toast-message {
            flex: 1;
            font-size: 14px;
            line-height: 1.4;
        }
        
        /* Currency buttons */
        .currency-btn {
            transition: all 0.2s ease;
            border: 2px solid #e1e5e9;
            background: white;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 6px;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .currency-btn:hover {
            border-color: #667eea;
            background: #f8f9ff;
            transform: translateY(-1px);
        }
        
        .currency-btn.active,
        .currency-btn.selected {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .currency-btn.active:hover,
        .currency-btn.selected:hover {
            background: linear-gradient(135deg, #5a6fd8, #6a42a0);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        /* Currency selector dropdown */
        .currency-selector {
            padding: 10px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 6px;
            background: white;
            min-width: 140px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .currency-selector:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .currency-selector:hover {
            border-color: #667eea;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .currency-toast {
                right: 10px;
                left: 10px;
                min-width: auto;
                transform: translateY(-100px);
            }
            
            .currency-toast.show {
                transform: translateY(0);
            }
            
            .currency-spinner {
                margin: 20px;
                padding: 20px;
            }
            
            .spinner-icon {
                font-size: 36px;
            }
        }
        
        /* Dark mode support */
        body.dark-mode .currency-spinner {
            background: #1f2937;
            color: #f9fafb;
        }
        
        body.dark-mode .currency-btn {
            background: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }
        
        body.dark-mode .currency-btn:hover {
            background: #4b5563;
            border-color: #667eea;
        }
        
        body.dark-mode .currency-selector {
            background: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }
        
        /* Billing period toggles */
        .billing-period-toggle {
            transition: all 0.2s ease;
        }
        
        .billing-period-toggle.active {
            background: #667eea;
            color: white;
        }
        
        /* Savings badges */
        .savings-container {
            transition: all 0.3s ease;
        }
        
        .savings-badge {
            animation: savingsBadgePulse 2s infinite;
        }
        
        @keyframes savingsBadgePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        </style>
    `;
    
    // Inject CSS
    if (!$('#currency-system-styles').length) {
        $('head').append(currencyCSS);
    }
    
    // Initialize when document is ready
    $(document).ready(function() {
        Currency.init();
        
        // Expose Currency object globally for external access
        window.YourSiteCurrency.Currency = Currency;
        
        if (window.YourSiteCurrency.debug) {
            console.log('Currency system ready. Available methods:', Object.keys(Currency));
        }
    });
    
    // Public API
    window.YourSiteCurrency.switchCurrency = function(currencyCode) {
        return Currency.switchCurrency(currencyCode);
    };
    
    window.YourSiteCurrency.getCurrentCurrency = function() {
        return Currency.getCurrentCurrency();
    };
    
    window.YourSiteCurrency.refreshPricing = function() {
        return Currency.refreshPricing();
    };
    
    window.YourSiteCurrency.getCurrencyInfo = function(currencyCode) {
        return Currency.getCurrencyInfo(currencyCode);
    };
    
})(jQuery);

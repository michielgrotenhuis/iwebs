<?php
/**
 * Currency Display Functions
 * File: inc/currency/currency-display.php
 * 
 * Improved version with better JavaScript, performance optimizations,
 * and enhanced error handling.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render currency selector widget
 */
function yoursite_render_currency_selector($args = array()) {
    $defaults = array(
        'style' => 'dropdown', // dropdown, flags, compact
        'show_flag' => true,
        'show_name' => false,
        'show_symbol' => true,
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
    <div class="<?php echo esc_attr($args['container_class']); ?>" 
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
    
    <?php if (!wp_script_is('currency-selector-js', 'enqueued')) : ?>
    <script id="currency-selector-js">
    (function() {
        'use strict';
        
        // Prevent multiple initializations
        if (window.currencySelectorInitialized) return;
        window.currencySelectorInitialized = true;
        
        let isProcessing = false;
        let currencyContainers = null;
        
        document.addEventListener('DOMContentLoaded', function() {
            initCurrencySelector();
        });

        function initCurrencySelector() {
            // Cache DOM elements
            currencyContainers = document.querySelectorAll('.currency-selector-container');
            
            // Single event delegation handler for all currency interactions
            document.addEventListener('click', handleCurrencyClick);
            
            // Keyboard accessibility
            document.addEventListener('keydown', handleCurrencyKeydown);
            
            // Close dropdowns on escape
            document.addEventListener('keyup', function(e) {
                if (e.key === 'Escape') {
                    closeCurrencyDropdowns();
                }
            });
        }
        
        function handleCurrencyClick(e) {
            try {
                // Handle currency selection
                const currencyTarget = e.target.closest('[data-currency-code]');
                if (currencyTarget) {
                    e.preventDefault();
                    switchCurrency(currencyTarget.dataset.currencyCode);
                    return;
                }
                
                // Handle dropdown toggle
                const toggleTarget = e.target.closest('.currency-dropdown-toggle');
                if (toggleTarget) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleCurrencyDropdown(toggleTarget);
                    return;
                }
                
                // Close dropdown when clicking outside
                if (!e.target.closest('.currency-selector-container')) {
                    closeCurrencyDropdowns();
                }
            } catch (error) {
                console.error('Currency click handler error:', error);
            }
        }
        
        function handleCurrencyKeydown(e) {
            if (e.target.closest('.currency-selector-container')) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    e.target.click();
                } else if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    handleArrowNavigation(e);
                }
            }
        }
        
        function handleArrowNavigation(e) {
            const container = e.target.closest('.currency-selector-container');
            if (!container) return;
            
            const dropdown = container.querySelector('.currency-dropdown');
            if (!dropdown || !dropdown.classList.contains('active')) return;
            
            e.preventDefault();
            const items = dropdown.querySelectorAll('[data-currency-code]');
            const currentIndex = Array.from(items).findIndex(item => item === document.activeElement);
            
            let nextIndex;
            if (e.key === 'ArrowDown') {
                nextIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
            } else {
                nextIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
            }
            
            items[nextIndex].focus();
        }
        
        function switchCurrency(currencyCode) {
            if (isProcessing || !currencyCode) return;
            
            isProcessing = true;
            showCurrencyLoadingState();
            
            const requestData = new URLSearchParams({
                action: 'switch_user_currency',
                currency: currencyCode,
                nonce: '<?php echo wp_create_nonce("currency_switch"); ?>'
            });
            
            fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: requestData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    updatePagePricing(currencyCode);
                    updateSelectorState(currencyCode);
                    showNotification(data.data.message || 'Currency updated successfully', 'success');
                } else {
                    throw new Error(data.data || 'Error switching currency');
                }
            })
            .catch(error => {
                console.error('Currency switch error:', error);
                showNotification(error.message || 'Network error occurred', 'error');
            })
            .finally(() => {
                hideCurrencyLoadingState();
                isProcessing = false;
            });
        }
        
        function updatePagePricing(currencyCode) {
            const updates = [];
            
            // Update pricing cards
            const pricingCards = document.querySelectorAll('.pricing-card, .conversion-pricing-card');
            if (pricingCards.length > 0) {
                updates.push(updatePricingCards(currencyCode));
            }
            
            // Update comparison tables
            const comparisonTables = document.querySelectorAll('.pricing-comparison-wrapper');
            if (comparisonTables.length > 0) {
                updates.push(updateComparisonTables(currencyCode));
            }
            
            // Update individual price elements
            const priceElements = document.querySelectorAll('[data-price-plan-id]');
            priceElements.forEach(element => {
                updatePriceElement(element, currencyCode);
            });
            
            // Wait for all updates to complete
            Promise.all(updates).catch(error => {
                console.error('Error updating pricing:', error);
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
                })
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.success && data.data.pricing) {
                    Object.keys(data.data.pricing).forEach(planId => {
                        const pricing = data.data.pricing[planId];
                        updatePlanPricing(planId, pricing);
                    });
                }
            });
        }
        
        function updateComparisonTables(currencyCode) {
            // Placeholder for comparison table updates
            return Promise.resolve();
        }
        
        function updatePriceElement(element, currencyCode) {
            // Placeholder for individual price element updates
        }
        
        function updatePlanPricing(planId, pricing) {
            if (!pricing) return;
            
            try {
                // Update monthly prices
                const monthlySelector = `[data-plan-id="${planId}"] .monthly-price-display, [data-plan-id="${planId}"] .pricing-monthly-pricing`;
                document.querySelectorAll(monthlySelector).forEach(el => {
                    const priceElement = el.querySelector('.price-amount, .text-4xl, .text-5xl');
                    if (priceElement && pricing.monthly_price) {
                        priceElement.textContent = pricing.monthly_price.replace(/[^0-9.,]/g, '');
                    }
                });
                
                // Update annual prices
                const annualSelector = `[data-plan-id="${planId}"] .annual-price-display, [data-plan-id="${planId}"] .pricing-annual-pricing`;
                document.querySelectorAll(annualSelector).forEach(el => {
                    const priceElement = el.querySelector('.price-amount, .text-4xl, .text-5xl');
                    if (priceElement && pricing.annual_monthly_equivalent) {
                        priceElement.textContent = pricing.annual_monthly_equivalent.replace(/[^0-9.,]/g, '');
                    }
                });
                
                // Update savings
                if (pricing.savings) {
                    const savingsSelector = `[data-plan-id="${planId}"] .annual-savings, [data-plan-id="${planId}"] .pricing-annual-savings`;
                    document.querySelectorAll(savingsSelector).forEach(el => {
                        const savingsText = el.querySelector('.savings-amount');
                        if (savingsText) {
                            savingsText.textContent = pricing.savings;
                        }
                    });
                }
            } catch (error) {
                console.error('Error updating plan pricing:', error);
            }
        }
        
        function toggleCurrencyDropdown(toggle) {
            try {
                const container = toggle.closest('.currency-selector-container');
                const dropdown = container.querySelector('.currency-dropdown');
                
                // Close other dropdowns first
                closeCurrencyDropdowns();
                
                if (dropdown) {
                    const isActive = dropdown.classList.toggle('active');
                    toggle.classList.toggle('active', isActive);
                    
                    // Fix ARIA accessibility - don't hide when active and focused
                    toggle.setAttribute('aria-expanded', isActive);
                    if (isActive) {
                        dropdown.removeAttribute('aria-hidden');
                        // Focus first option for keyboard users
                        const firstOption = dropdown.querySelector('[data-currency-code]');
                        if (firstOption) {
                            setTimeout(() => firstOption.focus(), 100);
                        }
                    } else {
                        // Only add aria-hidden if no element inside has focus
                        setTimeout(() => {
                            if (!dropdown.contains(document.activeElement)) {
                                dropdown.setAttribute('aria-hidden', 'true');
                            }
                        }, 100);
                    }
                }
            } catch (error) {
                console.error('Error toggling dropdown:', error);
            }
        }
        
        function closeCurrencyDropdowns() {
            if (!currencyContainers) return;
            
            currencyContainers.forEach(container => {
                const dropdown = container.querySelector('.currency-dropdown.active');
                const toggle = container.querySelector('.currency-dropdown-toggle.active');
                
                if (dropdown) {
                    dropdown.classList.remove('active');
                    // Only add aria-hidden if no element inside has focus
                    if (!dropdown.contains(document.activeElement)) {
                        dropdown.setAttribute('aria-hidden', 'true');
                    }
                }
                if (toggle) {
                    toggle.classList.remove('active');
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        }
        
        function updateSelectorState(currencyCode) {
            if (!currencyContainers) return;
            
            currencyContainers.forEach(container => {
                try {
                    // Update active states
                    container.querySelectorAll('[data-currency-code]').forEach(item => {
                        const isActive = item.dataset.currencyCode === currencyCode;
                        item.classList.toggle('active', isActive);
                        item.setAttribute('aria-current', isActive ? 'true' : 'false');
                    });
                    
                    // Update dropdown toggle display
                    const toggle = container.querySelector('.currency-dropdown-toggle');
                    const newActive = container.querySelector(`[data-currency-code="${currencyCode}"]`);
                    
                    if (toggle && newActive) {
                        const toggleFlag = toggle.querySelector('.currency-flag');
                        const toggleCode = toggle.querySelector('.currency-code');
                        const newFlag = newActive.querySelector('.currency-flag');
                        const newCode = newActive.querySelector('.currency-code');
                        
                        if (toggleFlag && newFlag) toggleFlag.textContent = newFlag.textContent;
                        if (toggleCode && newCode) toggleCode.textContent = newCode.textContent;
                    }
                } catch (error) {
                    console.error('Error updating selector state:', error);
                }
            });
            
            // Close dropdowns
            closeCurrencyDropdowns();
        }
        
        function showCurrencyLoadingState() {
            if (!currencyContainers) return;
            
            currencyContainers.forEach(container => {
                container.classList.add('loading');
                container.setAttribute('aria-busy', 'true');
            });
        }
        
        function hideCurrencyLoadingState() {
            if (!currencyContainers) return;
            
            currencyContainers.forEach(container => {
                container.classList.remove('loading');
                container.setAttribute('aria-busy', 'false');
            });
        }
        
        function showNotification(message, type = 'success') {
            // Remove existing notifications
            document.querySelectorAll('.currency-notification').forEach(n => n.remove());
            
            const notification = document.createElement('div');
            notification.className = `currency-notification ${type}`;
            notification.textContent = message;
            notification.setAttribute('role', 'alert');
            notification.setAttribute('aria-live', 'polite');
            
            // Improved styling
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
                transition: 'all 0.3s ease',
                transform: 'translateX(100%)',
                opacity: '0'
            });
            
            document.body.appendChild(notification);
            
            // Animate in
            requestAnimationFrame(() => {
                notification.style.transform = 'translateX(0)';
                notification.style.opacity = '1';
            });
            
            // Auto remove
            const timeout = type === 'error' ? 5000 : 3000;
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, timeout);
        }
        
        // Public API
        window.currencySelector = {
            switch: switchCurrency,
            close: closeCurrencyDropdowns,
            showNotification: showNotification
        };
        
    })();
    </script>
    
    <style id="currency-selector-styles">
    .currency-selector-container{position:relative;display:inline-block;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif}.currency-selector-container.loading{opacity:0.7;pointer-events:none}.currency-selector-container[aria-busy="true"]::after{content:'';position:absolute;top:50%;right:8px;width:12px;height:12px;border:2px solid #ccc;border-top-color:#007cba;border-radius:50%;animation:spin 1s linear infinite;transform:translateY(-50%)}@keyframes spin{to{transform:translateY(-50%) rotate(360deg)}}.currency-dropdown-toggle{display:flex;align-items:center;gap:8px;padding:10px 14px;background:#fff;border:1px solid #dddde3;border-radius:8px;cursor:pointer;font-size:14px;font-weight:500;transition:all 0.2s ease;outline:none;position:relative;min-width:120px}.currency-dropdown-toggle:hover{border-color:#007cba;box-shadow:0 2px 4px rgba(0,0,0,0.1)}.currency-dropdown-toggle:focus{border-color:#007cba;box-shadow:0 0 0 2px rgba(0,124,186,0.2)}.currency-dropdown-toggle.active{border-color:#007cba;box-shadow:0 2px 8px rgba(0,0,0,0.15)}.currency-dropdown-toggle .currency-chevron{margin-left:auto;transition:transform 0.2s ease}.currency-dropdown-toggle.active .currency-chevron{transform:rotate(180deg)}.currency-dropdown{position:absolute;top:100%;left:0;right:0;background:#fff;border:1px solid #dddde3;border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,0.15);z-index:1000;margin-top:4px;opacity:0;visibility:hidden;transform:translateY(-8px);transition:all 0.2s ease;max-height:300px;overflow-y:auto}.currency-dropdown.active{opacity:1;visibility:visible;transform:translateY(0)}.currency-dropdown-item{display:flex;align-items:center;gap:10px;padding:12px 16px;text-decoration:none;color:#1e1e1e;border-bottom:1px solid #f6f7f7;transition:all 0.15s ease;cursor:pointer;outline:none}.currency-dropdown-item:last-child{border-bottom:none}.currency-dropdown-item:hover,.currency-dropdown-item:focus{background:#f6f7f7;color:#007cba}.currency-dropdown-item.active{background:#e7f3ff;color:#005177;font-weight:600}.currency-dropdown-item .currency-flag{font-size:16px;width:20px;text-align:center}.currency-dropdown-item .currency-code{font-weight:500;min-width:40px}.currency-flags-selector{display:flex;gap:4px;flex-wrap:wrap}.currency-flag-item{display:flex;align-items:center;gap:6px;padding:8px 12px;background:#fff;border:1px solid #dddde3;border-radius:6px;text-decoration:none;color:#1e1e1e;font-size:13px;font-weight:500;transition:all 0.2s ease;cursor:pointer;outline:none}.currency-flag-item:hover,.currency-flag-item:focus{border-color:#007cba;box-shadow:0 2px 4px rgba(0,0,0,0.1);transform:translateY(-1px)}.currency-flag-item.active{background:#007cba;border-color:#005177;color:#fff;box-shadow:0 2px 8px rgba(0,124,186,0.3)}.currency-compact-selector{display:flex;background:#fff;border:1px solid #dddde3;border-radius:6px;overflow:hidden}.currency-compact-item{padding:10px 14px;cursor:pointer;transition:all 0.2s ease;text-decoration:none;color:#1e1e1e;border-right:1px solid #dddde3;font-size:13px;font-weight:500;display:flex;align-items:center;gap:6px;outline:none}.currency-compact-item:last-child{border-right:none}.currency-compact-item:hover,.currency-compact-item:focus{background:#f6f7f7;color:#007cba}.currency-compact-item.active{background:#007cba;color:#fff}.currency-notification{position:fixed;top:20px;right:20px;padding:14px 18px;border-radius:8px;color:#fff;font-weight:500;font-size:14px;z-index:10000;max-width:350px;box-shadow:0 4px 16px rgba(0,0,0,0.15)}.currency-notification.success{background:linear-gradient(135deg,#46b450 0%,#5cbf60 100%)}.currency-notification.error{background:linear-gradient(135deg,#dc3232 0%,#e74c3c 100%)}@media (prefers-color-scheme:dark){.currency-dropdown-toggle,.currency-dropdown,.currency-flag-item,.currency-compact-selector{background:#1e1e1e;border-color:#3c4043;color:#e8eaed}.currency-dropdown-item{color:#e8eaed;border-bottom-color:#3c4043}.currency-dropdown-item:hover,.currency-dropdown-item:focus,.currency-flag-item:hover,.currency-flag-item:focus,.currency-compact-item:hover,.currency-compact-item:focus{background:#3c4043;color:#8ab4f8}.currency-dropdown-item.active{background:#1a472a;color:#81c995}.currency-flag-item.active,.currency-compact-item.active{background:#1a73e8;border-color:#185abc}}@media (max-width:768px){.currency-dropdown{min-width:200px;right:0;left:auto}.currency-flags-selector{gap:4px}.currency-flag-item{padding:6px 10px;font-size:12px}.currency-notification{left:16px;right:16px;top:16px;text-align:center}.currency-dropdown-toggle{min-width:100px;padding:8px 12px}}@media (prefers-contrast:high){.currency-dropdown-toggle,.currency-dropdown-item,.currency-flag-item,.currency-compact-item{border-width:2px}.currency-dropdown-toggle:focus,.currency-dropdown-item:focus,.currency-flag-item:focus,.currency-compact-item:focus{outline:3px solid;outline-offset:2px}}@media (prefers-reduced-motion:reduce){.currency-dropdown-toggle,.currency-dropdown,.currency-dropdown-item,.currency-flag-item,.currency-compact-item,.currency-notification{transition:none}.currency-dropdown-toggle .currency-chevron{transition:none}}
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
    <button class="currency-dropdown-toggle <?php echo esc_attr($args['class']); ?>" 
            type="button"
            aria-expanded="false"
            aria-haspopup="listbox"
            aria-label="<?php esc_attr_e('Select currency', 'yoursite'); ?>">
        
        <?php if ($args['show_flag']) : ?>
            <span class="currency-flag" aria-hidden="true"><?php echo esc_html($current_currency['flag']); ?></span>
        <?php endif; ?>
        
        <span class="currency-code"><?php echo esc_html($current_currency['code']); ?></span>
        
        <?php if ($args['show_name']) : ?>
            <span class="currency-name"><?php echo esc_html($current_currency['name']); ?></span>
        <?php endif; ?>
        
        <?php if ($args['show_symbol']) : ?>
            <span class="currency-symbol"><?php echo esc_html($current_currency['symbol']); ?></span>
        <?php endif; ?>
        
        <svg class="currency-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <polyline points="6,9 12,15 18,9"></polyline>
        </svg>
    </button>
    
    <div class="currency-dropdown" 
         role="listbox" 
         aria-hidden="true"
         aria-label="<?php esc_attr_e('Currency options', 'yoursite'); ?>">
        <?php foreach ($currencies as $currency) : ?>
            <a href="#" 
               class="currency-dropdown-item <?php echo $currency['code'] === $current_currency['code'] ? 'active' : ''; ?>"
               data-currency-code="<?php echo esc_attr($currency['code']); ?>"
               role="option"
               aria-current="<?php echo $currency['code'] === $current_currency['code'] ? 'true' : 'false'; ?>"
               aria-label="<?php echo esc_attr(sprintf(__('Switch to %s (%s)', 'yoursite'), $currency['name'], $currency['code'])); ?>"
               tabindex="0">
                
                <?php if ($args['show_flag']) : ?>
                    <span class="currency-flag" aria-hidden="true"><?php echo esc_html($currency['flag']); ?></span>
                <?php endif; ?>
                
                <span class="currency-code"><?php echo esc_html($currency['code']); ?></span>
                
                <?php if ($args['show_name']) : ?>
                    <span class="currency-name"><?php echo esc_html($currency['name']); ?></span>
                <?php endif; ?>
                
                <?php if ($args['show_symbol']) : ?>
                    <span class="currency-symbol"><?php echo esc_html($currency['symbol']); ?></span>
                <?php endif; ?>
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
               data-currency-code="<?php echo esc_attr($currency['code']); ?>"
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
               data-currency-code="<?php echo esc_attr($currency['code']); ?>"
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
            'style' => $instance['style'] ?? 'dropdown',
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
        $instance['title'] = sanitize_text_field($new_instance['title'] ?? '');
        $instance['style'] = in_array($new_instance['style'] ?? '', ['dropdown', 'flags', 'compact']) ? $new_instance['style'] : 'dropdown';
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
    if (!in_array($atts['style'], ['dropdown', 'flags', 'compact'])) {
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
 * Add currency selector to header with improved integration
 */
function yoursite_add_currency_selector_to_header() {
    if (!yoursite_should_display_currency_selector()) {
        return;
    }
    
    $settings = get_option('yoursite_currency_settings', array());
    
    if ($settings['show_in_header'] ?? true) {
        echo '<div class="header-currency-selector" role="navigation" aria-label="' . esc_attr__('Currency selection', 'yoursite') . '">';
        echo yoursite_render_currency_selector(array(
            'style' => $settings['header_style'] ?? 'compact',
            'show_flag' => $settings['header_show_flag'] ?? true,
            'show_name' => false,
            'show_symbol' => false,
            'class' => 'header-currency-selector-widget'
        ));
        echo '</div>';
    }
}

/**
 * Add currency selector to footer with improved integration
 */
function yoursite_add_currency_selector_to_footer() {
    if (!yoursite_should_display_currency_selector()) {
        return;
    }
    
    $settings = get_option('yoursite_currency_settings', array());
    
    if ($settings['show_in_footer'] ?? true) {
        echo '<div class="footer-currency-selector" role="navigation" aria-label="' . esc_attr__('Currency selection', 'yoursite') . '">';
        echo '<span class="currency-selector-label">' . esc_html__('Currency:', 'yoursite') . ' </span>';
        echo yoursite_render_currency_selector(array(
            'style' => $settings['footer_style'] ?? 'dropdown',
            'show_flag' => $settings['footer_show_flag'] ?? true,
            'show_name' => false,
            'show_symbol' => $settings['footer_show_symbol'] ?? true,
            'class' => 'footer-currency-selector-widget'
        ));
        echo '</div>';
    }
}

/**
 * Enhanced pricing display with currency context
 */
function yoursite_pricing_with_currency_context($plan_id, $show_all_currencies = false) {
    if (!$plan_id) {
        return '';
    }
    
    $current_currency = yoursite_get_user_currency();
    $cache_key = "pricing_context_{$plan_id}_{$current_currency['code']}_" . ($show_all_currencies ? 'all' : 'single');
    $cached_output = wp_cache_get($cache_key, 'yoursite_pricing');
    
    if ($cached_output !== false) {
        return $cached_output;
    }
    
    $monthly_price = yoursite_get_pricing_plan_price($plan_id, $current_currency['code'], 'monthly');
    $annual_price = yoursite_get_pricing_plan_price($plan_id, $current_currency['code'], 'annual');
    
    ob_start();
    ?>
    <div class="pricing-with-currency-context" 
         data-plan-id="<?php echo esc_attr($plan_id); ?>"
         data-currency="<?php echo esc_attr($current_currency['code']); ?>">
        
        <!-- Current Currency Pricing -->
        <div class="current-currency-pricing">
            <div class="currency-header">
                <span class="currency-flag" aria-hidden="true"><?php echo esc_html($current_currency['flag']); ?></span>
                <span class="currency-name"><?php echo esc_html($current_currency['name']); ?></span>
                <span class="currency-code">(<?php echo esc_html($current_currency['code']); ?>)</span>
            </div>
            
            <div class="pricing-display">
                <?php if ($monthly_price > 0) : ?>
                    <div class="monthly-pricing" role="text" aria-label="<?php echo esc_attr(sprintf(__('Monthly price: %s', 'yoursite'), yoursite_format_currency($monthly_price, $current_currency['code']))); ?>">
                        <span class="price"><?php echo yoursite_format_currency($monthly_price, $current_currency['code']); ?></span>
                        <span class="period">/<?php esc_html_e('month', 'yoursite'); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($annual_price > 0) : ?>
                    <div class="annual-pricing" role="text" aria-label="<?php echo esc_attr(sprintf(__('Annual price: %s per month, billed annually', 'yoursite'), yoursite_format_currency($annual_price / 12, $current_currency['code']))); ?>">
                        <span class="price"><?php echo yoursite_format_currency($annual_price / 12, $current_currency['code']); ?></span>
                        <span class="period">/<?php esc_html_e('month', 'yoursite'); ?></span>
                        <span class="billing-note"><?php esc_html_e('billed annually', 'yoursite'); ?></span>
                        
                        <?php 
                        $savings = yoursite_calculate_annual_savings($plan_id, $current_currency['code']);
                        if ($savings > 0) : ?>
                            <div class="savings" role="text" aria-label="<?php echo esc_attr(sprintf(__('You save %s per year', 'yoursite'), yoursite_format_currency($savings, $current_currency['code']))); ?>">
                                <?php printf(esc_html__('Save %s per year', 'yoursite'), yoursite_format_currency($savings, $current_currency['code'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if ($show_all_currencies) : ?>
            <!-- All Currencies -->
            <div class="all-currencies-pricing">
                <h4><?php esc_html_e('Pricing in Other Currencies', 'yoursite'); ?></h4>
                <div class="currency-pricing-grid" role="table" aria-label="<?php esc_attr_e('Pricing in different currencies', 'yoursite'); ?>">
                    <?php 
                    $active_currencies = yoursite_get_active_currencies();
                    foreach ($active_currencies as $currency) :
                        if ($currency['code'] === $current_currency['code']) continue;
                        
                        $curr_monthly = yoursite_get_pricing_plan_price($plan_id, $currency['code'], 'monthly');
                        if ($curr_monthly <= 0) continue;
                    ?>
                        <div class="currency-pricing-row" role="row">
                            <span class="currency-info" role="cell">
                                <span aria-hidden="true"><?php echo esc_html($currency['flag']); ?></span>
                                <span><?php echo esc_html($currency['code']); ?></span>
                            </span>
                            <span class="price" role="cell">
                                <?php echo yoursite_format_currency($curr_monthly, $currency['code']); ?>/<?php esc_html_e('mo', 'yoursite'); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
    <?php
    
    $output = ob_get_clean();
    
    // Cache the output for 5 minutes
    wp_cache_set($cache_key, $output, 'yoursite_pricing', 300);
    
    return $output;
}

/**
 * AJAX handler registration with improved security
 */
function yoursite_register_currency_ajax_handlers() {
    // For logged-in users
    add_action('wp_ajax_switch_user_currency', 'yoursite_ajax_switch_currency');
    add_action('wp_ajax_get_all_pricing_in_currency', 'yoursite_ajax_get_pricing');
    
    // For non-logged-in users (if needed)
    add_action('wp_ajax_nopriv_switch_user_currency', 'yoursite_ajax_switch_currency');
    add_action('wp_ajax_nopriv_get_all_pricing_in_currency', 'yoursite_ajax_get_pricing');
}
add_action('init', 'yoursite_register_currency_ajax_handlers');

/**
 * Enhanced AJAX handler for currency switching
 */
function yoursite_ajax_switch_currency() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'currency_switch')) {
        wp_send_json_error(__('Invalid security token', 'yoursite'));
        return;
    }
    
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (empty($currency_code)) {
        wp_send_json_error(__('Currency code is required', 'yoursite'));
        return;
    }
    
    // Validate currency code
    $active_currencies = yoursite_get_active_currencies();
    $valid_currency = false;
    
    foreach ($active_currencies as $currency) {
        if ($currency['code'] === $currency_code) {
            $valid_currency = true;
            break;
        }
    }
    
    if (!$valid_currency) {
        wp_send_json_error(__('Invalid currency code', 'yoursite'));
        return;
    }
    
    // Switch the currency
    $result = yoursite_set_user_currency($currency_code);
    
    if ($result) {
        // Clear relevant caches
        wp_cache_flush_group('yoursite_pricing');
        
        wp_send_json_success(array(
            'message' => sprintf(__('Currency switched to %s', 'yoursite'), $currency_code),
            'currency' => $currency_code
        ));
    } else {
        wp_send_json_error(__('Failed to switch currency', 'yoursite'));
    }
}

/**
 * Enhanced AJAX handler for getting pricing data
 */
function yoursite_ajax_get_pricing() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'get_pricing')) {
        wp_send_json_error(__('Invalid security token', 'yoursite'));
        return;
    }
    
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (empty($currency_code)) {
        wp_send_json_error(__('Currency code is required', 'yoursite'));
        return;
    }
    
    try {
        $pricing_data = yoursite_get_all_pricing_data($currency_code);
        
        wp_send_json_success(array(
            'pricing' => $pricing_data,
            'currency' => $currency_code
        ));
    } catch (Exception $e) {
        wp_send_json_error(__('Failed to retrieve pricing data', 'yoursite'));
    }
}

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

// Hook functions to appropriate actions based on theme/plugin configuration
// These can be called from theme files or hooked to specific actions
// add_action('wp_head', 'yoursite_add_currency_selector_to_header');
// add_action('wp_footer', 'yoursite_add_currency_selector_to_footer');
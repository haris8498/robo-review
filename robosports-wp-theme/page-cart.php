<?php
/**
 * Template Name: Cart Page
 * The template for displaying the cart page
 */

get_header(); ?>

<style>
/* Added comprehensive CSS styling for cart page */
.cart-wrapper {
    background: linear-gradient(135deg, #070a11 0%, #0f1419 100%);
    min-height: 100vh;
    padding-top: 120px;
}

.cart-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.cart-header {
    text-align: center;
    margin-bottom: 3rem;
}

.cart-title {
    font-size: 3rem;
    font-weight: bold;
    color: white;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.cart-table {
    background: rgba(17, 24, 39, 0.8);
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(55, 65, 81, 0.3);
}

.cart-table-header {
    background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
    padding: 1.5rem;
    border-bottom: 1px solid rgba(55, 65, 81, 0.3);
}

.cart-item {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(55, 65, 81, 0.2);
    transition: all 0.3s ease;
}

.cart-item:hover {
    background: rgba(31, 41, 55, 0.5);
}

.cart-item:last-child {
    border-bottom: none;
}

.product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.product-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 0.5rem;
}

.product-variations {
    color: #9ca3af;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.remove-link {
    color: #ef4444;
    font-size: 0.875rem;
    text-decoration: underline;
    transition: color 0.2s ease;
}

.remove-link:hover {
    color: #dc2626;
}

.quantity-input {
    background: #374151;
    color: #ffffff;
    border: 1px solid #4b5563;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    width: 80px;
    text-align: center;
    font-weight: 600;
}

.quantity-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.cart-actions {
    background: rgba(31, 41, 55, 0.8);
    padding: 1.5rem;
    border-top: 1px solid rgba(55, 65, 81, 0.3);
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    justify-content: center;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.btn-clear {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
}

.btn-clear:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
}

.btn-finalize {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    font-size: 1.25rem;
    padding: 1rem 2rem;
}

.btn-finalize:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.empty-cart {
    text-align: center;
    padding: 5rem 2rem;
}

.empty-cart-icon {
    font-size: 5rem;
    margin-bottom: 2rem;
}

.empty-cart-title {
    font-size: 2rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 1rem;
}

.empty-cart-text {
    color: #9ca3af;
    font-size: 1.125rem;
    margin-bottom: 2rem;
}

.security-note {
    text-align: center;
    margin-top: 1rem;
    color: #9ca3af;
    font-size: 0.875rem;
}

/* Added modal styling */
#user-info-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px);
}

/* Enhanced modal container with better styling and animations */
#user-info-modal > div {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    border-radius: 1.5rem;
    padding: 2.5rem;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(55, 65, 81, 0.3);
    transform: scale(0.95);
    animation: modalFadeIn 0.3s ease-out forwards;
}

@keyframes modalFadeIn {
    to {
        transform: scale(1);
    }
}

/* Enhanced modal title with better typography */
#user-info-modal h3 {
    color: #ffffff;
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    letter-spacing: -0.025em;
}

/* Enhanced form field groups with better spacing */
#user-info-modal form > div:not(:last-child) {
    margin-bottom: 1.5rem;
}

/* Improved label styling */
#user-info-modal label {
    display: block;
    color: #f3f4f6;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
    letter-spacing: 0.025em;
}

/* Enhanced input field styling with better focus states */
#user-info-modal input {
    width: 100%;
    padding: 1rem 1.25rem;
    border-radius: 0.75rem;
    border: 2px solid #374151;
    background: #374151;
    color: #ffffff;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
}

#user-info-modal input:focus {
    outline: none;
    border-color: #3b82f6;
    background: #4b5563;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), inset 0 2px 4px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

#user-info-modal input::placeholder {
    color: #9ca3af;
    opacity: 0.8;
}

/* Enhanced button container with better layout */
#user-info-modal form > div:last-child {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(55, 65, 81, 0.3);
}

/* Improved cancel button styling */
#user-info-modal #cancel-order-btn {
    height: auto;
    width: auto;
    padding: 0.875rem 1.5rem;
    border-radius: 0.75rem;
    border: 2px solid #4b5563;
    background: transparent;
    color: #d1d5db;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

#user-info-modal #cancel-order-btn:hover {
    border-color: #6b7280;
    background: rgba(75, 85, 99, 0.2);
    color: #ffffff;
    transform: translateY(-1px);
}

/* Enhanced confirm button with better styling */
#user-info-modal .btn-finalize {
    margin: 0;
    padding: 0.875rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    position: relative;
    overflow: hidden;
}

#user-info-modal .btn-finalize:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
    transform: translateY(-2px);
}

#user-info-modal .btn-finalize:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
}

/* Enhanced loading states with better animations */
#user-info-modal .confirm-loading,
#user-info-modal .confirm-text {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
}

#user-info-modal .fa-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Mobile responsiveness improvements */
@media (max-width: 640px) {
    #user-info-modal > div {
        padding: 2rem 1.5rem;
        margin: 1rem;
        width: calc(100% - 2rem);
    }
    
    #user-info-modal h3 {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    #user-info-modal form > div:last-child {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    #user-info-modal #cancel-order-btn,
    #user-info-modal .btn-finalize {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .cart-container {
        padding: 1rem;
    }
    
    .cart-title {
        font-size: 2rem;
    }
    
    .cart-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

/* Hide WooCommerce add to cart notifications */
.woocommerce-message,
.woocommerce-info,
.woocommerce-error,
.wc-block-components-notice-banner,
.woocommerce-notices-wrapper,
.woocommerce .woocommerce-message,
.woocommerce .woocommerce-info,
.woocommerce .woocommerce-error,
div.woocommerce > .woocommerce-message,
div.woocommerce > .woocommerce-info,
div.woocommerce > .woocommerce-error {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    height: 0 !important;
    overflow: hidden !important;
}
</style>

<main id="main" class="site-main">
    
    <?php
    // Check if WooCommerce is active
    if (class_exists('WooCommerce')) {
        // Force start session if not already started
        if (!session_id()) {
            session_start();
        }
        
        // Initialize WooCommerce
        WC();
        
        // Ensure session is properly set
        if (!WC()->session->has_session()) {
            WC()->session->set_customer_session_cookie(true);
        }
        
        // Force load cart from session
        wc_load_cart();
        
        // Get cart from session if it exists
        if (WC()->session->get('cart')) {
            WC()->cart->get_cart_from_session();
        }
        
        // Set cart cookies
        WC()->cart->maybe_set_cart_cookies();
        
        // Calculate totals
        WC()->cart->calculate_totals();
        
        wp_enqueue_script('jquery');
        wp_localize_script('jquery', 'ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('finalize_order_nonce'),
            'clear_nonce' => wp_create_nonce('clear_cart_nonce')
        ));
        
        // Include the cart template with enhanced functionality
        do_action('woocommerce_before_cart');
        ?>

        <div class="cart-wrapper">
            <div class="cart-container">
                
                <!-- Updated header styling with proper CSS classes -->
                <?php 
                WC()->cart->get_cart_from_session();
                WC()->cart->maybe_set_cart_cookies();
                $cart_is_empty = WC()->cart->is_empty();
                $cart_count = WC()->cart->get_cart_contents_count();
                ?>
                
                <div class="cart-header">
                    <h1 class="cart-title">
                        Your Cart (<?php echo $cart_count; ?> items)
                    </h1>
                </div>

                <?php if ($cart_is_empty) : ?>
                    <!-- Enhanced empty cart design with proper CSS classes -->
                    <div class="empty-cart">
                        <div class="empty-cart-icon">🛒</div>
                        <h2 class="empty-cart-title">Your cart is currently empty!</h2>
                        <p class="empty-cart-text">Add some products to get started.</p>
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" 
                           class="btn btn-finalize">
                            Continue Shopping
                        </a>
                    </div>
                <?php else : ?>
                    <!-- Enhanced cart table with proper CSS styling -->
                    <div class="cart-table">
                        <!-- Table Header -->
                        <div class="cart-table-header">
                            <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: center;">
                                <div>
                                    <h3 style="color: #ffffff; font-size: 1.125rem; font-weight: 600; margin: 0;">Item</h3>
                                </div>
                                <div style="text-align: center;">
                                    <h3 style="color: #ffffff; font-size: 1.125rem; font-weight: 600; margin: 0;">Quantity</h3>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Cart Items -->
                        <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                            <?php do_action('woocommerce_before_cart_table'); ?>
                            
                            <div>
                                <?php
                                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                        ?>
                                        <!-- Enhanced cart item row with proper styling -->
                                        <div class="cart-item">
                                            <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: center;">
                                                <!-- Product Name Column -->
                                                <div style="display: flex; align-items: center; gap: 1rem;">
                                                    <!-- Product image -->
                                                    <div style="flex-shrink: 0;">
                                                        <?php
                                                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail', array('class' => 'product-image')), $cart_item, $cart_item_key);
                                                        if (!$product_permalink) {
                                                            echo $thumbnail;
                                                        } else {
                                                            printf('<a href="%s" style="display: block; transition: opacity 0.2s;">%s</a>', esc_url($product_permalink), $thumbnail);
                                                        }
                                                        ?>
                                                    </div>
                                                    
                                                    <!-- Product name and details -->
                                                    <div style="flex: 1; min-width: 0;">
                                                        <h4 class="product-name">
                                                            <?php
                                                            echo wp_kses_post(apply_filters(
                                                                'woocommerce_cart_item_name',
                                                                 sprintf('<a href="%s" style="color: white !important; text-decoration: none">%s</a>', esc_url($product_permalink), $_product->get_name()),
                                                                $cart_item,
                                                                $cart_item_key
                                                            ));
                                                            ?>
                                                        </h4>
                                                        
                                                        <!-- Product variations if any -->
                                                        <?php 
                                                        $product_variations = wc_get_formatted_cart_item_data($cart_item);
                                                        if ($product_variations) : 
                                                        ?>
                                                            <div class="product-variations">
                                                                <?php echo $product_variations; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <!-- Remove link -->
                                                        <div style="margin-top: 0.5rem;">
                                                            <?php
                                                            echo apply_filters(
                                                                'woocommerce_cart_item_remove_link',
                                                                sprintf(
                                                                    '<a href="%s" class="remove-link" aria-label="%s">Remove</a>',
                                                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                                    esc_html__('Remove this item', 'woocommerce')
                                                                ),
                                                                $cart_item_key
                                                            );
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Quantity Column -->
                                                <div style="text-align: center;">
                                                    <?php
                                                    if ($_product->is_sold_individually()) {
                                                        echo '<span class="quantity-input" style="display: inline-block; background: #374151; color: #ffffff; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600;">1</span>';
                                                        echo '<input type="hidden" name="cart[' . $cart_item_key . '][qty]" value="1" />';
                                                    } else {
                                                        $product_quantity = woocommerce_quantity_input(
                                                            array(
                                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                                'input_value'  => $cart_item['quantity'],
                                                                'max_value'    => $_product->get_max_purchase_quantity(),
                                                                'min_value'    => '0',
                                                                'product_name' => $_product->get_name(),
                                                                'classes'      => array('quantity-input')
                                                            ),
                                                            $_product,
                                                            false
                                                        );
                                                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            
                            <!-- Enhanced cart actions with three buttons -->
                            <div class="cart-actions">
                                <!-- Clear Cart Button -->
                                <button type="button" 
                                        id="clear-cart-btn"
                                        class="btn btn-clear">
                                    Clear Cart
                                </button>
                                
                                <!-- Finalize Order Button -->
                                <button type="button" 
                                        id="finalize-order-btn"
                                        class="btn btn-finalize">
                                    <span class="button-text">
                                        Finalize Order
                                    </span>
                                    <span class="loading-text" style="display: none;">
                                        <i class="fas fa-spinner fa-spin"></i>Processing...
                                    </span>
                                </button>
                            </div>
                            
                            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                        </form>
                    </div>
                    
                    <!-- User Information Modal -->
                    <div id="user-info-modal">
                        <div>
                            <h3>Complete Your Order</h3>
                            
                            <form id="user-info-form">
                                <div>
                                    <label for="customer-name">Full Name *</label>
                                    <input type="text" 
                                           id="customer-name" 
                                           name="customer_name" 
                                           required
                                           placeholder="Enter your full name">
                                </div>
                                
                                <div>
                                    <label for="customer-phone">Phone Number *</label>
                                    <input type="tel" 
                                           id="customer-phone" 
                                           name="customer_phone" 
                                           required
                                           placeholder="Enter your phone number">
                                </div>
                                
                                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                                    <button type="button" 
                                            id="cancel-order-btn">
                                        Cancel
                                    </button>
                                    <button type="submit" 
                                            id="confirm-order-btn"
                                            class="btn btn-finalize">
                                        <span class="confirm-text">
                                            Confirm Order
                                        </span>
                                        <span class="confirm-loading" style="display: none;">
                                            <i class="fas fa-spinner fa-spin"></i>Creating Order...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Added security note -->
                    <div class="security-note">
                        <i class="fas fa-shield-alt"></i> Secure checkout guaranteed
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <script type="text/javascript">
            var ajax_object = {
                ajax_url: "<?php echo admin_url('admin-ajax.php'); ?>",
                nonce: "<?php echo wp_create_nonce('finalize_order_nonce'); ?>",
                clear_nonce: "<?php echo wp_create_nonce('clear_cart_nonce'); ?>"
            };
        </script>

        <script>        
        document.addEventListener('DOMContentLoaded', function() {
            const finalizeBtn = document.getElementById('finalize-order-btn');
            const clearBtn = document.getElementById('clear-cart-btn');
            const modal = document.getElementById('user-info-modal');
            const userForm = document.getElementById('user-info-form');
            const cancelBtn = document.getElementById('cancel-order-btn');
            const confirmBtn = document.getElementById('confirm-order-btn');
            
            if (finalizeBtn) {
                finalizeBtn.addEventListener('click', function() {
                    modal.style.display = 'flex';
                });
            }
            
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                    userForm.reset();
                });
            }
            
            if (userForm) {
                userForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const customerName = document.getElementById('customer-name').value.trim();
                    const customerPhone = document.getElementById('customer-phone').value.trim();
                    
                    if (!customerName || !customerPhone) {
                        alert('Please fill in all required fields.');
                        return;
                    }
                                                    
                    const confirmText = confirmBtn.querySelector('.confirm-text');
                    const confirmLoading = confirmBtn.querySelector('.confirm-loading');
                    
                    confirmText.style.display = 'none';
                    confirmLoading.style.display = 'flex';
                    confirmBtn.disabled = true;
                    
                    jQuery.ajax({
                        url: ajax_object.ajax_url,
                        type: 'POST',
                        data: {
                            action: 'finalize_order_direct',
                            security: ajax_object.nonce,
                            customer_name: customerName,
                            customer_phone: customerPhone
                        },
                        success: function(response) {
                            if (response.success) {
                                confirmText.innerHTML = '<i class="fas fa-check"></i>Order Created!';
                                confirmText.style.display = 'flex';
                                confirmLoading.style.display = 'none';
                                
                                alert('✅ Your order has been submitted successfully!');

                                modal.style.display = 'none';
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            } else {
                                confirmText.innerHTML = '<i class="fas fa-exclamation-triangle"></i>Error';
                                confirmText.style.display = 'flex';
                                confirmLoading.style.display = 'none';
                                confirmBtn.disabled = false;
                                
                                alert('Error: ' + (response.data.message || 'Please try again'));
                                
                                setTimeout(() => {
                                    confirmText.innerHTML = '<i class="fas fa-check"></i>Confirm Order';
                                }, 3000);
                            }
                        },
                        error: function(xhr, status, error) {
                            confirmText.innerHTML = '<i class="fas fa-exclamation-triangle"></i>Network Error';
                            confirmText.style.display = 'flex';
                            confirmLoading.style.display = 'none';
                            confirmBtn.disabled = false;
                            
                            alert('Network error occurred. Please try again.');
                            
                            setTimeout(() => {
                                confirmText.innerHTML = '<i class="fas fa-check"></i>Confirm Order';
                            }, 3000);
                        }
                    });
                });
            }
            
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.style.display = 'none';
                        userForm.reset();
                    }
                });
            }
            
            if (clearBtn) {
                clearBtn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to clear all items from your cart?')) {            
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>Clearing...';
                        this.disabled = true;
                        
                        jQuery.ajax({
                            url: ajax_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'clear_cart',
                                security: ajax_object.clear_nonce
                            },
                            success: function(response) {
                                if (response.success) {
                                    window.location.reload();
                                } else {
                                    alert('Error clearing cart: ' + (response.data.message || 'Please try again'));
                                    clearBtn.innerHTML = originalText;
                                    clearBtn.disabled = false;
                                }
                            },
                            error: function(xhr, status, error) {
                                alert('Network error while clearing cart');
                                clearBtn.innerHTML = originalText;
                                clearBtn.disabled = false;
                            }
                        });
                    }
                });
            }
        });
        </script>

        <?php do_action('woocommerce_after_cart'); ?>
        
        <?php
    } else {
        ?>
        <div class="cart-container">
            <div style="text-align: center;">
                <h2 style="font-size: 2rem; font-weight: bold; color: #ffffff; margin-bottom: 1rem;">Cart Not Available</h2>
                <p style="color: #9ca3af; margin-bottom: 2rem;">WooCommerce is not active. Please contact the site administrator.</p>
                <a href="<?php echo home_url(); ?>" class="btn btn-finalize">
                    Return Home
                </a>
            </div>
        </div>
        <?php
    }
    ?>

</main>

<?php get_footer(); ?>

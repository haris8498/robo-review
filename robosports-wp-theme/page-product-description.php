<?php 
/**
 * Template Name: Product Description Page Enhanced
 * Custom template for displaying individual products with all variations
 */

if (!function_exists('get_header')) {
    $wp_load = dirname(__FILE__) . '/../../../../wp-load.php';
    if (file_exists($wp_load)) {
        require_once $wp_load;
    } else {
        die('WordPress bootstrap failed.');
    }
}

get_header(); ?>

<div class="product-description-page">
    <div class="container">
        <?php
        // Get product ID from URL parameter
        $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
        
        if ($product_id && get_post_type($product_id) === 'product') {
            $product = wc_get_product($product_id);
            
            if ($product && $product->is_visible()) {
                ?>
                <div class="single-product-wrapper">
                    <!-- Enhanced two-column grid layout -->
                    <div class="product-details-grid">
                        <!-- Product Images -->
                        <div class="product-images">
                            <?php
                            // Replace default WooCommerce gallery with Smart Slider per variation
                            $variations = $product->get_children();
                            if ( ! empty($variations) ) {
                                echo '<div class="product-sliders" id="product-sliders-' . $product->get_id() . '">';
                                
                                // Show first variation slider by default or first one with shortcode
                                $first_slider_shown = false;
                                
                                foreach( $variations as $variation_id ) {
                                    $shortcode = get_post_meta( $variation_id, '_slider_shortcode', true );
                                    if ($shortcode) {
                                        $display_style = '';
                                        if (!$first_slider_shown) {
                                            $display_style = 'display:block'; // Show first slider by default
                                            $first_slider_shown = true;
                                        } else {
                                            $display_style = 'display:none';
                                        }
                                        
                                        echo '<div class="variation-slider" id="slider-' . esc_attr($variation_id) . '" style="' . $display_style . '">';
                                        if (preg_match('/^\[smartslider3\s+slider="[^"]+"\]$/i', $shortcode)) {
                                            echo do_shortcode($shortcode);
                                        }
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                                
                                // Fallback: Show default product gallery if no sliders exist
                                if (!$first_slider_shown) {
                                    echo '<div id="default-product-gallery">';
                                    woocommerce_show_product_images();
                                    echo '</div>';
                                }
                            } else {
                                // No variations, show default gallery
                                woocommerce_show_product_images();
                            }
                            ?>
                        </div> <!-- end product-images -->


                        <!-- Product Information -->
                        <div class="product-info">
                            <?php 
                            $product_cats = wp_get_post_terms($product_id, 'product_cat');
                            if ($product_cats && !is_wp_error($product_cats)) : ?>
                                <div class="product-categories">
                                    <?php foreach ($product_cats as $cat) : ?>
                                        <span class="category-tag"><?php echo esc_html($cat->name); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <h1 class="product-title"><?php echo esc_html($product->get_name()); ?></h1>
                            
                            <!-- Price -->
                            <div class="product-price">
                                <?php echo $product->get_price_html(); ?>
                            </div>

                            <!-- Enhanced Variations Section -->
                            <?php if ($product->is_type('variable')) : ?>
                                <div class="product-variations-modern">
                                    <?php
                                    $attributes = $product->get_variation_attributes();
                                    foreach ($attributes as $attribute_name => $options) :
                                        $attribute_label = wc_attribute_label($attribute_name);
                                        $clean_attribute_name = sanitize_title($attribute_name);
                                        
                                        if (strtolower($attribute_label) === 'size' || strtolower($attribute_label) === 'sizes') :
                                    ?>
                                        <div class="variation-section size-section">
                                            <h3 class="variation-title">Available Sizes</h3>
                                            <div class="size-selector">
                                                <?php foreach ($options as $option) : ?>
                                                    <button type="button" class="size-btn variation-btn" 
                                                            data-attribute="<?php echo esc_attr($clean_attribute_name); ?>" 
                                                            data-value="<?php echo esc_attr($option); ?>">
                                                        <?php echo esc_html($option); ?>
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php 
                                        elseif (strtolower($attribute_label) === 'color' || strtolower($attribute_label) === 'colors') :
                                    ?>
                                        <div class="variation-section color-section">
                                            <h3 class="variation-title">Available Colors</h3>
                                            <div class="color-selector">
                                                <?php foreach ($options as $option) : ?>
                                                    <?php
                                                    $color_value = strtolower($option);
                                                    $css_color = '';
                                                    
                                                    // Try to get color from term meta first
                                                    $color_term = get_term_by('slug', $option, 'pa_color');
                                                    if ($color_term) {
                                                        $color_meta = get_term_meta($color_term->term_id, 'color', true);
                                                        if ($color_meta) {
                                                            $css_color = $color_meta;
                                                        }
                                                    }
                                                    
                                                    // Fallback color mapping
                                                    if (!$css_color) {
                                                        if (preg_match('/^#[a-f0-9]{6}$/i', $option)) {
                                                            $css_color = $option;
                                                        } else {
                                                            $color_map = [
                                                                'white' => '#ffffff',
                                                                'black' => '#000000',
                                                                'red' => '#ff0000',
                                                                'blue' => '#0000ff',
                                                                'green' => '#008000',
                                                                'yellow' => '#ffff00',
                                                                'orange' => '#ffa500',
                                                                'purple' => '#800080',
                                                                'pink' => '#ffc0cb',
                                                                'brown' => '#a52a2a',
                                                                'gray' => '#808080',
                                                                'grey' => '#808080',
                                                                'navy' => '#000080',
                                                                'maroon' => '#800000',
                                                                'silver' => '#c0c0c0',
                                                                'gold' => '#ffd700'
                                                            ];
                                                            $css_color = isset($color_map[$color_value]) ? $color_map[$color_value] : '#cccccc';
                                                        }
                                                    }
                                                    ?>
                                                    <button type="button" class="color-btn variation-btn" 
                                                            data-attribute="<?php echo esc_attr($clean_attribute_name); ?>" 
                                                            data-value="<?php echo esc_attr($option); ?>"
                                                            data-color-name="<?php echo esc_attr($option); ?>"
                                                            title="<?php echo esc_attr($option); ?>">
                                                        <span class="color-swatch" style="background-color: <?php echo esc_attr($css_color); ?>; <?php echo $color_value === 'white' ? 'border: 2px solid #444;' : ''; ?>"></span>
                                                        <span class="color-name"><?php echo esc_html($option); ?></span>
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php 
                                        else :
                                    ?>
                                        <div class="variation-section attribute-section">
                                            <h3 class="variation-title">Available <?php echo esc_html($attribute_label); ?></h3>
                                            <div class="attribute-selector">
                                                <?php foreach ($options as $option) : ?>
                                                    <button type="button" class="attribute-btn variation-btn" 
                                                            data-attribute="<?php echo esc_attr($clean_attribute_name); ?>" 
                                                            data-value="<?php echo esc_attr($option); ?>">
                                                        <?php echo esc_html($option); ?>
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                                <!-- Hidden WooCommerce variations form for functionality -->
                                <div style="display: none;">
                                    <?php if ($product->is_type('variable')) : ?>
                                        <form class="variations_form cart" method="post">
                                            <table class="variations">
                                                <?php
                                                $attributes = $product->get_variation_attributes();
                                                foreach ($attributes as $attribute_name => $options) :
                                                    $clean_name = sanitize_title($attribute_name);
                                                ?>
                                                <tr>
                                                    <td class="label">
                                                        <label for="<?php echo $clean_name; ?>"><?php echo wc_attribute_label($attribute_name); ?></label>
                                                    </td>
                                                    <td class="value">
                                                        <select id="<?php echo $clean_name; ?>" name="attribute_<?php echo $clean_name; ?>">
                                                            <option value="">Choose an option</option>
                                                            <?php foreach ($options as $option) : ?>
                                                                <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </table>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Enhanced Add to Cart Section -->
                            <div class="product-purchase-section">
                                <form id="add-to-cart-form" class="cart" method="post" action="<?php echo esc_url( wc_get_cart_url() ); ?>">
                                    <input type="hidden" name="add-to-cart" value="<?php echo $product->get_id(); ?>">
                                    <input type="hidden" id="selected-variation-id" name="variation_id" value="">
                                    
                                    <div class="cart-controls">
                                        <div class="quantity-wrapper">
                                            <label for="quantity">Qty:</label>
                                            <div class="quantity-input-wrapper">
                                                <button type="button" class="qty-btn qty-minus">-</button>
                                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product->get_stock_quantity() ? $product->get_stock_quantity() : 999; ?>" class="qty-input">
                                                <button type="button" class="qty-btn qty-plus">+</button>
                                            </div>
                                        </div>
                                        <button type="submit" id="custom-add-to-cart" class="add-to-cart-btn">
                                            <span class="btn-icon">🛒</span>
                                            <span class="btn-text">Add to Cart</span>
                                        </button>
                                    </div>
                                    
                                    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                                    
                                    <!-- Hidden fields for variations -->
                                    <?php if ($product->is_type('variable')) : ?>
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <?php
                                        $attributes = $product->get_variation_attributes();
                                        foreach ($attributes as $attribute_name => $options) :
                                            $clean_name = sanitize_title($attribute_name);
                                        ?>
                                            <input type="hidden" name="attribute_<?php echo $clean_name; ?>" 
                                                   id="attribute_<?php echo $clean_name; ?>" value="">
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </form>
                                
                                <!-- Selection status indicator -->
                                <?php if ($product->is_type('variable')) : ?>
                                    <div id="selection-status" class="selection-status">
                                        <span id="status-text">Please select your options</span>
                                    </div>
                                <?php endif; ?>
                                
                                <div id="cart-feedback" class="cart-feedback"></div>
                            </div>

                            <!-- Full Description -->
                            <?php if ($product->get_description()) : ?>
                                <div class="product-full-description">
                                    <h3>Product Description</h3>
                                    <div class="description-content">
                                        <?php echo $product->get_description(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Back to Category Link -->
                            <?php if ($product_cats && !is_wp_error($product_cats)) : ?>
                                <div class="back-to-category">
                                    <a href="<?php echo get_term_link($product_cats[0]); ?>" class="back-to-category-btn">
                                        <span class="btn-icon">←</span>
                                        <span class="btn-text">Back to <?php echo esc_html($product_cats[0]->name); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo '<div class="product-not-found"><h2>Product not found</h2><p>The requested product could not be found.</p></div>';
            }
        } else {
            echo '<div class="no-product-selected"><h2>No product selected</h2><p>Please select a product to view its details.</p></div>';
        }
        ?>
    </div>
</div>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.product-description-page {
    background: #1a1a1a;
    color: #ffffff;
    padding: 2rem 0;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    position: relative;
    overflow-x: hidden;
    margin-top: 40px;
}

.product-description-page::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 80%, rgba(79, 70, 229, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(79, 70, 229, 0.1) 0%, transparent 50%);
    pointer-events: none;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    position: relative;
    z-index: 1;
}

.variation-slider {
    width: 100% !important;
    height: 700px !important; /* Increased height */
}

/* Ensure the slider content fills the container */
.variation-slider .n2-ss-slider {
    width: 100% !important;
    height: 100% !important;
}

/* Make sure images within the slider scale properly */
.variation-slider img {
    width: 100% !important;
    height: 100% !important;
    object-fit: contain !important;
}

.single-product-wrapper {
    margin-top: 2rem;
    animation: fadeInUp 0.8s ease-out;
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

/* Enhanced Grid Layout */
.product-details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 5rem;
    margin-bottom: 3rem;
    align-items: start;
}


/* Zoom effect for slider images */
.variation-slider {
    overflow: hidden;
    border-radius: 16px;
}

.variation-slider .n2-ss-slider {
    overflow: hidden;
    border-radius: 16px;
}

.variation-slider img {
    transition: transform 0.5s ease;
    cursor: zoom-in;
}

.variation-slider:hover img {
    transform: scale(1.2);
}

/* For the default WooCommerce gallery fallback */
#default-product-gallery {
    overflow: hidden;
    border-radius: 16px;
}

#default-product-gallery .woocommerce-product-gallery__image {
    overflow: hidden;
    border-radius: 16px;
}

#default-product-gallery img {
    transition: transform 0.5s ease;
    cursor: zoom-in;
}

#default-product-gallery:hover img {
    transform: scale(1.2);
}

/* For the no variations case */
.product-images .woocommerce-product-gallery {
    overflow: hidden;
    border-radius: 16px;
}

.product-images .woocommerce-product-gallery__image {
    overflow: hidden;
    border-radius: 16px;
}

.product-images .woocommerce-product-gallery img {
    transition: transform 0.5s ease;
    cursor: zoom-in;
}

.product-images .woocommerce-product-gallery:hover img {
    transform: scale(1.2);
}

.gallery-thumb {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.gallery-thumb:hover,
.gallery-thumb.active {
    transform: translateY(-4px);
    border-color: #4F46E5;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.gallery-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Info Section */
.product-info {
    animation: fadeInRight 0.8s ease-out 0.2s both;
}

.size-btn {
    text-transform: uppercase;
    font-weight: 700; /* Optional: make it bolder for better appearance */
}

/* If you have specific size values that need special handling */
.size-btn[data-value="s"],
.size-btn[data-value="m"],
.size-btn[data-value="l"],
.size-btn[data-value="xl"],
.size-btn[data-value="xxl"],
.size-btn[data-value="xs"] {
    text-transform: uppercase;
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.product-categories {
    margin-bottom: 1rem;
}

.category-tag {
    display: inline-block;
    background: #4F46E5;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    margin-right: 0.5rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.product-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: #ffffff;
    line-height: 1.2;
}

.product-price {
    font-size: 2rem;
    font-weight: 700;
    color: #22c55e;
    margin-bottom: 2rem;
    animation: priceFloat 2s ease-in-out infinite;
}

@keyframes priceFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

.product-short-description {
    font-size: 1.125rem;
    line-height: 1.7;
    color: #cccccc;
    margin-bottom: 2.5rem;
    opacity: 0;
    animation: fadeIn 1s ease-out 0.5s forwards;
}

@keyframes fadeIn {va
    to { opacity: 1; }
}

/* Enhanced Variations Section */
.product-variations-modern {
    margin-bottom: 3rem;
}

.variation-section {
    margin-bottom: 2.5rem;
    animation: slideInLeft 0.6s ease-out;
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.variation-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #ffffff;
    position: relative;
}

/* Size Buttons */
.size-selector {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.size-btn {
    background: #1a1a1a;
    border: 1px solid #444;
    color: #cccccc;
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 50px;
}

.size-btn:hover {
    border-color: #4F46E5;
    background: #1a1a1a;
    color: #ffffff;
    transform: translateY(-2px);
}

.size-btn.selected {
    background: #4F46E5;
    border-color: #4F46E5;
    color: white;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
}

/* Color Buttons */
.color-selector {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.color-btn {
    background: #1a1a1a;
    border: 1px solid #444;
    color: #cccccc;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-width: 100px;
}

.color-btn:hover {
    border-color: #4F46E5;
    background: #1a1a1a;
    color: #ffffff;
    transform: translateY(-2px);
}

.color-swatch {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #ccc;
    transition: all 0.3s ease;
    display: inline-block;
}

.color-btn.selected {
    background: #4F46E5;
    border-color: #4F46E5;
    color: white;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
}

.color-btn.selected .color-swatch {
    border-color: white;
    transform: scale(1.1);
}

.color-name {
    font-weight: 500;
    text-transform: capitalize;
}

/* Attribute Buttons */
.attribute-selector {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.attribute-btn {
    background: #1a1a1a;
    border: 1px solid #444;
    color: #cccccc;
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.attribute-btn:hover {
    border-color: #4F46E5;
    background: #1a1a1a;
    color: #ffffff;
    transform: translateY(-2px);
}

.attribute-btn.selected {
    background: #4F46E5;
    border-color: #4F46E5;
    color: white;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
}

/* Purchase Section */
.product-purchase-section {
    background: #2a2a2a;
    border-radius: 12px;
    padding: 2rem;
    border: 1px solid #444;
    margin-bottom: 3rem;
    animation: slideInUp 0.8s ease-out 0.4s both;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.cart-controls {
    display: flex;
    gap: 2rem;
    align-items: center;
    margin-bottom: 1.5rem;
}

.quantity-wrapper {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-wrapper label {
    font-weight: 600;
    color: #cccccc;
}

.quantity-input-wrapper {
    display: flex;
    align-items: center;
    background: #1a1a1a;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #444;
}

.qty-btn {
    background: none;
    border: none;
    color: #ffffff;
    padding: 0.5rem 1rem;
    cursor: pointer;
    font-size: 1.25rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.qty-btn:hover {
    background: #4F46E5;
    color: white;
}

.qty-input {
    background: none;
    border: none;
    color: #ffffff;
    text-align: center;
    width: 60px;
    padding: 0.5rem 0.5rem;
    font-weight: 600;
}

.qty-input:focus {
    outline: none;
}

.add-to-cart-btn {
    background: #4F46E5;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-size: 1.125rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
}

.add-to-cart-btn:hover {
    background: #3730A3;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
}

.add-to-cart-btn:active {
    transform: translateY(-1px);
}

.btn-icon {
    font-size: 1.25rem;
    transition: transform 0.3s ease;
}

.add-to-cart-btn:hover .btn-icon {
    transform: scale(1.2);
}

/* Selection Status */
.selection-status {
    padding: 1rem;
    border-radius: 12px;
    font-weight: 500;
    text-align: center;
    transition: all 0.3s ease;
    background: #2a2a2a;
    border: 1px solid #444;
    color: #cccccc;
}

.selection-status.success {
    background-color: #22c55e;
    color: white;
    border-color: #16a34a;
}

.selection-status.error {
    background-color: #ef4444;
    color: white;
    border-color: #dc2626;
}

.selection-status.info {
    background-color: #3b82f6;
    color: white;
    border-color: #2563eb;
}

/* Cart Feedback */
.cart-feedback {
    margin-top: 1rem;
    padding: 1rem;
    border-radius: 12px;
    font-weight: 500;
    text-align: center;
    display: none;
    animation: slideInDown 0.3s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.cart-feedback.success {
    background-color: #22c55e;
    color: white;
    border: 1px solid #16a34a;
}

.cart-feedback.error {
    background-color: #ef4444;
    color: white;
    border: 1px solid #dc2626;
}

/* Product Description */
.product-full-description {
    background: #2a2a2a;
    border-radius: 12px;
    padding: 2rem;
    border: 1px solid #444;
    margin-bottom: 3rem;
    animation: fadeInUp 0.8s ease-out 0.6s both;
}

.product-full-description h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #ffffff;
    position: relative;
}

.description-content {
    line-height: 1.8;
    color: #cccccc;
    font-size: 1.125rem;
}

.description-content ul {
    list-style: none;
    padding-left: 0;
}

.description-content li {
    position: relative;
    padding-left: 2rem;
    margin-bottom: 0.75rem;
}

.description-content li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #22c55e;
    font-weight: bold;
    font-size: 1.25rem;
}

/* Back to Category */
.back-to-category {
    animation: fadeInUp 0.8s ease-out 0.8s both;
}

.back-to-category-btn {
    background: #4F46E5;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
}

.back-to-category-btn:hover {
    background: #3730A3;
    transform: translateY(-2px);
}

/* Hide default WooCommerce variation selects */
.variations_form .variations {
    display: none !important;
}

.variations_form .single_variation_wrap {
    display: none !important;
}

.variations_form .woocommerce-variation-add-to-cart {
    display: none !important;
}
/* Responsive Design */
@media (max-width: 1024px) {
    .product-details-grid {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    
    .product-images {
        position: static;
    }
    
    .main-product-image img {
        height: 400px;
    }
}

@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
    }
    
    .variation-slider {
        margin-top: -30px;
        width: 100% !important;
        height: 450px !important; /* Increased height */
    }

    /* Ensure the slider content fills the container */
    .variation-slider .n2-ss-slider {
        width: 100% !important;
        height: 100% !important;
    }
    
    /* Make sure images within the slider scale properly */
    .variation-slider img {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain !important;
    }
    
    .product-sliders{
        margin-top: -40px;
    }
    
    .product-title {
        font-size: 2rem;
    }
    
    .cart-controls {
        flex-direction: column;
        gap: 1.5rem;
        align-items: stretch;
    }
    
    .quantity-wrapper {
        justify-content: center;
    }
    
    .main-product-image img {
        height: 300px;
    }
    
    .size-selector,
    .color-selector,
    .attribute-selector {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .product-title {
        font-size: 1.75rem;
    }
    
    .image-container {
        padding: 1rem;
    }
    
    .product-purchase-section {
        padding: 1.5rem;
    }
}

/* Loading Animation */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 40px;
    height: 40px;
    border: 3px solid rgba(79, 70, 229, 0.3);
    border-top: 3px solid #4F46E5;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}
</style>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".variations_form");

    if (form) {
        form.addEventListener("woocommerce_variation_select_change", function () {
            // Get selected color
            const colorSelect = form.querySelector('select[name="attribute_pa_color"]');
            const selectedColor = colorSelect ? colorSelect.value : "";

            // Hide all sliders
            document.querySelectorAll(".variation-slider").forEach(slider => {
                slider.style.display = "none";
            });

            // Show only the slider for selected color
            if (selectedColor) {
                const slider = document.querySelector(".variation-slider-color-" + selectedColor);
                if (slider) {
                    slider.style.display = "block";
                }
            }
        });
    }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all variation buttons and form elements
    const variationButtons = document.querySelectorAll('.variation-btn');
    const cartForm = document.getElementById('add-to-cart-form');
    const mainProductImage = document.querySelector('.main-product-image img');
    const productGallery = document.querySelector('.product-gallery');
    const selectionStatus = document.getElementById('selection-status');
    const statusText = document.getElementById('status-text');
    const cartFeedback = document.getElementById('cart-feedback');
    const addToCartBtn = document.getElementById('custom-add-to-cart');
    const qtyInput = document.getElementById('quantity');
    const qtyMinusBtn = document.querySelector('.qty-minus');
    const qtyPlusBtn = document.querySelector('.qty-plus');
    const originalMainImageSrc = mainProductImage ? mainProductImage.src : '';

    // Global state for selected attributes
    let selectedAttributes = {};
    let isLoading = false;

    // Get variations data from PHP
    const variations = <?php 
    if ($product->is_type('variable')) {
        $available_variations = $product->get_available_variations();
        echo json_encode($available_variations);
    } else {
        echo '[]';
    }
    ?>;
    
    const availableAttributes = <?php 
    if ($product->is_type('variable')) {
        $attributes = $product->get_variation_attributes();
        $attr_info = array();
        foreach ($attributes as $attribute_name => $options) {
            $clean_name = sanitize_title($attribute_name);
            $attr_info[$clean_name] = array(
                'label' => wc_attribute_label($attribute_name),
                'options' => $options,
                'original_name' => $attribute_name
            );
        }
        echo json_encode($attr_info);
    } else {
        echo '{}';
    }
    ?>;

    // Debug logging function
    function debugLog(message, data) {
        return;
    }

    // Inject CSS to handle potential image display issues specific to your theme
    const style = document.createElement('style');
    style.textContent = `
        .main-product-image img {
            width: 100% !important;
            height: 500px !important;
            object-fit: contain !important;
            border-radius: 16px !important;
            transition: transform 0.5s ease, opacity 0.2s ease !important;
            display: block !important;
            visibility: visible !important;
        }
        
        .main-product-image {
            position: relative !important;
            overflow: hidden !important;
            border-radius: 16px !important;
            margin-bottom: 1.5rem !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }
        
        .main-product-image img[src=""],
        .main-product-image img:not([src]) {
            opacity: 0 !important;
            visibility: hidden !important;
        }
        
        .main-product-image.image-updating img {
            opacity: 0.3 !important;
        }
        
        .main-product-image.image-loaded img {
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        @media (max-width: 1024px) {
            .main-product-image img {
                height: 400px !important;
            }
        }
        
        @media (max-width: 768px) {
            .main-product-image img {
                height: 300px !important;
            }
        }
    `;
    document.head.appendChild(style);

    // Quantity controls
    if (qtyMinusBtn && qtyPlusBtn && qtyInput) {
        qtyMinusBtn.addEventListener('click', function() {
            const currentValue = parseInt(qtyInput.value);
            if (currentValue > 1) {
                qtyInput.value = currentValue - 1;
            }
        });

        qtyPlusBtn.addEventListener('click', function() {
            const currentValue = parseInt(qtyInput.value);
            const maxValue = parseInt(qtyInput.max);
            if (currentValue < maxValue) {
                qtyInput.value = currentValue + 1;
            }
        });
    }

    // Collect current selections
    function getSelectedAttributes() {
        const selected = {};
        variationButtons.forEach(button => {
            if (button.classList.contains('selected')) {
                selected[button.dataset.attribute] = button.dataset.value;
            }
        });
        return selected;
    }

    function normalizeAttributeValue(value) {
        if (!value) return '';
        return value.toString().toLowerCase().trim().replace(/[^a-z0-9]/g, '');
    }

    function getVariationAttributeValue(variation, attributeKey) {
        if (!variation || !variation.attributes) {
            return null;
        }

        const attrs = variation.attributes;
        
        // Create all possible key variations
        const possibleKeys = [
            attributeKey,
            'attribute_' + attributeKey,
            'attribute_pa_' + attributeKey.replace(/^pa_/, ''),
            'pa_' + attributeKey.replace(/^pa_/, ''),
            attributeKey.replace(/^attribute_/, '').replace(/^pa_/, '')
        ];

        // Remove duplicates
        const uniqueKeys = [...new Set(possibleKeys)];
        
        // Try exact matches first
        for (let key of uniqueKeys) {
            if (attrs[key]) {
                return attrs[key];
            }
        }
        
        // Try case-insensitive matching
        const normalizedInputKey = attributeKey.toLowerCase();
        for (let key in attrs) {
            const normalizedKey = key.toLowerCase();
            if (normalizedKey === normalizedInputKey || 
                normalizedKey.includes(normalizedInputKey) ||
                normalizedInputKey.includes(normalizedKey.replace(/^attribute_/, '').replace(/^pa_/, ''))) {
                return attrs[key];
            }
        }
        return null;
    }

    // Enhanced attribute matching function
    function findVariationByAttributes(attributes) {
        const selectedAttributeKeys = Object.keys(attributes);
        
        if (selectedAttributeKeys.length === 0) {
            return null;
        }

        // Try exact match first
        let matchedVariation = variations.find(variation => {
            const isExactMatch = selectedAttributeKeys.every(attrKey => {
                const selectedValue = attributes[attrKey];
                if (!selectedValue) return true; 
                
                const variationValue = getVariationAttributeValue(variation, attrKey);
                const match = variationValue && normalizeAttributeValue(variationValue) === normalizeAttributeValue(selectedValue);
                return match;
            });
            
            if (isExactMatch) {
            }
            return isExactMatch;
        });

        if (matchedVariation) {
            return matchedVariation;
        }
        
        // Try partial matches for single attribute
        if (selectedAttributeKeys.length === 1) {
            const singleAttrKey = selectedAttributeKeys[0];
            const singleAttrValue = attributes[singleAttrKey];

            if (singleAttrValue) {
                matchedVariation = variations.find(variation => {
                    const variationValue = getVariationAttributeValue(variation, singleAttrKey);
                    const match = variationValue && normalizeAttributeValue(variationValue) === normalizeAttributeValue(singleAttrValue);
                    return match;
                });
                
                if (matchedVariation) {
                    return matchedVariation;
                }
            }
        }
        
        // Try each attribute individually as fallback
        for (let attrKey of selectedAttributeKeys) {
            const attrValue = attributes[attrKey];
            if (attrValue) {
                matchedVariation = variations.find(variation => {
                    const variationValue = getVariationAttributeValue(variation, attrKey);
                    const match = variationValue && normalizeAttributeValue(variationValue) === normalizeAttributeValue(attrValue);
                    return match;
                });
                
                if (matchedVariation) {
                    return matchedVariation;
                }
            }
        }
        return null;
    }

    // Enhanced image extraction function
    function extractVariationImage(variation) {
        if (!variation) return null;
        
        // Try multiple image property paths with detailed logging
        const imagePaths = [
            'image.full_src',
            'image.src', 
            'image.url',
            'image_src',
            'image.large_src',
            'image',
            'featured_image',
            'variation_image_src'
        ];
        
        for (let path of imagePaths) {
            let imageUrl = null;
            
            if (path.includes('.')) {
                const parts = path.split('.');
                let obj = variation;
                for (let part of parts) {
                    if (obj && obj[part]) {
                        obj = obj[part];
                    } else {
                        obj = null;
                        break;
                    }
                }
                imageUrl = obj;
            } else {
                imageUrl = variation[path];
            }
            
            if (imageUrl && typeof imageUrl === 'string' && imageUrl.trim() !== '') {
                return imageUrl;
            }
        }
        
        // Check if image is an object with nested properties
        if (variation.image && typeof variation.image === 'object') {
            const imageObj = variation.image;
            
            // Try common WooCommerce image object properties
            const objProps = ['full_src', 'src', 'url', 'large', 'medium', 'thumbnail'];
            for (let prop of objProps) {
                if (imageObj[prop] && typeof imageObj[prop] === 'string') {
                    return imageObj[prop];
                }
            }
            
            // If image object has sizes
            if (imageObj.sizes) {
                const sizes = ['full', 'large', 'medium', 'thumbnail'];
                for (let size of sizes) {
                    if (imageObj.sizes[size] && imageObj.sizes[size].url) {
                        return imageObj.sizes[size].url;
                    }
                }
            }
        }
        return null;
    }

    // Function to update zoom and lightbox images
    function updateZoomAndLightboxImages(imageUrl) {
        // Update zoom containers
        const zoomSelectors = [
            '.woocommerce-product-gallery__image a',
            '.product-image-zoom',
            '.zoom-image',
            '.easyzoom-flyout'
        ];
        
        zoomSelectors.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(el => {
                if (el.tagName === 'A') {
                    el.href = imageUrl;
                }
                if (el.dataset) {
                    el.dataset.zoom = imageUrl;
                    el.dataset.src = imageUrl;
                }
            });
        });
        
        // Update lightbox data
        const lightboxElements = document.querySelectorAll('[data-lightbox], [data-fancybox]');
        lightboxElements.forEach(el => {
            if (el.href || el.dataset.src) {
                el.href = imageUrl;
                el.dataset.src = imageUrl;
            }
        });
    }

    // Enhanced main image element detection
    function getMainImageElement() {
        const selectors = [
            '.main-product-image img',
            '.woocommerce-product-gallery__image.flex-active-slide img',
            '.woocommerce-product-gallery__image:first-child img',
            '.product-image-main img',
            '.product-main-image img',
            '.flex-active-slide img',
            '.product-gallery-main img',
            'img.attachment-woocommerce_single',
            '.woocommerce-product-gallery .wp-post-image'
        ];
        
        for (let selector of selectors) {
            const element = document.querySelector(selector);
            if (element) {
                return element;
            }
        }
        return mainProductImage;
    }

    function updateVariationSlider() {
        // Get selected color value
        const colorButtons = document.querySelectorAll('.color-btn');
        let selectedColorValue = '';
        
        colorButtons.forEach(button => {
            if (button.classList.contains('selected')) {
                selectedColorValue = button.dataset.value;
            }
        });
        
        // Get selected design value
        const designButtons = document.querySelectorAll('[data-attribute*="design"], [data-attribute*="pa_design"]');
        let selectedDesignValue = '';
        
        designButtons.forEach(button => {
            if (button.classList.contains('selected')) {
                selectedDesignValue = button.dataset.value;
            }
        });
        
        // Hide all sliders
        document.querySelectorAll(".variation-slider").forEach(slider => {
            slider.style.display = "none";
        });

        // Priority: If both color and design are selected, try to find exact match first
        if (selectedColorValue && selectedDesignValue) {
            const exactMatch = variations.find(variation => {
                const variationColor = getVariationAttributeValue(variation, 'pa_color') || 
                                      getVariationAttributeValue(variation, 'color');
                const variationDesign = getVariationAttributeValue(variation, 'pa_design') || 
                                       getVariationAttributeValue(variation, 'design');
                
                return variationColor && normalizeAttributeValue(variationColor) === normalizeAttributeValue(selectedColorValue) &&
                       variationDesign && normalizeAttributeValue(variationDesign) === normalizeAttributeValue(selectedDesignValue);
            });
            
            if (exactMatch) {
                showSliderForVariation(exactMatch.variation_id);
                return;
            }
        }
        
        // If no exact match or only one attribute selected, try color first
        if (selectedColorValue) {
            const colorVariation = variations.find(variation => {
                const variationColor = getVariationAttributeValue(variation, 'pa_color') || 
                                      getVariationAttributeValue(variation, 'color');
                return variationColor && normalizeAttributeValue(variationColor) === normalizeAttributeValue(selectedColorValue);
            });
            
            if (colorVariation) {
                showSliderForVariation(colorVariation.variation_id);
                return;
            }
        }
        
        // Then try design if color not found or not selected
        if (selectedDesignValue) {
            const designVariation = variations.find(variation => {
                const variationDesign = getVariationAttributeValue(variation, 'pa_design') || 
                                       getVariationAttributeValue(variation, 'design');
                return variationDesign && normalizeAttributeValue(variationDesign) === normalizeAttributeValue(selectedDesignValue);
            });
            
            if (designVariation) {
                showSliderForVariation(designVariation.variation_id);
                return;
            }
        }
        
        // If no attribute is selected, show the first slider
        const firstSlider = document.querySelector(".variation-slider");
        if (firstSlider) {
            firstSlider.style.display = "block";
        }
    }
    
    // Helper function to show slider for a specific variation
    function showSliderForVariation(variationId) {
        const targetSlider = document.querySelector("#slider-" + variationId);
        if (targetSlider) {
            targetSlider.style.display = "block";
            
            // Force slider to re-render
            window.dispatchEvent(new Event('resize'));
            
            if (window.jQuery) {
                const sliderElement = window.jQuery(targetSlider).find('.n2-ss-slider').first();
                if (sliderElement.length) {
                    sliderElement.trigger('ss-reinit');
                }
            }
        }
    }

function updateVariationImage(variation) {
    
    // Hide all sliders first
    document.querySelectorAll(".variation-slider").forEach(slider => {
        slider.style.display = "none";
    });

    // Hide WooCommerce default gallery (optional)
    const defaultGallery = document.querySelector("#product-gallery");
    if (defaultGallery) {
        defaultGallery.style.display = "none";
    }

    if (variation && variation.variation_id) {
        const activeSlider = document.querySelector("#slider-" + variation.variation_id);
        if (activeSlider) {
            activeSlider.style.display = "block";
        } else {
            return;
        }
    } else {
       // Fallback: show the first available slider
        const firstSlider = document.querySelector(".variation-slider");
        if (firstSlider) {
            firstSlider.style.display = "block";
        } else if (defaultGallery) {
            defaultGallery.style.display = "block";
        }
    }
}

document.addEventListener("DOMContentLoaded", function() {
    if (typeof jQuery !== "undefined") {
        jQuery(function($) {
            $("form.variations_form").on("show_variation", function(event, variation) {
                updateVariationImage(variation);
            });

            $("form.variations_form").on("reset_data", function() {
                updateVariationImage(null);
            });
            updateVariationImage(null);
        });
    } else {
        // Fallback or Vanilla JS alternative could be added here
        updateVariationImage(null);
    }
});


// Validate and update variation
    function validateAndUpdateVariation() {
        selectedAttributes = getSelectedAttributes();
        const requiredAttributes = Object.keys(availableAttributes);
        const selectedCount = Object.keys(selectedAttributes).length;
        
        const varInput = document.getElementById("selected-variation-id");
        
        // This validation logic for the add to cart button remains the same
        if (selectedCount === requiredAttributes.length) {
            const matchedVariation = findVariationByAttributes(selectedAttributes);

            if (matchedVariation) {                
                if (varInput) {
                    varInput.value = matchedVariation.variation_id;
                }
                updateVariationSlider(matchedVariation.variation_id); 
                
                if (addToCartBtn) {
                    addToCartBtn.disabled = false;
                    addToCartBtn.classList.remove('loading');
                }
                
                updateSelectionStatus('Ready to add to cart! 🎉', 'success');
            } else {
                if (varInput) varInput.value = "";
                if (addToCartBtn) {
                    addToCartBtn.disabled = true;
                    addToCartBtn.classList.remove('loading');
                }
                updateSelectionStatus('This combination is not available ❌', 'error');
            }
        } else {
            if (varInput) varInput.value = "";
            if (addToCartBtn) {
                addToCartBtn.disabled = true;
                addToCartBtn.classList.remove('loading');
            }
            
            const remaining = requiredAttributes.length - selectedCount;
            if (remaining === requiredAttributes.length) {
                updateSelectionStatus('Please select your options', 'info');
            } else {
                updateSelectionStatus(`Please select ${remaining} more option${remaining > 1 ? 's' : ''} ⏳`, 'info');
            }
        }
    }
    
    function updateSelectionStatus(message, type) {
        if (selectionStatus && statusText) {
            statusText.textContent = message;
            selectionStatus.className = `selection-status ${type}`;
        }
    }

    function showCartFeedback(message, type) {
        if (cartFeedback) {
            cartFeedback.textContent = message;
            cartFeedback.className = `cart-feedback ${type}`;
            cartFeedback.style.display = 'block';
            
            // Hide after 5 seconds
            setTimeout(() => {
                cartFeedback.style.display = 'none';
            }, 5000);
        }
    }
    
    variationButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            if (isLoading) return;
            
            const attribute = this.dataset.attribute;
            const value = this.dataset.value;
            
            // Handle button selection
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
            } else {
                const sameAttributeButtons = document.querySelectorAll('[data-attribute="' + attribute + '"]');
                sameAttributeButtons.forEach(function(btn) {
                    btn.classList.remove('selected');
                });
                this.classList.add('selected');
            }
            
            // Update both your custom form and WooCommerce form
            const selectedValue = this.classList.contains('selected') ? value : '';
            
            // Update your custom hidden field
            const customField = document.getElementById('attribute_' + attribute);
            if (customField) {
                customField.value = selectedValue;
            }
            
            // Update WooCommerce hidden form
            const wcSelect = document.querySelector(`select[name="attribute_${attribute}"]`);
            if (wcSelect) {
                wcSelect.value = selectedValue;
                wcSelect.dispatchEvent(new Event('change', { bubbles: true }));
            }

            // Update slider based on color OR design selection
            if (attribute.includes('color') || attribute.includes('pa_color') || 
                attribute.includes('design') || attribute.includes('pa_design')) {
                updateVariationSlider();
            }
            
            selectedAttributes = getSelectedAttributes();
            validateAndUpdateVariation();
        });
    });
    // Gallery thumbnail clicks
    if (productGallery) {
        const galleryThumbs = productGallery.querySelectorAll('.gallery-thumb');
        galleryThumbs.forEach(function(thumb) {
            thumb.addEventListener('click', function() {
                const img = this.querySelector('img');
                const largeImage = img.dataset.largeImage || img.src;
                if (mainProductImage && largeImage) {
                    mainProductImage.style.opacity = '0.5';
                    setTimeout(function() {
                        mainProductImage.src = largeImage;
                        mainProductImage.style.opacity = '1';
                    });
                }
                // Update active thumbnail
                galleryThumbs.forEach(function(t) {
                    t.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    }

    // Initial validation
    if (typeof validateAndUpdateVariation === 'function') {
        validateAndUpdateVariation();
    }
});
</script>

<?php get_footer(); ?>
<?php
/**
 * The template for displaying product content within loops
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$custom_product_url = home_url('/product-description/?product_id=' . $product->get_id());
?>
<li <?php wc_product_class( '', $product ); ?>>
    <div class="woocommerce-loop-product__link">
        <!-- Product image with category badge -->
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php echo esc_url( $custom_product_url ); ?>">
                <?php the_post_thumbnail( 'woocommerce_thumbnail' ); ?>
            </a>
        <?php endif; ?>
        
        <!-- Category badge -->
        <?php
        $product_cats = get_the_terms( $product->get_id(), 'product_cat' );
        if ( $product_cats && ! is_wp_error( $product_cats ) ) :
            $main_cat = $product_cats[0];
        ?>
            <div class="product-category-badge">
                <?php echo esc_html( ucfirst($main_cat->name) ); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Product details section -->
    <div class="product-details">
        <!-- Product title -->
        <?php
        echo '<h2 class="woocommerce-loop-product__title"><a href="' . esc_url( $custom_product_url ) . '">' . get_the_title() . '</a></h2>';
        ?>

        <!-- Product short description -->
        <div class="product-description">
            <?php 
            $short_desc = $product->get_short_description();
            
            if ( $short_desc && !empty(trim($short_desc)) ) {
                // Display only the actual WooCommerce short description
                echo wp_trim_words( strip_tags( $short_desc ), 20, '...' );
            } else {
                // Show nothing if no short description is set
                echo '';
            }
            ?>
        </div>

        <!-- Price -->
        <?php
        echo '<span class="price">' . $product->get_price_html() . '</span>';
        ?>

        <!-- Add to cart button -->
        <?php
        add_filter('woocommerce_product_add_to_cart_text', function($text, $product) {
            if (wc_get_loop_prop('is_shortcode') || is_shop() || is_product_category() || is_product_tag()) {
                return 'Check Product';
            }
            return $text;
        }, 10, 2);
        
        add_filter('woocommerce_loop_add_to_cart_link', function($link, $product, $args) {
            $custom_product_url = home_url('/product-description/?product_id=' . $product->get_id());

            $link = '<a href="' . esc_url($custom_product_url) . '" 
                        class="button product_type_simple check_product_button">
                        Check Product
                    </a>';

            return $link;
        }, 10, 3);
        
        woocommerce_template_loop_add_to_cart();
        ?>
    </div>
</li>

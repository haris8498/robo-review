<?php
defined( 'ABSPATH' ) || exit;
get_header( 'shop' );

while ( have_posts() ) :
    the_post();
    global $product;
?>
<div class="single-product-container">
    <div class="single-product-image">
        <?php woocommerce_show_product_images(); ?>
    </div>

    <div class="single-product-summary">
        <!-- Product title is rendered by functions.php via woocommerce_single_product_summary action -->
        <div class="single-product-desc"><?php the_excerpt(); ?></div>

        <?php if ( $product->is_type( 'variable' ) ) : ?>
            <?php
            // Get product attributes
            $attributes = $product->get_attributes();
            if ( isset( $attributes['pa_size'] ) ) {
                echo '<div class="product-sizes"><strong>Available Sizes:</strong><br>';
                foreach ( $attributes['pa_size']->get_options() as $size_slug ) {
                    $size_name = get_term_by( 'slug', $size_slug, 'pa_size' )->name;
                    echo '<button class="size-btn" data-size="' . esc_attr( $size_slug ) . '">' . esc_html( $size_name ) . '</button>';
                }
                echo '</div>';
            }
            ?>
        <?php endif; ?>

        <div class="add-to-cart-wrapper">
            <?php 
            add_filter('woocommerce_product_add_to_cart_url', function($url, $product) {
                return home_url('/cart/');
            }, 10, 2);
            
            woocommerce_template_single_add_to_cart(); 
            ?>
        </div>

        <div class="single-product-details">
            <?php the_content(); ?>
        </div>
    </div>
</div>
<?php endwhile; ?>

<?php get_footer( 'shop' ); ?>

<?php
defined( 'ABSPATH' ) || exit;
get_header( 'shop' );
?>

<div class="shop-container">
    <h1 class="shop-title"><?php woocommerce_page_title(); ?></h1>

    <?php if ( woocommerce_product_loop() ) : ?>
        <?php
        add_filter( 'loop_shop_per_page', function() { return 12; }, 20 );
        add_filter( 'loop_shop_columns', function() { return 3; }, 20 );
        ?>
        
        <?php
        woocommerce_product_loop_start();
        
        while ( have_posts() ) {
            the_post();
            
            /**
             * Hook: woocommerce_shop_loop.
             */
            do_action( 'woocommerce_shop_loop' );
            
            wc_get_template_part( 'content', 'product' );
        }
        
        woocommerce_product_loop_end();
        ?>
        
        <?php
        /**
         * Hook: woocommerce_after_shop_loop.
         */
        do_action( 'woocommerce_after_shop_loop' );
        ?>
        
        <?php woocommerce_pagination(); ?>
    <?php else : ?>
        <?php
        /**
         * Hook: woocommerce_no_products_found.
         */
        do_action( 'woocommerce_no_products_found' );
        ?>
    <?php endif; ?>
</div>

<?php get_footer( 'shop' ); ?>

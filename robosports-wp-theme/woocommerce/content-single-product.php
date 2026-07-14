<?php
/**
 * Enhanced single product template for detailed product view with variations
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form();
    return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single-product-content', $product ); ?>>
    <!-- Enhanced product layout with better responsive design and variation display -->
    <div class="single-product-layout">
        
        <!-- Product Images -->
        <div class="product-images-section">
            <?php do_action( 'woocommerce_before_single_product_summary' ); ?>
        </div>

        <!-- Product Summary -->
        <div class="product-summary-section">
            <div class="summary entry-summary">
                
                <!-- Product Categories -->
                <?php
                $product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
                if ( ! empty( $product_cats ) && ! is_wp_error( $product_cats ) ) {
                    echo '<div class="product-categories">';
                    foreach ( $product_cats as $cat ) {
                        echo '<span class="category-badge category-' . esc_attr( $cat->slug ) . '">' . esc_html( $cat->name ) . '</span>';
                    }
                    echo '</div>';
                }
                ?>

                <?php do_action( 'woocommerce_single_product_summary' ); ?>

                <!-- Enhanced product variations display -->
                <?php if ( $product->is_type( 'variable' ) ) : ?>
                    <div class="product-variations-info">
                        <h4>Available Options:</h4>
                        <?php
                        $available_variations = $product->get_available_variations();
                        $variation_attributes = $product->get_variation_attributes();
                        
                        foreach ( $variation_attributes as $attribute_name => $options ) {
                            $attribute_label = wc_attribute_label( $attribute_name );
                            echo '<div class="variation-attribute">';
                            echo '<strong>' . esc_html( $attribute_label ) . ':</strong> ';
                            echo '<span class="attribute-options">' . implode( ', ', $options ) . '</span>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Product features section -->
                <div class="product-features">
                    <h4>Product Features:</h4>
                    <ul class="features-list">
                        <li>High-quality materials</li>
                        <li>Professional manufacturing</li>
                        <li>Bulk orders available</li>
                        <?php if ( $product->is_type( 'variable' ) ) : ?>
                            <li>Multiple size/color options</li>
                        <?php endif; ?>
                        <li>Custom sizing available</li>
                    </ul>
                </div>

                <!-- Bulk order contact section -->
                <div class="bulk-order-contact">
                    <h4>Need Bulk Orders?</h4>
                    <p>Contact us for wholesale pricing and custom orders.</p>
                    <div class="contact-buttons">
                        <a href="tel:<?php echo esc_attr(get_theme_mod('contact_phone', '+92 52 3562143')); ?>" 
                           class="contact-btn phone-btn">
                            📞 Call Now
                        </a>
                        <a href="https://wa.me/<?php echo esc_attr(get_theme_mod('contact_whatsapp', '447516033272')); ?>" 
                           target="_blank"
                           class="contact-btn whatsapp-btn">
                            💬 WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced product description and tabs section -->
    <div class="product-description-section">
        <div class="product-tabs">
            <div class="tab-navigation">
                <button class="tab-btn active" data-tab="description">Description</button>
                <?php if ( $product->is_type( 'variable' ) ) : ?>
                    <button class="tab-btn" data-tab="variations">All Variations</button>
                <?php endif; ?>
                <button class="tab-btn" data-tab="specifications">Specifications</button>
            </div>
            
            <div class="tab-content">
                <div id="description" class="tab-panel active">
                    <?php the_content(); ?>
                    <?php if ( ! get_the_content() && $product->get_description() ) : ?>
                        <?php echo wp_kses_post( $product->get_description() ); ?>
                    <?php endif; ?>
                </div>
                
                <?php if ( $product->is_type( 'variable' ) ) : ?>
                    <div id="variations" class="tab-panel">
                        <h4>All Available Variations:</h4>
                        <div class="variations-grid">
                            <?php
                            $available_variations = $product->get_available_variations();
                            foreach ( $available_variations as $variation ) {
                                $variation_obj = wc_get_product( $variation['variation_id'] );
                                echo '<div class="variation-item">';
                                echo '<div class="variation-attributes">';
                                foreach ( $variation['attributes'] as $attr_name => $attr_value ) {
                                    $attr_label = wc_attribute_label( str_replace( 'attribute_', '', $attr_name ) );
                                    echo '<span class="variation-attr"><strong>' . esc_html( $attr_label ) . ':</strong> ' . esc_html( $attr_value ) . '</span>';
                                }
                                echo '</div>';
                                echo '<div class="variation-price">' . $variation_obj->get_price_html() . '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div id="specifications" class="tab-panel">
                    <h4>Product Specifications:</h4>
                    <ul class="specifications-list">
                        <li><strong>Category:</strong> <?php echo esc_html( $product_cats[0]->name ?? 'General' ); ?></li>
                        <li><strong>SKU:</strong> <?php echo esc_html( $product->get_sku() ?: 'N/A' ); ?></li>
                        <?php if ( $product->get_weight() ) : ?>
                            <li><strong>Weight:</strong> <?php echo esc_html( $product->get_weight() . ' ' . get_option( 'woocommerce_weight_unit' ) ); ?></li>
                        <?php endif; ?>
                        <?php if ( $product->get_dimensions( false ) ) : ?>
                            <li><strong>Dimensions:</strong> <?php echo esc_html( $product->get_dimensions( false ) ); ?></li>
                        <?php endif; ?>
                        <li><strong>Material:</strong> Premium quality materials</li>
                        <li><strong>Bulk Orders:</strong> Available with custom pricing</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php do_action( 'woocommerce_after_single_product_summary' ); ?>

    <!-- Related categories section -->
    <div class="related-categories-section">
        <h3>Browse Other Categories</h3>
        <div class="categories-grid">
            <?php
            $main_categories = array(
                'sportswear' => 'Sportswear',
                'workwear' => 'Workwear', 
                'beekeeping' => 'Beekeeping'
            );
            
            foreach ($main_categories as $slug => $name) {
                $category = get_term_by('slug', $slug, 'product_cat');
                if ($category && $category->slug !== ($product_cats[0]->slug ?? '')) {
                    echo '<a href="' . esc_url(get_term_link($category)) . '" class="category-card">';
                    echo '<div class="category-image">';
                    echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/product-' . $slug . '.jpg') . '" alt="' . esc_attr($name) . '">';
                    echo '</div>';
                    echo '<div class="category-info">';
                    echo '<h4>' . esc_html($name) . '</h4>';
                    echo '<p>View all ' . strtolower($name) . ' products</p>';
                    echo '</div>';
                    echo '</a>';
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and panels
            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanels.forEach(p => p.classList.remove('active'));
            
            // Add active class to clicked button and corresponding panel
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });
});
</script>

<?php do_action( 'woocommerce_after_single_product' ); ?>

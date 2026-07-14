<?php
/**
 * The template for displaying product category archives
 */

get_header(); ?>

<div class="container mx-auto px-4 py-8">
    <?php
    $current_category = get_queried_object();
    $category_name = $current_category->name;
    $category_slug = $current_category->slug;
    ?>
    
    <div class="category-header">
        <h1>
            <?php echo esc_html($category_name); ?>
        </h1>

         <div class="divider mx-auto mb-4"></div>

        <?php if ($current_category->description): ?>
            <p>
                <?php echo wp_kses_post($current_category->description); ?>
            </p>
        <?php endif; ?>
    </div>

    <!-- Products Grid -->
    <?php if (have_posts()): ?>
        <!-- Updated grid to consistent 3 columns: lg:grid-cols-3 instead of xl:grid-cols-4 -->
        <div class="woocommerce">
            <ul class="products columns-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while (have_posts()): the_post(); ?>
                    <?php wc_get_template_part('content', 'product'); ?>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper mt-12">
            <?php
            echo paginate_links(array(
                'prev_text' => '← Previous',
                'next_text' => 'Next →',
                'class' => 'pagination'
            ));
            ?>
        </div>
    <?php else: ?>
        <div class="no-products text-center py-16">
            <div class="bg-gray-800 rounded-lg p-8 max-w-md mx-auto">
                <h3 class="text-2xl font-bold text-white mb-4">No Products Found</h3>
                <p class="text-gray-300 mb-6">We don't have any products in this category yet. Check back soon!</p>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" 
                   class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Browse All Products
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .category-header {
    margin-top: 100px;
    text-align: center;
    }

    .divider {
        margin: 0 auto;
        margin-bottom: 10px;
        margin-top: 10px;
        width: 120px;              
        height: 2px;               
        background: linear-gradient(to right, transparent, #3b82f6, transparent);
        border-radius: 50px;
    }

</style>

<?php get_footer(); ?>

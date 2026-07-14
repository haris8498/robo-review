<?php
/**
 * The template for displaying all pages
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

<main id="main" class="site-main page-main">
    <div class="container page-container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
                <header class="page-header">
                    <h1 class="page-title text-metallic">
                        <?php the_title(); ?>
                    </h1>
                    <div class="section-divider"></div>
                </header>

                <div class="page-content-wrapper glass">
                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'robosports'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </div>

                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="comments-section glass">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>

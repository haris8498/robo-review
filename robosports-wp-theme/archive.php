<?php
/**
 * The template for displaying archive pages
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
        <header class="page-header">
            <h1 class="page-title text-metallic">
                <?php
                if (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    single_tag_title();
                } elseif (is_author()) {
                    printf(__('Posts by %s', 'robosports'), get_the_author());
                } elseif (is_date()) {
                    if (is_year()) {
                        printf(__('Posts from %s', 'robosports'), get_the_date('Y'));
                    } elseif (is_month()) {
                        printf(__('Posts from %s', 'robosports'), get_the_date('F Y'));
                    } else {
                        printf(__('Posts from %s', 'robosports'), get_the_date());
                    }
                } else {
                    _e('Archives', 'robosports');
                }
                ?>
            </h1>
            
            <div class="section-divider"></div>
            
            <?php if (is_category() && category_description()) : ?>
                <div class="page-description">
                    <?php echo category_description(); ?>
                </div>
            <?php endif; ?>
        </header>

        <?php if (have_posts()) : ?>
            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card glass'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <header class="post-header">
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>" class="text-metallic">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                <div class="post-meta">
                                    <time datetime="<?php echo get_the_date('c'); ?>">
                                        📅 <?php echo get_the_date(); ?>
                                    </time>
                                    <span class="author">
                                        👤 <?php the_author(); ?>
                                    </span>
                                </div>
                            </header>
                            
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <footer class="post-footer">
                                <a href="<?php the_permalink(); ?>" class="cyber-button">
                                    <?php _e('Read More', 'robosports'); ?>
                                </a>
                            </footer>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php
            the_posts_pagination(array(
                'prev_text' => __('← Previous', 'robosports'),
                'next_text' => __('Next →', 'robosports'),
                'before_page_number' => '<span class="screen-reader-text">' . __('Page', 'robosports') . ' </span>',
            ));
            ?>
            
        <?php else : ?>
            <div class="no-posts glass page-content-card">
                <h2 class="page-subtitle">
                    <?php _e('Nothing Found', 'robosports'); ?>
                </h2>
                <p class="page-description">
                    <?php _e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'robosports'); ?>
                </p>
                <div class="search-form-centered">
                    <?php get_search_form(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>

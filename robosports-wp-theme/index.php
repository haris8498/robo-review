<?php
/**
 * The main template file
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

<main id="main" class="site-main">
    <div class="container">
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
                                        <?php echo get_the_date(); ?>
                                    </time>
                                    <span class="author">
                                        <?php _e('by', 'robosports'); ?> <?php the_author(); ?>
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
            // Pagination
            the_posts_pagination(array(
                'prev_text' => __('Previous', 'robosports'),
                'next_text' => __('Next', 'robosports'),
            ));
            ?>
            
        <?php else : ?>
            <div class="no-posts glass">
                <h2><?php _e('Nothing Found', 'robosports'); ?></h2>
                <p><?php _e('It seems we can\'t find what you\'re looking for.', 'robosports'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>

<?php
/**
 * The template for displaying all single posts
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
            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                <header class="page-header">
                    <h1 class="page-title text-metallic">
                        <?php the_title(); ?>
                    </h1>
                    
                    <div class="post-meta post-meta-single">
                        <time datetime="<?php echo get_the_date('c'); ?>">
                            📅 <?php echo get_the_date(); ?>
                        </time>
                        <span class="author">
                            👤 <?php _e('by', 'robosports'); ?> <?php the_author(); ?>
                        </span>
                        <?php if (has_category()) : ?>
                            <span class="categories">
                                🏷️ <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="section-divider"></div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail post-thumbnail-single">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

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

                <footer class="post-footer glass">
                    <?php if (has_tag()) : ?>
                        <div class="post-tags">
                            <h3 class="tags-title">
                                <?php _e('Tags:', 'robosports'); ?>
                            </h3>
                            <div class="tags-list">
                                <?php
                                $tags = get_the_tags();
                                if ($tags) {
                                    foreach ($tags as $tag) {
                                        echo '<span class="tag-item">' . $tag->name . '</span>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="post-navigation">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        
                        <?php if ($prev_post) : ?>
                            <a href="<?php echo get_permalink($prev_post); ?>" class="nav-link prev-post">
                                ← <?php _e('Previous Post', 'robosports'); ?>
                            </a>
                        <?php else : ?>
                            <span></span>
                        <?php endif; ?>

                        <?php if ($next_post) : ?>
                            <a href="<?php echo get_permalink($next_post); ?>" class="nav-link next-post">
                                <?php _e('Next Post', 'robosports'); ?> →
                            </a>
                        <?php endif; ?>
                    </div>
                </footer>

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

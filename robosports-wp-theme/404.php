<?php
/**
 * The template for displaying 404 pages (not found)
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
        <div class="error-404 glass page-content-card">
            <div class="error-content">
                <h1 class="error-title text-metallic page-title-large">
                    404
                </h1>
                
                <div class="section-divider"></div>
                
                <h2 class="page-subtitle">
                    <?php _e('Oops! Page not found', 'robosports'); ?>
                </h2>
                
                <p class="page-description">
                    <?php _e('It looks like nothing was found at this location. The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'robosports'); ?>
                </p>
                
                <div class="page-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="cyber-button cyber-glow">
                        <?php _e('Return to Home', 'robosports'); ?>
                    </a>
                    
                    <div class="search-form search-form-centered">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>

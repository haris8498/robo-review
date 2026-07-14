<?php
/**
 * Robosports Theme Functions - Enhanced and Debugged
 */

// Prevent direct access
// Temporary comment to trigger CodeRabbit review.
if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('ROBOSPORTS_VERSION', '1.0.0');
define('ROBOSPORTS_THEME_DIR', get_template_directory());
define('ROBOSPORTS_THEME_URL', get_template_directory_uri());

// Theme setup
function robosports_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
        'unlink-homepage-logo' => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-background');
    add_theme_support('customize-selective-refresh-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');
    
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'robosports'),
        'footer'  => __('Footer Menu', 'robosports'),
    ));
    
    // Set content width
    $GLOBALS['content_width'] = 1200;
    
    // Image Optimizer Plugin Compatibility
    add_theme_support('wp-lazy-loading');
    add_theme_support('webp-uploads');
    if (function_exists('wp_image_editor_supports')) {
        add_theme_support('avif-uploads');
    }
    add_theme_support('responsive-images');
    add_filter('wp_image_editors', 'robosports_image_editors');
    add_filter('jpeg_quality', 'robosports_jpeg_quality');
    add_filter('wp_editor_set_quality', 'robosports_editor_quality');
}
add_action('after_setup_theme', 'robosports_setup');

// Enqueue scripts and styles
function robosports_scripts() {
    // Main stylesheet
    wp_enqueue_style('robosports-style', get_stylesheet_uri(), array(), ROBOSPORTS_VERSION);
    
    // Custom CSS
    wp_enqueue_style('robosports-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), ROBOSPORTS_VERSION);
    
    // JavaScript files
    if (!wp_script_is('jquery', 'enqueued')) {
        wp_enqueue_script('jquery');
    }
    wp_enqueue_script('robosports-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), ROBOSPORTS_VERSION, true);
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Localize script for AJAX
    wp_localize_script('robosports-main', 'robosports_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('robosports_nonce'),
    ));
    
    // Localize theme data
    wp_localize_script('robosports-main', 'robosports_theme', array(
        'template_url' => get_template_directory_uri(),
        'home_url' => home_url(),
        'is_mobile' => wp_is_mobile(),
    ));
}
add_action('wp_enqueue_scripts', 'robosports_scripts');

// Enqueue WooCommerce specific styles
function robosports_woocommerce_styles() {
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('robosports-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array('robosports-style'), ROBOSPORTS_VERSION);
    }
}
add_action('wp_enqueue_scripts', 'robosports_woocommerce_styles');

// Localize product images for JavaScript
function robosports_localize_product_images() {
    $product_images = array(
        'sportswear' => robosports_get_image_data('product_image_sportswear', '/assets/images/product-sportswear.jpg', 'Sportswear Products'),
        'workwear' => robosports_get_image_data('product_image_workwear', '/assets/images/product-workwear.jpg', 'Workwear Products'),
        'beekeeping' => robosports_get_image_data('product_image_beekeeping', '/assets/images/product-beekeeping.jpg', 'Beekeeping Products'),
    );
    
    wp_localize_script('robosports-main', 'robosports_product_images', $product_images);
}
add_action('wp_enqueue_scripts', 'robosports_localize_product_images', 11);

// Load FontAwesome icons
function load_fontawesome_icons() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');
}
add_action('wp_enqueue_scripts', 'load_fontawesome_icons');

// Register widget areas
function robosports_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'robosports'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'robosports'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer 1', 'robosports'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here.', 'robosports'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 2', 'robosports'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here.', 'robosports'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 3', 'robosports'),
        'id'            => 'footer-3',
        'description'   => __('Add widgets here.', 'robosports'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'robosports_widgets_init');

// Customizer settings
function robosports_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('robosports_hero', array(
        'title'    => __('Hero Section', 'robosports'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('hero_title', array(
        'default'           => __('ROBOSPORTS', 'robosports'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title', 'robosports'),
        'section' => 'robosports_hero',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => __('B2B WHOLESALE Manufacturing', 'robosports'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'robosports'),
        'section' => 'robosports_hero',
        'type'    => 'textarea',
    ));

    // Hero Images
    $wp_customize->add_setting('hero_image_1', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_image_1', array(
        'label'     => __('Hero Image 1 (Sportswear)', 'robosports'),
        'section'   => 'robosports_hero',
        'mime_type' => 'image',
    )));

    $wp_customize->add_setting('hero_image_2', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_image_2', array(
        'label'     => __('Hero Image 2 (Workwear)', 'robosports'),
        'section'   => 'robosports_hero',
        'mime_type' => 'image',
    )));

    $wp_customize->add_setting('hero_image_3', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_image_3', array(
        'label'     => __('Hero Image 3 (Beekeeping)', 'robosports'),
        'section'   => 'robosports_hero',
        'mime_type' => 'image',
    )));

    // Product Images Section
    $wp_customize->add_section('robosports_products', array(
        'title'    => __('Product Images', 'robosports'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('product_image_sportswear', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'product_image_sportswear', array(
        'label'     => __('Sportswear Product Image', 'robosports'),
        'section'   => 'robosports_products',
        'mime_type' => 'image',
    )));

    $wp_customize->add_setting('product_image_workwear', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'product_image_workwear', array(
        'label'     => __('Workwear Product Image', 'robosports'),
        'section'   => 'robosports_products',
        'mime_type' => 'image',
    )));

    $wp_customize->add_setting('product_image_beekeeping', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'product_image_beekeeping', array(
        'label'     => __('Beekeeping Product Image', 'robosports'),
        'section'   => 'robosports_products',
        'mime_type' => 'image',
    )));
    
    // Contact Information
    $wp_customize->add_section('robosports_contact', array(
        'title'    => __('Contact Information', 'robosports'),
        'priority' => 40,
    ));
    
    $wp_customize->add_setting('contact_phone', array(
        'default'           => '+92 52 3562143 / +44 7516 033272',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_phone', array(
        'label'   => __('Phone Number', 'robosports'),
        'section' => 'robosports_contact',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('contact_whatsapp', array(
        'default'           => '447516033272',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_whatsapp', array(
        'label'       => __('WhatsApp Number', 'robosports'),
        'description' => __('Enter without + or country code', 'robosports'),
        'section'     => 'robosports_contact',
        'type'        => 'text',
    ));

    $wp_customize->add_setting('contact_email', array(
        'default'           => 'info@robosports.biz',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('contact_email', array(
        'label'   => __('Email Address', 'robosports'),
        'section' => 'robosports_contact',
        'type'    => 'email',
    ));
    
    $wp_customize->add_setting('contact_address', array(
        'default' => 'FF4X+8F6, Daska Rd, Miani, Sialkot, Pakistan',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('contact_address', array(
        'label' => __('Address', 'robosports'),
        'section' => 'robosports_contact',
        'type' => 'textarea',
    ));
    
    // Colors
    $wp_customize->add_section('robosports_colors', array(
        'title'    => __('Theme Colors', 'robosports'),
        'priority' => 50,
    ));

    $wp_customize->add_setting('primary_color', array(
        'default'           => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'   => __('Primary Color', 'robosports'),
        'section' => 'robosports_colors',
    )));

    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#1d4ed8',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'   => __('Secondary Color', 'robosports'),
        'section' => 'robosports_colors',
    )));

    // Image Optimization Section
    $wp_customize->add_section('robosports_image_optimization', array(
        'title'    => __('Image Optimization', 'robosports'),
        'priority' => 45,
    ));
    
    $wp_customize->add_setting('enable_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('enable_lazy_loading', array(
        'label'   => __('Enable Lazy Loading', 'robosports'),
        'section' => 'robosports_image_optimization',
        'type'    => 'checkbox',
    ));
    
    $wp_customize->add_setting('webp_support', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('webp_support', array(
        'label'   => __('Enable WebP Support', 'robosports'),
        'section' => 'robosports_image_optimization',
        'type'    => 'checkbox',
    ));
    
    $wp_customize->add_setting('image_quality', array(
        'default'           => 85,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('image_quality', array(
        'label'       => __('JPEG Quality', 'robosports'),
        'description' => __('Set JPEG compression quality (1-100)', 'robosports'),
        'section'     => 'robosports_image_optimization',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 100,
            'step' => 1,
        ),
    ));
}
add_action('customize_register', 'robosports_customize_register');

// Helper function to get image URL from customizer
function robosports_get_image_url($setting_name, $fallback_path = '', $size = 'full') {
    $image_id = get_theme_mod($setting_name);
    if ($image_id) {
        // Get optimized image URL with size support
        if ($size === 'full') {
            $image_url = wp_get_attachment_image_url($image_id, 'full');
        } else {
            $image_data = wp_get_attachment_image_src($image_id, $size);
            $image_url = $image_data ? $image_data[0] : false;
        }
        
        if ($image_url) {
            return $image_url;
        }
    }
    
    // Fallback to theme assets if no image is set
    if ($fallback_path) {
        return get_template_directory_uri() . $fallback_path;
    }
    
    return '';
}

// Helper function to get image with alt text
function robosports_get_image_data($setting_name, $fallback_path = '', $fallback_alt = '') {
    $image_id = get_theme_mod($setting_name);
    if ($image_id) {
        $image_url = wp_get_attachment_image_url($image_id, 'full');
        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        if ($image_url) {
            return array(
                'url' => $image_url,
                'alt' => $image_alt ?: $fallback_alt
            );
        }
    }
    
    // Fallback to theme assets if no image is set
    if ($fallback_path) {
        return array(
            'url' => get_template_directory_uri() . $fallback_path,
            'alt' => $fallback_alt
        );
    }
    
    return array('url' => '', 'alt' => '');
}

// Output custom CSS
function robosports_custom_css() {
    $primary_color = get_theme_mod('primary_color', '#3b82f6');
    $secondary_color = get_theme_mod('secondary_color', '#1d4ed8');
    ?>
    <style type="text/css">
        :root {
            --primary: <?php echo esc_attr($primary_color); ?>;
            --secondary: <?php echo esc_attr($secondary_color); ?>;
            --cyber-glow: <?php echo esc_attr($primary_color); ?>
        }
    </style>
    <?php
}
add_action('wp_head', 'robosports_custom_css');

// WooCommerce customizations
if (class_exists('WooCommerce')) {
    // Remove WooCommerce styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');

    function robosports_fix_woocommerce_logging() {
        // Fix WooCommerce logging directory issues on Windows/XAMPP
        add_filter('woocommerce_logger_log_directory', 'robosports_wc_log_directory');
        add_filter('pre_wp_is_writable', 'robosports_fix_wp_is_writable', 10, 2);
        
        // Ensure log directory exists
        $upload_dir = wp_upload_dir();
        $log_dir = $upload_dir['basedir'] . '/wc-logs';
        
        if (!file_exists($log_dir)) {
            wp_mkdir_p($log_dir);
        }
        
        // Create .htaccess file for security
        $htaccess_file = $log_dir . '/.htaccess';
        if (!file_exists($htaccess_file)) {
            file_put_contents($htaccess_file, "deny from all\n");
        }
    }
    add_action('init', 'robosports_fix_woocommerce_logging', 1);
    
    // Custom log directory function
    function robosports_wc_log_directory($log_dir) {
        $upload_dir = wp_upload_dir();
        $custom_log_dir = $upload_dir['basedir'] . '/wc-logs';
        
        // Ensure directory exists and is writable
        if (!file_exists($custom_log_dir)) {
            wp_mkdir_p($custom_log_dir);
        }
        
        return $custom_log_dir;
    }
    
    // Fix wp_is_writable function for Windows
    function robosports_fix_wp_is_writable($override, $path) {
        // Only handle if path is false or empty (the source of the error)
        if ($path === false || empty($path)) {
            return false;
        }
        
        // Let WordPress handle valid paths normally
        return $override;
    }
    
    // Disable WooCommerce logging temporarily if issues persist
    function robosports_disable_wc_logging_on_error() {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            // Only disable in debug mode to prevent issues
            add_filter('woocommerce_logging_should_log', '__return_false');
        }
    }
    add_action('init', 'robosports_disable_wc_logging_on_error', 0);

    // Add WooCommerce support
    function robosports_woocommerce_setup() {
        add_theme_support('woocommerce', array(
            'thumbnail_image_width' => 300,
            'single_image_width'    => 600,
            'product_grid'          => array(
                'default_rows'    => 3,
                'min_rows'        => 2,
                'max_rows'        => 8,
                'default_columns' => 3, // Changed from 4 to 3
                'min_columns'     => 2,
                'max_columns'     => 3, // Changed from 5 to 3
            ),
        ));
    }
    add_action('after_setup_theme', 'robosports_woocommerce_setup');

    // Customize WooCommerce wrapper
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    function robosports_woocommerce_wrapper_start() {
        echo '<main id="main" class="site-main woocommerce-main">';
    }
    add_action('woocommerce_before_main_content', 'robosports_woocommerce_wrapper_start', 10);

    function robosports_woocommerce_wrapper_end() {
        echo '</main>';
    }
    add_action('woocommerce_after_main_content', 'robosports_woocommerce_wrapper_end', 10);

    // Add cart count to AJAX response
    function robosports_add_to_cart_fragment($fragments) {
        $cart_count = WC()->cart->get_cart_contents_count();
        
        if ($cart_count > 0) {
            $fragments['.cart-count'] = '<span class="cart-count" style="background: #ef4444; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; margin-left: 4px;">' . $cart_count . '</span>';
            $fragments['.mobile-cart-count'] = '<span class="mobile-cart-count" style="background: #ef4444; color: white; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; position: absolute; top: -8px; right: -8px;">' . $cart_count . '</span>';
        } else {
            $fragments['.cart-count'] = '';
            $fragments['.mobile-cart-count'] = '';
        }
        
        return $fragments;
    }
    add_filter('woocommerce_add_to_cart_fragments', 'robosports_add_to_cart_fragment');
}

// Custom post excerpt length
function robosports_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'robosports_excerpt_length');

// Custom excerpt more
function robosports_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'robosports_excerpt_more');

// Add custom image sizes
function robosports_image_sizes() {
    add_image_size('robosports-hero', 1920, 1080, true);
    add_image_size('robosports-product', 400, 400, true);
    add_image_size('robosports-thumbnail', 300, 300, true);
}
add_action('after_setup_theme', 'robosports_image_sizes');

// Security enhancements
function robosports_security() {
    // Remove WordPress version from head
    remove_action('wp_head', 'wp_generator');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove Windows Live Writer link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
}
add_action('init', 'robosports_security');

// Performance optimizations
function robosports_performance() {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Remove jQuery migrate
    function robosports_remove_jquery_migrate($scripts) {
        if (!is_admin() && isset($scripts->registered['jquery'])) {
            $script = $scripts->registered['jquery'];
            if ($script->deps) {
                $script->deps = array_diff($script->deps, array('jquery-migrate'));
            }
        }
    }
    add_action('wp_default_scripts', 'robosports_remove_jquery_migrate');
}
add_action('init', 'robosports_performance');

// Custom logo function for backward compatibility
function robosports_get_custom_logo() {
    if (has_custom_logo()) {
        return get_custom_logo();
    }
    
    // Fallback to default logo
    $logo_url = get_template_directory_uri() . '/assets/images/logo.png';
    $site_name = get_bloginfo('name');
    
    return sprintf(
        '<a href="%1$s" class="custom-logo-link" rel="home"><img src="%2$s" class="custom-logo" alt="%3$s" style="height: 45px; width: auto; max-width: 200px; object-fit: contain;"></a>',
        esc_url(home_url('/')),
        esc_url($logo_url),
        esc_attr($site_name)
    );
}

// AJAX search functionality with proper nonce verification
function robosports_ajax_search() {
    $nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
    if (!wp_verify_nonce($nonce, 'robosports_nonce')) {
        wp_die('Security check failed');
    }
    
    $search_term = isset($_POST['query']) ? sanitize_text_field(wp_unslash($_POST['query'])) : '';
    
    if (empty($search_term) || strlen($search_term) < 2) {
        wp_send_json_error('Search term too short');
    }
    
    $args = array(
        's' => $search_term,
        'post_type' => array('post', 'page', 'product'),
        'posts_per_page' => 5,
        'post_status' => 'publish'
    );
    
    $search_query = new WP_Query($args);
    $results = array();
    
    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            $results[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'excerpt' => wp_trim_words(get_the_excerpt(), 15)
            );
        }
        wp_reset_postdata();
        wp_send_json_success($results);
    } else {
        wp_send_json_error('No results found');
    }
}
add_action('wp_ajax_robosports_live_search', 'robosports_ajax_search');
add_action('wp_ajax_nopriv_robosports_live_search', 'robosports_ajax_search');

// Contact form handler with proper validation
function robosports_contact_form_handler() {
    $nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
    if (!wp_verify_nonce($nonce, 'robosports_nonce')) {
        wp_send_json_error('Security check failed');
    }
    
    $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error('All fields are required');
    }
    
    if (!is_email($email)) {
        wp_send_json_error('Invalid email address');
    }
    
    // Send email (you can customize this)
    $to = get_option('admin_email');
    $subject = 'New Contact Form Submission from ' . get_bloginfo('name');
    $body = "Name: $name\nEmail: $email\nMessage: $message";
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    if (wp_mail($to, $subject, $body, $headers)) {
        wp_send_json_success('Message sent successfully');
    } else {
        wp_send_json_error('Failed to send message');
    }
}
add_action('wp_ajax_robosports_contact_form', 'robosports_contact_form_handler');
add_action('wp_ajax_nopriv_robosports_contact_form', 'robosports_contact_form_handler');

// Add custom body classes
function robosports_body_classes($classes) {
    // Add class for custom logo
    if (has_custom_logo()) {
        $classes[] = 'has-custom-logo';
    }
    
    // Add class for sidebar
    if (is_active_sidebar('sidebar-1')) {
        $classes[] = 'has-sidebar';
    }
    
    // Add class for WooCommerce pages
    if (class_exists('WooCommerce')) {
        if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
            $classes[] = 'woocommerce-page';
        }
    }
    
    return $classes;
}
add_filter('body_class', 'robosports_body_classes');

// Elementor support
function robosports_elementor_support() {
    add_theme_support('elementor');
}
add_action('after_setup_theme', 'robosports_elementor_support');

// Custom post types for products showcase
function robosports_custom_post_types() {
    // Product Categories
    register_post_type('product_category', array(
        'labels' => array(
            'name' => __('Product Categories', 'robosports'),
            'singular_name' => __('Product Category', 'robosports'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-category',
    ));
}
add_action('init', 'robosports_custom_post_types');

// Support for popular image optimization plugins
function robosports_image_optimization_plugins() {
    // Smush Plugin Support
    if (class_exists('WP_Smush')) {
        add_filter('wp_smush_image', function($image_path) {
            return robosports_image_optimization_integration($image_path, 'Smush');
        });
        add_action('wp_smush_image_optimised', function($image_id) {
            robosports_after_image_optimization($image_id, 'Smush');
        });
    }
    
    // ShortPixel Plugin Support
    if (class_exists('ShortPixelAPI')) {
        add_filter('shortpixel_image_optimised', function($image_path) {
            return robosports_image_optimization_integration($image_path, 'ShortPixel');
        });
        add_action('shortpixel_image_optimised', function($image_id) {
            robosports_after_image_optimization($image_id, 'ShortPixel');
        });
    }
    
    // Imagify Plugin Support
    if (class_exists('Imagify_Plugin')) {
        add_filter('imagify_optimized_attachment', function($image_path) {
            return robosports_image_optimization_integration($image_path, 'Imagify');
        });
        add_action('imagify_optimized_attachment', function($image_id) {
            robosports_after_image_optimization($image_id, 'Imagify');
        });
    }
    
    // EWWW Image Optimizer Support
    if (class_exists('EWWW_Image_Optimizer')) {
        add_filter('ewww_image_optimizer_allowed_types', 'robosports_ewww_allowed_types');
        add_action('ewww_image_optimizer_post_optimization', 'robosports_after_ewww_optimization');
    }
    
    // Optimole Plugin Support
    if (class_exists('Optml_Main')) {
        add_filter('optml_dont_replace_url', 'robosports_optimole_integration');
        add_action('optml_after_optimization', 'robosports_after_optimole_optimization');
    }
    
    // TinyPNG Plugin Support
    if (class_exists('Tiny_Plugin')) {
        add_filter('tinypng_image_optimised', function($image_path) {
            return robosports_image_optimization_integration($image_path, 'TinyPNG');
        });
        add_action('tinypng_image_optimised', function($image_id) {
            robosports_after_image_optimization($image_id, 'TinyPNG');
        });
    }
}
add_action('plugins_loaded', 'robosports_image_optimization_plugins');

// Custom image quality settings
function robosports_jpeg_quality($quality) {
    return 85; // Optimal balance between quality and file size
}

function robosports_editor_quality($quality, $mime_type = null, $context = array()) {
    switch ($mime_type) {
        case 'image/jpeg':
            return 85;
        case 'image/webp':
            return 80;
        case 'image/avif':
            return 75;
        default:
            return $quality;
    }
}
add_filter('wp_editor_set_quality', 'robosports_editor_quality', 10, 3);

// Enhanced image editors priority
function robosports_image_editors($editors) {
    // Prioritize GD over Imagick for better optimization plugin compatibility
    return array('WP_Image_Editor_GD', 'WP_Image_Editor_Imagick');
}

// Lazy loading configuration
function robosports_lazy_loading_attributes($attr, $attachment, $size) {
    // Skip lazy loading for above-the-fold images
    if (is_front_page() && in_array($size, array('robosports-hero', 'full'))) {
        $attr['loading'] = 'eager';
    } else {
        $attr['loading'] = 'lazy';
    }
    
    // Add decoding attribute for better performance
    $attr['decoding'] = 'async';
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'robosports_lazy_loading_attributes', 10, 3);

// WebP support for theme images
function robosports_webp_support($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    // Check if WebP version exists
    $webp_src = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $image_src);
    
    if (file_exists(str_replace(wp_upload_dir()['baseurl'], wp_upload_dir()['basedir'], $webp_src))) {
        $sources[] = array(
            'url' => $webp_src,
            'descriptor' => 'w',
            'value' => $size_array[0],
        );
    }
    
    return $sources;
}
add_filter('wp_calculate_image_srcset', 'robosports_webp_support', 10, 5);

// Plugin-specific integration functions
function robosports_image_optimization_integration($image_path, $plugin_name = '') {
    // Generic handler for all image optimization plugins
    // Custom handling can be added per plugin if needed in the future
    return $image_path;
}

function robosports_after_image_optimization($image_id, $plugin_name = '') {
    // Generic post-optimization handler for all plugins
    robosports_clear_image_cache($image_id);
    
    // Log optimization if needed
    if (defined('WP_DEBUG') && WP_DEBUG && $plugin_name) {
        error_log("RoboSports: Image {$image_id} optimized by {$plugin_name}");
    }
}

function robosports_ewww_allowed_types($allowed_types) {
    // Ensure all theme image types are supported
    $theme_types = array('image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif');
    return array_merge($allowed_types, $theme_types);
}

function robosports_after_ewww_optimization($image_id) {
    // Clear any theme-specific image caches
    robosports_clear_image_cache($image_id);
}

function robosports_optimole_integration($should_replace) {
    // Allow Optimole to handle theme images
    return false;
}

function robosports_after_optimole_optimization($image_id) {
    // Clear any theme-specific image caches
    robosports_clear_image_cache($image_id);
}

// Clear theme image caches after optimization
function robosports_clear_image_cache($image_id) {
    // Clear WordPress image cache
    wp_cache_delete($image_id, 'posts');
    
    // Clear any custom theme caches
    delete_transient('robosports_hero_images');
    delete_transient('robosports_product_images');
    
    // Trigger cache refresh for customizer images
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
    }
}

// Enhanced image handling for theme customizer
function robosports_optimized_image_url($setting_name, $fallback_path = '', $size = 'full') {
    $image_id = get_theme_mod($setting_name);
    if ($image_id) {
        // Get optimized image URL
        $image_data = wp_get_attachment_image_src($image_id, $size);
        if ($image_data) {
            return $image_data[0];
        }
    }
    
    // Fallback to theme assets
    if ($fallback_path) {
        return get_template_directory_uri() . $fallback_path;
    }
    
    return '';
}

// Add image optimization status to admin
function robosports_image_optimization_admin_notice() {
    $optimization_plugins = array(
        'WP_Smush' => 'Smush',
        'ShortPixelAPI' => 'ShortPixel',
        'Imagify_Plugin' => 'Imagify',
        'EWWW_Image_Optimizer' => 'EWWW Image Optimizer',
        'Optml_Main' => 'Optimole',
        'Tiny_Plugin' => 'TinyPNG'
    );
    
    $active_plugins = array();
    foreach ($optimization_plugins as $class => $name) {
        if (class_exists($class)) {
            $active_plugins[] = $name;
        }
    }
    
    if (!empty($active_plugins) && current_user_can('manage_options')) {
        echo '<div class="notice notice-success"><p>';
        echo '<strong>Robosports Theme:</strong> Image optimization active with ' . implode(', ', $active_plugins);
        echo '</p></div>';
    }
}
add_action('admin_notices', 'robosports_image_optimization_admin_notice');

// Apply customizer image optimization settings
function robosports_apply_image_settings() {
    // Apply lazy loading setting
    if (!get_theme_mod('enable_lazy_loading', true)) {
        remove_filter('wp_get_attachment_image_attributes', 'robosports_lazy_loading_attributes');
    }
    
    // Apply WebP support setting
    if (!get_theme_mod('webp_support', true)) {
        remove_filter('wp_calculate_image_srcset', 'robosports_webp_support');
    }
    
    // Apply custom image quality
    $custom_quality = get_theme_mod('image_quality', 85);
    if ($custom_quality !== 85) {
        add_filter('jpeg_quality', function() use ($custom_quality) {
            return $custom_quality;
        });
    }
}
add_action('wp', 'robosports_apply_image_settings');

// Custom walker class for dropdown menu support
class Robosports_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    // Start Level - Add dropdown class to parent items
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    // End Level
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    // Start Element - Add has-dropdown class to parent items
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Check if item has children
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children) {
            $classes[] = 'has-dropdown';
        }

        // Add nav-item class for styling
        if ($depth === 0) {
            $classes[] = 'nav-item';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';

        // Add appropriate classes for different menu levels
        $link_class = ($depth === 0) ? 'nav-link' : 'dropdown-link';
        $attributes .= ' class="' . $link_class . '"';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes .'>';
        
        $item_output .= isset($args->link_before) ? $args->link_before : '';
        $item_output .= '<span>' . apply_filters('the_title', $item->title, $item->ID) . '</span>';
        $item_output .= isset($args->link_after) ? $args->link_after : '';
        
        // Add dropdown arrow for parent items
        if ($has_children && $depth === 0) {
            $item_output .= '<span class="dropdown-arrow">▼</span>';
        }
        
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    // End Element
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

function robosports_woocommerce_loop_columns() {
    return 3; // 3 products per row on desktop to match the image layout
}
add_filter('loop_shop_columns', 'robosports_woocommerce_loop_columns');

function robosports_force_shop_columns() {
    return 3;
}
add_filter('woocommerce_output_related_products_args', function($args) {
    $args['columns'] = 3;
    return $args;
});

function robosports_woocommerce_products_per_page() {
    return 9; // Show 9 products per page (3 rows of 3)
}
add_filter('loop_shop_per_page', 'robosports_woocommerce_products_per_page', 20);

// Remove default WooCommerce single product hooks and add custom ones
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

// Add custom product title with enhanced styling
function robosports_custom_single_product_title() {
    echo '<h1 class="product_title entry-title text-3xl font-bold text-gray-900 mb-4">' . get_the_title() . '</h1>';
}
add_action('woocommerce_single_product_summary', 'robosports_custom_single_product_title', 5);

// Add custom product price with enhanced styling
function robosports_custom_single_product_price() {
    global $product;
    echo '<div class="price-wrapper mb-6">';
    echo '<span class="price text-3xl font-bold text-red-500">' . $product->get_price_html() . '</span>';
    echo '</div>';
}
add_action('woocommerce_single_product_summary', 'robosports_custom_single_product_price', 10);

// Automatic product category creation and enhanced WooCommerce functionality
function robosports_create_product_categories() {
    if (!class_exists('WooCommerce')) {
        return;
    }

    $categories = array(
        'sportswear' => array(
            'name' => 'Sportswear',
            'slug' => 'sportswear',
            'description' => 'High-quality sportswear for all your athletic needs'
        ),
        'workwear' => array(
            'name' => 'Workwear',
            'slug' => 'workwear', 
            'description' => 'Professional workwear and safety equipment'
        ),
        'beekeeping' => array(
            'name' => 'Beekeeping',
            'slug' => 'beekeeping',
            'description' => 'Complete beekeeping supplies and equipment'
        )
    );

    foreach ($categories as $category) {
        if (!term_exists($category['slug'], 'product_cat')) {
            $result = wp_insert_term(
                $category['name'],
                'product_cat',
                array(
                    'slug' => $category['slug'],
                    'description' => $category['description']
                )
            );
            
            // Log successful category creation
            if (!is_wp_error($result)) {
                error_log('RoboSports: Created product category - ' . $category['name']);
            }
        }
    }
}
add_action('init', 'robosports_create_product_categories');

function robosports_setup_custom_cart_page() {
    // Disable WooCommerce default cart redirects
    remove_action('template_redirect', 'wc_redirect_to_cart_redirect_url');
    
    // Override WooCommerce cart page setting
    add_filter('woocommerce_get_cart_url', function() {
        return home_url('/cart/');
    });

    // Override checkout URL to point to custom cart
    add_filter('woocommerce_get_checkout_url', function() {
        return home_url('/cart/');
    });

    add_filter('woocommerce_add_to_cart_redirect', function($url) {
        return home_url('/cart/');
    });
    
    add_filter('woocommerce_add_to_cart_fragments', function($fragments) {
        $fragments['redirect_to_cart'] = home_url('/cart/');
        return $fragments;
    });
}
add_action('init', 'robosports_setup_custom_cart_page');

function robosports_ajax_add_to_cart() {
    ob_start();
    
    try {
        $nonce = isset($_POST['security']) ? sanitize_text_field(wp_unslash($_POST['security'])) : '';
        if (empty($nonce) || !wp_verify_nonce($nonce, 'wc_add_to_cart')) {
            wp_send_json_error(array('message' => 'Security check failed'));
            return;
        }

        // Get product data
        $product_id = isset($_POST['product_id']) ? intval(wp_unslash($_POST['product_id'])) : 0;
        $quantity = isset($_POST['quantity']) ? intval(wp_unslash($_POST['quantity'])) : 1;
        $quantity = $quantity ?: 1;
        $variation_id = isset($_POST['variation_id']) ? intval(wp_unslash($_POST['variation_id'])) : 0;
        $variation_id = $variation_id ?: 0;
        
        // Get variation attributes
        $variation = array();
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'attribute_') === 0) {
                $variation[$key] = sanitize_text_field(wp_unslash($value));
            }
        }

        // Add to cart
        $cart_item_key = WC()->cart->add_to_cart(
            $product_id, 
            $quantity, 
            $variation_id, 
            $variation
        );

        if ($cart_item_key) {
            wp_send_json_success(array(
                'message' => 'Product added to cart!',
                'cart_count' => WC()->cart->get_cart_contents_count(),
                'redirect_url' => wc_get_cart_url()
            ));
        } else {
            $error_message = 'Failed to add to cart';
            $notices = wc_get_notices('error');
            if (!empty($notices)) {
                $error_message = $notices[0]['notice'];
                wc_clear_notices();
            }
            wp_send_json_error(array('message' => $error_message));
        }
        
    } catch (Exception $e) {
        wp_send_json_error(array('message' => 'Error: ' . $e->getMessage()));
    }
}
add_action('wp_ajax_robosports_add_to_cart', 'robosports_ajax_add_to_cart');
add_action('wp_ajax_nopriv_robosports_add_to_cart', 'robosports_ajax_add_to_cart');

// Allow products without a price to be added to cart
add_filter('woocommerce_is_purchasable', '__return_true');

// Replace price display with "—"
add_filter('woocommerce_get_price_html', function($price, $product) {
    return ''; // hide all prices
}, 10, 2);

// Force empty variation prices to 0 so Woo sees them
add_filter('woocommerce_product_variation_get_price', function($price, $product) {
    return $price ?: 0;
}, 10, 2);

add_filter('woocommerce_product_variation_get_regular_price', function($price, $product) {
    return $price ?: 0;
}, 10, 2);

add_filter('woocommerce_product_variation_get_sale_price', function($price, $product) {
    return $price ?: 0;
}, 10, 2);

function robosports_get_cart_count() {
    wp_send_json_success(array(
        'count' => WC()->cart->get_cart_contents_count()
    ));
}
add_action('wp_ajax_get_cart_count', 'robosports_get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'robosports_get_cart_count');

function robosports_rename_cod_payment_method($title, $payment_id) {
    if ($payment_id === 'cod') {
        $title = 'Confirm Order';
    }
    return $title;
}
add_filter('woocommerce_gateway_title', 'robosports_rename_cod_payment_method', 10, 2);

function robosports_custom_product_permalink($permalink, $post, $leavename) {
    if ($post->post_type !== 'product') {
        return $permalink;
    }
    
    $terms = get_the_terms($post->ID, 'product_cat');
    if ($terms && !is_wp_error($terms)) {
        $category = $terms[0];
        $parent_category = '';
        
        if ($category->parent) {
            $parent = get_term($category->parent, 'product_cat');
            $parent_category = $parent->slug . '/';
        }
        
        $permalink = home_url('/' . $parent_category . $category->slug . '/' . $post->post_name . '/');
    }
    
    return $permalink;
}
add_filter('post_type_link', 'robosports_custom_product_permalink', 10, 3);

function robosports_add_product_rewrite_rules() {
    add_rewrite_rule(
        '^([^/]+)/([^/]+)/([^/]+)/?$',
        'index.php?product=$matches[3]',
        'top'
    );
    add_rewrite_rule(
        '^([^/]+)/([^/]+)/?$',
        'index.php?product_cat=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        '^(sportswear|workwear|beekeeping)/?$',
        'index.php?product_cat=$matches[1]',
        'top'
    );
}
add_action('init', 'robosports_add_product_rewrite_rules');

function robosports_auto_assign_product_category($post_id) {
    if (get_post_type($post_id) !== 'product') {
        return;
    }
    
    $product_title = get_the_title($post_id);
    $product_content = get_post_field('post_content', $post_id);
    $search_text = strtolower($product_title . ' ' . $product_content);
    
    // Define keywords for each category with enhanced beekeeping terms
    $category_keywords = array(
        'beekeeping' => array('bee', 'honey', 'hive', 'beekeeping', 'apiary', 'smoker', 'veil', 'frame', 'extractor', 'queen', 'brood', 'wax', 'pollen'),
        'sportswear' => array('sport', 'athletic', 'gym', 'fitness', 'running', 'training', 'jersey', 'shorts', 'tracksuit', 'performance'),
        'workwear' => array('work', 'safety', 'construction', 'industrial', 'protective', 'uniform', 'coverall', 'helmet', 'boots', 'gloves')
    );
    
    // foreach ($category_keywords as $category_slug => $keywords) {
    //     foreach ($keywords as $keyword) {
    //         if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $search_text)) {
    //             $category = get_term_by('slug', $category_slug, 'product_cat');
    //             if ($category) {
    //                 wp_set_post_terms($post_id, array($category->term_id), 'product_cat', true);
    //                 error_log('RoboSports: Auto-assigned product "' . $product_title . '" to category "' . $category_slug . '"');
    //                 break 2; // Exit both loops once a match is found
    //             }
    //         }
    //     }
    // }
}
add_action('save_post', 'robosports_auto_assign_product_category');

function robosports_custom_product_rewrite_rules() {
    add_rewrite_rule(
        '^([^/]+)/([^/]+)/([^/]+)/?$',
        'index.php?product=$matches[3]',
        'top'
    );
}
add_action('init', 'robosports_custom_product_rewrite_rules');

function robosports_add_cart_scripts() {
    if (is_woocommerce() || is_cart()) {
        ?>
        <script>
        function addToCart(productId) {
            const button = document.querySelector(`[data-product-id="${productId}"]`);
            if (!button) return;
            
            // Add loading state
            button.classList.add('loading');
            button.disabled = true;
            
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            
            // Collect form data including variations
            const formData = new FormData();
            formData.append('action', 'robosports_add_to_cart');
            formData.append('product_id', productId);
            formData.append('quantity', 1);
            formData.append('security', '<?php echo wp_create_nonce('wc_add_to_cart'); ?>');
            
            const variationId = window.selectedVariationId || 0;
            // Add variation data if available
            if (variationId) {
                formData.append('variation_id', variationId);
                // Add selected attributes
                document.querySelectorAll('.variation-option.selected').forEach(option => {
                    const attrName = option.closest('.variation-group').dataset.attribute;
                    if (attrName) {
                        formData.append('attribute_' + attrName, option.dataset.value);
                    }
                });
            }
            
            // AJAX request with timeout
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout
            
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData,
                signal: controller.signal
            })
            .then(response => {
                clearTimeout(timeoutId);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Remove loading state
                button.classList.remove('loading');
                button.disabled = false;
                
                if (data.success) {
                    // Show success message
                    button.innerHTML = '<i class="fas fa-check"></i> Added!';
                    button.style.background = '#10b981';
                    
                    // Update cart count if element exists
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount && data.data.cart_count) {
                        cartCount.textContent = data.data.cart_count;
                        cartCount.style.display = 'flex';
                    }
                    
                    // Redirect to custom cart page after 1 second
                    setTimeout(() => {
                        window.location.href = '<?php echo home_url('/cart/'); ?>';
                    }, 1000);
                } else {
                    // Show error
                    button.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + (data.data.message || 'Error');
                    button.style.background = '#ef4444';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.style.background = '';
                    }, 3000);
                }
            })
            .catch(error => {
                clearTimeout(timeoutId);
                button.classList.remove('loading');
                button.disabled = false;
                
                if (error.name === 'AbortError') {
                    button.innerHTML = '<i class="fas fa-clock"></i> Timeout';
                } else {
                    button.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Error';
                }
                button.style.background = '#ef4444';
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.style.background = '';
                }, 3000);
            });
        }
        </script>
        <?php
    }
}
add_action('wp_footer', 'robosports_add_cart_scripts');

// Custom templates for specific pages
function robosports_product_description_page_template($template) {
    if (is_page('product-description') || is_page_template('page-product-description.php')) {
        $new_template = locate_template(array('page-product-description.php'));
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'robosports_product_description_page_template');

function robosports_beekeeping_page_template($template) {
    if (is_page('beekeeping') || is_page_template('page-beekeeping.php')) {
        $new_template = locate_template(array('page-beekeeping.php'));
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'robosports_beekeeping_page_template');

function robosports_redirect_product_to_custom_page() {
    if (is_product()) {
        global $post;
        $product_id = $post->ID;
        $custom_page_url = home_url('/product-description/?product_id=' . $product_id);
        wp_redirect($custom_page_url, 301);
        exit;
    }
}
add_action('template_redirect', 'robosports_redirect_product_to_custom_page');

function robosports_custom_product_permalink_override($permalink, $post, $leavename) {
    if ($post->post_type === 'product') {
        return home_url('/product-description/?product_id=' . $post->ID);
    }
    return $permalink;
}
add_filter('post_type_link', 'robosports_custom_product_permalink_override', 10, 3);

function robosports_finalize_order_direct() {
    try {
        // Quick nonce verification
        if (!wp_verify_nonce($_POST['security'], 'finalize_order_nonce')) {
            wp_send_json_error(array('message' => 'Security verification failed'));
            return;
        }

        // Quick field validation
        $customer_name = isset($_POST['customer_name']) ? sanitize_text_field(wp_unslash($_POST['customer_name'])) : '';
        $customer_phone = isset($_POST['customer_phone']) ? sanitize_text_field(wp_unslash($_POST['customer_phone'])) : '';
        
        if (empty($customer_name) || empty($customer_phone)) {
            wp_send_json_error(array('message' => 'Name and phone required'));
            return;
        }

        $cart_data = WC()->cart->get_cart();
        
        if (empty($cart_data)) {
            wp_send_json_error(array('message' => 'Cart is empty'));
            return;
        }

        $order = wc_create_order();

        foreach ($cart_data as $cart_item) {
            $product_id = $cart_item['product_id'];
            $variation_id = $cart_item['variation_id'];
            $quantity = $cart_item['quantity'];

            $product = wc_get_product($variation_id ? $variation_id : $product_id);
            if ($product) {
                $order->add_product($product, $quantity);
            }
        }

        $name_parts = explode(' ', $customer_name, 2);
        $address = array(
            'first_name' => $name_parts[0],
            'last_name' => isset($name_parts[1]) ? $name_parts[1] : '',
            'phone' => $customer_phone,
        );
        $order->set_address($address, 'billing');

        $order->add_meta_data('_created_via', 'robosports_cart');
        
        $order->calculate_totals();
        $order->save();

        // Clear the cart
        WC()->cart->empty_cart();

        $order_id = $order->get_id();

        wp_send_json_success(array(
            'message' => 'Order created successfully! Order #' . $order_id,
            'order_id' => $order_id
        ));

    } catch (Exception $e) {
        error_log("Order creation error: " . $e->getMessage());
        wp_send_json_error(array('message' => 'Failed to create order. Please try again.'));
    }
}


// ✅ Add the AJAX handler here
add_action('wp_ajax_finalize_order_direct', 'robosports_finalize_order_direct');
add_action('wp_ajax_nopriv_finalize_order_direct', 'robosports_finalize_order_direct');

function robosports_clear_cart() {
    try {
        $nonce = isset($_POST['security']) ? sanitize_text_field(wp_unslash($_POST['security'])) : '';
        if (!wp_verify_nonce($nonce, 'clear_cart_nonce')) {
            wp_send_json_error(array('message' => 'Security verification failed'));
            return;
        }

        // Check if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            wp_send_json_error(array('message' => 'WooCommerce is not active'));
            return;
        }

        // Initialize WooCommerce if needed
        if (!WC()->cart) {
            wc_load_cart();
        }

        // Clear the cart
        WC()->cart->empty_cart();
        
        // Clear any cart cookies
        WC()->cart->maybe_set_cart_cookies();

        wp_send_json_success(array(
            'message' => 'Cart cleared successfully',
            'cart_count' => 0
        ));

    } catch (Exception $e) {
        wp_send_json_error(array('message' => 'Error clearing cart: ' . $e->getMessage()));
    }
}

// Register the AJAX handlers for both logged-in and non-logged-in users
add_action('wp_ajax_clear_cart', 'robosports_clear_cart');
add_action('wp_ajax_nopriv_clear_cart', 'robosports_clear_cart');

// Add "Slider Shortcode" field for variations
add_action( 'woocommerce_product_after_variable_attributes', function( $loop, $variation_data, $variation ){
    woocommerce_wp_text_input( array(
        'id'          => "_slider_shortcode[$loop]",
        'label'       => __( 'Slider Shortcode', 'your-textdomain' ),
        'placeholder' => '[smartslider3 slider="3"]',
        'desc_tip'    => true,
        'description' => __( 'Paste Smart Slider shortcode for this variation.', 'your-textdomain' ),
        'value'       => get_post_meta( $variation->ID, '_slider_shortcode', true ),
    ));
}, 10, 3 );

// Save shortcode
add_action( 'woocommerce_save_product_variation', function( $variation_id, $i ){
    if ( isset($_POST['_slider_shortcode'][$i]) ) {
        update_post_meta( $variation_id, '_slider_shortcode', sanitize_text_field($_POST['_slider_shortcode'][$i]));
    }
}, 10, 2 );

// Pass shortcode into variation JSON
add_filter( 'woocommerce_available_variation', function( $data, $product, $variation ) {
    $shortcode = get_post_meta( $variation->get_id(), '_slider_shortcode', true );
    if ($shortcode) {
        $data['slider_shortcode'] = $shortcode;
        $data['variation_id']     = $variation->get_id();
    }
    return $data;
}, 10, 3 );

if (!function_exists('robosports_fallback_menu')) {
    function robosports_fallback_menu() {
        $pages = wp_list_pages(array(
            'title_li' => '',
            'echo'     => false,
            'depth'    => 1,
        ));

        if ($pages) {
            echo '<ul class="fallback-menu nav-menu-custom">' . $pages . '</ul>';
        } else {
            echo '<ul class="fallback-menu nav-menu-custom"><li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'robosports') . '</a></li></ul>';
        }
    }
}

if (!function_exists('robosports_mobile_menu')) {
    function robosports_mobile_menu() {
        $pages = wp_list_pages(array(
            'title_li' => '',
            'echo'     => false,
            'depth'    => 1,
        ));

        if ($pages) {
            echo '<ul class="fallback-menu mobile-nav-menu">' . $pages . '</ul>';
        } else {
            echo '<ul class="fallback-menu mobile-nav-menu"><li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'robosports') . '</a></li></ul>';
        }
    }
}

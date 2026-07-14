<?php
/**
 * The header template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <script>
    // Localize theme data for JavaScript
    window.robosports_theme = {
        template_url: '<?php echo esc_js(get_template_directory_uri()); ?>',
        home_url: '<?php echo esc_js(home_url()); ?>',
        is_mobile: <?php echo wp_is_mobile() ? 'true' : 'false'; ?>
    };
    </script>
    <meta name="google-site-verification" content="wQb_i-6CvCoEuLt6KvUGAeQY_vm9vHRPAxmiDTgGerA" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main">
        <?php _e('Skip to content', 'robosports'); ?>
    </a>

    <!-- Navigation -->
    <nav id="site-navigation" class="main-navigation">
        <div class="nav-container">
            <div class="nav-content">
                
                <!-- Logo -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="custom-logo-container">
                            <?php 
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            if ($logo && !empty($logo[0])) : ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="custom-logo-link">
                                    <img src="<?php echo esc_url($logo[0]); ?>" 
                                         alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                                         class="custom-logo-img">
                                </a>
                            <?php else : ?>
                                <!-- Fallback for custom logo -->
                                <div class="fallback-logo">
                                    <div class="logo-icon">R</div>
                                    <div class="logo-text">
                                        <div class="site-title">
                                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                                <?php echo esc_html(get_bloginfo('name') ?: 'ROBOSPORTS'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <div class="default-logo-container">
                            <?php 
                            $default_logo_path = get_template_directory_uri() . '/assets/images/logo.png';
                            ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="default-logo-link">
                                <img src="<?php echo esc_url($default_logo_path); ?>" 
                                     alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                                     class="default-logo-img"
                                     onerror="this.style.display='none'; this.parentNode.nextElementSibling.style.display='flex';">
                            </a>
                            <!-- Fallback text logo if image fails to load -->
                            <div class="fallback-logo" style="display: none;">
                                <div class="logo-icon">R</div>
                                <div class="logo-text">
                                    <div class="site-title">
                                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                            <?php echo esc_html(get_bloginfo('name') ?: 'ROBOSPORTS'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Desktop Navigation -->
                <div class="desktop-nav">
                    <nav class="main-menu">
                        <?php
                        if (has_nav_menu('primary')) {
                            wp_nav_menu(array(
                                'theme_location' => 'primary',
                                'menu_id'        => 'primary-menu',
                                'container'      => false,
                                'menu_class'     => 'nav-menu-custom',
                                'fallback_cb'    => 'robosports_fallback_menu',
                                'walker'         => class_exists('Robosports_Walker_Nav_Menu') ? new Robosports_Walker_Nav_Menu() : '',
                            ));
                        } else {
                            robosports_fallback_menu();
                        }
                        ?>
                    </nav>
                </div>

                <!-- Right Side Actions -->
                <div class="nav-actions">
                    <div class="desktop-actions">
                        <a href="https://wa.me/447516033272" target="_blank" rel="noopener noreferrer" class="contact-btn">
                            <span>📞</span>
                            <span><?php _e('Contact', 'robosports'); ?></span>
                        </a>
                        <?php if (class_exists('WooCommerce')) : ?>
                            <a href="<?php echo home_url('/cart/'); ?>" class="cart-btn">
                                <span>🛒</span>
                                <span><?php _e('Cart', 'robosports'); ?></span>
                                <?php 
                                $cart_count = WC()->cart->get_cart_contents_count();
                                if ($cart_count > 0) : ?>
                                    <span class="cart-count"><?php echo $cart_count; ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Toggle mobile menu" aria-expanded="false">
                        <span class="hamburger-icon">☰</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobile-menu" aria-hidden="true">
            <div class="mobile-menu-content">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'mobile-menu-list',
                        'container'      => false,
                        'menu_class'     => 'mobile-nav-menu',
                        'walker'         => class_exists('Robosports_Walker_Nav_Menu') ? new Robosports_Walker_Nav_Menu() : '',
                        'fallback_cb'    => 'robosports_mobile_menu',
                    ));
                } else {
                    robosports_mobile_menu();
                }
                ?>
                
                <div class="mobile-actions">
                    <a href="https://wa.me/447516033272" target="_blank" rel="noopener noreferrer" class="mobile-contact">
                        <span>📞</span>
                        <span><?php _e('Contact Sales', 'robosports'); ?></span>
                    </a>
                    <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo home_url('/cart/'); ?>" class="mobile-cart">
                            <span>🛒</span>
                            <span><?php _e('View Cart', 'robosports'); ?></span>
                            <?php 
                            $cart_count = WC()->cart->get_cart_contents_count();
                            if ($cart_count > 0) : ?>
                                <span class="mobile-cart-count"><?php echo $cart_count; ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>
    </nav>

<style>

* {
    box-sizing: border-box;
}

/* Navigation Bar - Fixed Styling with custom gaps */
.main-navigation {
    position: fixed !important;
    top: 40px;   
    left: 120px;   
    right: 120px;  
    z-index: 1000;
    background: linear-gradient(135deg, rgba(58, 66, 82, 0.2) 0%, rgba(62, 96, 117, 0.3) 100%);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    max-width: calc(100vw - 240px);
    box-sizing: border-box;
}

.main-navigation.scrolled {
    background: linear-gradient(135deg, rgba(26, 35, 50, 0.98) 0%, rgba(45, 74, 92, 0.98) 100%);
    backdrop-filter: blur(25px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
    transform: translateY(-2px);
}

/* Container inside nav */
.nav-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
    box-sizing: border-box;
}

.nav-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 70px;
    box-sizing: border-box;
}

/* Logo Styles */
.custom-logo-img,
.default-logo-img {
    height: 45px;
    width: auto;
    max-width: 200px;
    object-fit: contain;
    transition: all 0.3s ease;
    filter: brightness(1);
}

.custom-logo-img:hover,
.default-logo-img:hover {
    filter: brightness(1.1);
    transform: scale(1.05);
}

.fallback-logo {
    display: flex;
    align-items: center;
    gap: 12px;
}

.logo-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #00d4ff, #0099cc);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    font-size: 18px;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.logo-icon:hover {
    transform: rotate(5deg) scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
}

.site-title {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: white;
    letter-spacing: 2px;
    font-family: var(--font-display);
}

.site-title a {
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.site-title a:hover {
    color: #00d4ff;
    text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
}

/* Desktop Navigation */
.desktop-nav {
    display: flex;
    align-items: center;
    gap: 40px;
}

.nav-menu-custom {
    display: flex;
    align-items: center;
    gap: 32px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.nav-menu-custom li {
    position: relative;
}

.nav-menu-custom li a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
    font-size: 15px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.nav-menu-custom li a .dropdown-arrow {
    font-size: 10px;
    margin-left: 4px;
    transition: transform 0.3s ease;
}

.nav-menu-custom li.has-dropdown:hover a .dropdown-arrow {
    transform: rotate(180deg);
}

/* Dropdown menu styles */
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 220px;
    background: linear-gradient(135deg, rgba(26, 35, 50, 0.98) 0%, rgba(45, 74, 92, 0.98) 100%);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1000;
    padding: 8px 0;
    margin-top: 8px;
    list-style: none;
}

.nav-menu-custom li.has-dropdown:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-menu li {
    margin: 0;
}

.dropdown-link {
    display: flex !important;
    align-items: center;
    gap: 12px !important;
    padding: 12px 20px !important;
    color: rgba(255, 255, 255, 0.8) !important;
    font-weight: 400 !important;
    font-size: 14px !important;
    border-radius: 0 !important;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.dropdown-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 3px;
    height: 100%;
    background: #00d4ff;
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.dropdown-link:hover::before {
    transform: scaleY(1);
}

.dropdown-link:hover {
    background: rgba(0, 212, 255, 0.1) !important;
    color: #00d4ff !important;
    transform: translateX(8px);
}

.nav-menu-custom li a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.1), transparent);
    transition: left 0.5s ease;
}

.nav-menu-custom li a:hover::before {
    left: 100%;
}

.nav-menu-custom li a:hover {
    background: rgba(0, 212, 255, 0.1);
    color: #00d4ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 212, 255, 0.2);
}

.nav-menu-custom li.current-menu-item a {
    background: rgba(0, 212, 255, 0.15);
    color: #00d4ff;
    box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
}

/* Contact and Cart Buttons */
.nav-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-shrink: 0;
}

.desktop-actions {
    display: flex;
    align-items: center;
    gap: 16px;
}

.contact-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
    font-size: 15px;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    height: 40px;
    box-sizing: border-box;
}

.contact-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #3b82f6;
    transform: translateY(-2px);
}

.cart-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    font-weight: 600;
    font-size: 15px;
    padding: 10px 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 40px;
    box-sizing: border-box;
}

.cart-btn::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.cart-btn:hover::before {
    left: 100%;
}

.cart-btn:hover {
    background: linear-gradient(135deg, #1d4ed8, #3b82f6);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4);
}

.cart-count,
.mobile-cart-count {
    background: #ff4444;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    font-weight: bold;
    min-width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 4px;
}

/* Mobile Menu Toggle Button */
.mobile-menu-toggle {
    display: none;
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
    flex-shrink: 0;
    z-index: 1002;
}

.mobile-menu-toggle:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #00d4ff;
}

/* FIXED Mobile Menu - Always Hidden by Default */
.mobile-menu {
    position: fixed;
    top: 120px;
    right: -100%;
    width: 320px;
    height: auto;
    max-height: calc(100vh - 140px);
    background: linear-gradient(135deg, rgba(26, 35, 50, 0.98) 0%, rgba(45, 74, 92, 0.98) 100%);
    backdrop-filter: blur(25px);
    border-left: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px 0 0 16px;
    z-index: 1001;
    transition: right 0.3s ease;
    overflow-y: auto;
    padding: 20px 0;
    box-sizing: border-box;
    opacity: 0;
    visibility: hidden;
}

/* Mobile menu open state */
.mobile-menu.menu-open {
    right: 0 !important;
    opacity: 1 !important;
    visibility: visible !important;
}

.mobile-menu-content {
    padding: 0 20px;
    box-sizing: border-box;
}

.mobile-nav-menu {
    list-style: none;
    margin: 0;
    padding: 0;
}

.mobile-nav-menu li {
    margin-bottom: 8px;
}

.mobile-nav-menu li a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 16px;
}

.mobile-nav-menu li a:hover {
    background: rgba(0, 212, 255, 0.1);
    color: #3b82f6;
}

.mobile-actions {
    margin-top: 32px;
    padding-top: 32px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.mobile-contact,
.mobile-cart {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    margin-bottom: 8px;
}

.mobile-contact:hover,
.mobile-cart:hover {
    background: rgba(0, 212, 255, 0.1);
    color: #3b82f6;
}

/* Mobile Menu Overlay - Always Hidden by Default */
.mobile-menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.mobile-menu-overlay.active {
    opacity: 1 !important;
    visibility: visible !important;
}

/* Mobile dropdown support - FIXED */
@media (max-width: 1360px) {
    .dropdown-menu {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        margin: 8px 0 0 0;
        border-radius: 8px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
        padding: 0;
    }
    
    .mobile-nav-menu li.has-dropdown.mobile-dropdown-open .dropdown-menu {
        max-height: 300px;
        padding: 8px 0;
    }
    
    .dropdown-link {
        padding: 10px 16px !important;
        margin: 0 8px;
        border-radius: 6px !important;
    }

    /* CRITICAL: Hide desktop, show mobile menu button */
    .desktop-nav,
    .desktop-actions {
        display: none !important;
    }

    .mobile-menu-toggle {
        display: block !important;
    }
}

/* Tablet styles */
@media (min-width: 769px) and (max-width: 1400px) {
    .main-navigation {
        top: 20px;
        left: 60px;
        right: 60px;
        border-radius: 14px;
        max-width: calc(100vw - 120px);
    }
    
    .nav-content {
        height: 50px;
    }
    
    .nav-container {
        padding: 0 20px;
    }
    
    .custom-logo-img,
    .default-logo-img {
        height: 30px;
        max-width: 180px;
    }
    
    .logo-icon {
        width: 36px;
        height: 36px;
        font-size: 16px;
    }
    
    .site-title {
        font-size: 20px;
    }
}

/* Mobile (600px – 768px) */
@media (min-width: 600px) and (max-width: 768px) {
    .main-navigation {
        top: 20px;
        left: 40px;
        right: 40px;
        border-radius: 12px;
        max-width: calc(100vw - 80px);
    }
    
    .nav-content {
        height: 50px;
    }
    
    .nav-container {
        padding: 0 16px;
    }
    
    .custom-logo-img,
    .default-logo-img {
        height: 28px;
        max-width: 140px;
    }
    
    .logo-icon {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
    
    .site-title {
        font-size: 18px;
    }
    
    .mobile-menu {
        width: 280px;
        top: 90px;
    }
}

/* Small Mobile (380px – 600px) */
@media (min-width: 380px) and (max-width: 600px) {
    .main-navigation {
        top: 15px;
        left: 20px;
        right: 20px;
        border-radius: 10px;
        max-width: calc(100vw - 40px);
    }
    
    .nav-container {
        padding: 0 12px;
    }
    
    .nav-content {
        height: 48px;
    }
    
    .mobile-menu {
        width: 100%;
        left: 0;
        right: 0;
        top: 78px;
        border-radius: 0 0 12px 12px;
    }
    
    .custom-logo-img,
    .default-logo-img {
        height: 24px;
        max-width: 110px;
    }
    
    .logo-icon {
        width: 28px;
        height: 28px;
        font-size: 12px;
    }
    
    .site-title {
        font-size: 16px;
        letter-spacing: 1px;
    }
}

/* Extra Small Mobile (≤380px) */
@media (max-width: 380px) {
    .main-navigation {
        position: fixed !important;
        top: 15px;
        left: 8px;
        right: 8px;
        width: calc(100vw - 16px) !important;
        max-width: calc(100vw - 16px) !important;
        border-radius: 8px;
        box-sizing: border-box !important;
    }

    .nav-container {
        padding: 0 8px !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        width: 100% !important;
    }
    
    .nav-content {
        height: 52px !important;
        min-height: 52px !important;
        gap: 6px !important;
        flex-wrap: nowrap !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
        width: 100% !important;
    }
    
    .site-branding {
        flex-shrink: 1 !important;
        min-width: 0 !important;
        max-width: calc(100% - 50px) !important;
        overflow: hidden !important;
    }
    
    .custom-logo-img,
    .default-logo-img {
        height: 30px !important;
        max-width: 80px !important;
        object-fit: contain !important;
    }
    
    .logo-icon {
        width: 24px !important;
        height: 24px !important;
        font-size: 11px !important;
        border-radius: 4px !important;
        flex-shrink: 0 !important;
    }
    
    .site-title {
        font-size: 13px !important;
        letter-spacing: 0.5px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .mobile-menu-toggle {
        padding: 4px !important;
        font-size: 16px !important;
        flex-shrink: 0 !important;
        min-width: 36px !important;
        width: 36px !important;
        height: 36px !important;
    }
    
    .mobile-menu {
        width: 100% !important;
        top: 60px !important;
        left: 0 !important;
        right: 0 !important;
        border-radius: 0 0 12px 12px !important;
    }
}

/* Body scroll lock when menu is open */
body.mobile-menu-open {
    overflow: hidden;
}

/* Loading animations */
.custom-logo-img,
.default-logo-img {
    opacity: 0;
    animation: fadeInLogo 0.5s ease-in-out 0.2s forwards;
}

.main-navigation {
    opacity: 0;
    transform: translateY(-20px);
    animation: slideInNav 0.8s ease-out 0.1s forwards;
}

@keyframes slideInNav {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInLogo {
    to {
        opacity: 1;
    }
}
</style>

<script>
// Enhanced navigation functionality with proper mobile menu control
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileOverlay = document.getElementById('mobile-menu-overlay');
    const navigation = document.getElementById('site-navigation');
    const hamburgerIcon = mobileToggle?.querySelector('.hamburger-icon');

    // Initialize menu as closed
    function initializeMobileMenu() {
        if (mobileMenu) {
            mobileMenu.classList.remove('menu-open');
            mobileMenu.style.right = '-100%';
            mobileMenu.setAttribute('aria-hidden', 'true');
        }
        if (mobileOverlay) {
            mobileOverlay.classList.remove('active');
        }
        if (hamburgerIcon) {
            hamburgerIcon.textContent = '☰';
        }
        if (mobileToggle) {
            mobileToggle.setAttribute('aria-expanded', 'false');
        }
        document.body.classList.remove('mobile-menu-open');
    }

    // Initialize on load
    initializeMobileMenu();

    // FIXED: Mobile dropdown handling with proper event handling
    function setupMobileDropdowns() {
        const mobileDropdownItems = document.querySelectorAll('.mobile-nav-menu .has-dropdown > a');
        
        // Remove existing event listeners to prevent duplicates
        mobileDropdownItems.forEach(item => {
            const newItem = item.cloneNode(true);
            item.parentNode.replaceChild(newItem, item);
        });
        
        // Add fresh event listeners
        const freshDropdownItems = document.querySelectorAll('.mobile-nav-menu .has-dropdown > a');
        freshDropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const parentLi = this.parentElement;
                const isOpen = parentLi.classList.contains('mobile-dropdown-open');
                
                // Close all other dropdowns
                document.querySelectorAll('.mobile-nav-menu .has-dropdown').forEach(li => {
                    if (li !== parentLi) {
                        li.classList.remove('mobile-dropdown-open');
                    }
                });
                
                // Toggle current dropdown
                if (isOpen) {
                    parentLi.classList.remove('mobile-dropdown-open');
                } else {
                    parentLi.classList.add('mobile-dropdown-open');
                }
            });
            
            // Add touch event for better mobile support
            item.addEventListener('touchstart', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const parentLi = this.parentElement;
                const isOpen = parentLi.classList.contains('mobile-dropdown-open');
                
                // Close all other dropdowns
                document.querySelectorAll('.mobile-nav-menu .has-dropdown').forEach(li => {
                    if (li !== parentLi) {
                        li.classList.remove('mobile-dropdown-open');
                    }
                });
                
                // Toggle current dropdown
                if (isOpen) {
                    parentLi.classList.remove('mobile-dropdown-open');
                } else {
                    parentLi.classList.add('mobile-dropdown-open');
                }
            });
        });
    }

    // Setup mobile dropdowns initially
    setupMobileDropdowns();

    // Mobile menu toggle functionality
    if (mobileToggle && mobileMenu && mobileOverlay) {
        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isOpen = mobileMenu.classList.contains('menu-open');
            
            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });

        function openMobileMenu() {
            // Ensure menu is visible and positioned correctly
            mobileMenu.style.right = '0';
            mobileMenu.classList.add('menu-open');
            mobileMenu.setAttribute('aria-hidden', 'false');
            
            mobileOverlay.classList.add('active');
            
            if (hamburgerIcon) {
                hamburgerIcon.textContent = '✕';
            }
            if (mobileToggle) {
                mobileToggle.setAttribute('aria-expanded', 'true');
            }
            
            document.body.classList.add('mobile-menu-open');
            
            // Re-setup dropdowns when menu opens
            setupMobileDropdowns();
            
            // Animate menu items
            setTimeout(() => {
                const menuItems = mobileMenu.querySelectorAll('.mobile-nav-menu a, .mobile-actions a');
                menuItems.forEach((item, index) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(20px)';
                    setTimeout(() => {
                        item.style.transition = 'all 0.3s ease';
                        item.style.opacity = '1';
                        item.style.transform = 'translateX(0)';
                    }, index * 50);
                });
            }, 100);
        }

        function closeMobileMenu() {
            mobileMenu.classList.remove('menu-open');
            mobileMenu.style.right = '-100%';
            mobileMenu.setAttribute('aria-hidden', 'true');
            
            mobileOverlay.classList.remove('active');
            
            if (hamburgerIcon) {
                hamburgerIcon.textContent = '☰';
            }
            if (mobileToggle) {
                mobileToggle.setAttribute('aria-expanded', 'false');
            }
            
            document.body.classList.remove('mobile-menu-open');
            
            // Close all dropdowns
            document.querySelectorAll('.mobile-nav-menu .has-dropdown').forEach(li => {
                li.classList.remove('mobile-dropdown-open');
            });
        }

        // Close mobile menu when overlay is clicked
        mobileOverlay.addEventListener('click', function(e) {
            e.preventDefault();
            closeMobileMenu();
        });

        // Close menu when clicking on navigation links (not dropdowns)
        const mobileMenuLinks = mobileMenu.querySelectorAll('a:not(.has-dropdown > a)');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                closeMobileMenu();
            });
        });

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('menu-open')) {
                closeMobileMenu();
            }
        });

        // Prevent menu from staying open on resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1360) {
                closeMobileMenu();
            } else {
                // Re-setup dropdowns on resize for mobile
                setupMobileDropdowns();
            }
        });
    }

    // Navigation scroll effect
    let lastScrollTop = 0;
    let ticking = false;

    function updateNavigation() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (navigation) {
            if (scrollTop > 100) {
                navigation.classList.add('scrolled');
            } else {
                navigation.classList.remove('scrolled');
            }
        }
        
        lastScrollTop = scrollTop;
        ticking = false;
    }

    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateNavigation);
            ticking = true;
        }
    });

    // Logo fallback handling
    const logoImages = document.querySelectorAll('.custom-logo-img, .default-logo-img');
    logoImages.forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const fallback = this.parentNode.nextElementSibling;
            if (fallback && fallback.classList.contains('fallback-logo')) {
                fallback.style.display = 'flex';
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
  // Remove focus from any link/button when mobile menu is hidden
  const mobileMenu = document.getElementById("mobile-menu");

  const observer = new MutationObserver(mutations => {
    mutations.forEach(mutation => {
      if (
        mutation.attributeName === "aria-hidden" &&
        mobileMenu.getAttribute("aria-hidden") === "true"
      ) {
        const focused = mobileMenu.querySelector(":focus");
        if (focused) {
          focused.blur();
        }
      }
    });
  });

  if (mobileMenu) {
    observer.observe(mobileMenu, { attributes: true });
  }
});
</script>

    <main id="main" class="site-main">

<?php
// Fallback functions for menu rendering
if (!function_exists('robosports_render_menu')) {
    function robosports_render_menu($menu_type = 'desktop') {
        $menu_items = array(
            array('title' => 'Home', 'url' => home_url('/')),
            array('title' => 'About Us', 'url' => home_url('/about')),
            array(
                'title' => 'Sportswear', 
                'url' => home_url('/sportswear'), 
                'submenu' => array(
                    array('title' => 'Football Kits', 'url' => home_url('/sportswear/football-kits')),
                    array('title' => 'Basketball Uniforms', 'url' => home_url('/sportswear/basketball-uniforms')),
                    array('title' => 'Running Gear', 'url' => home_url('/sportswear/running-gear')),
                    array('title' => 'Training Wear', 'url' => home_url('/sportswear/training-wear')),
                )
            ),
            array(
                'title' => 'Workwear', 
                'url' => home_url('/workwear'), 
                'submenu' => array(
                    array('title' => 'Safety Vests', 'url' => home_url('/workwear/safety-vests')),
                    array('title' => 'Hard Hats', 'url' => home_url('/workwear/hard-hats')),
                    array('title' => 'Work Boots', 'url' => home_url('/workwear/work-boots')),
                    array('title' => 'Protective Gloves', 'url' => home_url('/workwear/protective-gloves')),
                )
            ),
            array(
                'title' => 'Beekeeping', 
                'url' => home_url('/beekeeping'), 
                'submenu' => array(
                    array('title' => 'Bee Suits', 'url' => home_url('/beekeeping/bee-suits')),
                    array('title' => 'Hive Tools', 'url' => home_url('/beekeeping/hive-tools')),
                    array('title' => 'Smokers', 'url' => home_url('/beekeeping/smokers')),
                    array('title' => 'Protective Gear', 'url' => home_url('/beekeeping/protective-gear')),
                )
            ),
            array('title' => 'Contact', 'url' => home_url('/contact')),
        );

        $menu_class = ($menu_type === 'mobile') ? 'mobile-nav-menu' : 'nav-menu-custom';
        $item_class = ($menu_type === 'mobile') ? '' : 'nav-item';
        $link_class = ($menu_type === 'mobile') ? '' : 'nav-link';
        $dropdown_class = ($menu_type === 'mobile') ? 'dropdown-menu' : 'dropdown-menu';
        $dropdown_link_class = 'dropdown-link';

        echo '<ul class="' . $menu_class . '">';
        foreach ($menu_items as $item) {
            $has_dropdown = isset($item['submenu']) ? ' has-dropdown' : '';
            echo '<li class="' . $item_class . $has_dropdown . '">';
            
            if (isset($item['submenu'])) {
                echo '<a href="' . esc_url($item['url']) . '" class="' . $link_class . '">';
                echo esc_html($item['title']);
                echo '<span class="dropdown-arrow">▼</span>';
                echo '</a>';
                
                echo '<ul class="' . $dropdown_class . '">';
                foreach ($item['submenu'] as $subitem) {
                    echo '<li>';
                    echo '<a href="' . esc_url($subitem['url']) . '" class="' . $dropdown_link_class . '">';
                    echo esc_html($subitem['title']);
                    echo '</a>';
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo '<a href="' . esc_url($item['url']) . '" class="' . $link_class . '">';
                echo esc_html($item['title']);
                echo '</a>';
            }
            
            echo '</li>';
        }
        echo '</ul>';
    }
}

if (!function_exists('robosports_fallback_menu')) {
    function robosports_fallback_menu() {
        robosports_render_menu('desktop');
    }
}

if (!function_exists('robosports_mobile_menu')) {
    function robosports_mobile_menu() {
        robosports_render_menu('mobile');
    }
}
?>


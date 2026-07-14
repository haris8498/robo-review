<?php
/**
 * The front page template
 */

if (!function_exists('get_header')) {
    $wp_load = dirname(__FILE__) . '/../../../../wp-load.php';
    if (file_exists($wp_load)) {
        require_once $wp_load;
    } else {
        die('WordPress bootstrap failed.');
    }
}

get_header(); 

// Get hero images from customizer
$hero_image_1 = robosports_get_image_data('hero_image_1', '/assets/images/hero-sports.jpg', 'Advanced Sportswear');
$hero_image_2 = robosports_get_image_data('hero_image_2', '/assets/images/hero-workwear.jpg', 'Industrial Workwear');
$hero_image_3 = robosports_get_image_data('hero_image_3', '/assets/images/hero-beekeeping.jpg', 'Specialized Beekeeping');

// Get product images from customizer
$product_sportswear = robosports_get_image_data('product_image_sportswear', '/assets/images/product-sportswear.jpg', 'Sportswear Products');
$product_workwear = robosports_get_image_data('product_image_workwear', '/assets/images/product-workwear.jpg', 'Workwear Products');
$product_beekeeping = robosports_get_image_data('product_image_beekeeping', '/assets/images/product-beekeeping.jpg', 'Beekeeping Products');
?>

<!-- AOS CSS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    AOS.init({
      duration: 1000, // 1s animation
      once: true,     // animate only once
      offset: 100,    // trigger slightly before element is in view
    });
  });
</script>

<!-- Hero Section -->
<section class="hero-section" style="position: relative; min-height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; padding-top: 140px; padding-bottom: 40px;">
    <!-- Background Slider -->
    <div class="hero-background" style="position: absolute; inset: 0; z-index: 0;">
        <div class="hero-slide active" style="position: absolute; inset: 0; opacity: 1; transition: opacity 1.5s ease-in-out;">
            <img src="<?php echo esc_url($hero_image_1['url']); ?>" alt="<?php echo esc_attr($hero_image_1['alt']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
            <div class="hero-overlay" style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(20, 20, 20, 0.7) 0%, rgba(20, 20, 20, 0.4) 50%, rgba(20, 20, 20, 0.8) 100%);"></div>
        </div>
        <div class="hero-slide" style="position: absolute; inset: 0; opacity: 0; transition: opacity 1.5s ease-in-out;">
            <img src="<?php echo esc_url($hero_image_2['url']); ?>" alt="<?php echo esc_attr($hero_image_2['alt']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
            <div class="hero-overlay" style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(20, 20, 20, 0.7) 0%, rgba(20, 20, 20, 0.4) 50%, rgba(20, 20, 20, 0.8) 100%);"></div>
        </div>
        <div class="hero-slide" style="position: absolute; inset: 0; opacity: 0; transition: opacity 1.5s ease-in-out;">
            <img src="<?php echo esc_url($hero_image_3['url']); ?>" alt="<?php echo esc_attr($hero_image_3['alt']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
            <div class="hero-overlay" style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(20, 20, 20, 0.7) 0%, rgba(20, 20, 20, 0.4) 50%, rgba(20, 20, 20, 0.8) 100%);"></div>
        </div>
    </div>

    <!-- Industrial Grid Overlay -->
    <div class="industrial-grid" style="position: absolute; inset: 0; opacity: 0.2; z-index: 10; background-image: linear-gradient(rgba(51, 51, 51, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(51, 51, 51, 0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>

    <!-- Content -->
    <div class="hero-content" style="position: relative; z-index: 30; text-align: center; max-width: 1200px; margin: 0 auto; padding: 0 24px;">
        <div class="hero-text" style="display: flex; flex-direction: column; gap: 32px;">
            <!-- Logo -->
            <h1 class="hero-title text-metallic" style="font-size: clamp(46px, 6vw, 124px); font-family: var(--font-display); font-weight: 900; letter-spacing: 0.001em; margin: 0;">
                <?php echo esc_html(get_theme_mod('hero_title', 'ROBO SPORTS')); ?>
            </h1>

            <!-- Subtitle -->
            <div class="hero-subtitle" style="display: flex; flex-direction: column; align-items: center; gap: 16px;">
                <div style="height: 1px; width: 128px; background: linear-gradient(to right, transparent, var(--cyber-glow), transparent);"></div>
                <p style="font-size: clamp(18px, 2vw, 24px); font-family: var(--font-body); font-weight: 300; letter-spacing: 0.05em; color: var(--muted-foreground); margin: 0;">
                    <?php echo esc_html(get_theme_mod('hero_subtitle', 'B2B WHOLESALE Manufacturing')); ?>
                </p>
                <div style="height: 1px; width: 128px; background: linear-gradient(to right, transparent, var(--cyber-glow), transparent);"></div>
            </div>

            <!-- Dynamic Content -->
            <div class="hero-dynamic" style="display: flex; flex-direction: column; gap: 16px;">
                <h2 class="dynamic-title" style="font-size: clamp(24px, 4vw, 48px); font-family: var(--font-display); font-weight: 700; color: var(--cyber-glow); margin: 0;">
                    Advanced Sportswear
                </h2>
                <p class="dynamic-subtitle" style="font-size: clamp(16px, 1.5vw, 20px); color: var(--muted-foreground); max-width: 600px; margin: 0 auto;">
                    Performance-driven athletic gear for professionals
                </p>
            </div>

            <!-- CTA Buttons -->
            <div class="hero-cta" style="display: flex; flex-direction: column; gap: 24px; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 24px; justify-content: center;">
                    <a href="https://wa.me/447516033272" target="_blank" rel="noopener noreferrer" class="cyber-button cyber-glow" style="font-size: 18px; padding: 16px 32px; display: flex; align-items: center; gap: 8px;">
                        <?php _e('Request Wholesale Prices', 'robosports'); ?>
                        <span>→</span>
                    </a>

                    <a href="<?php echo esc_url(home_url('/about')); ?>" class="demo-button glass" style="border: 1px solid rgba(59, 130, 246, 0.3); color: var(--cyber-glow); padding: 16px 32px; border-radius: 8px; text-decoration: none; font-size: 18px; display: flex; align-items: center; gap: 8px; transition: all 0.3s;" onmouseover="this.style.background='rgba(59, 130, 246, 0.1)'" onmouseout="this.style.background='rgba(26, 26, 26, 0.8)'">
                        <span>▶</span>
                        <?php _e('Our Story', 'robosports'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Categories Section -->
<section data-aos="fade-up" class="product-categories" style="padding: 96px 0; background: rgba(26, 26, 26, 0.5); position: relative; overflow: hidden;">
    <!-- Animated background elements -->
    <div class="floating-elements" style="position: absolute; inset: 0; pointer-events: none; z-index: 1;">
        <div class="float-element" style="position: absolute; top: 20%; left: 10%; width: 4px; height: 4px; background: rgba(59, 130, 246, 0.4); border-radius: 50%; animation: float 8s ease-in-out infinite;"></div>
        <div class="float-element" style="position: absolute; top: 60%; right: 15%; width: 3px; height: 3px; background: rgba(59, 130, 246, 0.3); border-radius: 50%; animation: float 10s ease-in-out infinite reverse;"></div>
        <div class="float-element" style="position: absolute; bottom: 30%; left: 20%; width: 2px; height: 2px; background: rgba(59, 130, 246, 0.5); border-radius: 50%; animation: float 12s ease-in-out infinite;"></div>
    </div>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 2;">
        <!-- Section Header -->
        <div class="section-header" style="text-align: center; margin-bottom: 64px;">
            <h2 class="section-title text-metallic" style="font-size: clamp(32px, 5vw, 64px); font-family: var(--font-display); font-weight: 700; margin-bottom: 16px;">
                <?php _e('PRODUCT CATEGORIES', 'robosports'); ?>
            </h2>
            <div style="height: 1px; width: 96px; background: linear-gradient(to right, transparent, var(--cyber-glow), transparent); margin: 0 auto 24px;"></div>
            <p style="font-size: 20px; color: var(--muted-foreground); max-width: 800px; margin: 0 auto;">
                <?php _e('Explore our comprehensive range of professional-grade equipment designed for modern businesses', 'robosports'); ?>
            </p>
        </div>

        <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px; align-items: center;">
            <!-- Product Image Display - Made Clickable -->
            <a href="<?php echo esc_url(home_url('/product-category/sportswear/')); ?>" class="product-showcase-link" style="display: block; text-decoration: none;">
                <div class="product-showcase glass" style="position: relative; height: 400px; border-radius: 16px; overflow: hidden; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <img id="active-product-image" src="<?php echo esc_url($product_sportswear['url']); ?>" alt="<?php echo esc_attr($product_sportswear['alt']); ?>" style="width: 100%; height: 100%; object-fit: cover; padding: 16px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                </div>
            </a>

            <!-- Product Info -->
            <div class="product-info" style="display: flex; flex-direction: column; gap: 32px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                <div class="product-header" style="display: flex; align-items: center; gap: 16px;">
                    <!-- Product Icon - Made Clickable -->
                    <a href="<?php echo esc_url(home_url('/product-category/sportswear/')); ?>" style="text-decoration: none;">
                        <div class="product-icon" style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, var(--primary), var(--cyber-glow)); display: flex; align-items: center; justify-content: center; font-size: 32px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;">
                            ⚡
                        </div>
                    </a>
                    <!-- Product Title and Name - Made Clickable -->
                    <a href="<?php echo esc_url(home_url('/product-category/sportswear/')); ?>" style="text-decoration: none;">
                        <div>
                            <h3 class="product-category" style="font-size: 32px; font-family: var(--font-display); font-weight: 700; color: var(--cyber-glow); margin: 0; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;">
                                Sportswear
                            </h3>
                            <p class="product-name" style="font-size: 18px; color: var(--muted-foreground); margin: 0; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;">
                                Athletic Performance Gear
                            </p>
                        </div>
                    </a>
                </div>

                <p class="product-description" style="font-size: 20px; color: var(--foreground); line-height: 1.6; margin: 0; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                    <!-- Removed hardcoded description text -->
                </p>

                <div class="product-features">
                    <h4 style="font-size: 18px; font-family: var(--font-display); font-weight: 600; color: var(--metallic-silver); margin-bottom: 16px;">
                        <?php _e('Featured Products:', 'robosports'); ?>
                    </h4>
                    <!-- Static features list for sportswear -->
                    <div class="features-list" style="display: flex; flex-direction: column; gap: 12px;">
                        <div class="feature-item" style="display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 8px; background: rgba(38, 38, 38, 0.3);">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--cyber-glow);"></div>
                            <span style="color: var(--foreground);">Smart Jerseys</span>
                        </div>
                        <div class="feature-item" style="display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 8px; background: rgba(38, 38, 38, 0.3);">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--cyber-glow);"></div>
                            <span style="color: var(--foreground);">Performance Shoes</span>
                        </div>
                        <div class="feature-item" style="display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 8px; background: rgba(38, 38, 38, 0.3);">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--cyber-glow);"></div>
                            <span style="color: var(--foreground);">Training Gear</span>
                        </div>
                    </div>
                </div>

                <!-- Fixed button URL to use proper WordPress page structure -->
                <a href="<?php echo esc_url(home_url('/product-category/sportswear/')); ?>" class="cyber-button cyber-glow catalog-button" style="align-self: flex-start; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                    <?php _e('View Sportswear Catalog', 'robosports'); ?>
                </a>
            </div>
        </div>

        <!-- Category Indicators -->
        <!-- Reverted category buttons back to selection buttons, not navigation links -->
        <div class="category-indicators" style="display: flex; justify-content: center; gap: 16px; margin-top: 64px;">
            <button class="category-btn active" data-category="sportswear" style="padding: 16px; border-radius: 12px; background: rgba(59, 130, 246, 0.2); color: var(--cyber-glow); border: none; cursor: pointer; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); font-size: 24px; transform: scale(1.1);" aria-label="Sportswear category">
                ⚡
            </button>
            <button class="category-btn" data-category="workwear" style="padding: 16px; border-radius: 12px; background: rgba(38, 38, 38, 0.3); color: var(--muted-foreground); border: none; cursor: pointer; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); font-size: 24px;" aria-label="Workwear category">
                🦺
            </button>
            <button class="category-btn" data-category="beekeeping" style="padding: 16px; border-radius: 12px; background: rgba(38, 38, 38, 0.3); color: var(--muted-foreground); border: none; cursor: pointer; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); font-size: 24px;" aria-label="Beekeeping category">
                🐝
            </button>
        </div>
    </div>
</section>

<!-- Trust Section -->
<section data-aos="fade-up" class="trust-section" style="padding: 96px 0; background: var(--background);">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
        <!-- Section Header -->
        <div data-aos="fade-up" class="section-header" style="text-align: center; margin-bottom: 80px;">
            <h2 class="section-title text-metallic" style="font-size: clamp(24px, 4vw, 48px); font-family: var(--font-display); font-weight: 500; margin-bottom: 24px;">
                <?php _e('TRUSTED BY INDUSTRY LEADERS', 'robosports'); ?>
            </h2>
            <div style="height: 1px; width: 128px; background: linear-gradient(to right, transparent, var(--cyber-glow), transparent); margin: 0 auto 48px;"></div>
        </div>

        <!-- Trust Badges Section - Using reusable component -->
        <div data-aos="fade-up" class="trust-badges" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 32px; margin-bottom: 80px;">
            <?php
            echo robosports_render_card('trust-badge', '🛡️', 'Achievement Award', '<b>Recognized by Govt. of Pakistan</b>');
            echo robosports_render_card('trust-badge', '🏆', 'Industry Leader', '<b>25+ years of wholesale experience</b>');
            echo robosports_render_card('trust-badge', '🚚', 'Global Shipping', '<b>Fast delivery to over the world</b>');
            echo robosports_render_card('trust-badge', '👥', 'Trusted Clients', '<b>Trusted by businesses worldwide</b>');
            ?>
        </div>

        <!-- Service Features - Using reusable component -->
        <div data-aos="fade-up" class="service-features" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 80px;">
            <?php
            echo robosports_render_card('service-feature', '✓', 'Custom Designs', 'Tailored solutions for your brand');
            echo robosports_render_card('service-feature', '🕐', 'Fast Turnaround', 'Express processing & shipping');
            echo robosports_render_card('service-feature', '🌐', 'Global Network', 'Distribution centers worldwide');
            echo robosports_render_card('service-feature', '⭐', 'Premium Quality', 'Rigorous testing & certification');
            ?>
        </div>

        <!-- CTA Banner -->
        <div data-aos="fade-up" class="cta-banner glass" style="border-radius: 24px; padding: clamp(32px, 8vw, 96px); text-align: center; position: relative; overflow: hidden;">
            <div style="position: absolute; inset: 0; background: linear-gradient(to right, rgba(59, 130, 246, 0.1), transparent, rgba(59, 130, 246, 0.1));"></div>
            <div style="position: relative; z-index: 10;">
                <h3 style="font-size: clamp(24px, 4vw, 48px); font-family: var(--font-display); font-weight: 700; color: var(--metallic-silver); margin-bottom: 16px;">
                    <?php _e('Ready to Scale Your Business?', 'robosports'); ?>
                </h3>
                <p style="font-size: 20px; color: var(--foreground); margin-bottom: 32px; max-width: 800px; margin-left: auto; margin-right: auto;">
                    <?php _e('Join thousands of businesses worldwide who trust Robosports for their wholesale needs. Get competitive pricing, fast delivery, and premium quality products.', 'robosports'); ?>
                </p>
                <div style="display: flex; flex-direction: column; gap: 16px; align-items: center;">
                    <div style="display: flex; flex-wrap: wrap; gap: 16px; justify-content: center;">
                        <a href="https://wa.me/447516033272" target="_blank" rel="noopener noreferrer" class="cyber-button cyber-glow" style="font-size: 18px; padding: 16px 32px;">
                            <?php _e('Request Wholesale Catalog', 'robosports'); ?>
                        </a>
                        <a href="https://wa.me/447516033272" target="_blank" rel="noopener noreferrer" class="glass" style="border: 1px solid rgba(59, 130, 246, 0.3); color: var(--cyber-glow); padding: 16px 32px; border-radius: 8px; text-decoration: none; font-size: 18px; transition: all 0.3s;" onmouseover="this.style.background='rgba(59, 130, 246, 0.1)'" onmouseout="this.style.background='rgba(26, 26, 26, 0.8)'">
                            <?php _e('Schedule Consultation', 'robosports'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Client Testimonials Section -->
<section data-aos="fade-up" class="testimonials-section" style="padding:60px 0; background:#111; color:#fff; text-align:center;">
  <div class="container" style="max-width:900px; margin:0 auto;">
    
        <!-- Heading -->
        <h2 style="font-size:34px; font-weight:700; margin-bottom:10px; color:#fff; letter-spacing:1px;">
        CLIENT TESTIMONIALS
        </h2>

        <!-- Blue Line -->
        <div style="width:120px; height:1px; margin:15px auto; 
            background:linear-gradient(90deg, transparent, #007bff, transparent); 
            border-radius:2px;">
        </div>

        <p style="font-size:16px; color:#ccc; margin-bottom:40px;">
        Hear from our satisfied B2B partners about their experience with Robosports products and services.
        </p>

    <!-- Swiper Slider -->
    <div class="swiper myTestimonials">
      <div class="swiper-wrapper">

        <!-- Testimonial 1 -->
        <div class="swiper-slide">
          <div style="background:#fff; color:#000; padding:30px; border-radius:15px; box-shadow:0 4px 12px rgba(0,0,0,0.2);">
            <span style="font-size:26px; color:#c9a227;">❝</span>
            <p style="font-size:18px; font-style:italic; color:#333; margin:20px 0;">
              Great quality products and excellent customer service! Highly recommended!
            </p>
            <h4 style="margin:10px 0 2px; font-size:18px; font-weight:700; color:#000;">
              Ayesha Khan
            </h4>
            <small style="display:block; font-size:14px; color:#555;">Client</small>
            <div style="color:#f5c518; font-size:18px; margin-top:10px;">★★★★★</div>
          </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="swiper-slide">
          <div style="background:#fff; color:#000; padding:30px; border-radius:15px; box-shadow:0 4px 12px rgba(0,0,0,0.2);">
            <span style="font-size:26px; color:#c9a227;">❝</span>
            <p style="font-size:18px; font-style:italic; color:#333; margin:20px 0;">
              Robosports delivers consistent quality. Their reliability makes them our go-to supplier.
            </p>
            <h4 style="margin:10px 0 2px; font-size:18px; font-weight:700; color:#000;">
              Sarah Mitchell
            </h4>
            <small style="display:block; font-size:14px; color:#555;">Client</small>
            <div style="color:#f5c518; font-size:18px; margin-top:10px;">★★★★★</div>
          </div>
        </div>

        <!-- Testimonial 3 -->
        <div class="swiper-slide">
          <div style="background:#fff; color:#000; padding:30px; border-radius:15px; box-shadow:0 4px 12px rgba(0,0,0,0.2);">
            <span style="font-size:26px; color:#c9a227;">❝</span>
            <p style="font-size:18px; font-style:italic; color:#333; margin:20px 0;">
              Fantastic experience working with Robosports. Great value for bulk orders.
            </p>
            <h4 style="margin:10px 0 2px; font-size:18px; font-weight:700; color:#000;">
              David Lee
            </h4>
            <small style="display:block; font-size:14px; color:#555;">B2B Client</small>
            <div style="color:#f5c518; font-size:18px; margin-top:10px;">★★★★★</div>
          </div>
        </div>
        
        <!-- Testimonial 4 -->
        <div class="swiper-slide">
          <div style="background:#fff; color:#000; padding:30px; border-radius:15px; box-shadow:0 4px 12px rgba(0,0,0,0.2);">
            <span style="font-size:26px; color:#c9a227;">❝</span>
            <p style="font-size:18px; font-style:italic; color:#333; margin:20px 0;">
              Excellent attention to detail and fast delivery. I’ll definitely order again.
            </p>
            <h4 style="margin:10px 0 2px; font-size:18px; font-weight:700; color:#000;">
              Muhammad Ali
            </h4>
            <small style="display:block; font-size:14px; color:#555;">Client</small>
            <div style="color:#f5c518; font-size:18px; margin-top:10px;">★★★★★</div>
          </div>
        </div>
        
        <!-- Testimonial 5 -->
        <div class="swiper-slide">
          <div style="background:#fff; color:#000; padding:30px; border-radius:15px; box-shadow:0 4px 12px rgba(0,0,0,0.2);">
            <span style="font-size:26px; color:#c9a227;">❝</span>
            <p style="font-size:18px; font-style:italic; color:#333; margin:20px 0;">
              The customer support was outstanding. They really care about their clients.
            </p>
            <h4 style="margin:10px 0 2px; font-size:18px; font-weight:700; color:#000;">
              Emma Johnson
            </h4>
            <small style="display:block; font-size:14px; color:#555;">Client</small>
            <div style="color:#f5c518; font-size:18px; margin-top:10px;">★★★★★</div>
          </div>
        </div>
        
        <!-- Testimonial 6 -->
        <div class="swiper-slide">
          <div style="background:#fff; color:#000; padding:30px; border-radius:15px; box-shadow:0 4px 12px rgba(0,0,0,0.2);">
            <span style="font-size:26px; color:#c9a227;">❝</span>
            <p style="font-size:18px; font-style:italic; color:#333; margin:20px 0;">
              Robosports is a great seller offering unbeatable quality and prices.
            </p>
            <h4 style="margin:10px 0 2px; font-size:18px; font-weight:700; color:#000;">
              Ahmed Raza
            </h4>
            <small style="display:block; font-size:14px; color:#555;">Client</small>
            <div style="color:#f5c518; font-size:18px; margin-top:10px;">★★★★★</div>
          </div>
        </div>
      </div>

      <!-- Navigation -->
      <div class="swiper-button-prev" style="color:#fff;"></div>
      <div class="swiper-button-next" style="color:#fff;"></div>
      <div class="swiper-pagination"></div>
    </div>

  </div>
</section>

<style>
	
	.payment-item {
    background: #111;
    padding: 20px;
    border-radius: 12px;
    color: #fff;
    font-size: 16px;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    cursor: pointer;
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.8s forwards;
}

/* Animate icons */
.payment-item i {
    font-size: 40px;
    margin-bottom: 10px;
    display: block;
}

/* Hover effect */
.payment-item:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0px 10px 20px rgba(0,0,0,0.4);
}

/* Fade up stagger effect */
.payment-item:nth-child(1) { animation-delay: 0.2s; }
.payment-item:nth-child(2) { animation-delay: 0.4s; }
.payment-item:nth-child(3) { animation-delay: 0.6s; }
.payment-item:nth-child(4) { animation-delay: 0.8s; }

/* Keyframes */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Brand color animations */
.payment-item:nth-child(1) i { /* PayPal */
    color: #003087;
    animation: paypalAnim 2.5s infinite;
}
@keyframes paypalAnim {
    0%,100% { color: #003087; transform: scale(1); }
    50%     { color: #009cde; transform: scale(1.2); }
}

.payment-item:nth-child(2) i { /* Visa */
    color: #1a1f71;
    animation: visaAnim 2.5s infinite;
}
@keyframes visaAnim {
    0%,100% { color: #1a1f71; transform: scale(1); }
    50%     { color: #f7b600; transform: scale(1.2); }
}

.payment-item:nth-child(3) i { /* MasterCard */
    color: #eb001b;
    animation: mastercardAnim 2.5s infinite;
}
@keyframes mastercardAnim {
    0%,100% { color: #eb001b; transform: scale(1); }
    50%     { color: #f79e1b; transform: scale(1.2); }
}

.payment-item:nth-child(4) i { /* Western Union */
    color: #007849;
    animation: wuAnim 2.5s infinite;
}
@keyframes wuAnim {
    0%,100% { color: #007849; transform: scale(1); }
    50%     { color: #facc15; transform: scale(1.2); }
}
/* -------------------------------------- */
/* --- Responsive Front-Page CSS --- */
/* -------------------------------------- */

/* Hero Section */
@media (max-width: 768px) {
    .hero-section {
        padding-top: 100px;
        padding-bottom: 20px;
        min-height: 80vh; /* Adjust for smaller screens */
    }

    .hero-content {
        padding: 0 16px;
    }

    .hero-title {
        font-size: clamp(36px, 10vw, 72px) !important;
        letter-spacing: 0.05em !important;
    }

    .hero-subtitle p {
        font-size: clamp(16px, 4vw, 20px) !important;
    }

    .dynamic-title {
        font-size: clamp(20px, 6vw, 36px) !important;
    }

    .dynamic-subtitle {
        font-size: clamp(14px, 3vw, 18px) !important;
        max-width: 90% !important;
    }

    .hero-cta div {
        flex-direction: column;
        gap: 16px;
    }
    
    .cyber-button,
    .demo-button {
        width: 100%;
        text-align: center;
        padding: 12px 24px !important;
        font-size: 16px !important;
    }
}

/* Product Categories Section */
@media (max-width: 1024px) {
    .product-categories {
        padding: 64px 0;
    }

    .products-grid {
        grid-template-columns: 1fr !important;
        gap: 24px !important;
    }
    
    .product-showcase {
        height: 300px !important;
        padding: 8px !important;
    }

    .product-info {
        gap: 24px;
    }

    .product-header {
        flex-direction: column;
        text-align: center;
        gap: 8px;
    }

    .product-icon {
        width: 56px !important;
        height: 56px !important;
        font-size: 28px !important;
    }

    .product-category {
        font-size: 28px !important;
    }

    .product-name {
        font-size: 16px !important;
    }

    .product-description {
        font-size: 16px !important;
    }

    .features-list {
        gap: 8px !important;
    }

    .catalog-button {
        align-self: center !important;
    }

    .category-indicators {
        gap: 12px !important;
        flex-wrap: wrap;
    }
}

/* Trust Section */
@media (max-width: 768px) {
    .trust-badges,
    .stats-grid,
    .service-features {
        grid-template-columns: 1fr !important;
        gap: 24px !important;
    }

    .cta-banner {
        padding: 48px 24px !important;
    }

    .cta-banner h3 {
        font-size: clamp(20px, 6vw, 36px) !important;
    }

    .cta-banner p {
        font-size: 16px !important;
    }

    .cta-banner div > div {
        flex-direction: column;
        gap: 16px;
    }

    .cta-banner a {
        width: 100%;
        text-align: center;
        font-size: 16px !important;
        padding: 12px 24px !important;
    }
}

/* Testimonials Section */
@media (max-width: 768px) {
    .testimonials-section {
        padding: 40px 20px !important;
    }

    .testimonials-section h2 {
        font-size: 28px !important;
    }

    .swiper-button-prev,
    .swiper-button-next {
        display: none !important;
    }
}

/* Enhanced animations for product section */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.4;
    }
    50% {
        transform: translateY(-20px) rotate(180deg);
        opacity: 0.8;
    }
}

/* Standardized hover effects with consistent timing */
.nav-btn:hover {
    background: rgba(59, 130, 246, 0.2) !important;
    transform: scale(1.1);
}

.category-btn:hover:not(.active) {
    background: rgba(38, 38, 38, 0.5) !important;
    transform: scale(1.05);
}

.category-btn.active {
    animation: pulse 3s ease-in-out infinite;
}

/* Consistent feature item animations */
.feature-item {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.feature-item:hover {
    background: rgba(38, 38, 38, 0.5) !important;
    transform: translateY(-2px);
}

/* Simple Testimonials Animations */

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hero carousel data
    const heroData = [
        {
            title: 'Advanced Sportswear',
            subtitle: 'Performance-driven athletic gear for professionals'
        },
        {
            title: 'Industrial Workwear',
            subtitle: 'Heavy-duty protection for demanding environments'
        },
        {
            title: 'Specialized Beekeeping',
            subtitle: 'Professional-grade equipment for apiary operations'
        }
    ];
    
    let currentHeroSlide = 0;
    const heroSlides = document.querySelectorAll('.hero-slide');
    const heroIndicators = document.querySelectorAll('.hero-indicators .indicator');
    const dynamicTitle = document.querySelector('.dynamic-title');
    const dynamicSubtitle = document.querySelector('.dynamic-subtitle');
    let heroAutoInterval;
    
    function updateHeroSlide(index) {        
        // Update background slides
        heroSlides.forEach((slide, i) => {
            if (i === index) {
                slide.style.opacity = '1';
            } else {
                slide.style.opacity = '0';
            }
        });
        
        // Update indicators
        heroIndicators.forEach((indicator, i) => {
            if (i === index) {
                indicator.classList.add('active');
                indicator.style.background = 'var(--cyber-glow)';
                indicator.style.boxShadow = '0 0 20px rgba(59, 130, 246, 0.3)';
            } else {
                indicator.classList.remove('active');
                indicator.style.background = 'var(--muted-foreground)';
                indicator.style.boxShadow = 'none';
            }
        });
        
        // Update dynamic text content
        if (dynamicTitle && dynamicSubtitle) {
            const heroContent = heroData[index];
            dynamicTitle.textContent = heroContent.title;
            dynamicSubtitle.textContent = heroContent.subtitle;
        }
        
        currentHeroSlide = index;
    }
    
    function startHeroAutoAdvance() {
        heroAutoInterval = setInterval(() => {
            const newIndex = currentHeroSlide === heroData.length - 1 ? 0 : currentHeroSlide + 1;
            updateHeroSlide(newIndex);
        }, 6000); // Change every 6 seconds
    }
    
    function stopHeroAutoAdvance() {
        if (heroAutoInterval) {
            clearInterval(heroAutoInterval);
            heroAutoInterval = null;
        }
    }
    
    // Hero indicator click handlers
    heroIndicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            updateHeroSlide(index);
            
            // Stop auto-advance temporarily, then restart after 10 seconds
            stopHeroAutoAdvance();
            setTimeout(startHeroAutoAdvance, 10000);
        });
    });
    
    // Initialize hero carousel
    updateHeroSlide(0);
    startHeroAutoAdvance();
    
    // Pause hero carousel when page is not visible
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopHeroAutoAdvance();
        } else {
            startHeroAutoAdvance();
        }
    });

    const categoryBtns = document.querySelectorAll('.category-btn');
    const productImage = document.getElementById('active-product-image');
    const productIcon = document.querySelector('.product-icon');
    const productCategory = document.querySelector('.product-category');
    const productName = document.querySelector('.product-name');
    const productDescription = document.querySelector('.product-description');
    const featuresList = document.querySelector('.features-list');
    const catalogButton = document.querySelector('.catalog-button');
    
    // Product data
    const products = {
        sportswear: {
            image: '<?php echo esc_url($product_sportswear['url']); ?>',
            alt: '<?php echo esc_attr($product_sportswear['alt']); ?>',
            icon: '⚡',
            category: 'Sportswear',
            name: 'Athletic Performance Gear',
            description: '',
            features: ['TrackSuits', 'Gym Accessories', 'Training Gear'],
            url: '/product-category/sportswear/'
        },
        workwear: {
            image: '<?php echo esc_url($product_workwear['url']); ?>',
            alt: '<?php echo esc_attr($product_workwear['alt']); ?>',
            icon: '🦺',
            category: 'Workwear',
            name: 'Industrial Safety Equipment',
            description: '',
            features: ['Multi-Pocket Trousers', 'Cargo Style', 'Secure Fit'],
            url: '/workwear/'
        },
        beekeeping: {
            image: '<?php echo esc_url($product_beekeeping['url']); ?>',
            alt: '<?php echo esc_attr($product_beekeeping['alt']); ?>',
            icon: '🐝',
            category: 'Beekeeping',
            name: 'Specialized Beekeeping Gear',
            description: '',
            features: ['Beekeeping Suits', 'Beekeeping Jackets', 'Sting-Resistant Fabric'],
            url: '/beekeeping/'
        }
    };
    
    let currentCategoryIndex = 0;
    const categoryKeys = Object.keys(products);
    let categoryAutoInterval;
    
    function updateProductCategory(categoryKey) {
        const product = products[categoryKey];
        
        // Update active button
        categoryBtns.forEach(btn => {
            btn.classList.remove('active');
            btn.style.background = 'rgba(38, 38, 38, 0.3)';
            btn.style.color = 'var(--muted-foreground)';
            btn.style.transform = 'scale(1)';
            btn.style.boxShadow = 'none';
        });
        
        const activeBtn = document.querySelector(`[data-category="${categoryKey}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active');
            activeBtn.style.background = 'rgba(59, 130, 246, 0.2)';
            activeBtn.style.color = 'var(--cyber-glow)';
            activeBtn.style.transform = 'scale(1.1)';
            activeBtn.style.boxShadow = '0 0 20px rgba(59, 130, 246, 0.3)';
        }
        
        // Update product display
        if (productImage) productImage.src = product.image;
        if (productImage) productImage.alt = product.alt;
        if (productIcon) productIcon.textContent = product.icon;
        if (productCategory) productCategory.textContent = product.category;
        if (productName) productName.textContent = product.name;
        if (productDescription) productDescription.textContent = product.description;
        
        // Update all links to the current category
        const showcaseLink = document.querySelector('.product-showcase-link');
        const iconLink = document.querySelector('.product-header a:first-child');
        const titleLink = document.querySelector('.product-header a:last-child');
        
        if (showcaseLink) showcaseLink.href = `<?php echo home_url(); ?>${product.url}`;
        if (iconLink) iconLink.href = `<?php echo home_url(); ?>${product.url}`;
        if (titleLink) titleLink.href = `<?php echo home_url(); ?>${product.url}`;
        
        // Update features list
        if (featuresList) {
            featuresList.innerHTML = product.features.map(feature => 
                `<div class="feature-item" style="display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 8px; background: rgba(38, 38, 38, 0.3);">
                    <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--cyber-glow);"></div>
                    <span style="color: var(--foreground);">${feature}</span>
                </div>`
            ).join('');
        }
        
        if (catalogButton) {
            catalogButton.href = `<?php echo home_url(); ?>${product.url}`;
            catalogButton.textContent = `View ${product.category} Catalog`;
        }
    }
    
    function startCategoryAutoRotation() {
        categoryAutoInterval = setInterval(() => {
            currentCategoryIndex = (currentCategoryIndex + 1) % categoryKeys.length;
            updateProductCategory(categoryKeys[currentCategoryIndex]);
        }, 4000); // Change every 4 seconds
    }
    
    function stopCategoryAutoRotation() {
        if (categoryAutoInterval) {
            clearInterval(categoryAutoInterval);
            categoryAutoInterval = null;
        }
    }
    
    // Category selection functionality - Manual controls stop auto-rotation temporarily
    categoryBtns.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            const category = this.dataset.category;
            currentCategoryIndex = categoryKeys.indexOf(category);
            updateProductCategory(category);
            
            // Stop auto-rotation temporarily, then restart after 8 seconds
            stopCategoryAutoRotation();
            setTimeout(startCategoryAutoRotation, 8000);
        });
    });
    startCategoryAutoRotation();
});

</script>

<!-- Swiper.js CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Swiper Init -->
<script>
  var swiper = new Swiper(".myTestimonials", {
    loop: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
</script>

<?php 
function robosports_render_card($type, $icon, $title, $description, $additional_class = '') {
    $card_html = '<div class="' . $type . '-card ' . $additional_class . '" role="article" aria-label="' . esc_attr($title) . ': ' . esc_attr($description) . '" style="background: rgba(45, 45, 45, 0.8); border-radius: 16px; padding: 32px 24px; text-align: center; transition: all 0.3s ease; border: 1px solid rgba(255, 255, 255, 0.1);" onmouseover="this.style.transform=\'translateY(-4px)\'; this.style.boxShadow=\'0 8px 25px rgba(59, 130, 246, 0.15)\'" onmouseout="this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'none\'">';
    
    if ($type === 'trust-badge') {
        $card_html .= '<div class="badge-icon" style="width: 64px; height: 64px; background: #2473f2c9; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-size: 24px;">' . $icon . '</div>';
    } else {
        $card_html .= '<div class="service-icon" style="width: 48px; height: 48px; margin: 0 auto 20px; color: #3b82f6; font-size: 32px; display: flex; align-items: center; justify-content: center;">' . $icon . '</div>';
    }
    
    $card_html .= '<h3 style="font-size: 20px; font-family: var(--font-display); font-weight: 600; color: #3b82f6; margin-bottom: 12px;">' . $title . '</h3>';
    $card_html .= '<p style="font-size: ' . ($type === 'trust-badge' ? '11px' : '14px') . '; color: #a0a0a0; margin: 0; line-height: 1.5;">' . $description . '</p>';
    $card_html .= '</div>';
    
    return $card_html;
}
?>

<?php get_footer(); ?>

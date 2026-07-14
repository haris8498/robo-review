<?php
/**
 * The footer template
 */
?>

<footer id="colophon" class="site-footer" style="background: #1a1a1a; color: #bbb; border-top: 1px solid #333; position: relative;">
    <!-- Animated Background Elements -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; pointer-events: none;">
        <div style="position: absolute; top: 20%; left: 10%; width: 2px; height: 2px; background: rgba(59, 130, 246, 0.6); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
        <div style="position: absolute; top: 60%; right: 15%; width: 1px; height: 1px; background: rgba(59, 130, 246, 0.4); border-radius: 50%; animation: float 8s ease-in-out infinite reverse;"></div>
        <div style="position: absolute; bottom: 30%; left: 20%; width: 1.5px; height: 1.5px; background: rgba(59, 130, 246, 0.5); border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
    </div>

    <div class="footer-container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 1;">
        
        <!-- Main Footer Content -->
        <div class="footer-content" style="padding: 48px 0; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 48px; align-items: start;">
            
            <!-- Company Info - Left Section -->
            <div class="footer-section company-info">
                <div class="footer-logo" style="margin-bottom: 24px;">
                    <a href="<?php echo home_url(); ?>" style="display: inline-block;">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" 
                             alt="<?php bloginfo('name'); ?> Logo" 
                             style="max-height: 50px; width: auto; filter: brightness(1.2);">
                    </a>
                </div>
                
                <p style="color: #bbb; font-size: 12px; line-height: 1.6; margin-bottom: 24px; max-width: 300px;">
                    <?php _e('Leading B2B wholesale supplier of premium sportswear, industrial workwear, and specialized beekeeping equipment. Serving businesses worldwide with cutting-edge solutions and unmatched quality.', 'robosports'); ?>
                </p>
                
                <!-- Contact Info -->
                <div class="contact-info" style="display: flex; flex-direction: column; gap: 8px;">
                    <div class="contact-item" style="display: flex; align-items: flex-start; gap: 8px; color: #bbb; font-size: 12px;">
                        <span style="color: #3b82f6; margin-top: 2px;">📍</span>
                        <a href="https://www.google.com/maps?q=FF4X+8F6,+Daska+Rd,+Miani,+Sialkot,+Pakistan" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           style="color: #bbb; text-decoration: none; transition: all 0.3s ease; cursor: pointer;"
                           onmouseover="this.style.color='#3b82f6'; this.style.textDecoration='underline'"
                           onmouseout="this.style.color='#bbb'; this.style.textDecoration='none'"
                           title="Open location in Google Maps">
                            <?php echo esc_html(get_theme_mod('contact_address', 'FF4X+8F6, Daska Rd, Miani, Sialkot, Pakistan')); ?>
                        </a>
                    </div>
                    
                    <div class="contact-item" style="display: flex; align-items: center; gap: 8px; color: #bbb; font-size: 12px;">
                        <span style="color: #3b82f6;">📧</span>
                        <a href="<?php echo esc_url('https://mail.google.com/mail/?view=cm&fs=1&to=' . rawurlencode(get_theme_mod('contact_email', 'info@robosports.biz'))); ?>"
                        target="_blank"
                        style="color: #bbb; text-decoration: none; font-size: 12px; transition: all 0.3s ease; text-decoration: none;"
                        onmouseover="this.style.color='#3b82f6'; this.style.textDecoration='underline'"
                        onmouseout="this.style.color='#bbb'; this.style.textDecoration='none'">
                            <?php echo esc_html(get_theme_mod('contact_email', 'info@robosports.biz')); ?>
                        </a>
                    </div>

                    <div class="contact-item" style="display: flex; align-items: center; gap: 8px; color: #bbb; font-size: 12px;">
                        <span style="color: #3b82f6;">📞</span>
                        <span><?php echo esc_html(get_theme_mod('contact_phone', '+92 52 3562143 / +92 323 3414243')); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Products Column -->
            <div class="footer-section">
                <h3 class="footer-section-title" style="color: #3b82f6; font-size: 14px; font-weight: 600; margin-bottom: 16px; margin-top: 75px;">
                    <?php _e('Products', 'robosports'); ?>
                </h3>
                <ul class="footer-links" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                    <li>
                        <!-- Added link to sportswear category page -->
                        <a href="<?php echo home_url('/sportswear/'); ?>" style="color: #bbb; font-size: 12px; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#bbb'">
                            <?php _e('Sportswear Collection', 'robosports'); ?>
                        </a>
                    </li>
                    <li>
                        <!-- Added link to workwear category page -->
                        <a href="<?php echo home_url('/workwear/'); ?>" style="color: #bbb; font-size: 12px; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#bbb'">
                            <?php _e('Industrial Workwear', 'robosports'); ?>
                        </a>
                    </li>
                    <li>
                        <!-- Added link to beekeeping category page -->
                        <a href="<?php echo home_url('/beekeeping/'); ?>" style="color: #bbb; font-size: 12px; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#bbb'">
                            <?php _e('Beekeeping Suits', 'robosports'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="https://wa.me/447516033272" target="_blank" rel="noopener noreferrer" style="color: #bbb; font-size: 12px; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#bbb'">
                            <?php _e('Custom Solutions', 'robosports'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="https://wa.me/447516033272" target="_blank" rel="noopener noreferrer" style="color: #bbb; font-size: 12px; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#bbb'">
                            <?php _e('Bulk Orders', 'robosports'); ?>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Services Column -->
            <div class="footer-section">
                <h3 class="footer-section-title" style="color: #3b82f6; font-size: 14px; font-weight: 600; margin-bottom: 16px; margin-top: 75px;">
                    <?php _e('Services', 'robosports'); ?>
                </h3>
                <ul class="footer-links" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                    <li>
                        <span style="color: #bbb; font-size: 12px; transition: color 0.3s;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#bbb'">
                            <?php _e('Wholesale Pricing', 'robosports'); ?>
                        </span>
                    </li>
                    <li>
                        <span style="color: #bbb; font-size: 12px; transition: color 0.3s;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#bbb'">
                            <?php _e('Global Shipping', 'robosports'); ?>
                        </span>
                    </li>
                    <li>
                        <span style="color: #bbb; font-size: 12px; transition: color 0.3s;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#bbb'">
                            <?php _e('Custom Branding', 'robosports'); ?>
                        </span>
                    </li>
                    <li>
                        <span style="color: #bbb; font-size: 12px; transition: color 0.3s;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#bbb'">
                            <?php _e('Quality Assurance', 'robosports'); ?>
                        </span>
                    </li>
                </ul>
            </div>
            
            <!-- Social Media Column -->
            <div class="footer-section">
                <h3 class="footer-section-title" style="color: #3b82f6; font-size: 14px; font-weight: 600; margin-bottom: 16px; margin-top: 75px">
                    <?php _e('Social Media', 'robosports'); ?>
                </h3>
                <div class="social-links" style="display: flex; gap: 12px; align-items: center;">
                    <a href="https://www.facebook.com/profile.php?id=100063721794692" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="social-link" 
                       aria-label="Visit Robosports on Facebook" 
                       style="width: 26px; height: 26px; border-radius: 6px; background: #333; display: flex; align-items: center; justify-content: center; color:white; text-decoration: none; transition: all 0.3s ease;"
                       onmouseout="this.style.background='white'; this.style.color='blue'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="16" height="16">
                            <title>Facebook Icon</title>
                            <path fill="currentColor" d="M240 363.3L240 576L356 576L356 363.3L442.5 363.3L460.5 265.5L356 265.5L356 230.9C356 179.2 376.3 159.4 428.7 159.4C445 159.4 458.1 159.8 465.7 160.6L465.7 71.9C451.4 68 416.4 64 396.2 64C289.3 64 240 114.5 240 223.4L240 265.5L174 265.5L174 363.3L240 363.3z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/robo_sports_?igsh=NG13ajhrcGZsOTRn" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="social-link" 
                       aria-label="Visit Robosports on Instagram" 
                       style="width: 26px; height: 26px; border-radius: 6px; background: #333; display: flex; align-items: center; justify-content: center; color:white; text-decoration: none; transition: all 0.3s ease;"
                       onmouseout="this.style.background='white'; this.style.color='blue'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="16" height="16">
                            <title>Instagram Icon</title>
                            <path fill="currentColor" d="M320.3 205C256.8 204.8 205.2 256.2 205 319.7C204.8 383.2 256.2 434.8 319.7 435C383.2 435.2 434.8 383.8 435 320.3C435.2 256.8 383.8 205.2 320.3 205zM319.7 245.4C360.9 245.2 394.4 278.5 394.6 319.7C394.8 360.9 361.5 394.4 320.3 394.6C279.1 394.8 245.6 361.5 245.4 320.3C245.2 279.1 278.5 245.6 319.7 245.4zM413.1 200.3C413.1 185.5 425.1 173.5 439.9 173.5C454.7 173.5 466.7 185.5 466.7 200.3C466.7 215.1 454.7 227.1 439.9 227.1C425.1 227.1 413.1 215.1 413.1 200.3zM542.8 227.5C541.1 191.6 532.9 159.8 506.6 133.6C480.4 107.4 448.6 99.2 412.7 97.4C375.7 95.3 264.8 95.3 227.8 97.4C192 99.1 160.2 107.3 133.9 133.5C107.6 159.7 99.5 191.5 97.7 227.4C95.6 264.4 95.6 375.3 97.7 412.3C99.4 448.2 107.6 480 133.9 506.2C160.2 532.4 191.9 540.6 227.8 542.4C264.8 544.5 375.7 544.5 412.7 542.4C448.6 540.7 480.4 532.5 506.6 506.2C532.8 480 541 448.2 542.8 412.3C544.9 375.3 544.9 264.5 542.8 227.5zM495 452C487.2 471.6 472.1 486.7 452.4 494.6C422.9 506.3 352.9 503.6 320.3 503.6C287.7 503.6 217.6 506.2 188.2 494.6C168.6 486.8 153.5 471.7 145.6 452C133.9 422.5 136.6 352.5 136.6 319.9C136.6 287.3 134 217.2 145.6 187.8C153.4 168.2 168.5 153.1 188.2 145.2C217.7 133.5 287.7 136.2 320.3 136.2C352.9 136.2 423 133.6 452.4 145.2C472 153 487.1 168.1 495 187.8C506.7 217.3 504 287.3 504 319.9C504 352.5 506.7 422.6 495 452z"/>
                        </svg>
                    </a>
                    <a href="https://www.tiktok.com/@robo_sports" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="social-link" 
                       aria-label="Visit Robosports on TikTok" 
                       style="width: 26px; height: 26px; border-radius: 6px; background: #333; display: flex; align-items: center; justify-content: center; color:white; text-decoration: none; transition: all 0.3s ease;"
                       onmouseout="this.style.background='white'; this.style.color='blue'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="16" height="16">
                            <title>TikTok Icon</title>
                            <path fill="currentColor" d="M544.5 273.9C500.5 274 457.5 260.3 421.7 234.7L421.7 413.4C421.7 446.5 411.6 478.8 392.7 506C373.8 533.2 347.1 554 316.1 565.6C285.1 577.2 251.3 579.1 219.2 570.9C187.1 562.7 158.3 545 136.5 520.1C114.7 495.2 101.2 464.1 97.5 431.2C93.8 398.3 100.4 365.1 116.1 336C131.8 306.9 156.1 283.3 185.7 268.3C215.3 253.3 248.6 247.8 281.4 252.3L281.4 342.2C266.4 337.5 250.3 337.6 235.4 342.6C220.5 347.6 207.5 357.2 198.4 369.9C189.3 382.6 184.4 398 184.5 413.8C184.6 429.6 189.7 444.8 199 457.5C208.3 470.2 221.4 479.6 236.4 484.4C251.4 489.2 267.5 489.2 282.4 484.3C297.3 479.4 310.4 469.9 319.6 457.2C328.8 444.5 333.8 429.1 333.8 413.4L333.8 64L421.8 64C421.7 71.4 422.4 78.9 423.7 86.2C426.8 102.5 433.1 118.1 442.4 131.9C451.7 145.7 463.7 157.5 477.6 166.5C497.5 179.6 520.8 186.6 544.6 186.6L544.6 274z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!--Payment Methods-->
        <div class="footer-payment" style="text-align: center; margin-top: 7px; margin-bottom: 15px;">
            <div class="payment-links" style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                <img src="https://robosports.biz/roboSports/wp-content/uploads/2025/09/paypal-icon.png" alt="PayPal" style="height:28px;">
                <img src="https://robosports.biz/roboSports/wp-content/uploads/2025/09/western-icon.png" alt="Western Union" style="height:28px;">
                <img src="https://robosports.biz/roboSports/wp-content/uploads/2025/09/bank-transfer-icon.png" alt="Bank Transfer" style="height:28px;">
                <img src="https://robosports.biz/roboSports/wp-content/uploads/2025/09/master-card-icon.png" alt="Mastercard" style="height:28px;">
                <img src="https://robosports.biz/roboSports/wp-content/uploads/2025/09/visa-icon.webp" alt="Visa" style="height:28px;">
            </div>
        </div>
        
		<!-- Bottom Bar -->
		<div class="footer-bottom" style="border-top: 1px solid #333; padding: 16px 0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
			<div class="copyright" style="color: #bbb; font-size: 12px;">
				© <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'robosports'); ?>
			</div>
			<div class="footer-links-bottom" style="display: flex; gap: 24px; font-size: 12px;">
				<!-- Privacy Policy -->
				<a href="<?php echo get_privacy_policy_url(); ?>" 
				style="color: #bbb; text-decoration: none; transition: color 0.3s;" 
				onmouseover="this.style.color='#3b82f6'" 
				onmouseout="this.style.color='#bbb'">
				<?php _e('Privacy Policy', 'robosports'); ?>
				</a>

				<!-- Terms of Service (points to Privacy Policy) -->
				<a href="<?php echo get_privacy_policy_url(); ?>" 
				style="color: #bbb; text-decoration: none; transition: color 0.3s;" 
				onmouseover="this.style.color='#3b82f6'" 
				onmouseout="this.style.color='#bbb'">
				<?php _e('Terms of Service', 'robosports'); ?>
				</a>

				<!-- Cookie Policy (points to Privacy Policy) -->
				<a href="<?php echo get_privacy_policy_url(); ?>" 
				style="color: #bbb; text-decoration: none; transition: color 0.3s;" 
				onmouseover="this.style.color='#3b82f6'" 
				onmouseout="this.style.color='#bbb'">
				<?php _e('Cookie Policy', 'robosports'); ?>
				</a>
			</div>
		</div>

    </div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.6; }
    50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
}

@media (max-width: 1024px) {
    .footer-content {
        display: grid;
        grid-template-columns: 1fr 1fr; /* two columns */
        grid-template-rows: auto auto; /* two rows */
        gap: 32px 40px;
        padding: 20px 10px;
        width: 100%;
    }

    /* Row 1 */
    .footer-content > .company-info {
        grid-row: 1;
        grid-column: 1;
    }

    .footer-content > .footer-section:nth-of-type(2) { /* Products */
        margin-top: 0.5rem;
        grid-row: 1;
        grid-column: 3;
    }

    /* Row 2 */
    .footer-content > .footer-section:nth-of-type(3) { /* Services */
        grid-row: 2;
        grid-column: 1;
    }

    .footer-content > .footer-section:nth-of-type(4) { /* Social Media */
        grid-row: 2;
        grid-column: 3;
    }

    /* Footer bottom (below grid) */
    .footer-bottom {
        flex-direction: row;
        text-align: center;
        gap: 12px;
    }

    .footer-links-bottom {
        flex-direction: row;
        gap: 8px;
    }

    .social-links {
        justify-content: flex-start;
    }
}

/* Extra small screens */
@media (max-width: 480px) {
    .footer-container {
        padding: 0 16px;
    }

    .contact-info,
    .company-info p {
        font-size: 11px;
    }
}
</style>

</body>
</html>

/**
 * Robosports Theme JavaScript - Optimized Version
 */

;((window) => {
  const $ = window.jQuery || window.$

  if (typeof $ !== "function") {
    if (window.console && window.console.warn) {
      window.console.warn("Robosports theme: jQuery is not available, so theme enhancements were skipped.")
    }
    return
  }

  // Safely declare global variables
  const woocommerce = window.woocommerce || {}
  const robosports_theme = window.robosports_theme || {}
  const robosports_ajax = window.robosports_ajax || {}

  // Responsive breakpoints
  const breakpoints = {
    mobile: 480,
    tablet: 768,
    desktop: 1024,
    large: 1440,
  }

  // Utility functions
  function getScreenSize() {
    const width = window.innerWidth
    if (width <= breakpoints.mobile) return "mobile"
    if (width <= breakpoints.tablet) return "tablet"
    if (width <= breakpoints.desktop) return "desktop"
    return "large"
  }

  function isTouchDevice() {
    return "ontouchstart" in window || navigator.maxTouchPoints > 0
  }

  function debounce(func, wait, immediate) {
    let timeout
    return function () {
      const args = arguments
      const later = () => {
        timeout = null
        if (!immediate) func.apply(this, args)
      }
      const callNow = immediate && !timeout
      clearTimeout(timeout)
      timeout = setTimeout(later, wait)
      if (callNow) func.apply(this, args)
    }
  }

  class UnifiedCarousel {
    constructor(config) {
      this.config = {
        container: null,
        slides: [],
        indicators: [],
        prevBtn: null,
        nextBtn: null,
        autoAdvance: true,
        interval: 5000,
        touchEnabled: true,
        pauseOnHover: false,
        onSlideChange: null,
        ...config,
      }

      this.currentIndex = 0
      this.autoInterval = null
      this.touchStartX = 0
      this.touchEndX = 0

      this.init()
    }

    init() {
      if (!this.config.container || this.config.slides.length === 0) return

      this.setupEventListeners()
      this.showSlide(0)

      if (this.config.autoAdvance) {
        this.startAutoAdvance()
      }
    }

    setupEventListeners() {
      // Navigation buttons
      if (this.config.prevBtn) {
        $(this.config.prevBtn).on("click", () => this.previousSlide())
      }

      if (this.config.nextBtn) {
        $(this.config.nextBtn).on("click", () => this.nextSlide())
      }

      // Indicators
      if (this.config.indicators.length > 0) {
        $(this.config.indicators).on("click", (e) => {
          const index = $(e.target).data("slide") || $(e.target).data("category") || 0
          this.goToSlide(index)
        })
      }

      // Touch support
      if (this.config.touchEnabled && isTouchDevice()) {
        this.setupTouchEvents()
      }

      // Pause on hover
      if (this.config.pauseOnHover) {
        $(this.config.container).hover(
          () => this.stopAutoAdvance(),
          () => this.startAutoAdvance(),
        )
      }

      // Pause when page is not visible
      document.addEventListener("visibilitychange", () => {
        if (document.hidden) {
          this.stopAutoAdvance()
        } else if (this.config.autoAdvance) {
          this.startAutoAdvance()
        }
      })
    }

    setupTouchEvents() {
      $(this.config.container).on("touchstart", (e) => {
        this.touchStartX = e.originalEvent.changedTouches[0].screenX
      })

      $(this.config.container).on("touchend", (e) => {
        this.touchEndX = e.originalEvent.changedTouches[0].screenX
        this.handleSwipe()
      })
    }

    handleSwipe() {
      const diff = this.touchStartX - this.touchEndX
      const threshold = 50

      if (Math.abs(diff) > threshold) {
        this.stopAutoAdvance()
        if (diff > 0) {
          this.nextSlide()
        } else {
          this.previousSlide()
        }
        setTimeout(() => this.startAutoAdvance(), 3000)
      }
    }

    showSlide(index) {
      this.currentIndex = index

      if (this.config.onSlideChange) {
        this.config.onSlideChange(index, this.config.slides[index])
      }

      this.updateIndicators()
    }

    updateIndicators() {
      if (this.config.indicators.length === 0) return

      $(this.config.indicators)
        .removeClass("active")
        .each((i, indicator) => {
          const $indicator = $(indicator)
          if (i === this.currentIndex) {
            $indicator.addClass("active")
          }
        })
    }

    nextSlide() {
      const nextIndex = (this.currentIndex + 1) % this.config.slides.length
      this.showSlide(nextIndex)
    }

    previousSlide() {
      const prevIndex = (this.currentIndex - 1 + this.config.slides.length) % this.config.slides.length
      this.showSlide(prevIndex)
    }

    goToSlide(index) {
      this.stopAutoAdvance()
      this.showSlide(index)
      setTimeout(() => this.startAutoAdvance(), 3000)
    }

    startAutoAdvance() {
      if (!this.config.autoAdvance || this.config.slides.length <= 1) return

      this.stopAutoAdvance()
      this.autoInterval = setInterval(() => {
        this.nextSlide()
      }, this.config.interval)
    }

    stopAutoAdvance() {
      if (this.autoInterval) {
        clearInterval(this.autoInterval)
        this.autoInterval = null
      }
    }

    destroy() {
      this.stopAutoAdvance()
      $(this.config.container).off()
      if (this.config.prevBtn) $(this.config.prevBtn).off()
      if (this.config.nextBtn) $(this.config.nextBtn).off()
      if (this.config.indicators.length > 0) $(this.config.indicators).off()
    }
  }

  // DOM Ready
  $(document).ready(() => {
    try {
      initSmoothScrolling()
      initAnimations()
      initCarousels()
      initContactForms()
      initSearch()
      initAccessibility()
      initScrollToTop()

      // Initialize WooCommerce enhancements only if WooCommerce exists
      if (typeof woocommerce !== "undefined" && Object.keys(woocommerce).length > 0) {
        initWooCommerceEnhancements()
      }
    } catch (error) {
      return;
    }
  })

  // Enhanced smooth scrolling
  function initSmoothScrolling() {
    $('a[href*="#"]:not([href="#"])').click(function () {
      if (
        location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") &&
        location.hostname == this.hostname
      ) {
        var target = $(this.hash)
        target = target.length ? target : $("[name=" + this.hash.slice(1) + "]")
        if (target.length) {
          $("html, body").animate(
            {
              scrollTop: target.offset().top - 100,
            },
            1000,
          )
          return false
        }
      }
    })
  }

  // Enhanced animations with reduced motion support
  function initAnimations() {
    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches

    if (prefersReducedMotion) {
      $(".fade-in").addClass("visible")
      return
    }

    // Intersection Observer for fade-in animations
    if ("IntersectionObserver" in window) {
      const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
      }

      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("visible")
            observer.unobserve(entry.target)
          }
        })
      }, observerOptions)

      $(".fade-in").each(function () {
        observer.observe(this)
      })
    } else {
      $(".fade-in").addClass("visible")
    }

    // Enhanced hover effects for non-touch devices
    if (!isTouchDevice()) {
      $(".cyber-glow").hover(
        function () {
          $(this).css("box-shadow", "0 0 40px rgba(96, 165, 250, 0.6)")
        },
        function () {
          $(this).css("box-shadow", "0 0 20px rgba(59, 130, 246, 0.3)")
        },
      )
    }
  }

  function initCarousels() {
    initHeroSlider()
    initSimpleTestimonialsCarousel()
    // Product carousel remains manual only (no auto-advance)
  }

  function initHeroSlider() {
    const heroSlides = $(".hero-slide")
    const heroIndicators = $(".hero-indicators .indicator")

    if (heroSlides.length === 0) return

    new UnifiedCarousel({
      container: ".hero-section",
      slides: heroSlides.toArray(),
      indicators: heroIndicators.toArray(),
      autoAdvance: true,
      interval: 6000,
      pauseOnHover: true,
      onSlideChange: (index, slide) => {
        // Update slide opacity
        heroSlides.css("opacity", 0)
        heroSlides.eq(index).css("opacity", 1)

        // Update indicators
        heroIndicators.removeClass("active").css({
          background: "var(--muted-foreground)",
          width: "12px",
          "box-shadow": "none",
        })

        heroIndicators.eq(index).addClass("active").css({
          background: "var(--cyber-glow)",
          width: "32px",
          "box-shadow": "0 0 20px rgba(59, 130, 246, 0.3)",
        })
      },
    })
  }

  function initProductCarousel() {
    // Disabled - no automation
  }

  function initSimpleTestimonialsCarousel() {
    const testimonialSlides = $(".testimonial-slide")
    const testimonialIndicators = $(".testimonial-indicators .indicator")

    if (testimonialSlides.length === 0) return

    new UnifiedCarousel({
      container: ".testimonials-section",
      slides: testimonialSlides.toArray(),
      indicators: testimonialIndicators.toArray(),
      autoAdvance: true,
      interval: 8000,
      pauseOnHover: true,
      onSlideChange: (index, slide) => {
        // Update testimonial display
        testimonialSlides.removeClass("active").hide()
        testimonialSlides.eq(index).addClass("active").show()

        // Update indicators
        testimonialIndicators.removeClass("active")
        testimonialIndicators.eq(index).addClass("active")
      },
    })
  }

  // Enhanced contact forms with better validation
  function initContactForms() {
    $(".contact-form").on("submit", function (e) {
      e.preventDefault()
      const $form = $(this)
      const $submitBtn = $form.find('button[type="submit"]')
      const originalBtnText = $submitBtn.text()
      const formData = $form.serialize()

      $submitBtn.text("Sending...").prop("disabled", true)
      $form.find(".form-message").remove()

      $.ajax({
        url: robosports_ajax.ajax_url,
        type: "POST",
        data: formData + "&action=robosports_contact_form&nonce=" + robosports_ajax.nonce,
        success: (response) => {
          if (response.success) {
            $form.append(
              `<p class=\"form-message success\" style=\"color: var(--success); margin-top: 16px;\">${response.data.message}</p>`,
            )
            $form[0].reset()
          } else {
            $form.append(
              `<p class=\"form-message error\" style=\"color: var(--error); margin-top: 16px;\">${response.data.message}</p>`,
            )
          }
        },
        error: () => {
          $form.append(
            `<p class=\"form-message error\" style=\"color: var(--error); margin-top: 16px;\">An unexpected error occurred. Please try again.</p>`,
          )
        },
        complete: () => {
          $submitBtn.text(originalBtnText).prop("disabled", false)
        },
      })
    })
  }

  // Enhanced search functionality
  function initSearch() {
    const $searchToggle = $(".search-toggle")
    const $searchOverlay = $(".search-overlay")
    const $searchClose = $(".search-close")

    $searchToggle.on("click", (e) => {
      e.preventDefault()
      $searchOverlay.addClass("active")
      $("body").addClass("no-scroll")
      setTimeout(() => {
        $searchOverlay.find('input[type="search"]').focus()
      }, 300)
    })

    $searchClose.on("click", () => {
      $searchOverlay.removeClass("active")
      $("body").removeClass("no-scroll")
    })

    $(document).on("keydown", (e) => {
      if (e.key === "Escape" && $searchOverlay.hasClass("active")) {
        $searchOverlay.removeClass("active")
        $("body").removeClass("no-scroll")
      }
    })
  }

  // Accessibility enhancements
  function initAccessibility() {
    // Add skip to content link functionality
    $('a[href="#content"]').on("click", (e) => {
      e.preventDefault()
      $("#content").attr("tabindex", "-1").focus()
    })

    // Keyboard navigation for menus
    $(".main-navigation ul li a").on("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") {
        $(this).click()
      }
    })
  }

  // Scroll to top button
  function initScrollToTop() {
    const $scrollToTopBtn = $(".scroll-to-top")

    $(window).on(
      "scroll",
      debounce(function () {
        if ($(this).scrollTop() > 300) {
          $scrollToTopBtn.addClass("show")
        } else {
          $scrollToTopBtn.removeClass("show")
        }
      }, 100),
    )

    $scrollToTopBtn.on("click", () => {
      $("html, body").animate({ scrollTop: 0 }, 800)
      return false
    })
  }

  // WooCommerce specific enhancements
  function initWooCommerceEnhancements() {
    // Example: Add custom quantity buttons
    $(".quantity").each(function () {
      const $this = $(this)
      const $input = $this.find(".qty")
      const $minus = $('<button type="button" class="minus">-</button>')
      const $plus = $('<button type="button" class="plus">+</button>')

      $this.prepend($minus)
      $this.append($plus)

      $minus.on("click", () => {
        const val = Number.parseInt($input.val())
        if (val > 1) {
          $input.val(val - 1).trigger("change")
        }
      })

      $plus.on("click", () => {
        const val = Number.parseInt($input.val())
        $input.val(val + 1).trigger("change")
      })
    })

    // Example: Enhance product gallery with lightgallery.js (if available)
    if (typeof $.fn.lightGallery === "function") {
      $(".woocommerce-product-gallery__wrapper").lightGallery({
        selector: ".woocommerce-product-gallery__image a",
        thumbnail: true,
        animateThumb: false,
        zoom: false,
        share: false,
        download: false,
        autoplay: false,
        fullScreen: false,
        pager: false,
      })
    }

    // Example: Custom add to cart messages
    $(document).on("added_to_cart", (event, fragments, cart_hash, $button) => {
      const productName = $button.data("product_title") || "Product"
      const message = `${productName} has been added to your cart.`
    })
  }
})(window)

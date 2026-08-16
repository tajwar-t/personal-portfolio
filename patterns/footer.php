<?php
/**
 * Title: Footer
 * Slug: tajwar-tajim/footer
 * Categories: tajwar-tajim
 * Block Types: core/template-part/footer
 * Description: Site footer — brand/tagline, sitemap + elsewhere link columns, newsletter (disabled), copyright, back-to-top button.
 *
 * @package Tajwar_Tajim
 */

?>
<!-- wp:html -->
<footer class="site-footer">
  <div class="container footer-inner">
    <div class="footer-brand">
      <a href="#home" class="logo"><span class="logo-mark">&lt;/&gt;</span><span class="logo-text">Tajwar<strong>Tajim</strong></span></a>
<!-- /wp:html -->
      <!-- wp:paragraph -->
      <p><?php esc_html_e( 'Computer Engineer and Web Developer specializing in WordPress, Shopify, and Magento 2.', 'tajwar-tajim' ); ?></p>
      <!-- /wp:paragraph -->
<!-- wp:html -->
    </div>

    <nav class="footer-nav" aria-label="Footer">
      <div class="footer-col">
<!-- /wp:html -->
        <!-- wp:heading {"level":5} -->
        <h5 class="wp-block-heading"><?php esc_html_e( 'Sitemap', 'tajwar-tajim' ); ?></h5>
        <!-- /wp:heading -->
        <!-- wp:list -->
        <ul class="wp-block-list">
          <!-- wp:list-item -->
          <li><a href="#about"><?php esc_html_e( 'About', 'tajwar-tajim' ); ?></a></li>
          <!-- /wp:list-item -->
          <!-- wp:list-item -->
          <li><a href="#services"><?php esc_html_e( 'Services', 'tajwar-tajim' ); ?></a></li>
          <!-- /wp:list-item -->
          <!-- wp:list-item -->
          <li><a href="#work"><?php esc_html_e( 'Work', 'tajwar-tajim' ); ?></a></li>
          <!-- /wp:list-item -->
          <!-- wp:list-item -->
          <li><a href="<?php echo esc_url( home_url( '/blog' ) ); ?>"><?php esc_html_e( 'Blog', 'tajwar-tajim' ); ?></a></li>
          <!-- /wp:list-item -->
          <!-- wp:list-item -->
          <li><a href="#contact"><?php esc_html_e( 'Contact', 'tajwar-tajim' ); ?></a></li>
          <!-- /wp:list-item -->
        </ul>
        <!-- /wp:list -->
<!-- wp:html -->
      </div>
      <div class="footer-col">
<!-- /wp:html -->
        <!-- wp:heading {"level":5} -->
        <h5 class="wp-block-heading"><?php esc_html_e( 'Elsewhere', 'tajwar-tajim' ); ?></h5>
        <!-- /wp:heading -->
        <!-- wp:list -->
        <ul class="wp-block-list">
          <!-- wp:list-item -->
          <li><a href="https://www.fiverr.com/tajimtajwar" target="_blank" rel="noopener">Fiverr</a></li>
          <!-- /wp:list-item -->
          <!-- wp:list-item -->
          <li><a href="https://github.com/tajwar-t" target="_blank" rel="noopener">GitHub</a></li>
          <!-- /wp:list-item -->
          <!-- wp:list-item -->
          <li><a href="https://linkedin.com/in/tajwar-tajim" target="_blank" rel="noopener">LinkedIn</a></li>
          <!-- /wp:list-item -->
        </ul>
        <!-- /wp:list -->
<!-- wp:html -->
      </div>
    </nav>

    <div class="footer-newsletter">
      <h5><?php esc_html_e( 'Stay in the loop', 'tajwar-tajim' ); ?></h5>
      <p><?php esc_html_e( 'Occasional notes on web dev — no spam.', 'tajwar-tajim' ); ?></p>
      <form class="newsletter-form" onsubmit="return false">
        <input type="email" placeholder="you@email.com" aria-label="<?php esc_attr_e( 'Email address for newsletter', 'tajwar-tajim' ); ?>">
        <button type="submit" aria-label="<?php esc_attr_e( 'Subscribe', 'tajwar-tajim' ); ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </button>
      </form>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container footer-bottom-inner">
<!-- /wp:html -->
      <!-- wp:paragraph -->
      <p>&copy; <span id="year"></span> <?php esc_html_e( 'Tajwar Tajim. All rights reserved.', 'tajwar-tajim' ); ?></p>
      <!-- /wp:paragraph -->
      <!-- wp:paragraph {"className":"footer-credit"} -->
      <p class="footer-credit"><?php esc_html_e( 'Crafted with care, one commit at a time.', 'tajwar-tajim' ); ?></p>
      <!-- /wp:paragraph -->
<!-- wp:html -->
    </div>
  </div>
</footer>

<button class="back-to-top" id="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'tajwar-tajim' ); ?>">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>
<!-- /wp:html -->

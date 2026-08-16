<?php
/**
 * Title: Header
 * Slug: tajwar-tajim/header
 * Categories: tajwar-tajim
 * Block Types: core/template-part/header
 * Description: Site header — logo, anchor nav with scrollspy, theme toggle, mobile menu, floating identity pill.
 *
 * @package Tajwar_Tajim
 */

?>
<!-- wp:html -->
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'tajwar-tajim' ); ?></a>
<div class="cursor-glow" id="cursor-glow" aria-hidden="true"></div>

<header class="site-header" id="site-header">
  <div class="container header-inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>#home" class="logo" aria-label="<?php esc_attr_e( 'Tajwar Tajim — home', 'tajwar-tajim' ); ?>">
      <span class="logo-mark">&lt;/&gt;</span>
      <span class="logo-text">Tajwar<strong>Tajim</strong></span>
    </a>

    <nav class="main-nav" id="main-nav" aria-label="Primary">
      <ul>
        <li><a href="#home" class="nav-link" data-section="home"><?php esc_html_e( 'Home', 'tajwar-tajim' ); ?></a></li>
        <li><a href="#about" class="nav-link" data-section="about"><?php esc_html_e( 'About', 'tajwar-tajim' ); ?></a></li>
        <li><a href="#services" class="nav-link" data-section="services"><?php esc_html_e( 'Services', 'tajwar-tajim' ); ?></a></li>
        <li><a href="#work" class="nav-link" data-section="work"><?php esc_html_e( 'Work', 'tajwar-tajim' ); ?></a></li>
        <li><a href="#experience" class="nav-link" data-section="experience"><?php esc_html_e( 'Experience', 'tajwar-tajim' ); ?></a></li>
        <li><a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="nav-link" data-section="blog"><?php esc_html_e( 'Blog', 'tajwar-tajim' ); ?></a></li>
        <li><a href="#contact" class="nav-link" data-section="contact"><?php esc_html_e( 'Contact', 'tajwar-tajim' ); ?></a></li>
      </ul>
    </nav>

    <div class="header-actions">
      <button class="theme-toggle" id="theme-toggle" type="button" aria-label="<?php esc_attr_e( 'Switch to dark theme', 'tajwar-tajim' ); ?>" aria-pressed="true">
        <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
        <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.8A9 9 0 1111.2 3 7 7 0 0021 12.8z"/></svg>
      </button>
      <a href="#contact" class="btn btn-primary btn-sm"><?php esc_html_e( "Let's Talk", 'tajwar-tajim' ); ?></a>
      <button class="menu-toggle" id="menu-toggle" type="button" aria-label="<?php esc_attr_e( 'Toggle menu', 'tajwar-tajim' ); ?>" aria-expanded="false" aria-controls="main-nav">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>
<div class="nav-scrim" id="nav-scrim"></div>

<div class="identity-pill" id="identity-pill">
  <span class="identity-pill-name">Tajwar Tajim</span>
  <button class="identity-pill-toggle" id="identity-pill-toggle" type="button" aria-expanded="false" aria-controls="identity-pill-menu" aria-label="<?php esc_attr_e( 'Quick links', 'tajwar-tajim' ); ?>">
    <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
  </button>
  <div class="identity-pill-menu" id="identity-pill-menu">
    <a href="mailto:tajim.tajwar@gmail.com"><?php esc_html_e( 'Email', 'tajwar-tajim' ); ?></a>
    <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/Tajwar_CV.pdf' ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Resume', 'tajwar-tajim' ); ?></a>
    <a href="https://github.com/tajwar-t" target="_blank" rel="noopener">GitHub</a>
    <a href="https://www.fiverr.com/tajimtajwar" target="_blank" rel="noopener">Fiverr</a>
  </div>
</div>
<!-- /wp:html -->

<?php
/**
 * Server-side render for `tajwar-tajim/site-header`.
 *
 * Renders the entire site header chrome — skip link, cursor-glow,
 * logo (real Custom Logo via tj_logo()), primary navigation, theme
 * toggle, CTA button, mobile menu toggle, and the floating identity
 * pill — driven by block attributes (menuId, ctaText, ctaUrl). No
 * Custom HTML block is used anywhere for this section; the handful of
 * elements below with no core-block equivalent (theme toggle, cursor
 * glow, mobile menu button, identity pill) are purely JS-interactive
 * chrome with nothing "content"-like to expose as an attribute.
 *
 * @package Tajwar_Tajim
 *
 * @var array $attributes Block attributes (menuId, ctaText, ctaUrl).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$tj_menu_id  = ! empty( $attributes['menuId'] ) ? (int) $attributes['menuId'] : 0;
$tj_cta_text = ! empty( $attributes['ctaText'] ) ? $attributes['ctaText'] : __( "Let's Talk", 'tajwar-tajim' );
$tj_cta_url  = ! empty( $attributes['ctaUrl'] ) ? $attributes['ctaUrl'] : '#contact';

$tj_nav_args = array(
	'container'            => 'nav',
	'container_class'      => 'main-nav',
	'container_id'         => 'main-nav',
	'container_aria_label' => __( 'Primary', 'tajwar-tajim' ),
	'menu_class'           => '',
	'fallback_cb'          => 'tj_primary_nav_fallback',
	'items_wrap'           => '<ul>%3$s</ul>',
	'depth'                => 1,
	'echo'                 => false,
);

if ( $tj_menu_id && wp_get_nav_menu_object( $tj_menu_id ) ) {
	$tj_nav_args['menu']           = $tj_menu_id;
	$tj_nav_args['theme_location'] = 'primary';
} else {
	$tj_nav_args['theme_location'] = 'primary';
}

$tj_nav_html = wp_nav_menu( $tj_nav_args );
?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'tajwar-tajim' ); ?></a>
<div class="cursor-glow" id="cursor-glow" aria-hidden="true"></div>

<header class="site-header" id="site-header">
	<div class="container header-inner">
		<?php tj_logo(); ?>

		<?php echo $tj_nav_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_nav_menu() output is already escaped. ?>

		<div class="header-actions">
			<button class="theme-toggle" id="theme-toggle" type="button" aria-label="<?php esc_attr_e( 'Switch to dark theme', 'tajwar-tajim' ); ?>" aria-pressed="true">
				<svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
				<svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.8A9 9 0 1111.2 3 7 7 0 0021 12.8z"/></svg>
			</button>
			<div class="wp-block-buttons header-cta">
				<div class="wp-block-button btn-sm"><a class="wp-block-button__link btn btn-primary btn-sm wp-element-button" href="<?php echo esc_url( $tj_cta_url ); ?>"><?php echo esc_html( $tj_cta_text ); ?></a></div>
			</div>
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

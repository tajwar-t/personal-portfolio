<?php
/**
 * Server-side render for `tajwar-tajim/site-footer`.
 *
 * Renders the entire footer — brand/tagline, Sitemap + Elsewhere menu
 * columns (each a real WordPress Menu, pickable per-block or falling
 * back to its theme location), newsletter blurb, copyright/credit
 * lines, and the back-to-top button — driven by block attributes. The
 * newsletter form itself stays raw markup (its fields' IDs/names are
 * JS-disabled utility markup with nothing "content"-like to expose).
 *
 * @package Tajwar_Tajim
 *
 * @var array $attributes Block attributes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$tj_tagline            = ! empty( $attributes['tagline'] ) ? $attributes['tagline'] : __( 'Computer Engineer and Web Developer specializing in WordPress, Shopify, and Magento 2.', 'tajwar-tajim' );
$tj_newsletter_heading  = ! empty( $attributes['newsletterHeading'] ) ? $attributes['newsletterHeading'] : __( 'Stay in the loop', 'tajwar-tajim' );
$tj_newsletter_text     = ! empty( $attributes['newsletterText'] ) ? $attributes['newsletterText'] : __( 'Occasional notes on web dev — no spam.', 'tajwar-tajim' );
$tj_copyright_text      = ! empty( $attributes['copyrightText'] ) ? $attributes['copyrightText'] : __( 'Tajwar Tajim. All rights reserved.', 'tajwar-tajim' );
$tj_credit_text         = ! empty( $attributes['creditText'] ) ? $attributes['creditText'] : __( 'Crafted with care, one commit at a time.', 'tajwar-tajim' );
$tj_sitemap_menu_id     = ! empty( $attributes['sitemapMenuId'] ) ? (int) $attributes['sitemapMenuId'] : 0;
$tj_elsewhere_menu_id   = ! empty( $attributes['elsewhereMenuId'] ) ? (int) $attributes['elsewhereMenuId'] : 0;

$tj_sitemap_args = array(
	'theme_location' => 'footer-sitemap',
	'container'      => false,
	'menu_class'      => '',
	'fallback_cb'     => 'tj_footer_sitemap_fallback',
	'items_wrap'      => '<ul class="wp-block-list">%3$s</ul>',
	'depth'           => 1,
	'echo'            => false,
);
if ( $tj_sitemap_menu_id && wp_get_nav_menu_object( $tj_sitemap_menu_id ) ) {
	$tj_sitemap_args['menu'] = $tj_sitemap_menu_id;
}

$tj_elsewhere_args = array(
	'theme_location' => 'footer-elsewhere',
	'container'      => false,
	'menu_class'      => '',
	'fallback_cb'     => 'tj_footer_elsewhere_fallback',
	'items_wrap'      => '<ul class="wp-block-list">%3$s</ul>',
	'depth'           => 1,
	'echo'            => false,
);
if ( $tj_elsewhere_menu_id && wp_get_nav_menu_object( $tj_elsewhere_menu_id ) ) {
	$tj_elsewhere_args['menu'] = $tj_elsewhere_menu_id;
}

$tj_sitemap_html   = wp_nav_menu( $tj_sitemap_args );
$tj_elsewhere_html = wp_nav_menu( $tj_elsewhere_args );
?>
<footer class="site-footer">
	<div class="container footer-inner">
		<div class="footer-brand">
			<?php tj_logo(); ?>
			<p><?php echo esc_html( $tj_tagline ); ?></p>
		</div>

		<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer', 'tajwar-tajim' ); ?>">
			<div class="footer-col">
				<h5 class="wp-block-heading"><?php esc_html_e( 'Sitemap', 'tajwar-tajim' ); ?></h5>
				<?php echo $tj_sitemap_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_nav_menu() output is already escaped. ?>
			</div>
			<div class="footer-col">
				<h5 class="wp-block-heading"><?php esc_html_e( 'Elsewhere', 'tajwar-tajim' ); ?></h5>
				<?php echo $tj_elsewhere_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_nav_menu() output is already escaped. ?>
			</div>
		</nav>

		<div class="footer-newsletter">
			<h5><?php echo esc_html( $tj_newsletter_heading ); ?></h5>
			<p><?php echo esc_html( $tj_newsletter_text ); ?></p>
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
			<p>&copy; <span id="year"></span> <?php echo esc_html( $tj_copyright_text ); ?></p>
			<p class="footer-credit"><?php echo esc_html( $tj_credit_text ); ?></p>
		</div>
	</div>
</footer>

<button class="back-to-top" id="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'tajwar-tajim' ); ?>">
	<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>

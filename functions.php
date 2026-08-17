<?php
/**
 * Tajwar Tajim Portfolio theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TJ_CONTACT_RECIPIENT', 'tajim.tajwar@gmail.com' );

/**
 * Theme setup.
 */
function tj_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 96,
			'width'       => 440,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_editor_style( 'assets/css/style.css' );
	add_editor_style( 'assets/css/editor-style.css' );

	register_nav_menus(
		array(
			'primary'          => __( 'Primary Navigation (header)', 'tajwar-tajim' ),
			'footer-sitemap'   => __( 'Footer — Sitemap column', 'tajwar-tajim' ),
			'footer-elsewhere' => __( 'Footer — Elsewhere column', 'tajwar-tajim' ),
		)
	);
}
add_action( 'after_setup_theme', 'tj_setup' );

/**
 * Adds `.nav-link` + `data-section` to each primary-menu link, matching
 * what assets/js/main.js's scrollspy IntersectionObserver looks for
 * (data-section must equal the target section's id). Derived automatically
 * from each link's own URL fragment (or "blog" for the Blog page link) so
 * editing the menu in Appearance → Menus doesn't require touching PHP.
 */
function tj_primary_nav_link_attributes( $atts, $item, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $atts;
	}

	$atts['class'] = trim( ( $atts['class'] ?? '' ) . ' nav-link' );

	$url = $atts['href'] ?? '';
	if ( false !== strpos( $url, '#' ) ) {
		$atts['data-section'] = substr( $url, strpos( $url, '#' ) + 1 );
	} elseif ( false !== strpos( $url, '/blog' ) ) {
		$atts['data-section'] = 'blog';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'tj_primary_nav_link_attributes', 10, 3 );

/**
 * Fallback nav output (used only if no menu has been assigned to a
 * location yet in Appearance → Menus) — matches the original hardcoded
 * links exactly, so the site still works correctly out of the box.
 */
function tj_primary_nav_fallback() {
	$links = array(
		'home'       => array( '#home', __( 'Home', 'tajwar-tajim' ) ),
		'about'      => array( '#about', __( 'About', 'tajwar-tajim' ) ),
		'services'   => array( '#services', __( 'Services', 'tajwar-tajim' ) ),
		'work'       => array( '#work', __( 'Work', 'tajwar-tajim' ) ),
		'experience' => array( '#experience', __( 'Experience', 'tajwar-tajim' ) ),
		'blog'       => array( home_url( '/blog' ), __( 'Blog', 'tajwar-tajim' ) ),
		'contact'    => array( '#contact', __( 'Contact', 'tajwar-tajim' ) ),
	);
	echo '<ul>';
	foreach ( $links as $section => $link ) {
		printf(
			'<li><a href="%s" class="nav-link" data-section="%s">%s</a></li>',
			esc_url( $link[0] ),
			esc_attr( $section ),
			esc_html( $link[1] )
		);
	}
	echo '</ul>';
}

function tj_footer_sitemap_fallback() {
	$links = array(
		'#about'                    => __( 'About', 'tajwar-tajim' ),
		'#services'                 => __( 'Services', 'tajwar-tajim' ),
		'#work'                     => __( 'Work', 'tajwar-tajim' ),
		home_url( '/blog' )         => __( 'Blog', 'tajwar-tajim' ),
		'#contact'                  => __( 'Contact', 'tajwar-tajim' ),
	);
	echo '<ul>';
	foreach ( $links as $url => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

function tj_footer_elsewhere_fallback() {
	$links = array(
		'https://www.fiverr.com/tajimtajwar' => 'Fiverr',
		'https://github.com/tajwar-t'        => 'GitHub',
		'https://linkedin.com/in/tajwar-tajim' => 'LinkedIn',
	);
	echo '<ul>';
	foreach ( $links as $url => $label ) {
		printf( '<li><a href="%s" target="_blank" rel="noopener">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * Site logo — renders the real Custom Logo (Appearance → Site Identity)
 * inside the theme's own `.logo` markup so the existing CSS keeps working,
 * falling back to the original text/mark logo when none is set.
 */
function tj_logo() {
	$home = esc_url( home_url( '/' ) . '#home' );

	if ( has_custom_logo() ) {
		$logo_id  = get_theme_mod( 'custom_logo' );
		$logo_img = wp_get_attachment_image(
			$logo_id,
			'full',
			false,
			array(
				'class' => 'logo-image',
				'alt'   => get_bloginfo( 'name' ),
			)
		);
		printf( '<a href="%s" class="logo" aria-label="%s">%s</a>', $home, esc_attr__( 'Tajwar Tajim — home', 'tajwar-tajim' ), $logo_img ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image() output is already escaped.
		return;
	}
	?>
	<a href="<?php echo $home; ?>" class="logo" aria-label="<?php esc_attr_e( 'Tajwar Tajim — home', 'tajwar-tajim' ); ?>">
		<span class="logo-mark">&lt;/&gt;</span>
		<span class="logo-text">Tajwar<strong>Tajim</strong></span>
	</a>
	<?php
}

/**
 * Enqueue theme assets.
 */
function tj_enqueue_assets() {
	$style_path = get_template_directory() . '/assets/css/style.css';
	$main_path  = get_template_directory() . '/assets/js/main.js';

	wp_enqueue_style(
		'tj-style',
		get_template_directory_uri() . '/assets/css/style.css',
		array(),
		// file_exists( $style_path ) ? filemtime( $style_path ) : wp_get_theme()->get( 'Version' )
		time()
	);

	wp_enqueue_script(
		'tj-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		file_exists( $main_path ) ? filemtime( $main_path ) : wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'tj_enqueue_assets' );

/**
 * SEO meta description — tier-3 hardcoded value (not visible page content, so it
 * doesn't fit "direct block editing"; swap for an SEO plugin later if needed).
 */
function tj_output_meta_description() {
	if ( ! is_front_page() ) {
		return;
	}
	echo '<meta name="description" content="' . esc_attr( 'Tajwar Tajim is a Computer Engineer and Web Developer specializing in WordPress, Shopify, and Magento 2 — a Level 2 Fiverr seller with a 5.0 rating across 194+ reviews.' ) . '">' . "\n";
}
add_action( 'wp_head', 'tj_output_meta_description' );

/**
 * Register block pattern category for the theme's own patterns.
 */
function tj_register_pattern_categories() {
	register_block_pattern_category(
		'tajwar-tajim',
		array( 'label' => __( 'Tajwar Tajim', 'tajwar-tajim' ) )
	);
}
add_action( 'init', 'tj_register_pattern_categories' );

/**
 * CPTs, taxonomy, meta boxes.
 */
require_once get_template_directory() . '/inc/cpt-project.php';
require_once get_template_directory() . '/inc/cpt-testimonial.php';
require_once get_template_directory() . '/inc/meta-boxes.php';

/**
 * Contact form (AJAX + wp_mail).
 */
require_once get_template_directory() . '/inc/contact-form.php';

/**
 * Custom dynamic blocks — build-free.
 *
 * Each block's editor script is plain vanilla JS (no bundler, no npm)
 * written directly against WordPress's own global scripts, so it's
 * registered here with its dependencies spelled out explicitly instead of
 * relying on a webpack-generated *.asset.php file.
 */
function tj_register_blocks() {
	$blocks_dir = get_template_directory() . '/blocks';
	$blocks     = array( 'project-grid', 'testimonials', 'blog-preview', 'site-header', 'site-footer' );

	foreach ( $blocks as $block ) {
		$path = $blocks_dir . '/' . $block;

		if ( ! file_exists( $path . '/block.json' ) ) {
			continue;
		}

		$handle = 'tajwar-tajim-' . $block . '-editor';

		wp_register_script(
			$handle,
			get_template_directory_uri() . '/blocks/' . $block . '/edit.js',
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-server-side-render', 'wp-api-fetch', 'wp-i18n' ),
			filemtime( $path . '/edit.js' ),
			true
		);

		register_block_type( $path );
	}
}
add_action( 'init', 'tj_register_blocks' );

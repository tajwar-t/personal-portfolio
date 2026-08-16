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
	add_editor_style( 'assets/css/style.css' );
	add_editor_style( 'assets/css/editor-style.css' );
}
add_action( 'after_setup_theme', 'tj_setup' );

/**
 * Enqueue theme assets.
 */
function tj_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'tj-style',
		get_template_directory_uri() . '/assets/css/style.css',
		array(),
		$theme_version
	);

	wp_enqueue_script(
		'tj-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		$theme_version,
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
 * Custom dynamic blocks.
 */
function tj_register_blocks() {
	$blocks_dir = get_template_directory() . '/build/blocks';

	foreach ( array( 'project-grid', 'testimonials', 'blog-preview' ) as $block ) {
		$path = $blocks_dir . '/' . $block;
		if ( file_exists( $path . '/block.json' ) ) {
			register_block_type( $path );
		}
	}
}
add_action( 'init', 'tj_register_blocks' );

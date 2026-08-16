<?php
/**
 * Custom Post Type: Testimonial
 *
 * Registers the `testimonial` CPT that powers the Testimonials slider.
 * Uses native post fields wherever possible: post title is the reviewer's
 * name/handle, post content (editor) is the review quote itself. Only
 * `tj_client_location` and `tj_avatar_hue` need custom meta (see
 * inc/meta-boxes.php).
 *
 * @package Tajwar_Tajim
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register the `testimonial` custom post type.
 */
function tj_register_testimonial_cpt() {
	$labels = array(
		'name'               => _x( 'Testimonials', 'Post type general name', 'tajwar-tajim' ),
		'singular_name'      => _x( 'Testimonial', 'Post type singular name', 'tajwar-tajim' ),
		'menu_name'          => _x( 'Testimonials', 'Admin Menu text', 'tajwar-tajim' ),
		'name_admin_bar'     => _x( 'Testimonial', 'Add New on Toolbar', 'tajwar-tajim' ),
		'add_new'            => __( 'Add New', 'tajwar-tajim' ),
		'add_new_item'       => __( 'Add New Testimonial', 'tajwar-tajim' ),
		'new_item'           => __( 'New Testimonial', 'tajwar-tajim' ),
		'edit_item'          => __( 'Edit Testimonial', 'tajwar-tajim' ),
		'view_item'          => __( 'View Testimonial', 'tajwar-tajim' ),
		'all_items'          => __( 'All Testimonials', 'tajwar-tajim' ),
		'search_items'       => __( 'Search Testimonials', 'tajwar-tajim' ),
		'not_found'          => __( 'No testimonials found.', 'tajwar-tajim' ),
		'not_found_in_trash' => __( 'No testimonials found in Trash.', 'tajwar-tajim' ),
		'archives'           => __( 'Testimonial Archives', 'tajwar-tajim' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 21,
		'menu_icon'          => 'dashicons-format-quote',
		'supports'           => array( 'title', 'editor' ),
	);

	register_post_type( 'testimonial', $args );
}
add_action( 'init', 'tj_register_testimonial_cpt' );

<?php
/**
 * Custom Post Type: Project
 *
 * Registers the `project` CPT (Work section grid) and its `project_category`
 * taxonomy. The three taxonomy term slugs — shopify, webapp, wordpress — are
 * load-bearing: they must exactly match the `data-filter` / `data-category`
 * values already hardcoded in assets/js/main.js's project filter tabs. Do not
 * rename them.
 *
 * @package Tajwar_Tajim
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register the `project` custom post type.
 */
function tj_register_project_cpt() {
	$labels = array(
		'name'                  => _x( 'Projects', 'Post type general name', 'tajwar-tajim' ),
		'singular_name'         => _x( 'Project', 'Post type singular name', 'tajwar-tajim' ),
		'menu_name'             => _x( 'Projects', 'Admin Menu text', 'tajwar-tajim' ),
		'name_admin_bar'        => _x( 'Project', 'Add New on Toolbar', 'tajwar-tajim' ),
		'add_new'               => __( 'Add New', 'tajwar-tajim' ),
		'add_new_item'          => __( 'Add New Project', 'tajwar-tajim' ),
		'new_item'              => __( 'New Project', 'tajwar-tajim' ),
		'edit_item'             => __( 'Edit Project', 'tajwar-tajim' ),
		'view_item'             => __( 'View Project', 'tajwar-tajim' ),
		'all_items'             => __( 'All Projects', 'tajwar-tajim' ),
		'search_items'          => __( 'Search Projects', 'tajwar-tajim' ),
		'not_found'             => __( 'No projects found.', 'tajwar-tajim' ),
		'not_found_in_trash'    => __( 'No projects found in Trash.', 'tajwar-tajim' ),
		'featured_image'        => __( 'Project Screenshot', 'tajwar-tajim' ),
		'set_featured_image'    => __( 'Set project screenshot', 'tajwar-tajim' ),
		'remove_featured_image' => __( 'Remove project screenshot', 'tajwar-tajim' ),
		'use_featured_image'    => __( 'Use as project screenshot', 'tajwar-tajim' ),
		'archives'              => __( 'Project Archives', 'tajwar-tajim' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'project' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-portfolio',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	);

	register_post_type( 'project', $args );
}
add_action( 'init', 'tj_register_project_cpt' );

/**
 * Register the `project_category` taxonomy for the `project` CPT.
 *
 * Term slugs (shopify, webapp, wordpress) intentionally match main.js's
 * `data-filter`/`data-category` values — see the Work section filter tabs.
 */
function tj_register_project_category_taxonomy() {
	$labels = array(
		'name'          => _x( 'Project Categories', 'taxonomy general name', 'tajwar-tajim' ),
		'singular_name' => _x( 'Project Category', 'taxonomy singular name', 'tajwar-tajim' ),
		'search_items'  => __( 'Search Project Categories', 'tajwar-tajim' ),
		'all_items'     => __( 'All Project Categories', 'tajwar-tajim' ),
		'edit_item'     => __( 'Edit Project Category', 'tajwar-tajim' ),
		'update_item'   => __( 'Update Project Category', 'tajwar-tajim' ),
		'add_new_item'  => __( 'Add New Project Category', 'tajwar-tajim' ),
		'new_item_name' => __( 'New Project Category Name', 'tajwar-tajim' ),
		'menu_name'     => __( 'Categories', 'tajwar-tajim' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'project-category' ),
	);

	register_taxonomy( 'project_category', array( 'project' ), $args );
}
add_action( 'init', 'tj_register_project_category_taxonomy' );

/**
 * Pre-create the three required `project_category` terms if they don't
 * already exist. These slugs are fixed contract with main.js's filter tabs
 * (`data-filter="shopify|webapp|wordpress"`) — never rename them.
 *
 * Runs on after_switch_theme, but is written idempotently (checked via
 * term_exists) so it's also safe to call again on init as a belt-and-braces
 * fallback in case the taxonomy wasn't registered yet at switch time.
 */
function tj_create_default_project_categories() {
	// Taxonomy must be registered before terms can be inserted against it.
	if ( ! taxonomy_exists( 'project_category' ) ) {
		tj_register_project_category_taxonomy();
	}

	$terms = array(
		'shopify'   => __( 'Shopify', 'tajwar-tajim' ),
		'webapp'    => __( 'Web App', 'tajwar-tajim' ),
		'wordpress' => __( 'WordPress', 'tajwar-tajim' ),
	);

	foreach ( $terms as $slug => $name ) {
		if ( ! term_exists( $slug, 'project_category' ) ) {
			wp_insert_term( $name, 'project_category', array( 'slug' => $slug ) );
		}
	}
}
add_action( 'after_switch_theme', 'tj_create_default_project_categories' );

<?php
/**
 * Hand-written meta boxes for the `project` and `testimonial` CPTs.
 *
 * Plain add_meta_box()/save_post_{$post_type} — no ACF, no page builder.
 * Every custom meta key is prefixed `tj_` deliberately, to stay out of the
 * way of core/plugin meta.
 *
 * @package Tajwar_Tajim
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* -------------------------------------------------------------------------
 * Project meta box: tj_github_url, tj_live_url, tj_tech_stack,
 * tj_placeholder_class
 * ---------------------------------------------------------------------- */

/**
 * Register the Project Details meta box.
 */
function tj_register_project_meta_box() {
	add_meta_box(
		'tj_project_details',
		__( 'Project Details', 'tajwar-tajim' ),
		'tj_render_project_meta_box',
		'project',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'tj_register_project_meta_box' );

/**
 * Render the Project Details meta box fields.
 *
 * @param WP_Post $post Current post object.
 */
function tj_render_project_meta_box( $post ) {
	wp_nonce_field( 'tj_save_project_details', 'tj_project_nonce' );

	$github = get_post_meta( $post->ID, 'tj_github_url', true );
	$live   = get_post_meta( $post->ID, 'tj_live_url', true );
	$stack  = get_post_meta( $post->ID, 'tj_tech_stack', true );
	$ph     = get_post_meta( $post->ID, 'tj_placeholder_class', true );
	$ph     = $ph ? $ph : 'ph-1';

	$placeholder_options = array( 'ph-1', 'ph-2', 'ph-3', 'ph-4', 'ph-5', 'ph-6' );
	?>
	<p>
		<label for="tj_github_url"><strong><?php esc_html_e( 'GitHub URL', 'tajwar-tajim' ); ?></strong></label><br />
		<input type="url" id="tj_github_url" name="tj_github_url" class="widefat"
			value="<?php echo esc_attr( $github ); ?>"
			placeholder="https://github.com/tajwar-t?tab=repositories" />
	</p>
	<p>
		<label for="tj_live_url"><strong><?php esc_html_e( 'Live Site URL', 'tajwar-tajim' ); ?></strong></label><br />
		<input type="url" id="tj_live_url" name="tj_live_url" class="widefat"
			value="<?php echo esc_attr( $live ); ?>"
			placeholder="https://example.com" />
		<span class="description"><?php esc_html_e( 'Optional — leave blank to hide the live-site link.', 'tajwar-tajim' ); ?></span>
	</p>
	<p>
		<label for="tj_tech_stack"><strong><?php esc_html_e( 'Tech Stack', 'tajwar-tajim' ); ?></strong></label><br />
		<input type="text" id="tj_tech_stack" name="tj_tech_stack" class="widefat"
			value="<?php echo esc_attr( $stack ); ?>"
			placeholder="Laravel, Shopify API, PHP" />
		<span class="description"><?php esc_html_e( 'Comma-separated list, rendered as stack pills.', 'tajwar-tajim' ); ?></span>
	</p>
	<p>
		<label for="tj_placeholder_class"><strong><?php esc_html_e( 'Placeholder Gradient', 'tajwar-tajim' ); ?></strong></label><br />
		<select id="tj_placeholder_class" name="tj_placeholder_class">
			<?php foreach ( $placeholder_options as $option ) : ?>
				<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $ph, $option ); ?>>
					<?php echo esc_html( $option ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<span class="description"><?php esc_html_e( 'Fallback gradient class used only when no featured image is set.', 'tajwar-tajim' ); ?></span>
	</p>
	<?php
}

/**
 * Save Project Details meta.
 *
 * @param int $post_id Post ID being saved.
 */
function tj_save_project_meta( $post_id ) {
	// Bail on autosave — no user-submitted data to save.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Verify nonce.
	if ( ! isset( $_POST['tj_project_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['tj_project_nonce'] ), 'tj_save_project_details' ) ) {
		return;
	}

	// Verify permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['tj_github_url'] ) ) {
		update_post_meta( $post_id, 'tj_github_url', esc_url_raw( wp_unslash( $_POST['tj_github_url'] ) ) );
	}

	if ( isset( $_POST['tj_live_url'] ) ) {
		update_post_meta( $post_id, 'tj_live_url', esc_url_raw( wp_unslash( $_POST['tj_live_url'] ) ) );
	}

	if ( isset( $_POST['tj_tech_stack'] ) ) {
		update_post_meta( $post_id, 'tj_tech_stack', sanitize_text_field( wp_unslash( $_POST['tj_tech_stack'] ) ) );
	}

	if ( isset( $_POST['tj_placeholder_class'] ) ) {
		$allowed_placeholders = array( 'ph-1', 'ph-2', 'ph-3', 'ph-4', 'ph-5', 'ph-6' );
		$ph_class             = sanitize_html_class( wp_unslash( $_POST['tj_placeholder_class'] ) );
		if ( ! in_array( $ph_class, $allowed_placeholders, true ) ) {
			$ph_class = 'ph-1';
		}
		update_post_meta( $post_id, 'tj_placeholder_class', $ph_class );
	}
}
add_action( 'save_post_project', 'tj_save_project_meta' );

/* -------------------------------------------------------------------------
 * Testimonial meta box: tj_client_location, tj_avatar_hue
 * ---------------------------------------------------------------------- */

/**
 * Register the Testimonial Details meta box.
 */
function tj_register_testimonial_meta_box() {
	add_meta_box(
		'tj_testimonial_details',
		__( 'Testimonial Details', 'tajwar-tajim' ),
		'tj_render_testimonial_meta_box',
		'testimonial',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'tj_register_testimonial_meta_box' );

/**
 * Render the Testimonial Details meta box fields.
 *
 * @param WP_Post $post Current post object.
 */
function tj_render_testimonial_meta_box( $post ) {
	wp_nonce_field( 'tj_save_testimonial_details', 'tj_testimonial_nonce' );

	$location = get_post_meta( $post->ID, 'tj_client_location', true );
	$hue      = get_post_meta( $post->ID, 'tj_avatar_hue', true );
	$hue      = ( '' !== $hue ) ? $hue : 0;
	?>
	<p>
		<label for="tj_client_location"><strong><?php esc_html_e( 'Client Location', 'tajwar-tajim' ); ?></strong></label><br />
		<input type="text" id="tj_client_location" name="tj_client_location" class="widefat"
			value="<?php echo esc_attr( $location ); ?>"
			placeholder="Netherlands &middot; Fiverr Client" />
	</p>
	<p>
		<label for="tj_avatar_hue"><strong><?php esc_html_e( 'Avatar Hue', 'tajwar-tajim' ); ?></strong></label><br />
		<input type="number" id="tj_avatar_hue" name="tj_avatar_hue" min="0" max="360" step="1"
			value="<?php echo esc_attr( $hue ); ?>" />
		<span class="description"><?php esc_html_e( '0-360, drives the avatar\'s HSL --hue custom property.', 'tajwar-tajim' ); ?></span>
	</p>
	<?php
}

/**
 * Save Testimonial Details meta.
 *
 * @param int $post_id Post ID being saved.
 */
function tj_save_testimonial_meta( $post_id ) {
	// Bail on autosave — no user-submitted data to save.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Verify nonce.
	if ( ! isset( $_POST['tj_testimonial_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['tj_testimonial_nonce'] ), 'tj_save_testimonial_details' ) ) {
		return;
	}

	// Verify permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['tj_client_location'] ) ) {
		update_post_meta( $post_id, 'tj_client_location', sanitize_text_field( wp_unslash( $_POST['tj_client_location'] ) ) );
	}

	if ( isset( $_POST['tj_avatar_hue'] ) ) {
		$hue = absint( wp_unslash( $_POST['tj_avatar_hue'] ) );
		$hue = min( 360, max( 0, $hue ) );
		update_post_meta( $post_id, 'tj_avatar_hue', $hue );
	}
}
add_action( 'save_post_testimonial', 'tj_save_testimonial_meta' );

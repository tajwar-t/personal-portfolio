<?php
/**
 * Server-side render for `tajwar-tajim/testimonials`.
 *
 * Queries the `testimonial` CPT (all published) and outputs ONLY the
 * `#testimonial-track` div and its `.testimonial-slide` children, matching
 * mockup/index.html exactly. The outer `.testimonial-slider` wrapper and the
 * prev/next buttons + dots stay static markup elsewhere in the template —
 * assets/js/main.js's testimonialSlider IIFE generates the dots itself by
 * reading `#testimonial-track > .testimonial-slide` at runtime, so this
 * block must not render controls of its own.
 *
 * @package Tajwar_Tajim
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$tj_testimonial_query = new WP_Query(
	array(
		'post_type'              => 'testimonial',
		'post_status'            => 'publish',
		'posts_per_page'         => -1,
		'orderby'                => 'menu_order date',
		'order'                  => 'DESC',
		'no_found_rows'          => true,
		'update_post_meta_cache' => true,
	)
);
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<div class="testimonial-track" id="testimonial-track">
		<?php
		if ( $tj_testimonial_query->have_posts() ) :
			while ( $tj_testimonial_query->have_posts() ) :
				$tj_testimonial_query->the_post();

				$tj_location = get_post_meta( get_the_ID(), 'tj_client_location', true );
				$tj_hue      = get_post_meta( get_the_ID(), 'tj_avatar_hue', true );
				$tj_hue      = ( '' !== $tj_hue ) ? absint( $tj_hue ) : 0;
				$tj_name     = get_the_title();
				$tj_initial  = $tj_name ? mb_strtoupper( mb_substr( $tj_name, 0, 1 ) ) : '?';
				?>
				<?php
				// Plain-text quote (mockup wraps a single <p>&ldquo;...&rdquo;</p> — strip any
				// block markup/HTML from post_content rather than risk nested <p> tags).
				$tj_quote = trim( wp_strip_all_tags( get_the_content() ) );
				?>
				<blockquote class="testimonial-slide">
					<p>&ldquo;<?php echo esc_html( $tj_quote ); ?>&rdquo;</p>
					<footer>
						<span class="avatar" style="--hue:<?php echo esc_attr( $tj_hue ); ?>"><?php echo esc_html( $tj_initial ); ?></span>
						<div>
							<cite><?php echo esc_html( $tj_name ); ?></cite>
							<?php if ( $tj_location ) : ?>
								<span><?php echo esc_html( $tj_location ); ?></span>
							<?php endif; ?>
						</div>
					</footer>
				</blockquote>
				<?php
			endwhile;
			wp_reset_postdata();
		endif;
		?>
	</div>
</div>

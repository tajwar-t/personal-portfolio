<?php
/**
 * Server-side render for `tajwar-tajim/blog-preview`.
 *
 * Queries the 3 latest real WordPress posts (standard `post` type, not a
 * CPT) and outputs markup matching mockup/index.html's `.blog-grid` >
 * `.blog-card` structure exactly.
 *
 * @package Tajwar_Tajim
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$tj_blog_query = new WP_Query(
	array(
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'posts_per_page'         => 3,
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
	)
);

// Rotating fallback gradient classes when a post has no featured image.
$tj_placeholder_classes = array( 'ph-1', 'ph-2', 'ph-3', 'ph-4', 'ph-5', 'ph-6' );
$tj_index               = 0;
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<div class="blog-grid">
		<?php
		if ( $tj_blog_query->have_posts() ) :
			while ( $tj_blog_query->have_posts() ) :
				$tj_blog_query->the_post();

				$tj_categories  = get_the_category();
				$tj_cat_name    = ! empty( $tj_categories ) ? $tj_categories[0]->name : '';
				$tj_permalink   = get_permalink();
				$tj_ph_class    = $tj_placeholder_classes[ $tj_index % count( $tj_placeholder_classes ) ];
				++$tj_index;
				?>
				<article class="blog-card">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php echo esc_url( $tj_permalink ); ?>" class="blog-media">
							<?php the_post_thumbnail( 'medium_large', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( $tj_permalink ); ?>" class="blog-media <?php echo esc_attr( $tj_ph_class ); ?>" aria-hidden="true"></a>
					<?php endif; ?>
					<div class="blog-body">
						<span class="blog-meta">
							<?php
							echo esc_html( get_the_date() );
							if ( $tj_cat_name ) {
								echo ' &middot; ' . esc_html( $tj_cat_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static separator entity.
							}
							?>
						</span>
						<h3><a href="<?php echo esc_url( $tj_permalink ); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo esc_html( get_the_excerpt() ); ?></p>
					</div>
				</article>
				<?php
			endwhile;
			wp_reset_postdata();
		endif;
		?>
	</div>
</div>

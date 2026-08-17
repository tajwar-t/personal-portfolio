<?php
/**
 * Server-side render for `tajwar-tajim/project-grid`.
 *
 * Renders the whole Work/Projects section — subtitle (tag), title (h2),
 * category filter tabs, and the grid itself — driven entirely by block
 * attributes (subtitle, title, postType). No Custom HTML block is used
 * anywhere in this section; everything below is produced by this one
 * dynamic block, matching mockup/index.html's `.section-heading` /
 * `.filter-tabs` / `.project-grid` > `.project-card[data-category]`
 * structure exactly, so assets/js/main.js's filter-tab logic
 * (`data-filter` / `data-category`) keeps working unchanged.
 *
 * @package Tajwar_Tajim
 *
 * @var array $attributes Block attributes (subtitle, title, postType).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$tj_subtitle  = ! empty( $attributes['subtitle'] ) ? $attributes['subtitle'] : 'Selected Work';
$tj_title     = ! empty( $attributes['title'] ) ? $attributes['title'] : "Projects I'm proud to have shipped";
$tj_post_type = ! empty( $attributes['postType'] ) && post_type_exists( $attributes['postType'] ) ? $attributes['postType'] : 'project';

$tj_has_category_filter = taxonomy_exists( 'project_category' ) && is_object_in_taxonomy( $tj_post_type, 'project_category' );

$tj_project_query = new WP_Query(
	array(
		'post_type'              => $tj_post_type,
		'post_status'            => 'publish',
		'posts_per_page'         => -1,
		'orderby'                => 'menu_order date',
		'order'                  => 'DESC',
		'no_found_rows'          => true,
		'update_post_meta_cache' => true,
		'update_post_term_cache' => true,
	)
);

// Reused verbatim from mockup/index.html's project card GitHub icon-link.
$tj_github_svg = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 .3a12 12 0 00-3.8 23.4c.6.1.8-.3.8-.6v-2c-3.3.7-4-1.6-4-1.6-.6-1.4-1.3-1.7-1.3-1.7-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.8 1.3 3.5 1 .1-.8.4-1.3.8-1.6-2.7-.3-5.4-1.3-5.4-6a4.6 4.6 0 011.2-3.2 4.3 4.3 0 010-3.2s1-.3 3.3 1.2a11.4 11.4 0 016 0C17.3 4 18.3 4.3 18.3 4.3a4.3 4.3 0 010 3.2 4.6 4.6 0 011.2 3.2c0 4.7-2.7 5.7-5.4 6 .5.4.9 1.2.9 2.3v3.4c0 .3.2.7.8.6A12 12 0 0012 .3z"/></svg>';

// The mockup has no existing "external link" icon to reuse, so this is a
// simple, conventional external-link glyph reusing the same .icon-link class.
$tj_external_svg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>';
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<div class="section-heading">
		<span class="tag reveal"><?php echo esc_html( $tj_subtitle ); ?></span>
		<h2 class="reveal"><?php echo esc_html( $tj_title ); ?></h2>
	</div>

	<?php if ( $tj_has_category_filter ) : ?>
		<?php $tj_terms = get_terms( array( 'taxonomy' => 'project_category', 'hide_empty' => true ) ); ?>
		<?php if ( ! is_wp_error( $tj_terms ) ) : ?>
			<div class="filter-tabs reveal" role="tablist" aria-label="<?php esc_attr_e( 'Filter projects by category', 'tajwar-tajim' ); ?>">
				<button class="filter-tab active" data-filter="all" role="tab" aria-selected="true"><?php esc_html_e( 'All', 'tajwar-tajim' ); ?></button>
				<?php foreach ( $tj_terms as $tj_term ) : ?>
					<button class="filter-tab" data-filter="<?php echo esc_attr( $tj_term->slug ); ?>" role="tab" aria-selected="false"><?php echo esc_html( $tj_term->name ); ?></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div class="project-grid">
		<?php
		if ( $tj_project_query->have_posts() ) :
			while ( $tj_project_query->have_posts() ) :
				$tj_project_query->the_post();

				$tj_category_slug = 'all';
				$tj_terms_for_post = $tj_has_category_filter ? get_the_terms( get_the_ID(), 'project_category' ) : null;
				if ( $tj_terms_for_post && ! is_wp_error( $tj_terms_for_post ) && ! empty( $tj_terms_for_post ) ) {
					$tj_category_slug = $tj_terms_for_post[0]->slug;
				}

				$tj_github_url = get_post_meta( get_the_ID(), 'tj_github_url', true );
				$tj_live_url   = get_post_meta( get_the_ID(), 'tj_live_url', true );
				$tj_stack_raw  = get_post_meta( get_the_ID(), 'tj_tech_stack', true );
				$tj_ph_class   = get_post_meta( get_the_ID(), 'tj_placeholder_class', true );
				$tj_ph_class   = $tj_ph_class ? $tj_ph_class : 'ph-1';

				$tj_stack = array();
				if ( $tj_stack_raw ) {
					$tj_stack = array_filter( array_map( 'trim', explode( ',', $tj_stack_raw ) ) );
				}
				?>
				<article class="project-card" data-category="<?php echo esc_attr( $tj_category_slug ); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="project-media">
							<?php the_post_thumbnail( 'large', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
						</div>
					<?php else : ?>
						<div class="project-media <?php echo esc_attr( $tj_ph_class ); ?>"><span><?php the_title(); ?></span></div>
					<?php endif; ?>

					<?php if ( $tj_github_url || $tj_live_url ) : ?>
						<div class="project-overlay">
							<?php if ( $tj_github_url ) : ?>
								<a href="<?php echo esc_url( $tj_github_url ); ?>" target="_blank" rel="noopener" class="icon-link" aria-label="<?php esc_attr_e( 'View on GitHub', 'tajwar-tajim' ); ?>"><?php echo $tj_github_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static, trusted inline SVG. ?></a>
							<?php endif; ?>
							<?php if ( $tj_live_url ) : ?>
								<a href="<?php echo esc_url( $tj_live_url ); ?>" target="_blank" rel="noopener" class="icon-link" aria-label="<?php esc_attr_e( 'View live site', 'tajwar-tajim' ); ?>"><?php echo $tj_external_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static, trusted inline SVG. ?></a>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<div class="project-body">
						<?php if ( $tj_terms_for_post && ! is_wp_error( $tj_terms_for_post ) && ! empty( $tj_terms_for_post ) ) : ?>
							<span class="project-tag"><?php echo esc_html( $tj_terms_for_post[0]->name ); ?></span>
						<?php endif; ?>
						<h3><?php the_title(); ?></h3>
						<p><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php if ( ! empty( $tj_stack ) ) : ?>
							<ul class="project-stack">
								<?php foreach ( $tj_stack as $tj_tech ) : ?>
									<li><?php echo esc_html( $tj_tech ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</article>
				<?php
			endwhile;
			wp_reset_postdata();
		endif;
		?>
	</div>
</div>

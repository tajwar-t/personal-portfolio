/**
 * Editor registration for tajwar-tajim/testimonials.
 *
 * Plain vanilla JS against WordPress's own global scripts — no build step,
 * no npm, no JSX. Rendering (editor preview and front end) is handled by
 * render.php via block.json's "render" field.
 */
( function ( blocks, element, blockEditor, i18n ) {
	'use strict';

	var el = element.createElement;
	var useBlockProps = blockEditor.useBlockProps;
	var ServerSideRender = window.wp.serverSideRender;
	var __ = i18n.__;

	blocks.registerBlockType( 'tajwar-tajim/testimonials', {
		edit: function () {
			var blockProps = useBlockProps();
			return el(
				'div',
				blockProps,
				el(
					'p',
					{ style: { margin: '0 0 8px', fontWeight: 600 } },
					__( 'Testimonials (live data)', 'tajwar-tajim' )
				),
				el( ServerSideRender, { block: 'tajwar-tajim/testimonials' } )
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.i18n );

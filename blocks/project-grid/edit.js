/**
 * Editor registration for tajwar-tajim/project-grid.
 *
 * Plain vanilla JS against WordPress's own global scripts (wp.blocks,
 * wp.element, wp.blockEditor, wp.serverSideRender, wp.i18n) — no build
 * step, no npm, no JSX. The block's actual rendering (both editor preview
 * and front end) is handled entirely by render.php via block.json's
 * "render" field; this file only needs to register the block type and
 * show a live preview in the editor.
 */
( function ( blocks, element, blockEditor, i18n ) {
	'use strict';

	var el = element.createElement;
	var useBlockProps = blockEditor.useBlockProps;
	var ServerSideRender = window.wp.serverSideRender;
	var __ = i18n.__;

	blocks.registerBlockType( 'tajwar-tajim/project-grid', {
		edit: function () {
			var blockProps = useBlockProps();
			return el(
				'div',
				blockProps,
				el(
					'p',
					{ style: { margin: '0 0 8px', fontWeight: 600 } },
					__( 'Project Grid (live data)', 'tajwar-tajim' )
				),
				el( ServerSideRender, { block: 'tajwar-tajim/project-grid' } )
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.i18n );

/**
 * Editor registration for tajwar-tajim/project-grid.
 *
 * Plain vanilla JS against WordPress's own global scripts (wp.blocks,
 * wp.element, wp.blockEditor, wp.components, wp.serverSideRender,
 * wp.apiFetch, wp.i18n) — no build step, no npm, no JSX.
 *
 * Three editable inputs live in the Inspector sidebar: subtitle (the small
 * eyebrow label), title (the section heading), and postType (which post
 * type's published entries drive the grid + category filter tabs). The
 * canvas itself shows a live ServerSideRender preview driven by the block's
 * own render.php, so title/subtitle/filter-tabs/grid all update together
 * as attributes change — no separate Custom HTML block anywhere.
 */
( function ( blocks, element, blockEditor, components, serverSideRender, apiFetch, i18n ) {
	'use strict';

	var el = element.createElement;
	var useState = element.useState;
	var useEffect = element.useEffect;
	var useBlockProps = blockEditor.useBlockProps;
	var InspectorControls = blockEditor.InspectorControls;
	var PanelBody = components.PanelBody;
	var TextControl = components.TextControl;
	var SelectControl = components.SelectControl;
	var ServerSideRender = serverSideRender;
	var __ = i18n.__;

	blocks.registerBlockType( 'tajwar-tajim/project-grid', {
		edit: function ( props ) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;
			var blockProps = useBlockProps();

			var postTypeState = useState( [
				{ label: __( 'Projects', 'tajwar-tajim' ), value: 'project' },
			] );
			var postTypeOptions = postTypeState[ 0 ];
			var setPostTypeOptions = postTypeState[ 1 ];

			useEffect( function () {
				apiFetch( { path: '/wp/v2/types' } ).then( function ( types ) {
					var options = Object.keys( types )
						.map( function ( slug ) {
							return { slug: slug, type: types[ slug ] };
						} )
						.filter( function ( entry ) {
							return entry.type.viewable;
						} )
						.map( function ( entry ) {
							return {
								label: entry.type.name,
								value: entry.slug,
							};
						} );
					if ( options.length ) {
						setPostTypeOptions( options );
					}
				} ).catch( function () {
					// Keep the fallback "Projects" option if the request fails.
				} );
			}, [] );

			return el(
				element.Fragment,
				{},
				el(
					InspectorControls,
					{},
					el(
						PanelBody,
						{ title: __( 'Section Content', 'tajwar-tajim' ) },
						el( TextControl, {
							label: __( 'Subtitle (eyebrow)', 'tajwar-tajim' ),
							value: attributes.subtitle,
							onChange: function ( value ) {
								setAttributes( { subtitle: value } );
							},
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} ),
						el( TextControl, {
							label: __( 'Title', 'tajwar-tajim' ),
							value: attributes.title,
							onChange: function ( value ) {
								setAttributes( { title: value } );
							},
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} ),
						el( SelectControl, {
							label: __( 'Post type source', 'tajwar-tajim' ),
							value: attributes.postType,
							options: postTypeOptions,
							onChange: function ( value ) {
								setAttributes( { postType: value } );
							},
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} )
					)
				),
				el(
					'div',
					blockProps,
					el(
						'p',
						{ style: { margin: '0 0 8px', fontWeight: 600 } },
						__( 'Projects Section (live data)', 'tajwar-tajim' )
					),
					el( ServerSideRender, {
						block: 'tajwar-tajim/project-grid',
						attributes: attributes,
					} )
				)
			);
		},
		save: function () {
			return null;
		},
	} );
} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.blockEditor,
	window.wp.components,
	window.wp.serverSideRender,
	window.wp.apiFetch,
	window.wp.i18n
);

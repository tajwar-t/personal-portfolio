/**
 * Editor registration for tajwar-tajim/site-header.
 *
 * Plain vanilla JS against WordPress's own global scripts — no build
 * step, no npm, no JSX. Inspector exposes which WordPress Menu drives
 * the nav (falls back to the "Primary Navigation" theme location when
 * left on "Default") and the CTA button's text/link. The canvas shows
 * a live ServerSideRender preview from the block's own render.php.
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

	blocks.registerBlockType( 'tajwar-tajim/site-header', {
		edit: function ( props ) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;
			var blockProps = useBlockProps();

			var menuState = useState( [
				{ label: __( 'Default (Primary Navigation location)', 'tajwar-tajim' ), value: 0 },
			] );
			var menuOptions = menuState[ 0 ];
			var setMenuOptions = menuState[ 1 ];

			useEffect( function () {
				apiFetch( { path: '/wp/v2/menus?per_page=100' } ).then( function ( menus ) {
					var options = [ { label: __( 'Default (Primary Navigation location)', 'tajwar-tajim' ), value: 0 } ].concat(
						menus.map( function ( menu ) {
							return { label: menu.name, value: menu.id };
						} )
					);
					setMenuOptions( options );
				} ).catch( function () {
					// Keep the fallback "Default" option if the request fails.
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
						{ title: __( 'Navigation', 'tajwar-tajim' ) },
						el( SelectControl, {
							label: __( 'Menu', 'tajwar-tajim' ),
							help: __( 'Manage menu items under Appearance → Menus.', 'tajwar-tajim' ),
							value: attributes.menuId,
							options: menuOptions,
							onChange: function ( value ) {
								setAttributes( { menuId: parseInt( value, 10 ) } );
							},
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} )
					),
					el(
						PanelBody,
						{ title: __( 'CTA Button', 'tajwar-tajim' ), initialOpen: false },
						el( TextControl, {
							label: __( 'Button text', 'tajwar-tajim' ),
							value: attributes.ctaText,
							onChange: function ( value ) {
								setAttributes( { ctaText: value } );
							},
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} ),
						el( TextControl, {
							label: __( 'Button link', 'tajwar-tajim' ),
							value: attributes.ctaUrl,
							onChange: function ( value ) {
								setAttributes( { ctaUrl: value } );
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
						__( 'Site Header (live preview)', 'tajwar-tajim' )
					),
					el( ServerSideRender, {
						block: 'tajwar-tajim/site-header',
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

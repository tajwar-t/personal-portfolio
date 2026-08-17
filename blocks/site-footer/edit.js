/**
 * Editor registration for tajwar-tajim/site-footer.
 *
 * Plain vanilla JS against WordPress's own global scripts — no build
 * step, no npm, no JSX. Inspector exposes which WordPress Menu drives
 * each footer column (falls back to its theme location when left on
 * "Default") plus the tagline/newsletter/copyright/credit copy. The
 * canvas shows a live ServerSideRender preview from render.php.
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

	var DEFAULT_OPTION = { label: __( 'Default (theme location)', 'tajwar-tajim' ), value: 0 };

	blocks.registerBlockType( 'tajwar-tajim/site-footer', {
		edit: function ( props ) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;
			var blockProps = useBlockProps();

			var menuState = useState( [ DEFAULT_OPTION ] );
			var menuOptions = menuState[ 0 ];
			var setMenuOptions = menuState[ 1 ];

			useEffect( function () {
				apiFetch( { path: '/wp/v2/menus?per_page=100' } ).then( function ( menus ) {
					var options = [ DEFAULT_OPTION ].concat(
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
							label: __( 'Sitemap column menu', 'tajwar-tajim' ),
							help: __( 'Manage menu items under Appearance → Menus.', 'tajwar-tajim' ),
							value: attributes.sitemapMenuId,
							options: menuOptions,
							onChange: function ( value ) {
								setAttributes( { sitemapMenuId: parseInt( value, 10 ) } );
							},
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} ),
						el( SelectControl, {
							label: __( 'Elsewhere column menu', 'tajwar-tajim' ),
							value: attributes.elsewhereMenuId,
							options: menuOptions,
							onChange: function ( value ) {
								setAttributes( { elsewhereMenuId: parseInt( value, 10 ) } );
							},
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} )
					),
					el(
						PanelBody,
						{ title: __( 'Brand & Copy', 'tajwar-tajim' ), initialOpen: false },
						el( TextControl, {
							label: __( 'Tagline', 'tajwar-tajim' ),
							value: attributes.tagline,
							onChange: function ( value ) {
								setAttributes( { tagline: value } );
							},
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} ),
						el( TextControl, {
							label: __( 'Newsletter heading', 'tajwar-tajim' ),
							value: attributes.newsletterHeading,
							onChange: function ( value ) {
								setAttributes( { newsletterHeading: value } );
							},
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} ),
						el( TextControl, {
							label: __( 'Newsletter text', 'tajwar-tajim' ),
							value: attributes.newsletterText,
							onChange: function ( value ) {
								setAttributes( { newsletterText: value } );
							},
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} ),
						el( TextControl, {
							label: __( 'Copyright text', 'tajwar-tajim' ),
							help: __( 'Shown after the auto-updating year.', 'tajwar-tajim' ),
							value: attributes.copyrightText,
							onChange: function ( value ) {
								setAttributes( { copyrightText: value } );
							},
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} ),
						el( TextControl, {
							label: __( 'Credit text', 'tajwar-tajim' ),
							value: attributes.creditText,
							onChange: function ( value ) {
								setAttributes( { creditText: value } );
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
						__( 'Site Footer (live preview)', 'tajwar-tajim' )
					),
					el( ServerSideRender, {
						block: 'tajwar-tajim/site-footer',
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

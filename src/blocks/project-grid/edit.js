import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';

export default function Edit() {
	const blockProps = useBlockProps();

	return (
		<div { ...blockProps }>
			<p style={ { margin: '0 0 8px', fontWeight: 600 } }>
				{ __( 'Project Grid (live data)', 'tajwar-tajim' ) }
			</p>
			<ServerSideRender block={ metadata.name } />
		</div>
	);
}

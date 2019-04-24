/**
 * Block dependencies
 */
import './editor.scss';

import Edit from './components/AdsEdit';

/**
 * Internal block libraries
 */
const { registerBlockType } = wp.blocks;

const blockAttributes = {
	size : {
		type: 'string',
		default: 'auto',
		enum: [ 'horizontal', 'vertical', 'auto' ],
	},
};

/**
 * Register block
 */
export default registerBlockType(
	'canino/ad',
	{
		title: 'Publicidad',
		description: 'Publicidad',
		category: 'canino',
		icon: {
			src: 'money',
		},
		attributes: blockAttributes,
		keywords: [
			'ad',
			'anuncio',
			'publicidad',
		],
		supports: [],
		edit: Edit,
		save: () => {
			// Rendered by PHP. See gutenberg.php.
			return null;
		},
	},
);

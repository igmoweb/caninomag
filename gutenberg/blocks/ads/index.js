/**
 * Block dependencies
 */
import './editor.scss';

import Edit from './components/AdsEdit';
import Save from './components/AdsSave';

/**
 * Internal block libraries
 */
const { registerBlockType } = wp.blocks;

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
		keywords: [
			'ad',
			'anuncio',
			'publicidad',
		],
		supports: [],
		edit: Edit,
		save: Save,
	},
);

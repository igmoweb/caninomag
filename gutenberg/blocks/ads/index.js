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

const blockAttributes = {
	size : {
		type: 'string',
		default: 'leaderboard',
		enum: [ 'leaderboard', 'medium' ],
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
		save: Save,
	},
);

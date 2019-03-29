/**
 * Block dependencies
 */
import './style.scss';
import './editor.scss';

import Edit from './components/ClickToTweetEdit';
import Save from './components/ClickToTweetSave';

/**
 * Internal block libraries
 */
const { registerBlockType } = wp.blocks;

const blockAttributes = {
	value : {
		type: 'string',
		source: 'html',
		selector: 'a.click-to-tweet-link',
		multiline: 'p',
		default: '',
	},
	twitterURL: {
		type: 'string',
		source: 'attribute',
		selector: 'a.click-to-tweet-link',
		attribute: 'href',
		default: '',
	},
};

/**
 * Register block
 */
export default registerBlockType(
	'canino/click-to-tweet',
	{
		title: 'Click To Tweet',
		description: 'Click to tweet',
		category: 'canino',
		icon: {
			src: 'twitter',
		},
		attributes: blockAttributes,
		keywords: [
			'twitter',
			'click',
			'tweet',
		],
		supports: [],
		edit: Edit,
		save: Save,
	},
);

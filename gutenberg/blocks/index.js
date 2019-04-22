import './click-to-tweet';
import './patreon';
import './ads';
import './style.scss';
import './editor.scss';

const allowedBlocks = [
	'jetpack/map',
	'jetpack/slideshow',
	'canino/click-to-tweet',
	'canino/patreon',
	'canino/ad',
	'core/paragraph',
	'core/image',
	'core/heading',
	'core/gallery',
	'core/list',
	'core/quote',
	'core/shortcode',
	'core/columns',
	'core/column',
	'core/embed',
	'core-embed/twitter',
	'core-embed/youtube',
	'core-embed/facebook',
	'core-embed/instagram',
	'core-embed/soundcloud',
	'core-embed/spotify',
	'core-embed/vimeo',
	'core-embed/imgur',
	'core-embed/mixcloud',
	'core-embed/polldaddy',
	'core-embed/reddit',
	'core-embed/ted',
	'core-embed/tumblr',
	'core/freeform',
	'core/html',
	'core/missing',
	'core/more',
	'core/separator',
	'core/block',
	'core/spacer',
	'core/template',
	'core/text-columns',
];

wp.domReady( () => {
	wp.blocks.getBlockTypes().forEach( function( blockType ) {
		if ( allowedBlocks.indexOf( blockType.name ) === -1 ) {
			wp.blocks.unregisterBlockType( blockType.name );
		}
	} );
} );


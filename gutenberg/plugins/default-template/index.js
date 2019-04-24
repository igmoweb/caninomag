const el = wp.element.createElement;
const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.editor;

const BLOCKS_TEMPLATE = [
	[ 'core/paragraph', { placeholder: 'Entradilla...' } ],
	[ 'core/more' ],
	[ 'core/paragraph', { placeholder: 'Contenido del artículo...' } ],
	[ 'canino/patreon', {} ],
];

registerBlockType( 'canino/template', {
	title: 'Plantilla por defecto',
	category: 'canino',
	icon: 'layout',
	edit: ( props ) => {
		return <InnerBlocks
			template={ BLOCKS_TEMPLATE }
			templateLock={ false }
		/>
	},
	save: ( props ) => {
		return <InnerBlocks.Content />;
	},
});



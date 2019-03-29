import SliderEdit from './components/SliderEdit';
const { RichText } = wp.editor;

/**
 * Block dependencies
 */
import './style.scss';
import './editor.scss';


/**
 * Internal block libraries
 */
const { registerBlockType } = wp.blocks;

const blockAttributes = {
	images: {
		type: 'array',
		default: [],
	},
};

/**
 * Register block
 */
export default registerBlockType(
	'canino/slider',
	{
		title: 'Slider',
		description: 'Click to tweet',
		category: 'canino',
		icon: 'images-alt',
		attributes: blockAttributes,
		keywords: [
			'slider',
			'image'
		],
		edit: SliderEdit,
		save: ( { attributes } ) => {
			const { images } = attributes;
			return (
				<div className="glide">
					<div className="glide__track" data-glide-el="track">
						<ul className="glide__slides">
							{ images.map( ( image ) => {
								return (
									<li key={ image.id || image.url } className="glide__slide">
										<figure>
											<img src={ image.url } alt={ image.alt } data-id={ image.id } className={ image.id ? `wp-image-${ image.id }` : null } />
											{ image.caption && image.caption.length > 0 && (
												<RichText.Content tagName="figcaption" value={ image.caption } />
											) }
										</figure>
									</li>
								);
							} ) }
						</ul>
					</div>
					<div className="glide__bullets" data-glide-el="controls[nav]">
						{
							images.map( ( image, key ) => {
								return <button className="glide__bullet" data-glide-dir={`=${key}`} />
							} )}
					</div>
				</div>
			);
		},
	},
);

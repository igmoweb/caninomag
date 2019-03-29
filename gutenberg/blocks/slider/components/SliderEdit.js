import Glide from '@glidejs/glide';
import _isEqual from 'lodash/isEqual';
import _pick from 'lodash/pick';
import _get from 'lodash/get';
import SliderImage from './SliderImage';

const { Component, Fragment } = wp.element;

const {
	withNotices,
	IconButton,
	Toolbar,
} = wp.components;
const {
	MediaPlaceholder,
	BlockControls,
	MediaUpload,
} = wp.editor;

const ALLOWED_MEDIA_TYPES = [ 'image' ];
//
export const pickRelevantMediaFiles = ( image ) => {
	const imageProps = _pick( image, [ 'alt', 'id', 'link', 'caption' ] );
	imageProps.url = _get( image, [ 'sizes', 'full', 'url' ] ) || get( image, [ 'media_details', 'sizes', 'large', 'source_url' ] ) || image.url;
	return imageProps;
};

class SliderEdit extends Component {

	state = {
		selectedImage: null,
	}

	onSelectImage( index ) {
		return () => {
			if ( this.state.selectedImage !== index ) {
				this.setState( {
					selectedImage: index,
				} );
			}
		};
	}

	onSelectImages = ( images ) => {
		const { attributes } = this.props;
		this.props.setAttributes( {
			...attributes,
			images: images.map( ( image ) => pickRelevantMediaFiles( image ) ),
		} );
	}

	initSlider() {
		if ( ! this.props.attributes.images.length ) {
			return;
		}

		const { clientId } = this.props;
		if ( typeof this.slider === 'object' ) {
			this.slider.destroy();
		}
		this.slider = new Glide( `#block-${ clientId } .glide` ).mount();
	}

	setImageAttributes( index, attributes ) {
		const { attributes: { images }, setAttributes } = this.props;
		if ( ! images[ index ] ) {
			return;
		}
		setAttributes( {
			images: [
				...images.slice( 0, index ),
				{
					...images[ index ],
					...attributes,
				},
				...images.slice( index + 1 ),
			],
		} );
	}

	componentDidUpdate( prevProps ) {
		if ( ! _isEqual( this.props.attributes.images, prevProps.attributes.images ) ) {
			this.initSlider();
		}
	}

	componentDidMount() {
		this.initSlider();
	}

	render() {
		const { attributes, isSelected, className, noticeOperations, noticeUI } = this.props;
		const { images } = attributes;

		const controls = <BlockControls>
			{ ! ! images.length && (
				<Toolbar>
					<MediaUpload
						onSelect={ this.onSelectImages }
						allowedTypes={ ALLOWED_MEDIA_TYPES }
						multiple
						gallery
						value={ images.map( ( img ) => img.id ) }
						render={ ( { open } ) => (
							<IconButton
								className="components-toolbar__control"
								label="Edit Slider"
								icon="edit"
								onClick={ open }
							/>
						) }
					/>
				</Toolbar>
			) }
		</BlockControls>;

		if ( images.length === 0 ) {
			return (
				<Fragment>
					{ controls }
					<MediaPlaceholder
						icon="format-gallery"
						className={ className }
						labels={ {
							title: 'Slider',
							instructions: 'Arrastra imágenes, sube nuevas o selecciónalas desde la librería.',
						} }
						onSelect={ this.onSelectImages }
						accept="image/*"
						allowedTypes={ ALLOWED_MEDIA_TYPES }
						multiple
						notices={ noticeUI }
						onError={ noticeOperations.createErrorNotice }
					/>
				</Fragment>
			);
		}


		return (
			<Fragment>
				{ controls }
				<div className={ `${ className } glide` }>
					<div className="glide__track" data-glide-el="track">
						<ul className="glide__slides">
							{ images.map( ( img, index ) => {
								return (
									<li key={ index } className="glide__slide">
										<SliderImage
											src={ img.url }
											alt={ img.alt }
											data-id={ img.id }
											id={ img.id }
											isSelected={ isSelected && this.state.selectedImage === index }
											// onRemove={ this.onRemoveImage( index ) }
											onSelect={ this.onSelectImage( index ) }
											setAttributes={ ( attrs ) => this.setImageAttributes( index, attrs ) }
											caption={ img.caption }
											// aria-label={ ariaLabel }
										/>
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
			</Fragment>
		)
	}
}

export default withNotices( SliderEdit );

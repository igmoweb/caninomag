import classnames from 'classnames';

const { withSelect } = wp.data;
const { Component, Fragment } = wp.element;
const { RichText } = wp.editor;
const { isBlobURL } = wp.blob;

class SliderImage extends Component {
	state = {
		captionSelected: false,
	};

	onSelectCaption = () => {
		if ( ! this.state.captionSelected ) {
			this.setState( {
				captionSelected: true,
			} );
		}

		if ( ! this.props.isSelected ) {
			this.props.onSelect();
		}
	}

	onImageClick = () => {
		if ( ! this.props.isSelected ) {
			this.props.onSelect();
		}

		if ( this.state.captionSelected ) {
			this.setState( {
				captionSelected: false,
			} );
		}
	}

	render() {
		const { src, alt, id, linkTo, link, isSelected, caption, onRemove, setAttributes, 'aria-label': ariaLabel } = this.props;

		const img = (
			// Disable reason: Image itself is not meant to be interactive, but should
			// direct image selection and unfocus caption fields.
			/* eslint-disable jsx-a11y/no-noninteractive-element-interactions */
			<Fragment>
				<img
					src={ src }
					alt={ alt }
					data-id={ id }
					tabIndex="0"
					aria-label={ ariaLabel }
					onClick={ this.onImageClick }
				/>
				{ isBlobURL( src ) && <Spinner/> }
			</Fragment>
			/* eslint-enable jsx-a11y/no-noninteractive-element-interactions */
		);

		const className = classnames( {
			'is-selected': isSelected,
			'is-transient': isBlobURL( src ),
		} );

		// Disable reason: Each block can be selected by clicking on it and we should keep the same saved markup
		/* eslint-disable jsx-a11y/no-noninteractive-element-interactions, jsx-a11y/onclick-has-role, jsx-a11y/click-events-have-key-events */
		return (
			<figure className={ className } tabIndex="-1">
				{ img }
				{ ( ! RichText.isEmpty( caption ) || isSelected ) ? (
					<RichText
						tagName="figcaption"
						placeholder="Write caption..."
						value={ caption }
						isSelected={ isSelected }
						onChange={ ( newCaption ) => setAttributes( { caption: newCaption } ) }
						unstableOnFocus={ this.onSelectCaption }
						inlineToolbar
					/>
				) : null }

			</figure>
		);
	}
}

export default withSelect( ( select, ownProps ) => {
	const { getMedia } = select( 'core' );
	const { id } = ownProps;

	return {
		image: id ? getMedia( id ) : null,
	};
})( SliderImage );

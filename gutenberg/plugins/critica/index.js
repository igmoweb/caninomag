import _get from 'lodash/get';
import './editor.scss';
import classnames from 'classnames';

const { registerPlugin } = wp.plugins;
const { Fragment, Component } = wp.element;
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost;
const { compose } = wp.compose;
const { withSelect, withDispatch } = wp.data;
const { Button, PanelBody, PanelRow, TextControl, Spinner, withNotices } = wp.components;
const { MediaPlaceholder } = wp.editor;
const { apiFetch } = wp;
const { MediaUploadCheck, MediaUpload } = wp.editor;
const { isBlobURL } = wp.blob;

const allowedMedia = [ 'image' ];
/**
 * Is the URL a temporary blob URL? A blob URL is one that is used temporarily.
 *
 * While the image is being uploaded and will not have an id yet allocated.
 *
 * @param {Object} image - The image object containing id and url properties.
 *
 * @returns {boolean} Is the URL a Blob URL.
 */
export const isTemporaryImage = ( { id, url } ) => ! id && isBlobURL( url );

/**
 * Parse a thumbnail URL from an object. Normally coming from Media Manager, REST API Endpoint
 * or a dropped file into media uploader.
 *
 * @param {Object} thumbnail - The thumbnail object.
 * @param {string} size - Image size that you ar looking for inside the thumbnail object.
 *
 * @returns {string} The image URL.
 */
export const getThumbnailUrl = ( thumbnail, size ) => {
	return _get( thumbnail, `sizes.${ size }.url` ) // Selected from media manager
		// Brought from media endpoint (This is very unlikely to happen)
		|| _get( thumbnail, `media_details.sizes.${ size }.source_url` )
		// Temporary image that is being uploaded. This will return a blob URL
		|| thumbnail.url
		|| thumbnail.source_url
		|| '';
};

/**
 * Normalize an image whether is a blob image or is coming from the DropZone or FormUploader components.
 *
 * @param {Object} thumbnail - Thumbnail object.
 * @param {string} size - Thumbnail size to select.
 *
 * @returns {Object} Media item object normalized.
 */
export const normalizeMediaObject = ( thumbnail, size ) => {
	const url = getThumbnailUrl( thumbnail, size );
	const id = _get( thumbnail, 'id', 0 );
	return {
		id,
		url,
		alt: _get( thumbnail, 'alt_text', '' ),
		isTemporary: isTemporaryImage( { id, url } ),
	};
};

const criticaFields = {
	general: {
		portada: {
			label: 'Portada',
			type: 'file',
		},
		titulo: {
			label: 'Título',
			type: 'text',
		},
		year: {
			label: 'Año',
			type: 'text',
		},
		'texto-ficha': {
			label: 'Slogan',
			type: 'text',
		},
		'texto-ficha2': {
			label: 'Texto 2',
			type: 'text',
		},
	},
	cine: {
		'cine-director': {
			label: 'Director',
			type: 'text',
		},
		'cine-guion': {
			label: 'Guión',
			type: 'text',
		},
		'cine-actores': {
			label: 'Actores',
			type: 'text',
		},
	},
	juego: {
		'game-estudio': {
			label: 'Estudio',
			type: 'text',
		},
		'game-distribuidora': {
			label: 'Distribuidora',
			type: 'text',
		},
		'game-plataformas': {
			label: 'Plataformas',
			type: 'text',
		},
	},
	libro: {
		'libro-editorial': {
			label: 'Editorial',
			type: 'text',
		},
		'libro-autor': {
			label: 'Autor',
			type: 'text',
		},
	},
	comic: {
		'comic-guionista': {
			label: 'Guionista',
			type: 'text',
		},
		'comic-editorial': {
			label: 'editorial',
			type: 'text',
		},
		'comic-dibujante': {
			label: 'Dibujante',
			type: 'text',
		},
	},
	musica: {
		'musica-artista': {
			label: 'Artista',
			type: 'text',
		},
		'musica-sello': {
			label: 'Sello',
			type: 'text',
		}
	}
};


class CriticaSidebar extends Component {
	state = {
		portada: {},
	}

	removePortada = () => {
		this.setState( { portada: normalizeMediaObject( {} ) } );
		this.props.editPost( {
			meta: {
				...this.props.meta,
				portada: 0,
			},
		} );
	}

	componentDidMount() {
		const { meta } = this.props;
		if ( meta.portada ) {
			apiFetch( {
				path: `wp/v2/media/${ meta.portada }`,
			} )
				.then( ( response ) => {
					this.setState( {
						portada: normalizeMediaObject( response, 'full' )
					} );
				} )
		}
	}

	selectPortada = ( newThumbnail ) => {
		this.setState( {
			portada: normalizeMediaObject( newThumbnail, 'full' )
		} );

		this.props.editPost( {
			meta: {
				...this.props.meta,
				portada: newThumbnail.id || 0,
			},
		} );
	}

	onUploadError = ( message ) => {
		const { noticeOperations } = this.props;
		noticeOperations.createErrorNotice( message );
	}

	render() {
		const { meta, editPost, noticeUI } = this.props;

		const removePortadaButton = <Button
			isLink
			isDestructive
			onClick={ this.removePortada }
		>
			Eliminar
		</Button>;

		return <Fragment>
			<PluginSidebarMoreMenuItem
				target="canino-critica"
			>
				Canino - Crítica
			</PluginSidebarMoreMenuItem>
			<PluginSidebar
				name="canino-critica"
				title="Crítica"
			>
				{
					Object.entries( criticaFields ).map( ( [ sectionKey, section ] ) => {
						return <PanelBody
							key={ sectionKey }
							title={ sprintf( 'Critica %s', sectionKey ) }
							className="canino-critica-sidebar"
						>

							{ Object.entries( section ).map( ( [ fieldKey, field ] ) => {
								if ( field.type === 'text' ) {
									return <PanelRow>
										<TextControl
											label={ field.label }
											value={ meta[ fieldKey ] }
											onChange={ ( newValue ) => {
												editPost( {
													meta: {
														...meta,
														[ fieldKey ]: newValue,
													},
												} );
											} }
										/>
									</PanelRow>;
								}

								const portadaId = meta[ fieldKey ];
								const isTemporary = isTemporaryImage( normalizeMediaObject( this.state.portada, 'full' ) );
								return <PanelRow>
									{
										! portadaId && ! isTemporary && <MediaPlaceholder
											labels={ {
												title: field.label,
											} }
											notices={ noticeUI }
											allowedTypes={ allowedMedia }
											multiple={ false }
											onSelect={ ( el ) => this.selectPortada( el ) }
											onError={ this.onUploadError }
										/>
									}

									{
										! ! portadaId && ! isTemporary &&
										<div className="canino-portada-wrap">
											<img src={ this.state.portada.url } alt=""/>
											<MediaUploadCheck>
												<MediaUpload
													title="Cambiar portada"
													onSelect={ this.selectPortada }
													allowedTypes={ allowedMedia }
													render={ ( { open } ) => (
														<div className="canino-portada-controls">
															<Button
																isLink
																onClick={ open }
															>
																Cambiar portada
															</Button>
															{ removePortadaButton }
														</div>
													) }
												/>
											</MediaUploadCheck>
										</div>
									}

									{
										! portadaId && isTemporary && <div className="canino-portada-wrap is-loading">
											<img src={ this.state.portada.url } alt=""/>
											<Spinner/>
										</div>
									}
								</PanelRow>

							} ) }
						</PanelBody>
					} )
				}
			</PluginSidebar>
		</Fragment>
	}
}

registerPlugin( 'canino-critica', {
	icon: 'index-card',
	render: compose( [
		withSelect( ( select ) => {
			const { getEditedPostAttribute } = select( 'core/editor' );
			const meta = getEditedPostAttribute( 'meta' );
			return {
				meta
			}
		} ),
		withDispatch( ( dispatch ) => {
			const { editPost } = dispatch( 'core/editor' );

			return {
				editPost,
			};
		} ),
		withNotices
	] )( CriticaSidebar ),
} );

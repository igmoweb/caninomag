<?php
/**
 * @author: WPMUDEV, Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Canino_Critica' ) ) {
	class Canino_Critica {
		public function __construct() {
			add_action( 'add_meta_boxes', [ $this, 'register_meta_box' ] );
			add_action( 'save_post', [ $this, 'save' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
			add_action( 'rest_api_init', [ $this, 'register_metas' ] );
		}

		public function enqueue_scripts( $hook ) {
			if ( 'post.php' === $hook ) {
				wp_enqueue_script( 'media-upload' );
				wp_enqueue_script( 'thickbox' );
				wp_enqueue_style( 'thickbox' );
			}
		}

		public function register_meta_box() {
			add_meta_box(
				'canino-critica',
				'Crítica',
				[
					$this,
					'render_critica',
				],
				'post',
				'advanced',
				[ '__back_compat_meta_box' => true ]
			);
			add_meta_box(
				'canino-critica-cine',
				'Crítica Cine',
				[
					$this,
					'render_cine',
				],
				'post',
				'advanced',
				[ '__back_compat_meta_box' => true ]
			);
			add_meta_box(
				'canino-critica-juego',
				'Crítica Juego',
				[
					$this,
					'render_juego',
				],
				'post',
				'advanced',
				[ '__back_compat_meta_box' => true ]
			);
			add_meta_box(
				'canino-critica-comic',
				'Crítica Cómic',
				[
					$this,
					'render_comic',
				],
				'post',
				'advanced',
				[ '__back_compat_meta_box' => true ]
			);
			add_meta_box(
				'canino-critica-musica',
				'Crítica Música',
				[
					$this,
					'render_musica',
				],
				'post',
				'advanced',
				[ '__back_compat_meta_box' => true ]
			);
			add_meta_box(
				'canino-critica-libro',
				'Crítica Libro',
				[
					$this,
					'render_libro',
				],
				'post',
				'advanced',
				[ '__back_compat_meta_box' => true ]
			);
		}

		public function register_metas() {
			foreach ( canino_get_critica_fields() as $section_key => $section ) {
				foreach ( $section as $field_key => $field ) {
					register_meta(
						'post',
						$field_key,
						[
							'type'         => $field['type'] === 'file' ? 'integer' : 'string',
							'single'       => true,
							'show_in_rest' => true,
						]
					);
				}
			}
		}

		public function save( $post_id ) {
			// Check if user has permissions to save data.
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			// Check if not an autosave.
			if ( wp_is_post_autosave( $post_id ) ) {
				return;
			}

			// Check if not a revision.
			if ( wp_is_post_revision( $post_id ) ) {
				return;
			}

			if ( empty( $_REQUEST['canino'] ) ) {
				return;
			}

			foreach ( $_REQUEST['canino'] as $meta_key => $meta_value ) {
				$meta_value = sanitize_text_field( $meta_value );
				if ( ! empty( $meta_value ) ) {
					update_post_meta( $post_id, $meta_key, $meta_value );
				} else {
					delete_post_meta( $post_id, $meta_key );
				}
			}
		}

		public function render( $post_id, $fields ) {
			if ( is_a( $post_id, 'WP_Post' ) ) {
				$post_id = $post_id->ID;
			}
			foreach ( $fields as $field => $atts ) {
				$name = "canino[$field]";
				$id   = "canino-$field";
				if ( 'text' === $atts['type'] ) {
					?>
					<p>
						<label for="<?php echo esc_attr( $id ); ?>>">
							<?php echo $atts['label']; ?>
						</label>
						<input type="text" class="widefat" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>" value="<?php $this->meta_value( $post_id, $field ); ?>">
					</p>
					<?php
				} elseif ( 'file' === $atts['type'] ) {
					$value = canino_get_critica_field( $field, $post_id );
					$url   = '';
					if ( $value ) {
						$url = wp_get_attachment_url( $value );
					}
					?>
					<p>
						<label for="<?php echo esc_attr( $id ); ?>>">
							<?php echo $atts['label']; ?><br/>
						</label>
						<input id="<?php echo $id; ?>-upload-button" type="button" class="button" value="Subir imagen" data-url="<?php echo esc_attr( $url ); ?>"/>
						<input type="hidden" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>" value="<?php $this->meta_value( $post_id, $field ); ?>">
					</p>
					<div id="<?php echo $id; ?>-image-holder">

					</div>
					<script>
						jQuery( document ).ready( function( $ ) {
							var $holder = $( '#<?php echo $id; ?>-image-holder' ),
								$button = $( '#<?php echo $id; ?>-upload-button' ),
								$field = $( '#<?php echo $id; ?>' ),
								uploader;

							function showImage( url ) {
								var content = $( '<img src="' + url + '" style="max-width:95%;display:block;" />' );
								var removeLink = $( '<a href="#">Eliminar</a>' );
								removeLink.click( function( e ) {
									e.preventDefault();
									$holder.html( '' );
									$field.val( '' );
								} );
								$holder.append( removeLink );
								$holder.append( content );

							}

							if ( $button.data( 'url' ) ) {
								showImage( $button.data( 'url' ) );
							}

							$button.click( function( e ) {
								if ( ! uploader ) {
									uploader = wp.media( {
										title: 'Añadir imagen',
										library: {
											type: 'image'
										},
										button: {
											text: 'Usar esta imagen'
										},
										multiple: false
									} )
										.on( 'select', function() { // it also has "open" and "close" events
											var attachment = uploader.state().get( 'selection' ).first().toJSON();
											if ( attachment.id ) {
												$field.val( attachment.id );
												showImage( attachment.url );
											}
										} );
								}
								e.preventDefault();
								uploader.open();
							} );
						} );
					</script>
					<?php
				}
			}
		}

		public function meta_value( $post_id, $key ) {
			echo esc_attr( get_post_meta( $post_id, $key, true ) );
		}

		public function render_cine( $post_id ) {
			$fields = canino_get_critica_fields( 'cine' );
			$this->render( $post_id, $fields );
		}

		public function render_juego( $post_id ) {
			$fields = canino_get_critica_fields( 'juego' );

			$this->render( $post_id, $fields );
		}

		public function render_comic( $post_id ) {
			$fields = canino_get_critica_fields( 'comic' );
			$this->render( $post_id, $fields );
		}

		public function render_musica( $post_id ) {
			$fields = canino_get_critica_fields( 'musica' );
			$this->render( $post_id, $fields );
		}

		public function render_libro( $post_id ) {
			$fields = canino_get_critica_fields( 'libro' );
			$this->render( $post_id, $fields );
		}

		public function render_critica( $post_id ) {
			$fields = canino_get_critica_fields( '' );
			$this->render( $post_id, $fields );
		}


	}
}


// new Canino_Critica();
function canino_is_critica_post() {
	$cats = wp_get_post_categories( get_the_ID() );
	if ( in_array( 236, $cats ) ) {
		return true;
	}

	return false;
}

function canino_get_critica_fields( $area = 'all' ) {
	$all_fields = [
		''       => [
			'portada'      => [
				'label'      => 'Portada',
				'type'       => 'file',
				'show-label' => true,

			],
			'titulo'       => [
				'label'      => 'Título',
				'type'       => 'text',
				'show-label' => true,
			],
			'year'         => [
				'label'      => 'Año',
				'type'       => 'text',
				'show-label' => true,
			],
			'texto-ficha'  => [
				'label'      => 'Slogan',
				'type'       => 'text',
				'show-label' => false,
			],
			'texto-ficha2' => [
				'label'      => 'Texto 2',
				'type'       => 'text',
				'show-label' => false,
			],
		],
		'cine'   => [
			'cine-director' => [
				'label'      => 'Director',
				'type'       => 'text',
				'show-label' => true,
			],
			'cine-guion'    => [
				'label'      => 'Guión',
				'type'       => 'text',
				'show-label' => true,
			],
			'cine-actores'  => [
				'label'      => 'Actores',
				'type'       => 'text',
				'show-label' => true,
			],
		],
		'juego'  => [
			'game-estudio'       => [
				'label'      => 'Estudio',
				'type'       => 'text',
				'show-label' => true,
			],
			'game-distribuidora' => [
				'label'      => 'Distribuidora',
				'type'       => 'text',
				'show-label' => true,
			],
			'game-plataformas'   => [
				'label'      => 'Plataformas',
				'type'       => 'text',
				'show-label' => true,
			],
		],
		'libro'  => [
			'libro-editorial' => [
				'label'      => 'Editorial',
				'type'       => 'text',
				'show-label' => true,
			],
			'libro-autor'     => [
				'label'      => 'Autor',
				'type'       => 'text',
				'show-label' => true,
			],
		],
		'comic'  => [
			'comic-guionista' => [
				'label'      => 'Guionista',
				'type'       => 'text',
				'show-label' => true,
			],
			'comic-editorial' => [
				'label'      => 'editorial',
				'type'       => 'text',
				'show-label' => true,
			],
			'comic-dibujante' => [
				'label'      => 'Dibujante',
				'type'       => 'text',
				'show-label' => true,
			],
		],
		'musica' => [
			'musica-artista' => [
				'label'      => 'Artista',
				'type'       => 'text',
				'show-label' => true,
			],
			'musica-sello'   => [
				'label'      => 'Sello',
				'type'       => 'text',
				'show-label' => true,
			],
		],
	];

	if ( 'all' === $area ) {
		return $all_fields;
	}

	return isset( $all_fields[ $area ] ) ? $all_fields[ $area ] : [];
}

function canino_get_critica_field( $field, $post_id = false ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$value = get_post_meta( $post_id, $field, true );
	if ( $value ) {
		return $value;
	}

	return false;
}

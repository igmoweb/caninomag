<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function canino_ad_banner( $size = 'large' ) {
	switch ( $size ) {
		case 'small': {
			$width = 300;
			$height = 250;
			break;
		}
		default: {
			$width = 748;
			$height = 90;
		}
	}
	?>
	<!-- Central_horizontal_Home -->
	<ins class="adsbygoogle"
	     style="display:inline-block;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px"
	     data-ad-client="ca-pub-8311800129241191"
	     data-ad-slot="1748594590"></ins>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
	<?php
}

function canino_get_archive_title() {
	$title = "Archivos";
	if ( is_day() ) {
		$title = __( "Archivos por día: ", 'canino' ) . get_the_date();
	} else if ( is_month() ) {
		$title = __( "Archivos por mes: ", 'canino' ) . get_the_date( 'F, Y' );
	} else if ( is_year() ) {
		$title = __( "Archivos por año: ", 'canino' ) . get_the_date( 'Y' );
	} else if ( is_tag() ) {
		$title = "Etiqueta: " . single_tag_title( "", false );
	} else if ( is_category() ) {
		$title = single_cat_title( "", false );
	} else if ( is_search() ) {
		$title = sprintf( "Resultados de la búsqueda: %s", get_search_query( false ) );
	} else if ( is_author() ) {
		$title = get_the_author();
	}
	return $title;
}

function canino_primary_class( $class = '' ) {
	if ( is_front_page() ) {
		$class .= ' column small-12 large-8 small-order-2 medium-order-1';
	}
	echo esc_attr( $class );
}

function canino_secondary_class( $class = '' ) {
	if ( is_front_page() ) {
		$class .= ' column small-12 large-4 small-order-1 medium-order-2';
	}
	echo esc_attr( $class );
}

/**
 * Remove sharing buttons from Excerpt
 */
function jptweak_remove_exshare() {
	remove_filter( 'the_excerpt', 'sharing_display',19 );
}
add_action( 'loop_start', 'jptweak_remove_exshare' );

function canino_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<h2 class="show-for-sr">Navegación de comentarios</h2>
			<div class="nav-links">
				<?php
				if ( $prev_link = get_previous_comments_link( 'Comentarios anteriores' ) ) :
					printf( '<div class="small button alignleft">&laquo; %s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( 'Comentarios más recientes' ) ) :
					printf( '<div class="small button alignright">%s &raquo;</div>', $next_link );
				endif;
				?>
			</div><!-- .nav-links -->
		</nav><!-- .comment-navigation -->
		<?php
	endif;
}

/**
 * Change order of comment reply fields
 */
add_filter( 'comment_form_fields', 'canino_comment_form_fields' );
function canino_comment_form_fields( $fields ) {
	$textarea = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $textarea;
	return $fields;
}

function alx_embed_html( $html ) {
	return '<div class="flex-video">' . $html . '</div>';
}

add_filter( 'embed_oembed_html', 'alx_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'alx_embed_html' ); // Jetpack


/**
 * Shows the logo
 */
function canino_the_custom_logo() {
	the_custom_logo();
}

add_filter( 'theme_mod_custom_logo', 'canino_custom_logo' );
function canino_custom_logo( $value ) {
	if ( ! function_exists( 'is_category' ) ) {
		return $value;
	}

	if ( is_category() ) {
		$category_id = get_queried_object_id();
		$header = get_theme_mod( 'canino_cat_header_' . $category_id );
		if ( $header && $post_id = attachment_url_to_postid( $header ) ) {
			return $post_id;
		}
	}

	return $value;
}

function canino_rich_snippet() {
	$data = false;
	if ( is_home() ) {
		$data = array(
			'@context' => 'http://schema.org',
			'@type' => 'WebSite',
			'url' => home_url(),
			'name' => get_bloginfo( 'name' ),
			'potentialAction' => array(
				'@type' => 'SearchAction',
				'target' => add_query_arg( 's', '{query}', home_url() )
			)
		);
	}
	elseif ( is_single() ) {
		$logo_id = get_theme_mod( 'custom_logo' );

		$data = array(
			'@context' => 'http://schema.org',
			'@type' => 'Article',
			'author' => array(
				'@type' => 'Thing',
				'name' => get_the_author()
			),
			'datePublished' => get_the_date( 'Y-m-d H:i:s' ),
			'dateModified' => get_the_modified_date( 'Y-m-d H:i:s' ),
			'url' => get_permalink(), // Change to AMP
			'mainEntityOfPage' => get_permalink(),
			'headline' => get_the_title(),
			'description' => get_the_excerpt(),
			'articleBody' => get_the_content(),
			'interactionCount' => 'UserComments:' . get_comments_number(),
			'publisher' => array(
				'@type' => 'Organization',
				'url' => home_url(),
				'name' => get_bloginfo( 'name' ),
				'logo' => array(
					'@type' => 'ImageObject',
					'url' => wp_get_attachment_image_src($logo_id, 'full' )
				)
			),
			'image' => array(
				'@type' => 'ImageObject',
				'url' => get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' ),
				'width' => get_option( "thumbnail_size_w" ),
				'height' => get_option( "thumbnail_size_h" )
			)
		);

		$cat = canino_get_post_category( get_the_ID() );
		if ( $cat ) {
			$data['ArticleSection'] = $cat->name;
		}
	}

	if ( $data ) {
		$data = wp_json_encode( $data );
		?>
		<script type="application/ld+json">
			<?php echo $data; ?>
		</script>
		<?php
	}
}
add_action( 'wp_head', 'canino_rich_snippet' );


function canino_the_post_teaser() {
	$post = get_post();
	$extended = get_extended( $post->post_content );
	if ( ! empty( $extended['main'] ) && ! empty( $extended['extended'] ) ) {
		echo $extended['main'];
		return;
	}
	the_excerpt();
}

function canino_the_post_content() {
	the_content( null, true );
}
<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Promoted articles? What's this?
 */
function canino_promoted_articles() {
	?>
	<!-- Composite Start -->
	<div id="M255518ScriptRootC127830">
		<div id="M255518PreloadC127830">
			Loading...
		</div>
		<script>
			(function(){
				var D=new Date(),d=document,b='body',ce='createElement',ac='appendChild',st='style',ds='display',n='none',gi='getElementById';
				var i=d[ce]('iframe');i[st][ds]=n;d[gi]("M255518ScriptRootC127830")[ac](i);try{var iw=i.contentWindow.document;iw.open();iw.writeln("<ht"+"ml><bo"+"dy></bo"+"dy></ht"+"ml>");iw.close();var c=iw[b];}
				catch(e){var iw=d;var c=d[gi]("M255518ScriptRootC127830");}var dv=iw[ce]('div');dv.id="MG_ID";dv[st][ds]=n;dv.innerHTML=127830;c[ac](dv);
				var s=iw[ce]('script');s.async='async';s.defer='defer';s.charset='utf-8';s.src="//jsc.mgid.com/c/a/caninomag.es.127830.js?t="+D.getYear()+D.getMonth()+D.getDate()+D.getHours();c[ac](s);})();
		</script>
	</div>
	<!-- Composite End -->
	<?php
}

/**
 * Renders an Ad Banner
 *
 * @param string $size Banner size.
 */
function canino_ad_banner( $size = 'large' ) {
	switch ( $size ) {
		case 'small':
			$width  = 300;
			$height = 250;
			break;
		default:
			$width  = 748;
			$height = 90;
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

/**
 * The archive titles
 *
 * @return string|void
 */
function canino_get_archive_title() {
	$title = 'Archivos';
	if ( is_day() ) {
		$title = __( 'Archivos por día: ', 'canino' ) . get_the_date();
	} elseif ( is_month() ) {
		$title = __( 'Archivos por mes: ', 'canino' ) . get_the_date( 'F, Y' );
	} elseif ( is_year() ) {
		$title = __( 'Archivos por año: ', 'canino' ) . get_the_date( 'Y' );
	} elseif ( is_tag() ) {
		$title = 'Etiqueta: ' . single_tag_title( '', false );
	} elseif ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_search() ) {
		$title = sprintf( 'Resultados de la búsqueda: %s', get_search_query( false ) );
	} elseif ( is_author() ) {
		$title = get_the_author();
	}
	return $title;
}

/**
 * Get the primary class for the main content
 *
 * @param string $class CSS Class.
 */
function canino_primary_class( $class = '' ) {
	if ( is_front_page() ) {
		$class .= ' column small-12 large-8 small-order-1 medium-order-1';
	}
	echo esc_attr( $class );
}

function canino_secondary_class( $class = '' ) {
	if ( is_front_page() ) {
		$class .= ' column small-12 large-4 small-order-2 medium-order-2';
	}
	echo esc_attr( $class );
}

/**
 * Remove sharing buttons from Excerpt
 */
function jptweak_remove_exshare() {
	remove_filter( 'the_excerpt', 'sharing_display', 19 );
}
add_action( 'loop_start', 'jptweak_remove_exshare' );

/**
 * Comments navigation
 */
function canino_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<h2 class="show-for-sr">Navegación de comentarios</h2>
			<div class="nav-links">
				<?php
				$prev_link = get_previous_comments_link( 'Comentarios anteriores' );
				$next_link = get_next_comments_link( 'Comentarios más recientes' );
				if ( $prev_link ) :
					printf( '<div class="small button alignleft">&laquo; %s</div>', $prev_link ); //phpcs:ignore
				endif;

				if ( $next_link ) :
					printf( '<div class="small button alignright">%s &raquo;</div>', $next_link ); //phpcs:ignore
				endif;
				?>
			</div><!-- .nav-links -->
		</nav><!-- .comment-navigation -->
		<?php
	endif;
}

/**
 * Change order of comment reply fields
 *
 * @param array $fields Form fields.
 *
 * @return array
 */
function canino_comment_form_fields( $fields ) {
	$textarea = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $textarea;
	return $fields;
}
add_filter( 'comment_form_fields', 'canino_comment_form_fields' );

/**
 * Wraps all embeds
 *
 * @param string $html Embed HTML.
 *
 * @return string
 */
function alx_embed_html( $html ) {
	return '<div class="flex-video">' . $html . '</div>';
}

add_filter( 'embed_oembed_html', 'alx_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'alx_embed_html' ); // Jetpack.


/**
 * Shows the logo
 */
function canino_the_custom_logo() {
	the_custom_logo();
}

/**
 * Shows the logo
 */
function canino_the_mobile_logo() {
	$custom_logo_id = get_theme_mod( 'canino_mobile_logo' );

	// We have a logo. Logo is go.
	if ( $custom_logo_id ) {
		$custom_logo_attr = array(
			'class'    => 'custom-logo hide-for-large',
			'itemprop' => 'logo',
		);

		$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
		if ( empty( $image_alt ) ) {
			$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
		}

		return sprintf(
			'<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
			esc_url( home_url( '/' ) ),
			wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr )
		);
	}

	return '';
}

/**
 * Hooks into the logo option
 *
 * @param int $value Current option value.
 *
 * @return int
 */
function canino_custom_logo( $value ) {
	if ( ! function_exists( 'is_category' ) ) {
		return $value;
	}

	if ( is_category() ) {
		$category_id = get_queried_object_id();
		$header      = get_theme_mod( 'canino_cat_header_' . $category_id );
		$post_id     = attachment_url_to_postid( $header );
		if ( $header && $post_id ) {
			return $post_id;
		}
	}

	return $value;
}
add_filter( 'theme_mod_custom_logo', 'canino_custom_logo' );


/**
 * Display the post teaser
 */
function canino_the_post_teaser() {
	$post     = get_post();
	$extended = get_extended( $post->post_content );
	if ( ! empty( $extended['main'] ) && ! empty( $extended['extended'] ) ) {
		echo $extended['main']; //phpcs:ignore
		return;
	}

	the_excerpt();
}

/**
 * Displays the post content
 */
function canino_the_post_content() {
	the_content( null, true );
}

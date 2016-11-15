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
			<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'twentyfifteen' ); ?></h2>
			<div class="nav-links">
				<?php
				if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'twentyfifteen' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'twentyfifteen' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
				?>
			</div><!-- .nav-links -->
		</nav><!-- .comment-navigation -->
		<?php
	endif;
}
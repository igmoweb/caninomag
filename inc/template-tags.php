<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function canino_ad_banner() {
	?>
	<!-- Central_horizontal_Home -->
	<ins class="adsbygoogle"
	     style="display:inline-block;width:728px;height:90px"
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
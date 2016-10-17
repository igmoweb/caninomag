<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function canino_get_archive_title() {
	$title = "Archives";
	if ( is_day() ) {
		$title = __( "Daily archives: ", 'pressroom' ) . get_the_date();
	} else if ( is_month() ) {
		$title = __( "Monthly archives: ", 'pressroom' ) . get_the_date( 'F, Y' );
	} else if ( is_year() ) {
		$title = __( "Yearly archives: ", 'pressroom' ) . get_the_date( 'Y' );
	} else if ( is_tag() ) {
		$title = single_tag_title( "", false );
	} else if ( is_category() ) {
		$title = single_cat_title( "", false );
	} else if ( is_search() ) {
		$title = __("Search results", 'pressroom');
	}
	return $title;
}
<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_multisite() && get_current_blog_id() !== 8 ) {
	return;
}


if ( is_admin() ) {
	return;
}

add_filter(
	'option_active_plugins',
	function ( $value ) {
		$request_uri = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
		unset( $value[ array_search( 'google-news-sitemap/apgnsm.php', $value ) ] );

		if ( $request_uri === '/' ) {
			unset( $value[ array_search( 'ml-slider/ml-slider.php', $value ) ] );
		}

		return $value;
	}
);


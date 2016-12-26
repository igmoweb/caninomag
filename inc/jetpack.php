<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function canino_custom_thumb_size( $get_image_options ) {
	$get_image_options['avatar_size'] = 80;
	return $get_image_options;
}
add_filter( 'jetpack_top_posts_widget_image_options', 'canino_custom_thumb_size' );

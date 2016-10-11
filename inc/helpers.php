<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function canino_get_3_cols_query( $offset = 5 ) {
	return new WP_Query( array(
		'posts_per_page' => 18,
		'page' => 1,
		'offset' => $offset,
		'ignore_sticky_posts' => true,
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => array( 'post-format-aside' ),
				'operator' => 'IN'
			)
		)
	) );
}

function canino_get_2_cols_query( $offset = 0 ) {
	return new WP_Query( array(
		'posts_per_page' => 6,
		'page' => 1,
		'offset' => $offset,
		'ignore_sticky_posts' => true,
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => array( 'post-format-aside' ),
				'operator' => 'IN'
			)
		)
	) );
}
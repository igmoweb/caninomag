<?php

/**
 * Class Canino_Query
 *
 * Modifies query parameters if needed
 */
class Canino_Query {
	public function __construct() {
		if ( is_admin() ) {
			return;
		}

		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
	}

	/**
	 * @param WP_Query $query
	 */
	public function pre_get_posts( $query ) {
		$is_archive = ( $query->is_search() || $query->is_archive() );
		if ( $query->is_main_query() && $is_archive ) {
			// Archives modifications
			set_query_var( 'posts_per_page', 12 );
		}
	}
}

new Canino_Query();

function canino_get_el_parte_home_query() {
	return new WP_Query( array(
		'showposts' => 10,
		'cat' => 30,
		'ignore_sticky_posts' => true
	));
}

function canino_get_2_cols_home_query( $offset = 0 ) {
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

function canino_get_3_cols_home_query( $offset = 6 ) {
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
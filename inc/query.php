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
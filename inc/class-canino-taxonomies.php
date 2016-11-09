<?php
/**
 * @author: WPMUDEV, Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Canino_Taxonomies' ) ) {
	class Canino_Taxonomies {

		public static function register() {
			self::register_destacado_taxonomy();
		}

		private static function register_destacado_taxonomy() {
			$labels = array(
				'name'                       => _x( 'Destacado', 'Taxonomy General Name', 'canino' ),
				'singular_name'              => _x( 'Destacado', 'Taxonomy Singular Name', 'canino' ),
				'menu_name'                  => __( 'Destacado', 'canino' ),
				'all_items'                  => __( 'All Items', 'canino' ),
				'parent_item'                => __( 'Parent Item', 'canino' ),
				'parent_item_colon'          => __( 'Parent Item:', 'canino' ),
				'new_item_name'              => __( 'New Item Name', 'canino' ),
				'add_new_item'               => __( 'Add New Item', 'canino' ),
				'edit_item'                  => __( 'Edit Item', 'canino' ),
				'update_item'                => __( 'Update Item', 'canino' ),
				'view_item'                  => __( 'View Item', 'canino' ),
				'separate_items_with_commas' => __( 'Separate items with commas', 'canino' ),
				'add_or_remove_items'        => __( 'Add or remove items', 'canino' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'canino' ),
				'popular_items'              => __( 'Popular Items', 'canino' ),
				'search_items'               => __( 'Search Items', 'canino' ),
				'not_found'                  => __( 'Not Found', 'canino' ),
				'no_terms'                   => __( 'No items', 'canino' ),
				'items_list'                 => __( 'Items list', 'canino' ),
				'items_list_navigation'      => __( 'Items list navigation', 'canino' ),
			);
			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => false,
				'public'                     => false,
				'show_ui'                    => false,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => false,
				'show_tagcloud'              => false,
				'query_var'                  => '',
				'rewrite'                    => false,
			);
			register_taxonomy( 'canino_destacado', array( 'post' ), $args );
		}
	}
}
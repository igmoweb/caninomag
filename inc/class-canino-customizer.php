<?php

class Canino_Customizer {

	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_settings' ) );
		add_filter( 'nav_menu_css_class', array( $this, 'primary_nav_menu_class' ), 10, 2 );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_inline_css' ) );
	}

	public function register_settings( $wp_customize ) {
		/** @var WP_Customize_Manager $wp_customize */

		$wp_customize->add_section( 'canino_options', array(
			'title'      => __( 'Canino' ),
			'priority'   => 10,
			'capability' => 'edit_theme_options',
		) );

		$this->ganalytics( $wp_customize );
		$this->ads( $wp_customize );
		$this->fb( $wp_customize );
		$this->category_colors( $wp_customize );
	}


	private function ganalytics( $wp_customize ) {
		$wp_customize->add_setting( 'canino_ganalytics', array(
			'type'       => 'theme_mod', // or 'option'
			'capability' => 'edit_theme_options',
			'default'    => '',
			//'sanitize_callback' => '',
		) );

		$wp_customize->add_control( 'canino_ganalytics', array(
			'type'    => 'textarea',
			'section' => 'canino_options', // Required, core or custom.
			'label'   => 'Google Analytics Code',
			'description'   => 'Do not add &lt;script&gt; tags'
		) );
	}

	private function ads( $wp_customize ) {
		$wp_customize->add_setting( 'canino_ads', array(
			'type'       => 'theme_mod', // or 'option'
			'capability' => 'edit_theme_options',
			'default'    => '',
			//'sanitize_callback' => '',
		) );

		$wp_customize->add_control( 'canino_ads', array(
			'type'    => 'textarea',
			'section' => 'canino_options', // Required, core or custom.
			'label'   => 'Ads Javascript',
			'description'   => 'Include &lt;script&gt; tags'
		) );
	}

	private function fb( $wp_customize ) {
		$wp_customize->add_setting( 'canino_fb', array(
			'type'       => 'theme_mod', // or 'option'
			'capability' => 'edit_theme_options',
			'default'    => '',
		) );

		$wp_customize->add_control( 'canino_fb', array(
			'type'    => 'textarea',
			'section' => 'canino_options', // Required, core or custom.
			'label'   => 'Facebook Footer Code'
		) );
	}

	private function category_colors( $wp_customize ) {
		$categories = get_terms( array( 'taxonomy' => 'category', 'hide-empty' => false ) );
		foreach ( $categories as $category ) {
			$wp_customize->add_setting( 'canino_cat_color_' . $category->term_id, array(
				'type'       => 'theme_mod', // or 'option'
				'capability' => 'edit_theme_options',
				'default'    => '',
			) );

			$wp_customize->add_control(
				new WP_Customize_Color_Control( $wp_customize, 'canino_cat_color_' . $category->term_id, array(
					'label' => sprintf( 'Categoría: %s', $category->name ),
					'section' => 'canino_options',
				) ) );
		}
	}

	public function add_inline_css() {
		$categories = get_terms( array( 'taxonomy' => 'category', 'hide-empty' => false ) );
		foreach ( $categories as $category ) {
			$color = get_theme_mod( 'canino_cat_color_' . $category->term_id, '' );
			if ( $color ) {

				$css = "
					#site-navigation ul.canino-primary-menu > li.menu-item-object-category-{$category->term_id}:hover {border-top-color:{$color}}
					a.category-{$category->term_id} {color:{$color}}
					body.category-{$category->term_id} #masthead {background-color:{$color}}
					";
				wp_add_inline_style( 'canino-style', $css );
			}
		}
	}

	/**
	 * Add an extra class for category items in menus
	 */
	public function primary_nav_menu_class( $class, $item) {
		if ( 'category' === $item->object ) {
			$class[] = 'menu-item-object-category-' . $item->object_id;
		}
		return $class;
	}

}

new Canino_Customizer();
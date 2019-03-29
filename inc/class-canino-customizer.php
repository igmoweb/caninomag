<?php

/**
 * Manage the customizer options
 */
class Canino_Customizer {

	/**
	 * Canino_Customizer constructor.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_settings' ) );
		add_filter( 'nav_menu_css_class', array( $this, 'primary_nav_menu_class' ), 10, 2 );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_inline_css' ) );
		add_action( 'the_category_list', array( $this, 'the_category_list' ) );
		add_action( 'parse_query', array( $this, 'parse_query' ) );
	}

	/**
	 * Register customizer options.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager.
	 */
	public function register_settings( $wp_customize ) {
		$wp_customize->add_panel(
			'canino_panel',
			array(
				'title'      => 'Canino',
				'priority'   => 10,
				'capability' => 'edit_theme_options',
			)
		);

		$wp_customize->add_section(
			'canino_options_analytics',
			array(
				'title'      => 'Analytics y Ads',
				'capability' => 'edit_theme_options',
				'panel'      => 'canino_panel',
			)
		);

		$wp_customize->add_section(
			'canino_options_colors',
			array(
				'title'      => 'Colores',
				'capability' => 'edit_theme_options',
				'panel'      => 'canino_panel',
			)
		);

		$wp_customize->add_section(
			'canino_options_headers',
			array(
				'title'      => 'Cabeceras de categorías',
				'capability' => 'edit_theme_options',
				'panel'      => 'canino_panel',
			)
		);

		$wp_customize->add_section(
			'canino_options_front_page',
			array(
				'title'      => 'Opciones de la home',
				'capability' => 'edit_theme_options',
				'panel'      => 'canino_panel',
			)
		);

		$this->ganalytics( $wp_customize );
		$this->ads( $wp_customize );
		$this->category_colors( $wp_customize );
		$this->category_headers( $wp_customize );
		$this->destacado_category( $wp_customize );
		$this->destacado_pequeno_category( $wp_customize );
		$this->logo_movil( $wp_customize );
	}

	/**
	 * G Analytics options
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager.
	 */
	private function ganalytics( $wp_customize ) {
		$wp_customize->add_setting(
			'canino_ganalytics',
			array(
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'default'    => '',
			)
		);

		$wp_customize->add_control(
			'canino_ganalytics',
			array(
				'type'        => 'textarea',
				'section'     => 'canino_options_analytics', // Required, core or custom.
				'label'       => 'Google Analytics Code',
				'description' => 'Do not add &lt;script&gt; tags',
			)
		);
	}

	/**
	 * Ads options
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager.
	 */
	private function ads( $wp_customize ) {
		$wp_customize->add_setting(
			'canino_ads',
			array(
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'default'    => '',
			)
		);

		$wp_customize->add_control(
			'canino_ads',
			array(
				'type'        => 'textarea',
				'section'     => 'canino_options_analytics', // Required, core or custom.
				'label'       => 'Ads Javascript',
				'description' => 'Include &lt;script&gt; tags',
			)
		);
	}

	/**
	 * Category colors options
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager.
	 */
	private function category_colors( $wp_customize ) {
		$categories = get_terms(
			array(
				'taxonomy'   => 'category',
				'hide-empty' => false,
			)
		);
		foreach ( $categories as $category ) {
			$wp_customize->add_setting(
				'canino_cat_color_' . $category->term_id,
				array(
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options',
					'default'    => '',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'canino_cat_color_' . $category->term_id,
					array(
						'label'   => sprintf( 'Categoría: %s', $category->name ),
						'section' => 'canino_options_colors',
					)
				)
			);
		}
	}

	/**
	 * Categories headers options
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager.
	 */
	private function category_headers( $wp_customize ) {
		$categories = get_terms(
			array(
				'taxonomy'   => 'category',
				'hide-empty' => false,
			)
		);
		foreach ( $categories as $category ) {
			$wp_customize->add_setting(
				'canino_cat_header_' . $category->term_id,
				array(
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options',
					'default'    => '',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Upload_Control(
					$wp_customize,
					'canino_cat_header_' . $category->term_id,
					array(
						'label'   => sprintf( 'Cabecera de categoría: %s', $category->name ),
						'section' => 'canino_options_headers',
					)
				)
			);
		}
	}

	/**
	 * Add inline CSS based on Customizer options.
	 */
	public function add_inline_css() {
		$categories = get_terms(
			array(
				'taxonomy'               => 'category',
				'hide-empty'             => false,
				'update_term_meta_cache' => false,
			)
		);
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
	 * Destacado options.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager.
	 */
	private function destacado_category( $wp_customize ) {
		$wp_customize->add_setting(
			'canino_destacado_category',
			array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'default'           => 4117,
				'sanitize_callback' => array( $this, 'sanitize_term_id' ),
			)
		);

		$wp_customize->add_control(
			'canino_destacado_category',
			array(
				'type'        => 'number',
				'description' => '<a target="_blank" href="https://sensacionweb.com/que-es-id-post-pagina-wordpress/#ver-la-id-de-una-categoria-y-etiqueta-desde-wordpress">Cómo averiguar el ID de una categoría o tag</a>',
				'section'     => 'canino_options_front_page',
				'label'       => 'ID de Categoría de Destacados',
			)
		);
	}

	/**
	 * Destacado pequeño options
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager.
	 */
	private function destacado_pequeno_category( $wp_customize ) {
		$wp_customize->add_setting(
			'canino_destacado_pequeno_category',
			array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'default'           => 4118,
				'sanitize_callback' => array( $this, 'sanitize_term_id' ),
			)
		);

		$wp_customize->add_control(
			'canino_destacado_pequeno_category',
			array(
				'type'        => 'number',
				'description' => '<a target="_blank" href="https://sensacionweb.com/que-es-id-post-pagina-wordpress/#ver-la-id-de-una-categoria-y-etiqueta-desde-wordpress">Cómo averiguar el ID de una categoría o tag</a>',
				'section'     => 'canino_options_front_page',
				'label'       => 'ID de Categoría de Destacados Pequeños',
			)
		);
	}

	/**
	 * Mobile logo option
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager.
	 */
	private function logo_movil( $wp_customize ) {
		$wp_customize->add_setting(
			'canino_mobile_logo',
			array(
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Cropped_Image_Control(
				$wp_customize,
				'canino_mobile_logo',
				array(
					'flex_height' => false,
					'flex_width'  => false,
					'label'       => 'Logo para móvil',
					'section'     => 'title_tagline',
				)
			)
		);
	}


	/**
	 * Term sanitization
	 *
	 * @param int $value Term ID.
	 *
	 * @return int
	 */
	public function sanitize_term_id( $value ) {
		$term = get_term( $value );
		if ( ! is_a( $term, 'WP_Term' ) ) {
			return 0;
		}
		return $term->term_id;
	}

	/**
	 * Add an extra class for category items in menus
	 *
	 * @param array   $class CSS class.
	 * @param WP_Term $item Term.
	 *
	 * @return array
	 */
	public function primary_nav_menu_class( $class, $item ) {
		if ( 'category' === $item->object ) {
			$class[] = 'menu-item-object-category-' . $item->object_id;
		}
		return $class;
	}

	/**
	 * Filter the category list based on Customizer options
	 *
	 * @param array $categories Categories list.
	 *
	 * @return array
	 */
	public function the_category_list( $categories ) {
		return array_values(
			array_filter(
				$categories,
				function( $category ) {
					return ( ! in_array( $category->term_id, array( canino_get_destacado_term_id(), canino_get_destacado_pequeno_term_id() ) ) ); //phpcs:ignore
				}
			)
		);
	}

	/**
	 * Parses query based on Customizer options
	 *
	 * @param WP_Query $query Query object.
	 */
	public function parse_query( $query ) {
		if (
			is_main_query()
			&& $query->is_category()
			&& (
				$query->get_queried_object_id() == canino_get_destacado_term_id() //phpcs:ignore
				|| $query->get_queried_object_id() == canino_get_destacado_pequeno_term_id() //phpcs:ignore
			)
		) {
			$query->is_404      = true;
			$query->is_category = false;
			$query->is_archive  = false;
		}
	}

}

/**
 * Return the destacado term ID
 *
 * @return string|int
 */
function canino_get_destacado_term_id() {
	return get_theme_mod( 'canino_destacado_category', 4117 );
}

/**
 * Return the destacado pequeño term ID
 *
 * @return string|int
 */
function canino_get_destacado_pequeno_term_id() {
	return get_theme_mod( 'canino_destacado_pequeno_category', 4118 );
}


new Canino_Customizer();

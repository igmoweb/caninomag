<?php

class Canino_Customizer {

	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_settings' ) );
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

}

new Canino_Customizer();
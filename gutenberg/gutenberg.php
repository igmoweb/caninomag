<?php

namespace Canino\Blocks;

/**
 * Gets this plugin's absolute directory path.
 *
 * @since  2.1.0
 * @ignore
 * @access private
 *
 * @return string
 */
function _get_blocks_directory() {
	return __DIR__;
}

/**
 * Gets this plugin's URL.
 *
 * @since  2.1.0
 * @ignore
 * @access private
 *
 * @return string
 */
function _get_dist_url() {
	static $plugin_url;

	if ( empty( $plugin_url ) ) {
		$plugin_url = get_stylesheet_directory_uri() . '/js';
	}

	return $plugin_url;
}

add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_assets' );
/**
 * Enqueue block editor only JavaScript and CSS.
 */
function enqueue_block_editor_assets() {
	// Make paths variables so we don't write em twice ;).
	$block_path         = '/editor.blocks.js';
	$plugins_path       = '/editor.plugins.js';
	$blocks_style_path  = '/css/editor.editor.blocks.css';
	$plugins_style_path = '/css/editor.editor.plugins.css';
	$style_path         = '/css/style.editor.blocks.css';

	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );

	// Enqueue the bundled block JS file.
	wp_enqueue_script(
		'canino-blocks-js',
		_get_dist_url() . $block_path,
		[ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' ],
		$version,
		false
	);

	// Enqueue the bundled block JS file.
	wp_enqueue_script(
		'canino-plugins-js',
		_get_dist_url() . $plugins_path,
		[ 'canino-blocks-js' ],
		$version,
		false
	);

	// Enqueue optional editor only styles.
	wp_enqueue_style(
		'canino-blocks-editor-style',
		_get_dist_url() . $blocks_style_path,
		[],
		$version
	);

	wp_enqueue_style(
		'canino-plugins-editor',
		_get_dist_url() . $plugins_style_path,
		[],
		$version
	);

	wp_enqueue_style(
		'canino-blocks-style',
		_get_dist_url() . $style_path,
		[],
		$version
	);
}

add_action( 'enqueue_block_assets', __NAMESPACE__ . '\enqueue_assets' );
/**
 * Enqueue front end and editor JavaScript and CSS assets.
 */
function enqueue_assets() {
	$style_path = '/css/style.editor.blocks.css';
	$theme      = wp_get_theme();
	wp_enqueue_style(
		'canino-blocks',
		_get_dist_url() . $style_path,
		null,
		$theme->get( 'Version' )
	);
}

add_action( 'enqueue_block_assets', __NAMESPACE__ . '\enqueue_frontend_assets' );
/**
 * Enqueue frontend JavaScript and CSS assets.
 */
function enqueue_frontend_assets() {

	// If in the backend, bail out.
	if ( is_admin() ) {
		return;
	}

	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );

	$block_path = '/frontend.blocks.js';
	wp_enqueue_script(
		'canino-blocks-frontend',
		_get_dist_url() . $block_path,
		[ 'jquery' ],
		$version,
		true
	);
}

function add_block_category( $categories ) {
	return array_merge(
		$categories,
		[
			[
				'slug'  => 'canino',
				'title' => __( 'Canino Blocks', 'canino' ),
			],
		]
	);
}

add_filter( 'block_categories', __NAMESPACE__ . '\add_block_category', 10, 2 );

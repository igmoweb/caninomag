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

	wp_enqueue_style(
		'canino-fonts',
		'https://fonts.googleapis.com/css?family=Lora|Arvo',
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

/**
 * Add Canino blocks category.
 *
 * @param array $categories Current block categories.
 *
 * @return array
 */
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

add_action(
	'init',
	function () {
		register_block_type(
			'canino/ad',
			[
				'render_callback' => __NAMESPACE__ . '\render_ad_block',
			]
		);
	}
);

/**
 * Ad block server side rendering.
 *
 * @param array $attributes Ad block attributes.
 *
 * @return false|string
 */
function render_ad_block( $attributes ) {
	ob_start();
	$size = isset( $attributes['size'] ) ? $attributes['size'] : 'auto';
	// phpcs:disable
	?>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- Inside_adaptable_articulo -->
	<ins class="adsbygoogle"
		 style="display:block"
		 data-ad-client="ca-pub-8311800129241191"
		 data-ad-slot="2524484593"
		 data-ad-format="<?php echo esc_attr( $size ); ?>"></ins>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push( {} );
	</script>
	<?php
	return ob_get_clean();
	// phpcs:enable
}

add_action(
	'init',
	function () {
		$post_type_object           = get_post_type_object( 'post' );
		$post_type_object->template = [
			[ 'canino/template' ],
		];
	}
);

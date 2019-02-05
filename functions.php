<?php
/**
 * @author: WPMUDEV, Ignacio Cruz (igmoweb)
 * @version:
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $content_width ) ) {
	$content_width = 600;
}

class Canino_Theme {

	private static $instance;

	public $version = '1.0';

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		add_filter( 'the_more_excerpt', array( $this, 'change_article_excerpt' ) );
		add_action( 'wp_head', array( $this, 'add_googleanalytics' ) );
		add_action( 'wp_footer', array( $this, 'add_ads' ) );

		add_filter( 'rp4wp_thumbnail_size', array( $this, 'rp4wp_my_thumbnail_size' ) );
		add_filter( 'rp4wp_append_content', '__return_false' );

		add_filter( 'esc_html', array( $this, 'rename_post_formats' ) );
		add_action( 'admin_head', array( $this, 'live_rename_formats' ) );

		add_action( 'admin_init', array( $this, 'maybe_upgrade' ) );

		add_action( 'media_buttons', array( $this, 'add_shortcode_button' ) );

		include_once 'inc/class-canino-load-more.php';
		include_once 'inc/class-canino-query.php';
		include_once 'inc/class-canino-customizer.php';
		include_once 'inc/class-canino-critica.php';
		include_once 'inc/class-canino-rich-snippets.php';
		include_once 'inc/shortcodes/post-banner.php';
		include_once 'inc/shortcodes/ad-banner.php';
		include_once 'inc/template-tags.php';
		include_once 'inc/jetpack.php';
		include_once 'inc/widgets/publicidad.php';
		include_once 'inc/widgets/articulos.php';
		include_once 'inc/hooks-templates.php';

		new Canino_Rich_Snippets();
	}

	function enqueue_styles() {
		$version = '20190204';
		wp_enqueue_style( 'canino-style', get_stylesheet_directory_uri() . '/css/app.css', array(), $version );
		wp_enqueue_style( 'canino-fonts', 'https://fonts.googleapis.com/css?family=Lora|Arvo' );
		wp_enqueue_script(
			'canino-foundation',
			get_stylesheet_directory_uri() . '/js/foundation.min.js',
			array( 'jquery' ),
			$version
		);

		$js = '
jQuery( document ).ready( function() {
	jQuery(document).foundation();
} );		
';
		wp_add_inline_script( 'canino-foundation', $js );

		if ( is_single() || is_author() ) {
			wp_enqueue_style( 'dashicons' );
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}


	function init() {
		load_child_theme_textdomain( 'canino', get_stylesheet_directory() . '/languages' );

		add_editor_style();

		add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'video' ) );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );

		// Sidebars
		register_sidebar(
			array(
				'name'          => 'Barra Lateral',
				'id'            => 'cabecera-arriba-del-to',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => 'Página de autor',
				'id'            => 'author',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => 'Pie de Página (Izquierda)',
				'id'            => 'pie-izq',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => 'Pie de Página (Centro)',
				'id'            => 'pie-centro',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => 'Pie de Página (Derecha)',
				'id'            => 'pie-dcha',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => 'Top Bar',
				'id'            => 'top-bar',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			)
		);

		add_image_size( 'post-grid-thumb-large', 787, 524, true );
		add_image_size( 'post-grid-thumb-big', 524, 524, true );
		add_image_size( 'post-grid-thumb-medium', 524, 261, true );
		add_image_size( 'blog-post-thumb', 330, 242, true );
		add_image_size( 'articulos-widget-small', 100, 100, true );
		add_image_size( 'articulos-widget-big', 524, 261, true );
		add_image_size( 'single-post-thumb', 634, 424, true );

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'canino' ),
				'social'  => __( 'Social Links Menu', 'canino' ),
			)
		);
	}

	function change_article_excerpt( $excerpt ) {
		global $page, $pages;

		if ( $page > count( $pages ) ) {
			$page = count( $pages );
		} // give them the highest numbered page that DOES exist

		$content = $pages[ $page - 1 ];
		if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
			$content = explode( $matches[0], $content, 2 );
			$excerpt = $content[0];
		}

		return $excerpt;
	}

	function add_googleanalytics() {
		$code = get_theme_mod( 'canino_ganalytics' );
		if ( $code ) {
			echo '<script type="text/javascript">' . $code . '</script>';
		}
	}


	function add_ads() {
		$code = get_theme_mod( 'canino_ads' );
		if ( $code ) {
			echo $code;
		}
	}

	function rp4wp_my_thumbnail_size( $thumb_size ) {
		return 'blog-post-thumb';
	}

	/**
	 * @TODO Bad for performance. Try to hook into l10n module
	 *
	 * @param $safe_text
	 *
	 * @return string
	 */
	function rename_post_formats( $safe_text ) {
		if ( $safe_text == 'Aside' ) {
			return 'Artículo';
		} elseif ( $safe_text == 'Link' ) {
			return 'Noticia';
		}

		return $safe_text;
	}

	function live_rename_formats() {
		global $current_screen;

		if ( $current_screen->id == 'edit-post' ) { ?>
			<script type="text/javascript">
				jQuery('document').ready(function() {

					jQuery("span.post-state-format").each(function() {
						if ( jQuery(this).text() == "Aside" )
							jQuery(this).text("Artículo");
						else if ( jQuery(this).text() == "Link" )
							jQuery(this).text("Noticia");
					});

				});
			</script>
			<?php
		}
	}

	function maybe_upgrade() {
		global $wpdb;
		$saved_version = get_option( 'canino_theme_version' );
		if ( $saved_version === $this->version ) {
			return;
		}

		if ( version_compare( $saved_version, '1.0', '<' ) ) {
			$terms = array(
				get_term_by( 'slug', 'destacado', 'category' ),
				get_term_by( 'slug', 'destacado-pequeno', 'category' ),
			);

			foreach ( $terms as $term ) {
				if ( ! $term ) {
					continue;
				}

				$wpdb->update(
					$wpdb->term_taxonomy,
					array( 'taxonomy' => 'canino_destacado' ),
					array( 'term_id' => $term->term_id ),
					array( '%s' ),
					array( '%d' )
				);

				clean_term_cache( $term->term_id, 'category' );
				clean_term_cache( $term->term_id, 'canino_destacado' );
			}
		}

		update_option( 'canino_theme_version', $this->version );
	}

	function add_shortcode_button() {
		?>
		<a href="#" id="insert-canino-banner" class="button">Ad Banner</a>
		<script>
			jQuery( '#insert-canino-banner' ).click( function( e ) {
				e.preventDefault();
				wp.media.editor.insert('[canino-post-banner]');
			})
		</script>
		<?php
	}


}


function canino_theme() {
	return Canino_Theme::get_instance();
}

// Instantiate
canino_theme();



function canino_get_post_category( $post_id ) {
	global $canino_categories;
	// Cache hack
	$canino_categories = is_array( $canino_categories ) ? $canino_categories : array();
	if ( isset( $canino_categories[ $post_id ] ) ) {
		return $canino_categories[ $post_id ];
	}

	$categories = apply_filters( 'the_category_list', get_the_category( $post_id ), $post_id );
	if ( $categories ) {
		$category = $categories[0];
	} else {
		$category = new WP_Term( new stdClass() );
	}

	$canino_categories[ $post_id ] = $category;
	return $category;
}

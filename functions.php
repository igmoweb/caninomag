<?php

add_action( 'wp_enqueue_scripts', 'pressroom_child_enqueue_styles' );
function pressroom_child_enqueue_styles() {
    wp_enqueue_style( 'pressroom-style', get_template_directory_uri() . '/style.css', array(), '20161012'  );
    wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/style.css', array(), '20161017b'  );
	wp_enqueue_script( 'main-style', get_stylesheet_directory_uri() . '/js/main.js', array(),'20161012', true );
    //post_formats
}

/**
 * Theme initialization
 */
add_action( 'after_setup_theme', 'presroom_child_setup_theme', 11 );
function presroom_child_setup_theme() {
    load_child_theme_textdomain( 'pressroom', get_stylesheet_directory() . '/languages' );

	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'video' ) );

	// Sidebars
	register_sidebar( array(
		'name' => 'Barra Lateral',
		'id' => 'cabecera-arriba-del-to',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="box_header">',
		'after_title' => '</h4>'
	) );

	register_sidebar( array(
		'name' => 'Artículos Relacionados',
		'id' => 'cabecera',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="box_header">',
		'after_title' => '</h4>'
	) );

	register_sidebar( array(
		'name' => 'Pie de Página',
		'id' => 'blog',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="box_header">',
		'after_title' => '</h4>'
	) );

	// Image sizes
	add_image_size( 'post-grid-thumb-large', 787, 524, true );
	add_image_size( 'post-grid-thumb-big', 524, 524, true );
	add_image_size( 'post-grid-thumb-medium', 524, 261, true );
	add_image_size( 'blog-post-thumb', 330, 242, true );
	add_image_size( 'el-parte-widget', 100, 100, true );
}

add_action("admin_print_scripts-term.php", "pr_theme_admin_print_scripts_colorpicker");

add_action( 'admin_menu', 'canino_remove_pressroom_menus', 500 );
function canino_remove_pressroom_menus() {
	remove_submenu_page( 'themes.php', 'edit.php?post_type=pressroom_sidebars' );
}



function pressroom_child_change_article_excerpt( $excerpt ) {
	global $page, $pages;

	if ( $page > count( $pages ) ) // if the requested page doesn't exist
	{
		$page = count( $pages );
	} // give them the highest numbered page that DOES exist

	$content = $pages[ $page - 1 ];
	if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
		$content = explode( $matches[0], $content, 2 );
		$excerpt = $content[0];
	}

	return $excerpt;
}
add_filter( 'the_more_excerpt', 'pressroom_child_change_article_excerpt' );

function pressroom_child_add_googleanalytics() {
	$code = get_theme_mod( 'canino_ganalytics' );
	if ( $code ) {
		echo '<script type="text/javascript">' . $code . '</script>';
	}
}
add_action('wp_head', 'pressroom_child_add_googleanalytics' );

function pressroom_child_add_ads() {
	$code = get_theme_mod( 'canino_ads' );
	if ( $code ) {
		echo $code;
	}
}
add_action('wp_footer', 'pressroom_child_add_ads' );

// Remove wordpress character editor conversion
remove_filter('the_content', 'wptexturize');

/**
 * @TODO Mejorar:
 * - ¿ Para qué es el post meta título? Se puede sustituir por el post_title?
 * - Ojo que usa ACF
 *
 */
function ficha_shortcode( $atts ) {
	$titulo  = get_post_meta( get_the_ID(), 'titulo', true );
	$portada = get_field( 'portada' );
	$text1   = get_post_meta( get_the_ID(), 'texto-ficha', true );
	$text2   = get_post_meta( get_the_ID(), 'texto-ficha2', true );

	$meta = array(
		'cinedirector' => get_post_meta( get_the_ID(), 'cine-director', true ),
		'cineguion'    => get_post_meta( get_the_ID(), 'cine-guion', true ),
		'cineactores'  => get_post_meta( get_the_ID(), 'cine-actores', true ),
		'cineformato'  => get_post_meta( get_the_ID(), 'cine-formatos', true ),
		'comicg'       => get_post_meta( get_the_ID(), 'comic-guionista', true ),
		'comicd'       => get_post_meta( get_the_ID(), 'comic-dibujante', true ),
		'comice'       => get_post_meta( get_the_ID(), 'comic-editorial', true ),
		'musicaut'     => get_post_meta( get_the_ID(), 'musica-artista', true ),
		'musicalab'    => get_post_meta( get_the_ID(), 'musica-sello', true ),
		'gamestu'      => get_post_meta( get_the_ID(), 'game-estudio', true ),
		'gamedis'      => get_post_meta( get_the_ID(), 'game-distribuidora', true ),
		'gamepla'      => get_post_meta( get_the_ID(), 'game-plataformas', true ),
		'libroaut'     => get_post_meta( get_the_ID(), 'libro-autor', true ),
		'libroedi'     => get_post_meta( get_the_ID(), 'libro-editorial', true ),
		'year'         => get_post_meta( get_the_ID(), 'year', true ),
	);
	?>
	<div class="wpb_column vc_column_container vc_col-sm-4 ficha-tecnica">
		<h2><?php echo $titulo; ?></h2>

		<?php if ( ! empty( $portada ) ): ?>
			<img width="330" height="auto" src="<?php echo esc_url( $portada['url'] ); ?>" alt="<?php echo esc_attr( $portada['alt'] ); ?>"/>
		<?php endif; ?>

		<?php if ( ! empty( $text1 ) ): ?>
			<p><?php echo $text1; ?></p>
		<?php endif; ?>

		<ul>
			<?php foreach ( $meta as $key => $value ): ?>
				<?php if ( ! empty( $value ) ): ?>
					<li><?php echo $value; ?></li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>

		<?php if ( ! empty( $text2 ) ): ?>
			<p><?php echo $text2; ?></p>
		<?php endif; ?>
	</div>
	<?php
}
add_shortcode( 'page_header', 'ficha_shortcode' );


// Filtro de Posts Relacionados

function rp4wp_my_thumbnail_size( $thumb_size ) {
	return 'blog-post-thumb';
}
add_filter( 'rp4wp_thumbnail_size', 'rp4wp_my_thumbnail_size' );
add_filter( 'rp4wp_append_content', '__return_false' );


include_once( 'inc/customizer.php' );
include_once( 'inc/load-more.php' );
include_once( 'inc/helpers.php' );
include_once( 'inc/template-tags.php' );
include_once( 'inc/query.php' );

// Widgets
include_once( 'inc/widgets/el-parte.php' );

// COSAS PARA CAMBIAR EN EL FUTURO
/**
 * @TODO Sustituir ACF por código
 */
/* field groups*/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_critica',
		'title' => 'Critica - Ficha',
		'fields' => array (
			array (
				'key' => 'fieldficha1',
				'label' => 'Titulo',
				'name' => 'titulo',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_55ef4562c5ffd',
				'label' => 'Portada',
				'name' => 'portada',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'fieldficha3',
				'label' => 'texto-ficha',
				'name' => 'texto-ficha',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha4',
				'label' => 'texto-ficha2',
				'name' => 'texto-ficha2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha5',
				'label' => 'Año',
				'name' => 'year',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha6',
				'label' => 'cine-director',
				'name' => 'cine-director',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha7',
				'label' => 'cine-guion',
				'name' => 'cine-guion',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha8',
				'label' => 'cine-actores',
				'name' => 'cine-actores',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha9',
				'label' => 'cine-formatos',
				'name' => 'cine-formatos',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha10',
				'label' => 'comic-guionista',
				'name' => 'comic-guionista',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha11',
				'label' => 'comic-editorial',
				'name' => 'comic-editorial',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha12',
				'label' => 'comic-dibujante',
				'name' => 'comic-dibujante',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha13',
				'label' => 'musica-artista',
				'name' => 'musica-artista',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha14',
				'label' => 'musica-sello',
				'name' => 'musica-sello',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha15',
				'label' => 'game-estudio',
				'name' => 'game-estudio',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha16',
				'label' => 'game-distribuidora',
				'name' => 'game-distribuidora',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha17',
				'label' => 'game-plataformas',
				'name' => 'game-plataformas',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha18',
				'label' => 'libro-editorial',
				'name' => 'libro-editorial',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' =>  'fieldficha19',
				'label' => 'libro-autor',
				'name' => 'libro-autor',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			)
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

/**
 * @TODO Bad for performance. Try to hook into l10n module
 *
 * @param $safe_text
 *
 * @return string
 */
function rename_post_formats( $safe_text ) {
	if ( $safe_text == 'Aside' )
		return 'Artículo';
	elseif ( $safe_text == 'Link' )
		return 'Noticia';

	return $safe_text;
}
add_filter( 'esc_html', 'rename_post_formats' );

//rename Aside in posts list table
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
	<?php }
}
add_action('admin_head', 'live_rename_formats');



// HOOKS DE VISUAL COMPOSER (QUITAR?)

// Remove the default Thematic blogtitle function
function remove_thematic_actions() {
	remove_filter('vc_gitem_template_attribute_post_image_background_image_css','vc_gitem_template_attribute_post_image_background_image_css',10);
}
// Call 'remove_thematic_actions' (above) during WP initialization
add_action('vc_gitem_template_attribute_filter_terms_css_classes','remove_thematic_actions');

add_action('vc_gitem_template_attribute_post_image_background_image_css','custom_vc_gitem_template_attribute_post_image_background_image_css', 10,2);

function ficha_integrateWithVC() {
	vc_map( array(
			"name"     => __( "Ficha Critica", "my-text-domain" ),
			"base"     => "ficha_critica",
			"class"    => 'wpb_vc_wp_widget',
			"weight"   => - 50,
			"category" => __( "Content", "my-text-domain" )
		)
	);
}
add_action( 'vc_after_init', 'ficha_integrateWithVC' );


/**
Modificación en wp-content\plugins\js_composer\include\params\vc_grid_item\attributes.php
 */
function custom_vc_gitem_template_attribute_post_image_background_image_css( $value, $data ) {

	extract( array_merge( array(
		'post' => null,
		'data' => ''
	), $data ) );
	if ( 'attachment' === $post->post_type ) {
		$src = wp_get_attachment_image_src( $post->ID, 'large' );
	} else {
		if( class_exists('Dynamic_Featured_Image') ) {
			global $dynamic_featured_image;
			$featuredImages = $dynamic_featured_image->get_featured_images($post->ID);
			if ($featuredImages[0]['attachment_id']) {
				$attachment_id = $featuredImages[0]['attachment_id'];
			} else {
				$attachment_id = get_post_thumbnail_id($post->ID);
			}
		} else {
			$attachment_id = get_post_thumbnail_id($post->ID);
		}
		$src = wp_get_attachment_image_src( $attachment_id, 'large' );
	}
	if ( ! empty( $src ) ) {
		$output = 'background-image: url(' . $src[0] . ') !important;';
	} else {
		$output = 'background-image: url(' . vc_asset_url( 'vc/vc_gitem_image.png' ) . ') !important;';
	}

	return apply_filters( 'vc_gitem_template_attribute_post_image_background_image_css_value', $output );
}
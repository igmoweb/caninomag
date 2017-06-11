<?php
/**
 * @author: WPMUDEV, Ignacio Cruz (igmoweb)
 * @version:
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'canino-post-banner', function( $atts ) {
	ob_start();
	?>
	<script type="text/javascript">(function() {
            if ( document.readyState === 'complete' ) {
                return;
            }
            if ( typeof EbuzzingCurrentAsyncId === 'undefined' ) {
                window.EbuzzingCurrentAsyncId = 0;
            } else {
                EbuzzingCurrentAsyncId ++;
            }
            var containerId = 'buzzPlayer' + EbuzzingCurrentAsyncId;
            document.write( '<d' + 'iv id="' + containerId + '"></di' + 'v>' );
            var params = { "size": 15 };
            eval( 'window.EbuzzingScriptParams_' + containerId + ' = params;' );
            var s = document.createElement( 'script' );
            s.async = true;
            s.defer = true;
            s.src = 'http://as.ebz.io/api/inContent.htm?pid=1145364' + String.fromCharCode( 38 ) + 'target=' + containerId + '';
            var x = document.getElementsByTagName( 'script' )[ 0 ];
            x.parentNode.insertBefore( s, x );
        })();</script>
	<?php
	return ob_get_clean();
});

// Shortcode buttons for WP Editor
add_action( 'admin_head', function() {
//	add_filter( 'mce_external_plugins', 'canino_add_shortcode_tinymce_plugin' );
//	add_filter( 'mce_buttons', 'canino_register_shortcode_button' );
//	add_filter( 'mce_external_languages', 'canino_add_tinymce_i18n' );
} );

function canino_add_shortcode_tinymce_plugin( $plugins ) {
	$plugins['canino_shortcodes'] = get_stylesheet_directory_uri() . 'js/editor-shortcodes.js';
	return $plugins;
}

function canino_register_shortcode_button() {
	array_push( $buttons, '|', 'canino_shortcodes' );
	return $buttons;
}
//
//function canino_add_tinymce_i18n() {
//	$i18n['canino_shortcodes'] = get_stylesheet_directory_uri() . 'inc/tinymce-shortcodes-i18n.php';
//	return $i18n;
//}

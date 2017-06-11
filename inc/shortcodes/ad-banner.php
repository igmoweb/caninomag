<?php
/**
 * @author: WPMUDEV, Ignacio Cruz (igmoweb)
 * @version:
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'canino-ad-banner', function( $atts ) {
	$defaults = array(
		'size' => 'small'
	);


	$atts = wp_parse_args( $atts, $defaults );
	ob_start();
	canino_ad_banner( $atts['size'] );
	return ob_get_clean();
});
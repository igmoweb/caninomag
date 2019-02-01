<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Deregister Cookie Law Info scripts/styles
 */
add_action( 'wp_enqueue_scripts', 'canino_cookie_law_info_deregister_scripts', 100 );
function canino_cookie_law_info_deregister_scripts() {
	wp_dequeue_script( 'cookie-law-info-script' );

	// These are already included in app.css
	wp_dequeue_style( 'cookielawinfo-style' );
}

/**
 * Add Cookie Law Infoe scripts/styles inline
 */
add_action( 'wp_footer', 'canino_cookie_law_info_footer_scripts', 7 );
function canino_cookie_law_info_footer_scripts() {
	$contents = file_get_contents( get_stylesheet_directory() . '/plugins/cookie-law-info/js/cookielawinfo.js' );
	?>
	<script>
		<?php echo $contents; ?>
	</script>
	<?php
}

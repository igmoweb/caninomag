<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Deregister Cookie Law Info scripts/styles
 */
add_action( 'wp_enqueue_scripts', 'canino_srcomments_deregister_scripts', 100 );
function canino_srcomments_deregister_scripts() {
	wp_dequeue_script( 'srcmnt-ajax-request' );
}

/**
 * Add Cookie Law Infoe scripts/styles inline
 */
add_action( 'wp_footer', 'canino_srcomments_footer_scripts', 7 );
function canino_srcomments_footer_scripts() {
	// Use home_url() if domain mapped to avoid cross-domain issues
	if ( home_url() != site_url() )
		$ajaxurl = home_url( '/wp-admin/admin-ajax.php' );
	else
		$ajaxurl = admin_url( 'admin-ajax.php' );

	$ajaxurl = apply_filters( 'safe_report_comments_ajax_url', $ajaxurl );

	$contents = file_get_contents( get_stylesheet_directory() . '/plugins/safe-report-comments/js/ajax.js' );
	?>
	<script>
		SafeCommentsAjax = {
			ajaxurl:'<?php echo $ajaxurl; ?>'
		};
		<?php echo $contents; ?>
	</script>
	<?php
}


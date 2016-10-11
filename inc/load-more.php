<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Canino_Load_More {
	public function __construct() {
		add_action( 'wp_footer', array( $this, 'scripts' ) );
		add_action( 'wp_ajax_nopriv_canino_load_more', array( $this, 'load_more' ) );
		add_action( 'wp_ajax_canino_load_more', array( $this, 'load_more' ) );
	}

	public function scripts() {
		if ( is_front_page() ) {
			?>
			<script>
				jQuery( document ).ready( function( $ ) {
					var $loadMoreButton = $('.load-more-btn');
					var spinner = $loadMoreButton.find('.canino-spinner');
					var currentOffset;

					$loadMoreButton.click( function(e) {
						e.preventDefault();

						var $this = $(this);
						var container = $('#' + $this.data( 'container' ) );
						var type = $this.data( 'type' );
						var perPage = $this.data( 'per-page' );

						currentOffset = currentOffset || $this.data( 'offset' );

						var data = {
							action: 'canino_load_more',
							type: type,
							offset: currentOffset,
							nonce: '<?php echo wp_create_nonce( "canino-load-more"); ?>'
						};

						spinner.css( 'visibility', 'visible' );
						$.post( '<?php echo admin_url( "admin-ajax.php", "relative" ); ?>', data, function( response ) {
							if ( response.success ) {
								container.append( response.data.markup );
								currentOffset = currentOffset + perPage;
							}
							spinner.css( 'visibility', 'hidden' );
						});
					});
				});
			</script>
			<?php
		}
	}

	public function load_more() {
		check_ajax_referer( 'canino-load-more', 'nonce' );
		$offset = absint( $_POST['offset'] );
		$type = $_POST['type'];

		ob_start();
		if ( '2-cols' === $type ) {
			include get_stylesheet_directory() . '/parts/front-page/posts-2-cols.php';
			$markup = ob_get_clean();
		}
		else {
			include get_stylesheet_directory() . '/parts/front-page/posts-3-cols.php';
			$markup = ob_get_clean();
		}


		if ( $markup ) {
			wp_send_json_success( array( 'markup' => $markup ) );
		}
		wp_send_json_error();
	}
}

new Canino_Load_More();
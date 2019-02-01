<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Canino_Rich_Snippets' ) ) {
	class Canino_Rich_Snippets {
		public function __construct() {
			add_action( 'wp_head', array( $this, 'snippet' ) );
		}

		function snippet() {
			$data = false;
			if ( is_home() ) {
				$data = array(
					'@context'        => 'http://schema.org',
					'@type'           => 'WebSite',
					'url'             => home_url(),
					'name'            => get_bloginfo( 'name' ),
					'potentialAction' => array(
						'@type'  => 'SearchAction',
						'target' => add_query_arg( 's', '{query}', home_url() ),
					),
				);
			} elseif ( is_single() ) {
				$logo_id = get_theme_mod( 'custom_logo' );
				$logo    = wp_get_attachment_image_src( $logo_id, 'full' );
				if ( $logo ) {
					$url  = parse_url( $logo[0] );
					$logo = $url['scheme'] . '://' . $url['host'] . $url['path'];
				}

				$data = array(
					'@context'         => 'http://schema.org',
					'@type'            => 'Article',
					'author'           => array(
						'@type' => 'Thing',
						'name'  => get_the_author(),
					),
					'datePublished'    => get_the_date( 'Y-m-d H:i:s' ),
					'dateModified'     => get_the_modified_date( 'Y-m-d H:i:s' ),
					'url'              => get_permalink(), // Change to AMP
					'mainEntityOfPage' => get_permalink(),
					'headline'         => get_the_title(),
					'description'      => get_the_excerpt(),
					'articleBody'      => get_the_content(),
					'interactionCount' => 'UserComments:' . get_comments_number(),
					'publisher'        => array(
						'@type' => 'Organization',
						'url'   => home_url(),
						'name'  => get_bloginfo( 'name' ),
						'logo'  => array(
							'@type' => 'ImageObject',
							'url'   => $logo,
						),
					),
					'image'            => array(
						'@type'  => 'ImageObject',
						'url'    => get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' ),
						'width'  => get_option( 'thumbnail_size_w' ),
						'height' => get_option( 'thumbnail_size_h' ),
					),
				);

				$cat = canino_get_post_category( get_the_ID() );
				if ( $cat ) {
					$data['ArticleSection'] = $cat->name;
				}
			}

			if ( $data ) {
				$data = wp_json_encode( $data );
				?>
				<script type="application/ld+json">
					<?php echo $data; ?>
				</script>
				<?php
			}
		}

	}
}

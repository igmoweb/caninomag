<?php
/**
 * @author: WPMUDEV, Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Canino_Destacado' ) ) {
	class Canino_Destacado {
		public function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'register_meta_box' ) );
			add_action( 'save_post', array( $this, 'save' ) );
		}

		public function register_meta_box() {
			add_meta_box( 'canino-destacado', 'Destacado', array( $this, 'render' ), 'post', 'side', 'high' );
		}

		public function render( $post ) {
			$terms = get_terms( array( 'hide_empty' => false, 'taxonomy' => 'canino_destacado' ) );
			$object_destacados = wp_get_object_terms( $post->ID, array( 'canino_destacado' ) );
			$selected = '';
			if ( $object_destacados ) {
				$selected = $object_destacados[0]->term_id;
			}

			?>
			<label for="canino-destacado" class="screen-reader-text">Destacado</label>
			<select name="canino-destacado" id="canino-destacado">
				<option value="">Sin destacar</option>
				<?php foreach ( $terms as $term ): ?>
					<option <?php selected( $selected, $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
				<?php endforeach; ?>
			</select>
			<?php
		}

		public function save( $post_id ) {
			// Check if user has permissions to save data.
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			// Check if not an autosave.
			if ( wp_is_post_autosave( $post_id ) ) {
				return;
			}

			// Check if not a revision.
			if ( wp_is_post_revision( $post_id ) ) {
				return;
			}

			$selected = absint( $_REQUEST['canino-destacado'] );
			$term = get_term( $selected, 'canino_destacado' );
			if ( ! $term ) {
				wp_set_object_terms( $post_id, array(), 'canino_destacado' );
			}
			else {
				wp_set_object_terms( $post_id, array( $term->term_id ), 'canino_destacado' );
			}
		}
	}
}

new Canino_Destacado();

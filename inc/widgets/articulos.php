<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version:
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Canino_Widget_Articulos extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'articulos'
		);
		parent::__construct( 'canino-articulos', 'Listado de posts (Canino)', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->get_defaults() );

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];
		}

		$query_args = array(
			'posts_per_page' => $instance['posts_number'],
			'ignore_sticky_posts' => true,
		);

		if ( $instance['author_posts'] && is_author() ) {
			$query_args['author'] = get_the_author_meta( 'ID' );
		}

		switch ( $instance['type'] ) {
			case 'destacado': {
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => 'canino_destacado',
						'field' => 'slug',
						'terms' => array( 'destacado', 'destacado-pequeno' )
					),
				);
				break;
			}
			case 'post-format-link':
			case 'post-format-aside': {
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => array( $instance['type'] ),
						'operator' => 'IN'
					)
				);
				break;
			}
		}

		if ( is_single() && $id = get_the_ID() ) {
			$query_args['post__not_in'] = array( $id );
		}

		$query = new WP_Query( $query_args );

		?>
		<?php if ( $query->have_posts() ): ?>
			<ul class="articulos-list <?php echo $instance['format']; ?>">
				<?php while ( $query->have_posts() ): $query->the_post(); ?>
					<li>
						<article class="articulos-post">
							<?php if ( 'text' != $instance['format'] ): ?>
								<header class="articulos-header">
									<a class="articulos-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_post_thumbnail( 'articulos-widget-' . $instance['format'] ); ?>
									</a>
								</header>
							<?php endif; ?>
							<section class="articulos-content">
								<p class="articulos-category"><?php echo get_the_category_list( ', ' ); ?></p>
								<h5>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_title(); ?>
									</a>
								</h5>
								<p class="articulos-author">Por <?php the_author_link(); ?></p>
								<p class="articulos-date"><?php the_date(); ?></p>
							</section>
						</article>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php endif; ?>
		<?php

		wp_reset_postdata();

		echo $args['after_widget'];
	}

	private function get_defaults() {
		return array(
			'title' => '',
			'posts_number' => 3,
			'type' => 'post-format-link',
			'author_posts' =>  false,
			'format' => 'small'
		);
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->get_defaults() );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>"><?php echo 'Número de posts'; ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_number' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['posts_number'] ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php echo 'Tipo'; ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
				<option value="post-format-link" <?php selected( 'post-format-link', $instance['type'] ); ?>>El Parte (Formato de post: link)</option>
				<option value="post-format-aside" <?php selected( 'post-format-aside', $instance['type'] ); ?>>Últimos artículos (Formato de post: aside)</option>
				<option value="destacado" <?php selected( 'destacado', $instance['type'] ); ?>>Sólo destacados</option>
			</select>
		</p>
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'author_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'author_posts' ) ); ?>" type="checkbox" <?php checked( $instance['author_posts'] ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'author_posts' ) ); ?>"><?php echo 'Sólo posts del autor actual (aplica en páginas de autor)'; ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'format' ) ); ?>"><?php echo 'Formato'; ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'format' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'format' ) ); ?>">
				<option value="small" <?php selected( 'small', $instance['format'] ); ?>>Pequeño</option>
				<option value="big" <?php selected( 'big', $instance['format'] ); ?>>Grande</option>
				<option value="text" <?php selected( 'text', $instance['format'] ); ?>>Sólo texto</option>
			</select>
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['author_posts'] = ! empty( $new_instance['author_posts'] );
		$instance['posts_number'] = absint( $new_instance['posts_number'] );
		$instance['format'] = $new_instance['format'];
		$instance['type'] = $new_instance['type'];
		return $instance;
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'Canino_Widget_Articulos' );
});



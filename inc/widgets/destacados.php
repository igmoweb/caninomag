<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version:
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Canino_Widget_Destacados extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'destacados'
		);
		parent::__construct( 'destacados', 'Artículos destacados (Canino)', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];
		}

		$query = new WP_Query( array(
			'posts_per_page' => 3,
			'ignore_sticky_posts' => true,
			'tax_query' => array(
				array(
					'taxonomy' => 'canino_destacado',
					'field' => 'slug',
					'terms' => array( 'destacado', 'destacado-pequeno' )
				),
			)
		) );

		?>
		<?php if ( $query->have_posts() ): ?>
			<ul class="destacado-list">
				<?php while ( $query->have_posts() ): $query->the_post(); ?>
					<li <?php post_class( 'post' ); ?>>
						<article class="destacado-post">
							<header class="destacado-header">
								<a class="destacado-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail( 'destacado-widget' ); ?>
								</a>
							</header>
							<section class="destacado-content">
								<h5>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_title(); ?>
									</a>
								</h5>
							</section>
							<footer class="destacado-footer">
								<p class="destacado-category"><?php echo get_the_category_list( ', ' ); ?></p>
								<p class="destacado-author">Por <?php the_author_link(); ?></p>
							</footer>
						</article>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php endif; ?>
		<?php

		wp_reset_postdata();

		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : 'Artículos destacados';
		$category = ! empty( $instance['category'] ) ? $instance['category'] : 0;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
		return $instance;
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'Canino_Widget_Destacados' );
});



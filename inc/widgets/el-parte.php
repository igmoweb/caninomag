<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version:
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Canino_Widget_El_Parte extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'el-parte'
		);
		parent::__construct( 'el-parte', 'El Parte', $widget_ops );
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
			echo '<h3 class="box_header page_margin_top_section">' . apply_filters( 'widget_title', $instance['title'] ) . '</h3>';
		}

		$query = new WP_Query( array(
			'posts_per_page' => 10,
			'ignore_sticky_posts' => true,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => array( 'post-format-link' ),
					'operator' => 'IN'
				)
			)
		) );

		?>
		<div class="vc_row wpb_row vc_row-fluid">
			<?php if ( $query->have_posts() ): ?>
				<ul class="blog clearfix small">
					<?php while ( $query->have_posts() ): $query->the_post(); ?>
						<li <?php post_class( 'post' ); ?>>
							<a class="post_image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail( 'el-parte-widget' ); ?>
							</a>
							<div class="post_content">
								<h5 class="clearfix">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_title(); ?>
									</a>
								</h5>
								<ul class="post_details simple">
									<li class="date full_border"><?php the_date(); ?></li>
								</ul>
							</div>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
		</div>
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
		$title = ! empty( $instance['title'] ) ? $instance['title'] : 'El Parte';
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
	register_widget( 'Canino_Widget_El_Parte' );
});



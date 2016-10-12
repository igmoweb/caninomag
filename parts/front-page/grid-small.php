<?php
$query = new WP_Query( array(
	'cat' => 687,
	'posts_per_page' => 4,
	'page' => 1,
	'ignore_sticky_posts' => true
) );
?>


<?php if ( $query->have_posts() ): ?>
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<div class="post small">
			<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'thumbnail', array( 'style' => 'display: block;' ) ); ?>
			</a>
			<div class="slider_content_box">
				<h5>
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h5>
			</div>
		</div>
	<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php
$query = new WP_Query( array(
	'cat' => 73,
	'posts_per_page' => 2,
	'page' => 1,
	'ignore_sticky_posts' => true
) );
?>


<?php if ( $query->have_posts() ): ?>
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<div class="post medium">
			<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'post-grid-thumb-medium', array( 'style' => 'display: block;' ) ); ?>
			</a>
			<div class="slider_content_box">
				<h2>
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h2>
			</div>
		</div>
	<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
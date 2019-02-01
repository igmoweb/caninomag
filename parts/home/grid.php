<div id="canino-grid">
	<?php
	$query = new WP_Query( array(
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => canino_get_destacado_term_id(),
			),
		),
		'posts_per_page' => 2,
		'page' => 1,
		'ignore_sticky_posts' => true
	) );
	?>
	<?php if ( $query->have_posts() ): ?>
		<div id="canino-grid-top" class="canino-grid row">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<div class="canino-grid-item item column large-6 small-12">
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail( 'post-grid-thumb-medium' ); ?>
					</a>
					<div class="canino-grid-item-content">
						<h2>
							<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h2>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>

	<?php
	$query = new WP_Query( array(
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => canino_get_destacado_pequeno_term_id(),
			),
		),
		'posts_per_page' => 4,
		'page' => 1,
		'ignore_sticky_posts' => true
	) );
	?>
	<?php if ( $query->have_posts() ): ?>
		<div id="canino-grid-bottom" class="canino-grid row">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<div class="canino-grid-item column large-3 small-6">
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail( 'thumbnail', array( 'style' => 'display: block;' ) ); ?>
					</a>
					<div class="canino-grid-item-content">
						<h2>
							<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h2>
					</div>
				</div>

			<?php endwhile; ?>
		</div>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>

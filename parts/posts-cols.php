<div class="canino-cols row">
	<?php while ( $query->have_posts() ) :
		$query->the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-cols column small-12 large-' . $columns ); ?>>
			<header class="post-header">
				<hr class="small show-for-small hide-for-large">
				<ul class="post-details show-for-small hide-for-large">
					<?php get_template_part( 'parts/post-details' ); ?>
				</ul>
				<div class="post-image">
					<a class="post-image" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail( 'blog-post-thumb' ); ?>
					</a>
				</div>
				<h2 class="post-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<ul class="post-details show-for-large">
					<?php get_template_part( 'parts/post-details' ); ?>
				</ul>
			</header>
			<section class="post-content">
				<?php canino_the_excerpt(); ?>
			</section>
			<footer class="post-footer">
				<span class="post-author">Por <?php the_author_posts_link(); ?></span>
			</footer>
		</article>
	<?php endwhile; ?>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="post-header">
		<div class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></div>
	</header>
	<section class="post-content">
		<h2 class="post-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
	</section>
</article>
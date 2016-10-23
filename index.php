<?php get_header(); ?>
<div id="main-content" class="row">
	<div id="primary" class="column small-12 large-12">
		<?php while ( have_posts() ): the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="post-header">
					<h1 class="post-title"><?php the_title(); ?> </h1>
					<hr>
				</header>
				<section class="post-content">
					<?php the_content(); ?>
				</section>
				<footer class="post-footer">
				</footer>
			</article>
		<?php endwhile; ?>
	</div>
</div>
<?php get_footer(); ?>

<?php get_header(); ?>
<div class="row">
	<div class="column large-12">
		<h1 class="page_title"><?php echo canino_get_archive_title(); ?></h1>
		<hr>
	</div>
</div>
<div id="main-content" class="row">
	<div id="primary" class="column small-12 large-8">
		<div class="canino-cols row">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<?php get_template_part( 'parts/content', 'archive' ); ?>
			<?php endwhile; ?>
		</div>
		<?php get_template_part( 'parts/pagination' ); ?>
	</div>

	<div id="secondary" class="column small-12 large-4">
		<?php get_sidebar( 'cabecera-arriba-del-to' ); ?>
	</div>
</div>
<?php get_footer(); ?>

<?php if ( have_posts() ): ?>
	<?php $counter = 0; ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php if ( 0 === ( $counter % 3 ) ): ?>
			<div class="vc_row wpb_row vc_row-fluid">
		<?php endif; ?>

		<div class="vc_col-sm-4 wpb_column vc_column_container">
			<ul class="blog three_columns clearfix">
				<?php get_template_part( 'parts/content', 'posts-cols' ); ?>
			</ul>
		</div>

		<?php if ( 0 === ( ( $counter + 1 ) % 3 ) ): ?>
			</div>
		<?php endif; ?>

		<?php $counter++; ?>
	<?php endwhile; ?>
	</div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>


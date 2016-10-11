<?php
$offset = isset( $offset ) ? $offset : 0;
$query = canino_get_2_cols_query( $offset );
?>

<?php if ( $query->have_posts() ): ?>
	<?php $counter = 0; ?>
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<?php if ( 0 === ( $counter % 2 ) ): ?>
			<div class="vc_row wpb_row vc_row-fluid">
		<?php endif; ?>

		<div class="vc_col-sm-6 wpb_column vc_column_container">
			<ul class="blog two_columns clearfix">
				<?php get_template_part( 'parts/front-page/content', 'posts-cols' ); ?>
			</ul>
		</div>

		<?php if ( 0 === ( ( $counter + 1 ) % 2 ) ): ?>
			</div>
		<?php endif; ?>

		<?php $counter++; ?>
	<?php endwhile; ?>
<?php endif; ?>

<?php wp_reset_postdata(); ?>


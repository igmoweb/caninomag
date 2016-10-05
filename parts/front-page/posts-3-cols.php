<?php
$query = new WP_Query( array(
	'posts_per_page' => 18,
	'page' => 1,
	'offset' => 5,
	'ignore_sticky_posts' => true,
	'tax_query' => array(
		array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( 'post-format-aside' ),
			'operator' => 'IN'
		)
	)
) );
?>

<?php if ( $query->have_posts() ): ?>
	<?php $counter = 0; ?>
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<?php if ( 0 === ( $counter % 3 ) ): ?>
			<div class="vc_row wpb_row vc_row-fluid">
		<?php endif; ?>

		<div class="vc_col-sm-4 wpb_column vc_column_container">
			<ul class="blog three_columns clearfix">
				<?php get_template_part( 'parts/front-page/content', 'posts-cols' ); ?>
			</ul>
		</div>

		<?php if ( 0 === ( ( $counter + 1 ) % 3 ) ): ?>
			</div>
		<?php endif; ?>

		<?php $counter++; ?>
	<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>


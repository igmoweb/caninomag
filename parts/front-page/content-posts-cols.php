<?php
$categories = wp_get_object_terms( get_the_ID(), 'category' );
$cat_name = '';
$cat_id = '';
if ( $categories ) {
	$cat_name = $categories[0]->name;
	$cat_id = $categories[0]->term_id;
}
?>

<li <?php post_class( 'post' ); ?>>
	<a class="post_image"
	   href="<?php echo esc_url( get_permalink() ); ?>"
	   title="<?php the_title_attribute(); ?>">
		<?php the_post_thumbnail( array(
			330,
			242
		), array(
			'style' => 'display: block;'
		) ); ?>
	</a>
	<div class="post-content">
		<h2 class="clearfix">
			<a
				href="<?php echo esc_url( get_permalink() ); ?>"
				title="<?php the_title_attribute(); ?>"><?php the_title(); ?>
			</a>
		</h2>
		<ul class="post_details simple">
			<li class="category container-category-<?php echo $cat_id; ?>">
				<a class="category-<?php echo $cat_id; ?>"
				   href="<?php echo get_category_link( $cat_id ); ?>"
				   title="Ver todas las entradas en la categoría <?php echo $cat_name; ?>"><?php echo $cat_name; ?></a>
			</li>
			<li class="date"><?php the_time( get_option( 'date_format' ) ); ?></li>
		</ul>
		<div class="post-excerpt">
			<?php the_excerpt(); ?>
		</div>

		<div class="author_row">
			<span class="author_by">Por </span>
			<?php the_author_posts_link(); ?>
		</div>
	</div>
</li>
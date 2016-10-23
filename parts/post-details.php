<?php if ( $category = canino_get_post_category( get_the_ID() ) ): ?>
	<li class="post-category">
		<a class="category-<?php echo $category->term_id; ?>"
		   href="<?php echo get_category_link( $category->term_id ); ?>"
		   title="Ver todas las entradas en la categoría <?php echo $category->name; ?>">
			<?php echo $category->name; ?>
		</a>
	</li>
<?php endif; ?>
<li class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></li>
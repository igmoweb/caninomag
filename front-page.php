<?php get_header(); ?>

<?php get_template_part( 'parts/home/grid' ); ?>

<div id="main-content" class="row">

	<div id="primary" class="<?php canino_primary_class(); ?>">

		<?php if ( is_active_sidebar( 'home-top-bar' ) ) : ?>
			<div id="home-top-bar" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'home-top-bar' ); ?>
			</div><!-- .widget-area -->
			<hr>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'home-top-bar' ) ) : ?>
			<div id="home-top-bar" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'home-top-bar' ); ?>
			</div><!-- .widget-area -->
			<hr>
		<?php endif; ?>

		<div id="canino-home-2-cols">
			<?php
				$query   = canino_get_2_cols_home_query();
				$columns = 6;
				require locate_template( 'parts/posts-cols.php' );
				wp_reset_postdata();
			?>
		</div>
		<div class="row hide-for-large">
			<button data-container="canino-home-2-cols" data-offset="6" data-per-page="6" data-type="2-cols" class="large-12 column button callout load-more-btn">
				Ver más artículos
				<span class="canino-spinner"></span>
			</button>
		</div>
	</div>
	<div id="secondary" class="<?php canino_secondary_class(); ?>">
		<?php get_sidebar( 'cabecera-arriba-del-to' ); ?>
	</div>
</div>
<div id="submain-content" class="show-for-large">
	<div id="canino-home-3-cols">
		<?php
			$query   = canino_get_3_cols_home_query();
			$columns = 4;
			require locate_template( 'parts/posts-cols.php' );
			wp_reset_postdata();
		?>
	</div>
	<div class="row">
		<button data-container="canino-home-3-cols" data-offset="18" data-per-page="12" data-type="3-cols" class="large-12 column button callout load-more-btn">
			Ver más artículos
			<span class="canino-spinner"></span>
		</button>
	</div>
</div>
<?php get_footer(); ?>

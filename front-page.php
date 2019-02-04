<?php get_header(); ?>

<?php get_template_part( 'parts/home/grid' ); ?>

<div id="main-content" class="row">

	<div id="primary" class="<?php canino_primary_class(); ?>">

		<h2 class="canino-section-title"><a href="<?php echo esc_url( get_category_link( canino_get_el_parte_term_id() ) ); ?>">El Parte</a></h2>
		<?php
			$query = canino_get_el_parte_home_query();
			require_once locate_template( 'parts/home/el-parte.php' );
			wp_reset_postdata();
		?>

		<div class="show-for-large">
			<h2 class="canino-section-title">Publicidad</h2>
			<div class="canino-publi row">
				<div class="column large-12">
					<?php canino_ad_banner(); ?>
				</div>
			</div>
			<hr>
		</div>

		<div class="show-for-medium-only">
			<h2 class="canino-section-title">Publicidad</h2>
			<div class="canino-publi row align-center">
				<div class="column medium-5">
					<?php canino_ad_banner( 'small' ); ?>
				</div>
			</div>
		</div>

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

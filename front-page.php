<?php get_header(); ?>

<?php get_template_part( 'parts/home/grid' ); ?>

<div id="main-content" class="row">

	<div id="primary" class="<?php canino_primary_class(); ?>">

		<h2 class="canino-section-title"><a href="<?php echo esc_url( get_category_link( 30 ) ); ?>">El Parte</a></h2>
		<?php
			$query = canino_get_el_parte_home_query();
			include_once( locate_template( 'parts/home/el-parte.php' ) );
			wp_reset_postdata();
		?>

		<div class="show-for-large">
			<h2 class="canino-section-title"><a href="<?php echo esc_url( get_category_link( 30 ) ); ?>">Publicidad</a></h2>
			<div class="canino-publi row">
				<div class="column large-12">
					<?php canino_ad_banner(); ?>
				</div>
			</div>
			<hr>
		</div>

		<div class="show-for-medium-only">
			<h2 class="canino-section-title"><a href="<?php echo esc_url( get_category_link( 30 ) ); ?>">Publicidad</a></h2>
			<div class="canino-publi row align-center">
				<div class="column medium-5">
					<?php canino_ad_banner( 'small' ); ?>
				</div>
			</div>
		</div>

		<div id="canino-home-2-cols">
			<?php
				$query = canino_get_2_cols_home_query();
				$columns = 6;
				include( locate_template( 'parts/posts-cols.php' ) );
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
			$query = canino_get_3_cols_home_query();
			$columns = 4;
			include( locate_template( 'parts/posts-cols.php' ) );
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
	<script>
		'use strict';
		// Make big grid images same height
		window.onload = function() {

			function matchHeights( images, min ) {
				var sizes = [],
					i,
					minSize;

				for ( i = 0; i < images.length; i++ ) {
					sizes.push( images[i].height );
				}

				minSize = Math.min.apply( null, sizes );
				if ( ! minSize ) {
					return;
				}

				if ( minSize < min ) {
					minSize = min;
				}
				for ( i = 0; i < images.length; i++ ) {
					images[i].style.height = minSize + 'px';
				}
			}


			function resizeGrid() {
				var bigMin, smallMin;
				if ( 'small' == Foundation.MediaQuery.current ) {
					smallMin = 150;
					bigMin = 250;
				}
				else {
					smallMin = 300;
					bigMin = 261;
				}

				if ( 'medium' != Foundation.MediaQuery.current && 'small' != Foundation.MediaQuery.current ) {
					// Big grid (only in large devices)
					matchHeights( document.querySelectorAll( '#canino-grid-top > div img' ), bigMin );
				}

				// Small Grid
				matchHeights( document.querySelectorAll( '#canino-grid-bottom > div img' ), smallMin );
			}

			resizeGrid();

			window.onresize = resizeGrid;

		};
	</script>
<?php get_footer(); ?>
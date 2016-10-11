<?php get_header(); ?>
	<div class="theme_page relative">
		<div class="clearfix">
			<div id="portada-grid" class="vc_row wpb_row vc_row-fluid grid-portada blog_grid">
				<div class="canino-home-grid-top wpb_column vc_column_container vc_col-sm-12">
					<div class="wpb_wrapper">

						<?php get_template_part( 'parts/front-page/grid' ); ?>

						<div class="wpb_raw_code wpb_content_element wpb_raw_html">
							<div class="wpb_wrapper">
								<div class="clearfix"></div>
							</div>
						</div>

						<?php get_template_part( 'parts/front-page/grid-small' ); ?>

						<div class="wpb_raw_code wpb_content_element wpb_raw_html">
							<div class="wpb_wrapper">
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="portada-main">
				<div id="portada-main-upper" class="vc_row wpb_row vc_row-fluid">
					<div id="portada-main-sidebar" class="wpb_column vc_column_container vc_col-sm-4">
						<?php get_sidebar( 'cabecera-arriba-del-to' ); ?>
					</div>
					<div id="portada-main-upper-inner" class="wpb_column vc_column_container vc_col-sm-8">

						<div id="portada-el-parte" class="vc_row wpb_row vc_row-fluid">
							<div class="canino-elparte-home wpb_column vc_column_container vc_col-sm-12">
								<?php get_template_part( 'parts/front-page/el-parte' ); ?>
							</div>
						</div>

						<div id="portada-publi" class="canino-home-publi vc_row wpb_row vc_row-fluid vc_hidden-xs">
							<div class="wpb_column vc_column_container vc_col-sm-12">
								<div class="wpb_wrapper">
									<div class="wpb_text_column wpb_content_element  vc_custom_1439651872428">
										<h4 class="box_header">
											<a href="<?php echo esc_url( get_category_link( 30 ) ); ?>">Publicidad</a>
										</h4>
										<!-- Central_horizontal_Home -->
										<ins class="adsbygoogle"
										     style="display:inline-block;width:728px;height:90px"
										     data-ad-client="ca-pub-8311800129241191"
										     data-ad-slot="1748594590"></ins>
										<script>
											(adsbygoogle = window.adsbygoogle || []).push({});
										</script>
									</div>
								</div>
							</div>
						</div>

						<div class="vc_row wpb_row vc_row-fluid">
							<div class="wpb_column vc_column_container vc_col-sm-12">
								<hr class="divider page_margin_top">
							</div>
						</div>

						<div id="portada-main-2-cols">
							<?php get_template_part( 'parts/front-page/posts-2-cols' ); ?>
						</div>

						<div id="portada-load-more-2-cols" class="vc_row wpb_row vc_row-fluid">
							<div class="wpb_column vc_column_container vc_col-sm-12">
								<button id="load-more-2-cols" data-type="2-cols" data-container="portada-main-2-cols" data-offset="6" data-per-page="6" class="load-more-btn alm-load-more-btn more">Ver más artículos <span class="canino-spinner"></span></button>
							</div>
						</div>

					</div>

				</div>

				<div id="portada-main-3-cols" class="vc_row wpb_row vc_row-fluid">
					<div id="canino-posts-3-cols" class="wpb_column vc_column_container vc_col-sm-12">
						<?php get_template_part( 'parts/front-page/posts-3-cols' ); ?>
					</div>
				</div>


				<div id="portada-load-more" class="vc_row wpb_row vc_row-fluid">
					<div class="wpb_column vc_column_container vc_col-sm-12">
						<button id="load-more" data-container="canino-posts-3-cols" data-offset="23" data-per-page="18" data-type="3-cols" class="load-more-btn alm-load-more-btn more">Ver más artículos <span class="canino-spinner"></span></button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
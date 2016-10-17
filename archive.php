<?php get_header(); ?>
	<div class="theme_page relative">
		<div class="page_header vc_row wpb_row vc_row-fluid clearfix page_margin_top">
			<div class="page_header_left">
				<h1 class="page_title"><?php echo canino_get_archive_title();?></h1>
			</div>
			<div class="page_header_right">
				<?php get_template_part( 'archives/breadcrumbs' ); ?>
			</div>
		</div>
		<div class="clearfix">
			<div class="vc_row wpb_row vc_row-fluid">
				<div class="divider_block clearfix page_margin_top_section"><hr class="divider first"><hr class="divider subheader_arrow"><hr class="divider last"></div>
				<div class="wpb_column vc_column_container vc_col-sm-8">
					<div class="wpb_wrapper">
						<div>
							<?php get_template_part( 'parts/archives/posts-2-cols' ); ?>
						</div>
						<div class="pagination_container clearfix theme_blog_3_columns_pagination page_margin_top">
							<?php get_template_part( 'parts/archives/pagination' ); ?>
						</div>
					</div>
				</div>
				<div class="wpb_column vc_column_container vc_col-sm-4">
					<?php get_sidebar( 'cabecera-arriba-del-to' ); ?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
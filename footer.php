	<div class="footer_container">
		<div class="footer clearfix">
			<div class="vc_row wpb_row vc_row-fluid ">
				<?php if ( is_active_sidebar( 'blog' ) ): ?>
					<?php dynamic_sidebar( 'blog' ); ?>
				<?php endif; ?>
			</div>
			<div class="vc_row wpb_row vc_row-fluid page_margin_top_section">
			</div>
		</div>
	</div>
</div>
<div class="background_overlay"></div>
<?php wp_footer(); ?>
</body>
</html>
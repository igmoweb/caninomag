	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ( is_active_sidebar( 'blog' ) ) : ?>
			<div class="widget-area row" role="complementary">
				<?php dynamic_sidebar( 'blog' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>
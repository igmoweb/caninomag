<?php
$title = canino_get_archive_title();
if ( is_search() ) {
	$title = __( "Results for phrase:", 'pressroom' ) . ' ' . get_search_query();
}
?>
<ul class="bread_crumb">
	<li>
		<a href="<?php echo get_home_url(); ?>" title="<?php esc_attr_e('Home', 'pressroom'); ?>">
			<?php _e('Home', 'pressroom'); ?>
		</a>
	</li>
	<li class="separator icon_small_arrow right_gray"> &nbsp; </li>
	<li><?php echo $title;?></li>
</ul>
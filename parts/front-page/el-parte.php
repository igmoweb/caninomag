<?php
$query = new WP_Query( array(
	'showposts' => 10,
	'cat' => 30,
	'ignore_sticky_posts' => true
));

$counter = 0;
?>
<div class="wpb_wrapper" id="el-parte">
	<div class="wpb_text_column wpb_content_element  vc_custom_1439651872428">
		<h3 class="box_header">
			<a href="<?php echo esc_url( get_category_link( 30 ) ); ?>">El parte</a>
		</h3>
	</div>
	<div class="vc_row wpb_row vc_inner vc_row-fluid">
		<div class="wpb_column vc_column_container vc_col-sm-6 vc_col-sm-12 el-parte-left">
			<div class="vc_column-inner ">
				<div class="wpb_wrapper">
					<div class="wpb_widgetised_column wpb_content_element clearfix">
						<div class="wpb_wrapper">
								<ul>
									<?php while ( $query->have_posts() && $counter < 5 ): $query->the_post(); ?>
										<?php $counter ++; ?>
										<li>
											<p class="post-date "><?php the_time( get_option( 'date_format' ) ); ?></p>
											<a class="post-title "
											   href="<?php echo esc_url( get_permalink() ); ?>"
											   rel="bookmark"><?php the_title(); ?>
											</a>
										</li>
									<?php endwhile; ?>
									<?php wp_reset_postdata(); ?>
								</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="wpb_column vc_column_container vc_col-sm-6 vc_hidden-xs">
			<div class="vc_column-inner el-parte-right">
				<div class="wpb_wrapper">
					<div class="wpb_widgetised_column wpb_content_element clearfix">
						<div class="wpb_wrapper">
							<ul>
								<?php while ( $query->have_posts() ): $query->the_post() ?>
									<li>
										<p class="post-date "><?php the_time( get_option( 'date_format' ) ); ?></p>
										<a class="post-title "
										   href="<?php echo esc_url( get_permalink() ); ?>"
										   rel="bookmark"><?php the_title(); ?>
										</a>
									</li>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
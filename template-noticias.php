<?php 

/*

Template Name: Noticias

*/

get_header();

?>

<div class="theme_page relative">

	<div class="page_header vc_row wpb_row vc_row-fluid clearfix page_margin_top">

		<div class="page_header_left">

			<?php

			if(is_archive())

			{

				if(is_day())

					$archive_header = __("Daily archives: ", 'pressroom') . get_the_date(); 

				else if(is_month())

					$archive_header = __("Monthly archives: ", 'pressroom') . get_the_date('F, Y');

				else if(is_year())

					$archive_header = __("Yearly archives: ", 'pressroom') . get_the_date('Y');

				else if(is_tag())

					$archive_header = single_tag_title("", false);

				else

					$archive_header = "Archives";

			}

			?>

			<h1 class="page_title"><?php echo (is_category() || is_archive() ? (is_category() ? single_cat_title("", false) : $archive_header) : get_the_title());?></h1>

		</div>

		<div class="page_header_right">

			<ul class="bread_crumb">

				<li>

					<a href="<?php echo get_home_url(); ?>" title="<?php esc_attr_e('Home', 'pressroom'); ?>">

						<?php _e('Home', 'pressroom'); ?>

					</a>

				</li>

				<li class="separator icon_small_arrow right_gray">

					&nbsp;

				</li>

				<li>

					<?php echo (is_category() || is_archive() ? (is_category() ? single_cat_title("", false) : $archive_header) : get_the_title());?>

				</li>

			</ul>

		</div>

	</div>

	<div class="clearfix">

		<?php

		if(is_category() || is_archive())

		{

			/*get page with blog template set*/

			$post_template_page_array = get_pages(array(

				'post_type' => 'page',

				'post_status' => 'publish',

				//'number' => 1,

				'meta_key' => '_wp_page_template',

				'meta_value' => 'template-noticias.php',

				'sort_order' => 'ASC',

				'sort_column' => 'menu_order',

			));

			if(count($post_template_page_array))

			{

				$post_template_page = $post_template_page_array[0];

				if(count($post_template_page_array) && isset($post_template_page))

				{

					echo wpb_js_remove_wpautop(apply_filters('the_content', $post_template_page->post_content));

					global $post;

					$post = $post_template_page;

					setup_postdata($post);

				}

				else

					echo wpb_js_remove_wpautop(apply_filters('the_content', '[vc_row][vc_column width="1/1"][vc_separator_pr style="gap" top_margin="none"][/vc_column][/vc_row][vc_row top_margin="none"][vc_column width="2/3"][blog_2_columns pr_pagination="1" items_per_page="6" featured_image_size="default" ids="-" category="-" author="-" order_by="date" order="DESC" featured_post="-" show_post_title="1" show_post_excerpt="1" read_more="1" read_more_featured="1" show_post_categories="1" show_post_author="0" show_post_date="1" post_details_layout="default" show_post_comments_box="1" show_more_page="-" show_more_label="READ MORE" top_margin="none"][/vc_column][vc_column width="1/3"][vc_tabs top_margin="page_margin_top" el_class="no_scroll"][vc_tab title="Most Read" tab_id="sidebar-most-read"][pr_rank_list type="views" items_per_page="4" ids="-" category="-" featured_image_size="default" show_post_categories="1" show_post_date="1" top_margin="page_margin_top"][read_more_button title="SHOW MORE" url="blog" top_margin="page_margin_top"][/vc_tab][vc_tab title="Commented" tab_id="sidebar-most-commented"][pr_rank_list type="comment_count" items_per_page="4" ids="-" category="-" featured_image_size="default" show_post_categories="1" show_post_date="1" top_margin="page_margin_top"][read_more_button title="SHOW MORE" url="blog" top_margin="page_margin_top"][/vc_tab][/vc_tabs][box_header title="Latest Posts" type="h4" bottom_border="1" top_margin="page_margin_top_section"][pr_post_carousel type="vertical" kind="default" items_per_page="4" ids="-" category="-" post_format="-" order_by="date,title" order="DESC" visible="3" post_details_layout="simple" count_number="0" show_comments_box="0" show_post_excerpt="0" read_more="0" featured_image_size="default" autoplay="0" pause_on_hover="1" scroll="1" effect="scroll" easing="swing" duration="500" top_margin="none"][box_header title="Top Authors" type="h4" bottom_border="1" top_margin="page_margin_top_section"][pr_top_authors ids="-" items_per_page="4" top_margin="page_margin_top"][/vc_column][/vc_row]'));

			}

			else

			{

				if(function_exists("wpb_map"))

					echo wpb_js_remove_wpautop(apply_filters('the_content', '[vc_row][vc_column width="1/1"][vc_separator_pr style="gap" top_margin="none"][/vc_column][/vc_row][vc_row top_margin="none"][vc_column width="2/3"][blog_2_columns pr_pagination="1" items_per_page="6" featured_image_size="default" ids="-" category="-" author="-" order_by="date" order="DESC" featured_post="-" show_post_title="1" show_post_excerpt="1" read_more="1" read_more_featured="1" show_post_categories="1" show_post_author="0" show_post_date="1" post_details_layout="default" show_post_comments_box="1" show_more_page="-" show_more_label="READ MORE" top_margin="none"][/vc_column][vc_column width="1/3"][vc_tabs top_margin="page_margin_top" el_class="no_scroll"][vc_tab title="Most Read" tab_id="sidebar-most-read"][pr_rank_list type="views" items_per_page="4" ids="-" category="-" featured_image_size="default" show_post_categories="1" show_post_date="1" top_margin="page_margin_top"][read_more_button title="SHOW MORE" url="blog" top_margin="page_margin_top"][/vc_tab][vc_tab title="Commented" tab_id="sidebar-most-commented"][pr_rank_list type="comment_count" items_per_page="4" ids="-" category="-" featured_image_size="default" show_post_categories="1" show_post_date="1" top_margin="page_margin_top"][read_more_button title="SHOW MORE" url="blog" top_margin="page_margin_top"][/vc_tab][/vc_tabs][box_header title="Latest Posts" type="h4" bottom_border="1" top_margin="page_margin_top_section"][pr_post_carousel type="vertical" kind="default" items_per_page="4" ids="-" category="-" post_format="-" order_by="date,title" order="DESC" visible="3" post_details_layout="simple" count_number="0" show_comments_box="0" show_post_excerpt="0" read_more="0" featured_image_size="default" autoplay="0" pause_on_hover="1" scroll="1" effect="scroll" easing="swing" duration="500" top_margin="none"][box_header title="Top Authors" type="h4" bottom_border="1" top_margin="page_margin_top_section"][pr_top_authors ids="-" items_per_page="4" top_margin="page_margin_top"][/vc_column][/vc_row]'));

			}

		}

		else

		{

			if(have_posts()) : while (have_posts()) : the_post();

				the_content();

			endwhile; endif;

		}

		?>

	</div>

</div>

<?php

get_footer(); 

?>
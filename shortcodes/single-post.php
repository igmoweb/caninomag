<?php
//post
function pr_theme_single_post($atts, $content)
{
	global $themename;
	global $theme_options;
	extract(shortcode_atts(array(
		"featured_image_size" => "default",
		"show_post_title" => 1,
		"show_post_featured_image" => 1,
		"show_post_excerpt" => 1,
		"show_post_categories" => 1,
		"show_post_date" => 1,
		"show_post_author" => 1,
		"show_post_views" => 1,
		"show_post_comments" => 1,
		"show_post_author_box" => 1,
		"show_share_box" => 1,
		"show_post_tags_footer" => 1,
		"show_post_categories_footer" => 1,
		"icons_count" => 1
	), $atts));
	
	$featured_image_size = str_replace("pr_", "", $featured_image_size);
	
	global $post;
	setup_postdata($post);
	
	$output = "";
	$post_format = get_post_format();
	$post_classes = get_post_class("post");
	$output .= '<div class="single ';
	if($post_format=="image")
		$output .= 'small_image ';
	foreach($post_classes as $key=>$post_class)
		$output .= ($key>0 ? ' ' : '') . $post_class;
	$output .= '">';
	if($show_post_title) 
		$output .= '<h1 class="post_title"><a href="' . get_permalink() . '" title="' . esc_attr(get_the_title()) . '">' . get_the_title() . '</a></h1>';
	if((int)$show_post_categories || (int)$show_post_date || (int)$show_post_author || (int)$show_post_views || (int)$show_post_comments)
	{
		$output .= '<ul class="post_details clearfix">';
		if((int)$show_post_categories)
		{
			$categories = get_the_category();
			$output .= '<li class="detail category">' . __("In ", "pressroom");
			foreach($categories as $key=>$category)
			{
				$output .= '<a href="' . get_category_link($category->term_id ) . '" ';
				if(empty($category->description))
					$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $category->name) . '"';
				else
					$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
				$output .= '>' . $category->name . '</a>' . ($category != end($categories) ? ', ' : '');
			}
			$output .= '</li>';
		}
		if((int)$show_post_date)
			$output .= '<li class="detail date">' . date_i18n(get_option('date_format'), strtotime($post->post_date))/* . ' ' . get_the_time(get_option('time_format'))*/ . '</li>';
		if((int)$show_post_author)
			$output .= '<li class="detail author"><a class="author" href="' . get_author_posts_url(get_the_author_meta('ID')) . '" title="' . esc_attr(get_the_author()) . '">' . get_the_author() . '</a>';
		if((int)$show_post_comments)
		{	
			$comments_count = get_comments_number();
			$output .= '<li class="detail comments scroll_to_comments"><a href="' . get_comments_link() . '" title="' . esc_attr($comments_count . ' ' . ($comments_count==1 ? __('comment', 'pressroom') : __('comments', 'pressroom'))) . '">' . $comments_count . ' ' . ($comments_count==1 ? __('comment', 'pressroom') : __('comments', 'pressroom')) . '</a></li>';
		}
		$output .= '</ul>';
	}
	$is_review = get_post_meta($post->ID, $themename. "_is_review", true);
	if($post_format=="quote")
	{
		$quote_text = get_post_meta($post->ID, $themename. "_quote_text", true);
		$quote_author = get_post_meta($post->ID, $themename. "_quote_author", true);
	}
	if($post_format=="image")
	{
		$output .= '<div class="post_content page_margin_top_section clearfix"><div class="content_box' . (!(int)$show_post_author_box ? ' full_width' : '') . '">';
		$output .= '<div class="post_image_box">';
	}
	if($post_format=="video" && get_post_meta($post->ID, $themename. "_video_url", true)!="")
	{
		$output .= '<iframe class="iframe_video page_margin_top" src="' . esc_url(get_post_meta($post->ID, $themename. "_video_url", true)) . '" allowfullscreen></iframe>';
	}
	else if($post_format=="audio" && get_post_meta($post->ID, $themename. "_audio_url", true)!="")
	{
		$output .= '<iframe class="iframe_sound page_margin_top" src="' . esc_url(get_post_meta($post->ID, $themename. "_audio_url", true)) . '"></iframe>';
	}
	else if($post_format=="gallery")
	{
		$attachment_ids = get_post_meta($post->ID, $themename. "_attachment_ids", true);
		$images = get_post_meta($post->ID, $themename. "_images", true);
		$images_titles = get_post_meta($post->ID, $themename. "_images_titles", true);
		$images_descriptions = get_post_meta($post->ID, $themename. "_images_descriptions", true);
		$videos = get_post_meta($post->ID, $themename. "_videos", true);
		$iframes = get_post_meta($post->ID, $themename. "_iframes", true);
		$output .= '<div class="horizontal_carousel_container thin page_margin_top gallery_control">
						<ul class="horizontal_carousel control-for-post-gallery visible-5 autoplay-0 scroll-1 navigation-1 easing-easeInOutQuint duration-750">';
		$gallery_control = "";
		$gallery_carousel = "";
		for($i=0; $i<count($images); $i++)
		{
			$gallery_control .= '<li><a href="#">' . wp_get_attachment_image($attachment_ids[$i], $themename . "-gallery-thumb-type-3") . '</a></li>';
			$gallery_carousel .= '<li>
				<a href="' . esc_url($images[$i]) . '" data-rel="gallery" title="' . esc_attr($images_titles[$i]) . '">
					<span class="icon fullscreen animated"></span>
					' . wp_get_attachment_image($attachment_ids[$i], "small-slider-thumb") . '
				</a>
			</li>';
		}
		$output .= $gallery_control . '</ul></div>
		<div id="control-by-post-gallery" class="horizontal_carousel_container big margin_top_10">
			<ul id="post-gallery" class="horizontal_carousel visible-1 autoplay-0 scroll-1 navigation-1 easing-easeInOutQuint duration-750">';
		$output .= $gallery_carousel;
		$output .= '</ul></div>';
		
		$output .= '<div id="gallery-popup" class="gallery_popup">
			<div class="header_container padding_top_bottom_15">
				<div class="header clearfix">';
					if($theme_options["logo_text"]!="")
						$output .= '<h1><a title="' . esc_attr($theme_options["logo_text"]) . '" href="' . get_home_url() . '">' . $theme_options["logo_text"] . '</a></h1>';
		$output .= '<a href="#" class="gallery_close close_popup"></a>
				</div>
			</div>
			<div class="header_container">
				<div class="horizontal_carousel_container thin gallery_control">
					<ul class="horizontal_carousel control-for-post-gallery-popup visible-8 autoplay-0 scroll-1 navigation-1 easing-easeInOutQuint duration-750">
						' . $gallery_control . '
					</ul>
				</div>
			</div>
			<div class="theme_page">
				<div class="vc_row wpb_row vc_row-fluid page_margin_top">
					<div id="control-by-post-gallery-popup" class="horizontal_carousel_container big margin_top_10">
						<ul id="post-gallery-popup" class="horizontal_carousel visible-1 autoplay-0 scroll-1 navigation-0 easing-easeInOutQuint duration-750">';
		$icon_type = array_values(array_filter((array)get_post_meta($post->ID, "social_icon_type", true)));
		$icon_url = array_values(array_filter((array)get_post_meta($post->ID, "social_icon_url", true)));
		$icon_target = array_values(array_filter((array)get_post_meta($post->ID, "social_icon_target", true)));
		
		$icons_html = "";
		if(count($icon_type))
		{
			$icons_html = '<div class="share_box page_margin_top_section clearfix">
								<label>' . __("Share", 'pressroom') . ':</label>
								<ul class="social_icons dark clearfix">';
			for($i=0; $i<count($icon_type); $i++)
			{
				$large_image_url = "";
				if(has_post_thumbnail() && (int)$show_post_featured_image)
				{
					$thumb_id = get_post_thumbnail_id(get_the_ID());
					$attachment_image = wp_get_attachment_image_src($thumb_id, "large");
					$large_image_url = $attachment_image[0];
				}
				$icons_html .= '<li><a' . ($icon_target[$i]=="new_window" ? ' target="_blank"' : '') . ' title="" href="' . esc_url(str_replace("{MEDIA_URL}", $large_image_url, str_replace("{TITLE}", urlencode(get_the_title()), str_replace("{URL}", get_permalink(), $icon_url[$i])))) . '" class="social_icon ' . esc_attr($icon_type[$i]) . '">&nbsp;</a></li>';
			}									
			$icons_html .= '</ul></div>';
		}
		for($i=0; $i<count($images); $i++)
		{
			$output .= '<li>
							<div class="vc_col-sm-8 wpb_column vc_column_container">
								' . wp_get_attachment_image($attachment_ids[$i], "small-slider-thumb") . '
							</div>
							<div class="vc_col-sm-4 wpb_column vc_column_container">
								<h3 class="page_margin_top">
									' . $images_titles[$i] . '
								</h3>
								<p>
									' . $images_descriptions[$i] . '
								</p>
								<div class="clearfix">
									<a class="read_more close_popup page_margin_top_section" href="#" title="' . __("Return to post", 'pressroom') . '"><span class="arrow"></span><span>' . __("RETURN TO POST", 'pressroom') . '</span></a>
								</div>
								' . $icons_html . '
							</div>
						</li>';
		}
		$output .= '</ul></div></div></div></div>';
	}
	else if(has_post_thumbnail() && (int)$show_post_featured_image)
	{
		$thumb_id = get_post_thumbnail_id(get_the_ID());
		$attachment_image = wp_get_attachment_image_src($thumb_id, "large");
		$large_image_url = $attachment_image[0];
		$output .= get_the_post_thumbnail(get_the_ID(), ($featured_image_size!="default" ? $featured_image_size : ($post_format!="image" ? "small-slider-thumb" : "blog-post-thumb")), array("alt" => get_the_title(), "title" => "", "class" => "post_image page_margin_top")) . ($post_format=="quote" && $quote_text!="" ? '<blockquote>' . $quote_text . ($quote_author!="" ? '<span class="author">' . $quote_author . '</span>' : '') . '</blockquote>' : '');
	}
	else if($post_format=="quote" && $quote_text!="")
	{
		$output .= '<blockquote class="page_margin_top">' . $quote_text . ($quote_author!="" ? '<span class="author">' . $quote_author . '</span>' : '') . '</blockquote>';
	}
	
	if($is_review!="" && $is_review!="no")
	{
		$points_scale = get_post_meta($post->ID, $themename. "_points_scale", true);
		$review_label = get_post_meta($post->ID, $themename. "_review_label", true);
		$review_value = get_post_meta($post->ID, $themename. "_review_value", true);
		$review_title = get_post_meta($post->ID, $themename. "_review_title", true);
		$review_description = get_post_meta($post->ID, $themename. "_review_description", true);
		$output .= '<div class="review_block clearfix">';
		$review_details_count = count(array_values(array_filter((array)$review_label)));
		$review_average = false;
		if($is_review=="percentage")
			$max = 100;
		else
			$max = ($points_scale>0 ? $points_scale : 10);
		$review_sum = 0;
		if($review_details_count)
		{
			for($i=0; $i<$review_details_count; $i++)
			{
				$review_sum += $review_value[$i];
				if($i==0 || $i==ceil($review_details_count/2))
				{
					if($i==ceil($review_details_count/2))
						$output .= '</ul></div>';
					$output .= '<div class="vc_col-sm-6 wpb_column vc_column_container"><ul class="review_chart">';
				}
				$output .= '<li>
					<h5 class="margin_top_0">' . $review_label[$i] . ($is_review=="percentage" ? ' (%)' : '') . '</h5>
					<div class="value_container">
						<div class="value_bar_container" style="width:' . ($review_value[$i]/$max*100) . '%;">
							<div class="value_bar animated_element animation-width duration-2000">
								<span class="number ' . ($is_review=="percentage" ? 'animated_element' : 'tens') . '" data-value="' . $review_value[$i] . '"></span>
							</div>
						</div>
					</div>
				</li>';
			}
			$output .= '</ul></div>';
		}
		$output .= '</div>';
		if($review_details_count)
			$review_average = round($review_sum/$review_details_count, 1);
		else
			$review_average = 0;
		if($review_title!="" || $review_description!="")
		{
			$output .= '<div class="review_summary margin_top_10 clearfix">
				<div class="number' . ($is_review=="points" ? ' tens' : '') . '" data-value="' . $review_average . '">' . ($is_review=="percentage" ? $review_average . '%' : '') . '</div>
				<div class="text">
					<h4 class="margin_top_0">' . $review_title . '</h4>
					<p>' . $review_description . '</p>
				</div>
				<div class="value_bar_container" style="width:' . ($review_average/$max*100) . '%;"><div class="value_bar animated_element duration-2000 animation-width"></div></div>
			</div>';
		}
	}
	$featured_caption = get_post_meta(get_the_ID(), $themename. "_featured_caption", true);
	if($featured_caption!="")
	{
		$output .= '<div class="sentence">
			<span class="text">' . $featured_caption . '</span>';
		$featured_caption_author = get_post_meta(get_the_ID(), $themename. "_featured_caption_author", true);
		if($featured_caption_author!="")
			$output .= '<span class="author">' . $featured_caption_author . '</span>';
		$output .= '</div>';
	}
	if($post_format=="image")
		$output .= '</div>';
	else
		$output .= '<div class="post_content page_margin_top_section clearfix"><div class="content_box' . (!(int)$show_post_author_box ? ' full_width' : '') . '">';
	if(((int)$show_post_excerpt==1) || ((int)$show_post_excerpt==2 && has_excerpt()))
		$output .= '<h4 class="excerpt">' . apply_filters("the_more_excerpt", get_the_excerpt()) . '</h4>';
	$output .= '<div class="text">' . (function_exists("wpb_js_remove_wpautop") ? wpb_js_remove_wpautop(apply_filters('the_content', get_the_content(null,true))) : apply_filters('the_content', get_the_content(null,true)));
	$output .= wp_link_pages(array(
		"before" => '<ul class="pagination post_pagination page_margin_top"><li>',
		"after" => '</li></ul>',
		"link_before" => '<span>',
		"link_after" => '</span>',
		"separator" => '</li><li>',
		"echo" => 0
	));
	if((int)$show_post_comments && (int)$comments_count)
		$output .= '<a class="read_more page_margin_top scroll_to_comments" href="' . get_comments_link() . '" title="' . $comments_count . ' ' . ($comments_count==1 ? __('comment', 'pressroom') : __('comments', 'pressroom')) . '"><span class="arrow"></span><span>' . $comments_count . ' ' . ($comments_count==1 ? __('comment', 'pressroom') : __('comments', 'pressroom')) . '</span></a>';
	$output .= '</div>';
	if($post_format!="image")
		$output .= '</div>';
	if((int)$show_post_author_box)
	{
		$author = get_user_by("id", get_the_author_meta('ID'));
		$output .= '<div class="author_box animated_element">
			<div class="single-author">
				<a class="thumb" href="' . get_author_posts_url($author->ID) . '" title="' . esc_attr($author->display_name) . '">' . get_avatar($author->ID, 100) . '</a>
				<div class="details">
					<h3><a href="' . get_author_posts_url($author->ID) . '" title="' . esc_attr($author->display_name) . '">' . $author->display_name . '</a></h3><br/>
					<div class="btn-twitter" ><a href="http://twitter.com/' . esc_attr($author->twitter) . '"><img src="' . get_template_directory_uri() .'/images/icons/social/Twitter_logo_blue_16.png"><p>Seguir en Twitter</p>@' . esc_attr($author->twitter) . '</a></div>
				</div>
			</div>
			<div id="at4-share" class="addthis_32x32_style atss at4-show">
				<a class="at-share-btn at-svc-facebook" href="#"><span class="at-icon-wrapper" style="background-color: rgb(59, 89, 152);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Facebook" alt="Facebook" class="at-icon at-icon-facebook"><g><path d="M21 6.144C20.656 6.096 19.472 6 18.097 6c-2.877 0-4.85 1.66-4.85 4.7v2.62H10v3.557h3.247V26h3.895v-9.123h3.234l.497-3.557h-3.73v-2.272c0-1.022.292-1.73 1.858-1.73h2V6.143z" fill-rule="evenodd"></path></g></svg></span></a>
				<a class="at-share-btn at-svc-email" href="#"><span class="at-icon-wrapper" style="background-color: rgb(115, 138, 141);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Email" alt="Email" class="at-icon at-icon-email"><g><path d="M26.19 9.55H6.04l10.02 7.57 10.13-7.57zM16.06 19.67l-10.28-8.8v11.58h20.57V10.96l-10.29 8.71z"></path></g></svg></span></a>
				<a class="at-share-btn at-svc-twitter" href="#"><span class="at-icon-wrapper" style="background-color: rgb(85, 172, 238);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Twitter" alt="Twitter" class="at-icon at-icon-twitter"><g><path d="M26.67 9.38c-.78.35-1.63.58-2.51.69.9-.54 1.6-1.4 1.92-2.42-.85.5-1.78.87-2.78 1.06a4.38 4.38 0 0 0-7.57 3c0 .34.04.68.11 1-3.64-.18-6.86-1.93-9.02-4.57-.38.65-.59 1.4-.59 2.2 0 1.52.77 2.86 1.95 3.64-.72-.02-1.39-.22-1.98-.55v.06c0 2.12 1.51 3.89 3.51 4.29a4.37 4.37 0 0 1-1.97.07c.56 1.74 2.17 3 4.09 3.04a8.82 8.82 0 0 1-5.44 1.87c-.35 0-.7-.02-1.04-.06a12.43 12.43 0 0 0 6.71 1.97c8.05 0 12.45-6.67 12.45-12.45 0-.19-.01-.38-.01-.57.84-.62 1.58-1.39 2.17-2.27z"></path></g></svg></span></a>
				<a class="at-share-btn at-svc-print" href="#"><span class="at-icon-wrapper" style="background-color: rgb(115, 138, 141);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Print" alt="Print" class="at-icon at-icon-print"><g><path d="M24.67 10.62h-2.86V7.49H10.82v3.12H7.95c-.5 0-.9.4-.9.9v7.66h3.77v1.31L15 24.66h6.81v-5.44h3.77v-7.7c-.01-.5-.41-.9-.91-.9zM11.88 8.56h8.86v2.06h-8.86V8.56zm10.98 9.18h-1.05v-2.1h-1.06v7.96H16.4c-1.58 0-.82-3.74-.82-3.74s-3.65.89-3.69-.78v-3.43h-1.06v2.06H9.77v-3.58h13.09v3.61zm.75-4.91c-.4 0-.72-.32-.72-.72s.32-.72.72-.72c.4 0 .72.32.72.72s-.32.72-.72.72zm-4.12 2.96h-6.1v1.06h6.1v-1.06zm-6.11 3.15h6.1v-1.06h-6.1v1.06z"></path></g></svg></span></a>
				<a class="at-share-btn at-svc-favorites" href="#"><span class="at-icon-wrapper" style="background-color: rgb(245, 202, 89);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Favorites" alt="Favorites" class="at-icon at-icon-favorites"><g><path d="M26.56 13.56a.432.432 0 0 0-.4-.29h-7.51l-2.32-7.14c-.06-.17-.22-.28-.39-.28s-.34.11-.39.28l-2.34 7.14H5.72c-.18 0-.34.12-.39.29-.06.17.01.35.15.46l6.06 4.42-2.34 7.17c-.06.17.01.35.15.46.14.11.34.1.49 0l6.1-4.43 6.09 4.43c.07.05.16.08.24.08s.17-.03.24-.08c.15-.1.2-.29.15-.46l-2.34-7.18 6.08-4.42a.37.37 0 0 0 .16-.45z"></path></g></svg></span></a>
				<a class="at-share-btn at-svc-compact" href="#"><span class="at-icon-wrapper" style="background-color: rgb(252, 109, 76);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="More" alt="More" class="at-icon at-icon-addthis"><g><path d="M25.07 13.74h-6.71V7.03h-4.47v6.71H7.18v4.47h6.71v6.71h4.47v-6.71h6.71z"></path></g></svg></span></a>
			</div>
		</div>';
	}
	if($post_format=="image")
		$output .= '</div>';
	$output .= '</div></div>';
	if($show_share_box && (int)$icons_count)
	{
		$output .= '<div class="vc_row wpb_row vc_row-fluid page_margin_top">
						<div class="share_box clearfix">
						<label>' . __("Share", 'pressroom') . ':</label>
						<ul class="social_icons clearfix">';
		for($i=0; $i<$icons_count; $i++)
		{
			if(isset($atts["icon_target" . $i]))
			{
				$large_image_url = "";
				if(has_post_thumbnail() && (int)$show_post_featured_image)
				{
					$thumb_id = get_post_thumbnail_id(get_the_ID());
					$attachment_image = wp_get_attachment_image_src($thumb_id, "large");
					$large_image_url = $attachment_image[0];
				}
				$output .= '<li><a' . ($atts["icon_target" . $i]=="_blank" ? ' target="_blank"' : '') . ' title="" href="' . esc_url(str_replace("{MEDIA_URL}", $large_image_url, str_replace("{TITLE}", urlencode(get_the_title()), str_replace("{URL}", get_permalink(), $atts["icon_url" . $i])))) . '" class="social_icon ' . esc_attr($atts["icon_type" . $i]) . '">&nbsp;</a></li>';
			}
		}
		$output .= '</ul></div></div>';
	}
	if((int)$show_post_tags_footer || (int)$show_post_categories_footer)
	{
		$output .= '<div class="vc_row wpb_row vc_row-fluid page_margin_top">';
		if((int)$show_post_tags_footer)
		{
			$tags = get_the_tags();
			if($tags)
			{
				$output .= '<ul class="taxonomies tags left clearfix">';
				foreach($tags as $key=>$tag)
				{
					$output .= '<li><a href="' . get_tag_link($tag->term_id ) . '" ';
					if(empty($tag->description))
						$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $tag->name) . '"';
					else
						$output .= 'title="' . esc_attr(strip_tags(apply_filters('tag_description', $tag->description, $tag))) . '"';
					$output .= '>' . $tag->name . '</a></li>';
				}
				$output .= '</ul>';
			}
		}
		/*if((int)$show_post_categories_footer)
		{
			$categories = get_the_category();
			if(count($categories))
				$output .= '<ul class="taxonomies categories right clearfix">';
			foreach($categories as $key=>$category)
			{
				$output .= '<li><a href="' . get_category_link($category->term_id ) . '" ';
				if(empty($category->description))
					$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $category->name) . '"';
				else
					$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
				$output .= '>' . $category->name . '</a></li>';
			}
			if(count($categories))
				$output .= '</ul>';
		}*/
		$output .= '</div>';
	}
	/*$output .= '<h4 class="box_header page_margin_top">' . __("Author", 'pressroom') . '</h4>';
	$author = get_user_by("id", get_the_author_meta('ID'));
	$output .= '<div class="author_box page_margin_top clearfix">
		<div class="single-author">
			<a class="thumb" href="' . get_author_posts_url($author->ID) . '" title="' . esc_attr($author->display_name) . '" style="float: left;">' . get_avatar($author->ID, 100) . '</a>
			<div class="details" style="float: left; clear: none; margin-left: 30px; margin-top: 0px;">
				<h5><a href="' . get_author_posts_url($author->ID) . '" title="' . esc_attr($author->display_name) . '">' . $author->display_name . '</a></h5>
				<h6>' . strtoupper($author->roles[0]) . '</h6>
				<a href="' . get_author_posts_url($author->ID) . '" class="more highlight margin_top_15">' . __("PROFILE", 'pressroom') . '</a>
			</div>
		</div>
	</div>';
	/*if((int)$comments)
	{
		ob_start();
		comments_template();
		require_once(locate_template("comments-form.php"));	
		$output .= ob_get_contents();
		ob_end_clean();
	}*/
	return $output;
}
add_shortcode("single_post", "pr_theme_single_post");

//visual composer
function pr_theme_single_post_vc_init()
{
	//image sizes
	$image_sizes_array = array();
	$image_sizes_array[__("Default", 'pressroom')] = "default";
	global $_wp_additional_image_sizes;
	foreach(get_intermediate_image_sizes() as $s) 
	{
		if(isset($_wp_additional_image_sizes[$s])) 
		{
			$width = intval($_wp_additional_image_sizes[$s]['width']);
			$height = intval($_wp_additional_image_sizes[$s]['height']);
		} 
		else
		{
			$width = get_option($s.'_size_w');
			$height = get_option($s.'_size_h');
		}
		$image_sizes_array[$s . " (" . $width . "x" . $height . ")"] = "pr_" . $s;
	}
	$params = array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Featured image size", 'pressroom'),
			"param_name" => "featured_image_size",
			"value" => $image_sizes_array
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post title", 'pressroom'),
			"param_name" => "show_post_title",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post featured image", 'pressroom'),
			"param_name" => "show_post_featured_image",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post excerpt", 'pressroom'),
			"param_name" => "show_post_excerpt",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0, __("Only when defined", 'pressroom') => 2)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post categories", 'pressroom'),
			"param_name" => "show_post_categories",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post date", 'pressroom'),
			"param_name" => "show_post_date",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post author", 'pressroom'),
			"param_name" => "show_post_author",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post views number", 'pressroom'),
			"param_name" => "show_post_views",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show comments number", 'pressroom'),
			"param_name" => "show_post_comments",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show author box in post content", 'pressroom'),
			"param_name" => "show_post_author_box",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post tags in post footer", 'pressroom'),
			"param_name" => "show_post_tags_footer",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post categories in post footer", 'pressroom'),
			"param_name" => "show_post_categories_footer",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show share box", 'pressroom'),
			"param_name" => "show_share_box",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		)
	);
	$count = array();
	for($i=1; $i<=30; $i++)
		$count[$i] = $i;
	$icons = array(
		"behance",
		"bing",
		"blogger",
		"deezer",
		"designfloat",
		"deviantart",
		"digg",
		"dribbble",
		"envato",
		"facebook",
		"flickr",
		"form",
		"forrst",
		"foursquare",
		"friendfeed",
		"googleplus",
		"instagram",
		"linkedin",
		"mail",
		"mobile",
		"myspace",
		"picasa",
		"pinterest",
		"reddit",
		"rss",
		"skype",
		"spotify",
		"soundcloud",
		"stumbleupon",
		"technorati",
		"tumblr",
		"twitter",
		"vimeo",
		"wykop",
		"xing",
		"youtube"
	);
	$params[] = array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Number of social icons", 'pressroom'),
		"param_name" => "icons_count",
		"value" => $count,
		"dependency" => Array('element' => "show_share_box", 'value' => '1')
	);
	for($i=0; $i<25; $i++)
	{
		$params[] = array(
			"type" => "dropdown",
			"heading" => __("Icon type", 'pressroom') . " " . ($i+1),
			"param_name" => "icon_type" . $i,
			"value" => $icons,
			"dependency" => Array('element' => "show_share_box", 'value' => '1')
		);
		$params[] = array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Icon url", 'pressroom') . " " . ($i+1),
			"param_name" => "icon_url" . $i,
			"value" => "",
			"dependency" => Array('element' => "show_share_box", 'value' => '1'),
			"description" => __("Use <strong>{URL}</strong> constant to have current post url in the link. You can also use <strong>{TITLE}</strong> variable and {MEDIA_URL} variable. Example: http://www.facebook.com/sharer.php?u=<strong>{URL}</strong> You can use <a href='http://www.sharelinkgenerator.com/' target='_blank'>Share Link Generator</a> to create share link", 'pressroom')
		);
		$params[] = array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Icon target", 'pressroom') . " " . ($i+1),
			"param_name" => "icon_target" . $i,
			"value" => array(__("Same window", 'pressroom') => "", __("New window", 'pressroom') => "_blank"),
			"dependency" => Array('element' => "show_share_box", 'value' => '1')
		);
	}
	vc_map( array(
		"name" => __("Post", 'pressroom'),
		"base" => "single_post",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-post",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_single_post_vc_init");
?>

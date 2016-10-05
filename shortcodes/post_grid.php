<?php
function pr_theme_post_grid_shortcode($atts)
{
	global $themename;
	extract(shortcode_atts(array(
		"type" => "large",
		"items_per_page" => -1,
		"ids" => "",
		"category" => "",
		"order_by" => "title,menu_order",
		"order" => "DESC",
		"show_post_icon" => 1,
		"show_post_categories" => 1,
		"show_post_date" => 0,
		"top_margin" => "none"
	), $atts));
	
	$ids = explode(",", $ids);
	if($ids[0]=="-" || $ids[0]=="")
	{
		unset($ids[0]);
		$ids = array_values($ids);
	}
	$category = explode(",", $category);
	if($category[0]=="-" || $category[0]=="")
	{
		unset($category[0]);
		$category = array_values($category);
	}
	$args = array( 
		'include' => $ids,
		'post_type' => 'post',
		'posts_per_page' => $items_per_page,
		'post_status' => 'publish',
		'category_name' => implode(",", $category),
		'orderby' => ($order_by=="views" ? 'meta_value_num' : implode(" ", explode(",", $order_by))), 
		'order' => $order
	);
	if($items_per_page==-1)
		$args['nopaging'] = true;
	if($order_by=="views")
		$args['meta_key'] = 'post_views_count';
	$posts_list = get_posts($args);
	$output = '';
	$category_filter_array = $category;
	foreach($posts_list as $post) 
	{
		$output .= '<div class="post ' . $type . '">
						<a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '">';
							if((int)$show_post_icon)
							{
								$is_review = get_post_meta($post->ID, $themename. "_is_review", true);
								$post_format = get_post_format($post->ID);
								require_once(locate_template("shortcodes/class/Post.php"));	
								$output .= (($is_review=="percentage" || $is_review=="points") && $post_format!="video" && $post_format!="gallery" ? '<span class="icon' . ($type=='vertical' ? ' review small">' : '"><span>' . get_post_meta($post->ID, $themename . "_review_average", true) . ($is_review=="percentage" ? '%' : '') . '</span>') . '</span>' : '') . ($post_format=="video" || $post_format=="gallery" ? '<span class="icon ' . $post_format . ($type=='vertical' ? ' small' : '') . '"></span>' : '');
							}
							if( class_exists('Dynamic_Featured_Image') ) {
								global $dynamic_featured_image;
								$featuredImages = $dynamic_featured_image->get_featured_images($post->ID);
								if ($featuredImages[0]['attachment_id']) {
									$attachment_id = $featuredImages[0]['attachment_id'];
									$output .= wp_get_attachment_image($featuredImages[0]['attachment_id'], ($type=="small" ? "thumbnail" : "post-grid-thumb-" . $type), array("alt" => get_the_title(), "title" => ""));
								} else {
									$output .= get_the_post_thumbnail($post->ID, ($type=="small" ? "thumbnail" : "post-grid-thumb-" . $type), array("alt" => get_the_title(), "title" => ""));
								}
							} else {
								$output .= get_the_post_thumbnail($post->ID, ($type=="small" ? "thumbnail" : "post-grid-thumb-" . $type), array("alt" => get_the_title(), "title" => ""));
							}
						$output .='</a>
						<div class="slider_content_box">';
							if((int)$show_post_categories || (int)$show_post_date)
								$output .= '<ul class="post_details simple">';
							if((int)$show_post_categories)
							{
								$post_categories = wp_get_post_categories($post->ID);
								if(count($post_categories))
								{
									$output .= '<li class="category">';
									$primary_category = get_post_meta($post->ID, $themename. "_primary_category", true);
									if(isset($primary_category) && $primary_category!="-" && $primary_category!="")
									{
										$primary_category_object = get_category($primary_category);
										if(is_object($primary_category_object))
										{
											$additional_categories = array();
											if(count($category_filter_array))
											{
												$found = false;
												$additional_categories = array();
												foreach((array)$category_filter_array as $category_filter)
												{
													if($category_filter==$primary_category_object->slug)
													{
														$found = true;
														$additional_categories = array();
														break;
													}
													else
														$additional_categories[] = $category_filter;
												}
											}
											$output .= '<a class="category-' . $primary_category_object->term_id . '" href="' . get_category_link($primary_category) . '" ';
											if(empty($primary_category_object->description))
												$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $primary_category_object->name) . '"';
											else
												$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $primary_category_object->description, $primary_category_object))) . '"';
											$output .= '>' . $primary_category_object->name . '</a>';
											if(count($additional_categories))
											{
												foreach($post_categories as $key=>$post_category)
												{
													$category = get_category($post_category);
													if(in_array($category->slug, $additional_categories))
													{
														$output .= ', <a class="category-' . $category->term_id . '" href="' . get_category_link($category->term_id) . '" ';
														if(empty($category->description))
															$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $category->name) . '"';
														else
															$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
														$output .= '>' . $category->name . '</a>';
													}
												}
											}
										}
									}
									else
									{
										foreach($post_categories as $key=>$post_category)
										{
											$category = get_category($post_category);
											$output .= '<a class="category-' . $category->term_id . '" href="' . get_category_link($category->term_id) . '" ';
											if(empty($category->description))
												$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $category->name) . '"';
											else
												$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
											$output .= '>' . $category->name . '</a>' . ($post_category != end($post_categories) ? ', ' : '');
										}
									}
									$output .= '</li>';
								}
							}
							if((int)$show_post_date)
								$output .= '	<li class="date">' . date_i18n(get_option('date_format'), strtotime($post->post_date)) . '</li>';
							if((int)$show_post_categories || (int)$show_post_date)
								$output .= '</ul>';
							$output .= '<h' . ($type=="small" ? '5' : '2') . '><a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '">' . $post->post_title . '</a></h' . ($type=="small" ? '5' : '2') . '>
						</div>
					</div>';
	}
	return $output;
}
add_shortcode("pr_post_grid", "pr_theme_post_grid_shortcode");

//visual composer
function pr_theme_post_grid_vc_init()
{
	//get posts list
	global $pressroom_posts_array;

	//get categories
	$post_categories = get_terms("category");
	$post_categories_array = array();
	$post_categories_array[__("All", 'pressroom')] = "-";
	foreach($post_categories as $post_category)
		$post_categories_array[$post_category->name] =  $post_category->slug;
	
	$params = array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'pressroom'),
			"param_name" => "type",
			"value" => array(__("Large", 'pressroom') => "large", __("Big", 'pressroom') => "big", __("Medium", 'pressroom') => "medium", __("Small", 'pressroom') => "small")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Post count", 'pressroom'),
			"param_name" => "items_per_page",
			"value" => -1,
			"description" => __("Set -1 to display all.", 'pressroom')
		),
		array(
			"type" => (count($pressroom_posts_array) ? "dropdownmulti" : "textfield"),
			"class" => "",
			"heading" => __("Display selected", 'pressroom'),
			"param_name" => "ids",
			"value" => (count($pressroom_posts_array) ? $pressroom_posts_array : ''),
			"description" => (count($pressroom_posts_array) ? '' : __("Please provide post ids separated with commas, to display only selected posts", 'pressroom'))
		),
		array(
			"type" => "dropdownmulti",
			"class" => "",
			"heading" => __("Display from Category", 'pressroom'),
			"param_name" => "category",
			"value" => $post_categories_array
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by", 'pressroom'),
			"param_name" => "order_by",
			"value" => array(__("Title, menu order", 'pressroom') => "title,menu_order", __("Menu order", 'pressroom') => "menu_order", __("Date", 'pressroom') => "date", __("Post views", 'pressroom') => "views", __("Comment count", 'pressroom') => "comment_count", __("Random", 'pressroom') => "rand")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order", 'pressroom'),
			"param_name" => "order",
			"value" => array( __("descending", 'pressroom') => "DESC", __("ascending", 'pressroom') => "ASC")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post format icon on featured image", 'pressroom'),
			"param_name" => "show_post_icon",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
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
			"value" => array(__("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	);
	vc_map( array(
		"name" => __("Post Grid", 'pressroom'),
		"base" => "pr_post_grid",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-post-grid",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_post_grid_vc_init");
?>

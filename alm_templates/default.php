<?php global $post;
	if(!isset($count)) {
		$count = 0;
	} 
?>
<div class="vc_col-sm-4 wpb_column vc_column_container <?php if($count%3==0) { echo 'no-left-margin';}?>"><ul class="blog three_columns clearfix page_margin_top_section"><li class="post post-<?php get_the_id;?> type-post status-publish format-aside has-post-thumbnail hentry">
<?php $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'blog-post-thumb');
	if( class_exists('Dynamic_Featured_Image') ) {
		global $dynamic_featured_image;
		$featuredImages = $dynamic_featured_image->get_featured_images($post->ID);
		if ($featuredImages[0]['attachment_id']) {
			$attachment_id = $featuredImages[0]['attachment_id'];
			echo '<a class="post_image" href="' . get_permalink() . '" title="' . esc_attr(get_the_title()) . '">' . wp_get_attachment_image($featuredImages[0]['attachment_id'],"blog-post-thumb", false, array("alt" => get_the_title(), "title" => "", "style" => "display: block;")) . '</a>';
		} else { ?>
			<a class="post_image" href="<?php the_permalink();?>" title="<?php the_title();?>"><img width="330" height="242" src="<?php echo $thumbnail_src[0];?>" class="attachment-blog-post-thumb" alt="<?php the_title();?>" title="" style="display: block;"></a>
<?php 	}
	} else { ?>
		<a class="post_image" href="<?php the_permalink();?>" title="<?php the_title();?>"><img width="330" height="242" src="<?php echo $thumbnail_src[0];?>" class="attachment-blog-post-thumb" alt="<?php the_title();?>" title="" style="display: block;"></a>
<?php }
?>
<h2 class="clearfix"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a></h2>
<?php 
	$categories = get_the_category();
?>
<ul class="post_details simple">
<li class="category">
<?php $cat_i = 0;
foreach($categories as $category) {
    if($cat_i != 0) { echo ", "; } ?>
	<a class="category-<?php echo $category->term_id;?>" href="http://caninomag.es/category/<?php echo $category->slug;?>/" title="View all posts filed under <?php echo $category->name;?>"><?php echo $category->name;?></a>
<?php $cat_i++;} ?>
</li>
<li class="date"><?php echo get_the_date();?></li></ul><?php the_excerpt();?>
<div class="author_row"><span class="author_by">By </span><a class="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author();?>"><?php the_author();?></a></div>
</li></ul></div>
<?php $count++; ?>

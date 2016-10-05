<?php
if(comments_open())
{
if(have_comments()):
	$comments_count = get_comments_number();
	?>
	<h4 class="box_header"><?php echo $comments_count . " " . ($comments_count!=1 ? __("Comments", 'pressroom') : __("Comment", 'pressroom')); ?></h4>
	<ul id="comments_list">
		<?php
		paginate_comments_links();
		wp_list_comments(array(
			'avatar_size' => 100,
			'page' => (isset($_GET["paged"]) ? (int)$_GET["paged"] : 1),
			'per_page' => '5',
			'callback' => 'pr_theme_comments_list'
		));
		?>
	<?php
	global $post;
	$query = $wpdb->prepare("SELECT COUNT(*) AS count FROM $wpdb->comments WHERE comment_approved = 1 AND comment_post_ID = %d AND comment_parent = 0", get_the_ID());
	$parents = $wpdb->get_row($query);
	if($parents->count>5)
		pr_comments_pagination(2, ceil($parents->count/5));
	?>
	</ul>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		$(".comments_list_container .reply_button").click(function(event){
			event.preventDefault();
			var offset = $("#comment_form").offset();
			$("html, body").animate({scrollTop: offset.top-10}, 400);
			$("#comment_form [name='comment_parent_id']").val($(this).attr("href").substr(1));
			$("#cancel_comment").css('display', 'block');
		});
		$("#cancel_comment").click(function(event){
			event.preventDefault();
			$(this).css('display', 'none');
			$("#comment_form [name='comment_parent_id']").val(0);
		});
	});
	</script>
	<?php
endif;
}
function pr_theme_comments_list($comment, $args, $depth)
{
	global $post;
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class('comment clearfix'); ?> id="comment-<?php comment_ID() ?>">
		<?php
		if((int)$comment->comment_parent>0)
		{
			echo '<a class="parent_arrow" href="#comment-' . (int)$comment->comment_parent . '" title="' . __('Show comment', 'pressroom') . '"></a>';
		}
		?>
		<div class="comment_author_avatar">
			<?php echo get_avatar( $comment->comment_author_email, $args['avatar_size'] ); ?>
		</div>
		<div class="comment_details">
			<div class="posted_by clearfix">
				<h5>
				<?php 
				comment_author_link();
				if((int)$comment->comment_parent>0)
				{	
					$parent_author = get_comment_author((int)$comment->comment_parent);
					echo '<a href="#comment-' . (int)$comment->comment_parent . '" class="in_reply">@' . $parent_author . '</a>';
				}
				?>
				</h5>
				<abbr title="<?php printf(__(' %1$s, %2$s', 'pressroom'), get_comment_date(),  get_comment_time()); ?>" class="timeago"><?php printf(__(' %1$s, %2$s', 'pressroom'), get_comment_date(),  get_comment_time()); ?></abbr>
			</div>
			<?php 
			comment_text(); 
			edit_comment_link(__('(Edit)', 'pressroom'),'<br>','<br><br>'); 
			?>
			<a class="read_more reply_button" href="#<?php comment_ID(); ?>" title="<?php esc_attr_e('Reply', 'pressroom'); ?>">
				<span class="arrow"></span><span><?php _e('REPLY', 'pressroom'); ?></span>
			</a>
			<div class="read_more report-abuse" style="float: right; clear: none; padding: 0">
				<?php do_action( 'comment_report_abuse_link' ); ?>
			</div>
		</div>
<?php
}
function pr_comments_pagination($range, $pages)
{
	$paged = (!isset($_GET["paged"]) || (int)$_GET["paged"]==0 ? 1 : (int)$_GET["paged"]);
	$showitems = ($range * 2)+1;
	
	echo "<ul class='pagination page_margin_top_section'>";
	//if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li class='left'><a href='#page-1'></a></li>";
	if($paged > 1 && $showitems < $pages) echo "<li class='left'><a href='#page-" . ($paged-1) . "'>&nbsp;</a></li>";

	for ($i=1; $i <= $pages; $i++)
	{
		if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
		{
			echo "<li" . ($paged == $i ? " class='selected'" : "") . ">" . ($paged == $i ? "<span>".$i."</span>":"<a href='#page-" . $i . "'>".$i."</a>") . "</li>";
		}
	}

	if ($paged < $pages && $showitems < $pages) echo "<li class='right'><a href='#page-" . ($paged+1) . "'>&nbsp;</a></li>";  
	//if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='#page-" . $pages . "' class='pagination_arrow'>&raquo;</a></li>";
	echo "</ul>";
}
?>
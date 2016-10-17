<?php

$links = paginate_links( array(
	'type' => 'array',
	'prev_text' => '<',
	'next_text' => '>',
	'mid_size' => 3
) );
?>

<ul class="pagination">
	<?php foreach ( $links as $link ): ?>
		<li><?php echo $link; ?></li>
	<?php endforeach; ?>
</ul>
<!--ul class="pagination">
	<li class="selected"><span>1</span></li>
	<li><a href="http://www.caninomag.es/page/2/?s=w" data-page="2">2</a></li>
	<li><a href="http://www.caninomag.es/page/3/?s=w" data-page="3">3</a></li>
	<li class="pr_pagination_next"><a href="http://www.caninomag.es/page/2/?s=w" data-page="2">›</a></li>
	<li class="pr_pagination_last"><a href="http://www.caninomag.es/page/152/?s=w" data-page="152">»</a></li>
</ul-->
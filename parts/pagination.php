<?php

$links = paginate_links(
	array(
		'type'      => 'array',
		'prev_text' => '<',
		'next_text' => '>',
		'mid_size'  => 3,
	)
);
?>
<?php if ( $links ) : ?>
	<ul class="pagination" role="navigation" aria-label="Paginación">
		<?php foreach ( $links as $link ) : ?>
			<li><?php echo $link; ?></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php $counter = 0; ?>
<div class="canino-el-parte row align-top">
	<div class="column">
		<?php
		while ( $query->have_posts() && $counter < 5 ) :
			$query->the_post();
			?>
			<?php get_template_part( 'parts/content', 'el-parte' ); ?>
			<?php $counter++; ?>
		<?php endwhile; ?>
	</div>
	<div class="column show-for-medium">
		<?php
		while ( $query->have_posts() && $counter < 10 ) :
			$query->the_post();
			?>
			<?php get_template_part( 'parts/content', 'el-parte' ); ?>
			<?php $counter++; ?>
		<?php endwhile; ?>
	</div>
</div>

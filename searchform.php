<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<input type="submit" class="button" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
</form>
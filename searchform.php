<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<label id="s">
			<span class="show-for-sr"><?php _ex( 'Search for:', 'label' ); ?></span>
		</label>
		<input type="search" class="input-group-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder' ); ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />
		<div class="input-group-button">
			<input type="submit" class="button" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
		</div>
	</div>
</form>
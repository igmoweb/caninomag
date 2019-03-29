import Glide from '@glidejs/glide';

jQuery( document ).ready( function( $) {
	var sliders = document.querySelectorAll('.glide');
	for (var i = 0; i < sliders.length; i++) {
		var glide = new Glide(sliders[i], {
			gap: 15,
		});

		glide.mount();
	}
	// new Glide( '.wp-block-canino-slider' ).mount();
})


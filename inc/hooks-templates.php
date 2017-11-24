<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'the_password_form', 'canino_password_form' );

function canino_password_form( $output ) {
	global $post;
	$post = get_post( $post );
	$label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
	$output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
	<p>Artículo en exclusiva para suscriptores en Patreon. Incluye la contraseña para ver el contenido completo. ¿Todavía no formas parte de Patreon? <a target="_blank" href="https://www.patreon.com/canino">Conviértete en micromecenas y accede a nuestros posts exclusivos</a>.</p>
	<p><label for="' . $label . '"><span class="show-for-sr">' . __( 'Password:' ) . '</span> <input name="post_password" id="' . $label . '" type="password" size="20" /></label> <input class="button expanded" type="submit" name="Submit" value="' . esc_attr_x( 'Enter', 'post password form' ) . '" /></p></form>
	';
	return $output;
}
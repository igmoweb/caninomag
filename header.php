<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header id="masthead" class="site-header" role="banner">

		<div id="top-bar">
			<?php get_sidebar( 'top-bar' ); ?>
		</div>

		<div class="site-branding text-center">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title">
					<?php canino_the_custom_logo(); ?>
				</h1>
			<?php else : ?>
				<p class="site-title">
					<?php canino_the_custom_logo(); ?>
				</p>
			<?php endif; ?>
		</div>

	</header>

	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<div class="title-bar hide-for-large" data-responsive-toggle="site-navigation" data-hide-for="large">
			<button class="menu-icon" type="button" data-toggle></button>
			<div class="title-bar-title">Menu</div>
		</div>
		<div id="site-navigation" class="main-navigation">
			<nav role="navigation" class="row">
				<div class="columns large-10 canino-primary-menu-wrap">
					<?php
					// Primary navigation menu.
					wp_nav_menu( array(
						'menu_class'     => 'menu vertical large-horizontal canino-primary-menu',
						'theme_location' => 'primary'
					) );
					?>
				</div>
				<div class="columns large-2 canino-social-menu-wrap">
					<?php
						if ( has_nav_menu( 'social' ) ) {
							// Social navigation menu.
							wp_nav_menu( array(
								'menu_class'     => 'menu small-horizontal canino-social-menu',
								'theme_location' => 'social',
								'depth' => 1,
								'link_before'    => '<span class="show-for-sr">',
								'link_after'     => '</span>',
							) );
						}
					?>
				</div>
			</nav>
		</div><!-- .main-navigation -->
	<?php endif; ?>

	<div id="content" role="main">
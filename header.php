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

		<div id="top-bar" class="row">
			<div class="column large-12">
				<?php get_sidebar( 'top-bar' ); ?>
			</div>
		</div>

		<div class="site-branding row show-for-large">
			<div class="column large-6 align-bottom">
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
			<div class="column large-6 text-right align-bottom header-patreon">
				<div class="row">
					<h2 class="column large-6 align-middle show-for-large">¿Te gusta lo que lees?</h2>
					<span class="column large-6 show-for-medium">
						<a target="_blank" href="https://www.patreon.com/canino">
							<span class="show-for-sr">Ap&oacute;yanos a partir de 2 Euros en Patreon</span>
							<img src="<?php echo get_template_directory_uri(); ?>/images/Boton_patreon.png" alt="">
						</a>
					</span>
				</div>
			</div>
		</div>
	</header>

	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<div class="title-bar hide-for-large" data-responsive-toggle="site-navigation" data-hide-for="large">
			<div class="title-bar-title">
				<div class="row align-middle">
					<span class="column small-4">
						<a href="<?php echo home_url(); ?>" class="custom-logo-link" rel="home" itemprop="url">
							<img width="150" height="150" src="<?php echo get_template_directory_uri() . '/images/canino-logo-small.png'; ?>" class="hide-for-large custom-logo" alt="Canino">
						</a>
					</span>
					<span class="column small-7">
						<a target="_blank" href="https://www.patreon.com/canino">
							<span class="show-for-sr">Ap&oacute;yanos a partir de 2 Euros en Patreon</span>
							<img src="<?php echo get_template_directory_uri(); ?>/images/Boton_patreon.png" alt="">
						</a>
					</span>
				</div>


			</div>
			<button class="menu-icon" type="button" data-toggle></button>
		</div>
		<div id="site-navigation" class="main-navigation">
			<nav role="navigation" class="row">
				<div class="columns large-12 canino-primary-menu-wrap">
					<?php
					// Primary navigation menu.
					wp_nav_menu(
						array(
							'menu_class'     => 'menu vertical large-horizontal canino-primary-menu',
							'theme_location' => 'primary',
						)
					);
					?>
				</div>
			</nav>
		</div><!-- .main-navigation -->
	<?php endif; ?>

	<?php if ( function_exists( 'yoast_breadcrumb' ) && ! is_home() && ! is_front_page() ) : ?>
		<div class="row">
			<?php yoast_breadcrumb( '<div id="breadcrumbs" class="column large-12">', '</div>' ); ?>
		</div>
	<?php endif; ?>

	<div id="content" role="main">

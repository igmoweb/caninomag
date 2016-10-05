<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<?php global $theme_options; ?>
	<head>
		<!--meta-->
		<meta charset="<?php bloginfo("charset"); ?>" />
		<meta name="generator" content="WordPress <?php bloginfo("version"); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.2" />
		
		<meta name="format-detection" content="telephone=no" />
		<!--style-->
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo("rss2_url"); ?>" />
		<link rel="pingback" href="<?php bloginfo("pingback_url"); ?>" />
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />
		<?php
		wp_head();
		$color_skin = (isset($_COOKIE['pr_color_skin']) ? $_COOKIE['pr_color_skin'] : $theme_options["color_scheme"]);
		if($color_skin!="high_contrast")
			require_once(locate_template("custom_colors.php"));
		?>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />
		
		<!-- Begin comScore Tag -->
		<script>
		  var _comscore = _comscore || [];
		  _comscore.push({ c1: "2", c2: "14906276" });
		  (function() {
			var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;
			s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
			el.parentNode.insertBefore(s, el);
		  })();
		</script>
		<noscript>
		  <img src="http://b.scorecardresearch.com/p?c1=2&c2=14906276&cv=2.0&cj=1" />
		</noscript>
		<!-- End comScore Tag -->
		
	</head>
	<?php
		$image_overlay = ((!isset($_COOKIE['pr_image_overlay']) && $theme_options['layout_image_overlay']=='overlay') || ((isset($_COOKIE['pr_image_overlay']) && $_COOKIE['pr_image_overlay']=='overlay') || (!isset($_COOKIE['pr_image_overlay']) && $theme_options['layout_image_overlay']=='')) ? ' overlay' : '');
		$layout_style_class = (isset($_COOKIE['pr_layout']) && $_COOKIE['pr_layout']=="boxed" ? (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']!="" ? $_COOKIE['pr_layout_style'] . $image_overlay : 'image_1' . $image_overlay) : (isset($theme_options['layout']) && $theme_options['layout']=="boxed" ? (isset($theme_options['layout_style']) && $theme_options['layout_style']!="" ? $theme_options['layout_style'] . (substr($theme_options['layout_style'], 0, 5)=="image" && isset($theme_options['layout_image_overlay']) && $theme_options['layout_image_overlay']!="0" ? $image_overlay : '') : 'image_1' . $image_overlay) : ''));
	?>
	<body <?php body_class(($layout_style_class!="color_preview" ? $layout_style_class : "")); ?>>
		<style>
.cintillo { height: 30px; width: 100%;  display: block; background-image: url('http://www.eldiario.es/socios/BLANCO-GENERAL_EDIFIL20140904_0001.png'); background-repeat: no-repeat; background-position: 98%; top: 0; margin-right: 30px; background-size: contain; z-index: 300; margin-right: 50px; position: absolute;text-indent: -9999px;overflow: hidden;}
 #container { padding-top: 30px; } 
</style>
		<a class="cintillo" title="eldiario.es: Noticias de actualidad sobre política y economía, análisis y blogs de opinión" href="http://eldiario.es">Medio asociado a eldiario.es</a>
		<div class="site_container<?php echo (isset($_COOKIE['pr_layout']) ? ($_COOKIE['pr_layout']=="boxed" ? ' boxed' : '') : ($theme_options['layout']=="boxed" ? ' boxed' : '')); ?>">
			<?php
			if($theme_options["header_top_sidebar"]!="")
			{
				$header_top_bar_container = (isset($color_skin) && $color_skin=='dark' ? ' style_4' : ($color_skin=='high_contrast' ? ' style_5 border' : ''));
				if(isset($theme_options["header_top_bar_container"]) && $theme_options["header_top_bar_container"]!="")
					$header_top_bar_container = $theme_options["header_top_bar_container"];
				?>
				<div class="header_top_bar_container clearfix<?php echo (isset($_COOKIE['pr_header_top_bar_container']) && $_COOKIE['pr_header_top_bar_container']!="" ? ' ' . $_COOKIE['pr_header_top_bar_container'] : ($header_top_bar_container!="" ? ' ' : '') . $header_top_bar_container); ?>">
				<?php
				$sidebar = get_post($theme_options["header_top_sidebar"]);
				if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)):
				?>
				<div class="header_top_bar clearfix">
					<?php
					dynamic_sidebar($sidebar->post_name);
					?>
				</div>
				<?php
				endif;
				?>
				</div>
				<?php
			}
			$header_container = (isset($color_skin) && $color_skin=='dark' ? ' style_2' : ($color_skin=='high_contrast' ? ' style_3' : ''));
			if($theme_options["header_container"]!="")
				$header_container = $theme_options["header_container"];
			?>
			<!-- Header -->
			<div class="header_container<?php echo (isset($_COOKIE['pr_header_container']) && $_COOKIE['pr_header_container']!="" ? ' ' . $_COOKIE['pr_header_container'] : ($header_container!="" ? ' ' : '') . $header_container); ?>">
				<div class="<?php if(!is_category(['mondo-pixel','inferno'])): ?>header<?php endif; ?> clearfix">
					<?php
					if(is_active_sidebar('header-top')):
					?>
					<div class="header_top_sidebar clearfix">
					<?php
					get_sidebar('header-top');
					?>
					</div>
					<?php
					endif;
					?>
					<div class="logo">
						<h1><a href="<?php echo get_home_url(); ?>" title="<?php bloginfo("name"); ?>">
							<?php if(is_category('mondo-pixel')): ?>
							<img src="<?php echo esc_url("http://www.caninomag.es/wp-content/uploads/2015/09/cabeceramondopixel.gif"); ?>" alt="logo" />
							<?php elseif(is_category('inferno')): ?>
								<img src="<?php echo esc_url("http://www.caninomag.es/wp-content/uploads/2015/09/cabecerainferno.gif"); ?>" alt="logo" />
							<?php elseif($theme_options["logo_url"]!=""): ?>
							<img src="<?php echo esc_url($theme_options["logo_url"]); ?>" alt="logo" />
							<?php endif; ?>
							<?php if($theme_options["logo_text"]!=""): ?>
							<?php echo $theme_options["logo_text"]; ?>
							<?php 
							endif;
							?>
						</a></h1>
					</div>
					<?php
					$header_top_right_sidebar_visible = false;
					if($theme_options["header_top_right_sidebar"]!="")
					{
						?>
						<div class="header_top_right_sidebar_container">
						<?php
						$sidebar = get_post($theme_options["header_top_right_sidebar"]);
						if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)):
						?>
						<?php
						dynamic_sidebar($sidebar->post_name);
						$header_top_right_sidebar_visible = true;
						?>
						<?php
						endif;
						?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
			//Get menu object
			$locations = get_nav_menu_locations();
			if(isset($locations["main-menu"]))
			{
				$main_menu_object = get_term($locations["main-menu"], "nav_menu");
				if(has_nav_menu("main-menu") && $main_menu_object->count>0) 
				{
					$menu_container = ' ' . (isset($_COOKIE['pr_menu_container']) && $_COOKIE['pr_menu_container']!="" ? $_COOKIE['pr_menu_container'] : $theme_options['menu_container']);
					$menu_type = ' ' . (isset($_COOKIE['pr_menu_type']) && $_COOKIE['pr_menu_type']!="" ? $_COOKIE['pr_menu_type'] : ((int)$theme_options["sticky_menu"] ? 'sticky' : ''));
					?>
					<div class="menu_container<?php echo esc_attr($menu_container . $menu_type);?>">
						<a href="#" class="mobile-menu-switch">
							<span class="line"></span>
							<span class="line"></span>
							<span class="line"></span>
						</a>
						<div class="mobile-menu-divider"></div>
					<?php
					wp_nav_menu(array(
						"container" => "nav",
						"container_class" => "ubermenu clearfix",
						"theme_location" => "main-menu",
						"menu_class" => "sf-menu ubermenu-nav"/*,
						"walker" => new Walker_Test()*/
					));
					?>
						<div class="addthis_default_style addthis_32x32_style addthis_toolbox">
							<a addthis:userid="caninomag" class="addthis_button_facebook_follow at300b" href="http://www.facebook.com/caninomag" target="_blank" title="Follow on Facebook">
								<span class="at4-icon at-icon-wrapper" style="background-color: rgb(59, 89, 152);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Facebook" alt="Facebook" class="at4-icon at-icon at-icon-facebook"><g><path d="M21 6.144C20.656 6.096 19.472 6 18.097 6c-2.877 0-4.85 1.66-4.85 4.7v2.62H10v3.557h3.247V26h3.895v-9.123h3.234l.497-3.557h-3.73v-2.272c0-1.022.292-1.73 1.858-1.73h2V6.143z" fill-rule="evenodd"></path></g></svg></span>
								<span class="addthis_follow_label"></span>
							</a>
							<a addthis:userid="caninomag" class="addthis_button_twitter_follow at300b" href="//twitter.com/caninomag" target="_blank" title="Tweet">
								<span class="at4-icon at-icon-wrapper" style="background-color: rgb(85, 172, 238);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Twitter" alt="Twitter" class="at4-icon at-icon at-icon-twitter"><g><path d="M26.67 9.38c-.78.35-1.63.58-2.51.69.9-.54 1.6-1.4 1.92-2.42-.85.5-1.78.87-2.78 1.06a4.38 4.38 0 0 0-7.57 3c0 .34.04.68.11 1-3.64-.18-6.86-1.93-9.02-4.57-.38.65-.59 1.4-.59 2.2 0 1.52.77 2.86 1.95 3.64-.72-.02-1.39-.22-1.98-.55v.06c0 2.12 1.51 3.89 3.51 4.29a4.37 4.37 0 0 1-1.97.07c.56 1.74 2.17 3 4.09 3.04a8.82 8.82 0 0 1-5.44 1.87c-.35 0-.7-.02-1.04-.06a12.43 12.43 0 0 0 6.71 1.97c8.05 0 12.45-6.67 12.45-12.45 0-.19-.01-.38-.01-.57.84-.62 1.58-1.39 2.17-2.27z"></path></g></svg></span>
								<span class="addthis_follow_label"></span>
							</a>
							<a addthis:userid="caninomag" class="addthis_button_instagram_follow at300b" href="http://instagram.com/caninomag" target="_blank" title="Follow on Instagram">
								<span class="at4-icon at-icon-wrapper" style="background-color: rgb(18, 86, 136);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Instagram" alt="Instagram" class="at4-icon at-icon at-icon-instagram"><g><path d="M22.96 22.21a.71.71 0 0 1-.714.716H9.72a.71.71 0 0 1-.716-.715v-7.593h1.652a5.127 5.127 0 0 0-.234 1.535c0 3 2.508 5.426 5.59 5.426 3.093 0 5.6-2.426 5.6-5.426 0-.527-.08-1.054-.233-1.535h1.58v7.594zm-3.327-6.245c0 1.933-1.617 3.504-3.62 3.504-1.993 0-3.61-1.572-3.61-3.505 0-1.934 1.617-3.504 3.61-3.504 2.003 0 3.62 1.57 3.62 3.505zm3.328-4.22a.81.81 0 0 1-.808.81h-2.04a.81.81 0 0 1-.807-.81V9.814a.81.81 0 0 1 .808-.81h2.04a.81.81 0 0 1 .808.81v1.933zM25 9.31A2.32 2.32 0 0 0 22.69 7H9.31A2.32 2.32 0 0 0 7 9.31v13.38A2.32 2.32 0 0 0 9.31 25h13.38A2.32 2.32 0 0 0 25 22.69V9.31z" fill-rule="evenodd"></path></g></svg></span>
								<span class="addthis_follow_label"></span>
							</a>
						</div>
					</div>
					<?php
					/*
					<div class="mobile_menu_container">
						<a href="#" class="mobile-menu-switch">
							<span class="line"></span>
							<span class="line"></span>
							<span class="line"></span>
						</a>
						<div class="mobile-menu-divider"></div>
					<?php
						wp_nav_menu(array(
							"container" => "nav",
							"container_class" => "ubermenu clearfix",
							"theme_location" => "main-menu",
							"menu_class" => "mobile-menu ubermenu-nav"/*,
							"walker" => new Walker_Test()*/
						/*));
					?>
					</div>
					<?php
					*/
				}
			}
			?>
		<!-- /Header -->
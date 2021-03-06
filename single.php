<?php get_header(); ?>
<div id="main-content" class="row">
	<div id="primary" class="column small-12 large-8">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
				<header class="post-header">
					<h1 class="post-title"><?php the_title(); ?> </h1>
					<ul class="post-details">
						<li class="post-category">
							<i class="fi-folder"></i> En <?php echo get_the_category_list( ', ' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></li>
						<li class="post-date"><i class="fi-clock"></i> <?php the_date(); ?></li>
						<li class="post-author"><i class="fi-pencil"></i> <?php the_author_link(); ?></li>
					</ul>
					<div class="post-image">
						<?php the_post_thumbnail( 'single-post-thumb' ); ?>
					</div>
				</header>
				<div class="row">
					<section id="post-content-<?php the_ID(); ?>" class="post-content large-10 small-12 column medium-order-2">
						<?php if ( post_password_required() ) : ?>
							<?php add_filter( 'post_password_required', '__return_false' ); ?>
							<h4 class="post-excerpt"><?php canino_the_post_teaser(); ?></h4>
							<?php echo get_the_password_form(); //phpcs:ignore ?>
							<?php add_filter( 'post_password_required', '__return_true' ); ?>
						<?php else : ?>
							<h4 class="post-excerpt"><?php canino_the_post_teaser(); ?></h4>
							<?php canino_the_post_content(); ?>
						<?php endif; ?>
					</section>
					<div id="post-bottom-<?php the_ID(); ?>"></div>
					<footer class="post-footer large-2 column medium-order-1" data-sticky-container>
						<div class="sticky" data-sticky data-top-anchor="post-content-<?php the_ID(); ?>:top" data-btm-anchor="post-bottom-<?php the_ID(); ?>:bottom">
							<div class="post-banner-author-avatar">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 110 ); ?>
								<h3 class="text-center"><?php the_author_posts_link(); ?></h3>
								<?php if ( get_the_author_meta( 'twitter' ) ) : ?>
									<div class="btn-twitter">
										<a href="https://twitter.com/<?php echo esc_attr( get_the_author_meta( 'twitter' ) ); ?>">
											<p>
												<strong>@<?php echo esc_html( get_the_author_meta( 'twitter' ) ); ?></strong>
											</p>
										</a>
									</div>
								<?php endif; ?>
							</div>
							<?php if ( function_exists( 'sharing_display' ) ) : ?>
								<div class="post-sharing text-center">
									<?php echo sharing_display();//phpcs:ignore ?>
								</div>
							<?php endif; ?>
							<div class="post-tags">
								<h3>Etiquetas</h3>
								<?php the_tags( '<span class="post-tag">', '</span><span class="post-tag">', '</span>' ); ?>
							</div>
						</div>
					</footer>
				</div>
			</article>

			<h2 class="canino-section-title">Publicidad</h2>
			<div class="hide-for-large">
				<?php canino_ad_banner( 'small' ); ?>
			</div>
			<div class="show-for-large">
				<?php canino_ad_banner(); ?>
			</div>


			<?php if ( function_exists( 'rp4wp_children' ) ) : ?>
				<?php rp4wp_children(); ?>
		<?php endif; ?>

			<?php if ( function_exists( 'mc4wp_show_form' ) ) : ?>
				<?php mc4wp_show_form( 25814 ); ?>
		<?php endif; ?>

		<?php endwhile; ?>

		<?php if ( comments_open() || get_comments_number() ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>
	</div>

	<div id="secondary" class="column small-12 large-4">
		<?php get_template_part( 'parts/critica-box' ); ?>
		<?php get_sidebar( 'cabecera-arriba-del-to' ); ?>
	</div>
</div>


<?php get_footer(); ?>

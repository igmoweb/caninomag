<?php get_header(); ?>
<div id="main-content" class="row">
	<div id="primary" class="column small-12 large-8">
		<?php while ( have_posts() ): the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
				<header class="post-header">
					<h1 class="post-title"><?php the_title(); ?> </h1>
					<ul class="post-details">
						<li class="post-category"><i class="fi-folder"></i> En <?php echo get_the_category_list( ', ' ); ?></li>
						<li class="post-date"><i class="fi-clock"></i> <?php the_date(); ?></li>
						<li class="post-author"><i class="fi-pencil"></i> <?php the_author_link(); ?></li>
						<li class="post-comments-count"><i class="fi-comment"></i> <a href="#comments"><?php printf( _n( '%d Comentario', '%d Comentarios', get_comments_number_text() ), get_comments_number_text() ); ?></a></li>
					</ul>
					<div class="post-image">
						<?php the_post_thumbnail( 'single-post-thumb' ); ?>
					</div>
					<ul class="post-details">
					</ul>
				</header>
				<div class="row">
					<section id="post-content-<?php the_ID(); ?>" class="post-content large-10 small-12 column medium-order-2">
						<h4 class="post-excerpt"><?php the_excerpt(); ?></h4>
						<?php the_content( null, true ); ?>
					</section>
					<footer class="post-footer large-2 column medium-order-1" data-sticky-container>
						<div class="sticky" data-sticky data-anchor="post-content-<?php the_ID(); ?>">
							<div class="post-banner-author-avatar">
								<?php echo get_avatar( get_the_author_meta('ID'), 100 ); ?>
							</div>
							<div class="post-banner-author">
								<h3 class="text-center"><?php the_author_posts_link(); ?></h3>
							</div>
							<?php if ( $twitter = get_the_author_meta( 'twitter' ) ): ?>
								<div class="btn-twitter">
									<a href="https://twitter.com/<?php echo esc_attr( $twitter ); ?>">
										<p><i class="fi-social-twitter"></i></p>
										<p>Seguir en Twitter</p>
										<p><strong>@<?php echo $twitter; ?></strong></p>
									</a>
								</div>
							<?php endif; ?>
							<?php if ( function_exists( 'sharing_display' ) ): ?>
								<div class="post-sharing text-center">
									<?php echo sharing_display(); ?>
								</div>
							<?php endif; ?>
							<hr class="small">
							<div class="post-tags">
								<p><small>Etiquetas</small></p>
								<?php the_tags( '<span class="post-tag">', '</span><span class="post-tag">', '</span>' ); ?>
							</div>
						</div>
					</footer>
				</div>
			</article>

			<?php if ( function_exists( 'rp4wp_children' ) ): ?>
				<?php rp4wp_children(); ?>
			<?php endif; ?>

			<?php if ( function_exists( 'mc4wp_show_form' ) ): ?>
				<?php mc4wp_show_form(25814); ?>
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

<?php if ( canino_is_critica_post() ): ?>
	<div class="canino-critica">
		<?php foreach ( canino_get_critica_fields() as $area => $fields ): ?>
			<?php foreach ( $fields as $key => $atts ): ?>
				<?php
					$value = canino_get_critica_field( $key );
					if ( empty( $value ) ) {
						continue;
					}
				?>
				<?php if ( 'titulo' === $key ): ?>
					<h3><?php echo esc_html( $value ); ?></h3>
				<?php elseif ( 'portada' === $key ): ?>
					<div><?php echo wp_get_attachment_image( $value, 'full' ); ?></div>
				<?php else: ?>
					<div>
						<?php if ( $atts['label'] && $atts['show-label'] ): ?>
							<strong><?php echo $atts['label']; ?></strong>:
						<?php endif; ?>
						<?php echo $value; ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

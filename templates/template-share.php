<?php
/**
 * Template: Share
 *
 * @package Recipes WordPress Theme
 */

$share_links = mytheme_share();
?>

<?php if ( $share_links ) : ?>
	<div class="rcps-details-cell">
		<h4 class="rcps-details-title">
			<?php if ( $share_links ) : ?>
				<?php esc_html_e( 'Share', 'recipes' ); ?>
			<?php endif; ?>
			<?php if ( $share_links && array_key_exists( 'print', $share_links ) ) : ?>
				&amp;
			<?php endif; ?>
			<?php if ( array_key_exists( 'print', $share_links ) ) : ?>
				<?php esc_html_e( 'Print', 'recipes' ); ?>
			<?php endif; ?>
		</h4>

		<ul class="rcps-list-social rcps-list-social-share">
			<?php foreach ( $share_links as $service => $share_url ) : ?>
				<?php if ( 'print' !== $service ) : ?>
					<li><a href="<?php echo esc_url( $share_url ); ?>" class="rcps-share-link rcps-social-<?php echo esc_attr( $service ); ?>" target="_blank" rel="noopener"><svg class="rcps-icon"><use xlink:href="<?php echo esc_url( get_template_directory_uri() . '/images/icons.svg#icon-' . $service ); ?>"/></svg><span class="screen-reader-text"><?php echo esc_html( ucfirst( $service ) ); ?></span></a></li>
				<?php elseif ( 'print' === $service ) : ?>
					<li><a href="javascript:window.print()" class="rcps-social-print"><svg class="rcps-icon"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-print"/></svg><span class="screen-reader-text"><?php esc_html_e( 'Print', 'recipes' ); ?></span></a></li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul><!-- .rcps-share -->
	</div>
<?php endif; ?>

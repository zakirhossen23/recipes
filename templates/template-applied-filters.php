<?php
/**
 * Template-applied-filters.php.
 *
 * @package Recipes WordPress Theme
 */

$applied_filters = rcps_get_applied_filters();
?>

<?php if ( ! empty( $applied_filters ) ) : ?>
	<div class="rcps-section-applied-filters">
		<div class="rcps-inner">
			<h3 class="screen-reader-text"><?php esc_html_e( 'Applied filters', 'recipes' ); ?></h3>

			<div class="rcps-buttons">
				<?php foreach ( $applied_filters as $key => $filter ) : ?>
					<a href="<?php echo esc_url( $filter->url ); ?>" class="rcps-btn rcps-btn-small" rel="nofollow">
						<?php // Translators: %1$s: taxonomy name, %2$s: filter value. ?>
						<?php printf( esc_html__( '%1$s: %2$s', 'recipes' ), esc_html( $filter->filter_title ), esc_html( $filter->name ) ); ?>
						<svg class="rcps-icon rcps-icon-small rcps-icon-btn"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-close"/></svg>
					</a>
				<?php endforeach; ?>

				<?php // If there are more than 2 filters applied, display a button to reset all filters. ?>
				<?php if ( count( $applied_filters ) > 2 ) : ?>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'recipe' ) ); ?>" class="rcps-btn rcps-btn-small">
						<?php esc_html_e( 'Clear all', 'recipes' ); ?>
						<svg class="rcps-icon rcps-icon-small rcps-icon-btn"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-close"/></svg>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

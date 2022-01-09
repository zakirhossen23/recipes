<?php
/**
 * Template: Recipe Grid
 *
 * @package Recipes WordPress Theme
 */

?>

<div class="rcps-section-content">
	<div class="rcps-inner">
		<?php if ( is_active_sidebar( 'rcps-recipe-grid-widgets-top' ) ) : ?>
			<?php dynamic_sidebar( 'rcps-recipe-grid-widgets-top' ); ?>
		<?php endif; ?>

			<?php if ( $wp_query->have_posts() ) : ?>
				<div class="rcps-recipe-grid rcps-ajax-target-loadmore">
					<?php while ( $wp_query->have_posts() ) : ?>
						<?php $wp_query->the_post(); ?>
						<?php get_template_part( 'templates/template', 'recipe' ); ?>
					<?php endwhile; ?>

				</div><!-- .rcps-recipe-grid -->

				<?php if ( $wp_query->max_num_pages > 1 ) : ?>
					<div class="rcps-load-more-posts-wrap">
						<button class="rcps-btn rcps-btn-big rcps-ajax-load-more-button"><?php esc_html_e( 'Load more', 'recipes' ); ?></button>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php $alert = rcps_get_recipe_grid_alert_message(); ?>
			<?php if ( ! empty( $alert ) ) : ?>
				<div class="rcps-single-content">
					<p class="rcps-alert rcps-alert-yellow"><?php echo esc_html( $alert ); ?></p>
				</div><!-- .rcps-single-content -->
			<?php endif; ?>

		<?php if ( is_active_sidebar( 'rcps-recipe-grid-widgets-bottom' ) ) : ?>
			<?php dynamic_sidebar( 'rcps-recipe-grid-widgets-bottom' ); ?>
		<?php endif; ?>
	</div><!-- .rcps-inner -->

	<?php mytheme_page_navi( 'rcps-pages-recipes' ); ?>

	<?php wp_reset_postdata(); ?>
</div><!-- .rcps-section-content -->

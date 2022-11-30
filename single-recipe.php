<?php

/**
 * Single-recipe.php
 *
 * @package Recipes WordPress Theme
 */

get_header(); ?>

<div class="rcps-title-header rcps-text-center">
	<a href="<?php echo esc_url(get_post_type_archive_link('recipe')); ?>" class="rcps-h1"><?php esc_html_e('Recipes', 'recipes'); ?></a>
</div>

<?php while (have_posts()) : ?>
	<?php the_post(); ?>
	<div <?php post_class(); ?>>
		<div class="rcps-section-content">
			<div class="rcps-inner">
				<div class="rcps-single-content">
					<h1 class="rcps-post-title"><?php the_title(); ?></h1>
					<div style="text-align: center;">
						<span>
							Recipe Source:
						</span>
						<?php $sourceurl = "  " .get_post_meta(get_the_ID(), 'source_url', true);

						if (str_contains($sourceurl, "https://")) { ?>
							<a href="<?php echo $sourceurl ?>"><?php echo $sourceurl ?></a>
						<?php } else { ?>
							<a><?php echo $sourceurl ?></a>
						<?php }
						?>

					</div>


					<?php $servings = get_post_meta(get_the_ID(), 'custom_meta_servings', true); ?>
					<div>
						<h6 style="font-weight: bold;text-align: center;">Servings: <?php echo absint($servings); ?></h6>
						<div id="files">

						</div>
					</div>

					<?php if (in_array('single_recipe', get_theme_mod('show_author_in', array('single_recipe')), true)) : ?>
						<?php get_template_part('templates/template', 'author'); ?>
					<?php endif; ?>

					<?php if (has_post_thumbnail() && rcps_show_featured_image()) : ?>
						<figure class="wp-block-image alignfull size-large">
							<?php
							the_post_thumbnail(
								'img-1140',
								array(
									'loading' => 'eager',
									'alt'     => get_the_title(),
								)
							);
							?>
						</figure>
					<?php endif; ?>

					<?php get_template_part('templates/template', 'user-actions'); ?>

					<div class="rcps-instructions">
						<?php the_content(); ?>
					</div>

					<?php
					wp_link_pages(array(
						'before' => '<p class="rcps-pages">' . __('Pages:', 'recipes'),
						'after'  => '</p>',
					));
					?>

					<?php if (rcps_has_any_term()) : ?>
						<div class="rcps-details rcps-hide-on-print">
							<?php get_template_part('templates/template', 'recipe-terms'); ?>

							<?php get_template_part('templates/template', 'share'); ?>
						</div><!-- .rcps-details -->
					<?php endif; ?>

					<div class="rcps-details rcps-hide-on-print">
						<?php if (mytheme_get_option('enable_ratings')) : ?>
							<div class="rcps-details-cell">
								<h4 class="rcps-details-title"><?php esc_html_e('Rate', 'recipes'); ?></h4>

								<?php mytheme_the_post_vote_buttons(get_the_ID()); ?>

								<?php mytheme_votes_percent(array('location' => 'single')); ?>
							</div>
						<?php endif; ?>

						<?php if (class_exists('Favorites')) : ?>
							<div class="rcps-details-cell">
								<h4 class="rcps-details-title"><?php esc_html_e('Favorite', 'recipes'); ?></h4>

								<div class="rcps-single-favorite">
									<?php mytheme_favorites_button(); ?>
								</div>
							</div>
						<?php endif; ?>
					</div><!-- .rcps-details -->

					<?php mytheme_page_navi_thumbnails(); ?>
				</div><!-- .rcps-single-content -->

				<?php if (is_active_sidebar('rcps-single-recipe-widgets-bottom')) : ?>
					<?php dynamic_sidebar('rcps-single-recipe-widgets-bottom'); ?>
				<?php endif; ?>
			</div><!-- .rcps-inner -->
		</div><!-- .rcps-section-content -->

		<?php comments_template(); ?>

		<?php if (is_active_sidebar('rcps-single-recipe-widgets-after-comments')) : ?>
			<?php dynamic_sidebar('rcps-single-recipe-widgets-after-comments'); ?>
		<?php endif; ?>
	</div>
<?php endwhile; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
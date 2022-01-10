<?php

/**
 * Template: Recipe Small
 *
 * @package Recipes WordPress Theme
 */

?>

<div class="rcps-widget-item">
	<div class="rcps-widget-image">
		<a href="<?php echo esc_url(mytheme_get_recipe_url()); ?>" <?php echo (mytheme_is_external_recipe() && mytheme_get_option('link_external_recipes_to_source') ? 'target="_blank" rel="noopener"' : ''); ?>>
			<?php
			the_post_thumbnail(
				'img-96',
				array(
					'class' => 'rcps-widget-img lazyload',
					'alt'   => get_the_title(),
				)
			);
			?>
		</a>
	</div><!-- .rcps-widget-image -->

	<a href="<?php echo esc_url(mytheme_get_recipe_url()); ?>" <?php echo (mytheme_is_external_recipe() && mytheme_get_option('link_external_recipes_to_source') ? 'target="_blank" rel="noopener"' : ''); ?> class="rcps-widget-recipes-title"><?php the_title(); ?></a>

	<ul class="rcps-meta rcps-meta-widget">
		<?php if ('recipe' === get_post_type()) : ?>
			<?php if (mytheme_get_option('enable_ratings')) : ?>
				<?php
				$votes_percent = get_post_meta(get_the_ID(), 'custom_meta_votes_percent', true);
				if ('0' !== $votes_percent) :
					$meta_percent = absint(round($votes_percent, 0)) . '%';
				else :
					$meta_percent = esc_html__('No Votes', 'recipes');
				endif;
				?>

				<li class="meta-percent">
					<svg class="rcps-icon rcps-icon-meta">
						<use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons.svg#icon-thumbs-up" />
					</svg><?php echo esc_html($meta_percent); ?>
				</li>
			<?php endif; ?>

			<?php if (get_post_meta(get_the_ID(), 'custom_meta_external_url', true) && get_post_meta(get_the_ID(), 'custom_meta_external_site', true)) : ?>
				<li><svg class="rcps-icon rcps-icon-meta">
						<use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons.svg#icon-external-link-square" />
					</svg>
					<a href="<?php echo esc_url(get_post_meta(get_the_ID(), 'custom_meta_external_url', true)); ?>" target="_blank" rel="noopener"><?php echo esc_html(get_post_meta(get_the_ID(), 'custom_meta_external_site', true)); ?></a>
				</li>

				<?php if (mytheme_get_option('link_external_recipes_to_source')) : ?>
					<li>
						<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title(); ?>"><svg class="rcps-icon rcps-icon-meta">
								<use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons.svg#icon-link" />
							</svg><span class="screen-reader-text"><?php esc_html_e('Permalink', 'recipes'); ?></span></a>
					</li>
				<?php endif; ?>
			<?php endif; ?>

		<?php elseif ('post' === get_post_type()) : ?>

			<li>
				<svg class="rcps-icon rcps-icon-meta">
					<use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons.svg#icon-date" />
				</svg><?php echo get_the_date(); ?>
			</li>
		<?php endif; ?>
	</ul>
</div><!-- .rcps-widget-item -->
<?php

/**
 * Single.php
 *
 * @package Recipes WordPress Theme
 */

get_header(); ?>

<div class="rcps-title-header rcps-text-center">
	<a href="<?php echo esc_url((get_option('page_for_posts') ? get_permalink(get_option('page_for_posts')) : get_home_url())); ?>" class="rcps-h1"><?php esc_html_e('Blog', 'recipes'); ?></a>
</div>

<?php while (have_posts()) : ?>
	<?php the_post(); ?>
	<div <?php post_class(); ?>>
		<div class="rcps-section-content">
			<div class="rcps-inner">
				<div class="rcps-single-content">
					<h1 class="rcps-post-title"><?php the_title(); ?></h1>

					<?php if (in_array('single_blog_post', get_theme_mod('show_author_in', array('single_blog_post')), true)) : ?>
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

					<?php the_content(); ?>

					<?php
					wp_link_pages(array(
						'before' => '<p class="rcps-pages">' . __('Pages:', 'recipes'),
						'after'  => '</p>',
					));
					?>

					<?php if (has_category() || has_tag()) : ?>
						<div class="rcps-details">

							<div class="rcps-details-cell">
								<h4 class="rcps-details-title"><?php esc_html_e('Categories', 'recipes'); ?></h4>

								<ul class="rcps-details-categories">
									<?php echo get_the_term_list(get_the_ID(), 'category', '<li>', '</li> <li>', '</li>'); ?>
									<?php echo get_the_term_list(get_the_ID(), 'post_tag', '<li>', '</li> <li>', '</li>'); ?>
								</ul><!-- .rcps-details-categories -->
							</div>

							<?php get_template_part('templates/template', 'share'); ?>
						</div><!-- .rcps-details -->
					<?php endif; ?>

					<?php mytheme_page_navi_thumbnails(); ?>
				</div><!-- .rcps-single-content -->

				<?php if (is_active_sidebar('rcps-single-post-widgets-bottom')) : ?>
					<?php dynamic_sidebar('rcps-single-post-widgets-bottom'); ?>
				<?php endif; ?>
			</div><!-- .rcps-inner -->

			<?php comments_template(); ?>

			<?php if (is_active_sidebar('rcps-single-post-widgets-after-comments')) : ?>
				<?php dynamic_sidebar('rcps-single-post-widgets-after-comments'); ?>
			<?php endif; ?>
		</div><!-- .rcps-section-content -->
	</div><!-- .hentry -->
<?php endwhile; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
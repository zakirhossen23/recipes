<?php
/**
 * Index.php
 *
 * @package Recipes WordPress Theme
 */

get_header(); ?>

<div class="rcps-title-header rcps-text-center">
	<h1><?php esc_html_e( 'Blog', 'recipes' ); ?></h1>
</div>

<?php get_template_part( 'templates/template', 'blog-categories' ); ?>

<div class="rcps-section-content">
	<div class="rcps-inner">
		<?php if ( ! is_paged() ) : ?>
			<h2><?php esc_html_e( 'Latest blog posts', 'recipes' ); ?></h2>
		<?php endif; ?>

		<div class="rcps-recipe-grid">
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<?php get_template_part( 'templates/template', 'blog-post' ); ?>
			<?php endwhile; ?>
		</div>

		<?php mytheme_page_navi(); ?>
	</div><!-- .rcps-inner -->
</div><!-- .rcps-section-content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

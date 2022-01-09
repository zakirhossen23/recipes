<?php
/**
 * Search.php
 *
 * @package Recipes WordPress Theme
 */

get_header(); ?>

<div class="rcps-title-header rcps-text-center">
	<h1><?php esc_html_e( 'Searching for', 'recipes' ); ?>: <?php printf( get_search_query() ); ?></h1>
</div>

<div class="rcps-section-content">
	<div class="rcps-inner">
		<?php if ( have_posts() ) : ?>
			<div class="rcps-recipe-grid">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<?php get_template_part( 'templates/template', 'blog-post' ); ?>
				<?php endwhile; ?>
			</div>

		<?php else : ?>
			<div class="rcps-single-content">
				<p class="rcps-alert rcps-alert-yellow"><?php esc_html_e( 'Sorry, but nothing matched your search criteria.', 'recipes' ); ?></p>
			</div><!-- .rcps-single-content -->
		<?php endif; ?>

		<?php mytheme_page_navi(); ?>
	</div><!-- .rcps-inner -->
</div><!-- .rcps-section-content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

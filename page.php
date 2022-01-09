<?php
/**
 * Page.php
 *
 * @package Recipes WordPress Theme
 */

get_header(); ?>

<div class="rcps-title-header rcps-text-center">
	<h1><?php the_title(); ?></h1>
</div>

<div class="rcps-section-content">
	<div class="rcps-inner">
		<div class="rcps-single-content">
			<div <?php post_class(); ?>>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>

					<?php the_content(); ?>

					<?php
					wp_link_pages( array(
						'before' => '<p class="rcps-pages">' . __( 'Pages:', 'recipes' ),
						'after'  => '</p>',
					) );
					?>
				<?php endwhile; ?>
			</div><!-- .hentry -->
		</div><!-- .rcps-single-content -->
	</div><!-- .rcps-inner -->

	<?php comments_template(); ?>
</div><!-- .rcps-section-content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

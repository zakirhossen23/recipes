<?php
/**
 * 404.php
 *
 * @package Recipes WordPress Theme
 */

get_header(); ?>

<div class="rcps-title-header rcps-text-center">
	<h1><?php esc_html_e( 'Not Found', 'recipes' ); ?></h1>
</div>

<div class="rcps-section-content">
	<div class="rcps-inner">
		<div class="rcps-single-content">
			<p class="rcps-alert rcps-alert-yellow"><?php esc_html_e( 'Apologies, but the page you requested could not be found.', 'recipes' ); ?></p>

			<?php
			$args = array(
				'post_type'              => 'recipe',
				'posts_per_page'         => 10,
				'orderby'                => 'post_date',
				'order'                  => 'DESC',
				'post_status'            => 'publish',
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			);

			$wp_query_recipes = new WP_Query( $args );
			?>

			<?php if ( $wp_query_recipes->have_posts() ) : ?>
				<h2><?php esc_html_e( 'Recent Recipes', 'recipes' ); ?></h2>

				<ul>
					<?php while ( $wp_query_recipes->have_posts() ) : ?>
						<?php $wp_query_recipes->the_post(); ?>
						<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
		</div><!-- .rcps-single-content -->
	</div><!-- .rcps-inner -->
</div><!-- .rcps-section-content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

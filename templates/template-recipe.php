<?php
/**
 * Template: Recipe
 *
 * @package Recipes WordPress Theme
 */

?>
<div class="rcps-item-wrap rcps-item-wrap-recipe">
	<article class="rcps-item <?php echo ( mytheme_is_external_recipe() ? 'rcps-item-external' : '' ); ?>">
		<div class="rcps-item-featured-img">
			<a href="<?php echo esc_url( mytheme_get_recipe_url() ); ?>" <?php echo ( mytheme_is_external_recipe() && mytheme_get_option( 'link_external_recipes_to_source' ) ? 'target="_blank" rel="noopener"' : '' ); ?>>
				<?php
				the_post_thumbnail(
				'img-560',
				array(
					'class' => 'lazyload',
					'alt'   => get_the_title(), 
				) );
				?>

				<?php if ( mytheme_get_option( 'enable_ratings' ) ) : ?>
					<?php
					$star_icon_color = get_theme_mod( 'color_star_rating', '#dbc164' );

					$css_class = '';
					if ( ! empty( $star_icon_color ) ) {
						$css_class = mytheme_get_contrast( $star_icon_color, 'rcps-item-rating-light', '' );
					}
					?>
					<div class="rcps-item-rating <?php echo sanitize_html_class( $css_class ); ?>">
						<?php mytheme_votes_percent( array( 'location' => 'card' ) ); ?>
					</div><!-- .rcps-item-rating -->
				<?php endif; ?>

				<?php $video_url = get_post_meta( get_the_ID(), '_rcps_meta_video_url', true ); ?>
				<?php if ( ! empty( $video_url ) || class_exists( 'Favorites' ) ) : ?>
					<div class="rcps-item-top">
						<?php if ( ! empty( $video_url ) ) : ?>
							<div class="rcps-item-top-left">
								<svg class="rcps-icon rcps-icon-white"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-video-play"/></svg>
							</div>
						<?php endif; ?>

						<?php if ( class_exists( 'Favorites' ) ) : ?>
							<div class="rcps-item-top-right">
								<?php mytheme_favorites_button(); ?>
							</div>
						<?php endif; ?>
					</div><!-- .rcps-item-top -->
				<?php endif; ?>
			</a>
		</div><!-- .rcps-item-featured-img -->

		<?php if ( in_array( 'recipe_card', get_theme_mod( 'show_author_in', array( 'recipe_card', 'blog_post_card' ) ), true ) ) : ?>
			<div class="rcps-item-author">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php echo wp_kses_post( rcps_user_avatar( get_the_author_meta( 'ID' ), 'img-64', 24, 'rcps-img-inline rcps-img-inline-left lazyload' ) ); ?><?php the_author(); ?>
				</a>
		
			</div>
		<?php endif; ?>

		<?php $taxonomies_on_card = get_theme_mod( 'tax_on_card_array', array( 'course' ) ); ?>
		<?php if ( is_array( $taxonomies_on_card ) && ! empty( $taxonomies_on_card[0] ) ) : ?>
			<?php $post_terms = wp_get_post_terms( get_the_ID(), $taxonomies_on_card, array( 'orderby' => 'term_group' ) ); ?>
			<?php if ( ! is_wp_error( $post_terms ) && ! empty( $post_terms ) ) : ?>
				<div class="rcps-item-tax">
					<?php foreach ( $post_terms as $post_term ) : ?>
						<a href="<?php echo esc_url( get_term_link( $post_term ) ); ?>"><?php echo esc_html( $post_term->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="rcps-item-tax">&nbsp;</div>
			<?php endif; ?>
		<?php endif; ?>

		<h3 class="rcps-item-title"><a href="<?php echo esc_url( mytheme_get_recipe_url() ); ?>" <?php echo ( mytheme_is_external_recipe() && mytheme_get_option( 'link_external_recipes_to_source' ) ? 'target="_blank" rel="noopener"' : '' ); ?>><?php the_title(); ?></a></h3>

		<?php get_template_part( 'templates/template', 'recipe-card-meta' ); ?>
	</article>
</div><!-- .rcps-item-recipe-wrap -->

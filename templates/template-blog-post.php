<?php
/**
 * Template: Blog Post
 *
 * @package Recipes WordPress Theme
 */

?>

<div class="rcps-item-wrap rcps-item-wrap-big rcps-item-wrap-post">
	<article class="rcps-item rcps-item-big">
		<div class="rcps-item-featured-img">
			<a href="<?php the_permalink(); ?>">
				<?php
				the_post_thumbnail( 'img-560',
				array(
					'class' => 'lazyload',
					'alt'   => get_the_title(),
				) );
				?>

				<?php $video_url = get_post_meta( get_the_ID(), '_rcps_meta_video_url', true ); ?>
				<?php if ( ! empty( $video_url ) ) : ?>
					<div class="rcps-item-top">
						<?php if ( ! empty( $video_url ) ) : ?>
							<div class="rcps-item-top-left">
								<svg class="rcps-icon rcps-icon-white"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-video-play"/></svg>
							</div>
						<?php endif; ?>
					</div><!-- .rcps-item-top -->
				<?php endif; ?>
			</a>
		</div><!-- .rcps-item-featured-img -->

		<?php if ( in_array( 'blog_post_card', get_theme_mod( 'show_author_in', array( 'recipe_card', 'blog_post_card' ) ), true ) ) : ?>
			<div class="rcps-item-author">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php echo wp_kses_post( rcps_user_avatar( get_the_author_meta( 'ID' ), 'img-64', 32, 'rcps-img-inline rcps-img-inline-left lazyload' ) ); ?><?php the_author(); ?>
				</a>
			</div>
		<?php endif; ?>

		<?php echo get_the_term_list( get_the_ID(), 'category', '<div class="rcps-item-tax">', ', ', '</div>' ); ?>

		<h3 class="rcps-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<ul class="rcps-meta rcps-meta-item">
			<li>
				<svg class="rcps-icon rcps-icon-meta"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-date"/></svg><?php echo get_the_date(); ?>
			</li>
		</ul>
	</article>
</div><!-- .rcps-item-recipe-wrap -->

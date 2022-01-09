<?php
/**
 * Template: User
 *
 * @package Recipes WordPress Theme
 */

global $list_user;
$user_recipe_count = count_user_posts( $list_user->ID, 'recipe' );
$user_post_count   = count_user_posts( $list_user->ID, 'post' );

if ( $user_recipe_count >= 1 ) {
	// Translators: %d is the number of recipes by the user.
	$recipes_published = sprintf( esc_html( _n( '%d recipe', '%d recipes', $user_recipe_count, 'recipes' ) ), absint( $user_recipe_count ) );
} else {
	$recipes_published = __( 'No recipes', 'recipes' );
}

if ( $user_post_count >= 1 ) {
	// Translators: %d is the number of posts by the user.
	$posts_published = sprintf( esc_html( _n( '%d blog post', '%d blog posts', $user_post_count, 'recipes' ) ), absint( $user_post_count ) );
}
?>

<div class="rcps-item-wrap rcps-item-wrap-big rcps-item-wrap-user">
	<a href="<?php echo esc_url( get_author_posts_url( $list_user->ID ) ); ?>" class="rcps-item rcps-item-big rcps-item-user">
		<?php if ( function_exists( 'rcps_user_avatar' ) ) : ?>
			<div class="rcps-item-user-avatar">
				<?php echo wp_kses_post( rcps_user_avatar( $list_user->ID, 'img-96', 60, 'lazyload' ) ); ?>
			</div>
		<?php endif; ?>

		<h3 class="rcps-item-title"><?php the_author_meta( 'display_name', $list_user->ID ); ?></h3>

		<ul class="rcps-meta rcps-meta-item">
			<li>
				<svg class="rcps-icon rcps-icon-meta"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-collection"/></svg><?php echo esc_html( $recipes_published ); ?>
			</li>

			<?php if ( $user_post_count >= 1 ) : ?>
				<li>
					<svg class="rcps-icon rcps-icon-meta"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-collection"/></svg><?php echo esc_html( $posts_published ); ?>
				</li>
			<?php endif; ?>
		</ul>
	</a>
</div>

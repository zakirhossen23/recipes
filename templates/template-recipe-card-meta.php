<?php
/**
 * Template: Recipe Card Meta
 *
 * @package Recipes WordPress Theme
 */

$displayed_meta_fields = get_theme_mod( 'displayed_meta_fields_recipe_card', array( 'total_time', 'ingredients_number', 'external_site_title', 'permalink' ) );

	
if ( empty( $displayed_meta_fields ) ) {
	return;
}
?>

<ul class="rcps-meta rcps-meta-item">
	<?php if ( mytheme_is_external_recipe() ) : ?>

		<?php if ( in_array( 'permalink', $displayed_meta_fields, true ) && mytheme_get_option( 'link_external_recipes_to_source' ) ) : ?>
			<li><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>"><svg class="rcps-icon rcps-icon-meta"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-link"/></svg><?php esc_html_e( 'Permalink', 'recipes' ); ?></a></li>
		<?php endif; ?>

		<?php if ( in_array( 'external_site_title', $displayed_meta_fields, true ) ) : ?>
			<li><a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'custom_meta_external_url', true ) ); ?>" target="_blank" rel="noopener"><svg class="rcps-icon rcps-icon-meta"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-external-link-square"/></svg><?php echo esc_html( get_post_meta( get_the_ID(), 'custom_meta_external_site', true ) ); ?></a></li>
		<?php endif; ?>

	<?php else : ?>

		<?php if ( in_array( 'total_time', $displayed_meta_fields, true ) ) : ?>
			<?php $total_time = get_post_meta( get_the_ID(), 'custom_meta_total_time', true ); ?>
			<?php if ( is_numeric( $total_time ) && 0 < $total_time ) : ?>
				<li>
					<svg class="rcps-icon rcps-icon-meta"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-clock"/></svg><?php mytheme_minutes_to_hr_min( $total_time ); ?>
				</li>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( in_array( 'ingredients_number', $displayed_meta_fields, true ) ) : ?>
			<?php $ingredients_number = get_post_meta( get_the_ID(), 'custom_meta_ingredients_number', true ); ?>
			<?php if ( $ingredients_number >= 1 ) : ?>
				<li>
					<svg class="rcps-icon rcps-icon-meta"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-spoon"/></svg><?php echo absint( $ingredients_number ); ?> <?php echo esc_html( _n( 'ingredient', 'ingredients', $ingredients_number, 'recipes' ) ); ?>
				</li>
			<?php endif; ?>
		<?php endif; ?>

	<?php endif; ?>

	<?php if ( in_array( 'views', $displayed_meta_fields, true ) && class_exists( 'WP_Widget_PostViews' ) ) : ?>
		<li>
			<?php // Translators: %d is the number of views. ?>
			<svg class="rcps-icon rcps-icon-meta"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-eye"/></svg><?php printf( esc_html__( '%d views', 'recipes' ), absint( $post->views ) ); ?>
		</li>
	<?php endif; ?>

	<?php if ( in_array( 'date', $displayed_meta_fields, true ) ) : ?>
		<li>
			<svg class="rcps-icon rcps-icon-meta"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-date"/></svg><?php echo get_the_date(); ?>
		</li>
	<?php endif; ?>

	<?php if ( in_array( 'comments', $displayed_meta_fields, true ) ) : ?>
		<li>
			<svg class="rcps-icon rcps-icon-meta"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-comments"/></svg><?php echo absint( get_comments_number() ); ?>
		</li>
	<?php endif; ?>
</ul>

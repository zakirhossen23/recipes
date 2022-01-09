<?php
/**
 * Template: Amp-meta
 *
 * @package Recipes WordPress Theme
 */

$servings            = get_post_meta( $post->ID, 'custom_meta_servings', true );
$calories_in_serving = absint( get_post_meta( $post->ID, 'custom_meta_calories_in_serving', true ) );
$prep_time           = absint( get_post_meta( $post->ID, 'custom_meta_prep_time', true ) );
$cook_time           = absint( get_post_meta( $post->ID, 'custom_meta_cook_time', true ) );
?>

<?php if ( ! empty( $servings ) ) : ?>
	<b><?php esc_html_e( 'Servings', 'recipes' ); ?></b>
	<?php echo absint( $servings ); ?> &bull;
<?php endif; ?>

<?php if ( ! empty( $calories_in_serving ) ) : ?>
	<b><?php esc_html_e( 'Calories in serving', 'recipes' ); ?></b>
	<?php echo absint( $calories_in_serving ); ?> &bull;
<?php endif; ?>

<?php if ( ! empty( $prep_time ) ) : ?>
	<b><?php esc_html_e( 'Mise It!', 'recipes' ); ?></b>
	<?php mytheme_minutes_to_hr_min( $prep_time ); ?> &bull;
<?php endif; ?>

<?php if ( ! empty( $cook_time ) ) : ?>
	<b><?php esc_html_e( 'Make It!', 'recipes' ); ?></b>
	<?php mytheme_minutes_to_hr_min( $cook_time ); ?>
<?php endif; ?>

<?php if ( rcps_has_any_term() ) : ?>
	<br><b><?php esc_html_e( 'Categories', 'recipes' ); ?></b>
<?php endif; ?>

<?php $taxonomies = get_object_taxonomies( 'recipe', 'names' ); ?>

<?php foreach ( $taxonomies as $taxonomy_name ) : ?>
	<?php if ( has_term( '', $taxonomy_name ) ) : ?>
		<?php echo get_the_term_list( $post->ID, $taxonomy_name, '', ' ', ' ' ); ?>
	<?php endif; ?>
<?php endforeach; ?>

<?php

/**
 * Template: Recipe Card Meta
 *
 * @package Recipes WordPress Theme
 */

$displayed_meta_fields = get_theme_mod('displayed_meta_fields_recipe_card', array('total_time', 'ingredients_number', 'external_site_title', 'permalink'));


if (empty($displayed_meta_fields)) {
	return;
}
?>

<ul class="rcps-meta rcps-meta-item">

	<?php $ingredients_number = get_post_meta(get_the_ID(), 'custom_meta_ingredients_number', true); ?>

	<li>
		<div style="display: flex;">
			<img src="https://shopitmiseitmakeit.ca/wp-content/uploads/shop-gray.jpg" style="width: 29px;">
			<div style="line-height: 29px;padding: 0 5px;"><?php echo absint($ingredients_number); ?> Shop It!</div>
		</div>
	</li>
	<?php $miseit_number = get_post_meta(get_the_ID(), 'custom_meta_prep_time', true); ?>

	<li>
		<div style="display: flex;">
			<img src="https://shopitmiseitmakeit.ca/wp-content/uploads/miseit-gray.jpg" style="width: 29px;">
			<div style="line-height: 29px;padding: 0 5px;"><?php echo absint($miseit_number); ?> Mise It!</div>
		</div>
	</li>

	<?php $makeit_number = get_post_meta(get_the_ID(), 'custom_meta_cook_time', true); ?>

	<li>
		<div style="display: flex;">
			<img src="https://shopitmiseitmakeit.ca/wp-content/uploads/make-It-gray.jpg" style="width: 29px;">
			<div style="line-height: 29px;padding: 0 5px;"><?php echo absint($makeit_number); ?> Make It!</div>
		</div>
	</li>




	<?php if (in_array('views', $displayed_meta_fields, true) && class_exists('WP_Widget_PostViews')) : ?>
		<li>
			<?php // Translators: %d is the number of views. 
			?>
			<svg class="rcps-icon rcps-icon-meta">
				<use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons.svg#icon-eye" />
			</svg><?php printf(esc_html__('%d views', 'recipes'), absint($post->views)); ?>
		</li>
	<?php endif; ?>

	<?php if (in_array('date', $displayed_meta_fields, true)) : ?>
		<li>
			<svg class="rcps-icon rcps-icon-meta">
				<use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons.svg#icon-date" />
			</svg><?php echo get_the_date(); ?>
		</li>
	<?php endif; ?>

	<?php if (in_array('comments', $displayed_meta_fields, true)) : ?>
		<li>
			<svg class="rcps-icon rcps-icon-meta">
				<use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons.svg#icon-comments" />
			</svg><?php echo absint(get_comments_number()); ?>
		</li>
	<?php endif; ?>
</ul>
<?php

/**
 * Template: Recipe Meta
 *
 * @package Recipes WordPress Theme
 */

$nutrition_facts = rcps_get_nutrition_facts($post, $exclude = array('custom_meta_servings', 'custom_meta_calories_in_serving'));
?>

<div class="rcps-details">
	<?php if (empty($nutrition_facts)) : ?>
		<?php $servings = get_post_meta(get_the_ID(), 'custom_meta_servings', true); ?>
		<?php if ($servings) : ?>
			<div class="rcps-details-cell">
				<div style="width: 28%;">
					<h4 class="rcps-details-title">Servings</h4>
					<div style="width: 100%;text-align: center;"> <?php echo absint($servings); ?></div>
				</div>
			</div>
		<?php endif; ?>

		<?php $calories_in_serving = absint(get_post_meta(get_the_ID(), 'custom_meta_calories_in_serving', true)); ?>
		<?php if ($calories_in_serving) : ?>
			<div class="rcps-details-cell">
				<h4 class="rcps-details-title"><?php esc_html_e('Calories in serving', 'recipes'); ?></h4>
				<?php echo absint($calories_in_serving); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php $prep_time = absint(get_post_meta(get_the_ID(), 'custom_meta_prep_time', true)); ?>
	<?php if ($prep_time) : ?>
		<div class="rcps-details-cell">
			<div style="width: 24%;">
				<h4 class="rcps-details-title">Mise It!</h4>
				<div style="width: 100%;text-align: center;"> <?php echo absint($prep_time); ?></div>
			</div>
		</div>
	<?php endif; ?>

	<?php $cook_time = absint(get_post_meta(get_the_ID(), 'custom_meta_cook_time', true)); ?>
	<?php if ($cook_time) : ?>
		<div class="rcps-details-cell">
			<div style="width: 26%;">
				<h4 class="rcps-details-title">Make It!</h4>
				<div style="width: 100%;text-align: center;"> <?php echo absint($cook_time); ?></div>
			</div>
		</div>
	<?php endif; ?>
</div><!-- .rcps-details -->
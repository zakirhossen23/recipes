<?php
/**
 * Template: Nutrition facts
 *
 * @package Recipes WordPress Theme
 */

$nutrition_facts = rcps_get_nutrition_facts( $post, $exclude = array( 'custom_meta_servings', 'custom_meta_calories_in_serving' ) );
?>

<div class="rcps-nutrition-facts">
	<div class="rcps-nutrition-facts-header">
		<h3><?php esc_html_e( 'Nutrition Facts', 'recipes' ); ?></h3>

		<?php if ( $post->custom_meta_servings ) : ?>
			<?php // Translators: %s is the number of servings. ?>
			<p><?php printf( esc_html__( 'Serving Size: %s', 'recipes' ), esc_html( $post->custom_meta_servings ) ); ?></p>
		<?php endif; ?>

		<?php if ( $post->custom_meta_calories_in_serving ) : ?>
			<?php // Translators: %s is the number of calories per serving. ?>
			<p><?php printf( esc_html__( 'Calories Per Serving: %s', 'recipes' ), absint( $post->custom_meta_calories_in_serving ) ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $nutrition_facts ) ) : ?>
		<?php if ( 'on' === mytheme_get_option( 'show_daily_values' ) ) : ?>
			<div class="rcps-nutrition-facts-row-daily-value-title">
				<?php esc_html_e( '% Daily Value', 'recipes' ); ?>
			</div>
		<?php endif; ?>

		<div class="rcps-nutrition-facts-rows">
			<?php foreach ( $nutrition_facts as $value ) : ?>
				<div class="rcps-nutrition-facts-row">
					<span class="rcps-nutrition-facts-item"><?php echo esc_html( $value->name ); ?></span>
					<span class="rcps-nutrition-facts-item-amount <?php echo( 'on' !== mytheme_get_option( 'show_daily_values' ) ? 'rcps-nutrition-facts-item-right' : '' ); ?>">
						<?php // Translators: %1$s is nutrient name. %2$s is the amount of nutrient. ?>
						&#8207;<?php printf( esc_html_x( '%1$s%2$s', 'Nutrient amount and unit in the nutrient facts.', 'recipes' ), esc_html( $value->amount ), esc_html( $value->unit ) ); ?>
					</span>
					<?php if ( 'on' === mytheme_get_option( 'show_daily_values' ) && ! empty( $value->daily_value_percent ) ) : ?>
						<span class="rcps-nutrition-facts-item-right"><?php echo esc_html( $value->daily_value_percent ); ?></span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>

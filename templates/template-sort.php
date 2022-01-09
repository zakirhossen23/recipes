<?php
/**
 * Template: Sort
 *
 * @package Recipes WordPress Theme
 */

?>

<div class="rcps-section-sort">
	<div class="rcps-inner">
		<div class="rcps-sorting">
			<div class="rcps-sort-cell">
				<?php // Translators: %d is the number of recipes found. ?>
				<span class="rcps-sort-title"><?php printf( esc_html( _n( '%d recipe', '%d recipes', $wp_query->found_posts, 'recipes' ) ), absint( $wp_query->found_posts ) ); ?></span>
			</div>

			<div class="rcps-sort-cell">
				<?php mytheme_fav_toggle(); ?>
			</div>

			<div class="rcps-sort-cell">
				<?php $sort_args = mytheme_order_recipes_by(); ?>
				<?php if ( ! empty( $sort_args ) ) : ?>
					<label class="rcps-sort-title"><?php esc_html_e( 'Sort by', 'recipes' ); ?></label>

					<div class="rcps-dropdown rcps-dropdown-inline">
						<button type="button" class="rcps-btn rcps-btn-dropdown rcps-btn-has-dropdown rcps-mb0">
							<?php echo esc_html( $sort_args->current_sort_title ); ?>
						</button>

						<div class="rcps-dropdown-content">
							<?php foreach ( $sort_args->sorts as $key => $value ) : ?>
								<div class="rcps-dropdown-input-wrap">
									<input type="radio" name="sort" id="id-<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( $value->is_active, true, true ); ?>>
									<label for="id-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value->title ); ?></label>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div><!-- .rcps-sorting -->
	</div><!-- .rcps-inner -->
</div><!-- .rcps-section-sort -->

<?php
/**
 * Template: Recipe Terms
 *
 * @package Recipes WordPress Theme
 */

$taxonomies = mytheme_get_option( 'categories_on_recipe' );
?>

<?php if ( rcps_has_any_term() && ! empty( $taxonomies ) ) : ?>
	<div class="rcps-details-cell">
		<h4 class="rcps-details-title"><?php esc_html_e( 'Categories', 'recipes' ); ?></h4>

		<ul class="rcps-details-categories">
			<?php foreach ( $taxonomies as $taxonomy ) : ?>
				<?php if ( has_term( '', $taxonomy ) ) : ?>
					<?php echo get_the_term_list( get_the_ID(), $taxonomy, '<li>', '</li> <li>', '</li>' ); ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul><!-- .rcps-details-categories -->
	</div>
<?php endif; ?>

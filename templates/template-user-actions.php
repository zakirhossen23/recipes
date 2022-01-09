<?php
/**
 * Template: Recipe Actions
 *
 * @package Recipes WordPress Theme
 */

$edit_recipe_page_id = rcps_get_page_with_shortcode( 'rcps_edit_recipe' );
?>

<?php if ( is_user_logged_in() && get_current_user_id() === (int) $post->post_author ) : ?>
	<div class="rcps-user-actions">
		<?php if ( get_query_var( 'rcps_delete_recipe_id' ) && (int) get_query_var( 'rcps_delete_recipe_id' ) === get_the_ID() ) : ?>
			<p class="rcps-alert rcps-alert-red rcps-text-center">
				<?php esc_html_e( 'Are you sure you want to delete this recipe?', 'recipes' ); ?>

				<a href="<?php echo esc_url( add_query_arg( array( 'rcps_delete_recipe_confirm' => get_the_ID() ) ) ); ?>"><?php esc_html_e( 'Delete', 'recipes' ); ?></a>
				<a href="<?php echo esc_url( remove_query_arg( 'rcps_delete_recipe_id' ) ); ?>"><?php esc_html_e( 'Cancel', 'recipes' ); ?></a>
			</p>

		<?php else : ?>

			<p class="rcps-alert rcps-text-center">
				<?php esc_html_e( 'This is one of your recipes.', 'recipes' ); ?>

				<?php if ( $edit_recipe_page_id ) : ?>
					<a href="<?php echo esc_url( add_query_arg( array( 'rcps_edit_recipe_id' => get_the_ID() ), get_permalink( $edit_recipe_page_id ) ) ); ?>"><?php esc_html_e( 'Edit', 'recipes' ); ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_url( add_query_arg( array( 'rcps_delete_recipe_id' => get_the_ID() ) ) ); ?>"><?php esc_html_e( 'Delete', 'recipes' ); ?></a>
			</p>
		<?php endif; ?>
	</div>
<?php endif; ?>

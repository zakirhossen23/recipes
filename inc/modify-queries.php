<?php
/**
 * Modify-queries.php
 *
 * Modify post queries.
 *
 * @package Recipes WordPress Theme
 */

if ( ! function_exists( 'mytheme_add_query_vars_filter' ) ) {
	/**
	 * Add custom query vars.
	 *
	 * @param [array] $vars Query vars.
	 */
	function mytheme_add_query_vars_filter( $vars ) {
		$vars[] = 'sort';
		$vars[] = 'success';
		$vars[] = 'fav';
		$vars[] = 'rcps_edit_recipe_id';
		$vars[] = 'rcps_delete_recipe_id';
		$vars[] = 'rcps_delete_recipe_confirm';

		return $vars;
	}
}
add_filter( 'query_vars', 'mytheme_add_query_vars_filter' );

if ( ! function_exists( 'mytheme_pre_get_posts' ) ) {
	/**
	 * Modify post queries.
	 *
	 * @param [array] $query Query.
	 */
	function mytheme_pre_get_posts( $query ) {

		if ( is_admin() || ! $query->is_main_query() ) {
			return $query;
		}

		$post_type = get_query_var( 'post_type' );

		$taxonomies = get_object_taxonomies( 'recipe', 'names' );

		if ( is_post_type_archive( 'recipe' ) || is_tax( $taxonomies ) || is_author() || ( is_search() && 'recipe' === $post_type ) ) {

			$query->set( 'post_type', 'recipe' );
			$query->set( 'posts_per_page', get_theme_mod( 'recipes_per_page', 18 ) );
			$query->set( 'paged', ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1 );
			$query->set( 'page', ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );

			if ( get_query_var( 'sort' ) ) {
				if ( ! in_array( get_query_var( 'sort' ), array( 'title', 'date', 'rating', 'views', 'time', 'favorites' ), true ) ) {
					wp_die( esc_html__( 'Error.', 'recipes' ) );
				}

				if ( 'date' === get_query_var( 'sort' ) ) {
					$query->set( 'orderby', 'date' );
					$query->set( 'order', 'DESC' );
				}

				if ( 'title' === get_query_var( 'sort' ) ) {
					$query->set( 'orderby', 'title' );
					$query->set( 'order', 'ASC' );
				}

				if ( in_array( get_query_var( 'sort' ), array( 'rating', 'time', 'views', 'favorites' ), true ) ) {
					$query->set( 'orderby', 'meta_value_num' );
					$query->set( 'order', 'DESC' );
				}

				if ( 'rating' === get_query_var( 'sort' ) ) {
					$query->set( 'meta_key', 'custom_meta_votes_percent' );
				} elseif ( 'time' === get_query_var( 'sort' ) ) {
					$query->set( 'meta_key', 'custom_meta_total_time' );
				} elseif ( 'views' === get_query_var( 'sort' ) ) {
					$query->set( 'meta_key', 'views' );
				} elseif ( 'favorites' === get_query_var( 'sort' ) ) {
					$query->set( 'meta_key', 'simplefavorites_count' );
				}
			}

			if ( get_query_var( 'fav' ) && class_exists( 'Favorites' ) ) {
				if ( is_user_logged_in() && '1' === esc_attr( get_query_var( 'fav' ) ) ) {
					$query->set( 'post__in', get_user_favorites() );
				}
				if ( ! is_user_logged_in() || ! get_user_favorites_count() ) {
					// Returns no posts if user is not logged in or has no favorites.
					$query->set( 'post__in', array( '0' ) );
				}
			}
		}
	}
}
add_action( 'pre_get_posts', 'mytheme_pre_get_posts' );

if ( ! function_exists( 'mytheme_fav_toggle' ) ) {
	/**
	 * Displays a favorite checkbox.
	 */
	function mytheme_fav_toggle() {

		if ( class_exists( 'Favorites' ) && get_option( 'users_can_register' ) ) {
			$icon    = 'icon-heart-outlined';
			$checked = checked( get_query_var( 'fav' ), '1', false );
			if ( $checked ) {
				$icon = 'icon-heart';
			}
			?>
			<input id="fav-toggle" type="checkbox" name="fav" value="1" <?php checked( get_query_var( 'fav' ), '1' ); ?> class="rcps-input-checkbox" onchange="this.form.submit()">
			<label for="fav-toggle" class="rcps-sort-title rcps-input-label">
				<svg class="rcps-icon rcps-icon-heart"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#<?php echo esc_attr( $icon ); ?>"/></svg>
				<?php esc_html_e( 'Show only favorites', 'recipes' ); ?>
			</label>
			<?php
		}
	}
}

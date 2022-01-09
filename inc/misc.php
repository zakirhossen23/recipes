<?php
/**
 * Misc.php
 *
 * Miscellaneous functions used in the theme.
 *
 * @package Recipes WordPress Theme
 */

if ( ! function_exists( 'mytheme_share' ) ) {
	/**
	 * Returns share links.
	 */
	function mytheme_share() {

		$displayed_share_links = mytheme_get_option( 'displayed_share_links' );

		$image = '';
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'img-1140', true );

		$share_urls = array(
			'facebook'  => 'https://www.facebook.com/sharer.php?u=' . wp_get_shortlink(),
			'twitter'   => 'https://twitter.com/share?url=' . wp_get_shortlink() . '&text=' . rawurlencode( get_the_title() ),
			'pinterest' => 'https://pinterest.com/pin/create/button/?url=' . wp_get_shortlink() . '&media=' . $image[0] . '&description=' . rawurlencode( get_the_title() ),
			'print'     => 'javascript:window.print()',
		);

		$return = array();
		if ( ! empty( $displayed_share_links ) ) {
			foreach ( $share_urls as $service => $url ) {
				if ( in_array( $service, $displayed_share_links, true ) ) {
					$return[ $service ] = $url;
				}
			}
		}

		return $return;
	}
}

if ( ! function_exists( 'mytheme_users_social_links' ) ) {
	/**
	 * Returns array of user's social links.
	 *
	 * @param  [int] $user_id User ID.
	 * @return [array]
	 */
	function mytheme_users_social_links( $user_id ) {

		$services = array(
			'instagram' => 'custom_meta_instagramurl',
			'facebook'  => 'custom_meta_facebookurl',
			'twitter'   => 'custom_meta_twitterurl',
			'pinterest' => 'custom_meta_pinteresturl',
			'youtube'   => 'custom_meta_youtubeurl',
			'home'      => 'user_url',
		);

		$return = array();

		foreach ( $services as $service => $url ) {
			$url = get_the_author_meta( $url, $user_id );

			// If URL validates.
			if ( filter_var( $url, FILTER_VALIDATE_URL ) !== false ) {
				$return[ $service ] = $url;
			}
		}

		return $return;
	}
}

if ( ! function_exists( 'mytheme_order_recipes_by' ) ) {
	/**
	 * Returns an array of sorting options set in the Theme Options.
	 */
	function mytheme_order_recipes_by() {

		$displayed_sort_options = array();
		$displayed_sort_options = mytheme_get_option( 'displayed_sort_options' );

		if ( empty( $displayed_sort_options ) ) {
			return false;
		}

		$return = array();

		$sort_args = array(
			'date'      => __( 'Date', 'recipes' ),
			'rating'    => __( 'Rating', 'recipes' ),
			'title'     => __( 'Title', 'recipes' ),
			'time'      => __( 'Total time', 'recipes' ),
			'views'     => __( 'Views', 'recipes' ),
			'favorites' => __( 'Most favorited', 'recipes' ),
		);

		if ( ! mytheme_get_option( 'enable_ratings' ) ) {
			unset( $sort_args['rating'] );
		}

		if ( ! class_exists( 'WP_Widget_PostViews' ) ) {
			unset( $sort_args['views'] );
		}

		if ( ! class_exists( 'Favorites' ) ) {
			unset( $sort_args['favorites'] );
		}

		foreach ( $sort_args as $key => $value ) {
			if ( ! in_array( $key, $displayed_sort_options, true ) ) {
				unset( $sort_args[ $key ] );
			}
		}

		if ( empty( $sort_args ) ) {
			return false;
		}

		$return = new \stdClass();

		$return->current_sort_title = __( 'Choose', 'recipes' );

		if ( get_query_var( 'sort' ) ) {
			$query_var = get_query_var( 'sort' );

			$return->current_sort_title = $sort_args[ $query_var ];
		} elseif ( array_key_exists( 'date', $sort_args ) ) {
			$return->current_sort_title = $sort_args['date'];
		}

		$return->sorts = array();

		foreach ( $sort_args as $key => $value ) {
			$item = new \stdClass();

			$item->title = $value;

			// Check if the sort is active.
			$item->is_active = false;
			if ( get_query_var( 'sort' ) === $key ) {
				$item->is_active = true;
			} elseif ( empty( get_query_var( 'sort' ) ) && 'date' === $key ) {
				$item->is_active = true;
			}

			$return->sorts[ $key ] = $item;
		}

		return $return;
	}
}

if ( ! function_exists( 'mytheme_filter_options' ) ) {
	/**
	 * Returns an array of filtering options set in the Theme Options.
	 *
	 * @param  [array] $displayed_filters Enabled filtering options.
	 */
	function mytheme_filter_options( $displayed_filters ) {

		if ( empty( $displayed_filters ) ) {
			return false;
		}

		$filters_array = get_object_taxonomies( 'recipe', 'objects' );

		$return = array();

		foreach ( $filters_array as $filter => $filter_tax ) {
			if ( in_array( $filter, $displayed_filters, true ) ) {
				$return[ $filter ]['singular_name'] = $filter_tax->labels->singular_name;

				if ( get_query_var( $filter ) ) {
					$return[ $filter ]['class']        = 'rcps-btn-active';
					$return[ $filter ]['active_count'] = count( (array) get_query_var( $filter ) );
				}
			}
		}

		return $return;
	}
}

if ( ! function_exists( 'mytheme_get_recipe_url' ) ) {
	/**
	 * Returns the recipe URL.
	 * If the recipe is from external site, returns the external URL meta value.
	 */
	function mytheme_get_recipe_url() {

		if ( mytheme_is_external_recipe() && mytheme_get_option( 'link_external_recipes_to_source' ) ) {
			return get_post_meta( get_the_ID(), 'custom_meta_external_url', true );
		} else {
			return get_permalink();
		}
	}
}

if ( ! function_exists( 'mytheme_minutes_to_hr_min' ) ) {
	/**
	 * Displays time in hours and minutes.
	 *
	 * @param string $minutes Time in minutes.
	 */
	function mytheme_minutes_to_hr_min( $minutes ) {

		$minutes = absint( $minutes );

		if ( empty( $minutes ) ) {
			return;
		}

		$d = floor( $minutes / 1440 );
		$h = floor( ( $minutes - $d * 1440 ) / 60 );
		$m = $minutes - ( $d * 1440 ) - ( $h * 60 );

		$return = '';

		if ( ! empty( $d ) ) {
			$return .= sprintf( '%d ' . __( 'days', 'recipes' ), $d ) . ' ';
		}

		if ( ! empty( $h ) ) {
			$return .= sprintf( '%d ' . __( 'hr', 'recipes' ), $h ) . ' ';
		}

		if ( ! empty( $m ) ) {
			$return .= sprintf( '%d ' . __( 'min', 'recipes' ), $m );
		}

		// Strip whitespace from the beginning and end of a string.
		$return = trim( $return );

		echo esc_html( $return );
	}
}

if ( ! function_exists( 'mytheme_hex2rgb' ) ) {
	/**
	 * Converts HEX color value to RGB.
	 *
	 * @param string $hex Hex color value.
	 */
	function mytheme_hex2rgb( $hex ) {

		$hex = str_replace( '#', '', $hex );

		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );

		return $r . ', ' . $g . ', ' . $b;
	}
}

if ( ! function_exists( 'mytheme_get_contrast' ) ) {
	/**
	 * Calculates color contrast.
	 * https://24ways.org/2010/calculating-color-contrast/
	 *
	 * @param  [string] $hex Hex color value.
	 * @param  [string] $dark_return String to return when color is dark.
	 * @param  [string] $light_return String to return when color is light.
	 * @return [string]
	 */
	function mytheme_get_contrast( $hex, $dark_return, $light_return ) {

		$rgb = mytheme_hex2rgb( $hex );

		list( $r, $g, $b ) = explode( ', ', $rgb );

		$yiq = ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000;

		return ( $yiq >= 155 ) ? $light_return : $dark_return;
	}
}

if ( ! function_exists( 'mytheme_mce_buttons_2' ) ) {
	/**
	 * Reveals the hidden "Styles" dropdown in the TinyMCE advanced toolbar.
	 *
	 * @param  [array] $buttons Buttons.
	 */
	function mytheme_mce_buttons_2( $buttons ) {

		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'mytheme_mce_buttons_2' );

if ( ! function_exists( 'mytheme_tiny_mce_before_init' ) ) {
	/**
	 * Adds custom style options dropdown to editor.
	 *
	 * @param  [array] $settings TinyMCE editor settings.
	 */
	function mytheme_tiny_mce_before_init( $settings ) {

		$style_formats = array(
			array(
				'title'   => 'Ingress',
				'block'   => 'p',
				'classes' => 'rcps-ingress',
			),
		);

		$settings['style_formats'] = wp_json_encode( $style_formats );

		return $settings;
	}
}
add_filter( 'tiny_mce_before_init', 'mytheme_tiny_mce_before_init' );

if ( ! function_exists( 'mytheme_add_body_class' ) ) {
	/**
	 * Adds CSS classes to the body tag.
	 *
	 * @param  string|array $classes One or more classes to add to the class list.
	 */
	function mytheme_add_body_class( $classes ) {

		if ( 'light' === get_theme_mod( 'theme', 'dark' ) ) {
			$classes[] = 'rcps-theme-light';
		} elseif ( 'dark' === get_theme_mod( 'theme', 'dark' ) ) {
			$classes[] = 'rcps-theme-dark';
		}

		if ( ! is_user_logged_in() ) {
			$classes[] = 'not-logged-in';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'mytheme_add_body_class' );

if ( ! function_exists( 'mytheme_favorites_button' ) ) {
	/**
	 * Displays favorite button.
	 */
	function mytheme_favorites_button() {

		if ( is_user_logged_in() ) {
			the_favorites_button();
		} elseif ( ! is_user_logged_in() ) {
			$favorites_options = get_option( 'simplefavorites_display' );
			?>
			<form action="<?php echo esc_url( wp_login_url( filter_input( INPUT_SERVER, 'REQUEST_URI' ) ) ); ?>">
				<input type="hidden" name="rcps_fav" value="1">
				<input type="hidden" name="rcps_id" value="<?php the_ID(); ?>">
				<button class="simplefavorite-button">
					<?php echo wp_kses( $favorites_options['buttontext'], rcps_get_wp_kses_allowed_html( 'favorite_button' ) ); ?>
					<?php if ( isset( $favorites_options['buttoncount'] ) && 'true' === $favorites_options['buttoncount'] ) : ?>
						<span class="simplefavorite-button-count"><?php the_favorites_count(); ?></span>
					<?php endif; ?>
				</button>
			</form>
			<?php
		}
	}
}

if ( ! function_exists( 'mytheme_archive_title' ) ) {
	/**
	 * Filters the blog archive title.
	 *
	 * @param  string $title Title.
	 * @return string        Archive title to be displayed.
	 */
	function mytheme_archive_title( $title ) {

		if ( is_day() ) {
			$title = get_the_date();
		} elseif ( is_month() ) {
			$title = get_the_date( 'F Y' );
		} elseif ( is_year() ) {
			$title = get_the_date( 'Y' );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_category() ) {
			$title = single_cat_title( '', false );
		} else {
			$title = single_cat_title( '', false );
		}

		return $title;
	}
}
add_filter( 'get_the_archive_title', 'mytheme_archive_title' );

if ( ! function_exists( 'mytheme_template_chooser' ) ) {
	/**
	 * Changes search template for recipes.
	 *
	 * @param  string $template The path of the template to include.
	 * @return string           Template.
	 */
	function mytheme_template_chooser( $template ) {

		$post_type = get_query_var( 'post_type' );

		if ( is_search() && 'recipe' === $post_type ) {
			return locate_template( 'archive-recipe.php' );
		}

		return $template;
	}
}
add_filter( 'template_include', 'mytheme_template_chooser' );

if ( ! function_exists( 'rcps_has_any_term' ) ) {
	/**
	 * Checks if a post has any term from a list of taxonomies.
	 *
	 * @return boolean
	 */
	function rcps_has_any_term() {

		$return = false;

		global $post;

		$get_object_taxonomies = get_object_taxonomies( $post, 'objects' );

		$taxonomies = apply_filters( 'rcps_filter_has_any_term_taxonomies', $get_object_taxonomies, $post );

		foreach ( $taxonomies as $tax ) {
			if ( has_term( '', $tax->name, $post ) ) {
				$return = true;
			}
		}

		return apply_filters( 'rcps_filter_has_any_term_return', $return );
	}
}

if ( ! function_exists( 'rcps_get_wp_kses_allowed_html' ) ) {
	/**
	 * Returns allowed HTML for wp_kses functions.
	 *
	 * @param  string $type Type.
	 * @return array
	 */
	function rcps_get_wp_kses_allowed_html( $type ) {

		$allowed_tags = array();

		if ( 'favorite_button' === $type ) {
			$allowed_tags = array(
				'svg' => array(
					'class' => array(),
				),
				'use' => array(
					'xlink:href' => array(),
				),
			);
		}

		$allowed_tags = apply_filters( 'rcps_filter_get_wp_kses_allowed_html', $allowed_tags, $type );

		return $allowed_tags;
	}
}

if ( ! function_exists( 'rcps_template_redirect' ) ) {
	/**
	 * Redirects to a single taxonomy page if recipe filters has only one taxonomy set.
	 */
	function rcps_template_redirect() {

		// Return if the search term or author_name is set.
		if ( get_query_var( 's' ) || get_query_var( 'author_name' ) ) {
			return;
		}

		$post_type  = get_query_var( 'post_type' );
		$taxonomies = get_object_taxonomies( 'recipe', 'names' );

		if ( empty( $taxonomies ) ) {
			return;
		}

		$query_vars = array();

		foreach ( $taxonomies as $taxonomy ) {
			$query_var = (array) get_query_var( $taxonomy );

			if ( ! empty( $query_var ) && count( $query_var ) > 1 ) {
				return;
			}

			if ( ! empty( $query_var ) && 1 === count( $query_var ) && ! empty( $query_var[0] ) ) {
				$query_vars[] = array( $query_var[0], $taxonomy );
			}
		}

		// Continue if only one taxonomy is active.
		if ( is_search() && 'recipe' === $post_type && count( $query_vars ) === 1 ) {
			$url = get_term_link( $query_vars[0][0], $query_vars[0][1] );

			if ( is_wp_error( $url ) ) {
				return;
			}

			// Add sort parameter to URL.
			if ( get_query_var( 'sort' ) ) {
				$url = add_query_arg( 'sort', get_query_var( 'sort' ), $url );
			}

			// Add favorite parameter to URL.
			if ( get_query_var( 'fav' ) ) {
				$url = add_query_arg( 'fav', get_query_var( 'fav' ), $url );
			}

			wp_safe_redirect( $url );
			die;
		}
	}
}
add_action( 'template_redirect', 'rcps_template_redirect' );

if ( ! function_exists( 'rcps_redirect_empty_search_term' ) ) {
	/**
	 * Fixes an issue with Yoast SEO plugin.
	 * Empty search term, and selecting multiple taxonomy filters causes an error (502 Bad Gateway).
	 */
	function rcps_redirect_empty_search_term() {

		// Return if Yoast SEO plugin is not active.
		if ( ! in_array( 'wordpress-seo/wp-seo.php', get_option( 'active_plugins' ), true ) ) {
			return;
		}

		// Return if the search term is set.
		if ( get_query_var( 's' ) ) {
			return;
		}

		$post_type = get_query_var( 'post_type' );

		if ( is_post_type_archive( 'recipe' ) && 'recipe' === $post_type && empty( get_query_var( 's' ) ) ) {
			// Get the URL.
			$url = ( isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http' ) . '://' . filter_input( INPUT_SERVER, 'HTTP_HOST' ) . filter_input( INPUT_SERVER, 'REQUEST_URI' );

			// Return if the 's' parameter is not empty.
			if ( strpos( $url, '?s=&' ) === false ) {
				return;
			}

			// Remove 's' parameter if it's empty.
			$url = str_replace( '?s=&', '?', $url );

			wp_safe_redirect( $url );
			die;
		}
	}
}
add_action( 'template_redirect', 'rcps_redirect_empty_search_term' );

/**
 * Returns alert message for the recipe grid.
 *
 * @return boolean|string Message.
 */
function rcps_get_recipe_grid_alert_message() {

	$alert = false;

	global $wp_query;

	if ( false === $wp_query->have_posts() ) {
		$alert = __( 'Sorry, but nothing matched your search criteria.', 'recipes' );
	}

	if ( class_exists( 'Favorites' ) && 1 === absint( get_query_var( 'fav' ) ) ) {
		$current_user = wp_get_current_user();

		if ( ! is_user_logged_in() ) {
			$alert = __( 'You must be logged in to view your favorite recipes.', 'recipes' );
		} elseif ( is_user_logged_in() && ! get_user_favorites( $current_user->ID, '', 'recipe' ) ) {
			$alert = __( 'You have no favorite recipes.', 'recipes' );
		}
	}

	return $alert;
}

/**
 * Returns array of applied filters.
 *
 * @return array
 */
function rcps_get_applied_filters() {

	$taxonomies = get_object_taxonomies( 'recipe', 'objects' );

	$return = array();

	if ( ! empty( get_query_var( 's' ) ) ) {
		$filter               = new \stdClass();
		$filter->filter_title = __( 'Keyword', 'recipes' );
		$filter->name         = get_query_var( 's' );
		$filter->url          = remove_query_arg( 's' );

		$return[] = $filter;
	}

	if ( ! empty( get_query_var( 'author_name' ) ) ) {
		$author_display_name = get_the_author_meta( 'display_name', get_query_var( 'author' ) );

		$filter               = new \stdClass();
		$filter->filter_title = __( 'Author', 'recipes' );
		$filter->name         = $author_display_name;
		$filter->url          = remove_query_arg( 'author_name' );

		$return[] = $filter;
	}

	foreach ( $taxonomies as $tax_name => $tax ) {

		// Get active term slugs for the taxonomy.
		$active_slugs = (array) get_query_var( $tax_name );

		// Continue if there are no active term slugs.
		if ( empty( $active_slugs ) || empty( $active_slugs[0] ) ) {
			continue;
		}

		$active_slugs_count = count( $active_slugs );

		foreach ( $active_slugs as $term_slug ) {

			$new_active_slugs = $active_slugs;

			if ( 1 === $active_slugs_count ) {
				$new_url = remove_query_arg( $tax_name, false );
			} elseif ( $active_slugs_count > 1 ) {

				// Remove the current slug from the array.
				$array_key = array_search( $term_slug, $active_slugs, true );
				if ( false !== $array_key ) {
					unset( $new_active_slugs[ $array_key ]);
				}

				$new_url = remove_query_arg( $tax_name, false );

				// Build the new URL.
				$query_args_array = array();
				foreach ( $new_active_slugs as $key => $value ) {
					$query_args_array[ $tax_name . '[' . $key . ']' ] = $value;
				}
				$new_url = add_query_arg( $query_args_array, $new_url );
			}

			$term = get_term_by( 'slug', $term_slug, $tax_name );

			$filter               = new \stdClass();
			$filter->name         = $term->name;
			$filter->filter_title = $tax->labels->singular_name;
			$filter->url          = $new_url;

			$return[] = $filter;
		}
	}

	// Remove numeric keys from item URLs.
	$preg_replace_patterns = array( '/\[\d+\]/', '/%5B\d+%5D/' );

	if ( ! empty( $return ) ) {
		foreach ( $return as $key => $item ) {
			$new_url = preg_replace( $preg_replace_patterns, '[]', $item->url );

			$return[ $key ]->url = $new_url;
		}
	}

	return $return;
}

/**
 * Returns WP_Query of author's recipes.
 *
 * @param int $author_id Author ID.
 *
 * @return WP_Query
 */
function rcps_author_query_recipes( $author_id ) {

	$args = array(
		'post_type'      => 'recipe',
		'posts_per_page' => 6,
		'author'         => $author_id,
	);

	$args = apply_filters( 'rcps_filter_args_author_query_recipes', $args );

	$wp_query_recipes = new WP_Query( $args );

	return $wp_query_recipes;
}

/**
 * Returns WP_Query of author's posts.
 *
 * @param int $author_id Author ID.
 *
 * @return WP_Query
 */
function rcps_author_query_posts( $author_id ) {

	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => 4,
		'author'         => $author_id,
	);

	$args = apply_filters( 'rcps_filter_args_author_query_posts', $args );

	$wp_query_posts = new WP_Query( $args );

	return $wp_query_posts;
}

/**
 * Returns WP_Query of author's favorite recipes.
 *
 * @param int $author_id Author ID.
 *
 * @return WP_Query|boolean
 */
function rcps_author_query_favorites( $author_id ) {

	// Get an array of user favorites (returns post ids).
	$user_favorites = get_user_favorites( $author_id, $site_id = null, $filters = null );

	// If the user has no favorites.
	if ( empty( $user_favorites ) ) {
		return false;
	}

	$args = array(
		'post_type'      => 'recipe',
		'posts_per_page' => 6,
		'post__in'       => $user_favorites,
	);

	$args = apply_filters( 'rcps_filter_args_author_query_favorites', $args );

	$wp_query_favorites = new WP_Query( $args );

	return $wp_query_favorites;
}

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support WordPress versions prior to 5.2.0.
	 */
	function wp_body_open() {
		/**
		 * Triggered after the opening <body> tag.
		 */
		do_action( 'wp_body_open' );
	}
}

<?php
/**
 * Ajax.php
 *
 * @package Recipes WordPress Theme
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Updates recipe listing via AJAX.
 */
function rcps_ajax_query_recipes() {

	// Check for nonce security.
	$validate_nonce = check_ajax_referer( 'ajax-nonce', '_ajax_nonce', false );

	if ( false === $validate_nonce ) {
		wp_die( esc_html__( 'Error.', 'recipes' ) );
	}

	$form_data = json_decode( stripslashes( filter_input( INPUT_POST, 'form_data' ) ), true );
	$get_args  = json_decode( stripslashes( filter_input( INPUT_POST, 'args' ) ), true );

	if ( ! empty( absint( $get_args['page'] ) ) ) {
		$args['paged'] = absint( $get_args['page'] );
	}

	if ( ! empty( absint( $get_args['current_page'] ) ) ) {
		$args['paged'] = absint( $get_args['current_page'] ) + 1;
	}

	if ( ! empty( $form_data['sort'] ) && ! empty( esc_attr( $form_data['sort'] ) ) ) {
		if ( ! in_array( esc_attr( $form_data['sort'] ), array( 'title', 'date', 'rating', 'views', 'relevance', 'time', 'favorites' ), true ) ) {
			wp_die( esc_html__( 'Error.', 'recipes' ) );
		}

		if ( 'date' === esc_attr( $form_data['sort'] ) ) {
			$args['orderby'] = 'date';
			$args['order']   = 'DESC';
		}

		if ( 'title' === esc_attr( $form_data['sort'] ) ) {
			$args['orderby'] = 'title';
			$args['order']   = 'ASC';
		}

		if ( in_array( esc_attr( $form_data['sort'] ), array( 'rating', 'time', 'views', 'favorites' ), true ) ) {
			$args['orderby'] = 'meta_value_num';
			$args['order']   = 'DESC';
		}

		if ( 'rating' === esc_attr( $form_data['sort'] ) ) {
			$args['meta_key'] = 'custom_meta_votes_percent'; // phpcs:ignore slow query ok.
		} elseif ( 'time' === esc_attr( $form_data['sort'] ) ) {
			$args['meta_key'] = 'custom_meta_total_time'; // phpcs:ignore slow query ok.
		} elseif ( 'views' === esc_attr( $form_data['sort'] ) ) {
			$args['meta_key'] = 'views'; // phpcs:ignore slow query ok.
		} elseif ( 'favorites' === esc_attr( $form_data['sort'] ) ) {
			$args['meta_key'] = 'simplefavorites_count'; // phpcs:ignore slow query ok.
		}
	}

	if ( ! empty( $form_data['fav'] ) && class_exists( 'Favorites' ) ) {
		if ( is_user_logged_in() && '1' === esc_attr( $form_data['fav'] ) ) {
			$args['post__in'] = get_user_favorites();
		}
		if ( ! is_user_logged_in() || ! get_user_favorites_count() ) {
			// Returns no posts if user is not logged in or has no favorites.
			$args['post__in'] = array( '0' );
		}
	}

	if ( ! empty( $form_data['s'] ) ) {
		$args['s'] = $form_data['s'];
	}

	if ( ! empty( $form_data['author_name'] ) ) {
		$args['author_name'] = esc_attr( $form_data['author_name'] );
	}

	$filters = mytheme_get_option( 'displayed_filters' );

	if ( ! empty( $filters ) ) {
		foreach ( $filters as $filter ) {
			if ( ! empty( $form_data[ $filter ] ) && 'keyword' !== $filter ) {
				$args['tax_query'][] = array(
					'relation' => 'OR',
					array(
						'taxonomy' => $filter,
						'field'    => 'slug',
						'terms'    => array_unique( $form_data[ $filter ] ),
					),
				);
			}
		}
	}

	$return = rcps_output_recipe_grid( $args );

	echo wp_json_encode( $return );

	wp_die();
}
add_action( 'wp_ajax_nopriv_rcps_ajax_query_recipes', 'rcps_ajax_query_recipes' );
add_action( 'wp_ajax_rcps_ajax_query_recipes', 'rcps_ajax_query_recipes' );

/**
 * Outputs recipe grid.
 *
 * @param  array $args WP Query args.
 */
function rcps_output_recipe_grid( $args = array() ) {

	$defaults = array(
		'post_type'      => 'recipe',
		'post_status'    => 'publish',
		'posts_per_page' => get_theme_mod( 'recipes_per_page', 18 ),
	);

	$args = wp_parse_args( (array) $args, $defaults );

	if ( empty( $args['tax_query'] ) ) {
		$args['update_post_term_cache'] = false;
	}

	if ( empty( $args['meta_query'] ) ) {
		$args['update_post_meta_cache'] = false;
	}

	$rcps_recipe_query = new WP_Query( $args );
	?>

	<?php ob_start(); ?>

	<?php if ( $rcps_recipe_query->have_posts() ) : ?>
		<?php while ( $rcps_recipe_query->have_posts() ) : ?>
			<?php $rcps_recipe_query->the_post(); ?>
			<?php get_template_part( 'templates/template', 'recipe' ); ?>
		<?php endwhile; ?>
	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

	<?php
	$html = ob_get_clean();

	return array(
		// Translators: %d is the number of recipes found.
		'post_count'   => sprintf( esc_html( _n( '%d recipe', '%d recipes', $rcps_recipe_query->found_posts, 'recipes' ) ), absint( $rcps_recipe_query->found_posts ) ),
		'recipes_html' => $html,
	);
}

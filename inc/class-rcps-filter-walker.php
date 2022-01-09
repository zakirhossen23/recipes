<?php
/**
 * Class-rcps-filter-walker.php
 *
 * @package Recipes WordPress Theme
 */

/**
 * Creates an HTML output of categories. Used for filter drop-downs.
 */
class Rcps_Filter_Walker extends Walker_Category {

	/**
	 * Starts the element output.
	 *
	 * @param  string   $output   Passed by reference. Used to append additional content.
	 * @param  WP_Post  $category Menu item data object.
	 * @param  int      $depth    Depth of menu item. Used for padding.
	 * @param  stdClass $args     An object of wp_nav_menu() arguments.
	 * @param  int      $id       Current item ID.
	 */
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

		$term_slug = esc_attr( $category->slug );
		$term_name = apply_filters( 'rcps_filter_list_filters_term_name', $category->name, $category );
		$taxonomy  = get_taxonomy( $category->taxonomy );

		$active_query_vars = get_query_var( $taxonomy->query_var );

		$is_checked = false;
		if ( is_tax( $taxonomy->name, $term_slug ) || in_array( $term_slug, (array) $active_query_vars, true ) ) {
			$is_checked = true;
		}

		$depth_class = null;
		if ( $depth >= 1 ) {
			$depth_class = ' rcps-dropdown-input-wrap-depth-' . $depth;
		}

		$output .= '<div class="rcps-dropdown-input-wrap' . ( $depth_class ? $depth_class : '' ) . '"><input type="checkbox" name="' . $taxonomy->name . '[]" id="id-' . $taxonomy->name . '-' . $term_slug . '" value="' . $term_slug . '"' . checked( $is_checked, true, false ) . '>';
		$output .= '<label for="id-' . $taxonomy->name . '-' . $term_slug . '">' . $term_name . '</label></div>';
	}
}

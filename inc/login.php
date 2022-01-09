<?php
/**
 * Login.php
 *
 * Custom functions for the login page.
 *
 * @package Recipes WordPress Theme
 */

if ( ! function_exists( 'mytheme_login_redirect' ) ) {
	/**
	 * Redirects user after successful login.
	 *
	 * @param string $redirect_to URL to redirect to.
	 * @param string $request URL the user is coming from.
	 * @param object $user Logged user's data.
	 * @return string
	 */
	function mytheme_login_redirect( $redirect_to, $request, $user ) {

		if ( isset( $user->roles ) && is_array( $user->roles ) ) {
			if ( in_array( 'administrator', $user->roles, true ) ) {
				return $redirect_to;
			} else {
				return home_url();
			}
		} else {
			return $redirect_to;
		}
	}
}
add_filter( 'login_redirect', 'mytheme_login_redirect', 10, 3 );

if ( ! function_exists( 'mytheme_login_logo_url' ) ) {
	/**
	 * Links the login logo to the homepage.
	 */
	function mytheme_login_logo_url() {
		return home_url();
	}
}
add_filter( 'login_headerurl', 'mytheme_login_logo_url' );

if ( ! function_exists( 'mytheme_login_logo_url_title' ) ) {
	/**
	 * Sets custom title text for the logo image.
	 */
	function mytheme_login_logo_url_title() {
		return get_bloginfo( 'name' );
	}
}
add_filter( 'login_headertext', 'mytheme_login_logo_url_title' );

if ( ! function_exists( 'mytheme_login_message' ) ) {
	/**
	 * Displays a custom message on the login page if trying to add a recipe to favorites.
	 *
	 * @param  [string] $message Message.
	 * @return [string]
	 */
	function mytheme_login_message( $message ) {

		$recipe_id = filter_input( INPUT_GET, 'rcps_id', FILTER_VALIDATE_INT );

		if ( empty( $message ) && 1 === filter_input( INPUT_GET, 'rcps_fav', FILTER_VALIDATE_INT ) && ! empty( get_permalink( $recipe_id ) ) ) {
			// Translators: %s is recipe title.
			return '<p class="message">' . sprintf( __( 'Please log in to add %s to your favorites', 'recipes' ), '<a href="' . get_permalink( $recipe_id ) . '">' . get_the_title( $recipe_id ) . '</a>' ) . '</p>';
		}

		return $message;
	}
}
add_filter( 'login_message', 'mytheme_login_message' );

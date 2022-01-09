<?php
/**
 * WP-postviews-custom.php
 *
 * @package Recipes WordPress Theme
 */

/**
 * Dequeues the WP-PostViews jQuery script.
 */
function rcps_dequeue_wp_postviews_jquery() {
	wp_dequeue_script( 'wp-postviews-cache' );
}
add_action( 'wp_print_scripts', 'rcps_dequeue_wp_postviews_jquery', 100 );

/**
 * Adds custom JavaScript if WP-PostViews should count the view.
 *
 * LINK: https://github.com/lesterchan/wp-postviews/blob/master/wp-postviews.php#L127
 */
function rcps_enqueue_custom_wp_postviews_js() {
	global $user_ID, $post;

	if ( ! defined( 'WP_CACHE' ) || ! WP_CACHE ) {
		return;
	}

	$views_options = get_option( 'views_options' );

	if ( isset( $views_options['use_ajax'] ) && 0 === (int) $views_options['use_ajax'] ) {
		return;
	}

	if ( ! wp_is_post_revision( $post ) && ( is_single() || is_page() ) ) {
		$should_count = false;
		switch ( (int) $views_options['count'] ) {
			case 0:
				$should_count = true;
				break;
			case 1:
				if ( empty( $_COOKIE[ USER_COOKIE ] ) && 0 === (int) $user_ID ) {
					$should_count = true;
				}
				break;
			case 2:
				if ( (int) $user_ID > 0 ) {
					$should_count = true;
				}
				break;
		}

		$should_count = apply_filters( 'postviews_should_count', $should_count, (int) $post->ID );
		if ( $should_count ) {

			// Registers script with an empty source to use the inline script only (without a JS file).
			wp_register_script( 'rcps-wp-postviews-custom', '', false, RCPS_THEME_VERSION, true );
			wp_enqueue_script( 'rcps-wp-postviews-custom' );
			wp_add_inline_script( 'rcps-wp-postviews-custom',
				"var xhr = new XMLHttpRequest();xhr.open('GET',viewsCacheL10n.admin_ajax_url+'?action=postviews&postviews_id='+viewsCacheL10n.post_id,true);xhr.send();"
			);

			$postviews_localize_args = array(
				'admin_ajax_url' => admin_url( 'admin-ajax.php' ),
				'post_id'        => (int) $post->ID,
			);

			wp_localize_script( 'rcps-wp-postviews-custom', 'viewsCacheL10n', $postviews_localize_args );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'rcps_enqueue_custom_wp_postviews_js' );

<?php
/**
 * Functions.php
 *
 * @package Recipes WordPress Theme
 */

/**
 * Defines theme version.
 */
define( 'RCPS_THEME_VERSION', '5.3.0' );

if ( ! function_exists( 'mytheme_get_option' ) ) {
	/**
	 * Wrapper function around cmb2_get_option.
	 *
	 * @param  string $key     Options array key.
	 * @param  mixed  $default Optional default value.
	 * @return mixed           Option value.
	 */
	function mytheme_get_option( $key = '', $default = false ) {

		if ( function_exists( 'cmb2_get_option' ) ) {
			return cmb2_get_option( 'rcps_options', $key, $default );
		}

		// Fallback to get_option if CMB2 is not loaded yet.
		$opts = get_option( 'rcps_options', $default );
		$val  = $default;

		if ( 'all' === $key ) {
			$val = $opts;
		} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
			$val = $opts[ $key ];
		}
		return $val;
	}
}

/**
 * Defines a constant for the max upload filesize.
 */
if ( mytheme_get_option( 'max_upload_filesize' ) && is_numeric( mytheme_get_option( 'max_upload_filesize' ) ) ) {
	$max_filesize = absint( mytheme_get_option( 'max_upload_filesize' ) );
} else {
	$max_filesize = 2;
}
define( 'RCPS_MAX_IMAGE_FILESIZE', $max_filesize );

define( 'RCPS_MIN_IMAGE_WIDTH', absint( mytheme_get_option( 'uploaded_image_min_width', 1140 ) ) );
define( 'RCPS_MIN_IMAGE_HEIGHT', absint( mytheme_get_option( 'uploaded_image_min_height', 500 ) ) );

/**
 * Requires files from /inc folder.
 */
require get_template_directory() . '/inc/migrate-options.php';
require get_template_directory() . '/inc/theme-setup.php';
require get_template_directory() . '/inc/plugins.php';
require get_template_directory() . '/inc/cmb2-theme-options.php';
require get_template_directory() . '/inc/comment-list.php';
require get_template_directory() . '/inc/login.php';
require get_template_directory() . '/inc/meta-boxes.php';
require get_template_directory() . '/inc/inline-style.php';
require get_template_directory() . '/inc/misc.php';
require get_template_directory() . '/inc/navigation.php';
require get_template_directory() . '/inc/class-rcps-filter-walker.php';
require get_template_directory() . '/inc/modify-queries.php';
require get_template_directory() . '/inc/images.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/ajax.php';

if ( class_exists( 'WP_Widget_PostViews' ) ) {
	require get_template_directory() . '/inc/wp-postviews-custom.php';
}

/**
 * Loads custom control classes for the Customizer.
 */
function rcps_load_customize_controls() {
	require_once( trailingslashit( get_template_directory() ) . 'inc/class-rcps-customizer-checkbox-multiple.php' );
}
add_action( 'customize_register', 'rcps_load_customize_controls', 0 );

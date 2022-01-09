<?php
/**
 * Plugins.php
 *
 * @package Recipes WordPress Theme
 */

/**
 * Requires TGM Plugin Activation library.
 */
require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';

if ( ! function_exists( 'mytheme_require_plugins' ) ) {
	/**
	 * Adds TGM Plugin Activation library.
	 */
	function mytheme_require_plugins() {

		$plugins = array(
			array(
				'name'             => 'Recipes Plugin',
				'slug'             => 'recipes-plugin',
				'source'           => get_template_directory() . '/lib/recipes-plugin-3.16.0.zip',
				'required'         => true,
				'version'          => '3.16.0',
				'force_activation' => true,
			),
			array(
				'name'     => 'Envato Market',
				'slug'     => 'envato-market',
				'source'   => get_template_directory() . '/lib/envato-market-2.0.6.zip',
				'required' => true,
				'version'  => '2.0.6',
			),
			array(
				'name'     => 'CMB2',
				'slug'     => 'cmb2',
				'required' => true,
			),
			array(
				'name'     => 'Favorites',
				'slug'     => 'favorites',
				'required' => false,
			),
			array(
				'name'     => 'WP-PostViews',
				'slug'     => 'wp-postviews',
				'required' => false,
			),
			array(
				'name'     => 'One Click Demo Import',
				'slug'     => 'one-click-demo-import',
				'required' => false,
			),
		);

		$config = array(
			'id'           => 'mytheme-tgmpa-required-plugins',
			'menu'         => 'mytheme-install-required-plugins',
			'has_notices'  => true,
			'dismissable'  => true,
			'is_automatic' => true,
		);

		tgmpa( $plugins, $config );
	}
}
add_action( 'tgmpa_register', 'mytheme_require_plugins' );

/**
 * Defines settings for the One Click Demo Import plugin.
 * http://proteusthemes.github.io/one-click-demo-import/
 */
function mytheme_ocdi_import_demo_data() {

	return array(
		array(
			'import_file_name'             => 'Demo Import 1',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo-imports/demo-content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo-imports/demo-widgets.wie',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo-imports/demo-customizer.dat',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'mytheme_ocdi_import_demo_data' );

/**
 * Sets options for Front page and Posts after importing the demo data.
 */
function mytheme_ocdi_after_import_setup() {

	$front_page_id = get_page_by_title( 'Home' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'mytheme_ocdi_after_import_setup' );

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

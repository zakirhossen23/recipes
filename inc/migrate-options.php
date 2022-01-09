<?php
/**
 * Migrate-options.php
 *
 * @package Recipes WordPress Theme
 */

if ( ! function_exists( 'of_get_option' ) ) {
	/**
	 * Loads default options for Options Framework plugin.
	 *
	 * @param string $name Option name.
	 * @param string $default Default option value.
	 */
	function of_get_option( $name, $default = false ) {

		$optionsframework_settings = get_option( 'optionsframework' );
		$option_name = $optionsframework_settings['id'];

		if ( get_option( $option_name ) ) {
			$options = get_option( $option_name );
		}

		if ( isset( $options[ $name ] ) ) {
			return $options[ $name ];
		} else {
			return $default;
		}
	}
}

/**
 * Migrates options from Options Framework.
 */
function mytheme_migrate_options() {

	// Check if the options have already been migrated.
	if ( ! empty( get_option( 'rcps_options_migrated' ) ) ) {
		return;
	}

	// Migrate logo option to theme mod.
	if ( ! empty( of_get_option( 'option_logo' ) ) ) {
		$logo_url = of_get_option( 'option_logo' );
		$logo_id = attachment_url_to_postid( $logo_url );

		if ( ! empty( $logo_id ) ) {
			set_theme_mod( 'custom_logo', $logo_id );
		}
	}

	// Migrate options to theme mods.
	$of_options = array(
		'option_color_accent' => 'color_accent',
		'option_color_favorite' => 'color_favorite',
		'option_color_title_background' => 'color_title_background',
		'option_color_star_rating' => 'color_star_rating',
		'option_rating_style' => 'rating_style',
		'option_theme' => 'theme',
		'option_recipes_number' => 'recipes_per_page',
		'option_tax' => 'tax_on_card',
		'option_font_headers' => 'font_headers',
		'option_font_body' => 'font_body',
	);

	foreach ( $of_options as $key => $value ) {
		if ( ! empty( of_get_option( $key ) ) ) {
			set_theme_mod( $value, of_get_option( $key ) );
		}
	}

	// Migrate rest of Options Framework options to CMB2 options.
	$rcps_options = array();
	$rcps_options_ads = array();

	// Text fields, textareas and selects.
	$text_options = array(
		'option_analytics' => 'analytics',
		'option_max_filesize' => 'max_upload_filesize',
		'option_image_placeholder' => 'image_placeholder',
		'option_submit_url' => 'allowed_submission_types',
	);

	foreach ( $text_options as $key => $value ) {
		if ( ! empty( of_get_option( $key ) ) ) {
			$rcps_options[ $value ] = of_get_option( $key );
		}
	}

	// Checkboxes.
	$checkboxes = array(
		'option_voting' => 'enable_ratings',
		'option_login' => 'account_links_main_navi',
		'option_admins_member_directory' => 'show_admins_in_member_directory',
		'option_external_link' => 'link_external_recipes_to_source',
		'option_submit_registered' => 'submissions_only_for_registered',
	);

	foreach ( $checkboxes as $key => $value ) {
		if ( ! empty( of_get_option( $key ) ) && '1' === of_get_option( $key ) ) {
			$rcps_options[ $value ] = 'on';
		}
	}

	// Multicheckboxes.
	$multi_checkboxes = array(
		'option_filters' => 'displayed_filters',
		'option_sorting' => 'displayed_sort_options',
		'option_share' => 'displayed_share_links',
		'option_displayed_fields' => 'displayed_form_fields',
		'option_required_fields' => 'required_form_fields',
	);

	foreach ( $multi_checkboxes as $key => $value ) {
		$option_values = of_get_option( $key );

		if ( ! empty( $option_values ) ) {
			foreach ( $option_values as $option_key => $option_value ) {
				if ( '1' === $option_value ) {
					$rcps_options[ $value ][] = $option_key;
				}
			}
		}
	}

	if ( ! empty( $rcps_options ) ) {
		$update_option = update_option( 'rcps_options', $rcps_options );
	}

	// Ads.
	$ads = array( 'option_ad_grid_top', 'option_ad_grid_bottom', 'option_ad_single' );

	foreach ( $ads as $ad ) {
		if ( ! empty( of_get_option( $ad ) ) ) {
			$rcps_options_ads[ $ad ] = of_get_option( $ad );
		}
	}

	if ( ! empty( $rcps_options_ads ) ) {
		$update_option = update_option( 'rcps_options_ads', $rcps_options_ads );
	}

	// Migrates existing custom CSS to the core option added in WordPress 4.7.
	// https://make.wordpress.org/core/2016/11/26/extending-the-custom-css-editor/.
	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		$css = of_get_option( 'option_custom_css' );
		if ( ! empty( $css ) ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return = wp_update_custom_css_post( $core_css . $css );
		}
	}

	// Migrates social link options to menu.
	$links = array(
		'facebook'  => 'Facebook',
		'flickr'    => 'Flickr',
		'google'    => 'Google+',
		'instagram' => 'Instagram',
		'linkedin'  => 'LinkedIn',
		'pinterest' => 'Pinterest',
		'tumblr'    => 'Tumblr',
		'twitter'   => 'Twitter',
		'vimeo'     => 'Vimeo',
		'vk'        => 'VK',
		'youtube'   => 'YouTube',
	);

	$social_links = array();

	foreach ( $links as $slug => $title ) {
		if ( ! empty( of_get_option( 'option_' . $slug ) ) ) {
			$social_links[] = array(
				'url' => of_get_option( 'option_' . $slug ),
				'title' => $title,
			);
		}
	}

	$menu_name = 'Social';
	$menu_exists = wp_get_nav_menu_object( $menu_name );

	if ( ! $menu_exists && ! empty( $social_links ) ) {

		// If it doesn't exist, let's create it.
		$menu_id = wp_create_nav_menu( $menu_name );

		foreach ( $social_links as $social_link ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'  => $social_link['title'],
				'menu-item-url'    => $social_link['url'],
				'menu-item-status' => 'publish',
				'menu-item-type'   => 'custom',
			) );
		}
	}

	update_option( 'rcps_options_migrated', 1 );
}
add_action( 'admin_init', 'mytheme_migrate_options' );

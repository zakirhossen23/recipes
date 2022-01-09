<?php
/**
 * Cmb2-theme-options.php.
 *
 * @package Recipes WordPress Theme
 */

/**
 * Registers a metabox to handle the theme options.
 */
function mytheme_cmb2_box_theme_options() {

	/**
	 * Registers main options page menu item and form.
	 */
	$options = new_cmb2_box( array(
		'id'           => 'rcps_main_options_page',
		'title'        => __( 'Recipes Options', 'recipes' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'rcps_options',
	) );

	$options->add_field( array(
		'name'    => __( 'Ratings', 'recipes' ),
		'desc'    => __( 'Enable the ratings system for recipes.', 'recipes' ),
		'id'      => 'enable_ratings',
		'type'    => 'checkbox',
		'default' => mytheme_cmb2_set_checkbox_defaults( true ),
	) );

	$options->add_field( array(
		'name'    => __( 'Account links in the main navigation', 'recipes' ),
		'desc'    => __( 'Display Log In, Register, and Account links in the main navigation.', 'recipes' ),
		'id'      => 'account_links_main_navi',
		'type'    => 'checkbox',
		'default' => mytheme_cmb2_set_checkbox_defaults( true ),
	) );

	$options->add_field( array(
		'name'    => __( 'Member directory', 'recipes' ),
		'desc'    => __( 'Display administrators in the member directory.', 'recipes' ),
		'id'      => 'show_admins_in_member_directory',
		'type'    => 'checkbox',
		'default' => mytheme_cmb2_set_checkbox_defaults( true ),
	) );

	$options->add_field( array(
		'name'    => __( 'Nutrition facts daily values', 'recipes' ),
		'desc'    => __( 'Display percent daily value in the nutrition facts.', 'recipes' ),
		'id'      => 'show_daily_values',
		'type'    => 'checkbox',
		'default' => mytheme_cmb2_set_checkbox_defaults( true ),
	) );

	$options->add_field( array(
		'name'              => __( 'Filtering recipes', 'recipes' ),
		'desc'              => __( 'Choose which fields are displayed on the recipe filters.', 'recipes' ),
		'id'                => 'displayed_filters',
		'type'              => 'multicheck_inline',
		'select_all_button' => false,
		'options_cb'        => 'rcps_get_recipe_filter_options',
		'default'           => mytheme_cmb2_set_checkbox_defaults( array( 'keyword', 'course', 'cuisine', 'skill-level', 'collection', 'recipe-tag' ) ),
	) );

	$options->add_field( array(
		'name'              => __( 'Sorting recipes', 'recipes' ),
		'desc'              => __( 'Choose which values the recipes can be sorted on.', 'recipes' ),
		'id'                => 'displayed_sort_options',
		'type'              => 'multicheck_inline',
		'select_all_button' => false,
		'options'           => array(
			'date'      => __( 'Date', 'recipes' ),
			'rating'    => __( 'Rating', 'recipes' ),
			'title'     => __( 'Title', 'recipes' ),
			'time'      => __( 'Time', 'recipes' ),
			'views'     => __( 'Views', 'recipes' ),
			'favorites' => __( 'Favorites', 'recipes' ),
		),
		'default'           => mytheme_cmb2_set_checkbox_defaults( array( 'date', 'rating', 'title', 'time', 'favorites' ) ),
	) );

	$options->add_field( array(
		'name'              => __( 'Taxonomies on the recipe', 'recipes' ),
		'desc'              => __( 'Choose which taxonomies are displayed on a single recipe.', 'recipes' ),
		'id'                => 'categories_on_recipe',
		'type'              => 'multicheck_inline',
		'select_all_button' => false,
		'options_cb'        => 'rcps_get_recipe_filter_options',
		'default'           => mytheme_cmb2_set_checkbox_defaults( array( 'course', 'cuisine', 'skill-level', 'collection', 'recipe-tag' ) ),
	) );

	$options->add_field( array(
		'name'              => __( 'Sharing and printing', 'recipes' ),
		'desc'              => __( 'Choose which social sharing buttons are displayed at the bottom of the recipes.', 'recipes' ),
		'id'                => 'displayed_share_links',
		'type'              => 'multicheck_inline',
		'select_all_button' => false,
		'options'           => array(
			'facebook'  => __( 'Facebook', 'recipes' ),
			'twitter'   => __( 'Twitter', 'recipes' ),
			'pinterest' => __( 'Pinterest', 'recipes' ),
			'print'     => __( 'Print', 'recipes' ),
		),
		'default'           => mytheme_cmb2_set_checkbox_defaults( array( 'facebook', 'twitter', 'pinterest', 'print' ) ),
	) );

	$options->add_field( array(
		'name' => __( 'Linking external recipes', 'recipes' ),
		'desc' => __( 'Link external recipes directly to the recipe source.', 'recipes' ),
		'id'   => 'link_external_recipes_to_source',
		'type' => 'checkbox',
	) );

	$options->add_field( array(
		'name' => __( 'Analytics', 'recipes' ),
		'desc' => __( 'Optional tracking code for the analytics services, for example Google Analytics.', 'recipes' ),
		'id'   => 'analytics',
		'type' => 'textarea_code',
	) );

	$options->add_field( array(
		'name' => __( 'Front-end recipe submission', 'recipes' ),
		'type' => 'title',
		'id'   => 'title_recipe_submission',
	) );

	$options->add_field( array(
		'name' => __( 'Allow submissions for registered users only', 'recipes' ),
		'desc' => __( 'Only registered users can submit recipes.', 'recipes' ),
		'id'   => 'submissions_only_for_registered',
		'type' => 'checkbox',
	) );

	$options->add_field( array(
		'name'    => __( 'Allowed submission types', 'recipes' ),
		'id'      => 'allowed_submission_types',
		'type'    => 'select',
		'options' => array(
			'0' => __( 'Only users own recipes', 'recipes' ),
			'2' => __( 'Only recipes on another sites', 'recipes' ),
			'1' => __( 'Users own recipes, and recipes on another sites', 'recipes' ),
		),
		'default' => '1',
	) );

	$options->add_field( array(
		'name'       => __( 'Displayed fields', 'recipes' ),
		'desc'       => __( 'Choose which fields are displayed on the front-end submit form.', 'recipes' ),
		'id'         => 'displayed_form_fields',
		'type'       => 'multicheck',
		'options_cb' => 'rcps_get_recipe_filter_options',
		'default'    => mytheme_cmb2_set_checkbox_defaults( array( 'ingredient_lists', 'image', 'custom_meta_prep_time', 'custom_meta_cook_time', 'custom_meta_servings', 'custom_meta_calories_in_serving', 'course', 'cuisine', 'special-diet', 'skill-level', 'recipe-tag' ) ),
	) );

	$options->add_field( array(
		'name'       => __( 'Required fields', 'recipes' ),
		'desc'       => __( "Choose which fields are required. Note: you can't require a field which is not displayed. See above.", 'recipes' ),
		'id'         => 'required_form_fields',
		'type'       => 'multicheck',
		'options_cb' => 'rcps_get_recipe_filter_options',
		'default'    => mytheme_cmb2_set_checkbox_defaults( array( 'ingredient_lists', 'image', 'custom_meta_prep_time', 'custom_meta_cook_time', 'custom_meta_servings', 'course', 'cuisine', 'skill-level' ) ),
	) );

	$options->add_field( array(
		'name'       => __( 'Maximum file size for uploaded images', 'recipes' ),
		'desc'       => __( 'Megabytes.', 'recipes' ),
		'id'         => 'max_upload_filesize',
		'default'    => '2',
		'type'       => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'min'  => '1',
			'max'  => '10',
			'step' => '1',
		),
	) );

	$options->add_field( array(
		'name'       => __( 'Minimum width for uploaded images', 'recipes' ),
		'desc'       => __( 'Pixels.', 'recipes' ),
		'id'         => 'uploaded_image_min_width',
		'default'    => 1140,
		'type'       => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'min'  => '560',
		),
	) );

	$options->add_field( array(
		'name'       => __( 'Minimum height for uploaded images', 'recipes' ),
		'desc'       => __( 'Pixels.', 'recipes' ),
		'id'         => 'uploaded_image_min_height',
		'default'    => 500,
		'type'       => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'min'  => '400',
		),
	) );

	$options->add_field( array(
		'name' => __( 'Placeholder Image', 'recipes' ),
		'type' => 'title',
		'id'   => 'title_layout_colors',
	) );

	$options->add_field( array(
		'name' => __( 'Placeholder Image', 'recipes' ),
		'desc' => __( 'Custom placeholder image for recipes without a featured image. Required size: 1140px by 500px or larger.', 'recipes' ),
		'id'   => 'image_placeholder',
		'type' => 'file',
	) );

	$options->add_field( array(
		'name'    => 'Options Saved',
		'id'      => 'options_saved',
		'type'    => 'hidden',
		'default' => date( 'H:i:s Y-m-d' ),
	) );

	/**
	 * Registers secondary options page.
	 */
	$ads = new_cmb2_box( array(
		'id'           => 'rcps_ads_options_page',
		'title'        => __( 'Advertisement', 'recipes' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'rcps_options_ads',
	) );

	$ads->add_field( array(
		'name' => __( 'Ad on the top of the recipe grid', 'recipes' ),
		'id'   => 'option_ad_grid_top',
		'type' => 'textarea_code',
	) );

	$ads->add_field( array(
		'name' => __( 'Ad on the bottom of the recipe grid', 'recipes' ),
		'id'   => 'option_ad_grid_bottom',
		'type' => 'textarea_code',
	) );

	$ads->add_field( array(
		'name' => __( 'Ad on single blog posts, and recipes', 'recipes' ),
		'id'   => 'option_ad_single',
		'type' => 'textarea_code',
	) );
}
add_action( 'cmb2_admin_init', 'mytheme_cmb2_box_theme_options' );

/**
 * Changes text color of CMB2 description to more readable.
 */
add_action('admin_head', function() {
	echo '<style>p.cmb2-metabox-description, span.cmb2-metabox-description {color:#666;}</style>';
});

/**
 * Returns default values for checkboxes.
 *
 * @param  mixed $defaults  On/Off (true/false).
 * @return mixed            Returns true or '', the blank default.
 */
function mytheme_cmb2_set_checkbox_defaults( $defaults ) {

	if ( is_array( $defaults ) && ! mytheme_get_option( 'options_saved' ) ) {
		return $defaults;
	}

	if ( true === $defaults && ! mytheme_get_option( 'options_saved' ) ) {
		return 'on';
	}
}

/**
 * Hides deprecated advertisement options page from menu.
 */
add_action( 'admin_menu', function() {
	remove_menu_page( 'rcps_options_ads' );
}, 999);

/**
 * Returns options for a CMB2 field.
 *
 * @param object $field Current field object.
 * @return array        Array of field options.
 */
function rcps_get_recipe_filter_options( $field ) {

	$options = array();

	if ( 'displayed_filters' === $field->args['id'] ) {
		$options['keyword'] = __( 'Keyword', 'recipes' );

		$taxonomies = get_object_taxonomies( 'recipe', 'objects' );
		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->labels->singular_name;
		}
	} elseif ( 'categories_on_recipe' === $field->args['id'] ) {
		$taxonomies = get_object_taxonomies( 'recipe', 'objects' );
		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->labels->singular_name;
		}
	} elseif ( 'displayed_form_fields' === $field->args['id'] || 'required_form_fields' === $field->args['id'] ) {
		$options = array(
			'ingredient_lists' => __( 'Ingredients', 'recipes' ),
			'image'            => __( 'Image', 'recipes' ),
		);

		if ( class_exists( '\CMB2_Boxes' ) ) {

			// Add CMB2 fields to the array.
			$meta_boxes = \CMB2_Boxes::get_all();

			if ( ! empty( $meta_boxes ) ) {
				foreach ( $meta_boxes as $meta_box ) {
					foreach ( $meta_box->meta_box['fields'] as $meta_key => $values ) {

						// Skip external recipe meta as they are always required.
						if ( 'custom_meta_external_url' === $meta_key || 'custom_meta_external_site' === $meta_key ) {
							continue;
						}

						// Add only the fields which have the 'rcps_form_display' parameter set to true.
						if ( ! empty( $values['rcps_form_display'] ) && true === $values['rcps_form_display'] ) {
							// Translators: %s is the meta field name.
							$options[ $meta_key ] = sprintf( esc_html__( 'Meta: %s', 'recipes' ), $values['name'] );
						}
					}
				}
			}
		}

		$taxonomies = get_object_taxonomies( 'recipe', 'objects' );
		foreach ( $taxonomies as $taxonomy ) {
			// Translators: %s is the taxonomy singular name.
			$options[ $taxonomy->name ] = sprintf( esc_html__( 'Taxonomy: %s', 'recipes' ), $taxonomy->labels->singular_name );
		}
	}

	return $options;
}

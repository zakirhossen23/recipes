<?php
/**
 * Customizer.php
 *
 * @package Recipes WordPress Theme
 */

/**
 * Adds customizer sections, settings, and controls.
 *
 * @param  WP_Customize_Manager $wp_customize Instance of the WP_Customize_Manager class.
 */
function mytheme_customize_register( $wp_customize ) {

	$wp_customize->add_section( 'rcps', array(
		'title'    => 'Recipes Theme',
		'priority' => 0,
	) );

	$wp_customize->add_setting( 'recipes_per_page', array(
		'default'           => '18',
		'type'              => 'theme_mod',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'recipes_per_page', array(
		'label'       => __( 'Number of recipes', 'recipes' ),
		'description' => __( 'Set the number of recipes per page.', 'recipes' ),
		'section'     => 'rcps',
		'settings'    => 'recipes_per_page',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'tax_on_card_array', array(
		'default'           => array( 'course' ),
		'type'              => 'theme_mod',
		'transport'         => 'refresh',
		'sanitize_callback' => 'rcps_sanitize_array',
	) );

	$wp_customize->add_control(
		new Rcps_Customizer_Checkbox_Multiple(
			$wp_customize,
			'tax_on_card_array',
			array(
				'section'     => 'rcps',
				'label'       => __( 'Taxonomy on the recipe', 'recipes' ),
				'description' => __( 'Select which taxonomies are displayed before the recipe card title.', 'recipes' ),
				'choices'     => mytheme_get_customizer_taxonomy_choices(),
			)
		)
	);

	$wp_customize->add_setting( 'show_author_in', array(
		'default'           => array( 'recipe_card', 'blog_post_card', 'single_blog_post', 'single_recipe' ),
		'type'              => 'theme_mod',
		'transport'         => 'refresh',
		'sanitize_callback' => 'rcps_sanitize_array',
	) );

	$wp_customize->add_control(
		new Rcps_Customizer_Checkbox_Multiple(
			$wp_customize,
			'show_author_in',
			array(
				'section' => 'rcps',
				'label'   => __( 'Show author in', 'recipes' ),
				'choices' => array(
					'recipe_card'      => __( 'Recipe Card', 'recipes' ),
					'blog_post_card'   => __( 'Blog Post Card', 'recipes' ),
					'single_blog_post' => __( 'Single Blog Post', 'recipes' ),
					'single_recipe'    => __( 'Single Recipe', 'recipes' ),
				),
			)
		)
	);

	$wp_customize->add_setting( 'displayed_meta_fields_recipe_card', array(
		'default'           => array( 'total_time', 'ingredients_number', 'external_site_title', 'permalink' ),
		'type'              => 'theme_mod',
		'transport'         => 'refresh',
		'sanitize_callback' => 'rcps_sanitize_array',
	) );

	$wp_customize->add_control(
		new Rcps_Customizer_Checkbox_Multiple(
			$wp_customize,
			'displayed_meta_fields_recipe_card',
			array(
				'section'     => 'rcps',
				'label'       => __( 'Meta fields on the recipe card.', 'recipes' ),
				'description' => __( 'Select which meta fields are displayed on the recipe card.', 'recipes' ),
				'choices'     => array(
					'total_time'          => __ ( 'Total time', 'recipes' ),
					'ingredients_number'  => __ ( 'Ingredients', 'recipes' ),
					'views'               => __ ( 'Views', 'recipes' ),
					'date'                => __ ( 'Date', 'recipes' ),
					'comments'            => __ ( 'Comments', 'recipes' ),
					'external_site_title' => __ ( 'External Recipe Site Title', 'recipes' ),
					'permalink'           => __ ( 'External Recipe Permalink', 'recipes' ),
				),
			)
		)
	);

	$wp_customize->add_setting( 'show_featured_image_after_title', array(
		'default'           => true,
		'type'              => 'theme_mod',
		'transport'         => 'refresh',
		'sanitize_callback' => 'rcps_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'show_featured_image_after_title', array(
		'type'    => 'checkbox',
		'section' => 'rcps',
		'label'   => __( 'Show the featured image after blog post title.', 'recipes' ),
	) );

	$wp_customize->add_setting( 'show_featured_image_after_recipe_title', array(
		'default'           => true,
		'type'              => 'theme_mod',
		'transport'         => 'refresh',
		'sanitize_callback' => 'rcps_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'show_featured_image_after_recipe_title', array(
		'type'    => 'checkbox',
		'section' => 'rcps',
		'label'   => __( 'Show the featured image after recipe title.', 'recipes' ),
	) );

	$wp_customize->add_setting( 'theme', array(
		'default'           => 'dark',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_html_class',
	) );

	$wp_customize->add_control( 'theme', array(
		'label'       => __( 'Theme', 'recipes' ),
		'description' => __( 'Are you using a light or dark background? This setting affects text colors used on the header and footer.', 'recipes' ),
		'section'     => 'colors',
		'settings'    => 'theme',
		'type'        => 'radio',
		'choices'     => array(
			'dark'  => __( 'Dark', 'recipes' ),
			'light' => __( 'Light', 'recipes' ),
		),
	) );

	$wp_customize->add_setting( 'font_body', array(
		'default'           => '12',
		'type'              => 'theme_mod',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'font_body', array(
		'label'    => __( 'Body Font', 'recipes' ),
		'section'  => 'rcps',
		'settings' => 'font_body',
		'type'     => 'select',
		'choices'  => mytheme_get_font_options(),
	) );

	$wp_customize->add_setting( 'font_headers', array(
		'default'           => '12',
		'type'              => 'theme_mod',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'font_headers', array(
		'label'    => __( 'Header Font', 'recipes' ),
		'section'  => 'rcps',
		'settings' => 'font_headers',
		'type'     => 'select',
		'choices'  => mytheme_get_font_options(),
	) );

	// Colors.
	$colors[] = array(
		'slug'    => 'color_links',
		'default' => get_theme_mod( 'color_accent', '#cd8d5f' ),
		'label'   => __( 'Link Color', 'recipes' ),
	);

	$colors[] = array(
		'slug'    => 'color_favorite',
		'default' => '#ff5459',
		'label'   => __( 'Favorite Icon Color', 'recipes' ),
	);

	$colors[] = array(
		'slug'    => 'color_title_background',
		'default' => '#292726',
		'label'   => __( 'Title Background Color', 'recipes' ),
	);

	$colors[] = array(
		'slug'    => 'color_star_rating',
		'default' => '#dbc164',
		'label'   => __( 'Rating Star Color', 'recipes' ),
	);

	$colors[] = array(
		'slug'    => 'color_term_background',
		'default' => '#ffff66',
		'label'   => __( 'Term Background Color', 'recipes' ),
	);

	// Add settings and controls for each color.
	foreach ( $colors as $color ) {

		$wp_customize->add_setting(
			$color['slug'], array(
				'default'           => $color['default'],
				'type'              => 'theme_mod',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			$color['slug'],
			array(
				'label'    => $color['label'],
				'section'  => 'colors',
				'settings' => $color['slug'],
			)
		) );
	}
}
add_action( 'customize_register', 'mytheme_customize_register' );

/**
 * Enqueues script used by the customizer.
 */
function mytheme_customizer_scripts() {

	wp_enqueue_script(
		'mytheme-theme-customize',
		get_template_directory_uri() . '/js/theme-customize.js',
		array( 'jquery', 'customize-preview' ),
		RCPS_THEME_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'mytheme_customizer_scripts' );

/**
 * Returns font options.
 *
 * @return array  Array of font options
 */
function mytheme_get_font_options() {

	$options = array(
		'1'  => 'Alegreya',
		'7'  => 'Alegreya Sans',
		'11' => 'Archivo Narrow',
		'6'  => 'Cabin',
		'10' => 'Chivo',
		'9'  => 'Fira Sans',
		'2'  => 'Gentium Book Basic',
		'16' => 'IBM Plex Sans',
		'15' => 'IBM Plex Serif',
		'12' => 'Karla',
		'8'  => 'Lato',
		'4'  => 'Lora',
		'13' => 'Noto Sans',
		'14' => 'Noto Serif',
		'17' => 'Poppins',
		'3'  => 'PT Serif',
		'5'  => 'Source Sans Pro',
	);

	return $options;
}

/**
 * Returns options for taxonomy displayed on recipe cards.
 *
 * @return array  Array of taxonomies
 */
function mytheme_get_customizer_taxonomy_choices() {

	$options = array();

	$taxonomies = get_object_taxonomies( 'recipe', 'objects' );

	foreach ( $taxonomies as $taxonomy ) {
		$options[ $taxonomy->name ] = $taxonomy->labels->singular_name;
	}

	return $options;
}

/**
 * Sanitizes multi checkbox.
 *
 * @param [type] $values Values.
 */
function rcps_sanitize_array( $values ) {

	$multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;

	return ! empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}

/**
 * Sanitizes checkbox value
 *
 * @param [type] $checked Value.
 * @return boolean
 */
function rcps_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

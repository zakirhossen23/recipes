<?php
/**
 * Meta-boxes.php
 *
 * CMB2 Meta Boxes.
 *
 * @package CMB2
 * @link https://github.com/WebDevStudios/CMB2
 */

/**
 * Sets meta boxes for the homepage template.
 */
function mytheme_custom_meta_homepage_template() {

	$cmb2 = new_cmb2_box( array(
		'id'           => 'custom_meta_homepage_template',
		'title'        => __( 'Homepage Settings', 'recipes' ),
		'object_types' => array( 'page' ),
		'show_on'      => array(
			'key'   => 'page-template',
			'value' => 'page-home.php',
		),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true,
	) );

	$cmb2->add_field( array(
		'name'       => __( 'Search suggestions', 'recipes' ),
		'desc'       => __( 'Deprecated. Use widgets at Appearance > Widgets to build the homepage.', 'recipes' ),
		'id'         => 'custom_meta_homepage_search_suggestions',
		'type'       => 'text',
		'attributes' => array(
			'readonly' => 'readonly',
		),
	) );

	$cmb2->add_field( array(
		'name'       => __( 'Title shown before the search suggestions', 'recipes' ),
		'desc'       => __( 'Deprecated. Use widgets at Appearance > Widgets to build the homepage.', 'recipes' ),
		'id'         => 'custom_meta_homepage_search_suggestions_title',
		'default'    => __( 'Popular searches', 'recipes' ),
		'type'       => 'text',
		'attributes' => array(
			'readonly' => 'readonly',
		),
	) );

	$cmb2->add_field( array(
		'name' => __( 'Display footer widgets on homepage', 'recipes' ),
		'id'   => 'custom_meta_homepage_display_widgets',
		'type' => 'checkbox',
	) );
}
add_action( 'cmb2_admin_init', 'mytheme_custom_meta_homepage_template' );

/**
 * Registers meta box for post settings.
 */
function rcps_cmb2_box_post_settings() {

	$cmb = new_cmb2_box( array(
		'id'           => 'rcps_cmb2_box_post_settings',
		'title'        => __( 'Post Settings', 'recipes' ),
		'object_types' => array( 'post', 'recipe' ),
		'context'      => 'side',
		'priority'     => 'default',
		'show_names'   => true,
		'closed'       => false,
	) );

	$cmb->add_field( array(
		'name'    => __( 'Show the featured image after title', 'recipes' ),
		'desc'    => __( 'If not set, the option from the Customizer is used.', 'recipes' ),
		'id'      => '_rcps_meta_show_featured_image',
		'type'    => 'radio_inline',
		'options' => array(
			'on'  => __( 'Yes', 'recipes' ),
			'off' => __( 'No', 'recipes' ),
		),
		'column'  => true,
	) );
}
add_action( 'cmb2_admin_init', 'rcps_cmb2_box_post_settings' );

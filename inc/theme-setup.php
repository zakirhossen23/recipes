<?php
/**
 * Theme-setup.php
 *
 * @package Recipes WordPress Theme
 */

/**
 * Sets the content width.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

if ( ! function_exists( 'mytheme_after_setup_theme' ) ) {
	/**
	 * Setups theme.
	 */
	function mytheme_after_setup_theme() {

		/**
		 * Registers theme support, enables editor styling, sets translation domain.
		 */
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'align-wide' );

		// Disable block widgets.
		remove_theme_support( 'widgets-block-editor' );

		$logo_defaults = array(
			'flex-height' => true,
			'flex-width'  => true,
		);
		add_theme_support( 'custom-logo', $logo_defaults );

		$background_defaults = array(
			'default-color'          => '#292726',
			'default-image'          => get_template_directory_uri() . '/images/default-background.jpg',
			'default-repeat'         => 'no-repeat',
			'default-position-x'     => 'center',
			'default-position-y'     => 'top',
			'default-size'           => 'auto',
			'default-attachment'     => 'scroll',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		);
		add_theme_support( 'custom-background', $background_defaults );

		add_editor_style();
		load_theme_textdomain( 'recipes', get_template_directory() . '/languages' );

		/**
		 * Enables navigation.
		 */
		register_nav_menus(
			array(
				'main'          => __( 'Main Navigation', 'recipes' ),
				'footer'        => __( 'Footer Navigation', 'recipes' ),
				'social_header' => __( 'Header Social Links', 'recipes' ),
				'social_footer' => __( 'Footer Social Links', 'recipes' ),
			)
		);

		/**
		 * Sets thumbnail sizes.
		 */
		set_post_thumbnail_size( 48, 48, true );
		add_image_size( 'img-64', 64, 64, true );
		add_image_size( 'img-96', 96, 96, true );
		add_image_size( 'img-280', 280, 200, true );
		add_image_size( 'img-560', 560, 400, true );
		add_image_size( 'img-1140', 1140, 500, true );

		add_image_size( 'rcps-img-480x480', 480, 480, true );
		add_image_size( 'rcps-img-640x480', 640, 480, true );
		add_image_size( 'rcps-img-640x360', 640, 360, true );
	}
}
add_action( 'after_setup_theme', 'mytheme_after_setup_theme' );

if ( ! function_exists( 'mytheme_styles_scripts' ) ) {
	/**
	 * Enqueues styles and scripts.
	 */
	function mytheme_styles_scripts() {

		wp_enqueue_style( 'recipes-style', get_stylesheet_uri(), '', RCPS_THEME_VERSION, 'screen' );
		$custom_css = mytheme_get_custom_css();
		wp_add_inline_style( 'recipes-style', $custom_css );

		wp_enqueue_style( 'print-style', get_template_directory_uri() . '/print.css', '', RCPS_THEME_VERSION, 'print' );

		wp_enqueue_script( 'recipes-scripts', get_template_directory_uri() . '/js/scripts.js', false, RCPS_THEME_VERSION, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script( 'svg4everybody', get_template_directory_uri() . '/js/svg4everybody.min.js', '', '2.1.9', false );
		wp_add_inline_script( 'svg4everybody', 'svg4everybody();' );

		wp_enqueue_script( 'html5shiv', '//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js', false, '3.7.3', false );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 10' );

		wp_enqueue_script( 'respond', '//oss.maxcdn.com/respond/1.4.2/respond.min.js', false, '1.4.2', false );
		wp_script_add_data( 'respond', 'conditional', 'lt IE 10' );

		global $wp_query;

		$localize_args = array(
			'url'            => admin_url( 'admin-ajax.php' ),
			'nonce'          => wp_create_nonce( 'ajax-nonce' ),
			'current_page'   => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
			'max_page'       => $wp_query->max_num_pages,
			'text_load_more' => __( 'Load more', 'recipes' ),
			'text_loading'   => __( 'Loading...', 'recipes' ),
		);

		wp_localize_script( 'recipes-scripts', 'ajax_var', $localize_args );
	}
}
add_action( 'wp_enqueue_scripts', 'mytheme_styles_scripts' );

/**
 * Dequeues scripts.
 */
function mytheme_dequeue_scripts() {

	if ( ! is_user_logged_in() ) {
		wp_dequeue_script( 'favorites' );
	}
}
add_action( 'wp_print_scripts', 'mytheme_dequeue_scripts', 100 );

if ( ! function_exists( 'mytheme_widgets_init' ) ) {
	/**
	 * Registers widget areas.
	 */
	function mytheme_widgets_init() {
		register_sidebar(
			array(
				'name'          => __( 'Homepage Widgets', 'recipes' ),
				'id'            => 'rcps-homepage-widgets',
				'before_widget' => '<div id="%1$s" class="rcps-homepage-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Left', 'recipes' ),
				'id'            => 'sidebar-widget-area-1',
				'before_widget' => '<div id="%1$s" class="rcps-widget-container %2$s">',
				'after_widget'  => '</div><!-- .rcps-widget-container -->',
				'before_title'  => '<h3 class="rcps-widget-title"><span>',
				'after_title'   => '</span></h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Center', 'recipes' ),
				'id'            => 'sidebar-widget-area-2',
				'before_widget' => '<div id="%1$s" class="rcps-widget-container %2$s">',
				'after_widget'  => '</div><!-- .rcps-widget-container -->',
				'before_title'  => '<h3 class="rcps-widget-title"><span>',
				'after_title'   => '</span></h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Right', 'recipes' ),
				'id'            => 'sidebar-widget-area-3',
				'before_widget' => '<div id="%1$s" class="rcps-widget-container %2$s">',
				'after_widget'  => '</div><!-- .rcps-widget-container -->',
				'before_title'  => '<h3 class="rcps-widget-title"><span>',
				'after_title'   => '</span></h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Recipe Grid: Top', 'recipes' ),
				'id'            => 'rcps-recipe-grid-widgets-top',
				'before_widget' => '<div id="%1$s" class="rcps-widget-center rcps-recipe-grid-widgets-top %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Recipe Grid: Bottom', 'recipes' ),
				'id'            => 'rcps-recipe-grid-widgets-bottom',
				'before_widget' => '<div id="%1$s" class="rcps-widget-center rcps-recipe-grid-widgets-bottom %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Single Post: Bottom', 'recipes' ),
				'id'            => 'rcps-single-post-widgets-bottom',
				'before_widget' => '<div id="%1$s" class="rcps-widget-center rcps-single-post-widgets-bottom %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Single Recipe: Bottom', 'recipes' ),
				'id'            => 'rcps-single-recipe-widgets-bottom',
				'before_widget' => '<div id="%1$s" class="rcps-widget-center rcps-single-recipe-widgets-bottom %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Single Recipe: After Comments', 'recipes' ),
				'id'            => 'rcps-single-recipe-widgets-after-comments',
				'before_widget' => '<div id="%1$s" class="rcps-single-recipe-widgets-after-comments %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Single Post: After Comments', 'recipes' ),
				'id'            => 'rcps-single-post-widgets-after-comments',
				'before_widget' => '<div id="%1$s" class="rcps-single-post-widgets-after-comments %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Header: Top', 'recipes' ),
				'id'            => 'rcps-widgets-header-top',
				'before_widget' => '<div id="%1$s" class="%2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'mytheme_widgets_init' );

if ( ! function_exists( 'mytheme_custom_titles' ) ) {
	/**
	 * Customizes title for the search template.
	 *
	 * @param  [string] $title Page title.
	 */
	function mytheme_custom_titles( $title ) {

		if ( is_search() && is_post_type_archive( 'recipe' ) && ! get_query_var( 's' ) ) {
			$title = wp_title( '', false, 'right' ) . ' | ' . get_bloginfo( 'name' );
		}

		return $title;
	}
}
add_filter( 'pre_get_document_title', 'mytheme_custom_titles' );

if ( ! function_exists( 'mytheme_custom_titles_separator' ) ) {
	/**
	 * Sets the title separator.
	 *
	 * @param  string $separator Page title separator.
	 */
	function mytheme_custom_titles_separator( $separator ) {

		$separator = '|';

		return $separator;
	}
}
add_filter( 'document_title_separator', 'mytheme_custom_titles_separator', 10 );

if ( ! function_exists( 'mytheme_mime_types' ) ) {
	/**
	 * Allows SVG uploads.
	 *
	 * @param  array $mimes Current array of mime types.
	 */
	function mytheme_mime_types( $mimes ) {

		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
}
add_filter( 'upload_mimes', 'mytheme_mime_types' );

if ( ! function_exists( 'mytheme_caption_padding' ) ) {
	/**
	 * Cleans captions (removes the added 10px width).
	 *
	 * @param  array $attrs Attributes.
	 */
	function mytheme_caption_padding( $attrs ) {

		if ( ! empty( $attrs['width'] ) ) {
			$attrs['width'] -= 10;
		}

		return $attrs;
	}
}
add_filter( 'shortcode_atts_caption', 'mytheme_caption_padding' );

/**
 * Deactivates plugins.
 */
function rcps_deactivate_plugins() {
	deactivate_plugins( '/relevanssi/relevanssi.php' );
}
add_action( 'admin_init', 'rcps_deactivate_plugins' );

/**
 * Disables Relevanssi if the plugin is still active.
 */
function rcps_disable_relevanssi() {
	remove_filter( 'posts_request', 'relevanssi_prevent_default_request' );
	remove_filter( 'the_posts', 'relevanssi_query', 99 );
}
add_action( 'init', 'rcps_disable_relevanssi' );

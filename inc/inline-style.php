<?php
/**
 * Inline-style.php
 *
 * Imports fonts from Google Fonts and creates custom inline CSS styles based on the Theme Options.
 *
 * @package Recipes WordPress Theme
 */

/**
 * Returns selected font to use in Google Webfont import and custom CSS.
 *
 * @param  string $type CSS font stack or font families for Google import script.
 * @return string|array A string or an array for CSS font family or Google import.
 */
function mytheme_get_the_fonts( $type ) {

	$option_font_headers = get_theme_mod( 'font_headers', 12 );
	$option_font_body    = get_theme_mod( 'font_body', 12 );

	// Check if the font options are set, else return false.
	if ( is_numeric( $option_font_headers ) && is_numeric( $option_font_headers ) ) {
		$fonts = array(
			'1'  => array( 'Alegreya', 'serif' ),
			'2'  => array( 'Gentium Book Basic', 'serif' ),
			'3'  => array( 'PT Serif', 'serif' ),
			'4'  => array( 'Lora', 'serif' ),
			'5'  => array( 'Source Sans Pro', 'sans-serif' ),
			'6'  => array( 'Cabin', 'sans-serif' ),
			'7'  => array( 'Alegreya Sans', 'sans-serif' ),
			'8'  => array( 'Lato', 'sans-serif' ),
			'9'  => array( 'Fira Sans', 'sans-serif' ),
			'10' => array( 'Chivo', 'sans-serif' ),
			'11' => array( 'Archivo Narrow', 'sans-serif' ),
			'12' => array( 'Karla', 'sans-serif' ),
			'13' => array( 'Noto Sans', 'sans-serif' ),
			'14' => array( 'Noto Serif', 'serif' ),
			'15' => array( 'IBM Plex Serif', 'serif' ),
			'16' => array( 'IBM Plex Sans', 'sans-serif' ),
			'17' => array( 'Poppins', 'sans-serif' ),
		);

		$font_stacks = array(
			'serif'      => 'Georgia,serif',
			'sans-serif' => 'Arial,sans-serif',
		);

		// Get font families.
		$font_headers = $fonts[ $option_font_headers ][0];
		$font_body    = $fonts[ $option_font_body ][0];

		// Get font stacks.
		$css_font_stack_headers = $font_stacks[ $fonts[ $option_font_headers ][1] ];
		$css_font_stack_body    = $font_stacks[ $fonts[ $option_font_body ][1] ];

		if ( 'google' === $type ) {
			if ( $option_font_headers !== $option_font_body ) {
				$return = array(
					'header' => $font_headers,
					'body'   => $font_body,
				);
			} elseif ( $option_font_headers === $option_font_body ) {
				$return = $font_headers;
			}
		} elseif ( 'css' === $type ) {
			$return = array(
				'header' => '"' . $font_headers . '",' . $css_font_stack_headers,
				'body'   => '"' . $font_body . '",' . $css_font_stack_body,
			);
		}

		return $return;
	} else {
		return false;
	}
}

/**
 * Imports the selected fonts from Google Fonts.
 */
function mytheme_import_fonts_from_google_fonts() {

	$fonts = mytheme_get_the_fonts( 'google' );

	if ( $fonts ) {
		if ( is_array( $fonts ) ) {
			$fonts = implode( ':400,400i,700,700i|', $fonts ) . ':400,400i,700,700i';
		} else {
			$fonts = $fonts . ':400,400i,700,700i';
		}

		// Replace dashes in font family.
		$fonts = str_replace( ' ', '+', $fonts );

		wp_enqueue_style( 'google-webfonts', '//fonts.googleapis.com/css?family=' . $fonts . '&display=swap', '', RCPS_THEME_VERSION, 'screen' );
	}
}
add_action( 'wp_enqueue_scripts', 'mytheme_import_fonts_from_google_fonts' );

/**
 * Adds custom inline CSS to the head.
 */
function mytheme_get_custom_css() {

	$color_links            = get_theme_mod( 'color_links', '#cd8d5f' );
	$color_favorite         = get_theme_mod( 'color_favorite', '#ff5459' );
	$color_title_background = get_theme_mod( 'color_title_background', '#292726' );
	$color_star_rating      = get_theme_mod( 'color_star_rating', '#dbc164' );
	$color_term_background  = get_theme_mod( 'color_term_background', '#ffff66' );

	$title_color_contrast           = mytheme_get_contrast( $color_title_background, 'dark', 'light' );
	$term_background_color_contrast = mytheme_get_contrast( $color_term_background, 'dark', 'light' );

	$get_the_fonts = mytheme_get_the_fonts( 'css' );
	if ( $get_the_fonts && ! empty( $get_the_fonts['body'] ) && ! empty( $get_the_fonts['header'] ) ) {
		$font_family_body    = $get_the_fonts['body'];
		$font_family_headers = $get_the_fonts['header'];
	}

	ob_start();
	?>
	body {font-family:<?php echo wp_kses( $font_family_body, array( '\"' ) ); ?>;}
	<?php if ( $font_family_body !== $font_family_headers ) { ?>
		h1, .rcps-h1, h2, h3, h4, h5, h6 {font-family:<?php echo wp_kses( $font_family_headers, array( '\"' ) ); ?>}
	<?php } ?>
	<?php if ( 'dark' === $title_color_contrast ) { ?>
		.rcps-hero-overlay {color:#f8f8f8;}
		.rcps-icon-on-hero {fill:#f8f8f8;}
	<?php } ?>
	.rcps-single-favorite .simplefavorite-button:after {content:"<?php esc_html_e( 'Add to favorites', 'recipes' ); ?>";}
	.rcps-single-favorite .simplefavorite-button.active:after {content:"<?php esc_html_e( 'In your favorites', 'recipes' ); ?>";}
	a {color:<?php echo esc_attr( $color_links ); ?>;}
	.rcps-title-header h1 a, .rcps-title-header a.rcps-h1, .rcps-nav-main-ul > li > a[aria-current="page"], .rcps-author-top a {text-decoration-color:<?php echo esc_attr( $color_links ); ?>;}
	.rcps-icon-heart-favorited, .rcps-input-checkbox:checked + label .rcps-icon {fill:<?php echo esc_attr( $color_favorite ); ?>;}
	.rcps-tabs-nav-active a {border-bottom-color:<?php echo esc_attr( $color_links ); ?>;}
	.rcps-hero-overlay {background:<?php echo esc_attr( $color_title_background ); ?>;background:rgba(<?php echo esc_attr( mytheme_hex2rgb( $color_title_background ) ); ?>, 0.9);}
	.rcps-rating-stars .rcps-icon {fill:<?php echo esc_attr( $color_star_rating ); ?>;}

	<?php if ( ! empty( $color_term_background ) ) : ?>
		.rcps-item-tax a, .rcps-item-tax span {background-color:<?php echo esc_attr( $color_term_background ); ?>;}
		<?php if ( 'dark' === $term_background_color_contrast ) : ?>
			.rcps-item-tax a, .rcps-item-tax span {color:#f8f8f8;}
		<?php endif; ?>
	<?php endif; ?>

	<?php
	$css = ob_get_clean();

	return preg_replace( '/\s+/S', ' ', $css );
}

if ( ! function_exists( 'mytheme_login_inline_css' ) ) {
	/**
	 * Adds custom inline CSS to the login page head.
	 */
	function mytheme_login_inline_css() {

		if ( ! get_background_color() ) {
			if ( 'light' === get_theme_mod( 'theme', 'dark' ) ) {
				$background_color = 'fff';
			} elseif ( 'dark' === get_theme_mod( 'theme', 'dark' ) ) {
				$background_color = '292726';
			}
		} elseif ( get_background_color() ) {
			$background_color = get_background_color();
		}

		ob_start();
		?>

		<?php if ( ! empty( $background_color ) ) : ?>
			html {background-color: #<?php echo esc_attr( $background_color ); ?>;}
			body.login {background-color: #<?php echo esc_attr( $background_color ); ?>;}
		<?php endif; ?>

		<?php if ( get_background_image() ) : ?>
			body.login {
				background-image: url(<?php echo esc_attr( get_background_image() ); ?>);
				background-position: <?php echo esc_attr( get_theme_mod( 'background_position_x', 'center' ) ); ?> <?php echo esc_attr( get_theme_mod( 'background_position_y', 'top' ) ); ?>;
				background-size: <?php echo esc_attr( get_theme_mod( 'background_size', 'auto' ) ); ?>;
				background-repeat: <?php echo esc_attr( get_theme_mod( 'background_repeat', 'no-repeat' ) ); ?>;
				background-attachment: <?php echo esc_attr( get_theme_mod( 'background_attachment', 'scroll' ) ); ?>;
			}
		<?php endif; ?>

		<?php if ( has_custom_logo() ) : ?>
			<?php $custom_logo_id = get_theme_mod( 'custom_logo' ); ?>
			<?php $logo = wp_get_attachment_image_src( $custom_logo_id, 'thumbnail' ); ?>
			body.login div#login h1 a {
				background-image: url(<?php echo esc_url( $logo[0] ); ?>);
			}
		<?php endif; ?>

		<?php if ( 'dark' === get_theme_mod( 'theme', 'dark' ) ) : ?>
			body.login #nav a, body.login #backtoblog a {
				color: #bbb;
			}
		<?php endif; ?>

		<?php
		$custom_css = ob_get_clean();

		wp_add_inline_style( 'login', $custom_css );
	}
}
add_action( 'login_enqueue_scripts', 'mytheme_login_inline_css' );

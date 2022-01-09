<?php
/**
 * Images.php
 *
 * @package Recipes WordPress Theme
 */

/**
 * Filters HTML used for post thumbnails.
 * Fallback images are used if the post has not a thumbnail.
 *
 * @param string       $html              The post thumbnail HTML.
 * @param int          $post_id           The post ID.
 * @param string       $post_thumbnail_id The post thumbnail ID.
 * @param string|array $size              The post thumbnail size.
 * @param string       $attr              Query string of attributes.
 *
 * @return string
 */
function rcps_filter_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) {

	if ( is_admin() ) {
		return $html;
	}

	// Post has no thumbnail. Use the placeholder image if set.
	if ( empty( $html ) ) {
		$attr['loading'] = 'eager';

		if ( 'img-1140' === $size ) {
			$attr['width']  = '1140';
			$attr['height'] = '500';
			$attr['src']    = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABHQAAAH0CAMAAABrWor7AAAAA1BMVEXd3d3u346CAAACP0lEQVR4Ae3BMQEAAADCIPunNsReYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEBytPwAAW5HbeQAAAAASUVORK5CYII=';
		} elseif ( 'img-560' === $size ) {
			$attr['width']  = '280';
			$attr['height'] = '200';
			$attr['src']    = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAARgAAADICAMAAAAEGQ4lAAAAA1BMVEXd3d3u346CAAAATUlEQVR42u3BAQ0AAADCoPdPbQ8HFAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAI8G24gAAbc3P+EAAAAASUVORK5CYII=';
		} elseif ( 'img-96' === $size ) {
			$attr['width']  = '48';
			$attr['height'] = '48';
			$attr['src']    = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAA1BMVEXd3d3u346CAAAAGUlEQVRIx+3BgQAAAADDoPlT3+AEVQEA8AwJMAAB0q0T2gAAAABJRU5ErkJggg==';
		} else {
			return $html;
		}

		if ( mytheme_get_option( 'image_placeholder' ) ) {
			$placeholder_image_id = mytheme_get_option( 'image_placeholder_id' );

			$attr['src']     = wp_get_attachment_image_src( $placeholder_image_id, $size )[0];
			$attr['loading'] = 'lazy';
		}

		ob_start();
		echo '<img ';
		foreach ( $attr as $key => $value ) {
			if ( ! empty( $key ) ) {
				if ( ! empty( $key ) && ! empty( $value ) ) {
					echo esc_attr( $key ) . '="' . esc_attr( $value ) . '" ';
				}
			}
		}
		echo '>';
		$html = ob_get_clean();

		// Replace 'src' attribute with 'data-src', and 'srcset' with 'data-srcset' to support lazy loading of images.
		if ( 'lazy' === $attr['loading'] ) {
			$html = str_replace( 'src="', 'data-src="', $html );
			$html = str_replace( 'srcset="', 'data-srcset="', $html );
		}
	}

	if ( 'img-96' === $size ) {
		$html = str_replace( 'width="96"', 'width="48"', $html );
		$html = str_replace( 'height="96"', 'height="48"', $html );
	} elseif ( 'img-560' === $size ) {
		$html = str_replace( 'width="560"', 'width="280"', $html );
		$html = str_replace( 'height="400"', 'height="200"', $html );
	}

	return $html;
}
add_filter( 'post_thumbnail_html', 'rcps_filter_post_thumbnail_html', 10, 5 );

/**
 * Filters image attributes.
 *
 * @param array        $attr       Attributes for the image markup.
 * @param WP_Post      $attachment Image attachment post.
 * @param string|array $size       Requested size.
 *
 * @return array
 */
function rcps_filter_attachment_image_attributes( $attr, $attachment, $size ) {

	// Modify attributes of images which have 'lazyload' class.
	if ( ! is_admin() && ! empty( $attr['class'] && strpos( $attr['class'], 'lazyload' ) !== false ) ) {

		// Add 'loading' attribute to support native lazy loading.
		$attr['loading'] = 'lazy';

		// Replace 'src' attribute with 'data-src' to support lazy loading of images.
		$attr['data-src'] = $attr['src'];
		unset( $attr['src'] );

		// Replace also 'srcset' with 'data-srcset' if set.
		if ( ! empty( $attr['srcset'] ) ) {
			$attr['data-srcset'] = $attr['srcset'];
			unset( $attr['srcset'] );
		}
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'rcps_filter_attachment_image_attributes', 10, 3 );

/**
 * Returns the ID of the term image or the thumbnail ID from one of the posts using the term.
 *
 * @param  WP_Term $term WP_Term object.
 *
 * @return int Image ID.
 */
function mytheme_get_term_image_id( $term ) {

	if ( empty( $term->term_id ) || empty( $term->taxonomy ) ) {
		return false;
	}

	// Try to get the image id from the term meta.
	$term_image_id = get_term_meta( $term->term_id, '_rcps_meta_term_image_id', true );

	if ( ! empty( $term_image_id ) ) {
		return $term_image_id;
	}

	// If term image meta is not set, get the thumbnail image from one of the recipes.
	$args_recipes = array(
		'post_type'      => 'recipe',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'fields'         => 'ids',
		'posts_per_page' => 1,
		'tax_query'      => array( // phpcs:ignore slow query ok.
			array(
				'taxonomy' => $term->taxonomy,
				'terms'    => $term->term_id,
			),
		),
		'meta_query'     => array( // phpcs:ignore slow query ok.
			array(
				'key' => '_thumbnail_id',
			),
		),
	);

	$args_recipes = apply_filters( 'rcps_filter_get_term_image_id_wp_query_args', $args_recipes );

	$wp_query_recipes = new WP_Query( $args_recipes );

	// If a post is found save the thumbnail id as term meta.
	if ( $wp_query_recipes->have_posts() ) {
		$term_image_id = get_post_thumbnail_id( $wp_query_recipes->posts[0] );
		update_term_meta( $term->term_id, '_rcps_meta_term_image_id', $term_image_id );
		wp_reset_postdata();
		return $term_image_id;
	}

	return false;
}

if ( ! function_exists( 'rcps_user_avatar' ) ) {
	/**
	 * Displays avatars.
	 *
	 * @param  int    $user_id        User ID.
	 * @param  string $thumbnail_name Thumbnail name.
	 * @param  int    $image_size     Image size in pixels.
	 * @param  string $class          CSS classes added to the img.
	 */
	function rcps_user_avatar( $user_id, $thumbnail_name, $image_size, $class = null ) {

		$avatar = wp_get_attachment_image_src( get_the_author_meta( 'custom_meta_avatar_id', $user_id ), $thumbnail_name );

		if ( ! empty( $avatar ) ) {
			$src = $avatar[0];
		} elseif ( empty( $avatar ) ) {
			if ( 'img-64' === $thumbnail_name ) {
				$src = get_avatar_url( $user_id, array( 'size' => 64 ) );
			} else {
				$src = get_avatar_url( $user_id, array( 'size' => 96 ) );
			}
		}

		$img = '<img src="' . esc_url( $src ) . '" alt="' . esc_html__( 'Avatar', 'recipes' ) . '" width="' . absint( $image_size ) . '" height="' . absint( $image_size ) . '" class="rcps-img-circle ' . esc_attr( $class ) . '" loading="eager">';

		// If class includes 'lazyload' change 'src' attribute to 'data-src', and 'loading' from 'eager' to 'lazy'.
		// Use 'is_admin' to check if on the dashboard, or getting a response via AJAX.
		if ( ! is_admin() && ! empty( $class ) && strpos( $class, 'lazyload' ) !== false ) {
			$img = str_replace( 'img src="', 'img data-src="', $img );
			$img = str_replace( 'loading="eager"', 'loading="lazy"', $img );
		}

		return $img;
	}
}

/**
 * Checks if the featured image should be displayed after the post title.
 *
 * @return boolean
 */
function rcps_show_featured_image() {

	global $post;

	if ( 'post' === $post->post_type && 'off' === $post->_rcps_meta_show_featured_image ) {
		return false;
	}

	if ( 'post' === $post->post_type && '' === $post->_rcps_meta_show_featured_image && false === get_theme_mod( 'show_featured_image_after_title', true ) ) {
		return false;
	}

	if ( 'recipe' === $post->post_type && 'off' === $post->_rcps_meta_show_featured_image ) {
		return false;
	}

	if ( 'recipe' === $post->post_type && '' === $post->_rcps_meta_show_featured_image && false === get_theme_mod( 'show_featured_image_after_recipe_title', true ) ) {
		return false;
	}

	return true;
}

/**
 * Filters image dimensions for SVG logo image.
 *
 * @param array|false  $image Array of image data, or boolean false if no image is available.
 * @param int          $attachment_id Image attachment ID.
 * @param string|int[] $size Requested image size.
 * @param bool         $icon Whether the image should be treated as an icon.
 *
 * @return array|false
 */
function rcps_set_svg_logo_dimensions( $image, $attachment_id, $size, $icon ) {

	if ( ! is_array( $image ) ) {
		return $image;
	}

	$custom_logo_id = get_theme_mod( 'custom_logo' );

	// Only for the logo image.
	if ( $custom_logo_id !== $attachment_id ) {
		return $image;
	}

	// Get the attachment file path.
	$file_path = get_attached_file( $attachment_id );

	// Get the MIME Content-type of the image.
	$mime_content_type = mime_content_type( $file_path );

	// Only if the image's MIME Content-type is SVG.
	if ( is_string( $mime_content_type ) && 'image/svg' === $mime_content_type ) {
		$width  = apply_filters( 'rcps_svg_logo_width', null );
		$height = apply_filters( 'rcps_svg_logo_height', null );

		// Return, if the dimensions are set with the filters.
		if ( $width > 1 && $height > 1 ) {
			$image[1] = $width;
			$image[2] = $height;

			return $image;
		}

		// Otherwise get the dimensions from the SVG file.
		libxml_use_internal_errors( true );
		$simplexml = simplexml_load_file( $file_path );

		if ( is_a( $simplexml, 'SimpleXMLElement' ) ) {
			$xmlattributes = $simplexml->attributes();

			if ( ! empty( $xmlattributes->width ) && ! empty( $xmlattributes->height ) ) {
				$width  = absint( $xmlattributes->width );
				$height = absint( $xmlattributes->height );

				$image[1] = $width;
				$image[2] = $height;
			}
		}
	}

	return $image;
}
add_filter( 'wp_get_attachment_image_src', 'rcps_set_svg_logo_dimensions', 100, 4 );

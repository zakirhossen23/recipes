<?php
/**
 * Navigation.php
 *
 * Miscellaneous functions used in the theme.
 *
 * @package Recipes WordPress Theme
 */

if ( ! function_exists( 'mytheme_page_navi' ) ) {
	/**
	 * Displays a paginated navigation to next/previous set of posts, when applicable.
	 *
	 * @param  string $class Class of the wrapping div.
	 */
	function mytheme_page_navi( $class = 'rcps-pages-blog' ) {

		$pagination = get_the_posts_pagination( array(
			'mid_size'           => 2,
			'prev_next'          => false,
			'screen_reader_text' => __( 'Choose page', 'recipes' ),
		) );

		if ( $pagination ) {
			?>
			<div class="rcps-pages <?php echo sanitize_html_class( $class ); ?> <?php echo( 'rcps-pages-recipes' === $class ? 'hide-on-load"' : '' ); ?>">
				<?php if ( 'rcps-pages-recipes' === $class ) : ?>
					<div class="rcps-inner">
						<?php echo wp_kses_post( $pagination ); ?>
					</div><!-- .rcps-inner -->
				<?php else : ?>
					<?php echo wp_kses_post( $pagination ); ?>
				<?php endif; ?>
			</div><!-- .rcps-pages -->
			<?php
		}
	}
}

if ( mytheme_get_option( 'account_links_main_navi' ) ) {
	if ( ! function_exists( 'mytheme_nav_login' ) ) {
		/**
		 * Adds account links to navigation.
		 *
		 * @param  string   $items  The HTML list content for the menu items.
		 * @param  stdClass $args   An object containing wp_nav_menu() arguments.
		 */
		function mytheme_nav_login( $items, $args ) {

			if ( 'main' === $args->theme_location ) {
				$account_links = array();
				$items_added   = '';

				if ( is_user_logged_in() ) {
					if ( class_exists( 'Favorites' ) ) {
						$account_links[] = array( add_query_arg( 'fav', '1', get_post_type_archive_link( 'recipe' ) ), __( 'Favorites', 'recipes' ) );
					}

					$account_links[] = array( get_author_posts_url( get_current_user_id() ), __( 'Profile', 'recipes' ) );

					$account_page_id = rcps_get_page_with_shortcode( 'rcps_user_settings' );
					if ( $account_page_id ) {
						$account_links[] = array( get_permalink( $account_page_id ), __( 'Settings', 'recipes' ) );
					}

					if ( current_user_can( 'administrator' ) ) {
						$account_links[] = array( admin_url(), __( 'Dashboard', 'recipes' ) );
					}

					$account_links[] = array( wp_logout_url( home_url() ), __( 'Log out', 'recipes' ) );

					$items_added = '<li class="menu-item-has-children rpcs-main-nav-account-link">' . rcps_user_avatar( get_current_user_id(), 'img-64', 32 ) . '<a href="#"> ' . __( 'Account', 'recipes' ) . '</a>
						<ul class="sub-menu">';
					foreach ( $account_links as $key => $value ) {
						$items_added .= '<li><a href="' . $value[0] . '">' . $value[1] . '</a></li>';
					}
					$items_added .= '</ul></li>';

				} elseif ( ! is_user_logged_in() ) {

					$account_links[] = array( wp_login_url( filter_input( INPUT_SERVER, 'REQUEST_URI' ) ), __( 'Log In', 'recipes' ) );

					if ( get_option( 'users_can_register' ) ) {
						$account_links[] = array( wp_registration_url(), __( 'Register', 'recipes' ), 'rcps-nav-btn' );
					}

					foreach ( $account_links as $key => $value ) {
						$items_added .= '<li><a href="' . $value[0] . '">' . $value[1] . '</a></li>';
					}
				}

				return $items . $items_added;
			}
			return $items;
		}
	}
	add_filter( 'wp_nav_menu_items', 'mytheme_nav_login', 10, 2 );
}

if ( ! function_exists( 'mytheme_page_navi_thumbnails' ) ) {
	/**
	 * Displays next/previous post navigation with thumbnails.
	 */
	function mytheme_page_navi_thumbnails() {

		$links = array(
			'prev' => array(
				'post'  => get_previous_post(),
				'title' => '&larr; ' . __( 'Previous', 'recipes' ),
			),
			'next' => array(
				'post'  => get_next_post(),
				'title' => __( 'Next', 'recipes' ) . ' &rarr;',
			),
		);
		?>

		<div class="rcps-next-prev">
			<?php foreach ( $links as $key => $value ) : ?>
				<?php if ( ! empty( $value['post'] ) ) : ?>
					<div class="rcps-next-prev-<?php echo esc_attr( $key ); ?>">
						<?php $data_src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAAZQTFRF////AAAAVcLTfgAAAAF0Uk5TAEDm2GYAAAAdSURBVHja7MGBAAAAAMOg+VPf4ARVAQDwTAABBgAJMAABIBu2IQAAAABJRU5ErkJggg=='; ?>
						<?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $value['post']->ID ), 'post-thumbnail' ); ?>
						<?php if ( ! empty( $thumbnail ) ) : ?>
							<?php $data_src = $thumbnail[0]; ?>
						<?php endif; ?>

						<a href="<?php the_permalink( $value['post']->ID ); ?>" rel="<?php echo esc_attr( $key ); ?>">
							<img data-src="<?php echo esc_attr( $data_src ); ?>" width="48" height="48" alt="<?php echo get_the_title( $value['post']->ID ); ?>" class="lazyload" loading="lazy">
						</a>

						<span><?php echo esc_html( $value['title'] ); ?></span>

						<a href="<?php the_permalink( $value['post']->ID ); ?>" rel="<?php echo esc_attr( $key ); ?>">
							<?php echo get_the_title( $value['post']->ID ); ?>
						</a>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

/**
 * Display SVG icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function mytheme_nav_menu_social_icons( $item_output, $item, $depth, $args ) {

	// Supported social links icons.
	$social_links_icons = array(
		'facebook.com'  => 'facebook',
		'fb.me'         => 'facebook',
		'flickr.com'    => 'flickr',
		'instagram.com' => 'instagram',
		'linkedin.com'  => 'linkedin',
		'pinterest.'    => 'pinterest',
		'tumblr.com'    => 'tumblr',
		'twitter.com'   => 'twitter',
		'vimeo.com'     => 'vimeo',
		'vk.com'        => 'vk',
		'youtube.com'   => 'youtube',
	);

	$social_icons = apply_filters( 'mytheme_social_links_icons', $social_links_icons );

	// Adds SVG icon inside the social links menu item, if the URL is supported.
	if ( 'social_header' === $args->theme_location || 'social_footer' === $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item->url, $attr ) ) {
				$target = '';
				if ( ! empty( $item->target ) ) {
					$target = ' target="' . $item->target . '"';
				}
				$item_output = '<a href="' . esc_url( $item->url ) . '"' . $target . '><svg class="rcps-icon rcps-icon-' . esc_attr( $value ) . '"><use xlink:href="' . esc_url( get_template_directory_uri() . '/images/icons.svg#icon-' . $value ) . '"/></svg><span class="screen-reader-text">' . esc_html( $item->title ) . '</span></a>';
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'mytheme_nav_menu_social_icons', 10, 4 );

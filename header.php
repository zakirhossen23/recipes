<?php
/**
 * Header.php
 *
 * @package Recipes WordPress Theme
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<script>var h = document.getElementsByTagName('html')[0];h.classList.add('js');</script>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div class="rcps-wrap">
		<?php if ( is_active_sidebar( 'rcps-widgets-header-top' ) ) : ?>
			<?php dynamic_sidebar( 'rcps-widgets-header-top' ); ?>
		<?php endif; ?>

		<header class="rcps-header">
			<div class="rcps-inner">
				<div class="rcps-header-branding">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="rcps-logo">
						<?php if ( has_custom_logo() ) : ?>
							<?php $custom_logo_id = get_theme_mod( 'custom_logo' ); ?>
							<?php $logo = wp_get_attachment_image_src( $custom_logo_id, 'thumbnail' ); ?>
							<?php if ( ! empty( $logo[0] ) ) : ?>
								<img src="<?php echo esc_url( $logo[0] ); ?>" width="<?php echo absint( $logo[1] ); ?>" height="<?php echo absint( $logo[2] ); ?>" class="rcps-logo-img" alt="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>">
							<?php endif; ?>
						<?php else : ?>
							<span class="rcps-logo-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
						<?php endif; ?>
					</a>
				</div><!-- .rcps-header-branding -->

				<?php if ( has_nav_menu( 'main' ) ) : ?>
					<nav class="rcps-nav-main" role="navigation">
						<button type="button" class="rcps-nav-toggle" aria-expanded="false"><span class="screen-reader-text"><?php echo esc_html( _x( 'Menu', 'Mobile menu button text (for screen readers)', 'recipes' ) ); ?></span><svg class="rcps-icon"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-menu"/></svg></button>

						<?php
						wp_nav_menu( array(
							'theme_location' => 'main',
							'container'      => false,
							'menu_class'     => 'rcps-nav-main-ul no-js',
							'fallback_cb'    => false,
							'item_spacing'   => 'discard',
							'depth'          => 2,
						) );
						?>
					</nav>
				<?php endif; ?>

				<?php if ( has_nav_menu( 'social_header' ) ) : ?>
					<?php
					wp_nav_menu( array(
						'theme_location'  => 'social_header',
						'container'       => 'nav',
						'container_class' => 'rcps-header-social',
						'menu_class'      => 'rcps-list-social rcps-list-social-header rcps-m0',
						'fallback_cb'     => false,
						'item_spacing'    => 'discard',
						'depth'           => 1,
					) );
					?>
				<?php endif; ?>
			</div><!-- .rcps-inner -->
		</header>
	</div><!-- .rcps-wrap -->

	<div class="rcps-wrap rcps-wrap-background">

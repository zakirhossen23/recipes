<?php
/**
 * Footer.php
 *
 * @package Recipes WordPress Theme
 */

?>

	<footer class="rcps-footer">
		<?php
		if ( has_nav_menu( 'social_footer' ) ) :
			wp_nav_menu( array(
				'theme_location'  => 'social_footer',
				'container'       => 'nav',
				'container_class' => 'rcps-footer-social',
				'menu_class'      => 'rcps-list-social',
				'fallback_cb'     => false,
				'depth'           => 1,
			) );
		endif;

		if ( has_nav_menu( 'footer' ) ) :
			wp_nav_menu( array(
				'theme_location'  => 'footer',
				'container'       => 'nav',
				'container_class' => 'rcps-nav-footer',
				'menu_class'      => 'rcps-nav-footer-ul',
				'fallback_cb'     => false,
				'depth'           => 1,
			) );
		endif;
		?>

		<?php
		$copyright_text = '&copy; Copyright ' . esc_html( date( 'Y' ) ) . ' <a href="https://themeforest.net/item/recipes-wordpress-theme/9258994?ref=myTheme" rel="nofollow">Recipes WordPress Theme</a> &mdash; <a href="https://wordpress.org/">' . esc_html__( 'Powered by WordPress', 'recipes' ) . '</a>';
		?>

		<p class="rcps-copyright"><?php echo wp_kses_post( apply_filters( 'rcps_filter_copyright_text', $copyright_text ) ); ?></p>

		<?php do_action( 'rcps_action_after_copyright_text' ); ?>
	</footer>
</div><!-- .rcps-wrap -->

<?php wp_footer(); ?>

</body>
</html>

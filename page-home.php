<?php
/**
 * Template Name: Home
 *
 * @package Recipes WordPress Theme
 */

get_header(); ?>

<?php if ( is_active_sidebar( 'rcps-homepage-widgets' ) ) : ?>
	<?php dynamic_sidebar( 'rcps-homepage-widgets' ); ?>
<?php endif; ?>

<?php if ( get_post_meta( get_the_ID(), 'custom_meta_homepage_display_widgets', true ) ) : ?>
	<?php get_sidebar(); ?>
<?php else : ?>
	</div><!-- .rcps-wrap.rcps-wrap-background -->
	<div class="rcps-wrap">
<?php endif; ?>

<?php get_footer(); ?>

<?php
/**
 * Template: Author
 *
 * @package Recipes WordPress Theme
 */

?>

<div class="rcps-author-top">
	<?php echo get_the_date(); ?>&nbsp; <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
	<?php echo wp_kses_post( rcps_user_avatar( get_the_author_meta( 'ID' ), 'img-64', 32, 'rcps-img-inline rcps-img-inline-right' ) ); ?>
</div>

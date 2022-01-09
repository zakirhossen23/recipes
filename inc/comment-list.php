<?php
/**
 * Comment-list.php
 *
 * @package Recipes WordPress Theme
 */

if ( ! function_exists( 'mytheme_comments' ) ) {
	/**
	 * Outputs template for comments and pingbacks.
	 *
	 * @param  [type] $comment [description].
	 * @param  [type] $args    [description].
	 * @param  [type] $depth   [description].
	 */
	function mytheme_comments( $comment, $args, $depth ) {

		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
		?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php esc_html_e( 'Pingback:', 'recipes' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'recipes' ), '<span class="rcps-edit-link">', '</span>' ); ?></p>
		<?php
			break;
			default:
				global $post;
		?>

		<li id="comment-<?php comment_ID(); ?>">
			<div <?php comment_class( 'rcps-comment' ); ?>>
				<div class="rcps-comment-author">
					<div class="rcps-comment-avatar">
						<?php echo wp_kses_post( rcps_user_avatar( $comment->user_id, 'img-64', 32, 'lazyload' ) ); ?>
					</div><!-- .rcps-comment-avatar -->

					<?php if ( '0' === $comment->user_id ) : ?>
						<span class="rcps-comment-author-name"><?php echo esc_html( $comment->comment_author ); ?></span>
					<?php else : ?>
						<a href="<?php echo esc_url( get_author_posts_url( $comment->user_id ) ); ?>" class="rcps-comment-author-name"><?php echo esc_html( $comment->comment_author ); ?></a>
					<?php endif; ?>

					<?php if ( get_the_author() === $comment->comment_author ) : ?>
						<span class="rcps-comment-by-author"><?php esc_html_e( 'Author', 'recipes' ); ?></span>
					<?php endif; ?>

					<?php // Translators: %s is the comment time in a human readable format. ?>
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="rcps-comment-time"><?php printf( esc_html__( '%s ago', 'recipes' ), esc_html( human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ) ); ?></a>
				</div><!-- .rcps-comment-author -->

				<?php if ( '0' === $comment->comment_approved ) : ?>
					<p class="rcps-comment-moderation rcps-m0"><em><?php esc_html_e( 'Your comment is awaiting moderation.', 'recipes' ); ?></em></p>
				<?php endif; ?>

				<div class="rcps-comment-body">
					<?php comment_text(); ?>

					<?php if ( is_user_logged_in() ) : ?>
						<p class="rcps-comment-reply">
							<?php
							comment_reply_link( array_merge( $args, array(
								'depth'      => $depth,
								'max_depth'  => $args['max_depth'],
								'reply_text' => __( 'Reply', 'recipes' ),
							) ) );
							?>
						</p>
					<?php endif; ?>
				</div><!-- .rcps-comment-body -->
			</div>

		<?php
			break;
			endswitch;
	}
}

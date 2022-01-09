<?php
/**
 * Comments.php
 *
 * @package Recipes WordPress Theme
 */

if ( post_password_required() || ( ! have_comments() && ! comments_open() ) ) {
	return;
}
?>

<?php $comments_page = ( ! empty( get_query_var( 'cpage' ) ) ? absint( get_query_var( 'cpage' ) ) : 1 ); ?>

<div class="rcps-section-comments">
	<div class="rcps-inner">
		<section id="comments" class="rcps-single-content">
			<div data-target="comment-form" <?php echo( ! have_comments() || absint( get_comment_pages_count() ) === $comments_page ? 'class="hide-on-load"' : '' ); ?>>
				<h3><?php comments_number( __( 'No Comments', 'recipes' ), __( 'One Comment', 'recipes' ), __( '% Comments', 'recipes' ) ); ?></h3>

				<ul class="rcps-commentlist">
					<?php wp_list_comments( array( 'callback' => 'mytheme_comments' ) ); ?>
				</ul>

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
					<p class="rcps-comment-pages"><?php previous_comments_link( '&larr; ' . __( 'Older Comments', 'recipes' ) ); ?> <?php next_comments_link( __( 'Newer Comments', 'recipes' ) . ' &rarr;' ); ?></p>
				<?php endif; ?>

				<?php
				$aria_req = ( $req ? ' aria-required="true"' : '' );

				$comment_form_default_fields = array(
					'author' => '<fieldset class="rcps-fieldset"><label class="rcps-label">' . __( 'Name', 'recipes' ) . '</label><input class="rcps-text-input" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . '></fieldset>',

					'email'  => '<fieldset class="rcps-fieldset"><label class="rcps-label">' . __( 'Email', 'recipes' ) . '</label><input class="rcps-text-input" id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . '></fieldset>',

					'url'    => '<fieldset class="rcps-fieldset"><label class="rcps-label">' . __( 'Website', 'recipes' ) . '</label><input class="rcps-text-input" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3"></fieldset>',
				);

				$args = array(
					'fields'               => apply_filters( 'comment_form_default_fields', $comment_form_default_fields ),

					'comment_field'        => '<fieldset class="rcps-fieldset"><label class="rcps-label">' . __( 'Your comment', 'recipes' ) . '</label><textarea class="rcps-textarea rcps-wide" id="comment" name="comment" cols="45" rows="5" tabindex="4" aria-required="true"></textarea></fieldset>',

					// Translators: %s is the login URL.
					'must_log_in'          => '<p class="rcps-must-log-in rcps-alert rcps-alert-yellow">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'recipes' ), wp_login_url( filter_input( INPUT_SERVER, 'REQUEST_URI' ) ) ) . '</p>',

					'title_reply'          => __( 'Leave a Reply', 'recipes' ),
					'title_reply_to'       => __( 'Leave a Reply', 'recipes' ),
					'cancel_reply_link'    => __( 'Cancel Reply', 'recipes' ),
					'label_submit'         => __( 'Submit', 'recipes' ),
					'comment_notes_before' => '',
					'comment_notes_after'  => '',
					'logged_in_as'         => '',
				);
				?>

				<?php comment_form( $args ); ?>
			</div>

			<button type="button" class="rcps-btn rcps-btn-big rcps-btn-wide" data-target-element="comment-form" data-hide-on-click="true"><?php comments_number( __( 'No comments. Leave a comment?', 'recipes' ), __( 'One Comment', 'recipes' ), __( '% Comments', 'recipes' ) ); ?></button>
		</section>
	</div><!-- .rcps-inner -->
</div><!-- .rcps-section-comments -->

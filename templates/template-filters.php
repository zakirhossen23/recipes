<?php
/**
 * Template: Filters
 *
 * @package Recipes WordPress Theme
 */

$displayed_filters = mytheme_get_option( 'displayed_filters' );
?>

<form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'recipe' ) ); ?>" class="rcps-ajax-form">
	<?php if ( ! empty( $displayed_filters ) ) : ?>
		<div class="rcps-section-filters">
			<div class="rcps-inner">
				<div class="rcps-filters">
					<?php if ( in_array( 'keyword', $displayed_filters, true ) ) : ?>
						<div class="rcps-filters-cell">
							<label for="rcps-filters-s" class="screen-reader-text"><?php esc_html_e( 'Keyword', 'recipes' ); ?></label>

							<div class="rcps-filters-keywords">
								<input type="text" name="s" id="rcps-filters-s" class="rcps-filters-s" value="<?php the_search_query(); ?>" placeholder="<?php esc_html_e( 'Keyword', 'recipes' ); ?>">
								<button class="rcps-filters-searchsubmit"><svg class="rcps-icon rcps-icon-search"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-search"/></svg><span class="screen-reader-text"><?php esc_html_e( 'Search', 'recipes' ); ?></span></button>
							</div>
						</div>
					<?php endif; ?>

					<?php $filters_array = mytheme_filter_options( $displayed_filters ); ?>
					<?php if ( ! empty( $filters_array ) ) : ?>
						<?php foreach ( $filters_array as $filter => $value ) : ?>
							<div class="rcps-filters-cell">
								<div class="rcps-dropdown">
									<span class="screen-reader-text"><?php echo esc_html( $value['singular_name'] ); ?></span>

									<button type="button" class="rcps-btn rcps-btn-wide rcps-btn-dropdown rcps-btn-has-dropdown rcps-mb0 <?php echo( ! empty( $value['class'] ) ? esc_attr( $value['class'] ) : '' ); ?>">
										<?php echo esc_html( $value['singular_name'] ); ?><?php echo( ! empty( $value['active_count'] ) ? ' <b>(' . esc_html( $value['active_count'] ) . ')</b>' : '' ); ?>
									</button>

									<div class="rcps-dropdown-content">
										<?php
										$args = array(
											'taxonomy'   => $filter,
											'title_li'   => '',
											'hide_empty' => true,
											'style'      => 'none',
											'walker'     => new Rcps_Filter_Walker(),
										);
										wp_list_categories( apply_filters( 'rcps_filter_get_filter_terms', $args ) );
										?>
									</div>
								</div>
							</div><!-- .rcps-filters-cell -->
						<?php endforeach; ?>
					<?php endif; ?>
				</div><!-- .rcps-filters -->

				<?php if ( get_query_var( 'author_name' ) ) : ?>
					<input type="hidden" name="author_name" value="<?php echo esc_attr( get_query_var( 'author_name' ) ); ?>">
				<?php endif; ?>
			</div><!-- .rcps-inner -->
		</div><!-- .rcps-section-filter -->
	<?php endif; ?>

	<?php if ( is_post_type_archive() ) : ?>
		<?php get_template_part( 'templates/template', 'applied-filters' ); ?>
	<?php endif; ?>

	<?php if ( ! is_page_template( 'page-home.php' ) ) : ?>
		<?php get_template_part( 'templates/template', 'sort' ); ?>
	<?php endif; ?>

	<noscript><input type="submit" value="<?php esc_html_e( 'Submit', 'recipes' ); ?>"></noscript>
</form>

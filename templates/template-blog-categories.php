<?php
/**
 * Template: Blog Categories
 *
 * @package Recipes WordPress Theme
 */

?>

<?php $show_categories = apply_filters( 'rcps_filter_show_category_links_on_blog_archive', true ); ?>

<?php if ( true === $show_categories && ! is_paged() ) : ?>

	<?php
	$current_term_id = false;
	if ( is_category() || is_tag() ) {
		$current_term_id = get_queried_object()->term_id;
	}

	$args = array(
		'orderby'  => 'name',
		'order'    => 'DESC',
		'taxonomy' => 'category',
	);

	$categories = get_categories( apply_filters( 'rcps_filter_get_blog_archive_categories_args', $args ) );
	?>

	<?php if ( ! empty( $categories ) ) : ?>
		<div class="rcps-section-content">
			<div class="rcps-inner">
				<h2><?php echo esc_html( apply_filters( 'rcps_filter_blog_archive_categories_title', __( 'Categories', 'recipes' ) ) ); ?></h2>

				<?php foreach ( $categories as $category ) : ?>
					<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="rcps-btn <?php echo sanitize_html_class( ( $category->term_id === $current_term_id ? 'rcps-btn-on' : '' ) ); ?> rcps-mb05"><?php echo esc_html( $category->name ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>

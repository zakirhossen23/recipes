<?php
/**
 * Taxonomy.php
 *
 * @package Recipes WordPress Theme
 */

get_header();

$term_image_id = mytheme_get_term_image_id( get_queried_object() );
?>

<?php get_template_part( 'templates/template', 'filters' ); ?>

<?php if ( ! empty( $term_image_id ) && ! is_paged() ) : ?>
	<div class="rcps-hero rcps-hero-small">
		<div class="rcps-hero-image">
			<?php echo wp_get_attachment_image( $term_image_id, 'img-1140', false, array( 'class' => 'lazyload rcps-hero-img' ) ); ?>
		</div><!-- .rcps-hero-image -->

		<div class="rcps-hero-content">
			<div class="rcps-hero-content-inner">
				<h1 class="rcps-title-hero"><span class="rcps-hero-overlay"><?php echo single_term_title(); ?></span></h1>
			</div><!-- .rcps-hero-content-inner -->
		</div><!-- .rcps-hero-content -->
	</div><!-- .rcps-hero -->

<?php elseif ( empty( $term_image_id ) || is_paged() ) : ?>
	<h1 class="screen-reader-text"><?php echo single_term_title(); ?></h1>
<?php endif; ?>

<?php if ( ! empty( term_description() ) && ! is_paged() ) : ?>
	<div class="rcps-section-content">
		<div class="rcps-inner">
			<div class="rcps-single-content">
				<?php if ( empty( $term_image_id ) ) : ?>
					<h1><?php echo single_term_title(); ?></h1>
				<?php endif; ?>

				<?php echo term_description(); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php get_template_part( 'templates/template', 'recipe-grid' ); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

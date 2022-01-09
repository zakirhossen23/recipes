<?php
/**
 * Author.php
 *
 * @package Recipes WordPress Theme
 */

get_header();

$curauth = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );

$author_description  = get_the_author_meta( 'description', $curauth->ID );
$author_social_links = mytheme_users_social_links( $curauth->ID );

$wp_query_recipes   = rcps_author_query_recipes( $curauth->ID );
$wp_query_posts     = rcps_author_query_posts( $curauth->ID );
$wp_query_favorites = rcps_author_query_favorites( $curauth->ID );
?>

<div class="rcps-title-header rcps-text-center">
	<?php echo wp_kses_post( rcps_user_avatar( $curauth->ID, 'img-64', 32, 'rcps-img-inline rcps-img-inline-left' ) ); ?>

	<h1><?php the_author_meta( 'display_name', $curauth->ID ); ?></h1>
</div>

<?php if ( ! empty( $author_description ) || ! empty( $author_social_links ) ) : ?>
	<div class="rcps-section-profile">
		<div class="rcps-inner">
			<?php if ( $author_description ) : ?>
				<p class="rcps-section-profile-bio"><?php echo wp_kses_post( $author_description ); ?></p>
			<?php endif; ?>

			<?php if ( $author_social_links ) : ?>
				<ul class="rcps-list-social rcps-list-social-user">
					<?php foreach ( $author_social_links as $service => $url ) : ?>
						<li><a href="<?php echo esc_url( $url ); ?>" class="rcps-social-<?php echo esc_attr( $service ); ?>"><svg class="rcps-icon"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-<?php echo esc_attr( $service ); ?>"/></svg></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div><!-- .rcps-inner -->
	</div><!-- .rcps-section-profile -->
<?php endif; ?>

<?php if ( ! $wp_query_recipes->have_posts() ) : ?>
	<div class="rcps-section-content">
		<div class="rcps-inner">
			<div class="rcps-single-content">
				<?php if ( is_user_logged_in() && get_current_user_id() === $curauth->ID ) : ?>
					<?php $alert = __( 'You have no recipes published. Want to submit your first one?', 'recipes' ); ?>
				<?php else : ?>
					<?php // Translators: %s is the name of the author. ?>
					<?php $alert = sprintf( __( '%s has no recipes published.', 'recipes' ), get_the_author_meta( 'display_name', $curauth->ID ) ); ?>
				<?php endif; ?>
				<p class="rcps-alert rcps-alert-yellow"><?php echo esc_html( $alert ); ?></p>
			</div><!-- .rcps-single-content -->
		</div><!-- .rcps-inner -->
	</div><!-- .rcps-section-content -->

<?php elseif ( $wp_query_recipes->have_posts() ) : ?>
	<div class="rcps-section-content">
		<div class="rcps-inner">
			<div class="rcps-title-header rcps-title-header-sec">
				<h2><?php esc_html_e( 'Latest recipes', 'recipes' ); ?></h2>

				<a href="<?php echo esc_url( add_query_arg( 'author_name', $curauth->user_nicename, get_post_type_archive_link( 'recipe' ) ) ); ?>" class="rcps-btn rcps-btn-small"><?php esc_html_e( 'View all', 'recipes' ); ?></a>
			</div><!-- .rcps-title-header -->

			<div class="rcps-recipe-grid">
				<?php while ( $wp_query_recipes->have_posts() ) : ?>
					<?php $wp_query_recipes->the_post(); ?>
					<?php get_template_part( 'templates/template', 'recipe' ); ?>
				<?php endwhile; ?>
			</div><!-- .rcps-recipe-grid -->
		</div><!-- .rcps-inner -->
	</div><!-- .rcps-section-content -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php if ( $wp_query_posts->have_posts() ) : ?>
	<div class="rcps-section-content">
		<div class="rcps-inner">
			<div class="rcps-title-header rcps-title-header-sec">
				<h2><?php esc_html_e( 'Latest blog posts', 'recipes' ); ?></h2>
			</div><!-- .rcps-title-header -->

			<div class="rcps-recipe-grid">
				<?php while ( $wp_query_posts->have_posts() ) : ?>
					<?php $wp_query_posts->the_post(); ?>
					<?php get_template_part( 'templates/template', 'blog-post' ); ?>
				<?php endwhile; ?>
			</div><!-- .rcps-recipe-grid -->
		</div><!-- .rcps-inner -->
	</div><!-- .rcps-section-content -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php if ( false !== $wp_query_favorites && $wp_query_favorites->have_posts() ) : ?>
	<div class="rcps-section-content">
		<div class="rcps-inner">
			<div class="rcps-title-header rcps-title-header-sec">
				<h2><?php esc_html_e( 'Favorite recipes', 'recipes' ); ?></h2>
			</div><!-- .rcps-title-header -->

			<div class="rcps-recipe-grid">
				<?php while ( $wp_query_favorites->have_posts() ) : ?>
					<?php $wp_query_favorites->the_post(); ?>
					<?php get_template_part( 'templates/template', 'recipe' ); ?>
				<?php endwhile; ?>
			</div><!-- .rcps-recipe-grid -->
		</div><!-- .rcps-inner -->
	</div><!-- .rcps-section-content -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

<?php
/**
 * Searchform.php
 *
 * @package Recipes WordPress Theme
 */

?>

<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="searchform-s" class="screen-reader-text"><?php esc_html_e( 'Search', 'recipes' ); ?></label>
	<input type="text" name="s" id="searchform-s" class="s" placeholder="<?php esc_html_e( 'Search', 'recipes' ); ?>" value="<?php printf( get_search_query() ); ?>">
	<input name="post_type" type="hidden" value="post">
	<button class="searchsubmit"><svg class="rcps-icon rcps-icon-search"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons.svg#icon-search"/></svg><span class="screen-reader-text"><?php esc_html_e( 'Search', 'recipes' ); ?></span></button>
</form>

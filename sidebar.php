<?php
/**
 * Sidebar.php
 *
 * @package Recipes WordPress Theme
 */

?>

</div><!-- .rcps-wrap.rcps-wrap-background -->

<div class="rcps-wrap rcps-wrap-aside">
	<aside class="rcps-aside">
		<div class="rcps-inner">
			<?php if ( is_active_sidebar( 'sidebar-widget-area-1' ) ) : ?>
				<div class="rcps-column is-one-third">
					<?php dynamic_sidebar( 'sidebar-widget-area-1' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'sidebar-widget-area-2' ) ) : ?>
				<div class="rcps-column is-one-third">
					<?php dynamic_sidebar( 'sidebar-widget-area-2' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'sidebar-widget-area-3' ) ) : ?>
				<div class="rcps-column is-one-third is-last">
					<?php dynamic_sidebar( 'sidebar-widget-area-3' ); ?>
				</div>
			<?php endif; ?>
			<div class="rcps-clear"></div>
		</div><!-- .rcps-inner -->
	</aside><!-- .rcps-aside -->

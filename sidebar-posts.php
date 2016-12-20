<?php
/**
 * Posts sidebar template.
 *
 * @package Responsive_Framework
 */

?>
<?php if ( is_active_sidebar( 'posts' ) ) : ?>
	<aside class="sidebarPosts">
		<?php dynamic_sidebar( 'posts' ); ?>
	</aside>
<?php endif;

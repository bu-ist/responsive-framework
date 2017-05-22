<?php
/**
 * Posts sidebar template.
 *
 * @package Responsive_Framework
 */

?>
<?php if ( is_active_sidebar( 'posts' ) ) : ?>
	<aside class="sidebar sidebar-posts">
		<?php dynamic_sidebar( 'posts' ); ?>
	</aside>
<?php endif;

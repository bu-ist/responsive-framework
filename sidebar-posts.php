<?php
/**
 * Posts sidebar template.
 *
 * @package Responsive_Framework
 */

?>
<?php if ( is_active_sidebar( 'posts' ) ) : ?>
	<aside class="sidebar sidebar-posts" role="complementary">
		<?php dynamic_sidebar( 'posts' ); ?>
	</aside>
<?php endif;

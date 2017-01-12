<?php
/**
 * Default sidebar template.
 *
 * @package Responsive_Framework
 */

?>
<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
	<aside class="sidebar">
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</aside>
<?php endif;

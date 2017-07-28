<?php
/**
 * Default sidebar template.
 *
 * @package Responsive_Framework
 */

?>
<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
	<aside class="sidebar">
		<h2 class="visually-hidden">Related to <?php the_title(); ?></h2>
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</aside>
<?php endif;

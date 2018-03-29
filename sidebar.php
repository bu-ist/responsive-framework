<?php
/**
 * Default sidebar template.
 *
 * @package Responsive_Framework
 */

if ( is_active_sidebar( 'sidebar' ) ) :
	/**
	 * Fires immediately before the opening default sidebar container element.
	 *
	 * @since 2.0.0
	 */
	do_action( 'r_sidebar_opening_before' );
	?>
	<aside class="sidebar" role="complementary">
		<?php
			/**
			 * Fires immediately after the opening default sidebar container element.
			 *
			 * @since 2.0.0
			 */
			do_action( 'r_sidebar_opening_after' );
		?>
		<h2 class="visually-hidden">Related to <?php the_title(); ?></h2>

		<?php dynamic_sidebar( 'sidebar' ); ?>

		<?php
			/**
			 * Fires immediately before the closing default sidebar container element.
			 *
			 * @since 2.0.0
			 */
			do_action( 'r_sidebar_closing_before' );
		?>
	</aside>
	<?php
	/**
	 * Fires immediately after the closing default sidebar container element.
	 *
	 * @since 2.0.0
	 */
	do_action( 'r_sidebar_closing_after' );

endif;

<?php
/**
 * Default sidebar template.
 *
 * @package Responsive_Framework
 */

if ( is_registered_sidebar( 'sidebar' ) && is_active_sidebar( 'sidebar' ) ) :
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
		<h2 class="u-visually-hidden">
		<?php
			/* translators: %s: Title for the current post. */
			printf( esc_html__( 'Related to %s', 'responsive-framework' ), esc_html__( get_the_title( get_queried_object_id() ), 'responsive-framework' ) );
		?>
		</h2>

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

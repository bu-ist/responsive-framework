<?php
/**
 * Footbar sidebar template.
 *
 * @package Responsive_Framework
 */

$footbar = responsive_get_footbar_id();

if ( is_active_sidebar( $footbar ) ) :
	/**
	 * Fires immediately before the opening footbar sidebar container element.
	 *
	 * @since 2.0.0
	 */
	do_action( 'r_sidebar_footbar_opening_before' );
	?>
	<aside class="footbar <?php responsive_sidebar_classes( $footbar ); ?>" role="complementary">
		<h2 class="u-visually-hidden">
		<?php
			/* translators: %s: Site name.  */
			printf( esc_html__( 'More about %s', 'responsive-framework' ), esc_html( get_bloginfo( 'name' ) ) );
		?>
		</h2>

		<?php
			/**
			 * Fires immediately after the opening footbar sidebar container element.
			 *
			 * @since 2.0.0
			 */
			do_action( 'r_sidebar_footbar_opening_after' );
		?>

		<div class="footbar-container">
			<?php dynamic_sidebar( $footbar ); ?>
		</div>

		<?php
			/**
			 * Fires immediately before the closing footbar sidebar container element.
			 *
			 * @since 2.0.0
			 */
			do_action( 'r_sidebar_footbar_closing_before' );
		?>
	</aside>
	<?php
	/**
	 * Fires immediately after the closing footbar sidebar container element.
	 *
	 * @since 2.0.0
	 */
	do_action( 'r_sidebar_footbar_closing_after' );

endif;

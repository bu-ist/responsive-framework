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
	 */
	do_action( 'r_before_sidebar_footbar_opening' );
	?>
	<aside class="footbar <?php responsive_sidebar_classes( 'footbar' ); ?>">
		<?php
			/**
			 * Fires immediately after the opening footbar sidebar container element.
			 */
			do_action( 'r_after_sidebar_footbar_opening' );
		?>

		<div class="footbar-container">
			<?php dynamic_sidebar( $footbar ); ?>
		</div>

		<?php
			/**
			 * Fires immediately before the closing footbar sidebar container element.
			 */
			do_action( 'r_before_sidebar_footbar_closing' );
		?>
	</aside>
	<?php
	/**
	 * Fires immediately after the closing footbar sidebar container element.
	 */
	do_action( 'r_after_sidebar_footbar_closing' );

endif;

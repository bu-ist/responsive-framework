<?php
/**
 * Site footer template.
 *
 * @package Responsive_Framework
 */

?>

				<?php
					/**
					 * Fires immediately before the inner closing content container.
					 *
					 * @since 2.0.0
					 */
					do_action( 'r_before_closing_container_inner' );
				?>
			</div><!-- .content-container -->
			<?php
				/**
				 * Fires immediately after the inner closing content container.
				 *
				 * @since 2.0.0
				 */
				do_action( 'r_after_closing_container_inner' );

				/**
				 * Fires immediately before the outer closing content container.
				 *
				 * @since 2.0.0
				 */
				do_action( 'r_before_closing_container_outer' );
			?>
		</main><!-- .content -->

		<?php
			/**
			 * Fires immediately after the outer closing content container.
			 *
			 * @since 2.0.0
			 */
			do_action( 'r_after_closing_container_outer' );

			/**
			 * Fires immediately before the closing wrapper div.
			 *
			 * @since 2.0.0
			 */
			do_action( 'r_before_closing_wrapper' );
		?>
	</div><!-- .wrapper -->
	<?php
		/**
		 * Fires immediately after the closing wrapper div.
		 *
		 * @since 2.0.0
		 */
		do_action( 'r_after_closing_wrapper' );
	?>

	<footer class="site-footer <?php responsive_extra_footer_classes(); ?>" role="contentinfo">
		<?php
			/**
			 * Fires immediately before the footer brand assets.
			 *
			 * @since 2.0.0
			 */
			do_action( 'r_before_footer_brand_assets' );
		?>
		<div class="site-footer-brand-assets">
			<?php responsive_branding_masterplate(); ?>
			<?php responsive_branding_bumc_logo(); ?>
			<?php responsive_branding_disclaimer(); ?>
			<?php responsive_customizer_footer_info(); ?>
		</div>
		<?php
			/**
			 * Fires immediately after the footer brand assets.
			 *
			 * @since 2.0.0
			 */
			do_action( 'r_after_footer_brand_assets' );
		?>

		<?php
			/**
			 * Fires immediately before the footer menus.
			 */
			do_action( 'r_before_footer_menus' );
		?>
		<div class="site-footer-menus">
			<?php responsive_footer_menu(); ?>
			<?php responsive_social_menu(); ?>
		</div>
		<?php
			/**
			 * Fires immediately after the footer menus.
			 *
			 * @since 2.0.0
			 */
			do_action( 'r_after_footer_menus' );
		?>

	</footer>

	<?php wp_footer(); ?>

	<?php
		/**
		 * Fires immediately before the closing body tag.
		 *
		 * @since 2.0.0
		 */
		do_action( 'r_before_closing_body_tag' );
	?>
</body>
</html>

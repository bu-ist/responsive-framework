<?php
/**
 * Site footer template.
 *
 * @package Responsive_Framework
 */

?>

				<?php
					/**
					 * Fires immediately before the closing content container div.
					 *
					 * @since 2.0.0
					 */
					do_action( 'r_before_closing_content_container' );
				?>
			</div><!-- .content-container -->
			<?php
				/**
				 * Fires immediately after the closing content container div.
				 *
				 * @since 2.0.0
				 */
				do_action( 'r_after_closing_content_container' );
			?>

		<?php get_sidebar( 'bottom' ); ?>

			<?php
				/**
				 * Fires immediately before the closing content div.
				 *
				 * @since 2.0.0
				 */
				do_action( 'r_before_closing_content' );
			?>
		</main><!-- .content -->
		<?php
			/**
			 * Fires immediately after the closing content div.
			 *
			 * @since 2.0.0
			 */
			do_action( 'r_after_closing_content' );
		?>

	</div><!-- .wrapper -->

	<footer class="site-footer <?php responsive_extra_footer_classes(); ?>" role="contentinfo">
		<div class="site-footer-brand-assets">
			<?php responsive_branding_masterplate(); ?>
			<?php responsive_branding_bumc_logo(); ?>
			<?php responsive_branding_disclaimer(); ?>
			<?php responsive_customizer_footer_info(); ?>
		</div>
		<div class="site-footer-menus">
			<?php responsive_footer_menu(); ?>
			<?php responsive_social_menu(); ?>
		</div>

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

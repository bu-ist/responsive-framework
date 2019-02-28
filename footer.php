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
		<?php get_template_part( 'template-parts/footer-branding' ); ?>
		<?php get_template_part( 'template-parts/footer-menus' ); ?>
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

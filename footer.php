			</div><!-- .content-container -->

		<?php get_sidebar( 'bottom' ); ?>

		</div><!-- .content -->
	</div><!-- .wrapper -->

	<footer class="siteFooter <?php responsive_extra_footer_classes(); ?>" role="contentinfo">

		<?php responsive_branding_masterplate(); ?>
		<?php responsive_branding_bumc_logo(); ?>
		<?php responsive_branding_disclaimer(); ?>

		<div class="siteFooter-content">
			<?php responsive_customizer_footer_info(); ?>
			<?php responsive_footer_menu(); ?>
			<?php responsive_social_menu(); ?>
		</div>

	</footer>

	<?php wp_footer(); ?>
</body>
</html>

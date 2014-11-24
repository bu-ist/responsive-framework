			</div><!-- .container -->

			<?php get_sidebar( 'bottom' ); ?>

			<footer class="siteFooter <?php responsive_extra_footer_classes(); ?>" role="contentinfo">

				<?php
					responsive_branding_masterplate( array(
						'before' => '<div class="siteFooter-brand">',
						'after'  => '</div>'
					) );
				?>

				<div class="siteFooter-content">

				<?php if ( responsive_customizer_has_footer_info() ) : ?>
					<div class="siteFooter-info">
						<?php responsive_customizer_footer_info(); ?>
					</div>
				<?php endif; ?>

				<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<nav class="siteFooter-links" role="navigation">
						<h3>Related Sites</h3>
						<?php
							wp_nav_menu( array(
								'theme_location' => 'footer',
								'depth'          => 1,
							) );
						?>
					</nav>
				<?php endif; ?>

				<?php if ( has_nav_menu( 'social' ) ) : ?>
					<nav class="siteFooter-social" role="navigation">
						<h3>Follow Us</h3>
						<?php responsive_social_menu(); ?>
					</nav>
				<?php endif; ?>

				</div>

			</footer>

			<?php wp_footer(); ?>

		</div>
	</div>
</body>
</html>

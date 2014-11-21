			</div><!-- .container -->

			<?php get_sidebar( 'bottom' ); ?>

			<footer class="siteFooter <?php responsive_extra_footer_classes(); ?>" role="contentinfo">

			<!--

			1. Add stateful classes to .siteFooter-wrapper to change column widths:
				
				.has-branding          ==> has master plate. This one can be inserted separately

				.has-info
				.has-links 
				.has-social
				.has-info-links-social
				.has-info-links
				.has-info-social
				.has-links-social

			2. Using custom menus for both siteFooter-links and siteFooter-social, allow ability to show/hide menu title in <h3>. 

			-->

				<?php responsive_branding_masterplate( array( 'before' => '<div class="siteFooter-brand">', 'after' => '</div>' ) ); ?>

				<div class="siteFooter-content">

					<div class="siteFooter-info">
						<h1>Related Sites</h1>
						<p>This is some content. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad minima similique aut quia placeat maxime.</p>
					</div>
				
					<nav class="siteFooter-links">
						<h3>Related Sites</h3>
						<ul>
							<li><a href="#">Department of Footer Links &amp; HTML Semantics</a></li>
							<li><a href="#">Another Relevant Website</a></li>
						</ul>
					</nav>

				<?php if ( has_nav_menu( 'social' ) ) : ?>
					<nav class="siteFooter-social" role="navigation">
						<h3>Follow Us</h3>
						<?php
							wp_nav_menu( array(
								'theme_location' => 'social',
								'depth'          => 1,
							) );
						?>
					</nav>
				<?php endif; ?>

				</div>

			</footer>

			<?php wp_footer(); ?>

		</div>
	</div>
</body>
</html>

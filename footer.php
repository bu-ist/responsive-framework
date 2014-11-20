			</div><!-- .container -->

			<?php get_sidebar( 'bottom' ); ?>

			<footer class="siteFooter has-branding" role="contentinfo">

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

				<div class="siteFooter-brand">
					<a href="#" class="brand-masterPlate">Boston University</a>
				</div>
				
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

					<nav class="siteFooter-social">
						<h3>Follow Us</h3>
						<ul>
							<li><a href="#">Facebook</a></li>
							<li><a href="#">Twitter</a></li>
							<li><a href="#">Friendster</a></li>
						</ul>
					</nav>
				</div>

			</footer>

			<?php wp_footer(); ?>

		</div>
	</div>
</body>
</html>

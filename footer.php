			</div><!-- .container -->

			<?php get_sidebar( 'bottom' ); ?>

			<footer class="siteFooter" role="contentinfo">
				<a href="#top" title="Jump back to top">&#8593;</a>

			<?php if ( function_exists( 'bu_footer_content' ) ) {
				bu_footer_content();
			}

			$footer_contact = get_option( 'burf_setting_footer_contact' );
			if ( $footer_contact ) { echo $footer_contact; }

			// Social media links
			wp_nav_menu( array(
				'theme_location' => 'social',
				'items_wrap'     => '<ul>%3$s</ul>',
				'container'      => false,
				'fallback_cb'    => false,
			) );

			?>
			</footer>

			<?php wp_footer(); ?>

		</div><!-- .contentWrapper -->
	</div><!-- .wrapper -->
</body>
</html>

<?php if ( is_active_sidebar( 'sidebar' ) ): ?>
	<aside class="sidebar col-md-4">

		<?php if ( is_page_template( 'page-templates/calendar.php' ) ) {
			bu_flexi_calendar_sidebar();
		} ?>

		<?php dynamic_sidebar( 'sidebar' ); ?>
	</aside>
<?php endif; ?>
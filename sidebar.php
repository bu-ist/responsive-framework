<?php if ( is_active_sidebar( 'sidebar' ) ): ?>
	<aside class="sidebar">

		<?php if ( is_page_template( 'page-templates/calendar.php' ) ) {
			bu_flexi_calendar_sidebar();
		} ?>

		<?php dynamic_sidebar( 'sidebar' ); ?>
	</aside>
<?php endif; ?>
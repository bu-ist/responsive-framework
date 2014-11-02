<?php if ( is_active_sidebar( 'right-content-area' ) ): ?>
	<aside id="right-content-area" class="col-md-4">

		<?php if ( is_page_template( 'page-templates/calendar.php' ) ) {
			bu_flexi_calendar_sidebar();
		} ?>

		<?php dynamic_sidebar( 'right-content-area' ); ?>
	</aside>
<?php endif; ?>
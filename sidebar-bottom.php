<?php
if ( is_active_sidebar( 'bottom-content-area' ) &&
	! is_page_template( 'page-templates/no-sidebars.php' ) &&
	! is_page_template( 'page-templates/homepage.php' ) &&
	! is_search() ):
	?>
<aside id="bottom-content-area">
	<div><!-- TODO: Why is this div here? -->
		<?php dynamic_sidebar( 'bottom-content-area' ); ?>
	</div>
</aside>
<?php endif; ?>
<?php if ( is_active_sidebar( 'footbar' ) ) : ?>
<aside class="footbar <?php responsive_sidebar_classes( 'footbar' ); ?>">
	<div class="footbar-container">
		<?php dynamic_sidebar( 'footbar' ); ?>
	</div>
</aside>
<?php endif; ?>

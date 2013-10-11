<?php $footbar = bu_flexi_get_footbar_for_post( get_the_ID() ); ?>
<?php if(is_active_sidebar($footbar)) : ?>
<aside id="footbar1"<?php bu_flexi_footbar_class( $footbar ); ?> role="complementary">
	<div class="container">
	<?php dynamic_sidebar($footbar); ?>
	</div><!-- /.container -->
</aside><!-- /#footbar -->
<?php endif; ?>

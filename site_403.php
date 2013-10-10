<?php get_header(); ?>
<div class="container">
	<?php get_template_part('main-container'); ?>
	<div<?php bu_flexi_main_id(); ?> class="main">
		<div class="container">
			<?php do_403_message(); ?>
		</div><!-- /.container -->
	</div><!--  /.main -->
</div><!-- /.container -->
<?php get_footer(); ?>
<?php get_header(); ?>
<?php get_template_part('after-header'); ?>
<div class="container">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div<?php bu_flexi_main_id(); ?> class="main taxonomy">
		<div class="container">
			<?php bu_flexi_get_taxonomy_template_part(); ?>
		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>

<?php get_footer(); ?>

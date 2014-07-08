<?php get_header(); ?>
<?php get_template_part('after-header'); ?>

<div class="container">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div class="main">
		<div class="container posts profiles">
			<h1>Profile Directory</h1>
			<?php bu_profile_get_template_part( 'basic' ); ?>
		<p class="navigation"><span class="previous"><?php previous_posts_link('Previous') ?></span> <span class="next"><?php next_posts_link('Next') ?></span></p><!-- /.navigation -->
		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>

<?php get_footer(); ?>
<?php
/*
Template Name: News
*/
?>

<?php get_header(); ?>
		<div class="posts col-md-8" >
			<! -- news posts -->
		</div>

		<?php if ( is_dynamic_sidebar( 'sidebar' ) ): ?>
		<aside class="col-md-4 sidebar">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</aside>
		<?php endif; ?>

<?php get_footer(); ?>

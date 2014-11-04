<?php get_header(); ?>

		<div class="posts col-md-8" >
			<?php get_template_part( 'loop', 'index' ); ?>
		</div>

		<?php if ( is_dynamic_sidebar( 'sidebar' ) ): ?>
		<aside class="col-md-4 sidebar">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</aside>
		<?php endif; ?>

	</div><!-- what am i closing? -->

<?php get_footer(); ?>

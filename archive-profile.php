<?php get_header(); ?>

	<article role="main" class="col-md-8" id="post-<?php the_ID(); ?>">

		<h1>Profile Directory</h1>
		<?php bu_profile_get_template_part( 'basic' ); ?>
		<p class="navigation"><span class="previous"><?php previous_posts_link( 'Previous' ) ?></span> <span class="next"><?php next_posts_link( 'Next' ) ?></span></p><!-- /.navigation -->

	</article><!-- #post-<?php the_ID(); ?> -->

<?php get_footer(); ?>

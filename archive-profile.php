<?php
/**
 * Template used to display Profile archive.
 */

get_header(); ?>

	<article role="main" class="col-md-8" id="post-<?php the_ID(); ?>">

		<h1>Profile Directory</h1>

		<?php bu_profile_get_template_part( 'basic' ); ?>

		<?php responsive_paging_nav(); ?>

	</article><!-- #post-<?php the_ID(); ?> -->

<?php get_footer(); ?>

<?php
/**
 * Template used to display Profile archive.
 *
 * @package Responsive_Framework\BU_Profiles
 */

get_header(); ?>

	<article class="content-area profiles-archive">
		<?php if ( have_posts() ) : ?>

			<h1>Profile Directory</h1>

			<ul class="profile-listing basic">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/profile' ); ?>
				<?php endwhile; ?>
			</ul>

			<?php responsive_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>
	</article>

<?php get_sidebar( 'profiles' ); ?>

<?php get_footer();

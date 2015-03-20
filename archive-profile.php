<?php
/**
 * Template used to display Profile archive.
 */

get_header(); ?>

	<article role="main" class="profiles-archive">
	<?php if ( have_posts() ) : ?>

		<h1>Profile Directory</h1>

		<div class="profile-listing">
			<ul class="basic">

		<?php while ( have_posts() ): the_post();

			get_template_part( 'template-parts/content', 'profiles' );

		endwhile; ?>

			</ul>
		</div>

		<?php
			responsive_posts_navigation( array(
				'prev_text'          => '<span class="meta-nav">&larr;</span> Previous',
				'next_text'          => 'Next <span class="meta-nav">&rarr;</span>',
				'screen_reader_text' => 'Profiles Navigation',
			) );
		?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>
	</article>

<?php get_sidebar( 'profiles' ); ?>

<?php get_footer(); ?>

<?php
/**
 * Template used to display Profile archive.
 */

get_header(); ?>

		<article role="main" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<h1>Profile Directory</h1>

			<?php bu_profile_get_template_part( 'basic' ); ?>

			<?php
				responsive_posts_navigation( array(
					'prev_text'          => '<span class="meta-nav">&larr;</span> Previous',
					'next_text'          => 'Next <span class="meta-nav">&rarr;</span>',
					'screen_reader_text' => 'Profiles Navigation',
				) );
			?>

		</article><!-- #post-<?php the_ID(); ?> -->

<?php get_sidebar( 'profiles' ); ?>
<?php get_footer(); ?>

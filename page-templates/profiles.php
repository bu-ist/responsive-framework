<?php
/*
 * Template Name: Profiles
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php responsive_content_banner( 'pageWidth' ); ?>

		<article role="main" class="col-md-8" id="post-<?php the_ID(); ?>">

			<?php responsive_content_banner( 'contentWidth' ); ?>

			<h1><?php the_title(); ?></h1>

			<?php the_content( '<p class="serif">Read the rest of this page &raquo;</p>' ); ?>

			<?php if ( defined( 'BU_PROFILES_PLUGIN_ACTIVE' ) && BU_PROFILES_PLUGIN_ACTIVE ) : ?>
			<?php $format = bu_profile_get_format_for_post(); ?>
			<?php $query = bu_profile_get_query();?>
			<?php bu_profile_get_template_part( $format, $query ); ?>
			<?php endif; ?>

			<?php responsive_comments(); ?>

		</article>

	<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

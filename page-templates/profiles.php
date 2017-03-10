<?php
/**
 * Template Name: Profiles
 *
 * @package Responsive_Framework\BU_Profiles
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php responsive_content_banner( 'page-width' ); ?>

		<article id="post-<?php the_ID(); ?>" class="content-area">

			<?php responsive_content_banner( 'content-width' ); ?>

			<?php the_title( '<h1>', '</h1>' ); ?>

			<?php the_content( '<p class="serif">Read the rest of this page &raquo;</p>' ); ?>

			<?php if ( defined( 'BU_PROFILES_PLUGIN_ACTIVE' ) && BU_PROFILES_PLUGIN_ACTIVE ) : ?>
			<?php $format = bu_profile_get_format_for_post(); ?>
			<?php $query = bu_profile_get_query();?>
			<?php bu_profile_get_template_part( $format, $query ); ?>
			<?php endif; ?>

			<?php responsive_comments(); ?>

		</article>

	<?php endwhile; ?>

<?php get_sidebar( 'profiles' ); ?>
<?php get_footer();

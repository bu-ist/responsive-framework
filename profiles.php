<?php
/**
 * Template Name: Profiles
 *
 * @package Responsive_Framework\BU_Profiles
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" class="content-area">

			<?php responsive_the_title(); ?>

			<?php the_content( '<p class="serif">' . esc_html__( 'Read the rest of this profile &raquo;', 'responsive-framework' ) . '</p>' ); ?>

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

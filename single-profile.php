<?php
/**
 * Template file used to render a single profile.
 *
 * @package Responsive_Framework\BU_Profiles
 */

get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'template-parts/profile', 'single' ); ?>

	<?php endif; ?>

<?php get_sidebar( 'profiles' ); ?>
<?php get_footer();

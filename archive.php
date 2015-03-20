<?php
/**
 * Generic post archive template.
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<?php
			the_archive_title( '<h1>', '</h1>' );
			the_archive_description( '<div class="taxonomyDescription">', '</div>' );
		?>

	<?php while ( have_posts() ): the_post(); ?>

		<?php get_template_part( 'template-parts/content' ); ?>

	<?php endwhile; ?>

	<?php responsive_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

<?php
if ( is_date() || is_author() || is_category() || is_tag() ) :
	get_sidebar( 'posts' );
else :
	get_sidebar();
endif;
?>

<?php get_footer(); ?>

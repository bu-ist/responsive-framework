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

	<?php responsive_paging_nav(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

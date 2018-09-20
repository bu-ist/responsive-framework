<?php
/**
 * Generic post archive template.

 * @package Responsive_Framework
 */

get_header();
?>

<article class="content-area">

	<?php if ( have_posts() ) : ?>

		<?php
			responsive_the_title();
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php r_get_template_part( get_post_type(), 'archive' ); ?>
		<?php endwhile; ?>

		<?php responsive_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/no-content', 'archive' ); ?>

	<?php endif; ?>

</article>

<?php r_get_archive_sidebar(); ?>

<?php get_footer();

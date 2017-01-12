<?php
/**
 * Generic post archive template.

 * @package Responsive_Framework
 */

get_header();

$archive_type = responsive_archive_type();
?>

<div class="content-area">

	<?php if ( have_posts() ) : ?>

		<?php
			the_archive_title( '<h1>', '</h1>' );
			the_archive_description( '<div class="taxonomyDescription">', '</div>' );
		?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', $archive_type ); ?>
		<?php endwhile; ?>

		<?php responsive_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

</div>

<?php get_sidebar( $archive_type ); ?>

<?php get_footer();

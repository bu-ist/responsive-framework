<?php
/**
 * Generic post archive template.
 */

get_header();

$archive_type = responsive_archive_type();
?>

	<?php if ( have_posts() ) : ?>

		<?php
			the_archive_title( '<h1>', '</h1>' );
			the_archive_description( '<div class="taxonomyDescription">', '</div>' );
		?>

		<?php
		// Profiles get some special sauce.
		if ( 'profiles' === $archive_type ) : ?>
		<div class="profile-listing">
			<ul class="basic">
		<?php endif; ?>

		<?php while ( have_posts() ): the_post();

			get_template_part( 'template-parts/content', $archive_type );

		endwhile; ?>

		<?php if ( 'profiles' === $archive_type ) : ?>
			</ul>
		</div>
		<?php endif; ?>

		<?php responsive_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

<?php get_sidebar( $archive_type ); ?>

<?php get_footer(); ?>

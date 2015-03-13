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

		<?php
		// Profiles get some special sauce.
		if ( responsive_is_archive_type( 'profiles' ) ) : ?>
		<div class="profile-listing">
			<ul class="basic">
		<?php endif; ?>

		<?php while ( have_posts() ): the_post();

			get_template_part( 'template-parts/content', responsive_archive_type() );

		endwhile; ?>

		<?php if ( responsive_is_archive_type( 'profiles' ) ) : ?>
			</ul>
		</div>
		<?php endif; ?>

		<?php responsive_paging_nav(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

<?php get_sidebar( responsive_archive_type() ); ?>

<?php get_footer(); ?>

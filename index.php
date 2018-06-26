<?php
/**
 * The main template file.
 *
 * @package Responsive_Framework
 */

get_header(); ?>

<article class="content-area">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php r_get_template_part( get_post_type(), 'index' ); ?>

		<?php endwhile; ?>

		<?php responsive_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/no-content', 'index' ); ?>

	<?php endif; ?>

	<?php get_sidebar(); ?>

</article>

<?php get_footer();

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

			<?php get_template_part( 'template-parts/content' ); ?>

		<?php endwhile; ?>

		<?php responsive_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

	<?php get_sidebar(); ?>

</article>

<?php get_footer();

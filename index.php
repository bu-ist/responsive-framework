<?php
/**
 * The main template file.
 */

get_header(); ?>

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content' ); ?>

			<?php endwhile; ?>

			<?php  if (  $wp_query->max_num_pages > 1 ) : ?>
			<ul class="navigation">
				<li class="older">
					<?php next_posts_link( __( 'Older posts' ) ); ?>
				</li>
				<li class="newer">
					<?php previous_posts_link( __( 'Newer posts' ) ); ?>
				</li>
			</ul>
			<?php endif; ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

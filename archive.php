<?php
/**
 * Generic post archive template.
 */

get_header(); ?>

		<div class="posts col-md-8" >

			<section class="row">

			<?php if ( have_posts() ) : ?>
				<h1>
					<?php if ( is_day() ) : ?><?php printf( __( '<span>Daily Archive</span> %s' ), get_the_date() ); ?>
					<?php elseif ( is_month() ) : ?><?php printf( __( '<span>Monthly Archive</span> %s' ), get_the_date( 'F Y' ) ); ?>
					<?php elseif ( is_year() ) : ?><?php printf( __( '<span>Yearly Archive</span> %s' ), get_the_date( 'Y' ) ); ?>
					<?php elseif ( is_category() ) : ?>Category: <?php echo single_cat_title(); ?>
					<?php elseif ( is_tag() ) : ?>Tag: <?php echo single_tag_title(); ?>
					<?php elseif ( is_tax() ) :
						global $wp_query;
						$term = $wp_query->get_queried_object();
						$title = $term->name;
						$tax = $term->taxonomy;
						$tax_obj = get_taxonomy( $tax );
						echo $tax_obj->label . ': ' . $title;
						?>
					<?php endif; ?>
				</h1>

			<?php while ( have_posts() ): the_post(); ?>

				<?php get_template_part( 'template-parts/content' ); ?>a

			<?php endwhile; ?>

			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php if (  $wp_query->max_num_pages > 1 ) : ?>
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

			</section>

		</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

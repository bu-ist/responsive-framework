<?php
/**
 * Template file used to render the Blog Posts Index, whether on the site front page or on a static page.
 */

get_header(); ?>

		<div class="posts col-md-8" >

			<section class="row">

			<?php if ( have_posts() ) : ?>
				<h1>Latest Posts</h1>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content' ); ?>

			<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

			</section>

		</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

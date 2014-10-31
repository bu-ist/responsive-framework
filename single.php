<?php get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<article role="main" class="col-md-8" id="post-<?php the_ID(); ?>">
			<header>
				<h1><?php the_title(); ?></h1>
			</header>

			<?php the_post_thumbnail( 'full' );?>

			<?php the_content(); ?>

			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:' ), 'after' => '</div>' ) ); ?>

			<footer class="entry-meta">
				<p>Posted <strong><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago'; ?></strong> on <time datetime="<?php the_time( 'l, F jS, Y' ) ?>" pubdate><?php the_time( 'l, F jS, Y' ) ?></time> &middot; <a href="<?php the_permalink(); ?>">Permalink</a></p>
			</footer>

			<?php responsive_comments(); ?>

			<ul class="navigation">
				<li class="older">
					<?php previous_post_link( '%link', '&larr; %title' ); ?>
				</li>
				<li class="newer">
					<?php next_post_link( '%link', '%title &rarr;' ); ?>
				</li>
			</ul>

			<?php endwhile; // end of the loop. ?>
		</article>

		<?php if ( is_dynamic_sidebar( 'right-content-area' ) ): ?>
			<aside class="col-md-4" id="right-content-area">
				<?php dynamic_sidebar( 'right-content-area' ); ?>
			</aside>
		<?php endif; ?>

	</div><!-- why am i here? -->

<?php get_footer(); ?>

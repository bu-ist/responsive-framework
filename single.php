<?php
/**
 * Template file used to render a single post.
 *
 * @package Responsive_Framework
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php responsive_content_banner( 'page-width' ); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area' ); ?>>

			<?php the_title( '<header><h1>', '</h1></header>' ); ?>

			<?php responsive_content_banner( 'content-width' ); ?>

			<?php the_content(); ?>

			<?php responsive_share_tools(); ?>

			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'responsive-framework' ), 'after' => '</div>' ) ); ?>

			<footer class="meta single-meta">
				<h4 class="post-title single-meta-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<?php if ( responsive_posts_should_display( 'author' ) ) : ?>
					<h5 class="byline single-meta-byline"><em>By </em><?php the_author(); ?></h5>
				<?php endif; ?>
				<p class="posted-date-category single-meta-info">
					<em class="posted">Posted </em><span class="date-offset"><?php echo esc_attr( human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago' ); ?></span>
					<em class="on"> on </em><span class="date"><time datetime="<?php the_time( 'l, F jS, Y' ) ?>" pubdate><?php the_time( 'l, F jS, Y' ) ?></time></span>
					<?php if ( responsive_posts_should_display( 'categories' ) ) : ?>
						<?php responsive_category_links( array( 'before' => '<span class="categories"><em> in </em>' ) ); ?>
					<?php endif; ?>
				</p>
				<?php if ( responsive_posts_should_display( 'tags' ) ) : ?>
					<?php the_tags( sprintf( '<p class="tagged single-meta-info"><em>%s: </em>', esc_html__( 'Tagged', 'responsive-framework' ) ), ', ', '</p>' ); ?>
				<?php endif; ?>
			</footer>

			<?php responsive_posts_archive_link(); ?>

			<?php edit_post_link( __( 'Edit', 'responsive-framework' ), '<span class="edit-link">', '</span>' ); ?>

			<?php responsive_comments(); ?>

		</article>

	<?php endwhile; ?>

<?php get_sidebar( 'posts' ); ?>
<?php get_footer();

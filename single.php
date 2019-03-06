<?php
/**
 * Template file used to render a single post.
 *
 * @package Responsive_Framework
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php
		/**
		 * Fires immediately before the opening article tag.
		 *
		 * @since 2.2.1
		 */
		do_action( 'r_before_opening_article' );
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area' ); ?>>

			<?php
			/**
			 * Fires immediately after opening article tag.
			 *
			 * @since 2.2.1
			 */
			do_action( 'r_after_opening_article' );
			?>

			<?php the_content(); ?>

			<?php responsive_share_tools(); ?>

			<?php
				wp_link_pages( array(
					'before' => sprintf( '<div class="page-link">%s', esc_html__( 'Pages:', 'responsive-framework' ) ),
					'after' => '</div>',
				) );
			?>

			<footer class="meta single-meta">
				<h4 class="post-title single-meta-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<?php if ( responsive_posts_should_display( 'author' ) ) : ?>
					<h5 class="byline single-meta-byline">
						<?php
							/* translators: %s: author name */
							printf( wp_kses( __( '<em>By </em>%s', 'responsive-framework' ), array(
								'em' => array(),
							) ), get_the_author() );
						?>
					</h5>
				<?php endif; ?>
				<p class="posted-date-category single-meta-info">
					<?php
						echo wp_kses( _x( '<em class="posted">Posted </em>', 'Precedes the date posted in a human readable format, ie. 3 days ago.', 'responsive-framework' ), array(
							'em' => array(
								'class' => array(),
							),
						) );
						?>
					<span class="date-offset">
						<?php
							/* translators: %s: human readable time format. Ex. 3 days ago. */
							printf( esc_html_x( '%s ago', '%s = human readable time difference', 'responsive-framework' ), esc_html( human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ) );
						?>
					</span>

					<?php if ( responsive_posts_should_display( 'categories' ) ) : ?>
						<?php
							responsive_category_links( array(
								'before' => sprintf( '<span class="categories"><em> %s </em>', _x( 'in', 'Precedes a list of categories the post is in.', 'responsive-framework' ) ),
							) );
						?>
					<?php endif; ?>
				</p>
				<?php if ( responsive_posts_should_display( 'tags' ) ) : ?>
					<?php the_tags( sprintf( '<p class="tagged single-meta-info"><em>%s: </em>', esc_html__( 'Tagged', 'responsive-framework' ) ), ', ', '</p>' ); ?>
				<?php endif; ?>
			</footer>

			<?php responsive_posts_archive_link(); ?>

			<?php edit_post_link( __( 'Edit', 'responsive-framework' ), '<span class="edit-link">', '</span>' ); ?>

			<?php responsive_comments(); ?>

			<?php
			/**
			 * Fires immediately before closing article tag.
			 *
			 * @since 2.2.1
			 */
			do_action( 'r_before_closing_article' );
			?>

		</article>

		<?php
		/**
		 * Fires immediately after closing article tag.
		 *
		 * @since 2.2.1
		 */
		do_action( 'r_after_closing_article' );
		?>

	<?php endwhile; ?>

<?php get_sidebar( 'posts' ); ?>
<?php get_footer();

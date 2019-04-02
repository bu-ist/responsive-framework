<?php
/**
 * Template Name: Calendar
 *
 * @package Responsive_Framework
 */

get_header();

// Displays the h1 page title and content.
while ( have_posts() ) :
	the_post();

	/**
	 * Fires immediately before the opening article tag.
	 *
	 * @since 2.3.3
	 */
	do_action( 'r_before_opening_article' );
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'content-area', 'calendar-list' ) ); ?>>

		<?php
		/**
		 * Fires immediately after opening article tag.
		 *
		 * @since 2.3.3
		 */
		do_action( 'r_after_opening_article' );

		the_content( '<p class="serif">Read the rest of this page &raquo;</p>' );

		wp_link_pages(
			array(
				'before'         => '<p><strong>Pages:</strong> ',
				'after'          => '</p>',
				'next_or_number' => 'number',
			)
		);

		// Retrieves calendar partial.
		get_template_part( 'template-parts/calendar/calendar' );

		/**
		 * Fires immediately before closing article tag.
		 *
		 * @since 2.3.3
		 */
		do_action( 'r_before_closing_article' );
		?>

	</article>

	<?php
	/**
	 * Fires immediately after closing article tag.
	 *
	 * @since 2.3.3
	 */
	do_action( 'r_after_closing_article' );

endwhile;

// Retrieve the calendar sidebar.
get_sidebar( 'calendar' );

get_footer();

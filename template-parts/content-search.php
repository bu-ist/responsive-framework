<?php
/**
 * Default content template partial.
 *
 * Used to render post content for archives.
 */
?>

<article id="post-<?php the_ID(); ?>">

	<h2>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h2>

	<?php responsive_post_meta(); ?>

	<?php responsive_search_results(); ?>

	<?php if ( responsive_posts_should_display( 'tags' ) ) {
		the_tags( '<div class="tags">Tags: ', ', ', '</div>' );
	} ?>

	<?php edit_post_link( 'Edit', '<p class="edit-link">', '</p>' ); ?>

</article>


	 
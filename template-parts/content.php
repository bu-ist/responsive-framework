<?php
/**
 * Default content template partial.
 *
 * Used to render post content for archives.
 *
 * @package Responsive_Framework
 */

?>

<article role="article" id="post-<?php the_ID(); ?>" <?php post_class( 'post-part' ); ?>>

	<h2 class="post-headline">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h2>

	<?php responsive_post_meta(); ?>

	<?php the_excerpt(); ?>

	<?php if ( responsive_posts_should_display( 'tags' ) ) {
		the_tags( '<p class="meta tags"><em>Tagged:</em> ', ', ', '</p>' );
} ?>

	<?php edit_post_link( 'Edit', '<p class="edit-link">', '</p>' ); ?>

</article>

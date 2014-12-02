<?php
/**
 * Default content template partial.
 *
 * Used to render post content for archives.
 */
?>

<article id="post-<?php the_ID(); ?>">

	<h2>
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( '%s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?>
		</a>
	</h2>

	<p class="entry-meta">
		<time datetime="<?php the_time( 'l, F jS, Y' ) ?>" pubdate><?php the_time( 'l jS F Y' ) ?></time>
	</p>

	<?php the_excerpt(); ?>

	<?php responsive_category_links( array( 'before' => '<div class="categories">Categories: ', 'after' => '</div>' ) ); ?>
	<?php the_tags( '<div class="tags">Tags: ', ', ', '</div>' ); ?>

	<?php edit_post_link( 'Edit', '<p class="edit-link">', '</p>' ); ?>

</article>

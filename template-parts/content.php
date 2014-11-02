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

	<?php if ( has_category() ) : ?>
	<div class="categories">
		Categories: <?php the_category( ', ' ); ?>
	</div>
	<?php endif; ?>

	<div class="tags">
		<?php the_tags( 'Tags: ', ', ', ' ' ); ?>
	</div>

	<div class="taxonomies">
		 <?php echo responsive_term_links(); ?>
	</div>

</article>

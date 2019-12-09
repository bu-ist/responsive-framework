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
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h2>

	<?php responsive_post_meta(); ?>
	<?php
		$glossary_terms = get_the_terms( get_the_ID(), 'glossary-cat' );
	?>

	<?php if ( $glossary_terms && ! is_wp_error( $glossary_terms ) ) : ?>
		<p class="glossary-terms">Categorized:
			<?php
				foreach ( $glossary_terms as $term ){
					echo( '<a href="' . get_term_link( $term ) . '" class="glossary-term-tag">' . $term->name . '</a>' );
				}
			?>
		</p>
	<?php endif; ?>

	<?php the_content(); ?>

	<?php edit_post_link( __( 'Edit Post', 'responsive-framework' ), '<span class="edit-link">', '</span><span class="post-edit-hint"></span>' ); ?>

</article>

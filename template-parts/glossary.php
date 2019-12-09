<?php
/**
 * Glossary content template partial.
 *
 * Used to render glossary terms content for archives.
 *
 * @package Responsive_Framework
 */

?>

<article role="article" id="post-<?php the_ID(); ?>" <?php post_class( 'post-part bu_collapsible_container' ); ?>>

	<h2 class="post-headline bu_collapsible">
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h2>
	<div class="bu_collapsible_section">
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
	</div>

	<?php edit_post_link( __( 'Edit Post', 'responsive-framework' ), '<span class="edit-link">', '</span><span class="post-edit-hint"></span>' ); ?>

</article>

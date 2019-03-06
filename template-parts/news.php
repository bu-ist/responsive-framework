<?php
/**
 * Template partial used to display content for BU Posts List "News" template.
 *
 * @package Responsive_Framework
 */

if ( ! class_exists( 'BU_News_Page_Template' ) ) {
	get_template_part( 'content' );
	return;
}
?>
<article role="article" id="post-<?php the_ID(); ?>" <?php post_class( 'post-part' ); ?>>

	<?php BU_News_Page_Template::show_thumbnail( '<div class="thumb post-thumb">', '</div>' ); ?>

	<h2 class="post-headline">
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h2>

	<?php

	$show_meta = (bool) BU_News_Page_Template::$display_content;

	if ( $show_meta ) : ?>
		<p class="meta post-meta">
			<?php BU_News_Page_Template::show_author( '<span class="author post-author"><em>By</em> ', '</span>' ); ?>
			<?php BU_News_Page_Template::show_date( '<span class="date post-date">', '</span>' ); ?>
			<?php BU_News_Page_Template::show_categories( '<span class="category post-category"><em>in</em> ', '</span>' ); ?>
			<?php BU_News_Page_Template::show_comments( '<span class="comment-counter">', '</span>' ); ?>
		</p>
	<?php endif; ?>

	<?php BU_News_Page_Template::show_content( '', '', 'More' ); ?>

	<?php

	if ( $show_meta ) {
		BU_News_Page_Template::show_tags( '<p class="meta tag-list"><span class="tags"><em>' . __( 'Tagged:', 'responsive-framework' ) . '</em> ', '</span></p>' );
	}

	?>

	<?php edit_post_link( __( 'Edit Post', 'responsive-framework' ), '<span class="edit-link">', '</span><span class="post-edit-hint"></span>' ); ?>

</article>

<?php
/**
 * Template partial used to display content for BU Posts List "News" template.
 *
 * @package Responsive_Framework
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area' ); ?>>

	<?php BU_News_Page_Template::show_thumbnail( '<div class="thumb">', '</div>' ); ?>

	<h2>
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	</h2>

	<?php

	$show_meta = (bool) BU_News_Page_Template::$display_content;

	if ( $show_meta ) : ?>
		<div class="meta">
			<?php BU_News_Page_Template::show_author( '<span class="author"><em>By</em> ', '</span>' ); ?>
			<?php BU_News_Page_Template::show_date( '<span class="date">', '</span>' ); ?>
			<?php BU_News_Page_Template::show_categories( '<span class="category"><em>in</em> ', '</span>' ); ?>
			<?php BU_News_Page_Template::show_comments( '<span class="comment-counter">', '</span>' ); ?>
		</div>
	<?php endif; ?>

	<?php BU_News_Page_Template::show_content( '', '', 'More' ); ?>

	<?php

	if ( $show_meta ) {
		BU_News_Page_Template::show_tags( '<p class="meta tag-list"><span class="tags"><em>Tagged:</em> ', '</span></p>' );
	}

	?>
</article>

<?php
/**
 * Template partial used to display content for single pages.
 *
 * @package Responsive_Framework
 */

?>

<article role="main" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php responsive_content_banner( 'contentWidth' ); ?>

	<?php the_title( '<h1>', '</h1>' ); ?>

	<?php the_content(); ?>

	<?php responsive_share_tools(); ?>

	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:' ), 'after' => '</div>' ) ); ?>

	<?php edit_post_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>

	<?php responsive_comments(); ?>

</article>

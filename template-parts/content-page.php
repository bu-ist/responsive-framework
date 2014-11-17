<?php
/**
 * Template partial used to display content for single pages.
 */
?>

<article role="main" id="post-<?php the_ID(); ?>">

	<?php responsive_content_banner( 'contentWidth' ); ?>

	<?php if ( is_front_page() ) { ?>
		<h1><?php the_title(); ?></h1>
	<?php } else { ?>
		<h1><?php the_title(); ?></h1>
	<?php } ?>

	<?php the_content(); ?>

	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:' ), 'after' => '</div>' ) ); ?>

	<?php edit_post_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>

	<?php responsive_comments(); ?>

</article>

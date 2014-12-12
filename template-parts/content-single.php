<?php
/**
 * Template partial used to display content for single posts.
 */
?>

<article role="main" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header>
		<h1><?php the_title(); ?></h1>
	</header>

	<?php responsive_content_banner( 'contentWidth' ); ?>

	<?php the_content(); ?>

	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:' ), 'after' => '</div>' ) ); ?>

	<footer class="meta">
		<h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		<h5 class="byline"><em>By </em><?php the_author(); ?></h5>
		<p class="postedDateCategory">
			<em class="posted">Posted </em><span class="date-offset"><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago'; ?></span>
			<em class="on"> on </em><span class="date"><time datetime="<?php the_time( 'l, F jS, Y' ) ?>" pubdate><?php the_time( 'l, F jS, Y' ) ?></time></span>
			<?php responsive_category_links( array( 'before' => '<span class="categories"><em> in </em>' ) ); ?>
		</p>
		<?php the_tags( '<p class="tagged"><em>Tagged: </em>', ', ', '</p>' ); ?>
	</footer>

	<?php responsive_posts_archive_link(); ?>

	<?php edit_post_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>

	<?php responsive_comments(); ?>

</article>
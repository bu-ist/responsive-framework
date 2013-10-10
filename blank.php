<?php
/*
Template Name: Page-width, no title, no sidebar(s) 
*/
?>
<?php get_header(); ?>
<?php get_template_part('after-header'); ?>
<div class="container">
	<?php get_template_part('main-container'); ?>
	<div class="main page-width">
		<div class="container">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="content-panel" id="post-<?php the_ID(); ?>">
            <?php edit_post_link('Edit', '<p class="edit-link">', '</p>'); ?>
            <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

        </div>
		    <?php endwhile; endif; ?>
		</div><!-- /.container -->
	</div><!--  /.main -->
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>
<?php get_footer(); ?>
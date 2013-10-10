
<?php
/*
Template Name: Glossary
*/
?>
<?php wp_enqueue_script('bu-glossary-highlight', get_bloginfo('template_directory') . '/scripts/bu-glossary-highlight.js', array('jquery'), false, true); ?>
<?php get_header(); ?>
<?php get_template_part('after-header'); ?>


<div class="container">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div<?php bu_flexi_main_id(); ?> class="main">
		<div class="container">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div class="content-panel" id="post-<?php the_ID(); ?>">
            <?php edit_post_link('Edit', '<p class="edit-link">', '</p>'); ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>


        </div>
		    <?php endwhile; endif; ?>
			<?php bu_flexi_glossary(); ?>
		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>

<?php get_footer(); ?>

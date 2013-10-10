<?php
/*
 * Template Name: Profiles
 */
?>
<?php get_header(); ?>
<?php get_template_part('after-header'); ?>

<div class="container">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div<?php bu_flexi_main_id(); ?> class="main">
		<div class="container">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php if (function_exists('bu_content_banner')) {
					bu_content_banner($post->ID, $args = array(
						'before' => '<div class="banner-container">',
						'after' => '</div>',
						'class' => 'banner',
						'maxwidth' => BU_FLEXI_CONTENT_IMAGE_WIDTH,
						'position' => 'content-width'

						));
				} ?>
        	<div class="content-panel" id="post-<?php the_ID(); ?>">
            		<?php edit_post_link('Edit', '<p class="edit-link">', '</p>'); ?>
			<h1><?php the_title(); ?></h1>
            		<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
			
			<?php if( defined('BU_PROFILES_PLUGIN_ACTIVE') && BU_PROFILES_PLUGIN_ACTIVE ): ?>
			<?php $format = bu_profile_get_format_for_post(); ?>
			<?php $query = bu_profile_get_query();?>
			<?php bu_profile_get_template_part( $format, $query ); ?>
			<?php endif; ?>
		
		</div><!-- /.post-<?php the_ID(); ?> -->
		<?php get_template_part('after-content'); ?>
		<?php if(bu_supports_comments()) { comments_template(); }?>

		    <?php endwhile; endif; ?>
		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>

<?php get_footer(); ?>
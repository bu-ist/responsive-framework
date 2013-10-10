<?php get_header(); ?>
<div class="container">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div<?php bu_flexi_main_id(); ?> class="main">
		<div class="container">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
			<div class="entry">
				<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a></p>
				<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></div>
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
				<p class="navigation"><span class="previous"><?php previous_image_link(null, 'Previous') ?></span> <span class="next"><?php next_image_link(null, 'Next') ?></span></p>
			</div>
		</div>
		<?php endwhile;  ?>
		<?php if(bu_supports_comments()) { comments_template(); }?>
		<?php else: ?>
		<p>Sorry, no attachments matched your criteria.</p>
		<?php endif; ?>

		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>

<?php get_footer(); ?>

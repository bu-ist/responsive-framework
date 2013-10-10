<?php $display_opts = get_option('flexi_display', array('cat' => 1, 'tag' => 1, 'author' => 0)); ?>
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
        
			<div class="content-panel full-post post" id="post-<?php the_ID(); ?>">
				<?php edit_post_link('Edit', '<p class="edit-link">', '</p>'); ?>
				<h1><?php the_title(); ?></h1>
				<p class="meta">
					<?php if ($display_opts['author']): ?>
					<span class="author"><em> By <?php the_author_posts_link()  ?></em></span>
					<?php endif; ?>
					
					<?php if ($display_opts['cat']): ?>
					<span class="category"><em>in <?php the_category(', ') ?></em></span>
					<?php endif; ?>	
					<br />
					<?php the_time('F jS, Y') ?>
				</p>
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div><!--/.content-->
			<p class="meta">
				<span class="tags"><?php the_tags('Tagged <em>', ', ', '</em>');  ?></span>
			</p>
			<?php if(bu_supports_comments()) { comments_template(); }?>
			<?php endwhile; endif; ?>
		</div><!-- /.container -->
	</div><!-- /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>

<?php get_footer(); ?>
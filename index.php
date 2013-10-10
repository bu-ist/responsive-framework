<?php $display_opts = get_option('flexi_display', array('cat' => 1, 'tag' => 1, 'author' => 0)); ?>
<?php get_header(); ?>

<div class="container">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div<?php bu_flexi_main_id(); ?> class="main">
		<div class="container posts">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="content-panel post" id="post-<?php the_ID(); ?>">
				<?php edit_post_link('Edit', '<p class="edit-link">', '</p>'); ?>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<p class="meta"><span class="date"><?php the_time('F jS, Y') ?></span>
					<?php if ($display_opts['cat']): ?>
					<span class="category">in <?php the_category(', ') ?></span>
					<?php endif; ?>	
					
					<?php if(bu_supports_comments()): ?>
					<span class="comment-counter"><a href="<?php comments_link(); ?>" rel="nofollow"><?php comments_number('<strong>0</strong> comments','<strong>1</strong> comment','<strong>%</strong> comments'); ?></a></span>
					<?php endif; ?>
				</p>
				<?php the_content('More'); ?>
				<p class="meta">
					<?php if ($display_opts['author']): ?>
					<span class="author">By <?php the_author_posts_link()  ?></span>
					<?php endif; ?>
					
					<?php if ($display_opts['tag']): ?>
					<?php the_tags('<span class="tags">Tagged ', ', ', '</span>');  ?>
					<?php endif; ?>
				</p>
			</div><!-- /.post -->
		    <?php endwhile; endif; ?>
				<p class="navigation"><span class="previous"><?php next_posts_link('Older') ?></span> <span class="next"><?php previous_posts_link('Newer') ?></span></p>
		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>

<?php get_footer(); ?>
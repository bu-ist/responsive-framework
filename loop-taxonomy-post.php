<?php $display_opts = get_option('flexi_display', array('cat' => 1, 'tag' => 1, 'author' => 0)); ?>
<?php if (have_posts()) : ?>
	<h1>Posts tagged <strong><?php bu_current_term_name(); ?></strong></h1 >
	<?php while (have_posts()) : the_post(); ?>
	<?php
	$odd_post = $wp_query->current_post % 2;
	if ($odd_post) {
		$odd_even = 'odd';
	} else {
		$odd_even = 'even';
	}
	?>
	<div class="content-panel post <?php echo $odd_even; ?>" id="post-<?php the_ID(); ?>">
		<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<p class="meta"><span class="date"><?php the_time('F jS, Y') ?></span>
			<?php if ($display_opts['cat']): ?>
			<span class="category">in <?php the_category(', ') ?></span>
			<?php endif; ?>
			
			<?php if (bu_supports_comments()): ?> 
				<span class="comment-counter"><a href="<?php comments_link(); ?>" rel="nofollow"><?php comments_number('<strong>0</strong> comments', '<strong>1</strong> comment', '<strong>%</strong> comments'); ?></a></span>
			<?php endif; ?>
		</p>
		<?php the_content('More'); ?>
		<p class="meta">
			<?php if ($display_opts['author']): ?>
			<span class="author">By <?php the_author_posts_link()  ?></span>
			<?php endif; ?>
			
			<?php if ($display_opts['tag']): ?>
			<span class="tags"><?php the_tags('Tagged ', ', ', '');  ?></span>
			<?php endif; ?>
		</p>
	</div><!-- /.post -->
	<?php endwhile; // End page/post loop ?>
	<p class="navigation"><span class="next"><?php next_posts_link('Next') ?></span> <span class="previous"><?php previous_posts_link('Previous') ?></span></p><!-- /.navigation -->
<?php else: ?>
	<p>No posts tagged <strong><?php bu_current_term_name(); ?></strong>.</p>
<?php endif;	// End post listing ?>
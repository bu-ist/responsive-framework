<?php if (have_posts()) : ?>
	<h1>Pages tagged <strong><?php bu_current_term_name(); ?></strong></h1 >
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
		<?php bu_thumbnail('', '', array('maxwidth' => 75, 'maxheight' => 75, 'use_thumb' => true)); ?>
		<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php esc_attr(get_the_title()); ?>"><?php the_title(); ?></a></h3>
		<?php bu_page_summary('<div class="summary">', '</div>'); ?>
	</div><!-- /.post -->
	<?php endwhile; // End page/post loop ?>
	<p class="navigation"><span class="next"><?php next_posts_link('Next') ?></span> <span class="previous"><?php previous_posts_link('Previous') ?></span></p><!-- /.navigation -->
<?php else: ?>
	<p>No pages tagged <strong><?php bu_current_term_name(); ?></strong>.</p>
<?php endif;	// End page listing ?>
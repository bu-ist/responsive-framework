<?php $display_opts = get_option('flexi_display', array('cat' => 1, 'tag' => 1, 'author' => 0)); ?>
<?php if (have_posts()) : ?>
	<h1>Items tagged <strong><?php bu_current_term_name(); ?></strong></h1 >
	<?php while (have_posts()) : the_post(); ?>
	<?php
	$post_type = get_post_type_object( $post->post_type );
	$post_type_label = $post_type->labels->singular_name;
	$taxonomy = get_queried_object()->taxonomy;
	$tax = get_taxonomy( $taxonomy );
	$odd_post = $wp_query->current_post % 2;
	if ($odd_post) {
		$odd_even = 'odd';
	} else {
		$odd_even = 'even';
	}
	?>
	<div class="content-panel post <?php echo $post->post_type; ?> <?php echo $odd_even; ?>" id="post-<?php the_ID(); ?>">
		<?php if( function_exists('bu_thumbnail') ): ?>
			<?php bu_thumbnail('<div class="thumbnail">', '</div>', array('maxwidth' => 75, 'maxheight' => 75, 'use_thumb' => true)); ?>
		<?php endif;?>
	<?php if ($post->post_type == 'page'): ?>
		<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></a></h3>
		<p class="meta">
			<span class="post-type"><?php echo $post_type_label; ?></span> | 
			<?php the_terms( get_the_ID(), $taxonomy, "<span class=\"$taxonomy\">{$tax->label}: ", ', ', "</span>\n" ); ?>
		</p>
		<?php bu_page_summary('<div class="summary"><p>', '</p></div>'); ?>
	<?php elseif($post->post_type == 'profile' && function_exists( 'bu_profile_detail' ) ): ?>
		<?php $full_name = bu_profile_detail( 'first_name', array('echo' => false ) ) . ' ' . bu_profile_detail( 'last_name', array('echo' => false ) ); ?>
		<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php echo esc_attr($full_name); ?>"><?php echo $full_name; ?></a></h3>
		<p class="meta">
			<span class="post-type"><?php echo $post_type_label; ?></span> | 
			<?php the_terms( get_the_ID(), $taxonomy, "<span class=\"$taxonomy\">{$tax->label}: ", ', ', "</span>\n" ); ?>
		</p>
	<?php elseif( $post->post_type == 'publication' ): ?>
		<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></a></h3>
		<p class="meta">
			<span class="post-type"><?php echo $post_type_label; ?></span> |
			<?php the_terms( get_the_ID(), $taxonomy, "<span class=\"$taxonomy\">{$tax->label}: ", ', ', "</span>\n" ); ?>
		</p>
	<?php else: ?>
		<h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
		<p class="meta">
			<span class="post-type"><?php echo $post_type_label; ?></span> |
			<span class="date"><?php the_time('F jS, Y') ?></span>
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
	<?php endif; // End page/post content ?>
	</div><!-- /.post -->
	<?php endwhile; // End page/post loop ?>
	<p class="navigation"><span class="next"><?php next_posts_link('Next') ?></span> <span class="previous"><?php previous_posts_link('Previous') ?></span></p><!-- /.navigation -->
<?php else: ?>
	<p>No items tagged <strong><?php bu_current_term_name(); ?></strong>.</p>
<?php endif;	// End mixed post type term listing ?>
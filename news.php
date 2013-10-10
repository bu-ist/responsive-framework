<?php 
/* 

Template Name: News

*/

get_header();

//setup for secondary query that lists posts based on the page's metadata.
include BU_NEWS_POST_LISTS_PATH . '/news-page-template.php';
BU_News_Page_Template::init();
$bu_display_content = BU_News_Page_Template::$display_content;

// Remove default sharedaddy display location
remove_filter('the_content', 'sharing_display', 19);

?>
<?php get_template_part('after-header'); ?>
<div class="container">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div<?php bu_flexi_main_id(); ?> class="main">
		<div class="container">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<?php if (function_exists('bu_content_banner')) {
					bu_content_banner($post->ID, $args = array(
						'before' => '<div class="banner-container">',
						'after' => '</div>',
						'class' => 'banner',
						'maxwidth' => BU_FLEXI_CONTENT_IMAGE_WIDTH,
						'position' => 'content-width'
						));
				} ?>
			<!--<div id="subscribe-container">
				<div id="subscribe-content"><a class="rss-link" href="<?php BU_News_Page_Template::get_rss_url() ?>" title="<?php bloginfo('name'); ?> RSS Feed"><span>RSS feed<span></a></div>
			</div>-->
			<div class="post" id="post-<?php the_ID(); ?>">
				<?php edit_post_link('Edit', '<p class="edit-link">', '</p>'); ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content(''); ?>
			</div>

		<?php $loop = BU_News_Page_Template::query_posts(); ?>
		<?php if($loop->have_posts()): ?>
			<div class="posts">
		<?php while($loop->have_posts()) : $loop->the_post(); ?>
				<div class="content-panel post<?php bu_flexi_comments_class($bu_display_content)?>" id="post-<?php the_ID(); ?>">
				<?php BU_News_Page_Template::show_thumbnail('<div class="thumb">', '</div>'); ?>
					<h2>
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					</h2>

					<?php
						$show_meta = bu_flexi_show_news_meta($bu_display_content);
						if($show_meta) {
							
							echo '<p class="meta">';
							BU_News_Page_Template::show_author('<span class="author"><em>By ', '</em></span><br>');
							BU_News_Page_Template::show_date( '<span class="date"><strong>', '</strong></span>');
							BU_News_Page_Template::show_categories( ' <span class="category">in ', '.</span>');

							echo '</p>';
							
							BU_News_Page_Template::show_comments(' <span class="comment-counter">', '</span>');
						}
						
						BU_News_Page_Template::show_content('', '', 'More');
						
						if ($show_meta) {
							echo '<p class="meta">';
							BU_News_Page_Template::show_tags(' <span class="tags">Tagged: <em>', '</em></span>');
							echo '</p>';
						}
					?>
				</div>

			<?php endwhile; ?>

				<p class="navigation"><span class="previous"><?php next_posts_link('Older', $loop->max_num_pages) ?></span> <span class="next"><?php previous_posts_link('Newer') ?></span></p>
			</div>
		<?php else : ?>

			<h1>No Posts Found</h1>
			<p>This site does not currently have any posts. Please check back later.</p>

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>
		
		
		<?php endwhile; ?>
		<?php else : ?>
			<h1>Not Found</h1>
			<p>Sorry, but you are looking for something that isn't here.</p>
		<?php endif; ?>
		<?php echo apply_filters( 'flexi_sharing', ''); ?>
		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>

<?php get_footer(); ?>


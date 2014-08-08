<?php
/*
 * Template Name: Profiles
 */
?>
<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
		<?php if (function_exists('bu_content_banner')) {
			echo(do_shortcode(bu_content_banner($post->ID, $args = array(
				'before' => '<div class="banner-container page-width">',
				'after' => '</div>',
				'class' => 'banner',
				//'maxwidth' => 900,
				'position' => 'page-width',
				'echo' => false
				))));
		} ?>
		
			
		<article role="main" class="col-md-8" id="post-<?php the_ID(); ?>">
			<?php if (function_exists('bu_content_banner')) {
				echo(do_shortcode(bu_content_banner($post->ID, $args = array(
					'before' => '<div class="banner-container content-width">',
					'after' => '</div>',
					'class' => 'banner',
					//'maxwidth' => 900,
					'position' => 'content-width',
					'echo' => false
					))));
			} ?>
			
			<h1><?php the_title(); ?></h1>
            		<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
			
			<?php if( defined('BU_PROFILES_PLUGIN_ACTIVE') && BU_PROFILES_PLUGIN_ACTIVE ): ?>
			<?php $format = bu_profile_get_format_for_post(); ?>
			<?php $query = bu_profile_get_query();?>
			<?php bu_profile_get_template_part( $format, $query ); ?>
			<?php endif; ?>
		
		</article>

		<?php responsive_comments(); ?>

		    <?php endwhile; endif; ?>
		    
		    <?php
	    	if(is_dynamic_sidebar("right-content-area")):
				?>
				<aside class="col-md-4" id="right-content-area">
					<?php dynamic_sidebar("right-content-area"); ?>
				</aside>
				<?php
	    	endif;	    	
	    ?>

<?php get_footer(); // will include footer-no-sidebar.php; ?>
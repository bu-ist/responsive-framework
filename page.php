<?php get_header(); ?>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
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
		
	        <?php if ( is_front_page() ) { ?>
	            <h1><?php the_title(); ?></h1>
	        <?php } else { ?>
	            <h1><?php the_title(); ?></h1>
	        <?php } ?>
	        <?php the_content(); ?>
	        
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:' ), 'after' => '</div>' ) ); ?>
	       
	        <?php edit_post_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
	        <?php comments_template( '', true ); ?>
	    
	        <?php endwhile; ?>
	    </article>
	    
	    <?php
	    	if(is_dynamic_sidebar("right-content-area")):
				?>
				<aside class="col-md-4" id="right-content-area">
					<?php dynamic_sidebar("right-content-area"); ?>
				</aside>
				<?php
	    	endif;	    	
	    ?>
	    
	</div>
<?php get_footer(); // will include footer-no-sidebar.php; ?>
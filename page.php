<?php get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		
	    <article role="main" class="primary-content" id="post-<?php the_ID(); ?>">
	    	<?php if (function_exists('bu_content_banner')) {
				bu_content_banner($post->ID, $args = array(
					'before' => '<div class="banner-container">',
					'after' => '</div>',
					'class' => 'banner',
					//'maxwidth' => 900,
					'position' => 'content-width'
					));
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
				<aside id="right-content-area">
					<?php dynamic_sidebar("right-content-area"); ?>
				</aside>
				<?php
	    	endif;
	    	
	    ?>
	</div>
<?php get_footer( 'no-sidebar' ); // will include footer-no-sidebar.php; ?>

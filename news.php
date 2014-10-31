<?php
/*
Template Name: News
*/
?>

<?php get_header(); ?>
		<div class="posts col-md-8" >
			<! -- news posts -->
		</div>

		<?php
if ( is_dynamic_sidebar( "right-content-area" ) ):
?>
				<aside class="col-md-4" id="right-content-area">
					<?php dynamic_sidebar( "right-content-area" ); ?>
				</aside>
				<?php
endif;
?>

<?php get_footer(); // will include footer-no-sidebar.php; ?>

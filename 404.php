<?php get_header(); ?>
<?php get_template_part('after-header'); ?>

<div class="container">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div<?php bu_flexi_main_id(); ?> class="main">
		<div class="container">
			<div class="content-panel post">
				<h1>Uh Oh, Page Not Found.</h1>
				<div class="message">
				<p><strong><?php
					$url = sprintf('%s://%s%s',
						$_SERVER['SERVER_PORT'] == 80 ? 'http' : 'https',
						$_SERVER['HTTP_HOST'],
						$_SERVER['REQUEST_URI']
					);
					echo (strlen($url) < 75) ? $url : substr($url, 0, 75) .'...';
				?></strong></p>
				</div>
				<p>Bad links happen to good people. Sorry about that. It's likely you clicked on an expired link. But just to be sure, try retyping the address. Some addresses are case sensitive, so type carefully. You can also use your back button, the navigation on this page, or the search field to get to where you want to go.</p>
			</div> <!-- /.post -->
		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>
<?php get_footer(); ?>
<?php
/**
 * Template file used to render a Server 404 error page
 */

get_header(); ?>

<section class="error-404 not-found">

	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Yikes! We couldn\'t find that.' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<p><?php _e( 'Looks like that page might not be here anymore. Want to give search a try?' ); ?></p>

		<?php responsive_search_form(); ?>

	</div><!-- .page-content -->
</section><!-- .error-404 -->

<?php get_footer();
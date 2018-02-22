<?php
/**
 * Template file used to render a Server 404 error page.
 *
 * @package Responsive_Framework
 */

get_header(); ?>

<div class="error-404 not-found content-area">

	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( "Yikes! We couldn't find that.", 'responsive-framework' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<p><?php esc_html_e( 'Looks like that page might not be here anymore. Want to give search a try?', 'responsive-framework' ); ?></p>

		<?php responsive_search_form(); ?>

	</div><!-- .page-content -->
</div><!-- .error-404 -->

<?php get_footer();

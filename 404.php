<?php
/**
 * Template file used to render a Server 404 error page
 */

get_header(); ?>

		<section class="error-404 not-found">

			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?' ); ?></p>

				<?php
				// TODO: Use search form once markup / styles support more than one.
				// responsive_search_form();
				?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

<?php get_footer(); ?>

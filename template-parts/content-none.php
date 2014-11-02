<?php
/**
 * Template partial used when no posts were found.
 */
?>

<article role="main">

	<h1><?php _e( 'Nothing Found' ); ?></h1>

	<?php if ( is_search() ) : ?>

		<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.' ); ?></p>
		<?php
		// TODO: Use search form once markup / styles support more than one.
		// responsive_search_form();
		?>

	<?php else : ?>

		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.' ); ?></p>
		<?php
		// TODO: Use search form once markup / styles support more than one.
		// responsive_search_form();
		?>

	<?php endif; ?>

</article>

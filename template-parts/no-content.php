<?php
/**
 * Template partial used when no posts were found.
 *
 * @package Responsive_Framework
 */

?>

<article role="article">

	<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'responsive-framework' ); ?></h1>

	<?php if ( is_search() ) : ?>

		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'responsive-framework' ); ?></p>
		<?php
		// TODO: Use search form once markup / styles support more than one.
		// responsive_search_form();.
		?>

	<?php else : ?>

		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'responsive-framework' ); ?></p>
		<?php
		// @TODO: Use search form once markup / styles support more than one.
		// responsive_search_form();.
		?>

	<?php endif; ?>

</article>

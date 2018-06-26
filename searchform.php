<?php
/**
 * Search form template used by `get_searchform()`.
 * Used for the WordPress default search form if BU Search is not available.
 *
 * @package Responsive_Framework
 */

?><form id="quicksearch" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<fieldset>
		<legend class="screen-reader-text"><span><?php esc_html_e( 'Search', 'responsive-framework' ); ?></span></legend>
		<label>
			<span class="screen-reader-text">Search for:</span>
			<input id="q" name="s" aria-label="<?php esc_attr_e( 'Search', 'responsive-framework' ); ?>" class="search-field" placeholder="<?php esc_attr_e( 'Search site&hellip;', 'responsive-framework' ); ?>" title="<?php esc_attr_e( 'Search for:', 'responsive-framework' ); ?>" type="text" value="<?php echo esc_attr( the_search_query() ); ?>">
		</label>
		<input type="submit" value="<?php esc_attr_e( 'Search', 'responsive-framework' ); ?>" name="do_search" class="button search-submit">
	</fieldset>
</form>

<?php
/**
 * Search form template used by `get_searchform()`.
 * Used for the WordPress default search form if BU Search is not available.
 *
 * @package Responsive_Framework
 */

?><form id="quicksearch" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<fieldset>
		<legend class="screen-reader-text"><span>Search</span></legend>
		<label>
			<span class="screen-reader-text">Search for:</span>
			<input id="q" name="s" aria-label="Search" class="search-field"  placeholder="Search site&hellip;" title="Search for:" type="text" value="<?php echo esc_attr( the_search_query() ); ?>">
		</label>
		<input type="submit" value="Search" name="do_search" class="button search-submit">
	</fieldset>
</form>

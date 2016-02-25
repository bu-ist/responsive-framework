<form id="quicksearch" action="<?php echo home_url( '/' ); ?>" method="get">
	<fieldset>
		<legend>Search</legend>
		<label for="q">Search in <?php echo home_url( '/' ); ?></label>
		<input id="q" type="text" name="s" class="search" aria-label="Search" title="Search" placeholder="Search site&hellip;" value="<?php the_search_query(); ?>" />
		<input type="submit" value="Search" name="do_search" class="button">
	</fieldset>
</form>

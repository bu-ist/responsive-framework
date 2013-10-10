<form role="search" id="quicksearch" action="<?php echo home_url( '/' ); ?>" method="get">
	<fieldset>
		<label class="screen-reader-text" for="s"><?php __('Search for:'); ?></label>
		<input id="q" type="text" alt="search text" name="s" value="<?php get_search_query(); ?>" />
		<input id="searchsubmit" class="button" type="submit" value="<?php esc_attr__('Search'); ?>" />
	</fieldset>
</form>
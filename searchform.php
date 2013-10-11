<form role="search" id="quicksearch" action="<?php echo home_url( '/' ); ?>" method="get">
	<fieldset>
		<label class="screen-reader-text" for="s"><?php __('Search for:'); ?></label>
		<input type="search" alt="Search" name="s" value="<?php get_search_query(); ?>" />
		<button type="submit" id="searchsubmit"  value="<?php esc_attr__('Search'); ?>" />
	</fieldset>
</form>
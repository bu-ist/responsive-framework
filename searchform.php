<form id="quicksearch" action="<?php echo home_url( '/' ); ?>" method="get">
    <fieldset>
        <label for="q">Search in <?php echo home_url( '/' ); ?></label>
        <input id="q" type="text" name="s" class="search" placeholder="Search Site..." value="<?php the_search_query(); ?>" />
        <input type="submit" value="Search" name="do_search" class="button">
    </fieldset>
</form>
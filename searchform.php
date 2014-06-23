<form class="quicksearch" action="/" method="get">
    <fieldset>
        <label for="search">Search in <?php echo home_url( '/' ); ?></label>
        <input type="text" name="s" class="search" placeholder="Search Site..." value="<?php the_search_query(); ?>" />
        <input type="submit" value="Search" name="do_search" class="button">
    </fieldset>
</form>
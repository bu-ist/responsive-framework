<?php
/**
 * Default filter bar partial.
 *
 * Used to render filter bars in archives.
 *
 * @package Responsive_Framework
 */

?>

<nav id="filter" class="filter-bar">
	<?php

	wp_list_categories( array(
			'taxonomy' => 'glossary-cat'
	) );

		$glossary_terms = get_categories( array(
			'taxonomy' => 'glossary-cat'
		) );

		//var_dump($glossary_terms);
	?>

	<div class="content-container filter-bar-content">
		<label class="search-field-label open-now-search">
			<span class="screen-reader-text"><?php esc_html_e( 'Search terms', 'responsive-framework' ); ?></span>
			<input id="js-opennow-search" class="js-fuzzy-search" placeholder="Search terms">
		</label>

		<button id="js-filter-control" class="filter-control filter-closed"><?php esc_html_e( 'Filter by group', 'responsive-framework' ); ?></button>

		<form id="js-filter-menu" class="filter-form">
			<div id="js-filter-dropdown" class="filter-dropdown filter-closed">

				<?php if ( $glossary_terms ) : ?>
				<fieldset id="js-filter-cuisine" class="filter-cuisine">
					<legend class="filter-title filter-cuisine-title"><?php esc_html_e( 'Filter', 'responsive-framework' ); ?></legend>
					<div class="column-wrap">
						<?php foreach ( $glossary_terms as $term ) : ?>
							<label class="filter-label filter-checkbox"><input type="checkbox" name="cuisine" value="<?php echo esc_attr( $term->slug ); ?>" /><?php echo esc_html( $term->name ); ?></label>
						<?php endforeach; ?>
					</div>
				</fieldset>
				<?php endif; ?>

			</div>

		</form>
	</div>
</nav>

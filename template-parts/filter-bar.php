<?php
/**
 * Default filter bar partial.
 *
 * Used to render filter bars in archives.
 *
 * @package Responsive_Framework
 */

// Enqueue List.js and Filter Bar javascript.
wp_enqueue_script( 'listjs' );
wp_enqueue_script( 'filter-bar' );

?>

<nav id="filter" class="filter-bar">
	<?php
		$glossary_terms = get_categories( array(
			'taxonomy' => 'glossary-cat'
		) );
	?>

	<div class="content-container filter-bar-content">
		<label class="search-field-label">
			<span class="screen-reader-text"><?php esc_html_e( 'Search terms', 'responsive-framework' ); ?></span>
			<input id="js-search" class="js-search" placeholder="Search terms">
		</label>

		<button id="js-filter-control" class="filter-control filter-closed"><?php esc_html_e( 'Filter by group', 'responsive-framework' ); ?></button>

		<form id="js-filter-menu" class="filter-form">
			<div id="js-filter-wrapper" class="filter-dropdown filter-closed">
				<?php if ( $glossary_terms ) : ?>
					<legend>
						<?php echo esc_html( get_taxonomy( 'glossary-cat' )->label ); ?>
					</legend>
					<?php foreach ( $glossary_terms as $parent_item ) : ?>
						<?php if ( 0 === $parent_item->parent ) : ?>
							<div id="js-filter-<?php echo esc_attr( $parent_item->slug ); ?>" class="filter-<?php echo esc_attr( $parent_item->slug ); ?>">
								<label class="filter-title filter-<?php echo esc_attr( $parent_item->slug ); ?>-title"><input type="checkbox" name="<?php echo esc_attr( $parent_item->slug ); ?>" value="<?php echo esc_attr( $parent_item->slug ); ?>" /><?php echo esc_html( $parent_item->name ); ?></label>

								<ul>
									<?php foreach ( $glossary_terms as $child_item ) : ?>
										<?php if ( $child_item->parent === $parent_item->term_id ) : ?>
											<li><label class="filter-label filter-checkbox"><input type="checkbox" name="<?php echo esc_attr( $child_item->slug ); ?>" value="<?php echo esc_attr( $child_item->slug ); ?>" /><?php echo esc_html( $child_item->name ); ?></label></li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

		</form>
	</div>
</nav>

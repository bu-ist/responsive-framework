<?php
/**
 * Add a filter dropdown to pages for filtering by page template.
 *
 * @package Responsive_Framework
 */

namespace BU\Responsive\Admin\Page_Template_Filters;

/**
 * Add query vars on the page edit screen for filtering by page template.
 *
 * @param array $query_vars Query vars.
 *
 * @return array Query vars.
 */
function query_vars( $query_vars ) {
	if ( ! is_admin() ) {
		return $query_vars;
	}

	$current_screen = get_current_screen();

	if ( empty( $current_screen ) ) {
		return $query_vars;
	}

	if ( 'edit' !== $current_screen->base ) {
		return $query_vars;
	}

	$query_vars[] = 'responsive_template_filter_top';
	$query_vars[] = 'responsive_template_filter_bottom';

	return $query_vars;
}
add_filter( 'query_vars', 'BU\Responsive\Admin\Page_Template_Filters\query_vars' );

/**
 * Display a dropdown menu for filtering by page template.
 *
 * @param string $post_type The post type slug.
 * @param string $which     The location of the extra table nav markup:
 *                          'top' or 'bottom' for WP_Posts_List_Table.
 */
function restrict_manage_posts( $post_type, $which ) {
	$post_types = array(
		'page',
	);

	/**
	 * Filters the post types to show a page template dropdown on.
	 *
	 * @param array $post_types Post types to display the filter on. Default is pages only.
	 */
	$post_types = apply_filters( 'responsive_show_page_template_dropdown', $post_types );

	if ( ! in_array( $post_type, $post_types, true ) ) {
		return;
	}

	$templates = get_page_templates();

	$selected_template = responsive_get_page_template_filter_value();

	if ( empty( $templates ) ) {
		return;
	}
	?>
	<select name="responsive_template_filter_<?php echo esc_attr( $which ); ?>">
		<option value="">All page templates</option>
		<option value="default" <?php selected( 'default', $selected_template ); ?>>Default</option>
		<?php foreach ( $templates as $name => $template ) : ?>
			<option value="<?php echo esc_attr( $template ); ?>" <?php selected( $template, $selected_template ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
}
add_action( 'restrict_manage_posts', 'BU\Responsive\Admin\Page_Template_Filters\restrict_manage_posts', 10, 2 );

/**
 * Filter posts by page template when one was selected in the WP_List_Table dropdown.
 *
 * @param \WP_Query $query The WP_Query instance (passed by reference).
 */
function pre_get_posts( $query ) {
	if ( ! is_admin() ) {
		return;
	}

	$template = responsive_get_page_template_filter_value();

	if ( empty( $template ) ) {
		return;
	}

	$meta_query = array(
		'key' => '_wp_page_template',
		'value' => $template,
	);

	$query->query_vars['meta_query'][] = $meta_query;
}
add_action( 'pre_get_posts', 'BU\Responsive\Admin\Page_Template_Filters\pre_get_posts' );

<?php
/**
 * Responsive Framework admin logic.
 *
 * @package Responsive_Framework
 */

$display_page_template = true;

/**
 * Filter whether to display the page template filter on the page admin.
 *
 * @param bool $display_page_template Whether to show the page template filter. Default is true.
 */
$display_page_template = apply_filters( 'responsive_show_page_template_filter', $display_page_template );

if ( $display_page_template ) {
	include_once 'responsive-admin-page-template-filter.php';
}

/**
 * Register footbar selection metabox.
 *
 * @param string $post_type Post type.
 */
function responsive_footbar_display_metabox( $post_type ) {
	if ( responsive_theme_supports_dynamic_footbars() && post_type_supports( $post_type, 'bu-dynamic-footbars' ) ) {
		add_meta_box(
			'bu-footbar',
			__( 'Footbar Display', 'responsive-framework' ),
			'responsive_footbar_display_metabox_form',
			$post_type,
			'side',
			'core'
		);
	}
}

add_action( 'add_meta_boxes', 'responsive_footbar_display_metabox', 10 );

/**
 * Display registered footbar areas.
 *
 * @param WP_Post $post Post object.
 */
function responsive_footbar_display_metabox_form( $post ) {
	$footbars = responsive_get_dynamic_footbars();
	$selected = responsive_get_footbar_id( $post->ID );
?>
<fieldset>
	<?php foreach ( $footbars as $id => $label ) : ?>
		<p><input type="radio" id="bu_footbar_<?php echo esc_attr( $id ); ?>" name="bu_footbar_id" value="<?php echo esc_attr( $id ); ?>" <?php checked( $id, $selected ); ?>/>
		<label for="bu_footbar_<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></p>
	<?php endforeach; ?>
	<p><input type="radio" id="bu_footbar_none" name="bu_footbar_id" value="none" <?php checked( 'none', $selected ); ?>/>
	<label for="bu_footbar_none"><?php esc_html_e( 'None', 'responsive-framework' ); ?></label></p>
</fieldset>

<?php
}

/**
 * Save footbar selection for the given post.
 *
 * @param int $post_id Post ID.
 */
function responsive_save_post_footbar( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset( $_POST['bu_footbar_id'] ) ) {
		$footbar_id = $_POST['bu_footbar_id'];
		$available_footbars = responsive_get_dynamic_footbars();

		if ( 'none' === $footbar_id || array_key_exists( $footbar_id, $available_footbars ) ) {
			update_post_meta( $post_id, '_bu_footbar_id', $footbar_id );
		}
	}
}
add_action( 'save_post', 'responsive_save_post_footbar', 10 );

/**
 * Get the page template query var value.
 *
 * @return bool|string false if empty or not set,
 *                     selected page template if it is.
 */
function responsive_get_page_template_filter_value() {
	$top_arg = get_query_var( 'responsive_template_filter_top' );
	$bottom_arg = get_query_var( 'responsive_template_filter_bottom' );

	if ( empty( $top_arg ) && empty( $bottom_arg ) ) {
		return false;
	}

	if ( ! empty( $top_arg ) ) {
		$page_template = $top_arg;
	} elseif ( ! empty( $bottom_arg ) ) {
		$page_template = $bottom_arg;
	} else {
		return false;
	}

	if ( empty( $page_template ) ) {
		return false;
	}

	return sanitize_text_field( $page_template );
}

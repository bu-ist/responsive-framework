<?php
/**
 * Responsive Framework admin logic.
 *
 * @package Responsive_Framework
 */

/**
 * Register footbar selection metabox.
 *
 * @param string  $post_type Post type.
 * @param WP_Post $post      Post object.
 */
function responsive_footbar_display_metabox( $post_type, $post ) {
	if ( responsive_theme_supports_dynamic_footbars() && post_type_supports( $post_type, 'bu-dynamic-footbars') ) {
		add_meta_box(
			'bu-footbar',
			'Footbar Display',
			'responsive_footbar_display_metabox_form',
			$post_type,
			'side',
			'core'
			);
	}
}

add_action( 'add_meta_boxes', 'responsive_footbar_display_metabox', 10, 2 );

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
	<?php foreach ( $footbars as $id => $label ): ?>
		<p><input type="radio" id="bu_footbar_<?php echo esc_attr( $id ); ?>" name="bu_footbar_id" value="<?php echo esc_attr( $id ); ?>" <?php checked( $id, $selected ); ?>/>
		<label for="bu_footbar_<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></p>
	<?php endforeach; ?>
	<p><input type="radio" id="bu_footbar_none" name="bu_footbar_id" value="none" <?php checked( 'none', $selected ); ?>/>
	<label for="bu_footbar_none">None</label></p>
</fieldset>

<?php
}

/**
 * Save footbar selection for the given post.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function responsive_save_post_footbar( $post_id, $post ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset( $_POST['bu_footbar_id'] ) ) {
		$footbar_id = $_POST['bu_footbar_id'];
		$available_footbars = responsive_get_dynamic_footbars();

		if ( $footbar_id == 'none' || array_key_exists( $footbar_id, $available_footbars ) ) {
			update_post_meta( $post_id, '_bu_footbar_id', $footbar_id );
		}
	}
}

add_action( 'save_post', 'responsive_save_post_footbar', 10, 2 );

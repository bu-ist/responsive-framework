<?php
/**
 * Single event partial for the calendar template.
 *
 * @package Responsive_Framework
 */

/**
 * Retrieves all event fields (standard and custom).
 *
 * Structure of this array follows like this:
 * [
 *     {fieldname} => [
 *         'label' => {fieldlabel}
 *         'value' => {fieldvalue}
 *     ],
 *     'contactOrganization' => [
 *         'label' => 'Contact Organization
 *         'value' => 'Boston University'
 *     ],
 *     [{...}],
 * ]
 */
$fields = responsive_calendar_get_fields();

// Bails immediately if fields returns an empty array.
if ( empty( $fields ) ) {
	return;
}

?>
<div class="single-event-additional-details">
	<dl class="tabular">
		<?php foreach ( $fields as $fieldname => $field ) : ?>
			<?php if ( ! empty( $field['value'] ) ) : ?>
				<dt class="single-event-label single-event-label-<?php echo sanitize_html_class( strtolower( $fieldname ) ); ?>">
					<?php echo esc_html( $field['label'] ); ?>
				</dt>
				<dd class="single-event-value single-event-value-<?php echo sanitize_html_class( strtolower( $fieldname ) ); ?>">
					<?php echo wp_kses_post( $field['value'] ); ?>
				</dd>
			<?php endif; ?>
		<?php endforeach; ?>
	</dl>
</div> <!-- /.additionalDetails -->

<?php
/**
 * Single event partial for the calendar template.
 *
 * @package Responsive_Framework
 */

global $buCalendar;

$labels = apply_filters( 'responsive_calendar_event_labels', array(
	'address'              => __( 'Address', 'responsive-framework' ) . ':',
	'audience'             => __( 'Audience', 'responsive-framework' ) . ':',
	'back_to_calendar'     => __( 'Back to Calendar', 'responsive-framework' ),
	'contact_email'        => __( 'Contact Email', 'responsive-framework' ) . ':',
	'contact_name'         => __( 'Contact Name', 'responsive-framework' ) . ':',
	'contact_organization' => __( 'Contact Organization', 'responsive-framework' ) . ':',
	'contact_phone'        => __( 'Contact Phone', 'responsive-framework' ) . ':',
	'deadline'             => __( 'Deadline', 'responsive-framework' ) . ':',
	'departments'          => __( 'Departments', 'responsive-framework' ) . ':',
	'ends'                 => __( 'Ends', 'responsive-framework' ) . ':',
	'fee'                  => __( 'Fees', 'responsive-framework' ) . ':',
	'fee_general'          => __( 'Fee (General)', 'responsive-framework' ) . ':',
	'fee_public'           => __( 'Fee (Public)', 'responsive-framework' ) . ':',
	'fee_senior'           => __( 'Fee (Seniors)', 'responsive-framework' ) . ':',
	'fee_staff'            => __( 'Fee (Staff)', 'responsive-framework' ) . ':',
	'fee_student'          => __( 'Fee (Students)', 'responsive-framework' ) . ':',
	'fee_student_bu'       => __( 'Fee (BU Students)', 'responsive-framework' ) . ':',
	'fees'                 => __( 'Fees', 'responsive-framework' ) . ':',
	'location'             => __( 'Location', 'responsive-framework' ) . ':',
	'registration'         => __( 'Registration', 'responsive-framework' ) . ':',
	'room'                 => __( 'Room', 'responsive-framework' ) . ':',
	'speakers'             => __( 'Speakers', 'responsive-framework' ) . ':',
	'starts'               => __( 'Starts', 'responsive-framework' ) . ':',
) );

// Retrieve single-event parameters.
$calendar_id = responsive_calendar_get_calendar_id();
$event_id    = responsive_calendar_get_event_id();
$oid         = responsive_calendar_get_oid();

// Retrieve the event by these IDs.
$event = $buCalendar->getEvent( $calendar_id, $event_id, $oid );
?>
<div class="single-event">
	<div class="single-event-summary">
		<h1><?php echo wp_kses_post( $event['summary'] ); ?></h1>
		<div class="single-event-schedule">
			<ul class="single-event-schedule-list">
				<?php if ( ! empty( $event['start_time'] ) && ! empty( $labels['starts'] ) ) : ?>
					<li class="single-event-schedule-start">
						<span class="single-event-label"><?php echo esc_html( $labels['starts'] ); ?> </span>
						<?php printf( '<span class="single-event-time">%s</span><em class="event-time-make-sentence"> on </em><span class="single-event-date">%s</span>', esc_html( date( 'g:i a', $event['starts'] ) ), esc_html( date( 'l, F j, Y', $event['starts'] ) ) ); ?>
					</li>
					<?php if ( ( $event['ends'] > 0 ) && ! empty( $labels['ends'] ) ) : ?>
						<li class="single-event-schedule-end">
							<span class="single-event-label"><?php echo esc_html( $labels['ends'] ); ?> </span>
							<?php printf( '<span class="single-event-time">%s</span><em class="event-time-make-sentence"> on </em><span class="single-event-date">%s</span>', esc_html( date( 'g:i a', $event['ends'] ) ), esc_html( date( 'l, F j, Y', $event['ends'] ) ) ); ?>
						</li>
					<?php endif; ?>
				<?php else : ?>
					<?php printf( '<li class="single-event-schedule-allday"><span class="single-event-label">All Day</span><em> on </em><span class="single-event-date">%s</span></li>', esc_html( date( 'l, F j, Y', $event['starts'] - intval( date( 'Z' ) ) ) ) ); ?>
				<?php endif; ?>
			</ul>
		</div> <!-- /.single-event-schedule -->
	</div> <!-- /.eventSummary -->

	<div class="single-event-description">
		<?php echo wp_kses_post( html_entity_decode( $event['description'] ) ); ?>
	</div>

	<div class="single-event-additional-details">
		<dl class="tabular">
			<?php if ( $event['speakers'] && ! empty( $labels['speakers'] ) ) : ?>
				<dt class="single-event-speakers-label"><?php echo esc_html( $labels['speakers'] ); ?></dt>
				<dd class="single-event-speakers-info"><?php echo wp_kses_post( $event['speakers'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['audience'] && ! empty( $labels['audience'] ) ) : ?>
				<dt class="single-event-audience-label"><?php echo esc_html( $labels['audience'] ); ?></dt>
				<dd class="single-event-audience-info"><?php echo wp_kses_post( $event['audience'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['departments'] && ! empty( $labels['departments'] ) ) : ?>
				<dt class="single-event-departments-label"><?php echo esc_html( $labels['departments'] ); ?></dt>
				<dd class="single-event-departments-info"><?php echo wp_kses_post( $event['departments'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['location'] && ! empty( $labels['location'] ) ) : ?>
				<dt class="single-event-location-label"><?php echo esc_html( $labels['location'] ); ?></dt>
				<dd class="single-event-location-info"><?php echo wp_kses_post( $event['location'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['locationBuilding'] && ! empty( $labels['address'] ) ) : ?>
				<dt class="single-event-location-building-label"><?php echo esc_html( $labels['address'] ); ?></dt>
				<dd class="single-event-location-building-info"><?php echo wp_kses_post( $event['locationBuilding'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['locationRoom'] && ! empty( $labels['room'] ) ) : ?>
				<dt class="single-event-location-room-label"><?php echo esc_html( $labels['room'] ); ?></dt>
				<dd class="single-event-location-room-info"><?php echo wp_kses_post( $event['locationRoom'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['fees'] && ! empty( $labels['fees'] ) ) : ?>
				<dt class="single-event-fees-label"><?php echo esc_html( $labels['fees'] ); ?></dt>
				<dd class="single-event-fees-info"><?php echo wp_kses_post( $event['fees'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['fee'] && ! empty( $labels['fee'] ) ) : ?>
				<dt class="single-event-fee-label"><?php echo esc_html( $labels['fee'] ); ?></dt>
				<dd class="single-event-fee-info"><?php echo wp_kses_post( $event['fee'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['feeGeneral'] && ! empty( $labels['fee_general'] ) ) : ?>
				<dt class="single-event-fee-general-label"><?php echo esc_html( $labels['fee_general'] ); ?></dt>
				<dd class="single-event-fee-general-info"><?php echo wp_kses_post( $event['feeGeneral'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['feePublic'] && ! empty( $labels['fee_public'] ) ) : ?>
				<dt class="single-event-fee-public-label"><?php echo esc_html( $labels['fee_public'] ); ?></dt>
				<dd class="single-event-fee-public-info"><?php echo wp_kses_post( $event['feePublic'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['feeStaff'] && ! empty( $labels['fee_staff'] ) ) : ?>
				<dt class="single-event-fee-staff-label"><?php echo esc_html( $labels['fee_staff'] ); ?></dt>
				<dd class="single-event-fee-staff-info"><?php echo wp_kses_post( $event['feeStaff'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['feeStudent'] && ! empty( $labels['fee_student'] ) ) : ?>
				<dt class="single-event-fee-student-label"><?php echo esc_html( $labels['fee_student'] ); ?></dt>
				<dd class="single-event-fee-student-info"><?php echo wp_kses_post( $event['feeStudent'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['feeBUStudent'] && ! empty( $labels['fee_student_bu'] ) ) : ?>
				<dt class="single-event-fee-bu-student-label"><?php echo esc_html( $labels['fee_student_bu'] ); ?></dt>
				<dd class="single-event-fee-bu-student-info"><?php echo wp_kses_post( $event['feeBUStudent'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['feeSenior'] && ! empty( $labels['fee_senior'] ) ) : ?>
				<dt class="single-event-fee-senior-label"><?php echo esc_html( $labels['fee_senior'] ); ?></dt>
				<dd class="single-event-fee-senior-info"><?php echo wp_kses_post( $event['feeSenior'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['deadline'] && ! empty( $labels['deadline'] ) ) : ?>
				<dt class="single-event-deadline-label"><?php echo esc_html( $labels['deadline'] ); ?></dt>
				<dd class="single-event-deadline-info"><?php echo wp_kses_post( $event['deadline'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['url'] && ! empty( $labels['registration'] ) ) : ?>
				<?php $url_text = $event['urlText'] ? $event['urlText'] : $event['url']; ?>
				<dt class="single-event-registration-label"><?php echo esc_html( $labels['registration'] ); ?></dt>
				<dd class="single-event-registration-info"><?php printf( '<a href="%s" class="single-event-registration-link">%s</a>', esc_url( $event['url'] ), esc_html( $url_text ) ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['contactOrganization'] && ! empty( $labels['contact_organization'] ) ) : ?>
				<dt class="single-event-contact-org-label"><?php echo esc_html( $labels['contact_organization'] ); ?></dt>
				<dd class="single-event-contact-org-info"><?php echo wp_kses_post( $event['contactOrganization'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['contact_name'] && ! empty( $labels['contact_name'] ) ) : ?>
				<dt class="single-event-contact-name-label"><?php echo esc_html( $labels['contact_name'] ); ?></dt>
				<dd class="single-event-contact-name-info"><?php echo wp_kses_post( $event['contact_name'] ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['contact_email'] && ! empty( $labels['contact_email'] ) ) : ?>
				<dt class="single-event-contact-email-label"><?php echo esc_html( $labels['contact_email'] ); ?></dt>
				<dd class="single-event-contact-email-info"><?php printf( '<a href="mailto:%s" class="single-event-contact-email-link">%s</a>', esc_url( $event['contact_email'] ), esc_html( $event['contact_email'] ) ); ?></dd>
			<?php endif; ?>
			<?php if ( $event['phone'] && ! empty( $labels['contact_phone'] ) ) : ?>
				<dt class="single-event-contact-phone-label"><?php echo esc_html( $labels['contact_phone'] ); ?></dt>
				<dd class="single-event-contact-phone-info"><?php echo wp_kses_post( $event['phone'] ); ?></dd>
			<?php endif; ?>

		</dl>
	</div> <!-- /.additionalDetails -->

	<?php if ( ! empty( $labels['back_to_calendar'] ) ) : ?>
		<p class="archive-link-container"><a href="<?php the_permalink(); ?>" class="archive-link calendar-archive-link"><?php echo esc_html( $labels['back_to_calendar'] ); ?></a></p>
	<?php endif; ?>

</div><!-- /.single-event -->
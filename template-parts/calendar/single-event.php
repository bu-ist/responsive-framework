<?php
/**
 * Single event partial for the calendar template.
 *
 * @package Responsive_Framework
 */

global $buCalendar;

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
				<?php if ( ! empty( $event['start_time'] ) ) : ?>
					<li class="single-event-schedule-start">
						<span class="single-event-label">Starts: </span><?php printf( '<span class="single-event-time">%s</span><em class="event-time-make-sentence"> on </em><span class="single-event-date">%s</span>', esc_html( date( 'g:i a', $event['starts'] ) ), esc_html( date( 'l, F j, Y', $event['starts'] ) ) ); ?>
					</li>
					<?php if ( $event['ends'] > 0 ) : ?>
						<li class="single-event-schedule-end"><span class="single-event-label">Ends: </span><?php printf( '<span class="single-event-time">%s</span><em class="event-time-make-sentence"> on </em><span class="single-event-date">%s</span>', esc_html( date( 'g:i a', $event['ends'] ) ), esc_html( date( 'l, F j, Y', $event['ends'] ) ) ); ?></dd>
					<?php endif; ?>
				<?php else : ?>
					<?php printf( '<li class="single-event-schedule-allday"><span class="single-event-label">All Day</span><em> on </em><span class="single-event-date">%s</span></li>', esc_html( date( 'l, F j, Y', $event['starts'] - intval( date( 'Z' ) ) ) ) ); ?>
				<?php endif; ?>
			</ul>
		</div> <!-- /.dateSummary -->
		<div class="single-event-description"><?php echo wp_kses_post( html_entity_decode( $event['description'] ) ); ?></div>
	</div> <!-- /.eventSummary -->

	<div class="single-event-additional-details">
		<dl class="tabular">
			<?php if ( $event['speakers'] ) { ?>
				<dt class="single-event-speakers-label">Speakers:</dt>
				<dd class="single-event-speakers-info"><?php echo wp_kses_post( $event['speakers'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['audience'] ) { ?>
				<dt class="single-event-audience-label">Audience:</dt>
				<dd class="single-event-audience-info"><?php echo wp_kses_post( $event['audience'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['departments'] ) { ?>
				<dt class="single-event-departments-label">Departments:</dt>
				<dd class="single-event-departments-info"><?php echo wp_kses_post( $event['departments'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['location'] ) { ?>
				<dt class="single-event-location-label">Location:</dt>
				<dd class="single-event-location-info"><?php echo wp_kses_post( $event['location'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['locationBuilding'] ) { ?>
				<dt class="single-event-location-building-label">Address:</dt>
				<dd class="single-event-location-building-info"><?php echo wp_kses_post( $event['locationBuilding'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['locationRoom'] ) { ?>
				<dt class="single-event-location-room-label">Room:</dt>
				<dd class="single-event-location-room-info"><?php echo wp_kses_post( $event['locationRoom'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['fees'] ) { ?>
				<dt class="single-event-fees-label">Fees:</dt>
				<dd class="single-event-fees-info"><?php echo wp_kses_post( $event['fees'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['fee'] ) { ?>
				<dt class="single-event-fee-label">Fees:</dt>
				<dd class="single-event-fee-info"><?php echo wp_kses_post( $event['fee'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['feeGeneral'] ) { ?>
				<dt class="single-event-fee-general-label">Fee (General):</dt>
				<dd class="single-event-fee-general-info"><?php echo wp_kses_post( $event['feeGeneral'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['feePublic'] ) { ?>
				<dt class="single-event-fee-public-label">Fee (Public):</dt>
				<dd class="single-event-fee-public-info"><?php echo wp_kses_post( $event['feePublic'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['feeStaff'] ) { ?>
				<dt class="single-event-fee-staff-label">Fee (Staff):</dt>
				<dd class="single-event-fee-staff-info"><?php echo wp_kses_post( $event['feeStaff'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['feeStudent'] ) { ?>
				<dt class="single-event-fee-student-label">Fee (Students):</dt>
				<dd class="single-event-fee-student-info"><?php echo wp_kses_post( $event['feeStudent'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['feeBUStudent'] ) { ?>
				<dt class="single-event-fee-bu-student-label">Fee (BU Students):</dt>
				<dd class="single-event-fee-bu-student-info"><?php echo wp_kses_post( $event['feeBUStudent'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['feeSenior'] ) { ?>
				<dt class="single-event-fee-senior-label">Fee (Seniors):</dt>
				<dd class="single-event-fee-senior-info"><?php echo wp_kses_post( $event['feeSenior'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['deadline'] ) { ?>
				<dt class="single-event-deadline-label">Deadline:</dt>
				<dd class="single-event-deadline-info"><?php echo wp_kses_post( $event['deadline'] ); ?></dd>
			<?php } ?>
			<?php
			if ( $event['url'] ) {
				$url_text = $event['url'];
				if ( $event['urlText'] ) {
					$url_text = $event['urlText'];
				}
				?>
					<dt class="single-event-registration-label">Registration:</dt>
					<dd class="single-event-registration-info"><?php printf( '<a href="%s" class="single-event-registration-link">%s</a>', esc_url( $event['url'] ), esc_html( $url_text ) ); ?></dd>
				<?php
			}
			?>
			<?php if ( $event['contactOrganization'] ) { ?>
				<dt class="single-event-contact-org-label">Contact Organization:</dt>
				<dd class="single-event-contact-org-info"><?php echo wp_kses_post( $event['contactOrganization'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['contact_name'] ) { ?>
				<dt class="single-event-contact-name-label">Contact Name:</dt>
				<dd class="single-event-contact-name-info"><?php echo wp_kses_post( $event['contact_name'] ); ?></dd>
			<?php } ?>
			<?php if ( $event['contact_email'] ) { ?>
				<dt class="single-event-contact-email-label">Contact Email:</dt>
				<dd class="single-event-contact-email-info"><?php printf( '<a href="mailto:%s" class="single-event-contact-email-link">%s</a>', esc_url( $event['contact_email'] ), esc_html( $event['contact_email'] ) ); ?></dd>
			<?php } ?>
			<?php if ( $event['phone'] ) { ?>
				<dt class="single-event-contact-phone-label">Contact Phone:</dt>
				<dd class="single-event-contact-phone-info"><?php echo wp_kses_post( $event['phone'] ); ?></dd>
			<?php } ?>

		</dl>
	</div> <!-- /.additionalDetails -->

	<p class="archive-link-container"><a href="<?php the_permalink(); ?>" class="archive-link calendar-archive-link">Back to Calendar</a></p>

</div><!-- /.single-event -->

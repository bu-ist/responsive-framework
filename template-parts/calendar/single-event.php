<?php
/**
 * Single event partial for the calendar template.
 *
 * @package Responsive_Framework
 */

global $buCalendar;

// Retrieve single-event labels used for templating.
$labels = responsive_calendar_event_labels();

// Retrieve the queried event.
$event = responsive_calendar_get_event();
?>
<div class="single-event">
	<div class="single-event-summary">
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

	<?php get_template_part( 'template-parts/calendar/single-event-fields' ); ?>

	<?php if ( ! empty( $labels['back_to_calendar'] ) ) : ?>
		<p class="archive-link-container"><a href="<?php the_permalink(); ?>" class="archive-link calendar-archive-link">
			<?php echo esc_html( $labels['back_to_calendar'] ); ?></a>
		</p>
	<?php endif; ?>

</div><!-- /.single-event -->

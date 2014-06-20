<?php
/*
Template Name: Calendar
*/

// calendar setup
function onYearDay($ts){
	global $buCalendar, $events;

	$contents = null;
	$day = date('Y-m-d', $ts);
	$contents = null;

	if ($buCalendar->hasEventsOnDay($day, $events)){
		$contents = ' ';
	}

	return $contents;
}

$calendarID = array_key_exists('cid', $_GET) ? intval($_GET['cid']) : get_option('bu_calendar_id');

$calendarURI = get_permalink($post);

$topics = NULL;
$topicDetail = NULL;
$event = NULL;

/* input */
$yyyymmdd = array_key_exists('date', $_GET) ? $_GET['date'] : NULL;

$topic = NULL;
if (array_key_exists('topic', $_GET)) {
	$topic = intval($_GET['topic']);
}
$topic = apply_filters('bu_flexi_calendar_topic', $topic);

$eventID = array_key_exists('eid', $_GET) ? intval($_GET['eid']) : NULL;

$topics = $buCalendar->getTopics($calendarID);
$topicDetail = ($topic) ? $buCalendar->pullTopicDetail($topic, $topics) : array('name' => 'All Topics');

if (!is_null($eventID)){
	$oid = array_key_exists('oid', $_GET) ? intval($_GET['oid']) : 0;
	$event = $buCalendar->getEvent($calendarID, $eventID, $oid);
	$yyyymmdd = date('Ymd', $event['starts']);
}

$timestamp = time();
$now = $timestamp;
 
if ($yyyymmdd) $timestamp = strtotime($yyyymmdd, 0);

$timestamp = strtotime('00:00', $timestamp);

/* check that date falls between:
 * The year 2000 (http://www.nbc.com/nbc/Late_Night_with_Conan_OBrien/intheyear2000/)
 * Ten years in the future from the current date
 */

$boundary_past = strtotime('2000-01-01 00:00:00', 0);
$boundary_future = strtotime('+10 years', $now);

if ($timestamp < $boundary_past) {
	$timestamp = $boundary_past;
	$yyyymmdd = date('Ymd', $timestamp);
}

if ($timestamp > $boundary_future) {
	$timestamp = $boundary_future;
	$yyyymmdd = date('Ymd', $timestamp);
}



// Remove default sharedaddy display location
remove_filter('the_content', 'sharing_display', 19);

?>
<?php get_header(); ?>


<article role="main" class="col-md-8" id="post-<?php the_ID(); ?>">
	<div class="container">
		<?php if (function_exists('bu_content_banner')) {
			bu_content_banner($post->ID, $args = array(
				'before' => '<div class="banner-container">',
				'after' => '</div>',
				'class' => 'banner',
				'position' => 'content-width'

				));
		} ?>
	
		<?php if (is_null($eventID)) { ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php endwhile; endif; ?>



		<?php if (!$calendarID) { ?>
			<p>This site does not have any calendar associated with it.</p>
		<?php } else { 
			if (array_key_exists('date', $_GET)) $timestamp = strtotime($_GET['date'], 0);

			$start_date = strtotime('00:00', $timestamp);
			$start_date = date('Y-m-d', $start_date);

			$months_to_show = 2;  //additional months to show

			$days = (intval(date('t', $timestamp)) - intval(date('j', $timestamp)));  //days left in current month

			$cur_mo = intval(date('n', $timestamp));
			for($mo = 1; $mo <= $months_to_show; $mo++) {
					$days = $days + intval(date('t', mktime(0, 0, 0, date('n', $timestamp)+$mo, 1)));  //let the month overflow for month&year
			}

			$params = array('maxevents'=>25);
			$events = $buCalendar->getEvents($calendarID, $start_date, $days, $topic, $params);

			$last_event = $events[(count($events)-1)]['starts'];  //timestamp for the last event retrieved

			$range_end = strtotime('+' . $days . ' day', $timestamp);

			if(count($events) < 25) {
				$query_end = $range_end;
			} else {
				$query_end = $last_event;
			}
			
			
			/* Content: Calendar Topic */
			if (is_array($topicDetail)) { ?>
				<h2 class="calendar-topic">
					<?php echo $topicDetail['name']; ?><span class="calendar-range">
						(<?php echo date('F j', $timestamp); ?> through <?php echo date('F j', $query_end); ?>)
					</span>
				</h2>
			<?php }	?>
				<div class="event-list">
					<div id="events">
						<?php
						$day = NULL;
						$time = NULL;
						$allday = FALSE;
						$nDisplayed = 0;
				
						if ((is_array($events)) && (count($events) > 0)){
							foreach ($events as $e){
								
								$_day = date('l, F j', $e['starts']);
								$_time = date('g:i A', $e['starts']);
								$_allday = $e['allday'];
								$event_time = '';
								if ($_day != $day){
									if($nDisplayed != 0) {
		                                echo '</ul>' . PHP_EOL;
									}
		                            printf('<h3 class="event-date">%s</h3>', $_day);
		                            echo PHP_EOL . '<ul>' . PHP_EOL;
									$day = $_day;
									$time = NULL;
								}
								//echo var_dump($e);
								if ($_allday) {
									if($_allday != $allday) {
										$event_time = 'All Day';
									}
								} else {
									if ($_time != $time){
										$event_time = $_time;
										$time = $_time;
									} else {
										$event_time = '&nbsp;';
									}
								}
								
								$event_url = $calendarURI;
								$event_url = add_query_arg('eid', $e['id'], $event_url);
								if(!empty($e['oid'])) $event_url = add_query_arg('oid', $e['oid'], $event_url);
								if(!empty($_GET['cid'])) $event_url = add_query_arg('cid', intval($_GET['cid']), $event_url);
							    echo "\t";	
								printf('<li><span class="event-time">%s</span> ', $event_time);
								
		                        printf('<span class="event-link"><a href="%s">%s</a></span></li>',  $event_url, $e['summary']);
		                        echo PHP_EOL;
		                        
								$nDisplayed++;
								/* not sure how to close a day with multiple events...  */
		                    
								if(count($events)== $nDisplayed) {
									echo '</ul>' . PHP_EOL;
								}
							}
						}

						if ($nDisplayed === 0){
							printf('<div id="noevents"><p>There are no events in <strong>%s</strong> during the specified time period.</p></div>', $topicDetail['name']);
						}
						?>
					</div>
				</div>
			<?php } ?>
	<?php } else { ?>
			<h1><?php echo $event['summary'];?></h1>
			<div class="eventDetail">
				<div class="description"><?php print(html_entity_decode($event['description'])); ?></div>
				<dl class="tabular">
					<?php if ($event['start_time'] != '') { ?>
						<dt>Starts:</dt>
						<dd><?php printf('%s on %s', date('g:i a', $event['starts']), date('l, F j, Y', $event['starts'])); ?></dd>
						<?php if ($event['ends'] > 0) { ?>
							<dt>Ends:</dt>
							<dd><?php printf('%s on %s', date('g:i a', $event['ends']), date('l, F j, Y', $event['ends'])); ?></dd>
						<?php } 
					} else {
						printf('<dt class="allday">All Day</dt><dd>on %s</dd>', date('l, F j, Y', $event['starts'] - intval(date('Z'))));	
					}	
					?>
					
					<?php if ($event['speakers']) { ?>
						<dt>Speakers:</dt>
						<dd><?php print($event['speakers']); ?></dd>
					<?php } ?>
					<?php if ($event['audience']) { ?>
						<dt>Audience:</dt>
						<dd><?php print($event['audience']); ?></dd>
					<?php } ?>
					<?php if ($event['departments']) { ?>
						<dt>Departments:</dt>
						<dd><?php print($event['departments']); ?></dd>
					<?php } ?>
					
					
					<?php if ($event['location']) { ?>
						<dt>Location:</dt>
						<dd><?php print($event['location']); ?></dd>
					<?php } ?>
					<?php if ($event['locationBuilding']) { ?>
						<dt>Address:</dt>
						<dd><?php print($event['locationBuilding']); ?></dd>
					<?php } ?>
					<?php if ($event['locationRoom']) { ?>
						<dt>Room:</dt>
						<dd><?php print($event['locationRoom']); ?></dd>
					<?php } ?>
					
					<?php if ($event['fees']) { ?>
						<dt>Fees:</dt>
						<dd><?php print($event['fees']); ?></dd>						
					<?php } ?>
					<?php if ($event['fee']) { ?>
						<dt>Fees:</dt>
						<dd><?php print($event['fee']); ?></dd>
					<?php } ?>
					<?php if ($event['feeGeneral']) { ?>
						<dt>Fee (General):</dt>
						<dd><?php print($event['feeGeneral']); ?></dd>
					<?php } ?>
					<?php if ($event['feePublic']) { ?>
						<dt>Fee (Public):</dt>
						<dd><?php print($event['feePublic']); ?></dd>
					<?php } ?>
					<?php if ($event['feeStaff']) { ?>
						<dt>Fee (Staff):</dt>
						<dd><?php print($event['feeStaff']); ?></dd>
					<?php } ?>
					<?php if ($event['feeStudent']) { ?>
						<dt>Fee (Students):</dt>
						<dd><?php print($event['feeStudent']); ?></dd>
					<?php } ?>
					<?php if ($event['feeBUStudent']) { ?>
						<dt>Fee (BU Students):</dt>
						<dd><?php print($event['feeBUStudent']); ?></dd>
					<?php } ?>
					<?php if ($event['feeSenior']) { ?>
						<dt>Fee (Seniors):</dt>
						<dd><?php print($event['feeSenior']); ?></dd>
					<?php } ?>
					<?php if ($event['deadline']) { ?>
						<dt>Deadline:</dt>
						<dd><?php print($event['deadline']); ?></dd>
					<?php } ?>
					<?php if ($event['url']) { 
						$urlText = $event['url'];
						if($event['urlText']){
							$urlText = $event['urlText'];
						}
						
					?>
					
						<dt>Registration:</dt>
						<dd><?php printf('<a href="%s">%s</a>', $event['url'], $urlText); ?></dd>
					<?php } ?>
					
					
					
					
					
					<?php if ($event['contactOrganization']) { ?>
						<dt>Contact Organization:</dt>
						<dd><?php print($event['contactOrganization']); ?></dd>
					<?php } ?>
					<?php if ($event['contact_name']) { ?>
						<dt>Contact Name:</dt>
						<dd><?php print($event['contact_name']); ?></dd>
					<?php } ?>
					<?php if ($event['contact_email']) { ?>
						<dt>Contact Email:</dt>
						<dd><?php printf('<a href="mailto:%s">%s</a>', $event['contact_email'], $event['contact_email']); ?></dd>
					<?php } ?>
					<?php if ($event['phone']) { ?>
						<dt>Contact Phone:</dt>
						<dd><?php print($event['phone']); ?></dd>
					<?php } ?>
					
				</dl><!-- /.eventDetail -->
				
			</div>
		<?php } ?>
	</div><!--/.container -->
</article>


<aside class="col-md-4" id="right-content-area">
	<?php
		bu_flexi_calendar_sidebar(); 
		if(is_dynamic_sidebar("right-content-area")){
			dynamic_sidebar("right-content-area"); 
		}
	?>
</aside>

</div>



<?php get_footer(); ?>






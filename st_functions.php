<?php

/*Importing functions from bu gf customizations */
/********************************************************/

function counselRecHandler($entry, $form){
    /*all we're doing righ now is marking is at received*/

	if($_POST["input_57"]!==""){
		//get the actual entry we want to edit
	    $editentry = GFAPI::get_entry($_POST["input_57"]);

	    if ( is_wp_error( $editentry ) ) {
	      echo "Error.";
	      die();
	    }

	   $editentry[127]='true';
      $updateit = GFAPI::update_entry($editentry);
	}

}

add_action("gform_after_submission_117", "counselRecHandler", 10, 2 );


/********************************************************/
//RISE is form 113
add_action("gform_after_submission_113", "studentUploadHandler", 10, 2 );
function studentUploadHandler($entry, $form){
    /*Checks for an application ID (a previous entry)*/

  if($_POST["input_7"]!==""){
    parse_str($_SERVER["QUERY_STRING"]); //will be stored in $entry
    //get the actual entry we want to edit
      $editentry = GFAPI::get_entry($_POST["input_7"]);

      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }
    foreach ( $form['fields'] as $field ) {
          $inputs = $field->get_entry_inputs();

          //advanced inputs are stored as arrays - name, address, etc.
          if ( is_array( $inputs ) ) {

              foreach ( $inputs as $input ) {
                  $value = rgar( $entry, (string) $input['id'] );

                 //var_dump($input['id'] . ' - ' . $value);
                 if ($input['id'] == '3.3') {
                    //first name
                    $editentry[41]=$value;
                    //var_dump('F Name ' . $value);
                 }
                 if ($input['id'] == '3.6') {
                    //last name
                    $editentry[41]=$value;
                    //var_dump('L Name ' . $value);
                 }

              }

          } else {
          	var_dump($entry);
            var_dump( $input['id'] . ' ' . $field->id . ' ' . $field->lable);

              $value = rgar( $entry, (string) $field->id );
              switch (true) {
              	//$field->id == 5 //HS transcript
                case ($input['id'] == '1.8' &&  $field->id == 5):
                  //trans received
                  $editentry[135]=$value;
                  $editentry[108]='true';
                    var_dump($value);
                  break;
                 //$field->id == 6 //standardized tesat scores
                case ($input['id'] == '1.8' &&  $field->id == 6):
                  //test scores received
                  $editentry[136]=$value;
                  $editentry[128]='true';
                    var_dump($value);
                  break;
                //$field->id == 8 //passport - not required?
				/*case ($input['id'] == '1.8' &&  $field->id == 8):
                  $editentry[43]=$value;
                  $editentry[129]='true';
                    var_dump($value);
                  break;*/

                default:
                  # code...
                  break;
              }

      }
      }
      //die();
      $updateit = GFAPI::update_entry($editentry);
  }

}

/********************************************************/
//RISE science/math rec 114
add_action("gform_after_submission_114", "studentRecommendationHandler", 10, 2 );
function studentRecommendationHandler($entry, $form){
    /*all we're doing righ now is marking is at received*/

  if($_POST["input_57"]!==""){
    //get the actual entry we want to edit
      $editentry = GFAPI::get_entry($_POST["input_57"]);

      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }

      $editentry[127]='true';
      $updateit = GFAPI::update_entry($editentry);
  }

}

/**********************************************************/


function countEntries($form_id, $entry, $field_id, $add_column_data, $field_value) {

  $search_criteria = array(
      'status'        => 'active',
      /*'field_filters' => array(
          'mode' => 'any',
          array(
              'key'   => '1',
              'value' => 'Second Choice'
          ),
          array(
              'key'   => '5',
              'value' => 'My text'
          )
      )*/
  );
  $search_criteria['field_filters'][] = array( 'key' => $field_id, 'value' => $field_value );

  $entry_count = GFAPI::count_entries( /*$form_id*/8, $search_criteria );
  $add_column_data .= ' - ' . $entry_count;
  //echo 'HERE ' . $add_column_data . ' or ' . $entry_count . '<BR><BR>';
  return $entry_count;

/*var_dump($form['fields'][45][58]);
var_dump($i);


$startdate = 2015-12-30; //(Y-m-d format) optional
$enddate = 2015-12-31; //(Y-m-d format) optional
$search_criteria = array(
'status'     => 'active', //optional
'start_date' => $startdate, //optional
'end_date'   => $enddate, //optional
'field_filters' => array(
    array(
        'key'   => '3', //this is the field id of your drop-down
        'value' => 'exhibitor_name'
    )
  )
);

$entry_count = GFAPI::count_entries(1, $search_criteria); // 1 is your form id
echo $entry_count;



*/
//$form['fields']['45']['58'] = $i;

 foreach ( $form['fields'] as &$field ) {
        if ( $field->id == 58 ) {
          //var_dump($field);
          //die();
            $field->placeholder = $i;
        }
    }

    return $form;
}

//add_filter( 'gform_pre_render_8', 'countEntries', 10, 2 );

add_action( 'gform_pre_entry_list', 'echo_content' );
function echo_content( $form_id ) {
    echo 'some content here';
}


//custom first column
/*add_action( 'gform_entries_first_column', 'bu_rise_first_column_content', 10, 5 );*/

function bu_rise_first_column_content ($form_id, $field_id, $value, $entry, $query_string){

}
//add_filter( 'gform_before_resend_notifications', 'dump_stuff', 10, 2);
function dump_stuff($form, $leads_id) {
  var_dump($form);
  echo $form['notifications']['5bd7168f4b4eb']['name'];
  var_dump($leads_id);
  die();
}
//add_action( 'gform_after_email', 'change_subject', 10, 2 );
function change_subject( $form, $lead_ids ) {
  //die();
  $entry = GFAPI::get_entry( $lead_ids );
  var_dump($entry['id']);
  $current_user = wp_get_current_user();
  RGFormsModel::add_note( $entry['id'], $current_user->ID, $current_user->display_name, 'Notification re-sent.' );
}

/*add_action( 'gform_after_email', function( $is_success, $to, $subject, $message, $headers, $attachments, $message_format, $from, $from_name, $bcc, $reply_to, $entry ) {
  $current_user = wp_get_current_user();
  RGFormsModel::add_note( $entry['id'], $current_user->ID, $current_user->display_name, 'Edited the note to be added' );
}, 10, 12 );
*/


/*add_filter( 'gform_pre_send_email', function ( $email, $message_format, $notifications, $entry ) {
  //cancel sending emails
  //var_dump($email);
  //var_dump($message_format);
  //var_dump($notifications);
  //var_dump($entry);
  $email['abort_email'] = false;
  $message = $notifications['subject'] . ' resent.';
  $current_user = wp_get_current_user();
  RGFormsModel::add_note( $entry['id'], $current_user->ID, $current_user->display_name, $message );
  return $email;
}, 10, 4 );*/












//custom other columns
add_action( 'gform_entries_column', 'bu_summer_application_cols', 10, 5 );

function bu_summer_application_cols( $form_id, $field_id, $value, $entry, $query_string ) {

	echo '<div>IDS: ' . $field_id . '<br>';

	switch ($form_id) {
		case '112':
			/*field 135 is the first student transcript
			use that to trigger the document status check*/
		    if ( $field_id == 135 ) {
		      bu_get_summer_application_cols($form_id, $entry, $field_id);
		      return;
		    }
			//targeting field 5 only
		    if ( $field_id == 73 ) {
		      bu_get_summer_application_cols($form_id, $entry, $field_id);
		      return;
		    }

		    if ( $field_id == 38 ) {
		      bu_get_summer_application_cols($form_id, $entry, $field_id);
		      return;
		    }
		    if ( $field_id == 30 ) {
		      bu_get_summer_application_cols($form_id, $entry, $field_id);
		      return;
		    }

			break;
		
		default:

			break;
	}
	//RISE = 112

        //return;
}


function bu_get_summer_application_cols($form_id, $entry, $field_id, $value){

  $form = GFAPI::get_form( $form_id );
  $entry = GFAPI::get_entry( $entry['id'] );
  $add_column_data .= $value;

  if ( $field_id == 73 ){
    $fields = GFAPI::get_fields_by_type( $form, array( 'fileupload' ) , true );

    foreach ($fields as $field) {
       if ( $entry[$field->id] != '' ){
        $add_column_data .= '<input type="checkbox" checked>' . $field->label . '<br>';
       } else {
        $add_column_data .= '<input type="checkbox"> ' . $field->label . ': '  . '<br>';
        }

      }
  } elseif ( $field_id == 38 ) {
    $field_nelnet_id = GFFormsModel::get_field( $form, 38 );
    $field_cc_masked_nember = GFFormsModel::get_field( $form, 36 );
    $field_amount = GFFormsModel::get_field( $form, 37 );
    $add_column_data .= $field_nelnet_id->label . ": " . $entry[38] . "<br>";
    $add_column_data .= $field_cc_masked_nember->label . ": " . $entry[36] . "<br>";
    $add_column_data .= $field_amount->label . ": " . $entry[37] . "<br>";
    countEntries($form_id, $entry, $field_id);

  } elseif ( $field_id == 30 ) {

    $field_program_1_choices = GFFormsModel::get_field( $form, 32 );
    $field_program_2_choices = GFFormsModel::get_field( $form, 74 );
    $add_column_data .= '<BR>First Choice: ' . $entry[32];

      $search_criteria['field_filters'][] = array('key' => 75, 'value' => $entry[32]);
      $actual_count = GFAPI::count_entries( $form_id, $search_criteria );
      $add_column_data .= '( ' . $actual_count . ' )';


    $add_column_data .= '<BR>Second Choice: ' . $entry[74];

      $search_criteria['field_filters'][] = array('key' => 75, 'value' => $entry[74]);
      $actual_count = GFAPI::count_entries( $form_id, $search_criteria );
      $add_column_data .= '( ' . $actual_count . ' )';

  } elseif ( $field_id == 135 ) {
    $output_type = 'col_data';
    rise_document_status($entry, $form, $output_type);
  }
}


/*
add_filter( 'gform_entry_detail_meta_boxes', 'add_payment_details_meta_box', 10, 3 );
function add_payment_details_meta_box( $meta_boxes, $entry, $form ) {
    if ( ! isset( $meta_boxes['payment'] ) ) {
        $meta_boxes['payment'] = array(
            'title'         => esc_html__( 'Status and Approvals', 'gravityforms' ),
            'callback'      => array( 'GFEntryDetail', 'meta_box_payment_details' ),
            'context'       => 'side',
            'callback_args' => array( $entry, $form ),
        );
    }

    return $meta_boxes;
}
*/

/**
 * Add the meta box to the entry detail page.
 *
 * @param array $meta_boxes The properties for the meta boxes.
 * @param array $entry The entry currently being viewed/edited.
 * @param array $form The form object used to process the current entry.
 *
 * @return array
 */
function register_status_meta_box( $meta_boxes, $entry, $form ) {
  // If the add-on is active and the form has an active feed, add the meta box.
      $meta_boxes[ 'bu_status_and_decision' ] = array(
          'title'    => 'Status and Decision Buttons',
          'callback' => 'add_status_details_meta_box',
          'context'  => 'side',
          'callback_args' => array( $entry, $form ),
      );

      $meta_boxes[ 'bu_document_approval_tools' ] = array(
        'title'    => 'Document Approvals',
        'callback' => 'meta_box_document_approval_tools',
        'context'  => 'side',
        'callback_args' => array( $entry, $form ),
        
      );

      //for adding custom content to the notifications
     $meta_boxes[ 'bu_notifications' ] = array(
          'title'    => 'BU Notifications',
          'callback' => 'add_bu_notification_content',
          'context'  => 'side',
          'callback_args' => array( $entry, $form ),
    );

  return $meta_boxes;
}
add_filter( 'gform_entry_detail_meta_boxes', 'register_status_meta_box', 10, 3 );

/**
* The callback used to echo the content to the meta box.
*
* @param array $args An array containing the form and entry objects.
*/

function add_status_details_meta_box( $args ) {

	$form  = $args['form'];
	$entry = $args['entry'];
	//var_dump($form['fields']);
	//personal statements and essays
	$html = '<li><a href="?page=program_application_essays&application_id=' . $entry['id'] . '" target="_blank">Review ' . $form['fields']['61']->label . '</a>';
	//confirm gpa?
	/*$html = '<li><a href="?page=program_application_essays&application_id=' . $entry['id'] . '" target="_blank">Review ' . $form['fields']['61']->label . '</a>';*/
		
	$html .= sprintf( '<input type="submit" value="%s" class="button" onclick="jQuery(\'#action\').val(\'%s\');" />', 'Status Updates', $action );


  echo $html;
}

function meta_box_document_approval_tools ($args){

  $form  = $args['form'];
  $entry = $args['entry'];
  //var_dump($entry);
  //var_dump($form);

  $output_type = 'review_status';
  rise_document_status($entry, $form, $output_type);
  rise_recommendation_status($entry, $form, $output_type);

}



/*
Notifications management







*/
if ($_POST['bu_gform_notifications'] != '') {
	var_dump($_POST);
	$form = GFAPI::get_form( $_POST['form_id'] );
	 $lead =GFAPI::get_entry($_POST['lead_id']);
	$notifications = GFCommon::get_notifications_to_send( 'form_submission', $form, $lead );
var_dump($notifications);
	$trying = GFCommon::send_notifications( $_POST['bu_gform_notifications'], $form, $lead, true, 'form_submission' );
	
}
function add_bu_notification_content( $args ) {
  echo "<h3>Notification Content</h3>";
  $form  = $args['form'];
  $entry = $args['entry'];
  $notifications_list = GFCommon::get_notifications_to_send('form_submission', $form, $entry );
  //var_dump($notifications_list);
   $html   = '<form action="" method="post">';
  $js_vars   = '';
  $action = 'bu_resend_notifications';
  foreach ($notifications_list as $notifications) {
  	//var_dump($notifications);

  	$notifications['message'] = parseNotifications( $notifications['message'] );
    $html  .= '<input type="checkbox" name="bu_gform_notifications" class="gform_notifications" value="' . $notifications['id'] . '" id="notification_id">' . $notifications['name'] . '<BR>';
    /*$html  .= '<input type="checkbox" name="bu_gform_notifications" class="gform_notifications" value="' . $notifications['message'] . '" id="notification_' . $key . '">' . $notifications['name'] . '<BR>';*/
  }
  $html  .= '<input type="hidden" name="form_id" class="gform_notifications" value="' . $form['id'] . '">';
  $html  .= '<input type="hidden" name="lead_id" class="gform_notifications" value="' . $form['entry_id'] . '">';
  $html .= '<div id="bu_notification"><textarea name="bu_notificaton"></textarea></div>';
  // Retrieve the user from the current entry, if available.


      // Add the 'Process Feeds' button.
      $html .= sprintf( '<input id="bu_resend" type="Submit" value="%s" class="button" />', 'Send Notification');
      $html .= '</form><script></script>
      
      ';
	echo $html;
	$notification_id = $notifications_list['id'];
/*$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers[] = 'From: ' . $notifications_list[0]['from'];
$headers[] = 'Reply-To: ' . $notifications_list[0]['from'];
$headers[] = 'X-Mailer: PHP/' . phpversion();*/

//$orig_message = preg_quote($notifications_list[0]['message']);
//$orig_message = $notifications_list[0]['message'];
 //var_dump($form['notifications']);
 //var_dump(GFCommon::get_remote_message());
 //var_dump(GFFormsModel::get_entry_meta($form["id"]));
 
}
/*
function add_bu_notification_content_old( $args ) {
  echo "Notification content";
  $form  = $args['form'];
  $entry = $args['entry'];
 //var_dump($form['notifications']);
 //var_dump(GFCommon::get_remote_message());
 //var_dump(GFFormsModel::get_entry_meta($form["id"]));
 $entry_meta = GFFormsModel::get_entry_meta($form["id"]);
 $body = array();
 foreach ($form["fields"] as $field) {
     if ($field["type"] == "honeypot") {
         //skip the honeypot field
         continue;
     }
     $field_value = GFFormsModel::get_lead_field_value($entry, $field);
     if (!empty($entry)) {
         $field_value = apply_filters("gform_zapier_field_value", $field_value, $form["id"], $field["id"], $entry);
     }
     $field_label = GFFormsModel::get_label($field);
     if (is_array($field["inputs"])) {
         //handling multi-input fields
         $non_blank_items = array();
         //field has inputs, complex field like name, address and checkboxes. Get individual inputs
         foreach ($field["inputs"] as $input) {
             $input_label = GFFormsModel::get_label($field, $input["id"]);
             $field_id = (string) $input["id"];
             $input_value = $field_value == null ? "" : $field_value[$field_id];
             $body[$input_label] = $input_value;
             if (!rgblank($input_value)) {
                 $non_blank_items[] = $input_value;
             }
         }
         //Also adding an item for the "whole" field, which will be a concatenation of the individual inputs
         switch (GFFormsModel::get_input_type($field)) {
             case "checkbox":
                 //checkboxes will create a comma separated list of values
                 $body[$field_label] = implode(", ", $non_blank_items);
                 break;
             case "name":
             case "address":
                 //name and address will separate inputs by a single blank space
                 $body[$field_label] = implode(" ", $non_blank_items);
                 break;
         }
     } else {
         $body[$field_label] = rgblank($field_value) ? "" : $field_value;
     }
 }
 $entry_meta = GFFormsModel::get_entry_meta($form["id"]);
 foreach ($entry_meta as $meta_key => $meta_config) {
     $body[$meta_config["label"]] = empty($entry) ? null : rgar($entry, $meta_key);
 }
     echo $body;
     var_dump($body);
  $html   = '';
  $js_vars   = '';
  $action = 'bu_resend_notifications';
  foreach ($form['notifications'] as $key => $value) {
    $html  .= '<input type="checkbox" name="bu_gform_notifications" class="gform_notifications" value="' . $value["message"] . '" id="notification_' . $key . '">' . $value["name"] . '<BR>';
  }
  $html .= '<div id="bu_notification"><textarea name="bu_notificaton"></textarea></div>';
  // Retrieve the user from the current entry, if available.


      // Add the 'Process Feeds' button.
      $html .= sprintf( '<input id="bu_resend" type="button" value="%s" class="button" />', 'Send Notification', $action );
      $html .= '<script></script>
      
      ';

  echo $html;
}*/

add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here

function my_action_javascript() { ?>
<script type="text/javascript" >
     /* function startMessage() {
       console.log(jQuery("input[name=bu_gform_notifications]:checked").val());
       document.querySelector("#bu_notification > textarea").value = jQuery("input[name=bu_gform_notifications]:checked").val();
      }
      */
     jQuery( document ).ready(function() {
      var myEl = document.getElementById("bu_resend");

      
      function ajxfunction() {
        console.log(document.querySelector("#bu_notification > textarea").value);
       

        var data = {
          "action": "my_action",
          "whatever": 1234
        };
      jQuery.post(ajaxurl, data, function(response) {
       
        alert("Got this from the server: " + response);
      });

      var selectedNotifications = new Array();
				jQuery(".gform_notifications:checked").each(function () {
					selectedNotifications.push(jQuery(this).val());
				});

alert('Line 593 ' + jQuery.toJSON(selectedNotifications));
alert('Line 594 ' + window.location.search.substr(1));
var parameterName = 'lid'
var tmp = [];
var lid;
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
          console.log(tmp[0] + ' ' + decodeURIComponent(tmp[1]));

          if (tmp[0] === parameterName) lid = decodeURIComponent(tmp[1]);
          if (tmp[0] === id) fid = decodeURIComponent(tmp[1]);
        });



      jQuery.post(ajaxurl, {
						action                 : "gf_resend_notifications",
						gf_resend_notifications: '9981674c19',
						notifications          : jQuery.toJSON(selectedNotifications),
						sendTo                 : sendTo,
						leadIds                : lid,
						formId                 : fid
					},
					function (response) {
						if (response) {
							displayMessage(response, "error", "#notifications");
						} else {
							displayMessage("Notifications were resent successfully.", "updated", "#notifications" );

							// reset UI
							jQuery(".gform_notifications").attr( 'checked', false );
							jQuery('#notification_override_email').val('');

							toggleNotificationOverride();

						}

						jQuery('#please_wait_container').hide();
						setTimeout(function () {
							jQuery('#notifications_container').find('.message').slideUp();
						}, 5000);
					}
				);




















      
      }

      myEl.addEventListener("click", ajxfunction, false);
      //jQuery(document).ready(ajxfunction);
           
    });
	
	</script>
	 <?php
}
function update_subject_one( $email, $message_format, $notification, $entry ) {
  //$original_subject = $form['notification']['subject'];
  var_dump($_POST['notification_override_email']);
  $notification['message'] = 'Resending - ' . $notification['message'];
  var_dump($notification);
  die();
  return $notification;
}

//add_action( 'wp_ajax_my_action', 'my_action' );

function my_action() {
	global $wpdb; // this is how you get access to the database
  //add_filter( 'gform_notification', 'my_gform_notification_signature', 10, 3 );
  //add_filter( 'gform_pre_send_email', 'update_subject_one', 10, 4 );

  //if it get's in here send a notice.
  GFAPI::send_notifications( $form, $entry, 'user_registered' );
  var_dump(GFAPI::send_notifications( $form, $entry, 'user_registered' ));
  

	$whatever = intval( $_POST['whatever'] );
  var_dump($_POST);
	$whatever += 10;
  ob_clean();
  echo 'LINE!!! ' . $entry;
  
  echo 'LINE!!! ' . $whatever;
	wp_die(); // this is required to terminate immediately and return a proper response
}





//working tester
add_filter( 'gform_entry_detail_meta_boxes_3','add_status_decision_tools_meta_box', 10, 3 );//rise form 
function add_status_decision_tools_meta_box( $meta_boxes, $entry, $form ) {
     // If the add-on is active and the form has an active feed, add the meta box.
  


  return $meta_boxes;
}


//add_filter( 'gform_before_resend_notifications', 'my_gform_notification_signature', 10, 2 );
function my_gform_notification_signature( $form, $leads_id ) {
       // append a signature to the existing notification
       // message with .=
    var_dump($form['notification']['subject']);
    die();
    $notification['message'] .= "n --The Team @ rocketgenius";
 
    return $notification;
}

//add_filter( 'gform_pre_send_email', 'update_subject', 10, 4 );
function update_subject( $email, $message_format, $notification, $entry ) {
    //$original_subject = $form['notification']['subject'];
    //var_dump($_POST['notification_override_email']);
    $notification['message'] = 'Resending - ' . $notification['message'];
    //var_dump($notification);
    //die();
    return $notification;
}



function rise_document_status ($entry, $form, $output_type) {
  	$needs_review = 'true';
    $review_status_html = 'Incomplete<br>';
    $add_column_data = 'Incomplete ';
    $value = rgar( $entry, (string) $field->id );

    //RISE high school transcript 1
    if ($entry['108'] == 'true') {//received
      if ($entry['107'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $review_status_html .= 'Please review: <a href="' . $entry['135'] . '" target="_blank">' . $form['fields']['156']['label'] . '</a><br>';
        $review_status_html .= '<a href="' . $entry['135'] . '" target="_blank">Approve</a><br>';
      }
    }

    //RISE Standardized test scores
    if ($entry['128'] == 'true') {//received
      if ($entry['106'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $review_status_html .= 'Please review: <a href="' . $entry['136'] . '" target="_blank">' . $form['fields']['154']['label'] . '</a><br>';
      }
    }

      /*
	we may be able to adapt this for all review notification - not only documents
      if($needs_review == 'false') {
        $add_column_data = 'Complete';
        $entry['103'] = 'true';
        $updated_entry = GFAPI::update_entry( $entry );
      } else {
        $entry['103'] = 'false';
        $updated_entry = GFAPI::update_entry( $entry );

        $add_column_data = 'Incomplete';
      }*/
      //$add_column_data = $review_status_html;
      if ($output_type == 'review_status') {
        echo 'Status ' . $review_status_html;
      } elseif($output_type == 'col_data') {
        echo $review_status_html;
      } else {
        echo 'no output type ' . $add_column_data;
      }
}



function rise_recommendation_status ($entry, $form, $output_type) {
  	$needs_review = 'true';
    $review_status_html = 'Recommendations Incomplete<br>';
    $add_column_data = 'Recommendations Incomplete ';
    $value = rgar( $entry, (string) $field->id );
	//var_dump($form['fields']);
    /*field id 221 Counselor/Advisor/Teacher Recommendations if it's not blanked consider it received */
    //var_dump($entry);
    if ($entry['127'] != '') {//received
      if ($entry['107'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $review_status_html .= 'Please review: <a href="?page=program_counsil_recommendations&application_id=' . $entry['id'] . '" target="_blank">' . $form['fields']['161']['label'] . '</a><br>';
        $review_status_html .= '<a href="' . $entry['id'] . '" target="_blank">Approve</a><br>';
      }
    }

      if ($output_type == 'review_status') {
        echo 'Status ' . $review_status_html;
      } elseif($output_type == 'col_data') {
        echo $review_status_html;
      } else {
        echo 'no output type ' . $add_column_data;
      }
}


add_action( 'gform_after_update_entry_112', 'copy_entry_to_program', 10, 2 );
//copies from rise form only
//needs to check the field ids etc make to make sure it's an application move
function copy_entry_to_program($form, $entry_id, $original_entry){
  $editentry = GFAPI::get_entry($entry_id);
  $editentry['form_id'] = $editentry['133'];
  $editentry['1.3'] = 'Deedee';
  $editentry['1.6'] = 'Ramon';
  $entry_id = GFAPI::add_entry($editentry);

  //
  //$response_data = array_merge($data, array('status' => 'OK', 'entry_id' => $entry_id, 'message' => $success_msg));
  //unset($response_data[21]);
 // $response = new WP_JSON_Response();
 // $response->set_data($response_data);
 // return $response;
}

//read form fields into sidebar
add_filter( 'gform_entry_detail_meta_boxes', 'admin_notes', 10, 3 );
function admin_notes( $meta_boxes, $entry, $form ) {
     // If the add-on is active and the form has an active feed, add the meta box.

     $meta_boxes[ 'bu_admin_notes' ] = array(
      'title'    => 'Admin Notes',
      'callback' => 'meta_box_admin_notes',
      'context'  => 'side',
      'callback_args' => array( $entry, $form ),
  );

  return $meta_boxes;
}
function meta_box_admin_notes ($args){
  $form  = $args['form'];
  $entry = $args['entry'];
  $html = '';

  $html .= '<P><B>Special Skills:</b> ' . $entry[141];
  $html .= '<P><B>Concerns:</b> ' . $entry[142];
  $html .= '<P><B>Possible Matches:</b> ' . $entry[143];

  $html .= '<div value="%s" class="summer-prog-button" />Update</div>';

  echo $html;
}

//Update actual program registration
//add_filter( 'gform_entry_detail_meta_boxes', 'add_actual_program_meta_box', 10, 3 );
function add_actual_program_meta_box( $meta_boxes, $entry, $form ) {
     // If the add-on is active and the form has an active feed, add the meta box.

     $meta_boxes[ 'bu_finalize_program_registration' ] = array(
      'title'    => 'Finalize Program Registration',
      'callback' => 'meta_box_actual_program',
      'context'  => 'side',
      'callback_args' => array( $entry, $form ),
  );

  return $meta_boxes;
}
function meta_box_actual_program ($args){
  $form  = $args['form'];
  $entry = $args['entry'];
  $html = '';

  $html .= 'First Choice: ' . $entry[32];

      $search_criteria['field_filters'][] = array('key' => 75, 'value' => $entry[32]);
      $actual_count = GFAPI::count_entries( $form_id, $search_criteria );
  $html .= '( ' . $actual_count . ' )<BR>';

  $html .= 'Second Choice: ' . $entry[74];
      $search_criteria['field_filters'][] = array('key' => 75, 'value' => $entry[74]);
      $actual_count = GFAPI::count_entries( $form_id, $search_criteria );
  $html .= '( ' . $actual_count . ' )<BR>';
  $html .= 'Actual: ' . $entry[75] . '<br>';

  $html .= '<div value="%s" class="summer-prog-button" />Update Actual</div>';

  echo $html;
}

//add a page for viewing notes archives



add_action( 'gform_entries_view', 'notification_archive', 10, 3 );
function notification_archive ($view, $form_id, $entry_id) {
 echo 'Yeah!';
 $notes = GFFormsModel::get_lead_notes($entry_id);
 if ( sizeof( $notes ) > 0 && $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
  ?>
  <div class="alignleft actions" style="padding:3px 0;">
    <label class="hidden" for="bulk_action"><?php esc_html_e( ' Bulk action', 'gravityforms' ) ?></label>
    <select name="bulk_action" id="bulk_action">
      <option value=''><?php esc_html_e( ' Bulk action ', 'gravityforms' ) ?></option>
      <option value='delete'><?php esc_html_e( 'Delete', 'gravityforms' ) ?></option>
    </select>
    <?php
    $apply_button = '<input type="submit" class="button" value="' . esc_attr__( 'Apply', 'gravityforms' ) . '" onclick="jQuery(\'#action\').val(\'bulk\');" style="width: 50px;" />';
    /**
     * A filter to allow you to modify the note apply button
     *
     * @param string $apply_button The Apply Button HTML
     */
    echo apply_filters( 'gform_notes_apply_button', $apply_button );
    ?>
  </div>
  <?php
}
?>
<table class="widefat fixed entry-detail-notes" cellspacing="0">
  <?php
  if ( ! $is_editable ) {
    ?>
    <thead>
    <tr>
      <th id="notes">Notes</th>
    </tr>
    </thead>
    <?php
  }
  ?>
  <tbody id="the-comment-list" class="list:comment">
  <?php
  $count = 0;
  $notes_count = sizeof( $notes );
  foreach ( $notes as $note ) {
    $count ++;
    $is_last = $count >= $notes_count ? true : false;
    ?>
    <tr valign="top">
      <?php
      if ( $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
      ?>
      <th class="check-column" scope="row" style="padding:9px 3px 0 0">
        <input type="checkbox" value="<?php echo $note->id ?>" name="note[]" />
      </th>
      <td colspan="2">
        <?php
        }
        else {
        ?>
      <td class="entry-detail-note<?php echo $is_last ? ' lastrow' : '' ?>">
        <?php
        }
        $class = $note->note_type ? " gforms_note_{$note->note_type}" : '';
        ?>
        <div class="note-meta-container <?php echo $note->user_email ? 'note-has-email' : ''; ?>">
          <div class="note-avatar">
            <?php
            /**
             * Allows filtering of the notes avatar
             *
             * @param array $note The Note object that is being filtered when modifying the avatar
             */
            echo apply_filters( 'gform_notes_avatar', get_avatar( $note->user_id, 48 ), $note ); ?>
          </div>
          <div class="note-meta">
            <h6 class="note-author"><?php echo esc_html( $note->user_name ) ?></h6>
            <p class="note-email">
              <?php if( $note->user_email ): ?>
                <a href="mailto:<?php echo esc_attr( $note->user_email ) ?>"><?php echo esc_html( $note->user_email ) ?></a> <br>
              <?php endif; ?>
              <?php esc_html_e( 'added on', 'gravityforms' ); ?> <?php echo esc_html( GFCommon::format_date( $note->date_created, false ) ) ?>
            </p>
          </div>
        </div>
        <div class="detail-note-content<?php echo $class ?>"><?php echo nl2br( esc_html( $note->value ) ) ?></div>
      </td>

    </tr>
    <?php
  }
  if ( $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
    ?>
    <tr>
      <td colspan="3" style="padding:10px;" class="lastrow">
        <textarea name="new_note" style="width:100%; height:50px; margin-bottom:4px;"></textarea>
        <?php
        $note_button = '<input type="submit" name="add_note" value="' . esc_attr__( 'Add Note', 'gravityforms' ) . '" class="button" style="width:auto;padding-bottom:2px;" onclick="jQuery(\'#action\').val(\'add_note\');"/>';

        /**
         * Allows for modification of the "Add Note" button for Entry Notes
         *
         * @param string $note_button The HTML for the "Add Note" Button
         */
        echo apply_filters( 'gform_addnote_button', $note_button );

        if ( ! empty( $emails ) ) {
          ?>
          &nbsp;&nbsp;
          <span>
                            <select name="gentry_email_notes_to" onchange="if(jQuery(this).val() != '') {jQuery('#gentry_email_subject_container').css('display', 'inline');} else{jQuery('#gentry_email_subject_container').css('display', 'none');}">
                              <option value=""><?php esc_html_e( 'Also email this note to', 'gravityforms' ) ?></option>
                              <?php foreach ( $emails as $email ) { ?>
                                <option value="<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></option>
                              <?php } ?>
                            </select>
                            &nbsp;&nbsp;

                            <span id='gentry_email_subject_container' style="display:none;">
                                <label for="gentry_email_subject"><?php esc_html_e( 'Subject:', 'gravityforms' ) ?></label>
                                <input type="text" name="gentry_email_subject" id="gentry_email_subject" value="" style="width:35%" />
                            </span>
                        </span>
        <?php } ?>
      </td>
    </tr>
    <?php
  }
  ?>
  </tbody>
</table>
<?php
 var_dump($entry_id, $notes);
  add_filter( 'gform_entry_detail_meta_boxes', 'register_notes_meta_box', 10, 3 );
  function register_notes_meta_box( $meta_boxes, $entry, $form ) {
    // If the add-on is active and the form has an active feed, add the meta box.



      echo GFEntryDetail::meta_box_notes();
    return $meta_boxes;
  }
  //RGFormsModel::get_notes( $entry_id );
  //var_dump(GFEntryDetail::meta_box_notes());
var_dump(RGFormsModel::get_lead($entry_id));
  $editentry = GFAPI::get_entry($entry_id);
  var_dump($editentry);
  echo GFEntryDetail::meta_box_notes($editentry);
}




/*
Adding menu pages

*/
/**
 * Adds a submenu page under a custom post type parent.
 */
function bu_st_recommendations_list_menu() {

    $menus[] = array( 'name' => 'program_teacher_recommendations', 'label' => __( 'Teacher Recommendations' ), 'callback' =>  'bu_teacher_recommendations_list' );
    $menus[] = array( 'name' => 'program_counsil_recommendations', 'label' => __( 'Counselor Recommendations' ), 'callback' =>  'bu_counsil_recommendations_list' );
    $menus[] = array( 'name' => 'program_application_essays', 'label' => __( 'Application Essays' ), 'callback' =>  'bu_program_essays_list' );
  return $menus;
}
 
/**
 * Display callback for the submenu page.
 */
function bu_teacher_recommendations_list() {
    $search_criteria = array(
    	'field_filters' => array(
        'mode' => 'any',
	        array(
	            'key'   => 'application_id',//application_id
	            'value' => $_GET['application_id']//passed id value
	        ),
	        array(
	            'key'   => '57',//application_id
	            'value' => $_GET['application_id']//passed id value
	        ),

	    )
	);
	$search_criteria = array();
	$sorting         = array( 'key' => '5', 'direction' => 'ASC' );
	$paging          = array( 'offset' => 0, 'page_size' => 25 );
	$total_count     = 0;
	$entries         = GFAPI::get_entries( 114, $search_criteria, $sorting, $paging, $total_count );
// $total_count now contains the total number of entries matching the search criteria. This is useful for displaying pagination controls.
	maybe_load_gf_entry_detail_class();
	foreach ($entries as $entry) {
		$form = GFAPI::get_form($entry['form_id']);
	 	$entry = GFAPI::get_entry($entry['id']);
	 //var_dump(GFEntryDetail::lead_detail_grid( $form, $entry ));
		echo '<form>';
	    echo GFEntryDetail::lead_detail_grid( $form, $entry );
	    echo '</form>';

	}
	
}

/**
 * Display callback for the submenu page.
 */
function bu_counsil_recommendations_list() {

    $search_criteria = array(
    	'field_filters' => array(
        'mode' => 'any',
	        array(
	            'key'   => 'application_id',//application_id
	            'value' => $_GET['application_id']//passed id value
	        ),
	        array(
	            'key'   => '57',//application_id
	            'value' => $_GET['application_id']//passed id value
	        ),

	    )
	);
	/*$sorting         = array( 'key' => '5', 'direction' => 'ASC' );
	$paging          = array( 'offset' => 0, 'page_size' => 25 );*/
	$total_count     = 0;
	$entries         = GFAPI::get_entries( 117, $search_criteria, /*$sorting, $paging,*/ $total_count );
// $total_count now contains the total number of entries matching the search criteria. This is useful for displaying pagination controls.
	maybe_load_gf_entry_detail_class();
	foreach ($entries as $entry) {
		$form = GFAPI::get_form($entry['form_id']);
	 	$entry = GFAPI::get_entry($entry['id']);
	 //var_dump(GFEntryDetail::lead_detail_grid( $form, $entry ));
		echo '<form>';
	    echo GFEntryDetail::lead_detail_grid( $form, $entry );
	    echo '</form>';

	}
	echo GFEntryList::leads_page($entry['form_id']);

}



function bu_program_essays_list() {
    $search_criteria = array(
    	'field_filters' => array(
        'mode' => 'any',
	        array(
	            'key'   => 'id',//application_id
	            'value' => $_GET['application_id']//passed id value
	        ),
	        array(
	            'key'   => '57',//application_id
	            'value' => $_GET['application_id']//passed id value
	        ),

	    )
	);
	//$search_criteria = array();
	/*$sorting         = array( 'key' => '5', 'direction' => 'ASC' );
	$paging          = array( 'offset' => 0, 'page_size' => 25 );*/
	$total_count     = 0;
	$entries         = GFAPI::get_entries( 112, $search_criteria, /*$sorting, $paging,*/ $total_count );
// $total_count now contains the total number of entries matching the search criteria. This is useful for displaying pagination controls.
	maybe_load_gf_entry_detail_class();
	foreach ($entries as $entry) {
		$form = GFAPI::get_form($entry['form_id']);
	 	$entry = GFAPI::get_entry($entry['id']);
/*var_dump($entry);
var_dump($form);
die();*/
		echo '<form>';
		echo '<H3>' . $form['fields']['61']->label . '</H3>';
		echo '<H4>' . $form['fields']['62']->label . '</H4>';
	    echo '<p>' . $entry['92'];
	    echo '<H4>' . $form['fields']['63']->label . '</H4>';
	    echo '<p>' . $entry['93'];
	    echo '<H4>' . $form['fields']['64']->label . '</H4>';
	    echo '<p>' . $entry['94'];
	    echo '</form>';

	}

}







add_filter( 'gform_addon_navigation', 'bu_st_recommendations_list_menu' );
//bu_st_recommendations_list_page();
add_action( 'gform_print_entry_content', 'gform_default_entry_content', 10, 3 );
function gform_default_entry_content( $form, $entry, $entry_ids ) {
 	maybe_load_gf_entry_detail_class();
    $page_break = rgget( 'page_break' ) ? 'print-page-break' : false;
 
    // Separate each entry inside a form element so radio buttons don't get treated as a single group across multiple entries.
    echo '<form>';
 
    GFEntryDetail::lead_detail_grid( $form, $entry );
 
    echo '</form>';
 
    if ( rgget( 'notes' ) ) {
        $notes = GFFormsModel::get_lead_notes( $entry['id'] );
        if ( ! empty( $notes ) ) {
            GFEntryDetail::notes_grid( $notes, false );
        }
    }
 
    // Output entry divider/page break.
    if ( array_search( $entry['id'], $entry_ids ) < count( $entry_ids ) - 1 ) {
        echo '<div class="print-hr ' . $page_break . '"></div>';
    }
 
}

/**
	 * Check if the Gravity Forms GFEntryDetail class exists, otherwise load it
	 *
	 * @since 4.0
	 */
	function maybe_load_gf_entry_detail_class() {
		/* Ensure Gravity Forms GFEntryDetail class is loaded */
		if ( ! class_exists( 'GFEntryDetail' ) ) {
			$entry_details_file = GFCommon::get_base_path() . '/entry_detail.php';
			if ( is_file( $entry_details_file ) ) {
				require_once( $entry_details_file );
			} else {
				echo 'Argh';
				die();
			}
		}
	}





function parseNotifications($orig_message) {

	while(preg_match('/:[0-9]+\.?[0-9]+}/s', $orig_message, $replacement_array, PREG_OFFSET_CAPTURE) == 1){
		$i++;
	$replacement_array = array(
		);

	$t = preg_match('/:[0-9]+\.?[0-9]+}/s', $orig_message, $replacement_array, PREG_OFFSET_CAPTURE);
	//var_dump($replacement_array);
	//var_dump($notifications_list);
	//count backwards from here
	$entry_length = strlen($replacement_array[0][0]);
	//echo 'Entry length ' . $entry_length . "<br>";
	$entry_string = $replacement_array[0][0];
	//echo 'Entry String ' . $entry_string . "<br>";
	$entry_string = str_replace('}', '', $entry_string);
	//echo 'Entry String ' . $entry_string . "<br>";
	$entry_string = str_replace(':', '', $entry_string);
	//echo 'Entry String ' . $entry_string . "<br>";
	$index_of_string = $replacement_array[0][1];//int 28
	//echo 'Index of String ' . $index_of_string . "<br>";
	//get the whole replacement string
	$length_of_string = $entry_length + $index_of_string;
	//check in here for the opening {
	//echo "135" . $orig_message;
	$check_string = substr( $orig_message, 0, $length_of_string );
	//echo 'Check String: ' . $check_string . "<br>";
	$string_start = strrpos ( $check_string, '{',  0);
	//echo 'Index of { ' . $string_start . "<br>";
	$string_to_replace = substr( $check_string, $string_start );
	//echo 'String to replace ' . $string_to_replace . "<br>";
	$replace_with = '';
	/*echo 'Replace with $editentry[' . $entry_string . "]<br>";
	echo 'Replace with ' . $editentry[$entry_string] . "<br>";*/

/*
	echo 'Entry length Label ' . $entry_length_string . "<br>";
	$length_of_string = $end_of_string - $string_start + $entry_length + 1;
	$replacement_string = substr( $orig_message, $string_start, $length_of_string );
	var_dump($replacement_array);*/
	//echo '<h1>I ' . $i . "</H1>";
	/*echo '139 replacement_string ' . $replacement_string . "<br>";
	echo 'END 139 replacement_string<br><br><br>';
	var_dump($editentry[$entry_string]);
	
	echo 'String Length ' . $length_of_string . "<br>";


	echo $replacement_string . "<br>";
	echo 'String End ' . $entry_length_string . "<br>";
	die();*/
	$orig_message = str_replace($string_to_replace, $editentry[$entry_string], $orig_message);
	$orig_message = str_replace('{parentemail:12}', $editentry['12'], $orig_message);
	$orig_message = str_replace('{parentemail:14}', $editentry['14'], $orig_message);
	$orig_message = str_replace('{parentemail:16}', $editentry['16'], $orig_message);
	$orig_message = str_replace('{parentemail:16}', $editentry['18'], $orig_message);
	if (isset($editentry['12']) && filter_var($editentry['12'], FILTER_VALIDATE_EMAIL) != false) {
		$parent_email = $editentry['12'];
	} elseif (isset($editentry['14']) && filter_var($editentry['14'], FILTER_VALIDATE_EMAIL) != false) {
		$parent_email = $editentry['14'];
	} elseif (isset($editentry['16']) && filter_var($editentry['16'], FILTER_VALIDATE_EMAIL) != false) {
		$parent_email = $editentry['16'];
	} elseif (isset($editentry['18']) && filter_var($editentry['18'], FILTER_VALIDATE_EMAIL) != false) {
		$parent_email = $editentry['18'];
	}
	
	
	
	
	$orig_message = str_replace('{email:5}', $editentry['5'], $orig_message);
	$orig_message = str_replace('{phone:181}', $editentry['181'], $orig_message);
	$orig_message = str_replace('{phone:156}', $editentry['156'], $orig_message);
	$orig_message = str_replace('{entry_id}', $editentry['id'], $orig_message);
	$orig_message = str_replace('{embed_url}', 'https://djgannon.cms-devl.bu.edu', $orig_message);
	$orig_message = str_replace('{date_mdy}', date("F j, Y, g:i a"), $orig_message);
	$orig_message = str_replace('{cashier_cc_masked_number:36}', $_GET['cashier_cc_masked_number'], $orig_message);
	$orig_message = str_replace('{cashier_charged_amount:37}', $_GET['cashier_charged_amount'], $orig_message);
	$orig_message = str_replace('{NelnetID:38}', $_GET['NelnetID'], $orig_message);
	
	/*var_dump(preg_last_error());*/
	//echo '198 New Message ' . $orig_message . "<br>";
	if ($i > 150) {
		die();
	} else {
		$i++;
	}
}
return $orig_message;
}





/*

r/www/sandboxes/djgannon/archives/2018-10-19-125418-sbox-1539966084/wp-content/mu-plugins/bu-gf-customizations/bu-gf-customizations.php:265:
array (size=23)
  'id' => string '52' (length=2)
  'form_id' => string '5' (length=1)
  'date_created' => string '2018-10-30 18:46:35' (length=19)
  'is_starred' => int 0
  'is_read' => int 0
  'ip' => string '168.122.88.146' (length=14)
  'source_url' => string 'http://djgannon.cms-devl.bu.edu/singlecell/rise-thank-you-and-complete-form/?TelegraphCashierDirectiveSrc=cashier&form_location=%2Fsummer%2Fwp-assets%2Ftelegraph%2F&form_configuration=form-config-hs-r' (length=200)
  'post_id' => null
  'currency' => string 'USD' (length=3)
  'payment_status' => null
  'payment_date' => null
  'transaction_id' => null
  'payment_amount' => null
  'payment_method' => null
  'is_fulfilled' => null
  'created_by' => string '6167' (length=4)
  'transaction_type' => null
  'user_agent' => string 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.67 Safari/537.36' (length=114)
  'status' => string 'active' (length=6)
  1 => string '1111' (length=4)
  2 => string '5000' (length=4)
  3 => string '5001607689' (length=10)
  4 => string '51' (length=2)
/var/www/sandboxes/djgannon/archives/2018-10-19-125418-sbox-1539966084/wp-content/mu-plugins/bu-gf-customizations/bu-gf-customizations.php:266:
array (size=11)
  'input_1' => string '1111' (length=4)
  'input_2' => string '5000' (length=4)
  'input_3' => string '5001607689' (length=10)
  'input_4' => string '51' (length=2)
  'is_submit_5' => string '1' (length=1)
  'gform_submit' => string '5' (length=1)
  'gform_unique_id' => string '' (length=0)
  'state_5' => string 'WyJbXSIsImQ5Y2U2OGUxNzE1OTZlYjZkN2E4MzI4YmJhNDVlODY3Il0=' (length=56)
  'gform_target_page_number_5' => string '0' (length=1)
  'gform_source_page_number_5' => string '1' (length=1)
  'gform_field_values' => string '' (length=0)

























<label class='gfield_label' for='input_4_36' >Credit Card</label><div class='ginput_container ginput_container_text'><input name='input_36' id='input_4_36' type='text' value='' class='medium'  tabindex='66'    aria-invalid="false" /></div></li><li id='field_4_37' class='gfield field_sublabel_below field_description_below gfield_visibility_hidden' ><label class='gfield_label' for='input_4_37' >Charged Amount</label><div class='ginput_container ginput_container_text'><input name='input_37' id='input_4_37' type='text' value='' class='medium'  tabindex='67'    aria-invalid="false" /></div></li><li id='field_4_38' class='gfield field_sublabel_below field_description_below gfield_visibility_hidden' ><label class='gfield_label' for='input_4_38' >Nelnet ID</label><div class='ginput_container ginput_container_text'><input name='input_38' id='input_4_38' type='text' value='' class='medium'  tabindex='68'    aria-invalid="false" />*/

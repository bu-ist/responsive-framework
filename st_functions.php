<?php

/*
Notifications management

*/

function parseMessage($orig_message, $editentry){
	GLOBAL $orig_message;
	$orig_message = str_replace('{entry_id}', $editentry['id'], $orig_message);
	$orig_message = str_replace('{embed_url}', 'https://djgannon.cms-devl.bu.edu', $orig_message);
	$orig_message = str_replace('{date_mdy}', date("F j, Y, g:i a"), $orig_message);
	
	$orig_message = str_replace('{cashier_cc_masked_number:36}', $_GET['cashier_cc_masked_number'], $orig_message);
	//die();
	$orig_message = str_replace('{cashier_charged_amount:37}', $_GET['cashier_charged_amount'], $orig_message);
	$orig_message = str_replace('{NelnetID:38}', $_GET['NelnetID'], $orig_message);
	//die();
	$replacement_array = array();
	//this gets most of the generic fields
	while(preg_match('/:[0-9]+\.?[0-9]+}/s', $orig_message, $replacement_array, PREG_OFFSET_CAPTURE) == 1){
		$i++;
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

		$orig_message = str_replace($string_to_replace, $editentry[$entry_string], $orig_message);
		
		/*if (isset($editentry['12']) && filter_var($editentry['12'], FILTER_VALIDATE_EMAIL) != false) {
			$parent_email = $editentry['12'];
		} elseif (isset($editentry['14']) && filter_var($editentry['14'], FILTER_VALIDATE_EMAIL) != false) {
			$parent_email = $editentry['14'];
		} elseif (isset($editentry['16']) && filter_var($editentry['16'], FILTER_VALIDATE_EMAIL) != false) {
			$parent_email = $editentry['16'];
		} elseif (isset($editentry['18']) && filter_var($editentry['18'], FILTER_VALIDATE_EMAIL) != false) {
			$parent_email = $editentry['18'];
		}
		*/
		
		
		/*var_dump(preg_last_error());*/
		//echo '198 New Message ' . $orig_message . "<br>";
		if ($i > 150) {
			die();
		} else {
			$i++;
		}
	}	
		// The regex here is the word 'go'.
	$email_regex  = "/{email:(.+)}/";
	// preg_match returns true or false.
	if($email_entry = preg_match($email_regex, $orig_message, $match)) 
	{
		$email_id = preg_match('/{email:/[0-9]+}/s', $orig_message, $replacement_array, PREG_OFFSET_CAPTURE);
	  //echo "<br>Email id should = " . $editentry[$match[1]];
	  $orig_message = str_replace($match[0], $editentry[$match[1]], $orig_message);
	} 
	else 
	{
	  //echo "<br>We found no match email.";
	}

	$phone_regex  = "/{phone:(.+)}/";
	// preg_match returns true or false.
	if($phone_entry = preg_match($phone_regex, $orig_message, $match)) 
	{
		$phone_id = preg_match('/{phone:/[0-9]+}/s', $orig_message, $replacement_array, PREG_OFFSET_CAPTURE);
	  //echo "Phone id should = " . $editentry[$match[1]];
	  $orig_message = str_replace($match[0], $editentry[$match[1]], $orig_message);
	} 
	else 
	{
	  //echo "<br>We found no match phone.";
	}

	$nickname_regex  = "/{nickname:(.+)}/";
	// preg_match returns true or false.
	if($nickname_entry = preg_match($nickname_regex, $orig_message, $match)) 
	{
		$nickname_id = preg_match('/{nickname:/[0-9]+}/s', $orig_message, $replacement_array, PREG_OFFSET_CAPTURE);
	  //echo "Nickname id should = " . $editentry[$match[1]];
	  $orig_message = str_replace($match[0], $editentry[$match[1]], $orig_message);
	} 
	else 
	{
	  //echo "<br>We found no match nickname.";
	}
//var_dump($orig_message);
//die();
	return $orig_message;

}

function parseHeaders($notifications_list, $editentry, $headers){
	/*var_dump($notifications_list[0]);
	var_dump($notifications_list[0]['bcc']);

also check for mentoremail

	*/
	GLOBAL $headers;
	$parentemail_regex  = "/{parentemail:(.+)}/";
	// preg_match returns true or false.
	if($parentemail = preg_match($parentemail_regex, $notifications_list[0]['bcc'], $match)) 
	{
		$parentemail_id = preg_match('/{parentemail:\[0-9\]+}/s', $notifications_list[0]['bcc'], $replacement_array, PREG_OFFSET_CAPTURE);
	  //echo "parentemail id should = " . $editentry[$match[1]];
	  $bcc_parent = str_replace($match[0], $editentry[$match[1]], $notifications_list[0]['bcc']);
	  $headers[] = 'Cc: ' . $bcc_parent;
	} 
	else 
	{
	  echo "We found no match.";
	}


	$cur_notification[bcc];
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/html; charset=iso-8859-1';

	// Additional headers
	$headers[] = 'From: ' . $notifications_list[0]['from'];
	$headers[] = 'Reply-To: ' . $notifications_list[0]['from'];
	$headers[] = 'Cc: ' . $bcc_parent;
	return $headers;
	//die();
}
if ($_POST['bu_gform_notifications'] != '') {
	
	$form = GFAPI::get_form( $_POST['form_id'] );
	 $lead =GFAPI::get_entry($_POST['lead_id']);
	 $form_events = array('0' => 'form_submission', '1' => 'admin_notifications', '2' => 'admin_offers',  );
	$notifications_list = GFCommon::get_notifications_to_send( 'admin_notifications', $form, $lead );
	foreach ($notifications_list as $key => $value) {
		if ($value['id'] == $_POST['bu_gform_notifications']){
		//echo $key . ' ' . $value .  '<BR>';
			$message_id = $value['id'];
			$message_key = $key;
		}
		//echo $key . ' ' . $value['id'] . ' ' . $message_key .  '<BR>';
	}
	//var_dump($notifications_list[$message_key]);
	//update form flags as needed for each message
	if ($notifications_list[$message_key]['id'] == '5d972c4da117d'){
		//document re-submit set flag to false
		//set entry transcript received to false
		$lead['108'] = false;
		//var_dump($lead);
		GFAPI::update_entry($lead);

	}

	$orig_message = str_replace('[notification_text]', $_POST['bu_notificaton'], $notifications_list[$message_key]['message']);
		/*$orig_message = $notifications_list[$message_key]['message']  . $_POST['bu_notificaton'];*/
		// /var_dump($orig_message);
		parseMessage($orig_message, $lead);
		parseHeaders($notifications_list, $editentry, $headers);

	
		if ($notifications_list[$message_key]['to'] == '{admin_email}') {
			$notifications_list[$message_key]['to'] = 'djgannon@bu.edu';
		}
		$to_email = $notifications_list[$message_key]['to'];
		$to_email = $notifications_list[$message_key]['to'];
		$to_email = 'djgannon@bu.edu';
		$mail_test = mail($to_email,
		$notifications_list[$message_key]['subject'], $orig_message, implode("\r\n", $headers) );

		RGFormsModel::add_note($_POST['lead_id'], $current_user->ID, $user_data->display_name, stripslashes($orig_message));
	
}

if ($_GET['bu_gform_notifications'] != '') {
	//var_dump($_POST);
	$form = GFAPI::get_form( $_GET['bu_gform_notifications'] );
	 $lead =GFAPI::get_entry($_GET['lid']);
	$notifications = GFCommon::get_notifications_to_send( 'form_submission', $form, $lead );
//var_dump($notifications);
	$trying = GFCommon::send_notifications( $_POST['bu_gform_notifications'], $form, $lead, true, 'form_submission' );




	
}
add_filter( 'gform_before_resend_notifications', 'checkPost', 10, 2 );
function checkPost($entry, $form){
	//var_dump($_POST);

	/*/var/www/sandboxes/djgannon/archives/2019-06-27-222500-sbox-1561675006/wp-content/themes/responsive-framework/st_functions.php:28:
array (size=6)
  'action' => string 'gf_resend_notifications' (length=23)
  'gf_resend_notifications' => string 'caf4aea9d5' (length=10)
  'notifications' => string '[\"5bd9ae9893a31\"]' (length=19)
  'sendTo' => string '' (length=0)
  'leadIds' => string '659' (length=3)
  'formId' => string '63' (length=2)*/
	//die();
}


function add_bu_notification_content( $args ) {
  
  $form  = $args['form'];
  $entry = $args['entry'];
  $notifications_list = GFCommon::get_notifications_to_send('admin_notifications', $form, $entry );
  //var_dump($notifications_list);
  $html   = '<form action="" method="post">';
  $js_vars   = '';
  $action = 'bu_resend_notifications';
  $html  .= "<h4>Admin Notifications</h4>";
  foreach ($notifications_list as $notifications) {
  	//var_dump($notifications);

  	$notifications['message'] = parseNotifications( $notifications['message'] );
    $html  .= '<input type="checkbox" name="bu_gform_notifications" class="gform_notifications" value="' . $notifications['id'] . '" id="notification_id">' . $notifications['name'] . '<BR>';
    /*$html  .= '<input type="checkbox" name="bu_gform_notifications" class="gform_notifications" value="' . $notifications['message'] . '" id="notification_' . $key . '">' . $notifications['name'] . '<BR>';*/
  }

  $notifications_list = GFCommon::get_notifications_to_send('admin_offers', $form, $entry );
  //var_dump($entry);
 $html  .= "<h4>Admin Offer Notices</h4>";
  foreach ($notifications_list as $notifications) {
  	//var_dump($notifications);

  	$notifications['message'] = parseNotifications( $notifications['message'] );
    $html  .= '<input type="checkbox" name="bu_gform_notifications" class="gform_notifications" value="' . $notifications['id'] . '" id="notification_id">' . $notifications['name'] . '<BR>';
    /*$html  .= '<input type="checkbox" name="bu_gform_notifications" class="gform_notifications" value="' . $notifications['message'] . '" id="notification_' . $key . '">' . $notifications['name'] . '<BR>';*/
  }

  $html  .= '<input type="hidden" name="form_id" class="gform_notifications" value="' . $form['id'] . '">';
  $html  .= '<input type="hidden" name="lead_id" class="gform_notifications" value="' . $entry['id'] . '">';
  $html .= '<div id="bu_notification"><textarea id="bu_notificaton_textarea" name="bu_notificaton"></textarea></div>';
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
       
        //alert("Got this from the server: " + response);
      });

      var selectedNotifications = new Array();
				jQuery(".gform_notifications:checked").each(function () {
					selectedNotifications.push(jQuery(this).val());
				});

/*alert('Line 593 ' + jQuery.toJSON(selectedNotifications));
alert('Line 594 ' + window.location.search.substr(1));*/
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
						gf_resend_notifications: '5bd9ae9893a31',
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


//add a page for viewing notes archives
/*var_dump(rgget('view'));
if (rgget('view') == 'entry') {
add_action( 'gform_entries_view', 'notification_archive', 10, 3 );

}*/
add_action( 'gform_entries_view', 'notification_archive', 10, 3 );
function notification_archive ($view, $form_id, $entry_id) {
 
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
 //var_dump($entry_id, $notes);
  add_filter( 'gform_entry_detail_meta_boxes', 'register_notes_meta_box', 10, 3 );
  function register_notes_meta_box( $meta_boxes, $entry, $form ) {
    // If the add-on is active and the form has an active feed, add the meta box.



      echo GFEntryDetail::meta_box_notes();
    return $meta_boxes;
  }
  //RGFormsModel::get_notes( $entry_id );
  //var_dump(GFEntryDetail::meta_box_notes());
/*var_dump(RGFormsModel::get_lead($entry_id));
  $editentry = GFAPI::get_entry($entry_id);
  var_dump($editentry);
  echo GFEntryDetail::meta_box_notes($editentry);*/




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

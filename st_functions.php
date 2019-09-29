<?php
/*Try updating entries directly form telegraph*/
$editentry = GFAPI::get_entry($_GET['application_id']);
//only out local payment confirmation
add_action( 'gform_loaded', 'get_classes', 10, 0 );
function get_classes(){
	if (class_exists(GFAPI)) {
    //$myclass = new MyClass();
} else {
	echo "Dead";
	//die();
}
var_dump($_SERVER['HTTP_X_FORWARDED_HOST']);
var_dump($_SERVER);
 if( isset($_SERVER['HTTP_X_FORWARDED_HOST']) &&
  		($_SERVER['HTTP_X_FORWARDED_HOST'] == 'djgannon.cms-devl.bu.edu')
  		&& $_GET['application_id'] != '' ) {
				
			//$editentry = GFAPI::get_entry($_GET['application_id']);
		//var_dump($editentry);
		$input_values['input_3']    = $_GET['NelnetID'];
				$input_values['input_2']  =  $_GET['transactionTotalAmount'];
				$input_values['input_1']  = $_GET['creditCardLastFour'];

				$input_values['address1']    = $_GET['address1'];
				$input_values['city']  =  $_GET['city'];
				$input_values['input_6.4']  = $_GET['state'];
				$input_values['input_6.5']    = $_GET['zipcode'];
				$input_values['input_6.6']  =  $_GET['country'];
				$input_values['input_5.5']  =  $_GET['lastname'];
				$input_values['input_5.3']  =  $_GET['firstname'];
				$input_values['input_7']  =  $_GET['email'];
				

				/*$input_values['payment_status']    = 'Yes';
				$input_values['payment_date']    = date('Y/m/d');*/
				$input_values['application_id']    = $_GET['application_id'];
        
        
    //$result = RGFormsModel::add_entry($input_values);
   //
				$result = GFAPI::submit_form( 47, $input_values);
			//var_dump($result);
			}
 //return $form;
}
add_action( 'gform_post_render_47', 'update_payment_info' );
function update_payment_info( $form ) {
		
		//first update the original application
		//$new_form = GFAPI::get_form('22');

    if( isset($_SERVER['HTTP_X_FORWARDED_HOST']) &&
  		($_SERVER['HTTP_X_FORWARDED_HOST'] == 'djgannon.cms-devl.bu.edu')
  		&& $_GET['application_id'] != '' ) {
				
			$editentry = GFAPI::get_entry($_GET['application_id']);
			//nelnet id
			$result = GFAPI::update_entry_field( $_GET['application_id'], '38', $_GET['NelnetID'] );
			$result = GFAPI::update_entry_field( $_GET['application_id'], '37', $_GET['transactionTotalAmount'] );
			$result = GFAPI::update_entry_field( input_values, '36', $_GET['creditCardLastFour'] );
			$result = GFAPI::update_entry_field( $_GET['application_id'], 'payment_date', date("Y/m/d") );
			$result = GFAPI::update_entry_field( $_GET['application_id'], 'payment_status', 'yes' );
			//var_dump($editentry);

			//update the entry and redirect?



			//var_dump($form);

			/*GFAPI::send_notifications( $new_form, $editentry, 'form_submission' );
			echo "<H1>HERE I COME . . .  " . $form["notifications"]["5ce6ea772f081"]["message"] . "!</H1>";
*/



				//second submit the current form without user interaction
				/*$input_values['input_1']    = $_GET['NelnetID'];
				$input_values['input_2']  =  $_GET['transactionTotalAmount'];
				$input_values['input_3']  = $_GET['creditCardLastFour'];

				$input_values['address1']    = $_GET['address1'];
				$input_values['city']  =  $_GET['city'];
				$input_values['input_6.4']  = $_GET['state'];
				$input_values['input_6.5']    = $_GET['zipcode'];
				$input_values['input_6.6']  =  $_GET['country'];
*/
				/*$input_values['payment_status']    = 'Yes';
				$input_values['payment_date']    = date('Y/m/d');*/
				//$input_values['application_id']    = $_GET['application_id'];
				

				/*$result = GFAPI::submit_form( '47', $input_values );
				can't submit a pre_rendered form so add the entry
				*/
				//var_dump($input_values);
				//$entry_id = GFAPI::add_entry( '47', $input_values );
				//var_dump($entry_id);

				//echo $result['confirmation_messsage'];
				//$result = RGFormsModel::add_entry($input_values);
				//var_dump($result);
					//$result = GFAPI::submit_form( 47, $input_values );
				$form = GFAPI::get_form( '47' );
    $form_string = "<p>One moment</p><script>jQuery(function() {alert('Jquery in thehOuse!');});</script>";
    $input_values['input_3']    = $_GET['NelnetID'];
				$input_values['input_2']  =  $_GET['transactionTotalAmount'];
				$input_values['input_1']  = $_GET['creditCardLastFour'];

				$input_values['address1']    = $_GET['address1'];
				$input_values['city']  =  $_GET['city'];
				$input_values['input_6.4']  = $_GET['state'];
				$input_values['input_6.5']    = $_GET['zipcode'];
				$input_values['input_6.6']  =  $_GET['country'];
				$input_values['input_5.5']  =  $_GET['lastname'];
				$input_values['input_5.3']  =  $_GET['firstname'];
				$input_values['input_7']  =  $_GET['email'];
				

				/*$input_values['payment_status']    = 'Yes';
				$input_values['payment_date']    = date('Y/m/d');*/
				$input_values['application_id']    = $_GET['application_id'];
        
        foreach ($form['fields'] as $key => $value) {
        	$form_string .= "Label: " .  $value['label'] . ": <br>";
        }
    //$result = RGFormsModel::add_entry($input_values);
   $result = GFAPI::submit_form( 47, $input_values);

/*
		RGFormsModel::save_lead($form, $input_values);
     //reading entry that was just saved
     $lead = RGFormsModel::get_lead($lead["id"]);
     $lead = GFFormsModel::set_entry_meta($lead, $form);
     $result = do_action('gform_entry_created', $lead, $form);*/




					//var_dump($form['input_5.3']);

					echo $form_string . $result['confirmation_message'];
		}
var_dump($result);
//exit;
    //$editentry = GFAPI::get_entry($_POST["input_7"]);creditCardLastFour
//'HTTP_X_FORWARDED_HOST' => string 'djgannon.cms-devl.bu.edu'
}
//add_filter( 'gform_get_form_filter_47', 'hide_while_pending', 10, 2 );
function hide_while_pending ($form ){
		$form = GFAPI::get_form( '47' );
    $form_string = "<p>One moment</p><script>jQuery(function() {alert('Jquery in thehOuse!');});</script>";
    $form['input_1']    = $_GET['NelnetID'];
				$form['input_2']  =  $_GET['transactionTotalAmount'];
				$form['input_3']  = $_GET['creditCardLastFour'];

				$form['address1']    = $_GET['address1'];
				$form['city']  =  $_GET['city'];
				$form['input_6.4']  = $_GET['state'];
				$form['input_6.5']    = $_GET['zipcode'];
				$form['input_6.6']  =  $_GET['country'];
$form['input_5.5']  =  $_GET['lastname'];
				$form['input_5.3']  =  $_GET['firstname'];
				/*$input_values['payment_status']    = 'Yes';
				$input_values['payment_date']    = date('Y/m/d');*/
				$input_values['application_id']    = $_GET['application_id'];
        //var_dump($form['fields'][0]);
        foreach ($form['fields'] as $key => $value) {
        	$form_string .= $key . ", Label: " .  $value['label'] . "<br>";
        }
    $result = RGFormsModel::add_entry($input_values);
   //$result = GFAPI::submit_form( 47, $form, $input_values );
 var_dump($form['input_5.5']);
    //return $form;
}




/*Importing functions from bu gf customizations */

function paymentConfHandler($form){
		/*Check for an application ID (a previous entry)*/

  if($_POST["input_4"]!==""){
    //Get original entry id
    parse_str($_SERVER["QUERY_STRING"]); //will be stored in $entry
//var_dump($_POST);
//var_dump(parse_str($_SERVER["QUERY_STRING"]));
    //get the actual entry we want to edit
    $editentry = GFAPI::get_entry($_POST["input_7"]);

    //make changes to it from new values in $_POST, this shows only the first field update
    $editentry[36]=$_POST["input_1"];
    $editentry[37]=$_POST["input_2"];
    $editentry[38]=$_POST["input_3"];

    //update it
    $updateit = GFAPI::update_entry($editentry);

    if ( is_wp_error( $updateit ) ) {
      echo "Error.";
    }
  }
}
add_action("gform_pre_submission_4", "paymentConfHandler");//rise conf
add_action("gform_pre_submission_9", "paymentConfHandler");//ssip conf
/********************************************************/

function counselRecHandler($entry, $form){
    /*Checks for an application ID (a previous entry)*/
    /*var_dump(rgar($entry));
    var_dump($form);
    */

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

	            $value = rgar( $entry, (string) $field->id );
	          	switch (true) {
	           		case ($input['id'] == '3.8' &&  $field->id == 4):
	           			//counselor email
	           			$editentry[42]=$value;
	               		//var_dump($value);
	           			break;

	            	case ($input['id'] == '3.8' &&  $field->id == 5):
	            		//counselor rec form
                  $editentry[43]=$value;
                  $editentry[127]='true';//received flag
	                	//var_dump($value);
	            		break;

	            	case ($input['id'] == '3.8' &&  $field->id == 6):
	            		//rec letter
	            		$editentry[44]=$value;
	                	//var_dump($value);
                  break;

	           		default:
	           			# code...
	           			break;
	           	}

			}
	    }
	    $updateit = GFAPI::update_entry($editentry);
	}

}

add_action("gform_after_submission_2", "counselRecHandler", 10, 2 );


/********************************************************/

function studentUploadHandler($entry, $form){
    /*Checks for an application ID (a previous entry)*/
    /*var_dump(rgar($entry));
    var_dump($form);
    */

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
          //var_dump($inputs);
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
            //var_dump( $input['id'] . ' ' . $field->id);

              $value = rgar( $entry, (string) $field->id );
              switch (true) {
                case ($input['id'] == '1.8' &&  $field->id == 5):
                  //trans received
                  $editentry[135]=$value;
                  $editentry[108]='true';
                    //var_dump($value);
                  break;

                case ($input['id'] == '1.8' &&  $field->id == 6):
                  //trans 2 received
                  $editentry[136]=$value;
                  $editentry[108]='true';
                    //var_dump($value);
                  break;


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

add_action("gform_after_submission_9", "studentUploadHandler", 10, 2 );
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
//add_action( 'gform_entries_first_column', 'bu_rise_first_column_content', 10, 5 );

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


add_filter( 'gform_pre_send_email', function ( $email, $message_format, $notifications, $entry ) {
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
}, 10, 4 );












//custom other columns
add_action( 'gform_entries_column', 'bu_summer_application_cols', 10, 5 );

function bu_summer_application_cols( $form_id, $field_id, $value, $entry, $query_string ) {

    if ( $form_id != 4 )
        return;

    if ( $field_id == 103 ) {
      bu_get_summer_application_cols($form_id, $entry, $field_id);          return;
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

  } elseif ( $field_id == 103 ) {
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
  var_dump($metaboxes);
      $meta_boxes[ 'bu_status_and_decision' ] = array(
          'title'    => 'Status and Decision Buttons',
          'callback' => 'add_status_details_meta_box',
          'context'  => 'side',
          'callback_args' => array( $entry, $form ),
      );

      $meta_boxes[ 'bu_status_and_decision_tools' ] = array(
        'title'    => 'Status and Decision Tools',
        'callback' => 'meta_box_status_decision_tools',
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
    
    //die();


    //var_dump(GFEntryDetail::meta_box_notes());
    //echo GFEntryDetail::meta_box_notes();
  return $meta_boxes;
}
add_filter( 'gform_entry_detail_meta_boxes', 'register_status_meta_box', 10, 3 );

/**
* The callback used to echo the content to the meta box.
*
* @param array $args An array containing the form and entry objects.
*/
function add_bu_notification_content( $args ) {
  echo "Notification content";
  $form  = $args['form'];
  $entry = $args['entry'];
 //var_dump($form['notifications']);
 var_dump(GFCommon::get_remote_message());
 var_dump(GFFormsModel::get_entry_meta($form["id"]));
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
}

//add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here

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
     /* jQuery.post(ajaxurl, data, function(response) {
       
        alert("Got this from the server: " + response);
      });*/

      var selectedNotifications = new Array();
				jQuery(".gform_notifications:checked").each(function () {
					selectedNotifications.push(jQuery(this).val());
				});

alert(jQuery.toJSON(selectedNotifications));
alert(window.location.search.substr(1));
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

function add_status_details_meta_box( $args ) {

  $form  = $args['form'];
  $entry = $args['entry'];

  $html   = '';
  $action = 'gf_user_registration_process_feeds';

  // Retrieve the user from the current entry, if available.

  echo GFCommon::get_remote_message();
      // Add the 'Process Feeds' button.
      $html .= sprintf( '<input type="submit" value="%s" class="button" onclick="jQuery(\'#action\').val(\'%s\');" />', 'Status Updates', $action );


  echo $html;
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

add_filter( 'gform_pre_send_email', 'update_subject', 10, 4 );
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
//var_dump($entry);
//var_dump($form['fields']);
    //student supplemental upload 1
    if ($entry['104'] == 'true') {//received
      if ($entry['130'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $review_status_html .= 'Please review: ' . $form['fields']['135']['label'] . '<br>';
      }
    }

    //student supplemental upload 2
    if ($entry['129'] == 'true') {//received
      if ($entry['131'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $review_status_html .= 'Please review: ' . $form['fields']['135']['label'] . '<br>';
      }
    }

    //high school transcript
    if ($entry['108'] == 'true') {//received
      if ($entry['107'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $review_status_html .= 'Please review: ' . $form['fields']['94']['label'] . '<br>';
      }
    }

    //high school teacher letter approval
    if ($entry['128'] == 'true') {//received
      if ($entry['106'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $review_status_html .= 'Please review: ' . $form['fields']['128']['label'] . '<br>';
      }
    }


    //high school counselor letter approval
    if ($entry['127'] == 'true') {//received
      if ($entry['105'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $review_status_html .= 'Please review: ' . $form['fields']['80']['label'] . '<br>';
      }
    }
    //echo $needs_review;
      if($needs_review == 'false') {
        $add_column_data = 'Complete';
        $entry['103'] = 'true';
        $updated_entry = GFAPI::update_entry( $entry );
      } else {
        $entry['103'] = 'false';
        $updated_entry = GFAPI::update_entry( $entry );

        $add_column_data = 'Incomplete';
      }
      //$add_column_data = $review_status_html;
      if ($output_type == 'review_status') {
        echo 'Status ' . $review_status_html;
      } elseif($output_type == 'col_data') {
        echo /*$add_column_data . '<br>' .*/ $review_status_html;
      } else {
        echo 'no output type ' . $add_column_data;
      }
}
function meta_box_status_decision_tools ($args){
  
  $form  = $args['form'];
  $entry = $args['entry'];
  //var_dump($entry);
  //var_dump($form);

  $output_type = 'review_status';
  rise_document_status($entry, $form, $output_type);

   
}

add_action( 'gform_after_update_entry_3', 'copy_entry_to_program', 10, 2 );
//copies from rise form only
//needs to check the field ids etc make to make sure it's an application move
function copy_entry_to_program($form, $entry_id, $original_entry){
  $editentry = GFAPI::get_entry($entry_id);
  $editentry['form_id'] = $editentry['133'];
  $editentry['1.3'] = 'Deedee';
  $editentry['1.6'] = 'Ramon';
  $entry_id = GFAPI::add_entry($editentry);

  // Give the user back a sanitized version of their input for displaying on the Thank You message
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

<?php
/*Custom Admin for RISE */
/********************************************************/
add_action( 'gform_entries_column', 'bu_summer_application_cols', 10, 5 );

function bu_summer_application_cols( $form_id, $field_id, $value, $entry, $query_string ) {

	//echo '<div>IDS: ' . $field_id . '<br>';

	switch ($form_id) {
		case '112':
			/*field 135 is the first student transcript
			use that to trigger the document status check*/
		    if ( $field_id == 135 ) {
		    	$output_type = 'col_data';
    			rise_document_status($entry, $form, $output_type);
		      //return;
		    }
			//Actual Program
		    if ( $field_id == 75 ) {
		      countEntries($form_id, $entry, $field->id);
		      //return;
		    }

		    if ( $field_id == 73 ) {
		      $fields = GFAPI::get_fields_by_type( $form, array( 'fileupload' ) , true );

		    }
		    if ( $field_id == 30 ) {
			    //this is counting for some other program I believe
			
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
	  	
		      //return;
		    }

			break;
		
		default:

			break;
	}
	
}

/*Collect data from secondary forms and feed into the main application*/
/********************************************************/

//RISE counselor recommendation
add_action("gform_after_submission_117", "counselRecHandler", 10, 2 );
function counselRecHandler($entry, $form){
    /*all we're doing right now is marking is at received*/
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

//RISE student upload form form 113
add_action("gform_after_submission_113", "studentUploadHandler", 10, 2 );
function studentUploadHandler($entry, $form){
	
	/*input_7 holds the application id of the program application*/
	if($_POST["input_7"]!==""){
    //get the actual entry we want to edit
      $editentry = GFAPI::get_entry($_POST["input_7"]);

      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }
    
    /*match the field values of the current form to the entry values of the original application*/
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


//RISE science/math rec 114
add_action("gform_after_submission_114", "studentRecommendationHandler", 10, 2 );
function studentRecommendationHandler($entry, $form){
    /*all we're doing right now is marking is at received*/
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
      'field_filters' => array(
          'mode' => 'any',
          array(
              'key'   => '75',
              'value' => 'Astronomy'
          ),
          array(
              'key'   => '75',
              'value' => 'Biology'
          ),
          array(
              'key'   => '75',
              'value' => 'Chemestry'
          )
      )
  );
  $search_criteria['field_filters'][] = array( 'key' => $field_id, 'value' => $field_value );

  $entry_count = GFAPI::count_entries( /*$form_id*/112, $search_criteria );
  $add_column_data .= ' - ' . $entry_count;
  echo $entry_count;
  
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



function rise_document_status ($entry, $form, $output_type) {
  	$needs_review = 'true';
    $review_status_html = 'Incomplete<br>';
    $add_column_data = 'Incomplete ';
    $value = rgar( $entry, (string) $field->id );

    //RISE high school transcript 1
    if ($entry['108'] == 'true') {//received
      if ($entry['107'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $review_status_html .= '<li>Please review: <a href="' . $entry['135'] . '" target="_blank">' . $form['fields']['156']['label'] . '</a><br>';
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $review_status_html .= '<a href="' . $actual_link . '&approve_hs_transcript=true">Approve</a><br>';
      }
    }

    //RISE Standardized test scores
    if ($entry['128'] == 'true') {//received
      if ($entry['106'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $review_status_html .= '<li>Please review: <a href="' . $entry['136'] . '" target="_blank">' . $form['fields']['154']['label'] . '</a><br>';
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $review_status_html .= '<a href="' . $actual_link . '&approve_test_scores=true">Approve</a><br>';
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
//approve transcript
if ( $_GET['approve_hs_transcript'] == true ){
	$editentry = GFAPI::get_entry($_GET['lid']);
	$editentry['107'] = 'true';
	GFAPI::update_entry($editentry);
}
//approve test scores
if ( $_GET['approve_test_scores'] == true ){
	$editentry = GFAPI::get_entry($_GET['lid']);
	$editentry['106'] = 'true';
	GFAPI::update_entry($editentry);
}


function rise_recommendation_status ($entry, $form, $output_type) {
  	$needs_review = 'true';
    $review_status_html = 'Recommendations Incomplete<br>';
    $add_column_data = 'Recommendations Incomplete ';
    $value = rgar( $entry, (string) $field->id );
	
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
add_filter( 'gform_entry_detail_meta_boxes', 'add_actual_program_meta_box', 10, 3 );
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

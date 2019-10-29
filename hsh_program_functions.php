<?php
/*Custom Admin for HSH */
/********************************************************/
add_action( 'gform_entries_column', 'bu_summer_hsh_application_cols', 10, 5 );

function bu_summer_hsh_application_cols( $form_id, $field_id, $value, $entry, $query_string ) {

  //echo '<div>IDS: ' . $field_id . '<br>';

  switch ($form_id) {
    case '112':
      /*field 135 is the first student transcript
      use that to trigger the document status check*/
        if ( $field_id == 135 ) {
          $output_type = 'col_data';
          hsh_document_status($entry, $form, $output_type);
          //return;
        }
      //Actual Program
        if ( $field_id == 75 ) {
          HSHcountEntries($form_id, $entry, $field->id);
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

//HSH counselor recommendation
add_action("gform_after_submission_116", "HSHcounselRecHandler", 10, 2 );
function HSHcounselRecHandler($entry, $form){
    /*all we're doing right now is marking is at received*/
    
  if($_POST["input_63"]!==""){
    //get the actual entry we want to edit
      $editentry = GFAPI::get_entry($_POST["input_63"]);

      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }

     $editentry[127]='true';
      $updateit = GFAPI::update_entry($editentry);
  }

}

//HSH teacher recommendation
add_action("gform_after_submission_110", "HSHteacherRecHandler", 10, 2 );
function HSHteacherRecHandler($entry, $form){
    /*all we're doing right now is marking is at received*/
    /*var_dump($_POST);
    die();*/
  if($_POST["input_63"]!==""){
    //get the actual entry we want to edit
      $editentry = GFAPI::get_entry($_POST["input_63"]);

      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }

     $editentry[128]='true';
      $updateit = GFAPI::update_entry($editentry);
  }

}

/**
 * Add the meta box to the entry detail page.
 *
 * @param array $meta_boxes The properties for the meta boxes.
 * @param array $entry The entry currently being viewed/edited.
 * @param array $form The form object used to process the current entry.
 *
 * @return array
 */
function register_hsh_status_meta_box( $meta_boxes, $entry, $form ) {
  // If the add-on is active and the form has an active feed, add the meta box.
      if ($entry['form_id'] == 12) {
        $meta_boxes[ 'bu_status_and_decision' ] = array(
          'title'    => 'Status and Decision Buttons',
          'callback' => 'add_hsh_status_details_meta_box',
          'context'  => 'side',
          'callback_args' => array( $entry, $form ),
          );

          $meta_boxes[ 'add_hsh_document_approval_tools_meta_box' ] = array(
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

      }
      return $meta_boxes;
}
add_filter( 'gform_entry_detail_meta_boxes', 'register_hsh_status_meta_box', 10, 3 );

/**
* The callback used to echo the content to the meta box.
*
* @param array $args An array containing the form and entry objects.
*/

function add_hsh_status_details_meta_box( $args ) {

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

function add_hsh_document_approval_tools_meta_box ($args){

  $form  = $args['form'];
  $entry = $args['entry'];
  //var_dump($entry);
  //var_dump($form);

  $output_type = 'review_status';
  hsh_document_status($entry, $form, $output_type);
  hsh_recommendation_status($entry, $form, $output_type);

}



function hsh_document_status ($entry, $form, $output_type) {
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


function hsh_recommendation_status ($entry, $form, $output_type) {
    $needs_review = 'true';
    $review_status_html = 'Recommendations Incomplete<br>';
    $add_column_data = 'Recommendations Incomplete ';
    $value = rgar( $entry, (string) $field->id );
  
    if ($entry['127'] != '') {//received
      if ($entry['107'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $review_status_html .= 'Please review: <a href="?page=program_counsel_recommendations&application_id=' . $entry['id'] . '" target="_blank">' . $form['fields']['161']['label'] . '</a><br>';
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
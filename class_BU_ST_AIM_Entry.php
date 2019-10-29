<<<<<<< HEAD
<?php
  class BU_ST_AIM_Entry
{
  /*public $entry;
  public $form;
  public $age;
  */

  public function __construct($entry, $form)
  {
    //var_dump($entry);
    /*$this->entry = $entry;
    $this->form = $form;*/
  }



public function rise_document_status_page($application_id)
  {

  $search_criteria = array(
      'field_filters' => array(
        'mode' => 'any',
          array(
              'key'   => 'application_id',//application_id
              'value' => $application_id//passed id value
          ),
          array(
              'key'   => '41',//application_id
              'value' => $application_id//passed id value
          ),

      
  );
 // $search_criteria = array();
  $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
  $paging          = array( 'offset' => 0, 'page_size' => 25 );
  $total_count     = 0;
  $entries         = GFAPI::get_entries( 55, $search_criteria, $sorting, $paging, $total_count );
  $form = GFAPI::get_form($entries[0]['form_id']);

  foreach ($entries as $entry) {

    //transcript
      echo '<h4>' . $form['fields']['4']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['24'] . '; <a href="' . $entry['5'] . '" target="_blank">View </a></div>';

    //internationl data form
        echo '<h4>' . $form['fields']['10']['label'] . '</h4>';
        echo '<div><b>Status: </b>' . $entry['27'] . '; <a href="' . $entry['10'] . '" target="_blank">View </a></div>';
    //pasport
    echo '<h4>' . $form['fields']['9']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['23'] . '; <a href="' . $entry['8'] . '" target="_blank">View </a></div>';

      //english
    echo '<h4>' . $form['fields']['8']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['26'] . '; <a href="' . $entry['11'] . '" target="_blank">View </a></div>';

      //writing sample
    echo '<h4>' . $form['fields']['6']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['25'] . '; <a href="' . $entry['6'] . '" target="_blank">View </a></div>';

    echo '<div><a href="admin.php?page=gf_entries&view=entry&id=65&lid=' . $entry['id'] . '&order=ASC&filter&paged=1&pos=0&field_id&operator" target="_blank">View Original Entry</a></div>';
  }
  //var_dump($entries);

}

  public function rise_document_status($entry, $form, $output_type)
  {


    $needs_review = 'true';
    $review_status_html = '';
    $add_column_data = 'Incomplete ';
    $value = rgar( $entry, (string) $field->id );
    
    $application_id = $entry['id'];
    $application_entry = GFAPI::get_entry( $application_id );
      //var_dump($entry);
        $needs_review = 'true';
        $search_criteria = array(
            'field_filters' => array(
              'mode' => 'any',
                array(
                    'key'   => 'application_id',//application_id
                    'value' => $application_id//passed id value
                ),
                array(
                    'key'   => '41',//application_id
                    'value' => $application_id//passed id value
                ),

            )
        );
       // $search_criteria = array();
        $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
        $paging          = array( 'offset' => 0, 'page_size' => 25 );
        $total_count     = 0;
        $doc_entries         = GFAPI::get_entries( 55, $search_criteria, $sorting, $paging, $total_count );
        $doc_form =GFAPI::get_form(55);
       //var_dump( $doc_form['fields'] );
        //var_dump( $doc_entries );
        foreach ($doc_entries as $entry) {

          $review_status_html .= "<hr>";
          //var_dump($entry);
          //transcript file  entry field
          if ( $entry['5'] != '') {//hasn't been viewed
            if ( $entry['24'] == '' )
                $entry['24'] = 'Pending Review';
              if ($entry['24'] != "Approved" && $application_entry['107'] == 'true') {
                
              } else {
                  $review_status_html .= '<li>' . $entry['24'] . ': <a href="' . $entry['5'] . '" target="_blank">' . $doc_form['fields']['3']['label'] . '</a><br>';

                  $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['21']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

                  if ($entry['23'] == 'Approved') {
                   $review_status_html .= ' checked';
                 }
                 $review_status_html .= '> Approve<br>';


                $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['21']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
                if ($entry['23'] == 'Denied') {
                  $review_status_html .= ' checked';
                }
                
                $review_status_html .= '> Deny</a><br>';

              }
          } else {
            $review_status_html .= '<li>' . $doc_form['fields']['3']['label'] . ' Not Received<br>';
            $review_status_html .= '<input type="hidden" name="' . $doc_form['fields']['21']['adminLabel'] . '_' . $entry['id'] . '" value="">';

          }
          
          //writing sample
          if ( $entry['6'] != '' ) {
            if ( $entry['25'] == '' )
                $entry['25'] = 'Pending Review';

              if ($entry['25'] != "Approved" && $application_entry['107'] == 'true') {
                
              } else {
            $review_status_html .= '<li>' . $entry['25'] . ': <a href="' . $entry['13'] . '" target="_blank">' . $doc_form['fields']['5']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['22']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['25'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['22']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['25'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
            }
          } else {
            $review_status_html .= '<li>' . $doc_form['fields']['5']['label'] . ' Not Received<br>';
          }

          //passport
          if ( $entry['8'] != '' ) {
            if ( $entry['23'] == '' )
                $entry['23'] = 'Pending Review';

              if ($entry['23'] != "Approved" && $application_entry['107'] == 'true') {
                
              } else {
            $review_status_html .= '<li>' . $entry['23'] . ': <a href="' . $entry['8'] . '" target="_blank">' . $doc_form['fields']['8']['label'] . '</a><br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['20']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['23'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['20']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['23'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
            }
          } else {
            
            $review_status_html .= '<li>' . $doc_form['fields']['8']['label'] . ' Not Received<br>';
            

          }

          //english prof
          if ( $entry['11'] != '' ) {
            if ( $entry['26'] == '' )
                $entry['26'] = 'Pending Review';

              if ($entry['26'] != "Approved" && $application_entry['107'] == 'true') {
                
              } else {
            $review_status_html .= '<li>' . $entry['26'] . ': <a href="' . $entry['8'] . '" target="_blank">' . $doc_form['fields']['7']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['23']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['26'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['23']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['26'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
            }
          } else {
            
            $review_status_html .= '<li>' . $doc_form['fields']['7']['label'] . ' Not Received<br>';
            

          }

          //International Student data form
          if ( $entry['10'] != '' ) {
            if ( $entry['27'] == '' )
                $entry['27'] = 'Pending Review';

              if ($entry['27'] != "Approved" && $application_entry['107'] == 'true') {
                
              } else {
            $review_status_html .= '<li>' . $entry['27'] . ': <a href="' . $entry['10'] . '" target="_blank">' . $doc_form['fields']['9']['label'] . '</a><br>';

           $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['24']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['27'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['24']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['27'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
            }
          } else {
            
            $review_status_html .= '<li>' . $doc_form['fields']['9']['label'] . ' Not Received<br>';
            

          }

         

          //echo $review_status_html;
        //die();
      }
        //die();
      
    //}
    

  $entry = GFAPI::get_entry($application_id);
  //var_dump($entry);
  $review_status_html .= '<h4>Section Complete?</h4>
    <li><input type="radio" name="docs_approval_status" value="completed"';

    if ($entry['107'] == 'true') {
      $review_status_html .= ' checked';
    }
     

     $review_status_html .= '> Completed<br>
    <li><input type="radio" name="docs_approval_status" value="incomplete"';

    if ($entry['107'] != 'true') {
      $review_status_html .= ' checked';
    }
     

     $review_status_html .= '> Incomplete</a>';
      

      if ($output_type == 'review_status') {
        return $review_status_html;
      } else {
        return $add_column_data;
      }
  }


public function aim_update_documents ($entry, $form, $output_type) {
    //var_dump($_POST);
    $form = GFAPI::get_form(55);
    
    foreach ($_POST as $key => $value) {
      if ( strpos( $key, 'approve_hs_transcript') !== false ) {
        $entry_ID = str_replace('approve_hs_transcript_', '', $key);
      } elseif ( strpos( $key, 'hs_writing_sample_approved') !== false ) {
        $entry_ID = str_replace('hs_writing_sample_approved_', '', $key);
      }
      elseif ( strpos( $key, 'hs_english_proficiency_approved') !== false ) {
        $entry_ID = str_replace('hs_english_proficiency_approved_', '', $key);
      }
      elseif ( strpos( $key, 'hs_intl_student_data_form_approved') !== false ) {
        $entry_ID = str_replace('hs_intl_student_data_form_approved_', '', $key);
      }
      elseif ( strpos( $key, 'hs_passport_approved') !== false ) {
        $entry_ID = str_replace('hs_passport_approved_', '', $key);
      }

    }
    if (!isset($entry_ID)) 
      $application_id = $_POST['application_id'];

    $doc_entry = GFAPI::get_entry($entry_ID);
//die();
    foreach ($_POST as $key => $value) {
      if ($value == 'false') {
        $value = 'Denied';
      }
      if ($value == 'true') {
        $value = 'Approved';
      }
      if ( strpos( $key, 'approve_hs_transcript') !== false ) {
        $doc_entry['24'] = $value;
      }

      if ( strpos( $key, 'hs_writing_sample_approved') !== false ) {
        $doc_entry['25'] = $value;
      }
      if ( strpos( $key, 'hs_intl_student_data_form_approved') !== false ) {
        $doc_entry['27'] = $value;
      }
      if ( strpos( $key, 'hs_english_proficiency_approved') !== false ) {
        $doc_entry['26'] = $value;
      }
      if ( strpos( $key, 'hs_passport_approved') !== false ) {
        $doc_entry['23'] = $value;
      }
      /*if ( strpos( $key, 'hs_bank_statement_approved') !== false ) {
        $doc_entry['22'] = $value;
      }
      */

      //
    }
    GFAPI::update_entry($doc_entry);
    //var_dump($doc_entry);

  }


  public function rise_recommendation_status ($entry, $form, $output_type) {
    $needs_review = 'true';
    $rec_status_html = 'Recommendations Incomplete<br>';
    $rec_column_data = 'Recommendations Incomplete ';
    $value = rgar( $entry, (string) $field->id );
    //127 is counsel rec letter
    
    if ( $entry['105'] == 'true' && $entry['106'] == 'true' ){
      $rec_status_html = 'Recommendations Complete<br>';
      $rec_column_data = 'Recommendations Complete';
    }

/*die();*/

    //128 is teacher rec letter
    if ($entry['128'] != 'false') {//received
      if ($entry['106'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $rec_status_html .= 'Please review: <a href="?page=program_teacher_recommendations&application_id=' . $entry['id'] . '&form_id=' . $entry['form_id'] . '" target="_blank">Teacher Recommendation</a><br>';
        $rec_status_html .= '<input type="radio" name="program_teacher_recommendations" value="true"> Approve<br>';
        $rec_status_html .= '<input type="radio" name="program_teacher_recommendations" value="false" checked> Deny</a><br>';
      } else {//received but approved is false
        $needs_review = 'true';
        $rec_status_html .= 'Approved: <a href="?page=program_teacher_recommendations&application_id=' . $entry['id'] . '&form_id=' . $entry['form_id'] . '" target="_blank">Teacher Recommendation</a><br>';
        $rec_status_html .= '<input type="radio" name="program_teacher_recommendations" value="true" checked> Approve<br>';
        $rec_status_html .= '<input type="radio" name="program_teacher_recommendations" value="false"> Deny</a><br>';
      }
    }
    $rec_status_html .= sprintf( '<li><input type="hidden" value="%s" name="update_recs" /></li>', 'true', $action );

      if ($output_type == 'review_status') {
        return $rec_status_html;
      } else {
        return $rec_column_data;
      } 
  }
public function bu_program_essays_list() {

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

  $total_count     = 0;
  $entries         = GFAPI::get_entries( 10, $search_criteria, /*$sorting, $paging,*/ $total_count );
// $total_count now contains the total number of entries matching the search criteria. This is useful for displaying pagination controls.
  maybe_load_gf_entry_detail_class();
  foreach ($entries as $entry) {
    $form = GFAPI::get_form($entry['form_id']);
    //$entry = GFAPI::get_entry($entry['id']);
/*var_dump($entry);
var_dump($form['fields']);*/

    echo '<form>';
    echo '<H3>' . $form['fields']['75']->label . '</H3>';
    echo '<H4>' . $form['fields']['76']->label . '</H4>';
      echo '<p>' . $entry['92'];
      echo '</form>';

  }

}

public function rise_counselor_rec_page($entry, $form) {
    $rec_html = '';
    //var_dump($_GET['application_id']);
    //die();
    $search_criteria = array(
      'field_filters' => array(
        'mode' => 'any',
          array(
              'key'   => 'application_id',//application_id
              'value' => $_GET['application_id']//passed id value
          ),
          array(
              'key'   => '85',//application_id
              'value' => $_GET['application_id']//passed id value
          ),

      )
  );
 // $search_criteria = array();
  $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
  $paging          = array( 'offset' => 0, 'page_size' => 25 );
  $total_count     = 0;
  $entries         = GFAPI::get_entries( 58, $search_criteria, $sorting, $paging, $total_count );
  //var_dump($entries);
  // $total_count now contains the total number of entries matching the search criteria. This is useful for displaying pagination controls.
  maybe_load_gf_entry_detail_class();
  foreach ($entries as $entry) {
    $form = GFAPI::get_form($entry['form_id']);
    $entry = GFAPI::get_entry($entry['id']);
   //var_dump(GFEntryDetail::lead_detail_grid( $form, $entry ));
    $rec_html .= '<div class="wrap gf_browser_chrome"><form>';
      $rec_html .=  GFEntryDetail::lead_detail_grid( $form, $entry );
      $rec_html .= '</form></div>';

  }
  return $rec_html;
}


  public function rise_form_completion_status (/*$entry, $form, $output_type*/) {
    $doc_status = $this->rise_document_status($entry, $form, 'col_data');
    $rec_status = $this->rise_recommendation_status($entry, $form, 'col_data');
      
    if ($doc_status == 'Incomplete ' || $rec_status == 'Recommendations Incomplete ' || $entry['132'] > 3) {
      echo "Incomplete";
    }
      
  }
  
}
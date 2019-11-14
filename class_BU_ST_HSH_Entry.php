<?php
  class BU_ST_HSH_Entry
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


  public function rise_counselor_rec_page($entry, $form) {
    $rec_html = '';
    /*var_dump($entry);
var_dump($_GET['application_id']);*/
    //die();
    $search_criteria = array(
      'field_filters' => array(
        'mode' => 'any',
          array(
              'key'   => 'application_id',//application_id
              'value' => $_GET['application_id']//passed id value
          ),
          array(
              'key'   => '69',//application_id
              'value' => $_GET['application_id']//passed id value
          ),

      )
  );
 // $search_criteria = array();
  $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
  $paging          = array( 'offset' => 0, 'page_size' => 25 );
  $total_count     = 0;
  $entries         = GFAPI::get_entries( 59, $search_criteria, $sorting, $paging, $total_count );
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

public function rise_teacher_rec_page($entry, $form) {
    $rec_html = '';
/*var_dump($entry);
var_dump($_GET['application_id']);*/
    //die();
    $search_criteria = array(
      'field_filters' => array(
        'mode' => 'any',
          array(
              'key'   => 'application_id',//application_id
              'value' => $_GET['application_id']//passed id value
          ),
          array(
              'key'   => '71',//application_id
              'value' => $_GET['application_id']//passed id value
          ),

      )
  );
 // $search_criteria = array();
  $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
  $paging          = array( 'offset' => 0, 'page_size' => 25 );
  $total_count     = 0;
  $entries         = GFAPI::get_entries( 74, $search_criteria, $sorting, $paging, $total_count );
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
    if ($entry['127'] != 'false') {//received
      if ($entry['105'] != 'true'){//received but approved is false
        $needs_review = 'true';
        $rec_status_html .= 'Please review: <a href="?page=program_counsel_recommendations&application_id=' . $entry['id'] . '&form_id=' . $entry['form_id'] . '" target="_blank">Counselor Recommendation</a><br>';
        
        $rec_status_html .= '<input type="radio" name="program_counsel_recommendations" value="true"> Approve<br>';
        $rec_status_html .= '<input type="radio" name="program_counsel_recommendations" value="false" checked> Deny</a><br>';
      } else {
        $rec_status_html .= 'Approved: <a href="?page=program_counsel_recommendations&application_id=' . $entry['id'] . '&form_id=' . $entry['form_id'] . '" target="_blank">Counselor Recommendation</a><br>';
        
        $rec_status_html .= '<input type="radio" name="program_counsel_recommendations" value="true"  checked> Approve<br>';
        $rec_status_html .= '<input type="radio" name="program_counsel_recommendations" value="false"> Deny</a><br>';

      }
    }

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
                    'key'   => '32',//application_id
                    'value' => $application_id//passed id value
                ),

            )
        );
       // $search_criteria = array();
        $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
        $paging          = array( 'offset' => 0, 'page_size' => 25 );
        $total_count     = 0;
        $doc_entries         = GFAPI::get_entries( 38, $search_criteria, $sorting, $paging, $total_count );

//var_dump( $application_id );
  $form = GFAPI::get_form($doc_entries[0]['form_id']);
  //var_dump($form['fields']);
  foreach ($doc_entries as $entry) {
    //transcript
        //var_dump($entry);
      echo '<h4>' . $form['fields']['5']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['12'] . '; <a href="' . $entry['5'] . '" target="_blank">View </a></div>';
      
    //test scores
        echo '<h4>' . $form['fields']['7']['label'] . '</h4>';
        echo '<div><b>Status: </b>' . $entry['13'] . '; <a href="' . $entry['6'] . '" target="_blank">View </a></div>';
    //passport
    echo '<h4>' . $form['fields']['9']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['20'] . '; <a href="' . $entry['14'] . '" target="_blank">View </a></div>';

      //transcript
    echo '<h4>' . $form['fields']['3']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['21'] . '; <a href="' . $entry['5'] . '" target="_blank">View </a></div>';

      //bank
    echo '<h4>' . $form['fields']['12']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['22'] . '; <a href="' . $entry['12'] . '" target="_blank">View </a></div>';

      //fin sponser
    echo '<h4>' . $form['fields']['9']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['24'] . '; <a href="' . $entry['11'] . '" target="_blank">View </a></div>';

      //toefl
    echo '<h4>' . $form['fields']['11']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['22'] . '; <a href="' . $entry['13'] . '" target="_blank">View </a></div>';

    





    echo '<div><a href="admin.php?page=gf_entries&view=entry&id=65&lid=' . $entry['id'] . '&order=ASC&filter&paged=1&pos=0&field_id&operator" target="_blank">View Original Entry</a></div>';
  }
  //die();
  //var_dump($entries);

}

  public function rise_document_status($entry, $form, $output_type)
  {

    $needs_review = 'true';
    $review_status_html = '';
    $add_column_data = 'Incomplete ';
    $value = rgar( $entry, (string) $field->id );
    //var_dump($entry);
    //
    $application_id = $entry['id'];
    $application_entry = GFAPI::get_entry( $application_id );
    $this->bu_program_doc_recieved_status($application_entry);
//var_dump($application_entry);
    //HSH high school transcript 1
    
      //some aspect of the documents section is not Approved.
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
                    'key'   => '32',//application_id
                    'value' => $application_id//passed id value
                ),

            )
        );
       // $search_criteria = array();
        $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
        $paging          = array( 'offset' => 0, 'page_size' => 25 );
        $total_count     = 0;
        $doc_entries         = GFAPI::get_entries( 38, $search_criteria, $sorting, $paging, $total_count );
        $doc_form =GFAPI::get_form(38);
        //var_dump( $doc_form['fields'] );
        foreach ($doc_entries as $entry) {

          $review_status_html .= "<hr>";

          //transcript file  entry field

          if ( $entry['5'] != '') {//hasn't been viewed
            if ( $entry['21'] == '' )
                $entry['21'] = 'Pending Review';
              if ($entry['21'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
              $review_status_html .= '<li>' . $entry['21'] . ': <a href="' . $entry['5'] . '" target="_blank">' . $doc_form['fields']['3']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['20']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['21'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['20']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['21'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
          
            }

          } else {
            $review_status_html .= '<li>' . $doc_form['fields']['3']['label'] . ' Not Received<br>';

          }
          
          //test scores
          //var_dump($entry);
          if ( $entry['6'] != '' ) {
            if ( $entry['22'] == '' )
                $entry['22'] = 'Pending Review';

              if ($entry['22'] != "Approved" && $application_entry['107'] == 'true') {
                
              } else {
            $review_status_html .= '<li>' . $entry['22'] . ': <a href="' . $entry['6'] . '" target="_blank">' . $doc_form['fields']['4']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['18']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['22'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['18']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['22'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
            }
          } else {
            $review_status_html .= '<li>' . $doc_form['fields']['4']['label'] . ' Not Received<br>';
          }

          //passport
          if ( $entry['8'] != '' ) {
            if ( $entry['20'] == '' )
                $entry['20'] = 'Pending Review';

              if ($entry['20'] != "Approved" && $application_entry['107'] == 'true') {
                break;
              }
            $review_status_html .= '<li>' . $entry['20'] . ': <a href="' . $entry['8'] . '" target="_blank">' . $doc_form['fields']['6']['label'] . '</a><br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['19']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['20'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['19']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['20'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
          } else {
            
            $review_status_html .= '<li>' . $doc_form['fields']['6']['label'] . ' Not Received<br>';
            

          }

          //International Student data form
          if ( $entry['10'] != '' ) {
            if ( $entry['25'] == '' )
                $entry['25'] = 'Pending Review';

              if ($entry['25'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
            $review_status_html .= '<li>' . $entry['25'] . ': <a href="' . $entry['10'] . '" target="_blank">' . $doc_form['fields']['7']['label'] . '</a><br>';

           $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['24']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['25'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['24']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['25'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
            }
          } else {
            
            $review_status_html .= '<li>' . $doc_form['fields']['7']['label'] . ' Not Received<br>';
            

          }

          //Financial sponsorship
          if ( $entry['11'] != '' ) {
            if ( $entry['24'] == '' )
                $entry['24'] = 'Pending Review';

              if ($entry['24'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
            $review_status_html .= '<li>' . $entry['24'] . ': <a href="' . $entry['11'] . '" target="_blank">' . $doc_form['fields']['8']['label'] . '</a><br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['23']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['24'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['23']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['24'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
            }
          } else {
            
            $review_status_html .= '<li>' . $doc_form['fields']['8']['label'] . ' Not Received<br>';
            

          }

          //toefl
          if ( $entry['10'] != '' ) {
            if ( $entry['22'] == '' )
                $entry['22'] = 'Pending Review';
/*var_dump($entry);
die();*/
              if ($entry['22'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
            $review_status_html .= '<li>' . $entry['22'] . ': <a href="' . $entry['13'] . '" target="_blank">' . $doc_form['fields']['10']['label'] . '</a><br>';



            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['22']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['22'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['22']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['22'] == 'Denied') {
              $review_status_html .= ' checked';
            }

            $review_status_html .= '> Deny</a><br>';

            }
          } else {

            $review_status_html .= '<li>' . $doc_form['fields']['11']['label'] . ' Not Received<br>';

          }

          //bank statement
          if ( $entry['9'] != '' ) {
            if ( $entry['21'] == '' )
                $entry['21'] = 'Pending Review';

              if ($entry['21'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
              $review_status_html .= '<li>' . $entry['21'] . ': <a href="' . $entry['12'] . '" target="_blank">' . $doc_form['fields']['9']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['21']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['21'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['21']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['12'] == 'Denied') {
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



  public function bu_program_doc_recieved_status ($entry, $form) {
    //var_dump($entry);

    $application_id = $entry['id'];
    $application_entry = GFAPI::get_entry( $application_id );
    
    $search_criteria = array(
            'field_filters' => array(
              'mode' => 'any',
                array(
                    'key'   => 'application_id',//application_id
                    'value' => $application_id//passed id value
                ),
                array(
                    'key'   => '32',//application_id
                    'value' => $application_id//passed id value
                ),

            )
        );
       // $search_criteria = array();
        $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
        $paging          = array( 'offset' => 0, 'page_size' => 25 );
        $total_count     = 0;
        $doc_entries     = GFAPI::get_entries( 38, $search_criteria, $sorting, $paging, $total_count );
        $doc_form =GFAPI::get_form(38);
       //var_dump( $doc_form['fields'] );
        //var_dump( $doc_entries );
        $trans_recd = false;
        $tst_scores_recd = false;
        $paspt_recd = false;
        $idf_recd = false;
        $fin_sponsor_recd = false;
        $bank_statement_recd = false;
        $toefl_recd = false;
        
        foreach ($doc_entries as $doc_entry) {
//var_dump($doc_entry);

         if ( $doc_entry['5'] != '' && $trans_recd == false ) {
              $trans_recd = true;
              echo '5 true <br>';
            }
            //test scores
            if ( $doc_entry['6'] != '' && $tst_scores_recd == false ) {
              $tst_scores_recd = true;
              echo '6 true <br>';
            }
            //passport
            if ( $doc_entry['8'] != '' && $paspt_recd == false ) {
              $paspt_recd = true;
              echo '8 true <br>';
            }
            //interntaional student data form
            if ( $doc_entry['10'] != '' && $idf_recd == false ) {
              $idf_recd = true;
              echo '10 true <br>';
            }
            //financial sponorship
            if ( $doc_entry['11'] != '' && $fin_sponsor_recd == false ) {
              $fin_sponsor_recd = true;
              echo '11 true <br>';
            }
            //bank statement
            if ( $doc_entry['12'] != '' && $bank_statement_recd == false ) {
              $bank_statement_recd = true;
              echo '12 true <br>';
            }
            //toefl
            if ( $doc_entry['13'] != '' && $toefl_recd == false ) {
              $toefl_recd = true;
              echo '13 true <br>';
            }

      }

//var_dump($entry);
//die();
        $all_received = false;

        //if not intl only need trans and test scores
        if ($entry['8'] != 'intl') {
          if ( $trans_recd == true && $tst_scores_recd == true ) {
            $application_entry['245'] = 'True';
            $updateit = GFAPI::update_entry($application_entry);
          } else {
            $application_entry['245'] = 'False';
            $updateit = GFAPI::update_entry($application_entry);
          }
        } elseif ($entry['8'] == 'intl') {
          if ($trans_recd == true
                && $tst_scores_recd == true             
                && $paspt_recd == true
                && $idf_recd == true
                && $fin_sponsor_recd == true
                && $toefl_recd == true) {
            $application_entry['245'] = 'True';
            $updateit = GFAPI::update_entry($application_entry);
          } else {
            $application_entry['245'] = 'False';
            $updateit = GFAPI::update_entry($application_entry);
          }

          }
    
          /*$entry = GFAPI::get_entry( $application_id );
          var_dump($entry);
          die();*/

    }






public function hsh_update_documents ($entry, $form, $output_type) {
    //var_dump($_POST);
    $form = GFAPI::get_form(46);
    
    foreach ($_POST as $key => $value) {
      if ( strpos( $key, 'approve_hs_transcript') !== false ) {
        $entry_ID = str_replace('approve_hs_transcript_', '', $key);
      }

    }

    $doc_entry = GFAPI::get_entry($entry_ID);
    var_dump($doc_entry);
    foreach ($_POST as $key => $value) {
      if ($value == 'false') {
        $value = 'Denied';
      }
      if ($value == 'true') {
        $value = 'Approved';
      }
      

      if ( strpos( $key, 'approve_test_scores') !== false ) {
        $doc_entry['19'] = $value;
      }

      if ( strpos( $key, 'hs_passport_approved') !== false ) {
        $doc_entry['20'] = $value;
      }

      if ( strpos( $key, 'approve_hs_transcript') !== false ) {
        $doc_entry['21'] = $value;
      }

      if ( strpos( $key, 'hs_bank_statement_approved') !== false ) {
        $doc_entry['22'] = $value;
      }
      if ( strpos( $key, 'hs_toefl_approved') !== false ) {
        $doc_entry['23'] = $value;
      }
       if ( strpos( $key, 'hs_fin_sponser_approved') !== false ) {
        $doc_entry['24'] = $value;
      }
      
      if ( strpos( $key, 'hs_intl_student_data_form_approved') !== false ) {
        $doc_entry['25'] = $value;
      }
      
      
      
      

      //
    }
    GFAPI::update_entry($doc_entry);
/*var_dump($form['fields']);
    $doc_entry = GFAPI::get_entry($entry_ID);
var_dump($doc_entry);*/


   /* 'approve_hs_transcript_801' => string 'true' (length=4)
  'approve_test_scores_801' => string 'true' (length=4)
  'hs_passport_approved_801' => string 'true' (length=4)
  'hs_intl_student_data_form_approved_801' => string 'false' (length=5)
  'hs_fin_sponser_approved_801' => string 'true' (length=4)
  'hs_toefl_approved_801' => string 'false' (length=5)
  'hs_bank_statement_approved_801' => string 'false' (length=5)
  'docs_approval_status' => string 'incomplete' (length=10)*/
    /*foreach ($_POST as $key => $value) {
    $transcript_id = str_replace('approve_hs_transcript_', '', $key);
    $tests_id = str_replace('approve_test_scores_', '', $key);
    $trans = str_replace($key . '_', '', $key);


    $doc_entry = GFAPI::get_entry($transcript_id);
    $test_entry = GFAPI::get_entry($tests_id);
}*/

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
  $entries         = GFAPI::get_entries( 12, $search_criteria, /*$sorting, $paging,*/ $total_count );
// $total_count now contains the total number of entries matching the search criteria. This is useful for displaying pagination controls.
  maybe_load_gf_entry_detail_class();
  foreach ($entries as $entry) {
    $form = GFAPI::get_form($entry['form_id']);
    //$entry = GFAPI::get_entry($entry['id']);
/*var_dump($entry);
var_dump($form['fields']);
die();*/
/*var_dump($form['fields']);
die();*/
    echo '<form>';
    echo '<H3>' . $form['fields']['47']->label . '</H3>';
    echo '<H4>' . $form['fields']['48']->label . '</H4>';
      echo '<p>' . $entry['92'];
      echo '<H3>' . $form['fields']['61']->label . '</H3>';
      echo '<H4>' . $form['fields']['62']->label . '</H4>';
      echo '<p>' . $entry['92'];
      echo '<H4>' . $form['fields']['68']->label . '</H4>';
      echo '<p>' . $entry['94'];
      echo '</form>';

  }

}
  public function rise_form_completion_status (/*$entry, $form, $output_type*/) {
    $doc_status = $this->rise_document_status($entry, $form, 'col_data');
    $rec_status = $this->rise_recommendation_status($entry, $form, 'col_data');
      
    if ($doc_status == 'Incomplete ' || $rec_status == 'Recommendations Incomplete ' || $entry['132'] > 3) {
      echo "Incomplete";
    }
      
  }
  

}
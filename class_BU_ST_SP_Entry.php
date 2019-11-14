<?php
  class BU_ST_SP_Entry
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
              'key'   => '30',//application_id
              'value' => $application_id//passed id value
          ),

      )
  );
 // $search_criteria = array();
  $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
  $paging          = array( 'offset' => 0, 'page_size' => 25 );
  $total_count     = 0;
  $entries         = GFAPI::get_entries( 48, $search_criteria, $sorting, $paging, $total_count );
  $form = GFAPI::get_form($entries[0]['form_id']);

  foreach ($entries as $entry) {

    //transcript
      echo '<h4>' . $form['fields']['7']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['23'] . '; <a href="' . $entry['5'] . '" target="_blank">View </a></div>';

    //internationl data form
        echo '<h4>' . $form['fields']['10']['label'] . '</h4>';
        echo '<div><b>Status: </b>' . $entry['26'] . '; <a href="' . $entry['10'] . '" target="_blank">View </a></div>';
    //pasport
    echo '<h4>' . $form['fields']['9']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['24'] . '; <a href="' . $entry['8'] . '" target="_blank">View </a></div>';

      //english
    echo '<h4>' . $form['fields']['11']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['26'] . '; <a href="' . $entry['13'] . '" target="_blank">View </a></div>';

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
    $this->bu_program_doc_recieved_status($application_entry);

        $needs_review = 'true';
        $search_criteria = array(
            'field_filters' => array(
              'mode' => 'any',
                array(
                    'key'   => 'application_id',//application_id
                    'value' => $application_id//passed id value
                ),
                array(
                    'key'   => '30',//application_id
                    'value' => $application_id//passed id value
                ),

            )
        );
       // $search_criteria = array();
        $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
        $paging          = array( 'offset' => 0, 'page_size' => 25 );
        $total_count     = 0;
        $doc_entries         = GFAPI::get_entries( 46, $search_criteria, $sorting, $paging, $total_count );
        $doc_form =GFAPI::get_form(46);
       //var_dump( $doc_form['fields'] );
        //var_dump( $doc_entries );
        foreach ($doc_entries as $entry) {

          $review_status_html .= "<hr>";
//var_dump($application_entry['107']);
          //transcript file  entry field
          if ( $entry['5'] != '') {//hasn't been viewed
            if ( $entry['22'] == '' )
                $entry['22'] = 'Pending Review';
              if ($entry['22'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
              $review_status_html .= '<li>' . $entry['22'] . ': <a href="' . $entry['5'] . '" target="_blank">' . $doc_form['fields']['3']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['8']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['22'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['8']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['22'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';

            }
          } else {
            $review_status_html .= '<li>' . $doc_form['fields']['3']['label'] . ' Not Received<br>';

          }
          
          //english
          if ( $entry['13'] != '' ) {
            if ( $entry['24'] == '' )
                $entry['24'] = 'Pending Review';

              if ($entry['24'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
            $review_status_html .= '<li>' . $entry['24'] . ': <a href="' . $entry['13'] . '" target="_blank">' . $doc_form['fields']['5']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['10']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['24'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['10']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['24'] == 'Denied') {
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
                //break;
              } else {
            $review_status_html .= '<li>' . $entry['23'] . ': <a href="' . $entry['8'] . '" target="_blank">' . $doc_form['fields']['6']['label'] . '</a><br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['9']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['23'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['9']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['23'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';

            }
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

           $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['11']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['25'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['11']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['25'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
            }
          } else {
            
            $review_status_html .= '<li>' . $doc_form['fields']['7']['label'] . ' Not Received<br>';
            

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
                    'key'   => '31',//application_id
                    'value' => $application_id//passed id value
                ),

            )
        );
       // $search_criteria = array();
        $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
        $paging          = array( 'offset' => 0, 'page_size' => 25 );
        $total_count     = 0;
        $doc_entries     = GFAPI::get_entries( 48, $search_criteria, $sorting, $paging, $total_count );
        $doc_form =GFAPI::get_form(48);
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

         if ( $doc_entry['5'] != '' && $trans_recd == false ) {
              $trans_recd = true;
              echo '5 true <br>';
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
            //eng_proff
            if ( $doc_entry['13'] != '' && $toefl_recd == false ) {
              $toefl_recd = true;
              echo '13 true <br>';
            }
            //hslang
            
              $hslang = $doc_entry['37'];
              
      }

//var_dump($entry);
//die();
        $all_received = false;

        //if not intl only need trans and test scores
        if ($entry['8'] != 'intl' && $trans_recd == true ) {
          
            if ( $hslang == 'english' || $hslang == 'English' ) {
              $application_entry['335'] = 'True';
              $updateit = GFAPI::update_entry($application_entry);
            
            } else {

              if ( $toefl_recd == true ) {
                $application_entry['335'] = 'True';
                $updateit = GFAPI::update_entry($application_entry);
              } else {
                $application_entry['335'] = 'False';
                $updateit = GFAPI::update_entry($application_entry);
              }
            }
            

          } elseif ($entry['8'] == 'intl' && $trans_recd == true ) {
            
            if ( $paspt_recd == true || $idf_recd == true ) {
              if ( $hslang == 'english' || $hslang == 'English' ) {
                $application_entry['335'] = 'True';
                $updateit = GFAPI::update_entry($application_entry);
              
              } else {

                if ( $toefl_recd == true ) {
                  $application_entry['335'] = 'True';
                  $updateit = GFAPI::update_entry($application_entry);
                } else {
                  $application_entry['335'] = 'False';
                  $updateit = GFAPI::update_entry($application_entry);
                }
              }

            
            } else {
              $application_entry['335'] = 'False';
              $updateit = GFAPI::update_entry($application_entry);
            }


          }
      
    
          /*$entry = GFAPI::get_entry( $application_id );
          var_dump($entry);
          die();*/

    }

public function sp_update_documents ($entry, $form, $output_type) {
    //var_dump($_POST);
    $form = GFAPI::get_form(38);
    
    foreach ($_POST as $key => $value) {

      if ( strpos( $key, 'approve_hs_transcript') !== false ) {
        $entry_ID = str_replace('approve_hs_transcript_', '', $key);
      } elseif (strpos( $key, 'hs_passport_approved') !== false ) {
        $entry_ID = str_replace('hs_passport_approved_', '', $key);
      } elseif (strpos( $key, 'hs_intl_student_data_form_approved') !== false ) {
        $entry_ID = str_replace('hs_intl_student_data_form_approved_', '', $key);
      } elseif (strpos( $key, 'hs_english_proficiency_approved') !== false ) {
        $entry_ID = str_replace('hs_english_proficiency_approved_', '', $key);
      }

    }

    $doc_entry = GFAPI::get_entry($entry_ID);
    /*var_dump($_POST);
    var_dump($doc_entry);*/
//die();
    foreach ($_POST as $key => $value) {
      if ($value == 'false') {
        $value = 'Denied';
      }
      if ($value == 'true') {
        $value = 'Approved';
      }
      if ( strpos( $key, 'approve_hs_transcript') !== false ) {
        $doc_entry['22'] = $value;
      }

      if ( strpos( $key, 'hs_passport_approved') !== false ) {
        $doc_entry['23'] = $value;
      }
      if ( strpos( $key, 'hs_intl_student_data_form_approved') !== false ) {
        $doc_entry['25'] = $value;
      }
      if ( strpos( $key, 'hs_english_proficiency_approved') !== false ) {
        $doc_entry['24'] = $value;
      }
      /*if ( strpos( $key, 'hs_toefl_approved') !== false ) {
        $doc_entry['23'] = $value;
      }
      if ( strpos( $key, 'hs_bank_statement_approved') !== false ) {
        $doc_entry['22'] = $value;
      }
      */

      //
    }
    GFAPI::update_entry($doc_entry);
    //var_dump($doc_entry);
    

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
  $entries         = GFAPI::get_entries( 28, $search_criteria, /*$sorting, $paging,*/ $total_count );
// $total_count now contains the total number of entries matching the search criteria. This is useful for displaying pagination controls.
  maybe_load_gf_entry_detail_class();
  foreach ($entries as $entry) {
    $form = GFAPI::get_form($entry['form_id']);
    //$entry = GFAPI::get_entry($entry['id']);
var_dump($entry);
var_dump($form['fields']);
die();
/*var_dump($form['fields']);
die();*/
    echo '<form>';
    echo '<H3>' . $form['fields']['52']->label . '</H3>';
    echo '<H4>' . $form['fields']['53']->label . '</H4>';
      echo '<p>' . $entry['33'];
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
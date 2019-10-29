<?php
  class BU_ST_Rise_Entry
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
    
    //die();
    $search_criteria = array(
      'field_filters' => array(
        'mode' => 'any',
          array(
              'key'   => 'application_id',//application_id
              'value' => $_GET['application_id']//passed id value
          ),
          array(
              'key'   => '62',//application_id
              'value' => $_GET['application_id']//passed id value
          ),

      )
  );
 // $search_criteria = array();
  $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
  $paging          = array( 'offset' => 0, 'page_size' => 25 );
  $total_count     = 0;
  $entries         = GFAPI::get_entries( 78, $search_criteria, $sorting, $paging, $total_count );
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
              'key'   => '61',//application_id
              'value' => $_GET['application_id']//passed id value
          ),

      )
  );
 // $search_criteria = array();
  $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
  $paging          = array( 'offset' => 0, 'page_size' => 25 );
  $total_count     = 0;
  $entries         = GFAPI::get_entries( 66, $search_criteria, $sorting, $paging, $total_count );
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
    } else {
        $rec_status_html .= 'Approved: <a href="?page=program_teacher_recommendations&application_id=' . $entry['id'] . '&form_id=' . $entry['form_id'] . '" target="_blank">Counselor Recommendation</a><br>';
        
        $rec_status_html .= '<input type="radio" name="program_teacher_recommendations" value="true"  checked> Approve<br>';
        $rec_status_html .= '<input type="radio" name="program_teacher_recommendations" value="false"> Deny</a><br>';

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
              'key'   => '7',//application_id
              'value' => $application_id//passed id value
          ),

      )
  );
 // $search_criteria = array();
  $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
  $paging          = array( 'offset' => 0, 'page_size' => 25 );
  $total_count     = 0;
  $entries         = GFAPI::get_entries( 65, $search_criteria, $sorting, $paging, $total_count );
  //var_dump($entries);
  $form = GFAPI::get_form($entries[0]['form_id']);
  //var_dump($form['fields']);
  foreach ($entries as $entry) {
    //transcript
        
      echo '<h4>' . $form['fields']['5']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['12'] . '; <a href="' . $entry['5'] . '" target="_blank">View </a></div>';
      
    //test scores
        echo '<h4>' . $form['fields']['7']['label'] . '</h4>';
        echo '<div><b>Status: </b>' . $entry['13'] . '; <a href="' . $entry['6'] . '" target="_blank">View </a></div>';
    //pasport
    echo '<h4>' . $form['fields']['9']['label'] . '</h4>';
      echo '<div><b>Status: </b>' . $entry['14'] . '; <a href="' . $entry['8'] . '" target="_blank">View </a></div>';

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

        $needs_review = 'true';
        $search_criteria = array(
            'field_filters' => array(
              'mode' => 'any',
                array(
                    'key'   => 'application_id',//application_id
                    'value' => $application_id//passed id value
                ),
                array(
                    'key'   => '7',//application_id
                    'value' => $application_id//passed id value
                ),

            )
        );
       // $search_criteria = array();
        $sorting         = array( 'key' => '5', 'direction' => 'ASC' );
        $paging          = array( 'offset' => 0, 'page_size' => 25 );
        $total_count     = 0;
        $doc_entries         = GFAPI::get_entries( 65, $search_criteria, $sorting, $paging, $total_count );
        $doc_form =GFAPI::get_form(65);
       //var_dump( $doc_form['fields'] );
        //var_dump( $doc_entries );
        foreach ($doc_entries as $entry) {

          $review_status_html .= "<hr>";

          //transcript file  entry field
          if ( $entry['5'] != '') {//hasn't been viewed
            if ( $entry['13'] == '' )
                $entry['13'] = 'Pending Review';
              if ($entry['13'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
              $review_status_html .= '<li>' . $entry['13'] . ': <a href="' . $entry['5'] . '" target="_blank">' . $doc_form['fields']['4']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['8']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['13'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['8']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['13'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';

            }
          } else {
            $review_status_html .= '<li>' . $doc_form['fields']['4']['label'] . ' Not Received<br>';

          }
          
          //test scores
          if ( $entry['6'] != '' ) {
            if ( $entry['14'] == '' )
                $entry['14'] = 'Pending Review';

              if ($entry['14'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
            $review_status_html .= '<li>' . $entry['14'] . ': <a href="' . $entry['13'] . '" target="_blank">' . $doc_form['fields']['5']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['10']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['14'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['10']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['14'] == 'Denied') {
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
        //var_dump($add_column_data);
        return $add_column_data;
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
  $entries         = GFAPI::get_entries( 63, $search_criteria, /*$sorting, $paging,*/ $total_count );
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
    echo '<H3>' . $form['fields']['65']->label . '</H3>';
    echo '<H4>' . $form['fields']['66']->label . '</H4>';
      echo '<p>' . $entry['92'];
      echo '<H4>' . $form['fields']['67']->label . '</H4>';
      echo '<p>' . $entry['93'];
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
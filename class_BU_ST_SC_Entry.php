<?php
  class BU_ST_SC_Entry
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
              'key'   => '7',//application_id
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
        $doc_entries         = GFAPI::get_entries( 48, $search_criteria, $sorting, $paging, $total_count );
        $doc_form =GFAPI::get_form(48);
        //var_dump( $doc_form['fields'] );
        foreach ($doc_entries as $entry) {

$review_status_html .= "<hr>";

          //transcript file  entry field
          if ( $entry['5'] != '') {//hasn't been viewed
            if ( $entry['23'] == '' )
                $entry['23'] = 'Pending Review';
              if ($entry['23'] != "Approved" && $application_entry['107'] == 'true') {
                break;
              }
              $review_status_html .= '<li>' . $entry['23'] . ': <a href="' . $entry['5'] . '" target="_blank">' . $doc_form['fields']['7']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['15']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['23'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['15']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['13'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
          } else {
            $review_status_html .= '<li>' . $doc_form['fields']['3']['label'] . ' Not Received<br>';

          }
          
          //test scores
          if ( $entry['6'] != '' ) {
            if ( $entry['14'] == '' )
                $entry['14'] = 'Pending Review';

              if ($entry['14'] != "Approved" && $application_entry['107'] == 'true') {
                break;
              }
            $review_status_html .= '<li>' . $entry['14'] . ': <a href="' . $entry['6'] . '" target="_blank">' . $doc_form['fields']['4']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['13']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['14'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['13']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['14'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
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
            $review_status_html .= '<li>' . $entry['20'] . ': <a href="' . $entry['8'] . '" target="_blank">' . $doc_form['fields']['7']['label'] . '</a><br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['14']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['20'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['14']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['20'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
          } else {
            
            $review_status_html .= '<li>' . $doc_form['fields']['7']['label'] . ' Not Received<br>';
            

          }

          //International Student data form
          if ( $entry['10'] != '' ) {
            if ( $entry['25'] == '' )
                $entry['25'] = 'Pending Review';

              if ($entry['25'] != "Approved" && $application_entry['107'] == 'true') {
                break;
              }
            $review_status_html .= '<li>' . $entry['25'] . ': <a href="' . $entry['10'] . '" target="_blank">' . $doc_form['fields']['8']['label'] . '</a><br>';

           $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['19']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['25'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['19']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['25'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
          } else {
            
            $review_status_html .= '<li>' . $doc_form['fields']['8']['label'] . ' Not Received<br>';
            

          }

          //Financial sponsorship
          if ( $entry['11'] != '' ) {
            if ( $entry['24'] == '' )
                $entry['24'] = 'Pending Review';

              if ($entry['24'] != "Approved" && $application_entry['107'] == 'true') {
                break;
              }
            $review_status_html .= '<li>' . $entry['24'] . ': <a href="' . $entry['11'] . '" target="_blank">' . $doc_form['fields']['9']['label'] . '</a><br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['18']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['24'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['18']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['24'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
          } else {
            
            $review_status_html .= '<li>' . $doc_form['fields']['9']['label'] . ' Not Received<br>';
            

          }

          //toefl
          if ( $entry['13'] != '' ) {
            if ( $entry['23'] == '' )
                $entry['23'] = 'Pending Review';
/*var_dump($entry);
die();*/
              if ($entry['23'] != "Approved" && $application_entry['107'] == 'true') {
                break;
              }
            $review_status_html .= '<li>' . $entry['23'] . ': <a href="' . $entry['13'] . '" target="_blank">' . $doc_form['fields']['11']['label'] . '</a><br>';



            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['17']['adminLabel'] . '_' . $entry['id'] . '" value="true"';

            if ($entry['23'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['17']['adminLabel'] . '_' . $entry['id'] . '" value="false"';
            if ($entry['23'] == 'Denied') {
              $review_status_html .= ' checked';
            }

            $review_status_html .= '> Deny</a><br>';
          } else {

            $review_status_html .= '<li>Toefl?' . $doc_form['fields']['11']['label'] . ' Not Received<br>';

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
  $entries         = GFAPI::get_entries( 73, $search_criteria, /*$sorting, $paging,*/ $total_count );
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
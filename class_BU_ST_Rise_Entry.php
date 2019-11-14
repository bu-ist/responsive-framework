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
    //var_dump($entry);
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
          $trans_recd = false;
          $test_recd = false;
          $paspt_recd = false;
        foreach ($doc_entries as $doc_entry) {

          $review_status_html .= "<hr>";

          //transcript file  entry field
          if ( $doc_entry['5'] != '') {//hasn't been viewed
            if ( $doc_entry['13'] == '' )
                $doc_entry['13'] = 'Pending Review';
              if ($doc_entry['13'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
              $review_status_html .= '<li>' . $doc_entry['13'] . ': <a href="' . $doc_entry['5'] . '" target="_blank">' . $doc_form['fields']['4']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['8']['adminLabel'] . '_' . $doc_entry['id'] . '" value="true"';

            if ($doc_entry['13'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['8']['adminLabel'] . '_' . $doc_entry['id'] . '" value="false"';
            if ($doc_entry['13'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';

            }
          } else {
            $review_status_html .= '<li>' . $doc_form['fields']['4']['label'] . ' Not Received<br>';

          }
          
          //test scores
          if ( $doc_entry['6'] != '' ) {
            if ( $doc_entry['14'] == '' )
                $doc_entry['14'] = 'Pending Review';

              if ($doc_entry['14'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
            $review_status_html .= '<li>' . $doc_entry['14'] . ': <a href="' . $doc_entry['13'] . '" target="_blank">' . $doc_form['fields']['5']['label'] . '</a><br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['10']['adminLabel'] . '_' . $doc_entry['id'] . '" value="true"';

            if ($doc_entry['14'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['10']['adminLabel'] . '_' . $doc_entry['id'] . '" value="false"';
            if ($doc_entry['14'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';
            }
          } else {
            $review_status_html .= '<li>' . $doc_form['fields']['5']['label'] . ' Not Received<br>';
          }

          //passport
          if ( $doc_entry['8'] != '' ) {
            if ( $doc_entry['23'] == '' )
                $doc_entry['23'] = 'Pending Review';

              if ($doc_entry['23'] != "Approved" && $application_entry['107'] == 'true') {
                //break;
              } else {
            $review_status_html .= '<li>' . $doc_entry['23'] . ': <a href="' . $doc_entry['8'] . '" target="_blank">' . $doc_form['fields']['6']['label'] . '</a><br>';


            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['9']['adminLabel'] . '_' . $doc_entry['id'] . '" value="true"';

            if ($doc_entry['23'] == 'Approved') {
              $review_status_html .= ' checked';
            }
            $review_status_html .= '> Approve<br>';

            $review_status_html .= '<input type="checkbox" name="' . $doc_form['fields']['9']['adminLabel'] . '_' . $doc_entry['id'] . '" value="false"';
            if ($doc_entry['23'] == 'Denied') {
              $review_status_html .= ' checked';
            }
            
            $review_status_html .= '> Deny</a><br>';

            }
          } else {
            
            $review_status_html .= '<li>' . $doc_form['fields']['6']['label'] . ' Not Received<br>';
            
          }

            if ( $doc_entry['5'] != '' && $trans_recd == false ) {
              $trans_recd = true;
            }
            //test scores
            if ( $doc_entry['6'] != '' && $test_recd == false ) {
              $test_recd = true;
            }
            //passport
            if ( $doc_entry['8'] != '' && $paspt_recd == false ) {
              $paspt_recd = true;
            }


      }
  //////////////////////////////////////////////////////////////
  //var_dump($entry);
  $entry = GFAPI::get_entry($application_id);

          if ( $entry['169'] == 'us' ) {
    
            if ($trans_recd == true && $test_recd == true) {
              $entry['239'] = 'True';
              $updateit = GFAPI::update_entry($entry);
              //exit;
            }
          
          
            if ($trans_recd != true || $test_recd != true) {
                $entry['239'] = 'False';
                $updateit = GFAPI::update_entry($entry);
              }
          }



          if ( $entry['169'] == 'intl' ) {
  

            if ($trans_recd == true && $test_recd == true && $paspt_recd == true) {
              $entry['239'] = 'True';
              $updateit = GFAPI::update_entry($entry);
              //exit;
            }
          
          
          if ($trans_recd != true || $test_recd != true || $paspt_recd != true) {
              $entry['239'] = 'False';
              $updateit = GFAPI::update_entry($entry);
            }
        }
        
  //Check to see if required documents are Received
      
  $review_status_html .= '<h4>Required Docs Recieved?</h4>';

   $review_status_html .= '<div class="alert">' . $entry['239'] . '</div>';
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

 
  public function bu_program_essays_list($entry) {
    /*$gf_entry_locking = new GFEntryLocking();
    $gf_entry_locking->lock_info( $_GET['application_id'] );*/
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
//var_dump($entry);
  $total_count     = 0;
  $entries         = GFAPI::get_entries( 63, $search_criteria, /*$sorting, $paging,*/ $total_count );
 // var_dump($entries);
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
    //echo '<form>';
    echo '<div class="wrap gf_entry_wrap">';
echo '<h2 class="gf_admin_page_title">
          <span id="gform_settings_page_title" class="gform_settings_page_title gform_settings_page_title_editable">RISE Application</span>
          
          <span class="gf_admin_page_subtitle">
            <span class="gf_admin_page_formid">ID: 63</span>
          </span>

                  </h2>';
//echo GFForms::top_toolbar();

      RGForms::top_toolbar();
      ?>
      <div id="poststuff">
          <?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
          <?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>


          <div id="post-body" class="metabox-holder columns-2">
            <div id="post-body-content">
              <?php
              /**
               * Fires before the entry detail content is displayed
               *
               * @param array $form The Form object
               * @param array $lead The Entry object
               */
              do_action( 'gform_entry_detail_content_before', $form, $lead );
              
              /**
               * Fires when entry details are displayed
               *
               * @param array $form The Form object
               * @param array $lead The Entry object
               */
              do_action( 'gform_entry_detail', $form, $lead );
              ?>
            </div>

            <div id="postbox-container-1" class="postbox-container">

              <?php
              /**
               * Fires before the entry detail sidebar is generated
               *
               * @param array $form The Form object
               * @param array $lead The Entry object
               */
              do_action( 'gform_entry_detail_sidebar_before', $form, $lead );
              ?>
              <?php
              do_meta_boxes( $screen->id, 'side', array( 'form' => $form, 'entry' => $lead, 'mode' => $mode ) ); ?>

              <?php
              /**
               * Inserts information into the middle of the entry detail sidebar
               *
               * @param array $form The Form object
               * @param array $lead The Entry object
               */
              do_action( 'gform_entry_detail_sidebar_middle', $form, $lead );
              ?>

              <!-- begin print button -->
              <div class="detail-view-print">
                <a href="javascript:;" onclick="var notes_qs = jQuery('#gform_print_notes').is(':checked') ? '&notes=1' : ''; var url='<?php echo trailingslashit( site_url() ) ?>?gf_page=print-entry&fid=<?php echo absint( $form['id'] ) ?>&lid=<?php echo absint( $lead['id'] ); ?>' + notes_qs; window.open (url,'printwindow');" class="button"><?php esc_html_e( 'Print', 'gravityforms' ) ?></a>
                <?php if ( GFCommon::current_user_can_any( 'gravityforms_view_entry_notes' ) ) { ?>
                  <input type="checkbox" name="print_notes" value="print_notes" checked="checked" id="gform_print_notes" />
                  <label for="print_notes"><?php esc_html_e( 'include notes', 'gravityforms' ) ?></label>
                <?php } ?>
              </div>
              <!-- end print button -->
              <?php
              /**
               * Fires after the entry detail sidebar information.
               *
               * @param array $form The Form object
               * @param array $lead The Entry object
               */
              do_action( 'gform_entry_detail_sidebar_after', $form, $lead );
              ?>
            </div>

            <div id="postbox-container-2" class="postbox-container">
              <?php do_meta_boxes( $screen->id, 'normal', array( 'form' => $form, 'entry' => $lead, 'mode' => $mode ) ); ?>
              <?php
              /**
               * Fires after the entry detail content is displayed
               *
               * @param array $form The Form object
               * @param array $lead The Entry object
               */
              do_action( 'gform_entry_detail_content_after', $form, $lead );
              ?>
            </div>
          
          <?php echo '';
    echo '<H3>' . $form['fields']['65']->label . '</H3>';
    echo '<H4>' . $form['fields']['66']->label . '</H4>';
      echo '<p>' . $entry['92'];
      echo '<H4>' . $form['fields']['67']->label . '</H4>';
      echo '<p>' . $entry['93'];
      echo '<H4>' . $form['fields']['68']->label . '</H4>';
      echo '<p>' . $entry['94'];
      echo '</form>';
      ?>
      </div>
        </div>


<?php 
//echo '<div class="clear"></div>';

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


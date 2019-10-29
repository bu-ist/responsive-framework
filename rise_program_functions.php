<?php

include 'class_BU_ST_Rise_Entry.php';
include 'class_BU_ST_HSH_Entry.php';
include 'class_BU_ST_SC_Entry.php';
include 'class_BU_ST_SP_Entry.php';
include 'class_BU_ST_AIM_Entry.php';
add_filter( 'gform_toolbar_menu', 'my_custom_toolbar', 10, 2 );
function my_custom_toolbar( $menu_items, $form_id ) {
 
    $menu_items['my_custom_link'] = array(
        'label' => 'Documents', // the text to display on the menu for this link
        'title' => 'Documents', // the text to be displayed in the title attribute for this link
        'url' => self_admin_url( "admin.php?page=program_documents_page&application_id=" . $_GET['lid'] . "&form_id=" . $_GET['id']), // the URL this link should point to
        'menu_class' => 'gf_form_toolbar_custom_link', // optional, class to apply to menu list item (useful for providing a custom icon)
        /*'link_class' => rgget( 'page' ) == 'my_custom_page' ? 'gf_toolbar_active' : *,*/ // class to apply to link (useful for specifying an active style when this link is the current page)
        'capabilities' => array( 'gravityforms_edit_forms' ), // the capabilities the user should possess in order to access this page
        'priority' => 500 // optional, use this to specify the order in which this menu item should appear; if no priority is provided, the menu item will be append to end
    );
    $menu_items['essay_link'] = array(
        'label' => 'Essays', // the text to display on the menu for this link
        'title' => 'Essays', // the text to be displayed in the title attribute for this link
        'url' => self_admin_url( "admin.php?page=program_application_essays&application_id=" . $_GET['lid'] . "&form_id=" . $_GET['id']), // the URL this link should point to
        'menu_class' => 'gf_form_toolbar_custom_link', 
        'capabilities' => array( 'gravityforms_edit_forms' ), // the capabilities the user should possess in order to access this page
        'priority' => 500 // optional, use this to specify the order in which this menu item should appear; if no priority is provided, the menu item will be append to end
    );

    $menu_items['counselor_rec_link'] = array(
        'label' => 'Counselor Rec.', // the text to display on the menu for this link
        'title' => 'Counselor Rec.', // the text to be displayed in the title attribute for this link
        'url' => self_admin_url( "admin.php?page=program_counsel_recommendations&application_id=" . $_GET['lid'] . "&form_id=" . $_GET['id']), // the URL this link should point to
        'menu_class' => 'gf_form_toolbar_custom_link', // optional, class to apply to menu list item (useful for providing a custom icon)
        /*'link_class' => rgget( 'page' ) == 'my_custom_page' ? 'gf_toolbar_active' : *,*/ // class to apply to link (useful for specifying an active style when this link is the current page)
        'capabilities' => array( 'gravityforms_edit_forms' ), // the capabilities the user should possess in order to access this page
        'priority' => 500 // optional, use this to specify the order in which this menu item should appear; if no priority is provided, the menu item will be append to end
    );

    $menu_items['teacher_rec_link'] = array(
        'label' => 'Teacher Rec.', // the text to display on the menu for this link
        'title' => 'Teacher Rec.', // the text to be displayed in the title attribute for this link
        'url' => self_admin_url( "admin.php?page=program_teacher_recommendations&application_id=" . $_GET['lid'] . "&form_id=" . $_GET['id']), // the URL this link should point to
        'menu_class' => 'gf_form_toolbar_custom_link', // optional, class to apply to menu list item (useful for providing a custom icon)
        /*'link_class' => rgget( 'page' ) == 'my_custom_page' ? 'gf_toolbar_active' : *,*/ // class to apply to link (useful for specifying an active style when this link is the current page)
        'capabilities' => array( 'gravityforms_edit_forms' ), // the capabilities the user should possess in order to access this page
        'priority' => 500 // optional, use this to specify the order in which this menu item should appear; if no priority is provided, the menu item will be append to end
    );

    $menu_items['archive_link'] = array(
        'label' => 'Archive', // the text to display on the menu for this link
        'title' => 'Archive', // the text to be displayed in the title attribute for this link
        'url' => self_admin_url( "admin.php?page=notification_archive_page&application_id=" . $_GET['lid'] . "&form_id=" . $_GET['id']), // the URL this link should point to
        'menu_class' => 'gf_form_toolbar_custom_link', 
        'capabilities' => array( 'gravityforms_edit_forms' ), // the capabilities the user should possess in order to access this page
        'priority' => 500 // optional, use this to specify the order in which this menu item should appear; if no priority is provided, the menu item will be append to end
    );
 
    return $menu_items;
}

add_action( 'gform_pre_submission', 'bu_st_update_nickname' );
function bu_st_update_nickname( $form ) {
  if ( $form['id'] == '63' && $_POST['input_161'] == '' ){
    $_POST['input_161'] = $_POST['input_1_3'];
  }
  if ( $form['id'] == '12' && $_POST['input_163'] == '' ){
    $_POST['input_163'] = $_POST['input_1_3'];
  }
  if ( $form['id'] == '73' && $_POST['input_189'] == '' ){
    $_POST['input_189'] = $_POST['input_1_3'];
  }
  if ( $form['id'] == '28' && $_POST['input_169'] == '' ){
    $_POST['input_169'] = $_POST['input_1_3'];
  }
  if ( $form['id'] == '10' && $_POST['input_143'] == '' ){
    $_POST['input_143'] = $_POST['input_1_3'];
  }



}
/*$_POST/GET triggered functions */
/********************************************************/

//program admin decisions
if ( isset($_POST['update_admin']) && $_POST['update_admin'] == true ){
  /*var_dump($_POST);
  die();*/
  $editentry = GFAPI::get_entry($_GET['lid']);
  $editentry['75'] = $_POST['input_75'];
  $editentry['133'] = $_POST['input_133'];
  GFAPI::update_entry($editentry);
}

//approve documents
if ( isset($_POST['doc_entry_id']) && $_POST['doc_entry_id'] != '' ){
  /*var_dump($_POST);
  var_dump($_GET);
  die();*/

  if (  $_GET['id'] == 12 ) {
    $bu_rise_entry_obj = new BU_ST_HSH_Entry($doc_entry, $form);
    $bu_rise_entry_obj->hsh_update_documents($_POST);
  } elseif ($_GET['id'] == 28) {
    $bu_rise_entry_obj = new BU_ST_SP_Entry($doc_entry, $form);
    $bu_rise_entry_obj->sp_update_documents($_POST);
  } elseif ($_GET['id'] == 10) {
    $bu_rise_entry_obj = new BU_ST_AIM_Entry($doc_entry, $form);
    $bu_rise_entry_obj->aim_update_documents($_POST);
  } elseif ($_GET['id'] == 73) {
    $bu_rise_entry_obj = new BU_ST_SC_Entry($doc_entry, $form);
    $bu_rise_entry_obj->sc_update_documents($_POST);
  } else {
  foreach ($_POST as $key => $value) {
    $transcript_id = str_replace('approve_hs_transcript_', '', $key);
    $tests_id = str_replace('approve_test_scores_', '', $key);
    $trans = str_replace($key . '_', '', $key);


    $doc_entry = GFAPI::get_entry($transcript_id);
    $test_entry = GFAPI::get_entry($tests_id);

    if ( !is_wp_error( $doc_entry ) ) {




      //$doc_entry['13'] = 'Approved';
      if ( $doc_entry['form_id'] == 65 || $doc_entry['form_id'] == 38 || $doc_entry['form_id'] == 48) {
        if ($value == 'false') {
          /*var_dump($doc_entry);
          var_dump($value);*/
         $doc_entry['13'] = 'Denied';
          GFAPI::update_entry($doc_entry);
        } elseif($value == 'true') {
          /*var_dump($doc_entry);
          var_dump($value);*/
          $doc_entry['13'] = 'Approved';
          GFAPI::update_entry($doc_entry);
        } else {
          $doc_entry['13'] = '';
          GFAPI::update_entry($doc_entry);
        }
      }
    }


    if ( !is_wp_error( $test_entry ) ) {

      if ( $test_entry['form_id'] == 65 ) {
        if ($value == 'false') {
          /*var_dump($test_entry);
          var_dump($value);*/
          $test_entry['14'] = 'Denied';
          GFAPI::update_entry($test_entry);
        } elseif ($value == 'true') {
          /*var_dump($test_entry);
          var_dump($value);*/
          $test_entry['14'] = 'Approved';
          GFAPI::update_entry($test_entry);
        } else {
          $test_entry['14'] = '';
          GFAPI::update_entry($test_entry);
        }

      }
/*var_dump($test_entry);
die();*/
      if ( $test_entry['form_id'] == 38 ) {
        if ($value == 'false') {
          /*var_dump($test_entry);
          var_dump($value);*/
          $test_entry['19'] = 'Denied';
          GFAPI::update_entry($test_entry);
        } elseif ($value == 'true') {
          /*var_dump($test_entry);
          var_dump($value);*/
          $test_entry['19'] = 'Approved';
          GFAPI::update_entry($test_entry);
        } else {
          $test_entry['19'] = '';
          GFAPI::update_entry($test_entry);
        }

      }
    } 
  }
}
  //die();
  if ( isset( $_POST['docs_approval_status'] ) && $_POST['docs_approval_status'] == 'completed') {

    $editentry = GFAPI::get_entry($_GET['lid']);
/*var_dump($_GET);
var_dump($_POST);
var_dump($editentry);
$form = GFAPI::get_form(73);
var_dump($form['fields'][69]);
die();*/
    if ( $_GET['id'] == '73' ) {
      $editentry['334'] = 'true';
      GFAPI::update_entry($editentry);
    } else {

    $editentry['104'] = 'true';
    $editentry['130'] = 'true';
    $editentry['108'] = 'true';
    $editentry['107'] = 'true';
    GFAPI::update_entry($editentry);
    }
  }
  if ( isset( $_POST['docs_approval_status'] ) && $_POST['docs_approval_status'] == 'incomplete') {

    $editentry = GFAPI::get_entry($_GET['lid']);
    /*var_dump($_GET);
var_dump($_POST);
var_dump($editentry);
$form = GFAPI::get_form(73);
var_dump($form['fields'][69]);
die();*/
    if ( $_GET['id'] == '73' ) {
      $editentry['334'] = 'false';
      GFAPI::update_entry($editentry);
    } else {

    
    $editentry['104'] = 'false';
    $editentry['130'] = 'false';
    $editentry['108'] = 'false';
    $editentry['107'] = 'false';
    GFAPI::update_entry($editentry);
  }
  }
  
}



if (  isset($_POST['update_recs']) && $_POST['update_recs'] == true ){
  /*var_dump($_POST);
  var_dump($_GET);*/
  
  $editentry = GFAPI::get_entry($_GET['lid']);
/*var_dump($editentry);
  die();*/
  //set received to false
  if (isset($_POST['program_teacher_recommendations'])) {
    $editentry['106'] = $_POST['program_teacher_recommendations'];
  }
  if (isset($_POST['program_counsel_recommendations'])) {
   /* var_dump($editentry);
  die();*/
    $editentry['105'] = $_POST['program_counsel_recommendations'];
  }
  
  GFAPI::update_entry($editentry);
}


/*Custom Admin for RISE */
/********************************************************/
add_action( 'gform_entries_column', 'bu_summer_application_cols', 10, 5 );

function bu_summer_application_cols( $form_id, $field_id, $value, $entry, $query_string ) {

	switch ($form_id) {
		case '63':
			/*field 135 is the first student transcript
			use that to trigger the document status check*/
        $bu_rise_entry_obj = new BU_ST_Rise_Entry($entry, $form);
		    if ( $field_id == 135 ) {

		    	$output_type = 'col_data';
          $doc_status = $bu_rise_entry_obj->rise_document_status($entry, $form, $output_type);
          echo $doc_status;
		      //return;
		    }
        if ( $field_id == 103 ) {
          $output_type = 'col_data';
          //echo "really";
          $form_status = $bu_rise_entry_obj->rise_form_completion_status();
          echo $form_status;
          //return;
        }
        if ( $field_id == 127 ) {
          $output_type = 'col_data';
          $doc_status = $bu_rise_entry_obj->rise_document_status($entry, $form, $output_type);
          echo $doc_status;
          //return;
        }
			//Actual Program
		    if ( $field_id == 75 ) {
		      countEntries($form_id, $entry, $field->id);
          echo $add_column_data;
		      //return;
		    }

		    if ( $field_id == 73 ) {
		      $fields = GFAPI::get_fields_by_type( $form, array( 'fileupload' ) , true );

		    }
        if ( $field_id == 68 ) {
          if ($value != '') {
            echo 'Paid';
          } else {
            echo 'NA';
          }

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



/*
Adding menu pages
*/
/**
 * Adds a submenu page under a custom post type parent.
 */

function bu_st_recommendations_list_menu() {

    $menus[] = array( 'name' => 'program_teacher_recommendations', 'label' => __( 'Teacher Recommendations' ), 'callback' =>  'bu_teacher_recommendations_list' );
    $menus[] = array( 'name' => 'program_counsel_recommendations', 'label' => __( 'Counselor Recommendations' ), 'callback' =>  'bu_counsel_recommendations_list' );
    $menus[] = array( 'name' => 'program_application_essays', 'label' => __( 'Application Essays' ), 'callback' =>  'bu_program_essays_list' );
    $menus[] = array( 'name' => 'program_documents_page', 'label' => __( 'Application Documents' ), 'callback' =>  'rise_document_status_page' );

    $menus[] = array( 'name' => 'notification_archive_page', 'label' => __( 'Archives' ), 'callback' =>  'notification_archive' );
  return $menus;
}

/**
 * Display callback for the submenu page.
 */

/*$entry = GFAPI::get_entry($_GET["application_id"]);
  $bu_rise_entry_obj = new BU_ST_Rise_Entry($entry, $form);
  //var_dump($bu_rise_entry_obj->entry);
  $rec = $bu_rise_entry_obj->rise_recommendation_status($entry);
  */
  //var_dump($entry);
function bu_teacher_recommendations_list() {
  //include 'bu-st-recommendations-template.php';
  $entry = GFAPI::get_entry($_GET["application_id"]);
  //var_dump($entry);
  if ($entry['form_id'] == 63) {
    $bu_rise_entry_obj = new BU_ST_Rise_Entry($entry, $form);
   //$bu_rise_entry_obj->rise_counselor_rec_page($_GET["application_id"]);
    $bu_rise_entry_obj->rise_teacher_rec_page($_GET["application_id"]);
  }
  
  if ($entry['form_id'] == 12) {
    $bu_rise_entry_obj = new BU_ST_HSH_Entry($entry, $form);
    $bu_rise_entry_obj->rise_teacher_rec_page($_GET["application_id"]);
  }

  if ($entry['form_id'] == 10) {
    $bu_rise_entry_obj = new BU_ST_AIM_Entry($entry, $form);
    $bu_rise_entry_obj->rise_counselor_rec_page($_GET["application_id"]);
  }
  echo $rec_html;

}

/**
 * Display callback for the submenu page.
 */
function bu_counsel_recommendations_list() {
  $entry = GFAPI::get_entry($_GET["application_id"]);

  if ($entry['form_id'] == 63) {
    $bu_rise_entry_obj = new BU_ST_Rise_Entry($entry, $form);
    $bu_rise_entry_obj->rise_counselor_rec_page($_GET["application_id"]);
  }

  if ($entry['form_id'] == 12) {
    $bu_rise_entry_obj = new BU_ST_HSH_Entry($entry, $form);
    $bu_rise_entry_obj->rise_counselor_rec_page($_GET["application_id"]);
  }

  if ($entry['form_id'] == 10) {
    $bu_rise_entry_obj = new BU_ST_AIM_Entry($entry, $form);
    $bu_rise_entry_obj->rise_counselor_rec_page($_GET["application_id"]);
  }

  echo $rec_html;
    /*$search_criteria = array(
      'field_filters' => array(
        'mode' => 'any',
          array(
              'key'   => 'application_id',//application_id
              'value' => $_GET['application_id']//passed id value
          ),
          array(
              'key'   => '57',//application_id
              'value' => $_GET['application_id']//passed id value
          ),

      )
  );
  
  $entries         = GFAPI::get_entries( 66, $search_criteria );
  maybe_load_gf_entry_detail_class();
  foreach ($entries as $entry) {
    $form = GFAPI::get_form($entry['form_id']);
    $entry = GFAPI::get_entry($entry['id']);
   //var_dump(GFEntryDetail::lead_detail_grid( $form, $entry ));
    echo '<form>';
      echo GFEntryDetail::lead_detail_grid( $form, $entry );
      echo '</form>';

  }*/
  //echo GFEntryList::leads_page($entry['form_id']);

}



function bu_program_essays_list() {


  if ($_GET['form_id'] == 63) {
    $bu_rise_entry_obj = new BU_ST_Rise_Entry($entry, $form);
    $bu_rise_entry_obj->bu_program_essays_list($_GET["application_id"]);
  }

  if ($_GET['form_id'] == 12) {
    $bu_rise_entry_obj = new BU_ST_HSH_Entry($entry, $form);
    $bu_rise_entry_obj->bu_program_essays_list($_GET["application_id"]);
  }

  if ($_GET['form_id'] == 73) {
    $bu_rise_entry_obj = new BU_ST_SC_Entry($entry, $form);
    $bu_rise_entry_obj->bu_program_essays_list($_GET["application_id"]);
  }

  if ($_GET['form_id'] == 10) {
    $bu_rise_entry_obj = new BU_ST_AIM_Entry($entry, $form);
    $bu_rise_entry_obj->bu_program_essays_list($_GET["application_id"]);
  }







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

function rise_document_status_page(){
  $entry = GFAPI::get_entry($_GET["application_id"]);
  if ($entry['form_id'] == 63) {
    $bu_rise_entry_obj = new BU_ST_Rise_Entry($entry, $form);
    $bu_rise_entry_obj->rise_document_status_page($_GET["application_id"]);
  }

  if ($entry['form_id'] == 12) {
    $bu_rise_entry_obj = new BU_ST_HSH_Entry($entry, $form);
    $bu_rise_entry_obj->rise_document_status_page($_GET["application_id"]);
  }

  if ($entry['form_id'] == 73) {
    $bu_rise_entry_obj = new BU_ST_SC_Entry($entry, $form);
    $bu_rise_entry_obj->rise_document_status_page($_GET["application_id"]);
  }

  if ($entry['form_id'] == 10) {
    $bu_rise_entry_obj = new BU_ST_AIM_Entry($entry, $form);
    $bu_rise_entry_obj->rise_document_status_page($_GET["application_id"]);
  }

  echo $rec_html;
}

/*Collect data from secondary forms and feed into the main application*/
/********************************************************/

//RISE counselor recommendation
//add_action("gform_after_submission_74", "counselRecHandler", 10, 2 );
add_action("gform_after_submission_74", "counselRecHandler", 10, 2 );


function counselRecHandler($entry, $form){
  /*var_dump($_POST);
  die();*/
    /*all we're doing right now is marking is at received*/
	if($_POST["input_71"]!==""){
		//get the actual entry we want to edit
	    $editentry = GFAPI::get_entry($_POST["input_71"]);

	    if ( is_wp_error( $editentry ) ) {
	      echo "Error.";
	      die();
	    }

	   $editentry[127]='true';
      $updateit = GFAPI::update_entry($editentry);
	}

}
add_action("gform_after_submission_78", "hshcounselRecHandler", 10, 2 );
function hshcounselRecHandler($entry, $form){
  /*var_dump($_POST);
  die();*/
    /*all we're doing right now is marking is at received*/
  if($_POST["input_62"]!==""){
    //get the actual entry we want to edit
      $editentry = GFAPI::get_entry($_POST["input_62"]);

      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }

     $editentry[127]='true';
      $updateit = GFAPI::update_entry($editentry);
  }

}


//hsh upload

//RISE student upload form form 65
add_action("gform_after_submission_65", "studentUploadHandler", 10, 2 );
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
          	//var_dump($entry);
            /*var_dump( $input['id'] . ' ' . $field->id . ' ' . $field->lable);*/

              $value = rgar( $entry, (string) $field->id );
              switch (true) {
              	//$field->id == 5 //HS transcript
                case ($input['id'] == '1.8' &&  $field->id == 5):
                  //trans received
                
                  $editentry[135]=$value;
                  $editentry[108]='pending_review';
                  
                    //var_dump($value);
                  break;
                 //$field->id == 6 //standardized tesat scores
                case ($input['id'] == '1.8' &&  $field->id == 6):
                  //test scores received called supplemental upload 1?
                  $editentry[136]=$value;
                  $editentry[104]='pending_review';
                    //var_dump($value);
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


//AIM teacher rec
add_action("gform_after_submission_58", "aimTeachRecommendationHandler", 10, 2 );
function aimTeachRecommendationHandler($entry, $form){
    /*all we're doing right now is marking is at received*/
  /*var_dump($_POST);
  die();*/
  if($_POST["input_85"]!==""){
    //get the actual entry we want to edit
      $editentry = GFAPI::get_entry($_POST["input_85"]);
      //var_dump($editentry);
      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }

      $editentry['128']='true';
      $updateit = GFAPI::update_entry($editentry);
  } else {
    $editentry = GFAPI::get_entry($entry["input_85"]);
    //var_dump($editentry);
      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }
  }

}


//hsh teacher rec
add_action("gform_after_submission_59", "hshTeachRecommendationHandler", 10, 2 );
function hshTeachRecommendationHandler($entry, $form){
    /*all we're doing right now is marking is at received*/
/*var_dump($_POST);
  die();*/
  if($_POST["input_69"]!==""){
    //get the actual entry we want to edit
      $editentry = GFAPI::get_entry($_POST["input_69"]);
      //var_dump($editentry);
      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }

      $editentry['128']='true';
      $updateit = GFAPI::update_entry($editentry);
  } else {
    $editentry = GFAPI::get_entry($entry["input_69"]);
    //var_dump($editentry);
      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }
  }

}
//RISE science/math rec 66 teacher
add_action("gform_after_submission_66", "studentRecommendationHandler", 10, 2 );
function studentRecommendationHandler($entry, $form){
    /*all we're doing right now is marking is at received*/

/*var_dump($_POST);
  die();*/
  if($_POST["input_61"]!==""){
    //get the actual entry we want to edit
      $editentry = GFAPI::get_entry($_POST["input_61"]);
      //var_dump($editentry);
      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }

      $editentry['128']='true';
      $updateit = GFAPI::update_entry($editentry);
  } else {
    $editentry = GFAPI::get_entry($entry["input_61"]);
    //var_dump($editentry);
      if ( is_wp_error( $editentry ) ) {
        echo "Error.";
        die();
      }
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

  $entry_count = GFAPI::count_entries( /*$form_id*/63, $search_criteria );
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

add_action( 'gform_after_email', function( $is_success, $to, $subject, $message, $headers, $attachments, $message_format, $from, $from_name, $bcc, $reply_to, $entry ) {
  /*var_dump($entry);
  var_dump($message);*/
  //die();
  $current_user = wp_get_current_user();
  
  //rise forms
  if ( $entry['form_id'] == '65'
        || $entry['form_id'] == '84'
        || $entry['form_id'] == '78'
        || $entry['form_id'] == '66'
        )  {
    //$entry['7'] is the original application id - put note there
    RGFormsModel::add_note( $entry['7'], $current_user->ID, $current_user->display_name, $message );
  }

  /*RGFormsModel::add_note($_POST['lead_id'], $current_user->ID, $user_data->display_name, stripslashes($orig_message));*/
}, 10, 12 );


/*
RGFormsModel::add_note($_POST['lead_id'], $current_user->ID, $user_data->display_name, stripslashes($orig_message));
add_filter( 'gform_pre_send_email', function ( $email, $message_format, $notifications, $entry ) {
  //cancel sending emails
  //var_dump($email);
  //var_dump($message_format);
  //var_dump($notifications);
  //var_dump($entry);
  //$email['abort_email'] = false;
  $message = $notifications['subject'] . ' resent.';
  $current_user = wp_get_current_user();
  RGFormsModel::add_note( $entry['id'], $current_user->ID, $current_user->display_name, $message );
  return $email;
}, 10, 4 );
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
  //var_dump($entry);
      if ( $entry['form_id'] == 63 || $entry['form_id'] == 12 || $entry['form_id'] == 10 ) {
        $meta_boxes[ 'bu_status_and_decision' ] = array(
          'title'    => 'Status and Decision Buttons',
          'callback' => 'add_status_details_meta_box',
          'context'  => 'side',
          'callback_args' => array( $entry, $form ),
          );

          $meta_boxes[ 'bu_document_approval_tools' ] = array(
            'title'    => 'Documentation and Review',
            'callback' => 'meta_box_document_approval_tools',
            'context'  => 'side',
            'callback_args' => array( $entry, $form ),
            
          );

          $meta_boxes[ 'bu_recommendation_approval_tools' ] = array(
            'title'    => 'Review Recommendations',
            'callback' => 'meta_box_recommendation_tools',
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
      if ( $entry['form_id'] == 73 || $entry['form_id'] == 28 ) {
        $meta_boxes[ 'bu_status_and_decision' ] = array(
          'title'    => 'Status and Decision Buttons',
          'callback' => 'add_status_details_meta_box',
          'context'  => 'side',
          'callback_args' => array( $entry, $form ),
          );

          $meta_boxes[ 'bu_document_approval_tools' ] = array(
            'title'    => 'Documentation and Review',
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
add_filter( 'gform_entry_detail_meta_boxes', 'register_status_meta_box', 10, 3 );

/**
* The callback used to echo the content to the meta box.
*
* @param array $args An array containing the form and entry objects.
*/

function add_status_details_meta_box( $args ) {

	$form  = $args['form'];
	$entry = $args['entry'];

  //use get field
  // Passing the form object with the field id.
//$cur_field = GFAPI::get_field( $form, 133 );
/*foreach ( $form['fields'] as $field ) {
  if ($field['id'] == '133'){
//var_dump($field['choices']);
    foreach ($field['choices'] as $choices) {
      //var_dump($choices);
      $html .= '<option value="' . $choices['value']  . '">' . $choices['text']  . '</option>';
    }

  }
//var_dump($field);
}
 */
// Passing the form id with the field id.
//$cur_field = GFAPI::get_field( 2, 1 );
 
// Passing the form id with the input id.
//$cur_field = GFAPI::get_field( 2, '1.3' );
  
	//var_dump($entry);die();
	//personal statements and essays
	/*$html = '<li>Review <a href="?page=program_application_essays&application_id=' . $entry['id'] . '" target="_blank">Personal Statements</a>';*/
  //confirm gpa?

  //manaage application
  $html = '<form action="" method="post">';
  $html .= '<li>Administrative Decision:<BR><select name="input_133" id="input_133" class="medium_admin gfield_select" tabindex="373" aria-invalid="false">';
  foreach ( $form['fields'] as $field ) {
  if ($field['id'] == '133'){
/*var_dump($field['choices']);
var_dump($entry['133']);*/
    foreach ($field['choices'] as $choices) {
      //var_dump($choices);
      $html .= '<option value="' . $choices['value']  . '"';
      
      if ( $entry['133'] == $choices['value'] ) {
          $html .= ' selected';
      }

      $html .= '>' . $choices['text']  . '</option>';
    }

  }
//var_dump($field);
}
$html .= '</select></li>';
$html .= '<li>Actual Program:<BR><select name="input_75" id="input_75" class="medium_admin gfield_select" aria-invalid="false">';
foreach ( $form['fields'] as $field ) {
  if ($field['id'] == '75'){
//var_dump($field['choices']);
    foreach ($field['choices'] as $choices) {
      //var_dump($choices);
      $html .= '<option value="' . $choices['value']  . '"';
      
      if ( $entry['75'] == $choices['text'] ) {
          $html .= ' selected';
      }

      $html .= '>' . $choices['text']  . '</option>';
    }

  }
//var_dump($field);
}
$html .= '</select></li>';
 /* 
  if ($entry['75'] == "NA") {
    $html .= ' selected';
  }
  $html .= '>- N/A -</option>
  <option value="Astronomy"';
  if ($entry['75'] == "Astronomy") {
    $html .= ' selected';
  }
  $html .= '>Astronomy</option>
  <option value="Biology"';
  if ($entry['75'] == "Biology") {
    $html .= ' selected';
  }
  $html .= '>Biology</option>
  <option value="Chemestry"';
  if ($entry['75'] == "Chemestry") {
    $html .= ' selected';
  }
  $html .= '>Chemestry</option>
  </select></li>';*/
	
	$html .= sprintf( '<li><input type="hidden" value="%s" name="update_admin" /></li>', 'true', $action );
	$html .= sprintf( '<li><input type="submit" value="%s" class="button" onclick="jQuery(\'#action\').val(\'%s\');" /></li>', 'Update Status', $action );
  $html .= '</form>';


  echo $html;
}

function meta_box_document_approval_tools ($args){

  /*$form  = $args['form'];
  $entry = $args['entry'];*/
  /*var_dump($args['entry']);
  die();*/
  if ( $args['form']['id'] == 10 ) {
    $bu_rise_entry_obj = new BU_ST_AIM_Entry($args['entry'], $args['form']);
  }
  if ( $args['form']['id'] == 12 ) {
    $bu_rise_entry_obj = new BU_ST_HSH_Entry($args['entry'], $args['form']);
  }
  if ( $args['form']['id'] == 63 ) {
    $bu_rise_entry_obj = new BU_ST_Rise_Entry($args['entry'], $args['form']);
  }
  if ( $args['form']['id'] == 73 ) {
    $bu_rise_entry_obj = new BU_ST_SC_Entry($args['entry'], $args['form']);
  }
  if ( $args['form']['id'] == 28 ) {
    $bu_rise_entry_obj = new BU_ST_SP_Entry($args['entry'], $args['form']);
  }

  $output_type = 'review_status';
  echo "<h3>Documents Status</h3>";
  echo '<form action="" method="post">';
  echo '<input type="hidden" name="doc_entry_id" value="' . $args['entry']['id'] . '">';

  //rise_document_status($entry, $form, $output_type);
  $doc_status = $bu_rise_entry_obj->rise_document_status($args['entry'], $args['form'], $output_type);
  echo $doc_status;
 /* echo "<h3>Recommendations Status</h3>";
  $rec_status = $bu_rise_entry_obj->rise_recommendation_status($entry, $form, $output_type);
  echo $rec_status;*/
  $review_status_html .= sprintf( '<li><input type="submit" value="%s" class="button" onclick="jQuery(\'#action\').val(\'%s\');" /></li>', 'Update Document Status', $action );
  echo $review_status_html;
  echo "</form>";
  /*echo $review_status_html;
  echo $add_column_data;*/

}

function meta_box_recommendation_tools ($args){

  /*$form  = $args['form'];
  $entry = $args['entry'];*/
  /*var_dump($args['entry']);
  die();*/
  //var_dump($form);
  if ( $args['form']['id'] == 10 ) {
    $bu_rise_entry_obj = new BU_ST_AIM_Entry($args['entry'], $args['form']);
  }
  if ( $args['form']['id'] == 12 ) {
    $bu_rise_entry_obj = new BU_ST_HSH_Entry($args['entry'], $args['form']);
  }
  if ( $args['form']['id'] == 63 ) {
    $bu_rise_entry_obj = new BU_ST_Rise_Entry($args['entry'], $args['form']);
  }

  $output_type = 'review_status';
/*  echo "<h3>Documents Status</h3>";
  echo '<form action="" method="post">';
  echo '<input type="hidden" name="doc_entry_id" value="' . $args['entry']['id'] . '">';
  //rise_document_status($entry, $form, $output_type);
  $doc_status = $bu_rise_entry_obj->rise_document_status($args['entry'], $args['form'], $output_type);
  echo $doc_status;*/
  echo '<form action="" method="post">';
  echo '<input type="hidden" name="rec_entry_id" value="' . $args['entry']['id'] . '">';
  echo "<h3>Recommendations Status</h3>";
  $rec_status = $bu_rise_entry_obj->rise_recommendation_status($args['entry'], $form, $output_type);
  echo $rec_status;
  $review_status_html .= sprintf( '<li><input type="submit" value="%s" class="button" onclick="jQuery(\'#action\').val(\'%s\');" /></li>', 'Update Recommendations Status', $action );
  echo $review_status_html;
  echo "</form>";
  /*echo $review_status_html;
  echo $add_column_data;*/

}

add_action( 'gform_after_update_entry_63', 'copy_entry_to_program', 10, 2 );
//copies from rise form only
/*needs to check the field ids etc make to make sure it's an application move
NOTE: Need to update the application_id field in each of the the feeder forms - documents, recomendaions, intent letters, etc

?Add a new Form Status "new", "spam", "moved" or 'acrhived' for applications that got moved to another Program?

*/

function copy_entry_to_program( $form, $entry_id ){
  //var_dump( $form );
  //var_dump( $entry_id );
  $editentry = GFAPI::get_entry($entry_id);
 // var_dump($editentry);
  //die();
  $editentry['form_id'] = '10';//10 is currently AIM
  $editentry['1.3'] = 'Deedee';
  $editentry['1.6'] = 'Ramon';
 // $entry_id = GFAPI::add_entry($editentry);
  var_dump($entry_id);
  //die();

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

  $html = '<form action="" method="post">';

  $html .= '<P><B>Special Skills:</b><br>
  <textarea name="special_skills" id="input_141">' . $entry[141];
  $html .= '</textarea>
  <P><B>Concerns:</b><br>
  <textarea name="concerns" id="input_142">' . $entry[142];
  $html .= '</textarea>
  <P><B>Possible Matches:</b><br>
  <textarea name="possible_matches" id="input_143"> ' . $entry[143];
  $html .= '</textarea>';
  $html .= sprintf( '<li><input type="hidden" value="%s" name="bu_update_admin_assessment" /></li>', 'true', $action );
  $html .= sprintf( '<li><input type="submit" value="%s" class="button" onclick="jQuery(\'#action\').val(\'%s\');" /></li>', 'Update Status', $action );
  $html .= '</form>';


  echo $html;
  /*var_dump($entry);
  die();*/
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

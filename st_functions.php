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

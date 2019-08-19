<?php
/**
 * Template Name: Program Application Thank You Page
 *
 * @package Responsive_Framework
 */

/*var_dump($_SERVER['HTTP_X_FORWARDED_HOST']);
var_dump($_SERVER);*/
/*Updating entries directly form telegraph*/
GLOBAL $orig_message;
$editentry = GFAPI::get_entry($_GET['application_id']);
if ( !isset($_GET['form_id']) || $_GET['form_id'] == '') {
	//var_dump($editentry);
	$_GET['form_id'] = $editentry['form_id'];
	$form = GFAPI::get_form( $editentry['form_id'] );
} else {
	$form = GFAPI::get_form( $_GET['form_id'] );
}
$notifications_list = GFCommon::get_notifications_to_send( 'payment_updated', $form, $editentry );
$notification_id = $notifications_list['id'];
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers[] = 'From: ' . $notifications_list[0]['from'];
$headers[] = 'Reply-To: ' . $notifications_list[0]['from'];
$headers[] = 'X-Mailer: PHP/' . phpversion();

//$orig_message = preg_quote($notifications_list[0]['message']);
$orig_message = $notifications_list[0]['message'];
$replacement_array = array(
	);
//var_dump($orig_message);


//var_dump($notifications_list);
//die();
$i= 0;
//echo $orig_message;
if ($notifications_list[0]['bcc'] != '') {
	//need to do a regex check here for multiple extra emails
	$notifications_list[0]['bcc'] = $editentry['12'];//parentemail:12
}
/* Finds a colon before a closing }
preg_match('/:(.*?)}/s', $orig_message, $replacement_array, PREG_OFFSET_CAPTURE);
I need to find the last colon before a closing bracket
*/
while(preg_match('/:[0-9]+\.?[0-9]+}/s', $orig_message, $replacement_array, PREG_OFFSET_CAPTURE) == 1){
$i++;
	$replacement_array = array(
		);

	$t = preg_match('/:[0-9]+\.?[0-9]+}/s', $orig_message, $replacement_array, PREG_OFFSET_CAPTURE);
	//var_dump($replacement_array);
	//var_dump($notifications_list);
	//count backwards from here
	$entry_length = strlen($replacement_array[0][0]);
	//echo 'Entry length ' . $entry_length . "<br>";
	$entry_string = $replacement_array[0][0];
	//echo 'Entry String ' . $entry_string . "<br>";
	$entry_string = str_replace('}', '', $entry_string);
	//echo 'Entry String ' . $entry_string . "<br>";
	$entry_string = str_replace(':', '', $entry_string);
	//echo 'Entry String ' . $entry_string . "<br>";
	$index_of_string = $replacement_array[0][1];//int 28
	//echo 'Index of String ' . $index_of_string . "<br>";
	//get the whole replacement string
	$length_of_string = $entry_length + $index_of_string;
	//check in here for the opening {
	//echo "135" . $orig_message;
	$check_string = substr( $orig_message, 0, $length_of_string );
	//echo 'Check String: ' . $check_string . "<br>";
	$string_start = strrpos ( $check_string, '{',  0);
	//echo 'Index of { ' . $string_start . "<br>";
	$string_to_replace = substr( $check_string, $string_start );
	//echo 'String to replace ' . $string_to_replace . "<br>";
	$replace_with = '';
	/*echo 'Replace with $editentry[' . $entry_string . "]<br>";
	echo 'Replace with ' . $editentry[$entry_string] . "<br>";*/

/*
	echo 'Entry length Label ' . $entry_length_string . "<br>";
	$length_of_string = $end_of_string - $string_start + $entry_length + 1;
	$replacement_string = substr( $orig_message, $string_start, $length_of_string );
	var_dump($replacement_array);*/
	//echo '<h1>I ' . $i . "</H1>";
	/*echo '139 replacement_string ' . $replacement_string . "<br>";
	echo 'END 139 replacement_string<br><br><br>';
	var_dump($editentry[$entry_string]);
	
	echo 'String Length ' . $length_of_string . "<br>";


	echo $replacement_string . "<br>";
	echo 'String End ' . $entry_length_string . "<br>";
	die();*/
	$orig_message = str_replace($string_to_replace, $editentry[$entry_string], $orig_message);
	$orig_message = str_replace('{email:5}', $editentry['5'], $orig_message);
	$orig_message = str_replace('{phone:181}', $editentry['181'], $orig_message);
	$orig_message = str_replace('{phone:156}', $editentry['156'], $orig_message);
	$orig_message = str_replace('{entry_id}', $editentry['id'], $orig_message);
	$orig_message = str_replace('{referer}', 'www.bu.edu/summer', $orig_message);
	$orig_message = str_replace('{date_mdy}', date("F j, Y, g:i a"), $orig_message);
	$orig_message = str_replace('{Credit Card:36}', $_GET['creditCardLastFour'], $orig_message);
	$orig_message = str_replace('{Charged Amount:37}', $_GET['transactionTotalAmount'], $orig_message);
	$orig_message = str_replace('{Nelnet ID:38}', $_GET['NelnetID'], $orig_message);
	
	/*var_dump(preg_last_error());*/
	//echo '198 New Message ' . $orig_message . "<br>";
	if ($i > 150) {
	die();
	} else {
		$i++;
	}
}
//die();
/*var_dump($_GET['form_id']);
var_dump($editentry);*/
switch ($_GET['form_id']) {
	//AIM
	case '74':
	if ($editentry['2.1'] != '') {
		$comp_addr = strcasecmp( $editentry['2.1'], $_GET['address1'] );
	} else {
		$comp_addr = strcasecmp( $editentry['150.1'], $_GET['address1'] );
	}

		if (   $editentry['payment_status'] == null
			&& $editentry['payment_date'] == null
			&& $editentry['36'] == ''//cc number
			&& $editentry['37'] == ''//amount paid
			&& $editentry['38'] == ''//nelnet id
			&& $comp_addr == 0
			&& $editentry['5'] == $_GET['email'] ) {
				//if it seems copecetic, continue
				$editentry['payment_status'] = 'Yes';
				$editentry['payment_date'] = date('Y/m/d');
				$editentry['36']    = $_GET['creditCardLastFour'];
				$editentry['37']    = $_GET['transactionTotalAmount'];
				$editentry['38']    = $_GET['NelnetID'];

				if (GFAPI::update_entry($editentry)) {
				 
					$success_message = "<p>Thank you for your application to Boston University Summer Term High School Programs. We have received both your application form and your $50 application fee. Your payment has been processed.</p>
					<p>To complete your application, please use the following link to upload your supplemental materials.</p>
					<p><blockquote>
					<a href='/summer/high-school-programs/academic-immersion/apply/upload/?firstname=" . $editentry['1.3'] . "&lastname=" . $editentry['1.6'] . "&email=" . $editentry['5'] . "&application_id=" . $editentry['id'] . "'>UPLOAD SUPPLEMENTAL MATERIALS</a></blockquote></p>
					<p>Please note all supplemental materials should be submitted at the same time. <p>Once you submit all of your supplemental materials we will contact you with further information. If you have any questions, please <a href='https://www.bu.edu/summer/high-school-programs/contact-us.shtml'>contact us</a></p>
					<p>Here is the information we have for your records:</p>
					<blockquote>"  . 
						$editentry['1.3'] . " " . $editentry['1.6'] . "<br/>"
						 . $editentry['2.1'] . $editentry['150.1'] . "<br/>" 
						 . $editentry['2.2'] . $editentry['150.2'] . "<br/>"
						 . $editentry['2.3'] . " " . $editentry['2.4'] . " "
						 . $editentry['2.5'] . $editentry['150.3'] . " "
						 . $editentry['150.4'] . " "
						 . $editentry['150.5'] . "<br/>"
						 . $editentry['150.6'] . $editentry['2.6'] . "<br/>
						<br/>
						Phone: " . $editentry['181'] . "<br/>
						Email: " . $editentry['5'] . "<br/><br/>
						
						Recommending Teacher Name: " . $editentry['23.3'] . $editentry['23.5'] . "<br/><br />	
	Recommending Teacher Email: " . $editentry['24'] . "<br/>

    <p>High School Program: Academic Immersion</p>
					</blockquote>
					<p>Payment Information:</p>
						 <blockquote>
						Payment Date: " . $editentry['payment_date'] . "<br/>
						Credit Card: " . $editentry['36'] . "<br/>
						Amount: " . $editentry['37'] . "<br/>
						Nelnet ID: " . $editentry['38'] . "<br/>
						
					</blockquote>";
					$to_email = $editentry[$notifications_list[0]['to']];
					$mail_test = mail($to_email,
							$notifications_list[0]['subject'],
							$message, implode("\r\n", $headers) );

				} else {
					$success_message =  '<P>Unable to update entry.</P>';
				}

			} else {
				$success_message =  '<P>Looks like payment information has already been updated.</P>';
		}

		break;

	//AIM Partner
	case '72':
		if ($editentry['2.1'] != '') {
			$comp_addr = strcasecmp( $editentry['2.1'], $_GET['address1'] );
		} else {
			$comp_addr = strcasecmp( $editentry['150.1'], $_GET['address1'] );
		}

		if (  $editentry['36'] == ''//cc number
			&& $editentry['37'] == ''//amount paid
			&& $editentry['38'] == ''//nelnet id
			&& $editentry['5'] == $_GET['email'] ) {
				//if it seems copecetic, continue
				$editentry['payment_status'] = 'Yes';
				$editentry['payment_date'] = date('Y/m/d');
				$editentry['36']    = $_GET['creditCardLastFour'];
				$editentry['37']    = $_GET['transactionTotalAmount'];
				$editentry['38']    = $_GET['NelnetID'];

				if ( GFAPI::update_entry($editentry) ) {
				 
					$success_message = "<p>Thank you for your application to Boston University Summer Term High School Programs. We have received both your application form and your $50 application fee. Your payment has been processed.</p>
					<p>To complete your application, please use the following link to upload your supplemental materials.</p>
					<p><blockquote>
					<a href='/summer/high-school-programs/academic-immersion/apply/upload/?firstname=" . $editentry['1.3'] . "&lastname=" . $editentry['1.6'] . "&email=" . $editentry['5'] . "&application_id=" . $editentry['id'] . "'>UPLOAD SUPPLEMENTAL MATERIALS</a></blockquote></p>
					<p>Please note all supplemental materials should be submitted at the same time. <p>Once you submit all of your supplemental materials we will contact you with further information. If you have any questions, please <a href='https://www.bu.edu/summer/high-school-programs/contact-us.shtml'>contact us</a></p>
					<p>Here is the information we have for your records:</p>
					<blockquote>"  . 
						$editentry['1.3'] . " " . $editentry['1.6'] . "<br/>"
						 . $editentry['2.1'] . $editentry['150.1'] . "<br/>" 
						 . $editentry['2.2'] . $editentry['150.2'] . "<br/>"
						 . $editentry['2.3'] . " " . $editentry['2.4'] . " "
						 . $editentry['2.5'] . $editentry['150.3'] . " "
						 . $editentry['150.4'] . " "
						 . $editentry['150.5'] . "<br/>"
						 . $editentry['150.6'] . $editentry['2.6'] . "<br/>
						<br/>
						Phone: " . $editentry['181'] . "<br/>
						Email: " . $editentry['5'] . "<br/><br/>
						
						Recommending Teacher Name: " . $editentry['23.3'] . $editentry['23.5'] . "<br/><br />	
	Recommending Teacher Email: " . $editentry['24'] . "<br/>

    <p>High School Program: Academic Immersion</p>";
					/*$to_email = $editentry[$notifications_list[0]['to']];
					$mail_test = mail($to_email,
							$notifications_list[0]['subject'],
							$message, implode("\r\n", $headers) );*/

				} else {
					$success_message =  '<P>Unable to update entry.</P>';
				}

			} else {
				$success_message =  '<P>Looks like payment information has already been updated.</P>';
		}

		break;
	//summer challenge
	//case '22':
	case '73':
		/*var_dump($editentry);
		var_dump($headers);*/
		//var_dump($orig_message);
		/*var_dump($to_email);*/
		$mail_test = mail('djgannon@bu.edu',
							$notifications_list[0]['subject'],
							$orig_message, implode("\r\n", $headers) );
		if ( $editentry['payment_status'] != 'Yes'
			&& $editentry['payment_date'] == ''
			&& $editentry['36'] == ''
			&& $editentry['37'] == ''
			&& $editentry['38'] == ''//nelnet id
			&& $comp_addr == 0
			&& $editentry['5'] == $_GET['email'] ) {

				//if it seems copecetic, continue
				$editentry['payment_status'] = 'Yes';
				$editentry['payment_date'] = date('Y/m/d');
				$editentry['36']    = $_GET['creditCardLastFour'];
				$editentry['37']    = $_GET['transactionTotalAmount'];
				$editentry['38']    = $_GET['NelnetID'];

				if (GFAPI::update_entry($editentry)) {
				 //var_dump( $editentry );
					$success_message = "<p>Thank you for your application to Boston University Summer Term High School Programs. We have received both your application form and your $50 application fee. Your payment has been processed.</p>
					<p>To complete your application, please use the following link to upload your supplemental materials.</p>
					<p><blockquote>
					<a href='http://djgannon.cms-devl.bu.edu/summer/summer-challenge-supplemental-materials-upload/?firstname=" . $editentry['1.3'] . "&lastname=" . $editentry['1.6'] . "&email=" . $editentry['5'] . "&application_id=" . $editentry['id'] . "'>UPLOAD SUPPLEMENTAL MATERIALS</a></blockquote></p>
					<p>Please note all supplemental materials should be submitted at the same time. <p>Once you submit all of your supplemental materials we will contact you with further information. If you have any questions, please <a href='https://www.bu.edu/summer/high-school-programs/contact-us.shtml'>contact us</a></p>
					<p>Here is the information we have for your records:</p>
					<blockquote>" . 
						$editentry['1.3'] . " " . $editentry['1.6'] . "<br/>
						" . $editentry['2.1'] . "<br/>
						" . $editentry['2.2'] . "<br/>" . 
						$editentry['2.3'] . " " . $editentry['2.4'] . " " . $editentry['2.5'] . "<br/>
						" . $editentry['2.6'] . "<br/>
						<br/>
						Phone: " . $editentry['181'] . "<br/>
						Email: " . $editentry['5'] . "<br/><br/>
						
						High School Program: Summer Challenge
					</blockquote>
					<p>Payment Information:</p>
						 <blockquote>
						Payment Date: " . $editentry['payment_date'] . "<br/>
						Credit Card: " . $editentry['36'] . "<br/>
						Amount: " . $editentry['37'] . "<br/>
						Nelnet ID: " . $editentry['38'] . "<br/>
						
					</blockquote>";
					$success_message = $orig_message;
					
					/*//notifications_list
					//var_dump($notifications_list );
					$headers[] = 'MIME-Version: 1.0';
					$headers[] = 'Content-type: text/html; charset=iso-8859-1';

					// Additional headers
					$headers[] = 'To: ' . $notifications_list[0]['to'];
					$headers[] = 'From: ' . $notifications_list[0]['from'];
					$headers[] = 'Reply-To: ' . $notifications_list[0]['from'];
					$headers[] = 'X-Mailer: PHP/' . phpversion();
					
					
    				
    				$message = str_replace('{Name (First):1.3}', $editentry['1.3'], $notifications_list[0]['message']);
    				$message = str_replace('{entry_id}', $editentry['id'], $message);
    				$message = str_replace('{Name (Last):1.6}', $editentry['1.6'], $message);
    				$message = str_replace("{Applicant\'s Email:5}", $editentry['5'], $message);
    				$message = str_replace("{Address (Street Address):2.1}", $editentry['2.1'], $message);
    				$message = str_replace("{Address (Street Address):150.1}", $editentry['150.1'], $message);
    				$message = str_replace("{Address (Address Line 2):2.2}", $editentry['2.2'], $message);
    				$message = str_replace("{Address (Address Line 2):150.2}", $editentry['250.2'], $message);
    				$message = str_replace("{Address (city):2.3}", $editentry['2.3'], $message);
    				$message = str_replace("{Address (City):150.3}", $editentry['150.3'], $message);

    				$message = str_replace("{Address (State / Province):2.4}", $editentry['2.4'], $message);
    				$message = str_replace("{Address (State / Province):150.4}", $editentry['150.4'], $message);

    				$message = str_replace("{Address (ZIP / Postal Code):2.5}", $editentry['2.5'], $message);
    				$message = str_replace("{Address (ZIP / Postal Code):150.5}", $editentry['150.5'], $message);

    				$message = str_replace("{Home Phone:181}", $editentry['181'], $message);
    				
    				*/

    				$to_email = $editentry[$notifications_list[0]['to']];
					$mail_test = mail($to_email,
							$notifications_list[0]['subject'],
							$orig_message, implode("\r\n", $headers) );
					$mail_test = mail('djgannon@bu.edu',
							$notifications_list[0]['subject'],
							$orig_message, implode("\r\n", $headers) );

				} else {
					$success_message =  '<P>Unable to update entry.</P>';
				}

			} else {
				$success_message =  '<P>Looks like payment information has already been updated.</P>';
		}

		break;

	//honors
	case '75':
		/*var_dump($orig_message);
		var_dump($notifications_list);*/
		if ($editentry['2.1'] != '') {
			$comp_addr = strcasecmp( $editentry['2.1'], $_GET['address1'] );
		} else {
			$comp_addr = strcasecmp( $editentry['161.1'], $_GET['address1'] );
		}
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';

		// Additional headers
		$headers[] = 'From: ' . $notifications_list[0]['from'];
		$headers[] = 'Reply-To: ' . $notifications_list[0]['from'];
		$headers[] = 'X-Mailer: PHP/' . phpversion();
		$mail_test = mail('djgannon@bu.edu',
							$notifications_list[0]['subject'],
							$orig_message, implode("\r\n", $headers) );
		if ( $editentry['payment_status'] != 'Yes'
			&& $editentry['payment_date'] == ''
			&& $editentry['36'] == ''
			&& $editentry['37'] == ''
			&& $editentry['38'] == ''//nelnet id
			&& $comp_addr == 0
			&& $editentry['5'] == $_GET['email'] ) {

				//if it seems copecetic, continue
				$editentry['payment_status'] = 'Yes';
				$editentry['payment_date'] = date('Y/m/d');
				$editentry['36']    = $_GET['creditCardLastFour'];
				$editentry['37']    = $_GET['transactionTotalAmount'];
				$editentry['38']    = $_GET['NelnetID'];

				if (GFAPI::update_entry($editentry)) {
				 //var_dump( $editentry );
					$success_message = $orig_message;

    				$to_email = $editentry[$notifications_list[0]['to']];
					$mail_test = mail($to_email,
							$notifications_list[0]['subject'],
							$orig_message, implode("\r\n", $headers) );
					$mail_test = mail('djgannon@bu.edu',
							$notifications_list[0]['subject'],
							$orig_message, implode("\r\n", $headers) );

				} else {
					$success_message =  '<P>Unable to update entry.</P>';
				}

			} else {
				$success_message =  '<P>Looks like payment information has already been updated.</P>';
		}

		break;

		//Preview
		case '79':
			/*var_dump($orig_message);
			var_dump($notifications_list);*/
			if ($editentry['2.1'] != '') {
				$comp_addr = strcasecmp( $editentry['2.1'], $_GET['address1'] );
			} else {
				$comp_addr = strcasecmp( $editentry['161.1'], $_GET['address1'] );
			}
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=iso-8859-1';

			// Additional headers
			$headers[] = 'From: ' . $notifications_list[0]['from'];
			$headers[] = 'Reply-To: ' . $notifications_list[0]['from'];
			$headers[] = 'X-Mailer: PHP/' . phpversion();
			$mail_test = mail('djgannon@bu.edu',
								$notifications_list[0]['subject'],
								$orig_message, implode("\r\n", $headers) );
			if ( $editentry['payment_status'] != 'Yes'
				&& $editentry['payment_date'] == ''
				&& $editentry['36'] == ''
				&& $editentry['37'] == ''
				&& $editentry['38'] == ''//nelnet id
				&& $comp_addr == 0
				&& $editentry['5'] == $_GET['email'] ) {

					//if it seems copecetic, continue
					$editentry['payment_status'] = 'Yes';
					$editentry['payment_date'] = date('Y/m/d');
					$editentry['36']    = $_GET['creditCardLastFour'];
					$editentry['37']    = $_GET['transactionTotalAmount'];
					$editentry['38']    = $_GET['NelnetID'];

					if (GFAPI::update_entry($editentry)) {
					 //var_dump( $editentry );
						$success_message = $orig_message;

	    				$to_email = $editentry[$notifications_list[0]['to']];
						$mail_test = mail($to_email,
								$notifications_list[0]['subject'],
								$orig_message, implode("\r\n", $headers) );
						$mail_test = mail('djgannon@bu.edu',
								$notifications_list[0]['subject'],
								$orig_message, implode("\r\n", $headers) );

					} else {
						$success_message =  '<P>Unable to update entry.</P>';
					}

				} else {
					$success_message =  '<P>Looks like payment information has already been updated.</P>';
			}

			break;

	//SSIP
	case '37':

		

		if ($editentry['payment_status'] != 'Yes'
			&& $editentry['payment_date'] == ''
			&& $editentry['36'] == ''
			&& $editentry['37'] == ''
			&& $editentry['38'] == ''
			&& $comp_addr == 0
			&& $editentry['5'] == $_GET['email']) {

				//if it seems copecetic, continue
				$editentry['payment_status'] = 'Yes';
				$editentry['payment_date'] = date('Y/m/d');
				$editentry['36']    = $_GET['creditCardLastFour'];
				$editentry['37']    = $_GET['transactionTotalAmount'];
				$editentry['38']    = $_GET['NelnetID'];

				if (GFAPI::update_entry($editentry)) {
				 //var_dump( $editentry );
					$success_message = "<p>Thank you for your application to the Boston University Summer Study Internship Program. Your application has been submitted and your $50 application fee payment has been processed.</p>
					 
					  <p>Here is the information we have for your records:</p>
					  <blockquote>" . 
						$editentry['199'] . " " . $editentry['201'] . "<br/>
						" . $editentry['2.1']  . $editentry['206.1'] . "<br/>
						" . $editentry['2.2'] . $editentry['206.2'] .  "<br/>" . 
						$editentry['2.3'] . $editentry['206.3'] . " " . $editentry['2.4'] . $editentry['206.4'] . " " . $editentry['2.5'] . $editentry['206.5'] . "<br/>
						" . $editentry['2.6'] . $editentry['206.6']. "<br/>
						<br/>
						Cell Phone: " . $editentry['214'] . "<br/>
						Email: " . $editentry['5'] . "<br/><br/>
					</blockquote>
					<p>Payment Information:</p>
						 <blockquote>
						Payment Date: " . $editentry['payment_date'] . "<br/>
						Credit Card: " . $editentry['36'] . "<br/>
						Amount: " . $editentry['37'] . "<br/>
						Nelnet ID: " . $editentry['38'] . "<br/>
						
					</blockquote>
						</p>";

						$to_email = $editentry[$notifications_list[0]['to']];
						$mail_test = mail($to_email,
							$notifications_list[0]['subject'],
							$message, implode("\r\n", $headers) );


				} else {
					$success_message =  '<P>Unable to update entry.</P>';
				}

			} else {
				$success_message =  '<P>Looks like payment information has already been updated.</P>';
		}

		break;

	//international
	case '44':

		if ($editentry['payment_status'] != 'Yes'
			&& $editentry['payment_date'] == ''
			&& $editentry['36'] == ''
			&& $editentry['37'] == ''
			&& $editentry['38'] == ''
			&& $comp_addr == 0
			&& $editentry['5'] == $_GET['email'] ) {

				//if it seems copecetic, continue
				$editentry['payment_status'] = 'Yes';
				$editentry['payment_date'] = date('Y/m/d');
				$editentry['36']    = $_GET['creditCardLastFour'];
				$editentry['37']    = $_GET['transactionTotalAmount'];
				$editentry['38']    = $_GET['NelnetID'];

				if (GFAPI::update_entry($editentry)) {
				 //var_dump( $editentry );
					$success_message = "<p>Thank you for your application to the Boston University Summer Study Internship Program. Your application has been submitted and your $50 application fee payment has been processed.</p>
					 
					  <p>Here is the information we have for your records:</p>
					  <blockquote>" . 
						$editentry['386'] . " " . $editentry['387'] . "<br/>
						" . $editentry['2.1']  . $editentry['206.1'] . "<br/>
						" . $editentry['2.2'] . $editentry['206.2'] .  "<br/>" . 
						$editentry['2.3'] . $editentry['206.3'] . " " . $editentry['2.4'] . $editentry['206.4'] . " " . $editentry['2.5'] . $editentry['206.5'] . "<br/>
						" . $editentry['2.6'] . $editentry['206.6']. "<br/>
						<br/>
						Cell Phone: " . $editentry['4'] . "<br/>
						Email: " . $editentry['5'] . "<br/><br/>
						
						High School Program: International Student
					</blockquote>
					<p>Payment Information:</p>
						 <blockquote>
						Payment Date: " . $editentry['payment_date'] . "<br/>
						Credit Card: " . $editentry['36'] . "<br/>
						Amount: " . $editentry['37'] . "<br/>
						Nelnet ID: " . $editentry['38'] . "<br/>
						
					</blockquote>
						</p>";
						$to_email = $editentry[$notifications_list[0]['to']];
						$mail_test = mail($to_email,
							$notifications_list[0]['subject'],
							$message, implode("\r\n", $headers) );


				} else {
					$success_message =  '<P>Unable to update entry.</P>';
				}

			} else {
				$success_message =  '<P>Looks like payment information has already been updated.</P>';
		}

		break;

		//RISE
	case '63':

		if ($editentry['payment_status'] != 'Yes'
			&& $editentry['payment_date'] == ''
			&& $editentry['36'] == ''
			&& $editentry['37'] == ''
			&& $editentry['38'] == ''
			&& $comp_addr == 0
			&& $editentry['5'] == $_GET['email'] ) {

				//if it seems copecetic, continue
				

				if (GFAPI::update_entry($editentry)) {
				 //var_dump( $editentry );
					$success_message = "<p>Thank you for your application to the Boston University Summer Study Internship Program. Your application has been submitted and your $50 application fee payment has been processed.</p>
					 
					  <p>Here is the information we have for your records:</p>
					  <blockquote>" . 
						$editentry['386'] . " " . $editentry['387'] . "<br/>
						" . $editentry['2.1']  . $editentry['206.1'] . "<br/>
						" . $editentry['2.2'] . $editentry['206.2'] .  "<br/>" . 
						$editentry['2.3'] . $editentry['206.3'] . " " . $editentry['2.4'] . $editentry['206.4'] . " " . $editentry['2.5'] . $editentry['206.5'] . "<br/>
						" . $editentry['2.6'] . $editentry['206.6']. "<br/>
						<br/>
						Cell Phone: " . $editentry['4'] . "<br/>
						Email: " . $editentry['5'] . "<br/><br/>
						
						High School Program: International Student
					</blockquote>
					<p>Payment Information:</p>
						 <blockquote>
						Payment Date: " . $editentry['payment_date'] . "<br/>
						Credit Card: " . $editentry['36'] . "<br/>
						Amount: " . $editentry['37'] . "<br/>
						Nelnet ID: " . $editentry['38'] . "<br/>
						
					</blockquote>
						</p>";
						$to_email = $editentry[$notifications_list[0]['to']];
						$mail_test = mail($to_email,
							$notifications_list[0]['subject'],
							$message, implode("\r\n", $headers) );


				} else {
					$success_message =  '<P>Unable to update entry.</P>';
				}

			} else {
				$success_message =  '<P>Looks like payment information has already been updated.</P>';
		}

		break;

	default:
		# code...
		break;
}



get_header(); ?>

<article role="article" id="post-<?php the_ID(); ?>" <?php post_class( 'post-part' ); ?>>

	<h2 class="post-headline">
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h2>

	<?php responsive_post_meta(); ?>

	<?php /*the_excerpt();*/ 
	echo $success_message;
	?>

	<?php if ( responsive_posts_should_display( 'tags' ) ) {
		the_tags( '<p class="meta tags"><em>' . __( 'Tagged:', 'responsive-framework' ) . '</em> ', ', ', '</p>' );
} ?>

	<?php edit_post_link( __( 'Edit', 'responsive-framework' ), '<p class="edit-link">', '</p>' ); ?>

</article>

<?php get_sidebar( 'posts' ); ?>
<?php get_footer();
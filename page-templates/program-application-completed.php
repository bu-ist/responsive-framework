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
GLOBAL $headers;
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
/*$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers[] = 'From: ' . $notifications_list[0]['from'];
$headers[] = 'Reply-To: ' . $notifications_list[0]['from'];
$headers[] = 'X-Mailer: PHP/' . phpversion();*/

//$orig_message = preg_quote($notifications_list[0]['message']);
$orig_message = $notifications_list[0]['message'];

parseMessage($orig_message, $editentry);
parseHeaders($notifications_list, $editentry, $headers);


switch ($_GET['form_id']) {
	//AIM - CC parent
	case '10':
		//international addresses are not always the same field
		if ($editentry['2.1'] != '') {
			$comp_addr = strcasecmp( $editentry['2.1'], $_GET['address1'] );
		} else {
			$comp_addr = strcasecmp( $editentry['150.1'], $_GET['address1'] );
		}

		if ($notifications_list[0]['bcc'] != '') {
			//regex check here for multiple extra emails?
			$notifications_list[0]['bcc'] = $parent_email;//parentemail:12
		}

		$cur_pay_status = checkPayStatus($editentry);
		if ( $cur_pay_status === true ) {

				if (GFAPI::update_entry($editentry)) {
					$success_message = $orig_message;
					
					$to_email = $editentry[$notifications_list[0]['to']];
					$mail_test = mail($to_email,
							$notifications_list[0]['subject'],
							$success_message, implode("\r\n", $headers) );

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

		$cur_pay_status = checkPayStatus($editentry);
		if ( $cur_pay_status === true ) {

				if ( GFAPI::update_entry($editentry) ) {
				 
					$success_message = $orig_message;
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
	case '73':
		if ($editentry['2.1'] != '') {
			$comp_addr = strcasecmp( $editentry['2.1'], $_GET['address1'] );
		} else {
			$comp_addr = strcasecmp( $editentry['321.1'], $_GET['address1'] );
		}
		if ($notifications_list[0]['bcc'] != '') {
			//regex check here for multiple extra emails?
			$notifications_list[0]['bcc'] = $parent_email;//parentemail:12
		}
		
		$cur_pay_status = checkPayStatus($editentry);
		if ( $cur_pay_status === true ) {

				if (GFAPI::update_entry($editentry)) {
				 //var_dump( $editentry );
					$success_message = $orig_message;

    				$to_email = $editentry[$notifications_list[0]['to']];
					$mail_test = mail($to_email,
							$notifications_list[0]['subject'],
							$orig_message, implode("\r\n", $headers) );
					/*$mail_test = mail('djgannon@bu.edu',
							$notifications_list[0]['subject'],
							$orig_message, implode("\r\n", $headers) );*/

				} else {
					$success_message =  '<P>Unable to update entry.</P>';
				}

			} else {
				$success_message =  '<P>Looks like payment information has already been updated.</P>';
		}

		break;

	//honors
	case '12':
		/*var_dump($orig_message);
		var_dump($notifications_list);*/
		if ($editentry['2.1'] != '') {
			$comp_addr = strcasecmp( $editentry['2.1'], $_GET['address1'] );
		} else {
			$comp_addr = strcasecmp( $editentry['161.1'], $_GET['address1'] );
		}
		if ($notifications_list[0]['bcc'] != '') {
			//regex check here for multiple extra emails?
			$notifications_list[0]['bcc'] = $parent_email;//parentemail:12
		}
		
		$cur_pay_status = checkPayStatus($editentry);
		if ( $cur_pay_status === true ) {

				if (GFAPI::update_entry($editentry)) {
				 //var_dump( $editentry );
					$success_message = $orig_message;

    				$to_email = $editentry[$notifications_list[0]['to']];
					$mail_test = mail($to_email,
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
	case '28':
		/*var_dump($orig_message);
		var_dump($notifications_list);*/
		if ($editentry['2.1'] != '') {
			$comp_addr = strcasecmp( $editentry['2.1'], $_GET['address1'] );
		} else {
			$comp_addr = strcasecmp( $editentry['161.1'], $_GET['address1'] );
		}

		if ($notifications_list[0]['bcc'] != '') {
			//regex check here for multiple extra emails?
			$notifications_list[0]['bcc'] = $parent_email;//parentemail:12
		}

		$cur_pay_status = checkPayStatus($editentry);
		if ( $cur_pay_status === true ) {

			if (GFAPI::update_entry($editentry)) {
			 //var_dump( $editentry );
				$success_message = $orig_message;

   				$to_email = $editentry[$notifications_list[0]['to']];
				$mail_test = mail($to_email,
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

		if ($editentry['2.1'] != '') {
			$comp_addr = strcasecmp( $editentry['2.1'], $_GET['address1'] );
		} else {
			$comp_addr = strcasecmp( $editentry['161.1'], $_GET['address1'] );
		}
		if ($notifications_list[0]['bcc'] != '') {
			//regex check here for multiple extra emails?
			$notifications_list[0]['bcc'] = $parent_email;//parentemail:12
		}

		$cur_pay_status = checkPayStatus($editentry);
		if ( $cur_pay_status === true ) {

				if (GFAPI::update_entry($editentry)) {
				 //var_dump( $editentry );
					$success_message = $orig_message;

					$to_email = $editentry[$notifications_list[0]['to']];
					$mail_test = mail($to_email,
							$notifications_list[0]['subject'],
							$orig_message, implode("\r\n", $headers) );


				} else {
					$success_message =  '<P>Unable to update entry.</P>';
				}

			} else {
				$success_message =  '<P>Looks like payment information has already been updated.</P>';
		}

		break;

	//international
	case '44':

		$cur_pay_status = checkPayStatus($editentry);
		if ( $cur_pay_status === true ) {

				if (GFAPI::update_entry($editentry)) {
				 //var_dump( $editentry );
					$success_message = $orig_message;
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
		//international addresses are not always the same field
		if ($editentry['2.1'] != '') {
			$comp_addr = strcasecmp( $editentry['2.1'], $_GET['address1'] );
		} else {
			$comp_addr = strcasecmp( $editentry['170.1'], $_GET['address1'] );
		}

		$cur_pay_status = checkPayStatus($editentry);

		if ( $cur_pay_status === true ) {
			//if it seems copecetic, continue
				$editentry['68']    = "Yes";

				//if it seems copecetic, continue
				if (GFAPI::update_entry($editentry)) {
				 //var_dump( $editentry );
					$success_message = $orig_message;
					$to_email = $editentry[$notifications_list[0]['to']];
					$mail_test = mail($to_email,
					$notifications_list[0]['subject'], $orig_message, implode("\r\n", $headers) );


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


function checkPayStatus($editentry){

	if ($editentry['payment_status'] != 'Yes'
			&& $editentry['payment_date'] == ''
			&& $editentry['36'] == ''
			&& $editentry['37'] == ''
			&& $editentry['38'] == ''
			&& $comp_addr == 0
			&& $editentry['5'] == $_GET['email'] ) {

				$editentry['payment_status'] = 'Yes';
				$editentry['payment_date'] = date('Y/m/d');
				$editentry['36']    = $_GET['creditCardLastFour'];
				$editentry['37']    = $_GET['transactionTotalAmount'];
				$editentry['38']    = $_GET['NelnetID'];

			return true;
	} else {
		return false;
	}

}


get_header(); ?>

<article role="article" id="post-<?php the_ID(); ?>" <?php post_class( 'post-part' ); ?>>

	<h2 class="post-headline"><?php the_title(); ?>
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
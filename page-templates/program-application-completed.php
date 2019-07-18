<?php
/**
 * Template Name: Program Application Thank You Page
 *
 * @package Responsive_Framework
 */

/*var_dump($_SERVER['HTTP_X_FORWARDED_HOST']);
var_dump($_SERVER);*/
/*Try updating entries directly form telegraph*/
$editentry = GFAPI::get_entry($_GET['application_id']);
if ($editentry['payment_status'] != 'Yes'
	&& $editentry['payment_date'] == ''
	&& $editentry['36'] == ''
	&& $editentry['37'] == ''
	&& $editentry['38'] == ''
	&& ( $editentry['2.1'] == $_GET['address1'] )
	&& ( $editentry['5'] == $_GET['email'] ) ) {

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
		} else {
			$success_message =  '<P>Unable to update entry.</P>';
		}

	} else {
		$success_message =  '<P>Looks like payment information has already been updated.</P>';
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

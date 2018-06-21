<?php
/**
 * Template file used to render a No Access error page.
 *
 * @package Responsive_Framework
 */

get_header();
?>

<div class="no-access not-found content-area">
	<header class="page-header">
		<h1 <?php echo r_page_title_class(); ?>><?php esc_html_e( 'Access Restricted To BUMC/BMC', 'responsive-framework' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<p>
		<?php
			/* translators: %s: BUMC help desk email. */
			printf( esc_html__( 'You are trying to access a page that is restricted to members of the Boston University Medical Campus (BUMC) and Boston Medical Center (BMC). If you are indeed part of the BUMC/BMC community, contact the BUMC Help Desk (%s | 617-638-5914) for further assistance, Monday through Friday, 8:30 a.m. to 5 p.m. or visit:', 'responsive-framework' ), '<a href="mailto:bumchelp@bu.edu">bumchelp@bu.edu</a>' );
		?>
		</p>
		<p><a href="http://www.bumc.bu.edu/bumc/oit/network/VPN">http://www.bumc.bu.edu/bumc/oit/network/VPN</a></p>
	</div><!-- .page-content -->
</div><!-- .no-access -->

<?php
get_footer();

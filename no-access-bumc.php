<?php
/**
 * Template file used to render a No Access error page
 */
get_header();
?>

<section class="no-access not-found">

	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Access Restricted To BUMC/BMC' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<p>You are trying to access a page that is restricted to members of the Boston University Medical Campus (BUMC) and Boston Medical Center (BMC). If you are indeed part of the BUMC/BMC community, contact the BUMC Help Desk (<a href="mailto:bumchelp@bu.edu">bumchelp@bu.edu</a> | 617-638-5914) for further assistance, Monday through Friday, 8:30 a.m. to 5 p.m. or visit:</p>
		<p><a href="http://www.bumc.bu.edu/bumc/oit/network/VPN">http://www.bumc.bu.edu/bumc/oit/network/VPN</a></p>
	</div><!-- .page-content -->
</section><!-- .no-access -->

<?php get_footer();

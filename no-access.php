<?php
/**
 * Template file used to render a No Access error page.
 *
 * @package Responsive_Framework
 */

get_header();
?>

<main role="main" class="no-access not-found content-area">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Access Restricted To BU/BUMC/BMC' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<p>You are trying to access a page that is restricted to members of the Boston University community.  For further assistance, please see:</p>
		<p><a href="http://www.bu.edu/pcsc/vpn/">http://www.bu.edu/pcsc/vpn/</a></p>
		<p><a href="http://www.bumc.bu.edu/bumc/oit/network/VPN">http://www.bumc.bu.edu/bumc/oit/network/VPN</a></p>

	</div><!-- .page-content -->
</main><!-- .no-access -->

<?php get_footer();

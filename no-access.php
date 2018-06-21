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
		<h1 <?php echo r_page_title_class(); ?>><?php esc_html_e( 'Access Restricted To BU/BUMC/BMC', 'responsive-framework' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<p><?php esc_html_e( 'You are trying to access a page that is restricted to members of the Boston University community.  For further assistance, please see:', 'responsive-framework' ); ?></p>
		<p><a href="http://www.bu.edu/pcsc/vpn/">http://www.bu.edu/pcsc/vpn/</a></p>
		<p><a href="http://www.bumc.bu.edu/bumc/oit/network/VPN">http://www.bumc.bu.edu/bumc/oit/network/VPN</a></p>

	</div><!-- .page-content -->
</div><!-- .no-access -->

<?php get_footer();

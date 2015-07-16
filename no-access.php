<?php
/**
 * Template file used to render a No Access error page
 */
get_header();
?>

<section class="no-access not-found">

	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<h2>Access Restricted To BU/BUMC/BMC</h2>
		<p>You are trying to access a page that is restricted to members of the Boston University community.  For further assistance, please see:</p>
		<p><a href="http://www.bu.edu/pcsc/vpn/">http://www.bu.edu/pcsc/vpn/</a></p>
		<p><a href="http://www.bumc.bu.edu/bumc/oit/network/VPN">http://www.bumc.bu.edu/bumc/oit/network/VPN</a></p>

	</div><!-- .page-content -->
</section><!-- .no-access -->

<?php get_footer(); ?>

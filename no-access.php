<?php get_header(); ?>
<?php get_template_part('after-header'); ?>

<div class="container">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div<?php bu_flexi_main_id(); ?> class="main">
		<div class="container">
			<h2>Access Restricted To BU/BUMC/BMC</h2>
			<p>You are trying to access a page that is restricted to members of the Boston University community.  For further assistance, please see:</p>
			<p><a href="http://www.bu.edu/pcsc/vpn/">http://www.bu.edu/pcsc/vpn/</a></p>
			<p><a href="http://www.bumc.bu.edu/bumc/oit/network/VPN">http://www.bumc.bu.edu/bumc/oit/network/VPN</a></p>
		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>
<?php get_footer(); ?>


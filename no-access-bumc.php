<?php get_header(); ?>
<?php get_template_part('after-header'); ?>

<div class="container">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div<?php bu_flexi_main_id(); ?> class="main">
		<div class="container">
			<h2>Access Restricted To BUMC/BMC</h2>
			<p>You are trying to access a page that is restricted to members of the Boston University Medical Campus (BUMC) and Boston Medical Center (BMC). If you are indeed part of the BUMC/BMC community, contact the BUMC Help Desk (<a href="mailto:bumchelp@bu.edu">bumchelp@bu.edu</a> | 617-638-5914) for further assistance, Monday through Friday, 8:30 a.m. to 5 p.m. or visit:</p>
			<p><a href="http://www.bumc.bu.edu/bumc/oit/network/VPN">http://www.bumc.bu.edu/bumc/oit/network/VPN</a></p>
		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>
<?php get_footer(); ?>

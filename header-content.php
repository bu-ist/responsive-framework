<div id="masthead">
    <h1><a href="<?php bloginfo('url');?>"><?php bu_flexi_get_header();?></a></h1>
    <p><?php bloginfo('description'); ?></p>
</div><!--/#masthead-->

<?php bu_flexi_get_search_form(); ?>

<div id="pnb" role="navigation">
	<?php if(!method_exists('BuAccessControlPlugin', 'is_site_403') || BuAccessControlPlugin::is_site_403() == false) bu_navigation_display_primary(); ?>
</div><!--/#pnb-->

<?php if(!method_exists('BuAccessControlPlugin', 'is_site_403') || BuAccessControlPlugin::is_site_403() == false) bu_flexi_display_utility_nav(); ?>


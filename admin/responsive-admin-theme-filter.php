<?php
/**
 * When on sites.bu.edu, limit ability to change theme to super admins only. Originally implemented to preserve Faculty Model sites.
 *
 * @package Responsive_Framework
 */

namespace BU\Responsive\Admin\Theme_Filters;

/**
 * If this is a sites.bu.edu site do not allow theme switching.
 *
 * @param array $query_vars Query vars.
 *
 * @return array Query vars.
 */

add_action( 'admin_menu', 'BU\Responsive\Admin\Theme_Filters\hide_theme_switcher' );
function hide_theme_switcher() {
	//add_option( 'Disable Theme Switching', 'False', '', '' );
    //check site domain
    if(strpos($_SERVER['HTTP_HOST'], 'djgannon') !== false) {
    	//remove_menu_page( 'themes.php' );
    	$serialized_value = maybe_serialize( 'False' );
    	/*add_option( 'Disable Theme Switching', $serialized_value, '', '' );*/
    	add_menu_page( 'Customize', 'Customize', 'administrator', 'customize.php?return=' . get_option('stylesheet') . '/wp-admin/', '', '', '6' );
    	add_menu_page( 'Widgets', 'Widgets', 'administrator', 'widgets.php', '', '', '7'  );
    	add_menu_page( 'Nav Menus', 'Menus', 'administrator', 'nav-menus.php', '', '', '8'  );
    	add_menu_page( 'Primary Navigation', 'Primary Navigation', 'administrator', 'themes.php?page=bu-navigation-settings', '', '', '9'  );
   }
}


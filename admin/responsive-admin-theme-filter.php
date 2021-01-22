<?php
/**
  *
Limits theme changing ability to Super Admins. Developed for FacultyModel sites on sites.bu.edu
 *
 * @package Responsive_Framework
 */

namespace BU\Responsive\Admin\Theme_Filters;


add_action( 'admin_menu', 'BU\Responsive\Admin\Theme_Filters\hide_theme_switcher' );
function hide_theme_switcher() {
    //
    if (get_option('Theme Switching Disabled') === 'True' ){
    	var_dump('Theme Switching Banned');
    	remove_menu_page( 'themes.php' );
    	add_menu_page( 'Customize', 'Customize', 'administrator', 'customize.php?return=' . get_option('stylesheet') . '/wp-admin/', '', '', '6' );
    	add_menu_page( 'Widgets', 'Widgets', 'administrator', 'widgets.php', '', '', '7'  );
    	add_menu_page( 'Nav Menus', 'Menus', 'administrator', 'nav-menus.php', '', '', '8'  );
    	add_menu_page( 'Primary Navigation', 'Primary Navigation', 'administrator', 'themes.php?page=bu-navigation-settings', '', '', '9'  );

    } 
}


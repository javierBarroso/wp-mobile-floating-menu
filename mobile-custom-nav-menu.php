<?php

/**
 * 
 *
 * @link              https://profiles.wordpress.org/javierbarroso/
 * @since             1.0.0
 * @package           Mobile_Custom_Nav_Menu
 *
 * @wordpress-plugin
 * Plugin Name:       Mobile Custom Nav Menu
 * Plugin URI:        https://profiles.wordpress.org/javierbarroso/
 * Description:       This plugin will help you to create a nice looking nav menu with no programming knowledge and no effort.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Javier Barroso
 * Author URI:        https://profiles.wordpress.org/javierbarroso/
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mobile-custom-nav-menu
 * Domain Path:       /languages
 */

/*
Mobile Custom Nav Menu is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

Mobile Custom Nav Menu is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Mobile Custom Nav Menu. If not, see https://www.gnu.org/licenses/gpl-3.0.html.
*/


// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

if(!defined('ABSPATH')){
    exit();
}

/**  includes   */

require dirname(__FILE__) . '/includes/class-mobile-custom-nav-menu.php';
require dirname(__FILE__) . '/includes/class-mobile-custom-nav-menu-activator.php';
require dirname(__FILE__) . '/includes/class-mobile-custom-nav-menu-deactivator.php';

/** define constants */

if(!defined('MOBILE_CUSTOM_NAV_MENU_NAME')){
    define('MOBILE_CUSTOM_NAV_MENU_NAME', plugin_basename( __FILE__ ));
}
if(!defined('MOBILE_CUSTOM_NAV_MENU_VERSION')){
    define('MOBILE_CUSTOM_NAV_MENU_VERSION', '1.0.0');
}
if(!defined('MOBILE_CUSTOM_NAV_MENU_PATH')){
    define('MOBILE_CUSTOM_NAV_MENU_PATH', plugin_dir_path( __FILE__ ));
}
if(!defined('MOBILE_CUSTOM_NAV_MENU_URL')){
    define('MOBILE_CUSTOM_NAV_MENU_URL', plugin_dir_url( __FILE__ ));
}

global $wpdb;
if (!defined('MCNM_TABLE')) {
	define('MCNM_TABLE', $wpdb->prefix . 'mcnm_mobile_custom_nav_menu');
}
if (!defined('MCNM_SETTINGS_TABLE')) {
	define('MCNM_SETTINGS_TABLE', $wpdb->prefix . 'mcnm_mobile_custom_nav_menu_settings');
}


/** activation and deactivation */


function activate_mobile_custom_nav_menu(){
    Mobile_Custom_Nav_Menu_Activation::activate();
}
function deactivate_mobile_custom_nav_menu(){
    Mobile_Custom_Nav_Menu_Deactivation::deactivate();
}

/**Run activation */
register_activation_hook(__FILE__, 'activate_mobile_custom_nav_menu');
/**run deactivation */
register_deactivation_hook(__FILE__, 'deactivate_mobile_custom_nav_menu');



if(class_exists('Mobile_Custom_Nav_Menu')){

    $plugin = new Mobile_Custom_Nav_Menu();
    $plugin->run();

}
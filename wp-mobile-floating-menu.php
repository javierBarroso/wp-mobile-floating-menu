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



/* 
class WpMobileFloatingMenu
{



    
    function register()
    {

        add_action('admin_menu', array($this, 'add_admin_menu'));

        add_action('wp_head', array($this, 'includes'));

        add_action('wp_enqueue_scripts', array($this, 'frontend_enqueue'));

        add_action('wp_footer', array($this, 'script_enqueue'));

        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));

    }

    
    function includes()
    {

        include_once WP_MOBILE_MENU . 'frontend.php';

    }


    //activate plugin
    function activate()
    {
        require_once WP_MOBILE_MENU . 'admin/classes/activate.php';

        WpMobileFloatingMenuActivate::activate();
    }


    //deactivate plugin
    function deactivate()
    {
        global $wpdb;

        $fm_current_settings_table = $wpdb->prefix . 'jb_mobile_menu';
        $fm_custom_style_table = $wpdb->prefix . 'jb_mobile_menu_settings';

        $wpdb->query("DROP TABLE IF EXISTS $fm_custom_style_table, $fm_current_settings_table");

        flush_rewrite_rules();
    }

    //add admin menu
    function add_admin_menu()
    {

        add_menu_page(
            'Mobile Floating Menu',
            'Mobile Floating Menu',
            'manage_options',
            WP_MOBILE_MENU . 'admin/pages/menu-settings.php',
            null,
            plugins_url('admin/assets/img/boton-menu-icon.svg', __FILE__),
            3
        );
        add_submenu_page(
            WP_MOBILE_MENU . 'admin/pages/menu-settings.php',
            'Add Survey',
            'Add Survey',
            'manage_options',
            WP_MOBILE_MENU . 'admin/pages/menu-settings.php',
            null
        );
    }

    //enqueue scripts
    function frontend_enqueue()
    {

        wp_enqueue_style('floating_menu_style', plugins_url('admin/css/wp_floating_menu.css', __FILE__));
        wp_enqueue_style('custom_floating_menu_style', plugins_url('admin/css/wp_custom_floating_menu.css', __FILE__));

    }

    function script_enqueue()
    {

        if (!did_action('wp_enqueue_media')) {
            wp_enqueue_media();
        }
        wp_enqueue_script('floating-menu-script',  plugins_url('admin/js/floating-menu.js', __FILE__), '', false);
        
    }

    function admin_enqueue()
    {

        wp_enqueue_style('custom_floating_menu_style', plugins_url('admin/css/wp_custom_floating_menu.css', __FILE__));
        wp_enqueue_style('floating_menu_admin_style_custom', plugins_url('admin/css/wp-floating-menu-admin.css', __FILE__));
        wp_register_script('floating-menu-script-admin', plugins_url('admin/js/admin-floating-menu.js', __FILE__), array('jquery'));
        wp_enqueue_script('floating-menu-script-admin');

    }
} */

if(class_exists('Mobile_Custom_Nav_Menu')){

    $plugin = new Mobile_Custom_Nav_Menu();
    $plugin->run();

}
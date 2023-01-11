<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wirenomads.com
 * @since             0.1.0
 * @package           Wp_Mobile_Floating_Menu
 *
 * @wordpress-plugin
 * Plugin Name:       Wp Mobile Floating Menu
 * Plugin URI:        https://wirenomads.com
 * Description:       Navigation menu for mobile
 * Version:           0.3.0
 * Author:            Javier Barroso
 * Author URI:        https://wirenomads.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-mobile-floating-menu
 * Domain Path:       /languages
 */



defined( 'ABSPATH' ) or die('Hey, Hands off this file!!!!');

if( ! defined('FLOATING_MENU')){
    define( 'FLOATING_MENU', plugin_dir_path( __FILE__ ));
}




class WpMobileFloatingMenu{

    

    //registration
    function register(){

        add_action( 'admin_menu', array($this, 'add_admin_menu') );

        add_action('wp_head', array($this, 'includes'));
        
        add_action( 'wp_head', array( $this, 'frontend_enqueue') );
        
        add_action( 'wp_head', array( $this, 'script_enqueue') );
        
        add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue') );

        
    }

    function includes(){
        include_once FLOATING_MENU . 'frontend.php';
    }


    //activate plugin
    function activate(){
        require_once FLOATING_MENU . 'admin/clases/activate.php';
        
        WpMobileFloatingMenuActivate::activate();
    }


    //deactivate plugin
    function deactivate(){
        global $wpdb;

        $fm_current_settings_table = $wpdb -> prefix . 'jb_mobile_menu';
        $fm_custom_style_table = $wpdb -> prefix . 'jb_mobile_menu_settings';
        
        $wpdb->query( "DROP TABLE IF EXISTS $fm_custom_style_table, $fm_current_settings_table" );
        
        flush_rewrite_rules();

    }

    //add admin menu
    function add_admin_menu(){

        add_menu_page( 
            'Mobile Floating Menu', 
            'Mobile Floating Menu', 
            'manage_options', 
            FLOATING_MENU . 'admin/pages/menu-settings.php', 
            null, 
            plugins_url('admin/assets/img/boton-menu-icon.svg', __FILE__), 
            3 
        );
        add_submenu_page( 
            FLOATING_MENU . 'admin/pages/menu-settings.php', 
            'Add Survey', 
            'Add Survey', 
            'manage_options', 
            FLOATING_MENU . 'admin/pages/menu-settings.php', 
            null
        );
    }

    //enqueue scripts
    function frontend_enqueue(){

        wp_enqueue_style( 'floating_menu_style', plugins_url('admin/css/wp_floating_menu.css', __FILE__));
        wp_enqueue_style( 'custom_floating_menu_style', plugins_url('admin/css/wp_custom_floating_menu.css', __FILE__));
        
    }
    
    function script_enqueue(){
        
        wp_register_script( 'floating-menu-script', plugins_url('admin/js/floating-menu.js', __FILE__),array('jquery'));
        wp_enqueue_script( 'floating-menu-script' );

    }

    function admin_enqueue(){
        wp_enqueue_style( 'floating_menu_admin_style_custom', plugins_url('admin/css/wp-floating-menu-admin.css', __FILE__));
        wp_register_script( 'floating-menu-script-admin', plugins_url('admin/js/admin-floating-menu.js', __FILE__),array('jquery'));
        wp_enqueue_script( 'floating-menu-script-admin' );
    }

    
}

if(class_exists('WpMobileFloatingMenu')){

    $floatingMenu = new WpMobileFloatingMenu();
    $floatingMenu -> register();

}

//activation
register_activation_hook( __FILE__, array( $floatingMenu, 'activate' ) );

//deactivation
register_deactivation_hook( __FILE__, array( $floatingMenu, 'deactivate' ) );



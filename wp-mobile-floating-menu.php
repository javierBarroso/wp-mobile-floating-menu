<?php


/**
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           WordPress_Mobile_Menu
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Mobile Menu
 * Plugin URI:        https://wirenomads.com
 * Description:       his plugin will help you to create a nice looking nav menu width no programming knowledge and no effort.
 * Version:           1.0.0
 * Author:            Javier Barroso
 * Author URI:        https://wirenomads.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wordpress_mobile_menu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'WORDPRESS_MOBILE_MENU_VERSION', '1.0.0' );


defined('ABSPATH') or die('Hey, Hands off this file!!!!');

if (!defined('WP_MOBILE_MENU')) {
    define('WP_MOBILE_MENU', plugin_dir_path(__FILE__));
}




class WpMobileFloatingMenu
{



    ///////////////////////////* registration *//////////////////////////
    function register()
    {

        add_action('admin_menu', array($this, 'add_admin_menu'));

        add_action('wp_head', array($this, 'includes'));

        add_action('wp_enqueue_scripts', array($this, 'frontend_enqueue'));

        add_action('wp_footer', array($this, 'script_enqueue'));

        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));

    }

    ///////////////////////////* include frontend file *///////////////////////////
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
}


// /* run on activation */
// function activate_wordpress_mobile_menu() {
// 	require_once WP_MOBILE_MENU . 'includes/class-wordpress-mobile-menu-activator.php';
// 	Wp_Mobile_Menu_Activator::activate();
// }

// /* run on deactivation */
// function deactivate_wordpress_mobile_menu() {
// 	require_once WP_MOBILE_MENU . 'includes/class-wordpress-mobile-menu-deactivator.php';
// 	Wp_Mobile_Menu_Deactivator::deactivate();
// }

// register_activation_hook( __FILE__, 'activate_wordpress_mobile_menu' );
// register_deactivation_hook( __FILE__, 'deactivate_wordpress_mobile_menu' );

// /* load plugin file */
// require WP_MOBILE_MENU . 'includes/class-wordpress-mobile-menu.php';

// function run_wp_mobile_menu(){
//     $plugin = new WpMobileMenu();
// }


if (class_exists('WpMobileFloatingMenu')) {

    $floatingMenu = new WpMobileFloatingMenu();
    $floatingMenu->register();
    
}

//activation
register_activation_hook(__FILE__, array($floatingMenu, 'activate'));

//deactivation
register_deactivation_hook(__FILE__, array($floatingMenu, 'deactivate'));


add_action('in_admin_header', function () {
    $currentPage = get_admin_page_parent( );
    if ($currentPage != 'wp-mobile-floating-menu/admin/pages/menu-settings.php') return;
    remove_all_actions('admin_notices');
    remove_all_actions('all_admin_notices');
    /* add_action('admin_notices', function () {
      echo print_r(get_current_screen(  ));
    }); */
  }, 1000);


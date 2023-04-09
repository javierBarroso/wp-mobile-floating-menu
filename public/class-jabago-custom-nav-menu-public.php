<?php
/**
 *
 * @link       https://profiles.wordpress.org/javierbarroso/
 * @since      1.0.0
 *
 * @package    Jabago_Custom_Nav_Menu
 * @subpackage Jabago_Custom_Nav_Menu/admin
 * @author     Javier Barroso <abby.javi.infox@gmail.com>
 * 
 * 
 *  Text Domain: jabago-custom-nav-menu
 *  Domain Path: /languages
 * 
 * 
 */

class Jabago_Custom_Nav_Menu_Public{
    /**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		/* require JABAGO_CUSTOM_NAV_MENU_PATH . 'includes/class-jabago-custom-nav-menu-walker.php';
		require JABAGO_CUSTOM_NAV_MENU_PATH . 'admin/classes/class-settings-management.php'; */

		add_action( 'wp_head', array( $this, 'ini' ) );
		
	}


    function ini(){
		
		require 'partials/jabago-custom-nav-menu-frontend.php';
		
	}

	
	



	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * enqueue css stylesheets for the public faceing side of the site
		 */

		wp_enqueue_style($this->plugin_name, JABAGO_CUSTOM_NAV_MENU_URL . 'includes/css/jabago-custom-nav-menu-public.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'variables', JABAGO_CUSTOM_NAV_MENU_URL . 'includes/css/jabago-custom-nav-menu-variables.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * enqueue javascripts files for the public faceing side of the site
		 */

		wp_enqueue_script($this->plugin_name, JABAGO_CUSTOM_NAV_MENU_URL . 'includes/js/jabago-custom-nav-menu-public.js', array('jquery'), $this->version, true);
	}
}
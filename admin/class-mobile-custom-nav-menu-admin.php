<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Mobile_Custom_Nav_Menu
 * @subpackage Mobile_Custom_Nav_Menu/admin
 * @author     Javier Barroso <abby.javi.infox@gmail.com>
 * 
 * 
 */



class Mobile_Custom_Nav_Menu_Admin
{

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action('admin_menu', array($this, 'add_admin_menu'));

		add_filter('plugin_action_links_' . MOBILE_CUSTOM_NAV_MENU_NAME, array($this, 'settings_link'));
	}

	function settings_link($links)
	{
		$demo_link = '<a style="color:red; font-weight: 700;" href="https://google.com">Buy Now</a>';
		$settings_link = '<a href="admin.php?page=bnt">Settings</a>';

		array_push($links, $demo_link);
		array_push($links, $settings_link);

		return $links;
	}


	/* Create admin menu pages */
	function add_admin_menu()
	{
		add_menu_page(
			'Mobile Custom Nav Menu',
			'Mobile Custom Nav Menu',
			'manage_options',
			'mcnm',
			array($this, 'mobile_custom_nav_menu_settings'),
			MOBILE_CUSTOM_NAV_MENU_URL . 'admin/assets/img/boton-menu-icon.svg', 
			3
		);
	}

	function mobile_custom_nav_menu_settings()
	{
		require_once MOBILE_CUSTOM_NAV_MENU_PATH . 'admin/partials/page-mobile-custom-nav-menu-settings.php';
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/mobile-custom-nav-menu-admin.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'previe-variables', MOBILE_CUSTOM_NAV_MENU_URL . 'public/css/mobile-custom-nav-menu-variables.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/mobile-custom-nav-menu.js', array('jquery'), $this->version, false);
	}
}

<?php
/**
 * @since      1.0.0
 * @package    Mobile_Custom_Nav_Menu
 * @subpackage Mobile_Custom_Nav_Menu/includes
 * @author     Javier Barroso <abby.javi.infox5@gmail.com>
 */

class Mobile_Custom_Nav_Menu_i18n
{

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain()
	{

		load_plugin_textdomain(
			'mobile-custom-nav-menu',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);
	}
	
}

<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WordPress_Jabago_Menu
 * @subpackage WordPress_Jabago_Menu/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    WordPress_Jabago_Menu
 * @subpackage WordPress_Jabago_Menu/includes
 * @author    Javier Barroso <abby.javi.infox5@gmail.com>
 */
class Jabago_Custom_Nav_Menu_Deactivation {

	/**
	 * Plugin deactivation class.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        flush_rewrite_rules();
	}

}
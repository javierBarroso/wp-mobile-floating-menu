<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WordPress_Mobile_Menu
 * @subpackage WordPress_Mobile_Menu/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    WordPress_Mobile_Menu
 * @subpackage WordPress_Mobile_Menu/includes
 * @author    Javier Barroso <abby.javi.infox5@gmail.com>
 */
class WordPress_Mobile_Menu_Deactivator {

	/**
	 * Plugin deactivation class.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        flush_rewrite_rules();
	}

}
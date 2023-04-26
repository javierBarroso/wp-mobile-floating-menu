<?php

/**
 * 
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WordPress_Jabago_Menu
 * @subpackage WordPress_Jabago_Menu/includes
 * @author    Javier Barroso <abby.javi.infox5@gmail.com>
 */


class Jabago_Custom_Nav_Menu_Activation {

	/**
	 * Activation class to create database tables
	 *
	 * @since    1.0.0
	 */

	public static function activate() {

        global $wpdb;

        $query = "CREATE TABLE IF NOT EXISTS `" . JABAGO_CUSTOM_NAV_MENU_TABLE . "`(
            `Id` INT NOT NULL AUTO_INCREMENT , 
            `current_style` TEXT NULL , 
            PRIMARY KEY (`Id`));";
        $wpdb->query($query);


        flush_rewrite_rules();
        
	}

}
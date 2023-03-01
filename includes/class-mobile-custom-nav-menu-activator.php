<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WordPress_Mobile_Menu
 * @subpackage WordPress_Mobile_Menu/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WordPress_Mobile_Menu
 * @subpackage WordPress_Mobile_Menu/includes
 * @author    Javier Barroso <abby.javi.infox5@gmail.com>
 */


class Mobile_Custom_Nav_Menu_Activation {

	/**
	 * Activation class to create database tables
	 *
	 * @since    1.0.0
	 */

	public static function activate() {

        global $wpdb;

        $query = "CREATE TABLE IF NOT EXISTS `" . MCNM_TABLE . "`(
            `Id` INT NOT NULL AUTO_INCREMENT , 
            `current_style` TEXT NULL , 
            PRIMARY KEY (`Id`));";
        $wpdb -> query($query);


        flush_rewrite_rules();
        
	}

}
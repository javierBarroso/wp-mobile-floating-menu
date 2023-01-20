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


class WordPress_Mobile_Menu_Activator {

	/**
	 * Activation class to create database tables
	 *
	 * @since    1.0.0
	 */

	public static function activate() {

        global $wpdb;

        $settings_table = $wpdb -> prefix . 'jb_wp_mobile_menu';

        /* Fix problem */
        $old_table_1 = $wpdb -> prefix . 'jb_jb_mobile_menu';
        $old_table_2 = $wpdb -> prefix . 'jb_jb_mobile_menu_settings';
        
        //$wpdb->query( "DROP TABLE IF EXISTS $settings_table, $fm_current_settings_table" );
        $wpdb->query( "DROP TABLE IF EXISTS $old_table_1, $old_table_2" );
        $wpdb->query( "DROP TABLE IF EXISTS $old_table_2, $old_table_1" );

        $query = "CREATE TABLE IF NOT EXISTS `".$settings_table."`(
            `Id` INT NOT NULL AUTO_INCREMENT , 
            `current_style` TEXT NULL , 
            PRIMARY KEY (`Id`));";
        $wpdb -> query($query);


        flush_rewrite_rules();
        
	}

}
<?php


/**
 * 
 * @package Wp_Mobile_Floating_Menu
 * 
 */


 class WpMobileFloatingMenuActivate{

    public static function activate(){

        global $wpdb;

        $fm_current_settings_table = $wpdb -> prefix . 'jb_mobile_menu';
        $fm_custom_style_table = $wpdb -> prefix . 'jb_mobile_menu_settings';

        /* Fix problem */
        $old_table_1 = $wpdb -> prefix . 'jb_jb_mobile_menu';
        $old_table_2 = $wpdb -> prefix . 'jb_jb_mobile_menu_settings';
        
        $wpdb->query( "DROP TABLE IF EXISTS $fm_custom_style_table, $fm_current_settings_table" );
        $wpdb->query( "DROP TABLE IF EXISTS $old_table_1, $old_table_2" );
        $wpdb->query( "DROP TABLE IF EXISTS $old_table_2, $old_table_1" );

        $query = "CREATE TABLE IF NOT EXISTS `".$fm_current_settings_table."`(
            `Id` INT NOT NULL AUTO_INCREMENT , 
            `current_menu` TEXT NOT NULL DEFAULT '1', 
            `style_preset` TEXT NOT NULL DEFAULT 'dark', 
            PRIMARY KEY (`Id`));";
        $wpdb -> query($query);

        $query = "CREATE TABLE IF NOT EXISTS `".$fm_custom_style_table."`(
            `Id` INT NOT NULL AUTO_INCREMENT , 
            `menu_id` INT NOT NULL , 
            `css_style` TEXT NULL , 
            `menu_structure` TEXT NULL ,   
            PRIMARY KEY (`Id`),
            FOREIGN KEY (menu_id) REFERENCES $fm_current_settings_table(Id)
        );";
        $wpdb -> query($query); 
        

        flush_rewrite_rules();
    }
 }
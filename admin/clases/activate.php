<?php

use Elementor\Core\Logger\Items\File;

/**
 * 
 * @package Wp_Mobile_Floating_Menu
 * 
 */


 class WpMobileFloatingMenuActivate{

    public static function activate(){

        global $wpdb;

        $fm_current_settings_table = $wpdb -> prefix . 'floating_menu_settings';
        $fm_custom_style_table = $wpdb -> prefix . 'floating_menu_custom_style_settings';
        

        $query = "CREATE TABLE IF NOT EXISTS `".$fm_current_settings_table."`(
            `Id` INT NOT NULL AUTO_INCREMENT , 
            `current_menu` TEXT NOT NULL DEFAULT '1', 
            `style_menu` TEXT NOT NULL DEFAULT 'dark', 
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

        $query = 'SELECT * FROM '. $fm_current_settings_table;
        $records = $wpdb->get_results($query, ARRAY_A);

        if(empty($records)){

            $data = [
                'Id' => 1
            ];
    
            $wpdb -> insert($fm_current_settings_table, $data);
            
        }
        

        flush_rewrite_rules();
    }
 }
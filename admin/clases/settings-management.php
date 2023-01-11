<?php


/**
 * 
 * @package Wp_Mobile_Floating_Menu
 * 
 */


class WpSettingsManagement{


    function get_menus_list(){

        $menus = wp_get_nav_menus(  );

        $output = [];

        foreach ($menus as $key => $value) {
            array_push($output,[
                "id" => $value->term_id,
                "name" => $value->name,
            ]);
        }
        
        return $output;
    }

    function save_general_settings(){

        global $wpdb;

        $fm_current_settings_table = $wpdb -> prefix . 'jb_mobile_menu';
        $fm_custom_style_table = $wpdb -> prefix . 'jb_mobile_menu_settings';

        $output = null;

        if(isset($_POST['save-settings'])){
            $settings = [
                'Id' => 1,
                'current_menu' => isset($_POST['menu_id']) ? $_POST['menu_id'] : (isset($records->current_menu) ? $records->current_menu : ''),
                'style_preset' => $_POST['style_preset'],
            ];
        
            empty($records) ? $wpdb -> insert($fm_current_settings_table, $settings) : $wpdb -> update($fm_current_settings_table, $settings, array('Id' => 1));
        
            $query = 'SELECT * FROM '. $fm_current_settings_table;
            $output = $wpdb->get_results($query, ARRAY_A);
        }

        return $output;
    }
}
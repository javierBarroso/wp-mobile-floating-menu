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

    function save_general_settings(array $data = []){

        global $wpdb;

        $fm_current_settings_table = $wpdb -> prefix . 'jb_mobile_menu';
        
        $query = 'SELECT * FROM '. $fm_current_settings_table;
        $records = $wpdb->get_results($query, ARRAY_A);

        $output = null;

        $settings_data = json_encode($data);

        
        if(isset($_POST['save-settings'])){
            $settings = [
                'Id' => 1,
                'current_menu' => isset($_POST['menu_id']) ? $_POST['menu_id'] : (isset($records->current_menu) ? $records->current_menu : ''),
                'style_preset' => $_POST['style_preset'],
                'current_style' => $settings_data,
            ];
        
            empty($records) ? $wpdb -> insert($fm_current_settings_table, $settings) : $wpdb -> update($fm_current_settings_table, $settings, array('Id' => 1));
        
            $query = 'SELECT current_style FROM '. $fm_current_settings_table .' WHERE 1';
            $records = $wpdb->get_results($query, ARRAY_A);
        }
    
        
        $filePath = plugin_dir_path( __FILE__ ) .'../css/wp_custom_floating_menu.css';
        
        $styleFile = file($filePath, FILE_IGNORE_NEW_LINES);
        
        foreach ($data['style'] as $key => $value) {
            
            $styleFile[$value[1]]= '--'. $key .' : '.$value[0].';';
            
        }
        
        file_put_contents($filePath, implode(PHP_EOL, $styleFile));

        $output = json_decode($records[0]['current_style']);
        return $output;
    }

    function load_settings(){
        global $wpdb;

        $fm_current_settings_table = $wpdb -> prefix . 'jb_mobile_menu';

        $query = 'SELECT * FROM '. $fm_current_settings_table;
        $records = $wpdb->get_results($query, ARRAY_A);

        $output = json_decode($records[0]['current_style']);

        return $output;
    }
}
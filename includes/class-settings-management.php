<?php


/**
 * 
 * @package Wp_Jabago_Floating_Menu
 * 
 */


class MCNM_Settings_Management{


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
        
        $query = 'SELECT * FROM '. MCNM_TABLE;
        $records = $wpdb->get_results($query);

        $output = null;

        $settings_data = json_encode($data);

        
        if(isset($_POST['save-settings'])){
            $settings = [
                'Id' => 1,
                'current_style' => $settings_data,
            ];
        
            empty($records) ? $wpdb -> insert( MCNM_TABLE, $settings ) : $wpdb -> update( MCNM_TABLE, $settings, array('Id' => 1));
        
            $query = 'SELECT current_style FROM '. MCNM_TABLE .' WHERE 1';
            $records = $wpdb->get_results($query);
        }
    
        
        $filePath = JABAGO_CUSTOM_NAV_MENU_PATH . 'includes/css/jabago-custom-nav-menu-variables.css';
        
        $styleFile = file($filePath, FILE_IGNORE_NEW_LINES);
        
        foreach ($data['style'] as $key => $value) {
            
            $styleFile[$value[1]]= '--'. $key .' : '.$value[0].';';
            
        }
        
        file_put_contents($filePath, implode(PHP_EOL, $styleFile));
        if($records){
            $output = json_decode($records[0]->current_style);
        }

        return $output;
    }

    function load_settings(){
        global $wpdb;

        $output = null;

        $query = 'SELECT * FROM '. MCNM_TABLE;
        $records = $wpdb->get_results($query);

        if($records){
            $output = json_decode($records[0]->current_style);
        }

        return $output;
    }
}
<?php
    if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

    global $wpdb;

    $old_table_1 = $wpdb -> prefix . 'jb_floating_menu_settings';
    $old_table_2 = $wpdb -> prefix . 'jb_floating_menu_settings';

    $wpdb->query( "DROP TABLE IF EXISTS $fm_current_settings_table" );
    
    delete_option("my_plugin_db_version");
?>
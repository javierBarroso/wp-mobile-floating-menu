<?php
    if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

    global $wpdb;

    $fm_current_settings_table = $wpdb -> prefix . 'jb_floating_menu_settings';

    $wpdb->query( "DROP TABLE IF EXISTS $fm_current_settings_table" );
    
    delete_option("my_plugin_db_version");
?>
<?php
    if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

    global $wpdb;

    $old_table_1 = $wpdb -> prefix . 'jb_jb_mobile_menu';
    $old_table_2 = $wpdb -> prefix . 'jb_jb_mobile_menu';

    $wpdb->query( "DROP TABLE IF EXISTS $fm_current_settings_table" );
    
    delete_option("my_plugin_db_version");
?>
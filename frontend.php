<?php

class MobileFloatingMenuFrontEnd{

    function __construct()
    {
        require ('admin/clases/floating_nav_menu_walker.php');
    }

    
}



if(!is_admin(  )){
    new MobileFloatingMenuFrontEnd;
}

global $wpdb;
        
$fm_current_settings_table = $wpdb -> prefix . 'floating_menu_settings';
$fm_custom_style_table = $wpdb -> prefix . 'floating_menu_custom_style_settings';

$query = 'SELECT * FROM '. $fm_current_settings_table;
$records = $wpdb->get_results($query, ARRAY_A);

$query = 'SELECT * FROM '. $fm_custom_style_table;
$custom_records = $wpdb->get_results($query, ARRAY_A);

if(!empty($records)){

    $structure_data = json_decode($custom_records[0]['menu_structure']);
    //$custom_logo_id = get_theme_mod( 'custom_logo' );
    //$image = wp_get_attachment_image_src( $custom_logo_id , 'full' )[0];

    /* echo '<div class="nav-toggle-container '. !empty($structure_data) ? $structure_data->buttonAlignment : '' . '">
                <button  id="mobile-nav-toggle" class="mobile-nav-toggle" aria-controls="floating-nav-menu" aria-expanded="false"></button>
            </div>
            <div class="floating-menu-back"></div>
            '; */
}


?>
<div class="nav-toggle-container <?php echo !empty($structure_data) ? $structure_data->buttonAlignment : 'hide'?>">
    <button  id="mobile-nav-toggle" class="mobile-nav-toggle" aria-controls="floating-nav-menu" aria-expanded="false"></button>
</div>
<div class="floating-menu-back"></div>

<?php



$header = '';

if(!empty($structure_data) && $structure_data->showHeader == 'on'){

    $header = '<div class="header">';

    if($structure_data->headerType == 'logo'){

        $header .= '<div class="blog-logo '.$structure_data->headerAlignment.'" >'.get_custom_logo( ).'</div>';
    }
    if($structure_data->headerType == 'avatar'){

        $header .= '<div class="user-avatar '.$structure_data->headerAlignment.'"><img src="'.get_avatar_url( wp_get_current_user()->ID).'"><div><a href="'.wp_get_current_user(  )->user_url.'">'.wp_get_current_user(  )->display_name.'</a></div></div>';
    }
    if($structure_data->headerText){
        $header .= '<div class="custom-text"><h2 class="'.$structure_data->headerAlignment.'">'.$structure_data->headerText.'</h2></div>';
    }

    $header .= '</div>';
    
}else{
    $header = '<br><br>';
}

$logout = '';

if(!empty($structure_data) && $structure_data->showFooter){

    if(is_user_logged_in(  )){
    
        $logout = '<br><hr><br><a href="'.wp_logout_url( 'home' ).'">Log Out</a>';
    }
}

if(!empty($records)){
    var_dump(wp_get_nav_menu_object( 'test' ));

    wp_nav_menu( array(
        //'theme_location'=>'primary',
        'menu' => !empty($records[0]['current_menu']) ? $records[0]['current_menu'] : (object) array('term_id'=>0),
        'container'=>'nav',
        'container_class'=>'floating-nav-menu-container',
        'menu_class'=>'floating-nav-menu '. $records[0]['style_menu'] . ' ' . $structure_data->menuAlignment,
        'menu_id'=>'loco',
        'items_wrap'=>'<ul data-visible="false" class="%2$s">'.$header.'%3$s'.$logout .'</ul>',
        'walker'=> !empty($records[0]['current_menu']) ? new floating_nav_menu_walker() : null,
     ) );
    
    
    
     add_action( 'after_setup_theme', 'register_floating_menu' );
    
    function register_floating_menu(){
        register_nav_menu( 'primary', array('Primary Menu') );
    }
}
 
?>






<?php

class MobileFloatingMenuFrontEnd{

    function __construct()
    {
        require ('admin/clases/floating_nav_menu_walker.php');
        require_once ('admin/clases/settings-management.php');
    }

    
}



if(!is_admin(  )){
    new MobileFloatingMenuFrontEnd;
}
$settings = new WpSettingsManagement;

$records = $settings->load_settings();


?>
<div class="nav-toggle-container <?php echo !empty($records) ? $records->buttonAlignment : 'hide'?>">
    <button  id="mobile-nav-toggle" class="mobile-nav-toggle" aria-controls="floating-nav-menu" aria-expanded="false"></button>
</div>
<div class="floating-menu-back"></div>

<?php



$header = '';

if(!empty($records) && $records->showHeader == 'on'){

    $header = '<div class="header">';

    if($records->headerType == 'logo'){

        $header .= '<div class="blog-logo '.$records->headerAlignment.'" >'.get_custom_logo( ).'</div>';
    }
    if($records->headerType == 'avatar'){

        $header .= '<div class="user-avatar '.$records->headerAlignment.'"><img src="'.get_avatar_url( wp_get_current_user()->ID).'"><div><a href="'.wp_get_current_user(  )->user_url.'">'.wp_get_current_user(  )->display_name.'</a></div></div>';
    }
    if($records->headerText){
        $header .= '<div class="custom-text"><h2 class="'.$records->headerAlignment.'">'.$records->headerText.'</h2></div>';
    }

    $header .= '</div>';
    
}else{
    $header = '<br><br>';
}

$logout = '';

if(!empty($records) && $records->showFooter == 'on'){

    if(is_user_logged_in(  ) && $records->showLogin == 'on'){
    
        $logout = '<br><hr><br><div class="menu-footer '.$records->footerAlignment.'"><a href="'.wp_logout_url( 'home' ).'">Log Out</a></div>';
    }
}

if(!empty($records) && $records->menuId && $records->showMenu == 'on'){
    

    wp_nav_menu( array(
        //'theme_location'=>'primary',
        'menu' => !empty($records->menuId) ? $records->menuId : (object) array('term_id'=>0),
        'container'=>'nav',
        'container_class'=>'floating-nav-menu-container',
        'menu_class'=>'floating-nav-menu '. $records->stylePreset . ' ' . $records->menuAlignment,
        'menu_id'=>'loco',
        'items_wrap'=>'<ul data-visible="false" class="%2$s">'.$header.'%3$s'.$logout .'</ul>',
        'walker'=> !empty($records->menuId) ? new floating_nav_menu_walker() : null,
    ) );
    
    
    
    add_action( 'after_setup_theme', 'register_floating_menu' );
    
    function register_floating_menu(){
        register_nav_menu( 'primary', array('Primary Menu') );
    }
}else{
    ?>
    <nav class="floating-nav-menu-container"><ul class="floating-nav-menu dark right" data-visible="false" style="display:flex ;"><div style="margin: auto;">no menu selected</div></ul> </nav>
    <?php
}

?>






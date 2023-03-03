<?php


require_once( MOBILE_CUSTOM_NAV_MENU_PATH . 'includes/class-mobile-custom-nav-menu-walker.php');
require_once(MOBILE_CUSTOM_NAV_MENU_PATH . 'admin/classes/class-settings-management.php');

function custom_search_form( ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
                <div class="search-form"><label class="screen-reader-text" for="s">' . __( 'Search:' ) . '</label>
                    <input class="search-text-input" type="text" placeholder="Search" name="s" id="s" />
                    <button class="search-button" type="submit" id="searchsubmit" >'. file_get_contents( MOBILE_CUSTOM_NAV_MENU_PATH . 'assets/img/search-icon.svg' ) . '</button>
                </div>
            </form>';

    return $form;
}


if (!is_admin()) {
    //new MobileFloatingMenuFrontEnd;
}
$settings = new MCNM_Settings_Management;

$records = $settings->load_settings();


?>
<div class="nav-toggle-container <?php echo !empty($records) ? $records->buttonAlignment : 'hide' ?>">
    <button id="mobile-nav-toggle" class="mobile-nav-toggle" aria-controls="floating-nav-menu" aria-expanded="false"></button>
</div>
<div class="floating-menu-back"></div>

<?php



$header = '';

$logout = '';

$search = custom_search_form( );

if (!empty($records) && $records->showHeader == 'on') {

    $header = '<div class="header">';

    if ($records->headerType == 'logo') {

        $header .= '<div class="blog-logo ' . $records->headerAlignment . '" >' . get_custom_logo() . '</div>';
    }
    if ($records->headerType == 'avatar') {

        $header .= '<div class="user-avatar ' . $records->headerAlignment . '"><img src="' . get_avatar_url(wp_get_current_user()->ID) . '"><a href="' . wp_get_current_user()->user_url . '">' . wp_get_current_user()->display_name . '</a></div>';
    }
    if ($records->headerText) {
        $header .= '<div class="custom-text"><h2 class="' . $records->headerAlignment . '">' . $records->headerText . '</h2></div>';
    }
    if($records->headerSearch == 'on'){
        $header .= '<div class="custom-text">' . $search . '</div>';
    }

    $header .= '</div>';
} else {
    $header = '<br><br>';
}



add_filter( 'get_search_form', 'custom_search_form', 40 );



if (!empty($records) && $records->showFooter == 'on') {

    if (is_user_logged_in() && $records->showLogin == 'on') {

        $logout = '<br><hr><br><div class="menu-footer ' . $records->footerAlignment . '"><a href="' . wp_logout_url('home') . '">Log Out</a></div>';
        
    }
}

if (!empty($records) && $records->menuId && $records->showMenu == 'on') {

    wp_nav_menu(array(
        //'theme_location'=>'primary',
        'menu' => !empty($records->menuId) ? $records->menuId : (object) array('term_id' => 0),
        'container' => 'nav',
        'container_class' => 'floating-nav-menu-container',
        'menu_class' => 'floating-nav-menu ' . $records->stylePreset . ' down ' . $records->menuAlignment,
        'menu_id' => 'loco',
        'items_wrap' => '<ul data-visible="false" class="%2$s">' . $header . '%3$s' . $logout . '</ul>',
        'walker' => !empty($records->menuId) ? new Mobile_Custom_Nav_Menu_Walker() : null,
    ));



    add_action('after_setup_theme', 'register_floating_menu');

    function register_floating_menu()
    {
        register_nav_menu('primary', array('Primary Menu'));
    }
} else {
?>
    <nav class="floating-nav-menu-container">
        <ul class="floating-nav-menu dark right" data-visible="false" style="display:flex ;">
            <div style="margin: auto;">no menu selected</div>
        </ul>
    </nav>
<?php
}

?>
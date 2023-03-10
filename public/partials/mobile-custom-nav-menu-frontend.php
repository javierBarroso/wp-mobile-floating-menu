<?php

/**
 *
 * @link       https://profiles.wordpress.org/javierbarroso/
 * @since      1.0.0
 *
 * @package    Mobile_Custom_Nav_Menu
 * @subpackage Mobile_Custom_Nav_Menu/admin
 * @author     Javier Barroso <abby.javi.infox@gmail.com>
 * 
 * 
 *  Text Domain: mobile-custom-nav-menu
 *  Domain Path: /languages
 * 
 * 
 */

require_once( MOBILE_CUSTOM_NAV_MENU_PATH . 'includes/class-mobile-custom-nav-menu-walker.php');
require_once( MOBILE_CUSTOM_NAV_MENU_PATH . 'includes/class-settings-management.php');

function custom_search_form( ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_attr( home_url( '/' ) ) . '" >
                <div class="search-form">
                    <input class="search-text-input" type="text" placeholder="Search" name="s" id="s" />
                    <button class="search-button" type="submit" id="searchsubmit" >'. file_get_contents( MOBILE_CUSTOM_NAV_MENU_PATH . 'includes/img/search-icon.svg' ) . '</button>
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
<div class="nav-toggle-container <?php echo !empty($records) ? esc_attr( $records->buttonAlignment ) : esc_attr( 'hide' ) ?>">
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

        $header .= '<div class="user-avatar ' . esc_attr( $records->headerAlignment ) . '"><img src="' . esc_attr( get_avatar_url(wp_get_current_user()->ID) ) . '"><a href="' . esc_attr( wp_get_current_user()->user_url ) . '">' . esc_attr( wp_get_current_user()->display_name ) . '</a></div>';
    }
    if ($records->headerText) {
        $header .= '<div class="custom-text"><h2 class="' . esc_attr( $records->headerAlignment ) . '">' . esc_html( $records->headerText ) . '</h2></div>';
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

        $logout = '<br><hr><br><div class="menu-footer ' . esc_attr( $records->footerAlignment ) . '"><a href="' . esc_attr( wp_logout_url('home') ) . '">Log Out</a></div>';
        
    }
}

if (!empty($records) && $records->menuId && $records->showMenu == 'on') {

    wp_nav_menu(array(
        //'theme_location'=>'primary',
        'menu' => !empty($records->menuId) ? $records->menuId : (object) array('term_id' => 0),
        'container' => 'nav',
        'container_class' => esc_attr( 'floating-nav-menu-container' ),
        'menu_class' => 'floating-nav-menu ' . esc_attr( $records->stylePreset ) . ' down ' . esc_attr( $records->menuAlignment ),
        'menu_id' => 'mcnm_public',
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
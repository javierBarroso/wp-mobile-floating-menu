<?php

/**
 *
 * @link       https://profiles.wordpress.org/javierbarroso/
 * @since      1.0.0
 *
 * @package    Jabago_Custom_Nav_Menu
 * @subpackage Jabago_Custom_Nav_Menu/admin
 * @author     Javier Barroso <abby.javi.infox@gmail.com>
 * 
 * 
 *  Text Domain: jabago-custom-nav-menu
 *  Domain Path: /languages
 * 
 * 
 */

require_once 'style-presets.php';
require_once JABAGO_CUSTOM_NAV_MENU_PATH . 'includes/class-settings-management.php';
require_once JABAGO_CUSTOM_NAV_MENU_PATH . 'includes/class-jabago-custom-nav-menu-walker.php';



$setting_manager = new Jabago_Cnm_Settings_Management;

$menus = $setting_manager->get_menus_list();

$pages = array();

foreach (get_pages() as $key => $page) {
    
    $pages[$key] = [
        'name' => $page->post_name,
        'url' => $page->guid,
    ];
}

$records = $setting_manager->load_settings();




if (!did_action('wp_enqueue_media')) {
    wp_enqueue_media();
}


$current_style_preset = 'dark';

if (isset($records->stylePreset)) {
    $current_style_preset = $records->stylePreset;
}

//TODO: icon selector 
function get_icons()
{

    $files = scandir(JABAGO_CUSTOM_NAV_MENU_PATH . 'includes/icons/');
    unset($files[0]);
    unset($files[1]);
    return $files;
}


if (isset($_POST['save-settings'])) {


    $settings_data = [];

    $customStructure = [];

    /* Style settings */

    if ($_POST['style_preset'] == $current_style_preset) {


        if (isset($_POST['background_color'])) {
            $settings_data['style']['menuBackground'] = [$_POST['background_color'], 2];
        }

        if (isset($_POST['front_color'])) {
            $settings_data['style']['fontColor'] = [$_POST['front_color'], 3];
        }

        if (isset($_POST['selected_item_background_color'])) {

            $settings_data['style']['selectedItemBackground'] = [$_POST['selected_item_background_color'], 4];
        }

        if (isset($_POST['selected_item_color'])) {

            $settings_data['style']['selectedItemColor'] = [$_POST['selected_item_color'], 5];
        }

        if (isset($_POST['item_font_size'])) {

            $settings_data['style']['fontSize'] = [$_POST['item_font_size'] . 'em', 6];
        }
    } else {
        foreach ($style_preset[$_POST['style_preset']] as $key => $value) {
            $settings_data['style'][$key] = $value;
        }
    }


    //////////////////////////* general settings *//////////////////////////

    if (isset($_POST['show-menu'])) {
        $settings_data['showMenu'] = $_POST['show-menu'];
    } else {
        $settings_data['showMenu'] = 'off';
    }

    if (isset($_POST['menu_id'])) {
        $settings_data['menuId'] = $_POST['menu_id'];
    } else {
        $settings_data['menuId'] = '';
    }


    if (isset($_POST['show-menu'])) {
        $settings_data['buttonAlignment'] = $_POST['button-alignment'];
    } else {
        $settings_data['buttonAlignment'] = $records ? $records->buttonAlignment : 'right';
    }

    if (isset($_POST['show-menu'])) {
        $settings_data['buttonVerticalAlignment'] = $_POST['button-vertical-alignment'];
    } else {
        $settings_data['buttonVerticalAlignment'] = $records ? $records->buttonVerticalAlignment : 'bottom';
    }

    if (isset($_POST['show-menu'])) {
        $settings_data['menuAlignment'] = $_POST['menu-alignment'];
    } else {
        $settings_data['menuAlignment'] = $records ? $records->menuAlignment : 'right';
    }

    //////////////////////////* Header settings *//////////////////////////

    if (isset($_POST['show-header'])) {
        $settings_data['showHeader'] = $_POST['show-header'];
    } else {

        $settings_data['showHeader'] = 'off';
    }


    if (isset($_POST['show-header'])) {
        $settings_data['headerType'] = $_POST['header-type'];
    } else {
        $settings_data['headerType'] = $records ? $records->headerType : 'logo';
    }

    if (isset($_POST['show-header'])) {
        $settings_data['headerAlignment'] = $_POST['header-alignment'];
    } else {

        $settings_data['headerAlignment'] = $records ? $records->headerAlignment : 'center';
    }

    if (isset($_POST['header-text'])) {
        $settings_data['headerText'] = $_POST['header-text'];
    } else {
        $settings_data['headerText'] = $records ? $records->headerText : '';
    }
    
    if (isset($_POST['logo'])) {
        $settings_data['logo'] = $_POST['logo'];
    } else {
        $settings_data['logo'] = $records ? $records->logo : '';
    }
    
    if (isset($_POST['header-search'])) {
        $settings_data['headerSearch'] = $_POST['header-search'];
    } else {
        $settings_data['headerSearch'] = 'off';
    }
    if (isset($_POST['search-text'])) {
        $settings_data['searchText'] = $_POST['search-text'];
    } else {
        $settings_data['searchText'] = $records ? $records->searchText : 'Search';
    }

    //////////////////////////* Footer settings *//////////////////////////

    if (isset($_POST['show-footer'])) {
        $settings_data['showFooter'] = $_POST['show-footer'];
    } else {
        $settings_data['showFooter'] = 'off';
    }
    if (isset($_POST['show-login'])) {
        $settings_data['showLogin'] = $_POST['show-login'];
    } else {
        $settings_data['showLogin'] = 'off';
    }
    if (isset($_POST['show-login'])) {
        $settings_data['loginUrl'] = $_POST['login-url'];
    } else {
        $settings_data['loginUrl'] = $records ? $records->loginUrl : '';
    }
    if (isset($_POST['show-login'])) {
        $settings_data['registerUrl'] = $_POST['register-url'];
    } else {
        $settings_data['registerUrl'] = $records ? $records->registerUrl : '';
    }
    if (isset($_POST['show-footer'])) {
        $settings_data['footerAlignment'] = $_POST['footer-alignment'];
    } else {
        $settings_data['footerAlignment'] = $records ? $records->footerAlignment : 'left';
    }

    //////////////////////////* Presets settings *//////////////////////////

    if (isset($_POST['style_preset'])) {
        $settings_data['stylePreset'] = $_POST['style_preset'];
    } else {
        $settings_data['stylePreset'] = $records ? $records->stylePreset : 'dark';
    }

    $records = $setting_manager->save_general_settings($settings_data);
}

//TODO: Fix notifications
//TODO: Fix error if there is no menu created
//TODO: enable disable search place holder text

//TODO: fix a on hover
//TODO: check message 
add_action( 'admin_notices', 'no_nav_menu' );
if (empty($menus)) {

    no_nav_menu();
    /* $message = sprintf(
        esc_html__('"%1$s" requires at least "%2$s" to be used.', 'jabago-custom-nav-menu'),
        '<strong>' . esc_html_e('Jabago Custom Nav Menu', 'jabago-custom-nav-menu') . '</strong>',
        '<strong>' . esc_html__('one nav menu', 'jabago-custom-nav-menu') . '</strong>',
        '<a href="#">' . esc_html__('Create menu', 'jabago-custom-nav-menu') . '</a>'
    );
    printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message); */
}


function no_nav_menu() {
    ?>
    <div class="notice notice-warning mcnm-notice">
        <img src="<?= JABAGO_CUSTOM_NAV_MENU_URL . '/includes/img/boton-menu.svg' ?>" width="50px">
        <p>
            <strong><?= esc_html_e('Jabago Custom Nav Menu', 'jabago-custom-nav-menu') ?></strong>
            <?= esc_html_e('requires at least', 'jabago-custom-nav-menu') ?>
            <strong><?= esc_html_e('one nav menu', 'jabago-custom-nav-menu') ?></strong>
            <?= esc_html_e('to be used.', 'jabago-custom-nav-menu') ?>
        </p>
    </div>
    <?php
}


?>

<!-- HTML -->

<div class="wrap">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://yoursite.com/wp-content/themes/yourtheme/style.css" media="all">
    <h2></h2>

    <div class="settings-header-page">
        <span class="plugin-logo"><img src="<?= esc_attr(JABAGO_CUSTOM_NAV_MENU_URL . '/includes/img/boton-menu.svg') ?>" alt=""> </span>
        <div>
            <h3><?= esc_html_e( 'Jabago Menu Settings', 'jabago-custom-nav-menu' ) ?></h3>
            <h4><?= esc_html_e( 'friendly use jabago nav menu', 'jabago-custom-nav-menu' ) ?></h4>
        </div>
    </div>


    <!-- tab links -->
    <div class="tabs">
        <label class="tab default" onClick="openTab(event, 'general')"> <?= esc_html_e( 'General Options', 'jabago-custom-nav-menu' ) ?> </label>
        <label class="tab" onClick="openTab(event, 'header')"><?= esc_html_e( 'Header', 'jabago-custom-nav-menu' ) ?></label>
        <label class="tab" onClick="openTab(event, 'footer')"><?= esc_html_e( 'Footer', 'jabago-custom-nav-menu' ) ?></label>
        <label class="tab" onClick="openTab(event, 'style-presets')"><?= esc_html_e( 'Style Presets', 'jabago-custom-nav-menu' ) ?></label>
        <label class="tab" onClick="openTab(event, 'custom-colors')"><?= esc_attr( 'Customize Style', 'jabago-custom-nav-menu' ) ?></label>
        <label class="tab" onClick="openTab(event, 'item-icon')"><?= esc_html_e( 'Menu Icon', 'jabago-custom-nav-menu' ) ?></label>
    </div>
    <div class="settings">
        <div class="settings-options">

            <form method="post">

                <!-- General Tab -->
                <div id="general" class="tab-content">
                    <div class="option">
                        <div class="label">
                            <label for="menu-active"><?= esc_html_e('Activate jabago menu', 'jabago-custom-nav-menu') ?></label>
                        </div>
                        <div class="checkbox-input">
                            <input <?= $records != null && $records->showMenu == 'on' ? 'checked' : ''; ?> class="tgl-skewed" type="checkbox" name="show-menu" id="show-menu" onclick="enable_input('menu-active', this)">
                            <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="show-menu"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="menu-select"><?= esc_html_e('Select Menu', 'jabago-custom-nav-menu') ?></label>
                        </div>

                        <div class="select-input">
                            <select <?= $records != null && $records->showMenu == 'on' ? '' : 'disabled'; ?> id="menu-select" name='menu_id' class="menu-active">

                                <?php
                                $html = '';
                                if (empty($menus)) {
                                    $html = esc_html_e( 'You must create a menu', 'jabago-custom-nav-menu' ) ;
                                }
                                foreach ($menus as $key => $menu) {
                                    $selected = '';
                                    if ($menu['id'] == $records->menuId) {
                                        $selected = 'selected';
                                    }
                                    $html .= '<option value="' . esc_attr( $menu['id'] ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $menu['name'] ) . '</option>';
                                }

                                echo $html;
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="menu-select"> <?= esc_html_e( 'Menu button horizontal position', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="radio-input">
                            <input <?php echo esc_attr( $records != null && $records->showMenu == 'on' ? '' : 'disabled' ); ?> class="menu-active" <?php echo esc_attr( $records != null && $records->buttonAlignment && $records->buttonAlignment == 'left' ? 'checked' : '' ); ?> type="radio" name="button-alignment" id="button-alignment-left" value="left">
                            <label for="button-alignment-left" data="LEFT"></label>
                            <input <?php echo esc_attr( $records != null && $records->showMenu == 'on' ? '' : 'disabled' ); ?> class="menu-active" <?php echo esc_attr( $records != null && $records->buttonAlignment && $records->buttonAlignment == 'center' ? 'checked' : '' ); ?> type="radio" name="button-alignment" id="button-alignment-center" value="center">
                            <label for="button-alignment-center" data="CENTER"></label>
                            <input <?php echo esc_attr( $records != null && $records->showMenu == 'on' ? '' : 'disabled' ); ?> class="menu-active <?php echo esc_attr( $records != null ? '' : 'default' ); ?>" <?php echo esc_attr( $records != null && $records->buttonAlignment && $records->buttonAlignment == 'right' ? 'checked' : '' ); ?> type="radio" name="button-alignment" id="button-alignment-right" value="right">
                            <label for="button-alignment-right" data="RIGHT"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="menu-select"> <?= esc_html_e( 'Menu button vertical position', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="radio-input">
                            <input <?php echo esc_attr( $records != null && $records->showMenu == 'on' ? '' : 'disabled' ); ?> class="menu-active" <?php echo esc_attr( $records != null && $records->buttonVerticalAlignment && $records->buttonVerticalAlignment == 'top' ? 'checked' : '' ); ?> type="radio" name="button-vertical-alignment" id="button-vertical-alignment-top" value="top">
                            <label for="button-vertical-alignment-top" data="TOP"></label>
                            <input <?php echo esc_attr( $records != null && $records->showMenu == 'on' ? '' : 'disabled' ); ?> class="menu-active <?php echo esc_attr( $records != null ? '' : 'default' ); ?>" <?php echo esc_attr( $records != null && $records->buttonVerticalAlignment && $records->buttonVerticalAlignment == 'bottom' ? 'checked' : '' ); ?> type="radio" name="button-vertical-alignment" id="button-vertical-alignment-bottom" value="bottom">
                            <label for="button-vertical-alignment-bottom" data="BOTTOM"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="menu-select"> <?= esc_html_e( 'Menu position', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="radio-input">
                            <input <?php echo esc_attr( $records != null && $records->showMenu == 'on' ? '' : 'disabled' ); ?> class="menu-active" <?php echo esc_attr( $records != null && $records->menuAlignment && $records->menuAlignment == 'left' ? 'checked' : '' ); ?> type="radio" name="menu-alignment" id="menu-alignment-left" value="left">
                            <label for="menu-alignment-left" data="LEFT"></label>
                            <input <?php echo esc_attr( $records != null && $records->showMenu == 'on' ? '' : 'disabled' ); ?> class="menu-active" <?php echo esc_attr( $records != null && $records->menuAlignment && $records->menuAlignment == 'center' ? 'checked' : '' ); ?> type="radio" name="menu-alignment" id="menu-alignment-center" value="center">
                            <label for="menu-alignment-center" data="CENTER"></label>
                            <input <?php echo esc_attr( $records != null && $records->showMenu == 'on' ? '' : 'disabled' ); ?> class="menu-active <?php echo esc_attr( $records != null ? '' : 'default' ); ?>" <?php echo esc_attr( $records != null && $records->menuAlignment && $records->menuAlignment == 'right' ? 'checked' : '' ); ?> type="radio" name="menu-alignment" id="menu-alignment-right" value="right">
                            <label for="menu-alignment-right" data="RIGHT"></label>
                        </div>
                    </div>
                </div>

                <!-- Header Tab -->
                
                <div id="header" class="tab-content">

                    <div class="option">
                        <div class="label">
                            <label for="show-header"> <?= esc_html_e( 'Show menu header', 'jabago-custom-nav-menu' ) ?> </label>
                        </div>
                        <div class="checkbox-input">
                            <input <?php echo esc_attr( $records != null && $records->showHeader == 'on' ? 'checked' : '' ); ?> class="tgl-skewed" type="checkbox" name="show-header" id="show-header" onclick="enable_input('header-style', this)">
                            <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="show-header"></label>
                        </div>
                    </div>

                    <div class="option">
                        <div class="label">
                            <label for="header-search"> <?= esc_html_e( 'Show menu search', 'jabago-custom-nav-menu' ) ?> </label>
                        </div>
                        <div class="checkbox-input">
                            <input onclick="enable_input('header-search', this)" <?php echo esc_attr( $records != null && $records->headerSearch == 'on' ? 'checked' : '' );
                                    echo esc_attr( $records != null && $records->showHeader == 'on' ? '' : ' disabled' ); ?> class="tgl-skewed header-style" type="checkbox" name="header-search" id="header-search">
                            <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="header-search"></label>
                        </div>
                    </div>

                    <div class="option">
                        <div class="label">
                            <label for="search-text"><?= esc_html_e( 'Search place holder', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="text-input">
                            <input value="<?= esc_attr( $records != null ? $records->searchText : '' ) ?> " <?= esc_attr( $records != null && $records->showHeader == 'on' ? '' : 'disabled' ); ?> class="header-style" type="text" name="search-text" id="search-text">
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="header-type"> <?= esc_html_e( 'Select header image type', 'jabago-custom-nav-menu' ) ?> </label>
                        </div>
                        <div class="input">
                            <select onchange="enable_custom_header_image_input(this.value)" <?php echo esc_attr( $records != null && $records->showHeader == 'on' ? '' : 'disabled' ); ?> name="header-type" class="header-style">
                                <option <?php echo esc_attr( $records != null ? '' : 'selected' ); ?> <?php echo esc_attr( $records != null && $records->headerType == 'logo' ? 'selected' : '' ); ?> value="logo"> <?= esc_html_e( 'Site logo', 'jabago-custom-nav-menu' ) ?> </option>
                                <option <?php echo esc_attr( $records != null && $records->headerType == 'avatar' ? 'selected' : '' ); ?> value="avatar"> <?= esc_html_e( 'User avatar', 'jabago-custom-nav-menu' ) ?></option>
                                <option <?php echo esc_attr( $records != null && $records->headerType == 'custom-image' ? 'selected' : '' ); ?> value="custom-image"> <?= esc_html_e( 'Custom Image', 'jabago-custom-nav-menu' ) ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="option" id="logo-select-container" style="display:<?= $records == null ? esc_attr( 'none' ) : ( $records->headerType == 'custom-image' ? 'grid' : 'none' ) ?>">
                        <div class="label">
                            <label for="header-custom-image"><?= esc_html_e( 'Select header image', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="input">
                            <label type="reset" id="logo-preview-container" class="upload_custom_image" onclick="select_logo();"><?= '<img src="' . esc_attr($records != null && $records->headerType == 'custom-image' ? $records->logo : JABAGO_CUSTOM_NAV_MENU_URL . 'includes/img/logo_placeholder.svg') . '" style="object-fit:contain" width=100 height=100 name="logo-preview" id="logo-preview" style="object-fit: cover;">'; ?></label>
                            <input style="display:none;" type="text" name="logo" id="logo" value="<?= esc_attr( $records != null && $records->headerType == 'custom-image' ? $records->logo : JABAGO_CUSTOM_NAV_MENU_URL . 'includes/img/logo_placeholder.svg' ) ?>" />
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for=""><?= esc_html_e( 'Header alignment', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="radio-input">
                            <input <?php echo esc_attr( $records != null && $records->headerAlignment == 'left' ? 'checked' : '' );
                                    echo esc_attr( $records != null && $records->showHeader == 'on' ? '' : ' disabled' ); ?> class="header-style" type="radio" name="header-alignment" id="header-alignment-left" value="left">
                            <label for="header-alignment-left" data="LEFT"></label>
                            <input  <?php echo esc_attr( $records != null && $records->headerAlignment == 'center' ? 'checked' : '' );
                                    echo esc_attr( $records != null && $records->showHeader == 'on' ? '' : ' disabled' ); ?> class="header-style <?php echo $records != null ? '' : 'default'; ?>" type="radio" name="header-alignment" id="header-alignment-center" value="center">
                            <label for="header-alignment-center" data="CENTER"></label>
                            <input <?php echo esc_attr( $records != null && $records->headerAlignment == 'right' ? 'checked' : '' );
                                    echo esc_attr( $records != null && $records->showHeader == 'on' ? '' : ' disabled' ); ?> class="header-style" type="radio" name="header-alignment" id="header-alignment-right" value="right">
                            <label for="header-alignment-right" data="RIGHT"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="show-header"><?= esc_html_e( 'Header text', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="text-input">
                            <input value="<?= esc_attr( $records != null ? $records->headerText : '' ) ?> " <?= esc_attr( $records != null && $records->showHeader == 'on' ? '' : 'disabled' ); ?> class="header-style" type="text" name="header-text" id="show-header">
                        </div>
                    </div>

                </div>

                <!-- Footer Tab -->
                <div id="footer" class="tab-content">
                    <div class="option">
                        <div class="label">
                            <label for="show-footer"><?= esc_html_e( 'Show menu footer', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="checkbox-input">
                            <input <?php echo esc_attr( $records != null && $records->showFooter == 'on' ? 'checked' : '' ); ?> class="tgl-skewed" type="checkbox" name="show-footer" id="show-footer" onclick="enable_input('footer-style', this)">
                            <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="show-footer"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="show-logout"><?= esc_html_e( 'Show logout login', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="checkbox-input">
                            <input onclick="enable_input('footer-login', this)" <?php echo esc_attr( $records != null && $records->showLogin == 'on' ? 'checked' : '' );
                                    echo esc_attr( $records != null && $records->showFooter == 'on' ? '' : ' disabled' ); ?> class="tgl-skewed footer-style" type="checkbox" name="show-login" id="show-login">
                            <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="show-login"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="show-logout"><?= esc_html_e( 'Set login page', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="checkbox-input">
                            <select class="footer-login footer-style" <?php echo esc_attr( $records != null && $records->showHeader == 'on' && $records->showLogin == 'on' ? '' : 'disabled' ); ?> name="login-url">
                                <?php
                                
                                foreach ($pages as $key => $page) {
                                    echo '<option value="' . esc_attr( $page['url'] ) . '" ' . esc_attr( $records != null && $records->loginUrl == $page['url'] ? 'selected' : '' ) . '>' . esc_html( $page['name'] ) . '</option>';
                                }
                                
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="show-logout"><?= esc_html_e( 'Set register page', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="checkbox-input">
                            <select class="footer-login footer-style" <?php echo esc_attr( $records != null && $records->showHeader == 'on' && $records->showLogin == 'on' ? '' : 'disabled' ); ?> name="register-url">
                                <?php
                                
                                foreach ($pages as $key => $page) {
                                    echo '<option value="' . esc_attr( $page['url'] ) . '" ' . esc_attr( $records != null && $records->registerUrl == $page['url'] ? 'selected' : '' ) . '>' . esc_html( $page['name'] ) . '</option>';
                                }
                                
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for=""><?= esc_html_e( 'Footer alignment', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="radio-input">
                            <input <?php echo esc_attr( $records != null && $records->footerAlignment == 'left' ? 'checked' : '' );
                                    echo esc_attr( $records != null && $records->showFooter == 'on' ? '' : ' disabled' ); ?> class="footer-style <?php echo esc_attr( $records != null ? '' : 'default' ); ?>" type="radio" name="footer-alignment" id="footer-alignment-left" value="left">
                            <label for="footer-alignment-left" data="LEFT"></label>
                            <input <?php echo esc_attr( $records != null && $records->footerAlignment == 'center' ? 'checked' : '' );
                                    echo esc_attr( $records != null && $records->showFooter == 'on' ? '' : ' disabled' ); ?> class="footer-style" type="radio" name="footer-alignment" id="footer-alignment-center" value="center">
                            <label for="footer-alignment-center" data="CENTER"></label>
                            <input <?php echo esc_attr( $records != null && $records->footerAlignment == 'right' ? 'checked' : '' );
                                    echo esc_attr( $records != null && $records->showFooter == 'on' ? '' : ' disabled' ); ?> class="footer-style" type="radio" name="footer-alignment" id="footer-alignment-right" value="right">
                            <label for="footer-alignment-right" data="RIGHT"></label>
                        </div>
                    </div>
                </div>


                <!-- Color Tab -->
                <div id="custom-colors" class="tab-content">


                    <div class="option">
                        <div class="label">
                            <label for="bg-color"><?= esc_html_e( 'Background color', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="color-input">
                            <input type="color" name="background_color" class="bg-color-color-picker" value="<?php echo esc_attr( $records != null ? $records->style->menuBackground[0] : $style_preset['dark']['menuBackground'][0] ) ?>">
                        </div>
                    </div>

                    <div class="option">
                        <div class="label">
                            <label for="f-color"><?= esc_html_e( 'Font color', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="color-input">
                            <input type="color" name="front_color" class="front-color-picker" value="<?php echo esc_attr( $records ? $records->style->fontColor[0] : $style_preset['dark']['fontColor'][0] ) ?>">
                        </div>
                    </div>

                    <div class="option">
                        <div class="label">
                            <label for="s-item-bg-color"><?= esc_html_e( 'Selected item background color', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="color-input">
                            <input type="color" name="selected_item_background_color" class="select-item-bg-color-picker" value="<?php echo esc_attr( $records ? ($records->stylePreset == 'glass' ? substr($records->style->selectedItemBackground[0], 0, -2) : $records->style->selectedItemBackground[0]) : $style_preset['dark']['selectedItemBackground'][0] ) ?>">
                        </div>
                    </div>

                    <div class="option">
                        <div class="label">
                            <label for="s-item-color"><?= esc_html_e( 'Selected item font color', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="color-input">
                            <input type="color" name="selected_item_color" class="select-item-color-picker" value="<?php echo esc_attr( $records ? $records->style->selectedItemColor[0] : $style_preset['dark']['selectedItemColor'][0] ) ?>">
                        </div>
                    </div>

                    <div class="option">
                        <div class="label">
                            <label for="s-font-size"><?= esc_html_e( 'Font size', 'jabago-custom-nav-menu' ) ?></label>
                        </div>
                        <div class="slider-input">
                            <input step="0.01" min="1" max="4" type="range" name="item_font_size" class="select-font-size-picker range-picker" oninput="slider()" value="<?php echo esc_attr( $records ? substr($records->style->fontSize[0], 0, -2) : substr($style_preset['dark']['fontSize'][0], 0, -2) ) ?>">
                            <span>0</span>
                        </div>

                    </div>

                </div>

                <!-- Presets Tab -->
                <div id="style-presets" class="tab-content">
                    <div class="style-presets-table">
                        <div class="preset <?= esc_attr( !empty($records) && $records->stylePreset == 'dark' ? 'selected' : '' ); ?>" style="background: url(<?= esc_attr(plugin_dir_url(__FILE__) . 'img/dark.png'); ?>); background-size:cover; background-repeat:no-repeat;">
                            <div class="preset-info">
                                <div class="info">
                                    <h4>Dark</h4>
                                    <div class="radio-input">
                                        <input class="<?php echo esc_attr($records && $records->stylePreset ? $records->stylePreset : 'default') ?>" type="radio" name="style_preset" id="dark" value="dark" <?php echo esc_attr( !empty($records) && $records->stylePreset == 'dark' ? 'checked' : '' ); ?>>
                                        <label class="style-radio" for="dark" data="select"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="preset <?= esc_attr( !empty($records) && $records->stylePreset == 'light' ? 'selected' : '' ); ?>" style="background: url(<?= esc_attr(plugin_dir_url(__FILE__) . 'img/light.png'); ?>); background-size:cover; background-repeat:no-repeat;">
                            <div class="preset-info">
                                <div class="info">
                                    <h4>Light</h4>
                                    <div class="radio-input">
                                        <input type="radio" name="style_preset" id="light" value="light" <?php echo esc_attr( !empty($records) && $records->stylePreset == 'light' ? 'checked' : '' ); ?>>
                                        <label class="style-radio" for="light" data="select"></label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="preset <?= esc_attr( !empty($records) && $records->stylePreset == 'blue' ? 'selected' : '' ); ?>" style="background: url(<?= esc_attr(plugin_dir_url(__FILE__) . 'img/blue.png'); ?>); background-size:cover; background-repeat:no-repeat;">
                            <div class="preset-info">
                                <div class="info">
                                    <h4>Blue</h4>
                                    <div class="radio-input">
        
                                        <input type="radio" name="style_preset" id="blue" value="blue" <?php echo esc_attr( !empty($records) && $records->stylePreset == 'blue' ? 'checked' : '' ); ?>>
        
                                        <label class="style-radio" for="blue" data="select"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="preset <?= esc_attr( !empty($records) && $records->stylePreset == 'glass' ? 'selected' : '' ); ?>" style="background: url(<?= esc_attr(plugin_dir_url(__FILE__) . 'img/glass.png'); ?>); background-size:cover; background-repeat:no-repeat;">
                            <div class="preset-info">
                                <div class="info">
                                    <h4>Glass</h4>
                                    <div class="radio-input">
        
                                        <input type="radio" name="style_preset" id="glass" value="glass" <?php echo esc_attr( !empty($records) && $records->stylePreset == 'glass' ? 'checked' : '' ); ?>>
        
                                        <label class="style-radio" for="glass" data="select"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Item Icon Tab -->
                <div id="item-icon" class="tab-content">
                    <div class="option">

                        <h2><?= esc_html_e( 'Under construction', 'jabago-custom-nav-menu' ) ?></h2>

                        <ul class="item-icon">
                            <?php
                            $items = wp_get_nav_menu_items($records->menuId);

                            if(empty($items)){
                                $items = [];
                            }

                            $html = '';

                            foreach ($items as $key => $value) {
                                $html .= '<li class="icon-selector">';
                                $html .= '<p>' . esc_html( $value->title ) . '</p>';
                                $html .= '<label onClick="showIconSelectorPanel(' . esc_attr( $key ) . ')" for="" class="icon-selector-button" id="menu-item-' . esc_attr( $key ) . '">no Icon</label>';
                                $html .= '</li>';
                            }
                            echo $html;
                            ?>

                        </ul>
                    </div>
                </div>
                <br><br>
                <button class="mcnm-button" type="submit" name="save-settings"><?= esc_html_e( 'Save Changes', 'jabago-custom-nav-menu' ) ?></button>
            </form>
        </div>
        <div class="preview">
            <div class="previw-back">
                <h1>My Web</h1>
                <br>
                <h2>About Us</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa commodi optio ad non totam repellat, aliquam magnam nulla neque iusto porro, aperiam quisquam dolores similique numquam deserunt. Vel, dolores corrupti!</p>
                <h3>Portfolio</h3>
                <ul>
                    <li>Project 1</li>
                    <li>Project 2</li>
                    <li>Project 3</li>
                    <li>Project 4</li>
                </ul>
            </div>
            <?php

            function custom_search_form()
            {
                $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_attr( home_url('/') ) . '" >
                                <div class="search-form"><label class="screen-reader-text" for="s">' . esc_html_e('Search:', 'jabago-custom-nav-menu') . '</label>
                                    <input class="search-text-input" type="text" value="" name="s" id="s" />
                                    <button class="search-button" type="submit" id="searchsubmit" >' . file_get_contents(JABAGO_CUSTOM_NAV_MENU_URL . 'includes/img/search-icon.svg') . '</button>
                                </div>
                            </form>';

                return $form;
            }


            $settings = new Jabago_Cnm_Settings_Management;

            $records = $settings->load_settings();

            $header = '';

            $logout = '';

            $search = custom_search_form();

            if (!empty($records) && $records->showHeader == 'on') {

                $header = '<div class="header">';

                if ($records->headerType == 'logo') {

                    $header .= '<div class="blog-logo ' . esc_attr($records->headerAlignment) . '" >' . get_custom_logo() . '</div>';
                }
                if ($records->headerType == 'avatar') {

                    $header .= '<div class="user-avatar ' . esc_attr($records->headerAlignment) . '"><img src="' . esc_attr(get_avatar_url(wp_get_current_user()->ID)) . '"><a href="' . esc_attr(wp_get_current_user()->user_url) . '">' . esc_html(wp_get_current_user()->display_name) . '</a></div>';
                }
                if ($records->headerText) {
                    $header .= '<div class="custom-text"><h2 class="' . esc_attr( $records->headerAlignment ) . '">' . esc_attr( $records->headerText ) . '</h2></div>';
                }
                if ($records->headerSearch == 'on') {
                    $header .= '<div class="custom-text">' . $search . '</div>';
                }

                $header .= '</div>';
            } else {
                $header = '<br><br>';
            }



            add_filter('get_search_form', 'custom_search_form', 40);



            if (!empty($records) && $records->showFooter == 'on') {
                
                

                if (is_user_logged_in() && $records->showLogin == 'on') {

                    $logout = '<br><hr><br><div class="menu-footer ' . esc_attr($records->footerAlignment) . '"><a href="' . esc_attr(wp_logout_url('home')) . '">Log Out</a></div>';
                }
            }

            
            if(!empty( $menus )){

                wp_nav_menu(array(
                    'menu' => !empty($records->menuId) ? $records->menuId : (object) array('term_id' => 0),
                    'container' => 'div',
                    'container_class' => 'floating-nav-menu-container',
                    'menu_class' => 'floating-nav-menu ' . esc_attr($records->stylePreset) . ' down ' . esc_attr($records->menuAlignment),
                    'menu_id' => 'loco',
                    'items_wrap' => '<ul data-visible="true" class="%2$s">%3$s</ul>',
                    'walker' => !empty($records->menuId) ? new Preview_Jabago_Custom_nav_menu_walker() : null,
                ));

            }
            ?>
        </div>

    </div>

    <div class="icon-modal hide" id="icon-panel">
        <div class="panel">
            <div class="header">
                <h3><?= esc_html_e( 'Select Icon', 'jabago-custom-nav-menu' ) ?></h3><span>&times;</span>
            </div>
            <br>
            <br>

            <div class="content">

                <?php

                $icons = get_icons();
                $icon = '';

                foreach ($icons as $key => $value) {
                    $icon .= '<div>';

                    $icon .= '<img src="' . esc_attr(plugin_dir_url(__FILE__) . '../includes/icons/' . $value) . '" ></img>';
                    $icon .= '</div>';
                }
                echo $icon;

                ?>
            </div>
        </div>
    </div>
</div>



<script>
    var defaultInputs = document.getElementsByClassName('default');

    for (let index = 0; index < defaultInputs.length; index++) {
        const element = defaultInputs[index];

        if (element.disabled) {
            element.disabled = false;
            element.click();
            element.disabled = true;
        } else {
            element.click();
        }

    }
    slider();
</script>
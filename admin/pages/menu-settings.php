<?php

require_once plugin_dir_path( __FILE__ ) . 'partials/style-presets.php';
require_once plugin_dir_path( __DIR__ ) . 'classes/settings-management.php';



$setting_manager = new WpSettingsManagement;

$menus = $setting_manager->get_menus_list();

$records = $setting_manager->load_settings();


global $wpdb;

$fm_current_settings_table = $wpdb -> prefix . 'jb_mobile_menu';


$current_style_preset = 'dark';

if(isset($records->stylePreset)){
    $current_style_preset = $records->stylePreset;
}



function get_icons(){

    $files = scandir( plugin_dir_path( __DIR__).'assets/icons/');
    unset($files[0]);
    unset($files[1]);
    return $files;
}


if(isset($_POST['save-settings'])){
    
    
    
    $settings_data = [];

    $customStructure = [];

    /* Style settings */
    
    if($_POST['style_preset'] == $current_style_preset){


        if(isset($_POST['background_color'])){
            $settings_data['style']['menuBackground'] = [$_POST['background_color'], 2];
        }

        if(isset($_POST['front_color'])){
            $settings_data['style']['fontColor'] = [$_POST['front_color'], 3];
        }

        if(isset($_POST['selected_item_background_color'])){
        
            $settings_data['style']['selectedItemBackground'] = [$_POST['selected_item_background_color'], 4];
        }

        if(isset($_POST['selected_item_color'])){
        
            $settings_data['style']['selectedItemColor'] = [$_POST['selected_item_color'], 5];
        }

        if(isset($_POST['item_font_size'])){
        
            $settings_data['style']['fontSize'] = [$_POST['item_font_size'] . 'em', 6];
        }
            
    }else{
            foreach ($style_preset[$_POST['style_preset']] as $key => $value) {
            $settings_data['style'][$key] = $value;
        }
        
    }


    //////////////////////////* general settings *//////////////////////////
    
    
    if(isset($_POST['show-menu'])){
        $settings_data['showMenu'] = $_POST['show-menu'];
    }else{
        $settings_data['showMenu'] = 'off';
    }

    if(isset($_POST['menu_id'])){
        $settings_data['menuId'] = $_POST['menu_id'];
    }else{
        $settings_data['menuId'] = '';
    }
    

    if(isset($_POST['show-menu'])){
        $settings_data['buttonAlignment'] = $_POST['button-alignment'];
    }else{
        $settings_data['buttonAlignment'] = $records ? $records->buttonAlignment : 'right';
    }
    
    if(isset($_POST['show-menu'])){
        $settings_data['menuAlignment'] = $_POST['menu-alignment'];
    }else{
        $settings_data['menuAlignment'] = $records ? $records->menuAlignment : 'right';
    }

    //////////////////////////* Header settings *//////////////////////////


    if(isset($_POST['show-header'])){
        $settings_data['showHeader'] = $_POST['show-header'];
    }else{

        $settings_data['showHeader'] = 'off';
    }

    
    if(isset($_POST['show-header'])){
        $settings_data['headerType'] = $_POST['header-type'];
    }else{
        $settings_data['headerType'] = $records ? $records->headerType : 'logo';
    }
    
    if(isset($_POST['show-header'])){
        $settings_data['headerAlignment'] = $_POST['header-alignment'];
    }else{
        
        $settings_data['headerAlignment'] = $records ? $records->headerAlignment : 'center';

    }

    if(isset($_POST['header-text'])){
        $settings_data['headerText'] = $_POST['header-text'];
    }else{
        $settings_data['headerText'] = $records ? $records->headerText : '';
    }

    if(isset($_POST['header-search'])){
        $settings_data['headerSearch'] = $_POST['header-search'];
    }else{
        $settings_data['headerSearch'] = $records ? $records->headerSearch : 'off';
    }

    //////////////////////////* Footer settings *//////////////////////////

    if(isset($_POST['show-footer'])){
        $settings_data['showFooter'] = $_POST['show-footer'];
    }else{
        $settings_data['showFooter'] = 'off';
    }
    if(isset($_POST['show-login'])){
        $settings_data['showLogin'] = $_POST['show-login'];
    }else{
        $settings_data['showLogin'] = $records ? $records->showLogin : 'off';
    }
    if(isset($_POST['show-footer'])){
        $settings_data['footerAlignment'] = $_POST['footer-alignment'];
    }else{
        $settings_data['footerAlignment'] = $records ? $records->footerAlignment : 'left';
    }

    //////////////////////////* Presets settings *//////////////////////////

    if(isset($_POST['style_preset'])){
        $settings_data['stylePreset'] = $_POST['style_preset'];
    }else{
        $settings_data['stylePreset'] = $records ? $records->stylePreset : 'dark';
    }

    $records = $setting_manager->save_general_settings($settings_data);

}


?>


<!-- HTML -->

<div class="wrap">
    
    <div class="settings-header-page">
        <span class="plugin-logo"></span>
        <h3>Mobile Menu Settings</h3>
    </div>


    <div class="settings">
        <div class="settings-options">
            
            <!-- tab links -->
            <div class="tabs">
                <button class="tab default" onClick="openTab(event, 'general')">General Options</button>
                <button class="tab" onClick="openTab(event, 'header')">Header</button>
                <button class="tab" onClick="openTab(event, 'footer')">Footer</button>
                <button class="tab" onClick="openTab(event, 'style-presets')">Style Presets</button>
                <button class="tab" onClick="openTab(event, 'custom-colors')">Style</button>
                <button class="tab" onClick="openTab(event, 'item-icon')">Menu Icon</button>
            </div>
            <form method="post">
            <!-- tabs content -->
    
                <!-- General Tab -->
                <div id="general" class="tab-content">
                    <div class="option">
                        <div class="label">
                            <label for="menu-active">Activate mobile menu</label>
                        </div>
                        <div class="checkbox-input">
                            <input <?php echo $records != null && $records->showMenu == 'on' ? 'checked' : ''; ?> class="tgl-skewed" type="checkbox" name="show-menu" id="show-menu" onclick="enable_input('menu-active')">
                            <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="show-menu"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="menu-select">Select Menu</label>
                        </div>
                
                        <div class="select-input">
                            <select <?php echo $records != null && $records->showMenu == 'on' ? '' : 'disabled'; ?> id="menu-select" name='menu_id' class="menu-active">
                                
                                <?php
                                    if(empty($menus)){
                                        echo 'You must create a menu';
                                    }
                                    foreach ($menus as $key => $menu) {
                                        $selected = '';
                                        if($menu['id'] == $records->menuId){
                                            $selected = 'selected';
                                        }
                                        echo '<option value="'.$menu['id'].'" '.$selected.'>'.$menu['name'].'</option>' ;
                                    }
                                ?>
        
                            </select>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="menu-select">Menu button position</label>
                        </div>
                        <div class="radio-input">
                            <input <?php echo $records != null && $records->showMenu == 'on' ? '' : 'disabled'; ?> class="menu-active" <?php echo $records != null && $records->buttonAlignment && $records->buttonAlignment == 'left' ? 'checked' : ''; ?> type="radio" name="button-alignment" id="button-alignment-left" value="left">
                            <label for="button-alignment-left" data="LEFT"></label>
                            <input <?php echo $records != null && $records->showMenu == 'on' ? '' : 'disabled'; ?> class="menu-active" <?php echo $records != null && $records->buttonAlignment && $records->buttonAlignment == 'center' ? 'checked' : ''; ?> type="radio" name="button-alignment" id="button-alignment-center" value="center">
                            <label for="button-alignment-center" data="CENTER"></label>
                            <input <?php echo $records != null && $records->showMenu == 'on' ? '' : 'disabled'; ?> class="menu-active <?php echo $records != null ? '' : 'default'; ?>" <?php echo $records != null && $records->buttonAlignment && $records->buttonAlignment == 'right' ? 'checked' : ''; ?> type="radio" name="button-alignment" id="button-alignment-right" value="right">
                            <label for="button-alignment-right" data="RIGHT"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="menu-select">Menu position</label>
                        </div>
                        <div class="radio-input">
                            <input <?php echo $records != null && $records->showMenu == 'on' ? '' : 'disabled'; ?> class="menu-active" <?php echo $records != null && $records->menuAlignment && $records->menuAlignment == 'left' ? 'checked' : ''; ?> type="radio" name="menu-alignment" id="menu-alignment-left" value="left">
                            <label for="menu-alignment-left" data="LEFT"></label>
                            <input <?php echo $records != null && $records->showMenu == 'on' ? '' : 'disabled'; ?> class="menu-active" <?php echo $records != null && $records->menuAlignment && $records->menuAlignment == 'center' ? 'checked' : ''; ?> type="radio" name="menu-alignment" id="menu-alignment-center" value="center">
                            <label for="menu-alignment-center" data="CENTER"></label>
                            <input <?php echo $records != null && $records->showMenu == 'on' ? '' : 'disabled'; ?> class="menu-active <?php echo $records != null ? '' : 'default'; ?>" <?php echo $records != null && $records->menuAlignment && $records->menuAlignment == 'right' ? 'checked' : ''; ?> type="radio" name="menu-alignment" id="menu-alignment-right" value="right">
                            <label for="menu-alignment-right" data="RIGHT"></label>
                        </div>
                    </div>
                </div>
    
                <!-- Header Tab -->
                <div id="header" class="tab-content">
                    <div class="option">
                        <div class="label">
                            <label for="show-header">Show menu header</label>
                        </div>
                        <div class="checkbox-input">
                            <input <?php echo $records != null && $records->showHeader == 'on' ? 'checked' : ''; ?> class="tgl-skewed" type="checkbox" name="show-header" id="show-header" onclick="enable_input('header-style')">
                            <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="show-header"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="header-search">Show menu search</label>
                        </div>
                        <div class="checkbox-input">
                            <input <?php echo $records != null && $records->headerSearch == 'on' ? 'checked' : ''; echo $records != null && $records->showHeader == 'on' ? '' : ' disabled'; ?> class="tgl-skewed header-style" type="checkbox" name="header-search" id="header-search">
                            <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="header-search"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="header-type">Show menu header</label>
                        </div>
                        <div class="input">
                            <select <?php echo $records != null && $records->showHeader == 'on' ? '' : 'disabled'; ?> name="header-type" class="header-style">
                                <option <?php echo $records != null && $records->headerType == 'logo' ? 'selected' : ''; ?> value="logo">Site logo</option>
                                <option <?php echo $records != null && $records->headerType == 'avatar' ? 'selected' : ''; ?> value="avatar">User avatar</option>
                            </select>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="">Header alignment</label>
                        </div>
                        <div class="radio-input">
                            <input <?php echo $records != null && $records->headerAlignment == 'left' ? 'checked' : ''; echo $records != null && $records->showHeader == 'on' ? '' : ' disabled'; ?> class="header-style" type="radio" name="header-alignment" id="header-alignment-left" value="left">
                            <label for="header-alignment-left" data="LEFT"></label>
                            <input <?php echo $records != null && $records->headerAlignment == 'center' ? 'checked' : ''; echo $records != null && $records->showHeader == 'on' ? '' : ' disabled'; ?> class="header-style <?php echo $records != null ? '' : 'default'; ?>" type="radio" name="header-alignment" id="header-alignment-center" value="center">
                            <label for="header-alignment-center" data="CENTER"></label>
                            <input <?php echo $records != null && $records->headerAlignment == 'right' ? 'checked' : ''; echo $records != null && $records->showHeader == 'on' ? '' : ' disabled'; ?> class="header-style" type="radio" name="header-alignment" id="header-alignment-right" value="right">
                            <label for="header-alignment-right" data="RIGHT"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="show-header">Header text</label>
                        </div>
                        <div class="text-input">
                            <input <?php echo $records != null ? 'value="'. $records->headerText.'"' : 'value=""'; echo $records != null && $records->showHeader == 'on' ? '' : 'disabled'; ?> class="header-style" type="text" name="header-text" id="show-header">
                        </div>
                    </div>
                    
                </div>
    
                <!-- Footer Tab -->
                <div id="footer" class="tab-content">
                    <div class="option">
                        <div class="label">
                            <label for="show-footer">Show menu footer</label>
                        </div>
                        <div class="checkbox-input">
                            <input <?php echo $records != null && $records->showFooter == 'on' ? 'checked' : ''; ?> class="tgl-skewed" type="checkbox" name="show-footer" id="show-footer" onclick="enable_input('footer-style')">
                            <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="show-footer"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="show-logout">Show logout or login</label>
                        </div>
                        <div class="checkbox-input">
                            <input <?php echo $records != null && $records->showLogin == 'on' ? 'checked' : ''; echo $records != null && $records->showFooter == 'on' ? '' : ' disabled'; ?> class="tgl-skewed footer-style" type="checkbox" name="show-login" id="show-login">
                            <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="show-login"></label>
                        </div>
                    </div>
                    <div class="option">
                        <div class="label">
                            <label for="">Footer alignment</label>
                        </div>
                        <div class="radio-input">
                            <input <?php echo $records != null && $records->footerAlignment == 'left' ? 'checked' : ''; echo $records != null && $records->showFooter == 'on' ? '' : ' disabled'; ?> class="footer-style <?php echo $records != null ? '' : 'default'; ?>" type="radio" name="footer-alignment" id="footer-alignment-left" value="left">
                            <label for="footer-alignment-left" data="LEFT"></label>
                            <input <?php echo $records != null && $records->footerAlignment == 'center' ? 'checked' : ''; echo $records != null && $records->showFooter == 'on' ? '' : ' disabled'; ?> class="footer-style" type="radio" name="footer-alignment" id="footer-alignment-center" value="center">
                            <label for="footer-alignment-center" data="CENTER"></label>
                            <input <?php echo $records != null && $records->footerAlignment == 'right' ? 'checked' : ''; echo $records != null && $records->showFooter == 'on' ? '' : ' disabled'; ?> class="footer-style" type="radio" name="footer-alignment" id="footer-alignment-right" value="right">
                            <label for="footer-alignment-right" data="RIGHT"></label>
                        </div>
                    </div>
                </div>
                
    
                <!-- Color Tab -->
                <div id="custom-colors" class="tab-content">
                    
                
                    <div class="option">
                        <div class="label">
                            <!-- <input type="checkbox" name="" id="bg-color" onclick="enable_input('bg-color-color-picker')"> -->
                            <label for="bg-color">Background color</label>
                        </div>
                        <div class="color-input">
                            <input type="color" name="background_color" class="bg-color-color-picker" value="<?php echo $records != null ? $records->style->menuBackground[0] : $style_preset['dark']['menuBackground'][0] ?>">
                        </div>
                    </div>
                    
                    <div class="option">
                        <div class="label">
                            <!-- <input type="checkbox" name="" id="f-color" onclick="enable_input('front-color-picker')"> -->
                            <label for="f-color">Font color</label>
                        </div>
                        <div class="color-input">
                            <input type="color" name="front_color" class="front-color-picker" value="<?php echo $records ? $records->style->fontColor[0] : $style_preset['dark']['fontColor'][0] ?>">
                        </div>
                    </div>
                    
                    <div class="option">
                        <div class="label">
                            <!-- <input type="checkbox" name="" id="s-item-bg-color" onclick="enable_input('select-item-bg-color-picker')"> -->
                            <label for="s-item-bg-color">Selected item background color</label>
                        </div>
                        <div class="color-input">
                            <input type="color" name="selected_item_background_color" class="select-item-bg-color-picker" value="<?php echo $records ? ($records->stylePreset == 'glass' ? substr($records->style->selectedItemBackground[0], 0, -2) : $records->style->selectedItemBackground[0] ) : $style_preset['dark']['selectedItemBackground'][0] ?>">
                        </div>
                    </div>
                    
                    <div class="option">
                        <div class="label">
                            <!-- <input type="checkbox" name="" id="s-item-color" onclick="enable_input('select-item-color-picker')"> -->
                            <label for="s-item-color">Selected item font color</label>
                        </div>
                        <div class="color-input">
                            <input type="color" name="selected_item_color" class="select-item-color-picker" value="<?php echo $records ? $records->style->selectedItemColor[0] : $style_preset['dark']['selectedItemColor'][0] ?>">
                        </div>
                    </div>
                    
                    <div class="option">
                        <div class="label">
                            <!-- <input type="checkbox" name="" id="s-font-size" onclick="enable_input('select-font-size-picker')"> -->
                            <label for="s-font-size">Font size</label>
                        </div>
                        <div class="slider-input">
                            <input step="0.01" min="1" max="4" type="range" name="item_font_size" class="select-font-size-picker range-picker" oninput="slider()" value="<?php echo $records ? substr($records->style->fontSize[0], 0, -2) : substr($style_preset['dark']['fontSize'][0], 0, -2) ?>">
                            <span>0</span>
                        </div>
                        
                    </div>
                    
                </div>
    
                <!-- Presets Tab -->
                <div id="style-presets" class="tab-content" >
                    <div style="display: flex;">
                        <div class="option">
                            <label for="dark">
                                <img src="<?php echo plugin_dir_url( __FILE__ ). '/img/dark.png'; ?>" width="120px" >
                            </label>
                            <br>
                            <div class="radio-input">
        
                                <input class="<?php echo $records && $records->stylePreset ? $records->stylePreset : 'default' ?>" type="radio" name="style_preset" id="dark" value="dark" <?php echo !empty($records) && $records->stylePreset == 'dark' ? 'checked' : ''; ?>>
                                
                                <label class="style-radio" for="dark" data="Dark"></label>
                            </div>
                        </div>
                        <div class="option">
                            <label for="light">
                                <img src="<?php echo plugin_dir_url( __FILE__ ). '/img/light.png'; ?>" width="120px" >
                            </label>
                            <br>
                            <div class="radio-input">
    
                                <input type="radio" name="style_preset" id="light" value="light" <?php echo !empty($records) && $records->stylePreset == 'light' ? 'checked' : ''; ?>>
                                <label class="style-radio" for="light" data="Light"></label>
                            </div>
                            
                        </div>
                        <div class="option">
                            <label for="blue">
                                <img src="<?php echo plugin_dir_url( __FILE__ ). '/img/blue.png'; ?>" width="120px" >
                            </label>
                            <br>
                            <div class="radio-input">
    
                                <input type="radio" name="style_preset" id="blue" value="blue" <?php echo !empty($records) && $records->stylePreset == 'blue' ? 'checked' : ''; ?>>
                                
                                <label class="style-radio" for="blue" data="Blue"></label>
                            </div>
                        </div>
                        <div class="option">
                            <label for="glass">
                                <img src="<?php echo plugin_dir_url( __FILE__ ). '/img/glass.png'; ?>" width="120px" >
                            </label>
                            <br>
                            <div class="radio-input">
    
                                <input type="radio" name="style_preset" id="glass" value="glass" <?php echo !empty($records) && $records->stylePreset == 'glass' ? 'checked' : ''; ?>>
                                
                                <label class="style-radio" for="glass" data="Glass"></label>
                            </div>
                        </div>
                        <div class="option">
                            <label for="custom-style">
                                <img src="<?php echo plugin_dir_url( __FILE__ ). '/img/glass.png'; ?>" width="120px" >
                            </label>
                            <br>
                            <div class="radio-input">
    
                                <input type="radio" name="style_preset" id="custom-style" value="custom-style" <?php echo !empty($records) && $records->stylePreset == 'custom-style' ? 'checked' : ''; ?>>
                                
                                <label class="style-radio" for="custom-style" data="Custom"></label>
                            </div>
                        </div>
                    </div>
                    
                </div>
    
                        
                <!-- Item Icon Tab -->
                <div id="item-icon" class="tab-content">
                    <div class="option">
                        
                        <h2>Under construction</h2>
                    
                        <ul class="item-icon">
                            <?php
                            $items = wp_get_nav_menu_items( $records->menuId );
    
                            
        
                            $html = '';
        
                            foreach ($items as $key => $value) {
                                $html .= '<li class="icon-selector">';
                                $html .= '<div><div>' . $value->title . '</div><br>';
                                $html .= '<div onClick="showIconSelectorPanel('.$key.')" class="icon-selector-button" id="menu-item-'.$key.'">no Icon</div>';
                                $html .= '</li>';
                            }
                            echo $html;
                            ?>
                            
                        </ul>
                    </div>
                </div>
                <br><br>
                <button class="button button-primary"  type="submit" name="save-settings">Save Changes</button>
            </form>
        </div>
        <div class="preview">
            <link rel="stylesheet" href="../css/wp_custom_floating_menu.css">
            <?php
            require_once(plugin_dir_path( __DIR__ ).'/classes/floating_nav_menu_walker.php');
            wp_nav_menu(array(
                //'theme_location'=>'primary',
                'menu' => !empty($records->menuId) ? $records->menuId : (object) array('term_id' => 0),
                'container' => 'nav',
                'container_class' => 'floating-nav-menu-container',
                'menu_class' => 'floating-nav-menu ' . $records->stylePreset . ' down ' . $records->menuAlignment,
                'menu_id' => 'loco',
                'items_wrap' => '<ul data-visible="true" class="%2$s">%3$s</ul>',
                'walker' => !empty($records->menuId) ? new floating_nav_menu_walker() : null,
            ));
            ?>
        </div>

    </div>
    
    <div class="icon-modal hide" id="icon-panel">
    <?php 

        $icons = get_icons();
        $icon = '';
                
        foreach ($icons as $key => $value) {
            $icon .= '<div>';
            $icon .= '<span style="background-image: url(\''.plugin_dir_url( __FILE__).'../assets/icons/'.$value.'\')" ></span> ' . $value;
            $icon .= '</div>';
        }
        echo $icon;

    ?>
        <a></a>
    </div>
</div>



<script>
    var notices = document.querySelectorAll('.notice');
    notices.forEach(element => {
        element.remove()
    });

    //document.getElementById('defaultTab').click();

    var defaultInputs = document.getElementsByClassName('default');

    for (let index = 0; index < defaultInputs.length; index++) {
        const element = defaultInputs[index];

        if(element.disabled){
            element.disabled = false;
            element.click();
            element.disabled = true;
        }else{
            element.click();
        }
        
    }
    slider();
</script>





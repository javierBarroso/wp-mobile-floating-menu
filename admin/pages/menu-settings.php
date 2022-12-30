<?php

$menus = wp_get_nav_menus();

$style_preset = [
    'dark' => [
        "--menuBackground" => ["#171717ff", 2],
        "--fontColor" => ["#747474ff", 3],
        "--selectedItemBackground" => ["#353535ff", 4],
        "--selectedItemColor" => ["#ffffffff", 5],
        "--fontSize" => ["1em", 6],
    ],
    'light' => [
        "--menuBackground" => ["#ffffffff", 2],
        "--fontColor" => ["#747474ff", 3],
        "--selectedItemBackground" => ["#eeeff6ff", 4],
        "--selectedItemColor" => ["#2a2e3aff", 5],
        "--fontSize" => ["1em", 6],
    ],
    'blue' => [
        "--menuBackground" => ["#2f49d1ff", 2],
        "--fontColor" => ["#8292e3ff", 3],
        "--selectedItemBackground" => ["#576cd9ff", 4],
        "--selectedItemColor" => ["#feffffff", 5],
        "--fontSize" => ["1em", 6],
    ]
];


global $wpdb;

$fm_current_settings_table = $wpdb -> prefix . 'floating_menu_settings';
$fm_custom_style_table = $wpdb -> prefix . 'floating_menu_custom_style_settings';


$query = 'SELECT * FROM '. $fm_current_settings_table;
$records = $wpdb->get_results($query, ARRAY_A);

$query = 'SELECT * FROM '. $fm_custom_style_table;
$style_records = $wpdb->get_results($query, ARRAY_A);
if(!empty($style_records)){

    $style_records = json_decode($style_records[0]['menu_structure']);
}

function get_icons(){

    $files = scandir( plugin_dir_path( __DIR__).'assets/img/');
    unset($files[0]);
    unset($files[1]);
    return $files;
}

function set_custom_css(array $style){

    global $wpdb;

    $fm_custom_style_table = $wpdb -> prefix . 'floating_menu_custom_style_settings';

    $query = 'SELECT * FROM '. $fm_custom_style_table;
    $records = $wpdb->get_results($query, ARRAY_A);

    $css_style = json_encode($style);

    $data = [
        'Id' => '1',
        'menu_id' => '1',
        'css_style' => $css_style,
    ];

    empty($records) ? $wpdb->insert($fm_custom_style_table, $data) : $wpdb->update($fm_custom_style_table, $data, array('Id' => 1));
    
    
    $filePath = plugin_dir_path( __FILE__ ) .'../css/wp_custom_floating_menu.css';
    
    $styleFile = file($filePath, FILE_IGNORE_NEW_LINES);
    
    foreach ($style as $key => $value) {
        
        $styleFile[$value[1]]= $key .' : '.$value[0].';';
        
    }
    
    file_put_contents($filePath, implode(PHP_EOL, $styleFile));

}

function save_structure($option){

    global $wpdb;

    $fm_custom_style_table = $wpdb -> prefix . 'floating_menu_custom_style_settings';

    $query = 'SELECT * FROM '. $fm_custom_style_table;
    $records = $wpdb->get_results($query, ARRAY_A);

    $structure_option = json_encode($option);

    $data = [
        'Id' => '1',
        'menu_id' => '1',
        'menu_structure' => $structure_option
    ];

    empty($records) ? $wpdb->insert($fm_custom_style_table, $data) : $wpdb->update($fm_custom_style_table, $data, array('Id' => 1));
    
}



if(isset($_POST['save-settings'])){

    $settings = [
        'Id' => 1,
        'current_menu' => $_POST['menu_id'],
        'style_menu' => $_POST['style_menu'],
    ];


    empty($records) ? $wpdb -> insert($fm_current_settings_table, $settings) : $wpdb -> update($fm_current_settings_table, $settings, array('Id' => 1));

    
    
    $query = 'SELECT * FROM '. $fm_current_settings_table;
    $records = $wpdb->get_results($query, ARRAY_A);


    
    $customCss = [];

    $customStructure = [];

    if($_POST['style_menu'] == 'custom-style'){



        if(isset($_POST['background_color'])){
            $customCss['--menuBackground'] = [$_POST['background_color'], 2];
        }

        if(isset($_POST['front_color'])){
            $customCss['--fontColor'] = [$_POST['front_color'], 3];
        }

        if(isset($_POST['selected_item_background_color'])){
           
            $customCss['--selectedItemBackground'] = [$_POST['selected_item_background_color'], 4];
        }

        if(isset($_POST['selected_item_color'])){
           
            $customCss['--selectedItemColor'] = [$_POST['selected_item_color'], 5];
        }

        if(isset($_POST['item_font_size'])){
           
            $customCss['--fontSize'] = [$_POST['item_font_size'] . 'em', 6];
        }

        
        /* $json = json_encode($customStructure);
        var_dump($json); */
    }else{
        
        foreach ($style_preset[$_POST['style_menu']] as $key => $value) {
            $customCss[$key] = $value;
        }
    }

    if(isset($_POST['show-header'])){
           
        $customStructure['showHeader'] = $_POST['show-header'];
    }else{

        $customStructure['showHeader'] = 'off';
    }
    
    if(isset($_POST['header-type'])){
       
        $customStructure['headerType'] = $_POST['header-type'];
    }
    
    if(isset($_POST['header-alignment'])){
       
        $customStructure['headerAlignment'] = $_POST['header-alignment'];
    }

    if(isset($_POST['header-text'])){
       
        $customStructure['headerText'] = $_POST['header-text'];
    }else{
        $customStructure['headerText'] = '';
    }

    if(isset($_POST['button-alignment'])){
       
        $customStructure['buttonAlignment'] = $_POST['button-alignment'];
    }
    
    if(isset($_POST['menu-alignment'])){
       
        $customStructure['menuAlignment'] = $_POST['menu-alignment'];
    }

    set_custom_css($customCss);
    
    save_structure($customStructure);

    $query = 'SELECT * FROM '. $fm_custom_style_table;
    $style_records = $wpdb->get_results($query, ARRAY_A);
    $style_records = json_decode($style_records[0]['menu_structure']);
    
    
    
}
/* $data = [['Hello', 2], ['World', 3]];
array_push($data, ["loco", 4]);
$data['test'] = ['Milo', 5];

$json = json_encode($data);

$array = json_decode($json);

foreach ($array as $key => $value) {
    //var_dump($key.' : '.$value[1]. ';');
    //var_dump($value);
}

var_dump(json_decode($json)); */

?>

<div class="wrap">

    
   
    
    <div class="settings-header-page">
        <h3>Mobile Menu Settings</h3>
    </div>

    
    <div class="settings-options">
        
        <!-- tab links -->
        <div class="tabs">
            <button class="tab default" onClick="openTab(event, 'general')">General Options</button>
            <button class="tab" onClick="openTab(event, 'header')">Header</button>
            <button class="tab" onClick="openTab(event, 'footer')">Footer</button>
            <button class="tab" onClick="openTab(event, 'style-presets')">Style Presets</button>
            <button class="tab" onClick="openTab(event, 'custom-colors')">Style</button>
            <button class="tab" onClick="openTab(event, 'menu-icons')">Menu Icon</button>
        </div>
        <form method="post">
        <!-- tabs content -->

            <!-- General Tab -->
            <div id="general" class="tab-content">
                <div class="option">
                    <div class="label">
                        <label for="menu-select">Select Menu</label>
                    </div>
            
                    <div class="select-input">
                        <select id="menu-select" name='menu_id'>
                            
                            <?php
                                foreach ($menus as $key => $menu) {
                                    $selected = '';
                                    if($menu->term_id == $records[0]['current_menu']){
                                        $selected = 'selected';
                                    }
                                    echo '<option value="'.$menu->term_id.'" '.$selected.'>'.$menu->name.'</option>' ;
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
                        <input <?php echo $style_records != null && $style_records->buttonAlignment && $style_records->buttonAlignment == 'left' ? 'checked' : ''; ?> type="radio" name="button-alignment" id="button-alignment-left" value="left">
                        <label for="button-alignment-left" data="LEFT"></label>
                        <input <?php echo $style_records != null && $style_records->buttonAlignment && $style_records->buttonAlignment == 'center' ? 'checked' : ''; ?> type="radio" name="button-alignment" id="button-alignment-center" value="center">
                        <label for="button-alignment-center" data="CENTER"></label>
                        <input <?php echo $style_records != null && $style_records->buttonAlignment && $style_records->buttonAlignment == 'right' ? 'checked' : ''; ?> class="<?php echo $style_records ? '' : 'default'; ?>" type="radio" name="button-alignment" id="button-alignment-right" value="right">
                        <label for="button-alignment-right" data="RIGHT"></label>
                    </div>
                </div>
                <div class="option">
                    <div class="label">
                        <label for="menu-select">Menu position</label>
                    </div>
                    <div class="radio-input">
                        <input <?php echo $style_records != null && $style_records->menuAlignment && $style_records->menuAlignment == 'left' ? 'checked' : ''; ?> type="radio" name="menu-alignment" id="menu-alignment-left" value="left">
                        <label for="menu-alignment-left" data="LEFT"></label>
                        <input <?php echo $style_records != null && $style_records->menuAlignment && $style_records->menuAlignment == 'center' ? 'checked' : ''; ?> type="radio" name="menu-alignment" id="menu-alignment-center" value="center">
                        <label for="menu-alignment-center" data="CENTER"></label>
                        <input <?php echo $style_records != null && $style_records->menuAlignment && $style_records->menuAlignment == 'right' ? 'checked' : ''; ?> class="<?php echo $style_records ? '' : 'default'; ?>" type="radio" name="menu-alignment" id="menu-alignment-right" value="right">
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
                        <input <?php echo $style_records != null && $style_records->showHeader == 'on' ? 'checked' : ''; ?> class="tgl-skewed" type="checkbox" name="show-header" id="show-header" onclick="enable_input('header-style')">
                        <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="show-header"></label>
                    </div>
                </div>
                <div class="option">
                    <div class="label">
                        <label for="header-type">Show menu header</label>
                    </div>
                    <div class="input">
                        <select <?php echo $style_records != null && $style_records->showHeader == 'on' ? '' : 'disabled'; ?> name="header-type" class="header-style">
                            <option <?php echo $style_records != null && $style_records->headerType == 'logo' ? 'selected' : ''; ?> value="logo">Site logo</option>
                            <option <?php echo $style_records != null && $style_records->headerType == 'avatar' ? 'selected' : ''; ?> value="avatar">User avatar</option>
                        </select>
                    </div>
                </div>
                <div class="option">
                    <div class="label">
                        <label for="">Header alignment</label>
                    </div>
                    <div class="radio-input">
                        <input <?php echo $style_records != null && $style_records->showHeader == 'on' ? '' : 'disabled'; echo $style_records != null && $style_records->headerAlignment == 'left' ? 'checked' : ''; ?> class="header-style" type="radio" name="header-alignment" id="header-alignment-left" value="left">
                        <label for="header-alignment-left" data="LEFT"></label>
                        <input <?php echo $style_records != null && $style_records->showHeader == 'on' ? '' : 'disabled'; echo $style_records != null && $style_records->headerAlignment == 'center' ? 'checked' : ''; ?> class="header-style <?php echo $style_records ? '' : 'default'; ?>" type="radio" name="header-alignment" id="header-alignment-center" value="center">
                        <label for="header-alignment-center" data="CENTER"></label>
                        <input <?php echo $style_records != null && $style_records->showHeader == 'on' ? '' : 'disabled'; echo $style_records != null && $style_records->headerAlignment == 'right' ? 'checked' : ''; ?> class="header-style" type="radio" name="header-alignment" id="header-alignment-right" value="right">
                        <label for="header-alignment-right" data="RIGHT"></label>
                    </div>
                </div>
                <div class="option">
                    <div class="label">
                        <label for="show-header">Header text</label>
                    </div>
                    <div class="text-input">
                        <input <?php echo $style_records != null && $style_records->showHeader == 'on' ? '' : 'disabled'; echo $style_records != null && $style_records->showHeader == 'on' ? 'value="'. $style_records->headerText.'"' : ''; ?> class="header-style" type="text" name="header-text" id="show-header">
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
                        <input class="tgl-skewed" type="checkbox" name="" id="show-footer">
                        <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="show-footer"></label>
                    </div>
                </div>
            </div>
            

            <!-- Color Tab -->
            <div id="custom-colors" class="tab-content">
                
            
                <div class="style-input">
                    <div class="label">
                        <!-- <input type="checkbox" name="" id="bg-color" onclick="enable_input('bg-color-color-picker')"> -->
                        <label for="bg-color">Background color</label>
                    </div>
                    <div class="color-input">
                        <input type="color" name="background_color" class="bg-color-color-picker" value="#ffffff">
                    </div>
                </div>
                
                <div class="style-input">
                    <div class="label">
                        <!-- <input type="checkbox" name="" id="f-color" onclick="enable_input('front-color-picker')"> -->
                        <label for="f-color">Font color</label>
                    </div>
                    <div class="color-input">
                        <input type="color" name="front_color" class="front-color-picker" value="#555555">
                    </div>
                </div>
                
                <div class="style-input">
                    <div class="label">
                        <!-- <input type="checkbox" name="" id="s-item-bg-color" onclick="enable_input('select-item-bg-color-picker')"> -->
                        <label for="s-item-bg-color">Selected item background color</label>
                    </div>
                    <div class="color-input">
                        <input type="color" name="selected_item_background_color" class="select-item-bg-color-picker" value="#cccccc">
                    </div>
                </div>
                
                <div class="style-input">
                    <div class="label">
                        <!-- <input type="checkbox" name="" id="s-item-color" onclick="enable_input('select-item-color-picker')"> -->
                        <label for="s-item-color">Selected item font color</label>
                    </div>
                    <div class="color-input">
                        <input type="color" name="selected_item_color" class="select-item-color-picker" value="#666666">
                    </div>
                </div>
                
                <div class="style-input">
                    <div class="label">
                        <!-- <input type="checkbox" name="" id="s-font-size" onclick="enable_input('select-font-size-picker')"> -->
                        <label for="s-font-size">Font size</label>
                    </div>
                    <div class="color-input">
                        <input step="0.01" min="1" max="4" type="range" name="item_font_size" class="select-font-size-picker" value="1">
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
    
                            <input type="radio" name="style_menu" id="dark" value="dark" <?php if($records[0]['style_menu'] == 'dark'){ echo 'checked'; } ?>>
                            
                            <label class="style-radio" for="dark" data="Dark"></label>
                        </div>
                    </div>
                    <div class="option">
                        <label for="light">
                            <img src="<?php echo plugin_dir_url( __FILE__ ). '/img/light.png'; ?>" width="120px" >
                        </label>
                        <br>
                        <div class="radio-input">

                            <input type="radio" name="style_menu" id="light" value="light" <?php if($records[0]['style_menu'] == 'light'){ echo 'checked'; } ?>>
                            <label class="style-radio" for="light" data="Light"></label>
                        </div>
                        
                    </div>
                    <div class="option">
                        <label for="blue">
                            <img src="<?php echo plugin_dir_url( __FILE__ ). '/img/blue.png'; ?>" width="120px" >
                        </label>
                        <br>
                        <div class="radio-input">

                            <input type="radio" name="style_menu" id="blue" value="blue" <?php if($records[0]['style_menu'] == 'blue'){ echo 'checked'; } ?>>
                            
                            <label class="style-radio" for="blue" data="Blue"></label>
                        </div>
                    </div>
                    <div class="option">
                        <label for="glass">
                            <img src="<?php echo plugin_dir_url( __FILE__ ). '/img/glass.png'; ?>" width="120px" >
                        </label>
                        <br>
                        <div class="radio-input">

                            <input type="radio" name="style_menu" id="glass" value="glass" <?php if($records[0]['style_menu'] == 'glass'){ echo 'checked'; } ?>>
                            
                            <label class="style-radio" for="glass" data="Glass"></label>
                        </div>
                    </div>
                    <div class="option">
                        <label for="custom-style">
                            <img src="<?php echo plugin_dir_url( __FILE__ ). '/img/glass.png'; ?>" width="120px" >
                        </label>
                        <br>
                        <div class="radio-input">

                            <input type="radio" name="style_menu" id="custom-style" value="custom-style" <?php if($records[0]['style_menu'] == 'custom-style'){ echo 'checked'; } ?>>
                            
                            <label class="style-radio" for="custom-style" data="Custom"></label>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- <div id="menu-icons" class="tab-content">
                <div class="option">
                    <div class="label">
                        <label for="header-type">Open menu button</label>
                    </div>
                    <div class="input">
                        <select <?php echo $style_records != null && $style_records->showHeader == 'on' ? '' : 'disabled'; ?> name="header-type" class="header-style">
                            <option <?php echo $style_records != null && $style_records->headerType == 'logo' ? 'selected' : ''; ?> value="logo">Site logo</option>
                            <option <?php echo $style_records != null && $style_records->headerType == 'avatar' ? 'selected' : ''; ?> value="avatar">User avatar</option>
                        </select>
                    </div>
                </div>
            </div> -->
                    
            <!-- Item Icon Tab -->
            <!-- <div id="item-icon" class="tab-content">
                <div class="option">
                    
                    

                    <ul class="item-icon">
                        <?php
                        /* $items = wp_get_nav_menu_items( $records[0]['current_menu'] );

                        $icons_list = get_icons();
                        $icon = '';
                                
                        foreach ($icons_list as $key => $value) {
                            $icon .= '<option>';
                            $icon .= $value;
                            $icon .= '</option>';
                        }
    
                        $html = '';
    
                        foreach ($items as $key => $value) {
                            $html .= '<li class="icon-selector">';
                            $html .= '<div><div>' . $value->title . '</div><br>';
                            $html .= '<select >';
                            $html .= $icon;
                            $html .= '</select></div>';
                            $html .= '<div>no Icon</div>';
                            $html .= '</li>';
                        }
                        echo $html; */
                        ?>
                    </ul>
                </div>
            </div> -->
            <br><br>
            <button class="button button-primary"  type="submit" name="save-settings">Save Changes</button>
        </form>
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

</script>





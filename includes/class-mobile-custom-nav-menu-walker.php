<?php

class Mobile_Custom_Nav_Menu_Walker extends Walker_Nav_Menu{

    private $curItem;

    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<ul class="floating-nav-submenu" id="floating-nav-submenu-'.$this->curItem.'" data-visible="false">';

    }

    function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        
        $icon = file_get_contents( MOBILE_CUSTOM_NAV_MENU_URL . 'assets/img/down-arrow.svg' );
        
        $classes = '';
        $this->curItem = $data_object->ID;
        $classes .= ($args->walker->has_children) ? ' class="parent menu-item" ' : ' class="menu-item" ';
        $output .= '<li '.$classes.' id="menu-item-'.$this->curItem.'">';
        $output .= ($data_object->url && $data_object->url != "#") ? '<div><a href="'.$data_object->url.'" >'.$data_object->title : '<div><a >'.$data_object->title;
        $output .= ($args->walker->has_children) ? '</a><span onclick="openSubmenu('.$this->curItem.')" id="expand-icon-'.$this->curItem.'" class="submenu-icon" src="'.plugins_url( '/assets/img/down-arrow.svg', __DIR__ ).'">'.$icon.'</span></div>' : '</a></div>';
        
    }

    function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }
}

class Preview_Mobile_Custom_nav_menu_walker extends Walker_Nav_Menu{

    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<ul class="floating-nav-submenu" id="floating-nav-submenu-'.$this->curItem.'" data-visible="false">';

    }

    function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        
        $icon = file_get_contents( MOBILE_CUSTOM_NAV_MENU_URL . 'assets/img/down-arrow.svg' );
        
        $classes = '';
        $this->curItem = $data_object->ID;
        $classes .= ($args->walker->has_children) ? ' class="parent menu-item" ' : ' class="menu-item" ';
        $output .= '<li '.$classes.' id="menu-item-'.$this->curItem.'">';
        $output .= '<div><a >'.$data_object->title;
        $output .= ($args->walker->has_children) ? '</a><span onclick="openSubmenu('.$this->curItem.')" id="expand-icon-'.$this->curItem.'" class="submenu-icon" src="'.plugins_url( '/assets/img/down-arrow.svg', __DIR__ ).'">'.$icon.'</span></div>' : '</a></div>';
        
    }

    function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }
}







<?php

/**
 * @since      1.0.0
 * @package    Jabago_Custom_Nav_Menu
 * @subpackage Jabago_Custom_Nav_Menu/includes
 * @author     Javier Barroso <abby.javi.infox5@gmail.com>
 */

class Jabago_Custom_Nav_Menu_Walker extends Walker_Nav_Menu{

    private $curItem;

    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<ul class="floating-nav-submenu" id="floating-nav-submenu-'. esc_attr( $this->curItem ) .'" data-visible="false">';

    }

    function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        
        $icon = file_get_contents( JABAGO_CUSTOM_NAV_MENU_URL . 'includes/img/down-arrow.svg' );
        
        $classes = '';
        $this->curItem = $data_object->ID;
        $classes .= ($args->walker->has_children) ? 'parent menu-item' : 'menu-item';
        $output .= '<li class="'. esc_attr( $classes ) .'" id="menu-item-'. esc_attr( $this->curItem ) .'">';
        $output .= ($data_object->url && $data_object->url != "#") ? '<div><a href="'. esc_attr( $data_object->url ) .'" >'. esc_html( $data_object->title ) : '<div><a >'. esc_html( $data_object->title );
        $output .= ($args->walker->has_children) ? '</a><span onclick="openSubmenu('. esc_attr( $this->curItem ) .')" id="expand-icon-'. esc_attr( $this->curItem ) .'" class="submenu-icon" src="'. esc_attr( plugins_url( '/includes/img/down-arrow.svg', __DIR__ ) ) .'">'.$icon.'</span></div>' : '</a></div>';
        
    }

    function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }
}

class Preview_Jabago_Custom_nav_menu_walker extends Walker_Nav_Menu{

    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<ul class="floating-nav-submenu" id="floating-nav-submenu-'. esc_attr( $this->curItem ) .'" data-visible="false">';

    }

    function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        
        $icon = file_get_contents( JABAGO_CUSTOM_NAV_MENU_URL . 'includes/img/down-arrow.svg' );
        
        $classes = '';
        $this->curItem = $data_object->ID;
        $classes .= ($args->walker->has_children) ? 'parent menu-item' : 'menu-item';
        $output .= '<li class="'. esc_attr( $classes ) .'" id="menu-item-'. esc_attr( $this->curItem ) .'">';
        $output .= '<div><a >'.$data_object->title;
        $output .= ($args->walker->has_children) ? '</a><span onclick="openSubmenu('. esc_attr( $this->curItem ) .')" id="expand-icon-'. esc_attr( $this->curItem ) .'" class="submenu-icon" src="'. esc_attr( plugins_url( '/includes/img/down-arrow.svg', __DIR__ ) ) .'">'. $icon .'</span></div>' : '</a></div>';
        
    }

    function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }
}







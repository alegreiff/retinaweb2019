<?php

/* Hoja de estilo CUSTOM (culpa de postcss font...)*/
add_action( 'wp_enqueue_scripts', 'wsm_custom_stylesheet', 20 );
function wsm_custom_stylesheet() {
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/custom.css' );
    wp_enqueue_style( 'custom-vars-in-php', get_stylesheet_directory_uri() . '/estilos.php' );
}
/* https://10up.github.io/wp-local-docker-docs/environments/ */

//Agregar widget areas
include_once (get_stylesheet_directory() . '/includes/widget-areas.php'); 

/**
 * Importa el widget con los logos del FOOTER
 */
include_once( get_stylesheet_directory() . '/widget/logos_footer.php');

genesis_register_sidebar(array('id' => 'before-footer-widgets', 'name' => __('Before Footer', 'daily-dish-pro'), 'description' => __('Widgets in this section will display before the footer widgets on every page.', 'daily-dish-pro'),));

add_action('genesis_before_footer', 'daily_dish_before_footer_widgets', 5);
/**
 * Hook before footer widget area above footer.
 *
 * @since 1.0.0
 */
function daily_dish_before_footer_widgets() {
    genesis_widget_area('before-footer-widgets', array('before' => '<div class="before-footer-widgets"><div class="wrap">', 'after' => '</div></div>',));
}


/** Register Utility Bar Widget Areas. */
    genesis_register_sidebar( array(
    'id' => 'utility-bar-left',
    'name' => __( 'Utility Bar Left', 'theme-prefix' ),
    'description' => __( 'This is the left utility bar above the header.', 'theme-prefix' ),
   ) );
   genesis_register_sidebar( array(
    'id' => 'utility-bar-right',
    'name' => __( 'Utility Bar Right', 'theme-prefix' ),
    'description' => __( 'This is the right utility bar above the header.', 'theme-prefix' ),
   ) );
   
   
   add_action( 'genesis_before_header', 'utility_bar' );
   /**
   * Add utility bar above header.
   *
   * @author Carrie Dils
   * @copyright Copyright (c) 2013, Carrie Dils
   * @license GPL-2.0+
   */
   function utility_bar() {
    
    echo '<div class="utility-bar"><div class="wrap">';
    
    genesis_widget_area( 'utility-bar-left', array(
    'before' => '<div class="utility-bar-left">',
    'after' => '</div>',
    ) );
    
    genesis_widget_area( 'utility-bar-right', array(
    'before' => '<div class="utility-bar-right">',
    'after' => '</div>',
    ) );
    
    echo '</div></div>';
    
   }

if($_SERVER["REQUEST_URI"] == '/'){
    add_action('wp_enqueue_scripts', 'carrusel_home');
}

function carrusel_home() {
    wp_register_script('carrusel', "//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js", array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'script-name', get_stylesheet_directory_uri() . '/js/carrusel_home.js', array('jquery'), '1.0.0', true );
    //wp_enqueue_style( 'carrusel', '//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css' );
    wp_enqueue_script('carrusel');
}
/* STICKY MENU https://www.jeanphilippemarchand.com/code/add-sticky-menu-genesis-sample-child-theme/ */
//* Enqueue sticky menu script
add_action('wp_enqueue_scripts', 'sp_enqueue_script');
function sp_enqueue_script() {
    wp_enqueue_script('sample-sticky-menu', get_stylesheet_directory_uri() . '/js/sticky-menu.js', array('jquery'), '1.0.0');
}

//Agrega y pone a disposición la librería de Font-Awesome
add_action('wp_enqueue_scripts', 'enqueue_load_fa');
function enqueue_load_fa() {
    //wp_register_script('fontawesome', "https://use.fontawesome.com/releases/v5.0.6/js/all.js", null, '1.1', false);
    wp_enqueue_style('font-awesome-free', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css'); 

    wp_enqueue_script('font-awesome-free');
}

//Añade Material design icons
add_action('wp_enqueue_scripts', 'efectos_js');
function efectos_js() {
    wp_register_script('efectos', get_stylesheet_directory_uri() . '/js/efectos.js', array('jquery'), '1.0.0', true );
    //wp_enqueue_style( 'style-name', 'https://storage.googleapis.com/code.getmdl.io/1.0.2/material.blue-orange.min.css' );
    wp_enqueue_style( 'style-name', 'https://fonts.googleapis.com/icon?family=Material+Icons', array() , CHILD_THEME_VERSION);
    wp_enqueue_script('efectos');
}





// Update CSS within in Admin
function admin_style() {
    
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/retinalatinaadmin.css' );
  }
  add_action('admin_enqueue_scripts', 'admin_style');

//QUITAR TÍTULO EN PÁGINAS
/*
add_action('genesis_before_entry', 'custom_remove_titles');
function custom_remove_titles() {
    // if we are not on a static Page, abort.
    if (!is_page()) {
        return;
    }
    remove_action('genesis_entry_header', 'genesis_entry_header_markup_open', 5);
    remove_action('genesis_entry_header', 'genesis_do_post_title');
    remove_action('genesis_entry_header', 'genesis_entry_header_markup_close', 15);
}*/
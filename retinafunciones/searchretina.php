<?php

// Enqueue scripts and styles
function buscador_retina() {
    wp_enqueue_script( 'hidesearch', get_stylesheet_directory_uri() . '/js/searchretina.js', array('jquery'), '1', true );
}
add_action( 'wp_enqueue_scripts', 'buscador_retina' );

/* function carga_iconos_ionic() {
    
    wp_enqueue_style( 'monochrome-ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css' );
  }
  add_action('admin_enqueue_scripts', 'carga_iconos_ionic'); */

  add_action( 'genesis_header', 'custom_get_header_search_toggle' );
/**
 * Outputs the header search form toggle button.
 */
function custom_get_header_search_toggle() {
    printf(
        '<a href="#header-search-wrap" aria-controls="header-search-wrap" aria-expanded="false" role="button" class="toggle-header-search"><span class="screen-reader-text">%s</span><span class="ionicons ion-ios-search"></span></a>',
        __( 'Show Search', 'genesis-sample' )
    );
}

add_action( 'genesis_header', 'custom_do_header_search_form' );
/**
 * Outputs the header search form.
 */
function custom_do_header_search_form() {
    $button = sprintf(
        '<a href="#" role="button" aria-expanded="false" aria-controls="header-search-wrap" class="toggle-header-search close"><span class="screen-reader-text">%s</span><span class="ionicons ion-ios-close-empty"></span></a>',
        __( 'Hide Search', 'genesis-sample' )
    );

    printf(
        '<div id="header-search-wrap" class="header-search-wrap">%s %s</div>',
        get_search_form( false ),
        $button
    );
}
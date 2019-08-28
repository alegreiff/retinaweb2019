<?php

/*JAIME DE GREIFF CUSTOM*/

//QUITAR TÍTULO EN PÁGINAS
add_action('genesis_before_entry', 'custom_remove_titles');
function custom_remove_titles() {
    // if we are not on a static Page, abort.
    if (!is_page()) {
        return;
    }
    remove_action('genesis_entry_header', 'genesis_entry_header_markup_open', 5);
    remove_action('genesis_entry_header', 'genesis_do_post_title');
    remove_action('genesis_entry_header', 'genesis_entry_header_markup_close', 15);
}

/** $video = embed */
function video_embebido($pelicula) {
    $video_meta = get_post_meta($pelicula->ID, 'video', true);
    $video = $video_meta['embed'];
    $salida = 'VID
	<iframe class="rl-iframe-video-home" src="http://cdnapi.kaltura.com/p/1993331/sp/199333100/embedIframeJs/uiconf_id/33074692/partner_id/1993331?iframeembed=true&playerId=kaltura_player_1452811701&entry_id=' . $video . '&flashvars[akamaiHD.loadingPolicy]=preInitialize&flashvars[akamaiHD.asyncInit]=true&flashvars[twoPhaseManifest]=true&flashvars[streamerType]=hdnetworkmanifest" allowfullscreen webkitallowfullscreen mozAllowFullScreen frameborder="0" style="width: 100%; height: 420px;" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></iframe>EOLOKO';
    return $salida;
}


/** TERCER MENU ES */
//Removido por innecesario

/*  add_action('init', 'register_additional_menu');
add_action('genesis_before', 'add_third_nav_genesis');
function register_additional_menu() {
    register_nav_menu('third-menu', __('Third Navigation Menu'));
}


function add_third_nav_genesis() {
    wp_nav_menu(array(
        'theme_location' => 'third-menu',
        'container_class' => 'genesis-nav-menu'
    ));
} */
//
/* Actualizaciones de Jaime*/

//* Reposition the secondary navigation menu

/* remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before', 'genesis_do_subnav' ); */



	


function register_menus() 
{
    register_nav_menus(
        array('paises_paginas_menu' => __( 'Países - Páginas' ))
    );
} 
add_action( 'init', 'register_menus' );

/**
 * Produces cleaner filenames for uploads
 *
 * @param  string $filename
 * @return string
 */
function wpartisan_sanitize_file_name( $filename ) {
 
    $sanitized_filename = remove_accents( $filename ); // Convert to ASCII
 
    // Standard replacements
    $invalid = array(
        ' '   => '-',
        '%20' => '-',
        '_'   => '-',
    );
    $sanitized_filename = str_replace( array_keys( $invalid ), array_values( $invalid ), $sanitized_filename );
 
    $sanitized_filename = preg_replace('/[^A-Za-z0-9-\. ]/', '', $sanitized_filename); // Remove all non-alphanumeric except .
    $sanitized_filename = preg_replace('/\.(?=.*\.)/', '', $sanitized_filename); // Remove all but last .
    $sanitized_filename = preg_replace('/-+/', '-', $sanitized_filename); // Replace any more than one - in a row
    $sanitized_filename = str_replace('-.', '.', $sanitized_filename); // Remove last - if at the end
    $sanitized_filename = strtolower( $sanitized_filename ); // Lowercase
 
    return $sanitized_filename;
}
 
add_filter( 'sanitize_file_name', 'wpartisan_sanitize_file_name', 10, 1 );

add_filter('use_block_editor_for_post', '__return_false');




/** FIN CAMPO PELICULADIRECTOR */

/*function my_relationship_result( $title, $post, $field, $post_id ) {
	
	$res = get_field('trailer', $post->ID);
	return $res;
	
}

add_filter('acf/fields/relationship/result/name=trailer', 'my_relationship_result', 10, 4);
*/

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 ); 

// Update CSS within in Admin
function admin_style() {
    
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/retinalatinaadmin.css' );
  }
  add_action('admin_enqueue_scripts', 'admin_style');



function retrieve_my_terms() {

    global $terms;

    $terms = get_terms( array(
        'taxonomy' => 'persons_categories',
        'hide_empty' => false,
    ) );
    $salida = [];
    foreach ($terms as $term) {
        $salida[] = $term;
        //return $option;
    }
    return $salida;
}
add_action('init', 'retrieve_my_terms', 9999);


/** EN CASO DE EMERGENCIA. SALVAR TODOS LOS POSTS */

/* function update_all_posts() {
    $args = array(
        'post_type' => 'person',
        'numberposts' => -1
    );
    $all_posts = get_posts($args);
    foreach ($all_posts as $single_post){
        $single_post->post_title = $single_post->post_title.'';
        wp_update_post( $single_post );
    }
}
add_action( 'wp_loaded', 'update_all_posts' ); */


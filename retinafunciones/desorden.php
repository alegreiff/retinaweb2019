<?php

/*JAIME DE GREIFF CUSTOM*/

add_action('wp_enqueue_scripts', 'enqueue_load_fa');
function enqueue_load_fa() {
    //wp_register_script('fontawesome', "https://use.fontawesome.com/releases/v5.0.6/js/all.js", null, '1.1', false);
    wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.2.0/css/all.css' );

    wp_enqueue_script('font-awesome-free');
}

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


//Añade Material design icons
add_action('wp_enqueue_scripts', 'efectos_js');
function efectos_js() {
    wp_register_script('efectos', get_stylesheet_directory_uri() . '/js/efectos.js', array('jquery'), '1.0.0', true );
    //wp_enqueue_style( 'style-name', 'https://storage.googleapis.com/code.getmdl.io/1.0.2/material.blue-orange.min.css' );
    wp_enqueue_style( 'style-name', 'https://fonts.googleapis.com/icon?family=Material+Icons', array() , CHILD_THEME_VERSION);
    wp_enqueue_script('efectos');
}


//
/* Actualizaciones de Jaime*/




//* Reposition the secondary navigation menu

/* remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before', 'genesis_do_subnav' ); */



// Enqueue scripts and styles
function themeprefix_scripts_and_styles() {
    wp_enqueue_Style( 'fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css' );
    wp_enqueue_script( 'hidesearch', get_stylesheet_directory_uri() . '/js/hidesearch.js', array('jquery'), '1', true );
}
add_action( 'wp_enqueue_scripts', 'themeprefix_scripts_and_styles' );

//Allow PHP to run in Widgets
function genesis_execute_php_widgets( $html ) {
	if ( strpos( $html, "<" . "?php" ) !==false ) {
	ob_start();
	eval( "?".">".$html );
	$html=ob_get_contents();
	ob_end_clean();
		}
	return $html;
}
add_filter( 'widget_text','genesis_execute_php_widgets' );	


//Add in new Search Widget areas
function themeprefix_extra_widgets() {	
	genesis_register_sidebar( array(
	'id'            => 'search',
	'name'          => __( 'Search', 'genesischild' ),
	'description'   => __( 'This is the Search toggle area', 'genesischild' ),
	'before_widget' => '<div class="search">',
	'after_widget'  => '</div>',
	) );
}
add_action( 'widgets_init', 'themeprefix_extra_widgets' );


//Position the Search Area
function themeprefix_search_widget() {
	genesis_widget_area ( 'search', array(
	'before' => '<div id="search-form-container">',
	'after'  => '</div>',));
}
add_action( 'genesis_after_header','themeprefix_search_widget' );


function custom_nav_item( $menu, stdClass $args ){
    // make sure we are in the primary menu
    if ( 'primary' != $args->theme_location )
    
        return $menu;   

    $menu  .= '</ul><ul class="search-form-container"><div class="search-toggle"><i class="fa fa-search"></i>
				<a href="#search-container" class="screen-reader-text"></a>
				</div>'; 
        return $menu; 
}
add_filter( 'wp_nav_menu_items', 'custom_nav_item', 10, 2 );

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


function my_relationship_query( $args, $field, $post_id ) {
	
    // only show children of the current post being edited
    
    //$args['meta_key'] = 'trailer';
    //$args['meta_value'] !='';
    
$args['meta_query'] = array(
    array(
    'key' => 'trailer', // name of custom field
    'value' => array(''),
    'compare' => 'NOT IN'
    )
); // <-- this one!
    // return
    //d($args);
    return $args;
    //d("mierda");
    
}


// filter for every field
add_filter('acf/fields/relationship/query/name=eltrailer', 'my_relationship_query', 10, 3);

/** CAMPO PELICULADIRECTOR */

function my_relationship_result( $title, $post, $field, $post_id ) {
	
    $res = get_field('director', $post->ID);
    //d($res[post_title]);
    //d($res[0]->post_title);
    return $title . ' / ' . $res[0]->post_title;
    //return $res[0]->post_title;
	
}

add_filter('acf/fields/relationship/result/name=peliculadirector', 'my_relationship_result', 10, 4);

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
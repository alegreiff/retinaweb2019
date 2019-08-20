<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

/* error_reporting(E_ALL); 
ini_set("display_errors", 1); */

// Start the engine.
include_once (get_template_directory() . '/lib/init.php');

// Setup Theme.
include_once (get_stylesheet_directory() . '/lib/theme-defaults.php');

// Set Localization (do not remove).
add_action('after_setup_theme', 'genesis_sample_localization_setup');
function genesis_sample_localization_setup() {
    load_child_theme_textdomain('genesis-sample', get_stylesheet_directory() . '/languages');
}

// Add the helper functions.
include_once (get_stylesheet_directory() . '/lib/helper-functions.php');

// Add Image upload and Color select to WordPress Theme Customizer.
require_once (get_stylesheet_directory() . '/lib/customize.php');

// Include Customizer CSS.
include_once (get_stylesheet_directory() . '/lib/output.php');

// Add WooCommerce support.
include_once (get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php');

// Add the required WooCommerce styles and Customizer CSS.
include_once (get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php');

// Add the Genesis Connect WooCommerce notice.
include_once (get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php');

// Child theme (do not remove).
define('CHILD_THEME_NAME', 'Genesis Sample');
define('CHILD_THEME_URL', 'http://www.studiopress.com/');
define('CHILD_THEME_VERSION', '2.3.0');

// Enqueue Scripts and Styles.
add_action('wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles');
function genesis_sample_enqueue_scripts_styles() {

    wp_enqueue_style('genesis-sample-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array() , CHILD_THEME_VERSION);
    wp_enqueue_style('dashicons');

    $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    wp_enqueue_script('genesis-sample-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array(
        'jquery'
    ) , CHILD_THEME_VERSION, true);
    wp_localize_script('genesis-sample-responsive-menu', 'genesis_responsive_menu', genesis_sample_responsive_menu_settings());

}

// Define our responsive menu settings.
function genesis_sample_responsive_menu_settings() {

    $settings = array(
        'mainMenu' => __('Menu', 'genesis-sample') ,
        'menuIconClass' => 'dashicons-before dashicons-menu',
        'subMenu' => __('Submenu', 'genesis-sample') ,
        'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
        'menuClasses' => array(
            'combine' => array(
                '.nav-primary',
                '.nav-header',
            ) ,
            'others' => array() ,
        ) ,
    );

    return $settings;

}

// Add HTML5 markup structure.
add_theme_support('html5', array(
    'caption',
    'comment-form',
    'comment-list',
    'gallery',
    'search-form'
));

// Add Accessibility support.
add_theme_support('genesis-accessibility', array(
    '404-page',
    'drop-down-menu',
    'headings',
    'rems',
    'search-form',
    'skip-links'
));

// Add viewport meta tag for mobile browsers.
add_theme_support('genesis-responsive-viewport');

// Add support for custom header.
add_theme_support('custom-header', array(
    'width' => 200,
    'height' => 158,
    'header-selector' => '.site-title a',
    'header-text' => false,
    'flex-height' => true,
    'flex-width' => true,
	
));

// Add support for custom background.
add_theme_support('custom-background');

// Add support for after entry widget.
add_theme_support('genesis-after-entry-widget-area');

// Add support for 3-column footer widgets.
//add_theme_support('genesis-footer-widgets', 3);

// Add Image Sizes.
add_image_size('featured-image', 720, 400, true);
add_image_size('poster-mini', 230, 325, true);

// Rename primary and secondary navigation menus.
add_theme_support('genesis-menus', array(
    'primary' => __('After Header Menu', 'genesis-sample') ,
    'secondary' => __('Footer Menu', 'genesis-sample')
));

// Reposition the secondary navigation menu.
remove_action('genesis_after_header', 'genesis_do_subnav');
add_action('genesis_footer', 'genesis_do_subnav', 5);

// Reduce the secondary navigation menu to one level depth.
add_filter('wp_nav_menu_args', 'genesis_sample_secondary_menu_args');
function genesis_sample_secondary_menu_args($args) {

    if ('secondary' != $args['theme_location']) {
        return $args;
    }

    $args['depth'] = 1;

    return $args;

}

// Modify size of the Gravatar in the author box.
add_filter('genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar');
function genesis_sample_author_box_gravatar($size) {
    return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter('genesis_comment_list_args', 'genesis_sample_comments_gravatar');
function genesis_sample_comments_gravatar($args) {

    $args['avatar_size'] = 60;

    return $args;

}

/*JAIME DE GREIFF CUSTOM*/
//Agregar widget areas
include_once (get_stylesheet_directory() . '/includes/widget-areas.php'); 

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

/* Devuelve el ID de la categoría ARCHIVO
este valor cambia de DESARROLLO a PRODUCCIÓN
*/
function categoria_archivo() {
    return '917';
}

/** $video = embed */
function video_embebido($pelicula) {
    $video_meta = get_post_meta($pelicula->ID, 'video', true);
    $video = $video_meta['embed'];
    $salida = 'VID
	<iframe class="rl-iframe-video-home" src="http://cdnapi.kaltura.com/p/1993331/sp/199333100/embedIframeJs/uiconf_id/33074692/partner_id/1993331?iframeembed=true&playerId=kaltura_player_1452811701&entry_id=' . $video . '&flashvars[akamaiHD.loadingPolicy]=preInitialize&flashvars[akamaiHD.asyncInit]=true&flashvars[twoPhaseManifest]=true&flashvars[streamerType]=hdnetworkmanifest" allowfullscreen webkitallowfullscreen mozAllowFullScreen frameborder="0" style="width: 100%; height: 420px;" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></iframe>EOLOKO';
    return $salida;
}

/* Función utlizada en los listados de películas para traer el poster en el tamaño apropiado*/
function trae_poster($poster) {
    $size = "poster-mini";
    $image = wp_get_attachment_image_src($poster['id'], $size);
    //return $image[0];
    $domain = get_site_url(); // returns something like http://domain.com
     $relative_url = str_replace( $domain, '', $image[0] );
     return $relative_url;

}
function enlace_relativo($enlace){
    $domain = get_site_url(); // returns something like http://domain.com
    $relative_url = str_replace( $domain, '', $enlace );
    return $relative_url;
}

function get_relative_thumb( $size ) {
    global $post;
    if ( has_post_thumbnail()) {
      $absolute_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size);
     $domain = get_site_url(); // returns something like http://domain.com
     $relative_url = str_replace( $domain, '', $absolute_url[0] );
     return $relative_url;
    }
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

/** AJAX FILTER */
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
function theme_name_scripts() {
	if ( is_page_template('paises.php') ) {
		wp_enqueue_script( 'script-name', get_stylesheet_directory_uri() . '/js/pagina.js', array('jquery'), '1.0.0', true );
		wp_localize_script( 'script-name', 'MyAjax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'security' => wp_create_nonce( 'my-special-string' )
		));
	}
}

// AJAX carga de películas para la plantilla de paises (categorías)
add_action('wp_ajax_filtro_peliculas_retina', 'filtro_peliculas_retina');
add_action('wp_ajax_nopriv_filtro_peliculas_retina', 'filtro_peliculas_retina');
function filtro_peliculas_retina(){
	//https://rudrastyh.com/wordpress/ajax-post-filters.html
	$args = array(
		'orderby' => 'date', // we will sort posts by date
		'order'	=> $_POST['date'], // ASC or DESC
		'posts_per_page' => -1,
        'post_type' => 'video',
        'post_status' => 'publish'
	);

	// for taxonomies / categories
    if( isset( $_POST['categoria_mostrada'] ) )
    $categorias = $_POST['categoria_mostrada'];
    if(isset( $_POST['formato']) && $_POST['formato'] == ''){
        $categorias = $_POST['categoria_mostrada'];
    }else{
        $categorias = array($_POST['categoria_mostrada'], $_POST['formato']);
    }
	if($_POST['categoria_mostrada'] == categoria_archivo()){
        $args['tax_query'] = array(
            'relation' => 'AND',

			array(
				'taxonomy' => 'videos_categories',
				'field' => 'id',
				'terms' => $_POST['categoria_mostrada']
			),
			array(
				'taxonomy' => 'videos_categories',
				'field'    => 'id',
				'terms' => $_POST['formato'],
				'operator' => 'AND'
            ),
			array(
				'taxonomy' => 'videos_categories',
				'field'    => 'id',
				'terms' => $_POST['genero'],
				'operator' => 'AND'
            )
		);
    }else{
        $args['tax_query'] = array(
            'relation' => 'AND',

			array(
				'taxonomy' => 'videos_categories',
				'field' => 'id',
				'terms' => $_POST['categoria_mostrada']
			),
			array(
				'taxonomy' => 'videos_categories',
				'field'    => 'id',
				'terms' => $_POST['formato'],
				'operator' => 'AND'
            ),
			array(
				'taxonomy' => 'videos_categories',
				'field'    => 'id',
				'terms' => $_POST['genero'],
				'operator' => 'AND'
            ),
            array(
				'taxonomy' => 'videos_categories',
				'field'    => 'id',
				'terms' => 917,
				'operator' => 'NOT IN'
            ),
		);
    }

    $query = new WP_Query( $args );
    $total = $query->found_posts;


	if( $query->have_posts() ) :
        //CONTROL CUÁNTOS ELEMENTOS
        //echo '<h1>'.$total.'</h1>';
        //echo '<div class="peliculas_paises">';
		while( $query->have_posts() ): $query->the_post();
		$poster = trae_poster(get_field('poster'));
        $pais_pelicula = muestra_codigopais(get_field('country_group'));
        $formato_pelicula = wp_get_post_terms(get_the_ID(), 'videos_format')[0]->name;
        $genero_pelicula = wp_get_post_terms(get_the_ID(), 'videos_genres')[0]->name;
        $duracion = get_field('duration');
            $year = get_field('year');
        //d($formato_pelicula);
			//echo '<h2>' . $query->post->post_title . '</h2>';
            //var_dump(get_field('poster'));

            echo '
            <div class="retina_poster">
            <a href="'.enlace_relativo(get_post_permalink()).'">
                <div class="picture" >
                    <img src="'.$poster.'" alt="">
                    <span class="duracion"> '.($duracion).'</span>

                </div>
                <div class="navigation">
                <span class="pais">'.$pais_pelicula.' - '.$year.'</span>
                    <h4>'.get_the_title().'</h4>
                    <span class="formato">'.muestra_genero($genero_pelicula).'</span>

                </div>
                </a>
            </div>
            ';

            /*echo '
            <article class="mini_film card  card--z-3">
                <a href="#">
                <img src="'.$poster.'" alt="Avatar" class="image" style="width:100%">
                <div class="middle">
                    <div class="text">
                        <p>'.$formato_pelicula.'</p>
                        <p>'.$genero_pelicula.'</p>
                    </div>
                </div>
                <h6>'.$pais_pelicula.'</h6>
                <h4>'.get_the_title().'</h4>
                </a>
            </article>

                ';*/
/*
<article class="mini_film">
                    <div class="containerx">
                        <img src="'.$poster.'" alt="" class="image">
                        <div class="middle">
                            <div class="text">John Doe</div>
                        </div>
                    </div>

                        <h6>'.$pais_pelicula.'</h6>
						<h4>'.get_the_title().'</h4>
                        <p>'.$formato_pelicula.'</p>


                </article>
*/
            endwhile;
		wp_reset_postdata();
		//echo '</div>';
	else :
		echo 'No posts found';
	endif;

	wp_die();
}



//Añade Material design icons
add_action('wp_enqueue_scripts', 'efectos_js');
function efectos_js() {
    wp_register_script('efectos', get_stylesheet_directory_uri() . '/js/efectos.js', array('jquery'), '1.0.0', true );
    //wp_enqueue_style( 'style-name', 'https://storage.googleapis.com/code.getmdl.io/1.0.2/material.blue-orange.min.css' );
    wp_enqueue_style( 'style-name', 'https://fonts.googleapis.com/icon?family=Material+Icons', array() , CHILD_THEME_VERSION);
    wp_enqueue_script('efectos');
}

//Función que retorna DOC o FIC según sea documental o ficción
function muestra_genero($genero){
    if ( $genero=='Documental' ) {
        return 'Doc';
    }else if( $genero=='Ficción' ){
        return 'Fic';
    }else{
        return '';
    }
}


function muestra_codigopais($pais){
    switch ($pais) {
        case 'DOCTV':
            $code = 'DocTV';
            break;
        case 'BOLIVIA':
            $code = 'Bo';
            break;
        case 'COLOMBIA':
            $code = 'Co';
            break;
        case 'ECUADOR':
            $code = 'Ec';
            break;
        case 'PERÚ':
            $code = 'Pe';
            break;
        case 'MÉXICO':
            $code = 'Mx';
            break;
        case 'URUGUAY':
            $code = 'Uy';
            break;
        default:
            $code = substr($pais, 0, 2);
    }
    return $code;
}




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


/**
 * Importa el widget con los logos del FOOTER
 */
include_once( get_stylesheet_directory() . '/widget/logos_footer.php');


if($_SERVER["REQUEST_URI"] == '/'){
    add_action('wp_enqueue_scripts', 'carrusel_home');

}

function carrusel_home() {
    wp_register_script('carrusel', "//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js", array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'script-name', get_stylesheet_directory_uri() . '/js/carrusel_home.js', array('jquery'), '1.0.0', true );
    //wp_enqueue_style( 'carrusel', '//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css' );
    wp_enqueue_script('carrusel');


}


//
/* Actualizaciones de Jaime*/

/* Hoja de estilo CUSTOM (culpa de postcss font...)*/
add_action( 'wp_enqueue_scripts', 'wsm_custom_stylesheet', 20 );
function wsm_custom_stylesheet() {
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/custom.css' );
}
/* https://10up.github.io/wp-local-docker-docs/environments/ */

/* STICKY MENU https://www.jeanphilippemarchand.com/code/add-sticky-menu-genesis-sample-child-theme/ */
//* Enqueue sticky menu script
add_action('wp_enqueue_scripts', 'sp_enqueue_script');
function sp_enqueue_script() {
    wp_enqueue_script('sample-sticky-menu', get_stylesheet_directory_uri() . '/js/sticky-menu.js', array('jquery'), '1.0.0');
}

//* Reposition the secondary navigation menu

/* remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before', 'genesis_do_subnav' ); */










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



function getYouTubeId($url) {
    if (strlen($url) == 11) {
        return $url;
    }else{
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    return $match[1];
    }
}

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 ); 

// Update CSS within in Admin
function admin_style() {
    
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/retinalatinaadmin.css' );
  }
  add_action('admin_enqueue_scripts', 'admin_style');




function nombre_taxonomia_persona($nombre, $entrada, $salida){
    $roles_personas=[
        ["label" => "Dirección", "campo" => 'director', "taxslug" =>'directores'],
        ["label" => "Asistencia de dirección", "campo" => 'directors_assistant', "taxslug" =>'asistente-de-direccion'],
        ["label" => "Guion", "campo" => 'screenwriter', "taxslug" =>'guionista'],
        ["label" => "Investigación", "campo" => 'searcher', "taxslug" =>'investigador'],
        ["label" => "Script / Continuista", "campo" => 'rl_script', "taxslug" =>'script-continuista'],
        ["label" => "Producción", "campo" => 'producer', "taxslug" =>'productor'],
        ["label" => "Montaje", "campo" => 'montajista', "taxslug" =>'montajista'],
        ["label" => "Sonido", "campo" => 'soundman', "taxslug" =>'sonidista'],
        ["label" => "Dirección de fotografía", "campo" => 'director_photography', "taxslug" =>'director-de-fotografia'],
        ["label" => "Cámara", "campo" => 'cameraman', "taxslug" =>'camarografo'],
    ];
    foreach ($roles_personas as $rol => $val) {
        if ($val[$entrada] == $nombre) {
            return $val[$salida];
        }
    }
    return null;

}


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
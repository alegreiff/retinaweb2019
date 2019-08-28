<?php
//Change search form text

function themeprefix_search_button_text( $text ) {
    return ( 'Buscar en Retina Latina...');
}
add_filter( 'genesis_search_text', 'themeprefix_search_button_text' );

// Enqueue scripts and styles
function themeprefix_scripts_and_styles() {
    wp_enqueue_script( 'hidesearch', get_stylesheet_directory_uri() . '/js/hidesearch.js', array('jquery'), '1', true );
}
add_action( 'wp_enqueue_scripts', 'themeprefix_scripts_and_styles' );

//Add in new Search Widget areas1
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
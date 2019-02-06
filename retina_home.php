<?php
/*
Template Name: Plantilla JAIME
*/
//remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
//remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
//remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

//add_action('genesis_meta', 'config_home_page_setup');

function config_home_page_setup(){
    $inicio_sidebars = array(
        'bienvenida' => is_active_sidebar( 'bienvenida' ),
        'call-to-action' => is_active_sidebar( 'call-to-action' ),
    );

    if ( ! in_array ( true, $inicio_sidebars ) ) {
        return;
    }

    if ( $inicio_sidebars['bienvenida']){
        add_action ('genesis_after_header', 'config_agrega_home_bienvenida');
    }
    if ( $inicio_sidebars['call-to-action']){
        add_action ('genesis_after_header', 'config_agrega_home_call');
    }
}

/**
 * Muestra el widget bienvenida en la página
 */
function config_agrega_home_bienvenida(){
    genesis_widget_area ( 'bienvenida', array(
        'before' => '<div class="bienvenida"><div class="wrap">',
        'after' => '</div></div>',
    ));
}

function config_agrega_home_call(){
    genesis_widget_area ( 'call-to-action', array(
        'before' => '<div class="call-to-action"><div class="wrap">',
        'after' => '</div></div>',
    ));
}


//add_action('genesis_loop', 'my_lup');
function my_lup(){
    echo '<div class="lista">
    <ul>
    <li>Uno</li>
    <li>Dos</li>
    <li>Tres Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque cum eius incidunt iusto odit quasi rem tempora ullam. Ad animi asperiores id quibusdam reiciendis? Autem blanditiis eaque iure quia voluptatum.</li>
    </ul>
</div>';
}




genesis();

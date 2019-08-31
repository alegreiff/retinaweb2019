<?php
//https://wpsmith.net/2011/how-to-make-a-custom-taxonomy-genesis-grid-archive-template/
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'wps_grid_loop_helper');
/** Add support for Genesis Grid Loop **/
function wps_grid_loop_helper(){
    catalogo_peliculas_taxonomia('videos_classification');
}

genesis();
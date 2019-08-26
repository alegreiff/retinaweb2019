<?php
//Extrae el ID de YouTube 
function getYouTubeId($url) {
    if (strlen($url) == 11) {
        return $url;
    }else{
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    return $match[1];
    }
}
//========================================================//
/* Devuelve el ID de la categoría ARCHIVO
este valor cambia de DESARROLLO a PRODUCCIÓN
*/
function categoria_archivo() {
    return '917';
}
//========================================================//

/* Función utlizada en los listados de películas para traer el poster en el tamaño apropiado*/
function trae_poster($poster) {
    $size = "poster-mini";
    $image = wp_get_attachment_image_src($poster['id'], $size);
    //return $image[0];
    $domain = get_site_url(); // returns something like http://domain.com
     $relative_url = str_replace( $domain, '', $image[0] );
     return $relative_url;

}

//Extrae un código por cada país Miembro
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

//EN  la página de inicio permite seleccionar las películas que tienen tráiler para ser mostradas en portada
function my_relationship_query( $args, $field, $post_id ) {
    // only show children of the current post being edited
    //$args['meta_key'] = 'trailer';
    //$args['meta_value'] !='';
    $args['meta_query'] = array(
        array(
            'key' => 'trailer', // name of custom field
            'value' => array(''),
            'compare' => 'NOT IN'
        )); // <-- this one!
    // return
    //d($args);
    return $args;
    
}
add_filter('acf/fields/relationship/query/name=eltrailer', 'my_relationship_query', 10, 3);

// En la página de inicio permite seleccionar los directores que se muestran en portada
/** CAMPO PELICULADIRECTOR */
function my_relationship_result( $title, $post, $field, $post_id ) {
	
    $res = get_field('director', $post->ID);
    return $title . ' / ' . $res[0]->post_title;
	
}

add_filter('acf/fields/relationship/result/name=peliculadirector', 'my_relationship_result', 10, 4);
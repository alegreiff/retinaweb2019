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
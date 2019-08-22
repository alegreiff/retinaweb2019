<?php
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'muestradatos');
/*VARIABLES DE TEXTO PARA MENSAJES DEL PROYECTO*/
$registro_inactiva = '<p>Regístrate, haz parte de Retina Latina</p>';
$registro_pelicula = '<p>¿No puedes ver la película?, regístrate, haz parte de Retina Latina. Únete</p>';

/* FUNCIONES AUXILIARES */


function formato_dato($dato){
    return '<p class="dato_pelicula">' . $dato . '</p>';
}
/* Función que trae el video desde KALTURA*/
function peliculaIframe($video){
    return '<iframe class="retinx" src="http://cdnapi.kaltura.com/p/1993331/sp/199333100/embedIframeJs/uiconf_id/33074692/partner_id/1993331?iframeembed=true&playerId=kaltura_player_1452811701&entry_id=' . $video . '&flashvars[akamaiHD.loadingPolicy]=preInitialize&flashvars[akamaiHD.asyncInit]=true&flashvars[twoPhaseManifest]=true&flashvars[streamerType]=hdnetworkmanifest" width="560" height="395" allowfullscreen webkitallowfullscreen mozAllowFullScreen frameborder="0" style="width: 600px; height: 320px;" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></iframe>';
}

function peliculaTrailer($trailer){
    return '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="600" height="320" src="http://www.youtube.com/embed/' . $trailer . '"frameborder="0" allowFullScreen></iframe>';
}

function tabla_popup($icono = 'fas fa-music', $etiqueta, $campo, $identificador){
    global $post;
    $pelicula = $post->post_title;
    if ($campo) {
        $s = do_shortcode('[su_lightbox type="inline" src="#' . $identificador . '"]
        <span class="enlace_ficha">
        <i class="' . $icono . '"></i>
        ' . $etiqueta . '</span>[/su_lightbox]');
        $s .= do_shortcode('[su_lightbox_content id="#' . $identificador . '"]<h3 class="rl-tablas-h3">' . $etiqueta . ' - ' . $pelicula . '</h3>' . wpautop($campo) . '[/su_lightbox_content]');
        return $s;
    }
}

function lista_asociada($etiqueta, $etiquetaplural = '', $campos){
  $etiquetaplural === '' ? $etiquetaplural = $etiqueta : $etiquetaplural = $etiquetaplural;
  $salida = '';
  if ($campos) :
    count($campos) ===  1 ? $salida .= '<p>' . $etiqueta . ': ' : $salida .= '<p>' . $etiquetaplural . ': ';
    //$salida .= '<p><strong>' . $etiqueta . ': </strong>';
    $ta = array();
    foreach ($campos as $campo) :
      $a_p = '<strong>' . $campo . '</strong>';
      array_push($ta, $a_p);
    endforeach;
      $salida .= implode(', ', $ta);
      $salida .= '</p>';
  endif;
  return $salida;
}

function creditos($rol, $rolplural = '', $personas_contenidos){
    /*
    SI LA PERSONA TIENE CONTENIDO, GENERAR EL ENLACE, SI NO, SOLO EL NOMBRE
    */
  $rolplural === '' ? $rolplural = $rol : $rolplural = $rolplural;
    $salida = '';
    if ($personas_contenidos) {
        count($personas_contenidos) ===  1 ? $salida .= '<p>' . $rol . ': ' : $salida .= '<p>' . $rolplural . ': ';
        $ta = array();
        foreach ($personas_contenidos as $persona) :
            //d($persona);
            
                if(strlen($persona->post_content)>0){
                    $a_p = '<a href="' . get_permalink($persona->ID) . '">' . get_the_title($persona->ID) . '</a>';
                }else{
                    $a_p = '<strong>' . get_the_title($persona->ID) . '</strong>';
                }
            
            
            /* if ($rol === 'Dirección') {
                $a_p = '<a href="' . get_permalink($persona->ID) . '">' . get_the_title($persona->ID) . '</a>';
            } else {
                $a_p = '<strong>' . get_the_title($persona->ID) . '</strong>';
            } */
            //$a_p = '<a href="' . get_permalink($persona->ID) . '">' . get_the_title($persona->ID) . '</a>';
            array_push($ta, $a_p);
        endforeach;
        $salida .= implode(', ', $ta);
        $salida .= '</p>';
    }
return $salida;
}
function web($url){
    if($url!=='')
    echo '<br /><i class="fas fa-link"></i> '. '<a href="'.$url.'" target="">Sitio web</a>';
}

function contacto_productora($contacto){
    if(!empty($contacto))
    echo '<br /> Contacto:'. $contacto;
    
}
function idiomas_pelicula($arregloidiomas){
    $idioma_mostrado = [];
    foreach($arregloidiomas as $idioma){
      $idioma_mostrado[] = $idioma->name;
    }
    $idioma_mostrado === 1 ? $prefijo = 'Idioma: '  : $prefijo = 'Idiomas: ';
    return $prefijo . implode(" / ", $idioma_mostrado);
    
}

function muestradatos(){
    global $registro_inactiva;
    global $registro_pelicula;
    $retina_film = null;
    $muestra_trailer = '';
    $muestra_film = null;
    $retina_trailer = null;
    $pais_pelicula = get_field('country_group');
    $post = get_post();
    $poster = get_field('poster')['url'];

    /*INICIO CAMPOS DE NO PERSONAS*/
    
    $otros_nombres = get_field('rl_otrosnombres');
    $paises_produccion = get_field('countries_production');
    $nacionalidad = get_field('citizenship_video');
    $subtitulos = get_field('subtitulos');
    $paises_coproduccion = get_field('rl_coproduccionpaises');
    $es_animacion = get_field('animation');
    $es_blancoynegro = get_field('color');
    $sitioweb = get_field('webpage'); //string
    $locaciones = get_field('locations'); //string
    $contacto = get_field('rl_contacto'); //string
    $inspirado = get_field('rl_inspirado'); //string
    $eventos = get_field('participation_event'); //string table
    $premios = get_field('awards'); //string table
    $musica = get_field('music'); //string table
    $duracion = get_field('duration');
    $year_pelicula = get_field('year');
    $imagendestacada = get_field('imagendestacada');
    $galeria = get_field('gallery');
    $video_meta = get_post_meta($post->ID, 'video', true);
    //d($video_meta['embed']);
    $video = $video_meta['embed'];
    $clasificacion_edad = wp_get_post_terms(get_the_ID(), 'videos_classification')[0]->name;
    $formato_pelicula = wp_get_post_terms(get_the_ID(), 'videos_format')[0]->name;
    $genero_pelicula = wp_get_post_terms(get_the_ID(), 'videos_genres')[0]->name;
    $idioma_pelicula = idiomas_pelicula(wp_get_post_terms(get_the_ID(), 'videos_language'));
    //$idioma_peliculax = wp_get_post_terms(get_the_ID(), 'videos_language');
    $tagges = wp_get_post_terms(get_the_ID(), 'post_tag');
    /* INICIO CAMPOS NUEVOS 2019*/
    $geobloqueo = get_field('rl_geobloqueo');
    /* FIN CAMPOS NUEVOS 2019*/
    $premios = get_field('awards');
    $imagendestacada ? $fondopelicula = $imagendestacada : $fondopelicula = get_the_post_thumbnail_url();

    /*FIN CAMPOS DE NO PERSONAS*/

    /*INICIO PERSONAS*/
    $reparto = get_field('cast');
    $director = get_field('director');
    $director_asistente = get_field('directors_assistant');
    $guionista = get_field('screenwriter');
    $companias = get_field('company_productors');
    $scriptcontinuista = get_field('rl_script');
    $productor = get_field('producer');
    $coproductor = get_field('coproducer');
    $productor_ejecutivo = get_field('executive_producer');
    $productor_asociado = get_field('associate_producer');
    $jefe_produccion = get_field('chief_producer');
    $productor = get_field('producer');
    
    /* SUMA EL CAMPO DE JEFE DE PRODUCCIÓN A PRODUCCIÓN */
    if($productor && $jefe_produccion){
        $prod_jefeprod = array_merge($jefe_produccion, $productor);
    }else if(!$productor && $jefe_produccion){
        $prod_jefeprod = ($jefe_produccion);
    }else if($productor && !$jefe_produccion){
        $prod_jefeprod = ($productor);
    }else{
        $prod_jefeprod = null;
    }
    /* FIN SUMA EL CAMPO DE JEFE DE PRODUCCIÓN A PRODUCCIÓN */

    $camarografo = get_field('cameraman');
    $director_fotografia = get_field('director_photography');
    $montajista = get_field('montajista');
    $colorista = get_field('rl_colorista');
    $sonidista = get_field('soundman');
    $sonido_disenador = get_field('sound_designer');
    $director_arte = get_field('art_director');
    $musico = get_field('musician');
    $animador = get_field('animator');
    $investigador = get_field('searcher');
    $sonido_mezcla = get_field('sound_mzl');
    $narracion = get_field('narration');
    $asistente_camara = get_field('camara_assistant');
    $productor_campo = get_field('rl_productordecampo');
    $productor_asistente = get_field('rl_productorasistente');
    $diseno_grafico  = get_field('rl_disenografico');
    $efectos_visuales = get_field('rl_efectosvisuales');
    $maquillador = get_field('rl_maquillaje');
    $microfonista = get_field('rl_microfonista');
    $editor_sonido = get_field('rl_ediciondesonido');
    $casting = get_field('casting');
    $fotofija = get_field('foto_fija');
    $vestuario = get_field('vestuario');
    /*FIN PERSONAS*/

    if ($musica) {
        $muestra_musica = tabla_popup("fas fa-music", "Música", $musica, "ficha_musica");
    } else {
        $muestra_musica = '';
    }
    if (get_field('trailer')) {
        $trailer = getYouTubeId(get_field('trailer')); //JAIME
    }else{
        $trailer = false;
    }
    //d($imagendestacada);
    if (isset($trailer)) {
        //$retina_trailer = true;
        $muestra_trailer = '<div class="trailer_retinalatina">' . peliculaTrailer($trailer) . '</div>';
    }
    include_once('parciales/main-pelicula-single.php');
    
  }
  
genesis(); 

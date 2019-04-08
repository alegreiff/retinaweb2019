<?php
function datospeliculaHeader($clase, $pais, $year, $duracion, $subs){
    if($subs==='Si'){
        $sub_salida = '<span class="subs"><i class="fas fa-grip-lines"></i> SI </span>';
    }
    echo '
    <div class='.$clase.'>
    <span class="paispelicula">'.$pais.'</span>
    <span class="year_pelicula">'.$year.'</span>
    <span class="duration"><i class="far fa-clock retinaicon"></i>'. $duracion .'</span>
    '. $sub_salida .'
    
    </div>';
}

?>

<main class="pelicula">
    <div class="peliculaheader" style="background-image: url('<?php echo $fondopelicula; ?>');">

    <!--Datos básicos de película versión DESKTOP-->
    <?php datospeliculaHeader('peliculaDatos', $pais_pelicula, $year_pelicula, $duracion, $subtitulos );?>
        <?php
        if (is_user_logged_in()) {
            $retina_film = true;
            $muestra_film = peliculaIframe($video);
        }
        //Si está logueado
        if ($retina_film) {
            if (get_field("msg_custom") == '' && $video) {
                if (isset($trailer)) {
                    echo do_shortcode('[su_tabs][su_tab title="Tráiler"]' . $muestra_trailer . '[/su_tab] [su_tab title="Ver Película"]' . $muestra_film . '[/su_tab] [/su_tabs]');
                } else {
                    echo do_shortcode('[su_tabs][su_tab title="Ver Película" anchor="r"]' . $muestra_film . '[/su_tab][/su_tabs]');
                }
            } else {
                if ($trailer) {
                    echo do_shortcode('[su_tabs class="rl-pelicula-pelicula"][su_tab title="Tráiler"]' . $muestra_trailer . '[/su_tab] [su_tab title="Advertencia"]<span class="retina_advertencia">' . get_field("msg_custom") . '</span>[/su_tab] [/su_tabs]');
                } else {
                echo do_shortcode('[su_tabs class="rl-pelicula-pelicula"][su_tab title="Advertencia"]<span class="retina_advertencia">' . get_field("msg_custom") . '</span>[/su_tab] [/su_tabs]');
            }
        }
    } else {
        if (get_field("msg_custom") == '') {
            if ($trailer) {
                echo do_shortcode('[su_tabs class="rl-pelicula-pelicula"][su_tab title="Tráiler"]' . $muestra_trailer . '[/su_tab] [su_tab title="Accede"]<span class="retina_advertencia">' . $registro_pelicula . '</span>[/su_tab] [/su_tabs]');
            } else {
                echo do_shortcode('[su_tabs][su_tab title="Accede"]<span class="retina_advertencia">' . $registro_pelicula . '</span>[/su_tab] [/su_tabs]');
            }
        } else {
            if ($trailer) {
                echo do_shortcode('[su_tabs][su_tab title="Tráiler"]' . $muestra_trailer . '[/su_tab] [su_tab title="Accede"]<span class="retina_advertencia">' . $registro_inactiva . get_field("msg_custom") . '</span>[/su_tab] [/su_tabs]');
            } else {
                echo do_shortcode('[su_tabs class="rl-pelicula-pelicula"][su_tab title="Registro"]<span class="retina_advertencia">' . $registro_inactiva . get_field("msg_custom") . '</span>[/su_tab] [/su_tabs]');
            }
        }
    }
    echo '</div>';
    echo '<div class="peliculasidebar">';
    //the_field('poster');
    if (!empty($poster)) : ?>
        <div><img src="<?php echo $poster; ?>" alt="" title="" class="retinsposter_responsive" /></div>
    <?php endif; ?>
    <div class="info_poster" style="background: gray">
    <!-- Información en la barra lateral -->
    
    <!--Datos básicos de película versión MOVIL-->
    <?php datospeliculaHeader('movil-peliculaDatos', $pais_pelicula, $year_pelicula, $duracion, $subtitulos );?>
        
        <?php
            echo '<span class="ficha_datosprincipales">';
            echo creditos('Dirección', '', $director);
            echo formato_dato($formato_pelicula);
            echo formato_dato($genero_pelicula);
            echo formato_dato('<strong>Clasificación</strong>: ' . $clasificacion_edad);
            echo creditos('Reparto', '', $reparto);
            echo '</span>';
            //$screenwriter = get_field("screenwriter");
            $tags = get_the_tags();
            $customPostTaxonomies = get_object_taxonomies('video');
            $taxonomy_objects = get_object_taxonomies('video', 'names');
            ?>
    </div>
    <?php
        if ($musica) {
            $muestra_musica = tabla_popup("fas fa-music", "Música", $musica, "ficha_musica");
        } else {
            $muestra_musica = '';
        }
    echo '</div>';
    include_once('videosalida.php');
echo '</main>';
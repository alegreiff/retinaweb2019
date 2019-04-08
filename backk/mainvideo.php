<main class="pelicula">
    <div class="peliculaheader" style="background-image: url('<?php echo $fondopelicula; ?>');">
        <div class="peliculaDatos">
            <span class="paispelicula"><?php echo $pais_pelicula; ?></span>
            <span class="year_pelicula"><?php echo $year_pelicula; ?></span>
            <span class="duration"><i class="far fa-clock retinaicon"></i> <?php echo $duracion; ?> </span>
        </div>
        <?php if (is_user_logged_in()) {
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

        <div class="info_poster">
            <!-- Información en la barra lateral -->
            <div class="movil-peliculaDatos">
                <span class="paispelicula"><?php echo $pais_pelicula; ?></span>
                <span class="year_pelicula"><?php echo $year_pelicula; ?></span>
                <span class="duration"><i class="far fa-clock retinaicon"></i> <?php echo $duracion; ?> </span>

            </div>
            <?php
                                                                                echo 'Clasificación: ' . $clasificacion_edad;
                                                                                echo creditos('Dirección', '', $director);
                                                                                echo formato_dato($formato_pelicula);
                                                                                echo formato_dato($genero_pelicula);
                                                                                echo formato_dato('<strong>Clasificación</strong>: ' . $clasificacion_edad);
                                                                                echo creditos('Reparto', '', $reparto);
                                                                                $screenwriter = get_field("screenwriter");



                                                                                ?>
            <?php
                                                                                $tags = get_the_tags();
                                                                                //d($tags);
                                                                                $customPostTaxonomies = get_object_taxonomies('video');
                                                                                //d($customPostTaxonomies);

                                                                                //d($classification);
                                                                                //$language = wp_get_post_terms(get_the_ID() , 'videos_language');
                                                                                $taxonomy_objects = get_object_taxonomies('video', 'names');
                                                                                //d($taxonomy_objects);

                                                                                //$term_list = wp_get_post_terms($post->ID, 'videos_categories', array("fields" => "all"));
                                                                                //d($term_list);

                                                                                //$topics = wp_get_post_terms(get_the_ID(), 'videos_format');
                                                                                //d($topics);
                                                                                //d($formato_pelicula);
                                                                                //d($genero_pelicula);
                                                                                //d($idioma_pelicula);
                                                                                //d($post);
                                                                                ?>

        </div>

        <?php

                                                                                if ($musica) {
                                                                                    $muestra_musica = tabla_popup("fas fa-music", "Música", $musica, "ficha_musica");
                                                                                } else {
                                                                                    $muestra_musica = 'sin musikA';
                                                                                }
                                                                                echo '</div>';
                                                                                echo '<div class="peliculainfo">';
                                                                                //echo "<p>" . $video . "</p>";
                                                                                //echo 'FILM: ' . $retina_film . ' TRAILER: ' . $retina_trailer . 'MENSAJE: ' . get_field("msg_custom");


                                                                                echo '<h2 class="retina_titulopelicula">' . $post->post_title . '</h2>';
                                                                                echo '<div class="">' . do_shortcode($post->post_content) . '</div>';
                                                                                echo '<div class="galeria_retina">' . $galeria . '</div>';

                                                                                echo '
            <div class="datos_adicionales">
                <div class="datos_ficha"><h5>Ficha técnica y artística</h5>
                    <span class="ficha_direccion">
                    ' . creditos("Asistente de dirección", 'Asistentes de dirección', $director_asistente) . '
                    ' . creditos("Guionista", 'Guionistas', $guionista) . '
                    </span>
                    <span class="ficha_produccion">
                    ' . lista_asociada('País de producción', 'Países de producción',  $paises_produccion) . '
                    ' . creditos("Compañía productora", 'Compañías productoras', $companias) . '
                    ' . creditos("Productor", 'Productores', $productor) . '
                    ' . creditos("Jefe de producción", 'Jefes de producción', $jefe_produccion) . '
                    ' . creditos("Coproductor", 'Coproductores', $coproductor) . '
                    ' . creditos("Productor ejecutivo", 'Productores ejecutivos', $productor_ejecutivo) . '
                    ' . creditos("Productor asociado", 'Productores asociados', $productor_asociado) . '
                    ' . creditos("Productor de campo", 'Productores de campo', $productor_campo) . '
                    </span>
                    <span class="ficha_fotografia">
                    ' . creditos("Cámara", '', $camarografo) . '
                    ' . creditos("Director de fotografía", 'Directores de fotografía', $director_fotografia) . '
                    ' . creditos("Asistente de cámara", 'Asistentes de cámara', $asistente_camara) . '
                    ' . creditos("Fotofija", '', $fotofija) . '
                    </span>
                    <span class="ficha_audio">
                    ' . creditos("Sonidista", 'Sonidistas', $sonidista) . '
                    ' . creditos("Diseñador de sonido", 'Diseñadores de sonido', $sonido_disenador) . '
                    ' . creditos("Músico", 'Músicos', $musico) . '
                    ' . creditos("Mezcla de sonido", '', $sonido_mezcla) . '
                    ' . creditos("Narración", '', $narracion) . '
                    </span>
                    <span class="ficha_varios">
                    ' . creditos("Montajista", 'Montajistas', $montajista) . '
                    ' . creditos("Director de arte", 'Directores de arte', $director_arte) . '
                    ' . creditos("Animador", 'Animadores', $animador) . '
                    ' . creditos("Investigador", 'Investigadores', $investigador) . '
                    ' . creditos("Casting", '', $casting) . '
                    ' . creditos("Vestuario", '', $vestuario) . '
                    </span>
                    <p> ' . lista_asociada('Nacionalidad de la película', '',  $nacionalidad) . ' </p>
                </div>
                <!--<div class="datos_eventos">' .  wpautop($eventos) . '<hr />' . wpautop($premios) . '</div>-->
                <div class="datos_eventos">
                
                ' . $muestra_musica . '
                ' . tabla_popup("fas fa-award", "Premios y reconocimientos", $premios, "ficha_premios") . '
                ' . tabla_popup("fas fa-star", "Participación en eventos cinematográficos", $eventos, "ficha_eventos") . '
                
             </div>
              
                 
            </div>';



                                                                                echo '</div>';
                                                                                echo '</main>';

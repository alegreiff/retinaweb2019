<?php
echo '<div class="peliculainfo">';
        echo '  <h2 class="retina_titulopelicula">' . $post->post_title . '</h2>';
        echo '  <div class="">' . do_shortcode($post->post_content) . '</div>';
        echo '  <div class="galeria_retina">' . $galeria . '</div>';
        echo '  <div class="datos_adicionales">
                    <div class="datos_ficha" style="background: lime;">
                        <h5>Ficha técnica y artística</h5>';
                        //LLAMA TEMPLATE PART FICHA DE DIRECCIÓN
                        include_once('fichadireccion.php');
                        //LLAMA TEMPLATE PART FICHA DE PRODUCCIÓN
                        include_once('fichaproduccion.php');
                        //LLAMA TEMPLATE PART FICHA DE FOTOGRAFÍA
                        include_once('fichafotografia.php');
                        //LLAMA TEMPLATE PART FICHA DE AUDIO
                        include_once('fichaaudio.php');
                        //LLAMA TEMPLATE PART FICHA VARIOS
                        include_once('fichavarios.php');
                    echo '<p>' . lista_asociada('Nacionalidad de la película', '', $nacionalidad).'</p>
                    </div>
                    <div class="datos_eventos" style="background: crimson">';
                    include_once('musica-premios-eventos.php');
                    echo '
                    </div>
                </div>';
echo '</div>';


<?php
echo '<div class="peliculainfo">';
        echo '  <h2 class="retina_titulopelicula">' . $post->post_title . '</h2>';
        if($otros_nombres){
            echo '<h5>'.$otros_nombres . '</h5>';
            
        }
        echo '  <div class="'.$geobloqueo.'">' . do_shortcode($post->post_content) . '</div>';
        if($inspirado){
            echo '<p class="rl_inspirado">'.$inspirado . '</p>';
            
        }
        echo '  <div class="galeria_retina">' . $galeria . '</div>';
        echo '  <div class="datos_adicionales">
                    <div class="datos_ficha">
                        <h5>Ficha técnica y artística</h5>';
                        echo '<div class="fichacolretina">';
                        //LLAMA TEMPLATE PART FICHA DE DIRECCIÓN
                        echo '<div class="fichacol001">';
                        include_once('fichadireccion.php');
                        //LLAMA TEMPLATE PART FICHA DE PRODUCCIÓN
                        include_once('fichaproduccion.php');
                        include_once('fichafotografia.php');
                        include_once('musica-premios-eventos.php');
                        //LLAMA TEMPLATE PART FICHA DE FOTOGRAFÍA
                        echo '</div>';
                        echo '<div class="fichacol002">';
                        
                        //LLAMA TEMPLATE PART FICHA DE AUDIO
                        include_once('fichaaudio.php');
                        //LLAMA TEMPLATE PART FICHA VARIOS
                        include_once('fichavarios.php');
                        echo '</div>';
                        echo '</div>';
                        
                    echo '</div>
                    <div class="datos_eventos">';
                    
                    echo '
                    </div>
                </div>';
echo '</div>';


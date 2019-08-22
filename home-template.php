<?php
/**
 * Template Name: Retina Latina - página de inicio
 * Plantilla Home Page RetinaLatina

 * @package retina
 */

remove_action ('genesis_loop', 'genesis_do_loop'); // Remove the standard loop
add_action( 'genesis_loop', 'peliculas_retina_home' ); // Add custom loop

function peliculas_retina_home() {

    /* Obtengo los parámetros de la página ACF */
    $traileresID = (get_field('eltrailer')); 
    $trailerinterno = get_field('trailerinterno');
    $directores = get_field('personajes_home');

    
    $traileres = array();
    foreach ($traileresID as $trailer) {
        $traileres[]= array(
            'titulo' => get_the_title($trailer),
            'trailer' => getYouTubeId(get_field('trailer', $trailer)),
            'url' => get_post_permalink($trailer),
            'pais' => get_field('country_group', $trailer)
        );
    }
    $et = $traileres[array_rand($traileres)];

    if(get_field('aliados')):
        $aliados = array();
        while(the_repeater_field('aliados')):
            $aliados[] = array(
                'imagen' => get_sub_field('imagen')['url'],
                'describe' => get_sub_field('texto_alianza'),
                'enlace' => get_sub_field('enlace'),

            );
        endwhile;
    endif;
    $numero_de_peliculas = get_field('num_peliculas');
    $categoria_home = get_field('peliculas_categoria');
    $destacado = get_field('destacado_home');
    //$haylistados=get_field('listado_secundario');

    if(get_field('listado_secundario')=='SI'){
        if(get_field('num_peliculas_secundaria')){
            $numero_de_peliculas_secundario = get_field('num_peliculas_secundaria');
        }
        if(get_field('peliculas_categoria_secundaria')){
            $categoria_home_secundario = get_field('peliculas_categoria_secundaria');
        }
        if(get_field('nombre_listado_secundaria')){
            $texto_home_secundaria = get_field('nombre_listado_secundaria');
        }
        if(get_field('enlace_secundarias')){
            $enlace_secundaria = get_field('enlace_secundarias');
        }

    }
    ?>
    <div class="rl_home">
        <div class="destacados">
            <div class="video">
            <?php
                //echo video_embebido($destacado);
                //echo $destacado->post_title;
                if($trailerinterno ==='SI'){
                echo peliculaTrailer($et['trailer']); 
                echo ($et['titulo']);
                }else{
                    echo peliculaTrailer(getYouTubeId(get_field('video_estreno'))); 
                    echo (get_field('mensaje_estreno'));
                    
                }
                
                
            ?>
            </div>
            
            
                <div class="ciclo">
                <div class="slider">
                <?php

                foreach($aliados as $aliado){

                    echo '<div>
                            <a href="'.$aliado['enlace'].'">
                                <img src="'.$aliado['imagen'].'" title="'.$aliado['describe'].'" style="width: 600px">
                            </a>


                    </div>';
                }

                ?>

                </div>
                <div class="slider-txt"></div>
            </div>
             
        </div>
        <div class="peliculas">
        <?php
        /**Loop películas
         */
        $args = array(
            'posts_per_page'=> $numero_de_peliculas,
            'post_type' => 'video',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'videos_categories',
                    'field'    => 'id',
                    'terms' => $categoria_home,
                    'operator' => 'IN'
                ),
                array(
                    'taxonomy' => 'videos_categories',
                    'field'    => 'id',
                    'terms' => categoria_archivo(),
                    'operator' => 'NOT IN'
                ),
            ),
            'orderby' => 'rand',
        );
        $loop = new WP_Query( $args );
        if( $loop->have_posts() ):

            while( $loop->have_posts() ): $loop->the_post(); global $post;

            $poster = trae_poster(get_field('poster'));
            $pais_pelicula = muestra_codigopais(get_field('country_group'));
            $formato_pelicula = wp_get_post_terms(get_the_ID(), 'videos_format')[0]->name;
            $genero_pelicula = wp_get_post_terms(get_the_ID(), 'videos_genres')[0]->name;
            $duracion = get_field('duration');
            $year = get_field('year');

            echo '

            <div class="retina_poster">
                <a href="'.get_post_permalink().'">
                    <div class="picture" >
                        <img src="'.$poster.'" alt="">
                        <span class="duracion"> '.($duracion).'</span>
                    </div>
                    <div class="navigation">
                        <span class="pais">'.$pais_pelicula.' - '.$year.'</span>
                        <h4>'.get_the_title().'</h4>
                        <span class="formato">'.muestra_genero($genero_pelicula).'</span>
                    </div>
                </a>
            </div>
            ';
            endwhile;
        endif;
        wp_reset_query();
        ?>
        </div>
        <?php
            if(isset($numero_de_peliculas_secundario)){
            ?>
        <div class="peliculas secundarias sec_<?php echo $numero_de_peliculas_secundario;?>">
        <?php
            if($texto_home_secundaria){
                echo '<div class="secundarias_titulo"><h4><a href="'.$enlace_secundaria.'">'.$texto_home_secundaria.'</a></h4></div>';
            }
        /**Loop películas
         */
        $args = array(
            'posts_per_page'=> $numero_de_peliculas_secundario,
            'post_type' => 'video',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'videos_categories',
                    'field'    => 'id',
                    'terms' => $categoria_home_secundario,
                    'operator' => 'IN'
                ),
                array(
                    'taxonomy' => 'videos_categories',
                    'field'    => 'id',
                    'terms' => categoria_archivo(),
                    'operator' => 'NOT IN'
                ),
            ),
            'orderby' => 'rand',
        );
        $loop = new WP_Query( $args );
        if( $loop->have_posts() ):

            while( $loop->have_posts() ): $loop->the_post(); global $post;

            $poster = trae_poster(get_field('poster'));
            //$pais_pelicula = get_field('country_group');

            $pais_pelicula = muestra_codigopais(get_field('country_group'));
            $formato_pelicula = wp_get_post_terms(get_the_ID(), 'videos_format')[0]->name;
            $genero_pelicula = wp_get_post_terms(get_the_ID(), 'videos_genres')[0]->name;
            $duracion = get_field('duration');
            $year = get_field('year');

            echo '

            <div class="retina_poster">
                <a href="'.get_post_permalink().'">
                    <div class="picture" >
                        <img src="'.$poster.'" alt="">
                        <span class="duracion"> '.($duracion).'</span>
                    </div>
                    <div class="navigation">
                        <span class="pais">'.$pais_pelicula.' - '.$year.'</span>
                        <h4>'.get_the_title().'</h4>
                        <span class="formato">'.muestra_genero($genero_pelicula).'</span>
                    </div>
                </a>
            </div>
            ';
            endwhile;
        endif;
        wp_reset_query();
        ?>
        </div>
            <?php
            }
        ?>
        <!-- <div class="aliados">
        <h4>Alianzas</h4>
            <?php
                /* $posicion = 0;
                foreach($aliados as $aliado){
                    $posicion++;
                    echo '<div class="alianza'.$posicion.'">
                            <a href="'.$aliado['enlace'].'">
                                <img src="'.$aliado['imagen'].'" alt="'.$aliado['describe'].'">
                            </a>
                                <p><a href="'.$aliado['enlace'].'">'.$aliado['describe'].'</a></p>

                    </div>';
                } */
            ?>
        </div> -->
        <div class="homeCierre">
            <div><h2>Noticias</h2></div>
            <div><h2>Personajes</h2></div>
            <div class="noticias">
                <?php
                        $loopNoticias = noticias_home();
                        if( $loopNoticias->have_posts() ):

                            while( $loopNoticias->have_posts() ): $loopNoticias->the_post(); 
                            global $post;

                            if(!get_the_post_thumbnail()){
                                $imagen='<img src='.get_stylesheet_directory_uri().'/images/no-imagendestacada.jpg">';
                            }else{
                                $imagen = get_the_post_thumbnail();
                            }
                            $categoria = get_the_category()[0]->cat_name;
                            $fecha = ucfirst(get_the_date( 'F j \d\e Y' ));
                            $contenido = get_the_excerpt(60);
                            //d($contenido);
                            echo '
                            <div class="noticia">
                                <span class="fecha">'.$fecha.'</span>
                                '.$imagen.'
                                <div>
                                <a href="'.get_post_permalink().'">'.get_the_title().'</a>
                                <p>'.$contenido.'</p>
                                </div>
                            </div>';
                            endwhile;
                        endif;                    
                    ?>
            </div>
            <div class="personajes">
                
                    <?php
                    //$loopPersonas = $lesdirecteurs;
                    $loopPersonas = $directores;
                    
                    foreach ($loopPersonas as $persona) {
                        //d($persona);
                        
                        $imagen = get_the_post_thumbnail($persona['peliculadirector'][0]);
                        $personaje = get_field('director', $persona['peliculadirector'][0]);

                        if(!get_the_post_thumbnail($personaje[0]->ID)){
                            $imagenDIR='<img src='.get_stylesheet_directory_uri().'/images/no-director.jpg">';
                        }else{
                            $imagenDIR = get_the_post_thumbnail($personaje[0]->ID);
                        }

                        $genero = $persona['genre'] ? 'Director' : 'Directora';
                        echo '<div class="personaje">
                                <p>'.get_the_title($personaje[0]->ID).'</p>
                                <a href="'.get_post_permalink($personaje[0]->ID).'"> 
                                '.$imagenDIR.'
                                </a> 
                                <p>'.get_field("citizenship_person", $personaje[0]->ID).'</p> 
                                <p>'.$genero.'</p> 
                                
                        </div>';
                        
                    }
                        
                                  
                    ?>

            </div>
        </div>
    </div>

    <?php
}

/**
 * FUNCIONES AUXILIARES
 */
function peliculaTrailer($trailer){
    //return '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="100%" height="100%" src="http://www.youtube.com/embed/' . $trailer . '"frameborder="0" allowFullScreen></iframe>';
            return '<iframe src="https://www.youtube.com/embed/' . $trailer . '?rel=0;controls=1;showinfo=0;theme=light" 
allowfullscreen width="100%" height="90%" frameborder="0"></iframe>';
}

function personas_home(){

    $args = array(
            'posts_per_page'=> 4,
            'post_type' => 'person',
            'fields' => 'ids',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'persons_categories',
                    'field'    => 'slug',
                    'terms' => 'enportada',
                    
                    'operator' => 'IN'
                )
            ),
            'orderby' => 'rand',
        );
        $personajes = new WP_Query( $args );
        wp_reset_query();
        d($personajes->posts);
    return $personajes;

}

function noticias_home(){

    $args = array(
            'posts_per_page'=> 2,
            'post_type' => 'post',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms' => 'portada',
                    'operator' => 'IN'
                )
            ),
            'orderby' => 'date',
        );
        $loop = new WP_Query( $args );
        wp_reset_query();
    return $loop;

}
 genesis();

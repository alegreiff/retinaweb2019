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


    //d($aliados);


    ?>
    <div class="rl_home">
        <div class="destacados">
            <div class="video">
            <?php
                echo $destacado->post_title;
                echo video_embebido($destacado);
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
            //$pais_pelicula = get_field('country_group');

            $pais_pelicula = muestra_codigopais(get_field('country_group'));
            d($pais_pelicula);
            $formato_pelicula = wp_get_post_terms(get_the_ID(), 'videos_format')[0]->name;
            $genero_pelicula = wp_get_post_terms(get_the_ID(), 'videos_genres')[0]->name;
            $duracion = get_field('duration');
            $year = get_field('year');

            echo '

            <div class="container">
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
            if($numero_de_peliculas_secundario){
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
            d($pais_pelicula);
            $formato_pelicula = wp_get_post_terms(get_the_ID(), 'videos_format')[0]->name;
            $genero_pelicula = wp_get_post_terms(get_the_ID(), 'videos_genres')[0]->name;
            $duracion = get_field('duration');
            $year = get_field('year');

            echo '

            <div class="container">
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
        <div class="aliados">
        <h4>Alianzas</h4>
            <?php
                $posicion = 0;
                foreach($aliados as $aliado){
                    $posicion++;
                    echo '<div class="alianza'.$posicion.'">
                            <a href="'.$aliado['enlace'].'">
                                <img src="'.$aliado['imagen'].'" alt="'.$aliado['describe'].'">
                            </a>
                                <p><a href="'.$aliado['enlace'].'">'.$aliado['describe'].'</a></p>

                    </div>';
                }
            ?>
            <!--<div class="alianza1">001</div>
            <div class="alianza2">002</div>
            <div class="alianza3">003</div>-->
        </div>
        <div class="datos">
            <div class="noticias">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ea magnam facere voluptas repellendus optio rem at animi quidem illum quod cupiditate expedita culpa dolores sapiente qui, est quo in impedit.</div>
            <div class="personajes">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum molestias ea eum doloribus ad nostrum iste architecto magni consectetur iure dolor quas numquam, nobis beatae incidunt, earum odit tenetur deleniti.</div>
        </div>
    </div>




    <?php
}

/**
 * FUNCIONES AUXILIARES
 */



 genesis();

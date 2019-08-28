<?php
/**
 * Author: Sridhar Katakam
 * Link: https://sridharkatakam.com/
 * https://sridharkatakam.com/custom-search-template-in-genesis-showing-results-grouped-by-post-types/
 */
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'sk_do_search_loop' );
/**
 * Outputs a custom loop.
 *
 * @global mixed $paged current page number if paginated.
 * @return void
 */

function sk_do_search_loop() {
	// create an array variable with specific post types in your desired order.
    $post_types = array( 'video', 'post', 'person' );
    the_field('opciones_rl_eslogan', 'option');

	echo '<div class="search-content">';
	foreach ( $post_types as $post_type ) {
        
		// get the search term entered by user.
        $s = isset( $_GET["s"] ) ? $_GET["s"] : "";
		// accepts any wp_query args.
		$args = (array(
			's' => $s,
			'post_type' => $post_type,
			'posts_per_page' => 10,
			'order' => 'ASC',
            'orderby' => 'title',
            
            'paged' => get_query_var( 'paged' )

		));
        $query = new WP_Query( $args );
        //d($query);
        switch ($post_type) {
            case 'video':
                $nombreColeccion = 'Películas';
                $clase= 'peliculas_search';
                break;
            case 'person':
                $nombreColeccion = 'Personajes del cine';
                $clase= 'persona_search';
                break;
            case 'post':
                $nombreColeccion = 'Entradas';
                $clase= 'posts_search';
                break;
        }
		if ( $query->have_posts() ) {

            echo '<div class="post-type '. $post_type .'"><div class="post-type-heading">'. $nombreColeccion. '</div>';


            echo '<div class="'.$clase.'">';
                if ($post_type!='video'){
                     $loop = new WP_Query( $args );
                    if( $loop->have_posts() ):
                        while( $loop->have_posts() ): $loop->the_post(); 
                        if($post_type==='person'){

                            $fields = get_fields();

                            d(the_post());
                            //if(has_term( ['Director', 'Colorizador', 'Maquillador'], 'persons_categories')){
                            if(get_the_post_thumbnail()){
                                $imagenDIR = get_the_post_thumbnail()? get_the_post_thumbnail(): 'ND';
                                if(!get_the_post_thumbnail()){
                                    $imagenDIR='<img src='.get_stylesheet_directory_uri().'/images/no-director.jpg">';
                                }else{
                                    $imagenDIR = get_the_post_thumbnail();
                                }
                                $dir = '<h6>Director</h6>';
                                echo '
                        <div class="container">
                        <a href="'.get_post_permalink().'">'.get_the_title().'  
                        '.$imagenDIR.'
                        </a>
                        '.$dir.'
                        </div>';
                            }
                        }else{
                          if(!get_the_post_thumbnail()){
                                    $imagen='<img src='.get_stylesheet_directory_uri().'/images/no-imagendestacada.jpg">';
                            }else{
                                    $imagen = get_the_post_thumbnail();
                            }
                            $categoria = get_the_category()[0]->cat_name;
                            ($categoria);
                            $fecha = ucfirst(get_the_date( 'F j \d\e Y' ));
                            echo '
                        <div class="container">
                        <p class="busca_fecha">'.$fecha.' </p>
                        
                        <a href="'.get_post_permalink().'"><h6 class="busca_titulo">'.get_the_title().'</h6>  
                        '.$imagen.'
                        </a>
                         <p class="busca_autor">'.get_the_author_meta( 'display_name').'</p>
                         <p class="busca_autor">'.$categoria.'</p>


                         
                        </div>';
                        }
                        endwhile;
                        echo '</div>';
                    endif;
                    //wp_reset_query();
                    
                    //genesis_custom_loop( $args );
                }else{
                    
                    $loop = new WP_Query( $args );
                    if( $loop->have_posts() ):
                        //echo '<div class="peliculas_search">';
                        while( $loop->have_posts() ): $loop->the_post(); 
                        
                        //global $post;
                        $poster = trae_poster(get_field('poster'));
                         
                        //$pais_pelicula = get_field('country_group');
                        $pais_pelicula = muestra_codigopais(get_field('country_group'));
                        //d($pais_pelicula);
                        $formato_pelicula = wp_get_post_terms(get_the_ID(), 'videos_format')[0]->name;
                        //d($formato_pelicula);
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
                        </div>';
                        endwhile;
                        echo '</div>';
                    endif;
        
                    wp_reset_query();
                }
                
			echo '</div>';
            
		}
    }
    echo '</div>';
    //echo '</div><h1 style="color: crimson">POR MEJORAR Búsqueda en etiquetas</h1>'; 
    // .search-content
}


genesis();
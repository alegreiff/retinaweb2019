<?php 
/**
 * Author: Hastimal Shah
 * Link: http://hastishah.com/
 * Email: hasti@hastishah.com
 */

 /* Remove the default loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'hs_do_search_loop' );
/**
 * Outputs a custom loop
 *
 * @global mixed $paged current page number if paginated
 * @return void
 */
	function hs_do_search_loop() {
    global $post;
	// create an array variable with specific post types in your desired order
    //$post_types = array('news','article', 'page', 'post' ); // other custom post type can be added.
    $post_types = array( 'video', 'post', 'person' );
	echo '<div class="search-content">';
	foreach ( $post_types as $post_type ) {
		// get the search term entered by user
		$s = isset( $_GET["s"] ) ? $_GET["s"] : "";
		// accepts any wp_query args
		$args = (array(
			's' => $s,
			'post_type' => $post_type,
			'posts_per_page' => 7,
			'order' => 'DESC',
            'orderby' => 'date'
            
		));
        
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
		
		
        global $wp_query;
        $wp_query  = new WP_Query( $args );
        if ( $wp_query->have_posts() ) {
			echo '<div class="post-type '. $post_type .'"><div class="post-type-heading">'. $nombreColeccion . '</div>';    
			if($post_type === 'video'){
				
				echo '<div class="peliculas">';
				while( $wp_query->have_posts() ): $wp_query->the_post(); 
				$poster = trae_poster(get_field('poster', get_the_ID()));
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
				echo '</div>';
			}else if($post_type === 'person'){
				echo '<div class="personajesbusqueda">';
				while( $wp_query->have_posts() ): $wp_query->the_post(); 
				$fields = get_fields();
				d($fields);
				//if(has_term( ['Director', 'Script / Continuista'], 'persons_categories')){
				$content = get_the_content();
					//d($content);
				if(strlen($content)>0){
					if(!get_the_post_thumbnail()){
						$imagenDIR='<img src='.get_stylesheet_directory_uri().'/images/no-director.jpg">';
					}else{
						$imagenDIR = get_the_post_thumbnail();
					}

					
					echo '<div class="personaje">
							<p>'.get_the_title().'</p>
							<a href="'.get_post_permalink().'"> 
							'.$imagenDIR.'
							</a> 
							<p>'.get_field("citizenship_person").'</p> 
							
							
					</div>';
				}
				
				endwhile;
				echo '</div>';
			}else{
				while( $wp_query->have_posts() ): $wp_query->the_post(); 
				echo the_title() . '<hr />';    
				endwhile;
			}
			//do_action( 'genesis_after_endwhile' );
            
            

			echo '</div>'; // .post-type video / post  / person
		}
        

        
        
    }
    
    
	echo '</div>'; // .search-content
}

genesis();

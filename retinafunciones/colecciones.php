<?php 
/** AJAX FILTER */
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
function theme_name_scripts() {
	if ( is_page_template('paises.php') || is_tax('videos_categories') ) {
		wp_enqueue_script( 'script-name', get_stylesheet_directory_uri() . '/js/pagina.js', array('jquery'), '1.0.0', true );
		wp_localize_script( 'script-name', 'MyAjax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'security' => wp_create_nonce( 'my-special-string' )
		));
	}
}

// AJAX carga de películas para la plantilla de paises (categorías)
add_action('wp_ajax_filtro_peliculas_retina', 'filtro_peliculas_retina');
add_action('wp_ajax_nopriv_filtro_peliculas_retina', 'filtro_peliculas_retina');

function filtro_peliculas_retina(){
	//https://rudrastyh.com/wordpress/ajax-post-filters.html
	$args = array(
		'orderby' => 'date', // we will sort posts by date
		'order'	=> $_POST['date'], // ASC or DESC
		'posts_per_page' => -1,
        'post_type' => 'video',
        'post_status' => 'publish'
	);

	// for taxonomies / categories
    if( isset( $_POST['categoria_mostrada'] ) )
    $categorias = $_POST['categoria_mostrada'];
    if(isset( $_POST['formato']) && $_POST['formato'] == ''){
        $categorias = $_POST['categoria_mostrada'];
    }else{
        $categorias = array($_POST['categoria_mostrada'], $_POST['formato']);
    }
	if($_POST['categoria_mostrada'] == categoria_archivo()){
        $args['tax_query'] = array(
            'relation' => 'AND',

			array(
				'taxonomy' => 'videos_categories',
				'field' => 'id',
				'terms' => $_POST['categoria_mostrada']
			),
			array(
				'taxonomy' => 'videos_format',
				'field'    => 'id',
				'terms' => $_POST['formato'],
				'operator' => 'AND'
            ),
			array(
				'taxonomy' => 'videos_genres',
				'field'    => 'id',
				'terms' => $_POST['genero'],
				'operator' => 'AND'
            )
		);
    }else{
        $args['tax_query'] = array(
            'relation' => 'AND',

			array(
				'taxonomy' => 'videos_categories',
				'field' => 'id',
				'terms' => $_POST['categoria_mostrada']
			),
			array(
				'taxonomy' => 'videos_format',
				'field'    => 'id',
				'terms' => $_POST['formato'],
				'operator' => 'AND'
            ),
			array(
				'taxonomy' => 'videos_genres',
				'field'    => 'id',
				'terms' => $_POST['genero'],
				'operator' => 'AND'
            ),
            array(
				'taxonomy' => 'videos_categories',
				'field'    => 'id',
				'terms' => 917,
				'operator' => 'NOT IN'
            ),
		);
    }

    $query = new WP_Query( $args );
    $total = $query->found_posts;


	if( $query->have_posts() ) :
        //CONTROL CUÁNTOS ELEMENTOS
        //echo '<h1>'.$total.'</h1>';
        //echo '<div class="peliculas_paises">';
		while( $query->have_posts() ): $query->the_post();
		$poster = trae_poster(get_field('poster'));
        $pais_pelicula = muestra_codigopais(get_field('country_group'));
        $formato_pelicula = wp_get_post_terms(get_the_ID(), 'videos_format')[0]->name;
        $genero_pelicula = wp_get_post_terms(get_the_ID(), 'videos_genres')[0]->name;
        $duracion = get_field('duration');
            $year = get_field('year');
        //d($formato_pelicula);
			//echo '<h2>' . $query->post->post_title . '</h2>';
            //var_dump(get_field('poster'));

            echo '
            <div class="retina_poster">
            <a href="'.enlace_relativo(get_post_permalink()).'">
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
		wp_reset_postdata();
		//echo '</div>';
	else :
		echo 'No hay películas en esta categoría';
	endif;

	wp_die();
}

// Función auxiliar de filtro_peliculas_retina
function enlace_relativo($enlace){
    $domain = get_site_url(); // returns something like http://domain.com
    $relative_url = str_replace( $domain, '', $enlace );
    return $relative_url;
}

/*function get_relative_thumb( $size ) {
    global $post;
    if ( has_post_thumbnail()) {
      $absolute_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size);
     $domain = get_site_url(); // returns something like http://domain.com
     $relative_url = str_replace( $domain, '', $absolute_url[0] );
     return $relative_url;
    }
}*/

function catalogo_peliculas_taxonomia($taxonomia)
{
    global $post;
    $taxonomy = $taxonomia; //change me
    $term     = get_query_var('term');
    $term_obj = get_term_by('slug', $term, $taxonomy);
    $cpt      = 'video'; //change me
    
    //if (function_exists('genesis_grid_loop')) {
        $args = array(
            'posts_per_page' => -1,
            'post_type' => $cpt,
            'order' => 'ASC',
            'orderby' => 'title',
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => array(
                        $term_obj->slug
                    )
                )
            )
        );
        global $wp_query;
        $wp_query  = new WP_Query( $args );
        if ( $wp_query->have_posts() ) {
			
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
			

		}
        

}

add_action( 'wp_enqueue_scripts', 'esnayoajax' ); 
function esnayoajax() {
	if ( is_tax('videos_format') ) {
		wp_enqueue_script( 'script-name', get_stylesheet_directory_uri() . '/js/taxonomias_video_ajax.js', array('jquery'), '1.0.0', true );
		wp_localize_script( 'script-name', 'pachukas', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'my-special-pachukas' ),
        'imagen' => get_stylesheet_directory_uri().'/images/bx_loader.gif'
		));
	}
}
add_action('wp_ajax_myfilter', 'misha_filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_myfilter', 'misha_filter_function');

function misha_filter_function(){
    
    
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'video',
        'order' => $_POST['fechaentrada'],
        'orderby' => 'date',
        'post_status' => 'publish',
        
    );

    if( isset( $_POST['genero'] ) && $_POST['genero'] !== ''){
        
        
        
        $args['tax_query'] = array(
            'relation' => 'AND',
            array(
				'taxonomy' => 'videos_format',
				'field'    => 'id',
				'terms' => $_POST['termino']
			
            ),

			array(
				'taxonomy' => 'videos_genres',
				'field' => 'id',
                'terms' => $_POST['genero'],
                'operator' => 'AND'
            ),
            
			
        );
    }else{
        
        
        $args['tax_query'] = array(
            'relation' => 'AND',
            array(
				'taxonomy' => 'videos_format',
				'field'    => 'id',
				'terms' => $_POST['termino']
			
            )
            
			
        );
        
    }
        
        //global $wp_query;
        //$wp_query  = new WP_Query( $args );
        $query = new WP_Query( $args );
        $total = $query->found_posts;
        
        if ( $query->have_posts() ) {
                echo '<div class="rl_peliculas_total">'.$total. ' - ORDEN: ' .$_POST['fechaentrada'].' - EDAD '.$_POST['edad'].'</div>';
			
				echo '<div class="peliculas">';
				while( $query->have_posts() ): $query->the_post(); 
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
                wp_reset_postdata();
				echo '</div>';
			

		}else{
            echo 'No postres found';
        }
 
	die();
}

<?php

remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'persona_categoria_retina');

function persona_categoria_retina(){

        global $post;
        $taxonomy = 'persons_categories'; //change me
        $term     = get_query_var('term');
        $term_obj = get_term_by('slug', $term, $taxonomy);
        $cpt      = 'person'; //change me
        
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
                $size = "persona-mini";
                
                    echo '<div class="personajesListado">';
                    while( $wp_query->have_posts() ): $wp_query->the_post(); 
                        $imagen = get_the_post_thumbnail();
                        //$personaje = get_field('director');

                        if(!get_the_post_thumbnail()){
                            $imagenDIR='<img src='.get_stylesheet_directory_uri().'/images/no-director.jpg">';
                        }else{
                            $imagenDIR = get_the_post_thumbnail(get_the_ID(), $size);
                        }

                        
                        echo '<div class="personaje">
                                <p class="nombre">'.get_the_title().'</p>
                                <a href="'.get_post_permalink().'"> 
                                '.$imagenDIR.'
                                </a> 
                                <p>'.get_field("citizenship_person").'</p> 
                                
                                
                        </div>';
                    endwhile;
                    echo '</div>';
                
    
            }
            
    
        
}

genesis();
<?php
/* remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'wps_grid_loop_helper');

function wps_grid_loop_helper(){
    catalogo_peliculas_taxonomia('videos_categories');
}

genesis(); */


remove_action ('genesis_loop', 'genesis_do_loop'); // Remove the standard loop
add_action( 'genesis_loop', 'retina_loop_paises' ); // Add custom loop

    global $wp;
    //$categoria = add_query_arg( array(), $wp->request );
    $categoria = get_queried_object()->slug;
    
    

function retina_loop_paises(){
    global $categoria;
    
    $cat = get_term_by('slug', $categoria, 'videos_categories')->term_id;
    
    ?>
    <div class="paises">
    <div class="header_peliculas"><i class="fas fa-film"></i>

</div>
        
<div class="filtros">

    

        
            <form id="filter">
                <input type="hidden" name="action" value="filtro_peliculas_retina">
                <input type="hidden" name="categoria_mostrada" value="<?php echo $cat;?>">

                <div class="controles">
                    <div class="switch-field">
                        
                        <input type="radio" id="switch_3_left" name="formato" value="" checked/>
                        <label for="switch_3_left">Todas las duraciones</label>
                        <input type="radio" id="switch_3_center" name="formato" value="92" />
                        <label for="switch_3_center">Cortometrajes</label>
                                <input type="radio" id="switch_3_right" name="formato" value="93" />
                        <label for="switch_3_right">Largometrajes</label>
                    </div>
                    
                    <div class="switch-field">
                        
                        <input type="radio" id="genero_left" name="genero" value="" checked/>
                        <label for="genero_left">Todos los géneros</label>
                        <input type="radio" id="genero_center" name="genero" value="19" />
                        <label for="genero_center">Documental</label>
                                <input type="radio" id="genero_right" name="genero" value="66" />
                        <label for="genero_right">Ficción</label>
                    </div>
                    <div><span class="mensaje">Mensaje</span></div>
                </div>
                
                
                
            </form>
        </div><!-- filtros-->

        
        <?php
            echo '<div class="peliculas_paises">Cargando';
            echo '</div>'; //peliculas_paises
            echo '</div>'; //paises
}

//función auxiliar para que muestre la categoría archivo
function es_archivo(){
    global $categoria;
    if($categoria == 'archivo'){
        return 0;
    }else{
        return categoria_archivo();
    }
}
genesis();



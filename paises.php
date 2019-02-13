<?php
/** 
 * Template Name: Retina Latina - Países
 * Plantilla PAÍSES RetinaLatina

 * @package retina
 */

remove_action ('genesis_loop', 'genesis_do_loop'); // Remove the standard loop
add_action( 'genesis_loop', 'retina_loop_paises' ); // Add custom loop

    global $wp;
    $categoria = add_query_arg( array(), $wp->request );

function retina_loop_paises(){
    global $categoria;
    $cat = get_term_by('slug', $categoria, 'videos_categories')->term_id;
    //d($cat);
    ?>
    <div class="paises">
    <div class="header_peliculas"><i class="fas fa-film"></i>

</div>
        
<div class="filtros">

    

        
            <form id="filter">
                <input type="hidden" name="action" value="filtro_peliculas_retina">
                <input type="hidden" name="categoria_mostrada" value="<?php echo $cat;?>">
                <!--<div class="switch-field">
                    <div class="switch-title">Is this awesome?</div>
                    <input type="radio" id="switch_left" name="switch_2" value="yes" checked/>
                    <label for="switch_left">Yes</label>
                    <input type="radio" id="switch_right" name="switch_2" value="no" />
                    <label for="switch_right">No</label>
                </div>-->
                <div class="controles">
                    <div class="switch-field">
                        
                        <input type="radio" id="switch_3_left" name="formato" value="" checked/>
                        <label for="switch_3_left">Todas las duraciones</label>
                        <input type="radio" id="switch_3_center" name="formato" value="22" />
                        <label for="switch_3_center">Cortometrajes</label>
                                <input type="radio" id="switch_3_right" name="formato" value="25" />
                        <label for="switch_3_right">Largometrajes</label>
                    </div>
                    
                    <div class="switch-field">
                        
                        <input type="radio" id="genero_left" name="genero" value="" checked/>
                        <label for="genero_left">Todos los géneros</label>
                        <input type="radio" id="genero_center" name="genero" value="23" />
                        <label for="genero_center">Documental</label>
                                <input type="radio" id="genero_right" name="genero" value="24" />
                        <label for="genero_right">Ficción</label>
                    </div>
                    <div><span class="mensaje">Mensaje</span></div>
                </div>
                <!--<label>
                    <input type="radio" name="formato" value="25" /> LARGO
                </label>
                <label>
                    <input type="radio" name="formato" value="22" /> CORTO
                </label>
                <label>
                    <input type="radio" name="formato" value="" checked="checked" /> TODOS
                </label>
                <label>
                    <input type="radio" name="date" value="ASC" /> Date: Ascending
                </label>
                <label>
                    <input type="radio" name="date" value="DESC" checked="checked" /> Date: Descending
                </label>-->
                
                
            </form>
        </div><!-- filtros-->
        <div class="menu">
        <?php
            echo'<div class="nav-primary">';
            //wp_nav_menu( array( 'theme_location' => 'third-menu', 'container_class' => 'genesis-nav-menu' ) );
            wp_nav_menu(array(
'container_class' => 'menu_paises',    // para que no tenga contenedor
'theme_location' => 'paises_paginas_menu',    // id del menu
'link_before' => '<div>', // HTML previo al texto de cada sección
'link_after' => '</div>'    // HTML posterior al texto de cada sección
));
            echo'</div>';
        ?>
        </div>
        
        <?php
            echo '<div class="peliculas_paises">';
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



<?php
//https://wpsmith.net/2011/how-to-make-a-custom-taxonomy-genesis-grid-archive-template/
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'wps_grid_loop_helper');
/** Add support for Genesis Grid Loop **/
    
function wps_grid_loop_helper(){
	?>
	<div id="contenedor_peliculas_ajax">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cargando.gif" alt="">
	</div>
	<?php
}

remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_headline', 10, 3 );
add_action( 'genesis_archive_title_descriptions', 'custom_do_archive_headings_headline', 10, 3 );

function custom_do_archive_headings_headline( $heading = '', $intro_text = '', $context = '' ) {
    $taxonomy = 'videos_format'; //change me
    $term     = get_query_var('term');
    $term_obj = get_term_by('slug', $term, $taxonomy);
	?>
		<div><?php echo $term;?> - <span class="tax_filter"></span></div>
		<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filtrotaxonomias_formato">
			<div class="switch-field" id="posss">
            	<input type="radio" id="genero_left" name="genero" data-value="todos los géneros" value="" checked/>
                <label for="genero_left">Todos los géneros</label>
                <input type="radio" id="genero_center" name="genero" data-value="documental" value="19" />
                <label for="genero_center">Documental</label>
                <input type="radio" id="genero_right" name="genero" data-value="ficción" value="66" />
                <label for="genero_right">Ficción</label>
            </div>
			<div>
			<?php
				if( $terms = get_terms( array( 'taxonomy' => 'videos_classification', 'orderby' => 'name' ) ) ) : 
 					echo '<select name="edad"><option value="">Todas las clasificaciones</option>';
					foreach ( $terms as $term ) :
						echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; 
					endforeach;
					echo '</select>';
				endif;
			?>
			<?php
				/* if( $terms = get_terms( array( 'taxonomy' => 'videos_genres', 'orderby' => 'name' ) ) ) : 
 					echo '<select name="genero" id="posss"><option value="">Todos los formatos</option>';
					foreach ( $terms as $term ) :
						echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; 
					endforeach;
					echo '</select>';
				endif; */
			?>
			</div>
			<input type="hidden" name="termino" value="<?php echo $term_obj->term_id;?>">
			<div class="switch-field">
      			<input type="radio" id="switch_left" name="fechaentrada" value="DESC" checked/>
      			<label for="switch_left">Recientes</label>
      			<input type="radio" id="switch_right" name="fechaentrada" value="ASC" />
      			<label for="switch_right">Menos recientes</label>
    		</div>

			<input type="hidden" name="action" value="myfilter">
		</form>
	<?php 
}


genesis();
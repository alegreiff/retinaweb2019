<?php

//Obtiene los videos relacionados si los hubiere
$videos = get_field("relation_films");

//Quita el título de la entrada
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//Agrega un contenido en el área del header de la entrada para mostrar la imagen destacada y el título
add_action('genesis_entry_header', 'imagendestacada', 1);
function imagendestacada(){
  // Parámetros para genesis_get_image
  $args = array(
    'format' => 'url'
  );
  // Función de Genesis genesis_get_image
  $imagos = genesis_get_image($args);
  ?>
  <div class="rl_imagendestacada_single" style="background: url('<?php echo $imagos ?>')">
    <div class="rl_header_entrada_sencilla">
      <h2><?php the_title(); ?> </h2>
    </div>
  </div>
  <?php
  
}
//Filtro para modificar la información de INFo del POST
add_filter('genesis_post_info', 'muestrafecha', 2);
function muestrafecha($dato){
  //[post_author_posts_link] [post_comments] [post_edit]
  $dato = '<span class="rl_fecha_entrada">'.ucfirst(get_the_date( 'F j \d\e Y' )).'</span>';
  return $dato;
}

add_filter('genesis_after_entry_content', 'muestrapeliculasrelacionadas');
function muestrapeliculasrelacionadas(){
  global $videos;
  // Si existen videos relacionados se muestran los posteres con la misma lógica de todo el sitio
  if ($videos){
    echo '<h3>Películas relacionadas</h3>';
    echo '<div class="peliculas">';
    foreach ($videos as $video){
      if ($video->post_status === 'publish'){
        $cam = get_fields($video->ID);
        $enlace_video = get_post_permalink($video->ID);
        $etiquetas_campos = [];
        foreach ($cam as $nombre => $valor){
          $etiquetas_campos[] = $nombre;
        }
        $poster = trae_poster(get_field('poster', $video->ID));
        $pais_pelicula = muestra_codigopais(get_field('country_group', $video->ID));
        $genero_pelicula = wp_get_post_terms($video->ID, 'videos_genres') [0]->name;
        $duracion = get_field('duration', $video->ID);
        $year = get_field('year', $video->ID);
        echo '
        <div class="retina_poster">
          <a href="' . $enlace_video . '">
            <div class="picture" >
              <img src="' . $poster . '" alt="">
              <span class="duracion"> ' . ($duracion) . '</span>
            </div>
            <div class="navigation">
              <span class="pais">' . $pais_pelicula . ' - ' . $year . '</span>
              <h4>' . $video->post_title . '</h4>
              <span class="formato">' . muestra_genero($genero_pelicula) . '</span>
            </div>
            ';
          echo '</a></div>';
      }
    }
    echo '</div>';
  }else{
    echo '';
  }  
}
genesis();
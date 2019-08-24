<?php

//Quita el título de la entrada
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

/* add_action('genesis_before_while', 'gen_before_while');
function gen_before_while(){
  echo 'Antes del While';
}

add_action('genesis_before_entry', 'gen_before_entry');
function gen_before_entry(){
  echo 'Antes de la entrada';
} */

/*add_action('genesis_entry_header', 'gen_entry_header', 1);
function gen_entry_header(){
  echo 'Empezando el Header';
}*/

/* add_action('genesis_pre_get_option_footer_text ', 'gen_after_endwhile', 1);
function gen_after_endwhile(){
  echo 'Después de End WHILE';
} */


add_action('genesis_entry_header', 'imagendestacada', 1);
function imagendestacada(){
  $args = array(
    'format' => 'url'
  );
  $imagos = genesis_get_image($args);
  ?>
  <div class="rl_imagendestacada_single" style="background: url('<?php echo $imagos ?>')">
    <div class="rl_header_entrada_sencilla">
      <h2 class="the-title"><?php the_title(); ?> </h2>
    </div>
  </div>
  <?php
  
}
/* FILTROS DENTRO DE POST*/

/* add_filter('genesis_post_title_text', 'cambia_titulo_sencillo', 3);
function cambia_titulo_sencillo($titulo){
  d($titulo);
  $titulo.= get_the_date();
  return $titulo;
} */

/* add_filter('genesis_post_title_output', 'cambia_titulo', 3);
function cambia_titulo($title){
  d($title);
  $title.= get_the_date();
  return $title;
} */
add_filter('genesis_post_info', 'muestrafecha', 2);
function muestrafecha($dato){
  $dato = '<span class="rl_fecha_entrada">'.ucfirst(get_the_date( 'F j \d\e Y' )).'</span>';
  return $dato;
}






















// Replace default genesis loop

//remove_action( 'genesis_loop', 'genesis_do_loop' );
//add_action( 'genesis_loop', 'your_custom_loop' );
  
  function your_custom_loop() { 

global $wp_query, $post;
//d($wp_query);
    $filmes_relacionados = get_field("relation_films");
    $tags = get_the_tags();
    //d($post);
    if(!empty($filmes_relacionados)){
        foreach($filmes_relacionados as $pelicula){
        $image_p= get_post_meta($pelicula->ID, 'poster',true);
        //d($pelicula->ID);
        //$imgDestacada = wp_get_attachment_url($image_p);
        $image = wp_get_attachment_image_src($image_p, 'poster-mini');
        $domain = get_site_url(); // returns something like http://domain.com
        $relative_url = str_replace( $domain, '', $image[0] );
        //echo $name;
        //echo '<img src="'.$relative_url.'" alt="">';
        //echo '<p>' . get_the_title() . '</p>';
        //the_content();

        if (have_posts()) : 
          while (have_posts()) : 
            the_post(); 
            echo '<img src="'.$relative_url.'" alt="">';
            the_content();
          endwhile; 
        endif;

}
 
}else{

    echo 'No Hay';   
/*foreach($filmes_relacionados as $key => $value):
$image_p= get_post_meta($value->ID, 'poster',true);
$imgDestacada = wp_get_attachment_url($image_p);						               
$name = $value->post_title;
d($name);
$link = $value->guid;
endforeach;
*/
}

    echo 'Jaime';
  
  }




genesis();
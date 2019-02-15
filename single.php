<?php

// Replace default genesis loop

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'your_custom_loop' );
  
  function your_custom_loop() { 

global $wp_query, $post;
d($wp_query);
    $filmes_relacionados = get_field("relation_films");
    $tags = get_the_tags();
    d($post);
    if(!empty($filmes_relacionados)){
        foreach($filmes_relacionados as $pelicula){
        $image_p= get_post_meta($pelicula->ID, 'poster',true);
        d($pelicula->ID);
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
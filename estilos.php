<?php
 $absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
 $wp_load = $absolute_path[0] . 'wp-load.php';
 require_once($wp_load);

  /*
  Do stuff like connect to WP database and grab user set values
  opciones_rl_color 
  */

  header('Content-type: text/css');
  header('Cache-control: must-revalidate');
  if(get_field('selecciona_tipo_colores', 'option')==='SI'){
      $color_fondo = get_field('color_retina', 'option');
  }else{
    $color_fondo = get_field('color_selector', 'option');
  }
?>

div.site-container { 
     
background:<?php echo $color_fondo?>; 
        
}

    
<?php

if(!class_exists('LogosFooterRETINA')) {
  class LogosFooterRETINA extends WP_Widget {
    /**
    * Este widget construye los logos del footer de MaguaRED de manera responsive
    * El CSS pertinente se encuentra en partials/_logos-footer-widget.scss
    */
    public function __construct() {
      $widget_ops = array(
        'classname' => 'footer_logos',
        'description' => 'Logos RETINA LATINA',
      );
      parent::__construct( 'footer_logos', 'RETINA LATINA LOGOS', $widget_ops );
    }
/**
    * Outputs the content of the widget
    *
    * @param array $args
    * @param array $instance
    */
    public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
          $args['widget_id'] = $this->id;
        }
        // widget ID with prefix for use in ACF API functions
        $widget_id = 'widget_' . $args['widget_id'];
        echo $args['before_widget'];
        ?>
            <div class="logos-footer-retina">
                
                <div class="coordinacion-texto"><p>Coordinación plataforma</p></div>
                <div class="coordinacion-logo"><a href="http://www.mincultura.gov.co/" target="_blank" title="Ministerio de Cultura"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/mincultura-gris.png" alt="Logo Gobierno de Colombia"></a></div>
                
                <div class="miembros-logo">
                    <p class="miembros">Entidades miembros</p>
                    <a href="http://www.conacinebolivia.com.bo/" target="_blank" title="Conacine - Bolivia"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/bolivia-conacine.png" alt="Logo Conacine - Bolivia"></a>
                    <a href="http://www.mincultura.gov.co/" target="_blank" title="Ministerio de Cultura - Colombia"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/mincultura-gris.png" alt="Logo Ministerio de Cultura - Colombia"></a>
                    <a href="http://www.cineyaudiovisual.gob.ec/" target="_blank" title="Instituto de cine y creación audiovisual - Ecuador"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/ecuador-icca.png" alt="Logo Instituto de cine y creación audiovisual - Ecuador"></a>
                    <a href="http://www.imcine.gob.mx/" target="_blank" title="Instituo Mexicano de Cinematografía - México"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/mexico-imcine.png" alt="Logo Instituo Mexicano de Cinematografía - México"></a>
                    <a href="http://www.cultura.gob.pe/" target="_blank" title="Ministerio de Cultura - Perú"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/peru-mincultura.png" alt="Logo Ministerio de Cultura - Perú"></a>
                    <a href="http://www.icau.mec.gub.uy/" target="_blank" title="Dirección del Cine y Audiovisual Nacional - Uruguay"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/uruguay-icau.png" alt="Logo Dirección del Cine y Audiovisual Nacional - Uruguay"></a>
                </div>
                <div class="colaboran-texto">Colaboran</div>
                <a class="colaboran-logo1" href="http://www.mincultura.gov.co/" target="_blank" title="Ministerio de Cultura"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/caci.png" alt="Logo Gobierno de Colombia"></a>
                <a class="colaboran-logo2"href="http://www.mincultura.gov.co/" target="_blank" title="Ministerio de Cultura"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/doctv.png" alt="Logo Gobierno de Colombia"></a>
                <div class="apoya-texto">Apoya</div>
                <div class="apoya-logo">
                <a href="http://www.mincultura.gov.co/" target="_blank" title="Ministerio de Cultura"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/bid.png" alt="Logo Gobierno de Colombia"></a>
                </div>
                
                
            </div>
            <!--<div class="logos-maguared-institucionales">
                
                <div><a href="http://www.mincultura.gov.co/" target="_blank" title="Ministerio de Cultura"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/gobiernodecolombia.png" alt="Logo Gobierno de Colombia"></a></div>
                <div><a href="http://unimedios.unal.edu.co/" target="_blank" title="Unimedios - Universidad Nacional de Colombia"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/unimedios.png" alt="Logo Unimedios - Universidad Nacional de Colombia"></a></div>
                <div><a href="http://www.deceroasiempre.gov.co/Paginas/deCeroaSiempre.aspx" target="_blank" title="De cero a Siempre"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/cero.png" alt="Logo De Cero a Siempre" class="bnimage"></a></div>
                <div><a href="http://www.mincultura.gov.co/leer-es-mi-cuento/Paginas/default.aspx" target="_blank" title="Leer es mi cuento"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/leer.png" alt="Logo Leer es mi cuento" class="bnimage"></a></div>
                <div><a href="https://maguared.gov.co" target="_blank" title="MaguaRED - Cultura y primera infancia en la red"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/maguared.png" alt="Logo MaguaRED" ></a></div>
                <div><a href="https://maguare.gov.co" target="_self" title="Descubre, imagina y crea con Maguaré"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/maguare.png" alt="Logo Maguaré" ></a></div>
                <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logosfooter/premio.png" alt="logo"></div>
            </div>-->
        <?php
        echo $args['after_widget'];

      }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
    	// outputs the options form on admin
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
    	// processes widget options to be saved
    }

  }

}

/**
 * Registra nuestro LogosFooterMAG Widget
 */
function register_logosFooterRetinaLatina()
{
  register_widget( 'LogosFooterRETINA' );
}
add_action( 'widgets_init', 'register_logosFooterRetinaLatina' );

<?php
/**
 * TEMPLATE PART
 * RETINA LATINA 
 * FICHA VARIOS
 */

 echo '<span class="ficha_varios">
    ' . creditos("Montaje", 'Montaje', $montajista) . '
    ' . creditos("Colorización", 'Colorización', $colorista) . '
    ' . creditos("Edición de sonido", 'Edición de sonido', $editor_sonido) . '
    ' . creditos("Direccción de arte", 'Direccción de arte', $director_arte) . '
    ' . creditos("Efectos visuales", '', $efectos_visuales) . '
    ' . creditos("Animación", 'Animación', $animador) . '
    ' . creditos("Diseño gráfico", '', $diseno_grafico) . '    

    ' . creditos("Casting", '', $casting) . '
    ' . creditos("Vestuario", '', $vestuario) . '
    ' . creditos("Maquillaje", '', $maquillador) . '
    ' . creditos("Narración", '', $narracion) . '

    
    
    
    </span>';

    //print_r($colorista);
/*echo '<hr>
<div class="testeretina">

<p>ID VIDEO: '. $video . '</p>
<p>SUBS: '. $subtitulos . '</p>
lungüística áéíóúÁÉÍÓÚ
<i class="fas fa-grip-lines"></i>
</div>
';*/
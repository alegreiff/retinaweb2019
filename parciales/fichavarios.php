<?php
/**
 * TEMPLATE PART
 * RETINA LATINA 
 * FICHA VARIOS
 */
echo '<span class="ficha_varios">
    ' . creditos("Montaje", 'Montaje', $montajista) . '
    ' . creditos("Colorización", 'Colorización', $colorista) . '
    ' . creditos("Direccción de arte", 'Direccción de arte', $director_arte) . '
    ' . creditos("Animación", 'Animación', $animador) . '
    ' . creditos("Investigación", 'Investigación', $investigador) . '
    ' . creditos("Casting", '', $casting) . '
    ' . creditos("Vestuario", '', $vestuario) . '
    LOCACIONES
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
<?php
/**
 * TEMPLATE PART
 * RETINA LATINA 
 * FICHA VARIOS
 */
echo '<span class="ficha_varios">
    ' . creditos("Montajista", 'Montajistas', $montajista) . '
    ' . creditos("Director de arte", 'Directores de arte', $director_arte) . '
    ' . creditos("Animador", 'Animadores', $animador) . '
    ' . creditos("Investigador", 'Investigadores', $investigador) . '
    ' . creditos("Casting", '', $casting) . '
    ' . creditos("Vestuario", '', $vestuario) . '
    </span>';

    print_r($screenwriter);
/*echo '<hr>
<div class="testeretina">

<p>ID VIDEO: '. $video . '</p>
<p>SUBS: '. $subtitulos . '</p>
lungüística áéíóúÁÉÍÓÚ
<i class="fas fa-grip-lines"></i>
</div>
';*/
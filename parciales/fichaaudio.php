<?php
/**
 * TEMPLATE PART
 * RETINA LATINA
 * FICHA DE AUDIO
 */echo '<span class="ficha_audio">
    ' . creditos("Sonido", 'Sonido', $sonidista) . '
    ' . creditos("Diseño de sonido", 'Diseño de sonido', $sonido_disenador) . '
    ' . creditos("Mezcla de sonido", '', $sonido_mezcla) . '
    ' . creditos("Microfonista", 'Microfonistas', $microfonista) . '
    ' . creditos("Música", 'Música', $musico) . '
    
    </span> ';
    //echo nombre_taxonomia_persona('cast', 'campo', 'label');
<?php
/**
 * TEMPLATE PART
 * RETINA LATINA
 * FICHA DE AUDIO
 */echo '<span class="ficha_audio">
    ' . creditos("Sonidista", 'Sonidistas', $sonidista) . '
    ' . creditos("Diseñador de sonido", 'Diseñadores de sonido', $sonido_disenador) . '
    ' . creditos("Músico", 'Músicos', $musico) . '
    ' . creditos("Mezcla de sonido", '', $sonido_mezcla) . '
    ' . creditos("Narración", '', $narracion) . '
    </span> ';
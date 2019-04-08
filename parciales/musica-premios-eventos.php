<?php
/**
 * TEMPLATE PART
 * RETINA LATINA
 * MÚSICA - PREMIOS - PARTICIPACIÓN EN EVENTOS
 */
    echo $muestra_musica . '
    ' . tabla_popup("fas fa-award", "Premios y reconocimientos", $premios, "ficha_premios") . '
    ' . tabla_popup("fas fa-star", "Participación en eventos cinematográficos", $eventos, "ficha_eventos") . '';
    
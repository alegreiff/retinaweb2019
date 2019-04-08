<?php
/**
 * TEMPLATE PART
 * RETINA LATINA
 * FICHA DE FOTOGRAFIA
 */
echo '<span class="ficha_fotografia">
    ' . creditos("Cámara", '', $camarografo) . '
    ' . creditos("Director de fotografía", 'Directores de fotografía', $director_fotografia) . '
    ' . creditos("Asistente de cámara", 'Asistentes de cámara', $asistente_camara) . '
    ' . creditos("Fotofija", '', $fotofija) . '
</span>';
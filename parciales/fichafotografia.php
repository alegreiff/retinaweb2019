<?php
/**
 * TEMPLATE PART
 * RETINA LATINA
 * FICHA DE FOTOGRAFIA
 */
echo '<span class="ficha_fotografia">
    ' . creditos("Dirección de fotografía", 'Dirección de fotografía', $director_fotografia) . '    
    ' . creditos("Cámara", '', $camarografo) . '
    ' . creditos("Asistencia de cámara", 'Asistencia de cámara', $asistente_camara) . '
    ' . creditos("Fotofija", '', $fotofija) . '
</span>';
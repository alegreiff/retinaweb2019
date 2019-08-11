<?php
/**
 * TEMPLATE PART
 * RETINA LATINA
 * FICHA DIRECCIÓN
 */
echo '<span class="ficha_direccion"> 
    ' . creditos("Direccción", '', $director) . '
    ' . creditos("Asistencia de dirección", 'Asistencia de dirección', $director_asistente) . '
    ' . creditos("Guion", 'Guion', $guionista) . '
    ' . creditos("Investigación", 'Investigación', $investigador) . '    
    ' . creditos("Continuista", '', $scriptcontinuista) . '
</span>';
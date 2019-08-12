<?php
/**
 * TEMPLATE PART
 * RETINA LATINA
 * FICHA DE PRODUCCIÓN
 */
echo '<span class="ficha_produccion">
    ' . lista_asociada('País de producción', 'Países de producción',  $paises_produccion) . '
    ' . lista_asociada('País coproductor', 'Países coproductores',  $paises_coproduccion) . '
    ' . creditos("Compañía productora", 'Compañías productoras', $companias) . '
    ' . creditos("Producción", 'Producción', $prod_jefeprod) . '
    ' . creditos("Coproducción", '', $coproductor) . '
    ' . creditos("Producción ejecutiva", 'Producción ejecutiva', $productor_ejecutivo) . '
    ' . creditos("Producción asociada", 'Producción asociada', $productor_asociado) . '
    ' . creditos("Producción de campo", 'Producción de campo', $productor_campo) . '
    ' . creditos("Asistencia de producción", 'Asistencia de producción', $productor_asistente) . '
    </span>';
 
    /* 
    echo '<span class="ficha_produccion">
    ' . lista_asociada('País de producción', 'Países de producción',  $paises_produccion) . '
    ' . lista_asociada('País coproductor', 'Países coproductores',  $paises_coproduccion) . '
    ' . creditos("Compañía productora", 'Compañías productoras', $companias) . '
    ' . creditos("SUMAR A PROD JEFE", "SUMAR A PROD JEFE", $jefe_produccion) . '
    ' . creditos("MIXX", "MIXXES", $mix) . '
    ' . creditos("Producción", 'Producción', $productor) . '
    ' . creditos("Coproducción", '', $coproductor) . '
    ' . creditos("Producción ejecutiva", 'Producción ejecutiva', $productor_ejecutivo) . '
    ' . creditos("Producción asociada", 'Producción asociada', $productor_asociado) . '
    ' . creditos("Producción de campo", 'Producción de campo', $productor_campo) . '
    ' . creditos("Asistencia de producción", 'Asistencia de producción', $productor_asistente) . '
    </span>';
    */
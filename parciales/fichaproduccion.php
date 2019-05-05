<?php
/**
 * TEMPLATE PART
 * RETINA LATINA
 * FICHA DE PRODUCCIÓN
 */
echo '<span class="ficha_produccion">
    ' . lista_asociada('País coproductor', 'Países coproductores',  $paises_produccion) . '
    ' . creditos("Compañía productora", 'Compañías productoras', $companias) . '
    ' . creditos("SUMAR A PROD JEFE", "SUMAR A PROD JEFE", $jefe_produccion) . '
    ' . creditos("Producción", 'Producción', $productor) . '
    ASISTENTE DE PRODUCCIÓN
    ' . creditos("Coproductor", 'Coproductores', $coproductor) . '

    ' . creditos("Producción ejecutiva", 'Producción ejecutiva', $productor_ejecutivo) . '
    ' . creditos("Producción asociada", 'Producción asociada', $productor_asociado) . '
    ' . creditos("Producción de campo", 'Producción de campo', $productor_campo) . '
    </span>';

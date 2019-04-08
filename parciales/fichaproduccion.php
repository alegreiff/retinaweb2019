<?php
/**
 * TEMPLATE PART
 * RETINA LATINA
 * FICHA DE PRODUCCIÓN
 */
echo '<span class="ficha_produccion">
    ' . lista_asociada('País de producción', 'Países de producción',  $paises_produccion) . '
    ' . creditos("Compañía productora", 'Compañías productoras', $companias) . '
    ' . creditos("Productor", 'Productores', $productor) . '
    ' . creditos("Jefe de producción", 'Jefes de producción', $jefe_produccion) . '
    ' . creditos("Coproductor", 'Coproductores', $coproductor) . '
    ' . creditos("Productor ejecutivo", 'Productores ejecutivos', $productor_ejecutivo) . '
    ' . creditos("Productor asociado", 'Productores asociados', $productor_asociado) . '
    ' . creditos("Productor de campo", 'Productores de campo', $productor_campo) . '
    </span>';

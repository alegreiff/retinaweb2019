<?php
//Listado de personas
//El valor de LABEL será mostrado al presentar cada campo
function nombre_taxonomia_persona($nombre, $entrada, $salida){
    $roles_personas=[
        ["label" => "Reparto", "campo" => 'cast', "taxslug" =>'actores'],
        ["label" => "Animación", "campo" => 'animator', "taxslug" =>'animador'],
        ["label" => "Asistencia de cámara", "campo" => 'camara_assistant', "taxslug" =>'asistente-de-camara'],
        ["label" => "Asistencia de dirección", "campo" => 'directors_assistant', "taxslug" =>'asistente-de-direccion'],
        ["label" => "Asistencia de producción", "campo" => 'rl_productorasistente', "taxslug" =>'asistente-de-produccion'],
        ["label" => "Cámara", "campo" => 'cameraman', "taxslug" =>'camarografo'],
        ["label" => "Castin", "campo" => 'casting', "taxslug" =>'casting'],
        ["label" => "Colorización", "campo" => 'rl_colorista', "taxslug" =>'colorizador'],
        ["label" => "Compañía productora", "campo" => 'company_productors', "taxslug" =>'companias-productoras'],
        ["label" => "Coproducción", "campo" => 'coproducer', "taxslug" =>'coproductor'],
        ["label" => "Dirección", "campo" => 'director', "taxslug" =>'directores'],
        ["label" => "Dirección de arte", "campo" => 'art_director', "taxslug" =>'director-de-arte'],
        ["label" => "Dirección de fotografía", "campo" => 'director_photography', "taxslug" =>'director-de-fotografia'],
        ["label" => "Diseño de sonido", "campo" => 'sound_designer', "taxslug" =>'disenador-de-sonido'],
        ["label" => "Diseño gráfico", "campo" => 'rl_disenografico', "taxslug" =>'diseno-grafico'],
        ["label" => "Edición de sonido", "campo" => 'rl_ediciondesonido', "taxslug" =>'editor-de-sonido'],
        ["label" => "Efectos visuales", "campo" => 'rl_efectosvisuales', "taxslug" =>'efectos-visuales'],
        ["label" => "Foto fija", "campo" => 'foto_fija', "taxslug" =>'foto-fija'],
        ["label" => "Guion", "campo" => 'screenwriter', "taxslug" =>'guionista'],
        ["label" => "Investigación", "campo" => 'searcher', "taxslug" =>'investigador'],
        ["label" => "Jefatura de producción", "campo" => 'chief_producer', "taxslug" =>'jefe-de-produccion'],
        ["label" => "Maquillaje", "campo" => 'rl_maquillaje', "taxslug" =>'maquillador'],
        ["label" => "Mezcla de sonido", "campo" => 'sound_mzl', "taxslug" =>'mezcla-de-sonido'],
        ["label" => "Microfonista", "campo" => 'rl_microfonista', "taxslug" =>'microfonista'],
        ["label" => "Montaje", "campo" => 'montajista', "taxslug" =>'montajista'],
        ["label" => "Música", "campo" => 'musician', "taxslug" =>'musico'],
        ["label" => "Narración", "campo" => 'narration', "taxslug" =>'narracion'],
        ["label" => "Producción", "campo" => 'producer', "taxslug" =>'productor'],
        ["label" => "Producción asociada", "campo" => 'associate_producer', "taxslug" =>'productor-asociado'],
        ["label" => "Producción de campo", "campo" => 'rl_productordecampo', "taxslug" =>'productor-de-campo'],
        ["label" => "Producción ejecutiva", "campo" => 'executive_producer', "taxslug" =>'productor-ejecutivo'],
        ["label" => "Script - continuista", "campo" => 'rl_script', "taxslug" =>'script-continuista'],
        ["label" => "Sonido directo", "campo" => 'soundman', "taxslug" =>'sonidista'],
        ["label" => "Vestuario", "campo" => 'vestuario', "taxslug" =>'vestuario']
        
    ];
    foreach ($roles_personas as $rol => $val) {
        if ($val[$entrada] == $nombre) {
            return $val[$salida];
        }
    }
    return null;

}
<?php
//Incompleto listado de personas
function nombre_taxonomia_persona($nombre, $entrada, $salida){
    $roles_personas=[
        ["label" => "Dirección", "campo" => 'director', "taxslug" =>'directores'],
        ["label" => "Asistencia de dirección", "campo" => 'directors_assistant', "taxslug" =>'asistente-de-direccion'],
        ["label" => "Guion", "campo" => 'screenwriter', "taxslug" =>'guionista'],
        ["label" => "Investigación", "campo" => 'searcher', "taxslug" =>'investigador'],
        ["label" => "Script / Continuista", "campo" => 'rl_script', "taxslug" =>'script-continuista'],
        ["label" => "Producción", "campo" => 'producer', "taxslug" =>'productor'],
        ["label" => "Montaje", "campo" => 'montajista', "taxslug" =>'montajista'],
        ["label" => "Sonido", "campo" => 'soundman', "taxslug" =>'sonidista'],
        ["label" => "Dirección de fotografía", "campo" => 'director_photography', "taxslug" =>'director-de-fotografia'],
        ["label" => "Cámara", "campo" => 'cameraman', "taxslug" =>'camarografo'],
    ];
    foreach ($roles_personas as $rol => $val) {
        if ($val[$entrada] == $nombre) {
            return $val[$salida];
        }
    }
    return null;

}
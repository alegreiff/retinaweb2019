#MIGRACIÓN
Paso 1: Garantizar que existan TODAS las taxonomías de PERSONAS que se necesitan en los campos de película

##CAMPO GEOBLOQUEO
###OPCIONES
Nombre del campo: rl_geobloqueo

- GEO_AL : América Latina
- GEO_ALL : Todo el mundo
- GEO_SC : Solo Colombia
- GEO_ALLNOCOL : Todo el mundo SIN Colombia
- GEO_ALLNOCOLNOUSA : Todo el mundo SIN Colombia ni Estados Unidos

##CAMPO Países de COPRODUCCIÓN
Nombre del campo: rl_coproduccionpaises

CAMPO CON NOMBRE MALO
field_producer

Se elimina y el nuevo se llama: campo_producer
Lo tienen las siguientes películas:

- "El último viaje con los hermanos" "video"
- "Este pueblo necesita un muerto" "video"
- "Hit" "video"
- "La Gorgona, historias fugadas" "video"
- "Carlota" "video"
- "La cantuta en la boca del diablo" "video"
- "La eterna noche de las doce lunas" "video"
- "Sangre y tierra - resistencia indígena en el Norte del Cauca" "video"
- "Campo Santo" "video"
- "Keyla" "video"
- "Down With Music" "video"

##CAMPO Script / Continuista
Nombre del campo: rl_script

###Crear taxonomía en Personas y relacionarla en campos personalizados
(Script / Continuista --- script-continuista)

##Clasificación de Público
Así está la cosa con las películas publicadas
Todo público: 263
Mayores de edad: 30
12 años: 56
15 años: 9

###Se debe remover General

##CAMPO Locaciones
Modificado. De texto a editor wysiwyg
(Sigue siendo wysiwyg peroNO tendrá tablas.)

##CAMPO Colorización
Nombre del campo: rl_colorista
###Crear taxonomía en Personas y relacionarla en campos personalizados
(Colorizador --- colorizador)

##CAMPO Productor de campo
(reemplaza al anterior llamado field_producer)
Nombre del campo: rl_productordecampo
###Se mantiene la taxonomía Productor de campo

##CAMPO Asistencia de producción
Nombre del campo: rl_productorasistente
###Crear taxonomía en Personas y relacionarla en campos personalizados
(Asistente de producción - asistente-de-produccion)

##CAMPO Sonido directo
No cambia nada. Es el campo sonidista de siempre
Cambian las etiquetas asociadas

##CAMPO Efectos visuales
Nombre del campo: rl_efectosvisuales
###Crear taxonomía en Personas y relacionarla en campos personalizados
(Efectos visuales --- efectos-visuales)

##CAMPO Diseño gráfico
Nombre del campo: rl_disenografico
###Crear taxonomía en Personas y relacionarla en campos personalizados
(Diseño gráfico --- diseno-grafico)

##JEFE DE PRODUCCIÓN SIGUE EXISTIENDO, NO SE ALIMENTA MÁS Y SE MUESTRA COMO PARTE DE PRODUCCIÓN. AL FINAL

##CAMPO Edición de sonido
Nombre del campo: rl_ediciondesonido
###Crear taxonomía en Personas y relacionarla en campos personalizados
(Editor de sonido --- editor-de-sonido)

##CAMPO Microfonista
Nombre del campo: rl_microfonista
###Crear taxonomía en Personas y relacionarla en campos personalizados
(Microfonista --- microfonista)

##CAMPO Maquillador
Nombre del campo: rl_maquillaje
###Crear taxonomía en Personas y relacionarla en campos personalizados
(Maquillador --- maquillador)

##CAMPO Contacto
Nombre del campo: rl_contacto
Typo: wysiwyg

###El campo Nacionalidad de la película NO SE MUESTRA

### ANIMACION y COLOR (Blanco y negro) Se muestran cuando existan

##CAMPO Inspirado en otra obra
Nombre del campo: rl_inspirado
Typo: wysiwyg

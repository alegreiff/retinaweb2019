/* field_producer */
SELECT * FROM `mcc_postmeta` 
WHERE `meta_key` 
like "field_p%"
AND `meta_value` NOT LIKE ''


/*
Películas con el campo field_producer

"El último viaje con los hermanos"	"video"
"Este pueblo necesita un muerto"	"video"
"Hit"	"video"
"La Gorgona, historias fugadas"	"video"
"Carlota"	"video"
"La cantuta en la boca del diablo"	"video"
"La eterna noche de las doce lunas"	"video"
"Sangre y tierra - resistencia indígena en el Norte del Cauca"	"video"
"Campo Santo"	"video"
"Keyla"	"video"
"Down With Music"	"video"
*/
SELECT post_title, post_type FROM `mcc_postmeta`, `mcc_posts`
WHERE `meta_key` 
like "field_producer"
AND `meta_value` NOT LIKE ''
AND mcc_postmeta.post_id = mcc_posts.ID




SELECT post_title, post_type FROM `mcc_postmeta`, `mcc_posts`
WHERE `meta_key` 
like "locations"
AND `meta_value` NOT LIKE ''
AND mcc_postmeta.post_id = mcc_posts.ID